import * as React from "react"
import { cn } from "@/lib/utils"

type ProductVisualKey =
  | "haldi-powder"
  | "haldi-paste"
  | "haldi-wellness"
  | "paint-interior"
  | "paint-exterior"
  | "paint-natural"
  | "paint-wood"
  | "paint-primer"

interface ProductVisualProps {
  id: ProductVisualKey
  className?: string
}

const gold = "oklch(0.72 0.15 75)"
const goldDeep = "oklch(0.62 0.16 65)"
const goldLight = "oklch(0.85 0.10 85)"
const charcoal = "oklch(0.20 0.012 60)"
const paper = "oklch(0.98 0.005 85)"
const line = "oklch(0.30 0.02 60 / 0.18)"

export function ProductVisual({ id, className }: ProductVisualProps) {
  return (
    <svg
      viewBox="0 0 320 320"
      xmlns="http://www.w3.org/2000/svg"
      className={cn("h-full w-full", className)}
      role="img"
      aria-label={`Illustration for ${id.replace(/-/g, " ")}`}
    >
      <defs>
        <linearGradient id={`bg-${id}`} x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stopColor={goldLight} />
          <stop offset="100%" stopColor={paper} />
        </linearGradient>
        <linearGradient id={`gold-${id}`} x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stopColor={gold} />
          <stop offset="100%" stopColor={goldDeep} />
        </linearGradient>
        <radialGradient id={`glow-${id}`} cx="50%" cy="50%" r="50%">
          <stop offset="0%" stopColor={gold} stopOpacity={0.25} />
          <stop offset="100%" stopColor={gold} stopOpacity={0} />
        </radialGradient>
      </defs>

      <rect width="320" height="320" fill={`url(#bg-${id})`} />
      <circle cx="160" cy="160" r="130" fill={`url(#glow-${id})`} />

      {/* Subject */}
      {renderSubject(id)}

      {/* Floor shadow */}
      <ellipse cx="160" cy="270" rx="80" ry="10" fill={charcoal} opacity={0.08} />
    </svg>
  )
}

