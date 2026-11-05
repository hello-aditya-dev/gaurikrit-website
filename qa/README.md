# QA Evidence Pack — V26 Final Acceptance

This directory holds the visual evidence for the V26 polish pass. It is **not deployed**
(GitHub Pages serves `docs/` only).

## before-client-screenshots/

The eight full-page screenshots supplied by the client on 5 November 2026
(GoFullPage captures of the live V23 site at 1366px, plus one pasted brand-reference
image). These are the "before" state and the acceptance references:

| File | Route |
|---|---|
| `gofullpage-...-website-2026-11-05-07_55_03.png` | `/` (Home) |
| `gofullpage-...-about-07_55_20.png` | `/about/` |
| `gofullpage-...-products-07_55_37.png` | `/products/` |
| `gofullpage-...-sustainability-07_56_00.png` | `/sustainability/` |
| `gofullpage-...-innovation-07_56_17.png` | `/innovation/` |
| `gofullpage-...-for-business-07_56_29.png` | `/for-business/` |
| `gofullpage-...-contact-07_56_41.png` | `/contact/` |
| `pasted_image_1793851461148.png` | Brand/logo reference tableau |

## after-v26/

The final V26 state of **all 14 routes**, captured locally from the regenerated
`docs/` build (file:// rendering, scroll-through so every lazy image and reveal
is visible), at three viewports each:

- `<page>-1440.jpg` — desktop 1440×900, full page
- `<page>-768.jpg` — tablet 768×1024, full page
- `<page>-390.jpg` — mobile 390×844, full page

Pages: home, about, products, distemper, emulsion, why-prakritik, colours,
sustainability, innovation, for-business, paint-calculator, downloads, contact, 404.

## What changed between before and after (summary)

1. **Logo plates removed** — the paper/cream tile behind the gold emblem in the
   footer (and 404 seal) is gone; the mark renders directly on its surface,
   honouring the client's "logo without background" instruction. Alpha
   transparency of the official files verified (29.8–41.3% fully transparent pixels).
2. **Public caption language rewritten** — "Client-supplied …" / "CLIENT
   ECOSYSTEM BANNER" / "supplied shade references" agency language replaced
   with natural figure captions; factual qualifiers (Futureline status,
   illustrative-concept notes) preserved exactly once per section.
3. **AA contrast fixes** — leaf-hue small-text labels darkened via the new
   `--leaf-deep` token (6 failing elements → 0; mechanical audit of all 14 routes).
4. **Footer rebalanced** — 5/6/4/3 column rhythm (Colours moved to Company),
   location line replaces the duplicated legal name, copyright bar balanced
   with the Hindi tagline, back-to-top button now forest green.
5. **Contact page de-duplicated** — the lower table shows registered-company
   facts only (matching the PHP template); differentiated "Phone (alternate)" labels.
6. **Carousel controls realigned** — dots optically centred under the frame
   (verified 0px offset), dot animation now transform-based with a larger touch target.
7. **Hallmark floor fixes** — `overflow-x: clip` (was `hidden`), `92dvh` after
   `92vh` (was a dead `svh`-then-`vh` override), `minmax(0, Nfr)` on all
   image-bearing grid tracks, outline-CTA affordance strengthened, eyebrow
   tracking relaxed 0.22em → 0.15em, heading rhythm fix on Why-Prakritik.
8. **Distemper/Emulsion copy differentiated** using documented facts (format,
   pack sizes, coverage).

Full details: see the V26 report in the repository documentation.
