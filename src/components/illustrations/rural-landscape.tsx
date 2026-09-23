"use client";

import * as React from "react";

export interface RuralLandscapeProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Thin horizontal rural field/grass line.
 * Rolling fields, grass tufts, distant tree silhouette, low horizon.
 * 1.5px forest stroke. No buildings, no people.
 * Used to extend across the bottom of the hero.
 */
export function RuralLandscape({
  className,
  ariaHidden = true,
}: RuralLandscapeProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 600 80"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Rural landscape</title>}

      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.5}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* Distant field line — back layer */}
        <path d="M 0 32 C 80 28 160 34 240 30 S 400 26 500 30 S 580 30 600 30" strokeWidth={1.1} opacity={0.45} />

        {/* Mid field line — gentle rolling */}
        <path d="M 0 42 C 100 38 200 44 300 40 S 500 36 600 42" strokeWidth={1.25} opacity={0.7} />

        {/* Main horizon line — most prominent */}
        <path d="M 0 50 C 80 46 160 52 240 48 S 380 44 460 48 S 540 48 600 50" strokeWidth={1.5} />

        {/* Foreground field division lines */}
        <path d="M 0 60 Q 150 56 300 60 T 600 58" strokeWidth={1.1} opacity={0.55} />
        <path d="M 0 68 Q 200 64 400 68 T 600 66" strokeWidth={1} opacity={0.4} />

        {/* Distant tree silhouette on horizon */}
        <path d="M 430 50 L 430 36" strokeWidth={1.4} />
        <path d="M 420 40 C 416 34 418 28 424 26 C 426 22 432 22 434 26 C 440 22 446 26 444 32 C 448 34 446 40 440 40 C 436 42 424 42 420 40 Z" strokeWidth={1.3} opacity={0.85} />

        {/* Second smaller distant tree */}
        <path d="M 120 52 L 120 44" strokeWidth={1.2} opacity={0.65} />
        <path d="M 116 46 C 114 42 116 38 120 37 C 122 35 126 36 126 39 C 128 41 128 45 124 46 C 122 47 118 47 116 46 Z" strokeWidth={1.1} opacity={0.6} />

        {/* Grass tufts — distant (small) */}
        {[
          [40, 50],
          [85, 49],
          [165, 51],
          [210, 49],
          [260, 50],
          [330, 49],
          [380, 51],
          [490, 50],
          [540, 49],
          [580, 50],
        ].map(([x, y], i) => (
          <g key={`distant-${i}`} strokeWidth={1} opacity={0.55}>
            <path d={`M ${x} ${y} L ${x - 1} ${y - 3}`} />
            <path d={`M ${x} ${y} L ${x + 1} ${y - 3}`} />
            <path d={`M ${x} ${y} L ${x} ${y - 4}`} />
          </g>
        ))}

        {/* Grass tufts — foreground (larger, more visible) */}
        {[
          [30, 68],
          [70, 70],
          [110, 68],
          [180, 72],
          [230, 70],
          [290, 72],
          [340, 70],
          [400, 72],
          [450, 70],
          [510, 72],
          [560, 70],
          [585, 72],
        ].map(([x, y], i) => (
          <g key={`fg-${i}`} strokeWidth={1.2} opacity={0.8}>
            <path d={`M ${x} ${y} L ${x - 2} ${y - 6}`} />
            <path d={`M ${x} ${y} L ${x + 2} ${y - 6}`} />
            <path d={`M ${x} ${y} L ${x} ${y - 8}`} />
            <path d={`M ${x - 1} ${y} L ${x - 3} ${y - 4}`} opacity={0.7} />
            <path d={`M ${x + 1} ${y} L ${x + 3} ${y - 4}`} opacity={0.7} />
          </g>
        ))}

        {/* Small leafy sprig accents scattered along */}
        <path d="M 460 66 C 462 62 466 60 470 62 C 468 64 464 66 460 66 Z" strokeWidth={1.1} opacity={0.7} />
        <path d="M 150 66 C 152 62 156 60 160 62 C 158 64 154 66 150 66 Z" strokeWidth={1.1} opacity={0.7} />
      </g>
    </svg>
  );
}
