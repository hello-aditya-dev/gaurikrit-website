<?php
/**
 * Illustration: Rural Landscape Band
 * V3 core illustration system.
 *
 * Wide, short, low-opacity rural engraving used as a supporting
 * background element. Restraint over flourish. Strokes in
 * var(--forest); the whole group sits at low opacity (0.18 base,
 * individual elements 0.4-0.85 within the group) so it reads as a
 * quiet engraving, never a tourism poster.
 *
 * Composition:
 *   - Low horizon line spanning the band.
 *   - 3 gentle rolling field contours.
 *   - One modest agricultural shed (peaked roof, rectangular body,
 *     small door) on the right.
 *   - One mature full-canopy tree on the left.
 *   - A few distant shrubs on the horizon line.
 *   - Two tiny zebu cow silhouettes in the middle field.
 *
 * Stroke language: 1.35px main organic, 0.85px detail. Round cap/join.
 * No cartoon sun, no mountain cliché, no excessive detail.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 1600 280" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Rural landscape engraving</title>

  <!-- The whole engraving sits at low opacity so it functions as background.
       Inner elements use individual opacities so the horizon reads first
       and the silhouettes fade further into the paper. -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round"
     opacity="0.18">

    <!-- ===== DISTANT FIELD CONTOUR — back layer, the softest ===== -->
    <path d="M 0 138 C 200 132, 380 138, 560 134
             S 920 130, 1100 134
             S 1440 138, 1600 134"
          stroke-width="1.35" opacity="0.45"/>

    <!-- ===== MID FIELD CONTOUR — gentle rolling, slightly more present ===== -->
    <path d="M 0 168 C 240 162, 460 168, 680 164
             S 1040 160, 1240 164
             S 1500 168, 1600 164"
          stroke-width="1.35" opacity="0.6"/>

    <!-- ===== MAIN HORIZON LINE — most prominent ===== -->
    <path d="M 0 196 C 220 192, 460 198, 700 194
             S 1080 190, 1300 194
             S 1540 198, 1600 194"
          stroke-width="1.35" opacity="0.85"/>

    <!-- ===== GROUND LINE — foreground baseline ===== -->
    <path d="M 0 232 L 1600 232"
          stroke-width="1.35" opacity="0.55"/>

    <!-- ===== MATURE TREE (left side) — full canopy, line-drawn ===== -->
    <g>
      <!-- Trunk — single slender stroke from ground up into canopy -->
      <path d="M 230 232 L 228 168" stroke-width="1.35" opacity="0.85"/>
      <!-- Two main branches splitting off the trunk -->
      <path d="M 228 188 C 218 184, 208 184, 198 188"
            stroke-width="0.85" opacity="0.7"/>
      <path d="M 228 184 C 238 180, 248 180, 258 184"
            stroke-width="0.85" opacity="0.7"/>
      <!-- Canopy — full rounded mass built from overlapping arcs.
           Drawn as a single closed contour with several cubic curves
           so the edge has natural variation, not a perfect circle. -->
      <path d="M 168 140
               C 160 120, 172 100, 196 96
               C 204 84, 224 80, 236 90
               C 248 80, 268 84, 276 98
               C 296 100, 308 118, 300 138
               C 308 148, 304 164, 286 168
               C 278 178, 258 180, 244 174
               C 234 182, 214 182, 202 174
               C 188 180, 168 178, 162 168
               C 152 162, 154 148, 168 140 Z"
            stroke-width="1.35" opacity="0.85"/>
      <!-- Canopy interior vein lines — 3 subtle branching marks -->
      <path d="M 232 140 C 226 150, 220 158, 214 162"
            stroke-width="0.85" opacity="0.55"/>
      <path d="M 232 140 C 240 150, 246 158, 252 162"
            stroke-width="0.85" opacity="0.55"/>
      <path d="M 232 140 L 232 130"
            stroke-width="0.85" opacity="0.45"/>
      <!-- Root flare marks at the base of the trunk -->
      <path d="M 222 232 C 218 236, 214 236, 212 234"
            stroke-width="0.85" opacity="0.6"/>
      <path d="M 234 232 C 238 236, 242 236, 244 234"
            stroke-width="0.85" opacity="0.6"/>
    </g>

    <!-- ===== DISTANT SHRUBS — small bush marks on the horizon ===== -->
    <g>
      <path d="M 540 196 C 548 190, 558 190, 562 196
               C 566 190, 574 190, 578 196"
            stroke-width="0.85" opacity="0.7"/>
      <path d="M 820 194 C 828 188, 838 188, 842 194"
            stroke-width="0.85" opacity="0.65"/>
      <path d="M 850 196 C 858 190, 866 190, 870 196"
            stroke-width="0.85" opacity="0.6"/>
      <path d="M 1180 194 C 1188 188, 1198 188, 1202 194"
            stroke-width="0.85" opacity="0.6"/>
    </g>

    <!-- ===== MODEST AGRICULTURAL SHED (right side) — small, simple ===== -->
    <g>
      <!-- Roof — single peaked line, low and shallow -->
      <path d="M 1280 168 L 1310 148 L 1380 148 L 1410 168"
            stroke-width="1.35" opacity="0.85"/>
      <!-- Roof underside — thin projection suggesting roof slab thickness -->
      <path d="M 1280 168 L 1410 168"
            stroke-width="0.85" opacity="0.55"/>
      <!-- Body — simple rectangle -->
      <path d="M 1290 168 L 1290 232 L 1400 232 L 1400 168"
            stroke-width="1.35" opacity="0.85"/>
      <!-- Door — small rectangle opening -->
      <path d="M 1330 232 L 1330 198 L 1360 198 L 1360 232"
            stroke-width="0.85" opacity="0.7"/>
      <!-- Small window/vent high on the wall -->
      <path d="M 1372 180 L 1384 180 L 1384 192 L 1372 192 Z"
            stroke-width="0.85" opacity="0.6"/>
      <!-- Roof tile segment lines — 3 subtle marks -->
      <path d="M 1310 152 L 1314 168" stroke-width="0.85" opacity="0.5"/>
      <path d="M 1340 148 L 1344 168" stroke-width="0.85" opacity="0.5"/>
      <path d="M 1370 148 L 1374 168" stroke-width="0.85" opacity="0.5"/>
    </g>

    <!-- ===== TINY ZEBU COWS — small silhouettes in the middle field ===== -->
    <!-- Cow A — facing left, sitting in the field at mid-distance -->
    <g opacity="0.85">
      <!-- Body barrel — small closed contour -->
      <path d="M 720 196
               C 728 192, 740 191, 752 192
               L 768 192
               L 768 200
               L 720 200
               C 718 198, 718 197, 720 196 Z"
            stroke-width="0.85"/>
      <!-- Hump — small rise above back line -->
      <path d="M 722 196 C 724 192, 728 190, 732 190
               C 736 190, 740 192, 742 196"
            stroke-width="0.85"/>
      <!-- Head — small wedge to the left -->
      <path d="M 720 196 C 716 196, 712 198, 710 200"
            stroke-width="0.85"/>
      <!-- Legs — 4 tiny vertical strokes -->
      <path d="M 724 200 L 724 208" stroke-width="0.85"/>
      <path d="M 728 200 L 728 208" stroke-width="0.85"/>
      <path d="M 762 200 L 762 208" stroke-width="0.85"/>
      <path d="M 766 200 L 766 208" stroke-width="0.85"/>
      <!-- Tail — short curve down -->
      <path d="M 768 194 C 772 196, 774 200, 772 204" stroke-width="0.85"/>
    </g>

    <!-- Cow B — facing left, slightly smaller, further back -->
    <g opacity="0.7">
      <path d="M 980 198
               C 986 195, 996 194, 1006 195
               L 1018 195
               L 1018 202
               L 980 202
               C 978 200, 978 199, 980 198 Z"
            stroke-width="0.85"/>
      <path d="M 982 198 C 984 195, 988 193, 992 193
               C 996 193, 1000 195, 1002 198"
            stroke-width="0.85"/>
      <path d="M 980 198 C 976 198, 972 200, 970 202"
            stroke-width="0.85"/>
      <path d="M 984 202 L 984 208" stroke-width="0.85"/>
      <path d="M 988 202 L 988 208" stroke-width="0.85"/>
      <path d="M 1014 202 L 1014 208" stroke-width="0.85"/>
      <path d="M 1018 200 C 1022 202, 1024 204, 1022 207" stroke-width="0.85"/>
    </g>

    <!-- ===== FOREGROUND GRASS TUFTS — restrained, deliberate ===== -->
    <g stroke-width="1.35">
      <!-- Tuft cluster 1 — left -->
      <path d="M 80 232 L 78 226" opacity="0.6"/>
      <path d="M 82 232 L 82 224" opacity="0.6"/>
      <path d="M 84 232 L 86 226" opacity="0.6"/>
      <!-- Tuft cluster 2 — between tree and cows -->
      <path d="M 460 232 L 458 226" opacity="0.55"/>
      <path d="M 462 232 L 462 224" opacity="0.55"/>
      <path d="M 464 232 L 466 226" opacity="0.55"/>
      <!-- Tuft cluster 3 — right of cows -->
      <path d="M 1080 232 L 1078 226" opacity="0.55"/>
      <path d="M 1082 232 L 1082 224" opacity="0.55"/>
      <path d="M 1084 232 L 1086 226" opacity="0.55"/>
      <!-- Tuft cluster 4 — left of shed -->
      <path d="M 1220 232 L 1218 226" opacity="0.55"/>
      <path d="M 1222 232 L 1222 224" opacity="0.55"/>
      <!-- Tuft cluster 5 — far right -->
      <path d="M 1480 232 L 1478 226" opacity="0.55"/>
      <path d="M 1482 232 L 1482 224" opacity="0.55"/>
      <path d="M 1484 232 L 1486 226" opacity="0.55"/>
    </g>

    <!-- ===== ONE LONGER GRASS BLADE — compositional accent ===== -->
    <path d="M 580 232 C 578 224, 576 218, 580 212"
          stroke-width="1.35" opacity="0.65"/>

  </g>
</svg>
