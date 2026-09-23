"use client"

import * as React from "react"
import { motion, useReducedMotion, type Variants } from "framer-motion"
import { Sparkles, Hammer, ShieldCheck } from "lucide-react"
import { company } from "@/lib/data"
import { cn } from "@/lib/utils"
import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"

const EASE = [0.22, 1, 0.36, 1] as const

const cardIcons = [Sparkles, Hammer, ShieldCheck] as const

export function About() {
  const reduceMotion = useReducedMotion()

  const containerVariants: Variants = {
    hidden: {},
    show: {
      transition: {
        delayChildren: reduceMotion ? 0 : 0.08,
        staggerChildren: reduceMotion ? 0 : 0.12,
      },
    },
  }

  const itemVariants: Variants = {
    hidden: reduceMotion ? { opacity: 1 } : { opacity: 0, y: 24 },
    show: {
      opacity: 1,
      y: 0,
      transition: { duration: reduceMotion ? 0 : 0.6, ease: EASE },
    },
  }

  const paragraphs = React.useMemo(
    () => company.story.body.split("\n\n"),
    []
  )

  return (
    <Section id="about" tone="paper" className="scroll-mt-20">
      <SectionHeading
        eyebrow="Our Story"
        title="Haldi and paint, crafted by the same hands."
        description={company.story.lead}
        align="center"
      />

      {/* Two-column body */}
      <motion.div
        variants={containerVariants}
        initial="hidden"
        whileInView="show"
        viewport={{ once: true, amount: 0.25 }}
        className="mt-14 grid gap-12 lg:grid-cols-2 lg:gap-12 lg:items-stretch"
      >
        {/* LEFT — image collage */}
        <motion.div variants={itemVariants} className="relative">
          <AboutCollage reduceMotion={!!reduceMotion} />
        </motion.div>

        {/* RIGHT — body copy + quote */}
        <motion.div
          variants={itemVariants}
          className="flex flex-col justify-center"
        >
          <div className="space-y-5 text-base leading-relaxed text-muted-foreground md:text-lg">
            {paragraphs.map((p, i) => (
              <p key={i}>{p}</p>
            ))}
          </div>

          {/* Founder quote card */}
          <figure className="mt-8 overflow-hidden rounded-2xl border border-primary/20 bg-secondary p-6 shadow-soft md:p-8">
            <div
              aria-hidden="true"
              className="font-display text-5xl leading-none text-primary/30"
            >
              &ldquo;
            </div>
            <blockquote
              className="-mt-4 font-display text-lg italic leading-relaxed text-foreground md:text-xl"
            >
              {company.story.founderQuote}
            </blockquote>
            <figcaption className="mt-4 flex items-center gap-3">
              <span
                className="flex h-9 w-9 items-center justify-center rounded-full gold-gradient text-xs font-bold text-accent"
                aria-hidden="true"
              >
                {company.story.founderName.charAt(0)}
              </span>
              <div>
                <p className="text-sm font-semibold text-foreground">
                  {company.story.founderName}
                </p>
                <p className="text-xs uppercase tracking-wider text-muted-foreground">
                  {company.story.founderRole}
                </p>
              </div>
            </figcaption>
          </figure>
        </motion.div>
      </motion.div>

      {/* Mini-cards */}
      <motion.div
        variants={containerVariants}
        initial="hidden"
        whileInView="show"
        viewport={{ once: true, amount: 0.3 }}
        className="mt-14 grid gap-5 md:grid-cols-3 md:mt-16"
      >
        {company.aboutCards.map((card, i) => {
          const Icon = cardIcons[i] ?? Sparkles
          return (
            <motion.div
              key={card.title}
              variants={itemVariants}
              whileHover={reduceMotion ? undefined : { y: -4 }}
              transition={{ duration: 0.25, ease: EASE }}
              className={cn(
                "group rounded-2xl border border-border bg-card p-6 shadow-soft transition-colors",
                "hover:border-primary/40 hover:shadow-gold"
              )}
            >
              <span
                className="mb-4 flex h-11 w-11 items-center justify-center rounded-xl gold-gradient text-accent shadow-gold"
                aria-hidden="true"
              >
                <Icon className="h-5 w-5" />
              </span>
              <h3 className="font-display text-lg font-bold text-foreground">
                {card.title}
              </h3>
              <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
                {card.desc}
              </p>
            </motion.div>
          )
        })}
      </motion.div>
    </Section>
  )
}

/* -------------------------------------------------------------------------- */
/* About collage — turmeric root SVG + "Since 1998" + paint swatch            */
/* -------------------------------------------------------------------------- */

