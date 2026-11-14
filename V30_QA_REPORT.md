# V30 QA Report — Final Quality Correction Pass

## 1. Heading Punctuation and Whitespace Scan

### Five specific heading corrections

| # | Page | Before | After | Status |
|---|---|---|---|---|
| 1 | Colours | `Colours for the Eco-Paints family.` | `Colours for the Eco-Paints Family` | ✓ Fixed |
| 2 | Products | `One natural resource. Multiple useful applications` | `One Natural Resource, Multiple Useful Applications` | ✓ Fixed |
| 3 | Products | `Two shade collections, inspired by nature.` | `Two Shade Collections, Inspired by Nature` | ✓ Fixed |
| 4 | Sustainability | `One Resource. A Wider Material Cycle` | `One Resource — A Wider Material Cycle` | ✓ Fixed |
| 5 | 404 | `This wall hasn't been painted yet.` | `This Wall Hasn't Been Painted Yet` | ✓ Fixed |

### Full heading scan results

| Check | PHP files | Generated HTML | build-static.mjs |
|---|---|---|---|
| Terminal full stops | 0 | 0 | 0 |
| Full stops anywhere in headings | 0 | 0 | 0 |
| Trailing whitespace | 0 | 0 | 0 |
| Leading whitespace | 0 | 0 | 0 |

**Result**: Zero heading defects across all 14 routes in both PHP and static output.

## 2. Asset Provenance Correction

- `ASSET_PROVENANCE.md` V29 section corrected: WebP files in
  `source-assets/client-originals/2026-11-14-update/` are explicitly labelled
  as optimized quality-95 derivatives, NOT byte-identical originals.
- Original PNG byte streams are NOT in this repository.
- `ASSET_MANIFEST.csv` and `READ_ME_FIRST_ZAI.txt` copied to
  `source-assets/client-originals/2026-11-14-update/` for provenance.
- Original filenames and SHA-256 hashes are recorded in the manifest.
- JPEG files and existing WebP carousel files are byte-for-byte originals.
- Both DOCX files are byte-for-byte originals.

## 3. Mobile QA Results

### 390×844 (iPhone 14 Pro)

| Route | Console errors | Horizontal overflow | Result |
|---|---|---|---|
| Home | 0 | ok | PASS |
| About / Our Story | 0 | ok | PASS |
| Products | 0 | ok | PASS |
| Distemper | 0 | ok | PASS |
| Emulsion | 0 | ok | PASS |
| Why Prakritik | 0 | ok | PASS |
| Colours | 0 | ok | PASS |
| Sustainability | 0 | ok | PASS |
| Innovation | 0 | ok | PASS |
| For Business | 0 | ok | PASS |
| Paint Calculator | 0 | ok | PASS |
| Downloads | 0 | ok | PASS |
| Contact | 0 | ok | PASS |
| 404 | 0 | ok | PASS |

### 360×800 (small Android)

| Route | Console errors | Horizontal overflow | Result |
|---|---|---|---|
| Home | 0 | ok | PASS |
| About / Our Story | 0 | ok | PASS |
| Products | 0 | ok | PASS |
| Distemper | 0 | ok | PASS |
| Emulsion | 0 | ok | PASS |
| Why Prakritik | 0 | ok | PASS |
| Colours | 0 | ok | PASS |
| Sustainability | 0 | ok | PASS |
| Innovation | 0 | ok | PASS |
| For Business | 0 | ok | PASS |
| Paint Calculator | 0 | ok | PASS |
| Downloads | 0 | ok | PASS |
| Contact | 0 | ok | PASS |
| 404 | 0 | ok | PASS |

### Desktop recheck (1440×900)

- Homepage: 0 heading full stops, 0 console errors
- Our Story: 0 heading full stops, 0 console errors

## 4. Screenshots

22 screenshots captured in `qa-screenshots/v30/`:
- 14 desktop screenshots (1440×900, full page)
- 8 mobile screenshots (390×844, full page) for key routes

## 5. Build Verification

- `node build-static.mjs`: 14 HTML files generated, exit 0
- All asset references resolve: 0 missing
- PHP/static heading parity: verified (both 0 defects)

## 6. Defects Found and Fixed

1. 5 headings with full stops → fixed with corrected wording
2. 46 headings with trailing whitespace → all trimmed
3. ASSET_PROVENANCE.md incorrectly claimed WebP files were byte-identical
   originals → corrected to explicitly label them as optimized derivatives
4. ASSET_MANIFEST.csv was not in the repo tree → copied to
   `source-assets/client-originals/2026-11-14-update/`

## 7. No Defects Found

- No horizontal overflow on any route at any tested viewport
- No broken navigation
- No cropped images
- No overlapping text
- No inconsistent section spacing
- No clipped headings
- No broken buttons or forms
- No mobile image focal-point problems
