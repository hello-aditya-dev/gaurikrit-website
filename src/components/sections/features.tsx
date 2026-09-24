"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import {
  Leaf,
  FlaskConical,
  Ruler,
  Wind,
  BookOpen,
  Truck,
  type LucideIcon,
} from "lucide-react"
import { Section, SectionHeading } from "@/components/layout/site-shell"

type Feature = {
  title: string
  description: string
  Icon: LucideIcon
}

const features: Feature[] = [
  {
    title: "Naturally Crafted",
    description: "Stone-ground turmeric, small-batch paint, no shortcuts.",
    Icon: Leaf,
  },
  {
    title: "Lab-Tested Purity",
    description: "Every batch screened for curcumin, heavy metals, and VOC.",
    Icon: FlaskConical,
  },
  {
    title: "100% Coverage",
    description: "Tested coverage figures published for every paint product.",
    Icon: Ruler,
  },
  {
    title: "Low-VOC Paints",
    description:
      "Interior under 50 g/L, natural paint under 5 g/L. Move in same day.",
    Icon: Wind,
  },
  {
    title: "Heritage Recipe",
    description: "Four generations of craft, documented and audited.",
    Icon: BookOpen,
  },
  {
    title: "Pan-India Delivery",
    description: "14,000+ pin-codes served, tracked from our Kolkata hub.",
    Icon: Truck,
  },
]

export function Features() {
  const reduceMotion = useReducedMotion()

  const container = {
    hidden: {},
    visible: {
      transition: {
        staggerChildren: reduceMotion ? 0 : 0.08,
        delayChildren: 0.05,
      },
    },
  }

  const item = {
    hidden: { opacity: 0, y: reduceMotion ? 0 : 18 },
    visible: {
      opacity: 1,
      y: 0,
      transition: { duration: 0.55, ease: "easeOut" as const },
    },
  }

  return (
    <Section id="features" tone="gold-tint">
      <SectionHeading
        eyebrow="Why Gaurikrit"
        title="Six reasons families and contractors trust us."
        description="From field to shelf, every step is built to earn trust."
      />
      <motion.ul
        variants={container}
        initial="hidden"
        whileInView="visible"
        viewport={{ once: true, margin: "-80px" }}
        className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3"
      >
        {features.map(({ title, description, Icon }) => (
          <motion.li key={title} variants={item}>
            <article className="flex h-full flex-col rounded-2xl border bg-card p-6 shadow-soft transition-all hover:-translate-y-1 hover:shadow-xl">
              <div
                className="mb-5 flex h-12 w-12 items-center justify-center rounded-full bg-primary/10"
                aria-hidden="true"
              >
                <Icon className="h-6 w-6 text-primary" aria-hidden="true" />
              </div>
              <h3 className="font-display text-lg font-bold text-card-foreground">
                {title}
              </h3>
              <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
                {description}
              </p>
            </article>
          </motion.li>
        ))}
      </motion.ul>
    </Section>
  )
}
