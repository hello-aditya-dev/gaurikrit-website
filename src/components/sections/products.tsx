"use client"

import * as React from "react"
import { AnimatePresence, motion, useReducedMotion } from "framer-motion"

import { cn } from "@/lib/utils"
import { productsData } from "@/lib/data"
import type { Product } from "@/types"
import { track } from "@/lib/analytics"
import {
  Section,
  SectionHeading,
} from "@/components/layout/site-shell"
import { ProductCard } from "@/components/product/product-card"
import { ProductDialog } from "@/components/product/product-dialog"
import { CompareBar } from "@/components/product/compare-bar"
import { CompareDialog } from "@/components/product/compare-dialog"
import { useCompareStore } from "@/lib/compare-store"

export function Products() {
  const reduce = useReducedMotion()
  const [active, setActive] = React.useState("all")
  const [selected, setSelected] = React.useState<Product | null>(null)
  const [dialogOpen, setDialogOpen] = React.useState(false)
  const [compareOpen, setCompareOpen] = React.useState(false)
  const compareIds = useCompareStore((s) => s.ids)

  const categories = productsData.categories
  const items = React.useMemo(() => {
    if (active === "all") return productsData.items
    return productsData.items.filter((p) => p.category === active)
  }, [active])

  const handleOpen = React.useCallback((product: Product) => {
    setSelected(product)
    setDialogOpen(true)
    track("product_view", { productId: product.id, productName: product.name })
  }, [])

  const handleEnquireFromCompare = React.useCallback((product: Product) => {
    // mirror the ProductDialog enquire flow: dispatch inquiry event + scroll
    if (typeof window !== "undefined") {
      window.dispatchEvent(
        new CustomEvent("gaurikrit:inquiry", {
          detail: { productId: product.id, productName: product.name },
        })
      )
      window.setTimeout(() => {
        document
          .getElementById("contact")
          ?.scrollIntoView({ behavior: "smooth", block: "start" })
      }, 60)
    }
  }, [])

  return (
    <Section id="products" tone="paper" className="bg-grain">
      <SectionHeading
        eyebrow="Our Craft"
        title="Two crafts, one discipline."
        description="Naturally crafted haldi and lab-tested, premium paint — explore the full Gaurikrit range. Select up to 3 to compare side by side."
      />

      {/* Filter tabs */}
      <div className="mt-8 flex justify-center">
        <div
          role="tablist"
          aria-label="Filter products by category"
          className="inline-flex items-center gap-1 rounded-full border bg-card p-1 shadow-soft"
        >
          {categories.map((c) => {
            const isActive = active === c.id
            return (
              <button
                key={c.id}
                role="tab"
                aria-selected={isActive}
                type="button"
                onClick={() => setActive(c.id)}
                className={cn(
                  "relative inline-flex items-center rounded-full px-4 py-2 text-xs font-semibold uppercase tracking-[0.14em] transition-colors sm:text-sm",
                  isActive
                    ? "text-primary-foreground"
                    : "text-muted-foreground hover:text-foreground"
                )}
              >
                {isActive ? (
                  <motion.span
                    layoutId="products-tab-pill"
                    className="absolute inset-0 -z-10 rounded-full gold-gradient shadow-gold"
                    transition={
                      reduce
                        ? { duration: 0 }
                        : { type: "spring", stiffness: 380, damping: 32 }
                    }
                  />
                ) : null}
                {c.label}
              </button>
            )
          })}
        </div>
      </div>

      {/* Grid */}
      <div className="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <AnimatePresence mode="popLayout">
          {items.map((p) => (
            <motion.div
              key={p.id}
              layout
              initial={reduce ? undefined : { opacity: 0, scale: 0.92 }}
              animate={reduce ? undefined : { opacity: 1, scale: 1 }}
              exit={reduce ? undefined : { opacity: 0, scale: 0.92 }}
              transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
            >
              <ProductCard product={p} onOpen={handleOpen} />
            </motion.div>
          ))}
        </AnimatePresence>
      </div>

      {/* Empty state */}
      {items.length === 0 ? (
        <p className="mt-12 text-center text-sm text-muted-foreground">
          No products in this category yet. Please check back soon.
        </p>
      ) : null}

      <ProductDialog
        product={selected}
        open={dialogOpen}
        onOpenChange={setDialogOpen}
      />

      {/* Comparison tray (only renders when ≥1 selected) */}
      <CompareBar onOpenCompare={() => setCompareOpen(true)} />
      <CompareDialog
        open={compareOpen}
        onOpenChange={setCompareOpen}
        onEnquire={handleEnquireFromCompare}
      />

      {/* Spacer so the fixed compare bar never covers footer content */}
      {compareIds.length > 0 ? <div className="h-24" aria-hidden="true" /> : null}
    </Section>
  )
}
