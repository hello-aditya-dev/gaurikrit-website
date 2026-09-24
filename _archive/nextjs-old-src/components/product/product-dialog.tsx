"use client"

import * as React from "react"
import { motion, useReducedMotion, AnimatePresence } from "framer-motion"
import { ArrowRight, ShieldCheck, Sparkles } from "lucide-react"

import { cn } from "@/lib/utils"
import { getClaimById } from "@/lib/data"
import type { Product } from "@/types"
import { ProductVisual } from "@/components/product/product-visual"
import { ShadePicker } from "@/components/product/shade-picker"
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog"
import { Button } from "@/components/ui/button"
import { track } from "@/lib/analytics"

interface ProductDialogProps {
  product: Product | null
  open: boolean
  onOpenChange: (open: boolean) => void
}

export function ProductDialog({
  product,
  open,
  onOpenChange,
}: ProductDialogProps) {
  const reduce = useReducedMotion()

  const handleEnquire = React.useCallback(() => {
    onOpenChange(false)
    if (typeof window === "undefined") return
    if (product) {
      track("product_enquire", {
        productId: product.id,
        productName: product.name,
        source: "product_dialog",
      })
      window.dispatchEvent(
        new CustomEvent("gaurikrit:inquiry", {
          detail: { productId: product.id, productName: product.name },
        })
      )
    }
    // Allow the dialog close tick to run before scrolling.
    window.setTimeout(() => {
      document
        .getElementById("contact")
        ?.scrollIntoView({ behavior: "smooth", block: "start" })
    }, 60)
  }, [onOpenChange, product])

  if (!product) {
    return null
  }

  const isDistemper = product.category === "distemper"
  const chipClass = isDistemper
    ? "bg-primary text-primary-foreground"
    : "bg-accent text-accent-foreground"

  const claims = product.claims
    .map((id) => getClaimById(id))
    .filter((c): c is NonNullable<typeof c> => Boolean(c))

  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent
        className="max-h-[90vh] overflow-y-auto p-0 sm:max-w-3xl"
      >
        <DialogHeader className="sr-only">
          <DialogTitle>{product.name}</DialogTitle>
          <DialogDescription>
            Detailed information about {product.name} — {product.tagline}.
          </DialogDescription>
        </DialogHeader>

        <motion.div
          key={product.id}
          initial={reduce ? false : { opacity: 0, y: 12 }}
          animate={reduce ? undefined : { opacity: 1, y: 0 }}
          transition={{ duration: 0.35, ease: [0.22, 1, 0.36, 1] }}
          className="grid gap-0 md:grid-cols-2"
        >
          {/* Visual */}
          <div className="relative aspect-square overflow-hidden border-b bg-secondary md:border-b-0 md:border-r">
            <ProductVisual
              id={product.image as React.ComponentProps<typeof ProductVisual>["id"]}
            />
            <span
              className={cn(
                "absolute left-4 top-4 inline-flex items-center rounded-full px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] shadow-soft",
                chipClass
              )}
            >
              {product.categoryLabel}
            </span>
          </div>

          {/* Details */}
          <div className="flex flex-col gap-5 p-6">
            <div>
              <span
                className={cn(
                  "inline-flex items-center rounded-full px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.14em]",
                  chipClass
                )}
              >
                {product.categoryLabel}
              </span>
              <h2 className="mt-3 font-display text-2xl font-bold leading-tight text-foreground">
                {product.name}
              </h2>
              <p className="mt-1 text-sm text-muted-foreground">
                {product.tagline}
              </p>
            </div>

            <p className="text-sm leading-relaxed text-muted-foreground">
              {product.description}
            </p>

            {/* How to use */}
            <div>
              <h3 className="mb-1.5 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
                <Sparkles className="size-3.5 text-primary" />
                How to use
              </h3>
              <p className="text-sm leading-relaxed text-muted-foreground">
                {product.usage}
              </p>
            </div>

            {/* Shade picker — only for the Natural Turmeric Paint (signature) */}
            {product.id === "paint-natural" ? <ShadePicker /> : null}

            {/* Sizes */}
            {product.sizes.length > 0 ? (
              <div>
                <h3 className="mb-2 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
                  Available sizes
                </h3>
                <ul className="flex flex-wrap gap-1.5">
                  {product.sizes.map((s) => (
                    <li
                      key={s}
                      className="rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground"
                    >
                      {s}
                    </li>
                  ))}
                </ul>
              </div>
            ) : null}

            {/* Price */}
            <div className="flex items-center justify-between gap-3 rounded-xl border bg-secondary/60 px-4 py-3">
              <span className="text-xs font-medium uppercase tracking-[0.14em] text-muted-foreground">
                Price range
              </span>
              <span className="font-display text-lg font-bold text-foreground">
                {product.priceRange}
              </span>
            </div>

            {/* Claims */}
            {claims.length > 0 ? (
              <div>
                <h3 className="mb-2 text-xs font-semibold uppercase tracking-[0.14em] text-foreground">
                  Verified claims
                </h3>
                <ul className="flex flex-col gap-2">
                  <AnimatePresence initial={false}>
                    {claims.map((c) => (
                      <motion.li
                        key={c.id}
                        initial={reduce ? false : { opacity: 0, y: 6 }}
                        animate={reduce ? undefined : { opacity: 1, y: 0 }}
                        transition={{ duration: 0.25 }}
                        className="flex items-start gap-2.5 rounded-lg border bg-card p-3"
                      >
                        <ShieldCheck className="mt-0.5 size-4 shrink-0 text-primary" />
                        <div className="min-w-0 flex-1">
                          <p className="text-sm leading-snug text-foreground">
                            {c.claim}
                          </p>
                          <p className="mt-1 font-mono text-[10px] text-muted-foreground">
                            #{c.reference}
                          </p>
                        </div>
                      </motion.li>
                    ))}
                  </AnimatePresence>
                </ul>
              </div>
            ) : null}

            {/* CTA */}
            <Button
              type="button"
              onClick={handleEnquire}
              className="group mt-1 h-11 w-full rounded-full gold-gradient text-primary-foreground shadow-gold hover:opacity-95"
              aria-label={`Enquire about ${product.name}`}
            >
              Enquire about this product
              <ArrowRight className="size-4 transition-transform duration-300 group-hover:translate-x-0.5" />
            </Button>
          </div>
        </motion.div>
      </DialogContent>
    </Dialog>
  )
}
