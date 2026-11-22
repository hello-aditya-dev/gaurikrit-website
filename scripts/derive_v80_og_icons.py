#!/usr/bin/env python3
"""V80 — Refresh OG social cards + favicon/app icons.

OG cards (1200x630): regenerates all 13 route cards using the new 2026-11-14 ZIP
product imagery (GBP Paint Bucket-1/2/3/4) and the established card template
(logo mark + headline + tagline + product photo on an accent panel).

Favicon / app icons: regenerated from the official brand mark so the browser
tab, apple-touch and android-chrome icons are crisp and current.

Outputs (both dist-hostinger/ and docs/):
  assets/social/og-<slug>.jpg            (13 cards)
  favicon-16x16.png / favicon-32x32.png / favicon-48x48.png
  apple-touch-icon.png
  android-chrome-192x192.png / android-chrome-512x512.png
"""
from pathlib import Path
from PIL import Image, ImageOps, ImageDraw, ImageFont
import json

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / 'source-assets' / 'client-originals' / '2026-11-14-update'
ECO = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
BRAND = ROOT / 'dist-hostinger' / 'assets' / 'brand'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-11-v80-og-icons'
HOST_SOCIAL = ROOT / 'dist-hostinger' / 'assets' / 'social'
DOCS_SOCIAL = ROOT / 'docs' / 'assets' / 'social'
HOST_ROOT = ROOT / 'dist-hostinger'
DOCS_ROOT = ROOT / 'docs'
DERIVED.mkdir(parents=True, exist_ok=True)
HOST_SOCIAL.mkdir(parents=True, exist_ok=True)
DOCS_SOCIAL.mkdir(parents=True, exist_ok=True)

FONT = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
BOLD = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'


def fit_font(draw, text, max_w, start=69):
    for size in range(start, 30, -1):
        font = ImageFont.truetype(BOLD, size)
        if draw.textbbox((0, 0), text, font=font)[2] <= max_w:
            return font
    return ImageFont.truetype(BOLD, 31)


def load_art(path):
    """Load an image, flatten RGBA onto white for clean OG composition."""
    if not path or not path.exists():
        return None
    im = Image.open(path)
    if im.mode in ('RGBA', 'LA', 'P'):
        im = im.convert('RGBA')
        bg = Image.new('RGB', im.size, (255, 255, 255))
        bg.paste(im, mask=im.split()[-1])
        return bg
    return im.convert('RGB')


