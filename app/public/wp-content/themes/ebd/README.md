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

## Static demo → later data

Placeholder copy is in `app/Classes/DemoCatalog.php`. Every string says Placeholder. Preview without creating pages:

- `/?ebd_demo=issue-01`
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
| Issue 01 cover | Front page. `DemoCatalog::issue()` — kicker, title, deck, features. |
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
