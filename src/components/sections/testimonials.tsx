"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { Quote } from "lucide-react"
import { Section, SectionHeading } from "@/components/layout/site-shell"
import { Separator } from "@/components/ui/separator"

type Testimonial = {
  quote: string
  name: string
  role: string
  location: string
}

const testimonials: Testimonial[] = [
  {
    quote:
      "The Natural Turmeric Paint let us move back into the nursery the same evening. No smell, no worry. That's the only paint I'll use now.",
    name: "Ananya Sengupta",
    role: "Homeowner",
    location: "Kolkata",
  },
  {
    quote:
      "Coverage figures are honest. What the label says is what I get on the wall. My site supervisors trust Gaurikrit blind.",
    name: "Rakesh Mehta",
    role: "Contractor",
    location: "Pune",
  },
  {
    quote:
      "Haldi sells itself once customers see the curcumin test report. Reorder cycle is under a week. Best margin in the category.",
    name: "Faiyaz Ahmed",
    role: "Retailer",
    location: "Lucknow",
  },
]

export function Testimonials() {
  const reduceMotion = useReducedMotion()

  const container = {
    hidden: {},
    visible: {
      transition: {
        staggerChildren: reduceMotion ? 0 : 0.1,
        delayChildren: 0.05,
      },
    },
  }

  const item = {
    hidden: { opacity: 0, y: reduceMotion ? 0 : 20 },
    visible: {
      opacity: 1,
      y: 0,
      transition: { duration: 0.55, ease: "easeOut" as const },
    },
  }

  return (
    <Section id="testimonials" tone="paper">
      <SectionHeading
        eyebrow="Loved by Homes & Pros"
        title="What families, contractors, and retailers say."
      />
      <motion.div
        variants={container}
        initial="hidden"
        whileInView="visible"
        viewport={{ once: true, margin: "-80px" }}
        className="mt-12 grid gap-6 md:grid-cols-3"
      >
        {testimonials.map((t) => {
          const initial = t.name.charAt(0)
          return (
            <motion.figure
              key={t.name}
              variants={item}
              className="flex h-full flex-col rounded-2xl border bg-card p-6 shadow-soft"
            >
              <Quote
                className="h-10 w-10 text-primary"
                aria-hidden="true"
              />
              <blockquote className="mt-4 flex-1">
                <p className="text-base leading-relaxed text-card-foreground">
                  {t.quote}
                </p>
              </blockquote>
              <Separator className="my-6" />
              <figcaption className="flex items-center gap-3">
                <span
                  className="flex h-11 w-11 shrink-0 items-center justify-center rounded-full gold-gradient font-display text-lg font-bold text-accent"
                  aria-hidden="true"
                >
                  {initial}
                </span>
                <div className="min-w-0">
                  <div className="truncate font-semibold text-card-foreground">
                    {t.name}
                  </div>
                  <div className="text-sm text-muted-foreground">
                    {t.role}, {t.location}
                  </div>
                </div>
              </figcaption>
            </motion.figure>
          )
        })}
      </motion.div>
    </Section>
  )
}
