"use client"

import * as React from "react"
import { useInView, useReducedMotion } from "framer-motion"
import { cn } from "@/lib/utils"

interface CountUpProps {
  /** Target numeric value */
  value: number
  /** Suffix appended after the number, e.g. "+" or "M+" */
  suffix?: string
  /** Prefix prepended, e.g. "₹" */
  prefix?: string
  /** Number of decimal places (default 0) */
  decimals?: number
  /** Animation duration in seconds (default 1.6) */
  duration?: number
  /** Start animation only when scrolled into view (default true) */
  startOnView?: boolean
  className?: string
}

/**
 * Animates a number from 0 → value when it scrolls into view.
 * Respects prefers-reduced-motion (renders the final value immediately).
 */
export function CountUp({
  value,
  suffix = "",
  prefix = "",
  decimals = 0,
  duration = 1.6,
  startOnView = true,
  className,
}: CountUpProps) {
  const reduceMotion = useReducedMotion()
  const ref = React.useRef<HTMLSpanElement>(null)
  const inView = useInView(ref, { once: true, margin: "-40px" })
  const [display, setDisplay] = React.useState(
    reduceMotion || !startOnView ? value : 0
  )

  React.useEffect(() => {
    if (reduceMotion) {
      setDisplay(value)
      return
    }
    if (startOnView && !inView) return

    let raf = 0
    const start = performance.now()
    const from = 0
    const to = value

    const tick = (now: number) => {
      const elapsed = (now - start) / 1000
      const t = Math.min(elapsed / duration, 1)
      // easeOutExpo for a premium settle
      const eased = t === 1 ? 1 : 1 - Math.pow(2, -10 * t)
      setDisplay(from + (to - from) * eased)
      if (t < 1) {
        raf = requestAnimationFrame(tick)
      } else {
        setDisplay(to)
      }
    }

    raf = requestAnimationFrame(tick)
    return () => cancelAnimationFrame(raf)
  }, [value, duration, startOnView, inView, reduceMotion])

  const formatted = display.toLocaleString("en-IN", {
    minimumFractionDigits: decimals,
    maximumFractionDigits: decimals,
  })

  return (
    <span ref={ref} className={cn("tabular-nums", className)}>
      {prefix}
      {formatted}
      {suffix}
    </span>
  )
}
