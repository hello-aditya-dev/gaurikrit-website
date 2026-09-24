<?php
/**
 * Illustration: Indian Limewashed Courtyard Elevation
 * V3 core illustration system.
 *
 * A believable vernacular limewashed wall/courtyard elevation.
 * NOT a palace, NOT a Mughal arch, NOT a temple. Rectangular
 * openings only. Limewash tonal patches suggest plaster age.
 *
 * Critical: the large wall plane is isolated as
 * `id="courtyard-wall-plane"` so the Colours of India JS can
 * recolour it at runtime.
 *
 * Includes:
 *   - Long plaster wall (limewash fill, subtle tonal patches)
 *   - Low masonry plinth (double line at base)
 *   - Rectangular timber door (height ~2× width, double-leaf,
 *     timber board detail, jamb depth suggestion)
 *   - Rectangular window (offset from door, mullion cross)
 *   - Jaali / ventilation openings high on the wall (3 small
 *     square perforations with lattice detail)
 *   - Simple parapet (thin double line at top, wall thickness)
 *   - Shallow verandah shade line above the door
 *   - Earthen floor baseline (ground line + subtle texture marks)
 *   - One restrained mature tree (line-drawn, left side)
 *
 * Stroke language: 1.35px main, 0.85px detail. Round cap/join.
 * Square cap on horizontal architectural moldings (parapet,
 * plinth, verandah line) for crisp endpoint registration.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 1440 850" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Indian limewashed courtyard elevation</title>

  <!-- ============================================================
       COURTYARD WALL PLANE — the recolourable wall surface.
       id="courtyard-wall-plane" — the Colours of India JS swaps
       the fill on this element. Default fill: limewash.
       ============================================================ -->
  <rect id="courtyard-wall-plane"
        x="80" y="130" width="1280" height="590"
        fill="var(--limewash)" stroke="none"/>

  <!-- ============================================================
       LIMEWASH TONAL PATCHES — very faint tonal variation across
       the wall (0.04 opacity). Suggests plaster age / weathering.
       Never a uniform colour block.
       ============================================================ -->
  <g fill="var(--forest)" stroke="none" opacity="0.04">
    <rect x="200" y="180" width="180" height="120"/>
    <rect x="700" y="200" width="140" height="100"/>
    <rect x="1200" y="250" width="120" height="180"/>
    <rect x="300" y="450" width="100" height="80"/>
    <rect x="1100" y="500" width="180" height="150"/>
    <rect x="900" y="600" width="160" height="100"/>
    <ellipse cx="450" cy="650" rx="80" ry="40"/>
  </g>

  <!-- ============================================================
       WALL OUTLINE — single clean stroke around the whole wall
       (drawn on top of the recolourable plane so the outline
       stays crisp regardless of fill colour).
       ============================================================ -->
  <rect x="80" y="130" width="1280" height="590"
        fill="none" stroke="var(--forest)"
        stroke-width="1.35" stroke-linejoin="miter"/>

  <!-- ============================================================
       PARAPET / WALL THICKNESS — double line at top of wall,
       suggesting physical depth when viewed from outside.
       Square cap for crisp architectural molding endpoints.
       ============================================================ -->
  <g stroke="var(--forest)" stroke-linecap="square" fill="none">
    <path d="M 80 130 H 1360" stroke-width="1.35"/>
    <path d="M 80 145 H 1360" stroke-width="0.85" opacity="0.65"/>
  </g>

  <!-- ============================================================
       PLINTH — double line at base of wall (masonry plinth band).
       Slightly wider than the wall (extends 20px each side).
       ============================================================ -->
  <g stroke="var(--forest)" stroke-linecap="square" fill="none">
    <path d="M 60 720 H 1380" stroke-width="1.35"/>
    <path d="M 60 740 H 1380" stroke-width="1.35"/>
    <!-- Subtle interior plinth line (masonry joint) -->
    <path d="M 60 732 H 1380" stroke-width="0.85" opacity="0.5"/>
  </g>
  <!-- Plinth fill (subtle mitti tone — earthy masonry) -->
  <rect x="60" y="720" width="1320" height="20"
        fill="var(--mitti)" stroke="none" opacity="0.12"/>

  <!-- ============================================================
       SHALLOW VERANDAH / SHADE LINE — thin projection above the
       door. Slightly wider than the door opening. Square cap.
       ============================================================ -->
  <g stroke="var(--forest)" stroke-linecap="square" fill="none">
    <!-- Shade projection line -->
    <path d="M 460 388 H 660" stroke-width="1.35"/>
    <!-- Subtle underside line (slab thickness) -->
    <path d="M 460 394 H 660" stroke-width="0.85" opacity="0.55"/>
    <!-- Two short vertical posts at each end -->
    <path d="M 460 388 L 460 404" stroke-width="0.85" opacity="0.6"/>
    <path d="M 660 388 L 660 404" stroke-width="0.85" opacity="0.6"/>
  </g>

  <!-- ============================================================
       TIMBER DOOR OPENING — rectangular (NOT arched).
       Door opening: x=480 to x=640 (width 160),
                     y=400 to y=720 (height 320).
       Height ≈ 2× width ✓.
       Double-leaf timber door with vertical board detail.
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Door opening — recessed background tone -->
    <rect x="480" y="400" width="160" height="320"
          fill="var(--background)" stroke-width="1.35"/>

    <!-- Door jamb depth suggestion — interior stroke at inset -->
    <path d="M 488 408 L 488 720" stroke-width="0.85" opacity="0.4"/>
    <path d="M 632 408 L 632 720" stroke-width="0.85" opacity="0.4"/>
    <path d="M 488 408 H 632" stroke-width="0.85" opacity="0.4"/>

    <!-- Door panel divider (double-leaf split, center) -->
    <path d="M 560 400 V 720" stroke-width="0.85" opacity="0.55"/>

    <!-- Timber board vertical lines — 5 per leaf -->
    <path d="M 498 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 516 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 534 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 548 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 572 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 586 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 604 400 V 720" stroke-width="0.5" opacity="0.4"/>
    <path d="M 622 400 V 720" stroke-width="0.5" opacity="0.4"/>

    <!-- Door threshold (slight step) -->
    <path d="M 476 720 L 644 720" stroke-width="1.35" opacity="0.85"/>

    <!-- Two horizontal rail lines on each leaf (top + bottom rail of the door panel) -->
    <path d="M 482 440 H 558" stroke-width="0.85" opacity="0.45"/>
    <path d="M 482 690 H 558" stroke-width="0.85" opacity="0.45"/>
    <path d="M 562 440 H 638" stroke-width="0.85" opacity="0.45"/>
    <path d="M 562 690 H 638" stroke-width="0.85" opacity="0.45"/>

    <!-- Door handles — haldi dots (the only haldi in the courtyard) -->
    <circle cx="544" cy="560" r="2.5" fill="var(--haldi)" stroke="none"/>
    <circle cx="576" cy="560" r="2.5" fill="var(--haldi)" stroke="none"/>
    <!-- Handle backplates (small forest rings around the haldi dots) -->
    <circle cx="544" cy="560" r="4" fill="none" stroke="var(--forest)" stroke-width="0.85"/>
    <circle cx="576" cy="560" r="4" fill="none" stroke="var(--forest)" stroke-width="0.85"/>
  </g>

  <!-- ============================================================
       WINDOW OPENING — rectangular, offset from the door.
       Window: x=860 to x=1040 (width 180),
              y=350 to y=550 (height 200).
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Window opening — recessed background tone -->
    <rect x="860" y="350" width="180" height="200"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Jamb depth suggestion -->
    <path d="M 868 358 L 868 550" stroke-width="0.85" opacity="0.4"/>
    <path d="M 1032 358 L 1032 550" stroke-width="0.85" opacity="0.4"/>
    <path d="M 868 358 H 1032" stroke-width="0.85" opacity="0.4"/>
    <!-- Mullion cross (vertical + horizontal) -->
    <path d="M 950 350 V 550" stroke-width="0.85" opacity="0.55"/>
    <path d="M 860 450 H 1040" stroke-width="0.85" opacity="0.55"/>
    <!-- Subtle secondary mullions (smaller panes) -->
    <path d="M 905 350 V 550" stroke-width="0.5" opacity="0.35"/>
    <path d="M 995 350 V 550" stroke-width="0.5" opacity="0.35"/>
    <path d="M 860 400 H 1040" stroke-width="0.5" opacity="0.35"/>
    <path d="M 860 500 H 1040" stroke-width="0.5" opacity="0.35"/>
    <!-- Window sill (slightly proud horizontal line) -->
    <path d="M 854 552 L 1046 552" stroke-width="1.35" opacity="0.85"/>
    <!-- Window head lintel line -->
    <path d="M 854 348 L 1046 348" stroke-width="1.35" opacity="0.85"/>
  </g>

  <!-- ============================================================
       JAALI / VENTILATION OPENINGS — small geometric perforations
       high on the wall. 3 small square openings with lattice
       detail, positioned to the right of the window.
       ============================================================ -->
  <g fill="var(--background)" stroke="var(--forest)"
     stroke-width="0.85" stroke-linejoin="round">
    <!-- Jaali 1 -->
    <rect x="1110" y="190" width="22" height="22"/>
    <path d="M 1115 190 V 212 M 1121 190 V 212 M 1127 190 V 212" stroke-width="0.5" opacity="0.7" fill="none"/>
    <path d="M 1110 195 H 1132 M 1110 201 H 1132 M 1110 207 H 1132" stroke-width="0.5" opacity="0.7" fill="none"/>
    <!-- Jaali 2 -->
    <rect x="1144" y="190" width="22" height="22"/>
    <path d="M 1149 190 V 212 M 1155 190 V 212 M 1161 190 V 212" stroke-width="0.5" opacity="0.7" fill="none"/>
    <path d="M 1144 195 H 1166 M 1144 201 H 1166 M 1144 207 H 1166" stroke-width="0.5" opacity="0.7" fill="none"/>
    <!-- Jaali 3 -->
    <rect x="1178" y="190" width="22" height="22"/>
    <path d="M 1183 190 V 212 M 1189 190 V 212 M 1195 190 V 212" stroke-width="0.5" opacity="0.7" fill="none"/>
    <path d="M 1178 195 H 1200 M 1178 201 H 1200 M 1178 207 H 1200" stroke-width="0.5" opacity="0.7" fill="none"/>
  </g>

  <!-- ============================================================
       WALL SURFACE ARTICULATION — very subtle horizontal limewash
       plaster lines (short, scattered, low opacity) suggesting
       the wall was plastered in horizontal courses.
       ============================================================ -->
  <g stroke="var(--forest)" stroke-width="0.5" opacity="0.18"
     stroke-linecap="round" fill="none">
    <!-- Left of door -->
    <path d="M 100 220 H 280"/>
    <path d="M 100 290 H 200"/>
    <path d="M 240 290 H 380"/>
    <path d="M 100 380 H 200"/>
    <path d="M 240 380 H 380"/>
    <path d="M 100 480 H 380"/>
    <path d="M 100 580 H 200"/>
    <path d="M 240 580 H 380"/>
    <path d="M 100 680 H 380"/>
    <!-- Between door and window -->
    <path d="M 680 350 H 800"/>
    <path d="M 680 450 H 800"/>
    <path d="M 680 550 H 800"/>
    <path d="M 680 650 H 800"/>
    <!-- Right of window -->
    <path d="M 1080 350 H 1300"/>
    <path d="M 1080 450 H 1240"/>
    <path d="M 1080 550 H 1240"/>
    <path d="M 1080 650 H 1300"/>
  </g>

  <!-- ============================================================
       MATURE TREE — restrained line-drawn tree on the left side.
       Full canopy (rounded mass with overlapping arcs), slender
       trunk, a few interior vein lines.
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Trunk — single slender stroke from ground up into canopy -->
    <path d="M 175 790 L 170 580" stroke-width="1.35" opacity="0.85"/>
    <!-- Two main branches splitting off the trunk -->
    <path d="M 172 660 C 158 640, 142 632, 130 628" stroke-width="0.85" opacity="0.7"/>
    <path d="M 170 640 C 184 620, 200 612, 212 608" stroke-width="0.85" opacity="0.7"/>
    <!-- Canopy — full rounded mass built from overlapping arcs.
         Drawn as a closed contour with several cubic curves for
         natural edge variation. Spans approx x=80 to x=260,
         y=440 to y=600. -->
    <path d="M 100 560
             C 88 540, 92 510, 112 496
             C 108 476, 124 458, 148 458
             C 152 440, 178 432, 198 444
             C 216 432, 240 440, 250 460
             C 274 460, 288 482, 280 504
             C 292 514, 294 538, 278 552
             C 282 568, 270 584, 248 588
             C 238 600, 218 604, 200 596
             C 184 608, 158 608, 144 596
             C 124 604, 102 596, 96 580
             C 86 574, 88 566, 100 560 Z"
          stroke-width="1.35" opacity="0.85"/>
    <!-- Canopy interior vein lines — 3 subtle branching marks -->
    <path d="M 174 540 C 168 552, 160 562, 152 568" stroke-width="0.85" opacity="0.55"/>
    <path d="M 174 540 C 182 552, 190 562, 198 568" stroke-width="0.85" opacity="0.55"/>
    <path d="M 174 540 L 174 524" stroke-width="0.85" opacity="0.45"/>
    <!-- Root flare at the base of the trunk -->
    <path d="M 167 790 C 162 794, 156 794, 152 792" stroke-width="0.85" opacity="0.6"/>
    <path d="M 178 790 C 183 794, 189 794, 193 792" stroke-width="0.85" opacity="0.6"/>
  </g>

  <!-- ============================================================
       EARTHEN / STONE FLOOR BASELINE — ground line + subtle texture
       marks (stone tile seams + a few grass tufts at the wall base).
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Main ground line -->
    <path d="M 0 790 H 1440" stroke-width="1.35" opacity="0.5"/>
    <!-- Lower subtle ground line (suggests ground depth) -->
    <path d="M 0 810 H 1440" stroke-width="0.85" opacity="0.25"/>
    <!-- Stone tile seam marks (subtle vertical ticks on the floor) -->
    <g stroke-width="0.85" opacity="0.3">
      <path d="M 220 790 L 220 810"/>
      <path d="M 380 790 L 380 810"/>
      <path d="M 540 790 L 540 810"/>
      <path d="M 700 790 L 700 810"/>
      <path d="M 860 790 L 860 810"/>
      <path d="M 1020 790 L 1020 810"/>
      <path d="M 1180 790 L 1180 810"/>
      <path d="M 1340 790 L 1340 810"/>
    </g>
    <!-- Small grass tufts at the base of the wall (restrained) -->
    <g stroke-width="0.85" opacity="0.6">
      <path d="M 410 790 L 408 784"/>
      <path d="M 412 790 L 412 782"/>
      <path d="M 414 790 L 416 784"/>
      <path d="M 720 790 L 718 784"/>
      <path d="M 722 790 L 722 782"/>
      <path d="M 724 790 L 726 784"/>
      <path d="M 1300 790 L 1298 784"/>
      <path d="M 1302 790 L 1302 782"/>
      <path d="M 1304 790 L 1306 784"/>
    </g>
  </g>

</svg>
