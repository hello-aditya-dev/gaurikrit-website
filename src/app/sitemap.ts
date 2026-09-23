import type { MetadataRoute } from "next"
import { allProducts } from "@/lib/data"

const BASE = "https://gaurikrit.example.com"

export default function sitemap(): MetadataRoute.Sitemap {
  const now = new Date()

  // Single page site — the homepage with its section anchors.
  const sections = [
    "home",
    "about",
    "products",
    "claims",
    "faq",
    "contact",
  ]

  const entries: MetadataRoute.Sitemap = [
    {
      url: `${BASE}/`,
      lastModified: now,
      changeFrequency: "weekly",
      priority: 1,
    },
    ...sections.map((s) => ({
      url: `${BASE}/#${s}`,
      lastModified: now,
      changeFrequency: "weekly" as const,
      priority: 0.8,
    })),
    // Surface every product (for crawlers that follow hash fragments).
    ...allProducts.map((p) => ({
      url: `${BASE}/#products`,
      lastModified: now,
      changeFrequency: "monthly" as const,
      priority: 0.7,
    })),
  ]

  return entries
}
