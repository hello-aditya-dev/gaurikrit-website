<?php
/**
 * Illustration: Indian Cow (side-view zebu)
 * Coded SVG — no photography dependency.
 * V2 finish pass — disciplined editorial line work.
 *
 * Side-view, facing LEFT. Distinct zebu features: visible hump rising
 * above the back line, dewlap fold under the neck, long hanging ears,
 * slender legs, elongated face, calm standing posture.
 *
 * Uses SEPARATE paths for head/face, horns, ears, neck+dewlap, body
 * barrel, hump, legs, tail — no single blob contour.
 */
// @var string $class Optional CSS class for the root <svg>
$class = $class ?? '';
?>
<svg viewBox="0 0 320 200" xmlns="http://www.w3.org/2000/svg"
     class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
     role="img" aria-hidden="true"
     preserveAspectRatio="xMidYMid meet"
     width="100%" height="100%">
  <title>Side-view Indian cow</title>

  <!-- Subtle ground line — very faint, for grounding the figure -->
  <line x1="22" y1="176" x2="298" y2="176"
        stroke="var(--forest)" stroke-width="1"
        stroke-linecap="round" opacity="0.15"/>

  <g fill="none" stroke="var(--forest)" stroke-width="1.5"
     stroke-linecap="round" stroke-linejoin="round">

    <!-- FAR HORN — drawn first, slightly behind head, lighter -->
    <path d="M 52 66 C 46 56, 38 50, 28 54" opacity="0.7"/>

    <!-- FAR EAR — drawn behind head, hanging down-back, lighter -->
    <path d="M 62 78 C 72 88, 80 100, 84 112
             C 80 114, 76 110, 70 102
             C 64 94, 58 86, 58 80 Z"
          opacity="0.65"/>

    <!-- BODY BARREL — closed contour: withers → back → rump → thigh → belly → chest → withers.
         Back line is intentionally flat/diagonal here; the hump sits on top as a separate path. -->
    <path d="M 88 88
             L 134 80
             C 160 82, 200 84, 240 86
             C 254 88, 262 90, 266 92
             C 274 94, 274 98, 272 102
             C 270 120, 268 138, 264 146
             L 92 146
             C 88 130, 86 110, 88 88 Z"/>

    <!-- HUMP — open curve rising above the back line, from withers to mid-back.
         This is the zebu signature — peak clearly above the back line. -->
    <path d="M 88 88
             C 92 72, 100 60, 110 58
             C 120 60, 128 70, 134 80"/>

    <!-- NECK TOP — from withers forward-down to poll -->
    <path d="M 88 88
             C 80 84, 72 80, 64 76
             L 52 70"/>

    <!-- HEAD / FACE — closed contour: poll → forehead → bridge → muzzle → under-jaw → cheek → poll.
         Elongated face (muzzle extends well forward of poll). -->
    <path d="M 52 70
             C 46 76, 40 82, 32 90
             C 26 96, 20 100, 16 104
             C 14 106, 14 109, 16 111
             C 20 113, 24 113, 28 111
             C 34 113, 42 113, 50 111
             C 54 110, 56 110, 58 110
             C 58 100, 56 90, 54 80
             C 53 76, 52 73, 52 70 Z"/>

    <!-- DEWLAP — loose skin fold from under-jaw down to chest between front legs -->
    <path d="M 50 111
             C 56 116, 64 122, 72 126
             C 78 130, 82 132, 86 132"/>

    <!-- DEWLAP FOLD LINES — subtle interior detail suggesting skin folds -->
    <path d="M 54 116 C 60 120, 66 124, 72 128"
          stroke-width="1.2" opacity="0.5"/>
    <path d="M 60 122 C 64 126, 68 128, 72 130"
          stroke-width="1.2" opacity="0.35"/>

    <!-- NEAR HORN — drawn over the head, prominent. Lyre-shaped, moderate length. -->
    <path d="M 50 70
             C 44 60, 36 54, 26 58
             C 24 60, 25 62, 28 62"/>

    <!-- NEAR EAR — long, hanging, leaf-shaped. Drawn over the head. -->
    <path d="M 58 76
             C 68 84, 76 96, 80 110
             C 76 112, 72 108, 68 102
             C 62 92, 56 84, 56 78 Z"/>

    <!-- EYE — small filled circle, calm half-lidded -->
    <circle cx="40" cy="84" r="1.6" fill="var(--forest)" stroke="none"/>

    <!-- BROW — subtle curve above the eye -->
    <path d="M 36 80 C 39 78, 43 78, 46 80"
          stroke-width="1.2" opacity="0.55"/>

    <!-- NOSTRIL — small dot -->
    <circle cx="20" cy="106" r="0.9" fill="var(--forest)" stroke="none"/>

    <!-- MOUTH — subtle line at muzzle -->
    <path d="M 15 111 Q 19 114, 23 111"
          stroke-width="1.2" opacity="0.7"/>

    <!-- FRONT LEGS — slender, paired (near + far). Each leg is two parallel strokes for slenderness. -->
    <!-- Near front leg -->
    <path d="M 92 146 L 93 170"/>
    <path d="M 96 146 L 97 170"/>
    <!-- Far front leg (slightly offset back, lighter) -->
    <path d="M 104 146 L 105 170" opacity="0.7"/>
    <path d="M 108 146 L 109 170" opacity="0.7"/>

    <!-- BACK LEGS — same treatment -->
    <!-- Near back leg -->
    <path d="M 238 146 L 239 170"/>
    <path d="M 242 146 L 243 170"/>
    <!-- Far back leg -->
    <path d="M 250 146 L 251 170" opacity="0.7"/>
    <path d="M 254 146 L 255 170" opacity="0.7"/>

    <!-- HOOF TICKS — small horizontal marks at the base of each leg -->
    <path d="M 90 171 L 99 171"/>
    <path d="M 102 171 L 111 171" opacity="0.7"/>
    <path d="M 236 171 L 245 171"/>
    <path d="M 248 171 L 257 171" opacity="0.7"/>

    <!-- TAIL — from rump curving down-back to the tuft -->
    <path d="M 270 92
             C 276 110, 280 130, 282 156"/>

    <!-- TAIL TUFT — three short strokes at the end -->
    <path d="M 282 156 C 278 162, 276 168, 278 172" stroke-width="1.2"/>
    <path d="M 282 156 C 282 164, 282 170, 283 173" stroke-width="1.2"/>
    <path d="M 282 156 C 286 162, 288 168, 286 172" stroke-width="1.2"/>

    <!-- SHOULDER BLADE — subtle interior detail suggesting the scapula under the hump -->
    <path d="M 112 96 C 116 110, 116 130, 114 144"
          stroke-width="1.2" opacity="0.35"/>

    <!-- BELLY MIDLINE — subtle curve suggesting the barrel's lower contour -->
    <path d="M 96 146 C 140 143, 200 143, 240 146"
          stroke-width="1.2" opacity="0.3"/>

    <!-- FLANK LINE — subtle curve suggesting the fold where the back leg meets the belly -->
    <path d="M 248 140 C 252 142, 254 144, 254 146"
          stroke-width="1.2" opacity="0.4"/>

  </g>

  <!-- HALDI ACCENT — inner ear canal tint, very subtle (0.15 opacity) -->
  <path d="M 62 80 C 70 88, 76 100, 78 110
           C 75 110, 72 106, 68 100
           C 64 92, 60 86, 60 80 Z"
        fill="var(--haldi)" stroke="none" opacity="0.15"/>

</svg>
