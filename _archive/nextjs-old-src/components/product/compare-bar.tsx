"use client"

import * as React from "react"
import { AnimatePresence, motion, useReducedMotion } from "framer-motion"
import { GitCompare, X, Trash2 } from "lucide-react"
import { Button } from "@/components/ui/button"
import { useCompareStore, MAX_COMPARE, useCompareProducts } from "@/lib/compare-store"
import { allProducts } from "@/lib/data"
import { track } from "@/lib/analytics"
import { cn } from "@/lib/utils"

interface CompareBarProps {
  onOpenCompare: () => void
}

/**
 * Floating bottom bar that shows the selected comparison products and a
 * "Compare now" CTA. Only renders when at least 1 product is selected.
 */
export function CompareBar({ onOpenCompare }: CompareBarProps) {
  const reduceMotion = useReducedMotion()
  const ids = useCompareStore((s) => s.ids)
  const remove = useCompareStore((s) => s.remove)
  const clear = useCompareStore((s) => s.clear)
  const selected = useCompareProducts(allProducts)
  const visible = ids.length > 0

  const onCompareClick = () => {
    track("product_compare_open", { count: ids.length })
    onOpenCompare()
  }

  return (
    <AnimatePresence>
      {visible ? (
        <motion.div
          initial={reduceMotion ? { opacity: 0 } : { opacity: 0, y: 24 }}
          animate={{ opacity: 1, y: 0 }}
          exit={reduceMotion ? { opacity: 0 } : { opacity: 0, y: 24 }}
          transition={{ duration: 0.3, ease: [0.22, 1, 0.36, 1] }}
          className="fixed inset-x-0 bottom-0 z-40 px-4 pb-4 sm:px-6 md:pb-6"
          role="region"
          aria-label="Product comparison tray"
        >
          <div className="mx-auto flex max-w-5xl items-center gap-3 rounded-2xl border border-primary/30 bg-background/95 p-3 shadow-gold backdrop-blur-md sm:gap-4 sm:p-4">
            {/* Compare icon + count */}
            <div className="flex shrink-0 items-center gap-2.5">
              <span className="flex h-10 w-10 items-center justify-center rounded-full gold-gradient text-accent shadow-gold">
                <GitCompare className="h-5 w-5" aria-hidden="true" />
              </span>
              <div className="hidden flex-col leading-tight sm:flex">
                <span className="text-sm font-bold text-foreground">Compare</span>
                <span className="text-[11px] text-muted-foreground">
                  {ids.length} of {MAX_COMPARE} selected
                </span>
              </div>
            </div>

            {/* Selected product chips */}
            <div className="flex flex-1 items-center gap-2 overflow-x-auto">
              {selected.map((p) => (
                <div
                  key={p.id}
                  className="flex shrink-0 items-center gap-2 rounded-full border bg-secondary/60 py-1 pl-2 pr-1"
                >
                  <span className="max-w-[140px] truncate text-xs font-medium text-foreground">
                    {p.name}
                  </span>
                  <button
                    type="button"
                    onClick={() => remove(p.id)}
                    aria-label={`Remove ${p.name} from comparison`}
                    className="flex h-5 w-5 items-center justify-center rounded-full text-muted-foreground transition-colors hover:bg-destructive/10 hover:text-destructive"
                  >
                    <X className="h-3.5 w-3.5" />
                  </button>
                </div>
              ))}
              {/* Empty slots */}
              {Array.from({ length: MAX_COMPARE - selected.length }).map((_, i) => (
                <div
                  key={`empty-${i}`}
                  className="hidden h-7 shrink-0 items-center gap-2 rounded-full border border-dashed border-border px-3 text-[11px] text-muted-foreground/70 sm:flex"
                >
                  + Add
                </div>
              ))}
            </div>

            {/* Clear */}
            <Button
              type="button"
              variant="ghost"
              size="sm"
              onClick={clear}
              aria-label="Clear comparison"
              className="hidden shrink-0 text-muted-foreground hover:text-destructive sm:inline-flex"
            >
              <Trash2 className="h-4 w-4" />
            </Button>

            {/* Compare CTA */}
            <Button
              type="button"
              onClick={onCompareClick}
              disabled={ids.length < 2}
              className={cn(
                "shrink-0 rounded-full gold-gradient text-accent shadow-gold hover:opacity-95",
                ids.length < 2 && "cursor-not-allowed opacity-60"
              )}
            >
              {ids.length < 2 ? "Select 2+" : "Compare now"}
            </Button>
          </div>
        </motion.div>
      ) : null}
    </AnimatePresence>
  )
}
