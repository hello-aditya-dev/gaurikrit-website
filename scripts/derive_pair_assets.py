"""V11 — Derive the canonical Prakritik Paint product assets from the client's
official two-bucket comparison image.

SOURCE (immutable, never modified):
    source-assets/client-originals/WhatsApp Image 2026-09-23 at 10.21.44 PM(2).jpeg
    800 x 400 — LEFT: Prakritik Distemper, RIGHT: Prakritik Emulsion,
    red headline "INDIA'S FIRST KHADI PRAKRITIK PAINT" (y 12-40),
    bottom blue/orange name bars (y 372-396), flat pastel-pink ground.

GEOMETRY (established by pixel segmentation + vision QA, see ASSET_PROVENANCE.md):
    left bucket   x 53-367   lid top y ~55   base bottom edge y ~355
    right bucket  x 445-749  lid top y ~55   base bottom edge y ~348
    headline      x 89-724   y 12-40 (+faint cream glow to y ~50)
    cast shadows  pink-tinted band y ~348-356 under both buckets
    bottom bars   left x 33-396 (sky blue), right x 439-791 (orange),
                  top edge y 358 (AA tips from y 354), full bars y 360-395

OUTPUTS (dist-hostinger/assets/products/):
    prakritik-pair.webp / .jpg                    — both buckets, headline and
        bars cropped away, pink ground kept, 2x Lanczos resample (1420x618).
    prakritik-distemper-from-pair.webp / .png     — LEFT bucket only, pink
        ground keyed out (border flood-fill + enclosed-pocket pass), pink
        defringe via alpha-ramp unmixing, 2x Lanczos resample.
    prakritik-emulsion-from-pair.webp / .png      — RIGHT bucket only, same.

Also regenerates og-distemper.jpg / og-emulsion.jpg social cards with the new
singles (same card template as scripts/prepare_assets.py).

No AI reconstruction anywhere: crops + deterministic Lanczos resampling +
color-math keying only. Labels, colours, proportions and branding untouched
apart from a gentle contrast/clarity lift.
"""
from pathlib import Path

import numpy as np
from PIL import Image, ImageDraw, ImageEnhance, ImageFilter, ImageFont, ImageOps

ROOT = Path(__file__).resolve().parents[1]
SRC = ROOT / 'source-assets' / 'client-originals' / 'WhatsApp Image 2026-09-23 at 10.21.44 PM(2).jpeg'
OUT = ROOT / 'dist-hostinger' / 'assets'
PRODUCTS = OUT / 'products'

# Pair keeps its natural pink ground (and the soft cast shadows, which sit
# on that ground); singles are cutouts, so their crops stop above the shadow
# band where the shadow-aware keyer takes over.
PAIR_BOX = (46, 48, 756, 357)        # 710 x 309 — both buckets + shadows, no headline, no bars
DISTEMPER_BOX = (37, 45, 383, 356)   # 346 x 311 — left bucket + breathing room
EMULSION_BOX = (429, 45, 765, 356)   # 336 x 311 — right bucket + breathing room

PINK_REF = np.array([253, 228, 218], dtype=float)  # median border pink
HARD_KEY = 18.0    # dist < 18  -> definitely background
SOFT_EDGE = 100.0  # dist 18-100 -> partial alpha ramp. The bucket colours
                   # sit 90-180 from pink, so their 50-90% anti-aliased mixes
                   # land in 45-100 — all of them must join the ramp or they
                   # stay opaque as a pink-tinted fringe.
EDGE_BAND = 4      # ramp applies within this many px of the background mask
SCALE = 2         # deterministic Lanczos resample factor


def dist_to_pink(arr):
    """Per-pixel euclidean distance from the reference background pink."""
    return np.sqrt(((arr - PINK_REF) ** 2).sum(axis=-1))


def enhance_rgb(im):
    """Gentle clarity lift — no oversaturation, no halo-forming sharpening."""
    im = ImageEnhance.Contrast(im).enhance(1.05)
    im = ImageEnhance.Color(im).enhance(1.04)
    im = im.filter(ImageFilter.UnsharpMask(radius=1.3, percent=60, threshold=3))
    return im


