import { NextResponse } from "next/server"
import { allClaims, claimsData } from "@/lib/data"

export const dynamic = "force-dynamic"

/**
 * GET /api/claims
 *   ?category=haldi|paint|process  — filter by category
 *   ?q=curcumin                     — free-text search on claim/source/reference
 *
 * Returns the public claims register as JSON. Enables a future headless/CMS
 * or admin view without touching the bundled JSON.
 */
export async function GET(req: Request) {
  const url = new URL(req.url)
  const category = url.searchParams.get("category") ?? "all"
  const q = url.searchParams.get("q")?.trim().toLowerCase() ?? ""

  let items = allClaims

  if (category && category !== "all") {
    items = items.filter((c) => c.category === category)
  }

  if (q) {
    items = items.filter(
      (c) =>
        c.claim.toLowerCase().includes(q) ||
        c.source.toLowerCase().includes(q) ||
        c.reference.toLowerCase().includes(q) ||
        c.categoryLabel.toLowerCase().includes(q)
    )
  }

  return NextResponse.json({
    ok: true,
    count: items.length,
    categories: claimsData.categories,
    items,
  })
}
