# Selph Theme — Tailwind CSS setup

WordPress block theme skeleton with Tailwind CSS v4 build tooling.

## Rules

1. `style.css` contains ONLY the theme header comment. Never add CSS rules
   to it — WordPress requires the file for theme recognition, that is its
   only job.
2. All CSS is authored in `src/css/` and compiled to `assets/css/`.
3. One global entry (`globals.css`: Tailwind preflight, design tokens,
   shared components) plus one entry per template context
   (`home`, `page`, `single`, `archive`).
4. Page-specific files import `tokens.css` + utilities WITHOUT preflight,
   so base styles are never shipped twice.

## Install

    npm install

## Build (production)

    npm run build

## Watch (development — recompiles on change)

    npm run watch

## Add a new page-specific CSS file

1. `src/css/your-page.css` — start it with:

       @import "./tokens.css";
       @import "tailwindcss/utilities.css" layer(utilities);

   (NOT preflight — that lives only in globals.css)

2. Register the entry in `build.mjs` (ENTRIES array).
3. Register the enqueue condition in `functions.php` ($page_styles array).

## Where utilities come from

Tailwind scans theme PHP files automatically. Templates, patterns, and
`inc/` PHP files are all picked up — write `class="btn-primary"` anywhere
and the utility is generated into the right entry file.

## Selph brand palette (defined in src/css/tokens.css)

- Deep Blue #0E7EA6 — headings
- Blue #27C2F8 — buttons and links
- Teal #8BDCE0 / Mint #A1E4DB — section backgrounds
- Lime #E9F8CD — callouts

The palette can be adjusted under **Appearance → Customize → Global Colors**.
Changes apply to theme-wide color tokens, including buttons, links, surfaces,
and text.
