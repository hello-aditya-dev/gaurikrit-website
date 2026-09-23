"use client"

import * as React from "react"
import Link from "next/link"
import { motion, useReducedMotion, type Variants } from "framer-motion"
import { ChevronDown, ArrowRight, Sparkles } from "lucide-react"
import { company } from "@/lib/data"
import { cn } from "@/lib/utils"
import { Button } from "@/components/ui/button"

const EASE = [0.22, 1, 0.36, 1] as const

/**
 * Replaces the words "haldi" and "paint" (case-insensitive) with a
 * gold-text-gradient span so they pop inside the headline.
 */
function renderHeadlineLine(line: string) {
  const tokens = line.split(/(\bhaldi\b|\bpaint\b)/i)
  return tokens.map((tok, i) => {
    if (/^haldi$/i.test(tok) || /^paint$/i.test(tok)) {
      return (
        <span key={i} className="gold-text-gradient font-display italic">
          {tok}
        </span>
      )
    }
    return <React.Fragment key={i}>{tok}</React.Fragment>
  })
}

export function Hero() {
  const reduceMotion = useReducedMotion()

  // Entrance variants — staggered fade-up, but disabled when user
  // prefers reduced motion (everything appears instantly).
  const containerVariants: Variants = {
    hidden: {},
    show: {
      transition: {
        delayChildren: reduceMotion ? 0 : 0.1,
        staggerChildren: reduceMotion ? 0 : 0.12,
      },
    },
  }

  const itemVariants: Variants = {
    hidden: reduceMotion ? { opacity: 1 } : { opacity: 0, y: 24 },
    show: {
      opacity: 1,
      y: 0,
      transition: { duration: reduceMotion ? 0 : 0.7, ease: EASE },
    },
  }

  // Word-by-word stagger for the headline lines.
  const headlineWords = React.useMemo(() => {
    return company.hero.headlineLines.map((line) => line.split(" "))
  }, [])

  return (
    <section
      id="home"
      aria-label="Gaurikrit — naturally crafted haldi & premium paint"
      className="relative isolate overflow-hidden bg-background bg-grain"
    >
      {/* Radial gold glow backdrop */}
      <div
        aria-hidden="true"
        className="pointer-events-none absolute inset-0 -z-10"
        style={{
          background:
            "radial-gradient(60% 50% at 70% 25%, oklch(0.72 0.15 75 / 0.18) 0%, oklch(0.72 0.15 75 / 0.05) 35%, transparent 70%)",
        }}
      />
      <div
        aria-hidden="true"
        className="pointer-events-none absolute inset-0 -z-10"
        style={{
          background:
            "radial-gradient(40% 30% at 15% 80%, oklch(0.85 0.10 85 / 0.20) 0%, transparent 65%)",
        }}
      />

      <div className="mx-auto flex min-h-[88vh] w-full max-w-7xl flex-col justify-center px-4 py-20 sm:px-6 md:py-24 lg:min-h-screen lg:py-28 lg:px-8">
        <div className="grid items-center gap-12 lg:grid-cols-[1.05fr_0.95fr] lg:gap-10">
          {/* LEFT COLUMN — copy */}
          <motion.div
            variants={containerVariants}
            initial="hidden"
            animate="show"
            className="flex flex-col items-start"
          >
            {/* Eyebrow pill */}
            <motion.div variants={itemVariants}>
              <span className="inline-flex items-center gap-2 rounded-full border border-border bg-background/60 px-3.5 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-foreground shadow-soft backdrop-blur">
                <span className="h-1.5 w-1.5 rounded-full gold-gradient" aria-hidden="true" />
                {company.hero.eyebrow}
              </span>
            </motion.div>

            {/* Headline — staggered word by word */}
            <motion.h1
              variants={itemVariants}
              className="mt-6 font-display text-4xl font-bold leading-[1.05] tracking-tight text-balance text-foreground sm:text-5xl md:text-6xl lg:text-7xl"
            >
              {headlineWords.map((words, lineIdx) => (
                <span
                  key={lineIdx}
                  className="block"
                  aria-label={company.hero.headlineLines[lineIdx]}
                >
                  {words.map((word, wordIdx) => (
                    <motion.span
                      key={`${lineIdx}-${wordIdx}`}
                      variants={itemVariants}
                      className="mr-[0.25em] inline-block"
                    >
                      {renderHeadlineLine(word)}
                    </motion.span>
                  ))}
                </span>
              ))}
            </motion.h1>

            {/* Subheadline */}
            <motion.p
              variants={itemVariants}
              className="mt-6 max-w-prose text-base leading-relaxed text-muted-foreground md:text-lg"
            >
              {company.hero.subheadline}
            </motion.p>

            {/* CTAs */}
            <motion.div
              variants={itemVariants}
              className="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center"
            >
              <Button
                asChild
                size="lg"
                className="gold-gradient h-12 rounded-full px-7 text-base font-semibold text-accent shadow-gold transition-transform hover:scale-[1.02]"
              >
                <Link href={company.hero.primaryCta.href}>
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
                <Link href={company.hero.secondaryCta.href}>
                  {company.hero.secondaryCta.label}
                </Link>
              </Button>
            </motion.div>
          </motion.div>

          {/* RIGHT COLUMN — floating cards collage */}
          <HeroCollage reduceMotion={!!reduceMotion} />
        </div>

        {/* Scroll cue */}
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ delay: reduceMotion ? 0 : 1, duration: 0.6 }}
          className="mt-12 flex justify-center lg:mt-16"
          aria-hidden="true"
        >
          <div className="flex flex-col items-center gap-1 text-muted-foreground">
            <span className="text-[0.65rem] font-semibold uppercase tracking-[0.25em]">
              Scroll
            </span>
            {reduceMotion ? (
              <ChevronDown className="h-4 w-4" />
            ) : (
              <motion.div
                animate={{ y: [0, 6, 0] }}
                transition={{ duration: 1.6, repeat: Infinity, ease: "easeInOut" }}
              >
                <ChevronDown className="h-4 w-4 text-primary" />
              </motion.div>
            )}
          </div>
        </motion.div>
      </div>
    </section>
  )
}

