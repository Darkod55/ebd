<p align="center">
  <a href="https://roots.io/sage/"><img alt="Sage" src="https://cdn.roots.io/app/uploads/logo-sage.svg" height="100"></a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/roots/sage"><img alt="Packagist Installs" src="https://img.shields.io/packagist/dt/roots/sage?label=projects%20created&colorB=2b3072&colorA=525ddc&style=flat-square"></a>
  <a href="https://github.com/roots/sage/actions/workflows/main.yml"><img alt="Build Status" src="https://img.shields.io/github/actions/workflow/status/roots/sage/main.yml?branch=main&logo=github&label=CI&style=flat-square"></a>
  <a href="https://twitter.com/rootswp"><img alt="Follow Roots" src="https://img.shields.io/badge/follow%20@rootswp-1da1f2?logo=twitter&logoColor=ffffff&message=&style=flat-square"></a>
  <a href="https://github.com/sponsors/roots"><img src="https://img.shields.io/badge/sponsor%20roots-525ddc?logo=github&style=flat-square&logoColor=ffffff&message=" alt="Sponsor Roots"></a>
</p>

# Ethical Brand Directory

Sage theme for the magazine rebuild. WordPress is the CMS. The public pages should not load WordPress chrome beyond `wp_head` and `wp_footer`.

## Run it locally

From the theme directory, on the Node version in `.nvmrc` (Node 20; `package.json` also allows Node 22):

```bash
cd app/public/wp-content/themes/ebd
composer install
npm install
npm run build
npm run dev
```

`npm run dev` needs `APP_URL` set to the Local site URL when the default `http://example.test` is wrong. `local_url` in `docs/agent-context.md` is still `(pending)`.

Do not commit `vendor/`, `node_modules/`, or `public/build/`.

## Front-end cleanup

`app/Classes/FrontendCleanup.php` boots for logged-out visitors. Each line in `bootLoggedOutCleanup()` is one removal. Comment that line to put the piece back.

| Line | Removes |
| --- | --- |
| `stripBlockLibraryCss()` | Block library CSS. `SetupPlus::dequeueBlockEditorAssets()` also removes it for logged-in users, so comment both to restore it. |
| `stripClassicThemeStyles()` | `classic-theme-styles` |
| `stripGlobalStyles()` | Global styles and the SVG duotone filters |
| `stripEmoji()` | Emoji script, styles, `s.w.org` prefetch |
| `stripEmbeds()` | oEmbed discovery links and `wp-embed`. Stored embed HTML still prints. |
| `stripJquery()` | jQuery. Theme JS is Alpine only. Restore this if a plugin on the public site needs jQuery. |
| `stripDashicons()` | Dashicons. Logged-in users skip this whole method, so the admin bar keeps them. |
| `stripHeadClutter()` | Generator, RSD, wlwmanifest, shortlink, REST and oEmbed discovery, feeds, adjacent posts |
| `stripUnusedPluginAssets()` | Only the handles listed in that method. The list is empty. Add a handle when a plugin’s assets are not needed. Do not empty `wp_head`. |

Comments and pingbacks are off for everyone, including wp-admin, via `disableCommentsAndPingbacks()` in the constructor. Comment that call to bring them back.

## Issue reader

`/issue-01/` is the cover. `/issue-01/cover` is the same spread. Every other spread is `/issue-01/{slug}/`. These are normal pages: they render without JavaScript, and each one is a real link.

The list of spreads is `app/issues/issue-01.php`. Append an item to add a spread. `layout` is the Blade file `resources/views/issue/layouts/{layout}.blade.php`. The three placeholders are `full-bleed`, `split`, and `closing`. A new layout is a new file plus that name in the config. Nothing else is registered.

`thumbnail` is `null` or an image URL for the overview strip. `article.demo` links the spread to a scrolling page (`article`, `article-picks`, `the-edit`, …). `article.url` can be a full URL instead, for a future permalink.

From 1024px wide (`64rem`) up — laptop and desktop — the spread is exactly one viewport (`100vh`, then `100svh`, then `100dvh`) and does not scroll. Below 1024px — tablet and mobile — the spread may grow and the page scrolls. The bottom bar stays fixed, including the iOS safe-area inset, and the page reserves that height so it does not cover the spread.

