# Gaurikrit Design System — design.md

**Version:** V26 (polish pass — locked system, verified against client screenshots + Hallmark audit)
**Scope:** All 14 routes. This file is the locked system of record for the Gaurikrit website.
**Authority:** The established Gaurikrit brand (forest green + haldi gold + warm paper) overrides any
generic design framework defaults. Hallmark v2.0.0 was used at **polish depth** ("keep our look"):
the system and layout stay; only verified defects were fixed.

---

## 1. Colour tokens (locked hex, no dark mode)

Declared once at `:root` in `assets/css/app.css`:

| Token | Value | Role |
|---|---|---|
| `--forest` | `#173F2B` | Primary brand green (headings, buttons, forest bands, footer) |
| `--forest-deep` | `#102F20` | Deeper forest (gradients on forest bands) |
| `--haldi` | `#E3A51A` | Turmeric gold accent (rules, active states, footer headings) |
| `--haldi-soft` | `#F2D783` | Soft gold (hover fills, highlights) |
| `--haldi-deep` | color-mix haldi 72% / charcoal 28% | Gold for small text/numerals on light bg |
| `--limewash` | `#F4EFE2` | Default page background (warm cream) |
| `--paper` | `#FAF8F1` | Section background (lighter warm paper) |
| `--kraft` | `#C9A77C` | Kraft paper tan (borders, neutral accents) |
| `--mitti` | `#A86E4B` | Earth/clay brown |
| `--geru` | `#B65432` | Geru red-orange (rare accent, also `--danger`) |
| `--leaf` | `#748468` | Leaf green — **decorative only** |
| `--leaf-deep` | `#5D6B54` | Leaf hue darkened for small-text labels (AA: 4.95–5.68:1) |
| `--indigo` | `#365B67` | Cool slate (Distemper accent) |
| `--charcoal` | `#201E19` | Ink (`--fg`) |
| `--soft-ink` | `#4D4A42` | Muted body text (`--fg-muted`) |
| `--hairline` | `rgba(32,30,25,0.14)` | Hairline borders |

**Section background families (five only):** limewash cream, paper, soft warm washes
(`--paper-warm`, `--paper-cool`, `--paper-leaf`), format washes (distemper cool / emulsion warm), forest.
Per-section colour inventions are not allowed.

**Rules:**
- On forest backgrounds, text uses `color-mix(in srgb, var(--paper) N%, transparent)` (60–90%) — never raw literals.
- Gold (`--haldi`) is never used for small text on light backgrounds; use `--haldi-deep` instead.
- `--leaf` is decorative only; small text in the leaf hue uses `--leaf-deep`.
- Buttons on gold fills always use charcoal text (`--accent-fg`), never white (contrast 7.7:1).
- `@media print` intentionally uses pure white ground + dark ink (print context exception).

## 2. Typography

| Role | Face | Notes |
|---|---|---|
| Display / headlines | **Newsreader** (serif), 600–700 | `clamp()` scales; `letter-spacing: -0.015em` on large heads |
| Body / UI | **Manrope** (sans) | 16px base, `line-height: 1.6` |
| Devanagari | **Noto Serif Devanagari** | गौरीकृत brand lockups; ~110% optical size vs Latin |

- Eyebrow labels: 0.75rem, 700, uppercase, `letter-spacing: 0.15em` (reduced from 0.22em in V26 for legibility), forest (light bg) or haldi (forest bg). This tracked-caps eyebrow is the locked Gaurikrit editorial device (documented Hallmark waiver).
- Body measure: `max-width: 65ch`; section descriptions capped ~48rem.
- `text-wrap: balance` on message-style headings.

## 3. Layout & spacing

- Container: `--max-w: 80rem` (1280px), centred, gutters grow beyond.
- 12-column editorial grid (`.grid-12`): desktop ≥1200px 12 col, tablet 768–1199 recomposes to 8, mobile ≤767 stacks to 4. **Image-bearing tracks use `minmax(0, 1fr)`.**
- Section rhythm: normal `clamp(4rem, 6vw, 7rem)`, large `clamp(7.5rem, 12vw, 10rem)`.
- Header height: 76px desktop (`--header-h: 4.75rem`), 80px ≥1024px.

## 4. Radii, borders, shadows

