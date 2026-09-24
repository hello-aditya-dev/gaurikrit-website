"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"

import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"
import {
  Accordion,
  AccordionContent,
  AccordionItem,
  AccordionTrigger,
} from "@/components/ui/accordion"
import { cn } from "@/lib/utils"

interface FaqItem {
  q: string
  a: string
}

const faqItems: FaqItem[] = [
  {
    q: "Is your turmeric really free of additives?",
    a: "Yes. No added colour, no fillers, no preservatives, no irradiation. Every batch is FSSAI-compliant and third-party audited. See claim ref FSSAI/GK-2024-118 in the register below.",
  },
  {
    q: "What does 'curcumin 4.5%+' mean?",
    a: "Curcumin is turmeric's main active compound. Our Pure Turmeric Powder is standardised to a minimum 4.5% curcumin, batch-tested by HPLC at a NABL-accredited lab.",
  },
  {
    q: "Is the Natural Turmeric Paint safe for a baby's room?",
    a: "Yes. It's lime-based, tinted only with plant and mineral pigments, with VOC under 5 g/L. You can move back into the room the same day it's painted. It carries the GreenPro ecolabel.",
  },
  {
    q: "What coverage will I actually get?",
    a: "Interior emulsion ~140 sq ft/L/coat, primer ~160 sq ft/L/coat, exterior ~120 sq ft/L/coat. These are tested figures, not marketing numbers. Find them in the Claims Register.",
  },
  {
    q: "Do you deliver across India?",
    a: "Yes — we ship to 14,000+ pin-codes from our Kolkata hub. Tracking is shared on dispatch. Bulk/project enquiries get a dedicated coordinator.",
  },
  {
    q: "Can I see the lab reports?",
    a: "Of course. Every claim in the register links to a reference number. Write to hello@gaurikrit.in with the reference ID and we'll share the corresponding report.",
  },
  {
    q: "Are your paints really lead-free?",
    a: "Yes. No lead or lead-based driers in any paint product. Verified by BIS lead-content testing — ref GK-PB-2024-009.",
  },
  {
    q: "How do I become a retailer or project partner?",
    a: "Use the contact form below and select 'Partnership' as the interest. Our partnerships team responds within one business day.",
  },
]

export function Faq() {
  const prefersReducedMotion = useReducedMotion()

  const revealProps = prefersReducedMotion
    ? {}
    : {
        initial: { opacity: 0, y: 24 },
        whileInView: { opacity: 1, y: 0 },
        viewport: { once: true, margin: "-80px" },
        transition: { duration: 0.6, ease: "easeOut" as const },
      }

  return (
    <Section id="faq" tone="gold-tint">
      <SectionHeading
        eyebrow="Questions"
        title="Before you ask."
        description="Straight answers to the questions we hear most. If something is still unclear, write to us — we read every message."
      />

      <motion.div
        className="mx-auto mt-10 max-w-5xl"
        {...revealProps}
      >
        <Accordion
          type="single"
          collapsible
          className={cn(
            "grid gap-3 lg:grid-cols-2 lg:gap-4"
          )}
        >
          {faqItems.map((item, idx) => (
            <AccordionItem
              key={item.q}
              value={`faq-${idx}`}
              className="rounded-xl border bg-card px-4 shadow-soft"
            >
              <AccordionTrigger className="text-left text-base font-medium text-foreground hover:no-underline">
                {item.q}
              </AccordionTrigger>
              <AccordionContent className="text-sm leading-relaxed text-muted-foreground">
                {item.a}
              </AccordionContent>
            </AccordionItem>
          ))}
        </Accordion>
      </motion.div>
    </Section>
  )
}

export default Faq
