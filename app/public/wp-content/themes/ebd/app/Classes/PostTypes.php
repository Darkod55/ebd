<?php

namespace App\PostTypes;

if (! class_exists(__NAMESPACE__ . '\PostTypes')) {
    /**
     * Theme custom post types.
     */
    class PostTypes
    {
        public const FEATURED_URL_META = 'mpx_featured_url';

        private static $instance;

        protected function __construct()
        {
            add_action('init', [$this, 'register'], 5);
            add_action('add_meta_boxes', [$this, 'registerMetaBoxes']);
            add_action('save_post_featured-post', [$this, 'saveFeaturedUrl'], 10, 2);
        }

        public function register(): void
        {
            register_post_type('featured-post', [
                'labels' => [
                    'name' => __('Featured Posts', 'sage'),
                    'singular_name' => __('Featured Post', 'sage'),
                    'add_new' => __('Add New', 'sage'),
                    'add_new_item' => __('Add New Featured Post', 'sage'),
                    'edit_item' => __('Edit Featured Post', 'sage'),
                    'new_item' => __('New Featured Post', 'sage'),
                    'view_item' => __('View Featured Post', 'sage'),
                    'search_items' => __('Search Featured Posts', 'sage'),
                    'not_found' => __('No featured posts found', 'sage'),
                    'not_found_in_trash' => __('No featured posts found in Trash', 'sage'),
                    'all_items' => __('All Featured Posts', 'sage'),
                    'menu_name' => __('Featured Posts', 'sage'),
                ],
                'public' => true,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-star-filled',
                'menu_position' => 21,
                'has_archive' => false,
                'rewrite' => false,
                'exclude_from_search' => true,
                'supports' => ['title', 'editor', 'thumbnail', 'revisions', 'page-attributes'],
            ]);

            register_post_meta('featured-post', self::FEATURED_URL_META, [
                'type' => 'string',
                'single' => true,
                'default' => '',
                'show_in_rest' => true,
                'auth_callback' => static function (): bool {
                    return current_user_can('edit_posts');
                },
                'sanitize_callback' => static function ($value): string {
                    return esc_url_raw(is_string($value) ? $value : '');
                },
            ]);
        }

        public function registerMetaBoxes(): void
        {
            add_meta_box(
                'mpx-featured-post-url',
                __('Read more URL', 'sage'),
                [$this, 'renderFeaturedUrlMetaBox'],
                'featured-post',
                'side',
                'default'
            );
        }

        public function renderFeaturedUrlMetaBox(\WP_Post $post): void
        {
            wp_nonce_field('mpx_featured_url_save', 'mpx_featured_url_nonce');

            $url = (string) get_post_meta($post->ID, self::FEATURED_URL_META, true);
            ?>
            <p>
                <label class="screen-reader-text" for="mpx_featured_url">
                    <?php esc_html_e('Read more URL', 'sage'); ?>
                </label>
                <input
                    type="url"
                    class="widefat"
                    id="mpx_featured_url"
                    name="<?php echo esc_attr(self::FEATURED_URL_META); ?>"
                    value="<?php echo esc_attr($url); ?>"
                    placeholder="https://"
                />
            </p>
            <p class="description">
                <?php esc_html_e('Optional. Shown as a Read more button in the featured post modal.', 'sage'); ?>
            </p>
            <?php
        }

        public function saveFeaturedUrl(int $postId, \WP_Post $post): void
        {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if ($post->post_type !== 'featured-post') {
                return;
            }

            if (! isset($_POST['mpx_featured_url_nonce'])
                || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['mpx_featured_url_nonce'])), 'mpx_featured_url_save')
            ) {
                return;
            }

            if (! current_user_can('edit_post', $postId)) {
                return;
            }

            $raw = isset($_POST[self::FEATURED_URL_META])
                ? wp_unslash($_POST[self::FEATURED_URL_META])
                : '';
            $url = esc_url_raw(is_string($raw) ? $raw : '');

            if ($url === '') {
                delete_post_meta($postId, self::FEATURED_URL_META);
            } else {
                update_post_meta($postId, self::FEATURED_URL_META, $url);
            }
        }

        public static function instance(): self
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }

    PostTypes::instance();
}
