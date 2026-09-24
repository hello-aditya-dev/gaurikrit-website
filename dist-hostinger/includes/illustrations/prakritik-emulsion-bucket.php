<?php
/**
 * Illustration: Prakritik Emulsion bucket
 * Coded SVG — no photography dependency.
 * V2 finish pass — taller cylindrical tin for liquid emulsion.
 *
 * Stylised website product illustration.
 * Replace with approved product photography when supplied.
 * To swap with a photo: change the ProductVisual data field to
 * "/assets/products/prakritik-emulsion.png"
 *
 * Same structural quality as the distemper bucket but slightly TALLER
 * (emulsion is liquid, taller pack). A subtle liquid line is visible
 * at the rim, suggesting liquid paint inside. Label says
 * "PRAKRITIK EMULSION".
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 220 300" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Prakritik Emulsion bucket</title>

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

  <!-- BUCKET BODY — TALLER tapered cylinder, paper-white fill.
       Top corners at the rim (x=40, x=180), bottom corners narrower (x=52, x=168).
       Taller body — base at y=270 (vs y=250 for distemper). -->
  <path d="M 40 62
           L 52 270
           C 60 276, 160 276, 168 270
           L 180 62 Z"
        fill="var(--paper)" stroke="var(--forest)"
        stroke-width="1.5" stroke-linejoin="round"/>

  <!-- SUBTLE VERTICAL HIGHLIGHT on the LEFT side of the cylinder -->
  <path d="M 56 80 L 64 260"
        stroke="var(--forest)" stroke-width="0.8" opacity="0.12"/>

  <!-- SUBTLE VERTICAL SHADOW on the RIGHT side -->
  <path d="M 162 80 L 156 260"
        stroke="var(--forest)" stroke-width="0.8" opacity="0.08"/>

  <!-- TOP RIM ELLIPSE — dark green -->
  <ellipse cx="110" cy="60" rx="70" ry="9"
           fill="var(--forest)" stroke="var(--forest)"
           stroke-width="1.5"/>

  <!-- INNER OPENING — limewash-toned inside -->
  <ellipse cx="110" cy="59" rx="62" ry="6"
           fill="var(--limewash)" opacity="0.85"/>

  <!-- LIQUID LINE AT RIM — a subtle haldi-toned ellipse just inside the rim,
       suggesting the liquid paint surface filling up to the rim -->
  <ellipse cx="110" cy="58" rx="58" ry="5"
           fill="var(--haldi)" opacity="0.32"/>

  <!-- SURFACE RIPPLE on the liquid — very subtle line suggesting liquid surface tension -->
  <path d="M 56 57 C 80 55, 140 55, 164 57"
        fill="none" stroke="var(--haldi-deep)"
        stroke-width="0.8" opacity="0.55"/>

  <!-- HALDI ACCENT STRIPE ABOVE LABEL BAND -->
  <path d="M 46 128 L 50 130 C 80 134, 140 134, 170 130 L 174 128"
        fill="none" stroke="var(--haldi-deep)"
        stroke-width="1.6" stroke-linecap="round"/>

  <!-- DARK-GREEN LABEL BAND — taller band (emulsion pack), curved to follow cylinder -->
  <path d="M 46 132
           L 50 204
           C 80 208, 140 208, 170 204
           L 174 132
           C 140 136, 80 136, 46 132 Z"
        fill="var(--forest)" stroke="var(--forest)"
        stroke-width="1.4" stroke-linejoin="round"/>

  <!-- HALDI ACCENT STRIPE BELOW LABEL BAND -->
  <path d="M 50 208 L 54 210 C 80 213, 140 213, 166 210 L 170 208"
        fill="none" stroke="var(--haldi-deep)"
        stroke-width="1.6" stroke-linecap="round"/>

  <!-- SMALL GEOMETRIC MARK above the wordmark — haldi dot -->
  <circle cx="110" cy="138" r="2.2" fill="var(--haldi)"/>

  <!-- WORDMARK TEXT -->
  <text x="110" y="153" text-anchor="middle"
        font-family="var(--font-display)" font-weight="700"
        font-size="12" fill="var(--haldi)" letter-spacing="1.5">GAURIKRIT</text>

  <!-- SUBTITLE LINE 1 -->
  <text x="110" y="174" text-anchor="middle"
        font-family="var(--font-display)" font-weight="700"
        font-size="7" fill="var(--haldi)" letter-spacing="1.6">PRAKRITIK</text>

  <!-- SUBTITLE LINE 2 -->
  <text x="110" y="190" text-anchor="middle"
        font-family="var(--font-display)" font-weight="700"
        font-size="7" fill="var(--haldi)" letter-spacing="1.6">EMULSION</text>

  <!-- SMALL UNDERLINE MARK beneath wordmark -->
  <path d="M 86 160 L 134 160"
        stroke="var(--haldi)" stroke-width="0.8" opacity="0.5"/>

  <!-- BOTTOM FRONT CURVE — base of cylinder -->
  <path d="M 52 270 C 60 276, 160 276, 168 270"
        fill="none" stroke="var(--forest)"
        stroke-width="1.5" opacity="0.85"/>

  <!-- SUBTLE BASE SHADOW ELLIPSE — very faint ground contact -->
  <ellipse cx="110" cy="276" rx="56" ry="3"
           fill="var(--forest)" opacity="0.08"/>

</svg>
