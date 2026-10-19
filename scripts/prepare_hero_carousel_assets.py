#!/usr/bin/env python3
"""Prepare V20 hero-carousel assets from the 2026-10-16 client posters.

Sources (untouched originals, already in the repo):
  source-assets/client-originals/WhatsApp Image 2026-10-16 at *.jpeg

Outputs (avif + webp + jpg ladder, matching the V19 ecosystem image system):
  dist-hostinger/assets/images/ecosystem/hero-<slug>-<W>.{avif,webp,jpg}
  source-assets/client-derived/hero/                     (archive copy)
  source-assets/client-derived/hero/manifest.json        (widths per slide)

POLICY (per task rules):
  - NO upscaling. Each slide gets 2 responsive rungs: long-edge 640 and
    native-max capped at 1280. If a rung equals the native long edge, the
    original pixels are used verbatim.
  - Files are named by their actual pixel WIDTH so the w-descriptor in
    <source srcset="... Ww"> is always accurate (important for the portrait
    poster whose width differs from its long edge).
  - avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.

Slide -> source mapping (verified by VLM):
  hero-eco-paints            <- 3 Prakritik Paint buckets (Emulsion/Emulsion/Distemper)
  hero-bio-coal-logs        <- Gaurikrit BIO-BRIQUETTES (cylindrical hollow briquettes)
  hero-cow-dung-logs        <- Gaurikrit COW-DUNG LOGS (premium biomass fuel)
  hero-eco-utility-products <- Gaurikrit ECO UTILITY PRODUCTS (dhoop/diyas/plates/cups)
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals'
DERIVED = ROOT / 'source-assets' / 'client-derived' / 'hero'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

SLIDES = [
    ('hero-eco-paints',            'WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg'),
    ('hero-bio-coal-logs',         'WhatsApp Image 2026-10-16 at 7.45.05 AM.jpeg'),
    ('hero-cow-dung-logs',         'WhatsApp Image 2026-10-16 at 7.45.05 AM (1).jpeg'),
    ('hero-eco-utility-products',  'WhatsApp Image 2026-10-16 at 7.45.05 AM (2).jpeg'),
]

# Long-edge targets; never upscale (capped at native long edge at runtime).
RUNGS = [640, 1280]


def save_variant(variant, stem, width, out_dir):
    """Write avif + webp + jpg for a single resized variant."""
    # avif — pillow-heif plugin (quality / speed kwargs)
    try:
        variant.save(str(out_dir / f'{stem}-{width}.avif'),
                     format='AVIF', quality=58, speed=6)
    except Exception as exc:  # pragma: no cover - environment fallback
        print(f'  ! avif failed for {stem}-{width}: {exc}')
    # webp
    variant.save(str(out_dir / f'{stem}-{width}.webp'),
                 format='WEBP', quality=82, method=6)
    # jpg
    variant.save(str(out_dir / f'{stem}-{width}.jpg'),
                 format='JPEG', quality=87, optimize=True, progressive=True)


manifest = []
for stem, fname in SLIDES:
    src = ORIG / fname
    if not src.exists():
        print(f'MISSING original: {src}')
        continue
    im = Image.open(src).convert('RGB')
    native_long = max(im.size)
    print(f'{stem}: native {im.size[0]}x{im.size[1]} (long edge {native_long})')
    seen = set()
    widths = []
    for target in RUNGS:
        le = min(target, native_long)  # cap — never upscale
        if le == native_long:
            variant = im
        else:
            scale = le / native_long
            new = (round(im.size[0] * scale), round(im.size[1] * scale))
            variant = im.resize(new, Image.LANCZOS)
        w = variant.size[0]
        if w in seen:
            continue
        seen.add(w)
        widths.append(w)
        save_variant(variant, stem, w, PUBLIC)
        save_variant(variant, stem, w, DERIVED)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')
    manifest.append({
        'stem': stem,
        'widths': widths,
        'intrinsic': list(im.size),
    })

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print('\nWROTE manifest.json:')
print(json.dumps(manifest, indent=2))
