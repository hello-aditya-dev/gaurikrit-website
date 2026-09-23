import { NextResponse } from "next/server"
import { allProducts } from "@/lib/data"

export const dynamic = "force-dynamic"

export async function GET(req: Request) {
  const url = new URL(req.url)
  const category = url.searchParams.get("category")

  const items = category && category !== "all"
    ? allProducts.filter((p) => p.category === category)
    : allProducts

  return NextResponse.json({
    ok: true,
    count: items.length,
    categories: ["all", "haldi", "paint"],
    items,
  })
}
