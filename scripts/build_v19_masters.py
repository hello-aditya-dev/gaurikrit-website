"""V19 — Build the Gaurikrit master image system.

Creates source-assets/masters/2026-09-27/ — high-quality 4K masters:

REAL-ENHANCED (factual product pixels preserved, deterministic pipeline only):
  - cutouts via border flood-fill keying (scipy) — logs plate, logs stack
  - reuse of the V11 pair cutouts + V18 single-bucket cutout
  - composites on a designed warm limewash field (procedural, site palette)
  - contact shadows, unified film grain — NO generative redraw of any
    factual pixel: labels, colours, shapes, rims stay exactly as supplied.

REPRESENTATIVE-GENERATED (category visuals, unbranded):
  - biocoal-editorial-4k.jpg        (from /tmp/v19-gen/biocoal-1.png)
  - utility-material-direction-4k   (from /tmp/v19-gen/utility-1.png)
  - colours-wall-4k                 (from /tmp/v19-gen/wall-2.png)
  - rawmat-4k                       (from /tmp/v19-gen/rawmat-1.png)
  AI generation basis + Lanczos 4K upscale + conservative sharpen + grain.
  No logos / labels / invented products anywhere in these.

Masters are NEVER served directly; public derivatives are produced by
scripts/build_v19_derivatives.py into dist-hostinger/assets/images/ecosystem/.

Deterministic: fixed seeds, fixed crop boxes, no network, no AI in this script.
"""
from pathlib import Path

import numpy as np
from PIL import Image, ImageDraw, ImageEnhance, ImageFilter
from scipy import ndimage

ROOT = Path(__file__).resolve().parents[1]
MASTERS = ROOT / 'source-assets' / 'masters' / '2026-09-27'
GEN = Path('/tmp/v19-gen')
ASSETS = ROOT / 'dist-hostinger' / 'assets'

MASTERS.mkdir(parents=True, exist_ok=True)

# ---------------------------------------------------------------------------
# Palette (matches app.css tokens so composites belong to the site, §59)
# ---------------------------------------------------------------------------
FIELD_TOP = np.array([244, 238, 224], dtype=np.float32)   # warm paper, light
FIELD_BOT = np.array([236, 226, 203], dtype=np.float32)   # deeper limewash
SHADOW_RGB = (62, 52, 38)

# ---------------------------------------------------------------------------
# helpers
# ---------------------------------------------------------------------------

def flood_key_cutout(src: Path, tol: float = 34.0, feather: float = 1.2,
                     keep_enclosed: bool = True,
                     shadow_junk: bool = False) -> Image.Image:
    """Cut subject out of a near-uniform background via border flood-fill.

    The background is the connected component of near-border-colour pixels
    that touches the image border. Enclosed pockets (holes in the subject
    that do NOT reach the border, e.g. the bucket lid interior ring) stay
    opaque when keep_enclosed=True.

    shadow_junk=True additionally removes the low-saturation bright cast
    shadow baked into the source background around the subject's base
    (e.g. the soft grey shadow under the terracotta plate) — it joins the
    floodable background set because it is connected to the true bg.
    """
    im = Image.open(src).convert('RGB')
    arr = np.asarray(im).astype(np.float32)
    h, w = arr.shape[:2]
    border = np.concatenate([arr[0], arr[-1], arr[:, 0], arr[:, -1]])
    bg = np.median(border, axis=0)

    dist = np.linalg.norm(arr - bg, axis=2)
    near = dist < tol
    if shadow_junk:
        mx = arr.max(axis=2); mn = arr.min(axis=2)
        sat = (mx - mn) / np.maximum(mx, 1)
        lum = arr.mean(axis=2)
        near = near | ((sat < 0.14) & (lum > 165))   # bright low-sat = cast shadow

    lbl, _ = ndimage.label(near)
    border_labels = set(np.unique(np.concatenate(
        [lbl[0], lbl[-1], lbl[:, 0], lbl[:, -1]])))
    border_labels.discard(0)
    bgmask = np.isin(lbl, list(border_labels)) if border_labels else near
    if keep_enclosed:
        # enclosed near-bg pockets (holes fully inside the subject) stay opaque
        inside = near & ~bgmask
        if inside.any():
            ilbl, _ = ndimage.label(inside)
            # any pocket touching the true bgmask remains background
            dil = ndimage.binary_dilation(bgmask, iterations=2)
            pocket_bg = ilbl[np.roll(dil, 1, 0) | np.roll(dil, -1, 0) |
                             np.roll(dil, 1, 1) | np.roll(dil, -1, 1)]
            bad = set(np.unique(pocket_bg)) - {0}
            if bad:
                bgmask = bgmask | np.isin(ilbl, list(bad))

    alpha = np.where(bgmask, 0, 255).astype(np.float32)
    # feather the boundary only (1-2px), not the whole mask
    solid = alpha > 0
    edge = solid & ~ndimage.binary_erosion(solid, iterations=1)
    soft = ndimage.gaussian_filter(alpha, feather)
    alpha = np.where(edge, soft, alpha)
    out = np.dstack([arr.astype(np.uint8), np.clip(alpha, 0, 255).astype(np.uint8)])
    return Image.fromarray(out, 'RGBA')


