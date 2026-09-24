<?php
/**
 * Illustration: Rural landscape (thin horizontal field line)
 * Coded SVG — no photography dependency.
 * V2 finish pass — disciplined editorial agricultural line drawing.
 *
 * Low horizon line. 2-3 gentle rolling field contours. A few precise
 * grass tufts (deliberate botanical marks, not random squiggles). One
 * distant tree silhouette (small, simple). Subtle plinth/ground line.
 * Line weight 1.2px. Very minimal — extends across the bottom of hero.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 640 80" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Rural landscape</title>

  <g fill="none" stroke="var(--forest)"
     stroke-width="1.2" stroke-linecap="round"
     stroke-linejoin="round">

    <!-- DISTANT FIELD LINE — back layer, very faint -->
    <path d="M 0 32 C 100 28, 200 32, 320 30 S 540 30, 640 30"
          stroke-width="1" opacity="0.4"/>

    <!-- MID FIELD LINE — gentle rolling, slightly more visible -->
    <path d="M 0 44 C 120 40, 240 44, 360 42 S 560 42, 640 44"
          stroke-width="1.1" opacity="0.6"/>

    <!-- MAIN HORIZON LINE — most prominent -->
    <path d="M 0 54 C 100 50, 200 54, 320 52 S 540 52, 640 54"
          stroke-width="1.2"/>

    <!-- DISTANT TREE SILHOUETTE — one only, small and simple -->
    <!-- Trunk -->
    <path d="M 440 54 L 440 38" stroke-width="1.1" opacity="0.85"/>
    <!-- Canopy — small irregular rounded shape -->
    <path d="M 432 42
             C 428 36, 432 30, 438 30
             C 440 26, 446 26, 448 30
             C 454 28, 458 32, 456 38
             C 458 42, 454 44, 448 42
             C 444 44, 436 44, 432 42 Z"
          stroke-width="1" opacity="0.85"/>

    <!-- PLINTH / GROUND LINE — lower, grounding the foreground -->
    <path d="M 0 64 L 640 64" stroke-width="1" opacity="0.5"/>

    <!-- PRECISE GRASS TUFTS — deliberate botanical marks (not random squiggles).
         Each tuft has 3 deliberate blades. Placement is rhythmic, not random. -->
    <g stroke-width="1.2">
      <!-- tuft 1 -->
      <path d="M 60 64 L 58 58"/>
      <path d="M 60 64 L 60 56"/>
      <path d="M 60 64 L 62 58"/>
      <!-- tuft 2 -->
      <path d="M 140 64 L 138 58"/>
      <path d="M 140 64 L 140 56"/>
      <path d="M 140 64 L 142 58"/>
      <!-- tuft 3 -->
      <path d="M 220 64 L 218 58"/>
      <path d="M 220 64 L 220 56"/>
      <path d="M 220 64 L 222 58"/>
      <!-- tuft 4 -->
      <path d="M 320 64 L 318 58"/>
      <path d="M 320 64 L 320 56"/>
      <path d="M 320 64 L 322 58"/>
      <!-- tuft 5 — slight variant: 2 blades only, for rhythm variation -->
      <path d="M 380 64 L 378 59"/>
      <path d="M 380 64 L 382 59"/>
      <!-- tuft 6 -->
      <path d="M 520 64 L 518 58"/>
      <path d="M 520 64 L 520 56"/>
      <path d="M 520 64 L 522 58"/>
      <!-- tuft 7 — at far right -->
      <path d="M 590 64 L 588 58"/>
      <path d="M 590 64 L 590 56"/>
      <path d="M 590 64 L 592 58"/>
    </g>

    <!-- ONE LONGER GRASS BLADE — for compositional accent (deliberate) -->
    <path d="M 260 64 C 258 56, 256 50, 258 46" stroke-width="1.2" opacity="0.85"/>

  </g>
</svg>
