<?php
/**
 * Illustration: Prakritik Distemper bucket
 * Coded SVG — no photography dependency.
 * V2 finish pass — disciplined cylindrical product tin.
 *
 * Stylised website product illustration.
 * Replace with approved product photography when supplied.
 * To swap with a photo: change the ProductVisual data field to
 * "/assets/products/prakritik-distemper.png"
 *
 * Accurate cylinder geometry: slight taper from rim (wider) to base
 * (narrower). Elliptical rim seen at slight angle. Metal bail handle
 * arched over the rim. Dark-green label band following the cylinder
 * curve (slightly curved, not a flat rectangle). Haldi accent stripes
 * above and below the band. Subtle vertical highlight on the left side
 * suggesting surface curvature (no glossy gradient). Simple geometric
 * mark (haldi dot) replaces any cartoon cow motif.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 220 280" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Prakritik Distemper bucket</title>

  <!-- BAIL / HANDLE — metal arch (drawn first, behind the rim) -->
  <path d="M 42 62 Q 110 22, 178 62"
        fill="none" stroke="var(--forest)"
        stroke-width="1.8" stroke-linecap="round"/>
  <!-- Handle inner line — subtle wire-thickness suggestion -->
  <path d="M 46 62 Q 110 28, 174 62"
        fill="none" stroke="var(--forest)"
        stroke-width="1" opacity="0.5"/>

  <!-- HANDLE ATTACHMENT LUGS — on the rim -->
  <circle cx="42" cy="62" r="3" fill="var(--forest)"/>
  <circle cx="178" cy="62" r="3" fill="var(--forest)"/>

  <!-- BUCKET BODY — tapered cylinder, paper-white fill.
       Top corners at the rim (x=40, x=180), bottom corners narrower (x=52, x=168) -->
  <path d="M 40 62
           L 52 250
           C 60 256, 160 256, 168 250
           L 180 62 Z"
        fill="var(--paper)" stroke="var(--forest)"
        stroke-width="1.5" stroke-linejoin="round"/>

  <!-- SUBTLE VERTICAL HIGHLIGHT on the LEFT side of the cylinder (curve suggestion).
       No glossy gradient — just a faint single line at 0.12 opacity. -->
  <path d="M 56 80 L 64 240"
        stroke="var(--forest)" stroke-width="0.8" opacity="0.12"/>

  <!-- SUBTLE VERTICAL SHADOW on the RIGHT side (even fainter) -->
  <path d="M 162 80 L 156 240"
        stroke="var(--forest)" stroke-width="0.8" opacity="0.08"/>

  <!-- TOP RIM ELLIPSE — dark green, seen at slight angle -->
  <ellipse cx="110" cy="60" rx="70" ry="9"
           fill="var(--forest)" stroke="var(--forest)"
           stroke-width="1.5"/>

  <!-- INNER OPENING — limewash-toned, showing the inside of the bucket -->
  <ellipse cx="110" cy="59" rx="62" ry="6"
           fill="var(--limewash)" opacity="0.85"/>

  <!-- INNER PAINT SURFACE — very subtle haldi tint inside the rim (suggesting paint residue) -->
  <ellipse cx="110" cy="59" rx="56" ry="4.5"
           fill="var(--haldi)" opacity="0.18"/>

  <!-- HALDI ACCENT STRIPE ABOVE LABEL BAND — thin line following the cylinder curve -->
  <path d="M 46 128 L 50 130 C 80 134, 140 134, 170 130 L 174 128"
        fill="none" stroke="var(--haldi-deep)"
        stroke-width="1.6" stroke-linecap="round"/>

  <!-- DARK-GREEN LABEL BAND — curved to follow the cylinder surface (not a flat rectangle).
       The top and bottom edges have a slight curve suggesting the wrap-around of the band. -->
  <path d="M 46 132
           L 50 180
           C 80 184, 140 184, 170 180
           L 174 132
           C 140 136, 80 136, 46 132 Z"
        fill="var(--forest)" stroke="var(--forest)"
        stroke-width="1.4" stroke-linejoin="round"/>

  <!-- HALDI ACCENT STRIPE BELOW LABEL BAND -->
  <path d="M 50 184 L 54 186 C 80 189, 140 189, 166 186 L 170 184"
        fill="none" stroke="var(--haldi-deep)"
        stroke-width="1.6" stroke-linecap="round"/>

  <!-- SMALL GEOMETRIC MARK above the wordmark — haldi dot (replaces cartoon cow motif) -->
  <circle cx="110" cy="138" r="2.2" fill="var(--haldi)"/>

  <!-- WORDMARK TEXT -->
  <text x="110" y="151" text-anchor="middle"
        font-family="var(--font-display)" font-weight="700"
        font-size="11" fill="var(--haldi)" letter-spacing="1.4">GAURIKRIT</text>

  <!-- PRODUCT NAME TEXT -->
  <text x="110" y="168" text-anchor="middle"
        font-family="var(--font-display)" font-weight="700"
        font-size="5.5" fill="var(--haldi)" letter-spacing="1.2">PRAKRITIK DISTEMPER</text>

  <!-- SMALL UNDERLINE MARK beneath wordmark -->
  <path d="M 86 174 L 134 174"
        stroke="var(--haldi)" stroke-width="0.8" opacity="0.5"/>

  <!-- BOTTOM FRONT CURVE — base of cylinder visible from the front -->
  <path d="M 52 250 C 60 256, 160 256, 168 250"
        fill="none" stroke="var(--forest)"
        stroke-width="1.5" opacity="0.85"/>

  <!-- SUBTLE BASE SHADOW ELLIPSE — very faint ground contact -->
  <ellipse cx="110" cy="256" rx="56" ry="3"
           fill="var(--forest)" opacity="0.08"/>

</svg>
