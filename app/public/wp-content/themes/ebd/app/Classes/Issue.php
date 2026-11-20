<?php

namespace App;

if (!class_exists(__NAMESPACE__.'\\Issue')) {
    /**
     * Class Issue
     *
     * Page-by-page magazine. One config file per issue under app/issues/.
     * Each spread is a real URL. Blade renders it. Alpine only enhances.
     *
     * /issue-01/ and /issue-01/cover are the cover.
     * /issue-01/{slug}/ is every other spread.
     *
     * @package App
     */
    class Issue
    {
        private static $instance;

        public const REWRITE_VERSION = '1';

        /**
         * Issue constructor.
         */
        protected function __construct()
        {
            add_action('init', [$this, 'registerRewrites']);
            add_action('init', [$this, 'maybeFlushRewrites'], 99);
            add_filter('query_vars', [$this, 'queryVars']);
            add_action('template_redirect', [$this, 'render'], 1);
        }

        /**
         * @return void
         */
        public function registerRewrites(): void
        {
            add_rewrite_rule(
                '^issue-([0-9]+)/([^/]+)/?$',
                'index.php?ebd_issue=$matches[1]&ebd_spread=$matches[2]',
                'top'
            );
            add_rewrite_rule(
                '^issue-([0-9]+)/?$',
                'index.php?ebd_issue=$matches[1]&ebd_spread=cover',
                'top'
            );
        }

        /**
         * Flush once per rule change so /issue-01/ resolves without a manual permalink save.
         *
         * @return void
         */
        public function maybeFlushRewrites(): void
        {
            if (get_option('ebd_issue_rewrite') === self::REWRITE_VERSION) {
                return;
            }

            flush_rewrite_rules(false);
            update_option('ebd_issue_rewrite', self::REWRITE_VERSION, false);
        }

        /**
         * @param array<int, string> $vars
         * @return array<int, string>
         */
        public function queryVars(array $vars): array
        {
            $vars[] = 'ebd_issue';
            $vars[] = 'ebd_spread';

            return $vars;
        }

        /**
         * @return void
         */
        public function render(): void
        {
            if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
                return;
            }

            $issueId = get_query_var('ebd_issue');
            $spreadSlug = get_query_var('ebd_spread');

            if (! is_string($issueId) || $issueId === '' || ! is_string($spreadSlug) || $spreadSlug === '') {
                return;
            }

            $model = self::present($issueId, $spreadSlug);

            if ($model === null) {
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
                nocache_headers();
                echo \view('404')->render();
                exit;
            }

            global $wp_query;
            $wp_query->is_404 = false;

            $title = $model['spread']['title'] . ' — ' . $model['issue_title'];
            $canonical = $model['spread']['url'];

            add_filter('pre_get_document_title', static function () use ($title) {
                return $title;
            });
            add_filter('get_canonical_url', static function () use ($canonical) {
                return $canonical;
            });

            status_header(200);
            echo \view('issue.spread', $model)->render();
            exit;
        }

        /**
         * Relative path for a spread. Cover's canonical path has no /cover suffix.
         */
        public static function path(string $issueSlug, string $spreadSlug): string
        {
            if ($spreadSlug === 'cover') {
                return '/' . $issueSlug . '/';
            }

            return '/' . $issueSlug . '/' . $spreadSlug . '/';
        }

        /**
         * @return array<string, mixed>|null
         */
        public static function present(string $issueId, string $spreadSlug): ?array
        {
            $issueSlug = self::issueSlug($issueId);
            $config = self::config($issueId);

            if ($config === null) {
                return null;
            }

            $spreadSlug = sanitize_title($spreadSlug);
            $items = $config['spreads'];
            $index = null;

            foreach ($items as $i => $item) {
                if ($item['slug'] === $spreadSlug) {
                    $index = $i;
                    break;
                }
            }

            if ($index === null) {
                return null;
            }

            $total = count($items);
            $spreads = [];

            foreach ($items as $i => $item) {
                $spreads[] = [
                    'slug' => $item['slug'],
                    'title' => $item['title'],
                    'number' => $i + 1,
                    'url' => self::url($issueSlug, $item['slug']),
                    'thumbnail' => $item['thumbnail'] ?? null,
                    'current' => $i === $index,
                ];
            }

            $current = $items[$index];
            $layout = (string) $current['layout'];

            if (! preg_match('/^[a-z0-9-]+$/', $layout) || ! \view()->exists('issue.layouts.' . $layout)) {
                return null;
            }

            $article = is_array($current['article'] ?? null) ? $current['article'] : [];
            $articleUrl = '';

            if (! empty($article['url']) && is_string($article['url'])) {
                $articleUrl = $article['url'];
            } elseif (! empty($article['demo']) && is_string($article['demo'])) {
                $articleUrl = DemoCatalog::url($article['demo']);
            }

            $spread = [
                'slug' => $current['slug'],
                'title' => $current['title'],
                'layout' => $layout,
                'number' => $index + 1,
                'total' => $total,
                'url' => $spreads[$index]['url'],
                'thumbnail' => $current['thumbnail'] ?? null,
                'article_url' => $articleUrl,
                'article_label' => (string) ($article['label'] ?? ''),
                'data' => is_array($current['data'] ?? null) ? $current['data'] : [],
                'prev' => $index > 0 ? $spreads[$index - 1] : null,
                'next' => $index < $total - 1 ? $spreads[$index + 1] : null,
            ];

            return [
                'issue_slug' => $issueSlug,
                'issue_title' => (string) $config['title'],
                'spread' => $spread,
                'spreads' => $spreads,
                'menu' => self::menu(),
            ];
        }

        /**
         * @return array<int, array{label: string, url: string}>
         */
        public static function menu(): array
        {
            return [
                ['label' => 'Placeholder · Contact', 'url' => DemoCatalog::url('contact')],
                ['label' => 'Placeholder · About', 'url' => DemoCatalog::url('about')],
                ['label' => 'Placeholder · The Edit', 'url' => DemoCatalog::url('the-edit')],
                ['label' => 'Placeholder · Contributors', 'url' => DemoCatalog::url('contributors')],
            ];
        }

        public static function url(string $issueSlug, string $spreadSlug): string
        {
            return home_url(self::path($issueSlug, $spreadSlug));
        }

        public static function issueSlug(string $issueId): string
        {
            $digits = preg_replace('/\D/', '', $issueId) ?? '';
            $digits = str_pad($digits === '' ? '0' : $digits, 2, '0', STR_PAD_LEFT);

            return 'issue-' . $digits;
        }

        /**
         * @return array{title: string, spreads: array<int, array<string, mixed>>}|null
         */
        public static function config(string $issueId): ?array
        {
            $path = self::configPath($issueId);

            if (! is_readable($path)) {
                return null;
            }

            $config = require $path;

            if (! is_array($config) || empty($config['spreads']) || ! is_array($config['spreads'])) {
                return null;
            }

            return $config;
        }

        public static function configPath(string $issueId): string
        {
            return dirname(__DIR__) . '/issues/' . self::issueSlug($issueId) . '.php';
        }

        /**
         * Singleton
         *
         * @return Issue
         */
        public static function instance()
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }

    Issue::instance();
}
