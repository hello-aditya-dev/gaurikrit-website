<?php
/**
 * Illustration: Gaurikrit cow mark (front-facing cow-head in scalloped emblem)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/gaurikrit-cow-mark.tsx
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Gaurikrit cow mark</title>

  <!-- Scalloped floral emblem — haldi fill -->
  <path
    d="M 98.8 76.1 Q 112 60 98.8 43.9 Q 96.8 23.2 76.1 21.2 Q 60 8 43.9 21.2 Q 23.2 23.2 21.2 43.9 Q 8 60 21.2 76.1 Q 23.2 96.8 43.9 98.8 Q 60 112 76.1 98.8 Q 96.8 96.8 98.8 76.1 Z"
    fill="var(--haldi)"
    stroke="var(--forest)"
    stroke-width="1.75"
    stroke-linejoin="round"
  />

  <!-- Inner accent ring — very subtle -->
  <circle
    cx="60"
    cy="60"
    r="44"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.8"
    opacity="0.35"
  />

  <g fill="none" stroke="var(--forest)" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
    <!-- Left horn — curves up and outward -->
    <path d="M 50 32 C 42 24 34 20 30 22 C 28 23 28 26 31 27 C 38 29 45 31 50 33" />
    <!-- Right horn — mirror -->
    <path d="M 70 32 C 78 24 86 20 90 22 C 92 23 92 26 89 27 C 82 29 75 31 70 33" />

    <!-- Left ear — long, hanging out -->
    <path d="M 46 40 C 36 46 28 56 26 66 C 30 66 36 62 42 56 C 46 50 48 44 48 40 Z" />
    <!-- Right ear — mirror -->
    <path d="M 74 40 C 84 46 92 56 94 66 C 90 66 84 62 78 56 C 74 50 72 44 72 40 Z" />

    <!-- Head outline (front-facing, prominent forehead) -->
    <path d="M 60 30 C 52 30 46 33 44 38 C 42 42 42 50 44 56 C 46 64 48 70 50 74 C 54 78 56 82 60 84 C 64 82 66 78 70 74 C 72 70 74 64 76 56 C 78 50 78 42 76 38 C 74 33 68 30 60 30 Z" />

    <!-- Forehead crest line — subtle vertical center crease -->
    <path d="M 60 33 L 60 44" stroke-width="1.1" opacity="0.55" />
    <!-- Forehead bulge definition -->
    <path d="M 54 36 Q 60 38 66 36" stroke-width="1.1" opacity="0.55" />

    <!-- Muzzle band line (separating muzzle from face) -->
    <path d="M 48 70 Q 60 74 72 70" stroke-width="1.3" opacity="0.75" />

    <!-- Mouth -->
    <path d="M 54 80 Q 60 82 66 80" stroke-width="1.3" opacity="0.75" />
  </g>

  <!-- Eyes — two small filled dots -->
  <circle cx="53" cy="50" r="1.7" fill="var(--forest)" />
  <circle cx="67" cy="50" r="1.7" fill="var(--forest)" />

  <!-- Nostrils — two small filled dots -->
  <circle cx="55" cy="77" r="1.2" fill="var(--forest)" />
  <circle cx="65" cy="77" r="1.2" fill="var(--forest)" />
</svg>
