<?php
/**
 * Illustration: Rural landscape (thin horizontal field/grass line)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/rural-landscape.tsx
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 600 80" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Rural landscape</title>

  <g fill="none" stroke="var(--forest)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    <!-- Distant field line — back layer -->
    <path d="M 0 32 C 80 28 160 34 240 30 S 400 26 500 30 S 580 30 600 30" stroke-width="1.1" opacity="0.45" />

    <!-- Mid field line — gentle rolling -->
    <path d="M 0 42 C 100 38 200 44 300 40 S 500 36 600 42" stroke-width="1.25" opacity="0.7" />

    <!-- Main horizon line — most prominent -->
    <path d="M 0 50 C 80 46 160 52 240 48 S 380 44 460 48 S 540 48 600 50" stroke-width="1.5" />

    <!-- Foreground field division lines -->
    <path d="M 0 60 Q 150 56 300 60 T 600 58" stroke-width="1.1" opacity="0.55" />
    <path d="M 0 68 Q 200 64 400 68 T 600 66" stroke-width="1" opacity="0.4" />

    <!-- Distant tree silhouette on horizon -->
    <path d="M 430 50 L 430 36" stroke-width="1.4" />
    <path d="M 420 40 C 416 34 418 28 424 26 C 426 22 432 22 434 26 C 440 22 446 26 444 32 C 448 34 446 40 440 40 C 436 42 424 42 420 40 Z" stroke-width="1.3" opacity="0.85" />

    <!-- Second smaller distant tree -->
    <path d="M 120 52 L 120 44" stroke-width="1.2" opacity="0.65" />
    <path d="M 116 46 C 114 42 116 38 120 37 C 122 35 126 36 126 39 C 128 41 128 45 124 46 C 122 47 118 47 116 46 Z" stroke-width="1.1" opacity="0.6" />

    <!-- Grass tufts — distant (small) -->
    <g stroke-width="1" opacity="0.55">
      <!-- tuft [40, 50] -->
      <path d="M 40 50 L 39 47" />
      <path d="M 40 50 L 41 47" />
      <path d="M 40 50 L 40 46" />
      <!-- tuft [85, 49] -->
      <path d="M 85 49 L 84 46" />
      <path d="M 85 49 L 86 46" />
      <path d="M 85 49 L 85 45" />
      <!-- tuft [165, 51] -->
      <path d="M 165 51 L 164 48" />
      <path d="M 165 51 L 166 48" />
      <path d="M 165 51 L 165 47" />
      <!-- tuft [210, 49] -->
      <path d="M 210 49 L 209 46" />
      <path d="M 210 49 L 211 46" />
      <path d="M 210 49 L 210 45" />
      <!-- tuft [260, 50] -->
      <path d="M 260 50 L 259 47" />
      <path d="M 260 50 L 261 47" />
      <path d="M 260 50 L 260 46" />
      <!-- tuft [330, 49] -->
      <path d="M 330 49 L 329 46" />
      <path d="M 330 49 L 331 46" />
      <path d="M 330 49 L 330 45" />
      <!-- tuft [380, 51] -->
      <path d="M 380 51 L 379 48" />
      <path d="M 380 51 L 381 48" />
      <path d="M 380 51 L 380 47" />
      <!-- tuft [490, 50] -->
      <path d="M 490 50 L 489 47" />
      <path d="M 490 50 L 491 47" />
      <path d="M 490 50 L 490 46" />
      <!-- tuft [540, 49] -->
      <path d="M 540 49 L 539 46" />
      <path d="M 540 49 L 541 46" />
      <path d="M 540 49 L 540 45" />
      <!-- tuft [580, 50] -->
      <path d="M 580 50 L 579 47" />
      <path d="M 580 50 L 581 47" />
      <path d="M 580 50 L 580 46" />
    </g>

    <!-- Grass tufts — foreground (larger, more visible) -->
    <g stroke-width="1.2" opacity="0.8">
      <!-- tuft [30, 68] -->
      <path d="M 30 68 L 28 62" />
      <path d="M 30 68 L 32 62" />
      <path d="M 30 68 L 30 60" />
      <path d="M 29 68 L 27 64" opacity="0.7" />
      <path d="M 31 68 L 33 64" opacity="0.7" />
      <!-- tuft [70, 70] -->
      <path d="M 70 70 L 68 64" />
      <path d="M 70 70 L 72 64" />
      <path d="M 70 70 L 70 62" />
      <path d="M 69 70 L 67 66" opacity="0.7" />
      <path d="M 71 70 L 73 66" opacity="0.7" />
      <!-- tuft [110, 68] -->
      <path d="M 110 68 L 108 62" />
      <path d="M 110 68 L 112 62" />
      <path d="M 110 68 L 110 60" />
      <path d="M 109 68 L 107 64" opacity="0.7" />
      <path d="M 111 68 L 113 64" opacity="0.7" />
      <!-- tuft [180, 72] -->
      <path d="M 180 72 L 178 66" />
      <path d="M 180 72 L 182 66" />
      <path d="M 180 72 L 180 64" />
      <path d="M 179 72 L 177 68" opacity="0.7" />
      <path d="M 181 72 L 183 68" opacity="0.7" />
      <!-- tuft [230, 70] -->
      <path d="M 230 70 L 228 64" />
      <path d="M 230 70 L 232 64" />
      <path d="M 230 70 L 230 62" />
      <path d="M 229 70 L 227 66" opacity="0.7" />
      <path d="M 231 70 L 233 66" opacity="0.7" />
      <!-- tuft [290, 72] -->
      <path d="M 290 72 L 288 66" />
      <path d="M 290 72 L 292 66" />
      <path d="M 290 72 L 290 64" />
      <path d="M 289 72 L 287 68" opacity="0.7" />
      <path d="M 291 72 L 293 68" opacity="0.7" />
      <!-- tuft [340, 70] -->
      <path d="M 340 70 L 338 64" />
      <path d="M 340 70 L 342 64" />
      <path d="M 340 70 L 340 62" />
      <path d="M 339 70 L 337 66" opacity="0.7" />
      <path d="M 341 70 L 343 66" opacity="0.7" />
      <!-- tuft [400, 72] -->
      <path d="M 400 72 L 398 66" />
      <path d="M 400 72 L 402 66" />
      <path d="M 400 72 L 400 64" />
      <path d="M 399 72 L 397 68" opacity="0.7" />
      <path d="M 401 72 L 403 68" opacity="0.7" />
      <!-- tuft [450, 70] -->
      <path d="M 450 70 L 448 64" />
      <path d="M 450 70 L 452 64" />
      <path d="M 450 70 L 450 62" />
      <path d="M 449 70 L 447 66" opacity="0.7" />
      <path d="M 451 70 L 453 66" opacity="0.7" />
      <!-- tuft [510, 72] -->
      <path d="M 510 72 L 508 66" />
      <path d="M 510 72 L 512 66" />
      <path d="M 510 72 L 510 64" />
      <path d="M 509 72 L 507 68" opacity="0.7" />
      <path d="M 511 72 L 513 68" opacity="0.7" />
      <!-- tuft [560, 70] -->
      <path d="M 560 70 L 558 64" />
      <path d="M 560 70 L 562 64" />
      <path d="M 560 70 L 560 62" />
      <path d="M 559 70 L 557 66" opacity="0.7" />
      <path d="M 561 70 L 563 66" opacity="0.7" />
      <!-- tuft [585, 72] -->
      <path d="M 585 72 L 583 66" />
      <path d="M 585 72 L 587 66" />
      <path d="M 585 72 L 585 64" />
      <path d="M 584 72 L 582 68" opacity="0.7" />
      <path d="M 586 72 L 588 68" opacity="0.7" />
    </g>

    <!-- Small leafy sprig accents scattered along -->
    <path d="M 460 66 C 462 62 466 60 470 62 C 468 64 464 66 460 66 Z" stroke-width="1.1" opacity="0.7" />
    <path d="M 150 66 C 152 62 156 60 160 62 C 158 64 154 66 150 66 Z" stroke-width="1.1" opacity="0.7" />
  </g>
</svg>
