<?php

namespace App\Filters\Traits;

/**
 * Trait frontend
 *
 * Logged-out public front end. Each method is one toggle. The calls live
 * in App\FrontendCleanup::bootLoggedOutCleanup(). Comment a call to put
 * that piece back.
 *
 * wp_head and wp_footer stay registered so SEO, analytics, and security
 * plugins can still print. This trait is not booted for logged-in users,
 * so the admin bar is untouched.
 *
 * @package App\Filters\Traits
 */
trait frontend
{
    /**
     * Core block library CSS (combined handle and per-block wp-block-*).
     * Theme CSS owns the look.
     *
     * SetupPlus::dequeueBlockEditorAssets() also strips these handles for
     * every visitor, including logged-in users. Commenting only this toggle
     * does not bring the CSS back until that method is commented too.
     */
    public function stripBlockLibraryCss(): void
    {
        add_action('wp_enqueue_scripts', function () {
            foreach ([
                'wp-block-library',
                'wp-block-library-theme',
                'global-styles',
            ] as $handle) {
                wp_dequeue_style($handle);
                wp_deregister_style($handle);
            }

            $styles = wp_styles();

            if (! $styles) {
                return;
            }

            foreach (array_keys($styles->registered) as $handle) {
                if (str_starts_with((string) $handle, 'wp-block-')) {
                    wp_dequeue_style($handle);
                }
            }
        }, 100);
    }

    /**
     * classic-theme-styles. Separate from the block library so it can be
     * restored on its own.
     */
    public function stripClassicThemeStyles(): void
    {
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('classic-theme-styles');
            wp_deregister_style('classic-theme-styles');
        }, 100);
    }

    /**
     * theme.json global stylesheet and the SVG duotone filters WordPress
     * injects in the body.
     */
    public function stripGlobalStyles(): void
    {
        remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
        remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        remove_action('wp_footer', 'wp_global_styles_render_svg_filters');
    }

    /**
     * Emoji detection script, inline styles, email substitution, and the
     * s.w.org dns-prefetch.
     */
    public function stripEmoji(): void
    {
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_filter('the_content_feed', 'wp_staticize_emoji');
        remove_filter('comment_text_rss', 'wp_staticize_emoji');
        remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
        add_filter('emoji_svg_url', '__return_false');

        add_filter('tiny_mce_plugins', function ($plugins) {
            return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
        });

        add_filter('wp_resource_hints', function ($urls, $relation) {
            if ($relation !== 'dns-prefetch' || ! is_array($urls)) {
                return $urls;
            }

            return array_values(array_filter($urls, function ($url) {
                return ! is_string($url) || ! str_contains($url, 's.w.org');
            }));
        }, 10, 2);
    }

    /**
     * oEmbed discovery <link> tags and the wp-embed script.
     * Embed HTML already stored in post content still prints.
     */
    public function stripEmbeds(): void
    {
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');

        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_script('wp-embed');
            wp_deregister_script('wp-embed');
        }, 100);
    }

    /**
     * jQuery and jquery-migrate.
     * resources/js/app.js does not use jQuery (Alpine only). Comment this
     * toggle back in if a plugin on the public site actually needs it.
     */
    public function stripJquery(): void
    {
        add_action('wp_enqueue_scripts', function () {
            foreach (['jquery', 'jquery-core', 'jquery-migrate'] as $handle) {
                wp_dequeue_script($handle);
                wp_deregister_script($handle);
            }
        }, 100);
    }

    /**
     * Dashicons. Logged-in requests never reach this method, so the admin
     * bar keeps the icon font.
     */
    public function stripDashicons(): void
    {
        add_action('wp_enqueue_scripts', function () {
            wp_dequeue_style('dashicons');
            wp_deregister_style('dashicons');
        }, 100);
    }

    /**
     * Generator, RSD, Windows Live Writer, shortlink, REST and oEmbed
     * discovery, feed links, and adjacent-post links.
     */
    public function stripHeadClutter(): void
    {
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        remove_action('template_redirect', 'wp_shortlink_header', 11);
        remove_action('template_redirect', 'rest_output_link_header', 11);
    }

    /**
     * Plugin styles and scripts that a public page does not need.
     * Add a registered handle. Do not guess. An empty list removes
     * nothing, so SEO, analytics, and security tags on wp_head stay.
     */
    public function stripUnusedPluginAssets(): void
    {
        add_action('wp_enqueue_scripts', function () {
            foreach ([
                // 'contact-form-7',
            ] as $handle) {
                wp_dequeue_style($handle);
                wp_dequeue_script($handle);
            }
        }, 100);
    }
}
