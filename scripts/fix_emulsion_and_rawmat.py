#!/usr/bin/env python3
"""V23 asset-integrity fixes — Emulsion presentation + raw-material photography.

PART A — Prakritik Emulsion (client brief: the Emulsion image is softer than
the Distemper image and shows unwanted pinkish remnants around its base).

  The previous Emulsion presentation derived from the V11 pair-graphic cutout
  (a 800x400 marketing banner) — low native resolution and pink-background
  keying artefacts. This script rebuilds the Emulsion assets from the best
  available client original:

    source-assets/client-originals/WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg
    (1280x853, left bucket, sharp labels, natural wall+floor background)

  Outputs (all genuine client pixels — no AI redraw of any label/pack detail):
    dist-hostinger/assets/images/client/prakritik-emulsion-single-cut.png/.webp
        transparent cutout, same naming/pipeline as prakritik-distemper-single-cut
    dist-hostinger/assets/images/ecosystem/prakritik-emulsion-{640,960,1280,1600}.{avif,webp,jpg}
        4:3 paper-field presentation matching the Distemper panel style
        (replaces the pink-halo hero set)
    dist-hostinger/assets/social/og-emulsion.jpg
        share card — only the in-frame product region is replaced

PART B — Raw-material photography (client brief: supplied photographs must be
used for the raw material instead of generic generated straw imagery).

  New ecosystem stems (16:9 ladder, native 1672px, never upscaled):
    rawmat-shed        <- Cow-Dung pile-2.png  (about resource chapter)
    rawmat-cakes       <- Cow-Dung pile-4.png  (sustainability hero)
    rawmat-tree        <- Cow-Dung pile-1.png  (why-prakritik flow 01)
  (Homepage stage 01 already uses flow-cow-dung <- Cow-Dung pile-3.png.)

Policy: client originals are never modified; derivatives are named by their
actual pixel width; avif/webp/jpg triplet per rung like the existing system.
"""
from pathlib import Path
import json

import numpy as np
from PIL import Image, ImageDraw, ImageFilter, ImageEnhance
from scipy import ndimage

ROOT = Path(__file__).resolve().parents[1]
ORIG = ROOT / 'source-assets' / 'client-originals'
ECO = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'ecosystem'
CLIENT = ROOT / 'dist-hostinger' / 'assets' / 'images' / 'client'
SOCIAL = ROOT / 'dist-hostinger' / 'assets' / 'social'
DERIVED = ROOT / 'source-assets' / 'client-derived' / '2026-10-29-fixes'
DERIVED.mkdir(parents=True, exist_ok=True)

# Palette — same tokens as scripts/build_v19_masters.py so the composite
# panel belongs to the site's visual system.
FIELD_TOP = np.array([244, 238, 224], dtype=np.float32)
FIELD_BOT = np.array([236, 226, 203], dtype=np.float32)
SHADOW_RGB = (62, 52, 38)


# ---------------------------------------------------------------------------
# shared helpers (mirrors of the V19 pipeline)
# ---------------------------------------------------------------------------

