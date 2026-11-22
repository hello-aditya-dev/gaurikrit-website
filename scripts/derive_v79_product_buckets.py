#!/usr/bin/env python3
"""V79 — Distemper & Emulsion product images from the 2026-11-14 ZIP.

The products page chapter cards and the Distemper detail page were still using
older product cutouts / a landscape duo image. The client's ZIP supplies the
definitive single-bucket renders:

  GBP Paint Bucket-4.png  -> single Distemper bucket (blue label), 1269x1240
  GBP Paint Bucket-2.png  -> single Emulsion bucket (yellow-green label), 1122x1402

Outputs:
  1. client/prakritik-distemper-single-cut.{png,webp}  <- Bucket-4 (RGBA preserved)
     client/prakritik-emulsion-single-cut.{png,webp}   <- Bucket-2 (RGBA preserved)
     These feed the products page chapter cards via $PRODUCTS officialImage.
  2. ecosystem/prakritik-distemper-solo-v79-{640,960}.{avif,webp,jpg} <- Bucket-4
     Flattened to white (RGB). Feeds the Distemper detail page, parallel to the
     existing prakritik-emulsion-solo-v70 (Bucket-2) used on the Emulsion detail.

Written to both dist-hostinger/ and docs/ asset trees; archived under
source-assets/client-derived/2026-11-v79-product-buckets/ with manifest.json.

POLICY: no upscaling (rungs capped at native). avif q58/s6, webp q82/m6, jpg q87.
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / 'source-assets' / 'client-originals' / '2026-11-14-update'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-v79-product-buckets'
CLIENT_HOST = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'client'
CLIENT_DOCS = ROOT / 'docs' / 'assets' / 'images' / 'client'
ECO_HOST = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
ECO_DOCS = ROOT / 'docs' / 'assets' / 'images' / 'ecosystem'
for d in (DERIVED, CLIENT_HOST, CLIENT_DOCS, ECO_HOST, ECO_DOCS):
    d.mkdir(parents=True, exist_ok=True)

manifest = []


def save_rgba(im, stem, out_dir):
    """Write PNG + WebP preserving RGBA transparency (product cutouts)."""
    im.save(str(out_dir / f'{stem}.png'), format='PNG')
    im.save(str(out_dir / f'{stem}.webp'), format='WEBP', quality=90, method=6, lossless=False)


def save_rgb_variant(variant, stem, width, out_dir):
    """Write avif + webp + jpg (flattened to white) for the ecosystem ladder."""
    try:
        variant.save(str(out_dir / f'{stem}-{width}.avif'), format='AVIF', quality=58, speed=6)
    except Exception as exc:
        print(f'  ! avif failed for {stem}-{width}: {exc}')
    variant.save(str(out_dir / f'{stem}-{width}.webp'), format='WEBP', quality=82, method=6)
    variant.save(str(out_dir / f'{stem}-{width}.jpg'), format='JPEG', quality=87, optimize=True, progressive=True)


# ---- 1. Single-cut product cutouts (client/) — RGBA preserved ----
CUTS = [
    ('prakritik-distemper-single-cut', 'GBP Paint Bucket-4.png'),
    ('prakritik-emulsion-single-cut', 'GBP Paint Bucket-2.png'),
]
for stem, src_name in CUTS:
    src = SRC / src_name
    if not src.exists():
        print(f'MISSING: {src}')
        continue
    im = Image.open(src).convert('RGBA')
    print(f'{stem}: {im.size} RGBA  src={src_name}')
    save_rgba(im, stem, CLIENT_HOST)
    save_rgba(im, stem, CLIENT_DOCS)
    save_rgba(im, stem, DERIVED)
    manifest.append({'stem': stem, 'kind': 'cutout', 'source': src_name, 'size': list(im.size), 'mode': 'RGBA'})

# ---- 2. Distemper solo ecosystem ladder (Bucket-4) — flattened to white ----
SOLO = [('prakritik-distemper-solo-v79', 'GBP Paint Bucket-4.png', [640, 960])]
for stem, src_name, rungs in SOLO:
    src = SRC / src_name
    im = Image.open(src)
    if im.mode in ('RGBA', 'LA') or (im.mode == 'P' and 'transparency' in im.info):
        bg = Image.new('RGB', im.size, (255, 255, 255))
        im = im.convert('RGBA')
        bg.paste(im, mask=im.split()[-1])
        im = bg
    else:
        im = im.convert('RGB')
    native_w = im.size[0]
    print(f'{stem}: {im.size} RGB  src={src_name}')
    seen, widths = set(), []
    for target in rungs:
        w = min(target, native_w)
        if w == native_w:
            variant = im
        else:
            scale = w / native_w
            variant = im.resize((w, round(im.size[1] * scale)), Image.LANCZOS)
        w = variant.size[0]
        if w in seen:
            continue
        seen.add(w); widths.append(w)
        save_rgb_variant(variant, stem, w, ECO_HOST)
        save_rgb_variant(variant, stem, w, ECO_DOCS)
        save_rgb_variant(variant, stem, w, DERIVED)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}} ({variant.size[0]}x{variant.size[1]})')
    manifest.append({'stem': stem, 'kind': 'ecosystem-ladder', 'source': src_name, 'widths': widths, 'intrinsic': list(im.size)})

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print('\nWROTE manifest.json:')
print(json.dumps(manifest, indent=2))
