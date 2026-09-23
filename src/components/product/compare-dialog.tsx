"use client"

import * as React from "react"
import { motion, AnimatePresence, useReducedMotion } from "framer-motion"
import { X, ArrowRight, Check, Minus, GitCompare } from "lucide-react"
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
} from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { ProductVisual } from "@/components/product/product-visual"
import { useCompareProducts } from "@/lib/compare-store"
import { getClaimById, allProducts } from "@/lib/data"
import type { Product } from "@/types"
import { track } from "@/lib/analytics"
import { cn } from "@/lib/utils"

interface CompareDialogProps {
  open: boolean
  onOpenChange: (open: boolean) => void
  onEnquire: (product: Product) => void
}

interface Row {
  key: string
  label: string
  render: (p: Product) => React.ReactNode
}

const ROWS: Row[] = [
  {
    key: "category",
    label: "Category",
    render: (p) => (
      <Badge variant="secondary" className="font-medium">
        {p.categoryLabel}
      </Badge>
    ),
  },
  {
    key: "tagline",
    label: "Tagline",
    render: (p) => <span className="text-sm text-foreground">{p.tagline}</span>,
  },
  {
    key: "price",
    label: "Price range",
    render: (p) => (
      <span className="font-display text-lg font-bold text-foreground">
        {p.priceRange}
      </span>
    ),
  },
  {
    key: "sizes",
    label: "Available sizes",
    render: (p) => (
      <div className="flex flex-wrap justify-center gap-1.5">
        {p.sizes.map((s) => (
          <span
            key={s}
            className="rounded-full bg-secondary px-2.5 py-1 text-xs font-medium text-secondary-foreground"
          >
            {s}
          </span>
        ))}
      </div>
    ),
  },
  {
    key: "highlights",
    label: "Highlights",
    render: (p) => (
      <ul className="flex flex-col gap-1 text-left">
        {p.highlights.map((h) => (
          <li key={h} className="flex items-start gap-2 text-sm text-foreground">
            <Check className="mt-0.5 size-4 shrink-0 text-primary" />
            {h}
          </li>
        ))}
      </ul>
    ),
  },
  {
    key: "usage",
    label: "Best for",
    render: (p) => (
      <p className="text-sm leading-relaxed text-muted-foreground">{p.usage}</p>
    ),
  },
  {
    key: "claims",
    label: "Verified claims",
    render: (p) => {
      const claims = p.claims
        .map((id) => getClaimById(id))
        .filter((c): c is NonNullable<typeof c> => Boolean(c))
      if (claims.length === 0)
        return (
          <span className="inline-flex items-center gap-1 text-xs text-muted-foreground">
            <Minus className="size-3" /> None listed
          </span>
        )
      return (
        <ul className="flex flex-col gap-1.5 text-left">
          {claims.map((c) => (
            <li key={c.id} className="text-xs leading-snug text-foreground">
              <span className="font-medium">{c.claim}</span>
              <span className="mt-0.5 block font-mono text-[10px] text-muted-foreground">
                #{c.reference}
              </span>
            </li>
          ))}
        </ul>
      )
    },
  },
]

