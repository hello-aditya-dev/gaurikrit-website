#!/usr/bin/env python3
"""V73 — Derive responsive variants for the PDF p9 Section 1 story image.

Source (untouched original from the client's 2026-11 ZIP):
  Img Frmr-1.png  -> man in maroon jacket with cow under bare tree
                    (matches PDF p9 Image C — Section 1 of Our Story page)

Native 1224x1285 (nearly square). Capped rungs: 640, 960, 1224.

Outputs (avif + webp + jpg ladder, matching the V29/V70 ecosystem image system):
  dist-hostinger/assets/images/ecosystem/story-farmer-maroon-<W>.{avif,webp,jpg}
  docs/assets/images/ecosystem/story-farmer-maroon-<W>.{avif,webp,jpg}
  source-assets/client-derived/2026-11-v73-story-farmer-maroon/

POLICY (per task rules and existing derive_v29_assets.py pattern):
  - NO upscaling. Each rung is capped at the native long edge.
  - avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.
  - RGBA PNGs are flattened to RGB on a white background.
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
CONTENT_DIR = Path('/home/z/my-project/gaurikrit-work/new-content/Website Content')
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-v73-story-farmer-maroon'
PUBLIC_HOST = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
PUBLIC_DOCS = ROOT / 'docs' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC_HOST.mkdir(parents=True, exist_ok=True)
PUBLIC_DOCS.mkdir(parents=True, exist_ok=True)

ITEMS = [
    ('story-farmer-maroon', 'Img Frmr-1.png', [640, 960, 1224]),
]


def save_variant(variant, stem, width, out_dir):
    try:
        variant.save(str(out_dir / f'{stem}-{width}.avif'),
                     format='AVIF', quality=58, speed=6)
    except Exception as exc:
        print(f'  ! avif failed for {stem}-{width}: {exc}')
    variant.save(str(out_dir / f'{stem}-{width}.webp'),
                 format='WEBP', quality=82, method=6)
    variant.save(str(out_dir / f'{stem}-{width}.jpg'),
                 format='JPEG', quality=87, optimize=True, progressive=True)


manifest = []
for stem, src_name, rungs in ITEMS:
    src_path = CONTENT_DIR / src_name
    if not src_path.exists():
        print(f'MISSING original: {src_path}')
        continue
    im = Image.open(src_path)
    if im.mode in ('RGBA', 'LA') or (im.mode == 'P' and 'transparency' in im.info):
        bg = Image.new('RGB', im.size, (255, 255, 255))
        im = im.convert('RGBA')
        bg.paste(im, mask=im.split()[-1])
        im = bg
    else:
        im = im.convert('RGB')
    native_w = im.size[0]
    print(f'{stem}: native {im.size[0]}x{im.size[1]}  src={src_name}')
    seen = set()
    widths = []
    for target in rungs:
        w = min(target, native_w)
        if w == native_w:
            variant = im
        else:
            scale = w / native_w
            new = (w, round(im.size[1] * scale))
            variant = im.resize(new, Image.LANCZOS)
        w = variant.size[0]
        if w in seen:
            continue
        seen.add(w)
        widths.append(w)
        save_variant(variant, stem, w, PUBLIC_HOST)
        save_variant(variant, stem, w, PUBLIC_DOCS)
        save_variant(variant, stem, w, DERIVED)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')
    manifest.append({
        'stem': stem,
        'source': str(src_path),
        'source_name': src_name,
        'widths': widths,
        'intrinsic': list(im.size),
    })

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print('\nWROTE manifest.json:')
print(json.dumps(manifest, indent=2))
