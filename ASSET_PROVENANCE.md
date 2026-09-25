# Asset Provenance — Gaurikrit Website

Maps each client original to its public derivatives. Client originals in
`source-assets/client-originals/` are immutable — never modify them.

Last verified: V8 pass — product derivatives re-cut as complete-bucket crops
(no sliced lids/bases/sides) after the V7 inspection. Commit of record for
the originals: `215f5df47d41fc18c332ff3505a5ab0e16126741`.

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
| 9 | `WhatsApp …10.21.44 PM(2).jpeg` | 800×400 | Two-bucket comparison graphic ("INDIA'S FIRST KHADI PRAKRITIK PAINT", Distemper blue + Emulsion orange) on light pink ground. | Yes — product comparison (not currently used; group photo used instead) |
| 10 | `WhatsApp …10.22.06 PM(2).jpeg` | 1280×621 | **Three-bucket group photo** (2 Emulsion + 1 Distemper centre) on wooden surface, white ground. Highest-quality current hero product image. | Yes — hero product image |

## Derivative mapping

| Public file | Source original | Notes |
|-------------|-----------------|-------|
| `assets/brand/gaurikrit-logo-full.png` | #4 Gaurikrit_Haldi & Black.pdf | Extracted via pdftoppm + alpha |
| `assets/brand/gaurikrit-logo-mark.png` | #4 Gaurikrit_Haldi & Black.pdf | Cropped from full logo |
| `assets/products/prakritik-group.jpg` | #10 WhatsApp 10.22.06 | Full 3-bucket group photo (1280×621) |
| `assets/products/prakritik-distemper.jpg` | #10 WhatsApp 10.22.06 | **V8 complete-bucket crop** (395,0,885,621) = 490×621 — full photo height kept; centre Distemper bucket complete (lid, handle, base, sides); narrow neighbour slivers at both edges are part of the original shelf photo (never slice the main bucket to remove them) |
| `assets/products/prakritik-emulsion.jpg` | #10 WhatsApp 10.22.06 | **V8 complete-bucket crop** (830,0,1280,621) = 450×621 — right Emulsion bucket complete to the photo's natural right edge (wood); centre-bucket sliver at left is occlusion present in the original photo |
| `assets/documents/prakritik-paint-brochure.pdf` | #1 Broucher-paint.pdf | Direct copy |
| `assets/documents/prakritik-paint-brochure-cover.jpg` | #1 Broucher-paint.pdf | Rendered page 1 at 120 DPI |
| `assets/editorial/zebu-study.webp` | `source-assets/zebu-study.png` (1536×1024) | Generated editorial artwork |
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
2. **Natural-history cow art** (zebu-study) is reserved for the material
   origin narrative; the V7 home hero and Ashta section no longer layer it
   as background noise.
3. **Architectural art** (business-context / architectural studies) appears
   only as editorial context on For-Business; the Why-Prakritik context
   chapter now uses the neutral rural engraving at 0.08 opacity instead of
   a building that could imply a facility.
4. **The official logo** is used only for branding (header, footer, direct
   contact plate, product plate heads, 404 seal) — never as substitute
   imagery for a section.
5. File #8 (future-products collage) is excluded from all public outputs.

## Priority rule

For product/brand imagery:
1. client-originals (highest priority)
2. other high-quality source-assets
3. prepared production derivatives
4. generated editorial art (only when needed)

Never re-compress an already-compressed derivative to make another file.