function AboutCollage({ reduceMotion }: { reduceMotion: boolean }) {
  return (
    <div className="relative mx-auto h-[420px] w-full max-w-[480px] md:h-[480px]">
      {/* Main gold-tinted panel with turmeric root illustration */}
      <motion.div
        initial={reduceMotion ? undefined : { opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: reduceMotion ? 0 : 0.7, ease: EASE }}
        whileHover={reduceMotion ? undefined : { y: -4 }}
        className="absolute inset-0 overflow-hidden rounded-2xl border border-primary/20 bg-secondary shadow-soft"
      >
        {/* Soft glow */}
        <div
          aria-hidden="true"
          className="pointer-events-none absolute inset-0"
          style={{
            background:
              "radial-gradient(50% 40% at 50% 30%, oklch(0.72 0.15 75 / 0.18), transparent)",
          }}
        />
        {/* Turmeric root SVG */}
        <svg
          viewBox="0 0 360 360"
          className="absolute inset-0 h-full w-full"
          role="img"
          aria-label="Stylised turmeric root illustration"
        >
          <defs>
            <linearGradient id="about-root" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stopColor="oklch(0.85 0.10 85)" />
              <stop offset="55%" stopColor="oklch(0.72 0.15 75)" />
              <stop offset="100%" stopColor="oklch(0.55 0.16 65)" />
            </linearGradient>
            <linearGradient id="about-root-2" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0%" stopColor="oklch(0.80 0.13 80)" />
              <stop offset="100%" stopColor="oklch(0.60 0.16 65)" />
            </linearGradient>
          </defs>

          {/* Main root body — curving finger shape */}
          <path
            d="M180 70 C 210 90 215 130 200 165 C 188 195 195 225 215 245 C 230 260 240 285 230 305 C 220 320 195 322 180 308 C 165 295 168 270 175 250 C 182 228 178 200 168 178 C 158 156 150 130 165 105 C 170 95 175 80 180 70 Z"
            fill="url(#about-root)"
          />
          {/* Secondary root — smaller finger */}
          <path
            d="M250 130 C 270 145 275 170 263 195 C 253 215 258 240 275 258 C 287 270 290 290 280 302 C 270 312 250 308 245 295 C 240 280 248 265 255 250 C 262 232 262 215 255 198 C 248 180 240 160 245 142 C 247 136 248 132 250 130 Z"
            fill="url(#about-root-2)"
            opacity={0.92}
          />
          {/* Knob rings on main root */}
          <ellipse
            cx="195"
            cy="160"
            rx="14"
            ry="3"
            fill="oklch(0.45 0.16 60)"
            opacity={0.35}
          />
          <ellipse
            cx="200"
            cy="220"
            rx="12"
            ry="3"
            fill="oklch(0.45 0.16 60)"
            opacity={0.35}
          />
          {/* Taper tip */}
          <path
            d="M225 305 C 232 312 235 318 230 325 C 225 330 218 326 218 318 C 218 312 222 308 225 305 Z"
            fill="oklch(0.55 0.16 65)"
          />
          {/* Highlight stripe */}
          <path
            d="M180 90 C 195 110 195 140 185 165 C 178 185 180 210 188 232"
            fill="none"
            stroke="oklch(0.96 0.01 85 / 0.45)"
            strokeWidth={3}
            strokeLinecap="round"
          />
          {/* Sprinkled spice dots around base */}
          {[
            [80, 320],
            [110, 330],
            [140, 325],
            [300, 320],
            [275, 332],
            [240, 328],
            [60, 305],
            [320, 305],
          ].map(([x, y], i) => (
            <circle
              key={i}
              cx={x}
              cy={y}
              r={3.5}
              fill="oklch(0.72 0.15 75)"
              opacity={0.7}
            />
          ))}
          {/* Caption tag */}
          <text
            x="180"
            y="48"
            textAnchor="middle"
            fontFamily="serif"
            fontSize="13"
            fontWeight="700"
            letterSpacing="0.18em"
            fill="oklch(0.55 0.16 65)"
          >
            CURCUMA LONGA
          </text>
        </svg>
      </motion.div>

      {/* Overlapping "Since 1998" charcoal card */}
      <motion.div
        initial={reduceMotion ? undefined : { opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: reduceMotion ? 0 : 0.7, delay: reduceMotion ? 0 : 0.15, ease: EASE }}
        whileHover={reduceMotion ? undefined : { y: -4 }}
        className="absolute -bottom-6 -left-3 w-[44%] rotate-[-3deg] rounded-2xl charcoal-gradient p-4 shadow-soft md:-left-6 md:p-5"
      >
        <p className="text-[0.65rem] font-semibold uppercase tracking-[0.2em] text-primary">
          Established
        </p>
        <p className="mt-1 font-display text-3xl font-bold leading-none text-accent-foreground md:text-4xl">
          1998
        </p>
        <p className="mt-1 text-[0.7rem] uppercase tracking-wider text-muted-foreground">
          Kolkata, India
        </p>
      </motion.div>

      {/* Floating paint swatch chip */}
      <motion.div
        initial={reduceMotion ? undefined : { opacity: 0, y: 20 }}
        whileInView={{ opacity: 1, y: 0 }}
        viewport={{ once: true }}
        transition={{ duration: reduceMotion ? 0 : 0.7, delay: reduceMotion ? 0 : 0.3, ease: EASE }}
        whileHover={reduceMotion ? undefined : { y: -4 }}
        className="absolute -top-4 -right-3 w-[42%] rotate-[4deg] rounded-2xl border border-border bg-card p-3 shadow-soft md:-right-6 md:p-4"
      >
        <p className="text-[0.6rem] font-semibold uppercase tracking-[0.18em] text-muted-foreground">
          Shade
        </p>
        <div className="mt-2 flex gap-1.5">
          {[
            "oklch(0.72 0.15 75)",
            "oklch(0.55 0.06 60)",
            "oklch(0.85 0.10 85)",
          ].map((c, i) => (
            <span
              key={i}
              className="h-6 w-6 rounded-full ring-2 ring-white/60"
              style={{ background: c }}
            />
          ))}
        </div>
        <p className="mt-2 font-display text-sm font-bold text-foreground">
          1,200+ shades
        </p>
      </motion.div>
    </div>
  )
}
