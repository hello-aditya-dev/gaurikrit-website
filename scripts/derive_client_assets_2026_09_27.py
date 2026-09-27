"""V18 — Derive production assets from the 2026-09-27 client batch.

SOURCES (immutable, never modified — see ASSET_PROVENANCE.md #11-20):
    WhatsApp Image 2026-09-27 at 4.10.20 PM.jpeg    1254x1254 — stacked logs +
        clay stove w/ embers + "GBP Bio Products" logo (top, y 3.5-27.5%) +
        "Cow Dung Logs" banner (bottom, y 89-97.5%) + watermark (y 38-46.5%)
    WhatsApp Image 2026-09-27 at 4.09.33 PM.jpeg     894x723  — three logs on
        terracotta plate + straw, clean white ground, no branding
    WhatsApp Image 2026-09-27 at 4.09.32 PM (2).jpeg 1280x969 — rectangular
        briquette stack, clean white ground, no branding
    WhatsApp Image 2026-09-27 at 4.09.32 PM.jpeg     853x1280 — single
        Prakritik Paint bucket (blue Distemper config), uniform white ground
        (243,243,243), sharp label incl. the white lid

OUTPUTS (dist-hostinger/assets/images/client/ — new V18 asset family):
    gocast-logs-context.webp / .jpg          1254x420 — branding-free band:
        logs + stove embers. GBP logo / watermark / banner cropped out
        (crop verified by vision QA: zero text remnants).
    cow-dung-logs-plate.webp / .jpg          ~880x700 — white-margin trim of
        the terracotta-plate shot (the cleanest log visual). Natural ratio,
        natural contact shadows kept, deliberate catalogue-plate presentation.
    cow-dung-logs-stack.webp / .jpg          ~1180x900 — white-margin trim of
        the briquette stack. GENERIC material visual — never labelled Bio-Coal.
    prakritik-distemper-single.webp / .jpg   ~800x1150 — white-trim of the
        single Distemper bucket. NO cutout (label lid is white — keying would
        destroy it); natural white plate kept. No redraw, no recolour.

    + og-colours.jpg / og-products.jpg / og-home.jpg social cards
      (established 1200x630 template from derive_pair_assets.py).

Also regenerates the /colours/ shade catalogue data source constants? No —
shade hexes live in includes/data.php + build-static.mjs (see V18 worklog:
pixel-sampled from the palette posters, cross-checked by VLM).

Archival copies of every derivative: source-assets/derived/2026-09-27/.

No AI reconstruction anywhere: crops + deterministic Lanczos resampling +
white-margin trims + the same gentle clarity lift as V11 only.
"""
from pathlib import Path

import numpy as np
from PIL import Image, ImageDraw, ImageEnhance, ImageFilter, ImageFont, ImageOps

ROOT = Path(__file__).resolve().parents[1]
SRC_DIR = ROOT / 'source-assets' / 'client-originals'
OUT = ROOT / 'dist-hostinger' / 'assets'
CLIENT = OUT / 'images' / 'client'
ARCHIVE = ROOT / 'source-assets' / 'derived' / '2026-09-27'

F_CONTEXT = SRC_DIR / 'WhatsApp Image 2026-09-27 at 4.10.20 PM.jpeg'
F_PLATE = SRC_DIR / 'WhatsApp Image 2026-09-27 at 4.09.33 PM.jpeg'
F_STACK = SRC_DIR / 'WhatsApp Image 2026-09-27 at 4.09.32 PM (2).jpeg'
F_BUCKET = SRC_DIR / 'WhatsApp Image 2026-09-27 at 4.09.32 PM.jpeg'

# Geometry (established by pixel segmentation + vision QA, see ASSET_PROVENANCE.md):
# GBP logo band ends ~y 27.5%, watermark band ends ~y 46.5%,
# "Cow Dung Logs" banner starts ~y 89%. The 55-88.5% band keeps the stack's
# upper surface, the stove firebox w/ embers (left) and the ground plane.
CONTEXT_BOX = (0, 690, 1254, 1110)  # 1254 x 420 — vision-verified zero branding

# V18 pixel-sampled shade data (Signature + Premium), for the OG colour card.
SHADE_OG = ['#F5EDE0', '#EFE4CE', '#F8AE03', '#D58F18',
            '#1E4825', '#6D9A57', '#8BC3E7', '#D14B1D']

