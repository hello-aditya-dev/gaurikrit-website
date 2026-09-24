<?php
/**
 * Illustration: Field botanicals (grass sprig, leafy branch, seed head)
 * Coded SVG — no photography dependency.
 * V2 finish pass — herbarium / old-botanical-book line style.
 *
 * 2-3 plant specimens: a grass sprig (left), a leafy branch (center),
 * a seed head (right). Very fine, disciplined line work (1.2px). Each
 * plant has: a stem line, leaf shapes (paired or alternate), seed /
 * flower detail. No fill — pure line drawing (only seed grains as
 * small filled ellipses for accent). Arranged as a small composition,
 * not overlapping chaotically. Decorative accent — restrained.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 220 220" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Field botanicals</title>

  <g fill="none" stroke="var(--forest)"
     stroke-width="1.2" stroke-linecap="round"
     stroke-linejoin="round">

    <!-- ===== SPECIMEN 1: GRASS SPRIG (left) ===== -->
    <!-- Main stem — long, slightly curving -->
    <path d="M 40 200 L 40 60" stroke-width="1.3"/>

    <!-- Long curved blades — alternate along the stem -->
    <path d="M 40 180 C 28 175, 22 165, 26 152
             C 36 162, 42 172, 40 180 Z"
          stroke-width="1.1"/>
    <path d="M 40 155 C 52 150, 58 140, 54 127
             C 44 137, 38 147, 40 155 Z"
          stroke-width="1.1"/>
    <path d="M 40 130 C 28 125, 22 115, 26 102
             C 36 112, 42 122, 40 130 Z"
          stroke-width="1.1"/>
    <path d="M 40 105 C 52 100, 58 90, 54 77
             C 44 87, 38 97, 40 105 Z"
          stroke-width="1.1"/>
    <!-- Small upper leaf -->
    <path d="M 40 80 C 35 75, 36 67, 42 61
             C 40 71, 40 75, 40 80 Z"
          stroke-width="1"/>
    <!-- Tip — slender awn -->
    <path d="M 40 60 C 38 56, 40 50, 44 48"
          stroke-width="1.1"/>

    <!-- Leaf vein accents — subtle interior lines on the larger blades -->
    <path d="M 40 178 C 34 170, 30 162, 28 156"
          stroke-width="0.7" opacity="0.45"/>
    <path d="M 40 128 C 34 120, 30 112, 28 106"
          stroke-width="0.7" opacity="0.45"/>

    <!-- Root suggestion — three small marks at the base -->
    <path d="M 40 200 L 38 207" stroke-width="0.9" opacity="0.55"/>
    <path d="M 40 200 L 42 207" stroke-width="0.9" opacity="0.55"/>
    <path d="M 40 200 L 40 209" stroke-width="0.9" opacity="0.55"/>


    <!-- ===== SPECIMEN 2: LEAFY BRANCH (center) ===== -->
    <!-- Main stem — taller -->
    <path d="M 110 200 L 110 50" stroke-width="1.3"/>

    <!-- Side branch offshoots — alternate, short -->
    <path d="M 110 175 L 100 168" stroke-width="1"/>
    <path d="M 110 150 L 122 142" stroke-width="1"/>
    <path d="M 110 125 L 100 118" stroke-width="1"/>
    <path d="M 110 100 L 122 92" stroke-width="1"/>
    <path d="M 110 75 L 100 68" stroke-width="1"/>

    <!-- Leaves — alternate along stem, curved teardrop shapes -->
    <path d="M 110 175 C 92 170, 84 162, 88 150
             C 100 162, 108 170, 110 175 Z"
          stroke-width="1.1"/>
    <path d="M 110 150 C 128 145, 136 137, 132 125
             C 120 137, 112 145, 110 150 Z"
          stroke-width="1.1"/>
    <path d="M 110 125 C 92 120, 84 112, 88 100
             C 100 112, 108 120, 110 125 Z"
          stroke-width="1.1"/>
    <path d="M 110 100 C 128 95, 136 87, 132 75
             C 120 87, 112 95, 110 100 Z"
          stroke-width="1.1"/>
    <path d="M 110 75 C 95 70, 90 62, 95 54
             C 105 64, 110 70, 110 75 Z"
          stroke-width="1"/>

    <!-- Leaf veins on alternate leaves -->
    <path d="M 110 173 C 100 165, 94 159, 88 153"
          stroke-width="0.7" opacity="0.45"/>
    <path d="M 110 148 C 120 140, 126 134, 132 128"
          stroke-width="0.7" opacity="0.45"/>
    <path d="M 110 123 C 100 115, 94 109, 88 103"
          stroke-width="0.7" opacity="0.45"/>
    <path d="M 110 98 C 120 90, 126 84, 132 78"
          stroke-width="0.7" opacity="0.45"/>

    <!-- Tip bud — small terminal leaf -->
    <path d="M 110 50 C 106 46, 110 40, 114 42
             C 114 46, 112 50, 110 50 Z"
          stroke-width="1.1"/>


    <!-- ===== SPECIMEN 3: SEED HEAD (right) ===== -->
    <!-- Stem -->
    <path d="M 180 200 L 180 95" stroke-width="1.3"/>

    <!-- Lower leaves at base — paired -->
    <path d="M 180 165 C 168 161, 164 153, 168 143
             C 176 153, 180 161, 180 165 Z"
          stroke-width="1.1"/>
    <path d="M 180 165 C 192 161, 196 153, 192 143
             C 184 153, 180 161, 180 165 Z"
          stroke-width="1.1"/>

    <!-- Mid leaves — smaller, slightly higher up -->
    <path d="M 180 135 C 170 131, 166 125, 170 117
             C 178 125, 180 131, 180 135 Z"
          stroke-width="1"/>
    <path d="M 180 135 C 190 131, 194 125, 190 117
             C 182 125, 180 131, 180 135 Z"
          stroke-width="1"/>

    <!-- SEED HEAD — oval cluster shape -->
    <ellipse cx="180" cy="80" rx="9" ry="18"
             stroke-width="1.3"/>

    <!-- AWNS — long thin bristles out the top of the seed head -->
    <g stroke-width="0.8" opacity="0.7">
      <path d="M 174 65 C 172 58, 172 50, 174 44"/>
      <path d="M 180 65 L 180 40"/>
      <path d="M 186 65 C 188 58, 188 50, 186 44"/>
      <path d="M 170 68 C 166 62, 162 56, 160 50"/>
      <path d="M 190 68 C 194 62, 198 56, 200 50"/>
    </g>

  </g>

  <!-- SEED GRAINS — small filled ellipses inside the seed head for accent -->
  <g fill="var(--forest)" stroke="none">
    <ellipse cx="175" cy="72" rx="1.5" ry="2.2"/>
    <ellipse cx="185" cy="72" rx="1.5" ry="2.2"/>
    <ellipse cx="180" cy="78" rx="1.5" ry="2.2"/>
    <ellipse cx="175" cy="84" rx="1.5" ry="2.2"/>
    <ellipse cx="185" cy="84" rx="1.5" ry="2.2"/>
    <ellipse cx="180" cy="90" rx="1.5" ry="2.2"/>
    <ellipse cx="177" cy="96" rx="1.2" ry="1.8"/>
    <ellipse cx="183" cy="96" rx="1.2" ry="1.8"/>
  </g>

</svg>
