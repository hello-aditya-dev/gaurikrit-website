"use client";

import * as React from "react";

export interface IndianCowProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Side-view Indian / zebu cow — calm standing posture.
 * Old agricultural line-drawing aesthetic.
 * Forest-green outline (~1.75px), haldi ear-tint accent.
 */
export function IndianCow({ className, ariaHidden = true }: IndianCowProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 280 180"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Side-view Indian cow</title>}

      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.75}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* Body + head outline (single closed contour) */}
        <path d="M 56 50 C 48 50 40 56 34 64 C 30 70 28 76 30 82 L 24 88 C 20 90 18 92 20 94 L 24 98 C 21 100 22 102 26 102 L 32 102 C 38 105 44 108 50 110 C 56 113 62 115 68 116 L 78 118 C 90 120 110 119 130 118 L 200 118 C 220 118 235 116 245 110 C 254 102 258 92 256 84 C 254 76 250 70 244 66 C 230 60 210 58 190 58 L 130 58 C 118 58 110 56 100 52 C 90 48 84 48 78 52 C 72 56 68 60 62 60 C 60 58 58 54 56 50 Z" />

        {/* Front leg 1 (forward) */}
        <path d="M 78 118 L 86 118 L 84 158 L 80 158 Z" />
        {/* Front leg 2 (behind) */}
        <path d="M 100 118 L 108 118 L 106 158 L 102 158 Z" />
        {/* Back leg 1 (forward) */}
        <path d="M 208 118 L 216 118 L 218 158 L 214 158 Z" />
        {/* Back leg 2 (behind) */}
        <path d="M 230 118 L 238 118 L 240 158 L 236 158 Z" />

        {/* Hooves — small darkening marks */}
        <path d="M 79 160 L 85 160" strokeWidth={1.5} />
        <path d="M 101 160 L 107 160" strokeWidth={1.5} />
        <path d="M 213 160 L 219 160" strokeWidth={1.5} />
        <path d="M 235 160 L 241 160" strokeWidth={1.5} />

        {/* Horns — front horn (lower, nearer) */}
        <path d="M 50 52 C 44 44 42 32 48 26 C 54 22 60 26 60 34" />
        {/* Horns — back horn (slightly offset up/back) */}
        <path d="M 56 52 C 52 44 52 32 60 26 C 66 24 72 30 70 38" />

        {/* Ear — long, relaxed, hanging down behind horn (closed leaf shape) */}
        <path d="M 62 56 C 70 60 76 70 80 86 C 80 92 76 92 72 88 C 68 78 62 70 60 62 C 60 58 60 56 62 56 Z" />

        {/* Dewlap folds under the neck */}
        <path d="M 64 110 C 70 115 78 117 86 116" strokeWidth={1.4} opacity={0.65} />
        <path d="M 62 107 C 67 112 73 113 80 113" strokeWidth={1.3} opacity={0.45} />
        <path d="M 60 104 C 64 108 68 109 74 109" strokeWidth={1.2} opacity={0.3} />

        {/* Hump definition line — front of hump rising from neck */}
        <path d="M 72 56 C 76 54 80 52 84 52" strokeWidth={1.4} opacity={0.55} />
        {/* Hump back slope definition */}
        <path d="M 92 52 C 96 54 100 56 104 58" strokeWidth={1.3} opacity={0.4} />

        {/* Shoulder blade suggestion line */}
        <path d="M 96 80 C 100 90 104 100 104 110" strokeWidth={1.2} opacity={0.35} />

        {/* Tail — long curve from rump down with tuft */}
        <path d="M 252 72 C 258 80 262 95 262 115 C 262 122 260 128 258 132" />
        {/* Tail tuft */}
        <path d="M 258 130 C 262 132 264 138 262 142" strokeWidth={1.3} />
        <path d="M 256 130 C 254 134 254 140 256 144" strokeWidth={1.3} />
        <path d="M 260 132 C 264 136 266 142 262 146" strokeWidth={1.3} />

        {/* Eye */}
        <circle cx={42} cy={76} r={1.6} fill="var(--forest)" stroke="none" />
        {/* Brow suggestion */}
        <path d="M 38 73 C 41 71 45 71 48 73" strokeWidth={1.2} opacity={0.55} />

        {/* Muzzle detail — nostril + mouth line */}
        <circle cx={24} cy={94} r={0.9} fill="var(--forest)" stroke="none" />
        <path d="M 22 99 Q 26 101 30 99" strokeWidth={1.2} opacity={0.7} />

        {/* Subtle ground line */}
        <path d="M 20 164 L 260 164" strokeWidth={1} opacity={0.22} />
      </g>

      {/* Haldi accent — inner ear canal tint */}
      <path
        d="M 65 60 C 72 66 76 76 78 86 C 75 88 72 86 70 82 C 66 74 62 68 64 60 Z"
        fill="var(--haldi)"
        stroke="none"
        opacity={0.85}
      />
    </svg>
  );
}
