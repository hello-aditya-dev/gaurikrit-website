#!/usr/bin/env python3
"""Prepare V22 client assets from the 2026-10-29 OneDrive batch.

Sources (untouched originals, preserved verbatim):
  source-assets/client-originals/2026-10-29-update/

Outputs (avif + webp + jpg ladder, matching the V19/V20 ecosystem image system):
  dist-hostinger/assets/images/ecosystem/<stem>-<W>.{avif,webp,jpg}
  source-assets/client-derived/2026-10-29/             (archive copy)
  source-assets/client-derived/2026-10-29/manifest.json

POLICY (per task rules):
  - NO upscaling. Each rung is capped at the native long edge. If a rung
    equals the native width, the original pixels are used verbatim.
  - Files are named by their ACTUAL pixel WIDTH so the w-descriptor in
    <source srcset="... Ww"> is always truthful.
  - avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.
  - Never re-encode derivatives from other derivatives — always resize
    from the preserved original.

Stem -> source mapping (verified by VLM inspection):
  CAROUSEL (hero showcase, 4 landscape client artworks ~16:9):
    carousel-eco-paints          <- Gaurikrit_Eco_Paints_1920x1080.webp
    carousel-bio-briquettes      <- Gaurikrit_Bio_Briquettes_1920x1080.webp
    carousel-cow-dung-logs       <- Gaurikrit_Cow_Dung_Logs.png (1672x941)
    carousel-eco-utility-products<- Gaurikrit_Eco_Utility_Products_1920x1080.webp
  FLOW (four-stage "From Waste to Resource"):
    flow-cow-dung      <- Cow-Dung pile-3.png (real photograph, no text)
    flow-processing    <- Natural waste processing.png (conceptual visual)
    flow-impact        <- Earth globe with green leaf arrows-4.png (3D render)
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals' / '2026-10-29-update'
CAROUSEL_DIR = ORIG / 'Gaurikrit_Final_4_Carousel_Images'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-10-29'
PUBLIC = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC.mkdir(parents=True, exist_ok=True)

# (stem, source path, target widths — capped at native width, never upscaled)
ITEMS = [
    # Hero carousel — the four final client-selected landscape artworks.
    ('carousel-eco-paints',           CAROUSEL_DIR / 'Gaurikrit_Eco_Paints_1920x1080.webp',        [640, 960, 1280, 1920]),
    ('carousel-bio-briquettes',       CAROUSEL_DIR / 'Gaurikrit_Bio_Briquettes_1920x1080.webp',     [640, 960, 1280, 1920]),
    ('carousel-cow-dung-logs',        CAROUSEL_DIR / 'Gaurikrit_Cow_Dung_Logs.png',                [640, 960, 1280]),
    ('carousel-eco-utility-products', CAROUSEL_DIR / 'Gaurikrit_Eco_Utility_Products_1920x1080.webp', [640, 960, 1280, 1920]),
    # Four-stage flow imagery.
    ('flow-cow-dung',   ORIG / 'Cow-Dung pile-3.png',                        [640, 960, 1280]),
    ('flow-processing', ORIG / 'Natural waste processing.png',               [640, 960]),
    ('flow-impact',     ORIG / 'Earth globe with green leaf arrows-4.png',   [640, 960]),
]


def save_variant(variant, stem, width, out_dir):
    """Write avif + webp + jpg for a single resized variant."""
    try:
        variant.save(str(out_dir / f'{stem}-{width}.avif'),
                     format='AVIF', quality=58, speed=6)
    except Exception as exc:  # pragma: no cover - environment fallback
        print(f'  ! avif failed for {stem}-{width}: {exc}')
    variant.save(str(out_dir / f'{stem}-{width}.webp'),
                 format='WEBP', quality=82, method=6)
    variant.save(str(out_dir / f'{stem}-{width}.jpg'),
                 format='JPEG', quality=87, optimize=True, progressive=True)


manifest = []
for stem, src_path, rungs in ITEMS:
    if not src_path.exists():
        print(f'MISSING original: {src_path}')
        continue
    im = Image.open(src_path).convert('RGB')
    native_w = im.size[0]
    print(f'{stem}: native {im.size[0]}x{im.size[1]}')
    seen = set()
    widths = []
    for target in rungs:
        w = min(target, native_w)  # cap — never upscale
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
        save_variant(variant, stem, w, PUBLIC)
        save_variant(variant, stem, w, DERIVED)
        print(f'  -> {stem}-{w}.{{avif,webp,jpg}}  ({variant.size[0]}x{variant.size[1]})')
    manifest.append({
        'stem': stem,
        'source': str(src_path.relative_to(ROOT)),
        'widths': widths,
        'intrinsic': list(im.size),
    })

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print('\nWROTE manifest.json:')
print(json.dumps(manifest, indent=2))
