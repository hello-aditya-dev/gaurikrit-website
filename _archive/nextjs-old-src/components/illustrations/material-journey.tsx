"use client";

import * as React from "react";

export interface MaterialJourneyProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Material flow: cow (source) → drying/refining → bucket (product) → wall (application).
 * 4 stages connected by dashed line, each a small line icon.
 * Forest stroke, haldi connector. Horizontal layout.
 */
export function MaterialJourney({
  className,
  ariaHidden = true,
}: MaterialJourneyProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 600 120"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Material journey</title>}

      {/* Dashed haldi connectors between stages */}
      <g
        fill="none"
        stroke="var(--haldi-deep)"
        strokeWidth={1.5}
        strokeLinecap="round"
        strokeDasharray="4 4"
      >
        <path d="M 110 60 L 190 60" />
        <path d="M 260 60 L 340 60" />
        <path d="M 400 60 L 490 60" />
      </g>

      {/* Arrowheads at end of each connector */}
      <g fill="var(--haldi-deep)" stroke="none">
        <path d="M 190 60 L 184 56 L 184 64 Z" />
        <path d="M 340 60 L 334 56 L 334 64 Z" />
        <path d="M 490 60 L 484 56 L 484 64 Z" />
      </g>

      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.5}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* STAGE 1 — Cow (source) at x ~ 75 */}
        <path d="M 50 70 C 48 66 47 62 50 58 C 52 55 55 55 56 58 C 56 53 58 52 58 56 C 58 58 58 61 56 62 L 56 65 C 60 63 64 63 68 65 L 90 65 C 94 65 96 67 96 71 L 96 70 Z" />
        <path d="M 54 70 L 53 80" strokeWidth={1.2} />
        <path d="M 58 70 L 59 80" strokeWidth={1.2} />
        <path d="M 90 70 L 89 80" strokeWidth={1.2} />
        <path d="M 94 70 L 95 80" strokeWidth={1.2} />
        <path d="M 96 66 C 100 68 102 73 100 78" strokeWidth={1.2} />
        <circle cx={51} cy={64} r={0.6} fill="var(--forest)" stroke="none" />

        {/* STAGE 2 — Drying/refining tray with sun */}
        {/* Sun above */}
        <circle cx={225} cy={42} r={7} />
        <path d="M 225 31 L 225 28" />
        <path d="M 217 36 L 215 34" />
        <path d="M 233 36 L 235 34" />
        <path d="M 213 42 L 210 42" />
        <path d="M 237 42 L 240 42" />
        <path d="M 219 49 L 217 51" />
        <path d="M 231 49 L 233 51" />
        {/* Tray (trapezoidal) */}
        <path d="M 195 65 L 255 65 L 250 76 L 200 76 Z" />
        {/* Material in tray — wavy line */}
        <path d="M 200 65 C 215 60 230 65 245 62 C 252 60 252 64 252 65" strokeWidth={1.2} />
        {/* Particles */}
        <circle cx={210} cy={63} r={0.8} fill="var(--forest)" stroke="none" />
        <circle cx={220} cy={61} r={0.8} fill="var(--forest)" stroke="none" />
        <circle cx={235} cy={63} r={0.8} fill="var(--forest)" stroke="none" />
        <circle cx={242} cy={61} r={0.8} fill="var(--forest)" stroke="none" />

        {/* STAGE 3 — Paint bucket (product) at x ~ 375 */}
        {/* Top rim ellipse */}
        <ellipse cx={375} cy={42} rx={17} ry={4} fill="var(--forest)" stroke="var(--forest)" />
        {/* Body */}
        <path d="M 358 42 L 360 80 L 390 80 L 392 42" />
        <path d="M 358 42 C 360 40 390 40 392 42" strokeWidth={1.2} opacity={0.7} />
        {/* Handle */}
        <path d="M 360 42 Q 375 32 390 42" strokeWidth={1.4} />
        {/* Label band */}
        <path d="M 359 60 L 391 60" strokeWidth={1.4} />
        <path d="M 359 65 L 391 65" strokeWidth={1.4} />
        {/* Small haldi stripe accent on bucket */}
        <path d="M 359 70 L 391 70" strokeWidth={1} stroke="var(--haldi-deep)" />

        {/* STAGE 4 — Wall + brush (application) at x ~ 525 */}
        {/* Wall section */}
        <path d="M 495 40 L 555 40 L 555 80 L 495 80 Z" />
        {/* Wall brick lines */}
        <path d="M 495 56 L 555 56" strokeWidth={0.7} opacity={0.5} />
        <path d="M 515 40 L 515 56" strokeWidth={0.7} opacity={0.5} />
        <path d="M 535 56 L 535 80" strokeWidth={0.7} opacity={0.5} />
        <path d="M 505 56 L 505 80" strokeWidth={0.7} opacity={0.5} />
        <path d="M 525 56 L 525 80" strokeWidth={0.7} opacity={0.5} />
        <path d="M 545 56 L 545 80" strokeWidth={0.7} opacity={0.5} />
        <path d="M 495 68 L 555 68" strokeWidth={0.7} opacity={0.5} />

        {/* Haldi paint stroke on wall */}
        <path
          d="M 500 50 L 550 50 L 550 60 L 500 60 Z"
          fill="var(--haldi)"
          stroke="none"
          opacity={0.7}
        />
        <path d="M 500 50 L 550 50" strokeWidth={1} />
        <path d="M 500 60 L 550 60" strokeWidth={1} />

        {/* Brush applying paint */}
        {/* Handle */}
        <path d="M 555 22 L 545 36" strokeWidth={1.6} />
        {/* Ferrule */}
        <path d="M 543 34 L 550 38 L 547 42 L 540 38 Z" strokeWidth={1.3} />
        {/* Bristles */}
        <path d="M 540 39 L 535 50" strokeWidth={1.2} />
        <path d="M 543 41 L 539 52" strokeWidth={1.2} />
        <path d="M 546 42 L 543 53" strokeWidth={1.2} />
      </g>

      {/* Stage labels */}
      <g
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={8}
        fill="var(--forest)"
        textAnchor="middle"
        letterSpacing={1.5}
      >
        <text x={75} y={105}>SOURCE</text>
        <text x={225} y={105}>REFINE</text>
        <text x={375} y={105}>PRODUCT</text>
        <text x={525} y={105}>APPLY</text>
      </g>

      {/* Small sub-labels (italic, smaller) */}
      <g
        fontFamily="Georgia, serif"
        fontSize={6}
        fill="var(--forest)"
        textAnchor="middle"
        opacity={0.7}
        fontStyle="italic"
      >
        <text x={75} y={115}>cow dung</text>
        <text x={225} y={115}>sun-dried</text>
        <text x={375} y={115}>paint</text>
        <text x={525} y={115}>wall</text>
      </g>
    </svg>
  );
}
