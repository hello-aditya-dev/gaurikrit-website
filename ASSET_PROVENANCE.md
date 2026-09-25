# Asset Provenance — Gaurikrit Website

Maps each client original to its public derivatives. Client originals in
`source-assets/client-originals/` are immutable — never modify them.

## 10 Client Originals

| # | File | Dimensions | Classification | Public use? |
|---|------|------------|----------------|-------------|
| 1 | `Broucher-paint(2).pdf` | 4 pages | Paint brochure (specs, benefits, launch) | Yes — brochure PDF + cover |
| 2 | `Company Board3(2).pdf` | 1 page | Company board (brand presentation) | No — internal reference |
| 3 | `Gaurikrit_Black & White(2).pdf` | 1 page | Brand identity (B&W variant) | No — internal reference |
| 4 | `Gaurikrit_Haldi & Black(2).pdf` | 1 page | Brand identity (haldi+black variant) | Yes — logo extracted |
| 5 | `WhatsApp …10.11.56 PM(2).jpeg` | 853×1280 | **Official Gaurikrit logo** (yellow scalloped badge + cow head) | Yes — logo reference |
| 6 | `WhatsApp …10.14.15 PM(2).jpeg` | 853×1280 | **Single paint can** (Khadi India Prakritik Paint) | Yes — product photo |
| 7 | `WhatsApp …10.15.03 PM(2).jpeg` | 1280×1024 | Gaurikrit Bio Products cardboard box | No — packaging reference |
| 8 | `WhatsApp …10.20.10 PM(2).jpeg` | 1024×1024 | **Collage with unsupported future products** (cow dung logs, bio-fertilizer, utility items) | **NO — contains unconfirmed products** |
| 9 | `WhatsApp …10.21.44 PM(2).jpeg` | 800×400 | Two buckets: Distemper (blue) + Emulsion (orange) | Yes — product comparison |
| 10 | `WhatsApp …10.22.06 PM(2).jpeg` | 1280×621 | Three-bucket group photo | Yes — hero product image |

## Derivative mapping

| Public file | Source original | Notes |
|-------------|-----------------|-------|
| `assets/brand/gaurikrit-logo-full.png` | #4 Gaurikrit_Haldi & Black.pdf | Extracted via pdftoppm + alpha |
| `assets/brand/gaurikrit-logo-mark.png` | #4 Gaurikrit_Haldi & Black.pdf | Cropped from full logo |
| `assets/products/prakritik-group.jpg` | #10 WhatsApp 10.22.06 | Full 3-bucket group photo (1280×621) |
| `assets/products/prakritik-distemper.jpg` | #10 WhatsApp 10.22.06 | Crop (385,52,895,590) = 510×538 |
| `assets/products/prakritik-emulsion.jpg` | #10 WhatsApp 10.22.06 | Crop (895,56,1250,542) = 355×486 |
| `assets/documents/prakritik-paint-brochure.pdf` | #1 Broucher-paint.pdf | Direct copy |
| `assets/documents/prakritik-paint-brochure-cover.jpg` | #1 Broucher-paint.pdf | Rendered page 1 at 120 DPI |
| `assets/editorial/zebu-study.webp` | `source-assets/zebu-study.png` (1536×1024) | Generated editorial artwork |
| `assets/editorial/courtyard-study.webp` | `source-assets/courtyard-study.png` (1942×809) | Generated editorial artwork |
| `assets/editorial/interior-wall-study.webp` | `source-assets/editorial/interior-wall-study.png` | Generated editorial artwork |
| `assets/editorial/exterior-wall-study-v2.webp` | `source-assets/editorial/exterior-wall-study-v2.png` | Generated editorial artwork |
| `assets/editorial/finished-wall-study.webp` | `source-assets/editorial/finished-wall-study.png` | Generated editorial artwork |
| `assets/editorial/business-context-study.webp` | `source-assets/editorial/business-context-study.png` | Generated editorial artwork |
| `assets/editorial/rural-landscape.webp` | `source-assets/editorial/rural-landscape.png` | Generated editorial artwork |

## Priority rule

For product/brand imagery:
1. client-originals (highest priority)
2. other high-quality source-assets
3. prepared production derivatives
4. generated editorial art (only when needed)

Never re-compress an already-compressed derivative to make another file.
