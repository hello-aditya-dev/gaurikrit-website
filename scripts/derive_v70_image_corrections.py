#!/usr/bin/env python3
"""V70 — Derive responsive variants for the four PDF image corrections (p4/p5/p6/p8).

Sources (untouched originals from the client's 2026-11 ZIP, in
/home/z/my-project/gaurikrit-work/new-content/Website Content/):
  GBP Paint Bucket-3.png        -> p4: two-bucket pair  (Distemper + Emulsion, side-by-side)
  GBP Paint Bucket-1.png        -> p5: three-bucket trio (center Distemper, flanked by two Emulsion,
                                  on a wooden floor against a whitewashed brick wall)
  GBP Paint Bucket-2.png        -> p6: clean single Emulsion-bucket render (portrait)
  Golden Morning Cattle Yard.png -> p8: rural cattle yard with thatched-roof open sheds,
                                  green trees/foliage, blue sky (NO visible dung pile)

Outputs (avif + webp + jpg ladder, matching the V19/V20/V29 ecosystem image system):
  dist-hostinger/assets/images/ecosystem/<stem>-<W>.{avif,webp,jpg}
  source-assets/client-derived/2026-11-v70-image-corrections/   (archive copy)
  source-assets/client-derived/2026-11-v70-image-corrections/manifest.json

POLICY (per task rules and existing derive_v29_assets.py pattern):
  - NO upscaling. Each rung is capped at the native long edge. If a rung
    equals the native width, the original pixels are used verbatim.
  - Files are named by their ACTUAL pixel WIDTH so the w-descriptor in
    <source srcset="... Ww"> is always truthful.
  - avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.
  - RGBA PNGs are flattened to RGB on a white background so transparent
    pixels (the black-bg cutouts in the bucket PNGs) don't surprise us.
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
CONTENT_DIR = Path('/home/z/my-project/gaurikrit-work/new-content/Website Content')
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-v70-image-corrections'
PUBLIC_HOST = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
PUBLIC_DOCS = ROOT / 'docs' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC_HOST.mkdir(parents=True, exist_ok=True)
PUBLIC_DOCS.mkdir(parents=True, exist_ok=True)

# (stem, source filename, target widths — capped at native width, never upscaled)
ITEMS = [
    # p4 — Why-Prakritik material-steps card 02: two-bucket side-by-side group
    # on a plain dark background. Native 1772x888 (landscape 2:1).
    ('gbp-bucket-pair-v70',   'GBP Paint Bucket-3.png',         [640, 960, 1280, 1536]),
    # p5 — Why-Prakritik Two Formats block: three-bucket group (Emulsion |
    # Distemper | Emulsion) on a wooden floor against a whitewashed brick
    # wall. Native 1536x1024 (landscape 3:2).
    ('gbp-bucket-trio-v70',   'GBP Paint Bucket-1.png',         [640, 960, 1280, 1536]),
    # p6 — Prakritik Emulsion product detail hero: clean single Emulsion
    # bucket render (portrait). Native 1122x1402 — capped at 960 wide.
    ('prakritik-emulsion-solo-v70', 'GBP Paint Bucket-2.png',   [640, 960]),
    # p8 — Homepage Stage 01 Cow Dung card: rural cattle yard with
    # thatched-roof open sheds, green trees/foliage, blue sky — NO visible
    # dung pile. Native 1672x941 (landscape ~16:9).
    ('cattle-yard-v70',       'Golden Morning Cattle Yard.png', [640, 960, 1280, 1536]),
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
for stem, src_name, rungs in ITEMS:
    src_path = CONTENT_DIR / src_name
    if not src_path.exists():
        print(f'MISSING original: {src_path}')
        continue
    im = Image.open(src_path)
    # Flatten RGBA onto white so transparent cutouts don't surprise us.
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
