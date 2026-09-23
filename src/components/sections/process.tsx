"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import {
  Sprout,
  Hammer,
  FlaskConical,
  Truck,
  type LucideIcon,
} from "lucide-react"
import { Section, SectionHeading } from "@/components/layout/site-shell"

type Step = {
  numeral: string
  title: string
  description: string
  Icon: LucideIcon
}

const steps: Step[] = [
  {
    numeral: "01",
    title: "Source",
    description: "Single-origin turmeric, tested raw materials for paint.",
    Icon: Sprout,
  },
  {
    numeral: "02",
    title: "Craft",
    description: "Stone-ground haldi, small-batch milled paint.",
    Icon: Hammer,
  },
  {
    numeral: "03",
    title: "Test",
    description: "NABL lab screens every batch before it ships.",
    Icon: FlaskConical,
  },
  {
    numeral: "04",
    title: "Deliver",
    description: "Tracked dispatch to 14,000+ pin-codes.",
    Icon: Truck,
  },
]

export function Process() {
  const reduceMotion = useReducedMotion()

  const container = {
    hidden: {},
    visible: {
      transition: {
        staggerChildren: reduceMotion ? 0 : 0.12,
        delayChildren: 0.05,
      },
    },
  }

  const item = {
    hidden: { opacity: 0, y: reduceMotion ? 0 : 22 },
    visible: {
      opacity: 1,
      y: 0,
      transition: { duration: 0.55, ease: "easeOut" as const },
    },
  }

  return (
    <Section tone="charcoal">
      <SectionHeading
        tone="on-charcoal"
        eyebrow="The Craft"
        title="From field to your home, in four steps."
        description="Every Gaurikrit product follows the same disciplined path."
      />
      <motion.div
        variants={container}
        initial="hidden"
        whileInView="visible"
        viewport={{ once: true, margin: "-80px" }}
        className="relative mt-14"
      >
        {/* Desktop connector line — sits at the numeral mid-height,
            visible in the gaps between cards (cards render above it). */}
        <div
          aria-hidden="true"
          className="pointer-events-none absolute left-0 right-0 top-12 hidden border-t-2 border-dashed border-primary/40 lg:block"
        />
        <ol className="relative grid gap-6 md:grid-cols-2 lg:grid-cols-4">
          {steps.map(({ numeral, title, description, Icon }) => (
            <motion.li
              key={numeral}
              variants={item}
              className="relative flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-sm"
            >
              <div className="mb-4 flex items-center gap-3">
                <span
                  className="font-display text-5xl font-bold leading-none text-primary"
                  aria-hidden="true"
                >
                  {numeral}
                </span>
                <span
                  className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10"
                  aria-hidden="true"
                >
                  <Icon className="h-5 w-5 text-primary" aria-hidden="true" />
                </span>
              </div>
              <h3 className="font-display text-lg font-bold text-accent-foreground">
                {title}
              </h3>
              <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
                {description}
              </p>
            </motion.li>
          ))}
        </ol>
      </motion.div>
    </Section>
  )
}
