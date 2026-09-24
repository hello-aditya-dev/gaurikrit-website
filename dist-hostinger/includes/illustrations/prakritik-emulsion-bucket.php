<?php
/**
 * Illustration: Prakritik Emulsion bucket (taller front-facing white cylindrical bucket)
 * Coded SVG — no photography dependency.
 * Ported from src/components/illustrations/prakritik-emulsion-bucket.tsx
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 200 260" xmlns="http://www.w3.org/2000/svg" class="<?= htmlspecialchars($class, ENT_QUOTES) ?>" role="img" aria-hidden="true" preserveAspectRatio="xMidYMid meet" width="100%" height="100%">
  <title>Prakritik Emulsion bucket</title>

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

  <!-- Liquid paint drip at rim — small wobble of haldi paint over the rim -->
  <path
    d="M 50 62 C 55 70 52 78 58 76 C 62 75 60 68 62 64"
    fill="var(--haldi)"
    stroke="var(--forest)"
    stroke-width="1.2"
    stroke-linejoin="round"
  />
  <path
    d="M 138 64 C 142 70 140 78 146 76 C 150 75 148 68 152 64"
    fill="var(--haldi)"
    stroke="var(--forest)"
    stroke-width="1.2"
    stroke-linejoin="round"
  />
  <!-- Small drip bead on right side -->
  <circle cx="150" cy="82" r="2.2" fill="var(--haldi)" stroke="var(--forest)" stroke-width="0.8" />

  <!-- Bucket body — taller, white, slightly tapered -->
  <path
    d="M 38 60 L 50 228 C 75 235 125 235 150 228 L 162 60 Z"
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
  <!-- Inner opening (inside of bucket) -->
  <ellipse
    cx="100"
    cy="57"
    rx="55"
    ry="5.5"
    fill="var(--secondary)"
    opacity="0.85"
  />
  <!-- Paint surface inside — haldi tinted -->
  <ellipse
    cx="100"
    cy="57"
    rx="50"
    ry="4"
    fill="var(--haldi)"
    opacity="0.4"
  />

  <!-- Bottom front curve -->
  <path
    d="M 50 228 C 60 234 140 234 150 228"
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
    <path d="M 78 110 C 76 106 75 102 76 98 C 77 94 80 93 82 95 C 82 90 84 89 86 92 C 86 95 86 98 84 99 L 86 101 C 88 99 90 98 92 98 C 95 96 100 96 105 98 L 116 98 C 120 98 122 100 122 104 L 122 110 Z" />
    <!-- Cow legs -->
    <path d="M 82 110 L 81 120" stroke-width="1.2" />
    <path d="M 88 110 L 89 120" stroke-width="1.2" />
    <path d="M 115 110 L 114 120" stroke-width="1.2" />
    <path d="M 121 110 L 122 120" stroke-width="1.2" />
    <!-- Cow tail -->
    <path d="M 122 104 C 126 106 128 112 126 116" stroke-width="1.2" />
    <!-- Cow eye -->
    <circle cx="79" cy="101" r="0.6" fill="var(--forest)" stroke="none" />
  </g>

  <!-- Haldi accent stripe (upper) -->
  <path
    d="M 44 124 L 156 124"
    stroke="var(--haldi-deep)"
    stroke-width="2.2"
    stroke-linecap="round"
  />
  <!-- Haldi accent stripe (lower) -->
  <path
    d="M 47 196 L 153 196"
    stroke="var(--haldi-deep)"
    stroke-width="2.2"
    stroke-linecap="round"
  />

  <!-- Dark-green label band (taller for emulsion) -->
  <path
    d="M 44 128 L 47 192 L 153 192 L 156 128 C 120 132 80 132 44 128 Z"
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
    font-size="13"
    fill="var(--haldi)"
    letter-spacing="1.5"
  >GAURIKRIT</text>
  <!-- Subtitle line 1 -->
  <text
    x="100"
    y="167"
    text-anchor="middle"
    font-family="Georgia, serif"
    font-weight="700"
    font-size="7.5"
    fill="var(--haldi)"
    letter-spacing="1.6"
  >PRAKRITIK</text>
  <!-- Subtitle line 2 -->
  <text
    x="100"
    y="181"
    text-anchor="middle"
    font-family="Georgia, serif"
    font-weight="700"
    font-size="7.5"
    fill="var(--haldi)"
    letter-spacing="1.6"
  >EMULSION</text>

  <!-- Small underline mark beneath wordmark -->
  <path
    d="M 78 156 L 122 156"
    stroke="var(--haldi)"
    stroke-width="0.8"
    opacity="0.5"
  />

  <!-- Subtle bucket sheen on left side -->
  <path
    d="M 56 70 L 62 220"
    stroke="var(--forest)"
    stroke-width="0.6"
    opacity="0.18"
  />
</svg>
