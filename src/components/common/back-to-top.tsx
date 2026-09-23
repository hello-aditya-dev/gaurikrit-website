"use client"

import * as React from "react"
import { motion, AnimatePresence, useReducedMotion } from "framer-motion"
import { ArrowUp } from "lucide-react"
import { cn } from "@/lib/utils"

/**
 * Floating "Back to top" button.
 * Appears after scrolling past 600px. Smooth-scrolls to #home.
 * Respects reduced motion. Keyboard accessible (button + aria-label).
 */
export function BackToTop() {
  const reduceMotion = useReducedMotion()
  const [visible, setVisible] = React.useState(false)

  React.useEffect(() => {
    const onScroll = () => setVisible(window.scrollY > 600)
    onScroll()
    window.addEventListener("scroll", onScroll, { passive: true })
    return () => window.removeEventListener("scroll", onScroll)
  }, [])

  const onClick = React.useCallback(() => {
    if (reduceMotion) {
      window.scrollTo(0, 0)
    } else {
      window.scrollTo({ top: 0, behavior: "smooth" })
    }
  }, [reduceMotion])

  return (
    <AnimatePresence>
      {visible ? (
        <motion.button
          type="button"
          onClick={onClick}
          aria-label="Back to top"
          initial={reduceMotion ? { opacity: 0 } : { opacity: 0, y: 16, scale: 0.85 }}
          animate={{ opacity: 1, y: 0, scale: 1 }}
          exit={reduceMotion ? { opacity: 0 } : { opacity: 0, y: 16, scale: 0.85 }}
          transition={{ duration: 0.25, ease: [0.22, 1, 0.36, 1] }}
          whileHover={reduceMotion ? undefined : { y: -3 }}
          whileTap={reduceMotion ? undefined : { scale: 0.94 }}
          className={cn(
            "fixed bottom-5 right-5 z-40 flex h-11 w-11 items-center justify-center rounded-full",
            "border border-primary/30 bg-background/90 text-primary shadow-gold backdrop-blur-md",
            "transition-colors hover:border-primary hover:bg-primary hover:text-primary-foreground",
            "focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2",
            "md:bottom-7 md:right-7 md:h-12 md:w-12"
          )}
        >
          <ArrowUp className="h-5 w-5" />
        </motion.button>
      ) : null}
    </AnimatePresence>
  )
}
