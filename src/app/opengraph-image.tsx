import { ImageResponse } from "next/og"
import { readFile } from "node:fs/promises"
import { company } from "@/lib/data"

export const alt = "Gaurikrit — Naturally Crafted Haldi & Premium Paint"
export const size = { width: 1200, height: 630 }
export const contentType = "image/png"

/**
 * Dynamic OpenGraph image with real brand fonts.
 *
 * Tries to fetch Playfair Display + Inter from a CDN; if that fails (e.g. no
 * outbound network in a sandbox), falls back to local Liberation Serif + Sans
 * read from the filesystem so Satori always has a font to calculate layout.
 *
 * Route: /opengraph-image (Next.js convention — auto-wired into metadata).
 *
 * Note: Satori (the renderer) requires every <div> with more than one child
 * to have an explicit `display: "flex"` (or "none"). Single-text divs are fine.
 */

async function loadFonts(): Promise<{ name: string; data: ArrayBuffer; weight: 400 | 700; style: "normal" | "italic" }[]> {
  // 1. Try CDN fonts (Playfair Display + Inter) — on-brand.
  try {
    const base = "https://cdn.jsdelivr.net/fontsource/fonts"
    const [playfairRes, interRes] = await Promise.all([
      fetch(`${base}/playfair-display@1.2.0/latin-700-normal.woff2`, { cache: "no-store" }),
      fetch(`${base}/inter@1.1.0/latin-400-normal.woff2`, { cache: "no-store" }),
    ])
    if (playfairRes.ok && interRes.ok) {
      const [playfairData, interData] = await Promise.all([
        playfairRes.arrayBuffer(),
        interRes.arrayBuffer(),
      ])
      return [
        { name: "Playfair Display", data: playfairData, weight: 700, style: "normal" },
        { name: "Inter", data: interData, weight: 400, style: "normal" },
        { name: "Inter", data: interData, weight: 700, style: "normal" },
      ]
    }
  } catch {
    // fall through to local fonts
  }

  // 2. Fallback: local Liberation Serif (display) + Sans (body).
  try {
    const [serifData, sansData] = await Promise.all([
      readFile("/usr/share/fonts/truetype/liberation/LiberationSerif-Bold.ttf"),
      readFile("/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf"),
    ])
    return [
      { name: "Liberation Serif", data: serifData.buffer.slice(0), weight: 700, style: "normal" },
      { name: "Liberation Sans", data: sansData.buffer.slice(0), weight: 400, style: "normal" },
      { name: "Liberation Sans", data: sansData.buffer.slice(0), weight: 700, style: "normal" },
    ]
  } catch {
    // 3. Last resort: return empty — Satori will throw but we've tried.
    return []
  }
}

export default async function OpengraphImage() {
  const gold = "#c8901f" // approx of oklch(0.72 0.15 75) in sRGB
  const goldLight = "#e7c171"
  const charcoal = "#1a1816"
  const paper = "#fdfaf2"
  const fonts = await loadFonts()
  const hasFonts = fonts.length > 0
  // Use the display font name for headings, body font name for the rest.
  const displayFont = hasFonts ? fonts[0].name : "sans-serif"
  const bodyFont = hasFonts ? fonts[1].name : "sans-serif"

  return new ImageResponse(
    (
      <div
        style={{
          width: "100%",
          height: "100%",
          display: "flex",
          flexDirection: "column",
          justifyContent: "space-between",
          background: charcoal,
          padding: "72px",
          fontFamily: bodyFont,
          position: "relative",
        }}
      >
        {/* Gold radial glows (decorative) */}
        <div
          style={{
            position: "absolute",
            top: "-180px",
            right: "-160px",
            width: "640px",
            height: "640px",
            borderRadius: "50%",
            background: `radial-gradient(closest-side, ${gold}55, transparent)`,
            display: "flex",
          }}
        />
        <div
          style={{
            position: "absolute",
            bottom: "-220px",
            left: "-140px",
            width: "540px",
            height: "540px",
            borderRadius: "50%",
            background: `radial-gradient(closest-side, ${goldLight}33, transparent)`,
            display: "flex",
          }}
        />

        {/* Top row — brand mark */}
        <div style={{ display: "flex", alignItems: "center", gap: "20px" }}>
          <div
            style={{
              width: "72px",
              height: "72px",
              borderRadius: "50%",
              background: `linear-gradient(135deg, ${goldLight}, ${gold})`,
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              fontSize: "40px",
              fontWeight: 700,
              fontFamily: displayFont,
              color: charcoal,
            }}
          >
            G
          </div>
          <div style={{ display: "flex", flexDirection: "column" }}>
            <div
              style={{
                fontSize: "34px",
                fontWeight: 700,
                fontFamily: displayFont,
                color: paper,
                letterSpacing: "-0.01em",
                display: "flex",
              }}
            >
              Gaurikrit
            </div>
            <div
              style={{
                fontSize: "15px",
                color: "#a8a09a",
                letterSpacing: "0.18em",
                textTransform: "uppercase",
                marginTop: "4px",
                display: "flex",
              }}
            >
              {`Haldi & Paint · Since ${company.foundedYear}`}
            </div>
          </div>
        </div>

        {/* Middle — headline */}
        <div
          style={{
            display: "flex",
            flexDirection: "column",
            gap: "16px",
            maxWidth: "980px",
          }}
        >
          <div
            style={{
              fontSize: "20px",
              color: gold,
              letterSpacing: "0.22em",
              textTransform: "uppercase",
              fontWeight: 600,
              display: "flex",
            }}
          >
            {company.hero.eyebrow}
          </div>
          <div
            style={{
              display: "flex",
              flexDirection: "column",
              fontSize: "72px",
              fontWeight: 700,
              fontFamily: displayFont,
              color: paper,
              lineHeight: 1.08,
              letterSpacing: "-0.025em",
            }}
          >
            <span style={{ display: "flex" }}>The golden warmth of</span>
            <span style={{ display: "flex" }}>
              <span style={{ color: gold, fontStyle: "italic" }}>{`haldi`}</span>
              <span>{`, the precision`}</span>
            </span>
            <span style={{ display: "flex" }}>
              <span>{`of premium `}</span>
              <span style={{ color: gold, fontStyle: "italic" }}>{`paint`}</span>
              <span>{`.`}</span>
            </span>
          </div>
        </div>

        {/* Bottom — certifications + seal */}
        <div
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "space-between",
          }}
        >
          <div style={{ display: "flex", gap: "14px", alignItems: "center" }}>
            {["FSSAI", "NABL", "ISO 9001", "GreenPro"].map((c) => (
              <div
                key={c}
                style={{
                  display: "flex",
                  alignItems: "center",
                  gap: "8px",
                  padding: "10px 18px",
                  borderRadius: "999px",
                  border: `1px solid ${gold}55`,
                  background: `${gold}11`,
                  color: paper,
                  fontSize: "16px",
                  fontWeight: 600,
                }}
              >
                <span style={{ color: gold, fontSize: "18px", display: "flex" }}>
                  •
                </span>
                {c}
              </div>
            ))}
          </div>
          <div
            style={{
              display: "flex",
              alignItems: "center",
              gap: "12px",
              padding: "14px 22px",
              borderRadius: "999px",
              background: `linear-gradient(135deg, ${goldLight}, ${gold})`,
              color: charcoal,
              fontSize: "18px",
              fontWeight: 700,
            }}
          >
            {`${company.hero.seal.label} · ${company.hero.seal.sublabel}`}
          </div>
        </div>
      </div>
    ),
    { ...size, fonts }
  )
}
