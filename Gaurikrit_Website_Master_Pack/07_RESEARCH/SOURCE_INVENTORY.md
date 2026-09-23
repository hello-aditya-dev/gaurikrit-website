# Source Inventory

Files supplied by the client and their intended use in the build.

## 00_SOURCE_ASSETS/originals/
| File | Type | Used for |
|------|------|---------|
| `Company Board3.pdf` | Brief | Company background, founder note |
| `Broucher-paint.pdf` | Brochure | Paint product copy, specs, coverage figures |
| `Website Development.pdf` | Brief | IA, sections, conversion goals |
| `Gaurikrit_Haldi & Black.pdf` | Brand | Haldi product tone + gold/black palette |
| `Gaurikrit_Black & White.pdf` | Brand | Master palette discipline |
| `Gaurikrit_Black & White (1).pdf` | Brand | Variant of above |
| 6 WhatsApp images | Product | Product card imagery (to be optimised) |

## Working assets (to be produced in 00_SOURCE_ASSETS/working/)
- Renamed product images: `haldi-powder.webp`, `haldi-paste.webp`, `haldi-wellness.webp`, `paint-interior.webp`, `paint-exterior.webp`, `paint-natural.webp`, `paint-wood.webp`, `paint-primer.webp`.
- Logo renders: `logo-full.svg`, `logo-mono.svg`, `logo-mark.svg`.
- Website brief render: `brief-render.png`.

## How originals map to the build
- Brand PDFs → `02_DESIGN/DESIGN_SYSTEM.md` colour tokens.
- Brochure → `05_CONTENT_DATA/products.json` paint entries.
- Company Board → `05_CONTENT_DATA/company.json` story + stats.
- WhatsApp images → `public/products/*.webp` after rename/optimise.

## Status
- **Originals:** not present in this sandbox build (uploaded to client drive).
- **Working:** AI-generated visuals + CSS used as substitutes for v1.
- **Replace before public launch** per `CLIENT_INPUTS_REQUIRED.md`.
