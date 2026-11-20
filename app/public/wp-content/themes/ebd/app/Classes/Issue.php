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

        public const REWRITE_VERSION = '2';

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
                '^issue-([0-9]+)/([^/]+)/read/?$',
                'index.php?ebd_issue=$matches[1]&ebd_spread=$matches[2]&ebd_read=1',
                'top'
            );
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
            $vars[] = 'ebd_read';

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

            $isRead = (string) get_query_var('ebd_read') === '1';
            $piece = null;

            if ($isRead) {
                $piece = self::piece($model['spread']['read_key'] ?? '');
                if ($piece === null) {
                    global $wp_query;
                    $wp_query->set_404();
                    status_header(404);
                    nocache_headers();
                    echo \view('404')->render();
                    exit;
                }
            }

            $title = ($isRead ? $piece['title'] : $model['spread']['title']) . ' — ' . $model['issue_title'];
            $canonical = $isRead ? self::url($model['issue_slug'], $model['spread']['slug'] . '/read') : $model['spread']['url'];

            add_filter('pre_get_document_title', static function () use ($title) {
                return $title;
            });
            add_filter('get_canonical_url', static function () use ($canonical) {
                return $canonical;
            });
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

            status_header(200);

            if ($isRead) {
                echo \view('issue.article', [
                    'piece' => $piece,
                    'issue_title' => $model['issue_title'],
                    'spread_url' => $model['spread']['url'],
                ])->render();
                exit;
            }

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

            $config['spreads'] = self::hydrate($config['spreads'], $issueSlug);

            $spreadSlug = sanitize_title($spreadSlug);
            $items = $config['spreads'];
            $index = null;

            $public = [];
            foreach ($items as $item) {
                if (empty($item['study'])) {
                    $public[] = $item;
                }
            }
            $items = $public;

            foreach ($items as $i => $item) {
                if ($item['slug'] === $spreadSlug) {
                    $index = $i;
                    break;
                }
            }

            if ($index === null) {
                foreach ($config['spreads'] as $item) {
                    if (($item['slug'] ?? '') === $spreadSlug && ! empty($item['study'])) {
                        $items = [$item];
                        $index = 0;
                        break;
                    }
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
                    'thumbnail' => self::publicImage($item['thumbnail'] ?? null),
                    'current' => $i === $index,
                ];
            }

            $current = $items[$index];
            $layout = (string) $current['layout'];

            if (! preg_match('/^[a-z0-9-]+$/', $layout) || ! \view()->exists('issue.layouts.' . $layout)) {
                return null;
            }

            $article = is_array($current['article'] ?? null) ? $current['article'] : [];
            $readKey = is_string($article['read'] ?? null) ? $article['read'] : '';
            $articleUrl = '';

            if ($readKey !== '') {
                $articleUrl = self::url($issueSlug, $current['slug'] . '/read');
            } elseif (! empty($article['url']) && is_string($article['url'])) {
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
                'thumbnail' => self::publicImage($current['thumbnail'] ?? null),
                'read_key' => $readKey,
                'article_url' => $articleUrl,
                'article_label' => (string) ($article['label'] ?? 'Read more'),
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
         * Pour article text into the spreads that ask for it.
         * Paragraphs stay whole. Anything left over becomes another two-column spread.
         *
         * @param array<int, array<string, mixed>> $spreads
         * @return array<int, array<string, mixed>>
         */
        public static function hydrate(array $spreads, string $issueSlug): array
        {
            $catalog = self::articles();
            $ads = self::ads();
            $streams = [];

            foreach ($catalog as $key => $piece) {
                if (! empty($piece['blocks']) && is_array($piece['blocks'])) {
                    $streams[$key] = array_values($piece['blocks']);
                }
            }

            $cursors = [];
            $openers = [];
            $filled = [];

            foreach ($spreads as $spread) {
                $from = $spread['from'] ?? null;
                if (! empty($spread['ending']) && is_string($from) && isset($streams[$from])) {
                    $guard = 0;
                    $budget = (int) ($spread['words'] ?? 220);
                    while (self::wordsLeft($streams[$from], $cursors[$from] ?? 0) > ($budget + 70) && $guard < 8) {
                        $filled[] = self::fillSpread([
                            'slug' => $from.'-cont-'.($guard + 1),
                            'from' => $from,
                            'layout' => 'article-two-column',
                            'words' => 280,
                            'leave' => $budget,
                            'placeholder' => false,
                        ], $catalog, $ads, $streams, $cursors, $openers, $issueSlug);
                        $guard++;
                    }
                }

                $filled[] = self::fillSpread($spread, $catalog, $ads, $streams, $cursors, $openers, $issueSlug);
            }

            return $filled;
        }

        /**
         * @param array<int, array<string, mixed>> $blocks
         */
        private static function wordsLeft(array $blocks, int $cursor): int
        {
            $words = 0;
            for ($i = $cursor; $i < count($blocks); $i++) {
                $words += str_word_count(wp_strip_all_tags((string) ($blocks[$i]['text'] ?? '')));
            }

            return $words;
        }

        /**
         * @param array<string, mixed> $spread
         * @param array<string, array<string, mixed>> $catalog
         * @param array<string, array<string, mixed>> $ads
         * @param array<string, array<int, array<string, mixed>>> $streams
         * @param array<string, int> $cursors
         * @param array<string, string> $openers
         * @return array<string, mixed>
         */
        private static function fillSpread(array $spread, array $catalog, array $ads, array &$streams, array &$cursors, array &$openers, string $issueSlug): array
        {
            $data = is_array($spread['data'] ?? null) ? $spread['data'] : [];
            $from = $spread['from'] ?? null;

            if (is_string($from) && isset($streams[$from], $catalog[$from])) {
                $piece = $catalog[$from];
                $cursor = $cursors[$from] ?? 0;
                $isFirst = $cursor === 0;
                $budget = (int) ($spread['words'] ?? 220);
                $blocks = $streams[$from];
                $quote = null;

                if (($spread['layout'] ?? '') === 'pull-quote') {
                    foreach ($blocks as $j => $block) {
                        if ($j < $cursor) {
                            continue;
                        }
                        if (($block['type'] ?? '') === 'quote') {
                            $quote = $block['text'];
                            array_splice($blocks, $j, 1);
                            $streams[$from] = $blocks;
                            break;
                        }
                    }
                }

                $leave = (int) ($spread['leave'] ?? 0);
                $taken = [];
                $count = 0;
                while ($cursor < count($blocks)) {
                    $words = str_word_count(wp_strip_all_tags((string) $blocks[$cursor]['text']));
                    $after = self::wordsLeft($blocks, $cursor + 1);
                    if ($taken !== [] && $leave > 0 && $after < $leave) {
                        break;
                    }
                    if ($taken !== [] && $leave === 0 && ($count + $words) > $budget) {
                        break;
                    }
                    $taken[] = $blocks[$cursor];
                    $count += $words;
                    $cursor++;
                    if ($count >= $budget) {
                        break;
                    }
                }

                $cursors[$from] = $cursor;
                if ($isFirst) {
                    $openers[$from] = (string) $spread['slug'];
                    if (isset($taken[0]) && ($taken[0]['type'] ?? '') === 'p') {
                        $taken[0]['drop'] = true;
                    }
                }

                $cols = 2;
                if (str_contains((string) $spread['layout'], 'three')) {
                    $cols = 3;
                }
                if (in_array($spread['layout'], ['article-opener', 'article-opener-banner', 'article-with-half-ad', 'pull-quote'], true)) {
                    $cols = 1;
                }

                $allWords = str_word_count(wp_strip_all_tags(
                    (string) ($piece['standfirst'] ?? '').' '.implode(' ', array_column($piece['blocks'], 'text'))
                ));

                $data = array_merge($data, [
                    'blocks' => $taken,
                    'columns' => self::splitColumns($taken, $cols),
                    'quote' => $quote,
                    'continued' => ! $isFirst,
                    'show_title' => $isFirst,
                    'heading' => $isFirst ? (string) $piece['title'] : (string) ($piece['kicker'] ?? 'Continued'),
                    'dek' => $isFirst ? (string) ($piece['standfirst'] ?? '') : '',
                    'kicker' => $data['kicker'] ?? (string) ($piece['kicker'] ?? ''),
                    'byline' => $isFirst ? (string) ($piece['byline'] ?? '') : '',
                    'role' => (string) ($piece['role'] ?? ''),
                    'words' => $allWords,
                    'single_url' => $cursor >= count($streams[$from])
                        ? self::url($issueSlug, ($openers[$from] ?? $spread['slug']).'/read')
                        : '',
                ]);

                $spread['title'] = $isFirst
                    ? (string) $piece['title']
                    : (string) ($piece['kicker'] ?? 'Continued').' · continued';
                $spread['article'] = ['read' => $from, 'label' => ''];
            }

            if (! empty($spread['ad']) && isset($ads[$spread['ad']])) {
                $data['ad'] = $ads[$spread['ad']];
                if (empty($spread['title'])) {
                    $spread['title'] = 'Placeholder ad · '.$ads[$spread['ad']]['brand'];
                }
            }

            if (($spread['layout'] ?? '') === 'contributors-grid') {
                $data['people'] = $catalog['contributors']['people'] ?? [];
            }

            $spread['data'] = $data;

            if (empty($spread['title'])) {
                $spread['title'] = (string) ($data['heading'] ?? 'Spread');
            }

            return $spread;
        }

        /**
         * @param array<int, array<string, mixed>> $blocks
         * @return array<int, array<int, array<string, mixed>>>
         */
        private static function splitColumns(array $blocks, int $cols): array
        {
            $cols = max(1, $cols);
            if ($cols === 1 || $blocks === []) {
                return [$blocks];
            }

            $total = 0;
            foreach ($blocks as $block) {
                $total += str_word_count(wp_strip_all_tags((string) $block['text']));
            }

            $target = (int) ceil($total / $cols);
            $columns = [];
            $index = 0;
            $count = 0;
            $columns[$index] = [];

            foreach ($blocks as $block) {
                $words = str_word_count(wp_strip_all_tags((string) $block['text']));
                if ($index < ($cols - 1) && $count > 0 && $count >= $target) {
                    $index++;
                    $count = 0;
                    $columns[$index] = [];
                }
                $columns[$index][] = $block;
                $count += $words;
            }

            return $columns;
        }

        /**
         * @return array<string, array<string, mixed>>
         */
        public static function ads(): array
        {
            $path = dirname(__DIR__).'/issues/ads.php';
            if (! is_readable($path)) {
                return [];
            }
            $ads = require $path;

            return is_array($ads) ? $ads : [];
        }

        /**
         * @return array<int, array{label: string, url: string}>
         */
        public static function menu(): array
        {
            return [
                ['label' => 'Contact', 'url' => DemoCatalog::url('contact')],
                ['label' => 'The Edit', 'url' => self::url('issue-01', 'the-edit/read')],
                ['label' => 'Contributors', 'url' => self::url('issue-01', 'contributors/read')],
            ];
        }

        /**
         * @return array<string, mixed>|null
         */
        public static function piece(string $key): ?array
        {
            if ($key === '' || ! preg_match('/^[a-z0-9-]+$/', $key)) {
                return null;
            }

            $all = self::articles();

            return is_array($all[$key] ?? null) ? $all[$key] : null;
        }

        /**
         * @return array<string, array<string, mixed>>
         */
        public static function articles(): array
        {
            $path = dirname(__DIR__) . '/issues/articles.php';

            if (! is_readable($path)) {
                return [];
            }

            $articles = require $path;

            return is_array($articles) ? $articles : [];
        }

        /**
         * Theme file URI for an optimised issue image. Pass the webp filename.
         */
        public static function image(string $file): string
        {
            return get_theme_file_uri('resources/images/issue-01/' . ltrim($file, '/'));
        }

        public static function imageAvif(string $file): string
        {
            return self::image((string) preg_replace('/\.webp$/', '.avif', $file));
        }

        /**
         * @param mixed $file
         */
        public static function publicImage($file): ?string
        {
            if (! is_string($file) || $file === '') {
                return null;
            }

            if (str_contains($file, '/')) {
                return $file;
            }

            return self::image($file);
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
