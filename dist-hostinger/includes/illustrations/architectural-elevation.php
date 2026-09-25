<?php
/**
 * Illustration: Architectural Project Elevation
 * V3 core illustration system.
 *
 * Orthographic elevation of a modest contemporary Indian
 * residential/institutional building. Pure elevation — no 3D
 * perspective, no shadows, no gloss. Communicates "architects /
 * builders / projects" through technical-drawing discipline:
 * dimension ticks with end slashes, a faint architectural grid,
 * restrained opening proportions, one wall plane picked out in
 * haldi (the "Prakritik Paint goes here" callout).
 *
 * Stroke language: 1.35px main organic, 0.85px detail. Round cap/join.
 * (Architectural dimension extension lines use square cap for crisp
 * endpoint registration — a deliberate technical-drawing override.)
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 1200 700" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Architectural building elevation</title>

  <!-- ============================================================
       ARCHITECTURAL GRID — very faint, suggests drawing paper.
       Vertical every 60px, horizontal every 60px. Opacity 0.05.
       ============================================================ -->
  <g stroke="var(--forest)" stroke-width="0.5" opacity="0.05">
    <!-- Vertical grid lines (across the building width) -->
    <path d="M 240 100 V 620"/>
    <path d="M 300 100 V 620"/>
    <path d="M 360 100 V 620"/>
    <path d="M 420 100 V 620"/>
    <path d="M 480 100 V 620"/>
    <path d="M 540 100 V 620"/>
    <path d="M 600 100 V 620"/>
    <path d="M 660 100 V 620"/>
    <path d="M 720 100 V 620"/>
    <path d="M 780 100 V 620"/>
    <path d="M 840 100 V 620"/>
    <path d="M 900 100 V 620"/>
    <path d="M 960 100 V 620"/>
    <!-- Horizontal grid lines -->
    <path d="M 240 120 H 960"/>
    <path d="M 240 180 H 960"/>
    <path d="M 240 240 H 960"/>
    <path d="M 240 300 H 960"/>
    <path d="M 240 360 H 960"/>
    <path d="M 240 420 H 960"/>
    <path d="M 240 480 H 960"/>
    <path d="M 240 540 H 960"/>
    <path d="M 240 580 H 960"/>
  </g>

  <!-- ============================================================
       HALDI-HIGHLIGHTED WALL PLANE — the "Prakritik Paint goes here"
       callout. Filled at 0.5 opacity. Drawn UNDER the wall outline
       so the outline reads cleanly on top.
       ============================================================ -->
  <rect id="arch-elev-haldi-plane"
        x="600" y="260" width="360" height="160"
        fill="var(--haldi)" stroke="none" opacity="0.5"/>

  <!-- ============================================================
       BUILDING ELEVATION — line-drawn, orthographic
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- BUILDING OUTLINE — main facade rectangle -->
    <rect x="240" y="120" width="720" height="460"
          stroke-width="1.35" fill="var(--limewash)"/>

    <!-- PARAPET — thin band at the top, slightly proud -->
    <path d="M 240 120 H 960" stroke-width="1.35"/>
    <path d="M 240 130 H 960" stroke-width="0.85" opacity="0.55"/>

    <!-- FLOOR DIVIDER LINES — horizontal lines at each floor level -->
    <path d="M 240 260 H 960" stroke-width="0.85" opacity="0.7"/>
    <path d="M 240 420 H 960" stroke-width="0.85" opacity="0.7"/>

    <!-- VERTICAL STRUCTURAL BAYS — subtle verticals that suggest
         the building's structural grid (columns / load-bearing piers) -->
    <path d="M 360 130 V 580" stroke-width="0.85" opacity="0.35"/>
    <path d="M 600 130 V 580" stroke-width="0.85" opacity="0.35"/>
    <path d="M 840 130 V 580" stroke-width="0.85" opacity="0.35"/>

    <!-- ===== FLOOR 3 (TOP) — 3 smaller windows ===== -->
    <rect x="290" y="170" width="50" height="80"
          fill="var(--background)" stroke-width="1.35"/>
    <rect x="575" y="170" width="50" height="80"
          fill="var(--background)" stroke-width="1.35"/>
    <rect x="860" y="170" width="50" height="80"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Window mullion crosses -->
    <path d="M 315 170 V 250" stroke-width="0.85" opacity="0.5"/>
    <path d="M 290 210 H 340" stroke-width="0.85" opacity="0.5"/>
    <path d="M 600 170 V 250" stroke-width="0.85" opacity="0.5"/>
    <path d="M 575 210 H 625" stroke-width="0.85" opacity="0.5"/>
    <path d="M 885 170 V 250" stroke-width="0.85" opacity="0.5"/>
    <path d="M 860 210 H 910" stroke-width="0.85" opacity="0.5"/>

    <!-- ===== FLOOR 2 (MIDDLE) — 4 windows ===== -->
    <!-- Left window (in the limewash plane) -->
    <rect x="285" y="295" width="60" height="100"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Window between limewash and haldi plane -->
    <rect x="455" y="295" width="60" height="100"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Window inside the haldi plane -->
    <rect x="650" y="295" width="60" height="100"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Right window (in the haldi plane) -->
    <rect x="855" y="295" width="60" height="100"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Window mullion crosses -->
    <path d="M 315 295 V 395" stroke-width="0.85" opacity="0.5"/>
    <path d="M 285 345 H 345" stroke-width="0.85" opacity="0.5"/>
    <path d="M 485 295 V 395" stroke-width="0.85" opacity="0.5"/>
    <path d="M 455 345 H 515" stroke-width="0.85" opacity="0.5"/>
    <path d="M 680 295 V 395" stroke-width="0.85" opacity="0.5"/>
    <path d="M 650 345 H 710" stroke-width="0.85" opacity="0.5"/>
    <path d="M 885 295 V 395" stroke-width="0.85" opacity="0.5"/>
    <path d="M 855 345 H 915" stroke-width="0.85" opacity="0.5"/>

    <!-- ===== FLOOR 1 (GROUND) — entrance door + 2 side windows ===== -->
    <!-- Main entrance door (center-left) — timber, double-leaf -->
    <rect x="380" y="430" width="120" height="150"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Door divider (double-leaf split) -->
    <path d="M 440 430 V 580" stroke-width="0.85" opacity="0.55"/>
    <!-- Door jamb depth suggestion -->
    <path d="M 385 435 V 575" stroke-width="0.85" opacity="0.35"/>
    <!-- Door threshold -->
    <path d="M 378 580 L 502 580" stroke-width="1.35" opacity="0.85"/>
    <!-- Door handle marks (haldi dots) -->
    <circle cx="430" cy="510" r="1.6" fill="var(--haldi)" stroke="none"/>
    <circle cx="450" cy="510" r="1.6" fill="var(--haldi)" stroke="none"/>
    <!-- Door canopy / verandah projection above the entrance -->
    <path d="M 360 425 H 540" stroke-width="0.85" opacity="0.55"/>
    <path d="M 360 425 L 360 432" stroke-width="0.85" opacity="0.55"/>
    <path d="M 540 425 L 540 432" stroke-width="0.85" opacity="0.55"/>

    <!-- Left ground-floor window -->
    <rect x="270" y="460" width="80" height="80"
          fill="var(--background)" stroke-width="1.35"/>
    <path d="M 310 460 V 540" stroke-width="0.85" opacity="0.5"/>
    <path d="M 270 500 H 350" stroke-width="0.85" opacity="0.5"/>
    <!-- Sill line -->
    <path d="M 268 540 L 352 540" stroke-width="0.85" opacity="0.55"/>

    <!-- Right ground-floor window (in the haldi plane) -->
    <rect x="855" y="460" width="80" height="80"
          fill="var(--background)" stroke-width="1.35"/>
    <path d="M 895 460 V 540" stroke-width="0.85" opacity="0.5"/>
    <path d="M 855 500 H 935" stroke-width="0.85" opacity="0.5"/>
    <path d="M 853 540 L 937 540" stroke-width="0.85" opacity="0.55"/>

    <!-- ===== PLINTH — base band, slightly wider than building ===== -->
    <rect x="220" y="580" width="760" height="40"
          fill="var(--mitti)" stroke="var(--forest)" stroke-width="1.35" opacity="0.18"/>
    <path d="M 220 580 H 980" stroke-width="1.35"/>
    <path d="M 220 620 H 980" stroke-width="1.35"/>
    <path d="M 220 612 H 980" stroke-width="0.85" opacity="0.5"/>

    <!-- ===== GROUND LINE ===== -->
    <path d="M 80 620 H 1120" stroke-width="1.35" opacity="0.55"/>

    <!-- ===== SUBTLE LIMEWASH PLASTER LINES on the wall
            (very short, scattered, low opacity) ===== -->
    <g stroke-width="0.5" opacity="0.18">
      <path d="M 250 200 H 280"/>
      <path d="M 400 200 H 430"/>
      <path d="M 250 360 H 280"/>
      <path d="M 400 360 H 430"/>
      <path d="M 250 500 H 270"/>
      <path d="M 540 200 H 570"/>
      <path d="M 720 220 H 760"/>
    </g>

  </g>

  <!-- ============================================================
       DIMENSION TICKS — thin extension lines with 45° end slashes.
       Square cap on extension lines (technical-drawing convention).
       ============================================================ -->
  <g fill="none" stroke="var(--forest)" stroke-width="0.85"
     stroke-linecap="square" stroke-linejoin="round">

    <!-- LEFT SIDE — total building height dimension (parapet → plinth top) -->
    <!-- Extension lines from building left edge outward -->
    <path d="M 240 120 H 160" opacity="0.7"/>
    <path d="M 240 580 H 160" opacity="0.7"/>
    <!-- Dimension line -->
    <path d="M 170 120 V 580" opacity="0.85"/>
    <!-- End ticks (45° slashes) -->
    <path d="M 165 124 L 175 116"/>
    <path d="M 165 584 L 175 576"/>
    <!-- Sub-dimensions for each floor -->
    <path d="M 240 260 H 180" opacity="0.55"/>
    <path d="M 240 420 H 180" opacity="0.55"/>
    <!-- Small ticks at the floor dividers on the dimension line -->
    <path d="M 165 264 L 175 256" opacity="0.7"/>
    <path d="M 165 424 L 175 416" opacity="0.7"/>

    <!-- RIGHT SIDE — single floor height dimension -->
    <path d="M 960 260 H 1040" opacity="0.7"/>
    <path d="M 960 420 H 1040" opacity="0.7"/>
    <path d="M 1030 260 V 420" opacity="0.85"/>
    <path d="M 1025 264 L 1035 256"/>
    <path d="M 1025 424 L 1035 416"/>

    <!-- BOTTOM — building width dimension -->
    <path d="M 240 620 V 670" opacity="0.7"/>
    <path d="M 960 620 V 670" opacity="0.7"/>
    <path d="M 240 660 H 960" opacity="0.85"/>
    <path d="M 236 656 L 244 664"/>
    <path d="M 956 656 L 964 664"/>
    <!-- Structural bay sub-dimensions (3 bays) -->
    <path d="M 360 620 V 650" opacity="0.55"/>
    <path d="M 600 620 V 650" opacity="0.55"/>
    <path d="M 840 620 V 650" opacity="0.55"/>
    <path d="M 356 646 L 364 654" opacity="0.7"/>
    <path d="M 596 646 L 604 654" opacity="0.7"/>
    <path d="M 836 646 L 844 654" opacity="0.7"/>

  </g>

  <!-- ===== TINY ANNOTATION TICK next to the haldi plane ===== -->
  <g fill="none" stroke="var(--forest)" stroke-width="0.85"
     stroke-linecap="round">
    <!-- Leader line from the haldi plane to a small label position -->
    <path d="M 780 260 L 780 220 L 880 220" opacity="0.7"/>
    <!-- Small endpoint dot -->
    <circle cx="780" cy="260" r="2" fill="var(--haldi)" stroke="var(--forest)" stroke-width="0.85"/>
  </g>
  <!-- Annotation text (Manrope, small, soft-ink) -->
  <text x="884" y="216"
        font-family="var(--font-sans)" font-size="10" font-weight="600"
        fill="var(--soft-ink)" stroke="none" letter-spacing="1.2"
        opacity="0.85">PAINT ZONE</text>

</svg>