def og_card(slug, line1, line2, art_path, bg, accent, out_dir):
    im = Image.new('RGB', (1200, 630), bg)
    d = ImageDraw.Draw(im)
    d.rectangle((0, 0, 24, 630), fill='#173F2B')          # forest strip
    d.rounded_rectangle((720, 28, 1180, 604), radius=18, fill=accent)  # product panel
    art = load_art(art_path)
    if art:
        thumb = ImageOps.contain(art.convert('RGBA'), (404, 492))
        # composite onto the accent panel (flatten so no white box)
        panel_box = Image.new('RGB', thumb.size, accent)
        if thumb.mode == 'RGBA':
            panel_box.paste(thumb, mask=thumb.split()[-1])
        else:
            panel_box = thumb.convert('RGB')
        im.paste(panel_box, (748 + (404 - thumb.width) // 2, 68 + (492 - thumb.height) // 2))
    # logo mark
    mark = Image.open(BRAND / 'gaurikrit-logo-mark.png').convert('RGBA')
    mini = mark.copy(); mini.thumbnail((102, 102), Image.Resampling.LANCZOS)
    im.paste(mini, (69, 47), mini)
    d = ImageDraw.Draw(im)
    d.text((191, 71), 'GAURIKRIT', font=ImageFont.truetype(BOLD, 28), fill='#173F2B')
    d.text((70, 266), line1, font=fit_font(d, line1, 620), fill='#173F2B')
    d.text((70, 350), line2, font=fit_font(d, line2, 620), fill='#173F2B')
    d.line((70, 515, 650, 515), fill='#A38A54', width=2)
    d.text((70, 537), 'Good for Nature. Good for Life.', font=ImageFont.truetype(FONT, 22), fill='#365746')
    im.save(out_dir / f'og-{slug}.jpg', quality=88, optimize=True, progressive=True)


# (slug, line1, line2, art, bg, accent)
BUCKET4 = SRC / 'GBP Paint Bucket-4.png'   # single Distemper (blue)
BUCKET2 = SRC / 'GBP Paint Bucket-2.png'   # single Emulsion (yellow-green)
BUCKET3 = SRC / 'GBP Paint Bucket-3.png'   # pair
BUCKET1 = SRC / 'GBP Paint Bucket-1.png'   # trio on wood floor
CARDS = [
    ('home',           'Gaurikrit',        'Bio Products',             BUCKET1, '#F4EFE2', '#E6BD75'),
    ('products',       'Prakritik Paint',  'Distemper & Emulsion',     BUCKET3, '#F6EBD9', '#E6BD75'),
    ('distemper',      'Prakritik',        'Distemper Paint',          BUCKET4, '#E8F1F2', '#A5C5D1'),
    ('emulsion',       'Prakritik',        'Emulsion Paint',           BUCKET2, '#F6EBD9', '#E6BD75'),
    ('why-prakritik',  'Why Prakritik',    'A natural material',       BUCKET3, '#F4EFE2', '#E6BD75'),
    ('about',          'Our Story',        'When Reverence Becomes Responsibility', None, '#F4EFE2', '#173F2B'),
    ('sustainability', 'Sustainability',   'A circular material model', None, '#E8F1F2', '#173F2B'),
    ('innovation',     'Innovation',       'Directions in progress',   None, '#F4EFE2', '#748468'),
    ('colours',        'Colours',          'Natural colour references', None, '#F6EBD9', '#E6BD75'),
    ('calculator',     'Paint Calculator', 'Project summary tool',     BUCKET1, '#F4EFE2', '#E6BD75'),
    ('downloads',      'Downloads',        'Documents & references',   BUCKET1, '#F4EFE2', '#E6BD75'),
    ('contact',        'Contact',          'Talk to Us',               BUCKET1, '#F4EFE2', '#E6BD75'),
    ('for-business',   'For Business',     'Partnership enquiries',    BUCKET1, '#F4EFE2', '#E6BD75'),
]

manifest = []
for slug, l1, l2, art, bg, acc in CARDS:
    og_card(slug, l1, l2, art, bg, acc, HOST_SOCIAL)
    og_card(slug, l1, l2, art, bg, acc, DOCS_SOCIAL)
    og_card(slug, l1, l2, art, bg, acc, DERIVED)
    manifest.append({'slug': slug, 'line1': l1, 'line2': l2, 'art': str(art) if art else None})
    print(f'  og-{slug}.jpg')

# ---- Favicon / app icons from brand mark ----
mark = Image.open(BRAND / 'gaurikrit-logo-mark.png').convert('RGBA')
# flatten onto forest green for favicons (so the mark reads on a solid bg)
def icon(size, bg_color=(23, 63, 43)):
    bg = Image.new('RGB', (size, size), bg_color)
    m = mark.copy(); m.thumbnail((int(size*0.82), int(size*0.82)), Image.Resampling.LANCZOS)
    bg.paste(m, ((size-m.width)//2, (size-m.height)//2), m)
    return bg

ICONS = [
    ('favicon-16x16.png', 16), ('favicon-32x32.png', 32), ('favicon-48x48.png', 48),
    ('apple-touch-icon.png', 180), ('android-chrome-192x192.png', 192),
    ('android-chrome-512x512.png', 512),
]
for name, size in ICONS:
    im = icon(size)
    im.save(HOST_ROOT / name)
    im.save(DOCS_ROOT / name)
    im.save(DERIVED / name)
    print(f'  {name} ({size}x{size})')

(DERIVED / 'manifest.json').write_text(json.dumps(manifest, indent=2))
print(f'\nWrote {len(CARDS)} OG cards + {len(ICONS)} icons to dist-hostinger/, docs/, and archive.')