- Buttons/inputs: 6–8px. Material panels: 0–8px. No universal large rounding, no glowing shadows.
- One radius per nesting level; `--r-pill` only for genuine dots/swatches.
- Shadows: rare, soft, wide, low-opacity (`--shadow-soft`).
- Hairlines: `--hairline` / `--border-strong` on light; `color-mix(paper 12–35%)` on forest.

## 5. Buttons

- **Primary:** forest fill, paper text. **Secondary:** haldi-soft fill, charcoal. **Haldi:** gold fill, charcoal text (AA 7.7:1). **Outline:** transparent, forest text, `color-mix(primary 62%)` border (strengthened V26 — must never read as disabled), 6% forest fill on hover.
- One primary button style per screen; CTA vocabulary: "Talk to Us" (header), "Enquire / Discuss a Project" (page bodies).
- Every interactive element has `:focus-visible` (haldi outline, instant).

## 6. Navigation

- Desktop: logo left, centre nav (Home, Our Story, Products ▾, Sustainability, Innovation, Partners, Contact), "Talk to Us" pill right. Transparent at scroll-top; 92% paper + blur when scrolled.
- Mobile: slide-in panel from right, forest overlay, products sub-group, utilities at bottom.
- Active link: forest colour + 2px underline scale-in.

## 7. Logo usage

- The official gold cow-emblem seal carries **genuine alpha transparency** (verified: 512×512, 29.8% fully-transparent pixels). Client instruction: **no background plate anywhere** — header, footer and 404 render the mark directly on the surface (V26 removed the paper tiles).
- Header: mark 2.5rem + "Gaurikrit" wordmark + "BIO PRODUCTS" sub-line.
- Footer: mark on forest (fallback SVG re-points `--forest` → `--paper` in footer scope), wordmark in paper.
- Clear space ≥ the seal's inner-ring margin; never regenerate or recolour the mark.

## 8. Imagery treatment

- **Client originals are immutable.** Never crop labels/text out of official artwork; frame with `object-fit: contain` where edge content must survive.
- Real photography (cow-dung piles, paint packs) leads editorial sections; official posters/infographics render large with honest captions.
- Framed-figure treatment for pack shots; consistent crop ratios across sibling modules.
- Conceptual artwork always carries its factual qualifier (e.g. "Illustrative processing concept — not a photograph of Gaurikrit's facility."). Public captions never use agency language ("client-supplied") — they read as natural figure captions.
- Futureline status ("not yet in production") appears once per product section (badge or caption), never repeated in every paragraph.

## 9. Motion

- `--ease: cubic-bezier(0.22, 1, 0.36, 1)`, `--dur: 0.3s`.
- `transform` and `opacity` only — never animate `width/height/top/left`.
- Every animation has a `prefers-reduced-motion: reduce` fallback; carousel autoplay disables under reduced motion.
- Reveal-on-scroll is subtle (opacity/translate); content visible with scripting off.

## 10. Responsive breakpoints

- Grid: ≤767 / 768–1199 / ≥1200. Nav: <1024 mobile menu. Carousel controls stack <561px.
- No horizontal overflow: `overflow-x: clip` on html and body (never `hidden` — sticky-safe).
- Viewport-height sections use `vh` fallback + `dvh` (dynamic viewport) second.

## 11. Accessibility requirements

- WCAG AA text contrast (mechanically audited all 14 routes; leaf-label failures fixed in V26 via `--leaf-deep`).
- Keyboard: full nav, carousel (arrows/pause), calculator, forms; visible focus at all times.
- Labels/ARIA on every control; `alt` text describes the actual artwork honestly.
- Touch targets ≥ 2.25rem (carousel dots are 1.5rem-wide pills).

## 12. Component conventions

- Definition tables: label column caps + value column, hairline row rules, one baseline grid.
- Phone numbers: first "Phone", second "Phone (alternate)" — never two identical labels.
- Forms: custom inputs + styled selects, one required-marker convention (`Label *`), real validation feedback, honest static-hosting behaviour (mailto draft, labelled as such).
- Footer: brand block (mark, tagline, location) + 5/6/4/3 column balance; copyright bar carries legal name + GSTIN.
- Status pills: Futureline gold-trim pill, readable at 100% zoom.
