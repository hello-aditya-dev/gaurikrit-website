/**
 * Calculator-grade specs for Gaurikrit paint products.
 *
 * `coverage` is in sq ft per litre per coat (tested figures, also cited in
 * the Claims Register). `pricePerLitre` is the indicative mid-band price
 * used for estimates only — real quotes come from the contact form.
 *
 * coats defaults to 2 for topcoats + 1 for primer = 3 coats total when
 * `needsPrimer` is true.
 */

export interface PaintSpec {
  id: string
  name: string
  category: "interior" | "exterior" | "natural" | "wood" | "primer"
  coverage: number // sq ft per litre per coat
  pricePerLitre: number // ₹ per litre (indicative)
  coats: number // recommended topcoats
  needsPrimer: boolean
  unit: "L"
}

export const PAINT_SPECS: PaintSpec[] = [
  {
    id: "paint-interior",
    name: "Interior Premium Emulsion",
    category: "interior",
    coverage: 140,
    pricePerLitre: 380,
    coats: 2,
    needsPrimer: true,
    unit: "L",
  },
  {
    id: "paint-exterior",
    name: "Exterior Weather Guard",
    category: "exterior",
    coverage: 120,
    pricePerLitre: 460,
    coats: 2,
    needsPrimer: true,
    unit: "L",
  },
  {
    id: "paint-natural",
    name: "Natural Turmeric Paint",
    category: "natural",
    coverage: 100,
    pricePerLitre: 580,
    coats: 2,
    needsPrimer: false,
    unit: "L",
  },
  {
    id: "paint-primer",
    name: "Bond Prime Sealer",
    category: "primer",
    coverage: 160,
    pricePerLitre: 280,
    coats: 1,
    needsPrimer: false,
    unit: "L",
  },
]

export const PRIMER_SPEC = PAINT_SPECS.find((s) => s.id === "paint-primer")!

/**
 * Estimate litres + cost for a given paint over a wall area.
 *
 * @param areaSqft wall area in square feet
 * @param spec paint spec
 * @param includePrimer whether to add a primer coat
 * @param wastagePct wastage buffer (default 10%)
 */
export function estimatePaint(
  areaSqft: number,
  spec: PaintSpec,
  includePrimer: boolean = true,
  wastagePct: number = 10
): {
  topcoatLitres: number
  primerLitres: number
  totalLitres: number
  topcoatCost: number
  primerCost: number
  totalCost: number
  buckets: { size: number; qty: number }[]
} {
  const safeArea = Math.max(0, areaSqft)
  const buffer = 1 + wastagePct / 100

  const topcoatLitres =
    spec.id === "paint-primer"
      ? (safeArea / spec.coverage) * buffer
      : (safeArea / spec.coverage) * spec.coats * buffer

  const primerLitres =
    includePrimer && spec.needsPrimer && spec.id !== "paint-primer"
      ? (safeArea / PRIMER_SPEC.coverage) * buffer
      : 0

  const totalLitres = topcoatLitres + primerLitres
  const topcoatCost = topcoatLitres * spec.pricePerLitre
  const primerCost = primerLitres * PRIMER_SPEC.pricePerLitre
  const totalCost = topcoatCost + primerCost

  // Round up to the nearest standard bucket size.
  const bucketSizes = [1, 4, 10, 20]
  const buckets = pickBuckets(totalLitres, bucketSizes)

  return {
    topcoatLitres: round(topcoatLitres),
    primerLitres: round(primerLitres),
    totalLitres: round(totalLitres),
    topcoatCost: round(topcoatCost),
    primerCost: round(primerCost),
    totalCost: round(totalCost),
    buckets,
  }
}

function pickBuckets(
  litres: number,
  sizes: number[]
): { size: number; qty: number }[] {
  const sorted = [...sizes].sort((a, b) => b - a)
  let remaining = litres
  const result: { size: number; qty: number }[] = []
  for (const size of sorted) {
    const qty = Math.floor(remaining / size)
    if (qty > 0) {
      result.push({ size, qty })
      remaining -= qty * size
    }
  }
  // round up the last fraction to the smallest bucket
  if (remaining > 0.01) {
    const smallest = sorted[sorted.length - 1]
    const existing = result.find((b) => b.size === smallest)
    if (existing) existing.qty += 1
    else result.push({ size: smallest, qty: 1 })
  }
  return result
}

function round(n: number): number {
  return Math.round(n * 10) / 10
}

export function formatINR(amount: number): string {
  return new Intl.NumberFormat("en-IN", {
    style: "currency",
    currency: "INR",
    maximumFractionDigits: 0,
  }).format(amount)
}
