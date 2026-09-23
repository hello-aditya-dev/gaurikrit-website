"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { ArrowRight, Star, GitCompare } from "lucide-react"

import { cn } from "@/lib/utils"
import type { Product } from "@/types"
import { ProductVisual } from "@/components/product/product-visual"
import { Button } from "@/components/ui/button"
import { useCompareStore, MAX_COMPARE } from "@/lib/compare-store"
import { track } from "@/lib/analytics"

interface ProductCardProps {
  product: Product
  onOpen: (product: Product) => void
}

export function ProductCard({ product, onOpen }: ProductCardProps) {
  const reduce = useReducedMotion()
  const isSelected = useCompareStore((s) => s.ids.includes(product.id))
  const isFull = useCompareStore((s) => s.ids.length >= MAX_COMPARE)
  const toggle = useCompareStore((s) => s.toggle)

  const isHaldi = product.category === "haldi"
  const chipClass = isHaldi
    ? "bg-primary text-primary-foreground"
    : "bg-accent text-accent-foreground"

  const onCompareToggle = (e: React.MouseEvent) => {
    e.stopPropagation()
    const added = toggle(product.id)
    if (added) {
      track("product_compare_add", { productId: product.id, productName: product.name })
    }
  }

  return (
    <motion.article
      layout
      initial={reduce ? undefined : { opacity: 0, y: 24, scale: 0.96 }}
      whileInView={reduce ? undefined : { opacity: 1, y: 0, scale: 1 }}
      viewport={{ once: true, margin: "-60px" }}
      exit={reduce ? undefined : { opacity: 0, scale: 0.96 }}
      transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
      whileHover={reduce ? undefined : { y: -6 }}
      className={cn(
        "group relative flex flex-col overflow-hidden rounded-2xl border bg-card shadow-soft",
        "transition-all duration-300 hover:-translate-y-1 hover:shadow-xl",
        product.featured && "ring-2 ring-primary/50",
        isSelected && "ring-2 ring-primary"
      )}
    >
      {/* Featured ribbon */}
      {product.featured ? (
        <span className="absolute right-3 top-3 z-10 inline-flex items-center gap-1 rounded-full gold-gradient px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-accent shadow-gold">
          <Star className="h-3 w-3 fill-accent" aria-hidden="true" />
          Featured
        </span>
      ) : null}

      {/* Visual */}
      <div className="relative aspect-square overflow-hidden border-b">
        <ProductVisual id={product.image as React.ComponentProps<typeof ProductVisual>["id"]} />

        {/* Category chip */}
        <span
          className={cn(
            "absolute left-3 top-3 inline-flex items-center rounded-full px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] shadow-soft",
            chipClass
          )}
        >
          {product.categoryLabel}
        </span>

        {/* Compare toggle */}
        <button
          type="button"
          onClick={onCompareToggle}
          disabled={!isSelected && isFull}
          aria-pressed={isSelected}
          aria-label={
            isSelected
              ? `Remove ${product.name} from comparison`
              : `Add ${product.name} to comparison`
          }
          title={
            !isSelected && isFull
              ? `Comparison full (max ${MAX_COMPARE})`
              : isSelected
                ? "Remove from comparison"
                : "Add to comparison"
          }
          className={cn(
            "absolute bottom-3 right-3 z-10 inline-flex items-center gap-1 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.12em] backdrop-blur transition-all",
            isSelected
              ? "border-primary bg-primary text-primary-foreground shadow-gold"
              : "border-border bg-background/80 text-foreground/80 hover:border-primary hover:text-primary",
            !isSelected && isFull && "cursor-not-allowed opacity-50"
          )}
        >
          <GitCompare className="h-3 w-3" aria-hidden="true" />
          {isSelected ? "Comparing" : "Compare"}
        </button>
      </div>

      {/* Body */}
      <div className="flex flex-1 flex-col p-5">
        <h3 className="font-display text-lg font-bold leading-tight text-foreground">
          {product.name}
        </h3>
        <p className="mt-1 text-sm text-muted-foreground">{product.tagline}</p>

        {/* Highlights */}
        {product.highlights.length > 0 ? (
          <ul className="mt-3 flex flex-wrap gap-1.5">
            {product.highlights.slice(0, 3).map((h) => (
              <li
                key={h}
                className="rounded-full bg-secondary px-2.5 py-1 text-xs font-medium text-secondary-foreground"
              >
                {h}
              </li>
            ))}
          </ul>
        ) : null}

        {/* Footer */}
        <div className="mt-5 flex items-center justify-between gap-3 pt-1">
          <span className="text-sm font-semibold text-foreground">
            {product.priceRange}
          </span>
          <Button
            type="button"
            variant="ghost"
            size="sm"
            onClick={() => onOpen(product)}
            aria-label={`View details for ${product.name}`}
            className="-mr-2 text-primary hover:bg-primary/10 hover:text-primary"
          >
            View details
            <ArrowRight className="size-4 transition-transform duration-300 group-hover:translate-x-0.5" />
          </Button>
        </div>
      </div>
    </motion.article>
  )
}
