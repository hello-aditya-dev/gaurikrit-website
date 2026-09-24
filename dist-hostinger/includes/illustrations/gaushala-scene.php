<?php
/**
 * Illustration: Gaushala scene (cows under a shelter, tree, ground)
 * Coded SVG — no photography dependency.
 * V2 finish pass — calm, quiet, architectural-elevation composition.
 *
 * 2 simplified cows (side-view, simplified IndianCow silhouettes —
 * outlines only, less detail). A low shelter roofline (simple
 * architectural line — sloped roof on posts). A ground line. One small
 * tree. Very calm, quiet composition — not cluttered.
 *
 * Each cow uses separate paths for body barrel, hump, head, legs, tail
 * (no single blob contour) — same discipline as the IndianCow but
 * simplified.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 440 220" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Gaushala scene</title>

  <g fill="none" stroke="var(--forest)"
     stroke-width="1.5" stroke-linecap="round"
     stroke-linejoin="round">

    <!-- ===== SHELTER — low pitched roof on posts ===== -->
    <!-- Roof top line — sloped, gentle peak -->
    <path d="M 40 96 L 220 76 L 380 96" stroke-width="1.6"/>
    <!-- Roof underside — parallel line for thickness (reads as a roof slab) -->
    <path d="M 46 102 L 220 82 L 374 102" stroke-width="1.1" opacity="0.65"/>

    <!-- Roof tile / segment lines — subtle vertical strokes suggesting tile divisions -->
    <path d="M 90 92 L 92 98" stroke-width="0.9" opacity="0.45"/>
    <path d="M 140 86 L 142 92" stroke-width="0.9" opacity="0.45"/>
    <path d="M 190 80 L 192 86" stroke-width="0.9" opacity="0.45"/>
    <path d="M 240 80 L 242 86" stroke-width="0.9" opacity="0.45"/>
    <path d="M 290 84 L 292 90" stroke-width="0.9" opacity="0.45"/>
    <path d="M 340 90 L 342 96" stroke-width="0.9" opacity="0.45"/>

    <!-- Support posts — 3 vertical posts holding up the roof -->
    <path d="M 60 102 L 60 178" stroke-width="1.4"/>
    <path d="M 220 82 L 220 178" stroke-width="1.4"/>
    <path d="M 360 96 L 360 178" stroke-width="1.4"/>

    <!-- Post base bands — small horizontal ticks where the posts meet the ground -->
    <path d="M 57 178 L 63 178" stroke-width="1.2"/>
    <path d="M 217 178 L 223 178" stroke-width="1.2"/>
    <path d="M 357 178 L 363 178" stroke-width="1.2"/>


    <!-- ===== COW 1 — side-view, simplified, under shelter (facing left) ===== -->
    <g>
      <!-- BODY BARREL -->
      <path d="M 78 150
               L 130 144
               C 145 145, 155 147, 160 148
               L 160 168
               L 80 168
               C 78 162, 76 156, 78 150 Z"/>

      <!-- HUMP — rises above back line -->
      <path d="M 78 150
               C 82 142, 88 138, 94 138
               C 100 138, 106 142, 110 146"/>

      <!-- NECK TOP — from withers forward-down to poll -->
      <path d="M 78 150 C 72 148, 66 146, 60 145"/>

      <!-- HEAD — side-view, elongated face -->
      <path d="M 60 145
               C 56 147, 52 151, 48 155
               C 44 159, 42 162, 42 164
               C 46 166, 52 166, 58 164
               C 60 164, 62 164, 64 164
               C 64 158, 62 152, 60 145 Z"/>

      <!-- HORN — short, curved -->
      <path d="M 60 145 C 56 140, 52 138, 48 139" stroke-width="1.2"/>

      <!-- EAR — small, hanging -->
      <path d="M 64 149 C 70 153, 74 157, 76 161" stroke-width="1.2"/>

      <!-- FRONT LEGS — slender, paired -->
      <path d="M 84 168 L 84 180" stroke-width="1.3"/>
      <path d="M 88 168 L 88 180" stroke-width="1.3"/>

      <!-- BACK LEGS — slender, paired -->
      <path d="M 148 168 L 148 180" stroke-width="1.3"/>
      <path d="M 152 168 L 152 180" stroke-width="1.3"/>

      <!-- TAIL — short, with tuft -->
      <path d="M 160 152 C 166 156, 168 164, 166 172" stroke-width="1.2"/>
      <path d="M 166 172 L 165 178" stroke-width="1.1"/>
      <path d="M 166 172 L 168 178" stroke-width="1.1"/>

      <!-- EYE -->
      <circle cx="52" cy="155" r="0.8" fill="var(--forest)" stroke="none"/>

      <!-- HOOF TICKS -->
      <path d="M 82 181 L 90 181" stroke-width="1.2"/>
      <path d="M 146 181 L 154 181" stroke-width="1.2"/>
    </g>


    <!-- ===== COW 2 — smaller, slightly further back (drawn with reduced scale),
                 simplified silhouette, facing left ===== -->
    <g opacity="0.85">
      <!-- BODY BARREL -->
      <path d="M 220 160
               L 268 154
               C 280 155, 290 157, 295 158
               L 295 176
               L 222 176
               C 220 170, 218 164, 220 160 Z"/>

      <!-- HUMP -->
      <path d="M 220 160
               C 224 153, 230 149, 236 149
               C 242 149, 248 153, 252 157"/>

      <!-- NECK TOP -->
      <path d="M 220 160 C 214 158, 208 157, 202 156"/>

      <!-- HEAD -->
      <path d="M 202 156
               C 198 158, 194 162, 190 166
               C 186 170, 184 173, 184 175
               C 188 177, 194 177, 200 175
               C 202 175, 204 175, 206 175
               C 206 169, 204 163, 202 156 Z"/>

      <!-- HORN -->
      <path d="M 202 156 C 198 151, 194 149, 190 150" stroke-width="1.2"/>

      <!-- EAR -->
      <path d="M 206 160 C 212 164, 216 168, 218 172" stroke-width="1.2"/>

      <!-- FRONT LEGS -->
      <path d="M 226 176 L 226 186" stroke-width="1.3"/>
      <path d="M 230 176 L 230 186" stroke-width="1.3"/>

      <!-- BACK LEGS -->
      <path d="M 285 176 L 285 186" stroke-width="1.3"/>
      <path d="M 289 176 L 289 186" stroke-width="1.3"/>

      <!-- TAIL -->
      <path d="M 295 162 C 300 166, 302 174, 300 180" stroke-width="1.2"/>
      <path d="M 300 180 L 299 184" stroke-width="1.1"/>
      <path d="M 300 180 L 301 184" stroke-width="1.1"/>

      <!-- EYE -->
      <circle cx="194" cy="166" r="0.7" fill="var(--forest)" stroke="none"/>

      <!-- HOOF TICKS -->
      <path d="M 224 187 L 232 187" stroke-width="1.2"/>
      <path d="M 283 187 L 291 187" stroke-width="1.2"/>
    </g>


    <!-- ===== SMALL TREE on the right side ===== -->
    <!-- Trunk -->
    <path d="M 415 178 L 415 145" stroke-width="1.5"/>
    <!-- Canopy — small irregular rounded silhouette -->
    <path d="M 415 145
             C 402 143, 396 132, 402 124
             C 398 116, 406 110, 414 114
             C 418 106, 428 106, 432 114
             C 440 110, 446 116, 442 124
             C 446 132, 440 142, 428 144
             C 424 148, 418 148, 415 145 Z"
          stroke-width="1.3"/>
    <!-- Canopy interior vein lines — subtle -->
    <path d="M 415 145 L 415 130" stroke-width="0.9" opacity="0.55"/>
    <path d="M 415 134 L 408 124" stroke-width="0.7" opacity="0.4"/>
    <path d="M 415 134 L 422 124" stroke-width="0.7" opacity="0.4"/>


    <!-- ===== GROUND LINE — main horizon at the shelter base ===== -->
    <path d="M 0 180 L 440 180" stroke-width="1.5"/>

    <!-- LOWER GROUND SUBTLE LINE — a second ground level for depth -->
    <path d="M 0 188 L 440 188" stroke-width="0.9" opacity="0.4"/>

    <!-- DISTANT HORIZON — very faint, behind the shelter -->
    <path d="M 0 175 L 440 175" stroke-width="0.9" opacity="0.35"/>

    <!-- FOREGROUND GRASS TUFTS — restrained, deliberate botanical marks -->
    <g stroke-width="1.1" opacity="0.75">
      <path d="M 30 180 L 30 184"/>
      <path d="M 32 180 L 32 184"/>
      <path d="M 34 180 L 34 185"/>
      <path d="M 175 180 L 175 184"/>
      <path d="M 177 180 L 177 184"/>
      <path d="M 320 180 L 320 184"/>
      <path d="M 322 180 L 322 184"/>
      <path d="M 395 180 L 395 184"/>
      <path d="M 397 180 L 397 184"/>
    </g>

    <!-- ONE LONGER GRASS BLADE — compositional accent -->
    <path d="M 200 180 C 198 174, 196 168, 198 164" stroke-width="1.2" opacity="0.7"/>

  </g>
</svg>
