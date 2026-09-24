# Image Handoff — Gaurikrit Website

This document defines the exact paths for official visual assets that will be
inserted later by ChatGPT Work. The website is built so that each asset path
has a coded SVG fallback. When the official file is dropped in, the JS image-
handoff system automatically shows it instead of the fallback — no redesign
required.

## Asset paths

### 1. `/assets/brand/gaurikrit-logo-full.png`
- **Used in:** Header (desktop), footer, About page, mobile menu
- **Recommended:** Transparent PNG, high resolution (≥ 240×80px), landscape orientation
- **Fallback:** Coded cow-mark emblem (`includes/illustrations/gaurikrit-cow-mark.php`) + "Gaurikrit" typography
- **Handoff element:** `.brand__mark[data-official-image]`

### 2. `/assets/brand/gaurikrit-logo-mark.png`
- **Used in:** Favicon, header mark (mobile), footer mark
- **Recommended:** Transparent PNG, square (≥ 72×72px), the cow-head emblem only
- **Fallback:** `includes/illustrations/gaurikrit-cow-mark.php`
- **Handoff element:** `.brand__mark[data-official-image]`

### 3. `/assets/products/prakritik-distemper.png`
- **Used in:** Homepage two-products panel, products overview, Distemper product page
- **Recommended:** Transparent PNG, product cut-out (packaging isolated), square or portrait
- **Fallback:** `includes/illustrations/prakritik-distemper-bucket.php`
- **Handoff element:** `.product-media[data-official-image]`

### 4. `/assets/products/prakritik-emulsion.png`
- **Used in:** Homepage two-products panel, products overview, Emulsion product page
- **Recommended:** Transparent PNG, product cut-out, square or portrait
- **Fallback:** `includes/illustrations/prakritik-emulsion-bucket.php`
- **Handoff element:** `.product-media[data-official-image]`

### 5. `/assets/products/prakritik-group.png`
- **Used in:** Homepage hero (right composition)
- **Recommended:** Transparent PNG, both products grouped, landscape orientation
- **Fallback:** Coded emulsion-bucket SVG + cow + paint-stroke composition
- **Handoff element:** `.product-media[data-official-image]` in `.hero__art`

### 6. `/assets/documents/prakritik-paint-brochure.pdf`
- **Used in:** Downloads page
- **Recommended:** Standard PDF, product brochure
- **Fallback:** "Contact Gaurikrit for the current product brochure." text (no broken link)
- **Detection:** PHP `is_file()` server-side + JS brochure-detection module

### 7. `/assets/documents/prakritik-paint-brochure-cover.png`
- **Used in:** Downloads page brochure cover
- **Recommended:** PNG, brochure cover image, landscape or portrait
- **Fallback:** Coded paper/brochure SVG composition
- **Handoff element:** `.product-media[data-official-image]`

## How the handoff works

Every image region uses this pattern:

```html
<div class="product-media" data-official-image="/assets/products/example.png">
    <img class="product-media__official" src="/assets/products/example.png"
         alt="Example" width="400" height="400">
    <div class="product-media__fallback">
        <!-- coded SVG illustration -->
    </div>
</div>
```

JavaScript (`assets/js/app.js` → `initImageHandoff()`):
- On `<img>` `load`: sets `data-loaded="true"` on the container → shows official image, hides fallback.
- On `<img>` `error`: hides the `<img>`, shows the fallback SVG.
- Handles cached images (already loaded before JS runs).
- No layout shift (dimensions reserved on the `<img>`).

## Testing

1. **With all assets absent:** the site must look finished using SVG fallbacks.
2. **With a dummy file added to each path:** the official image must replace the fallback with no layout shift.
3. **With the brochure PDF absent:** no broken download button — the "Contact Gaurikrit" message shows.
4. **With the brochure PDF present:** "View Brochure" + "Download PDF" buttons appear.
