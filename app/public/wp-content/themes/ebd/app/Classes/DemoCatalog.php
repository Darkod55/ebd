<?php

namespace App;

if (!class_exists(__NAMESPACE__.'\\DemoCatalog')) {
    /**
     * Class DemoCatalog
     *
     * Placeholder copy for the static Issue 01 demo.
     * Every string is labelled Placeholder. Nothing here is real content.
     *
     * Later, replace the arrays with queries. The keys match the fields
     * a post type would store. url() is the only link helper; point it
     * at get_permalink() when the pages exist.
     *
     * Preview without creating pages: /?ebd_demo=issue-01 (see views()).
     * The same Blade files are also page templates (Template Name).
     *
     * @package App
     */
    class DemoCatalog
    {
        private static $instance;

        /**
         * DemoCatalog constructor.
         */
        protected function __construct()
        {
            add_action('template_redirect', [$this, 'renderPreview']);
        }

        /**
         * Query-string preview of the static templates.
         * Remove this method when the pages are real.
         *
         * @return void
         */
        public function renderPreview(): void
        {
            if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
                return;
            }

            $key = isset($_GET['ebd_demo']) ? sanitize_key(wp_unslash($_GET['ebd_demo'])) : '';

            // The magazine itself is /issue-01/, not this query preview.
            if ($key === 'issue-01') {
                wp_safe_redirect(home_url('/issue-01/'));
                exit;
            }

            $view = self::views()[$key] ?? null;

            if (! $view) {
                return;
            }

            status_header(200);
            nocache_headers();
            echo \view($view)->render();
            exit;
        }

        /**
         * Preview key => Blade view (also the page template file name).
         *
         * @return array<string, string>
         */
        public static function views(): array
        {
            return [
                'issue-01' => 'template-issue-01',
                'article' => 'template-article',
                'article-picks' => 'template-article-picks',
                'contributors' => 'template-contributors',
                'about' => 'template-about',
                'the-edit' => 'template-the-edit',
                'partner' => 'template-partner',
                'contact' => 'template-contact',
            ];
        }

        /**
         * @return array<int, array{label: string, key: string}>
         */
        public static function nav(): array
        {
            return [
                ['label' => 'Issue 01', 'key' => 'issue-01'],
                ['label' => 'The Edit', 'key' => 'the-edit'],
                ['label' => 'Contributors', 'key' => 'contributors'],
                ['label' => 'About', 'key' => 'about'],
                ['label' => 'Partner', 'key' => 'partner'],
                ['label' => 'Contact', 'key' => 'contact'],
            ];
        }

        /**
         * Temporary href. Swap for a permalink when the page exists.
         */
        public static function url(string $key): string
        {
            if ($key === 'issue-01') {
                return home_url(Issue::path('issue-01', 'cover'));
            }

            return add_query_arg('ebd_demo', $key, home_url('/'));
        }

        /**
         * Future: front page / issue post. Fields: kicker, title, deck, edition, features[].
         *
         * @return array<string, mixed>
         */
        public static function issue(): array
        {
            return [
                'kicker' => 'Placeholder · Issue 01',
                'title' => 'Placeholder cover line',
                'deck' => 'Placeholder deck. This becomes the issue introduction.',
                'edition' => 'Placeholder · London',
                'features' => [
                    [
                        'kicker' => 'Placeholder · Fashion',
                        'title' => 'Placeholder article title',
                        'author' => 'Placeholder Author',
                        'href' => self::url('article'),
                    ],
                    [
                        'kicker' => 'Placeholder · Beauty',
                        'title' => 'Placeholder editor’s picks',
                        'author' => 'Placeholder Editor',
                        'href' => self::url('article-picks'),
                    ],
                    [
                        'kicker' => 'Placeholder · Directory',
                        'title' => 'Placeholder brand cards',
                        'author' => 'The Edit',
                        'href' => self::url('the-edit'),
                    ],
                ],
            ];
        }

        /**
         * Future: article post. Fields: kicker, title, deck, author, role, toc[], sections[].
         *
         * @return array<string, mixed>
         */
        public static function article(): array
        {
            return [
                'kicker' => 'Placeholder · Fashion',
                'title' => 'Placeholder article title',
                'deck' => 'Placeholder deck for a single article. Two or three sentences.',
                'author' => 'Placeholder Author',
                'role' => 'Placeholder · Contributing editor',
                'date' => 'Placeholder · Issue 01',
                'toc' => [
                    ['id' => 'one', 'label' => 'Placeholder · First section'],
                    ['id' => 'two', 'label' => 'Placeholder · Second section'],
                    ['id' => 'three', 'label' => 'Placeholder · Third section'],
                ],
                'sections' => [
                    [
                        'id' => 'one',
                        'heading' => 'Placeholder · First section',
                        'body' => 'Placeholder paragraph. The article body will come from the post content.',
                    ],
                    [
                        'id' => 'two',
                        'heading' => 'Placeholder · Second section',
                        'body' => 'Placeholder paragraph. A second block, so the table of contents has somewhere to land.',
                    ],
                    [
                        'id' => 'three',
                        'heading' => 'Placeholder · Third section',
                        'body' => 'Placeholder paragraph. Short on purpose. Real copy is a later pass.',
                    ],
                ],
            ];
        }

        /**
         * Future: article variant, or a product repeater on a beauty story.
         *
         * @return array<string, mixed>
         */
        public static function picks(): array
        {
            $article = self::article();
            $article['kicker'] = 'Placeholder · Beauty';
            $article['title'] = 'Placeholder editor’s picks';
            $article['deck'] = 'Placeholder deck. Same article shell, with a product grid instead of a long essay.';
            $article['products'] = [
                ['name' => 'Placeholder product', 'brand' => 'Placeholder brand', 'note' => 'Placeholder · one line'],
                ['name' => 'Placeholder product', 'brand' => 'Placeholder brand', 'note' => 'Placeholder · one line'],
                ['name' => 'Placeholder product', 'brand' => 'Placeholder brand', 'note' => 'Placeholder · one line'],
                ['name' => 'Placeholder product', 'brand' => 'Placeholder brand', 'note' => 'Placeholder · one line'],
            ];

            return $article;
        }

        /**
         * Future: contributor post type. Fields: name, role, bio.
         *
         * @return array<int, array<string, string>>
         */
        public static function contributors(): array
        {
            return [
                ['name' => 'Placeholder Name', 'role' => 'Placeholder · Editor', 'bio' => 'Placeholder bio. One or two sentences.'],
                ['name' => 'Placeholder Name', 'role' => 'Placeholder · Writer', 'bio' => 'Placeholder bio. One or two sentences.'],
                ['name' => 'Placeholder Name', 'role' => 'Placeholder · Photographer', 'bio' => 'Placeholder bio. One or two sentences.'],
            ];
        }

        /**
         * Future: about page content.
         *
         * @return array<string, mixed>
         */
        public static function about(): array
        {
            return [
                'kicker' => 'Placeholder · About',
                'title' => 'Placeholder about title',
                'paragraphs' => [
                    'Placeholder paragraph. Who publishes the magazine.',
                    'Placeholder paragraph. What the directory is for.',
                ],
            ];
        }

        /**
         * Future: brand post type. Fields: name, category, city, summary.
         *
         * @return array<int, array<string, string>>
         */
        public static function brands(): array
        {
            return [
                ['name' => 'Placeholder Brand', 'category' => 'Placeholder · Clothing', 'city' => 'Placeholder · City', 'summary' => 'Placeholder summary. One sentence.'],
                ['name' => 'Placeholder Brand', 'category' => 'Placeholder · Beauty', 'city' => 'Placeholder · City', 'summary' => 'Placeholder summary. One sentence.'],
                ['name' => 'Placeholder Brand', 'category' => 'Placeholder · Home', 'city' => 'Placeholder · City', 'summary' => 'Placeholder summary. One sentence.'],
                ['name' => 'Placeholder Brand', 'category' => 'Placeholder · Jewellery', 'city' => 'Placeholder · City', 'summary' => 'Placeholder summary. One sentence.'],
            ];
        }

        /**
         * Future: partner page.
         *
         * @return array<string, mixed>
         */
        public static function partner(): array
        {
            return [
                'kicker' => 'Placeholder · Partner',
                'title' => 'Placeholder partnership title',
                'paragraphs' => [
                    'Placeholder paragraph. Why a brand would partner.',
                    'Placeholder paragraph. What an issue partnership includes.',
                ],
            ];
        }

        /**
         * Future: contact page. The form does not submit.
         *
         * @return array<string, string>
         */
        public static function contact(): array
        {
            return [
                'kicker' => 'Placeholder · Contact',
                'title' => 'Placeholder contact title',
                'intro' => 'Placeholder intro. The form below is a shell. It does not send.',
            ];
        }

        /**
         * Singleton
         *
         * @return DemoCatalog
         */
        public static function instance()
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }

    DemoCatalog::instance();
}
