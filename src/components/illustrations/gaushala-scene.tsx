"use client";

import * as React from "react";

export interface GaushalaSceneProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Calm gaushala — 2-3 simplified side-view cows,
 * low shelter roofline, ground line, small tree.
 * Minimal forest line art. Used in About / story section.
 */
export function GaushalaScene({
  className,
  ariaHidden = true,
}: GaushalaSceneProps) {
  const isHidden = ariaHidden !== false;

  // Reusable tiny cow silhouette (centered at cx, cy = feet baseline)
  const renderCow = (cx: number, baselineY: number, scale = 1) => {
    const s = scale;
    return (
      <g
        key={`cow-${cx}-${baselineY}`}
        transform={`translate(${cx} ${baselineY}) scale(${s}) translate(${-cx} ${-baselineY})`}
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* Body + head outline (with hump) */}
        <path
          d={`M ${cx - 18} ${baselineY - 6}
              C ${cx - 20} ${baselineY - 12}, ${cx - 18} ${baselineY - 18}, ${cx - 14} ${baselineY - 18}
              C ${cx - 14} ${baselineY - 22}, ${cx - 11} ${baselineY - 23}, ${cx - 10} ${baselineY - 20}
              C ${cx - 10} ${baselineY - 18}, ${cx - 10} ${baselineY - 16}, ${cx - 12} ${baselineY - 15}
              L ${cx - 10} ${baselineY - 13}
              C ${cx - 6} ${baselineY - 15}, ${cx - 2} ${baselineY - 14}, ${cx + 2} ${baselineY - 13}
              C ${cx + 8} ${baselineY - 14}, ${cx + 14} ${baselineY - 13}, ${cx + 18} ${baselineY - 12}
              C ${cx + 22} ${baselineY - 11}, ${cx + 24} ${baselineY - 8}, ${cx + 24} ${baselineY - 6}
              L ${cx + 24} ${baselineY - 6}
              L ${cx - 18} ${baselineY - 6} Z`}
        />
        {/* Front leg 1 */}
        <path d={`M ${cx - 14} ${baselineY - 6} L ${cx - 15} ${baselineY}`} strokeWidth={1.2} />
        {/* Front leg 2 */}
        <path d={`M ${cx - 9} ${baselineY - 6} L ${cx - 8} ${baselineY}`} strokeWidth={1.2} />
        {/* Back leg 1 */}
        <path d={`M ${cx + 16} ${baselineY - 6} L ${cx + 15} ${baselineY}`} strokeWidth={1.2} />
        {/* Back leg 2 */}
        <path d={`M ${cx + 21} ${baselineY - 6} L ${cx + 22} ${baselineY}`} strokeWidth={1.2} />
        {/* Tail */}
        <path d={`M ${cx + 24} ${baselineY - 11} C ${cx + 28} ${baselineY - 9}, ${cx + 30} ${baselineY - 4}, ${cx + 28} ${baselineY}`} strokeWidth={1.2} />
        {/* Horn */}
        <path d={`M ${cx - 14} ${baselineY - 18} C ${cx - 16} ${baselineY - 22}, ${cx - 14} ${baselineY - 25}, ${cx - 12} ${baselineY - 24}`} strokeWidth={1.1} />
        {/* Ear */}
        <path d={`M ${cx - 12} ${baselineY - 17} C ${cx - 8} ${baselineY - 16}, ${cx - 6} ${baselineY - 14}, ${cx - 6} ${baselineY - 12}`} strokeWidth={1.1} />
        {/* Eye */}
        <circle cx={cx - 16} cy={baselineY - 14} r={0.5} fill="var(--forest)" stroke="none" />
      </g>
    );
  };

  return (
    <svg
      viewBox="0 0 400 200"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Gaushala scene</title>}

      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.5}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* Shelter roofline — low pitched sloping roof */}
        <path d="M 50 100 L 220 78 L 350 100" strokeWidth={1.6} />
        {/* Roof underside line — parallel for thickness */}
        <path d="M 55 106 L 220 84 L 345 106" strokeWidth={1.1} opacity={0.65} />
        {/* Roof tile/segment lines */}
        <path d="M 90 96 L 92 102" strokeWidth={0.9} opacity={0.5} />
        <path d="M 130 90 L 132 96" strokeWidth={0.9} opacity={0.5} />
        <path d="M 170 85 L 172 91" strokeWidth={0.9} opacity={0.5} />
        <path d="M 220 78 L 222 84" strokeWidth={0.9} opacity={0.5} />
        <path d="M 270 84 L 272 90" strokeWidth={0.9} opacity={0.5} />
        <path d="M 310 92 L 312 98" strokeWidth={0.9} opacity={0.5} />

        {/* Shelter support poles */}
        <path d="M 70 106 L 70 162" strokeWidth={1.4} />
        <path d="M 220 84 L 220 162" strokeWidth={1.4} />
        <path d="M 330 100 L 330 162" strokeWidth={1.4} />
        {/* Pole base bands */}
        <path d="M 67 162 L 73 162" strokeWidth={1.2} opacity={0.7} />
        <path d="M 217 162 L 223 162" strokeWidth={1.2} opacity={0.7} />
        <path d="M 327 162 L 333 162" strokeWidth={1.2} opacity={0.7} />

        {/* Cows — 2 under the shelter, 1 outside on the right */}
        {renderCow(120, 162, 1)}
        {renderCow(180, 162, 0.9)}
        {renderCow(370, 178, 0.7)}

        {/* Small tree (left side) */}
        <path d="M 30 162 L 30 130" strokeWidth={1.5} />
        {/* Tree canopy — irregular rounded shape */}
        <path d="M 30 130 C 16 128 8 116 14 104 C 10 96 18 86 28 90 C 30 80 44 78 50 88 C 58 84 66 92 60 100 C 68 108 62 124 50 126 C 44 132 34 132 30 130 Z" strokeWidth={1.4} />
        {/* Canopy detail veins */}
        <path d="M 30 130 L 30 116" strokeWidth={0.9} opacity={0.55} />
        <path d="M 30 122 L 22 112" strokeWidth={0.7} opacity={0.4} />
        <path d="M 30 122 L 38 112" strokeWidth={0.7} opacity={0.4} />

        {/* Ground line */}
        <path d="M 0 165 L 400 165" strokeWidth={1.5} />
        {/* Lower ground subtle line */}
        <path d="M 0 175 L 400 175" strokeWidth={0.9} opacity={0.4} />

        {/* Foreground grass tufts */}
        <g strokeWidth={1.1} opacity={0.8}>
          <path d="M 60 165 L 60 170" />
          <path d="M 62 165 L 62 170" />
          <path d="M 64 165 L 64 171" />
          <path d="M 150 165 L 150 170" />
          <path d="M 152 165 L 152 170" />
          <path d="M 154 165 L 154 171" />
          <path d="M 240 165 L 240 170" />
          <path d="M 242 165 L 242 170" />
          <path d="M 244 165 L 244 171" />
          <path d="M 320 165 L 320 170" />
          <path d="M 322 165 L 322 170" />
          <path d="M 324 165 L 324 171" />
          <path d="M 395 165 L 395 170" />
          <path d="M 397 165 L 397 170" />
        </g>

        {/* Distant ground line / horizon */}
        <path d="M 0 158 L 400 158" strokeWidth={0.9} opacity={0.35} />

        {/* Tiny birds in the distance (3 small v-shapes) */}
        <g strokeWidth={1} opacity={0.5}>
          <path d="M 270 50 L 274 47 L 278 50" />
          <path d="M 295 38 L 298 35 L 301 38" />
          <path d="M 320 52 L 323 49 L 326 52" />
        </g>

        {/* Sun low on horizon (small circle) */}
        <circle cx={360} cy={36} r={6} strokeWidth={1.2} />
        {/* Sun ray suggestion (3 short rays) */}
        <path d="M 360 26 L 360 22" strokeWidth={1} opacity={0.6} />
        <path d="M 350 32 L 346 28" strokeWidth={1} opacity={0.6} />
        <path d="M 370 32 L 374 28" strokeWidth={1} opacity={0.6} />
      </g>
    </svg>
  );
}
