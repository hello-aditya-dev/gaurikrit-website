<?php
/**
 * Illustration: Calculator Wall Scene
 * V3 core illustration system.
 *
 * A layered interactive wall scene that responds to calculator
 * selections via data- attributes on the SVG root. The wall
 * surface is recolourable (id="wall-surface"). Various optional
 * detail layers appear/disappear based on calculator state.
 *
 * Base elements (always visible):
 *   - Wall/room elevation (rect with door + window openings)
 *   - Floor line (ground baseline)
 *   - Architectural dimension lines (vertical height + horizontal
 *     width) with end ticks
 *
 * Dynamic elements (controlled via CSS reacting to data- attributes
 * on the root <svg>, set by the calculator JS):
 *   [data-state="fresh"]    wall-surface limewash fill (default)
 *   [data-state="repaint"]  repaint-edge appears (mitti/geru patch
 *                           along bottom edge — previous colour)
 *   [data-location="interior"]  interior-detail appears (baseboard)
 *   [data-location="exterior"]  exterior-detail appears (plinth +
 *                               subtle sky line)
 *   [data-paint="distemper"]  product-distemper mark (corner)
 *   [data-paint="emulsion"]   product-emulsion mark (corner)
 *   [data-area]               dimension-annotation appears with the
 *                             entered value
 *
 * Stroke language: 1.35px main, 0.85px detail. Round cap/join.
 * Square cap on dimension extension lines (technical-drawing
 * convention).
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 800 600" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Calculator wall scene</title>

  <defs>
    <style>
      /* ===== Default hidden dynamic layers ===== */
      #repaint-edge,
      #interior-detail,
      #exterior-detail,
      #product-distemper,
      #product-emulsion,
      #dimension-annotation {
        display: none;
      }

      /* ===== State: repaint — show previous-colour patch ===== */
      svg[data-state="repaint"] #repaint-edge { display: block; }

      /* ===== Location: interior / exterior ===== */
      svg[data-location="interior"] #interior-detail { display: block; }
      svg[data-location="exterior"] #exterior-detail { display: block; }

      /* ===== Paint type — product mark ===== */
      svg[data-paint="distemper"] #product-distemper { display: block; }
      svg[data-paint="emulsion"] #product-emulsion { display: block; }

      /* ===== Area entered — dimension annotation appears ===== */
      svg[data-area]:not([data-area=""]) #dimension-annotation { display: block; }

      /* ===== Wall surface recolouring based on state =====
         Default (fresh or unset): limewash fill.
         Repaint: limewash fill (the repaint-edge overlay carries
         the previous-colour patch). */
    </style>
  </defs>

  <!-- ============================================================
       EXTERIOR DETAIL (sky line + plinth) — visible only when
       data-location="exterior"
       ============================================================ -->
  <g id="exterior-detail" fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Subtle horizon / sky line above the wall -->
    <path d="M 0 60 H 800" stroke-width="0.85" opacity="0.3"/>
    <!-- Plinth band — slightly wider than the wall, miti-toned -->
    <rect x="80" y="520" width="640" height="20"
          fill="var(--mitti)" stroke="var(--forest)" stroke-width="1.35" opacity="0.2"/>
    <!-- Plinth horizontal lines (top + bottom) -->
    <path d="M 80 520 H 720" stroke-width="1.35"/>
    <path d="M 80 540 H 720" stroke-width="1.35"/>
    <path d="M 80 533 H 720" stroke-width="0.85" opacity="0.5"/>
  </g>

  <!-- ============================================================
       WALL SURFACE — recolourable plane (id="wall-surface")
       Default limewash fill; the Colours of India JS / calculator
       JS can override this fill via the style attribute or via
       CSS variable substitution.
       ============================================================ -->
  <rect id="wall-surface" x="100" y="80" width="600" height="440"
        fill="var(--limewash)" stroke="none"/>

  <!-- Subtle limewash plaster lines on the wall (always visible
       for material suggestion, very low opacity) -->
  <g stroke="var(--forest)" stroke-width="0.5" opacity="0.18"
     stroke-linecap="round" fill="none">
    <path d="M 120 160 H 180"/>
    <path d="M 340 140 H 420"/>
    <path d="M 640 220 H 690"/>
    <path d="M 120 360 H 180"/>
    <path d="M 340 380 H 420"/>
    <path d="M 640 420 H 690"/>
    <path d="M 120 460 H 180"/>
    <path d="M 340 460 H 420"/>
  </g>

  <!-- ============================================================
       REPAINT EDGE — previous-colour patch along the bottom edge
       Visible only when data-state="repaint". Mitti-toned band
       along the base of the wall, suggesting the old paint colour
       exposed where the new paint hasn't fully covered.
       ============================================================ -->
  <g id="repaint-edge">
    <!-- Mitti patch along the bottom of the wall (irregular top edge) -->
    <path d="M 100 480
             C 200 478, 300 482, 400 480
             C 500 478, 600 482, 700 480
             L 700 520 L 100 520 Z"
          fill="var(--mitti)" stroke="var(--forest)"
          stroke-width="0.85" opacity="0.55"/>
    <!-- Geru accent (small darker patch within the mitti band) -->
    <path d="M 380 500 C 420 498, 460 502, 480 500 L 480 520 L 380 520 Z"
          fill="var(--geru)" stroke="none" opacity="0.35"/>
    <!-- Subtle seam line where old meets new paint -->
    <path d="M 100 480 C 200 478, 300 482, 400 480
             C 500 478, 600 482, 700 480"
          stroke="var(--forest)" stroke-width="0.85"
          fill="none" opacity="0.5"/>
  </g>

  <!-- ============================================================
       WALL OUTLINE (always visible) — drawn on top of wall-surface
       so the recolour doesn't affect the crisp outline.
       ============================================================ -->
  <rect x="100" y="80" width="600" height="440"
        fill="none" stroke="var(--forest)" stroke-width="1.35"/>

  <!-- PARAPET / CORNICE — thin double line at top of wall -->
  <g fill="none" stroke="var(--forest)" stroke-linecap="round">
    <path d="M 100 80 H 700" stroke-width="1.35"/>
    <path d="M 100 90 H 700" stroke-width="0.85" opacity="0.55"/>
  </g>

  <!-- ============================================================
       DOOR OPENING — rectangular, height ~2x width, double-leaf
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Door opening (recessed background tone) -->
    <rect x="200" y="300" width="100" height="220"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Door jamb depth suggestion (second interior stroke) -->
    <path d="M 206 306 L 206 520" stroke-width="0.85" opacity="0.4"/>
    <path d="M 294 306 L 294 520" stroke-width="0.85" opacity="0.4"/>
    <path d="M 206 306 H 294" stroke-width="0.85" opacity="0.4"/>
    <!-- Door panel divider (double-leaf split) -->
    <path d="M 250 300 V 520" stroke-width="0.85" opacity="0.55"/>
    <!-- Timber board lines (4 vertical boards per leaf) -->
    <path d="M 215 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <path d="M 230 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <path d="M 240 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <path d="M 260 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <path d="M 270 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <path d="M 285 300 V 520" stroke-width="0.5" opacity="0.4"/>
    <!-- Door threshold -->
    <path d="M 198 520 L 302 520" stroke-width="1.35" opacity="0.85"/>
    <!-- Door handles (haldi dots) -->
    <circle cx="240" cy="420" r="1.8" fill="var(--haldi)" stroke="none"/>
    <circle cx="260" cy="420" r="1.8" fill="var(--haldi)" stroke="none"/>
  </g>

  <!-- ============================================================
       WINDOW OPENING — rectangular, with mullion cross
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Window opening (recessed background tone) -->
    <rect x="480" y="180" width="140" height="140"
          fill="var(--background)" stroke-width="1.35"/>
    <!-- Window jamb depth suggestion -->
    <path d="M 486 186 L 486 320" stroke-width="0.85" opacity="0.4"/>
    <path d="M 614 186 L 614 320" stroke-width="0.85" opacity="0.4"/>
    <path d="M 486 186 H 614" stroke-width="0.85" opacity="0.4"/>
    <!-- Mullion cross -->
    <path d="M 550 180 V 320" stroke-width="0.85" opacity="0.55"/>
    <path d="M 480 250 H 620" stroke-width="0.85" opacity="0.55"/>
    <!-- Window sill line (below window, slightly proud) -->
    <path d="M 476 322 L 624 322" stroke-width="1.35" opacity="0.85"/>
  </g>

  <!-- ============================================================
       INTERIOR DETAIL (baseboard) — visible only when
       data-location="interior"
       ============================================================ -->
  <g id="interior-detail" fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Baseboard skirting profile (across the bottom of the wall,
         with a small profile notch at the top) -->
    <rect x="100" y="498" width="600" height="22"
          fill="var(--limewash)" stroke="var(--forest)" stroke-width="1.35"/>
    <path d="M 100 498 H 700" stroke-width="1.35"/>
    <path d="M 100 510 H 700" stroke-width="0.85" opacity="0.55"/>
    <!-- Small profile notch (skirting toe) -->
    <path d="M 100 514 H 700" stroke-width="0.85" opacity="0.4"/>
    <!-- Note: the door opening sits in front of the baseboard
         (the door + threshold are drawn above the baseboard). -->
  </g>

  <!-- ============================================================
       FLOOR LINE — ground baseline, always visible
       ============================================================ -->
  <path d="M 0 540 H 800" fill="none" stroke="var(--forest)"
        stroke-width="1.35" opacity="0.55"/>

  <!-- ============================================================
       DIMENSION LINES — architectural dimension marks with end ticks
       (always visible — they're part of the base technical drawing)
       ============================================================ -->
  <g fill="none" stroke="var(--forest)" stroke-width="0.85"
     stroke-linecap="square" stroke-linejoin="round">
    <!-- LEFT — wall height dimension (vertical) -->
    <!-- Extension lines from wall top + bottom outward to x=60 -->
    <path d="M 100 80 H 60" opacity="0.7"/>
    <path d="M 100 520 H 60" opacity="0.7"/>
    <!-- Dimension line at x=70 -->
    <path d="M 70 80 V 520" opacity="0.85"/>
    <!-- End ticks (45° slashes) -->
    <path d="M 65 84 L 75 76"/>
    <path d="M 65 524 L 75 516"/>
    <!-- Sub-tick at floor line -->
    <path d="M 100 540 H 60" opacity="0.55"/>
    <path d="M 65 544 L 75 536" opacity="0.7"/>

    <!-- BOTTOM — wall width dimension (horizontal) -->
    <!-- Extension lines from wall left + right downward to y=580 -->
    <path d="M 100 540 V 580" opacity="0.7"/>
    <path d="M 700 540 V 580" opacity="0.7"/>
    <!-- Dimension line at y=570 -->
    <path d="M 100 570 H 700" opacity="0.85"/>
    <!-- End ticks -->
    <path d="M 96 566 L 104 574"/>
    <path d="M 696 566 L 704 574"/>
    <!-- Door width sub-tick -->
    <path d="M 200 540 V 560" opacity="0.55"/>
    <path d="M 300 540 V 560" opacity="0.55"/>
    <path d="M 196 556 L 204 564" opacity="0.7"/>
    <path d="M 296 556 L 304 564" opacity="0.7"/>
    <!-- Window width sub-tick -->
    <path d="M 480 540 V 560" opacity="0.55"/>
    <path d="M 620 540 V 560" opacity="0.55"/>
    <path d="M 476 556 L 484 564" opacity="0.7"/>
    <path d="M 616 556 L 624 564" opacity="0.7"/>
  </g>

  <!-- ============================================================
       DIMENSION ANNOTATION — visible only when [data-area] is set
       on the SVG root. JS sets the text content of the value.
       Two text elements: a label and the value (with a small
       leader line connecting them to the wall).
       ============================================================ -->
  <g id="dimension-annotation">
    <!-- Leader line + dot from the wall centre to the annotation -->
    <path d="M 400 80 L 400 40" stroke="var(--forest)"
          stroke-width="0.85" fill="none" opacity="0.7"
          stroke-linecap="round"/>
    <circle cx="400" cy="80" r="2"
            fill="var(--haldi)" stroke="var(--forest)" stroke-width="0.85"/>
    <!-- Label background pill (subtle limewash tone) -->
    <rect x="320" y="20" width="160" height="24"
          fill="var(--limewash)" stroke="var(--forest)"
          stroke-width="0.85" rx="3"/>
    <!-- "Area" label (Manrope, soft-ink) -->
    <text x="335" y="36"
          font-family="var(--font-sans)" font-size="10" font-weight="600"
          fill="var(--soft-ink)" stroke="none" letter-spacing="1.2">
      AREA
    </text>
    <!-- Value (Manrope, forest, bold) — JS replaces the content -->
    <text id="dimension-annotation-value" x="470" y="36"
          font-family="var(--font-sans)" font-size="12" font-weight="700"
          fill="var(--forest)" stroke="none" text-anchor="end"
          letter-spacing="0.8">
      — m²
    </text>
  </g>

  <!-- ============================================================
       PRODUCT MARK — DISTEMPER (visible only when
       data-paint="distemper"). A small simplified distemper bucket
       mark in the lower-right corner, beside the dimension line.
       ============================================================ -->
  <g id="product-distemper" fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Bucket body — short, slightly tapered -->
    <path d="M 730 510 L 736 555 L 770 555 L 776 510 Z"
          stroke-width="1.35" fill="var(--forest)"/>
    <!-- Top rim ellipse -->
    <ellipse cx="753" cy="510" rx="23" ry="4"
             fill="var(--forest)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Inner rim (limewash) -->
    <ellipse cx="753" cy="509" rx="19" ry="3"
             fill="var(--limewash)" stroke="none"/>
    <!-- Handle arch -->
    <path d="M 731 510 C 740 496, 766 496, 775 510"
          stroke-width="1.35"/>
    <!-- Haldi accent stripes -->
    <path d="M 731 525 C 740 527, 766 527, 775 525"
          stroke="var(--haldi)" stroke-width="0.85"/>
    <path d="M 733 545 C 740 547, 766 547, 773 545"
          stroke="var(--haldi)" stroke-width="0.85"/>
    <!-- Label text -->
    <text x="753" y="540"
          font-family="var(--font-display)" font-size="6" font-weight="700"
          fill="var(--paper)" stroke="none"
          text-anchor="middle" letter-spacing="0.6">DISTEMPER</text>
  </g>

  <!-- ============================================================
       PRODUCT MARK — EMULSION (visible only when
       data-paint="emulsion"). A taller bucket mark.
       ============================================================ -->
  <g id="product-emulsion" fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Bucket body — taller, slightly tapered -->
    <path d="M 728 500 L 735 555 L 772 555 L 779 500 Z"
          stroke-width="1.35" fill="var(--forest)"/>
    <!-- Top rim ellipse -->
    <ellipse cx="753" cy="500" rx="25" ry="4"
             fill="var(--forest)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Inner rim (limewash) with subtle liquid line -->
    <ellipse cx="753" cy="499" rx="21" ry="3"
             fill="var(--limewash)" stroke="none"/>
    <ellipse cx="753" cy="500" rx="18" ry="2.5"
             fill="var(--haldi)" stroke="none" opacity="0.32"/>
    <!-- Handle arch -->
    <path d="M 729 500 C 740 484, 766 484, 777 500"
          stroke-width="1.35"/>
    <!-- Haldi accent stripes -->
    <path d="M 729 520 C 740 522, 766 522, 777 520"
          stroke="var(--haldi)" stroke-width="0.85"/>
    <path d="M 731 545 C 740 547, 766 547, 775 545"
          stroke="var(--haldi)" stroke-width="0.85"/>
    <!-- Label text (3-line emulsion label) -->
    <text x="753" y="518"
          font-family="var(--font-display)" font-size="5.5" font-weight="700"
          fill="var(--paper)" stroke="none"
          text-anchor="middle" letter-spacing="0.5">GAURIKRIT</text>
    <text x="753" y="532"
          font-family="var(--font-display)" font-size="5.5" font-weight="700"
          fill="var(--paper)" stroke="none"
          text-anchor="middle" letter-spacing="0.5">PRAKRITIK</text>
    <text x="753" y="546"
          font-family="var(--font-display)" font-size="5.5" font-weight="700"
          fill="var(--haldi-soft)" stroke="none"
          text-anchor="middle" letter-spacing="0.5">EMULSION</text>
  </g>

</svg>
