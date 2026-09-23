"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { Check } from "lucide-react"
import { cn } from "@/lib/utils"
import { track } from "@/lib/analytics"

export interface Shade {
  id: string
  name: string
  /** CSS color value (oklch/hex) */
  color: string
  /** background tint for the wall preview, slightly lighter */
  wall: string
}

/**
 * Curated shade palette for the Natural Turmeric Paint line.
 * Plant + mineral pigments only — no synthetic dyes.
 */
export const NATURAL_SHADES: Shade[] = [
  { id: "haldi-gold", name: "Haldi Gold", color: "oklch(0.72 0.15 75)", wall: "oklch(0.82 0.10 80)" },
  { id: "saffron", name: "Saffron", color: "oklch(0.70 0.18 55)", wall: "oklch(0.80 0.12 60)" },
  { id: "terracotta", name: "Terracotta", color: "oklch(0.60 0.14 45)", wall: "oklch(0.72 0.10 55)" },
  { id: "indigo-mineral", name: "Mineral Indigo", color: "oklch(0.42 0.10 250)", wall: "oklch(0.58 0.08 250)" },
  { id: "ash-clay", name: "Ash Clay", color: "oklch(0.62 0.03 70)", wall: "oklch(0.78 0.02 70)" },
  { id: "moss-green", name: "Moss Green", color: "oklch(0.55 0.10 145)", wall: "oklch(0.72 0.08 145)" },
]

interface ShadePickerProps {
  shades?: Shade[]
  className?: string
}

/**
 * Interactive shade picker with a live "wall preview".
 * Used in the Natural Turmeric Paint product dialog.
 */
export function ShadePicker({ shades = NATURAL_SHADES, className }: ShadePickerProps) {
  const reduceMotion = useReducedMotion()
  const [active, setActive] = React.useState(0)

  const shade = shades[active] ?? shades[0]

  const onPick = (i: number) => {
    setActive(i)
    track("shade_preview", { shadeId: shades[i].id, shadeName: shades[i].name })
  }

  return (
    <div className={cn("flex flex-col gap-3", className)}>
      <h3 className="flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
        Preview a shade
        <span className="font-mono text-[10px] normal-case tracking-normal text-muted-foreground">
          (natural pigments only)
        </span>
      </h3>

      {/* Wall preview */}
      <div
        className="relative h-28 overflow-hidden rounded-2xl border shadow-soft sm:h-32"
        style={{ background: shade.wall }}
        aria-label={`Wall preview in ${shade.name}`}
        role="img"
      >
        {/* Window frame motif */}
        <div className="absolute right-4 top-3 h-16 w-12 rounded-sm border-2 border-foreground/15 bg-foreground/5" aria-hidden="true" />
        <div className="absolute right-4 top-3 h-16 w-12" aria-hidden="true">
          <div className="absolute inset-x-0 top-1/2 h-0.5 -translate-y-1/2 bg-foreground/15" />
          <div className="absolute inset-y-0 left-1/2 w-0.5 -translate-x-1/2 bg-foreground/15" />
        </div>
        {/* Paint can motif */}
        <motion.div
          key={shade.id}
          initial={reduceMotion ? false : { opacity: 0, scale: 0.9 }}
          animate={{ opacity: 1, scale: 1 }}
          transition={{ duration: 0.25 }}
          className="absolute bottom-2 left-3 flex items-center gap-2"
        >
          <span
            className="block h-10 w-7 rounded-sm border border-foreground/10 shadow-soft"
            style={{ background: shade.color }}
            aria-hidden="true"
          />
          <span className="text-xs font-medium text-foreground/70">
            {shade.name}
          </span>
        </motion.div>
      </div>

      {/* Swatch dots */}
      <div className="flex flex-wrap gap-2">
        {shades.map((s, i) => {
          const isActive = i === active
          return (
            <button
              key={s.id}
              type="button"
              onClick={() => onPick(i)}
              aria-pressed={isActive}
              aria-label={`Preview ${s.name}`}
              title={s.name}
              className={cn(
                "relative h-9 w-9 rounded-full ring-2 ring-offset-2 ring-offset-background transition-all",
                isActive ? "ring-primary scale-110" : "ring-border hover:ring-primary/50"
              )}
              style={{ background: s.color }}
            >
              {isActive ? (
                <Check className="absolute inset-0 m-auto h-4 w-4 text-foreground drop-shadow" />
              ) : null}
            </button>
          )
        })}
      </div>
    </div>
  )
}
