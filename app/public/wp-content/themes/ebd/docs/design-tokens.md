# Design tokens — rebrand playbook

> **Project:** Elita Konsalting — landing page (Version 2)
> **Populated:** 26 Oct 2026 from the approved design (`reference.html` in the handoff package).
> All values below are measured from the design, not estimated. See **§ Project notes** at the end for values that don't fit this token set.

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

Paths below are theme-relative (`app/public/wp-content/themes/cpj/…`).

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
primary: #3D55D6
primary-dark: #2A3FB0
secondary: #13183A
tertiary: #7A3EC8
tertiary-light: #B79CF0
gray: #F5F6FB
light: #EEF1FE
line: #E3E6F0
line-strong: #C5CCE8
body: #3A4058
muted: #5B627A
on-dark: #C9D0F2
white: #fff
black: #000

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

#### What changed and why (Elita)

| Key | Value | Where it's used in the design |
| --- | --- | --- |
| `primary` | `#3D55D6` | Brand blue: buttons, links, icons, CTA band, step borders |
| `primary-dark` | `#2A3FB0` | **New.** Primary button / link hover |
| `secondary` | `#13183A` | Ink navy: headings, utility bar, "Финансии и технологија" section, contact box, inverted stage card |
| `tertiary` | `#7A3EC8` | Brand violet: eyebrow labels, bullet markers |
| `tertiary-light` | `#B79CF0` | **New.** Eyebrows and ticks on dark (secondary) backgrounds |
| `gray` | `#F5F6FB` | Alternating light section background, quote box, "Не сте сигурни" strip |
| `light` | `#EEF1FE` | Icon tiles, avatar circles, booking box |
| `line` | `#E3E6F0` | **New.** Card borders, dividers, header/footer rules |
| `line-strong` | `#C5CCE8` | **New.** Input borders, outline-button border |
| `body` | `#3A4058` | **New.** Default paragraph text |
| `muted` | `#5B627A` | **New.** Captions, card descriptions, small labels |
| `on-dark` | `#C9D0F2` | **New.** Body text on `secondary` backgrounds |
| `spacing-clamp-block-xl` | `104px` | All main content sections (top + bottom) |
| `spacing-clamp-block` | `64px` | CTA band. (Stats strip uses 48px — see notes) |
| `width-container` | `1288px` | 1240px content + 24px inline padding each side (border-box) |
| `width-content` | `760px` | Max width of section intro blocks (eyebrow + H2 + paragraph) |
| `radius-surface` | `20px` | Cards, form card, testimonial cards, image corners |
| `padding-surface` / `-lg` | `28px` / `40px` | Service cards / form card and panels |
| `padding-btn-*` | `13/26`, `10/18` | Main buttons are 52px tall; header button (`btn-sm`) is 44px tall |

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

> **This project adds 7 colour names** (`primary-dark`, `tertiary-light`, `line`, `line-strong`, `body`, `muted`, `on-dark`), so the full palette sync is required (step 3 included). `line` and `line-strong` are also used as `border-*` utilities, so add `border-line` and `border-line-strong` to `@source inline` as well.

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

#### Notes on the type scale (Elita)

- **Fonts:** headings (H1–H4, stat numbers, button-like labels in cards) use **Montserrat** 600/700/800; body uses **Inter** 400/500/600. Both **must include the Cyrillic subset**; the site is in Macedonian. Set them in `fonts.css` and self-host (no Google Fonts requests, for GDPR).
- **Weights / tracking / leading** (set in `typography.css` alongside sizes):
  - H1: 800, letter-spacing −0.025em, line-height 1.08
  - H2: 700, −0.02em, 1.15
  - H3: 700, normal, 1.3
  - H4: 600–700, normal, 1.4
  - Body line-height: 1.6
- **Stat numbers** (20+, 7+, МК · ЕУ) are 40px Montserrat 800, a one-off display size; style them as `.h1`-weight with a fixed 40px rather than adding a token.
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

#### Button changes (Elita)

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
cd app/public/wp-content/themes/cpj
npm run build
```

Spot-check: colours in editor palette, `.container` width, buttons (FE + editor + custom block select), type at fixed sizes and at vmin/vmax if fluid recipes were applied.

---

## Project notes — values outside this token set (Elita)

These are used in the design but have **no key in this playbook**, so the agent will not apply them from the Active blocks. Decide per item: add a token to the playbook (then update the mapping tables), or keep it as a documented component-level value.

| Value | Where | Suggestion |
| --- | --- | --- |
| **Button radius `12px`** | All rectangular buttons | ⚠️ The playbook says button radius "comes from brand tokens", but the only radius token is `radius-surface` (20px). Applying it as-is would give 20px buttons. Add `radius-btn: 12px`, or accept 20px. |
| Pill radius `9999px` | CTA-band button, chips, avatar circles, social icons | Use Tailwind `rounded-full`; no token needed |
| Input radius `10px` | Form fields | Add `radius-input`, or reuse 12px |
| Large radii `24px` / `28px` | About portrait panel / contact box | Component-level; or round both to `radius-surface` |
| Small radius `14px` | Icon tiles (48px) | Component-level |
| Section spacing `48px` | Stats strip under hero | One-off; could use `spacing-clamp-block` (64px) if you're happy with a slightly taller strip |
| Secondary grey text `#4A5170` | Section intro paragraphs | Very close to `muted`; recommend merging into `muted` (`#5B627A`) or `body` |
| On-dark muted `#8F98C7` | Utility bar city label, separators | Could be added as `on-dark-muted` |
| Card shadow `0 12px 32px rgb(19 24 58 / .08)` | Floating elements only | Add a shadow token if the theme supports one |
| Focus ring `2px solid primary`, offset `2px` | All interactive elements | Global `:focus-visible` style, not a token |
| `.mw-1000` utility name | `width-content` is now 760px | The class name no longer matches its value; consider renaming to `.mw-content` |
| Theme path `themes/cpj` | Apply-order and paths sections | Retarget to this project's theme slug via `docs/agent-context.md` |
