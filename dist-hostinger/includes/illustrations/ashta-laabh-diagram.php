<?php
/**
 * Illustration: Ashta-Laabh radial diagram (8 benefits around a central cow mark)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/ashta-laabh-diagram.tsx
 *
 * NOTE: The original TSX computes icon positions from a cx/cy/ringRadius triple
 * via JavaScript template literals and Array.from(). This PHP port pre-computes
 * those coordinates (cx=160, cy=160, ringRadius=110, 0.707*110=77.77) so the
 * rendered SVG is byte-for-byte equivalent to the React output.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 320 320" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Eight benefits radial diagram</title>

  <!-- Outer subtle ring connecting all icons -->
  <circle
    cx="160"
    cy="160"
    r="110"
    fill="none"
    stroke="var(--forest)"
    stroke-width="0.8"
    opacity="0.3"
  />

  <!-- Connector lines from center to each icon (dashed haldi) -->
  <g
    fill="none"
    stroke="var(--haldi-deep)"
    stroke-width="1"
    stroke-dasharray="2 3"
    opacity="0.6"
  >
    <line x1="160" y1="160" x2="160" y2="50" />
    <line x1="160" y1="160" x2="237.77" y2="82.23" />
    <line x1="160" y1="160" x2="270" y2="160" />
    <line x1="160" y1="160" x2="237.77" y2="237.77" />
    <line x1="160" y1="160" x2="160" y2="270" />
    <line x1="160" y1="160" x2="82.23" y2="237.77" />
    <line x1="160" y1="160" x2="50" y2="160" />
    <line x1="160" y1="160" x2="82.23" y2="82.23" />
  </g>

  <!-- Tiny decorative dots on the ring between icons -->
  <g fill="var(--haldi)" stroke="none">
    <circle cx="199.8" cy="63.91" r="1.5" />
    <circle cx="256.09" cy="120.2" r="1.5" />
    <circle cx="256.09" cy="199.8" r="1.5" />
    <circle cx="199.8" cy="256.09" r="1.5" />
    <circle cx="120.2" cy="256.09" r="1.5" />
    <circle cx="63.91" cy="199.8" r="1.5" />
    <circle cx="63.91" cy="120.2" r="1.5" />
    <circle cx="120.2" cy="63.91" r="1.5" />
  </g>

  <!-- Central cow mark — simplified -->
  <g>
    <!-- Inner haldi disc backdrop for cow mark -->
    <circle
      cx="160"
      cy="160"
      r="38"
      fill="var(--haldi)"
      stroke="var(--forest)"
      stroke-width="1.5"
      opacity="0.95"
    />
    <circle
      cx="160"
      cy="160"
      r="32"
      fill="none"
      stroke="var(--forest)"
      stroke-width="0.7"
      opacity="0.4"
    />
    <!-- Tiny cow head silhouette inside the disc (forest strokes) -->
    <g
      fill="none"
      stroke="var(--forest)"
      stroke-width="1.5"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <!-- Left horn -->
      <path d="M 148 152 C 142 144, 138 140, 136 142" />
      <!-- Right horn -->
      <path d="M 172 152 C 178 144, 182 140, 184 142" />
      <!-- Left ear -->
      <path d="M 146 156 C 140 158, 136 164, 138 168" />
      <!-- Right ear -->
      <path d="M 174 156 C 180 158, 184 164, 182 168" />
      <!-- Head outline -->
      <path d="M 160 148 C 152 148, 146 151, 146 156 C 146 164, 148 170, 152 174 C 156 177, 164 177, 168 174 C 172 170, 174 164, 174 156 C 174 151, 168 148, 160 148 Z" />
      <!-- Muzzle line -->
      <path d="M 152 168 Q 160 170 168 168" stroke-width="1.1" opacity="0.7" />
    </g>
    <!-- Eyes -->
    <circle cx="155" cy="160" r="1.4" fill="var(--forest)" />
    <circle cx="165" cy="160" r="1.4" fill="var(--forest)" />
    <!-- Nostrils -->
    <circle cx="157" cy="170" r="1" fill="var(--forest)" />
    <circle cx="163" cy="170" r="1" fill="var(--forest)" />
  </g>

  <!-- Icon 1 — Sun (top, 160, 50) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <circle cx="160" cy="50" r="7" />
    <path d="M 160 38 L 160 34" />
    <path d="M 168 42 L 172 38" />
    <path d="M 152 42 L 148 38" />
    <path d="M 172 50 L 176 50" />
    <path d="M 148 50 L 144 50" />
  </g>

  <!-- Icon 2 — Leaf (top-right, 237.77, 82.23) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 233.77 86.23 C 231.77 78.23, 241.77 74.23, 245.77 80.23 C 241.77 86.23, 235.77 88.23, 233.77 86.23 Z" />
    <path d="M 233.77 86.23 C 237.77 82.23, 241.77 80.23, 245.77 80.23" stroke-width="1" opacity="0.7" />
  </g>

  <!-- Icon 3 — Drop (right, 270, 160) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 270 150 C 263 158, 263 164, 270 164 C 277 164, 277 158, 270 150 Z" />
    <path d="M 267 162 Q 270 164 273 162" stroke-width="0.9" opacity="0.6" />
  </g>

  <!-- Icon 4 — Wall (bottom-right, 237.77, 237.77) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 227.77 229.77 L 247.77 229.77 L 247.77 245.77 L 227.77 245.77 Z" />
    <path d="M 227.77 237.77 L 247.77 237.77" stroke-width="0.9" />
    <path d="M 237.77 229.77 L 237.77 237.77" stroke-width="0.9" />
    <path d="M 232.77 237.77 L 232.77 245.77" stroke-width="0.9" />
    <path d="M 242.77 237.77 L 242.77 245.77" stroke-width="0.9" />
  </g>

  <!-- Icon 5 — Sprout (bottom, 160, 270) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 160 278 L 160 266" />
    <path d="M 160 270 C 156 268, 152 266, 152 262 C 156 264, 158 266, 160 268" />
    <path d="M 160 268 C 164 266, 168 264, 168 260 C 164 262, 162 264, 160 266" />
    <!-- Soil line -->
    <path d="M 152 278 L 168 278" stroke-width="1.2" />
  </g>

  <!-- Icon 6 — Heart (bottom-left, 82.23, 237.77) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 82.23 243.77 C 76.23 239.77, 72.23 233.77, 76.23 231.77 C 79.23 230.77, 81.23 232.77, 82.23 235.77 C 83.23 232.77, 85.23 230.77, 88.23 231.77 C 92.23 233.77, 88.23 239.77, 82.23 243.77 Z" />
  </g>

  <!-- Icon 7 — Home (left, 50, 160) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 40 162 L 50 152 L 60 162 L 60 168 L 40 168 Z" />
    <path d="M 47 168 L 47 162 L 53 162 L 53 168" stroke-width="1.1" />
  </g>

  <!-- Icon 8 — Branch / leafy sprig (top-left, 82.23, 82.23) -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <path d="M 82.23 90.23 L 82.23 72.23" />
    <path d="M 82.23 84.23 C 78.23 82.23, 74.23 78.23, 76.23 74.23 C 80.23 76.23, 80.23 80.23, 82.23 82.23" />
    <path d="M 82.23 78.23 C 86.23 76.23, 90.23 74.23, 88.23 70.23 C 84.23 72.23, 84.23 74.23, 82.23 76.23" />
  </g>

  <!-- Labels under each icon -->
  <g
    font-family="Georgia, serif"
    font-weight="700"
    font-size="8"
    fill="var(--forest)"
    opacity="0.85"
  >
    <text x="160" y="32" text-anchor="middle">Solar</text>
    <text x="237.77" y="64.23" text-anchor="middle">Herbal</text>
    <text x="288" y="163" text-anchor="start">Low-water</text>
    <text x="237.77" y="255.77" text-anchor="middle">Breathes</text>
    <text x="160" y="288" text-anchor="middle">Biodeg.</text>
    <text x="82.23" y="255.77" text-anchor="middle">Safe-air</text>
    <text x="32" y="163" text-anchor="end">Indoor</text>
    <text x="82.23" y="64.23" text-anchor="middle">Natural</text>
  </g>
</svg>