function renderSubject(id: ProductVisualKey) {
  switch (id) {
    case "haldi-powder":
      return (
        <g>
          {/* mound */}
          <path
            d="M110 230 Q160 150 210 230 Z"
            fill={`url(#gold-${id})`}
          />
          <path
            d="M120 225 Q160 165 200 225"
            fill="none"
            stroke={goldLight}
            strokeWidth={2}
            opacity={0.6}
          />
          {/* sprinkles */}
          {[
            [150, 200], [170, 195], [140, 215], [180, 210], [160, 180],
          ].map(([x, y], i) => (
            <circle key={i} cx={x} cy={y} r={3} fill={goldDeep} opacity={0.7} />
          ))}
          {/* spoon */}
          <rect x="150" y="120" width="6" height="80" rx={3} fill={charcoal} opacity={0.7} transform="rotate(-15 153 160)" />
          <ellipse cx="138" cy="118" rx="14" ry="10" fill={charcoal} opacity={0.85} transform="rotate(-15 138 118)" />
        </g>
      )
    case "haldi-paste":
      return (
        <g>
          {/* jar */}
          <rect x="120" y="150" width="80" height="100" rx="8" fill={goldLight} stroke={line} strokeWidth={1.5} />
          <rect x="120" y="150" width="80" height="30" rx="8" fill={charcoal} opacity={0.12} />
          <rect x="120" y="240" width="80" height="10" rx={4} fill={goldDeep} opacity={0.4} />
          {/* lid */}
          <rect x="115" y="135" width="90" height="22" rx="6" fill={charcoal} />
          {/* paste inside */}
          <rect x="128" y="175" width="64" height="68" rx={4} fill={`url(#gold-${id})`} />
          {/* highlight */}
          <rect x="132" y="180" width="8" height="50" rx={4} fill={goldLight} opacity={0.6} />
          {/* label */}
          <rect x="132" y="205" width="56" height="24" rx={3} fill={paper} opacity={0.7} />
          <line x1="140" y1="215" x2="180" y2="215" stroke={charcoal} strokeWidth={1} opacity={0.4} />
          <line x1="140" y1="222" x2="172" y2="222" stroke={charcoal} strokeWidth={1} opacity={0.4} />
        </g>
      )
    case "haldi-wellness":
      return (
        <g>
          {/* amber jar */}
          <rect x="125" y="140" width="70" height="110" rx="6" fill={goldDeep} opacity={0.85} />
          <rect x="125" y="140" width="70" height="110" rx="6" fill="none" stroke={line} strokeWidth={1.5} />
          <rect x="120" y="125" width="80" height="22" rx="6" fill={charcoal} />
          {/* window */}
          <rect x="135" y="170" width="50" height="60" rx="4" fill={paper} opacity={0.9} />
          <text x="160" y="195" textAnchor="middle" fontFamily="serif" fontSize="11" fontWeight="700" fill={goldDeep}>
            CURC
          </text>
          <text x="160" y="210" textAnchor="middle" fontFamily="sans-serif" fontSize="9" fill={charcoal}>
            6%+
          </text>
          {/* highlight */}
          <rect x="130" y="148" width="6" height="40" rx={3} fill={goldLight} opacity={0.7} />
        </g>
      )
    case "paint-interior":
      return (
        <g>
          {/* paint can */}
          <rect x="115" y="160" width="90" height="100" rx="4" fill={paper} stroke={line} strokeWidth={1.5} />
          {/* lid */}
          <rect x="108" y="150" width="104" height="14" rx="3" fill={charcoal} />
          {/* handle */}
          <path d="M140 152 Q160 138 180 152" fill="none" stroke={charcoal} strokeWidth={2} />
          {/* label band */}
          <rect x="115" y="195" width="90" height="42" fill={`url(#gold-${id})`} />
          <text x="160" y="215" textAnchor="middle" fontFamily="serif" fontSize="11" fontWeight="700" fill={paper}>
            GAURIKRIT
          </text>
          <text x="160" y="228" textAnchor="middle" fontFamily="sans-serif" fontSize="7" fill={paper} opacity={0.8}>
            INTERIOR EMULSION
          </text>
          {/* paint drip */}
          <path d="M115 200 Q110 215 115 235" fill="none" stroke={`url(#gold-${id})`} strokeWidth={6} strokeLinecap="round" />
        </g>
      )
    case "paint-exterior":
      return (
        <g>
          {/* bucket */}
          <path d="M110 165 L210 165 L200 255 L120 255 Z" fill={paper} stroke={line} strokeWidth={1.5} />
          <ellipse cx="160" cy="165" rx="50" ry="8" fill={charcoal} opacity={0.85} />
          {/* gold band */}
          <path d="M118 200 L202 200 L200 220 L120 220 Z" fill={`url(#gold-${id})`} />
          {/* text */}
          <text x="160" y="245" textAnchor="middle" fontFamily="serif" fontSize="9" fontWeight="700" fill={charcoal}>
            WEATHER GUARD
          </text>
          {/* sun + cloud marks */}
          <circle cx="135" cy="145" r="10" fill={gold} opacity={0.9} />
          <path d="M170 138 q5 -8 12 -3 q5 -6 12 0 q6 0 4 6 l-28 0 q-2 -3 0 -3" fill={paper} opacity={0.9} />
        </g>
      )
    case "paint-natural":
      return (
        <g>
          {/* round tin */}
          <ellipse cx="160" cy="170" rx="58" ry="14" fill={charcoal} />
          <rect x="102" y="170" width="116" height="80" rx="4" fill={`url(#gold-${id})`} />
          <ellipse cx="160" cy="250" rx="58" ry="14" fill={goldDeep} opacity={0.7} />
          {/* lid ring */}
          <ellipse cx="160" cy="170" rx="58" ry="14" fill="none" stroke={paper} strokeWidth={1} opacity={0.6} />
          {/* turmeric motif */}
          <g transform="translate(160 215)">
            <path d="M0 -20 C 10 -15 14 0 8 12 C 4 18 -4 18 -8 12 C -14 0 -10 -15 0 -20 Z" fill={paper} opacity={0.85} />
            <path d="M0 -20 L0 14" stroke={goldDeep} strokeWidth={1.5} opacity={0.5} />
          </g>
          {/* leaf */}
          <path d="M205 175 q10 -8 18 2 q4 6 -2 10 q-8 4 -14 -2 q-4 -6 -2 -10" fill={paper} opacity={0.7} />
        </g>
      )
    case "paint-wood":
      return (
        <g>
          {/* brush */}
          <rect x="156" y="120" width="8" height="90" rx={2} fill={charcoal} />
          <rect x="150" y="100" width="20" height="28" rx={3} fill={goldDeep} />
          <path d="M150 128 L170 128 L168 150 L152 150 Z" fill={`url(#gold-${id})`} />
          {/* bristles */}
          <path d="M152 150 L150 165 M156 150 L156 168 M160 150 L160 170 M164 150 L164 168 M168 150 L170 165" stroke={goldDeep} strokeWidth={1.5} />
          {/* wood panel */}
          <rect x="90" y="190" width="140" height="60" rx={4} fill={goldLight} />
          <path d="M90 205 L230 205 M90 220 L230 220 M90 235 L230 235" stroke={goldDeep} strokeWidth={1} opacity={0.3} />
          <path d="M100 200 Q120 210 110 225 Q100 240 130 245" fill="none" stroke={goldDeep} strokeWidth={1} opacity={0.25} />
          {/* wood grain knots */}
          <circle cx="140" cy="218" r="3" fill={goldDeep} opacity={0.4} />
          <circle cx="190" cy="230" r="2.5" fill={goldDeep} opacity={0.4} />
        </g>
      )
    case "paint-primer":
      return (
        <g>
          {/* tall can */}
          <rect x="120" y="120" width="80" height="140" rx={4} fill={paper} stroke={line} strokeWidth={1.5} />
          <rect x="113" y="110" width="94" height="14" rx={3} fill={charcoal} />
          {/* label */}
          <rect x="125" y="155" width="70" height="80" rx={3} fill={`url(#gold-${id})`} />
          <text x="160" y="180" textAnchor="middle" fontFamily="serif" fontSize="11" fontWeight="700" fill={paper}>
            BOND
          </text>
          <text x="160" y="195" textAnchor="middle" fontFamily="serif" fontSize="11" fontWeight="700" fill={paper}>
            PRIME
          </text>
          <line x1="140" y1="205" x2="180" y2="205" stroke={paper} strokeWidth={1} opacity={0.5} />
          <text x="160" y="220" textAnchor="middle" fontFamily="sans-serif" fontSize="7" fill={paper} opacity={0.8}>
            SEALER · 1-COAT
          </text>
          {/* highlight */}
          <rect x="126" y="125" width="5" height="30" rx={2} fill={goldLight} opacity={0.8} />
        </g>
      )
    default:
      return null
  }
}
