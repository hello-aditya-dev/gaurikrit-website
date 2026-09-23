/**
 * Lightweight analytics sink.
 *
 * v1: logs to console in dev, queues for a future Plausible/PostHog/GA4
 * integration. Swap the body of `track()` to point at a real provider
 * without touching any call site.
 *
 * Safe to call from the server (no-ops) or the client.
 * Never throws — analytics must never break UX.
 */

export type AnalyticsEvent =
  | "hero_cta_click"
  | "nav_click"
  | "product_view"
  | "product_enquire"
  | "product_compare_add"
  | "product_compare_open"
  | "claim_search"
  | "claim_filter"
  | "claim_copy_reference"
  | "faq_expand"
  | "form_submit"
  | "newsletter_subscribe"
  | "theme_toggle"
  | "shade_preview"
  | "recipe_view"
  | "coverage_calculate"
  | "calculator_enquire"
  | "calculator_compare"
  | "press_click"
  | "cert_view"

export interface AnalyticsPayload {
  [key: string]: string | number | boolean | null | undefined
}

function isClient(): boolean {
  return typeof window !== "undefined"
}

export function track(event: AnalyticsEvent, payload: AnalyticsPayload = {}): void {
  if (!isClient()) return
  try {
    const enriched = {
      event,
      ts: Date.now(),
      path: window.location.pathname + window.location.hash,
      ...payload,
    }
    // v1 sink — log in dev, ready to swap for a real provider.
    if (process.env.NODE_ENV !== "production") {
      console.debug("[analytics]", event, enriched)
    }
    // Future: window.plausible?.(event, { props: enriched }) or posthog.capture(...)
    // Stash on a global queue so a later-loaded provider can drain it.
    const q = (window as unknown as { __gk_analytics?: Array<typeof enriched> })
      .__gk_analytics ?? []
    q.push(enriched)
    ;(window as unknown as { __gk_analytics?: Array<typeof enriched> }).__gk_analytics = q
  } catch {
    // analytics must never throw
  }
}
