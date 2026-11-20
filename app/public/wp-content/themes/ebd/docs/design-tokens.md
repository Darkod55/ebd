# Design tokens — rebrand playbook

> **Project:** Ethical Brand Directory — magazine rebuild (Issue 01) plus a simple brand directory. WordPress is the CMS; the public front end should stay free of WordPress chrome.
> **Populated:** 20 Nov 2026 from the public CSS on https://ethicalbranddirectory.com/ (read-only; that site was not changed).
> Colour hexes below are copied from that CSS, not estimated. The current homepage editorial `:root` (`--ebd-*`) is the palette. Astra’s link colour and the Elementor kit are recorded in **§ Project notes** and were not promoted over the homepage tokens. See that section for the audit hexes that do not appear in the live CSS.

## Order on a new site

1. **First** `docs/agent-context.md` — identity, `AGENTS.md`, Cursor rules, path retargets
2. **This file** (`docs/design-tokens.md`) — brand tokens, type, buttons

On an existing site that already has agent context, you can run this playbook alone for rebrand-only work.

---

**Human input:** edit the **Active** blocks in this file only.  
**Runtime CSS:** `resources/css/theme/variables.css` (and related files) — written by the agent.

### Agent prompt (copy/paste)

```text
Read docs/design-tokens.md in this theme. For every Active value that is not (pending), write it into the mapped targets (variables.css, typography.css, button sync files). Run palette / type / button sync checklists, then npm run build from the theme directory. Do not invent tokens or button variants that are not listed. Do not reverse-engineer existing clamp() values. (pending) = leave that target unchanged.
```

Paths below are theme-relative (`app/public/wp-content/themes/ebd/…`).

---

## Source of truth

| Role | Where |
| --- | --- |
| **You edit** | This file — Active brand tokens, type scale, button recipes |
| **Agent writes** | `variables.css`, `typography.css`, `buttons.css`, `editor.css`, `button.json`, `trait-blocks.php` (+ optional nav) |
| Fonts (files / `@font-face`) | `resources/css/theme/fonts.css` (swap files separately if needed) |

Never invent one-off hex / magic widths / radii / type sizes in components. Use `var(--…)` / theme utilities after apply.

---

## Active brand tokens

Edit values here. Agent maps each key → `variables.css` `@theme static`.  
`(pending)` = skip that key. Remove a colour key only when intentionally dropping it (then run palette sync).

```text
# Colours → --color-{name}
# Sources: homepage editorial :root on ethicalbranddirectory.com (20 Nov 2026),
# except tertiary / tertiary-light (see the table under this block).
primary: #c6a46b
primary-dark: #8d6a38
secondary: #111111
tertiary: #f598a4
tertiary-light: #e8c6c4
gray: #f6f3ec
light: #e8e0d4
line: #e8e0d4
line-strong: #8a857c
body: #111111
muted: #8a857c
on-dark: #fbfaf6
white: #fbfaf6
black: #080808

# Section spacing → --spacing-clamp-*
spacing-clamp-inline: 24px
spacing-clamp-block: 64px
spacing-clamp-block-xl: 104px

# Layout → --width-* / --radius-* / --padding-*
width-container: 1288px
width-content: 760px
radius-surface: 20px
padding-surface: 28px
padding-surface-lg: 40px
padding-btn-y: 13px
padding-btn-x: 26px
padding-btn-sm-y: 10px
padding-btn-sm-x: 18px

# Fixed type tokens → --font-size-* (for fluid headings / fluid body see § Type scale)
font-size-xs: 13px
font-size-sm: 15px
font-size-base: 16px
font-size-lead: 17px
font-size-btn: 16px
```

#### What changed and why (Ethical Brand Directory)

Hex only. Token **names** are unchanged, so this is not a palette-name sync. Spacing, widths, radius, type scale, and button recipes below are still the starter values — the live homepage was not used to invent new keys.

