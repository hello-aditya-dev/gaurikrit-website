"use client"

import * as React from "react"
import { motion, AnimatePresence, useReducedMotion } from "framer-motion"
import { ChefHat, Clock, Users, ChevronLeft, ChevronRight, Sparkles } from "lucide-react"
import { Section, SectionHeading } from "@/components/layout/site-shell"
import { Button } from "@/components/ui/button"
import { Badge } from "@/components/ui/badge"
import { RECIPES } from "@/data/recipes"
import { allProducts } from "@/lib/data"
import { track } from "@/lib/analytics"
import { cn } from "@/lib/utils"

const EASE = [0.22, 1, 0.36, 1] as const

export function RecipeCarousel() {
  const reduceMotion = useReducedMotion()
  const [active, setActive] = React.useState(0)
  const recipe = RECIPES[active]
  const product = allProducts.find((p) => p.id === recipe.productId)

  const go = (dir: 1 | -1) => {
    const next = (active + dir + RECIPES.length) % RECIPES.length
    setActive(next)
    track("recipe_view", { recipeId: RECIPES[next].id, title: RECIPES[next].title })
  }

  // keyboard nav when focused
  const onKeyDown = (e: React.KeyboardEvent) => {
    if (e.key === "ArrowLeft") go(-1)
    if (e.key === "ArrowRight") go(1)
  }

  return (
    <Section id="recipes" tone="paper" className="bg-grain">
      <SectionHeading
        eyebrow="From our kitchen"
        title="Three ways to use our haldi"
        description="Everyday rituals that make the most of Gaurikrit turmeric — drawn from the family recipe book."
      />

      <div
        className="mt-10 grid gap-6 lg:grid-cols-[1.1fr_1fr] lg:gap-8"
        tabIndex={0}
        role="region"
        aria-label="Recipe carousel. Use left and right arrow keys to navigate."
        onKeyDown={onKeyDown}
      >
        {/* LEFT — recipe card */}
        <div className="relative overflow-hidden rounded-3xl border bg-card shadow-soft">
          {/* accent banner */}
          <div
            className="relative h-32 overflow-hidden"
            style={{ background: recipe.accent }}
          >
            <div
              aria-hidden="true"
              className="absolute inset-0 opacity-30"
              style={{
                backgroundImage:
                  "radial-gradient(circle at 1px 1px, oklch(1 0 0 / 0.4) 1px, transparent 0)",
                backgroundSize: "16px 16px",
              }}
            />
            <div className="relative flex h-full flex-col justify-between p-6">
              <div className="flex items-center justify-between">
                <Badge className="bg-background/80 text-foreground backdrop-blur">
                  <ChefHat className="mr-1 h-3 w-3" /> Recipe
                </Badge>
                <div className="flex gap-2 text-[11px] font-medium text-foreground">
                  <span className="inline-flex items-center gap-1 rounded-full bg-background/70 px-2.5 py-1 backdrop-blur">
                    <Clock className="h-3 w-3" /> {recipe.duration}
                  </span>
                  <span className="inline-flex items-center gap-1 rounded-full bg-background/70 px-2.5 py-1 backdrop-blur">
                    <Users className="h-3 w-3" /> {recipe.serves}
                  </span>
                </div>
              </div>
              <div>
                <h3 className="font-display text-2xl font-bold leading-tight text-foreground">
                  {recipe.title}
                </h3>
                <p className="text-sm text-foreground/80">{recipe.subtitle}</p>
              </div>
            </div>
          </div>

          {/* steps */}
          <div className="p-6">
            <AnimatePresence mode="wait">
              <motion.ol
                key={recipe.id}
                initial={reduceMotion ? false : { opacity: 0, y: 12 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0 }}
                transition={{ duration: 0.35, ease: EASE }}
                className="space-y-4"
              >
                {recipe.steps.map((step, i) => (
                  <li key={step.title} className="flex gap-4">
                    <span
                      className="flex h-9 w-9 shrink-0 items-center justify-center rounded-full font-display text-sm font-bold text-accent"
                      style={{ background: recipe.accent }}
                    >
                      {i + 1}
                    </span>
                    <div className="pt-1">
                      <p className="text-sm font-semibold text-foreground">{step.title}</p>
                      <p className="mt-0.5 text-sm leading-relaxed text-muted-foreground">
                        {step.detail}
                      </p>
                    </div>
                  </li>
                ))}
              </motion.ol>
            </AnimatePresence>

            {/* nav controls */}
            <div className="mt-6 flex items-center justify-between border-t border-border pt-4">
              <div className="flex gap-1.5" role="tablist" aria-label="Recipe selector">
                {RECIPES.map((r, i) => (
                  <button
                    key={r.id}
                    role="tab"
                    aria-selected={i === active}
                    aria-label={`Show recipe: ${r.title}`}
                    onClick={() => {
                      setActive(i)
                      track("recipe_view", { recipeId: r.id, title: r.title })
                    }}
                    className={cn(
                      "h-2 rounded-full transition-all",
                      i === active ? "w-8 bg-primary" : "w-2 bg-border hover:bg-primary/50"
                    )}
                  />
                ))}
              </div>
              <div className="flex gap-2">
                <Button
                  type="button"
                  variant="outline"
                  size="icon"
                  onClick={() => go(-1)}
                  aria-label="Previous recipe"
                  className="h-9 w-9 rounded-full"
                >
                  <ChevronLeft className="h-4 w-4" />
                </Button>
                <Button
                  type="button"
                  variant="outline"
                  size="icon"
                  onClick={() => go(1)}
                  aria-label="Next recipe"
                  className="h-9 w-9 rounded-full"
                >
                  <ChevronRight className="h-4 w-4" />
                </Button>
              </div>
            </div>
          </div>
        </div>

        {/* RIGHT — product link + tips */}
        <div className="flex flex-col gap-4">
          <div className="rounded-3xl border bg-secondary/40 p-6">
            <p className="text-xs font-semibold uppercase tracking-[0.18em] text-primary">
              Made with
            </p>
            <h4 className="mt-1 font-display text-lg font-bold text-foreground">
              {product?.name ?? "Gaurikrit haldi"}
            </h4>
            <p className="mt-1 text-sm text-muted-foreground">{product?.tagline}</p>
            <ul className="mt-4 space-y-2">
              {product?.highlights.slice(0, 3).map((h) => (
                <li key={h} className="flex items-start gap-2 text-sm text-foreground">
                  <Sparkles className="mt-0.5 h-4 w-4 shrink-0 text-primary" />
                  {h}
                </li>
              ))}
            </ul>
          </div>

          <div className="rounded-3xl border border-primary/30 bg-primary/[0.04] p-6">
            <p className="font-display text-base font-bold text-foreground">
              A note from the family kitchen
            </p>
            <p className="mt-2 text-sm leading-relaxed text-muted-foreground">
              Haldi is always added to hot fat — ghee or oil — for a few seconds
              before the wet ingredients. This blooms the curcumin and removes
              the raw edge. Never let it burn; turmeric turns bitter past 10
              seconds in very hot fat.
            </p>
            <Button
              asChild
              variant="outline"
              size="sm"
              className="mt-4 rounded-full border-primary/40 text-primary hover:bg-primary/10"
            >
              <a href="#products">Shop the haldi range</a>
            </Button>
          </div>

          <div className="rounded-3xl border bg-card p-6 shadow-soft">
            <p className="font-display text-base font-bold text-foreground">
              {String(active + 1).padStart(2, "0")}
              <span className="text-muted-foreground"> / {String(RECIPES.length).padStart(2, "0")}</span>
            </p>
            <p className="text-xs text-muted-foreground">
              Use the arrows or dots to browse all {RECIPES.length} recipes.
            </p>
          </div>
        </div>
      </div>
    </Section>
  )
}
