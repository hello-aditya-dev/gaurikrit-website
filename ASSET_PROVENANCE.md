# Asset Provenance — Gaurikrit Website

Maps each client original to its public derivatives. Client originals in
`source-assets/client-originals/` are immutable — never modify them.

Last verified: V10 pass — zebu-study retired from all pages; five new
surface-study editorial derivatives added (raw-material / finished-surface /
interior-finish / exterior-finish / colour-wall). Commit of record for the
originals: `215f5df47d41fc18c332ff3505a5ab0e16126741`.

## 10 Client Originals — inspected & classified

| # | File | Dimensions | Classification (V7 inspection) | Public use? |
|---|------|------------|----------------|-------------|
| 1 | `Broucher-paint(2).pdf` | 4 pages, A4 portrait | Official product brochure: cover (Gaurikrit logo + "Prakritik Paint" + "Colours of INDIA"), product details (both formats + specs + BIS note + coverage disclaimer), about paint (Ashta Laabh 8-benefit infographic + cows), back cover (12 Aug 2023 launch, BIS 15489:2013 / 428:2013 mention, contact details). No prices. | Yes — brochure PDF + cover |
| 2 | `Company Board3(2).pdf` | 1 page, A4 | Company signboard: legal name, गौरीकृत, address, GSTIN, email, phones. Highest-quality source of the legal/contact data. | No — internal reference (data only) |
| 3 | `Gaurikrit_Black & White(2).pdf` | 1 page, A4 landscape | Official logo, B&W vector variant (scalloped badge + cow head + laurel + "Gaurikrit" serif wordmark). | No — internal reference |
| 4 | `Gaurikrit_Haldi & Black(2).pdf` | 1 page, A4 landscape | Official logo, haldi+black vector variant. Best-quality logo source (vector). | Yes — logo extracted |
| 5 | `WhatsApp …10.11.56 PM(2).jpeg` | 853×1280 | Official Gaurikrit logo raster (badge + wordmark, portrait) on transparent-style background. | Yes — logo reference |
| 6 | `WhatsApp …10.14.15 PM(2).jpeg` | 853×1280 | Single Prakritik paint can (Khadi India branding, red cow icon, "ECO-FRIENDLY COW DUNG PAINT"), transparent-style background. | Yes — product photo (single-can reference) |
| 7 | `WhatsApp …10.15.03 PM(2).jpeg` | 1280×1024 | Gaurikrit kraft-box packaging shot with official logo ("NATURAL • PURE • SUSTAINABLE", www.gaurikrit.com) on blurred plant background. | No — packaging reference only |
| 8 | `WhatsApp …10.20.10 PM(2).jpeg` | 1024×1024 | **Collage with UNSUPPORTED future products** (cow dung logs, bio-fertilizer mix, "Future Line" utility products: diyas, cups, mosquito coils). | **NO — contains unconfirmed products; never publish** |
| 9 | `WhatsApp …10.21.44 PM(2).jpeg` | 800×400 | Two-bucket comparison graphic ("INDIA'S FIRST KHADI PRAKRITIK PAINT", Distemper left + Emulsion right) on light pink ground. | Yes — **V11 canonical pair source**: products-page hero pair, Distemper single, Emulsion single |
| 10 | `WhatsApp …10.22.06 PM(2).jpeg` | 1280×621 | **Three-bucket group photo** (2 Emulsion + 1 Distemper centre) on wooden surface, white ground. Highest-quality current hero product image. | Yes — hero product image |

## Derivative mapping