def make_pair():
    im = Image.open(SRC).convert('RGB').crop(PAIR_BOX)
    im = im.resize((im.width * SCALE, im.height * SCALE), Image.Resampling.LANCZOS)
    im = enhance_rgb(im)
    im.save(PRODUCTS / 'prakritik-pair.jpg', quality=90, optimize=True, progressive=True)
    im.save(PRODUCTS / 'prakritik-pair.webp', quality=88, method=6)
    return im


def is_shadow(px):
    """Cast-shadow test for the bottom zone only: light, weakly-saturated
    warm tints of the pink ground (covers both the pink tint under the
    Emulsion and the greyer tint under the Distemper). The luminance and
    r>=g gates keep every bucket rim, lid, handle and label band out."""
    r, g, b = px
    lum = 0.299 * r + 0.587 * g + 0.114 * b
    return (lum >= 195 and r >= 205 and 2 <= r - g <= 80
            and max(r, g, b) - min(r, g, b) <= 70)


def key_pink(im):
    """Flood-fill the flat pink ground from the borders (including the pink
    cast shadows under the buckets), key enclosed pink pockets (inside handle
    arcs), and defringe the anti-aliased edge by unmixing the pink contribution
    from partial-alpha pixels."""
    rgb = np.asarray(im.convert('RGB')).astype(float)
    h, w, _ = rgb.shape
    d = dist_to_pink(rgb)
    hard = d < HARD_KEY
    # shadows live directly under the bucket bases only — restrict the
    # shadow pass to the bottom zone so label bands can never be touched
    shadow_rows = np.zeros((h, w), dtype=bool)
    shadow_rows[int(h * 0.88):, :] = True
    shadow = np.apply_along_axis(is_shadow, -1, rgb) & shadow_rows
    passable = hard | shadow

    # --- 1. border flood fill over pink + shadow pixels -------------------
    bg = np.zeros((h, w), dtype=bool)
    stack = []
    for x in range(w):
        for y in (0, h - 1):
            if passable[y, x] and not bg[y, x]:
                bg[y, x] = True
                stack.append((y, x))
    for y in range(h):
        for x in (0, w - 1):
            if passable[y, x] and not bg[y, x]:
                bg[y, x] = True
                stack.append((y, x))
    while stack:
        y, x = stack.pop()
        if y > 0 and passable[y - 1, x] and not bg[y - 1, x]:
            bg[y - 1, x] = True
            stack.append((y - 1, x))
        if y < h - 1 and passable[y + 1, x] and not bg[y + 1, x]:
            bg[y + 1, x] = True
            stack.append((y + 1, x))
        if x > 0 and passable[y, x - 1] and not bg[y, x - 1]:
            bg[y, x - 1] = True
            stack.append((y, x - 1))
        if x < w - 1 and passable[y, x + 1] and not bg[y, x + 1]:
            bg[y, x + 1] = True
            stack.append((y, x + 1))

    # --- 2. enclosed pink pockets (gap between handle wire and rim) --------
    pocket = passable & ~bg
    if pocket.any():
        visited = np.zeros((h, w), dtype=bool)
        for yy in range(h):
            for xx in range(w):
                if pocket[yy, xx] and not visited[yy, xx]:
                    comp = []
                    stack = [(yy, xx)]
                    visited[yy, xx] = True
                    while stack:
                        y, x = stack.pop()
                        comp.append((y, x))
                        for ny, nx in ((y - 1, x), (y + 1, x), (y, x - 1), (y, x + 1)):
                            if 0 <= ny < h and 0 <= nx < w and pocket[ny, nx] and not visited[ny, nx]:
                                visited[ny, nx] = True
                                stack.append((ny, nx))
                    if len(comp) >= 40:  # ignore stray near-pink specks
                        for y, x in comp:
                            bg[y, x] = True

    # --- 3. alpha: hard background 0, edge ramp on the AA band ------------
    alpha = np.ones((h, w), dtype=float)
    alpha[bg] = 0.0
    fringe = ~bg & (d < SOFT_EDGE)
    # restrict the ramp to pixels near the background mask
    near = bg.copy()
    for _ in range(EDGE_BAND):
        near = near | np.roll(near, 1, 0) | np.roll(near, -1, 0) \
                   | np.roll(near, 1, 1) | np.roll(near, -1, 1)
    near[0, :] = near[-1, :] = True
    near[:, 0] = near[:, -1] = True
    ramp = fringe & near
    alpha[ramp] = np.clip((d[ramp] - HARD_KEY) / (SOFT_EDGE - HARD_KEY), 0.0, 1.0)

    # --- 3b. matte contrast: kill the faint pink-side fringe, solidify the
    # true edge (keeps thin structures like the handle wire crisp) --------
    alpha = np.clip((alpha - 0.32) / 0.36, 0.0, 1.0)

    # --- 4. defringe: unmix the pink contribution from partial pixels -----
    # (only where the pixel is substantially product; below that the ramp
    # alpha is near zero and unmixing would just amplify noise)
    out = rgb.copy()
    mix = ramp & (alpha >= 0.30)
    if mix.any():
        am = np.maximum(alpha[mix], 0.4)[:, None]
        out[mix] = np.clip((rgb[mix] - (1.0 - am) * PINK_REF) / am, 0, 255)

    rgba = np.dstack([out, alpha * 255.0]).astype(np.uint8)
    return Image.fromarray(rgba, 'RGBA')


