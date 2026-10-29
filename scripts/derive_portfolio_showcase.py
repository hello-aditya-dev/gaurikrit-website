#!/usr/bin/env python3
"""Derive responsive variants for the Stage 03 Product Portfolio showcase.

Source (preserved verbatim, never modified):
  source-assets/client-originals/2026-10-29-update/GBP Futureline Products Showcase-2.png

The client request named this asset "Biodegradable Product Showcase.png".
The exact filename is not present in any shared folder we can access; the
closest content match (a comprehensive 2x2 biodegradable utility-products
showcase: Dhoop Cups, Cow-Dung Diyas, Biodegradable Plates, Eco Glasses)
is "GBP Futureline Products Showcase-2.png". This substitution is
documented in ASSET_PROVENANCE.md and the final report.

Outputs (avif + webp + jpg ladder, capped at native width, never upscaled):
  dist-hostinger/assets/images/ecosystem/flow-portfolio-<W>.{avif,webp,jpg}
  source-assets/client-derived/2026-10-29-fixes/flow-portfolio-<W>.{avif,webp,jpg}
"""
from pathlib import Path
from PIL import Image
import hashlib, json

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / 'source-assets' / 'client-originals' / '2026-10-29-update' / 'GBP Futureline Products Showcase-2.png'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-10-29-fixes'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

with open(SRC, 'rb') as fh:
    sha = hashlib.sha256(fh.read()).hexdigest()

im = Image.open(SRC).convert('RGB')
native_w = im.size[0]
print(f'Source: {SRC.name}')
print(f'  intrinsic {im.size[0]}x{im.size[1]}  sha256={sha}')
print(f'  file size: {SRC.stat().st_size} bytes')

STEM = 'flow-portfolio'
RUNGS = [640, 960]
widths = []
seen = set()
for target in RUNGS:
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
    for out_dir in (PUBLIC, DERIVED):
        variant.save(str(out_dir / f'{STEM}-{w}.avif'), format='AVIF', quality=58, speed=6)
        variant.save(str(out_dir / f'{STEM}-{w}.webp'), format='WEBP', quality=82, method=6)
        variant.save(str(out_dir / f'{STEM}-{w}.jpg'), format='JPEG', quality=87, optimize=True, progressive=True)
    print(f'  -> {STEM}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')

# Also copy the original into client-derived archive (byte-for-byte) and
# into dist-hostinger/assets/images/client/ as a PNG fallback.
import shutil
client_dir = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'client'
client_dir.mkdir(parents=True, exist_ok=True)
archive_png = DERIVED / 'biodegradable-product-showcase-original.png'
shutil.copyfile(SRC, archive_png)
print(f'  archived original -> {archive_png.relative_to(ROOT)}')

manifest_path = DERIVED / 'manifest.json'
existing = json.loads(manifest_path.read_text()) if manifest_path.exists() else {}
existing['flow-portfolio'] = {
    'source': str(SRC.relative_to(ROOT)),
    'client_request_name': 'Biodegradable Product Showcase.png',
    'substitution_note': 'Exact filename not present in shared folders; GBP Futureline Products Showcase-2.png is the closest content match (comprehensive 2x2 biodegradable utility-products showcase).',
    'intrinsic': list(im.size),
    'sha256': sha,
    'widths': widths,
    'outputs': [f'dist-hostinger/assets/images/ecosystem/{STEM}-{w}.{ext}' for w in widths for ext in ('avif','webp','jpg')],
}
manifest_path.write_text(json.dumps(existing, indent=2))
print(f'\nUpdated {manifest_path.relative_to(ROOT)}')
