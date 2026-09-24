"use client";

import * as React from "react";

export interface FieldBotanicalsProps {
  className?: string;
  ariaHidden?: boolean;
}

/**
 * Botanical line details — grass sprig, leafy branch, seed head.
 * Herbarium / old-botanical-book aesthetic.
 * Forest, 1.5px, fine line. Used as decorative section accents.
 */
export function FieldBotanicals({
  className,
  ariaHidden = true,
}: FieldBotanicalsProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 200 200"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Field botanicals</title>}

      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.5}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* === GRASS SPRIG (left side) === */}
        {/* Main stem */}
        <path d="M 50 180 L 50 70" strokeWidth={1.4} />
        {/* Leaves — long curved blades */}
        <path d="M 50 168 C 35 162 25 152 28 138 C 36 150 46 158 50 168 Z" strokeWidth={1.3} />
        <path d="M 50 146 C 65 140 75 130 72 116 C 64 128 56 138 50 146 Z" strokeWidth={1.3} />
        <path d="M 50 122 C 35 116 25 106 28 92 C 36 104 46 112 50 122 Z" strokeWidth={1.3} />
        <path d="M 50 100 C 65 94 75 84 72 70 C 64 82 56 92 50 100 Z" strokeWidth={1.3} />
        <path d="M 50 78 C 45 72 47 62 55 56 C 50 66 49 72 50 78 Z" strokeWidth={1.2} />
        {/* Leaf vein accents */}
        <path d="M 50 168 C 42 158 38 150 30 142" strokeWidth={0.7} opacity={0.5} />
        <path d="M 50 122 C 42 112 38 104 30 96" strokeWidth={0.7} opacity={0.5} />
        {/* Root suggestion */}
        <path d="M 50 180 L 48 188" strokeWidth={0.9} opacity={0.5} />
        <path d="M 50 180 L 52 188" strokeWidth={0.9} opacity={0.5} />
        <path d="M 50 180 L 50 190" strokeWidth={0.9} opacity={0.5} />

        {/* === LEAFY BRANCH (center) === */}
        {/* Main stem */}
        <path d="M 100 180 L 100 50" strokeWidth={1.5} />
        {/* Branch small offshoots */}
        <path d="M 100 160 L 92 152" strokeWidth={1.1} />
        <path d="M 100 140 L 108 132" strokeWidth={1.1} />
        <path d="M 100 120 L 92 112" strokeWidth={1.1} />
        <path d="M 100 100 L 108 92" strokeWidth={1.1} />
        <path d="M 100 80 L 92 72" strokeWidth={1.1} />

        {/* Leaves — alternating along stem */}
        <path d="M 100 160 C 80 155 70 145 75 130 C 85 145 95 155 100 160 Z" strokeWidth={1.3} />
        <path d="M 100 140 C 120 135 130 125 125 110 C 115 125 105 135 100 140 Z" strokeWidth={1.3} />
        <path d="M 100 120 C 80 115 70 105 75 90 C 85 105 95 115 100 120 Z" strokeWidth={1.3} />
        <path d="M 100 100 C 120 95 130 85 125 70 C 115 85 105 95 100 100 Z" strokeWidth={1.3} />
        <path d="M 100 80 C 85 75 80 65 85 55 C 95 65 100 75 100 80 Z" strokeWidth={1.2} />
        {/* Leaf veins */}
        <path d="M 100 160 C 92 152 86 146 78 138" strokeWidth={0.7} opacity={0.5} />
        <path d="M 100 140 C 108 132 114 126 122 118" strokeWidth={0.7} opacity={0.5} />
        <path d="M 100 120 C 92 112 86 106 78 98" strokeWidth={0.7} opacity={0.5} />
        <path d="M 100 100 C 108 92 114 86 122 78" strokeWidth={0.7} opacity={0.5} />
        {/* Branch tip bud */}
        <path d="M 100 50 C 96 46 98 40 102 42 C 102 46 100 50 100 50 Z" strokeWidth={1.2} />

        {/* === SEED HEAD (right side) === */}
        {/* Stem */}
        <path d="M 160 180 L 160 95" strokeWidth={1.5} />
        {/* Small leaves at base */}
        <path d="M 160 130 C 145 125 140 115 145 105 C 150 115 158 125 160 130 Z" strokeWidth={1.3} />
        <path d="M 160 130 C 175 125 180 115 175 105 C 170 115 162 125 160 130 Z" strokeWidth={1.3} />
        {/* Lower smaller leaves */}
        <path d="M 160 155 C 148 150 144 142 148 134 C 154 142 158 148 160 155 Z" strokeWidth={1.1} opacity={0.85} />
        <path d="M 160 155 C 172 150 176 142 172 134 C 166 142 162 148 160 155 Z" strokeWidth={1.1} opacity={0.85} />

        {/* Seed head — oval cluster */}
        <ellipse cx={160} cy={78} rx={11} ry={20} strokeWidth={1.4} />

        {/* Seed grains (small ovals/dots inside the cluster) */}
        <g strokeWidth={0.8} opacity={0.85}>
          <ellipse cx={155} cy={68} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={165} cy={68} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={160} cy={74} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={155} cy={80} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={165} cy={80} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={160} cy={86} rx={2} ry={3.2} fill="var(--forest)" stroke="none" />
          <ellipse cx={157} cy={92} rx={1.6} ry={2.6} fill="var(--forest)" stroke="none" />
          <ellipse cx={163} cy={92} rx={1.6} ry={2.6} fill="var(--forest)" stroke="none" />
        </g>
        {/* Awns (long thin bristles out the top of seed head) */}
        <g strokeWidth={0.8} opacity={0.7}>
          <path d="M 155 60 C 153 54 154 48 156 42" />
          <path d="M 160 60 C 160 52 160 44 160 38" />
          <path d="M 165 60 C 167 54 166 48 164 42" />
          <path d="M 152 62 C 148 56 145 50 142 44" />
          <path d="M 168 62 C 172 56 175 50 178 44" />
        </g>

        {/* === Scattered detail dots (subtle field texture) === */}
      </g>
      <g fill="var(--forest)" stroke="none">
        <circle cx={28} cy={50} r={0.8} opacity={0.5} />
        <circle cx={180} cy={186} r={0.9} opacity={0.5} />
        <circle cx={120} cy={188} r={0.7} opacity={0.45} />
        <circle cx={30} cy={186} r={0.7} opacity={0.5} />
        <circle cx={185} cy={50} r={0.8} opacity={0.45} />
      </g>
    </svg>
  );
}
