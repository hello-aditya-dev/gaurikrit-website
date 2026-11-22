#!/usr/bin/env python3
"""V78 — Handover finishing corrections (Nov-17 PDF Part 1 & Part 2).

Two outstanding image corrections that are NOT already satisfied by V70–V77:

  1. colours-wall  (Part 1 p1–p3 compliance)
     The current colours-wall is a textured stucco interior scene. The client's
     Nov-17 correction states: "We can't use textured wall illustration. It has
     be a plain fresh painted wall." Replace with the plain freshly-painted
     Pearl Cream wall from the 2026-11-14 ZIP (wall-8 Pearl cream.png, native
     1672x941). No upscaling — the ladder is capped at 1600 (<= native 1672).

  2. story-farmer-cow-14  (Part 2 p4 — About/Story Section 1 image)
     The About Section 1 image currently uses story-farmer-cow-4 (derived from
     Img Frmr-4.jpeg — overcast/hazy). The Nov-17 Part 2 p4 correction swaps it
     for the GOLDEN-HOUR version of the same scene: Img Frmr-14.png (man in grey
     hoodie crouching, holding a light-brown cow's face, green tarpaulin hut,
     golden hour light). Native 1199x1312 (portrait). New stem
     story-farmer-cow-14; the about template is updated to reference it.

Outputs (avif + webp + jpg ladder, matching the V19/V70/V76 ecosystem system):
  dist-hostinger/assets/images/ecosystem/<stem>-<W>.{avif,webp,jpg}
  docs/assets/images/ecosystem/<stem>-<W>.{avif,webp,jpg}
  source-assets/client-derived/2026-11-v78-handover-corrections/  (archive + manifest.json)

POLICY (same as derive_v70 / derive_v76):
  - NO upscaling. Each rung capped at native long edge.
  - Files named by ACTUAL pixel width so the w-descriptor is truthful.
  - avif q=58 / speed=6, webp q=82 / method=6, jpg q=87 progressive.
  - RGBA flattened to RGB on white.
"""
from pathlib import Path
from PIL import Image
import json

ROOT = Path(__file__).resolve().parents[1]
SRC_DIR = ROOT / 'source-assets' / 'client-originals' / '2026-11-14-update'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-v78-handover-corrections'
PUBLIC_HOST = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
PUBLIC_DOCS = ROOT / 'docs' / 'assets' / 'images' / 'ecosystem'
DERIVED.mkdir(parents=True, exist_ok=True)
PUBLIC_HOST.mkdir(parents=True, exist_ok=True)
PUBLIC_DOCS.mkdir(parents=True, exist_ok=True)

# (stem, source filename, target widths — capped at native width, never upscaled)
ITEMS = [
    # Part 1 p1-p3: plain freshly-painted Pearl Cream wall replaces textured
    # colours-wall. Native 1672x941 (landscape ~16:9). Ladder capped at 1600.
    ('colours-wall', 'wall-8 Pearl cream.png', [640, 960, 1280, 1600]),
    # Part 2 p4: golden-hour farmer-with-cow for About Section 1. Native
    # 1199x1312 (portrait). Ladder [640, 864] (864 <= 1199).
    ('story-farmer-cow-14', 'Img Frmr-14.png', [640, 864]),
]


def save_variant(variant, stem, width, out_dir):
    """Write avif + webp + jpg for a single resized variant."""
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
    src_path = SRC_DIR / src_name
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