The bar is prev, `N / total` (a `<details>` overview of every spread), next, and Menu (contact and the other placeholder pages). Arrow keys, swipe, neighbour prefetch, and a short fade are the Alpine extras. `prefers-reduced-motion: reduce` does a normal page load instead. Esc or a click outside closes the overview.

`/?ebd_demo=issue-01` redirects to `/issue-01/`. Permalinks flush once when the theme boots (`ebd_issue_rewrite`).

## Static demo → later data

Placeholder copy for the other pages is in `app/Classes/DemoCatalog.php`. Every string says Placeholder. Preview without creating pages:

- `/issue-01/` (and `/issue-01/opener`, `/picture`, `/colophon`, …)
- `/?ebd_demo=article`
- `/?ebd_demo=article-picks`
- `/?ebd_demo=contributors`
- `/?ebd_demo=about`
- `/?ebd_demo=the-edit`
- `/?ebd_demo=partner`
- `/?ebd_demo=contact`

The same files are page templates (`Template Name` in `resources/views/template-*.blade.php`). Assign one to a page when you want a real URL. Then change `DemoCatalog::url()` to `get_permalink()`.

| Template | Later source |
| --- | --- |
| Issue 01 spreads | `app/issues/issue-01.php`. One row per spread. Layout Blade files in `resources/views/issue/layouts/`. |
| Article | Single article. `article()` — author, role, toc, sections. |
| Editor’s picks | Same article, plus a product repeater (`picks()`). |
| Contributors | Contributor posts. `contributors()` — name, role, bio. |
| About | Page. `about()`. |
| The Edit | Brand posts. `brands()` — name, category, city, summary. |
| Partner | Page. `partner()`. |
| Contact | Page. Form is a shell (`@submit.prevent`). No email and no storage. |

Shared partials: `resources/views/partials/issue/` (masthead, footer, byline, toc, newsletter, ad slot). Layout: `resources/views/layouts/issue.blade.php`. The starter header and front page are unchanged.

Colours and type: `docs/design-tokens.md` is the edit point. Runtime values are in `resources/css/theme/variables.css`. Fonts are self-hosted Cormorant Garamond and Raleway (`resources/css/theme/fonts.css`). No Google Fonts request.

# Sage

**Advanced hybrid WordPress starter theme with Laravel Blade and Tailwind CSS**

- 🔧 Clean, efficient theme templating with Laravel Blade
- ⚡️ Modern front-end development workflow powered by Vite
- 🎨 Out of the box support for Tailwind CSS
- 🚀 Harness the power of Laravel with [Acorn integration](https://github.com/roots/acorn)
- 📦 Block editor support built-in

Sage brings proper PHP templating and modern JavaScript tooling to WordPress themes. Write organized, component-based code using Laravel Blade, enjoy instant builds and CSS hot-reloading with Vite, and leverage Laravel's robust feature set through Acorn.

[Read the docs to get started](https://roots.io/sage/docs/installation/)

## Support us

Roots is an independent open source org, supported only by developers like you. Your sponsorship funds [WP Packages](https://wp-packages.org/) and the entire Roots ecosystem, and keeps them independent. Support us by purchasing [Radicle](https://roots.io/radicle/) or [sponsoring us on GitHub](https://github.com/sponsors/roots) — sponsors get access to our private Discord.

### Sponsors

<a href="https://carrot.com/"><img src="https://cdn.roots.io/app/uploads/carrot.svg" alt="Carrot" height="90"></a> <a href="https://wordpress.com/"><img src="https://cdn.roots.io/app/uploads/wordpress.svg" alt="WordPress.com" height="90"></a> <a href="https://www.itineris.co.uk/"><img src="https://cdn.roots.io/app/uploads/itineris.svg" alt="Itineris" height="90"></a> <a href="https://kinsta.com/?kaid=OFDHAJIXUDIV"><img src="https://cdn.roots.io/app/uploads/kinsta.svg" alt="Kinsta" height="90"></a> <a href="https://40q.agency/"><img src="https://cdn.roots.io/app/uploads/40q.svg" alt="40Q" height="90"></a>

## Community

Keep track of development and community news.

- Join us on Discord by [sponsoring us on GitHub](https://github.com/sponsors/roots)
- Join us on [Roots Discourse](https://discourse.roots.io/)
- Follow [@rootswp on Twitter](https://twitter.com/rootswp)
- Follow the [Roots Blog](https://roots.io/blog/)
- Subscribe to the [Roots Newsletter](https://roots.io/subscribe/)
