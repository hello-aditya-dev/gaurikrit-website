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

---

## V19 — Master image system + provenance (2026-09-27, this pass)

V19 built ONE art-directed image system: 4K masters in
`source-assets/masters/2026-09-27/`, public responsive derivatives in
`assets/images/ecosystem/` (AVIF + WebP + JPEG, 640–2560 ladder, srcset/sizes
on every placement). Deterministic pipeline: `scripts/build_v19_masters.py`
(+ `scripts/build_v19_derivatives.py`). No AI reconstruction of any factual
product pixel anywhere.

### Master registry (SOURCE / TYPE / PRESERVATION / GENERATIVE AREAS / USE)

| Master | SOURCE | TYPE | FACTUAL PRESERVATION | GENERATIVE AREAS | PUBLIC USE |
|---|---|---|---|---|---|
| `home-hero-ecosystem-4k.jpg` (3840×2560) + `-mobile-4k.jpg` (2000×2500) | V11 pair cutouts (#7→`prakritik-distemper/emulsion-from-pair.png`) + client log plate (#12) | **real-enhanced composite** | Both bucket cutouts pasted pixel-exact (labels, colours, rims untouched); plate mirrored + edge-unmixed only | background sweep (procedural limewash, no AI), contact shadows, grain | home hero (LCP, fetchpriority=high; mobile portrait variant ≤899px) |
| `eco-paints-pair-4k.jpg` (3840×2400) | same pair cutouts | **real-enhanced composite** | identical factual treatment | same procedural background | home four-directions 01 + documented family, products hero/eco-family, about stage 02, sustainability pair contexts |
| `prakritik-distemper-4k.jpg` (2160×2640) | #15 blue-bucket cutout (`prakritik-distemper-single-cut.png`, V18 flood-key) | **real-enhanced composite** | bucket pixels exact (label/colours unchanged; capped ±6% WB on near-whites only) | procedural sweep + shadow | distemper detail hero (cover-fit panel), sustainability wall-coating outcome |
| `prakritik-emulsion-4k.jpg` (2160×2640) | `prakritik-emulsion-from-pair.png` | **real-enhanced composite** | same | same | emulsion detail hero |
| `material-development-4k.jpg` (2880×1920) | #15 cutout | **real-enhanced composite** | same | same | home stage 02 (product WITH context — never a giant label crop) |
| `gocast-editorial-4k.jpg` (3200×2400) | #12 plate (flood-key cutout, shadow-junk keying) | **real-cropped composite** | plate/logs/straw pixels exact; mirrored for lighting match | sweep + shadow | home four-directions 02, products GoCast feature, partners strip |
| `gocast-material-4k.jpg` (3840×2560) | #13 stack (end-grain crop 30–94% × 18–82%) | **real-cropped** | crop + contrast only | none | about stage 03, sustainability fuel outcome |
| `gocast-context-4k.jpg` (3840×1286) | #11 GBP-free band (V18 crop) | **real-cropped** | contrast lift only | none | reserved (not placed in V19 pages) |
| `innovation-research-4k.jpg` (3840×2400) | rawmat (#gen) + #13 log crop + wall (#gen) as three sample slabs | **hybrid composition** | log chip pixels real; other two chips are from generated category images (below) | slab frame + sweep | home innovation teaser, innovation hero, about idea chapter |
| `biocoal-editorial-4k.jpg` (3840×2880) | z-ai generation (basis: `/tmp/v19-gen/biocoal-1.png`, prompt archived below) | **representative-generated** | n/a — contains NO Gaurikrit product, NO packaging, NO text, NO logo (VLM-verified) | whole scene | home four-directions 03, products Bio-Coal section, partners strip |
| `utility-material-direction-4k.jpg` (3840×2880) | z-ai generation (basis `/tmp/v19-gen/utility-1.png`, 5% edge crop) | **representative-generated** | n/a — unbranded moulded natural forms; NO text/logos (VLM-verified) | whole scene | home four-directions 04, products Utility section, partners strip |
| `colours-wall-4k.jpg` (3840×2192) | z-ai generation (basis `/tmp/v19-gen/wall-2.png`) | **representative-generated** | n/a — generic interior; wall-only SVG tint mask M101,115 H1236 V645 + bench hole | whole scene | /colours/ visualizer, home stage 03, calculator hero plate |
| `rawmat-4k.jpg` (3840×2192) | z-ai generation (basis `/tmp/v19-gen/rawmat-1.png`) | **representative-generated** | n/a — generic biomass/straw surface, no text | whole scene | home stage 01, about resource chapter, sustainability hero, why-prakritik flow |

### Generation bases (prompts summarised; masters carry the unmix/relight/grain pipeline)

- **Bio-Coal**: "dense dark biomass bio-coal fuel briquettes… matte black/deep
  charcoal… 3/4 view ~30° above, 55mm, soft side light, warm limestone/paper
  background, no text/logos/fire/leaves." Dark + dense + industrial vs GoCast's
  brown fibrous natural logs — the required visual distinction (VLM-verified).
- **Utility**: "unbranded moulded natural-material forms — trays, discs,
  pressed tiles, plant-fibre textures, warm tan/kraft/clay, 35° elevated,
  soft daylight, no text/labels/packaging." Reads as material prototypes,
  NOT commercial tableware (VLM comparison: utility-1 beat utility-2 which
  read as dinnerware).
- **Wall**: "bright minimal room, very large flat warm ivory limewash wall,
  soft daylight from left, bench + jute rug corner, 50mm, no text/people."
  Chosen for tintability (9/10 VLM) — wall-1 rejected (props broke the wall).
- **Raw material**: "raw biomass patty with golden straw fibre drying on warm
  clay, macro, warm sunlight." Chosen for organic believability (rawmat-2
  rejected: cloned-straw artifacts).

### V19 alt-text discipline (§58)

Real product images say "Prakritik Distemper/Emulsion paint pack…";
representative visuals say "Representative biomass briquette material study
for the Bio-Coal category" / "Representative moulded natural-material utility
forms…" and carry an on-image "Category visual" tag on home + explicit
figcaptions on products. No generated image is ever described as a
documented Gaurikrit product.

### Removed from public assets (§71; originals/masters retained in source-assets/)

`products/prakritik-pair.{jpg,webp}` (superseded by the pair master),
`products/prakritik-{single-can,two-buckets,distemper,emulsion}.jpg` (legacy
low-res), `editorial/{colour-wall,finished-wall,interior-wall,exterior-wall,
exterior-wall-v2,architectural-elevation,business-context,zebu}-study.{jpg,webp}`
(unreferenced), `illustrations/` folder (legacy). The from-pair cutout PNGs
(+ webp serving copies) stay: they are live pipeline inputs and are still
served on the products page catalogue chapters.

---

## V20 — hero transitioning showcase + Bio-Coal/Utility client-poster upgrade (2026-10-16 originals)

### New client originals (untouched, in `source-assets/client-originals/`)

| File | Product direction | VLM-verified contents |
|---|---|---|
| `WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg` (1280×853) | Eco-Paints | Three Prakritik Paint buckets (Emulsion, Emulsion, Distemper); Gaurikrit + Khadi India branding; "प्रकृतिक पेंट"; anti-bacterial/anti-fungal/eco-friendly claims |
| `WhatsApp Image 2026-10-16 at 7.45.05 AM.jpeg` (1024×1024) | Bio-Coal Logs | Gaurikrit BIO-BRIQUETTES poster — "Premium Renewable Biomass Fuel"; cylindrical hollow briquettes; high-calorific / low-moisture / low-ash claims |
| `WhatsApp Image 2026-10-16 at 7.45.05 AM (1).jpeg` (1024×1024) | Cow-Dung Logs | Gaurikrit COW-DUNG LOGS poster — "Premium Biomass Fuel"; made from processed cow dung; havan/crematorium/boiler/industrial use |
| `WhatsApp Image 2026-10-16 at 7.45.05 AM (2).jpeg` (853×1280) | Eco Utility Products | Gaurikrit ECO UTILITY PRODUCTS poster — Dhoop Cups, Cow-Dung Diyas, Biodegradable Disposable Plates, Eco Glasses/Cups |

### Derived hero carousel ladders (`scripts/prepare_hero_carousel_assets.py`)

Pillow avif+webp+jpg, 2 rungs per slide (long-edge 640 + native-max capped at
1280; NO upscaling). Files named by ACTUAL pixel width so the `<source srcset
Ww>` descriptor is truthful (the portrait utility poster therefore advertises
426w / 853w). Lives in both `dist-hostinger/assets/images/ecosystem/` (public)
and `source-assets/client-derived/hero/` (archive + `manifest.json`).

| Slide stem | Rungs (px w) | Intrinsic | Used in |
|---|---|---|---|
| `hero-eco-paints` | 640, 1280 | 1280×853 | hero slide 1 |
| `hero-bio-coal-logs` | 640, 1024 | 1024×1024 | hero slide 2 |
| `hero-cow-dung-logs` | 640, 1024 | 1024×1024 | hero slide 3 |
| `hero-eco-utility-products` | 426, 853 | 853×1280 | hero slide 4 |

### Derived family-card crops (`scripts/prepare_family_card_assets.py`)

3/2 crops that preserve product identity + label text (Part 6 upgrade of the
homepage "Four directions" grid and the Products page direction sections).

| Stem | Source | Crop anchor | Intrinsic crop | Rungs | Replaces |
|---|---|---|---|---|---|
| `family-bio-coal-logs` | bio-briquettes poster | center | 1024×683 | 640, 960, 1024 | `biocoal-editorial` (representative-generated) |
| `family-eco-utility-products` | utility poster | top | 853×569 | 640, 853 | `utility-material-direction` (representative-generated) |

### Factual-discipline changes

The homepage 4-card grid and the Products page Bio-Coal + Utility direction
sections previously labelled these two as "Category visual" / "Representative …
visual — not a documented product photograph" because the imagery was
unbranded generated material studies. With the 2026-10-16 client product
posters now integrated, those disclaimers are removed and the alt text /
figcaptions / aria-labels now read "Client-supplied Gaurikrit … product
poster". No invented claims/specs/certifications were added — all claims
visible on screen are the client's own poster copy. The `biocoal-editorial`
and `utility-material-direction` masters are retained on disk (still used by
the For-Business `biz-hero__ecosystem` tile mosaic); only the homepage grid
and Products direction sections switched to client imagery.

### Components / files touched

- `dist-hostinger/index.php` — hero `<style>` + markup + `$HERO_SLIDES` data;
  `$familyMedia` array (Bio-Coal/Utility stems + representative=false); family
  card `<img>` fallback now uses `max($m['ladder'])`.
- `build-static.mjs` — JS twin of all the above (HERO_SLIDES, heroSlides,
  heroDots, `.hero-showcase*` CSS, carousel markup, mediaSpec with widths/fb,
  familySection photoSpec with w/h/fb/real, accurate figcaptions); added
  `hero-carousel.js` script tag.
- `dist-hostinger/products/index.php` — Bio-Coal + Utility direction-section
  figures upgraded to client crops (accurate width/height, no CLS).
- `dist-hostinger/includes/footer.php` — `hero-carousel.js` script tag.
- `dist-hostinger/assets/js/hero-carousel.js` — NEW vanilla-JS carousel module.
- `dist-hostinger/assets/js/app.js` — `HeroCarousel` added to boot `mods`.
- `scripts/prepare_hero_carousel_assets.py` + `prepare_family_card_assets.py`
  — NEW reproducible asset pipelines (Pillow).

---

## V22 — 2026-10-29 client batch (OneDrive ZIP): final carousel artworks + four-stage flow imagery

**Source originals (preserved verbatim, never modified):**
`source-assets/client-originals/2026-10-29-update/` — 19 files from the client's
OneDrive ZIP (`OneDrive_2026-10-29.zip`). Full inventory with SHA-256 hashes
recorded at intake; every file visually inspected (VLM) before selection.

### Selected and used on the site

| Original | Dimensions | Type | Used for |
|---|---|---|---|
| `Gaurikrit_Final_4_Carousel_Images/Gaurikrit_Eco_Paints_1920x1080.webp` | 1920×1080 | Client artwork (paint buckets) | Hero slide 1 + Eco-Paints portfolio card |
| `Gaurikrit_Final_4_Carousel_Images/Gaurikrit_Bio_Briquettes_1920x1080.webp` | 1920×1080 | Client artwork (briquettes) | Hero slide 2 + Bio-Briquettes portfolio card + Products page |
| `Gaurikrit_Final_4_Carousel_Images/Gaurikrit_Cow_Dung_Logs.png` | 1672×941 | Client artwork (logs) | Hero slide 3 + Cow-Dung Logs portfolio card + Products page |
| `Gaurikrit_Final_4_Carousel_Images/Gaurikrit_Eco_Utility_Products_1920x1080.webp` | 1920×1080 | Client artwork (utility) | Hero slide 4 + Utility portfolio card + Products page |
| `Cow-Dung pile-3.png` | 1672×941 | Photograph (no text) | Four-stage flow — Stage 01 Cow Dung |
| `Natural waste processing.png` | 1254×1254 | Conceptual 3D render | Four-stage flow — Stage 02 Processing & Innovation (caption stays neutral: "conceptual visual", NOT claimed as Gaurikrit's facility) |
| `Earth globe with green leaf arrows-4.png` | 1254×1254 | 3D render (no text) | Four-stage flow — Stage 04 Environmental Impact |

### Preserved but not embedded on the site

| Original | Notes |
|---|---|
| `Cow-Dung pile-1/2/4.png` | Alternative raw-material photography (pile-3 selected — clearest composition). Available for future use. |
| `From Cow Dung to a Greener Future.png` | Wide lifecycle illustration — used as a visual reference for the four-stage flow; NOT embedded (embedded words would be unreadable at card size; the flow is recreated in accessible HTML per client instruction). |
| `From Cow Dung to Sustainable Solutions-1.png` | Wide four-stage flow graphic (1983×793) — same treatment: reference only. |
| `GBP Paint Bucket.png`, `GBP Products Banner.png` | Older promotional materials — superseded by the Final-4 carousel artworks. |
| `GBP Bio-Briquettes.jpeg`, `GBP Cow-Dung Logs.jpeg` | Square poster variants — superseded by the landscape carousel artworks. |
| `GBP Futureline Products Showcase-1/2/3.png` | Older utility showcase materials — superseded. |

### Derived responsive ladders (`scripts/derive_client_assets_2026_10_29.py`)

Pillow avif (q58/s6) + webp (q82/m6) + jpg (q87 progressive), resized from the
preserved originals only (never from other derivatives), never upscaled, files
named by ACTUAL pixel width. Archive copies + `manifest.json` in
`source-assets/client-derived/2026-10-29/`.

| Stem | Source | Rungs | Used on |
|---|---|---|---|
| `carousel-eco-paints` | Eco-Paints artwork | 640, 960, 1280, 1920 | Homepage hero + portfolio + mini-grid |
| `carousel-bio-briquettes` | Bio-Briquettes artwork | 640, 960, 1280, 1920 | Homepage hero + portfolio + mini-grid + /products/ |
| `carousel-cow-dung-logs` | Cow-Dung Logs artwork | 640, 960, 1280 | Homepage hero + portfolio + mini-grid + /products/ |
| `carousel-eco-utility-products` | Eco Utility artwork | 640, 960, 1280, 1920 | Homepage hero + portfolio + mini-grid + /products/ |
| `flow-cow-dung` | Cow-Dung pile-3.png | 640, 960, 1280 | Homepage flow Stage 01 |
| `flow-processing` | Natural waste processing.png | 640, 960 | Homepage flow Stage 02 |
| `flow-impact` | Earth globe PNG | 640, 960 | Homepage flow Stage 04 |

### Terminology change (recorded per client instruction, V22)

- **"GoCast Logs" → "Cow-Dung Logs"** — the name printed on the client's
  supplied product artwork. Family ID `gocast-logs` → `cow-dung-logs`;
  legacy anchor `/products/#gocast-logs` preserved as an invisible alias.
- **"Bio-Coal Logs" → "Bio-Briquettes"** — same reason. Family ID
  `bio-coal-logs` → `bio-briquettes`; legacy anchor
  `/products/#bio-coal-logs` preserved as an invisible alias.
- Form field VALUES (`gocast-logs`, `bio-coal-logs` in `$INTEREST_OPTIONS`)
  deliberately kept stable so existing enquiry deep links and backend
  validation continue to work; only the visible LABELS changed.

### Components / files touched (V22)

- `dist-hostinger/index.php` — `$HERO_SLIDES` (4 landscape artworks, 16/9
  frame), flow stages 01/02/03/04 (new imagery + 2×2 mini-grid for Stage 03),
  `$familyMedia` (carousel stems), circular section condensed to a summary +
  link to /sustainability/, innovation section restored to
  `innovation-research`.
- `dist-hostinger/includes/data.php` — `$FAMILIES` renamed entries, menus,
  footer links, form labels, application groups.
- `dist-hostinger/products/index.php` — direction sections renamed with new
  anchors + legacy alias spans; figures switched to client artworks.
- `dist-hostinger/assets/css/app.css` — `.family__media--photo` frame 3:2→16:9
  with `object-fit: contain`.
- `dist-hostinger/contact|for-business|sustainability/index.php` — wording.
- Mirrors of all of the above under `docs/`.
- Retired from use (files kept on disk): `hero-*` carousel ladders (V20),
  `family-bio-coal-logs`, `family-eco-utility-products`, `rawmat` /
  `innovation-research` on the flow (innovation-research still used in the
  Research & Innovation section), `colours-wall` on the flow.

### V22.1 — Biodegradable Product Showcase (Stage 03, 2026-10-29)

The client requested replacing the homepage Stage 03 (Product Portfolio)
image with `Biodegradable Product Showcase.png` from the shared folder.

**Filename resolution**: The exact filename `Biodegradable Product
Showcase.png` is not present in any shared folder or client-originals
archive we can access. The closest content match — a comprehensive 2×2
biodegradable utility-products showcase (Dhoop Cups, Cow-Dung Diyas,
Biodegradable Disposable Plates, Eco Glasses) under the
"GAURIKRIT® ECO UTILITY PRODUCTS / Sustainable Solutions from Nature"
header — is `GBP Futureline Products Showcase-2.png` from the
2026-10-29 OneDrive batch. This substitution is documented here and in
the final report; the client should confirm it is the intended artwork.

- **Source (preserved byte-for-byte)**:
  `source-assets/client-originals/2026-10-29-update/GBP Futureline Products Showcase-2.png`
- **Intrinsic dimensions**: 1024 × 1536 (portrait, 2:3)
- **SHA-256**: `2539773079f6a8f42b33b1ea7ff7342e442f8f3c7c7024d4de86856df0569917`
- **File size**: 2,275,653 bytes
- **Archived original**: `source-assets/client-derived/2026-10-29-fixes/biodegradable-product-showcase-original.png`
- **Derivatives** (generated by `scripts/derive_portfolio_showcase.py`,
  capped at native width, never upscaled; avif q=58 / webp q=82 / jpg q=87):
  - `flow-portfolio-640.{avif,webp,jpg}` (640 × 960)
  - `flow-portfolio-960.{avif,webp,jpg}` (960 × 1440)
- **Placement**: Homepage Stage 03 (Product Portfolio) in both
  `dist-hostinger/index.php` and `docs/index.html` (generated from
  `build-static.mjs`). Uses `resource-step__figure--poster` with
  `object-fit: contain` so the complete poster — embedded labels, logos,
  product imagery — is never cropped.
- **Alt text**: "Gaurikrit biodegradable product showcase — dhoop cups,
  cow-dung diyas, biodegradable plates and eco glasses"

The previous Stage 03 implementation (a 2×2 mini-grid of four separate
carousel artworks) is retired. The four individual product directions are
still represented in the hero carousel and the families section below.

### V22.1 — Emulsion image reconciliation

The PHP product data previously declared `prakritik-emulsion-from-pair.png`
(638 × 612) as the official Emulsion image, while the generated static
page used `prakritik-emulsion-1280.jpg` (1280 × 1564). Both builds now
use a single consistent source: a clean cutout derived from
`source-assets/client-originals/WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg`,
produced by `scripts/fix_emulsion_and_rawmat.py`.

- **Source**: `WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg`
- **Derivatives**: `prakritik-emulsion-{640,960,1280,1600}.{avif,webp,jpg}`
  (intrinsic 1280 × 960, 4:3) + `prakritik-emulsion-single-cut.png/.webp`
  (client image archive) + `og-emulsion.jpg` (social card).
- **Framing**: `.product-detail__panel` uses `aspect-ratio: 4/3` with
  `object-fit: contain` so the complete bucket, lid, handle and label
  are always visible.
- VLM-verified: no pink remnants, no halos, clean base, complete label.

### V22.1 — Raw-material photograph reconciliation

The About and Sustainability pages previously referenced the old `rawmat`
ladder and descriptions referring to "generic biomass or straw fibre".
Replaced with genuine cow-dung pile photographs from the 2026-10-29
client originals:

| Placement | Stem | Source original |
|---|---|---|
| Homepage Stage 01 (Cow Dung) | `flow-cow-dung` | `Cow-Dung pile-3.png` |
| About / Our Story (hero + Stage 01) | `rawmat-shed` | `Cow-Dung pile-2.png` |
| Sustainability (hero) | `rawmat-cakes` | `Cow-Dung pile-4.png` |
| Why Prakritik (Chapter 01) | `rawmat-tree` | `Cow-Dung pile-1.png` |

All four sources are genuine photographs of cow-dung piles supplied by
the client on 2026-10-29. No generated straw images remain in active use.

### V22.1 — For Business page parity

Both `dist-hostinger/for-business/index.php` and `docs/for-business/index.html`
now use the same 2×2 tile hero composition featuring the four approved
client-supplied carousel artworks:
`carousel-eco-paints`, `carousel-cow-dung-logs`, `carousel-bio-briquettes`,
`carousel-eco-utility-products` (each 1280 × 720, `object-fit: cover`).
The old four-tile grid using `eco-paints-pair`, `gocast-editorial`,
`biocoal-editorial` and `utility-material-direction` is retired.

### V22.1 — build-static.mjs as authoritative source

`build-static.mjs` is corrected so that running `node build-static.mjs`
reproduces the approved current website in `docs/` without restoring old
wording or old image stems. All obsolete public-facing product names
(`GoCast Logs`, `Bio-Coal Logs`, `Utility Products` as a direction name)
and the heading `One resource. Four directions.` have been removed from
active templates and data definitions. Legacy HTML IDs, URL anchors and
form submission values (`gocast-logs`, `bio-coal-logs`, `utility-products`)
are preserved for compatibility; only visible labels changed.

### V22.2 — Futureline product status (client-confirmed, 2026-10-29)

The client confirmed that Bio-Briquettes and Eco Utility Products are
Futureline products, not yet in production. The `FAMILIES` data in both
`build-static.mjs` and `dist-hostinger/includes/data.php` now carries a
`statusVariant` field with three values: `documented` (Eco-Paints),
`development` (Cow-Dung Logs), and `futureline` (Bio-Briquettes and
Eco Utility Products).

The `status` display text for the two Futureline directions is
"Futureline · Not yet in production". CSS variants
`.family__status--futureline` and `.status-badge--futureline` render
this with the haldi accent and forest-green text — consistent with the
existing design system, legible on desktop and mobile, and accessible
via `title` attributes on the badges.

The hero carousel sub-captions for Bio-Briquettes and Eco Utility
Products now read "Futureline · Not yet in production"; Cow-Dung Logs
reads "Development direction"; Eco-Paints reads "Prakritik Paint
family".

All availability-implying language has been removed. The client-supplied
artwork for both directions is preserved byte-for-byte; status wording
appears only as separate HTML text, never edited into the images.

### V22.3 — Emulsion image correction + Stage 02 conceptual qualifier

**Emulsion image**: The previous V22.1 cutout (from WhatsApp Image
2026-10-16 at 7.45.04 AM.jpeg) had defective bottom edges — jagged
outline, torn/peeling label remnants, and cutout artifacts confirmed
by VLM inspection. Per the audit requirement to "stop iterating on a
defective cutout" and "prefer a clean intact product photograph," the
Emulsion image is now derived from `GBP Paint Bucket.png` (1536×1024)
from the 2026-10-29 OneDrive archive.

- **Source**: `source-assets/client-originals/2026-10-29-update/GBP Paint Bucket.png`
- **SHA-256**: `69d2c6e0ba3fc0d2...` (full hash in client-originals)
- **Intrinsic dimensions**: 1536 × 1024 (3:2 landscape)
- **Content**: Professional photograph showing the Prakritik Paint range
  (Emulsion, Distemper, Emulsion) on a wooden surface with white brick
  wall background. Clean natural bottom edges — no cutout artifacts.
- **Derivatives**: `prakritik-emulsion-{640,960,1280,1536}.{avif,webp,jpg}`
- **Panel**: 4:3 aspect-ratio with `object-fit: contain` (image is 3:2,
  so small top/bottom letterboxing appears — acceptable as a matted look)
- **Alt text**: "Prakritik Emulsion paint pack — the Prakritik Paint
  range with the Emulsion bucket visible on the right"
- **VLM-verified**: Clean professional photograph, no defects, complete
  buckets with clean edges, no cutout artifacts.

The Distemper image remains unchanged (clean cutout from the 2026-09-27
pair photo, VLM-verified as clean with no defects).

**Stage 02 Processing & Innovation**: Added a visible italic qualifier
caption "Illustrative processing concept — not a photograph of Gaurikrit's
facility." below the stage description. This ensures the conceptual
`Natural waste processing.png` artwork cannot be mistaken for a
photograph of Gaurikrit's actual operations. The alt text already said
"Conceptual visual" but the audit required a visible qualifier.
CSS: `.resource-step__qualifier` (0.6875rem, italic, muted, opacity 0.8).

### V23 — Complete client asset integration

All 19 original assets from OneDrive_2026-10-29.zip are now accounted
for and implemented. This section records the 7 assets that were
previously unused or underused and have now been integrated.

| # | Original file | Stem | Placement | Derivatives |
|---|---|---|---|---|
| 8 | GBP Bio-Briquettes.jpeg | `gbp-bio-briquettes` | Products page, Bio-Briquettes section poster | 640, 960, 1024 |
| 9 | GBP Cow-Dung Logs.jpeg | `gbp-cow-dung-logs` | Products page, Cow-Dung Logs section poster | 640, 960, 1024 |
| 10 | GBP Futureline Products Showcase-1.png | `showcase-utility` | Products page, Eco Utility Products section poster | 640, 960, 1022 |
| 12 | GBP Futureline Products Showcase-3.png | `showcase-innovation` | Innovation page, documented-outcome section | 640, 960, 1254 |
| 14 | GBP Products Banner.png | `products-banner` | Products page, ecosystem banner after hero | 640, 960, 1280, 1536 |
| 7 | From Cow Dung to a Greener Future.png | `journey-greener` | Sustainability page, after circular-economy section | 640, 960, 1280, 1672 |
| 6 | From Cow Dung to Sustainable Solutions-1.png | `journey-sustainable` | About page, after company-info section | 640, 960, 1280, 1600, 1983 |

All infographics and banners carry visible italic qualifiers:
"Illustrative direction — not a verified production process or measured
environmental outcome." The GBP Products Banner caption explicitly
states "Bio-Briquettes and Eco Utility Products are Futureline products,
not yet in production."

**Logo transparency**: The existing logo files
(`gaurikrit-logo-mark.png`, `gaurikrit-logo-mark-sm.png`,
`gaurikrit-logo-full.png`) already have genuine alpha-channel
transparency (verified: corner pixels alpha=0, edge samples 95%+
transparent). No background-removal was needed. The header's
`.brand__mark` uses `background: var(--paper)` which matches the site's
paper background, so the logo blends naturally without a visible
rectangular tile. VLM-confirmed: "blends naturally into the page
background... no visible white or off-white rectangular background
tile."

**Asset coverage summary (all 19)**:
- 4 cow-dung pile photos: Home (pile-3), About (pile-2), Sustainability (pile-4), Why Prakritik (pile-1)
- 4 carousel artworks: Homepage hero carousel (all 4)
- Earth globe: Homepage Stage 04 (flow-impact)
- Natural waste processing: Homepage Stage 02 (flow-processing)
- GBP Paint Bucket: Emulsion product page (prakritik-emulsion)
- GBP Futureline Products Showcase-2: Homepage Stage 03 (flow-portfolio)
- GBP Bio-Briquettes: Products page Bio-Briquettes poster
- GBP Cow-Dung Logs: Products page Cow-Dung Logs poster
- GBP Futureline Products Showcase-1: Products page Eco Utility poster
- GBP Futureline Products Showcase-3: Innovation page material study
- GBP Products Banner: Products page ecosystem banner
- From Cow Dung to a Greener Future: Sustainability page infographic
- From Cow Dung to Sustainable Solutions-1: About page infographic
