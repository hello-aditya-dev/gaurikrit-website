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

---

# V18 — Client-Asset Integration (2026-09-27 batch)

Commit of record for the new originals: `7a7b99ed909420c498411f7c567307420db15942`.
Inspection: VLM content analysis + pixel sampling + PDF render (full logs in the
V18 worklog). The 10 new originals below extend the 10 originals above
(now 20 total in `source-assets/client-originals/`).

## 10 New Client Originals — inspected & classified

| # | File | Dimensions | Contents | Classification | Approved website use | Prohibited / misleading use |
|---|------|------------|----------|----------------|----------------------|------------------------------|
| 11 | `WhatsApp Image 2026-09-27 at 4.10.20 PM.jpeg` | 1254×1254 | ~9 hollow cylindrical cow-dung logs stacked in a pyramid beside a clay stove with glowing embers; **"GBP Bio Products" logo + leaf graphic top (y 3.5–27.5%)**, "Cow Dung Logs" banner bottom (y 89–97.5%), faint watermark on top log (y 38–46.5%); soft bokeh background | CLIENT VISUAL REFERENCE | **Derivative crop only** (`gocast-logs-context`): y 55–88.5% band — logs + stove/fire context, branding cropped out. Contextual cow-dung-log imagery | NEVER display full image (GBP wordmark conflicts with the Gaurikrit master brand); never as official Gaurikrit packaging |
| 12 | `WhatsApp Image 2026-09-27 at 4.09.33 PM.jpeg` | 894×723 | Three cylindrical cow-dung logs with central holes on a terracotta plate with straw, clean white studio background, natural contact shadows, **no text/branding** | REAL PRODUCT IMAGE (cleanest log visual) | Primary GoCast / cow-dung-log imagery (`cow-dung-logs-plate`) — deliberate catalogue-plate presentation (white ground is intentional) | Never infer dimensions/weight/burn duration/calorific value/composition; never label as Bio-Coal |
| 13 | `WhatsApp Image 2026-09-27 at 4.09.32 PM (2).jpeg` | 1280×969 | 10 rectangular briquette-style dung logs with central holes, staggered pyramid, clean white background, natural shadows, **no text/branding** | CLIENT VISUAL REFERENCE | Secondary material visual (`cow-dung-logs-stack`) — generic caption "Client-supplied cow-dung log reference" or no caption | **Do NOT label Bio-Coal** until the client confirms this exact image represents Bio-Coal; no invented format names (GoCast Round/Brick etc.) |
| 14 | `WhatsApp Image 2026-09-27 at 4.09.32 PM (1).jpeg` | 1280×1024 | Gaurikrit kraft-box **packaging concept mockup** (3D-render quality): kraft brown, forest-green bands, haldi emblem, botanical engraving linework, rural landscape illustration; printed claims "100% NATURAL / CHEMICAL FREE / ECO FRIENDLY / SUSTAINABLE LIVING", "MADE WITH NATURE'S GOODNESS", "Good for Nature. Good for Life." | MARKETING CONCEPT (packaging visual/mockup) | **Internal design reference ONLY** — art-direction inspiration (kraft warmth, green bands, haldi accent, botanical linework) applied subtly | NEVER as hero product; NEVER as proof of an existing packaged product; do NOT propagate its printed claims site-wide |
| 15 | `WhatsApp Image 2026-09-27 at 4.09.32 PM.jpeg` | 853×1280 | Single Prakritik Paint bucket (blue Distemper configuration), clean isolated white background (verified uniform 243,243,243), sharp label: "Prakritik Paint", प्रकृतिक पेंट, Khadi India oval, cow icon, "ECO-FRIENDLY COW DUNG PAINT", the 8-benefit list, "A Swadeshi Product" | REAL PRODUCT IMAGE (high-value) | Distemper-specific feature presentation (`prakritik-distemper-single`) — product detail page, Eco-Paints feature; keep natural white plate (no redraw, no AI reconstruction, no recolour) | Do not redraw/reconstruct label; do not recolour packaging; do not present as Emulsion |
| 16 | `WhatsApp Image 2026-09-27 at 4.09.31 PM (2).jpeg` | 1280×853 | Wide landscape colour presentation: "Colours Inspired by Nature", 12 Signature Collection shades, 24 Premium Collection shades, interior visual, bucket, marketing language | OFFICIAL FACT SOURCE (colour system) + CLIENT VISUAL REFERENCE | **Shade DATA source** — names/codes/cross-checking + hex sampling for the /colours/ route (real HTML UI, never the poster as an image) | NEVER embed the poster as a website section or as the colour selector; poster marketing language stays out of copy |
| 17 | `WhatsApp Image 2026-09-27 at 4.09.31 PM (1).jpeg` | 853×1280 | Portrait colour-palette poster: Signature + Premium collections, interior + product visuals | OFFICIAL FACT SOURCE (colour system) | Cross-check shade names/codes/grouping + hex sampling | Same as #16 |
| 18 | `WhatsApp Image 2026-09-27 at 4.09.31 PM.jpeg` | 853×1280 | Second portrait colour-palette presentation | OFFICIAL FACT SOURCE (colour system) | Cross-check + hex sampling (36 swatches pixel-verified) | Same as #16 |
| 19 | `GBP Broucher1.pdf` | 1 page, 1152×768 pt | One-page client brochure: "GAURIKRIT KHADI PRAKRITIK PAINT", why-choose section, Distemper + Emulsion range (**specs match the site's locked data exactly**), science panel, 6-step process, chemical-vs-Prakritik comparison, colour direction, contact block. **Address typos: "Khurayawali / Post Amia / Khuruj"** (board #20 spells correctly) | OFFICIAL FACT SOURCE (cross-check) + MARKETING CONCEPT | Positioning/structure reference; confirms existing specs. Extra marketing claims → CLIENT_VERIFICATION_REQUIRED.md only | No fear-marketing comparison; no unverified health/performance claims; do not copy its graphic style |
| 20 | `company hoarding board 2.pdf` | 1 page, A4 portrait | Company identity board: Gaurikrit (गौरीकृत) Bio Products, legal name, **"55, Village Khuriyawali, Post Arniya, Khurja, District Bulandshahr, Uttar Pradesh – 203131, India"**, GSTIN 09AAMCG8400F1ZK, seva@gaurikrit.com, +91-9999624446 / 9837638842, "Good for Nature. Good for Life.", kraft botanical board design | OFFICIAL FACT SOURCE (company data) | Canonical company/contact verification — matches data.php COMPANY exactly. Board aesthetic = internal brand reference | Board marketing badges (100% NATURAL / CHEMICAL FREE) are NOT propagated as site claims |

## V18 brand rules (from this batch)

1. **Master brand stays GAURIKRIT.** The "GBP Bio Products" wordmark on #11 is
   a legacy/sister branding never shown on the site. No second brand identity.
2. **Master tagline stays "Good for Nature. Good for Life."** The palette
   posters' "Nature's Care. India's Future." is campaign artwork only (logged
   for confirmation, never deployed).