FONT = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
BOLD = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'


def enhance_rgb(im):
    """Gentle clarity lift — identical to the V11 product pipeline."""
    im = ImageEnhance.Contrast(im).enhance(1.05)
    im = ImageEnhance.Color(im).enhance(1.04)
    im = im.filter(ImageFilter.UnsharpMask(radius=1.3, percent=60, threshold=3))
    return im


def trim_white(im, thr=13, pad=26, cap=0.92):
    """Trim uniform white margins (studio ground) while never eating more
    than `cap` of any side — protects light product parts (the bucket's
    white lid sits ~12 from the 243 ground, hence thr=13 + the cap)."""
    a = np.asarray(im.convert('RGB')).astype(int)
    h, w, _ = a.shape
    bg = np.array([243, 243, 243])
    d = np.sqrt(((a - bg) ** 2).sum(axis=-1))
    content = d > thr
    rows = np.where(content.any(axis=1))[0]
    cols = np.where(content.any(axis=0))[0]
    if not len(rows) or not len(cols):
        return im
    top = int(max(rows.min() - pad, 0))
    bottom = int(min(rows.max() + pad + 1, h))
    left = int(max(cols.min() - pad, 0))
    right = int(min(cols.max() + pad + 1, w))
    # safety caps: never trim past cap of the frame on any side
    top = max(top, int(h * (1 - cap) / 2))
    bottom = min(bottom, h - int(h * (1 - cap) / 2))
    left = max(left, int(w * (1 - cap) / 2))
    right = min(right, w - int(w * (1 - cap) / 2))
    return im.crop((left, top, right, bottom))


def save_pair(im, stem):
    """webp + jpg pair into dist-hostinger and the archive folder."""
    for folder in (CLIENT, ARCHIVE):
        folder.mkdir(parents=True, exist_ok=True)
        im.save(folder / f'{stem}.jpg', quality=90, optimize=True, progressive=True)
        im.save(folder / f'{stem}.webp', quality=88, method=6)
    return im


def derive_context():
    im = Image.open(F_CONTEXT).convert('RGB').crop(CONTEXT_BOX)
    im = enhance_rgb(im)
    return save_pair(im, 'gocast-logs-context')


def derive_plate():
    im = Image.open(F_PLATE).convert('RGB')
    im = trim_white(im, thr=13, pad=30)
    im = enhance_rgb(im)
    return save_pair(im, 'cow-dung-logs-plate')


def derive_stack():
    im = Image.open(F_STACK).convert('RGB')
    im = trim_white(im, thr=13, pad=30)
    im = enhance_rgb(im)
    return save_pair(im, 'cow-dung-logs-stack')


def derive_bucket():
    im = Image.open(F_BUCKET).convert('RGB')
    im = trim_white(im, thr=13, pad=34, cap=0.97)
    im = enhance_rgb(im)
    return save_pair(im, 'prakritik-distemper-single')


# ---------------------------------------------------------------------------
# V18 single-bucket CUTOUT — deterministic white-ground key (same colour-math
# approach as the V11 pink keyer in derive_pair_assets.py; no AI anywhere).
# The bucket's lid is light bluish-grey (~209/218/212 — far from the 243
# ground) and is ENCLOSED by the bucket silhouette, so a border flood-fill
# over near-ground pixels can never reach it. The natural contact shadow
# under the base is kept only where it is dark enough to read as grounding.
# ---------------------------------------------------------------------------

BG_REF = np.array([243, 243, 243], dtype=float)
WHITE_HARD = 14.0   # dist < 14 from the ground -> definitely background
WHITE_SOFT = 64.0   # dist 14-64 -> partial alpha ramp (anti-aliased edge)


