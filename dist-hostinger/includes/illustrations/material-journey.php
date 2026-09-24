<?php
/**
 * Illustration: Material journey (cow → refine → product → apply)
 * Coded SVG — no photography dependency.
 * V2 finish pass — disciplined material-flow diagram.
 *
 * Horizontal 4-stage material-flow: cow → drying/refining → bucket →
 * wall-with-brush. Each stage is a small finished line icon, NOT a
 * generic infographic icon. Connecting dashed haldi line with arrow
 * marks. Each stage labelled with a number (01, 02, 03, 04) in
 * Newsreader serif.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 640 140" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Material journey</title>

  <!-- CONNECTING DASHED HALDI LINE — between stages, with directional arrow marks -->
  <g fill="none" stroke="var(--haldi-deep)"
     stroke-width="1.2" stroke-dasharray="3 3"
     opacity="0.7" stroke-linecap="round">
    <path d="M 110 70 L 210 70"/>
    <path d="M 270 70 L 370 70"/>
    <path d="M 430 70 L 530 70"/>
  </g>

  <!-- DIRECTIONAL ARROW MARKS — small triangles at the end of each connector -->
  <g fill="var(--haldi-deep)" stroke="none">
    <path d="M 210 70 L 204 66 L 204 74 Z"/>
    <path d="M 370 70 L 364 66 L 364 74 Z"/>
    <path d="M 530 70 L 524 66 L 524 74 Z"/>
  </g>

  <g fill="none" stroke="var(--forest)"
     stroke-width="1.5" stroke-linecap="round"
     stroke-linejoin="round">

    <!-- ===== STAGE 1 — SMALL COW SILHOUETTE (simplified side-view, facing left) =====
         Simplified version of the IndianCow: body barrel, hump, head, 4 legs, tail, eye. -->
    <g>
      <!-- BODY BARREL (closed contour) -->
      <path d="M 68 56
               L 92 52
               C 100 53, 108 55, 112 56
               L 112 70
               L 68 70
               C 66 64, 66 60, 68 56 Z"/>
      <!-- HUMP — rises above back line -->
      <path d="M 68 56
               C 70 48, 76 42, 80 42
               C 84 42, 88 48, 92 52"/>
      <!-- NECK TOP — from withers forward-down to poll -->
      <path d="M 68 56 C 62 54, 56 53, 50 52"/>
      <!-- HEAD — elongated face, side-view -->
      <path d="M 50 52
               C 46 54, 42 58, 38 62
               C 34 66, 32 70, 32 72
               C 36 74, 42 74, 48 72
               C 52 72, 54 72, 56 72
               C 56 64, 54 58, 50 52 Z"/>
      <!-- HORN — short, curved -->
      <path d="M 50 52 C 46 47, 42 45, 38 46" stroke-width="1.3"/>
      <!-- EAR — small, hanging -->
      <path d="M 54 56 C 60 60, 64 64, 66 68" stroke-width="1.3"/>
      <!-- FRONT LEGS — slender, paired -->
      <path d="M 72 70 L 72 84" stroke-width="1.3"/>
      <path d="M 76 70 L 76 84" stroke-width="1.3"/>
      <!-- BACK LEGS — slender, paired -->
      <path d="M 104 70 L 104 84" stroke-width="1.3"/>
      <path d="M 108 70 L 108 84" stroke-width="1.3"/>
      <!-- TAIL — short with tuft -->
      <path d="M 112 58 C 118 62, 120 70, 118 78" stroke-width="1.3"/>
      <!-- EYE -->
      <circle cx="42" cy="60" r="0.7" fill="var(--forest)" stroke="none"/>
      <!-- HOOF TICKS -->
      <path d="M 70 85 L 78 85" stroke-width="1.2"/>
      <path d="M 102 85 L 110 85" stroke-width="1.2"/>
    </g>

    <!-- ===== STAGE 2 — SUN OVER A DRYING SURFACE (tray with material) ===== -->
    <g>
      <!-- SUN — small circle with rays -->
      <circle cx="240" cy="40" r="6"/>
      <path d="M 240 30 L 240 27"/>
      <path d="M 234 35 L 232 33"/>
      <path d="M 246 35 L 248 33"/>
      <path d="M 230 40 L 227 40"/>
      <path d="M 250 40 L 253 40"/>
      <path d="M 236 45 L 234 47"/>
      <path d="M 244 45 L 246 47"/>
      <!-- DRYING SURFACE — trapezoidal tray -->
      <path d="M 218 64 L 262 64 L 258 76 L 222 76 Z"/>
      <!-- MATERIAL INSIDE TRAY — wavy line suggesting dried material -->
      <path d="M 222 63 C 232 60, 242 64, 252 61 C 256 60, 258 62, 258 64"
            stroke-width="1.2"/>
      <!-- PARTICLE DOTS — scattered on the material -->
      <circle cx="230" cy="62" r="0.7" fill="var(--forest)" stroke="none"/>
      <circle cx="240" cy="60" r="0.7" fill="var(--forest)" stroke="none"/>
      <circle cx="248" cy="62" r="0.7" fill="var(--forest)" stroke="none"/>
    </g>

    <!-- ===== STAGE 3 — SMALL BUCKET SILHOUETTE ===== -->
    <g>
      <!-- TOP RIM ELLIPSE -->
      <ellipse cx="400" cy="44" rx="13" ry="3.5"
               fill="var(--forest)" stroke="var(--forest)"
               stroke-width="1.2"/>
      <!-- BODY — slight taper -->
      <path d="M 387 44 L 389 84 L 411 84 L 413 44"/>
      <!-- HANDLE ARCH -->
      <path d="M 387 44 Q 400 32, 413 44" stroke-width="1.4"/>
      <!-- INNER RIM OPENING — limewash tone -->
      <ellipse cx="400" cy="43" rx="10" ry="2.5"
               fill="var(--limewash)" stroke="none" opacity="0.7"/>
      <!-- LABEL BAND — dark green, slight curve -->
      <path d="M 388 58 L 389 70 L 411 70 L 412 58 C 400 60, 400 60, 388 58 Z"
            fill="var(--forest)" stroke="var(--forest)" stroke-width="1.2"/>
      <!-- HALDI ACCENT STRIPE above label -->
      <path d="M 388 56 L 412 56" stroke="var(--haldi-deep)" stroke-width="1"/>
      <!-- HALDI ACCENT STRIPE below label -->
      <path d="M 389 72 L 411 72" stroke="var(--haldi-deep)" stroke-width="1"/>
      <!-- BASE CURVE -->
      <path d="M 389 84 C 392 86, 408 86, 411 84"
            stroke-width="1.2" opacity="0.7"/>
    </g>

    <!-- ===== STAGE 4 — WALL SECTION WITH PAINT BRUSH (application) ===== -->
    <g>
      <!-- WALL SECTION — rectangular elevation -->
      <path d="M 538 44 L 582 44 L 582 84 L 538 84 Z"/>
      <!-- WALL HORIZONTAL ARTICULATION LINES — subtle plaster lines -->
      <path d="M 538 56 L 582 56" stroke-width="0.7" opacity="0.5"/>
      <path d="M 538 70 L 582 70" stroke-width="0.7" opacity="0.5"/>
      <!-- PAINT STROKE on wall — haldi band (already applied paint) -->
      <path d="M 538 50 L 582 50 L 582 56 L 538 56 Z"
            fill="var(--haldi)" stroke="none" opacity="0.85"/>
      <!-- BRUSH — applying more paint to the wall -->
      <!-- Handle -->
      <path d="M 575 30 L 565 44" stroke-width="1.6"/>
      <!-- Ferrule (metal band) -->
      <path d="M 563 42 L 569 46 L 566 50 L 560 46 Z"
            stroke-width="1.2"/>
      <!-- Bristles — 3 strokes fanning out to the wall -->
      <path d="M 560 46 L 555 52" stroke-width="1.2"/>
      <path d="M 563 48 L 559 54" stroke-width="1.2"/>
      <path d="M 566 50 L 563 56" stroke-width="1.2"/>
      <!-- Haldi paint on bristle tips — subtle dots -->
      <circle cx="555" cy="52" r="0.6" fill="var(--haldi)" stroke="none"/>
      <circle cx="559" cy="54" r="0.6" fill="var(--haldi)" stroke="none"/>
    </g>

  </g>

  <!-- STAGE NUMBERS in Newsreader serif (var font-display) -->
  <g font-family="var(--font-display)" font-weight="700"
     font-size="9" fill="var(--haldi-deep)"
     text-anchor="middle" letter-spacing="1.4">
    <text x="80" y="110">01</text>
    <text x="240" y="110">02</text>
    <text x="400" y="110">03</text>
    <text x="560" y="110">04</text>
  </g>

  <!-- STAGE LABELS — small captions under each number (subtle) -->
  <g font-family="var(--font-sans)" font-weight="600"
     font-size="6" fill="var(--soft-ink)"
     text-anchor="middle" letter-spacing="1.5" opacity="0.7">
    <text x="80" y="122">SOURCE</text>
    <text x="240" y="122">REFINE</text>
    <text x="400" y="122">PRODUCT</text>
    <text x="560" y="122">APPLY</text>
  </g>

</svg>
