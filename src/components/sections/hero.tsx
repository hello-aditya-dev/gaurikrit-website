"use client"

import * as React from "react"
import Link from "next/link"
import { motion, useReducedMotion, type Variants } from "framer-motion"
import { ArrowRight, ChevronDown } from "lucide-react"
import { company } from "@/lib/data"
import { track } from "@/lib/analytics"
import { Button } from "@/components/ui/button"
import {
  IndianCow,
  PaintBrushStroke,
  PrakritikEmulsionBucket,
  RuralLandscape,
} from "@/components/illustrations"

const EASE = [0.22, 1, 0.36, 1] as const

export function Hero() {
  const reduceMotion = useReducedMotion()

  const container: Variants = {
    hidden: {},
    show: { transition: { staggerChildren: reduceMotion ? 0 : 0.1, delayChildren: reduceMotion ? 0 : 0.15 } },
  }
  const item: Variants = {
    hidden: reduceMotion ? { opacity: 1 } : { opacity: 0, y: 20 },
    show: { opacity: 1, y: 0, transition: { duration: reduceMotion ? 0 : 0.65, ease: EASE } },
  }

  return (
    <section
      id="home"
      aria-label="Gaurikrit Bio Products — Prakritik Paint"
      className="relative isolate overflow-hidden bg-limewash bg-paper-grain"
    >
      <div className="mx-auto flex min-h-[88vh] w-full max-w-7xl flex-col justify-center px-4 py-24 sm:px-6 md:py-28 lg:min-h-screen lg:py-32 lg:px-8">
        <div className="grid items-center gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:gap-8">
          {/* LEFT — copy */}
          <motion.div variants={container} initial="hidden" animate="show" className="flex flex-col items-start">
            {/* Devanagari + brand lockup */}
            <motion.div variants={item} className="flex flex-col gap-1">
              <span className="font-devanagari text-4xl font-bold leading-none text-foreground sm:text-5xl">
                {company.devanagari}
              </span>
              <span className="text-[11px] font-semibold uppercase tracking-[0.28em] text-primary">
                {company.fullName?.toUpperCase() ?? company.name}
              </span>
            </motion.div>

            {/* Headline */}
            <motion.h1
              variants={item}
              className="mt-6 font-display text-4xl font-bold leading-[1.05] tracking-tight text-balance text-foreground sm:text-5xl md:text-6xl lg:text-7xl"
            >
              {company.hero.headlineLines.map((line, i) => (
                <span key={i} className="block" aria-label={line}>
                  {line}
                </span>
              ))}
            </motion.h1>

            {/* Subheadline */}
            <motion.p
              variants={item}
              className="mt-6 max-w-prose text-base leading-relaxed text-muted-foreground md:text-lg"
            >
              {company.hero.subheadline}
            </motion.p>

            {/* CTAs */}
            <motion.div variants={item} className="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
              <Button
                asChild
                size="lg"
                className="bg-forest h-12 rounded-full px-7 text-base font-semibold text-primary-foreground shadow-forest transition-transform hover:scale-[1.02]"
              >
                <Link
                  href={company.hero.primaryCta.href}
                  onClick={() => track("hero_cta_click", { cta: "primary", label: company.hero.primaryCta.label })}
                >
                  {company.hero.primaryCta.label}
                  <ArrowRight className="ml-1 h-4 w-4" />
                </Link>
              </Button>
              <Button
                asChild
                size="lg"
                variant="outline"
                className="h-12 rounded-full border-border bg-background/60 px-7 text-base font-medium text-foreground backdrop-blur transition-colors hover:border-primary hover:text-primary"
              >
                <Link
                  href={company.hero.secondaryCta.href}
                  onClick={() => track("hero_cta_click", { cta: "secondary", label: company.hero.secondaryCta.label })}
                >
                  {company.hero.secondaryCta.label}
                </Link>
              </Button>
            </motion.div>
          </motion.div>

          {/* RIGHT — coded illustration composition */}
          <HeroComposition reduceMotion={!!reduceMotion} />
        </div>

        {/* Rural landscape line — extends across the bottom of the composition */}
        <motion.div
          initial={reduceMotion ? false : { opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: reduceMotion ? 0 : 1.4, duration: 0.8, ease: EASE }}
          className="mt-10 h-16 w-full lg:mt-16"
          aria-hidden="true"
        >
          <RuralLandscape />
        </motion.div>
      </div>

      {/* Scroll cue */}
      <motion.div
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: reduceMotion ? 0 : 2, duration: 0.6 }}
        className="absolute bottom-4 left-1/2 -translate-x-1/2 text-muted-foreground"
        aria-hidden="true"
      >
        <div className="flex flex-col items-center gap-1">
          <span className="text-[0.6rem] font-semibold uppercase tracking-[0.25em]">Scroll</span>
          {reduceMotion ? (
            <ChevronDown className="h-4 w-4" />
          ) : (
            <motion.div animate={{ y: [0, 6, 0] }} transition={{ duration: 1.6, repeat: Infinity, ease: "easeInOut" }}>
              <ChevronDown className="h-4 w-4 text-primary" />
            </motion.div>
          )}
        </div>
      </motion.div>
    </section>
  )
}

/* -------------------------------------------------------------------------- */
/* Hero right-side composition                                                 */
/* Animation sequence (per spec):                                              */
/*  1. paint stroke reveals horizontally                                       */
/*  2. product enters upward 18px                                              */
/*  3. cow line draws once                                                     */
/*  4. landscape line gently resolves (handled in parent)                      */
/*  5. stop — NO continuous floating                                           */
/* -------------------------------------------------------------------------- */

function HeroComposition({ reduceMotion }: { reduceMotion: boolean }) {
  return (
    <motion.div
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      transition={{ duration: reduceMotion ? 0 : 0.4, delay: reduceMotion ? 0 : 0.3 }}
      className="relative mx-auto h-[380px] w-full max-w-[460px] sm:h-[440px] md:h-[500px] md:max-w-[520px] lg:block"
      aria-hidden="true"
    >
      {/* Layer 1 — haldi paint stroke (reveals horizontally) */}
      <motion.div
        className="absolute inset-0 flex items-center justify-center"
        initial={reduceMotion ? false : { clipPath: "inset(0 100% 0 0)" }}
        animate={{ clipPath: "inset(0 0% 0 0)" }}
        transition={{ duration: reduceMotion ? 0 : 1.1, ease: EASE, delay: reduceMotion ? 0 : 0.4 }}
      >
        <div className="h-[80%] w-[88%] paint-edge">
          <PaintBrushStroke />
        </div>
      </motion.div>

      {/* Layer 2 — Prakritik paint bucket (enters upward 18px) */}
      <motion.div
        className="absolute left-1/2 top-1/2 h-[70%] w-[46%]"
        initial={reduceMotion ? false : { opacity: 0, y: 18 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: reduceMotion ? 0 : 0.7, ease: EASE, delay: reduceMotion ? 0 : 1.0 }}
        style={{ translateX: "-50%", translateY: "-50%" }}
      >
        <PrakritikEmulsionBucket />
      </motion.div>

      {/* Layer 3 — Indian cow line (draws once, sits behind-right) */}
      <motion.div
        className="absolute -right-4 bottom-2 h-[42%] w-[55%] opacity-80"
        initial={reduceMotion ? false : { opacity: 0, pathLength: 0 }}
        animate={{ opacity: 0.85, pathLength: 1 }}
        transition={{ duration: reduceMotion ? 0 : 1.2, ease: EASE, delay: reduceMotion ? 0 : 1.4 }}
      >
        <IndianCow />
      </motion.div>
    </motion.div>
  )
}
