/**
 * Calculator-grade specs for Gaurikrit Prakritik Paint products.
 *
 * `coverage` is in sq ft per unit (kg for distemper, L for emulsion) per coat.
 * `pricePerUnit` is the indicative mid-band price used for estimates only.
 */

export interface PaintSpec {
  id: string
  name: string
  category: "distemper" | "emulsion"
  /** Coverage in sq ft per unit per coat */
  coverage: number
  /** Price per unit (₹, indicative) */
  pricePerUnit: number
  /** Recommended topcoats */
  coats: number
  /** Whether a primer coat is recommended */
  needsPrimer: boolean
  /** Display unit */
  unit: "kg" | "L"
  /** Pack sizes available */
  packSizes: number[]
}

export const PAINT_SPECS: PaintSpec[] = [
  {
    id: "prakritik-distemper",
    name: "Prakritik Distemper",
    category: "distemper",
    coverage: 130,
    pricePerUnit: 180,
    coats: 2,
    needsPrimer: true,
    unit: "kg",
    packSizes: [5, 10, 20],
  },
  {
    id: "prakritik-emulsion",
    name: "Prakritik Emulsion",
    category: "emulsion",
    coverage: 150,
    pricePerUnit: 360,
    coats: 2,
    needsPrimer: true,
    unit: "L",
    packSizes: [1, 4, 10, 20],
  },
]

export const PRIMER_SPEC: PaintSpec = {
  id: "prakritik-primer",
  name: "Prakritik Limewash Primer",
  category: "distemper",
  coverage: 160,
  pricePerUnit: 140,
  coats: 1,
  needsPrimer: false,
  unit: "kg",
  packSizes: [5, 10, 20],
}

/**
 * Estimate paint + cost for a given wall area.
 */
export function estimatePaint(
  areaSqft: number,
  spec: PaintSpec,
  includePrimer: boolean = true,
  wastagePct: number = 10
): {
  topcoatUnits: number
  primerUnits: number
  totalUnits: number
  topcoatCost: number
  primerCost: number
  totalCost: number
  buckets: { size: number; qty: number }[]
  unitLabel: string
} {
  const safeArea = Math.max(0, areaSqft)
  const buffer = 1 + wastagePct / 100

  const topcoatUnits = (safeArea / spec.coverage) * spec.coats * buffer
  const primerUnits =
    includePrimer && spec.needsPrimer
      ? (safeArea / PRIMER_SPEC.coverage) * buffer
      : 0

  const totalUnits = topcoatUnits + primerUnits
  const topcoatCost = topcoatUnits * spec.pricePerUnit
  const primerCost = primerUnits * PRIMER_SPEC.pricePerUnit
  const totalCost = topcoatCost + primerCost

  const buckets = pickBuckets(topcoatUnits, spec.packSizes)
  const unitLabel = spec.unit

  return {
    topcoatUnits: round(topcoatUnits),
    primerUnits: round(primerUnits),
    totalUnits: round(totalUnits),
    topcoatCost: round(topcoatCost),
    primerCost: round(primerCost),
    totalCost: round(totalCost),
    buckets,
    unitLabel,
  }
}

function pickBuckets(
  units: number,
  sizes: number[]
): { size: number; qty: number }[] {
  const sorted = [...sizes].sort((a, b) => b - a)
  let remaining = units
  const result: { size: number; qty: number }[] = []
  for (const size of sorted) {
    const qty = Math.floor(remaining / size)
    if (qty > 0) {
      result.push({ size, qty })
      remaining -= qty * size
    }
  }
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