| Public file | Source original | Notes |
|-------------|-----------------|-------|
| `assets/brand/gaurikrit-logo-full.png` | #4 Gaurikrit_Haldi & Black.pdf | Extracted via pdftoppm + alpha |
| `assets/brand/gaurikrit-logo-mark.png` | #4 Gaurikrit_Haldi & Black.pdf | Cropped from full logo |
| `assets/products/prakritik-group.jpg` | #10 WhatsApp 10.22.06 | Full 3-bucket group photo (1280×621) |
| `assets/products/prakritik-distemper.jpg` | #10 WhatsApp 10.22.06 | **V8 complete-bucket crop** (395,0,885,621) = 490×621 — full photo height kept; centre Distemper bucket complete (lid, handle, base, sides); narrow neighbour slivers at both edges are part of the original shelf photo (never slice the main bucket to remove them) |
| `assets/products/prakritik-emulsion.jpg` | #10 WhatsApp 10.22.06 | **V8 complete-bucket crop** (830,0,1280,621) = 450×621 — right Emulsion bucket complete to the photo's natural right edge (wood); centre-bucket sliver at left is occlusion present in the original photo |
| `assets/products/prakritik-pair.webp` / `.jpg` | #9 WhatsApp 10.21.44 | **V11 canonical pair crop** (46,48,756,357) = 710×309 → 2× Lanczos = 1420×618 — both buckets complete + natural cast shadows on the client's pink ground; red headline (y 12–40) and bottom name bars (y 358+) cropped away. Products-page hero ("Two formats"). Script: `scripts/derive_pair_assets.py` |
| `assets/products/prakritik-distemper-from-pair.webp` / `.png` | #9 WhatsApp 10.21.44 | **V11 clean single cutout** — LEFT bucket crop (37,45,383,356) = 346×311 → 2× Lanczos → transparent matte: border flood-fill pink key (incl. pink cast shadows + enclosed handle pockets), 4px alpha ramp + pink unmix defringe. Trimmed to matte + 14px. **Replaces `prakritik-distemper.jpg` as `officialImage` everywhere.** |
| `assets/products/prakritik-emulsion-from-pair.webp` / `.png` | #9 WhatsApp 10.21.44 | **V11 clean single cutout** — RIGHT bucket crop (429,45,765,356), same pipeline. **Replaces `prakritik-emulsion.jpg` as `officialImage` everywhere.** |
| `assets/social/og-distemper.jpg` | #9 via cutout | V11 regeneration of the distemper share card with the new clean single (same card template as `scripts/prepare_assets.py`) |
| `assets/social/og-emulsion.jpg` | #9 via cutout | V11 regeneration of the emulsion share card with the new clean single |
| `assets/documents/prakritik-paint-brochure.pdf` | #1 Broucher-paint.pdf | Direct copy |
| `assets/documents/prakritik-paint-brochure-cover.jpg` | #1 Broucher-paint.pdf | Rendered page 1 at 120 DPI |
| `assets/editorial/zebu-study.webp` | `source-assets/zebu-study.png` (1536×1024) | Generated editorial artwork — **RETIRED from all pages in V10** (decorative cow illustration removed; files kept on disk for history) |
| `assets/editorial/raw-material-study.webp` | `source-assets/editorial/raw-material-study.png` (1344×768) | V10 generated editorial artwork — raw lime-plaster wall surface (home material statement, material step 01, why-prakritik 01, about direction) |
| `assets/editorial/finished-surface-study.webp` | `source-assets/editorial/finished-surface-study.png` (1344×768) | V10 generated editorial artwork — finished matte wall surface (material step 03, why-prakritik 03) |
| `assets/editorial/interior-finish-study.webp` | `source-assets/editorial/interior-finish-study.png` (1344×768) | V10 generated editorial artwork — interior wall-finish strip (Distemper chapter/detail plates) |
| `assets/editorial/exterior-finish-study.webp` | `source-assets/editorial/exterior-finish-study.png` (1344×768) | V10 generated editorial artwork — exterior wall-finish strip (Emulsion chapter/detail plates) |
| `assets/editorial/colour-wall-study.webp` | `source-assets/editorial/colour-wall-study.png` (1344×768) | V10 generated editorial artwork — purpose-built wall elevation for the Colours of India SVG paint mask (wall-plane geometry CV-verified: wall y 104–724, door x 80–304 y 370–768, window x 894–1180 y 346–654) |
| `assets/editorial/courtyard-study.webp` | `source-assets/courtyard-study.png` (1942×809) | Generated editorial artwork |
| `assets/editorial/interior-wall-study.webp` | `source-assets/editorial/interior-wall-study.png` | Generated editorial artwork |
| `assets/editorial/exterior-wall-study-v2.webp` | `source-assets/editorial/exterior-wall-study-v2.png` | Generated editorial artwork |
| `assets/editorial/finished-wall-study.webp` | `source-assets/editorial/finished-wall-study.png` | Generated editorial artwork |
| `assets/editorial/business-context-study.webp` | `source-assets/editorial/business-context-study.png` | Generated editorial artwork |
| `assets/editorial/rural-landscape.webp` | `source-assets/editorial/rural-landscape.png` | Generated editorial artwork |

## V7 usage rules (enforced by this pass)

1. **Real product photography is used for products only** (hero, product
   chapters, detail pages, about hero, formats sections). Never replaced
   with generated art.
