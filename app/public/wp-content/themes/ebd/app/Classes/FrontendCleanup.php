<?php

namespace App;

use App\Filters\Traits\frontend;
use App\Filters\Traits\strings;

if (!class_exists(__NAMESPACE__.'\\FrontendCleanup')) {
    /**
     * Class FrontendCleanup
     *
     * Strips WordPress front-end noise for logged-out visitors.
     * Comment one line in bootLoggedOutCleanup() to restore that piece.
     * Comments are the exception: they stay off in wp-admin too.
     *
     * @package App
     */
    class FrontendCleanup
    {
        private static $instance;

        use frontend;
        use strings;

        /**
         * FrontendCleanup constructor.
         */
        protected function __construct()
        {
            // Comments and pingbacks off everywhere, including wp-admin.
            $this->disableCommentsAndPingbacks();

            add_action('wp', [$this, 'bootLoggedOutCleanup']);
        }

        /**
         * Asset and head toggles. Skipped for logged-in users so the admin
         * bar still loads.
         *
         * @return void
         */
        public function bootLoggedOutCleanup(): void
        {
            if (is_user_logged_in() || is_admin()) {
                return;
            }

            $this->stripBlockLibraryCss(); // Core block library CSS. SetupPlus also removes it for logged-in users.
            $this->stripClassicThemeStyles(); // classic-theme-styles handle.
            $this->stripGlobalStyles(); // Global styles CSS and SVG duotone filters.
            $this->stripEmoji(); // Emoji script, styles, and the s.w.org prefetch.
            $this->stripEmbeds(); // oEmbed discovery links and wp-embed. Theme JS does not use them.
            $this->stripJquery(); // jQuery. Theme JS is Alpine only. Restore if a plugin needs it.
            $this->stripDashicons(); // Dashicons. The admin bar never reaches this line.
            $this->stripHeadClutter(); // generator, RSD, wlwmanifest, shortlink, REST/oEmbed discovery, feeds, adjacent posts.
            $this->stripUnusedPluginAssets(); // Named plugin handles only. The list is empty until you add one.
        }

        /**
         * Singleton
         *
         * @return FrontendCleanup
         */
        public static function instance()
        {
            if (! (self::$instance instanceof self)) {
                self::$instance = new self;
            }

            return self::$instance;
        }
    }

    FrontendCleanup::instance();
}
