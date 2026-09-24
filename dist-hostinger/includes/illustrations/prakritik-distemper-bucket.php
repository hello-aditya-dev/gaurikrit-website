<?php
/**
 * Illustration: Prakritik Distemper bucket (front-facing white cylindrical bucket)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/prakritik-distemper-bucket.tsx
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 200 240" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Prakritik Distemper bucket</title>

  <!-- Bail / handle — metal arch -->
  <path
    d="M 40 60 Q 100 18 160 60"
    fill="none"
    stroke="var(--forest)"
    stroke-width="2"
    stroke-linecap="round"
  />
  <path
    d="M 44 60 Q 100 24 156 60"
    fill="none"
    stroke="var(--forest)"
    stroke-width="1"
    opacity="0.55"
  />
  <!-- Handle attachment lugs -->
  <circle cx="40" cy="60" r="2.5" fill="var(--forest)" />
  <circle cx="160" cy="60" r="2.5" fill="var(--forest)" />

  <!-- Bucket body — white, slightly tapered, with subtle inner shadow at base -->
  <path
    d="M 38 60 L 52 208 C 75 215 125 215 148 208 L 162 60 Z"
    fill="var(--card)"
    stroke="var(--forest)"
    stroke-width="1.75"
    stroke-linejoin="round"
  />

  <!-- Top rim ellipse — dark green -->
  <ellipse
    cx="100"
    cy="58"
    rx="62"
    ry="8"
    fill="var(--forest)"
    stroke="var(--forest)"
    stroke-width="1.5"
  />
  <!-- Inner opening (lighter limewash — inside of bucket visible) -->
  <ellipse
    cx="100"
    cy="57"
    rx="55"
    ry="5.5"
    fill="var(--secondary)"
    opacity="0.85"
  />
  <!-- Inner paint sheen line — haldi tint inside -->
  <ellipse
    cx="100"
    cy="57"
    rx="50"
    ry="4"
    fill="var(--haldi)"
    opacity="0.25"
  />

  <!-- Bottom front curve (subtle, suggesting cylinder base) -->
  <path
    d="M 52 208 C 60 214 140 214 148 208"
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.5"
    opacity="0.7"
  />

  <!-- Small cow-line motif on upper white body -->
  <g
    fill="none"
    stroke="var(--forest)"
    stroke-width="1.4"
    stroke-linecap="round"
    stroke-linejoin="round"
  >
    <!-- Tiny side-view cow silhouette with hump -->
    <path d="M 78 112 C 76 108 75 104 76 100 C 77 96 80 95 82 97 C 82 92 84 91 86 94 C 86 97 86 100 84 101 L 86 103 C 88 101 90 100 92 100 C 95 98 100 98 105 100 L 116 100 C 120 100 122 102 122 106 L 122 112 Z" />
    <!-- Cow legs -->
    <path d="M 82 112 L 81 122" stroke-width="1.2" />
    <path d="M 88 112 L 89 122" stroke-width="1.2" />
    <path d="M 115 112 L 114 122" stroke-width="1.2" />
    <path d="M 121 112 L 122 122" stroke-width="1.2" />
    <!-- Cow tail -->
    <path d="M 122 106 C 126 108 128 114 126 118" stroke-width="1.2" />
    <!-- Cow eye -->
    <circle cx="79" cy="103" r="0.6" fill="var(--forest)" stroke="none" />
  </g>

  <!-- Haldi accent stripe (upper) -->
  <path
    d="M 44 126 L 156 126"
    stroke="var(--haldi-deep)"
    stroke-width="2.2"
    stroke-linecap="round"
  />
  <!-- Haldi accent stripe (lower) -->
  <path
    d="M 47 176 L 153 176"
    stroke="var(--haldi-deep)"
    stroke-width="2.2"
    stroke-linecap="round"
  />

  <!-- Dark-green label band (cylinder-curved rectangle) -->
  <path
    d="M 44 130 L 47 172 L 153 172 L 156 130 C 120 134 80 134 44 130 Z"
    fill="var(--forest)"
    stroke="var(--forest)"
    stroke-width="1.5"
    stroke-linejoin="round"
  />

  <!-- Wordmark text -->
  <text
    x="100"
    y="150"
    text-anchor="middle"
    font-family="Georgia, serif"
    font-weight="700"
    font-size="12"
    fill="var(--haldi)"
    letter-spacing="1.5"
  >GAURIKRIT</text>
  <!-- Product name text -->
  <text
    x="100"
    y="165"
    text-anchor="middle"
    font-family="Georgia, serif"
    font-weight="700"
    font-size="6"
    fill="var(--haldi)"
    letter-spacing="1.2"
  >PRAKRITIK DISTEMPER</text>

  <!-- Small underline mark beneath wordmark -->
  <path
    d="M 78 154 L 122 154"
    stroke="var(--haldi)"
    stroke-width="0.8"
    opacity="0.5"
  />

  <!-- Subtle bucket highlight on left side (cylinder sheen) -->
  <path
    d="M 56 70 L 64 200"
    stroke="var(--forest)"
    stroke-width="0.6"
    opacity="0.18"
  />
</svg>