export function CompareDialog({ open, onOpenChange, onEnquire }: CompareDialogProps) {
  const reduceMotion = useReducedMotion()
  const selected = useCompareProducts(allProducts)

  // Winner highlights — only meaningful with 2+ products.
  const winners = React.useMemo(() => {
    if (selected.length < 2) return {} as Record<string, string[]>
    const result: Record<string, string[]> = {}

    // Best value = lowest mid price (parse first number from priceRange)
    const prices = selected.map((p) => ({
      id: p.id,
      price: parseInt(p.priceRange.replace(/[^0-9]/g, "").slice(0, 4) || "999999", 10) || 999999,
    }))
    const minPrice = Math.min(...prices.map((p) => p.price))
    result["Best value"] = prices.filter((p) => p.price === minPrice).map((p) => p.id)

    // Most claims = highest count of verified claims
    const claimCounts = selected.map((p) => ({
      id: p.id,
      count: p.claims
        .map((id) => getClaimById(id))
        .filter((c): c is NonNullable<typeof c> => Boolean(c)).length,
    }))
    const maxClaims = Math.max(...claimCounts.map((c) => c.count))
    if (maxClaims > 0) {
      result["Most claims"] = claimCounts.filter((c) => c.count === maxClaims).map((c) => c.id)
    }

    // Lowest VOC (only among paint products that have the low-voc claim)
    const vocProducts = selected.filter((p) => p.claims.includes("clm-low-voc"))
    if (vocProducts.length >= 1) {
      // Natural Turmeric Paint has the lowest VOC (<5 g/L) per claims
      const naturalPaint = vocProducts.find((p) => p.id === "prakritik-emulsion")
      if (naturalPaint) {
        result["Lowest VOC"] = [naturalPaint.id]
      }
    }

    return result
  }, [selected])

  const winnerBadges = (productId: string): string[] =>
    Object.entries(winners).flatMap(([label, ids]) =>
      ids.includes(productId) ? [label] : []
    )

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent className="max-h-[92vh] overflow-hidden p-0 sm:max-w-5xl">
        <DialogHeader className="sr-only">
          <DialogTitle>Compare Gaurikrit products</DialogTitle>
          <DialogDescription>
            Side-by-side comparison of {selected.length} selected products.
          </DialogDescription>
        </DialogHeader>

        {/* Top bar */}
        <div className="flex items-center justify-between border-b bg-secondary/40 px-5 py-4">
          <div className="flex items-center gap-2.5">
            <span className="flex h-9 w-9 items-center justify-center rounded-full gold-gradient text-accent shadow-gold">
              <GitCompare className="h-4 w-4" />
            </span>
            <div>
              <h2 className="font-display text-lg font-bold leading-tight text-foreground">
                Compare products
              </h2>
              <p className="text-xs text-muted-foreground">
                {selected.length} selected · side by side
              </p>
            </div>
          </div>
        </div>

        {/* Body — scrollable */}
        <div className="overflow-y-auto px-5 py-5">
          {selected.length === 0 ? (
            <div className="flex flex-col items-center justify-center py-12 text-center">
              <GitCompare className="h-10 w-10 text-muted-foreground/40" />
              <p className="mt-3 text-sm text-muted-foreground">
                No products selected. Add 2 or 3 from the grid to compare.
              </p>
            </div>
          ) : (
            <div
              className="grid gap-px overflow-hidden rounded-xl border bg-border"
              style={{
                gridTemplateColumns: `140px repeat(${selected.length}, minmax(0, 1fr))`,
              }}
            >
              {/* Header row: empty corner + product headers */}
              <div className="bg-secondary/60" />
              {selected.map((p) => {
                const badges = winnerBadges(p.id)
                return (
                  <div key={p.id} className="bg-card p-3 text-center">
                    <div className="mx-auto mb-2 aspect-square w-20 overflow-hidden rounded-lg border bg-secondary">
                      <ProductVisual
                        id={p.image as React.ComponentProps<typeof ProductVisual>["id"]}
                      />
                    </div>
                    <p className="font-display text-sm font-bold leading-tight text-foreground">
                      {p.name}
                    </p>
                    {/* Winner badges */}
                    {badges.length > 0 ? (
                      <div className="mt-1.5 flex flex-wrap justify-center gap-1">
                        {badges.map((b) => (
                          <span
                            key={b}
                            className="inline-block rounded-full gold-gradient px-2 py-0.5 text-[8px] font-bold uppercase tracking-wider text-accent shadow-gold"
                          >
                            ★ {b}
                          </span>
                        ))}
                      </div>
                    ) : p.featured ? (
                      <span className="mt-1 inline-block rounded-full bg-secondary px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-secondary-foreground">
                        Featured
                      </span>
                    ) : null}
                  </div>
                )
              })}

              {/* Data rows */}
              {ROWS.map((row) => (
                <React.Fragment key={row.key}>
                  <div className="flex items-center bg-secondary/60 px-3 py-3">
                    <span className="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted-foreground">
                      {row.label}
                    </span>
                  </div>
                  {selected.map((p) => (
                    <div
                      key={`${row.key}-${p.id}`}
                      className="flex items-center justify-center bg-card px-3 py-3 text-center"
                    >
                      <AnimatePresence mode="wait">
                        <motion.div
                          key={`${row.key}-${p.id}`}
                          initial={reduceMotion ? false : { opacity: 0 }}
                          animate={{ opacity: 1 }}
                          transition={{ duration: 0.2 }}
                          className="w-full"
                        >
                          {row.render(p)}
                        </motion.div>
                      </AnimatePresence>
                    </div>
                  ))}
                </React.Fragment>
              ))}

              {/* CTA row */}
              <div className="flex items-center bg-secondary/60 px-3 py-3">
                <span className="text-[11px] font-semibold uppercase tracking-[0.12em] text-muted-foreground">
                  Action
                </span>
              </div>
              {selected.map((p) => (
                <div key={`cta-${p.id}`} className="flex items-center justify-center bg-card px-3 py-3">
                  <Button
                    type="button"
                    size="sm"
                    onClick={() => {
                      track("product_enquire", {
                        productId: p.id,
                        productName: p.name,
                        source: "compare_dialog",
                      })
                      onOpenChange(false)
                      onEnquire(p)
                    }}
                    className="w-full rounded-full gold-gradient text-accent shadow-gold hover:opacity-95"
                    aria-label={`Enquire about ${p.name}`}
                  >
                    Enquire
                    <ArrowRight className="size-3.5" />
                  </Button>
                </div>
              ))}
            </div>
          )}
        </div>
      </DialogContent>
    </Dialog>
  )
}
