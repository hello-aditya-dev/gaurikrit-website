"use client"

import { create } from "zustand"
import { persist } from "zustand/middleware"
import type { Product } from "@/types"

const MAX_COMPARE = 3

interface CompareState {
  /** ids of products selected for comparison */
  ids: string[]
  /** add a product to the comparison (no-op if full or already present) */
  add: (id: string) => boolean
  /** remove a product from the comparison */
  remove: (id: string) => void
  /** toggle a product in/out of the comparison; returns the new selected state */
  toggle: (id: string) => boolean
  /** clear the comparison */
  clear: () => void
  /** is the given id selected? */
  has: (id: string) => boolean
  /** is the comparison full (>= MAX_COMPARE)? */
  isFull: () => boolean
}

/**
 * Zustand store for product comparison, persisted to localStorage so the
 * selection survives a page refresh during a session.
 *
 * Capped at MAX_COMPARE (3) so the compare dialog stays readable.
 */
export const useCompareStore = create<CompareState>()(
  persist(
    (set, get) => ({
      ids: [],
      add: (id) => {
        const current = get().ids
        if (current.includes(id)) return false
        if (current.length >= MAX_COMPARE) return false
        set({ ids: [...current, id] })
        return true
      },
      remove: (id) => set({ ids: get().ids.filter((x) => x !== id) }),
      toggle: (id) => {
        const current = get().ids
        if (current.includes(id)) {
          set({ ids: current.filter((x) => x !== id) })
          return false
        }
        if (current.length >= MAX_COMPARE) return false
        set({ ids: [...current, id] })
        return true
      },
      clear: () => set({ ids: [] }),
      has: (id) => get().ids.includes(id),
      isFull: () => get().ids.length >= MAX_COMPARE,
    }),
    {
      name: "gaurikrit-compare",
      // only persist the ids
      partialize: (s) => ({ ids: s.ids }),
    }
  )
)

export { MAX_COMPARE }

/**
 * Helper to hydrate selected Product objects from ids.
 * Call inside a component so it re-renders when the catalogue or ids change.
 */
export function useCompareProducts(allProducts: Product[]): Product[] {
  const ids = useCompareStore((s) => s.ids)
  return ids
    .map((id) => allProducts.find((p) => p.id === id))
    .filter((p): p is Product => Boolean(p))
}
