"""V19 — Produce public web derivatives from the 4K masters.

Writes dist-hostinger/assets/images/ecosystem/<name>-<width>.<avif|webp|jpg>

Responsive ladder (only sizes <= master width are produced):
  640, 960, 1280, 1600, 1920, 2560

Formats: AVIF (best), WebP, JPEG fallback. A 390px phone must never
download a 3840px image (§56) — pages reference these with srcset/sizes.

Deterministic; masters are never modified.
"""
from pathlib import Path
import json

from PIL import Image

ROOT = Path(__file__).resolve().parents[1]
MASTERS = ROOT / 'source-assets' / 'masters' / '2026-09-27'
OUT = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
OUT.mkdir(parents=True, exist_ok=True)

SIZES = [640, 960, 1280, 1600, 1920, 2560]

# master name -> max derivative width (cap below master width when the
# display context never needs more)
MASTERS_SPEC = {
    'home-hero-ecosystem-4k.jpg':            {'max': 2560},
    'home-hero-ecosystem-mobile-4k.jpg':     {'max': 1600},
    'eco-paints-pair-4k.jpg':                {'max': 2560},
    'prakritik-distemper-4k.jpg':            {'max': 1600},
    'prakritik-emulsion-4k.jpg':             {'max': 1600},
    'gocast-editorial-4k.jpg':               {'max': 1920},
    'gocast-material-4k.jpg':                {'max': 2560},
    'gocast-context-4k.jpg':                 {'max': 2560},
    'biocoal-editorial-4k.jpg':              {'max': 1920},
    'utility-material-direction-4k.jpg':     {'max': 1920},
    'colours-wall-4k.jpg':                   {'max': 2560},
    'rawmat-4k.jpg':                         {'max': 1920},
    'innovation-research-4k.jpg':            {'max': 2560},
    'material-development-4k.jpg':          {'max': 1920},
}

manifest = {}
for name, spec in MASTERS_SPEC.items():
    stem = name.replace('-4k.jpg', '')
    src = Image.open(MASTERS / name).convert('RGB')
    mw = src.width
    manifest[stem] = {'master': f'source-assets/masters/2026-09-27/{name}',
                      'derivatives': []}
    for w in SIZES:
        if w > spec['max'] or w > mw:
            continue
        r = w / mw
        im = src.resize((w, int(src.height * r)), Image.LANCZOS)
        avif = OUT / f'{stem}-{w}.avif'
        webp = OUT / f'{stem}-{w}.webp'
        jpg = OUT / f'{stem}-{w}.jpg'
        im.save(avif, quality=68, effort=6)       # AVIF: strong compression
        im.save(webp, quality=82, method=6)
        im.save(jpg, quality=84, optimize=True, progressive=True,
                subsampling=1)
        manifest[stem]['derivatives'].append(
            {'w': w, 'h': im.height,
             'avif': avif.stat().st_size, 'webp': webp.stat().st_size,
             'jpg': jpg.stat().st_size})
        print(f'{stem}-{w}: {im.width}x{im.height}')

(MASTERS / 'derivatives-manifest.json').write_text(json.dumps(
    manifest, indent=2))
total = sum(d['avif'] + d['webp'] + d['jpg']
            for v in manifest.values() for d in v['derivatives'])
print(f'\n{sum(len(v["derivatives"]) for v in manifest.values())} '
      f'derivative triplets, {total // 1024} KB total on disk')
