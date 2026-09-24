<?php
/**
 * Illustration: Indian courtyard wall (limewashed wall with arched opening)
 * Coded SVG — no photography dependency.
 * V2 finish pass — architectural elevation-quality study.
 *
 * Wall with physical depth (double line at top edge suggesting
 * thickness). Base plinth line. Cusped ogee arch opening (Indian /
 * Sultanate style). Wall surface articulation: subtle horizontal
 * limewash plaster lines. Painted colour field (haldi colorwash
 * section). Believable proportions: door height ~2x width, arch spring
 * line at ~60% of height. Minimal but realistic.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 360 280" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Indian courtyard wall</title>

  <!-- WALL SURFACE — limewash fill (subtle ground for the whole elevation) -->
  <rect x="20" y="30" width="320" height="190"
        fill="var(--limewash)" stroke="none"/>

  <!-- PAINTED COLOUR FIELD — haldi colorwash section on the right portion of wall.
       Suggests a painted wall surface (the colour of India). -->
  <rect x="240" y="36" width="92" height="178"
        fill="var(--haldi)" opacity="0.55" stroke="none"/>

  <!-- WALL OUTLINE — single clean stroke around the whole wall -->
  <rect x="20" y="30" width="320" height="190"
        fill="none" stroke="var(--forest)"
        stroke-width="1.5" stroke-linejoin="miter"/>

  <!-- WALL TOP — DOUBLE LINE suggesting physical wall thickness (parapet/cornice) -->
  <path d="M 20 30 L 340 30"
        stroke="var(--forest)" stroke-width="1.5"
        stroke-linecap="square"/>
  <path d="M 20 36 L 340 36"
        stroke="var(--forest)" stroke-width="1.2" opacity="0.65"
        stroke-linecap="square"/>

  <!-- WALL SURFACE ARTICULATION — subtle horizontal limewash plaster layer lines.
       Scattered, short segments (not full lines) for restraint. -->
  <g stroke="var(--forest)" stroke-width="0.5" opacity="0.18"
     stroke-linecap="round">
    <!-- Left side of wall (limewash section) -->
    <path d="M 30 60 L 130 60"/>
    <path d="M 30 90 L 50 90"/>
    <path d="M 100 90 L 130 90"/>
    <path d="M 30 120 L 50 120"/>
    <path d="M 30 150 L 50 150"/>
    <path d="M 30 180 L 50 180"/>
    <!-- Right side (haldi colorwash section) — slightly more visible against the colour -->
    <path d="M 250 60 L 330 60" opacity="0.6"/>
    <path d="M 250 90 L 330 90" opacity="0.6"/>
    <path d="M 250 120 L 330 120" opacity="0.6"/>
    <path d="M 250 150 L 330 150" opacity="0.6"/>
    <path d="M 250 180 L 330 180" opacity="0.6"/>
  </g>

  <!-- PAINTED FIELD BORDER — subtle vertical edge where colorwash meets limewash -->
  <path d="M 240 36 L 240 214"
        stroke="var(--forest)" stroke-width="0.8" opacity="0.4"/>

  <!-- ARCHED OPENING — cusped ogee arch (Indian/Sultanate style).
       Opening: x=140 to x=220 (width 80), y=60 apex to y=220 base (height 160).
       Door height ~2x width ✓. Spring line at y=124 (60% of height from base) ✓.
       Fill with background tone to suggest a recessed void. -->
  <path d="M 140 124
           C 148 100, 152 92, 162 88
           C 172 84, 176 76, 180 60
           C 184 76, 188 84, 198 88
           C 208 92, 212 100, 220 124
           L 220 220
           L 140 220
           Z"
        fill="var(--background)" stroke="var(--forest)"
        stroke-width="1.5" stroke-linejoin="round"/>

  <!-- ARCH INNER EDGE — second stroke suggesting jamb depth (recessed opening) -->
  <path d="M 144 124
           C 150 102, 154 94, 162 90
           C 172 86, 176 78, 180 64
           C 184 78, 188 86, 198 90
           C 206 94, 210 102, 216 124
           L 216 220"
        fill="none" stroke="var(--forest)"
        stroke-width="0.8" opacity="0.45"/>

  <!-- THRESHOLD LINE — at the base of the opening (slight step) -->
  <path d="M 138 220 L 222 220"
        stroke="var(--forest)" stroke-width="1.4" opacity="0.7"/>

  <!-- INNER SHADOW LINE — at the back of the recessed opening, suggesting depth -->
  <path d="M 146 220 L 146 130"
        stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>

  <!-- PLINTH AT BASE OF WALL — double line suggesting base thickness -->
  <path d="M 20 220 L 340 220"
        stroke="var(--forest)" stroke-width="1.5"
        stroke-linecap="square"/>
  <path d="M 20 228 L 340 228"
        stroke="var(--forest)" stroke-width="1.2" opacity="0.65"
        stroke-linecap="square"/>

  <!-- FLOOR GROUND LINE — at very bottom -->
  <path d="M 0 240 L 360 240"
        stroke="var(--forest)" stroke-width="1" opacity="0.4"/>

  <!-- SMALL GRASS TUFTS at base of step — restrained, deliberate -->
  <g stroke="var(--forest)" stroke-width="1" opacity="0.6"
     stroke-linecap="round">
    <path d="M 40 240 L 40 244"/>
    <path d="M 42 240 L 42 244"/>
    <path d="M 44 240 L 44 245"/>
    <path d="M 280 240 L 280 244"/>
    <path d="M 282 240 L 282 244"/>
    <path d="M 284 240 L 284 245"/>
  </g>

</svg>
