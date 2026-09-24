<?php
/**
 * Illustration: Indian Zebu Cow Study
 * V3 core illustration system.
 *
 * THE signature illustration — large editorial study quality,
 * not a mascot. Side-elevation of a medium Indian/zebu cow,
 * facing LEFT. Pure line art (no haldi accent on the cow).
 *
 * Visual traits:
 *   - Medium Indian/zebu build (not too large, not too small)
 *   - Realistic shoulder hump rising above the back line
 *     (proportionally correct, not exaggerated)
 *   - Long dewlap (loose skin fold under the neck/chin,
 *     drawn with 2-3 subtle fold lines)
 *   - Long relaxed ears (hanging, leaf-shaped, not perky)
 *   - Proportionate curved horns (moderate length, gentle curve)
 *   - Narrow elongated face (long and slender, not a rounded blob)
 *   - Realistic muzzle (broad, soft, with nostril dot + mouth line)
 *   - Believable chest (depth and volume via forward chest bulge)
 *   - Slender legs with knee joint suggestions
 *   - Visible hooves (small dark cloven marks)
 *   - Naturally hanging tail (long, near the ground, with tuft)
 *   - Quiet standing posture (calm, still, dignified)
 *
 * Technical approach:
 *   - SEPARATE path elements for body barrel, hump, neck, head,
 *     horns L+R, ears L+R, dewlap (main + fold lines), 4 legs
 *     (each a pair of parallel strokes), tail, tuft.
 *   - NO single big closed contour — separate paths prevent the
 *     blobby feel.
 *   - Eye: small filled circle (r=2), calm half-lidded.
 *   - Muzzle: nostril dot + mouth curve.
 *   - Hooves: small horizontal cloven marks.
 *   - Ground: very subtle horizontal line (0.12 opacity).
 *   - Haldi accent: NONE. Pure line art.
 *
 * Stroke language: 1.35px main organic, 0.85px detail. Round cap/join.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 1000 600" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Indian zebu cow study — side elevation, facing left</title>

  <!-- Subtle ground line — very faint, for grounding the figure -->
  <line x1="40" y1="525" x2="960" y2="525"
        stroke="var(--forest)" stroke-width="1.35"
        stroke-linecap="round" opacity="0.12"/>

  <g fill="none" stroke="var(--forest)"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- ============================================================
         FAR HORN (RIGHT horn, behind head) — drawn first, lighter.
         Attaches at the poll and curves up-and-back (rightward),
         foreshortened from this side view.
         ============================================================ -->
    <path d="M 222 290
             C 240 272, 268 252, 295 240
             C 300 237, 303 240, 300 245"
          stroke-width="1.35" opacity="0.65"/>

    <!-- ============================================================
         FAR EAR (RIGHT ear, behind head) — drawn first, lighter.
         Hangs down-back from behind the head.
         ============================================================ -->
    <path d="M 235 308
             C 226 326, 218 348, 215 372
             C 213 386, 220 392, 230 388
             C 245 380, 256 360, 262 336
             C 264 322, 262 312, 254 308
             C 246 305, 240 305, 235 308 Z"
          stroke-width="1.35" opacity="0.6"/>

    <!-- ============================================================
         BODY BARREL — closed contour.
         Withers (top-front) → back → rump → hindquarters curve
         → belly → brisket → chest front (FORWARD BULGE for depth)
         → back to withers.
         The chest front curves forward (lower x) suggesting a
         believable chest depth, not a flat front.
         ============================================================ -->
    <path d="M 320 260
             C 400 263, 580 268, 790 280
             C 815 285, 835 305, 832 360
             C 830 400, 820 418, 800 422
             C 600 430, 400 430, 320 425
             C 295 420, 278 400, 278 365
             C 277 330, 282 300, 295 280
             C 305 268, 312 262, 320 260 Z"
          stroke-width="1.35"/>

    <!-- ============================================================
         HUMP — separate open curve rising above the back line.
         Zebu signature. From withers (320, 260) up to peak
         (380, 215) and back down to mid-back (440, 263).
         45px rise above the back line — clearly visible,
         proportionally correct (not exaggerated).
         ============================================================ -->
    <path d="M 320 260
             C 335 232, 358 208, 380 215
             C 400 222, 422 240, 440 263"
          stroke-width="1.35"/>

    <!-- ============================================================
         NECK TOP — from withers forward-down to the poll.
         Single curve connecting body to head.
         ============================================================ -->
    <path d="M 320 260
             C 290 268, 255 280, 222 290"
          stroke-width="1.35"/>

    <!-- ============================================================
         HEAD / FACE — closed contour, elongated narrow.
         Poll → forehead → long bridge of nose → broad soft muzzle
         → under-jaw → cheek → back to poll.
         The bridge is long and slender; the muzzle widens and
         rounds for the broad soft trait.
         ============================================================ -->
    <path d="M 222 290
             C 212 296, 200 308, 188 322
             C 168 348, 138 368, 100 380
             C 78 386, 56 388, 42 392
             C 32 395, 30 402, 38 406
             C 50 410, 70 410, 92 406
             C 118 402, 148 396, 175 386
             C 198 376, 215 358, 224 336
             C 230 320, 232 302, 222 290 Z"
          stroke-width="1.35"/>

    <!-- ============================================================
         NEAR HORN (LEFT horn, in profile) — drawn over head.
         From poll curving up-forward (toward upper-left, since
         cow faces left). Moderate length, gentle curve, with
         small back-curve at the tip.
         ============================================================ -->
    <path d="M 222 290
             C 200 268, 170 244, 138 232
             C 128 230, 125 235, 132 240
             C 138 244, 144 246, 148 248"
          stroke-width="1.35"/>

    <!-- ============================================================
         NEAR EAR (LEFT ear, in profile) — long, relaxed, leaf-shaped.
         Hangs DOWN and slightly forward (toward face direction).
         Drawn as a closed leaf shape — narrow at attachment,
         widening to a rounded tip.
         ============================================================ -->
    <path d="M 198 304
             C 188 322, 174 348, 162 372
             C 156 386, 162 396, 175 394
             C 192 390, 210 374, 222 352
             C 232 332, 236 314, 230 306
             C 222 300, 208 300, 198 304 Z"
          stroke-width="1.35"/>

    <!-- ============================================================
         EYE — small filled circle, calm half-lidded.
         r=2 at this scale. Positioned on the upper face, below
         the bridge of nose and toward the forehead.
         ============================================================ -->
    <circle cx="138" cy="338" r="2" fill="var(--forest)" stroke="none"/>

    <!-- BROW — subtle curve above the eye -->
    <path d="M 128 330 C 133 326, 144 326, 152 330"
          stroke-width="0.85" opacity="0.55"/>

    <!-- ============================================================
         NOSTRIL — small filled dot on the broad muzzle.
         ============================================================ -->
    <circle cx="58" cy="392" r="1.6" fill="var(--forest)" stroke="none"/>

    <!-- MOUTH — subtle curve at the muzzle -->
    <path d="M 40 402 Q 55 408, 72 404"
          stroke-width="0.85" opacity="0.7"/>

    <!-- ============================================================
         DEWLAP — long loose skin fold from under-jaw to brisket.
         Main line is the lower edge of the fold; 2 interior fold
         lines suggest skin creases.
         ============================================================ -->
    <!-- Main dewlap line (lower edge) -->
    <path d="M 100 408
             C 150 432, 200 458, 250 452
             C 280 446, 300 436, 318 428"
          stroke-width="1.35"/>
    <!-- Fold line 1 (subtle, above main line) -->
    <path d="M 115 408
             C 160 426, 200 446, 232 444"
          stroke-width="0.85" opacity="0.55"/>
    <!-- Fold line 2 (subtle, above fold 1) -->
    <path d="M 130 408
             C 170 422, 200 438, 220 438"
          stroke-width="0.85" opacity="0.4"/>

    <!-- ============================================================
         FRONT LEGS — slender paired strokes, near + far.
         Near front leg (foreground): paired strokes ~8px apart.
         Far front leg (slightly behind, lighter): paired strokes.
         Each leg has a small horizontal knee tick partway down.
         ============================================================ -->
    <!-- Near front leg — paired parallel strokes -->
    <path d="M 308 425 L 308 522" stroke-width="1.35"/>
    <path d="M 316 425 L 316 522" stroke-width="1.35"/>
    <!-- Knee suggestion (small horizontal tick) -->
    <path d="M 305 462 L 319 462" stroke-width="0.85" opacity="0.55"/>
    <!-- Slight thigh bulge above the knee (subtle) -->
    <path d="M 305 440 C 304 450, 304 455, 306 460"
          stroke-width="0.85" opacity="0.4"/>
    <path d="M 319 440 C 320 450, 320 455, 318 460"
          stroke-width="0.85" opacity="0.4"/>

    <!-- Far front leg (slightly behind, lighter) — paired strokes -->
    <path d="M 332 425 L 332 522" stroke-width="1.35" opacity="0.65"/>
    <path d="M 340 425 L 340 522" stroke-width="1.35" opacity="0.65"/>
    <!-- Knee suggestion -->
    <path d="M 329 462 L 343 462" stroke-width="0.85" opacity="0.45"/>

    <!-- ============================================================
         BACK LEGS — slender paired strokes, near + far.
         Near back leg (foreground) and far back leg (behind).
         ============================================================ -->
    <!-- Near back leg — paired parallel strokes -->
    <path d="M 748 422 L 748 522" stroke-width="1.35"/>
    <path d="M 756 422 L 756 522" stroke-width="1.35"/>
    <!-- Hock suggestion -->
    <path d="M 745 462 L 759 462" stroke-width="0.85" opacity="0.55"/>
    <!-- Slight gaskin bulge above the hock (subtle) -->
    <path d="M 745 440 C 744 450, 744 455, 746 460"
          stroke-width="0.85" opacity="0.4"/>
    <path d="M 759 440 C 760 450, 760 455, 758 460"
          stroke-width="0.85" opacity="0.4"/>

    <!-- Far back leg (slightly behind, lighter) — paired strokes -->
    <path d="M 772 422 L 772 522" stroke-width="1.35" opacity="0.65"/>
    <path d="M 780 422 L 780 522" stroke-width="1.35" opacity="0.65"/>
    <!-- Hock suggestion -->
    <path d="M 769 462 L 783 462" stroke-width="0.85" opacity="0.45"/>

    <!-- ============================================================
         HOOF TICKS — small horizontal cloven marks at the base of
         each leg pair. Two short marks per hoof (suggesting the
         cloven split).
         ============================================================ -->
    <!-- Near front hoof -->
    <path d="M 306 524 L 312 524" stroke-width="1.35"/>
    <path d="M 312 524 L 318 524" stroke-width="1.35" opacity="0.55"/>
    <!-- Far front hoof -->
    <path d="M 330 524 L 336 524" stroke-width="1.35" opacity="0.65"/>
    <path d="M 336 524 L 342 524" stroke-width="1.35" opacity="0.4"/>
    <!-- Near back hoof -->
    <path d="M 746 524 L 752 524" stroke-width="1.35"/>
    <path d="M 752 524 L 758 524" stroke-width="1.35" opacity="0.55"/>
    <!-- Far back hoof -->
    <path d="M 770 524 L 776 524" stroke-width="1.35" opacity="0.65"/>
    <path d="M 776 524 L 782 524" stroke-width="1.35" opacity="0.4"/>

    <!-- ============================================================
         TAIL — long, naturally hanging, reaches near the ground.
         From rump (820, 295) curving down-back to (855, 510).
         ============================================================ -->
    <path d="M 820 295
             C 832 320, 845 380, 852 440
             C 855 470, 855 495, 852 515"
          stroke-width="1.35"/>

    <!-- TAIL TUFT — three short strokes at the end -->
    <path d="M 852 515 C 845 522, 840 525, 842 528" stroke-width="0.85"/>
    <path d="M 852 515 C 852 522, 852 528, 854 530" stroke-width="0.85"/>
    <path d="M 852 515 C 860 522, 865 525, 863 528" stroke-width="0.85"/>

    <!-- ============================================================
         INTERIOR ANATOMY SUGGESTIONS — very subtle, low opacity.
         These give the cow depth and volume without going 3D.
         ============================================================ -->
    <!-- Shoulder blade line (scapula under the hump) -->
    <path d="M 360 275 C 366 320, 366 380, 360 420"
          stroke-width="0.85" opacity="0.3"/>
    <!-- Belly midline (subtle barrel lower contour) -->
    <path d="M 322 425 C 480 430, 640 430, 798 422"
          stroke-width="0.85" opacity="0.25"/>
    <!-- Flank fold where back leg meets belly -->
    <path d="M 738 410 C 745 415, 750 420, 748 422"
          stroke-width="0.85" opacity="0.4"/>
    <!-- Hip line (subtle, suggesting the hip bone under the rump) -->
    <path d="M 770 290 C 778 320, 778 360, 770 400"
          stroke-width="0.85" opacity="0.3"/>
    <!-- Rib suggestion marks (3 subtle vertical curves along the body) -->
    <path d="M 500 280 C 498 320, 498 380, 500 420"
          stroke-width="0.5" opacity="0.25"/>
    <path d="M 580 282 C 578 320, 578 380, 580 420"
          stroke-width="0.5" opacity="0.25"/>
    <path d="M 660 284 C 658 320, 658 380, 660 420"
          stroke-width="0.5" opacity="0.25"/>
    <!-- Neck muscle suggestion (subtle curve from poll to withers) -->
    <path d="M 230 295 C 260 270, 290 268, 318 262"
          stroke-width="0.5" opacity="0.3"/>

  </g>
</svg>
