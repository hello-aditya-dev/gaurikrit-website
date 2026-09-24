<?php
/**
 * Illustration: Indian courtyard wall (limewashed wall with arched opening)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/indian-courtyard.tsx
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 320 240" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Indian courtyard wall</title>

  <!-- Limewashed wall section — subtle fill -->
  <rect
    x="20"
    y="20"
    width="280"
    height="180"
    fill="var(--secondary)"
    stroke="var(--forest)"
    stroke-width="1.75"
    stroke-linejoin="round"
  />

  <!-- Wall top cornice line — architectural molding -->
  <path
    d="M 20 30 L 300 30"
    stroke="var(--forest)"
    stroke-width="1.1"
    opacity="0.5"
  />
  <path
    d="M 20 26 L 300 26"
    stroke="var(--forest)"
    stroke-width="0.8"
    opacity="0.3"
  />

  <!-- Wall texture — subtle horizontal limewash lines -->
  <g stroke="var(--forest)" stroke-width="0.5" opacity="0.18">
    <path d="M 30 50 L 120 50" />
    <path d="M 200 50 L 290 50" />
    <path d="M 30 95 L 50 95" />
    <path d="M 200 95 L 215 95" />
    <path d="M 30 130 L 50 130" />
    <path d="M 200 130 L 215 130" />
    <path d="M 30 165 L 50 165" />
    <path d="M 200 165 L 215 165" />
  </g>

  <!-- Haldi painted field on right side of wall (colorwashed section) -->
  <rect
    x="220"
    y="36"
    width="65"
    height="148"
    fill="var(--haldi)"
    stroke="var(--forest)"
    stroke-width="1.4"
    opacity="0.92"
  />

  <!-- Chunari/border pattern on haldi field — scalloped border at top -->
  <path
    d="M 222 48 Q 227 44 232 48 Q 237 44 242 48 Q 247 44 252 48 Q 257 44 262 48 Q 267 44 272 48 Q 277 44 283 48"
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.1"
    opacity="0.6"
  />
  <!-- Chunari/border pattern at bottom -->
  <path
    d="M 222 172 Q 227 176 232 172 Q 237 176 242 172 Q 247 176 252 172 Q 257 176 262 172 Q 267 176 272 172 Q 277 176 283 172"
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.1"
    opacity="0.6"
  />
  <!-- Vertical motif lines on haldi field -->
  <g stroke="var(--forest)" stroke-width="0.7" opacity="0.4">
    <path d="M 235 60 L 235 160" />
    <path d="M 252 60 L 252 160" />
    <path d="M 269 60 L 269 160" />
  </g>
  <!-- Central dot motif on haldi field -->
  <circle cx="252" cy="110" r="3" fill="var(--forest)" opacity="0.7" />
  <circle cx="252" cy="110" r="5" fill="none" stroke="var(--forest)" stroke-width="0.8" opacity="0.55" />

  <!-- Arched opening (central doorway) — Indian cusped arch -->
  <path
    d="M 130 200 L 130 80 C 130 64 138 54 150 52 C 152 56 152 60 150 62 C 156 60 160 56 160 54 C 162 50 170 50 172 54 C 170 56 168 60 170 62 C 176 60 184 64 188 70 C 192 76 190 80 190 80 L 190 200 Z"
    fill="var(--background)"
    stroke="var(--forest)"
    stroke-width="1.75"
    stroke-linejoin="round"
  />
  <!-- Arch inner edge detail — second stroke for depth -->
  <path
    d="M 134 200 L 134 82 C 134 68 140 60 150 58"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.9"
    opacity="0.5"
  />
  <path
    d="M 186 200 L 186 82 C 186 68 180 60 170 58"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.9"
    opacity="0.5"
  />

  <!-- Threshold line at base of opening -->
  <path
    d="M 130 200 L 190 200"
    stroke="var(--forest)"
    stroke-width="1.4"
    opacity="0.7"
  />

  <!-- Small wall niche (left side, smaller arched indentation) -->
  <path
    d="M 60 145 L 60 110 C 60 100 64 96 72 94 C 74 96 74 98 72 99 C 76 98 78 96 78 94 C 82 93 86 95 88 99 C 89 103 88 105 88 105 L 88 145 Z"
    fill="var(--background)"
    stroke="var(--forest)"
    stroke-width="1.5"
    stroke-linejoin="round"
  />
  <!-- Niche inner detail line -->
  <path
    d="M 63 145 L 63 112 C 63 104 67 98 72 97"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.7"
    opacity="0.5"
  />
  <!-- Small niche sill -->
  <path
    d="M 58 147 L 90 147"
    stroke="var(--forest)"
    stroke-width="1.2"
    opacity="0.6"
  />

  <!-- Floor / step at the bottom of the wall -->
  <path
    d="M 0 200 L 320 200"
    stroke="var(--forest)"
    stroke-width="1.75"
  />
  <!-- Lower step -->
  <path
    d="M 20 215 L 300 215"
    stroke="var(--forest)"
    stroke-width="1.25"
    opacity="0.65"
  />
  <!-- Floor ground line at very bottom -->
  <path
    d="M 0 228 L 320 228"
    stroke="var(--forest)"
    stroke-width="1"
    opacity="0.4"
  />

  <!-- Subtle shadow inside the opening (depth) -->
  <path
    d="M 132 200 L 132 84 C 132 72 138 64 148 60"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.5"
    opacity="0.18"
  />

  <!-- Small grass tuft at base of step -->
  <g stroke="var(--forest)" stroke-width="1.1" opacity="0.7">
    <path d="M 30 228 L 30 232" />
    <path d="M 32 228 L 32 232" />
    <path d="M 34 228 L 34 232" />
    <path d="M 280 228 L 280 232" />
    <path d="M 282 228 L 282 232" />
    <path d="M 284 228 L 284 232" />
  </g>
</svg>
