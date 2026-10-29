#!/usr/bin/env python3
"""V23 — Derive responsive variants for underused client assets.

Generates derivatives for 7 assets not yet meaningfully used on the site:
  gbp-bio-briquettes    <- GBP Bio-Briquettes.jpeg (1024x1024)
  gbp-cow-dung-logs     <- GBP Cow-Dung Logs.jpeg (1024x1024)
  showcase-utility      <- GBP Futureline Products Showcase-1.png (1022x1095)
  showcase-innovation   <- GBP Futureline Products Showcase-3.png (1254x1254)
  products-banner       <- GBP Products Banner.png (1536x1024)
  journey-greener       <- From Cow Dung to a Greener Future.png (1672x941)
  journey-sustainable   <- From Cow Dung to Sustainable Solutions-1.png (1983x793)

All derivatives capped at native width (no upscaling).
avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.
"""
from pathlib import Path
from PIL import Image
import hashlib, json

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals' / '2026-10-29-update'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-10-29-fixes'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

ITEMS = [
    # (stem, source_filename, target_widths)
    ('gbp-bio-briquettes',   'GBP Bio-Briquettes.jpeg',                    [640, 960, 1024]),
    ('gbp-cow-dung-logs',    'GBP Cow-Dung Logs.jpeg',                     [640, 960, 1024]),
    ('showcase-utility',     'GBP Futureline Products Showcase-1.png',     [640, 960, 1022]),
    ('showcase-innovation',  'GBP Futureline Products Showcase-3.png',     [640, 960, 1254]),
    ('products-banner',      'GBP Products Banner.png',                    [640, 960, 1280, 1536]),
    ('journey-greener',      'From Cow Dung to a Greener Future.png',      [640, 960, 1280, 1672]),
    ('journey-sustainable',  'From Cow Dung to Sustainable Solutions-1.png', [640, 960, 1280, 1600, 1983]),
]

manifest = {}
for stem, src_name, rungs in ITEMS:
    src_path = ORIG / src_name
    with open(src_path, 'rb') as f:
        sha = hashlib.sha256(f.read()).hexdigest()
    im = Image.open(src_path).convert('RGB')
    native_w = im.size[0]
    print(f'{stem}: native {im.size[0]}x{im.size[1]}  sha={sha[:16]}')
    widths = []
    seen = set()
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
        seen.add(w)
        widths.append(w)
        for out_dir in [PUBLIC, DERIVED]:
            variant.save(str(out_dir / f'{stem}-{w}.avif'), format='AVIF', quality=58, speed=6)
            variant.save(str(out_dir / f'{stem}-{w}.webp'), format='WEBP', quality=82, method=6)
            variant.save(str(out_dir / f'{stem}-{w}.jpg'), format='JPEG', quality=87, optimize=True, progressive=True)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')
    manifest[stem] = {
        'source': str(src_path.relative_to(ROOT)),
        'source_sha256': sha,
        'intrinsic': list(im.size),
        'widths': widths,
    }

# Update manifest.json
manifest_path = DERIVED / 'manifest.json'
existing = json.loads(manifest_path.read_text()) if manifest_path.exists() else {}
existing.update(manifest)
manifest_path.write_text(json.dumps(existing, indent=2))
print(f'\nUpdated {manifest_path.relative_to(ROOT)}')