def make_single(box, stem):
    im = Image.open(SRC).convert('RGB').crop(box)
    im = im.resize((im.width * SCALE, im.height * SCALE), Image.Resampling.LANCZOS)
    cut = key_pink(im)
    # trim fully-transparent border rows/cols (keep a tight, clean canvas)
    bbox = cut.getchannel('A').getbbox()
    pad = 14
    l = max(bbox[0] - pad, 0)
    t = max(bbox[1] - pad, 0)
    r = min(bbox[2] + pad, cut.width)
    b = min(bbox[3] + pad, cut.height)
    cut = cut.crop((l, t, r, b))
    # gentle enhancement on RGB only (alpha untouched)
    rgb = ImageEnhance.Contrast(cut.convert('RGB')).enhance(1.05)
    rgb = ImageEnhance.Color(rgb).enhance(1.04)
    rgb = rgb.filter(ImageFilter.UnsharpMask(radius=1.3, percent=60, threshold=3))
    final = Image.merge('RGBA', (*rgb.split(), cut.getchannel('A')))
    final.save(PRODUCTS / f'{stem}.png', optimize=True)
    final.save(PRODUCTS / f'{stem}.webp', quality=88, method=6)
    return final


# ---------------------------------------------------------------------------
# OG social cards for the two detail pages (template identical to
# scripts/prepare_assets.py so the whole card set stays consistent).
# ---------------------------------------------------------------------------
FONT = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf'
BOLD = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf'


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
    thumb = ImageOps.contain(art.convert('RGBA'), (404, 492))
    im.paste(thumb, (748 + (404 - thumb.width) // 2, 68 + (492 - thumb.height) // 2), thumb)
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
    im.save(OUT / 'social' / f'og-{slug}.jpg', quality=88, optimize=True, progressive=True)


if __name__ == '__main__':
    PRODUCTS.mkdir(parents=True, exist_ok=True)
    pair = make_pair()
    dist = make_single(DISTEMPER_BOX, 'prakritik-distemper-from-pair')
    emul = make_single(EMULSION_BOX, 'prakritik-emulsion-from-pair')
    og_card('distemper', 'Prakritik', 'Distemper Paint', dist, '#E8F1F2', '#A5C5D1')
    og_card('emulsion', 'Prakritik', 'Emulsion Paint', emul, '#F6EBD9', '#E6BD75')
    for im, name in [(pair, 'prakritik-pair'), (dist, 'prakritik-distemper-from-pair'),
                     (emul, 'prakritik-emulsion-from-pair')]:
        print(f'{name}: {im.width}x{im.height} {im.mode}')
    print('OG cards regenerated for distemper + emulsion.')
