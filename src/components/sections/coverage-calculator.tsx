"use client"

import * as React from "react"
import { motion, useReducedMotion, AnimatePresence } from "framer-motion"
import { Calculator, Ruler, PaintBucket, IndianRupee, RotateCcw, Info } from "lucide-react"
import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Badge } from "@/components/ui/badge"
import { Separator } from "@/components/ui/separator"
import {
  PAINT_SPECS,
  estimatePaint,
  formatINR,
  type PaintSpec,
} from "@/lib/paint-calculator"
import { track } from "@/lib/analytics"
import { cn } from "@/lib/utils"

const EASE = [0.22, 1, 0.36, 1] as const

type Surface = "walls" | "ceiling" | "compound"

const SURFACES: { id: Surface; label: string; hint: string }[] = [
  { id: "walls", label: "Interior walls", hint: "Bedrooms, living rooms" },
  { id: "ceiling", label: "Ceiling", hint: "Flat overhead" },
  { id: "compound", label: "Exterior / compound", hint: "Outdoor walls" },
]

export function CoverageCalculator() {
  const reduceMotion = useReducedMotion()
  const [area, setArea] = React.useState<string>("500")
  const [surface, setSurface] = React.useState<Surface>("walls")
  const [selectedId, setSelectedId] = React.useState<string>("paint-interior")
  const [includePrimer, setIncludePrimer] = React.useState(true)
  const [computed, setComputed] = React.useState(false)

  const areaNum = Math.max(0, Number(area) || 0)
  const spec = PAINT_SPECS.find((s) => s.id === selectedId) ?? PAINT_SPECS[0]

  const result = React.useMemo(() => {
    if (areaNum <= 0) return null
    return estimatePaint(areaNum, spec, includePrimer)
  }, [areaNum, spec, includePrimer])

  const onCalculate = () => {
    setComputed(true)
    track("coverage_calculate", {
      area: areaNum,
      surface,
      productId: spec.id,
      includePrimer,
      totalLitres: result?.totalLitres ?? 0,
      totalCost: result?.totalCost ?? 0,
    })
  }

  const onReset = () => {
    setArea("500")
    setSurface("walls")
    setSelectedId("paint-interior")
    setIncludePrimer(true)
    setComputed(false)
  }

  return (
    <Section id="calculator" tone="charcoal" className="overflow-hidden">
      {/* decorative gold glow */}
      <div
        aria-hidden="true"
        className="pointer-events-none absolute inset-0 -z-0"
        style={{
          background:
            "radial-gradient(50% 50% at 85% 15%, oklch(0.72 0.15 75 / 0.12), transparent 70%)",
        }}
      />
      <SectionHeading
        tone="on-charcoal"
        eyebrow="Plan your project"
        title="Coverage calculator"
        description="Enter your wall area and pick a paint. We'll estimate the litres, primer, and indicative cost — based on our lab-tested coverage figures."
      />

      <div className="mt-10 grid gap-6 lg:grid-cols-[1fr_1.1fr] lg:gap-8">
        {/* INPUT PANEL */}
        <div className="rounded-3xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-sm md:p-8">
          {/* Area */}
          <div className="space-y-2">
            <Label htmlFor="area" className="flex items-center gap-2 text-sm font-medium text-accent-foreground">
              <Ruler className="h-4 w-4 text-primary" />
              Wall area (sq ft)
            </Label>
            <Input
              id="area"
              type="number"
              inputMode="numeric"
              min={0}
              value={area}
              onChange={(e) => setArea(e.target.value)}
              placeholder="e.g. 500"
              className="h-12 border-white/15 bg-white/5 text-lg font-semibold text-accent-foreground placeholder:text-muted-foreground/60"
            />
            <p className="text-xs text-muted-foreground">
              Tip: length × height of all walls, minus doors/windows (approx 15%).
            </p>
          </div>

          {/* Surface type */}
          <div className="mt-6 space-y-2">
            <Label className="text-sm font-medium text-accent-foreground">Surface</Label>
            <div className="grid grid-cols-3 gap-2">
              {SURFACES.map((s) => (
                <button
                  key={s.id}
                  type="button"
                  onClick={() => setSurface(s.id)}
                  aria-pressed={surface === s.id}
                  className={cn(
                    "rounded-xl border px-3 py-2.5 text-left transition-all",
                    surface === s.id
                      ? "border-primary bg-primary/15"
                      : "border-white/10 bg-white/[0.03] hover:border-primary/50"
                  )}
                >
                  <span
                    className={cn(
                      "block text-xs font-semibold",
                      surface === s.id ? "text-primary" : "text-accent-foreground"
                    )}
                  >
                    {s.label}
                  </span>
                  <span className="mt-0.5 block text-[10px] text-muted-foreground">
                    {s.hint}
                  </span>
                </button>
              ))}
            </div>
          </div>

          {/* Paint picker */}
          <div className="mt-6 space-y-2">
            <Label className="text-sm font-medium text-accent-foreground">Paint product</Label>
            <div className="grid gap-2">
              {PAINT_SPECS.filter((s) => s.id !== "paint-primer").map((s) => (
                <button
                  key={s.id}
                  type="button"
                  onClick={() => setSelectedId(s.id)}
                  aria-pressed={selectedId === s.id}
                  className={cn(
                    "flex items-center justify-between rounded-xl border px-4 py-3 transition-all",
                    selectedId === s.id
                      ? "border-primary bg-primary/15"
                      : "border-white/10 bg-white/[0.03] hover:border-primary/50"
                  )}
                >
                  <span className="flex flex-col items-start">
                    <span
                      className={cn(
                        "text-sm font-semibold",
                        selectedId === s.id ? "text-primary" : "text-accent-foreground"
                      )}
                    >
                      {s.name}
                    </span>
                    <span className="text-[10px] text-muted-foreground">
                      {s.coverage} sq ft/L/coat · {s.coats} coats
                    </span>
                  </span>
                  {s.id === "paint-natural" ? (
                    <Badge className="gold-gradient text-accent">Featured</Badge>
                  ) : null}
                </button>
              ))}
            </div>
          </div>

          {/* Primer toggle */}
          <div className="mt-6 flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3">
            <div className="flex items-center gap-2">
              <Info className="h-4 w-4 text-primary" />
              <div>
                <p className="text-sm font-medium text-accent-foreground">Include primer coat</p>
                <p className="text-[10px] text-muted-foreground">Recommended on fresh plaster</p>
              </div>
            </div>
            <button
              type="button"
              role="switch"
              aria-checked={includePrimer}
              onClick={() => setIncludePrimer((v) => !v)}
              className={cn(
                "relative h-6 w-11 rounded-full transition-colors",
                includePrimer ? "bg-primary" : "bg-white/15"
              )}
            >
              <span
                className={cn(
                  "absolute top-0.5 h-5 w-5 rounded-full bg-background transition-transform",
                  includePrimer ? "translate-x-5" : "translate-x-0.5"
                )}
              />
            </button>
          </div>

          {/* Actions */}
          <div className="mt-6 flex gap-3">
            <Button
              type="button"
              onClick={onCalculate}
              className="flex-1 rounded-full gold-gradient text-accent shadow-gold hover:opacity-95"
              size="lg"
            >
              <Calculator className="h-4 w-4" />
              Calculate
            </Button>
            <Button
              type="button"
              variant="ghost"
              onClick={onReset}
              aria-label="Reset calculator"
              className="border border-white/10 text-accent-foreground hover:bg-white/5"
            >
              <RotateCcw className="h-4 w-4" />
            </Button>
          </div>
        </div>

        {/* RESULT PANEL */}
        <div className="relative rounded-3xl border border-primary/30 bg-background p-6 shadow-gold md:p-8">
          <AnimatePresence mode="wait">
            {result && computed ? (
              <motion.div
                key="result"
                initial={reduceMotion ? false : { opacity: 0, y: 12 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 0.35, ease: EASE }}
              >
                <div className="mb-5 flex items-center justify-between">
                  <div className="flex items-center gap-2">
                    <span className="flex h-9 w-9 items-center justify-center rounded-full gold-gradient text-accent shadow-gold">
                      <PaintBucket className="h-4 w-4" />
                    </span>
                    <div>
                      <p className="text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                        Your estimate
                      </p>
                      <p className="font-display text-sm font-bold text-foreground">{spec.name}</p>
                    </div>
                  </div>
                  <Badge variant="secondary" className="font-mono">
                    {areaNum} sq ft
                  </Badge>
                </div>

                {/* Headline: total litres */}
                <div className="rounded-2xl bg-secondary/60 p-5 text-center">
                  <p className="text-xs font-semibold uppercase tracking-[0.18em] text-muted-foreground">
                    Paint needed
                  </p>
                  <p className="mt-1 font-display text-5xl font-bold text-foreground">
                    {result.totalLitres}
                    <span className="ml-1 text-xl text-muted-foreground">L</span>
                  </p>
                  <div className="mt-2 flex justify-center gap-4 text-xs text-muted-foreground">
                    <span>
                      <span className="font-semibold text-foreground">{result.topcoatLitres}L</span> topcoat
                    </span>
                    {result.primerLitres > 0 ? (
                      <span>
                        <span className="font-semibold text-foreground">{result.primerLitres}L</span> primer
                      </span>
                    ) : null}
                  </div>
                </div>

                {/* Buckets */}
                {result.buckets.length > 0 ? (
                  <div className="mt-4">
                    <p className="mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                      Suggested packs
                    </p>
                    <div className="flex flex-wrap gap-2">
                      {result.buckets.map((b) => (
                        <span
                          key={b.size}
                          className="inline-flex items-center gap-1.5 rounded-full border bg-card px-3 py-1.5 text-sm font-medium text-foreground"
                        >
                          <PaintBucket className="h-3.5 w-3.5 text-primary" />
                          {b.qty} × {b.size}L
                        </span>
                      ))}
                    </div>
                  </div>
                ) : null}

                <Separator className="my-5" />

                {/* Cost */}
                <div className="space-y-2">
                  <div className="flex items-center justify-between text-sm">
                    <span className="text-muted-foreground">Topcoat ({result.topcoatLitres}L)</span>
                    <span className="font-medium text-foreground flex items-center">
                      <IndianRupee className="h-3.5 w-3.5" />
                      {result.topcoatCost.toLocaleString("en-IN")}
                    </span>
                  </div>
                  {result.primerCost > 0 ? (
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-muted-foreground">Primer ({result.primerLitres}L)</span>
                      <span className="font-medium text-foreground flex items-center">
                        <IndianRupee className="h-3.5 w-3.5" />
                        {result.primerCost.toLocaleString("en-IN")}
                      </span>
                    </div>
                  ) : null}
                  <div className="flex items-center justify-between border-t border-border pt-3">
                    <span className="text-sm font-semibold text-foreground">Indicative total</span>
                    <span className="font-display text-2xl font-bold text-primary flex items-center">
                      {formatINR(result.totalCost)}
                    </span>
                  </div>
                  <p className="pt-1 text-[10px] text-muted-foreground">
                    * Indicative only. Final quote via the contact form. Wastage buffer of 10% included.
                  </p>
                </div>

                {/* CTA */}
                <Button
                  asChild
                  className="mt-6 w-full rounded-full gold-gradient text-accent shadow-gold hover:opacity-95"
                >
                  <a href="#contact" onClick={() => track("calculator_enquire", { productId: spec.id, area: areaNum })}>
                    Get an exact quote
                  </a>
                </Button>
              </motion.div>
            ) : (
              <motion.div
                key="empty"
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                exit={{ opacity: 0 }}
                className="flex h-full flex-col items-center justify-center py-16 text-center"
              >
                <span className="flex h-16 w-16 items-center justify-center rounded-full bg-secondary">
                  <Calculator className="h-8 w-8 text-primary" />
                </span>
                <p className="mt-4 font-display text-lg font-bold text-foreground">
                  Your estimate will appear here
                </p>
                <p className="mt-1 max-w-xs text-sm text-muted-foreground">
                  Enter your wall area, choose a paint, and tap Calculate.
                </p>
              </motion.div>
            )}
          </AnimatePresence>
        </div>
      </div>
    </Section>
  )
}
