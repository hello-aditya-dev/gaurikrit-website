"use client"

import * as React from "react"
import { motion, useReducedMotion } from "framer-motion"
import { ArrowRight } from "lucide-react"

import { cn } from "@/lib/utils"
import type { Product } from "@/types"
import { ProductVisual } from "@/components/product/product-visual"
import { Button } from "@/components/ui/button"

interface ProductCardProps {
  product: Product
  onOpen: (product: Product) => void
}

export function ProductCard({ product, onOpen }: ProductCardProps) {
  const reduce = useReducedMotion()

  const isHaldi = product.category === "haldi"
  const chipClass = isHaldi
    ? "bg-primary text-primary-foreground"
    : "bg-accent text-accent-foreground"

  return (
    <motion.article
      layout
      initial={reduce ? false : { opacity: 0, y: 24, scale: 0.96 }}
      whileInView={reduce ? false : { opacity: 1, y: 0, scale: 1 }}
      viewport={{ once: true, margin: "-60px" }}
      exit={reduce ? undefined : { opacity: 0, scale: 0.96 }}
      transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
      whileHover={reduce ? undefined : { y: -6 }}
      className={cn(
        "group relative flex flex-col overflow-hidden rounded-2xl border bg-card shadow-soft",
        "transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
      )}
    >
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