| Key | Value | Live source (ethicalbranddirectory.com, 20 Nov 2026) |
| --- | --- | --- |
| `primary` | `#c6a46b` | Homepage `--ebd-gold`. Rules, focus, `--ebd-link`. |
| `primary-dark` | `#8d6a38` | Homepage `--ebd-gold-deep`. Eyebrows on paper. |
| `secondary` | `#111111` | Homepage `--ebd-ink`. Body and headings. |
| `tertiary` | `#f598a4` | Astra customizer link colour (`a, .page-title`). The audit’s `#f55b84` does **not** occur in the live CSS. Not the homepage accent — that is gold. |
| `tertiary-light` | `#e8c6c4` | Elementor kit `--e-global-color-secondary` (dusty blush still served site-wide). |
| `gray` | `#f6f3ec` | Homepage `--ebd-paper`. Page background. |
| `light` | `#e8e0d4` | Homepage `--ebd-paper-shade`. |
| `line` | `#e8e0d4` | Same paper-shade. Homepage rules are mostly `rgba(8, 8, 8, 0.12)` or 1px gold; this token stays a solid hex. |
| `line-strong` | `#8a857c` | Homepage `--ebd-muted`. |
| `body` | `#111111` | Homepage `--ebd-ink`. |
| `muted` | `#8a857c` | Homepage `--ebd-muted`. |
| `on-dark` | `#fbfaf6` | Homepage `--ebd-white` (cover text). |
| `white` | `#fbfaf6` | Homepage `--ebd-white`. Warm paper white, not `#fff`. |
| `black` | `#080808` | Homepage `--ebd-black`. Cover and filled buttons on the live page. |

### Brand token → CSS variable

| Recipe key | Writes |
| --- | --- |
| `primary` … `black` (and any new colour name) | `--color-{name}` |
| `spacing-clamp-inline` / `block` / `block-xl` | `--spacing-clamp-*` |
| `width-container` / `width-content` | `--width-*` |
| `radius-surface` | `--radius-surface` |
| `padding-surface` / `padding-surface-lg` | `--padding-surface*` |
| `padding-btn-y` / `x` / `sm-y` / `sm-x` | `--padding-btn-*` |
| `font-size-xs` / `sm` / `base` / `lead` / `btn` | `--font-size-*` |

### What each token is for

| Token | Used for |
| --- | --- |
| `--color-*` | Editor palette + `text-*` / `bg-*` |
| `--spacing-clamp-*` | `px-clamp`, `py-clamp`, `py-clamp-xl`, … |
| `--width-container` | `.container` + editor mirrors |
| `--width-content` | `.mw-1000` |
| `--radius-surface` | Shared radius (`rounded-surface`) |
| `--padding-surface*` | Cards, FAQ, column cells, bleed |
| `--padding-btn-*` | `.btn` / `.btn-sm` |
| `--font-size-xs\|sm\|base\|lead` | `.fs-*` (+ body/`p` via base) |
| `--font-size-btn` | Button labels |

### Palette sync (add / rename / remove a colour)

When colour **names** change (not only hex):

1. Update Active brand tokens above
2. Agent writes `--color-{name}` in `variables.css`
3. `theme.css` — add/remove `text-{name}` and `bg-{name}` in `@source inline`
4. Update any button recipes that reference the old name
5. `npm run build`

Hex-only changes: step 1 → agent writes `variables.css` → build.

> **The starter added 7 colour names** (`primary-dark`, `tertiary-light`, `line`, `line-strong`, `body`, `muted`, `on-dark`). Those names are already in `theme.css` `@source inline`, including `border-line` and `border-line-strong`. The Ethical Brand Directory pass changed hex values only, so the name-sync steps were not run again.

---

## Type scale

Use for **headings** (usually fluid) and optional **fluid overrides** of body/fs/btn.  
Fixed body/fs/btn sizes normally live in § Active brand tokens; fill a key here only when you want `min / max` fluid type or to override a heading.

### Convention

```text
Minimum Viewport Width: {vmin}px
Maximum Viewport Width: {vmax}px
H1: {minFont}px / {maxFont}px
body: 17px
```

| Recipe value | Meaning | Agent output |
| --- | --- | --- |
| `16px` (no slash) | Fixed | Set target to `16px` — **no** `clamp()` |
| `16px / 18px` | Fluid | Calculate `clamp()` (formula below) |
| `--font-size-lead` | Alias | `font-size: var(--font-size-lead)` |
| `(pending)` / omitted | Skip | Do not change that target |

- Before `/` = size at `vmin`; after `/` = size at `vmax`.
- Root **16px**. Prefer `Maximum Viewport Width` = `width-container`.
- Viewport lines required only if any filled recipe uses `min / max`.
- Optional: `H1 line-height (lg+): 64px` → `typography.css` lg media query.

