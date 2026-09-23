"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { Star } from "lucide-react"
import { Container } from "@/components/layout/site-shell"
import { track } from "@/lib/analytics"

/**
 * "As featured in" credibility strip.
 * Logos rendered as stylised text-marks (no external image deps).
 * Sits below the testimonials to reinforce trust before the FAQ.
 */

interface PressItem {
  name: string
  tag: string
  style: string
}

const PRESS: PressItem[] = [
  { name: "Architectural Digest", tag: "India", style: "font-serif italic" },
  { name: "The Better India", tag: "Feature", style: "font-sans font-bold tracking-tight" },
  { name: "Elle Decor", tag: "Pick", style: "font-serif tracking-wide" },
  { name: "House Beautiful", tag: "Editor's Choice", style: "font-sans font-light tracking-[0.2em] uppercase" },
  { name: "Mid-Day", tag: "Mumbai", style: "font-sans font-black" },
  { name: "Deccan Herald", tag: "Bengaluru", style: "font-serif font-bold" },
]

export function PressStrip() {
  const reduceMotion = useReducedMotion()

  return (
    <section
      aria-label="As featured in"
      className="border-y border-border bg-background py-12 md:py-14"
    >
      <Container>
        <motion.div
          initial={reduceMotion ? false : { opacity: 0, y: 12 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true, amount: 0.3 }}
          transition={{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
          className="text-center"
        >
          <p className="flex items-center justify-center gap-2 text-xs font-semibold uppercase tracking-[0.22em] text-muted-foreground">
            <Star className="h-3.5 w-3.5 fill-primary text-primary" aria-hidden="true" />
            As featured in
          </p>
        </motion.div>

        <motion.ul
          initial={reduceMotion ? false : { opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true, amount: 0.3 }}
          transition={{ duration: 0.6, delay: 0.1 }}
          className="mt-6 grid grid-cols-2 gap-x-6 gap-y-5 sm:grid-cols-3 lg:grid-cols-6"
        >
          {PRESS.map((p, i) => (
            <motion.li
              key={p.name}
              initial={reduceMotion ? false : { opacity: 0, y: 8 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.4, delay: 0.15 + i * 0.05 }}
              className="flex flex-col items-center justify-center text-center"
            >
              <a
                href="#contact"
                onClick={() => track("press_click", { name: p.name })}
                className="group flex flex-col items-center"
                aria-label={`${p.name} — ${p.tag}`}
              >
                <span
                  className={`text-base text-muted-foreground/80 transition-colors group-hover:text-foreground md:text-lg ${p.style}`}
                >
                  {p.name}
                </span>
                <span className="mt-0.5 text-[10px] uppercase tracking-[0.18em] text-muted-foreground/60 transition-colors group-hover:text-primary">
                  {p.tag}
                </span>
              </a>
            </motion.li>
          ))}
        </motion.ul>
      </Container>
    </section>
  )
}
