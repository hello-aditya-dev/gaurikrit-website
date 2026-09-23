"use client"

import * as React from "react"

/**
 * Scroll-spy hook: returns the id of the section currently in view.
 * Observes the sections whose ids are passed in `sectionIds`.
 *
 * Uses IntersectionObserver with a rootMargin that favours the top third
 * of the viewport, so the "active" link switches as the user scrolls.
 *
 * @param sectionIds list of section ids to observe (in document order).
 * @param options.offset top offset in px (matches scroll-padding-top). Default 96.
 */
export function useActiveSection(
  sectionIds: string[],
  options: { offset?: number } = {}
): string | null {
  const { offset = 96 } = options
  const [active, setActive] = React.useState<string | null>(sectionIds[0] ?? null)

  React.useEffect(() => {
    if (typeof window === "undefined") return
    if (typeof IntersectionObserver === "undefined") return

    const elements = sectionIds
      .map((id) => document.getElementById(id))
      .filter((el): el is HTMLElement => el !== null)

    if (elements.length === 0) return

    const observer = new IntersectionObserver(
      (entries) => {
        // Find the entry closest to the top that is intersecting.
        const visible = entries
          .filter((e) => e.isIntersecting)
          .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top)

        if (visible.length > 0) {
          setActive(visible[0].target.id)
        }
      },
      {
        // Trigger when the section's top crosses ~30% of the viewport.
        rootMargin: `-${offset}px 0px -55% 0px`,
        threshold: [0, 0.1, 0.25, 0.5, 1],
      }
    )

    elements.forEach((el) => observer.observe(el))
    return () => observer.disconnect()
  }, [sectionIds, offset])

  return active
}
