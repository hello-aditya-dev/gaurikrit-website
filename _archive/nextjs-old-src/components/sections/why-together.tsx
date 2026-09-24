"use client"

import * as React from "react"
import { motion, useReducedMotion, type Variants } from "framer-motion"
import { Leaf, PaintBucket, ArrowLeftRight, Sparkles } from "lucide-react"
import { Section, SectionHeading } from "@/components/layout/site-shell"
import { cn } from "@/lib/utils"

const EASE = [0.22, 1, 0.36, 1] as const

/**
 * "Why haldi + paint together" — the unique brand hook.
 *
 * A split storytelling section: left = haldi, right = paint, centre = the
 * "one promise" bridge. This is the section that explains *why* Gaurikrit
 * makes both, which is the brand's main differentiator.
 */
export function WhyTogether() {
  const reduceMotion = useReducedMotion()

  const container: Variants = {
    hidden: {},
    show: { transition: { staggerChildren: reduceMotion ? 0 : 0.12, delayChildren: reduceMotion ? 0 : 0.1 } },
  }
  const item: Variants = {
    hidden: reduceMotion ? { opacity: 1 } : { opacity: 0, y: 22 },
    show: { opacity: 1, y: 0, transition: { duration: reduceMotion ? 0 : 0.6, ease: EASE } },
  }

  return (
    <Section
      id="why-together"
      tone="default"
      className="bg-grain"
    >
      <SectionHeading
        eyebrow="The Gaurikrit idea"
        title="Why haldi and paint, together?"
        description="Two crafts that seem opposite — one feeds the body, one shelters the home. We make both because the rule that governs them is the same: never sell what you wouldn't bring home to your own family."
      />

      <motion.div
        variants={container}
        initial="hidden"
        whileInView="show"
        viewport={{ once: true, amount: 0.25 }}
        className="mt-12 grid items-stretch gap-4 md:grid-cols-[1fr_auto_1fr] md:gap-6"
      >
        {/* LEFT — Haldi */}
        <motion.div variants={item}>
          <div className="flex h-full flex-col rounded-3xl border bg-card p-7 shadow-soft">
            <div className="mb-5 flex items-center gap-3">
              <span className="flex h-12 w-12 items-center justify-center rounded-2xl gold-gradient text-accent shadow-gold">
                <Leaf className="h-6 w-6" aria-hidden="true" />
              </span>
              <div>
                <p className="text-[11px] font-semibold uppercase tracking-[0.2em] text-primary">
                  The body
                </p>
                <h3 className="font-display text-2xl font-bold leading-tight text-foreground">
                  Naturally crafted haldi
                </h3>
              </div>
            </div>
            <p className="text-sm leading-relaxed text-muted-foreground">
              Sun-cured for 21 days. Stone-ground in small lots. Every batch
              screened for curcumin and heavy metals. What reaches your shelf
              is the same turmeric we cook with at home.
            </p>
            <ul className="mt-5 space-y-2.5">
              {[
                "Curcumin 4.5%+, batch-tested",
                "No additives, no irradiation",
                "FSSAI-licensed, NABL-screened",
              ].map((t) => (
                <li key={t} className="flex items-start gap-2.5 text-sm text-foreground">
                  <Sparkles className="mt-0.5 size-4 shrink-0 text-primary" />
                  {t}
                </li>
              ))}
            </ul>
          </div>
        </motion.div>

        {/* CENTER — the bridge */}
        <motion.div variants={item} className="flex items-center justify-center">
          <div className="relative flex h-full w-full flex-col items-center justify-center gap-3 rounded-3xl border-2 border-dashed border-primary/40 bg-primary/5 p-5 text-center md:w-56">
            <span className="flex h-14 w-14 items-center justify-center rounded-full gold-gradient text-accent shadow-gold">
              <ArrowLeftRight className="h-6 w-6" aria-hidden="true" />
            </span>
            <p className="font-display text-lg font-bold leading-tight text-foreground">
              One promise
            </p>
            <p className="text-xs leading-relaxed text-muted-foreground">
              The same discipline that grinds our haldi tests every litre of
              our paint. Purity is not a category — it's a habit.
            </p>
            <div className="mt-2 h-px w-12 bg-primary/40" aria-hidden="true" />
            <p className="font-mono text-[10px] uppercase tracking-[0.18em] text-muted-foreground">
              est. 1998
            </p>
          </div>
        </motion.div>

        {/* RIGHT — Paint */}
        <motion.div variants={item}>
          <div className="flex h-full flex-col rounded-3xl border bg-accent p-7 text-accent-foreground shadow-soft">
            <div className="mb-5 flex items-center gap-3">
              <span className="flex h-12 w-12 items-center justify-center rounded-2xl bg-primary text-accent shadow-gold">
                <PaintBucket className="h-6 w-6" aria-hidden="true" />
              </span>
              <div>
                <p className="text-[11px] font-semibold uppercase tracking-[0.2em] text-primary">
                  The home
                </p>
                <h3 className="font-display text-2xl font-bold leading-tight text-accent-foreground">
                  Premium, low-VOC paint
                </h3>
              </div>
            </div>
            <p className="text-sm leading-relaxed text-muted-foreground">
              Lab-tested for coverage, weatherability, and VOC. A signature
              natural paint, turmeric-infused and tinted only with plant and
              mineral pigments — safe enough for a nursery the day it's painted.
            </p>
            <ul className="mt-5 space-y-2.5">
              {[
                "VOC < 50 g/L interior, < 5 g/L natural",
                "8-year weatherability on exteriors",
                "GreenPro ecolabel, no lead, ever",
              ].map((t) => (
                <li key={t} className="flex items-start gap-2.5 text-sm text-accent-foreground">
                  <Sparkles className="mt-0.5 size-4 shrink-0 text-primary" />
                  {t}
                </li>
              ))}
            </ul>
          </div>
        </motion.div>
      </motion.div>

      {/* Bottom note */}
      <motion.p
        variants={item}
        initial="hidden"
        whileInView="show"
        viewport={{ once: true }}
        className={cn(
          "mx-auto mt-10 max-w-2xl text-center font-display text-lg italic leading-relaxed text-muted-foreground md:text-xl"
        )}
      >
        “We never sell what we wouldn't bring home to our own family.”
        <span className="mt-1 block text-sm not-italic text-foreground">
          — Gauri Kritivas, Founder &amp; Master Crafter
        </span>
      </motion.p>
    </Section>
  )
}