| Recipe key | Also accept | Writes to |
| --- | --- | --- |
| `H1` … `H6` | `h1` … `h6` | `typography.css` → `hN, .hN` |
| `body` | `p`, `base`, `fs-base` | `--font-size-base` (+ `body`/`p` use the token) |
| `fs-xs` / `fs-sm` / `fs-lead` | `fs-small`, `lead` | matching `--font-size-*` |
| `btn` | `button` | `--font-size-btn` |

### Clamp formula (`min / max` only)

```text
slope      = (maxPx - minPx) / (vmax - vmin)
intercept  = minPx - slope * vmin
preferred  = (intercept / root)rem + (slope * 100)vw
result     = clamp( (minPx/root)rem , preferred , (maxPx/root)rem )
```

Round rem/vw to **4 decimal places**. Do not hand-tune the middle term.

Example: `vmin=767`, `vmax=1330`, `H1: 50px / 75px` →  
`clamp(3.125rem, 0.9963rem + 4.4405vw, 4.6875rem)`.

### Active recipes

```text
Minimum Viewport Width: 768px
Maximum Viewport Width: 1288px
H1: 36px / 58px
H2: 30px / 44px
H3: 20px / 22px
H4: 18px
H5: (pending)
H6: (pending)
body: 16px
fs-xs: 13px
fs-sm: 15px
fs-lead: 17px / 18px
btn: 16px
H1 line-height (lg+): 63px
```

#### Notes on the type scale (Ethical Brand Directory)

- **Fonts:** the live homepage sets `--ebd-serif: 'Cormorant Garamond'` and `--ebd-sans: 'Raleway'`, and also requests those families from Google Fonts. This theme self-hosts them (no Google Fonts requests). `--font-heading` is Cormorant Garamond; `--font-sans` is Raleway (already in `resources/fonts/`). The previous heading file, Lora, stays on disk and is no longer referenced. The Active clamp recipes below were **not** rewritten from the live `clamp()` middle terms.
- **Weights / tracking / leading** (set in `typography.css` alongside sizes):
  - H1: 800, letter-spacing −0.025em, line-height 1.08
  - H2: 700, −0.02em, 1.15
  - H3: 700, normal, 1.3
  - H4: 600–700, normal, 1.4
  - Body line-height: 1.6
- **Stat numbers** on the starter landing page (still in `resources/views/sections/home/`) are a one-off display size. Do not add a token for them. They are not part of the magazine.
- **H5 / H6** aren't used on this page; left `(pending)`.
- **Expected agent output** with vmin 768 / vmax 1288, as a cross-check:
  - H1 → `clamp(2.25rem, 0.2192rem + 4.2308vw, 3.625rem)`
  - H2 → `clamp(1.875rem, 0.5827rem + 2.6923vw, 2.75rem)`
  - H3 → `clamp(1.25rem, 1.0654rem + 0.3846vw, 1.375rem)`
  - fs-lead → `clamp(1.0625rem, 0.9702rem + 0.1923vw, 1.125rem)`

### Type sync (filled keys only)

1. This file — Active recipes
2. Headings → `typography.css`
3. body/fs/btn → `variables.css` (overrides brand-token values for those keys)
4. `npm run build`

---

## Button recipes

Colour states only. Padding / radius / label size come from brand tokens.

### Convention

```text
{class}: {default utilities} / {hover utilities}
```

- Before `/` = default; after `/` = hover.
- Utilities: `bg-{token}`, `text-{token}`, optional `border-{token}`, `bg-transparent`, `gradient({from}→{to})`.
- Default border matches `bg-*` unless `border-*` is set.

Example: `btn-primary: bg-primary text-white / bg-secondary text-white`

### Active recipes

```text
btn-primary: bg-primary text-white / bg-primary-dark text-white
btn-secondary: bg-secondary text-white / bg-primary text-white
btn-outline: bg-white text-secondary border-line-strong / bg-white text-secondary border-primary
btn-white: bg-white text-secondary / bg-light text-secondary
```

Legacy aliases: `btn-primary-alt` → `btn-primary`; `btn-outline-primary` → `btn-outline`.

#### Button changes (Ethical Brand Directory)

Recipes are unchanged. They pick up the hexes above (`btn-primary` is gold on warm white, hover deep gold). The live homepage buttons are square, `#080808` fill, `#fbfaf6` label. That would be a recipe change (`bg-black text-white`); it was not applied, because this pass only replaces colour values.

