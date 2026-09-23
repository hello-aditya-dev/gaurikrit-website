"use client"

import * as React from "react"
import { cn } from "@/lib/utils"
import {
  PrakritikDistemperBucket,
  PrakritikEmulsionBucket,
} from "@/components/illustrations"

type ProductVisualKey =
  | "prakritik-distemper"
  | "prakritik-emulsion"

interface ProductVisualProps {
  id: ProductVisualKey | string
  className?: string
}

/**
 * Renders the coded SVG product illustration for a given product id.
 *
 * Design rule: each product maps to exactly one illustration component.
 * To later swap with real photography, change the parent to render an
 * <img src="/products/{id}.webp" /> instead of this component — the
 * ProductCard and ProductDialog already key off this data field.
 */
const VISUALS: Record<ProductVisualKey, React.ComponentType<{ className?: string }>> = {
  "prakritik-distemper": PrakritikDistemperBucket,
  "prakritik-emulsion": PrakritikEmulsionBucket,
}

export function ProductVisual({ id, className }: ProductVisualProps) {
  const Visual = VISUALS[id as ProductVisualKey]
  if (!Visual) {
    // Fallback: a neutral bucket outline if the id is unknown.
    return <FallbackBucket className={className} />
  }
  return <Visual className={className} />
}

function FallbackBucket({ className }: { className?: string }) {
  return (
    <svg
      viewBox="0 0 200 240"
      xmlns="http://www.w3.org/2000/svg"
      className={cn("h-full w-full", className)}
      role="img"
      aria-label="Prakritik paint illustration"
    >
      <rect x="50" y="60" width="100" height="150" rx="6" fill="none" stroke="var(--forest)" strokeWidth="1.75" strokeLinejoin="round" />
      <rect x="44" y="52" width="112" height="14" rx="3" fill="none" stroke="var(--forest)" strokeWidth="1.75" />
      <path d="M70 52 Q100 38 130 52" fill="none" stroke="var(--forest)" strokeWidth="1.75" strokeLinecap="round" />
      <rect x="50" y="110" width="100" height="40" fill="var(--haldi)" opacity="0.3" />
    </svg>
  )
}