2. **Natural-history cow art** (zebu-study) is RETIRED (V10): the home
   material statement, why-prakritik hero + chapter 01, and the about
   material-direction section now use grounded surface studies instead.
   The only remaining bovine imagery is the official brand logo (header/
   footer cow-head mark, a branding element, not decoration).
3. **Architectural art** (business-context / architectural studies) appears
   only as editorial context on For-Business; the Why-Prakritik context
   chapter now uses the neutral rural engraving at 0.08 opacity instead of
   a building that could imply a facility.
4. **The official logo** is used only for branding (header, footer, direct
   contact plate, product plate heads, 404 seal) — never as substitute
   imagery for a section.
5. File #8 (future-products collage) is excluded from all public outputs.

## V11 usage rules (product visuals)

1. **The 10.21.44 pair image (#9) is the canonical two-product visual**: the
   products-page hero carries `prakritik-pair` (the official
   Distemper-vs-Emulsion comparison, headline and name bars cropped away).
2. **Single-product visuals come from the pair-derived cutouts**
   (`prakritik-distemper-from-pair` / `prakritik-emulsion-from-pair`):
   complete buckets, no neighbour slivers, no occlusion — used as
   `officialImage` for product chapters, material steps, format cards,
   about product cards and both detail-page heroes (WebP source + PNG
   fallback inside `<picture>`; `picture{display:contents}` keeps the
   layout identical).
3. **The 10.22.06 three-bucket photo (#10) stays on the home + about
   heroes** (`prakritik-group.jpg`, 1280×621) where the render size wants
   its higher resolution; its V8 single-bucket crops remain on disk as
   higher-resolution fallbacks but are no longer referenced by templates.
4. Derivatives are deterministic: crops + 2× Lanczos resampling + colour-math
   keying only (`scripts/derive_pair_assets.py`). No AI reconstruction, no
   label retouching, no saturation tricks.

## Priority rule

For product/brand imagery:
1. client-originals (highest priority)
2. other high-quality source-assets
3. prepared production derivatives
4. generated editorial art (only when needed)

Never re-compress an already-compressed derivative to make another file.

## V12 finishing pass (visual system)

1. **Illustration partials retired + deleted** (files removed from the repo,
   not just unreferenced): `ashta-laabh-seal` (radial cow seal),
   `calculator-wall-scene` (dormant wall SVG), `indian-cow`, `gaushala-scene`,
   `material-to-wall`, `indian-courtyard`, `paint-brush-stroke`,
   `rural-landscape` (SVG), `prakritik-distemper-bucket`,
   `prakritik-emulsion-bucket`, `architectural-elevation`. Only
   `gaurikrit-cow-mark` (official logo fallback) and `field-botanicals`
   (404 decorative accent) remain. `assets/js/ashta-laabh.js` deleted too.
2. **Ashta Laabh is now the shared typographic `.benefits-grid`** (app.css
   §18) on Home, Products, Why-Prakritik and both detail pages — numbers as
   real text (01–08), haldi numbering, forest names, Hindi secondary lines.
   No seal, no diagram, no interactivity needed.
3. **Product presentation = quiet catalogue panels** (app.css §14 +
   page-local detail-hero styles): hairline border only (no 3px accent
   stripe, no shadow, no gradient), a whisper of the format wash in the
   paper ground, the complete pack anchored toward the panel base, and the
   format's wall-finish study as the panel's base strip. V11 crop geometry
   unchanged (packs stay complete).
4. **Hero plates**: home (prakritik-group) and products (prakritik-pair)
   sit on quiet hairline-bordered paper plates — no accent stripe, no
   shadow, no decorative paint swash (removed). About hero plate: same
   treatment (brand-head strip kept).
5. **Calculator page**: the decorative sticky wall-scene (photo +
   never-driven SVG) was removed — the tool is the page (single column,
   max 60rem). `.calc__result` is now a styled forest panel matching the
   classes calculator.js actually emits.
6. **Why ch06 context**: the rural-landscape now renders as a framed
   editorial band inside the chapter grid (regional context only) — the
   PHP↔static class drift (`why-context-band` vs `-bg`) was fixed.
7. **Editorial imagery unchanged**: raw-material-study, interior/exterior
   finish studies, colour-wall-study, courtyard-study, business-context-
   study, rural-landscape (raster) all keep their V10 roles; zebu-study,
   exterior-wall-study, finished-wall-study, architectural-elevation
   (raster) remain on disk but unreferenced.
