"use client";

import * as React from "react";

export interface PrakritikEmulsionBucketProps {
  className?: string;
  ariaHidden?: boolean;
}

// Stylised website product illustration.
// Replace with approved product photography when supplied.
// To swap with a photo: change the ProductVisual data field to "/products/prakritik-emulsion.webp"
// and the ProductCard will render an <img> instead of this SVG.

/**
 * Front-facing taller white cylindrical emulsion bucket.
 * Liquid-paint look (small drip at rim), dark-green rim + label band,
 * haldi-yellow accent stripes, "GAURIKRIT" wordmark,
 * "PRAKRITIK EMULSION" name, small cow-line motif.
 */
export function PrakritikEmulsionBucket({
  className,
  ariaHidden = true,
}: PrakritikEmulsionBucketProps) {
  const isHidden = ariaHidden !== false;
  return (
    <svg
      viewBox="0 0 200 260"
      width="100%"
      height="100%"
      preserveAspectRatio="xMidYMid meet"
      xmlns="http://www.w3.org/2000/svg"
      className={className}
      aria-hidden={isHidden ? "true" : undefined}
      role={isHidden ? undefined : "img"}
    >
      {!isHidden && <title>Prakritik Emulsion bucket</title>}

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

      {/* Liquid paint drip at rim — small wobble of haldi paint over the rim */}
      <path
        d="M 50 62 C 55 70 52 78 58 76 C 62 75 60 68 62 64"
        fill="var(--haldi)"
        stroke="var(--forest)"
        strokeWidth={1.2}
        strokeLinejoin="round"
      />
      <path
        d="M 138 64 C 142 70 140 78 146 76 C 150 75 148 68 152 64"
        fill="var(--haldi)"
        stroke="var(--forest)"
        strokeWidth={1.2}
        strokeLinejoin="round"
      />
      {/* Small drip bead on right side */}
      <circle cx={150} cy={82} r={2.2} fill="var(--haldi)" stroke="var(--forest)" strokeWidth={0.8} />

      {/* Bucket body — taller, white, slightly tapered */}
      <path
        d="M 38 60 L 50 228 C 75 235 125 235 150 228 L 162 60 Z"
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
      {/* Inner opening (inside of bucket) */}
      <ellipse
        cx={100}
        cy={57}
        rx={55}
        ry={5.5}
        fill="var(--secondary)"
        opacity={0.85}
      />
      {/* Paint surface inside — haldi tinted */}
      <ellipse
        cx={100}
        cy={57}
        rx={50}
        ry={4}
        fill="var(--haldi)"
        opacity={0.4}
      />

      {/* Bottom front curve */}
      <path
        d="M 50 228 C 60 234 140 234 150 228"
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
        <path d="M 78 110 C 76 106 75 102 76 98 C 77 94 80 93 82 95 C 82 90 84 89 86 92 C 86 95 86 98 84 99 L 86 101 C 88 99 90 98 92 98 C 95 96 100 96 105 98 L 116 98 C 120 98 122 100 122 104 L 122 110 Z" />
        {/* Cow legs */}
        <path d="M 82 110 L 81 120" strokeWidth={1.2} />
        <path d="M 88 110 L 89 120" strokeWidth={1.2} />
        <path d="M 115 110 L 114 120" strokeWidth={1.2} />
        <path d="M 121 110 L 122 120" strokeWidth={1.2} />
        {/* Cow tail */}
        <path d="M 122 104 C 126 106 128 112 126 116" strokeWidth={1.2} />
        {/* Cow eye */}
        <circle cx={79} cy={101} r={0.6} fill="var(--forest)" stroke="none" />
      </g>

      {/* Haldi accent stripe (upper) */}
      <path
        d="M 44 124 L 156 124"
        stroke="var(--haldi-deep)"
        strokeWidth={2.2}
        strokeLinecap="round"
      />
      {/* Haldi accent stripe (lower) */}
      <path
        d="M 47 196 L 153 196"
        stroke="var(--haldi-deep)"
        strokeWidth={2.2}
        strokeLinecap="round"
      />

      {/* Dark-green label band (taller for emulsion) */}
      <path
        d="M 44 128 L 47 192 L 153 192 L 156 128 C 120 132 80 132 44 128 Z"
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
        fontSize={13}
        fill="var(--haldi)"
        letterSpacing={1.5}
      >
        GAURIKRIT
      </text>
      {/* Subtitle line 1 */}
      <text
        x={100}
        y={167}
        textAnchor="middle"
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={7.5}
        fill="var(--haldi)"
        letterSpacing={1.6}
      >
        PRAKRITIK
      </text>
      {/* Subtitle line 2 */}
      <text
        x={100}
        y={181}
        textAnchor="middle"
        fontFamily="Georgia, serif"
        fontWeight={700}
        fontSize={7.5}
        fill="var(--haldi)"
        letterSpacing={1.6}
      >
        EMULSION
      </text>

      {/* Small underline mark beneath wordmark */}
      <path
        d="M 78 156 L 122 156"
        stroke="var(--haldi)"
        strokeWidth={0.8}
        opacity={0.5}
      />

      {/* Subtle bucket sheen on left side */}
      <path
        d="M 56 70 L 62 220"
        stroke="var(--forest)"
        strokeWidth={0.6}
        opacity={0.18}
      />
    </svg>
  );
}
