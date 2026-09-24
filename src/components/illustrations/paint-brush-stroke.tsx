"use client";

import * as React from "react";

export interface PaintBrushStrokeProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Enormous irregular haldi-yellow brush stroke.
 * Organic, slightly-irregular shape (NOT a perfect rectangle).
 * Haldi gradient fill, subtle irregular edge.
 * One confident brush stroke. Used behind the product bucket in hero.
 */
export function PaintBrushStroke({
  className,
  ariaHidden = true,
}: PaintBrushStrokeProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 600 400"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Paint brush stroke</title>}

      <defs>
        <linearGradient id="brush-stroke-grad" x1="0" y1="0" x2="0.6" y2="1">
          <stop offset="0%" stopColor="var(--haldi)" />
          <stop offset="55%" stopColor="var(--haldi)" />
          <stop offset="100%" stopColor="var(--haldi-deep)" />
        </linearGradient>
        <radialGradient id="brush-stroke-bloom" cx="50%" cy="50%" r="60%">
          <stop offset="0%" stopColor="var(--haldi)" stopOpacity="0.6" />
          <stop offset="100%" stopColor="var(--haldi)" stopOpacity="0" />
        </radialGradient>
        <filter id="brush-stroke-grain" x="0" y="0" width="100%" height="100%">
          <feTurbulence
            type="fractalNoise"
            baseFrequency="0.9"
            numOctaves="2"
            seed="7"
          />
          <feColorMatrix
            type="matrix"
            values="0 0 0 0 0  0 0 0 0 0  0 0 0 0 0  0 0 0 0.12 0"
          />
          <feComposite in2="SourceGraphic" operator="in" />
        </filter>
      </defs>

      {/* Soft bloom behind the stroke */}
      <ellipse cx={300} cy={200} rx={260} ry={170} fill="url(#brush-stroke-bloom)" />

      {/* Main irregular brush stroke — organic wobble on all edges */}
      <path
        d="M 50 200
           C 60 180 70 160 90 140
           C 130 110 170 90 210 100
           C 240 88 270 110 300 104
           C 330 96 360 90 390 95
           C 420 90 450 100 480 110
           C 510 120 540 150 555 180
           C 565 220 565 260 555 290
           C 540 320 510 340 470 345
           C 430 360 390 350 360 340
           C 320 350 280 350 240 340
           C 200 350 160 340 130 330
           C 90 320 60 280 50 240
           C 45 220 45 210 50 200 Z"
        fill="url(#brush-stroke-grad)"
        stroke="var(--haldi-deep)"
        strokeWidth={1.2}
        strokeLinejoin="round"
        opacity={0.92}
      />

      {/* Inner subtle highlight — a lighter organic blob on top */}
      <path
        d="M 120 180
           C 170 140 250 130 310 150
           C 360 130 440 140 500 175
           C 510 195 470 215 410 200
           C 350 215 280 215 220 195
           C 170 210 130 200 120 180 Z"
        fill="var(--haldi)"
        stroke="none"
        opacity={0.45}
      />

      {/* Subtle darker rim along the lower-right edge */}
      <path
        d="M 555 290 C 540 320 510 340 470 345 C 430 360 390 350 360 340 C 320 350 280 350 240 340"
        fill="none"
        stroke="var(--haldi-deep)"
        strokeWidth={1.5}
        opacity={0.5}
      />

      {/* Bristle texture — a few thin lighter strokes laid along the stroke */}
      <g
        fill="none"
        stroke="var(--haldi-deep)"
        strokeWidth={1.4}
        strokeLinecap="round"
        opacity={0.35}
      >
        <path d="M 90 170 C 200 130 380 130 540 200" />
        <path d="M 80 210 C 200 180 400 180 540 250" />
      </g>
      <g
        fill="none"
        stroke="var(--haldi)"
        strokeWidth={1.2}
        strokeLinecap="round"
        opacity={0.5}
      >
        <path d="M 100 195 C 200 165 400 165 540 220" />
      </g>

      {/* Brush drag-out tails at edges — tapering strokes off the main body */}
      <path
        d="M 50 200 C 35 198 22 205 8 210"
        fill="none"
        stroke="var(--haldi)"
        strokeWidth={6}
        strokeLinecap="round"
        opacity={0.7}
      />
      <path
        d="M 555 200 C 575 200 590 195 595 188"
        fill="none"
        stroke="var(--haldi)"
        strokeWidth={5}
        strokeLinecap="round"
        opacity={0.6}
      />
      <path
        d="M 555 280 C 575 285 590 282 598 278"
        fill="none"
        stroke="var(--haldi-deep)"
        strokeWidth={4}
        strokeLinecap="round"
        opacity={0.55}
      />

      {/* Sparse grain/noise overlay for paper-fibre feel */}
      <rect
        x={50}
        y={90}
        width={510}
        height={260}
        filter="url(#brush-stroke-grain)"
        opacity={0.25}
      />
    </svg>
  );
}