def make_field(w: int, h: int, seed: int = 19) -> Image.Image:
    """A designed warm limewash/paper field — the common ground for every
    composite. Soft upper-left daylight, gentle vignette, paper grain."""
    yy, xx = np.mgrid[0:h, 0:w].astype(np.float32)
    grad = (yy / max(h - 1, 1))[:, :, None]
    img = FIELD_TOP[None, None, :] * (1 - grad) + FIELD_BOT[None, None, :] * grad

    # soft directional light from the upper-left
    r = np.sqrt(((xx - w * 0.24) / (w * 0.95)) ** 2 +
                ((yy - h * 0.16) / (h * 0.95)) ** 2)
    light = np.clip(1.0 - 0.16 * r, 0, 1)
    img += light[:, :, None] * np.array([7, 6, 4], dtype=np.float32)

    # paper texture: two noise octaves + fine grain
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

    # gentle vignette (bottom-right falls away)
    v = 1 - 0.06 * (xx / w + yy / h) / 2
    img *= v[:, :, None]

    return Image.fromarray(np.clip(img, 0, 255).astype(np.uint8), 'RGB')


def add_grain(im: Image.Image, sigma: float = 2.3, seed: int = 7) -> Image.Image:
    """Unified fine film grain — breaks digital flatness at web scale."""
    arr = np.asarray(im.convert('RGB')).astype(np.float32)
    rng = np.random.default_rng(seed)
    noise = rng.normal(0, sigma, arr.shape[:2])[:, :, None]
    return Image.fromarray(np.clip(arr + noise, 0, 255).astype(np.uint8), 'RGB')


def unmix_fringe(rgba: Image.Image, bg: tuple, floor: float = 0.12) -> Image.Image:
    """Un-premultiply edge colours. Semi-transparent pixels from a flood-key
    cutout carry the source background colour blended in (C_obs = C_fg*a +
    bg*(1-a)). Recover the true foreground colour so edges stop glowing with
    the source background's white/pink tint."""
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    a = arr[:, :, 3:4] / 255.0
    semi = (a[:, :, 0] > 0.02) & (a[:, :, 0] < 0.98)
    bgv = np.array(bg, dtype=np.float32)[None, None, :]
    a_safe = np.clip(a, floor, 1.0)
    unmixed = (arr[:, :, :3] - bgv * (1 - a_safe)) / a_safe
    arr[:, :, :3] = np.where(semi[:, :, None], unmixed, arr[:, :, :3])
    # gently darken the remaining rim so soft edges stop reading as halos
    arr[:, :, :3] = np.where(semi[:, :, None], arr[:, :, :3] * 0.94,
                             arr[:, :, :3])
    return Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8), 'RGBA')


def clean_bottom_glow(rgba: Image.Image, bg: tuple, band: float = 0.14,
                      sat_max: float = 0.24, lum_min: float = 140) -> Image.Image:
    """Remove the residual source-background glow wedge under a cutout's
    base (semi-transparent pink/grey pixels left by the studio shadow)."""
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    h = arr.shape[0]
    b = slice(int(h * (1 - band)), h)
    sub = arr[b]
    a = sub[:, :, 3]
    mx = sub[:, :, :3].max(axis=2); mn = sub[:, :, :3].min(axis=2)
    sat = (mx - mn) / np.maximum(mx, 1)
    lum = sub[:, :, :3].mean(axis=2)
    bgv = np.array(bg, dtype=np.float32)
    near_bg = np.linalg.norm(sub[:, :, :3] - bgv, axis=2) < 65
    junk = (a > 0) & (a < 252) & ((near_bg) | ((sat < sat_max) & (lum > lum_min)))
    sub[:, :, 3] = np.where(junk, 0, a)
    arr[b] = sub
    return Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8), 'RGBA')


