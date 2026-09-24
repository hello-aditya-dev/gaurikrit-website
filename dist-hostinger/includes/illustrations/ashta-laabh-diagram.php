<?php
/**
 * Illustration: Ashta-Laabh radial diagram (8 benefits around a central cow mark)
 * Coded SVG — no photography dependency.
 * V2 finish pass — disciplined radial seal with 8 benefit nodes.
 *
 * Central medallion with a small cow-mark. 8 nodes arranged in a
 * circle around the centre (8 nodes at 45° intervals via trig).
 * Each node is a small circle (with the number 01-08 inside) and the
 * benefit label beside it. Thin dashed connector lines from centre to
 * each node (0.3 opacity). The active/hovered node (set via JS on the
 * sibling list items carrying data-ashta-node) lights up with a haldi
 * fill and a thicker line, and the matching connector turns solid
 * haldi. The diagram itself is purely decorative (aria-hidden) —
 * keyboard/touch interaction lives on the visible list beside it.
 *
 * The CSS uses the modern :has() selector so the SVG responds to the
 * list item's [data-active] state without needing data-ashta-node on
 * the SVG nodes themselves (preserving aria-hidden semantics).
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 360 360" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Eight benefits radial diagram</title>

  <defs>
    <style>
      /* Base node styles — calm default state */
      .al-node__dot {
        fill: var(--paper);
        stroke: var(--forest);
        stroke-width: 1.5;
        transition: fill 0.3s ease, stroke-width 0.3s ease, stroke 0.3s ease;
      }
      .al-node__num {
        fill: var(--forest);
        font-family: var(--font-display);
        font-size: 9px;
        font-weight: 700;
        text-anchor: middle;
        dominant-baseline: central;
        transition: fill 0.3s ease;
        letter-spacing: 0.4px;
      }
      .al-node__lbl {
        fill: var(--soft-ink);
        font-family: var(--font-sans);
        font-size: 6.5px;
        font-weight: 600;
        letter-spacing: 0.6px;
        opacity: 0.85;
        transition: fill 0.3s ease, opacity 0.3s ease;
        text-transform: uppercase;
      }
      .al-node__connector {
        stroke: var(--forest);
        stroke-width: 0.8;
        opacity: 0.3;
        stroke-dasharray: 2 3;
        transition: stroke 0.3s ease, opacity 0.3s ease,
                    stroke-width 0.3s ease, stroke-dasharray 0.3s ease;
      }

      /* Active state — when the sibling list item with matching
         data-ashta-node is [data-active="true"], light up the matching
         SVG node. Uses :has() (modern browsers — Chrome 105+, Safari
         15.4+, Firefox 121+). On older browsers the SVG renders in its
         calm default state, which is still perfectly legible. */
      [data-ashta-laabh]:has([data-ashta-node="al-1"][data-active="true"]) .al-node-1 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-2"][data-active="true"]) .al-node-2 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-3"][data-active="true"]) .al-node-3 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-4"][data-active="true"]) .al-node-4 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-5"][data-active="true"]) .al-node-5 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-6"][data-active="true"]) .al-node-6 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-7"][data-active="true"]) .al-node-7 .al-node__dot,
      [data-ashta-laabh]:has([data-ashta-node="al-8"][data-active="true"]) .al-node-8 .al-node__dot {
        fill: var(--haldi);
        stroke: var(--haldi-deep);
        stroke-width: 1.8;
      }

      [data-ashta-laabh]:has([data-ashta-node="al-1"][data-active="true"]) .al-node-1 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-2"][data-active="true"]) .al-node-2 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-3"][data-active="true"]) .al-node-3 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-4"][data-active="true"]) .al-node-4 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-5"][data-active="true"]) .al-node-5 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-6"][data-active="true"]) .al-node-6 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-7"][data-active="true"]) .al-node-7 .al-node__connector,
      [data-ashta-laabh]:has([data-ashta-node="al-8"][data-active="true"]) .al-node-8 .al-node__connector {
        stroke: var(--haldi-deep);
        stroke-width: 1.2;
        opacity: 1;
        stroke-dasharray: none;
      }

      [data-ashta-laabh]:has([data-ashta-node="al-1"][data-active="true"]) .al-node-1 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-2"][data-active="true"]) .al-node-2 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-3"][data-active="true"]) .al-node-3 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-4"][data-active="true"]) .al-node-4 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-5"][data-active="true"]) .al-node-5 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-6"][data-active="true"]) .al-node-6 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-7"][data-active="true"]) .al-node-7 .al-node__lbl,
      [data-ashta-laabh]:has([data-ashta-node="al-8"][data-active="true"]) .al-node-8 .al-node__lbl {
        fill: var(--forest);
        opacity: 1;
      }
    </style>
  </defs>

  <!-- OUTER SUBTLE RING — connects all node positions visually -->
  <circle cx="180" cy="180" r="110"
          fill="none" stroke="var(--forest)"
          stroke-width="0.8" opacity="0.25"/>

  <!-- CENTRAL MEDALLION with cow-mark -->
  <circle cx="180" cy="180" r="38"
          fill="var(--haldi)" stroke="var(--forest)"
          stroke-width="1.5"/>
  <!-- Inner accent ring — subtle -->
  <circle cx="180" cy="180" r="33"
          fill="none" stroke="var(--forest)"
          stroke-width="0.7" opacity="0.4"/>

  <!-- Central cow head — front-facing, simplified cow-mark silhouette -->
  <g fill="none" stroke="var(--forest)" stroke-width="1.3"
     stroke-linecap="round" stroke-linejoin="round">
    <!-- Left horn -->
    <path d="M 168 172 C 162 164, 158 160, 156 162"/>
    <!-- Right horn -->
    <path d="M 192 172 C 198 164, 202 160, 204 162"/>
    <!-- Head outline (front-facing, prominent forehead, elongated face) -->
    <path d="M 180 168
             C 172 168, 168 172, 168 178
             C 168 186, 170 194, 174 198
             C 176 200, 184 200, 186 198
             C 190 194, 192 186, 192 178
             C 192 172, 188 168, 180 168 Z"/>
    <!-- Muzzle line -->
    <path d="M 174 194 Q 180 196, 186 194"
          stroke-width="1.1" opacity="0.7"/>
  </g>
  <!-- Eyes -->
  <circle cx="175" cy="180" r="1.4" fill="var(--forest)"/>
  <circle cx="185" cy="180" r="1.4" fill="var(--forest)"/>
  <!-- Nostrils -->
  <circle cx="177" cy="192" r="0.9" fill="var(--forest)"/>
  <circle cx="183" cy="192" r="0.9" fill="var(--forest)"/>

  <!-- ===== 8 NODES — positioned at 45° intervals around (180,180), r=110 ===== -->

  <!-- Node 1: Antibacterial (top, -90°) -->
  <g class="al-node al-node-1">
    <line class="al-node__connector" x1="180" y1="142" x2="180" y2="82"/>
    <circle class="al-node__dot" cx="180" cy="70" r="12"/>
    <text class="al-node__num" x="180" y="70">01</text>
    <text class="al-node__lbl" x="180" y="48" text-anchor="middle">Antibacterial</text>
  </g>

  <!-- Node 2: Antifungal (top-right, -45°) -->
  <g class="al-node al-node-2">
    <line class="al-node__connector" x1="207" y1="153" x2="250" y2="110"/>
    <circle class="al-node__dot" cx="258" cy="102" r="12"/>
    <text class="al-node__num" x="258" y="102">02</text>
    <text class="al-node__lbl" x="273" y="86" text-anchor="start">Antifungal</text>
  </g>

  <!-- Node 3: Eco-Friendly (right, 0°) -->
  <g class="al-node al-node-3">
    <line class="al-node__connector" x1="218" y1="180" x2="278" y2="180"/>
    <circle class="al-node__dot" cx="290" cy="180" r="12"/>
    <text class="al-node__num" x="290" y="180">03</text>
    <text class="al-node__lbl" x="306" y="184" text-anchor="start">Eco-Friendly</text>
  </g>

  <!-- Node 4: Thermal Insulator (bottom-right, 45°) -->
  <g class="al-node al-node-4">
    <line class="al-node__connector" x1="207" y1="207" x2="250" y2="250"/>
    <circle class="al-node__dot" cx="258" cy="258" r="12"/>
    <text class="al-node__num" x="258" y="258">04</text>
    <text class="al-node__lbl" x="273" y="278" text-anchor="start">Thermal Ins.</text>
  </g>

  <!-- Node 5: Cost-Effective (bottom, 90°) -->
  <g class="al-node al-node-5">
    <line class="al-node__connector" x1="180" y1="218" x2="180" y2="278"/>
    <circle class="al-node__dot" cx="180" cy="290" r="12"/>
    <text class="al-node__num" x="180" y="290">05</text>
    <text class="al-node__lbl" x="180" y="312" text-anchor="middle">Cost-Effective</text>
  </g>

  <!-- Node 6: Metal-Free (bottom-left, 135°) -->
  <g class="al-node al-node-6">
    <line class="al-node__connector" x1="153" y1="207" x2="110" y2="250"/>
    <circle class="al-node__dot" cx="102" cy="258" r="12"/>
    <text class="al-node__num" x="102" y="258">06</text>
    <text class="al-node__lbl" x="87" y="278" text-anchor="end">Metal-Free</text>
  </g>

  <!-- Node 7: Non-Toxic (left, 180°) -->
  <g class="al-node al-node-7">
    <line class="al-node__connector" x1="142" y1="180" x2="82" y2="180"/>
    <circle class="al-node__dot" cx="70" cy="180" r="12"/>
    <text class="al-node__num" x="70" y="180">07</text>
    <text class="al-node__lbl" x="54" y="184" text-anchor="end">Non-Toxic</text>
  </g>

  <!-- Node 8: Odourless (top-left, 225°) -->
  <g class="al-node al-node-8">
    <line class="al-node__connector" x1="153" y1="153" x2="110" y2="110"/>
    <circle class="al-node__dot" cx="102" cy="102" r="12"/>
    <text class="al-node__num" x="102" y="102">08</text>
    <text class="al-node__lbl" x="87" y="86" text-anchor="end">Odourless</text>
  </g>

</svg>