def key_white(im):
    rgb = np.asarray(im.convert('RGB')).astype(float)
    h, w, _ = rgb.shape
    d = np.sqrt(((rgb - BG_REF) ** 2).sum(axis=-1))
    hard = d < WHITE_HARD

    # 1. border flood fill over the near-ground mask
    bg = np.zeros((h, w), dtype=bool)
    stack = []
    for x in range(w):
        for y in (0, h - 1):
            if hard[y, x] and not bg[y, x]:
                bg[y, x] = True
                stack.append((y, x))
    for y in range(h):
        for x in (0, w - 1):
            if hard[y, x] and not bg[y, x]:
                bg[y, x] = True
                stack.append((y, x))
    while stack:
        y, x = stack.pop()
        if y > 0 and hard[y - 1, x] and not bg[y - 1, x]:
            bg[y - 1, x] = True
            stack.append((y - 1, x))
        if y < h - 1 and hard[y + 1, x] and not bg[y + 1, x]:
            bg[y + 1, x] = True
            stack.append((y + 1, x))
        if x > 0 and hard[y, x - 1] and not bg[y, x - 1]:
            bg[y, x - 1] = True
            stack.append((y, x - 1))
        if x < w - 1 and hard[y, x + 1] and not bg[y, x + 1]:
            bg[y, x + 1] = True
            stack.append((y, x + 1))

    # 2. alpha: hard background 0, soft ramp near the background mask
    alpha = np.ones((h, w), dtype=float)
    alpha[bg] = 0.0
    fringe = ~bg & (d < WHITE_SOFT)
    near = bg.copy()
    for _ in range(4):
        near = near | np.roll(near, 1, 0) | np.roll(near, -1, 0) \
                   | np.roll(near, 1, 1) | np.roll(near, -1, 1)
    near[0, :] = near[-1, :] = True
    near[:, 0] = near[:, -1] = True
    ramp = fringe & near
    alpha[ramp] = np.clip((d[ramp] - WHITE_HARD) / (WHITE_SOFT - WHITE_HARD), 0.0, 1.0)
    alpha = np.clip((alpha - 0.30) / 0.42, 0.0, 1.0)

    # 3. defringe: unmix the ground contribution from partial-alpha pixels
    out = rgb.copy()
    mix = ramp & (alpha >= 0.30)
    if mix.any():
        am = np.maximum(alpha[mix], 0.4)[:, None]
        out[mix] = np.clip((rgb[mix] - (1.0 - am) * BG_REF) / am, 0, 255)

    rgba = np.dstack([out, alpha * 255.0]).astype(np.uint8)
    return Image.fromarray(rgba, 'RGBA')


def derive_bucket_cutout():
    im = Image.open(F_BUCKET).convert('RGB')
    im = trim_white(im, thr=13, pad=34, cap=0.97)
    cut = key_white(im)
    bbox = cut.getchannel('A').getbbox()
    pad = 12
    l = max(bbox[0] - pad, 0)
    t = max(bbox[1] - pad, 0)
    r = min(bbox[2] + pad, cut.width)
    b = min(bbox[3] + pad, cut.height)
    cut = cut.crop((l, t, r, b))
    # gentle enhancement on RGB only (alpha untouched) — V11 convention
    rgb = ImageEnhance.Contrast(cut.convert('RGB')).enhance(1.05)
    rgb = ImageEnhance.Color(rgb).enhance(1.04)
    rgb = rgb.filter(ImageFilter.UnsharpMask(radius=1.3, percent=60, threshold=3))
    final = Image.merge('RGBA', (*rgb.split(), cut.getchannel('A')))
    for folder in (CLIENT, ARCHIVE):
        folder.mkdir(parents=True, exist_ok=True)
        final.save(folder / 'prakritik-distemper-single-cut.png', optimize=True)
        final.save(folder / 'prakritik-distemper-single-cut.webp', quality=88, method=6)
    return final


# ---------------------------------------------------------------------------
# OG social cards — template identical to derive_pair_assets.py so the whole
# card set stays consistent.
# ---------------------------------------------------------------------------

def fit_font(draw, text, max_w, start=69):
    for size in range(start, 30, -1):
        font = ImageFont.truetype(BOLD, size)
        if draw.textbbox((0, 0), text, font=font)[2] <= max_w:
            return font
    return ImageFont.truetype(BOLD, 31)