def relight(rgba: Image.Image, strength: float = 0.07) -> Image.Image:
    """Subtle lateral relight so pasted subjects share the scene's upper-left
    key light: left edge slightly lifted, right edge slightly darkened."""
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    h, w = arr.shape[:2]
    g = np.linspace(1.0 + strength, 1.0 - strength, w)[None, :, None]
    arr[:, :, :3] *= g
    return Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8), 'RGBA')


def tight_alpha(rgba: Image.Image, erode: int = 1) -> Image.Image:
    """Erode the alpha mask by a pixel or two to cut remaining crisp fringes
    from low-resolution keys (only for cutouts with plenty of margin)."""
    arr = np.asarray(rgba.convert('RGBA')).copy()
    a = arr[:, :, 3] > 0
    a = ndimage.binary_erosion(a, iterations=erode)
    arr[:, :, 3] = np.where(a, arr[:, :, 3], 0)
    return Image.fromarray(arr, 'RGBA')


def sweep_field(w: int, h: int, seed: int = 19, cove_at: float = 0.56) -> Image.Image:
    """A seamless studio cyclorama: lighter wall above, soft cove curve,
    slightly deeper table surface below — the classic one-photograph read.
    Light direction: upper-left (matches the pair source photography)."""
    yy, xx = np.mgrid[0:h, 0:w].astype(np.float32)
    yn = yy / max(h - 1, 1)
    base = FIELD_TOP[None, None, :] * (1 - yn[:, :, None]) + \
           FIELD_BOT[None, None, :] * yn[:, :, None]
    # wall luminance: 1.0 at the top → 0.955 approaching the cove
    wall_lum = 1.0 - 0.045 * np.clip(yn / max(cove_at, 1e-3), 0, 1)
    # table luminance: 0.975 just below the cove (the curve catches light)
    # falling gently to 0.93 at the front edge
    table = np.clip((yn - cove_at) / max(1 - cove_at, 1e-3), 0, 1)
    table_lum = 0.975 - 0.045 * table
    lum = np.where(yn < cove_at, wall_lum, table_lum)
    # smooth the junction into a soft S — the cove curve
    lum = ndimage.gaussian_filter1d(lum, sigma=h / 110, axis=0)
    img = base * lum[:, :, None]

    # directional light from the upper-left
    r = np.sqrt(((xx - w * 0.18) / (w * 1.05)) ** 2 +
                ((yy - h * 0.10) / (h * 1.05)) ** 2)
    light = np.clip(1.0 - 0.14 * r, 0, 1)
    img += light[:, :, None] * np.array([8, 7, 5], dtype=np.float32)

    rng = np.random.default_rng(seed)
    coarse = rng.normal(0, 1, (max(h // 24, 2), max(w // 24, 2))).astype(np.float32)
    coarse = np.asarray(Image.fromarray(coarse).resize((w, h), Image.BILINEAR),
                        dtype=np.float32)
    img += ndimage.gaussian_filter(coarse, w / 90)[:, :, None] * 2.2
    mid = rng.normal(0, 1, (max(h // 6, 2), max(w // 6, 2))).astype(np.float32)
    mid = np.asarray(Image.fromarray(mid).resize((w, h), Image.BILINEAR),
                     dtype=np.float32)
    img += mid[:, :, None] * 0.9

    v = 1 - 0.05 * ((xx / w) * 0.6 + (yy / h) * 0.4)
    img *= v[:, :, None]
    return Image.fromarray(np.clip(img, 0, 255).astype(np.uint8), 'RGB')


def dehalo(rgba: Image.Image) -> Image.Image:
    """Kill the 1-2px bright fringe around cutout edges: darken the
    semi-transparent rim toward the interior colour."""
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    a = arr[:, :, 3]
    rim = (a > 20) & (a < 235)
    if rim.any():
        arr[rim, :3] *= 0.93
    # 1px soften of the alpha edge
    soft = ndimage.gaussian_filter(a, 0.8)
    edge = (a > 0) & ~ndimage.binary_erosion(a > 0, iterations=1)
    arr[:, :, 3] = np.where(edge, soft, a)
    return Image.fromarray(np.clip(arr, 0, 255).astype(np.uint8), 'RGBA')


def grounded_shadow(field: Image.Image, cx: float, base_y: float, half_w: float,
                    depth: float, opacity: float = 0.16) -> Image.Image:
    """Two-pass grounding: a tight ambient-occlusion pool right under the
    object + a broad soft directional shadow thrown to the lower-right."""
    w, h = field.size
    layer = Image.new('RGBA', (w, h), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    # tight AO pool
    d.ellipse([cx - half_w * 0.92, base_y - depth * 0.18,
               cx + half_w * 0.92, base_y + depth * 0.55],
              fill=SHADOW_RGB + (int(255 * opacity * 1.25),))
    layer = layer.filter(ImageFilter.GaussianBlur(depth * 0.28))
    # broad cast shadow to the lower-right (light upper-left)
    d2 = ImageDraw.Draw(layer)
    d2.ellipse([cx - half_w * 0.5 + half_w * 0.22, base_y - depth * 0.08,
                cx + half_w * 1.05 + half_w * 0.30, base_y + depth * 0.9],
               fill=SHADOW_RGB + (int(255 * opacity * 0.55),))
    layer = layer.filter(ImageFilter.GaussianBlur(depth * 0.8))
    out = field.convert('RGBA')
    out.alpha_composite(layer)
    return out.convert('RGB')


def warm_ambient(field: Image.Image, cx: float, cy: float, radius: float,
                 rgb=(196, 138, 96), opacity: float = 0.05) -> Image.Image:
    """A faint warm bounce near a warm-coloured object (terracotta plate
    reflecting onto the sweep) — one of the cues that sell a single scene."""
    w, h = field.size
    layer = Image.new('RGBA', (w, h), (0, 0, 0, 0))
    d = ImageDraw.Draw(layer)
    d.ellipse([cx - radius, cy - radius * 0.7, cx + radius, cy + radius * 0.7],
              fill=rgb + (int(255 * opacity),))
    layer = layer.filter(ImageFilter.GaussianBlur(radius * 0.5))
    out = field.convert('RGBA')
    out.alpha_composite(layer)
    return out.convert('RGB')


def contact_shadow(field: Image.Image, cx: float, cy: float, rx: float,
                   ry: float, opacity: float = 0.16, blur: float = 70,
                   offset: tuple = (0.03, 0.012)) -> Image.Image:
    """Soft physically-plausible grounding shadow. Light comes from the
    upper-left, so shadows sit slightly down-right of the subject base."""
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


def enhance_mild(rgba: Image.Image, wb_strength: float = 0.35,
                 brightness: float = 1.02, contrast: float = 1.03) -> Image.Image:
    """Source-preserving enhancement (§15): orientation/white-balance/exposure/
    sharpen only. Factual pixels (label, colours, shape) keep their values —
    channel gains are capped so brand colours cannot drift."""
    arr = np.asarray(rgba.convert('RGBA')).astype(np.float32)
    rgb, alpha = arr[:, :, :3], arr[:, :, 3]

    # neutralise the studio cast using the near-white pixels only (lids/rim)
    mask = (alpha > 200) & (rgb.min(axis=2) > 120) & \
           (rgb.max(axis=2) - rgb.min(axis=2) < 28)
    if mask.sum() > 400:
        mean = rgb[mask].mean(axis=0)
        target = float(mean.mean())
        gains = np.clip(target / np.maximum(mean, 1), 0.94, 1.06)  # capped ±6%
        gains = 1 + (gains - 1) * wb_strength
        rgb *= gains[None, None, :]

    rgb = np.clip(rgb, 0, 255)
    im = Image.fromarray(np.dstack([rgb.astype(np.uint8),
                                    alpha.astype(np.uint8)]), 'RGBA')
    # conservative sharpen — radius 1.4, moderate amount, threshold protects
    # flat label areas from halos
    sharp = im.filter(ImageFilter.UnsharpMask(radius=1.4, percent=68, threshold=4))
    im = Image.composite(sharp, im, im.split()[3].point(lambda a: 255 if a > 200 else 0))
    im = ImageEnhance.Brightness(im).enhance(brightness)
    im = ImageEnhance.Contrast(im).enhance(contrast)
    return im


def upscale_4k(im: Image.Image, target_w: int, target_h: int) -> Image.Image:
    """Deterministic Lanczos resample to the 4K master canvas + conservative
    sharpen. No invented detail (§17): grain is added at the end."""
    im = im.resize((target_w, target_h), Image.LANCZOS)
    im = im.filter(ImageFilter.UnsharpMask(radius=1.8, percent=52, threshold=3))
    return im


def place(field: Image.Image, subject: Image.Image, x: int, y: int,
          scale: float) -> tuple:
    """Resize subject by scale, paste at (x, y) = top-left position.
    Returns (field, pasted_box) where pasted_box = (cx, base_y, half_w)."""
    w, h = subject.size
    subject = subject.resize((max(1, int(w * scale)), max(1, int(h * scale))),
                             Image.LANCZOS)
    field = field.convert('RGBA')
    field.alpha_composite(subject, (x, y))
    return field.convert('RGB'), (x + subject.width / 2, y + subject.height,
                                  subject.width / 2)


def save(im: Image.Image, name: str, quality: int = 92) -> Path:
    p = MASTERS / name
    im.convert('RGB').save(p, quality=quality, optimize=True, progressive=True,
                           subsampling=1)
    print(f'  master: {name}  {im.size[0]}x{im.size[1]}')
    return p


# ---------------------------------------------------------------------------
# 1. cutouts from client originals (never modify the originals)
# ---------------------------------------------------------------------------
print('[1] flood-key cutouts')
plate_cut = flood_key_cutout(
    ASSETS / 'images' / 'client' / 'cow-dung-logs-plate.jpg', tol=30,
    shadow_junk=True)
plate_cut.save(MASTERS / '_logs-plate-cut.png')
stack_cut = flood_key_cutout(
    ASSETS / 'images' / 'client' / 'cow-dung-logs-stack.jpg', tol=30,
    shadow_junk=True)
stack_cut.save(MASTERS / '_logs-stack-cut.png')

pair_dist = enhance_mild(Image.open(ASSETS / 'products' /
                                    'prakritik-distemper-from-pair.png'))
pair_emul = enhance_mild(Image.open(ASSETS / 'products' /
                                    'prakritik-emulsion-from-pair.png'))
single_cut = enhance_mild(Image.open(ASSETS / 'images' / 'client' /
                                     'prakritik-distemper-single-cut.png'))
plate_cut = enhance_mild(plate_cut, wb_strength=0.15)
stack_cut = enhance_mild(stack_cut, wb_strength=0.15)

# unmix edge fringes against each source's real background colour
plate_cut = unmix_fringe(tight_alpha(plate_cut, 1), (255, 255, 253))
stack_cut = unmix_fringe(stack_cut, (255, 255, 255))
pair_dist = clean_bottom_glow(
    unmix_fringe(pair_dist, (253, 228, 218)), (253, 228, 218))
pair_emul = clean_bottom_glow(
    unmix_fringe(pair_emul, (253, 228, 218)), (253, 228, 218))
single_cut = unmix_fringe(single_cut, (242, 242, 242))
# relight: all pasted subjects share the scene's upper-left key
pair_dist = relight(pair_dist, 0.05)
pair_emul = relight(pair_emul, 0.05)
single_cut = relight(single_cut, 0.04)
plate_cut = relight(plate_cut, 0.07)

# ---------------------------------------------------------------------------
# 2. HOME HERO — one designed composition (§25–27)
#    ONE seamless studio sweep. Paint pair front-left on the table plane;
#    logs plate back-right on the same table; light from the upper-left for
#    both (the plate cutout is mirrored so its lighting direction matches
#    the pair source photography); shared two-pass shadows + warm bounce.
# ---------------------------------------------------------------------------
print('[2] home hero ecosystem composition')
W, H = 3840, 2560
field = sweep_field(W, H, seed=19)

plate_hero = plate_cut.transpose(Image.FLIP_LEFT_RIGHT)

sd, se = 1.66, 1.66
pw_d, ph_d = int(pair_dist.width * sd), int(pair_dist.height * sd)
pw_e, ph_e = int(pair_emul.width * se), int(pair_emul.height * se)
base_y = int(H * 0.815)
dx = int(W * 0.135)
ex = dx + int(pw_d * 0.86)

field = grounded_shadow(field, dx + pw_d / 2, base_y, pw_d * 0.5, 130,
                        opacity=0.17)
field = grounded_shadow(field, ex + pw_e / 2, base_y + 10, pw_e * 0.5, 120,
                        opacity=0.15)
field, _ = place(field, pair_dist, dx, base_y - ph_d, sd)
field, _ = place(field, pair_emul, ex, base_y + 10 - ph_e, se)

# plate — back-right on the same table, mirrored to match the light
sp = 1.5
pw_p, ph_p = int(plate_hero.width * sp), int(plate_hero.height * sp)
px = int(W * 0.585)
pbase = int(H * 0.665)
field = warm_ambient(field, px + pw_p / 2, pbase - ph_p * 0.45, pw_p * 0.85,
                     opacity=0.05)
field = grounded_shadow(field, px + pw_p / 2, pbase, pw_p * 0.48, 150,
                        opacity=0.15)
field, _ = place(field, plate_hero, px, pbase - ph_p, sp)

save(add_grain(field, 2.4), 'home-hero-ecosystem-4k.jpg')

# --- mobile portrait crop of the hero (§51): diagonal composition ---
# plate upper-right against the sweep wall, buckets lower-left — a diagonal
# relationship (not a stacked totem) that keeps the one-scene read.
print('[2b] home hero mobile portrait')
Wm, Hm = 2000, 2500
fieldm = sweep_field(Wm, Hm, seed=23, cove_at=0.44)
plate_m = plate_cut.transpose(Image.FLIP_LEFT_RIGHT)
sm = 1.12
pwm, phm = int(plate_m.width * sm), int(plate_m.height * sm)
pxm = int(Wm * 0.44)
pbasem = int(Hm * 0.40)
fieldm = warm_ambient(fieldm, pxm + pwm / 2, pbasem - phm * 0.45, pwm * 0.85,
                      opacity=0.05)
fieldm = grounded_shadow(fieldm, pxm + pwm / 2, pbasem + 6, pwm * 0.5, 105,
                         opacity=0.18)
fieldm, _ = place(fieldm, plate_m, pxm, pbasem - phm, sm)

sdp, sep = 1.58, 1.58
pwd, phd = int(pair_dist.width * sdp), int(pair_dist.height * sdp)
pwe, phe = int(pair_emul.width * sep), int(pair_emul.height * sep)
base = int(Hm * 0.95)
dxx = int(Wm * 0.045)
exx = dxx + int(pwd * 0.84)
assert dxx + pwd * 0.84 + pwe <= Wm - 20, 'mobile pair overflows canvas'
assert pxm + pwm <= Wm - 20, 'mobile plate overflows canvas'
fieldm = grounded_shadow(fieldm, dxx + pwd / 2, base, pwd * 0.5, 95,
                         opacity=0.17)
fieldm = grounded_shadow(fieldm, exx + pwe / 2, base + 6, pwe * 0.5, 90,
                         opacity=0.15)
fieldm, _ = place(fieldm, pair_dist, dxx, base - phd, sdp)
fieldm, _ = place(fieldm, pair_emul, exx, base + 8 - phe, sep)
save(add_grain(fieldm, 2.2), 'home-hero-ecosystem-mobile-4k.jpg')

# ---------------------------------------------------------------------------
# 3. ECO-PAINTS PAIR — canonical editorial pair (§19A)
# ---------------------------------------------------------------------------
print('[3] eco-paints pair editorial')
W, H = 3840, 2400
field = make_field(W, H, seed=29)
sd, se = 2.0, 2.0
pw_d, ph_d = int(pair_dist.width * sd), int(pair_dist.height * sd)
pw_e, ph_e = int(pair_emul.width * se), int(pair_emul.height * se)
base_y = int(H * 0.845)
dx = int(W * 0.215)
ex = dx + int(pw_d * 0.88)
field = contact_shadow(field, dx + pw_d / 2, base_y, pw_d * 0.46, ph_d * 0.07,
                       opacity=0.17, blur=55)
field = contact_shadow(field, ex + pw_e / 2, base_y + 8, pw_e * 0.46,
                       ph_e * 0.065, opacity=0.15, blur=55)
field, _ = place(field, pair_dist, dx, base_y - ph_d, sd)
field, _ = place(field, pair_emul, ex, base_y + 10 - ph_e, se)
save(add_grain(field, 2.4), 'eco-paints-pair-4k.jpg')

# ---------------------------------------------------------------------------
# 4. CATALOGUE SINGLES (§19B/C, §38–39)
# ---------------------------------------------------------------------------
print('[4] catalogue singles')
# distemper — the higher-res blue bucket cutout
W, H = 2160, 2640
field = make_field(W, H, seed=31)
s = 2.2
pw, ph = int(single_cut.width * s), int(single_cut.height * s)
x, base_y = int((W - pw) / 2), int(H * 0.93)
field = contact_shadow(field, x + pw / 2, base_y, pw * 0.36, ph * 0.045,
                       opacity=0.17, blur=45)
field, _ = place(field, single_cut, x, base_y - ph, s)
save(add_grain(field, 2.2), 'prakritik-distemper-4k.jpg')

# emulsion — from-pair cutout
W, H = 2160, 2640
field = make_field(W, H, seed=37)
s = 3.1
pw, ph = int(pair_emul.width * s), int(pair_emul.height * s)
x, base_y = int((W - pw) / 2), int(H * 0.92)
field = contact_shadow(field, x + pw / 2, base_y, pw * 0.38, ph * 0.05,
                       opacity=0.16, blur=48)
field, _ = place(field, pair_emul, x, base_y - ph, s)
save(add_grain(field, 2.2), 'prakritik-emulsion-4k.jpg')

# ---------------------------------------------------------------------------
# 5. GOCAST editorial + material crops (§20)
# ---------------------------------------------------------------------------
print('[5] gocast set')
W, H = 3200, 2400
field = sweep_field(W, H, seed=41, cove_at=0.5)
plate_g = plate_cut
s = 2.5
pw, ph = int(plate_g.width * s), int(plate_g.height * s)
x, base_y = int((W - pw) / 2), int(H * 0.915)
field = warm_ambient(field, x + pw / 2, base_y - ph * 0.45, pw * 0.8,
                     opacity=0.05)
field = grounded_shadow(field, x + pw / 2, base_y, pw * 0.5, 160, opacity=0.16)
field, _ = place(field, plate_g, x, base_y - ph, s)
save(add_grain(field, 2.3), 'gocast-editorial-4k.jpg')

# material macro: end-grain / holes crop of the stack (§51 keeps holes visible)
stack = Image.open(ASSETS / 'images' / 'client' / 'cow-dung-logs-stack.jpg')
sw, sh = stack.size
crop = stack.crop((int(sw * 0.30), int(sh * 0.18), int(sw * 0.94),
                   int(sh * 0.82))).convert('RGB')
crop = ImageEnhance.Contrast(crop).enhance(1.04)
crop = ImageEnhance.Color(crop).enhance(1.03)
save(add_grain(upscale_4k(crop, 3840, 2560), 2.0), 'gocast-material-4k.jpg')

# context band (real client stove context, GBP-free) enhanced
ctx = Image.open(ASSETS / 'images' / 'client' / 'gocast-logs-context.jpg')
ctx = ImageEnhance.Contrast(ctx).enhance(1.03)
save(add_grain(upscale_4k(ctx, 3840, 1286), 1.8), 'gocast-context-4k.jpg')

# ---------------------------------------------------------------------------
# 6. GENERATED REPRESENTATIVE MASTERS (4K upscale + grain)
# ---------------------------------------------------------------------------
print('[6] representative-generated masters')
for src_name, out_name, w, h in [
        ('biocoal-1.png', 'biocoal-editorial-4k.jpg', 3840, 2880),
        ('utility-1.png', 'utility-material-direction-4k.jpg', 3840, 2880),
        ('wall-2.png', 'colours-wall-4k.jpg', 3840, 2192),
        ('rawmat-1.png', 'rawmat-4k.jpg', 3840, 2192)]:
    im = Image.open(GEN / src_name).convert('RGB')
    im = ImageEnhance.Contrast(im).enhance(1.02)
    save(add_grain(upscale_4k(im, w, h), 2.1), out_name)

# utility: focus crop — tighten to the cohesive cluster (drop far edges)
util = Image.open(GEN / 'utility-1.png').convert('RGB')
uw, uh = util.size
util_c = util.crop((int(uw * 0.05), int(uh * 0.04), int(uw * 0.95),
                    int(uh * 0.96)))
util_c = ImageEnhance.Contrast(util_c).enhance(1.02)
save(add_grain(upscale_4k(util_c, 3840, 2880), 2.1),
     'utility-material-direction-4k.jpg')

# ---------------------------------------------------------------------------
# 7. INNOVATION RESEARCH COMPOSITION (§33) — three material samples on
#    one field: raw biomass / processed log / finished coating
# ---------------------------------------------------------------------------
print('[7] innovation research composition')
W, H = 3840, 2400

rawmat = Image.open(GEN / 'rawmat-1.png').convert('RGB')
rw, rh = rawmat.size
raw_chip = rawmat.crop((int(rw * 0.30), int(rh * 0.18), int(rw * 0.70),
                        int(rh * 0.86)))          # the patty mound
stack_rgb = Image.open(ASSETS / 'images' / 'client' /
                       'cow-dung-logs-stack.jpg').convert('RGB')
tw, th = stack_rgb.size
log_chip = stack_rgb.crop((int(tw * 0.36), int(th * 0.22), int(tw * 0.64),
                           int(th * 0.78)))       # a clean log with end grain
wall = Image.open(GEN / 'wall-2.png').convert('RGB')
ww, wh_ = wall.size
coat_chip = wall.crop((int(ww * 0.28), int(wh_ * 0.10), int(ww * 0.62),
                       int(wh_ * 0.62)))          # flat painted wall area
# warm the coating chip into the site's limewash family (kills the grey slab)
coat_chip = Image.blend(coat_chip, Image.new('RGB', coat_chip.size,
                                             (238, 226, 202)), 0.18)

chip_h = 1180
def fit_h(im, h):
    r = h / im.height
    return im.resize((max(1, int(im.width * r)), h), Image.LANCZOS)
raw_chip, log_chip, coat_chip = (fit_h(c, chip_h) for c in
                                 (raw_chip, log_chip, coat_chip))
chips = [raw_chip, log_chip, coat_chip]

def make_slab(chip: Image.Image) -> Image.Image:
    """Sample board with visible thickness: front face + darker bottom and
    right side faces (light upper-left) — a photographed material slab."""
    t = 46
    w, h = chip.size
    slab = Image.new('RGBA', (w + t + 8, h + t + 8), (0, 0, 0, 0))
    bottom = Image.new('RGB', (w + t, t), (150, 132, 104))
    side = Image.new('RGB', (t, h), (139, 121, 95))
    slab.paste(bottom, (0, h, w + t, h + t))
    slab.paste(side, (w, 0, w + t, h))
    slab.paste(chip, (0, 0))
    return slab

field = sweep_field(W, H, seed=47, cove_at=0.42)
total_w = sum(c.width for c in chips)
gap = int((W * 0.74 - total_w) / 2)
start_x = int((W - (total_w + 2 * gap)) / 2)
base_y = int(H * 0.815)

x = start_x
for c in chips:
    slab = make_slab(c)
    field = grounded_shadow(field, x + slab.width / 2, base_y,
                            slab.width * 0.5, 120, opacity=0.16)
    field, _ = place(field, slab, int(x - 4), int(base_y - slab.height + 4), 1.0)
    x += c.width + gap
save(add_grain(field, 2.3), 'innovation-research-4k.jpg')


# ---------------------------------------------------------------------------
# 8. MATERIAL DEVELOPMENT (§28 stage 02) — the documented single bucket
#    placed left-of-centre in a wide editorial sweep: a product WITH context,
#    never a giant cropped label. Differentiates the home stage system from
#    the pair placements (§62 repetition).
# ---------------------------------------------------------------------------
print('[8] material development composition')
W, H = 2880, 1920
field = sweep_field(W, H, seed=53, cove_at=0.5)
s = 1.72
pw, ph = int(single_cut.width * s), int(single_cut.height * s)
x, base_y = int(W * 0.16), int(H * 0.90)
field = grounded_shadow(field, x + pw / 2, base_y, pw * 0.42, 150, opacity=0.17)
field, _ = place(field, single_cut, x, base_y - ph, s)
save(add_grain(field, 2.2), 'material-development-4k.jpg')

print('\nAll masters written to', MASTERS)
