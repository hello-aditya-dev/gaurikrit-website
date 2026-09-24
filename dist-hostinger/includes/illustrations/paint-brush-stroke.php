<?php
/**
 * Illustration: Paint brush stroke (large irregular haldi paint patch)
 * Coded SVG — no photography dependency.
 * V2 finish pass — feels like a painted surface, not a decorative blob.
 *
 * Organic, slightly irregular shape (like a brush stroke or limewash
 * patch). Edge has subtle wobble (not a perfect geometric shape).
 * Haldi gradient fill (haldi-soft → haldi → haldi-deep). Very subtle
 * internal tonal variation (1-2 lighter patches, 0.15 opacity). Subtle
 * paper-grain texture overlay (tiny dots, 0.03 opacity). Path with
 * many control points for the organic edge.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 640 420" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Paint brush stroke</title>

  <defs>
    <!-- HALDI GRADIENT — soft → mid → deep, diagonal -->
    <linearGradient id="pbs-grad" x1="0.2" y1="0.1" x2="0.8" y2="0.9">
      <stop offset="0%" stop-color="var(--haldi-soft)"/>
      <stop offset="40%" stop-color="var(--haldi)"/>
      <stop offset="100%" stop-color="var(--haldi-deep)"/>
    </linearGradient>

    <!-- PAPER-GRAIN TEXTURE PATTERN — tiny dots, very sparse.
         Applied as an additional layer at 0.05 opacity for a paper-fibre feel. -->
    <pattern id="pbs-grain" x="0" y="0" width="4" height="4"
             patternUnits="userSpaceOnUse">
      <circle cx="1" cy="1" r="0.45" fill="var(--charcoal)" opacity="0.5"/>
      <circle cx="3" cy="2.5" r="0.3" fill="var(--charcoal)" opacity="0.35"/>
    </pattern>

    <!-- CLIP PATH — the main stroke shape, used to clip the grain overlay -->
    <clipPath id="pbs-clip">
      <path d="M 50 210
               C 38 200, 28 218, 36 240
               C 44 262, 60 268, 78 258
               C 96 250, 108 274, 130 270
               C 154 266, 168 290, 192 286
               C 218 282, 232 308, 258 304
               C 286 300, 302 326, 332 322
               C 364 318, 380 344, 412 340
               C 444 336, 462 360, 496 354
               C 528 348, 548 372, 580 362
               C 600 356, 612 336, 600 314
               C 614 296, 596 282, 612 264
               C 624 244, 600 232, 588 220
               C 600 204, 580 192, 568 184
               C 552 168, 528 178, 508 172
               C 484 166, 470 184, 446 180
               C 422 174, 408 192, 384 188
               C 360 182, 344 200, 320 196
               C 294 190, 278 208, 254 204
               C 228 198, 212 218, 188 214
               C 162 208, 146 226, 122 222
               C 96 216, 80 232, 58 226
               C 44 222, 42 218, 50 210 Z"/>
    </clipPath>
  </defs>

  <!-- MAIN ORGANIC BRUSH STROKE — irregular edge with many control points.
       Haldi gradient fill. Subtle forest outline for definition. -->
  <path d="M 50 210
           C 38 200, 28 218, 36 240
           C 44 262, 60 268, 78 258
           C 96 250, 108 274, 130 270
           C 154 266, 168 290, 192 286
           C 218 282, 232 308, 258 304
           C 286 300, 302 326, 332 322
           C 364 318, 380 344, 412 340
           C 444 336, 462 360, 496 354
           C 528 348, 548 372, 580 362
           C 600 356, 612 336, 600 314
           C 614 296, 596 282, 612 264
           C 624 244, 600 232, 588 220
           C 600 204, 580 192, 568 184
           C 552 168, 528 178, 508 172
           C 484 166, 470 184, 446 180
           C 422 174, 408 192, 384 188
           C 360 182, 344 200, 320 196
           C 294 190, 278 208, 254 204
           C 228 198, 212 218, 188 214
           C 162 208, 146 226, 122 222
           C 96 216, 80 232, 58 226
           C 44 222, 42 218, 50 210 Z"
        fill="url(#pbs-grad)"
        stroke="var(--haldi-deep)"
        stroke-width="1.2"
        stroke-linejoin="round"
        opacity="0.92"/>

  <!-- INTERNAL LIGHTER PATCH 1 — small organic shape on top of the stroke.
       Suggests a thicker/limewash-ier part of the brushstroke. -->
  <path d="M 150 220
           C 180 200, 240 196, 290 210
           C 340 220, 380 210, 400 230
           C 380 250, 330 244, 280 240
           C 230 235, 180 250, 150 220 Z"
        fill="var(--haldi-soft)"
        stroke="none"
        opacity="0.3"/>

  <!-- INTERNAL LIGHTER PATCH 2 — smaller accent on lower-right -->
  <path d="M 420 270
           C 450 256, 490 260, 510 280
           C 488 294, 450 290, 420 270 Z"
        fill="var(--haldi-soft)"
        stroke="none"
        opacity="0.25"/>

  <!-- SUBTLE DARKER RIM along the lower edge — suggests where the brush
       dragged slightly thicker paint. Single line, low opacity. -->
  <path d="M 192 286
           C 218 282, 232 308, 258 304
           C 286 300, 302 326, 332 322
           C 364 318, 380 344, 412 340"
        fill="none"
        stroke="var(--haldi-deep)"
        stroke-width="1.5"
        opacity="0.4"
        stroke-linecap="round"/>

  <!-- BRISTLE TEXTURE — a few thin lighter strokes laid along the stroke direction.
       Subtle, suggests the direction the brush was dragged. -->
  <g fill="none" stroke="var(--haldi-deep)"
     stroke-width="1.3" stroke-linecap="round"
     opacity="0.28">
    <path d="M 100 200 C 240 168, 400 168, 560 232"/>
    <path d="M 90 240 C 240 210, 420 210, 560 278"/>
  </g>
  <g fill="none" stroke="var(--haldi-soft)"
     stroke-width="1.1" stroke-linecap="round"
     opacity="0.4">
    <path d="M 110 220 C 240 188, 400 188, 540 244"/>
  </g>

  <!-- PAPER-GRAIN TEXTURE OVERLAY — very subtle (3-4% perceived opacity).
       Uses the clip path so the grain only appears inside the stroke shape. -->
  <g clip-path="url(#pbs-clip)" opacity="0.06">
    <rect x="0" y="0" width="640" height="420" fill="url(#pbs-grain)"/>
  </g>

</svg>