def make_field(w, h, seed=19):
    yy, xx = np.mgrid[0:h, 0:w].astype(np.float32)
    grad = (yy / max(h - 1, 1))[:, :, None]
    img = FIELD_TOP[None, None, :] * (1 - grad) + FIELD_BOT[None, None, :] * grad
    r = np.sqrt(((xx - w * 0.24) / (w * 0.95)) ** 2 +
                ((yy - h * 0.16) / (h * 0.95)) ** 2)
    light = np.clip(1.0 - 0.16 * r, 0, 1)
    img += light[:, :, None] * np.array([7, 6, 4], dtype=np.float32)
    rng = np.random.default_rng(seed)
    coarse = np.asarray(Image.fromarray(
        rng.normal(0, 1, (max(h // 24, 2), max(w // 24, 2))).astype(np.float32)
    ).resize((w, h), Image.BILINEAR), dtype=np.float32)
    coarse = ndimage.gaussian_filter(coarse, w / 90)
    img += coarse[:, :, None] * np.array([2.6, 2.4, 2.0], dtype=np.float32)
    mid = rng.normal(0, 1, (max(h // 6, 2), max(w // 6, 2))).astype(np.float32)
    mid = np.asarray(Image.fromarray(mid).resize((w, h), Image.BILINEAR),
                     dtype=np.float32)
    img += mid[:, :, None] * 1.1
    v = 1 - 0.06 * (xx / w + yy / h) / 2
    img *= v[:, :, None]
    return Image.fromarray(np.clip(img, 0, 255).astype(np.uint8), 'RGB')


def add_grain(im, sigma=2.3, seed=7):
    arr = np.asarray(im.convert('RGB')).astype(np.float32)
    rng = np.random.default_rng(seed)
    noise = rng.normal(0, sigma, arr.shape[:2])[:, :, None]
    return Image.fromarray(np.clip(arr + noise, 0, 255).astype(np.uint8), 'RGB')


def contact_shadow(field, cx, cy, rx, ry, opacity=0.16, blur=70,
                   offset=(0.03, 0.012)):
    w, h = field.size
    layer = Image.new('RGBA', (w, h), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    ox, oy = int(rx * offset[0]), int(ry * offset[1])
    d.ellipse([cx - rx + ox, cy - ry + oy, cx + rx + ox, cy + ry + oy],
              fill=SHADOW_RGB + (int(255 * opacity),))
    layer = layer.filter(ImageFilter.GaussianBlur(blur))
    out = field.convert('RGBA')
    out.alpha_composite(layer)
    return out.convert('RGB')


def unmix_fringe(rgba, bg, floor=0.12):
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    a = arr[:, :, 3:4] / 255.0
    semi = (a[:, :, 0] > 0.02) & (a[:, :, 0] < 0.98)
    bgv = np.array(bg, dtype=np.float32)[None, None, :]
    a_safe = np.clip(a, floor, 1.0)
    unmixed = (arr[:, :, :3] - bgv * (1 - a_safe)) / a_safe
    arr[:, :, :3] = np.where(semi[:, :, None], unmixed, arr[:, :, :3])
    arr[:, :, :3] = np.where(semi[:, :, None], arr[:, :, :3] * 0.94,
                             arr[:, :, :3])
    return Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8), 'RGBA')


def enhance_mild(rgba, wb_strength=0.35, brightness=1.02, contrast=1.03):
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    rgb, alpha = arr[:, :, :3], arr[:, :, 3]
    mask = (alpha > 200) & (rgb.min(axis=2) > 120) & \
           (rgb.max(axis=2) - rgb.min(axis=2) < 28)
    if mask.sum() > 400:
        mean = rgb[mask].mean(axis=0)
        target = float(mean.mean())
        gains = np.clip(target / np.maximum(mean, 1), 0.94, 1.06)
        gains = 1 + (gains - 1) * wb_strength
        rgb *= gains[None, None, :]
    rgb = np.clip(rgb, 0, 255)
    im = Image.fromarray(np.dstack([rgb.astype(np.uint8),
                                    alpha.astype(np.uint8)]), 'RGBA')
    sharp = im.filter(ImageFilter.UnsharpMask(radius=1.4, percent=68, threshold=4))
    im = Image.composite(sharp, im, im.split()[3].point(lambda a: 255 if a > 200 else 0))
    im = ImageEnhance.Brightness(im).enhance(brightness)
    im = ImageEnhance.Contrast(im).enhance(contrast)
    return im


def save_triplet(im, stem, width, out_dirs):
    """avif + webp + jpg ladder rung, named by actual pixel width."""
    for out in out_dirs:
        out.mkdir(parents=True, exist_ok=True)
        try:
            im.save(str(out / f'{stem}-{width}.avif'), format='AVIF',
                    quality=58, speed=6)
        except Exception as exc:
            print(f'  ! avif failed {stem}-{width}: {exc}')
        im.save(str(out / f'{stem}-{width}.webp'), format='WEBP',
                quality=82, method=6)
        im.save(str(out / f'{stem}-{width}.jpg'), format='JPEG',
                quality=87, optimize=True, progressive=True)


# ---------------------------------------------------------------------------
# PART A1 — Emulsion single-bucket cutout from the 2026-10-16 photo
# ---------------------------------------------------------------------------

def cutout_emulsion():
    src = ORIG / 'WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg'
    im = Image.open(src).convert('RGB')
    # Left bucket region: verified complete (handle top y≈179 after crop
    # offset; label right edge x≈409; base y≈640). Floor margin kept below.
    CROP = (0, 60, 410, 700)
    crop = im.crop(CROP)
    arr = np.asarray(crop).astype(np.float32)
    h, w = arr.shape[:2]
    lum = arr.mean(axis=2)
    mx = arr.max(axis=2)
    mn = arr.min(axis=2)
    sat = (mx - mn) / np.maximum(mx, 1)

    # strong edges block flood leakage (crisp bucket boundary vs soft wall)
    grad = ndimage.gaussian_gradient_magnitude(lum, sigma=1.0)
    edge = ndimage.binary_dilation(grad > 12, iterations=1)

    # 1) WALL — near-white, flooded from top/left/right borders
    wall_near = (np.abs(arr - 233).max(axis=2) < 42) & (sat < 0.24) & ~edge
    lblw, nw = ndimage.label(wall_near)
    border_ids = set(np.unique(np.concatenate(
        [lblw[0], lblw[:, 0], lblw[:, -1]]))) - {0}
    wall = np.isin(lblw, list(border_ids))

    # 2) FLOOR — warm wood, flooded from the bottom border
    floor_near = ((arr[:, :, 0] - arr[:, :, 1] > 18) &
                  (arr[:, :, 0] - arr[:, :, 2] > 42) & (lum > 70) & ~edge)
    lblf, nf = ndimage.label(floor_near)
    floor_ids = set(np.unique(lblf[-1])) - {0}
    floor = np.isin(lblf, list(floor_ids))

    # 3) RIGHT-SIDE SHADOW BAND — dark pixels connected to the right border
    #    (the shaded wall between this bucket and its neighbour)
    dark_near = (lum < 150) & ~edge
    lbld, nd_ = ndimage.label(dark_near)
    dark_ids = set(np.unique(np.concatenate(
        [lbld[:, -1], lbld[0, :], lbld[-1, :]]))) - {0}
    dark = np.isin(lbld, list(dark_ids))
    # only keep dark regions in the right-hand third (the shadow band), so
    # any stray dark flood elsewhere can never touch the bucket body
    dark[:, :int(w * 0.62)] = False

    bg = wall | floor | dark
    alpha = np.where(bg, 0, 255).astype(np.float32)

    # keep only the main bucket component (+ its handle), drop speckles
    fg = alpha > 0
    lblfg, nfg = ndimage.label(fg)
    main_id = lblfg[int(h * 0.55), int(w * 0.35)]   # inside the label
    keep = (lblfg == main_id)
    # the handle may form its own component through the raised arch gap —
    # keep any component that overlaps the top-left quadrant band (handle zone)
    for cid in range(1, nfg + 1):
        if cid == main_id:
            continue
        ys, xs = np.where(lblfg == cid)
        if len(xs) < 200:
            continue
        if xs.max() < w * 0.55 and ys.min() < h * 0.35:
            keep |= (lblfg == cid)   # handle / lid fragments
    alpha = np.where(keep, alpha, 0)

    # feather the boundary (1-2px)
    solid = alpha > 0
    eroded = ndimage.binary_erosion(solid, iterations=1)
    edgeband = solid & ~eroded
    soft = ndimage.gaussian_filter(alpha, 1.2)
    alpha = np.where(edgeband, soft, alpha)

    out = np.dstack([arr.astype(np.uint8),
                     np.clip(alpha, 0, 255).astype(np.uint8)])
    cut = Image.fromarray(out, 'RGBA')

    # defringe against the wall colour, then mild source-true enhancement
    cut = unmix_fringe(cut, (233, 233, 234))
    cut = enhance_mild(cut)

    # trim to the matte + margin
    a = np.asarray(cut)[:, :, 3]
    ys, xs = np.where(a > 8)
    x0, x1 = max(0, xs.min() - 14), min(w, xs.max() + 14)
    y0, y1 = max(0, ys.min() - 14), min(h, ys.max() + 14)
    cut = cut.crop((x0, y0, x1, y1))
    print(f'  emulsion cutout trimmed: {cut.size[0]}x{cut.size[1]}')
    return cut


# ---------------------------------------------------------------------------
# PART A2 — 4:3 paper-field presentation panel (matches Distemper panel)
# ---------------------------------------------------------------------------

def emulsion_panel(cut):
    W, H = 2400, 1800                       # 4:3 working master
    field = make_field(W, H, seed=37)
    # scale the bucket to ~68% of the panel height, centred
    target_h = int(H * 0.68)
    s = target_h / cut.height
    bw, bh = int(cut.width * s), target_h
    big = cut.resize((bw, bh), Image.LANCZOS)
    x = int((W - bw) / 2)
    base_y = int(H * 0.885)
    field = contact_shadow(field, x + bw / 2, base_y, bw * 0.44,
                           bh * 0.035, opacity=0.17, blur=48)
    field = field.convert('RGBA')
    field.alpha_composite(big, (x, base_y - bh))
    return add_grain(field.convert('RGB'), 2.2)


# ---------------------------------------------------------------------------
# PART A3 — og-emulsion share card: replace only the in-frame product
# ---------------------------------------------------------------------------

def fix_og_card(cut):
    card = Image.open(SOCIAL / 'og-emulsion.jpg').convert('RGB')
    arr = np.asarray(card)
    # frame interior (measured): x 650..1008, y 164..462; backdrop cream
    x0, y0, x1, y1 = 653, 166, 1006, 460
    r = 22  # rounded-corner radius preserved by drawing a rounded rect
    # backdrop: vertical gradient sampled from the original frame corners
    top_rgb = (246, 235, 217)
    bot_rgb = (237, 227, 206)
    mask = Image.new('L', (x1 - x0, y1 - y0), 0)
    d = ImageDraw.Draw(mask)
    d.rounded_rectangle([0, 0, x1 - x0 - 1, y1 - y0 - 1], radius=r, fill=255)
    grad = np.zeros((y1 - y0, x1 - x0, 3), dtype=np.float32)
    tt = np.linspace(0, 1, y1 - y0)[:, None, None]
    grad[:] = (np.array(top_rgb) * (1 - tt) + np.array(bot_rgb) * tt)
    grad_img = Image.fromarray(grad.astype(np.uint8), 'RGB')
    card.paste(grad_img, (x0, y0), mask)

    # product: same height ratio as the frame interior (~86% height)
    inner_h = int((y1 - y0) * 0.84)
    s = inner_h / cut.height
    bw, bh = int(cut.width * s), inner_h
    big = cut.resize((bw, bh), Image.LANCZOS)
    # soft contact shadow under the bucket base
    sh = Image.new('RGBA', card.size, (0, 0, 0, 0))
    ds = ImageDraw.Draw(sh)
    cx = x0 + (x1 - x0) / 2
    base = y1 - int((y1 - y0) * 0.06)
    ds.ellipse([cx - bw * 0.5, base - 8, cx + bw * 0.5, base + 10],
               fill=SHADOW_RGB + (36,))
    sh = sh.filter(ImageFilter.GaussianBlur(14))
    card = Image.alpha_composite(card.convert('RGBA'), sh).convert('RGB')
    px = int(cx - bw / 2)
    py = base - bh
    card.paste(big, (px, py), big)
    return card


# ---------------------------------------------------------------------------
# PART B — raw-material pile derivatives
# ---------------------------------------------------------------------------

def build_rawmat_stems():
    items = [
        ('rawmat-shed',  ORIG / '2026-10-29-update' / 'Cow-Dung pile-2.png', [640, 960, 1280]),
        ('rawmat-cakes', ORIG / '2026-10-29-update' / 'Cow-Dung pile-4.png', [640, 960, 1280]),
        ('rawmat-tree',  ORIG / '2026-10-29-update' / 'Cow-Dung pile-1.png', [640, 960, 1280]),
    ]
    made = {}
    for stem, path, rungs in items:
        im = Image.open(path).convert('RGB')
        native_w = im.width
        for target in rungs:
            if target > native_w:
                continue
            if target == native_w:
                variant = im
            else:
                scale = target / native_w
                variant = im.resize((target, round(im.height * scale)),
                                    Image.LANCZOS)
            save_triplet(variant, stem, variant.width, [ECO, DERIVED])
            print(f'  {stem}-{variant.width}  ({variant.width}x{variant.height})')
        made[stem] = {'source': str(path.relative_to(ROOT)), 'widths': rungs}
    return made


# ---------------------------------------------------------------------------

def main():
    print('[A1] emulsion single-bucket cutout')
    cut = cutout_emulsion()
    cut.save(CLIENT / 'prakritik-emulsion-single-cut.png')
    cut.save(CLIENT / 'prakritik-emulsion-single-cut.webp', 'WEBP',
             quality=90, method=6)
    # archive copy + keep the intermediate render for inspection
    cut.save(DERIVED / 'prakritik-emulsion-single-cut.png')

    print('[A2] emulsion presentation panel derivatives')
    panel = emulsion_panel(cut)
    panel.save(DERIVED / '_prakritik-emulsion-panel-master.jpg', quality=92)
    for width in (1600, 1280, 960, 640):
        hh = int(width * 3 / 4)
        variant = panel.resize((width, hh), Image.LANCZOS)
        save_triplet(variant, 'prakritik-emulsion', width, [ECO])
        print(f'  prakritik-emulsion-{width}  ({width}x{hh})')

    print('[A3] og-emulsion share card')
    card = fix_og_card(cut)
    card.save(SOCIAL / 'og-emulsion.jpg', quality=90, optimize=True,
              progressive=True)
    card.save(DERIVED / 'og-emulsion.jpg', quality=90)

    print('[B] raw-material pile derivatives')
    made = build_rawmat_stems()

    (DERIVED / 'manifest.json').write_text(json.dumps({
        'emulsion-single-cut': {
            'source': 'source-assets/client-originals/WhatsApp Image 2026-10-16 at 7.45.04 AM.jpeg',
            'outputs': [
                'dist-hostinger/assets/images/client/prakritik-emulsion-single-cut.png',
                'dist-hostinger/assets/images/client/prakritik-emulsion-single-cut.webp',
                'dist-hostinger/assets/images/ecosystem/prakritik-emulsion-{640,960,1280,1600}.{avif,webp,jpg}',
                'dist-hostinger/assets/social/og-emulsion.jpg',
            ],
        },
        'rawmat': made,
    }, indent=2))
    print('done.')


if __name__ == '__main__':
    main()
