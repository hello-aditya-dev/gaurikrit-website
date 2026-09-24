<?php
/**
 * Illustration: Gaurikrit cow mark (front-facing cow-head in emblem)
 * Coded SVG — no photography dependency.
 * V2 finish pass — refined, symmetrical, restrained emblem.
 *
 * Clean circular haldi emblem with forest outline. Front-facing cow head
 * with prominent forehead, two curved horns, two long hanging ears,
 * calm eyes, and muzzle. Symmetrical, dignified.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Gaurikrit cow mark</title>

  <!-- Emblem — clean circle, haldi fill, forest outline -->
  <circle cx="70" cy="70" r="60"
          fill="var(--haldi)" stroke="var(--forest)"
          stroke-width="1.5"/>

  <!-- Inner accent ring — very subtle, for restraint -->
  <circle cx="70" cy="70" r="54"
          fill="none" stroke="var(--forest)"
          stroke-width="0.8" opacity="0.35"/>

  <g fill="none" stroke="var(--forest)" stroke-width="1.5"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- LEFT HORN — curves up and outward from the forehead, moderate length -->
    <path d="M 60 38
             C 52 28, 42 22, 32 22
             C 28 22, 26 24, 28 26
             C 36 30, 46 32, 56 36"/>

    <!-- RIGHT HORN — mirror of left -->
    <path d="M 80 38
             C 88 28, 98 22, 108 22
             C 112 22, 114 24, 112 26
             C 104 30, 94 32, 84 36"/>

    <!-- LEFT EAR — long, hanging out and slightly down -->
    <path d="M 56 46
             C 44 50, 32 56, 24 64
             C 28 66, 36 64, 44 60
             C 50 56, 54 50, 58 48 Z"/>

    <!-- RIGHT EAR — mirror of left -->
    <path d="M 84 46
             C 96 50, 108 56, 116 64
             C 112 66, 104 64, 96 60
             C 90 56, 86 50, 82 48 Z"/>

    <!-- HEAD — front-facing, prominent forehead, elongated face down to muzzle.
         Forehead bulges out at top, narrows through bridge, widens at muzzle, chin under. -->
    <path d="M 70 36
             C 62 36, 56 40, 54 46
             C 52 52, 52 60, 54 66
             C 56 76, 60 86, 64 92
             C 66 96, 74 96, 76 92
             C 80 86, 84 76, 86 66
             C 88 60, 88 52, 86 46
             C 84 40, 78 36, 70 36 Z"/>

    <!-- FOREHEAD CENTER CREASE — subtle vertical line -->
    <path d="M 70 40 L 70 52"
          stroke-width="1.2" opacity="0.5"/>

    <!-- FOREHEAD BULGE DEFINITION — subtle horizontal curve -->
    <path d="M 64 44 Q 70 46, 76 44"
          stroke-width="1.2" opacity="0.5"/>

    <!-- MUZZLE BAND — separating muzzle from face bridge -->
    <path d="M 58 76 Q 70 80, 82 76"
          stroke-width="1.2" opacity="0.65"/>

    <!-- MOUTH -->
    <path d="M 62 90 Q 70 93, 78 90"
          stroke-width="1.2" opacity="0.7"/>

  </g>

  <!-- EYES — two small filled dots, calm -->
  <circle cx="62" cy="56" r="1.6" fill="var(--forest)"/>
  <circle cx="78" cy="56" r="1.6" fill="var(--forest)"/>

  <!-- NOSTRILS — two small filled dots -->
  <circle cx="64" cy="84" r="1.1" fill="var(--forest)"/>
  <circle cx="76" cy="84" r="1.1" fill="var(--forest)"/>

</svg>