/* -------------------------------------------------------------------------- */
/* Hero collage — floating cards on the right                                 */
/* -------------------------------------------------------------------------- */

function HeroCollage({ reduceMotion }: { reduceMotion: boolean }) {
  const drift = React.useMemo(
    () =>
      reduceMotion
        ? undefined
        : {
            animate: { y: [0, -10, 0] },
            transition: { duration: 4, repeat: Infinity, ease: "easeInOut" as const },
          },
    [reduceMotion]
  )

  const driftSlow = React.useMemo(
    () =>
      reduceMotion
        ? undefined
        : {
            animate: { y: [0, 8, 0] },
            transition: { duration: 5.5, repeat: Infinity, ease: "easeInOut" as const },
          },
    [reduceMotion]
  )

  return (
    <motion.div
      initial={{ opacity: 0, scale: 0.95 }}
      animate={{ opacity: 1, scale: 1 }}
      transition={{ duration: reduceMotion ? 0 : 0.8, delay: reduceMotion ? 0 : 0.3, ease: EASE }}
      className="relative mx-auto hidden h-[460px] w-full max-w-[460px] sm:block md:h-[520px] md:max-w-[520px] lg:block"
      aria-hidden="true"
    >
      {/* Soft halo behind cards */}
      <div
        className="absolute left-1/2 top-1/2 -z-10 h-[80%] w-[80%] -translate-x-1/2 -translate-y-1/2 rounded-full"
        style={{
          background:
            "radial-gradient(closest-side, oklch(0.72 0.15 75 / 0.22), transparent)",
        }}
      />

      {/* Turmeric mound card */}
      <motion.div
        {...drift}
        className="absolute left-2 top-8 w-[68%] rotate-[-4deg] rounded-3xl gold-gradient p-6 shadow-gold"
      >
        <div className="mb-3 flex items-center gap-2">
          <Sparkles className="h-4 w-4 text-accent" />
          <span className="text-xs font-semibold uppercase tracking-[0.18em] text-accent">
            Stone-ground Haldi
          </span>
        </div>
        {/* Mound SVG */}
        <svg
          viewBox="0 0 200 120"
          className="h-auto w-full"
          role="presentation"
        >
          <defs>
            <linearGradient id="hero-mound" x1="0" y1="0" x2="0" y2="1">
              <stop offset="0%" stopColor="oklch(0.85 0.10 85)" />
              <stop offset="100%" stopColor="oklch(0.62 0.16 65)" />
            </linearGradient>
          </defs>
          <path d="M30 100 Q100 30 170 100 Z" fill="url(#hero-mound)" />
          <path
            d="M50 96 Q100 50 150 96"
            fill="none"
            stroke="oklch(0.96 0.01 85 / 0.55)"
            strokeWidth={2}
          />
          {[
            [80, 80],
            [105, 70],
            [125, 82],
            [95, 88],
            [115, 92],
          ].map(([x, y], i) => (
            <circle key={i} cx={x} cy={y} r={2.5} fill="oklch(0.55 0.16 60)" opacity={0.7} />
          ))}
        </svg>
        {/* Seal badge */}
        <div className="mt-4 flex items-center gap-3 rounded-2xl bg-background/30 px-3 py-2 backdrop-blur">
          <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border-2 border-dashed border-accent/40">
            <span className="text-[0.6rem] font-bold uppercase tracking-wider text-accent">
              Seal
            </span>
          </div>
          <div>
            <p className="text-sm font-bold leading-tight text-accent">
              {company.hero.seal.label}
            </p>
            <p className="text-[0.7rem] uppercase tracking-wider text-accent/70">
              {company.hero.seal.sublabel}
            </p>
          </div>
        </div>
      </motion.div>

      {/* Paint swatch card */}
      <motion.div
        {...driftSlow}
        className="absolute bottom-6 right-0 w-[60%] rotate-[5deg] rounded-3xl charcoal-gradient p-5 shadow-soft"
      >
        <div className="mb-3 flex items-center justify-between">
          <span className="text-xs font-semibold uppercase tracking-[0.18em] text-accent-foreground">
            Premium Paint
          </span>
          <span className="rounded-full bg-primary/20 px-2 py-0.5 text-[0.65rem] font-bold uppercase tracking-wider text-primary">
            Low-VOC
          </span>
        </div>
        {/* Color dots */}
        <div className="mb-3 flex items-center gap-2">
          {[
            "oklch(0.72 0.15 75)",
            "oklch(0.55 0.06 60)",
            "oklch(0.85 0.10 85)",
          ].map((c, i) => (
            <span
              key={i}
              className="h-8 w-8 rounded-full ring-2 ring-white/15"
              style={{ background: c }}
            />
          ))}
          <span className="ml-auto font-display text-xl font-bold text-primary">
            1,200+
          </span>
        </div>
        <p className="text-[0.7rem] uppercase tracking-wider text-muted-foreground">
          shades, lab-matched
        </p>
      </motion.div>

      {/* Floating stat chip */}
      <motion.div
        {...drift}
        className="absolute -left-2 bottom-16 rotate-[-6deg] rounded-full border border-border bg-background px-4 py-2 shadow-soft"
      >
        <div className="flex items-center gap-2">
          <span className="font-display text-lg font-bold text-primary">25+</span>
          <span className="text-[0.7rem] uppercase tracking-wider text-muted-foreground">
            years of craft
          </span>
        </div>
      </motion.div>

      {/* Decorative dotted ring */}
      <div
        className="absolute right-6 top-0 h-20 w-20 rounded-full border-2 border-dashed border-primary/30"
        aria-hidden="true"
      />
    </motion.div>
  )
}