def og_card(slug, line1, line2, art, bg, accent):
    mark = Image.open(OUT / 'brand' / 'gaurikrit-logo-mark.png').convert('RGBA')
    im = Image.new('RGB', (1200, 630), bg)
    d = ImageDraw.Draw(im)
    d.rectangle((0, 0, 24, 630), fill='#173F2B')
    d.rounded_rectangle((720, 28, 1180, 604), radius=18, fill=accent)
    thumb = ImageOps.contain(art.convert('RGB'), (404, 492))
    im.paste(thumb, (748 + (404 - thumb.width) // 2, 68 + (492 - thumb.height) // 2))
    mini = mark.copy()
    mini.thumbnail((102, 102), Image.Resampling.LANCZOS)
    im.paste(mini, (69, 47), mini)
    d = ImageDraw.Draw(im)
    d.text((191, 71), 'GAURIKRIT', font=ImageFont.truetype(BOLD, 28), fill='#173F2B')
    d.text((70, 266), line1, font=fit_font(d, line1, 620), fill='#173F2B')
    d.text((70, 350), line2, font=fit_font(d, line2, 620), fill='#173F2B')
    d.line((70, 515, 650, 515), fill='#A38A54', width=2)
    d.text((70, 537), 'Good for Nature. Good for Life.',
           font=ImageFont.truetype(FONT, 22), fill='#365746')
    for folder in (OUT / 'social', ARCHIVE):
        folder.mkdir(parents=True, exist_ok=True)
        im.save(folder / f'og-{slug}.jpg', quality=88, optimize=True, progressive=True)
    return im


def shade_card_art():
    """8 pixel-sampled shade swatches on a paper plate — the /colours/ card."""
    art = Image.new('RGB', (404, 492), '#F4EFE2')
    d = ImageDraw.Draw(art)
    sw_w, sw_h, gap, x0, y0 = 82, 98, 14, 21, 66
    for i, hexv in enumerate(SHADE_OG):
        cx = x0 + (i % 4) * (sw_w + gap)
        cy = y0 + (i // 4) * (sw_h + gap)
        d.rounded_rectangle((cx, cy, cx + sw_w, cy + sw_h), radius=8, fill=hexv)
    d.text((21, 24), 'SIGNATURE + PREMIUM', font=ImageFont.truetype(BOLD, 19), fill='#173F2B')
    d.text((21, 404), '36 client-supplied shade references',
           font=ImageFont.truetype(FONT, 17), fill='#365746')
    return art


def ecosystem_art():
    """Two real objects — the Prakritik pair + the clean log plate."""
    art = Image.new('RGB', (404, 492), '#F4EFE2')
    pair = Image.open(OUT / 'products' / 'prakritik-pair.jpg').convert('RGB')
    logs = Image.open(CLIENT / 'cow-dung-logs-plate.jpg').convert('RGB')
    pair_t = ImageOps.contain(pair, (404, 226))
    logs_t = ImageOps.contain(logs, (404, 236))
    art.paste(pair_t, ((404 - pair_t.width) // 2, 14))
    art.paste(logs_t, ((404 - logs_t.width) // 2, 252))
    return art


if __name__ == '__main__':
    ctx = derive_context()
    plate = derive_plate()
    stack = derive_stack()
    bucket = derive_bucket()
    cutout = derive_bucket_cutout()
    og_colours = og_card('colours', 'Prakritik Paint', 'Colours Inspired by Nature',
                         shade_card_art(), '#F6EBD9', '#E9DDC3')
    og_products = og_card('products', 'One Resource.', 'Four Directions.',
                          ecosystem_art(), '#E8F1F2', '#DCE7E0')
    og_home = og_card('home', 'Reimagining Cow Dung', 'as a Resource',
                      ecosystem_art(), '#F4EFE2', '#E6DCC6')
    # V18: the Distemper share card now carries the sharp client-supplied
    # single (same template + the same Distemper blue palette as V11).
    og_dist = og_card('distemper', 'Prakritik', 'Distemper Paint',
                      cutout, '#E8F1F2', '#A5C5D1')
    for im, name in [(ctx, 'gocast-logs-context'), (plate, 'cow-dung-logs-plate'),
                     (stack, 'cow-dung-logs-stack'), (bucket, 'prakritik-distemper-single'),
                     (cutout, 'prakritik-distemper-single-cut'),
                     (og_colours, 'og-colours'), (og_products, 'og-products'),
                     (og_home, 'og-home'), (og_dist, 'og-distemper')]:
        print(f'{name}: {im.width}x{im.height}')
    print('V18 derivatives + OG cards done.')
