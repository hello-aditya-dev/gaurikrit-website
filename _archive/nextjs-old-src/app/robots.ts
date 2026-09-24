import type { MetadataRoute } from "next"

export default function robots(): MetadataRoute.Robots {
  return {
    rules: [
      {
        userAgent: "*",
        allow: "/",
        disallow: ["/api/"],
      },
    ],
    sitemap: "https://gaurikrit.example.com/sitemap.xml",
    host: "https://gaurikrit.example.com",
  }
}
