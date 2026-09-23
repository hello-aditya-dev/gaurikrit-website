"use client"

import * as React from "react"
import { useReducedMotion, motion } from "framer-motion"
import { cn } from "@/lib/utils"

interface MarqueeProps {
  children: React.ReactNode
  className?: string
  /** Pause on hover */
  pauseOnHover?: boolean
  /** Direction */
  direction?: "left" | "right"
  /** Duration in seconds for one full loop */
  duration?: number
}

/**
 * Pure-CSS marquee. Duplicates children once and translates the track
 * by -50%. Respects reduced motion (no animation, shows static row).
 */
export function Marquee({
  children,
  className,
  pauseOnHover = true,
  direction = "left",
  duration = 28,
}: MarqueeProps) {
  const reduceMotion = useReducedMotion()

  return (
    <div
      className={cn(
        "group relative flex overflow-hidden",
        pauseOnHover && "[&:hover_.marquee-track]:[animation-play-state:paused]",
        className
      )}
      // mask the edges so items fade in/out
      style={{
        maskImage:
          "linear-gradient(to right, transparent, black 8%, black 92%, transparent)",
        WebkitMaskImage:
          "linear-gradient(to right, transparent, black 8%, black 92%, transparent)",
      }}
    >
      <style>{`
        @keyframes gaurikrit-marquee {
          from { transform: translateX(0); }
          to { transform: translateX(-50%); }
        }
        @keyframes gaurikrit-marquee-reverse {
          from { transform: translateX(-50%); }
          to { transform: translateX(0); }
        }
      `}</style>
      <div
        className={cn(
          "marquee-track flex shrink-0 items-center",
          !reduceMotion && direction === "left" && "animate-[gaurikrit-marquee_var(--d)_linear_infinite]",
          !reduceMotion && direction === "right" && "animate-[gaurikrit-marquee-reverse_var(--d)_linear_infinite]"
        )}
        style={
          {
            "--d": `${duration}s`,
          } as React.CSSProperties
        }
      >
        {children}
        {/* duplicate for seamless loop */}
        <div className="flex shrink-0 items-center" aria-hidden="true">
          {children}
        </div>
      </div>
    </div>
  )
}

/** A single marquee item — icon/short-text pill. */
export function MarqueeItem({
  children,
  className,
}: {
  children: React.ReactNode
  className?: string
}) {
  return (
    <div
      className={cn(
        "flex shrink-0 items-center gap-2 px-6 py-2",
        className
      )}
    >
      {children}
    </div>
  )
}
