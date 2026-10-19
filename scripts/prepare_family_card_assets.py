#!/usr/bin/env python3
"""Prepare V20 family-card assets for the four-directions section (Part 6).

Upgrades the Bio-Coal and Utility family cards on the homepage from
"representative category visuals" (generic material studies) to REAL
client-supplied product posters (the 2026-10-16 originals). The
family__media--photo frame is a locked 3/2 box with object-fit:cover,
so each source is cropped to a clean 3/2 region that preserves product
identity and the main label text:

  family-bio-coal-logs         <- center 3/2 crop of the bio-briquettes
                                  poster (captures Gaurikrit mark +
                                  BIO-BRIQUETTES title + the briquettes)
  family-eco-utility-products  <- TOP 3/2 crop of the utility poster
                                  (captures ECO UTILITY PRODUCTS header
                                  + the Dhoop Cups and Diyas quadrants)

Outputs (avif + webp + jpg ladder, same V19 system): both the canonical
public tree (dist-hostinger/assets/images/ecosystem/) and the derived
archive (source-assets/client-derived/family-cards/). No upscaling.
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals'
DERIVED = ROOT / 'source-assets' / 'client-derived' / 'family-cards'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

# (stem, source filename, crop anchor)
CROPS = [
    ('family-bio-coal-logs',        'WhatsApp Image 2026-10-16 at 7.45.05 AM.jpeg',     'center'),
    ('family-eco-utility-products', 'WhatsApp Image 2026-10-16 at 7.45.05 AM (2).jpeg', 'top'),
]

TARGET_RATIO = 3 / 2  # width / height


def crop_to_ratio(im, anchor):
    """Return a 3/2 crop of im. anchor in {'center','top'}."""
    w, h = im.size
    target_h = round(w / TARGET_RATIO)
    if target_h >= h:
        # image is wider than 3/2 already; crop width instead
        target_w = round(h * TARGET_RATIO)
        x = (w - target_w) // 2 if anchor == 'center' else 0
        return im.crop((x, 0, x + target_w, h))
    if anchor == 'top':
        y = 0
    else:  # center
        y = (h - target_h) // 2
    return im.crop((0, y, w, y + target_h))


def save_ladder(im, stem, rungs):
    """Save avif+webp+jpg at each width rung (capped at native width)."""
    native_w = im.size[0]
    out_widths = []
    for r in rungs:
        w = min(r, native_w)
        if w in out_widths:
            continue
        out_widths.append(w)
        variant = im if w == native_w else im.resize(
            (w, round(w / TARGET_RATIO)), Image.LANCZOS)
        for fmt, opts in (
            ('avif', dict(quality=58, speed=6)),
            ('webp', dict(quality=82, method=6)),
            ('jpg', dict(quality=87, optimize=True, progressive=True)),
        ):
            for out_dir in (PUBLIC, DERIVED):
                variant.save(str(out_dir / f'{stem}-{w}.{fmt}'),
                             format='AVIF' if fmt == 'avif'
                             else 'WEBP' if fmt == 'webp' else 'JPEG',
                             **opts)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')
    return out_widths


manifest = []
for stem, fname, anchor in CROPS:
    src = ORIG / fname
    if not src.exists():
        print(f'MISSING: {src}')
        continue
    im = Image.open(src).convert('RGB')
    cropped = crop_to_ratio(im, anchor)
    print(f'{stem}: source {im.size[0]}x{im.size[1]} -> crop {cropped.size[0]}x{cropped.size[1]} ({anchor})')
    widths = save_ladder(cropped, stem, [640, 960, 1280])
    manifest.append({'stem': stem, 'widths': widths, 'intrinsic_crop': list(cropped.size), 'anchor': anchor})

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print('\nWROTE manifest.json:')
print(json.dumps(manifest, indent=2))
