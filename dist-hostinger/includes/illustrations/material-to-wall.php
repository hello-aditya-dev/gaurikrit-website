<?php
/**
 * Illustration: Material-to-Wall Diagram
 * V3 core illustration system.
 *
 * Three conceptual stages (manufacturing details are NOT confirmed —
 * this is a conceptual narrative, not a process diagram):
 *   01 NATURAL MATERIAL  — a simplified cow profile (source)
 *   02 PRAKRITIK PAINT   — a paint vessel (tin) + brush (product)
 *   03 FINISHED WALL     — a wall elevation with door opening (application)
 *
 * ONE continuous line runs through all three stages, transitioning
 * visually from a forest ground-line (under the cow) → a forest
 * material-line → a haldi paint-stroke segment (where the brush
 * would lay paint) → a forest wall-baseline (under the finished
 * wall). The haldi paint-stroke segment is the only haldi in the
 * diagram — it is the material transition from raw to applied.
 *
 * Stroke language: 1.35px main organic, 0.85px detail. Round cap/join.
 * Stage numerals in Newsreader serif (var(--font-display)) — large,
 * editorial. Stage labels in Manrope (var(--font-sans)) — small caps.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 1600 500" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Material to wall diagram</title>

  <defs>
    <!-- Haldi paint-stroke gradient — soft to deep, gives the stroke
         segment a wet-paint feel without going glossy. -->
    <linearGradient id="mtw-paint" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%"  stop-color="var(--haldi-soft)"/>
      <stop offset="50%" stop-color="var(--haldi)"/>
      <stop offset="100%" stop-color="var(--haldi)"/>
    </linearGradient>
  </defs>

  <!-- ============================================================
       CONTINUOUS CONNECTING LINE — runs through all three stages.
       Three visually-joined segments at y=380 (ground/baseline).

       Segment 1: forest ground-line under the cow (x=130 → 540)
       Segment 2: forest transition segment (x=540 → 580)
       Segment 3: HALDI paint stroke — wider, organic edge (x=580 → 1080)
       Segment 4: forest wall baseline under the finished wall (x=1080 → 1560)
       ============================================================ -->
  <g fill="none" stroke-linecap="round" stroke-linejoin="round">
    <!-- Forest ground-line under cow -->
    <path d="M 130 380 L 540 380"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.85"/>
    <!-- Brief forest transition (subtle visual seam between ground and paint) -->
    <path d="M 540 380 L 580 380"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.55"/>
    <!-- Haldi paint stroke — wider, with a faint organic wobble -->
    <path d="M 580 380 C 660 378, 880 382, 980 379 C 1030 378, 1060 380, 1080 380"
          stroke="url(#mtw-paint)" stroke-width="6" opacity="0.95"/>
    <!-- Subtle haldi halo just above the stroke segment — paint being laid onto a surface -->
    <path d="M 600 376 C 700 374, 900 378, 1060 376"
          stroke="var(--haldi)" stroke-width="2.5" opacity="0.4"/>
    <!-- Forest wall baseline -->
    <path d="M 1080 380 L 1560 380"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.85"/>
  </g>

  <!-- ============================================================
       STAGE 01 — NATURAL MATERIAL (simplified cow profile, facing right)
       Cow sits small in the section, ground at y=380.
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- FAR HORN — drawn behind head, lighter -->
    <path d="M 372 296 C 365 282, 358 274, 348 276"
          stroke-width="0.85" opacity="0.7"/>
    <!-- FAR EAR — small leaf behind head, lighter -->
    <path d="M 376 304 C 372 318, 366 328, 360 332
             C 362 322, 366 312, 372 304 Z"
          stroke-width="0.85" opacity="0.65"/>

    <!-- BODY BARREL — closed contour: chest top → back → rump → belly → chest front -->
    <path d="M 340 280
             C 320 273, 280 270, 230 272
             C 210 274, 196 278, 192 286
             C 188 296, 188 304, 192 312
             L 200 322
             L 335 322
             C 340 316, 342 308, 342 300
             C 342 290, 342 284, 340 280 Z"
          stroke-width="1.35"/>

    <!-- HUMP — open curve rising above the back line, between chest and mid-back -->
    <path d="M 332 278
             C 322 252, 300 240, 280 246
             C 270 250, 262 262, 258 272"
          stroke-width="1.35"/>

    <!-- NECK TOP — from chest top forward-down to the poll -->
    <path d="M 340 280
             C 352 285, 364 290, 372 294"
          stroke-width="1.35"/>

    <!-- HEAD / FACE — closed contour: poll → forehead → bridge → muzzle → under-jaw → cheek → poll.
         Elongated narrow face; muzzle extends forward of poll. Cow faces RIGHT. -->
    <path d="M 372 294
             C 378 296, 384 300, 388 304
             C 392 308, 396 312, 400 316
             C 404 320, 408 322, 410 324
             C 408 326, 404 328, 400 328
             C 396 330, 392 332, 388 332
             C 384 332, 380 332, 376 332
             C 374 328, 372 322, 372 316
             C 372 308, 372 300, 372 294 Z"
          stroke-width="1.35"/>

    <!-- DEWLAP — loose skin fold from under-jaw down to chest, with one fold line -->
    <path d="M 388 332 C 384 340, 380 348, 376 354
             C 372 358, 366 360, 358 360"
          stroke-width="1.35"/>
    <path d="M 392 334 C 388 342, 384 350, 380 356"
          stroke-width="0.85" opacity="0.55"/>

    <!-- NEAR HORN — drawn over the head, prominent. From poll up-back to the left. -->
    <path d="M 374 294
             C 368 280, 360 270, 350 272
             C 348 274, 350 276, 352 278"
          stroke-width="1.35"/>

    <!-- NEAR EAR — long leaf hanging down-back. From below horn, down-left. -->
    <path d="M 380 302
             C 376 316, 370 328, 364 334
             C 360 332, 362 322, 366 312
             C 370 304, 374 300, 380 302 Z"
          stroke-width="1.35"/>

    <!-- EYE — small filled circle, calm -->
    <circle cx="394" cy="306" r="1.8" fill="var(--forest)" stroke="none"/>

    <!-- BROW — subtle curve above the eye -->
    <path d="M 390 302 C 393 300, 397 300, 400 302"
          stroke-width="0.85" opacity="0.55"/>

    <!-- NOSTRIL — small dot near the muzzle tip -->
    <circle cx="406" cy="320" r="1.2" fill="var(--forest)" stroke="none"/>

    <!-- MOUTH — subtle line at muzzle -->
    <path d="M 404 326 Q 408 328, 412 326"
          stroke-width="0.85" opacity="0.7"/>

    <!-- FRONT LEGS — slender paired strokes. Near (right, foreground). -->
    <path d="M 320 322 L 320 376" stroke-width="1.35"/>
    <path d="M 325 322 L 325 376" stroke-width="1.35"/>
    <!-- Far front leg (slightly offset back, lighter) -->
    <path d="M 310 322 L 310 376" stroke-width="1.35" opacity="0.65"/>
    <path d="M 315 322 L 315 376" stroke-width="1.35" opacity="0.65"/>

    <!-- BACK LEGS — slender paired strokes. Near (left, foreground). -->
    <path d="M 218 322 L 218 376" stroke-width="1.35"/>
    <path d="M 223 322 L 223 376" stroke-width="1.35"/>
    <!-- Far back leg -->
    <path d="M 208 322 L 208 376" stroke-width="1.35" opacity="0.65"/>
    <path d="M 213 322 L 213 376" stroke-width="1.35" opacity="0.65"/>

    <!-- KNEE SUGGESTIONS — small horizontal ticks partway down each near leg -->
    <path d="M 318 350 L 327 350" stroke-width="0.85" opacity="0.45"/>
    <path d="M 216 350 L 225 350" stroke-width="0.85" opacity="0.45"/>

    <!-- HOOF TICKS — small horizontal cloven marks at the base of each leg pair -->
    <path d="M 318 376 L 327 376" stroke-width="1.35"/>
    <path d="M 308 376 L 317 376" stroke-width="1.35" opacity="0.65"/>
    <path d="M 216 376 L 225 376" stroke-width="1.35"/>
    <path d="M 206 376 L 215 376" stroke-width="1.35" opacity="0.65"/>

    <!-- TAIL — from rump curving down-back, with small tuft at end -->
    <path d="M 192 288
             C 186 300, 182 320, 180 340
             C 178 356, 180 368, 184 372"
          stroke-width="1.35"/>
    <!-- TAIL TUFT — three short strokes -->
    <path d="M 184 372 C 180 376, 178 378, 180 380" stroke-width="0.85"/>
    <path d="M 184 372 C 184 376, 184 378, 186 380" stroke-width="0.85"/>
    <path d="M 184 372 C 188 376, 190 378, 188 380" stroke-width="0.85"/>

    <!-- SHOULDER BLADE INTERIOR LINE — subtle scapula suggestion -->
    <path d="M 330 286 C 326 300, 326 312, 328 320"
          stroke-width="0.85" opacity="0.35"/>

    <!-- BELLY MIDLINE — subtle curve suggesting barrel lower contour -->
    <path d="M 200 322 C 240 320, 290 320, 335 322"
          stroke-width="0.85" opacity="0.3"/>

  </g>

  <!-- ============================================================
       STAGE 02 — PRAKRITIK PAINT (paint vessel + brush)
       Bucket centered around x=720, brush around x=920.
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- PAINT VESSEL (TIN) — cylindrical, slight taper from rim to base -->
    <!-- Top rim ellipse (dark green fill for the rolled metal edge) -->
    <ellipse cx="720" cy="240" rx="56" ry="12"
             fill="var(--forest)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Inner opening (limewash tone — interior of the vessel) -->
    <ellipse cx="720" cy="238" rx="48" ry="9"
             fill="var(--limewash)" stroke="none" opacity="0.85"/>
    <!-- Subtle liquid surface line inside the rim (haldi-tinted paint) -->
    <ellipse cx="720" cy="240" rx="44" ry="7"
             fill="var(--haldi)" stroke="none" opacity="0.32"/>
    <path d="M 678 240 C 700 244, 740 244, 762 240"
          stroke="var(--haldi)" stroke-width="0.85" opacity="0.55"/>

    <!-- BODY — slight taper from rim (x=664-776) to base (x=676-764) -->
    <path d="M 664 240 L 676 380 L 764 380 L 776 240"
          stroke-width="1.35"/>

    <!-- METAL BAIL HANDLE — arched over the rim -->
    <path d="M 666 240 C 690 200, 750 200, 774 240"
          stroke-width="1.35"/>
    <!-- Two attachment lugs where bail meets rim -->
    <path d="M 664 236 L 664 244" stroke-width="1.35"/>
    <path d="M 776 236 L 776 244" stroke-width="1.35"/>

    <!-- LABEL BAND — dark green band with curved top/bottom edges (cylinder curve) -->
    <path d="M 668 300
             C 690 304, 750 304, 772 300
             L 770 332
             C 750 336, 690 336, 670 332 Z"
          fill="var(--forest)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- HALDI ACCENT STRIPES above and below the label band -->
    <path d="M 668 294 C 690 298, 750 298, 772 294"
          stroke="var(--haldi)" stroke-width="1.35"/>
    <path d="M 670 338 C 690 342, 750 342, 770 338"
          stroke="var(--haldi)" stroke-width="1.35"/>

    <!-- WORDMARK on label band -->
    <text x="720" y="318"
          font-family="var(--font-display)" font-size="11" font-weight="700"
          fill="var(--paper)" stroke="none"
          text-anchor="middle" letter-spacing="1.2">PRAKRITIK</text>

    <!-- BASE CURVE — subtle ellipse suggestion at the bottom -->
    <path d="M 676 380 C 690 386, 750 386, 764 380"
          stroke-width="0.85" opacity="0.6"/>

    <!-- VERTICAL HIGHLIGHT on left side of vessel — subtle, not glossy -->
    <path d="M 678 250 C 680 290, 680 340, 680 374"
          stroke="var(--paper)" stroke-width="2" opacity="0.25"/>

    <!-- PAINT BRUSH — laying next to the bucket, leaning right toward the wall -->
    <!-- Handle (down-right from top to ferrule) -->
    <path d="M 940 200 L 905 250"
          stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Wood-grain accent on handle -->
    <path d="M 938 205 L 908 248"
          stroke="var(--mitti)" stroke-width="0.85" opacity="0.55"/>
    <!-- Ferrule (metal band) -->
    <path d="M 905 248 L 912 256 L 905 264 L 898 256 Z"
          fill="var(--kraft)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Haldi accent stripe on ferrule -->
    <path d="M 902 256 L 910 256"
          stroke="var(--haldi)" stroke-width="0.85" opacity="0.85"/>
    <!-- Bristles — 3 strokes fanning down-left toward the baseline (paint stroke) -->
    <path d="M 905 264 C 895 280, 885 320, 875 372"
          stroke="var(--forest)" stroke-width="1.35"/>
    <path d="M 905 264 C 905 285, 905 325, 905 374"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.85"/>
    <path d="M 905 264 C 915 285, 925 320, 935 372"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.7"/>
    <!-- Haldi paint on bristle tips — where the brush meets the line -->
    <circle cx="875" cy="374" r="2.5" fill="var(--haldi)" stroke="none"/>
    <circle cx="905" cy="376" r="2.5" fill="var(--haldi)" stroke="none"/>
    <circle cx="935" cy="374" r="2.5" fill="var(--haldi)" stroke="none"/>

  </g>

  <!-- ============================================================
       STAGE 03 — FINISHED WALL (simplified courtyard elevation)
       Wall sits on the continuous baseline at y=380.
       ============================================================ -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- WALL SURFACE — limewash fill, recolourable by Colours of India JS -->
    <rect id="mtw-wall-surface" x="1100" y="160" width="460" height="220"
          fill="var(--limewash)" stroke="var(--forest)" stroke-width="1.35"/>

    <!-- PARAPET — thin double line at top suggesting wall thickness -->
    <path d="M 1100 160 L 1560 160"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.9"/>
    <path d="M 1100 170 L 1560 170"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.55"/>

    <!-- PLINTH — thin double line at base -->
    <path d="M 1100 380 L 1560 380"
          stroke="var(--forest)" stroke-width="1.35"/>
    <path d="M 1100 388 L 1560 388"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.55"/>

    <!-- DOOR OPENING — rectangular, height ~2x width -->
    <rect x="1240" y="220" width="80" height="160"
          fill="var(--background)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Door jamb depth line — second stroke suggesting recess -->
    <path d="M 1245 225 L 1245 376"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.4"/>
    <!-- Door threshold line at base -->
    <path d="M 1238 380 L 1322 380"
          stroke="var(--forest)" stroke-width="1.35" opacity="0.7"/>

    <!-- TIMBER DOOR — vertical board suggestion inside the opening -->
    <path d="M 1252 220 L 1252 380" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <path d="M 1268 220 L 1268 380" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <path d="M 1284 220 L 1284 380" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <path d="M 1300 220 L 1300 380" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <!-- Door handle (small haldi dot) -->
    <circle cx="1306" cy="304" r="1.8" fill="var(--haldi)" stroke="none"/>

    <!-- WINDOW OPENING — small rectangular, offset from door -->
    <rect x="1420" y="240" width="100" height="80"
          fill="var(--background)" stroke="var(--forest)" stroke-width="1.35"/>
    <!-- Window mullion cross -->
    <path d="M 1470 240 L 1470 320" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <path d="M 1420 280 L 1520 280" stroke="var(--forest)" stroke-width="0.85" opacity="0.5"/>
    <!-- Window sill line -->
    <path d="M 1418 322 L 1522 322" stroke="var(--forest)" stroke-width="0.85" opacity="0.55"/>

    <!-- JAALI / VENTILATION DETAIL — 3 small square openings high on the wall -->
    <rect x="1130" y="190" width="10" height="10"
          fill="var(--background)" stroke="var(--forest)" stroke-width="0.85"/>
    <rect x="1148" y="190" width="10" height="10"
          fill="var(--background)" stroke="var(--forest)" stroke-width="0.85"/>
    <rect x="1166" y="190" width="10" height="10"
          fill="var(--background)" stroke="var(--forest)" stroke-width="0.85"/>

    <!-- SUBTLE LIMEWASH PLASTER LINES on the wall (short, scattered) -->
    <path d="M 1110 220 L 1180 220" stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>
    <path d="M 1110 280 L 1140 280" stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>
    <path d="M 1110 340 L 1180 340" stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>
    <path d="M 1340 200 L 1400 200" stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>
    <path d="M 1340 340 L 1400 340" stroke="var(--forest)" stroke-width="0.5" opacity="0.18"/>

    <!-- SMALL SHRUB at the base of the wall — restrained botanical accent -->
    <path d="M 1085 380 C 1080 372, 1080 364, 1086 360"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.6"/>
    <path d="M 1090 380 C 1088 370, 1088 362, 1092 358"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.55"/>
    <path d="M 1095 380 C 1096 370, 1096 362, 1094 358"
          stroke="var(--forest)" stroke-width="0.85" opacity="0.55"/>

  </g>

  <!-- ============================================================
       STAGE LABELS — large numerals in Newsreader serif + small
       Manrope captions. Numerals sit ABOVE the diagram; captions BELOW.
       ============================================================ -->
  <g font-family="var(--font-display)" font-weight="700"
     text-anchor="middle" fill="var(--forest)" letter-spacing="2">
    <text x="265" y="100" font-size="56">01</text>
    <text x="800" y="100" font-size="56">02</text>
    <text x="1330" y="100" font-size="56">03</text>
  </g>

  <g font-family="var(--font-sans)" font-weight="600"
     text-anchor="middle" fill="var(--soft-ink)" letter-spacing="3"
     font-size="11">
    <text x="265" y="448">NATURAL MATERIAL</text>
    <text x="800" y="448">PRAKRITIK PAINT</text>
    <text x="1330" y="448">FINISHED WALL</text>
  </g>

  <!-- Subtle vertical divider ticks between stages (architectural register marks) -->
  <g stroke="var(--forest)" stroke-width="0.85" opacity="0.25">
    <path d="M 533 340 L 533 420"/>
    <path d="M 1067 340 L 1067 420"/>
  </g>

</svg>
