#!/usr/bin/env python3
"""V29 — Derive responsive variants for new story + Stage 03 assets."""
from pathlib import Path
from PIL import Image
import hashlib, json, os

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals' / '2026-11-14-update'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-14-update'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

# (stem, source_filename, target_widths)
ITEMS = [
    # Homepage Stage 03 — Biodegradable Product Showcase (replaces Showcase-2)
    ('flow-portfolio', 'Biodegradable Product Showcase.webp', [640, 960, 1254]),
    # Story images
    ('story-gir-cow-calf', 'Golden-Hour Gir Cow and Calf-2.webp', [640, 960, 1254]),
    ('story-tender-moment', 'Tender Moment with a Resting Cow.webp', [640, 960, 1224]),
    ('story-product-showcase', 'Biodegradable Product Showcase.webp', [640, 960, 1254]),
    ('story-cattle-shelter', 'story1.1-cattle-shelter-embedded.png', [640, 960, 1028]),
    ('story-campus', 'story1.1-campus-embedded.jpeg', [640, 960, 1101]),
    # Also generate from the standalone campus images for inventory
    ('campus-sunrise', 'Gaurikrit Sustainable Bioproducts Campus at Sunrise.webp', [640, 960, 1280, 1672]),
    ('bio-products-sunrise', 'Gaurikrit Bio Products at Sunrise.webp', [640, 960, 1280, 1672]),
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
        if w in seen: continue
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

manifest_path = DERIVED / 'manifest.json'
manifest_path.write_text(json.dumps(manifest, indent=2))
print(f'\nWrote {manifest_path.relative_to(ROOT)}')
