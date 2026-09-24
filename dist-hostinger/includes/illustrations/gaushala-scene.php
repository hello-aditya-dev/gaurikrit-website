<?php
/**
 * Illustration: Gaushala scene (cows under a shelter, tree, ground)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/gaushala-scene.tsx
 *
 * NOTE: The original TSX uses a `renderCow(cx, baselineY, scale)` helper
 * that wraps the cow silhouette in a transform
 * `translate(cx by) scale(s) translate(-cx -by)`. This PHP port pre-computes
 * each cow's coordinates for the three placements (120/162/1, 180/162/0.9,
 * 370/178/0.7) and keeps the per-cow transform attribute so the rendering
 * matches the React output byte-for-byte.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Gaushala scene</title>

  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.5"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <!-- Shelter roofline — low pitched sloping roof -->
    <path d="M 50 100 L 220 78 L 350 100" stroke-width="1.6" />
    <!-- Roof underside line — parallel for thickness -->
    <path d="M 55 106 L 220 84 L 345 106" stroke-width="1.1" opacity="0.65" />
    <!-- Roof tile/segment lines -->
    <path d="M 90 96 L 92 102" stroke-width="0.9" opacity="0.5" />
    <path d="M 130 90 L 132 96" stroke-width="0.9" opacity="0.5" />
    <path d="M 170 85 L 172 91" stroke-width="0.9" opacity="0.5" />
    <path d="M 220 78 L 222 84" stroke-width="0.9" opacity="0.5" />
    <path d="M 270 84 L 272 90" stroke-width="0.9" opacity="0.5" />
    <path d="M 310 92 L 312 98" stroke-width="0.9" opacity="0.5" />

    <!-- Shelter support poles -->
    <path d="M 70 106 L 70 162" stroke-width="1.4" />
    <path d="M 220 84 L 220 162" stroke-width="1.4" />
    <path d="M 330 100 L 330 162" stroke-width="1.4" />
    <!-- Pole base bands -->
    <path d="M 67 162 L 73 162" stroke-width="1.2" opacity="0.7" />
    <path d="M 217 162 L 223 162" stroke-width="1.2" opacity="0.7" />
    <path d="M 327 162 L 333 162" stroke-width="1.2" opacity="0.7" />

    <!-- Cow 1: cx=120, baselineY=162, scale=1 -->
    <g
      transform="translate(120 162) scale(1) translate(-120 -162)"
      fill="none"
      stroke="var(--forest)"
      stroke-width="1.4"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <!-- Body + head outline (with hump) -->
      <path d="M 102 156 C 100 150, 102 144, 106 144 C 106 140, 109 139, 110 142 C 110 144, 110 146, 108 147 L 110 149 C 114 147, 118 148, 122 149 C 128 148, 134 149, 138 150 C 142 151, 144 154, 144 156 L 144 156 L 102 156 Z" />
      <!-- Front leg 1 -->
      <path d="M 106 156 L 105 162" stroke-width="1.2" />
      <!-- Front leg 2 -->
      <path d="M 111 156 L 112 162" stroke-width="1.2" />
      <!-- Back leg 1 -->
      <path d="M 136 156 L 135 162" stroke-width="1.2" />
      <!-- Back leg 2 -->
      <path d="M 141 156 L 142 162" stroke-width="1.2" />
      <!-- Tail -->
      <path d="M 144 151 C 148 153, 150 158, 148 162" stroke-width="1.2" />
      <!-- Horn -->
      <path d="M 106 144 C 104 140, 106 137, 108 138" stroke-width="1.1" />
      <!-- Ear -->
      <path d="M 108 145 C 112 146, 114 148, 114 150" stroke-width="1.1" />
      <!-- Eye -->
      <circle cx="104" cy="148" r="0.5" fill="var(--forest)" stroke="none" />
    </g>

    <!-- Cow 2: cx=180, baselineY=162, scale=0.9 -->
    <g
      transform="translate(180 162) scale(0.9) translate(-180 -162)"
      fill="none"
      stroke="var(--forest)"
      stroke-width="1.4"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <!-- Body + head outline (with hump) -->
      <path d="M 162 156 C 160 150, 162 144, 166 144 C 166 140, 169 139, 170 142 C 170 144, 170 146, 168 147 L 170 149 C 174 147, 178 148, 182 149 C 188 148, 194 149, 198 150 C 202 151, 204 154, 204 156 L 204 156 L 162 156 Z" />
      <!-- Front leg 1 -->
      <path d="M 166 156 L 165 162" stroke-width="1.2" />
      <!-- Front leg 2 -->
      <path d="M 171 156 L 172 162" stroke-width="1.2" />
      <!-- Back leg 1 -->
      <path d="M 196 156 L 195 162" stroke-width="1.2" />
      <!-- Back leg 2 -->
      <path d="M 201 156 L 202 162" stroke-width="1.2" />
      <!-- Tail -->
      <path d="M 204 151 C 208 153, 210 158, 208 162" stroke-width="1.2" />
      <!-- Horn -->
      <path d="M 166 144 C 164 140, 166 137, 168 138" stroke-width="1.1" />
      <!-- Ear -->
      <path d="M 168 145 C 172 146, 174 148, 174 150" stroke-width="1.1" />
      <!-- Eye -->
      <circle cx="164" cy="148" r="0.5" fill="var(--forest)" stroke="none" />
    </g>

    <!-- Cow 3: cx=370, baselineY=178, scale=0.7 -->
    <g
      transform="translate(370 178) scale(0.7) translate(-370 -178)"
      fill="none"
      stroke="var(--forest)"
      stroke-width="1.4"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <!-- Body + head outline (with hump) -->
      <path d="M 352 172 C 350 166, 352 160, 356 160 C 356 156, 359 155, 360 158 C 360 160, 360 162, 358 163 L 360 165 C 364 163, 368 164, 372 165 C 378 164, 384 165, 388 166 C 392 167, 394 170, 394 172 L 394 172 L 352 172 Z" />
      <!-- Front leg 1 -->
      <path d="M 356 172 L 355 178" stroke-width="1.2" />
      <!-- Front leg 2 -->
      <path d="M 361 172 L 362 178" stroke-width="1.2" />
      <!-- Back leg 1 -->
      <path d="M 386 172 L 385 178" stroke-width="1.2" />
      <!-- Back leg 2 -->
      <path d="M 391 172 L 392 178" stroke-width="1.2" />
      <!-- Tail -->
      <path d="M 394 167 C 398 169, 400 174, 398 178" stroke-width="1.2" />
      <!-- Horn -->
      <path d="M 356 160 C 354 156, 356 153, 358 154" stroke-width="1.1" />
      <!-- Ear -->
      <path d="M 358 161 C 362 162, 364 164, 364 166" stroke-width="1.1" />
      <!-- Eye -->
      <circle cx="354" cy="164" r="0.5" fill="var(--forest)" stroke="none" />
    </g>

    <!-- Small tree (left side) -->
    <path d="M 30 162 L 30 130" stroke-width="1.5" />
    <!-- Tree canopy — irregular rounded shape -->
    <path d="M 30 130 C 16 128 8 116 14 104 C 10 96 18 86 28 90 C 30 80 44 78 50 88 C 58 84 66 92 60 100 C 68 108 62 124 50 126 C 44 132 34 132 30 130 Z" stroke-width="1.4" />
    <!-- Canopy detail veins -->
    <path d="M 30 130 L 30 116" stroke-width="0.9" opacity="0.55" />
    <path d="M 30 122 L 22 112" stroke-width="0.7" opacity="0.4" />
    <path d="M 30 122 L 38 112" stroke-width="0.7" opacity="0.4" />

    <!-- Ground line -->
    <path d="M 0 165 L 400 165" stroke-width="1.5" />
    <!-- Lower ground subtle line -->
    <path d="M 0 175 L 400 175" stroke-width="0.9" opacity="0.4" />

    <!-- Foreground grass tufts -->
    <g stroke-width="1.1" opacity="0.8">
      <path d="M 60 165 L 60 170" />
      <path d="M 62 165 L 62 170" />
      <path d="M 64 165 L 64 171" />
      <path d="M 150 165 L 150 170" />
      <path d="M 152 165 L 152 170" />
      <path d="M 154 165 L 154 171" />
      <path d="M 240 165 L 240 170" />
      <path d="M 242 165 L 242 170" />
      <path d="M 244 165 L 244 171" />
      <path d="M 320 165 L 320 170" />
      <path d="M 322 165 L 322 170" />
      <path d="M 324 165 L 324 171" />
      <path d="M 395 165 L 395 170" />
      <path d="M 397 165 L 397 170" />
    </g>

    <!-- Distant ground line / horizon -->
    <path d="M 0 158 L 400 158" stroke-width="0.9" opacity="0.35" />

    <!-- Tiny birds in the distance (3 small v-shapes) -->
    <g stroke-width="1" opacity="0.5">
      <path d="M 270 50 L 274 47 L 278 50" />
      <path d="M 295 38 L 298 35 L 301 38" />
      <path d="M 320 52 L 323 49 L 326 52" />
    </g>

    <!-- Sun low on horizon (small circle) -->
    <circle cx="360" cy="36" r="6" stroke-width="1.2" />
    <!-- Sun ray suggestion (3 short rays) -->
    <path d="M 360 26 L 360 22" stroke-width="1" opacity="0.6" />
    <path d="M 350 32 L 346 28" stroke-width="1" opacity="0.6" />
    <path d="M 370 32 L 374 28" stroke-width="1" opacity="0.6" />
  </g>
</svg>
