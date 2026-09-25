<?php
/**
 * Illustration: Ashta Laabh Seal
 * V3 core illustration system.
 *
 * A large radial typographic seal — NOT a tiny wheel beside UI rows.
 * Replaces the V2 ashta-laabh-diagram.php.
 *
 * Composition:
 *   - Centre: circular medallion (r=80) with a small side-view cow
 *     mark. Forest outline, subtle limewash fill.
 *   - 8 numbered radial lines extending outward at 45° intervals,
 *     each a 0.85px stroke from the medallion edge to a label
 *     position.
 *   - 8 labels at the end of each radial line: number (Newsreader
 *     serif, forest) + benefit name (Manrope, forest).
 *
 * Interactive state: SVG nodes carry `data-benefit` attributes. The
 * page JS sets `data-active="true"` on the selected SVG node. When
 * active: the radial line turns haldi, the label moves 3px outward
 * along its angle (via CSS transform), and other labels reduce
 * opacity. Pure CSS progressive enhancement via `:has()` — older
 * browsers render the seal in its calm default state.
 *
 * Stroke language: 0.85px detail lines, 1.35px medallion outline.
 * Round cap/join.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 600 600" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Ashta Laabh seal — eight benefits</title>

  <defs>
    <style>
      /* ===== Default node state ===== */
      .al-node {
        opacity: 1;
        transition: opacity 0.3s ease, transform 0.3s ease;
      }
      .al-node__line {
        stroke: var(--forest);
        stroke-width: 0.85;
        opacity: 0.45;
        stroke-linecap: round;
        transition: stroke 0.3s ease, stroke-width 0.3s ease, opacity 0.3s ease;
      }
      .al-node__num {
        fill: var(--forest);
        font-family: var(--font-display);
        font-size: 18px;
        font-weight: 700;
        text-anchor: middle;
        dominant-baseline: central;
        letter-spacing: 0.5px;
        transition: fill 0.3s ease;
      }
      .al-node__name {
        fill: var(--forest);
        font-family: var(--font-sans);
        font-size: 10px;
        font-weight: 600;
        text-anchor: middle;
        dominant-baseline: central;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        opacity: 0.85;
        transition: fill 0.3s ease, opacity 0.3s ease;
      }

      /* ===== When ANY node is active, dim the other nodes ===== */
      svg:has(.al-node[data-active="true"]) .al-node:not([data-active="true"]) {
        opacity: 0.4;
      }

      /* ===== Active node — radial line turns haldi, label pops ===== */
      .al-node[data-active="true"] .al-node__line {
        stroke: var(--haldi);
        stroke-width: 1.35;
        opacity: 1;
      }
      .al-node[data-active="true"] .al-node__num {
        fill: var(--forest-deep);
      }
      .al-node[data-active="true"] .al-node__name {
        fill: var(--forest);
        opacity: 1;
      }

      /* ===== Active label moves 3px outward along its angle ===== */
      .al-node-1[data-active="true"] { transform: translate(0px, -3px); }
      .al-node-2[data-active="true"] { transform: translate(2.12px, -2.12px); }
      .al-node-3[data-active="true"] { transform: translate(3px, 0px); }
      .al-node-4[data-active="true"] { transform: translate(2.12px, 2.12px); }
      .al-node-5[data-active="true"] { transform: translate(0px, 3px); }
      .al-node-6[data-active="true"] { transform: translate(-2.12px, 2.12px); }
      .al-node-7[data-active="true"] { transform: translate(-3px, 0px); }
      .al-node-8[data-active="true"] { transform: translate(-2.12px, -2.12px); }
    </style>
  </defs>

  <!-- ============================================================
       OUTER SUBTLE RING — connects all label positions visually
       ============================================================ -->
  <circle cx="300" cy="300" r="215"
          fill="none" stroke="var(--forest)"
          stroke-width="0.85" opacity="0.18" stroke-dasharray="2 4"/>

  <!-- ============================================================
       CENTRAL MEDALLION — circular, with a small cow-mark inside
       ============================================================ -->
  <circle cx="300" cy="300" r="80"
          fill="var(--limewash)" stroke="var(--forest)" stroke-width="1.35"/>
  <!-- Inner accent ring -->
  <circle cx="300" cy="300" r="73"
          fill="none" stroke="var(--forest)"
          stroke-width="0.85" opacity="0.4"/>

  <!-- Central cow-mark — small side-view silhouette, facing LEFT
       (consistent with the brand signature cow). Drawn with the same
       separate-paths discipline: body barrel, hump, neck top, head,
       horn, ear, eye, 4 legs, tail. -->
  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- FAR HORN — behind head, lighter -->
    <path d="M 252 286 C 248 280, 244 278, 240 280" stroke-width="0.85" opacity="0.65"/>
    <!-- FAR EAR — small leaf behind head, lighter -->
    <path d="M 256 294 C 252 304, 248 312, 244 316" stroke-width="0.85" opacity="0.65"/>
    <!-- BODY BARREL — closed contour -->
    <path d="M 268 288
             C 260 286, 252 285, 246 287
             C 240 289, 236 292, 234 296
             L 234 318
             L 322 320
             C 326 314, 326 304, 324 296
             C 320 290, 314 288, 308 288
             C 296 286, 282 286, 268 288 Z"
          stroke-width="1.35"/>
    <!-- HUMP — open curve rising above the back line -->
    <path d="M 266 288
             C 262 278, 256 272, 252 270
             C 248 268, 246 270, 246 274
             C 248 280, 252 285, 256 288"
          stroke-width="1.35"/>
    <!-- NECK TOP — from withers forward-down to poll -->
    <path d="M 268 288 C 262 287, 256 286, 252 284" stroke-width="1.35"/>
    <!-- HEAD — small wedge extending left to muzzle -->
    <path d="M 252 284
             C 248 286, 244 290, 240 294
             C 236 298, 232 302, 230 304
             C 230 306, 232 308, 236 308
             C 240 310, 244 312, 248 312
             C 252 312, 252 312, 252 310
             C 252 302, 252 294, 252 284 Z"
          stroke-width="1.35"/>
    <!-- NEAR HORN — over head, prominent -->
    <path d="M 252 284 C 248 278, 244 274, 240 276" stroke-width="1.35"/>
    <!-- NEAR EAR — small leaf hanging down -->
    <path d="M 258 292 C 254 302, 250 310, 246 314
             C 250 310, 254 302, 258 296 Z" stroke-width="1.35"/>
    <!-- EYE — small filled circle -->
    <circle cx="240" cy="294" r="1.4" fill="var(--forest)" stroke="none"/>
    <!-- NOSTRIL — small dot -->
    <circle cx="232" cy="302" r="1" fill="var(--forest)" stroke="none"/>
    <!-- FRONT LEGS (left side, paired slender strokes) -->
    <path d="M 244 320 L 244 338" stroke-width="1.35"/>
    <path d="M 248 320 L 248 338" stroke-width="1.35"/>
    <path d="M 254 320 L 254 338" stroke-width="1.35" opacity="0.65"/>
    <path d="M 258 320 L 258 338" stroke-width="1.35" opacity="0.65"/>
    <!-- BACK LEGS (right side, paired slender strokes) -->
    <path d="M 308 320 L 308 338" stroke-width="1.35"/>
    <path d="M 312 320 L 312 338" stroke-width="1.35"/>
    <path d="M 318 320 L 318 338" stroke-width="1.35" opacity="0.65"/>
    <path d="M 322 320 L 322 338" stroke-width="1.35" opacity="0.65"/>
    <!-- HOOF TICKS -->
    <path d="M 243 339 L 259 339" stroke-width="0.85"/>
    <path d="M 307 339 L 323 339" stroke-width="0.85"/>
    <!-- TAIL — from rump curving down with small tuft -->
    <path d="M 322 292 C 328 300, 332 314, 332 326
             C 332 332, 330 336, 328 338" stroke-width="1.35"/>
    <path d="M 328 338 C 326 342, 324 344, 326 346" stroke-width="0.85"/>
    <path d="M 328 338 C 328 342, 328 344, 330 346" stroke-width="0.85"/>
  </g>

  <!-- Small haldi dot accent in the medallion corner (the brand mark) -->
  <circle cx="300" cy="248" r="2.5" fill="var(--haldi)" stroke="none"/>

  <!-- ============================================================
       8 RADIAL NODES — at 45° intervals around centre (300, 300)
       Line: r=80 (medallion edge) → r=215 (label position)
       Labels: number (top) + name (bottom), centred at r=240
       ============================================================ -->

  <!-- ===== NODE 1: Antibacterial (top, angle -90°) =====
       Line: (300, 220) → (300, 85), Label centre: (300, 60) -->
  <g class="al-node al-node-1" data-benefit="antibacterial">
    <line class="al-node__line" x1="300" y1="220" x2="300" y2="85"/>
    <text class="al-node__num" x="300" y="50">01</text>
    <text class="al-node__name" x="300" y="70">Antibacterial</text>
  </g>

  <!-- ===== NODE 2: Antifungal (top-right, angle -45°) =====
       Line: (357, 243) → (452, 148), Label centre: (470, 130) -->
  <g class="al-node al-node-2" data-benefit="antifungal">
    <line class="al-node__line" x1="357" y1="243" x2="452" y2="148"/>
    <text class="al-node__num" x="470" y="120">02</text>
    <text class="al-node__name" x="470" y="140">Antifungal</text>
  </g>

  <!-- ===== NODE 3: Eco-Friendly (right, angle 0°) =====
       Line: (380, 300) → (515, 300), Label centre: (540, 300) -->
  <g class="al-node al-node-3" data-benefit="eco-friendly">
    <line class="al-node__line" x1="380" y1="300" x2="515" y2="300"/>
    <text class="al-node__num" x="540" y="290">03</text>
    <text class="al-node__name" x="540" y="310">Eco-Friendly</text>
  </g>

  <!-- ===== NODE 4: Natural Thermal Insulator (bottom-right, angle 45°) =====
       Line: (357, 357) → (452, 452), Label centre: (470, 470)
       Long name split across two lines. -->
  <g class="al-node al-node-4" data-benefit="thermal-insulator">
    <line class="al-node__line" x1="357" y1="357" x2="452" y2="452"/>
    <text class="al-node__num" x="470" y="460">04</text>
    <text class="al-node__name" x="470" y="478">Natural Thermal</text>
    <text class="al-node__name" x="470" y="492">Insulator</text>
  </g>

  <!-- ===== NODE 5: Cost-Effective (bottom, angle 90°) =====
       Line: (300, 380) → (300, 515), Label centre: (300, 540) -->
  <g class="al-node al-node-5" data-benefit="cost-effective">
    <line class="al-node__line" x1="300" y1="380" x2="300" y2="515"/>
    <text class="al-node__num" x="300" y="530">05</text>
    <text class="al-node__name" x="300" y="550">Cost-Effective</text>
  </g>

  <!-- ===== NODE 6: Free from Heavy Metals (bottom-left, angle 135°) =====
       Line: (243, 357) → (148, 452), Label centre: (130, 470)
       Long name split across two lines. -->
  <g class="al-node al-node-6" data-benefit="heavy-metal-free">
    <line class="al-node__line" x1="243" y1="357" x2="148" y2="452"/>
    <text class="al-node__num" x="130" y="460">06</text>
    <text class="al-node__name" x="130" y="478">Free from Heavy</text>
    <text class="al-node__name" x="130" y="492">Metals</text>
  </g>

  <!-- ===== NODE 7: Non-Toxic (left, angle 180°) =====
       Line: (220, 300) → (85, 300), Label centre: (60, 300) -->
  <g class="al-node al-node-7" data-benefit="non-toxic">
    <line class="al-node__line" x1="220" y1="300" x2="85" y2="300"/>
    <text class="al-node__num" x="60" y="290">07</text>
    <text class="al-node__name" x="60" y="310">Non-Toxic</text>
  </g>

  <!-- ===== NODE 8: Odourless (top-left, angle 225°) =====
       Line: (243, 243) → (148, 148), Label centre: (130, 130) -->
  <g class="al-node al-node-8" data-benefit="odourless">
    <line class="al-node__line" x1="243" y1="243" x2="148" y2="148"/>
    <text class="al-node__num" x="130" y="120">08</text>
    <text class="al-node__name" x="130" y="140">Odourless</text>
  </g>

</svg>