#### Button changes (starter, still the Active recipes)

| Variant | Status | Used for |
| --- | --- | --- |
| `btn-primary` | Hover changed to `primary-dark` | All main CTAs ("Закажете консултација", "Побарајте понуда", form submit) |
| `btn-secondary` | Kept (ink) | Not on the landing page; kept as a dark option for light sections |
| `btn-outline` | **New** | Secondary actions: "Нашите услуги", stage-card buttons 01/03, "Поставете прашање" |
| `btn-white` | Hover changed (no longer goes transparent) | On dark/blue backgrounds: CTA band, inverted stage card 02 |
| `btn-tertiary` | **Removed** | No violet buttons in the design |
| `btn-gradient` | **Removed** | The design uses no gradients |

Adding `btn-outline` and removing `btn-tertiary` / `btn-gradient` means **all 6 steps of the button sync** below must run. The `btn-outline-primary` legacy alias now points to `btn-outline` instead of `btn-white`.

### Button sync (when Active recipes change)

| # | File | What |
| --- | --- | --- |
| 1 | `resources/css/theme/buttons.css` | `.btn-{name}` default + hover |
| 2 | `resources/css/editor.css` | Editor `.wp-block-button.btn-{name}` mirrors |
| 3 | `app/blocks/extensions/button.json` | `button_type` options |
| 4 | `app/Traits/blocks/trait-blocks.php` | `populateButtonTypes()` + type allow-list in `moveCoreButtonClassesToLink()` |
| 5 | `app/Traits/filters/trait-navs.php` | Optional `menu-btn-{name}` map |
| 6 | This file | Keep Active recipes in sync |

**Required for custom blocks:** step 4. Default type remains `btn-primary`.

Modifiers (not colour recipes): `btn-sm`, `btn-full`, `btn-has-icon`.

---

## Apply order (agent)

1. Write filled § Active brand tokens → `variables.css`
2. Palette name changes → `theme.css` `@source inline`
3. Filled § Type scale → `typography.css` / type tokens
4. § Button recipes → button CSS + PHP/JSON sync
5. `npm run build` from theme directory

```bash
cd app/public/wp-content/themes/ebd
npm run build
```

Spot-check: colours in editor palette, `.container` width, buttons (FE + editor + custom block select), type at fixed sizes and at vmin/vmax if fluid recipes were applied.

---

## Project notes — values outside this token set (Ethical Brand Directory)

These were read off the live site and have **no separate key**, or they disagree with an Active value. The agent does not invent keys for them.

| Value | Where on the live site | What this theme did |
| --- | --- | --- |
| Homepage `--ebd-gold-soft: rgba(198, 164, 107, 0.28)` and `--ebd-line: rgba(8, 8, 8, 0.12)` | Editorial `:root` | Left as notes. Active `line` is the solid paper-shade `#e8e0d4`. |
| Astra `a { color: #f598a4 }` / hover `#ed1566` | `astra-theme-css-inline-css` | `#f598a4` is `tertiary`. `#ed1566` has no key. Audit blush `#f55b84` is **absent** from the CSS fetched on 20 Nov 2026. |
| Elementor kit `--e-global-color-primary: #CABB86`, accent `#C9A6A6`, link `#ED2F74` | `post-22092.css` | Older kit, still enqueued. Not copied over the homepage `:root`, except `#e8c6c4` → `tertiary-light`. |
| Live buttons: radius `0`, fill `#080808`, label `#fbfaf6`, Raleway, uppercase, tracking | Homepage + popup `post-25988.css` | Not a recipe change. `btn-primary` stays `bg-primary`. `radius-surface` stays `20px`. |
| Live type: Cormorant display, Raleway 300 body, fluid sizes in `--ebd-h1`…`--ebd-h4` | Homepage `:root` | Families swapped in `fonts.css`. Active type recipes were not recalculated. |
| Google Fonts stylesheet + `fonts.googleapis.com` preconnect | Homepage `<head>` | Not used. Fonts are files under `resources/fonts/`. |
| `.mw-1000` utility name | Theme `sections.css` | `width-content` is 760px. Class name kept; renaming is out of scope. |
| Theme path | This file’s path lines | `ebd` (the folder that is actually in the repo). The pushed identity said `elita-konsalting`; that slug is not the theme directory. |
