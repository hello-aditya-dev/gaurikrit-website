"use client"

import * as React from "react"
import { motion, useReducedMotion, type Variants } from "framer-motion"
import { BadgeCheck } from "lucide-react"
import { company } from "@/lib/data"
import { cn } from "@/lib/utils"
import { CountUp } from "@/components/common/count-up"

const EASE = [0.22, 1, 0.36, 1] as const

export function TrustBar() {
  const reduceMotion = useReducedMotion()

  const containerVariants: Variants = {
    hidden: {},
    show: {
      transition: {
        delayChildren: reduceMotion ? 0 : 0.05,
        staggerChildren: reduceMotion ? 0 : 0.08,
      },
    },
  }

  const itemVariants: Variants = {
    hidden: reduceMotion ? { opacity: 1 } : { opacity: 0, y: 16 },
    show: {
      opacity: 1,
      y: 0,
      transition: { duration: reduceMotion ? 0 : 0.55, ease: EASE },
    },
  }

  return (
    <section
      aria-label="Trust and certifications"
      className="bg-accent text-accent-foreground"
    >
      <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 md:py-16 lg:px-8">
        {/* Stats */}
        <motion.ul
          variants={containerVariants}
          initial="hidden"
          whileInView="show"
          viewport={{ once: true, amount: 0.3 }}
          className="grid grid-cols-2 gap-px overflow-hidden rounded-2xl bg-white/5 md:grid-cols-4"
        >
          {company.stats.map((stat, i) => {
            const hasNumeric =
              typeof stat.numericValue === "number" && !Number.isNaN(stat.numericValue)
            return (
              <motion.li
                key={stat.label}
                variants={itemVariants}
                className={cn(
                  "flex flex-col items-center justify-center bg-accent px-4 py-6 text-center md:py-8",
                  i % 2 === 0 && "md:border-l-0"
                )}
              >
                <p className="font-display text-3xl font-bold tracking-tight text-primary md:text-4xl">
                  {hasNumeric ? (
                    <CountUp
                      value={stat.numericValue as number}
                      suffix={stat.suffix}
                      prefix={stat.prefix}
                      decimals={stat.decimals}
                    />
                  ) : (
                    stat.value
                  )}
                </p>
                <p className="mt-1.5 text-xs font-medium uppercase tracking-[0.18em] text-muted-foreground">
                  {stat.label}
                </p>
              </motion.li>
            )
          })}
        </motion.ul>

        {/* Certifications */}
        <motion.div
          variants={containerVariants}
          initial="hidden"
          whileInView="show"
          viewport={{ once: true, amount: 0.3 }}
          className="mt-8 flex flex-wrap items-center justify-center gap-3 md:mt-10"
        >
          <span className="text-xs font-semibold uppercase tracking-[0.2em] text-muted-foreground/80">
            Accredited by
          </span>
          {company.certifications.map((cert) => (
            <motion.div
              key={cert.name}
              variants={itemVariants}
              className="flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur transition-colors hover:border-primary/40"
            >
              <BadgeCheck className="h-4 w-4 text-primary" aria-hidden="true" />
              <span className="text-sm font-bold text-accent-foreground">
                {cert.name}
              </span>
              <span className="text-xs text-muted-foreground">·</span>
              <span className="text-xs text-muted-foreground">{cert.desc}</span>
            </motion.div>
          ))}
        </motion.div>
      </div>
    </section>
  )
}