3. **Two shade collections.** Signature (12) and Premium (the card
   enumerates 5 groups x 6 = 30 shades, GK-201..GK-230 — while the poster
   headline prints "24 SHADES", a client-side inconsistency). The site
   displays all 30 client-supplied shades and claims no contradicting
   total (see CLIENT_VERIFICATION_REQUIRED.md). Repeated names across
   collections are NOT merged (GK-104 Mango Yellow is a separate catalogue
   entry from GK-207 Mango Yellow).
4. **Digital hex values are pixel-sampled approximations** from posters #16–18
   (median swatch color, cross-checked between VLM reading and programmatic
   sampling). The /colours/ page carries a permanent quiet disclaimer:
   "Digital previews are indicative. Actual colour may vary with surface,
   application, lighting and display."

## V18 derivative mapping

| Public file | Source | Notes |
|-------------|--------|-------|
| `assets/images/client/gocast-logs-context.webp` / `.jpg` | #11 (4.10.20) | **Branding-free contextual crop**: y 55–88.5% × full width ≈ 1254×419 — stacked logs + stove embers; GBP logo, watermark and "Cow Dung Logs" banner cropped out; VLM-verified clean. Script: `scripts/derive_client_assets_2026_09_27.py` |
| `assets/images/client/cow-dung-logs-plate.webp` / `.jpg` | #12 (4.09.33) | White-margin trim + subtle contrast lift; natural 894×~700 ratio; deliberate catalogue-plate presentation (no cutout — straw/plate shadows preserved) |
| `assets/images/client/cow-dung-logs-stack.webp` / `.jpg` | #13 (4.09.32 (2)) | White-margin trim; generic material visual (never labelled Bio-Coal) |
| `assets/images/client/prakritik-distemper-single.webp` / `.jpg` | #15 (4.09.32) | White-margin trim, natural white plate kept (label has white lid — NO cutout/keying possible); Distemper feature image |
| `assets/social/og-colours.jpg` | shade data | 8 pixel-sampled swatches + mark + "Colours Inspired by Nature" (established OG template) |
| `assets/social/og-products.jpg` | pair + #12 | Regenerated: paint pair + clean log plate — the ecosystem story |
| `assets/social/og-home.jpg` | pair + #12 | Regenerated: two real objects (paint + logs) |

Archival copies of every derivative: `source-assets/derived/2026-09-27/`.
