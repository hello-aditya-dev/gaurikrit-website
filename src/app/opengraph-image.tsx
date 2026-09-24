import { ImageResponse } from "next/og"
import { readFile } from "node:fs/promises"
import path from "node:path"
import { company } from "@/lib/data"

export const alt = "Gaurikrit Bio Products — Prakritik Paint. Walls that breathe sustainability."
export const size = { width: 1200, height: 630 }
export const contentType = "image/png"

// Prevent build-time prerender — the OG image renders on-demand at request
// time, where the serverless function has filesystem access to the bundled
// fonts. (Build machines like Vercel's iad1 don't have the CDN reachable
// during prerender, which crashed the previous build.)
export const dynamic = "force-dynamic"

/**
 * Dynamic OpenGraph image for Gaurikrit Bio Products.
 *
 * Fonts: bundled Liberation Serif (display) + Sans (body) travel with the
 * repo so the route never depends on a CDN fetch or a system font install.
 * On Vercel/Node the serverless function reads them via fs at request time.
 *
 * Route: /opengraph-image (Next.js convention — auto-wired into metadata).
 *
 * Satori requires every <div> with >1 child to have explicit `display: flex`.
 */

let cachedFonts:
  | { name: string; data: Buffer; weight: 400 | 700; style: "normal" | "italic" }[]
  | null = null

async function loadFonts() {
  if (cachedFonts) return cachedFonts
  const fontDir = path.join(process.cwd(), "src/app/_fonts")
  const [serifBold, sansReg, sansBold] = await Promise.all([
    readFile(path.join(fontDir, "LiberationSerif-Bold.ttf")),
    readFile(path.join(fontDir, "LiberationSans-Regular.ttf")),
    readFile(path.join(fontDir, "LiberationSans-Bold.ttf")),
  ])
  cachedFonts = [
    { name: "Liberation Serif", data: serifBold, weight: 700, style: "normal" },
    { name: "Liberation Sans", data: sansReg, weight: 400, style: "normal" },
    { name: "Liberation Sans", data: sansBold, weight: 700, style: "normal" },
  ]
  return cachedFonts
}

export default async function OpengraphImage() {
  const fonts = await loadFonts()
  const forest = "#1c2a1e"
  const forestMid = "#34503a"
  const haldi = "#d4a017"
  const haldiLight = "#e9c76b"
  const mitti = "#a86a3a"
  const paper = "#f7f3eb"

  return new ImageResponse(
    (
      <div
        style={{
          width: "100%",
          height: "100%",
          display: "flex",
          flexDirection: "column",
          justifyContent: "space-between",
          background: paper,
          padding: "72px",
          fontFamily: "Liberation Sans",
          position: "relative",
        }}
      >
        {/* Soft haldi wash top-right */}
        <div
          style={{
            position: "absolute",
            top: "-160px",
            right: "-140px",
            width: "620px",
            height: "620px",
            borderRadius: "50%",
            background: `radial-gradient(closest-side, ${haldi}33, transparent)`,
            display: "flex",
          }}
        />
        {/* Soft forest wash bottom-left */}
        <div
          style={{
            position: "absolute",
            bottom: "-200px",
            left: "-120px",
            width: "540px",
            height: "540px",
            borderRadius: "50%",
            background: `radial-gradient(closest-side, ${forest}22, transparent)`,
            display: "flex",
          }}
        />

        {/* Top row — Devanagari + brand lockup */}
        <div style={{ display: "flex", alignItems: "center", gap: "24px" }}>
          {/* Cow-mark emblem (gold circle with forest G) */}
          <div
            style={{
              width: "80px",
              height: "80px",
              borderRadius: "50%",
              background: `linear-gradient(135deg, ${haldiLight}, ${haldi})`,
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              fontSize: "44px",
              fontWeight: 700,
              fontFamily: "Liberation Serif",
              color: forest,
            }}
          >
            G
          </div>
          <div style={{ display: "flex", flexDirection: "column" }}>
            <div
              style={{
                fontSize: "38px",
                fontWeight: 700,
                fontFamily: "Liberation Serif",
                color: forest,
                letterSpacing: "-0.01em",
                display: "flex",
              }}
            >
              Gaurikrit
            </div>
            <div
              style={{
                fontSize: "16px",
                color: forestMid,
                letterSpacing: "0.22em",
                textTransform: "uppercase",
                marginTop: "4px",
                fontWeight: 700,
                display: "flex",
              }}
            >
              BIO PRODUCTS · PRAKRITIK PAINT
            </div>
          </div>
        </div>

        {/* Middle — headline */}
        <div
          style={{
            display: "flex",
            flexDirection: "column",
            gap: "14px",
            maxWidth: "1000px",
          }}
        >
          <div
            style={{
              fontSize: "22px",
              color: haldi,
              letterSpacing: "0.2em",
              textTransform: "uppercase",
              fontWeight: 700,
              display: "flex",
            }}
          >
            {company.hero.eyebrow}
          </div>
          <div
            style={{
              display: "flex",
              flexDirection: "column",
              fontSize: "78px",
              fontWeight: 700,
              fontFamily: "Liberation Serif",
              color: forest,
              lineHeight: 1.04,
              letterSpacing: "-0.025em",
            }}
          >
            <span style={{ display: "flex" }}>Walls that breathe</span>
            <span style={{ display: "flex" }}>
              <span style={{ color: haldi }}>{`sustainability`}</span>
              <span>{`.`}</span>
            </span>
          </div>
          <div
            style={{
              display: "flex",
              fontSize: "24px",
              color: forestMid,
              maxWidth: "880px",
              lineHeight: 1.35,
            }}
          >
            Cow dung-based Prakritik Paint in distemper and emulsion formats. Naturally breathable, naturally Indian.
          </div>
        </div>

        {/* Bottom — product + cert row */}
        <div
          style={{
            display: "flex",
            alignItems: "center",
            justifyContent: "space-between",
          }}
        >
          <div style={{ display: "flex", gap: "12px", alignItems: "center" }}>
            {["Lead-Free", "Low-VOC", "Breathable", "Gaushala-Sourced"].map((c) => (
              <div
                key={c}
                style={{
                  display: "flex",
                  alignItems: "center",
                  gap: "8px",
                  padding: "10px 18px",
                  borderRadius: "999px",
                  border: `1.5px solid ${forest}44`,
                  background: `${forest}08`,
                  color: forest,
                  fontSize: "16px",
                  fontWeight: 700,
                }}
              >
                <span style={{ color: haldi, fontSize: "18px", display: "flex" }}>
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
              background: forest,
              color: paper,
              fontSize: "18px",
              fontWeight: 700,
            }}
          >
            {`प्राकृतिक Paint`}
          </div>
        </div>
      </div>
    ),
    { ...size, fonts }
  )
}
