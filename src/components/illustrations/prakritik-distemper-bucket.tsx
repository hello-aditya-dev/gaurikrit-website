"use client";

import * as React from "react";

export interface PrakritikDistemperBucketProps {
  className?: string;
  ariaHidden?: boolean;
}

// Stylised website product illustration.
// Replace with approved product photography when supplied.
// To swap with a photo: change the ProductVisual data field to "/products/prakritik-distemper.webp"
// and the ProductCard will render an <img> instead of this SVG.

/**
 * Front-facing white cylindrical distemper bucket.
 * Dark-green rim + label band, haldi-yellow accent stripes,
 * "GAURIKRIT" wordmark, "PRAKRITIK DISTEMPER" name, small cow-line motif.
 */
export function PrakritikDistemperBucket({
  className,
  ariaHidden = true,
}: PrakritikDistemperBucketProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 200 240"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Prakritik Distemper bucket</title>}

      {/* Bail / handle — metal arch */}
      <path
        d="M 40 60 Q 100 18 160 60"
        fill="none"
        stroke="var(--forest)"
        strokeWidth={2}
        strokeLinecap="round"
      />
      <path
        d="M 44 60 Q 100 24 156 60"
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1}
        opacity={0.55}
      />
      {/* Handle attachment lugs */}
      <circle cx={40} cy={60} r={2.5} fill="var(--forest)" />
      <circle cx={160} cy={60} r={2.5} fill="var(--forest)" />

      {/* Bucket body — white, slightly tapered, with subtle inner shadow at base */}
      <path
        d="M 38 60 L 52 208 C 75 215 125 215 148 208 L 162 60 Z"
        fill="var(--card)"
        stroke="var(--forest)"
        strokeWidth={1.75}
        strokeLinejoin="round"
      />

      {/* Top rim ellipse — dark green */}
      <ellipse
        cx={100}
        cy={58}
        rx={62}
        ry={8}
        fill="var(--forest)"
        stroke="var(--forest)"
        strokeWidth={1.5}
      />
      {/* Inner opening (lighter limewash — inside of bucket visible) */}
      <ellipse
        cx={100}
        cy={57}
        rx={55}
        ry={5.5}
        fill="var(--secondary)"
        opacity={0.85}
      />
      {/* Inner paint sheen line — haldi tint inside */}
      <ellipse
        cx={100}
        cy={57}
        rx={50}
        ry={4}
        fill="var(--haldi)"
        opacity={0.25}
      />

      {/* Bottom front curve (subtle, suggesting cylinder base) */}
      <path
        d="M 52 208 C 60 214 140 214 148 208"
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.5}
        opacity={0.7}
      />

      {/* Small cow-line motif on upper white body */}
      <g
        fill="none"
        stroke="var(--forest)"
        strokeWidth={1.4}
        strokeLinecap="round"
        strokeLinejoin="round"
      >
        {/* Tiny side-view cow silhouette with hump */}
        <path d="M 78 112 C 76 108 75 104 76 100 C 77 96 80 95 82 97 C 82 92 84 91 86 94 C 86 97 86 100 84 101 L 86 103 C 88 101 90 100 92 100 C 95 98 100 98 105 100 L 116 100 C 120 100 122 102 122 106 L 122 112 Z" />
        {/* Cow legs */}
        <path d="M 82 112 L 81 122" strokeWidth={1.2} />
        <path d="M 88 112 L 89 122" strokeWidth={1.2} />
        <path d="M 115 112 L 114 122" strokeWidth={1.2} />
        <path d="M 121 112 L 122 122" strokeWidth={1.2} />
        {/* Cow tail */}
        <path d="M 122 106 C 126 108 128 114 126 118" strokeWidth={1.2} />
        {/* Cow eye */}
        <circle cx={79} cy={103} r={0.6} fill="var(--forest)" stroke="none" />
      </g>

      {/* Haldi accent stripe (upper) */}
      <path
        d="M 44 126 L 156 126"
        stroke="var(--haldi-deep)"
        strokeWidth={2.2}
        strokeLinecap="round"
      />
      {/* Haldi accent stripe (lower) */}
      <path
        d="M 47 176 L 153 176"
        stroke="var(--haldi-deep)"
        strokeWidth={2.2}
        strokeLinecap="round"
      />

      {/* Dark-green label band (cylinder-curved rectangle) */}
      <path
        d="M 44 130 L 47 172 L 153 172 L 156 130 C 120 134 80 134 44 130 Z"
        fill="var(--forest)"
        stroke="var(--forest)"
        strokeWidth={1.5}
        strokeLinejoin="round"
      />

      {/* Wordmark text */}
      <text
        x={100}
        y={150}
        textAnchor="middle"
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={12}
        fill="var(--haldi)"
        letterSpacing={1.5}
      >
        GAURIKRIT
      </text>
      {/* Product name text */}
      <text
        x={100}
        y={165}
        textAnchor="middle"
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={6}
        fill="var(--haldi)"
        letterSpacing={1.2}
      >
        PRAKRITIK DISTEMPER
      </text>

      {/* Small underline mark beneath wordmark */}
      <path
        d="M 78 154 L 122 154"
        stroke="var(--haldi)"
        strokeWidth={0.8}
        opacity={0.5}
      />

      {/* Subtle bucket highlight on left side (cylinder sheen) */}
      <path
        d="M 56 70 L 64 200"
        stroke="var(--forest)"
        strokeWidth={0.6}
        opacity={0.18}
      />
    </svg>
  );
}
