"use client";

import * as React from "react";

export interface AshtaLaabhDiagramProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Ashta-Laabh (eight benefits) radial diagram.
 * Central cow-mark, 8 small icons arranged in a circle
 * (sun, leaf, drop, wall, sprout, heart, home, branch).
 * Thin connecting lines. Forest, haldi accents.
 */
export function AshtaLaabhDiagram({
  className,
  ariaHidden = true,
}: AshtaLaabhDiagramProps) {
  const isHidden = ariaHidden !== false;
  // Center of viewBox
  const cx = 160;
  const cy = 160;
  const ringRadius = 110;

  // 8 icon positions at 45-degree intervals, starting at top (0deg = top going clockwise)
  const icons = [
    { x: cx, y: cy - ringRadius, label: "Solar" }, // top — sun
    { x: cx + ringRadius * 0.707, y: cy - ringRadius * 0.707, label: "Herbal" }, // top-right — leaf
    { x: cx + ringRadius, y: cy, label: "Low-water" }, // right — drop
    { x: cx + ringRadius * 0.707, y: cy + ringRadius * 0.707, label: "Breathes" }, // bottom-right — wall
    { x: cx, y: cy + ringRadius, label: "Biodeg." }, // bottom — sprout
    { x: cx - ringRadius * 0.707, y: cy + ringRadius * 0.707, label: "Safe-air" }, // bottom-left — heart
    { x: cx - ringRadius, y: cy, label: "Indoor" }, // left — home
    { x: cx - ringRadius * 0.707, y: cy - ringRadius * 0.707, label: "Natural" }, // top-left — branch
  ];

  return (
    <svg
      viewBox="0 0 320 320"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Eight benefits radial diagram</title>}

      {/* Outer subtle ring connecting all icons */}
      <circle
        cx={cx}
        cy={cy}
        r={ringRadius}
        fill="none"
        stroke="var(--forest)"
        strokeWidth={0.8}
        opacity={0.3}
      />

      {/* Connector lines from center to each icon (dashed haldi) */}
      <g
        fill="none"
        stroke="var(--haldi-deep)"
        strokeWidth={1}
        strokeDasharray="2 3"
        opacity={0.6}
      >
        {icons.map((p, i) => (
          <line key={`line-${i}`} x1={cx} y1={cy} x2={p.x} y2={p.y} />
        ))}
      </g>

      {/* Tiny decorative dots on the ring between icons */}
      <g fill="var(--haldi)" stroke="none">
        {Array.from({ length: 8 }).map((_, i) => {
          const angle = (i / 8) * 2 * Math.PI + Math.PI / 8;
          const x = cx + (ringRadius - 6) * Math.cos(angle - Math.PI / 2);
          const y = cy + (ringRadius - 6) * Math.sin(angle - Math.PI / 2);
          return <circle key={`dot-${i}`} cx={x} cy={y} r={1.5} />;
        })}
      </g>

      {/* Central cow mark — simplified */}
      <g>
        {/* Inner haldi disc backdrop for cow mark */}
        <circle
          cx={cx}
          cy={cy}
          r={38}
          fill="var(--haldi)"
          stroke="var(--forest)"
          strokeWidth={1.5}
          opacity={0.95}
        />
        <circle
          cx={cx}
          cy={cy}
          r={32}
          fill="none"
          stroke="var(--forest)"
          strokeWidth={0.7}
          opacity={0.4}
        />
        {/* Tiny cow head silhouette inside the disc (forest strokes) */}
        <g
          fill="none"
          stroke="var(--forest)"
          strokeWidth={1.5}
          strokeLinecap="round"
          strokeLinejoin="round"
        >
          {/* Left horn */}
          <path d={`M ${cx - 12} ${cy - 8} C ${cx - 18} ${cy - 16}, ${cx - 22} ${cy - 20}, ${cx - 24} ${cy - 18}`} />
          {/* Right horn */}
          <path d={`M ${cx + 12} ${cy - 8} C ${cx + 18} ${cy - 16}, ${cx + 22} ${cy - 20}, ${cx + 24} ${cy - 18}`} />
          {/* Left ear */}
          <path d={`M ${cx - 14} ${cy - 4} C ${cx - 20} ${cy - 2}, ${cx - 24} ${cy + 4}, ${cx - 22} ${cy + 8}`} />
          {/* Right ear */}
          <path d={`M ${cx + 14} ${cy - 4} C ${cx + 20} ${cy - 2}, ${cx + 24} ${cy + 4}, ${cx + 22} ${cy + 8}`} />
          {/* Head outline */}
          <path d={`M ${cx} ${cy - 12} C ${cx - 8} ${cy - 12}, ${cx - 14} ${cy - 9}, ${cx - 14} ${cy - 4} C ${cx - 14} ${cy + 4}, ${cx - 12} ${cy + 10}, ${cx - 8} ${cy + 14} C ${cx - 4} ${cy + 17}, ${cx + 4} ${cy + 17}, ${cx + 8} ${cy + 14} C ${cx + 12} ${cy + 10}, ${cx + 14} ${cy + 4}, ${cx + 14} ${cy - 4} C ${cx + 14} ${cy - 9}, ${cx + 8} ${cy - 12}, ${cx} ${cy - 12} Z`} />
          {/* Muzzle line */}
          <path d={`M ${cx - 8} ${cy + 8} Q ${cx} ${cy + 10} ${cx + 8} ${cy + 8}`} strokeWidth={1.1} opacity={0.7} />
        </g>
        {/* Eyes */}
        <circle cx={cx - 5} cy={cy} r={1.4} fill="var(--forest)" />
        <circle cx={cx + 5} cy={cy} r={1.4} fill="var(--forest)" />
        {/* Nostrils */}
        <circle cx={cx - 3} cy={cy + 10} r={1} fill="var(--forest)" />
        <circle cx={cx + 3} cy={cy + 10} r={1} fill="var(--forest)" />
      </g>

      {/* 8 Icons */}
      {/* Icon 1 — Sun (top) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <circle cx={icons[0].x} cy={icons[0].y} r={7} />
        <path d={`M ${icons[0].x} ${icons[0].y - 12} L ${icons[0].x} ${icons[0].y - 16}`} />
        <path d={`M ${icons[0].x + 8} ${icons[0].y - 8} L ${icons[0].x + 12} ${icons[0].y - 12}`} />
        <path d={`M ${icons[0].x - 8} ${icons[0].y - 8} L ${icons[0].x - 12} ${icons[0].y - 12}`} />
        <path d={`M ${icons[0].x + 12} ${icons[0].y} L ${icons[0].x + 16} ${icons[0].y}`} />
        <path d={`M ${icons[0].x - 12} ${icons[0].y} L ${icons[0].x - 16} ${icons[0].y}`} />
      </g>

      {/* Icon 2 — Leaf (top-right) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[1].x - 4} ${icons[1].y + 4} C ${icons[1].x - 6} ${icons[1].y - 4}, ${icons[1].x + 4} ${icons[1].y - 8}, ${icons[1].x + 8} ${icons[1].y - 2} C ${icons[1].x + 4} ${icons[1].y + 4}, ${icons[1].x - 2} ${icons[1].y + 6}, ${icons[1].x - 4} ${icons[1].y + 4} Z`} />
        <path d={`M ${icons[1].x - 4} ${icons[1].y + 4} C ${icons[1].x} ${icons[1].y}, ${icons[1].x + 4} ${icons[1].y - 2}, ${icons[1].x + 8} ${icons[1].y - 2}`} strokeWidth={1} opacity={0.7} />
      </g>

      {/* Icon 3 — Drop (right) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[2].x} ${icons[2].y - 10} C ${icons[2].x - 7} ${icons[2].y - 2}, ${icons[2].x - 7} ${icons[2].y + 4}, ${icons[2].x} ${icons[2].y + 4} C ${icons[2].x + 7} ${icons[2].y + 4}, ${icons[2].x + 7} ${icons[2].y - 2}, ${icons[2].x} ${icons[2].y - 10} Z`} />
        <path d={`M ${icons[2].x - 3} ${icons[2].y + 2} Q ${icons[2].x} ${icons[2].y + 4} ${icons[2].x + 3} ${icons[2].y + 2}`} strokeWidth={0.9} opacity={0.6} />
      </g>

      {/* Icon 4 — Wall (bottom-right) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[3].x - 10} ${icons[3].y - 8} L ${icons[3].x + 10} ${icons[3].y - 8} L ${icons[3].x + 10} ${icons[3].y + 8} L ${icons[3].x - 10} ${icons[3].y + 8} Z`} />
        <path d={`M ${icons[3].x - 10} ${icons[3].y} L ${icons[3].x + 10} ${icons[3].y}`} strokeWidth={0.9} />
        <path d={`M ${icons[3].x} ${icons[3].y - 8} L ${icons[3].x} ${icons[3].y}`} strokeWidth={0.9} />
        <path d={`M ${icons[3].x - 5} ${icons[3].y} L ${icons[3].x - 5} ${icons[3].y + 8}`} strokeWidth={0.9} />
        <path d={`M ${icons[3].x + 5} ${icons[3].y} L ${icons[3].x + 5} ${icons[3].y + 8}`} strokeWidth={0.9} />
      </g>

      {/* Icon 5 — Sprout (bottom) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[4].x} ${icons[4].y + 8} L ${icons[4].x} ${icons[4].y - 4}`} />
        <path d={`M ${icons[4].x} ${icons[4].y} C ${icons[4].x - 4} ${icons[4].y - 2}, ${icons[4].x - 8} ${icons[4].y - 4}, ${icons[4].x - 8} ${icons[4].y - 8} C ${icons[4].x - 4} ${icons[4].y - 6}, ${icons[4].x - 2} ${icons[4].y - 4}, ${icons[4].x} ${icons[4].y - 2}`} />
        <path d={`M ${icons[4].x} ${icons[4].y - 2} C ${icons[4].x + 4} ${icons[4].y - 4}, ${icons[4].x + 8} ${icons[4].y - 6}, ${icons[4].x + 8} ${icons[4].y - 10} C ${icons[4].x + 4} ${icons[4].y - 8}, ${icons[4].x + 2} ${icons[4].y - 6}, ${icons[4].x} ${icons[4].y - 4}`} />
        {/* Soil line */}
        <path d={`M ${icons[4].x - 8} ${icons[4].y + 8} L ${icons[4].x + 8} ${icons[4].y + 8}`} strokeWidth={1.2} />
      </g>

      {/* Icon 6 — Heart (bottom-left) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[5].x} ${icons[5].y + 6} C ${icons[5].x - 6} ${icons[5].y + 2}, ${icons[5].x - 10} ${icons[5].y - 4}, ${icons[5].x - 6} ${icons[5].y - 6} C ${icons[5].x - 3} ${icons[5].y - 7}, ${icons[5].x - 1} ${icons[5].y - 5}, ${icons[5].x} ${icons[5].y - 2} C ${icons[5].x + 1} ${icons[5].y - 5}, ${icons[5].x + 3} ${icons[5].y - 7}, ${icons[5].x + 6} ${icons[5].y - 6} C ${icons[5].x + 10} ${icons[5].y - 4}, ${icons[5].x + 6} ${icons[5].y + 2}, ${icons[5].x} ${icons[5].y + 6} Z`} />
      </g>

      {/* Icon 7 — Home (left) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[6].x - 10} ${icons[6].y + 2} L ${icons[6].x} ${icons[6].y - 8} L ${icons[6].x + 10} ${icons[6].y + 2} L ${icons[6].x + 10} ${icons[6].y + 8} L ${icons[6].x - 10} ${icons[6].y + 8} Z`} />
        <path d={`M ${icons[6].x - 3} ${icons[6].y + 8} L ${icons[6].x - 3} ${icons[6].y + 2} L ${icons[6].x + 3} ${icons[6].y + 2} L ${icons[6].x + 3} ${icons[6].y + 8}`} strokeWidth={1.1} />
      </g>

      {/* Icon 8 — Branch / leafy sprig (top-left) */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        <path d={`M ${icons[7].x} ${icons[7].y + 8} L ${icons[7].x} ${icons[7].y - 10}`} />
        <path d={`M ${icons[7].x} ${icons[7].y + 2} C ${icons[7].x - 4} ${icons[7].y}, ${icons[7].x - 8} ${icons[7].y - 4}, ${icons[7].x - 6} ${icons[7].y - 8} C ${icons[7].x - 2} ${icons[7].y - 6}, ${icons[7].x - 2} ${icons[7].y - 2}, ${icons[7].x} ${icons[7].y}`} />
        <path d={`M ${icons[7].x} ${icons[7].y - 4} C ${icons[7].x + 4} ${icons[7].y - 6}, ${icons[7].x + 8} ${icons[7].y - 8}, ${icons[7].x + 6} ${icons[7].y - 12} C ${icons[7].x + 2} ${icons[7].y - 10}, ${icons[7].x + 2} ${icons[7].y - 8}, ${icons[7].x} ${icons[7].y - 6}`} />
      </g>

      {/* Labels under each icon */}
      <g
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={8}
        fill="var(--forest)"
        textAnchor="middle"
        opacity={0.85}
      >
        {icons.map((p, i) => (
          <text
            key={`label-${i}`}
            x={
              p.y < cy - 30
                ? p.x
                : p.y > cy + 30
                  ? p.x
                  : p.x < cx
                    ? p.x - 18
                    : p.x + 18
            }
            y={
              p.y < cy - 30
                ? p.y - 18
                : p.y > cy + 30
                  ? p.y + 18
                  : p.y + 3
            }
            textAnchor={
              p.y < cy - 30 || p.y > cy + 30
                ? "middle"
                : p.x < cx
                  ? "end"
                  : "start"
            }
          >
            {p.label}
          </text>
        ))}
      </g>
    </svg>
  );
}
