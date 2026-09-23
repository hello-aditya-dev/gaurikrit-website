/**
 * Application guide cards for Gaurikrit Prakritik Paint.
 * Each guide has 3–4 steps. Used in the GuideCarousel section.
 */

export interface GuideStep {
  title: string
  detail: string
}

export interface Guide {
  id: string
  productId: string
  title: string
  subtitle: string
  duration: string
  serves: string
  accent: string // CSS color for the visual accent
  steps: GuideStep[]
}

export const GUIDES: Guide[] = [
  {
    id: "prep-limewash-primer",
    productId: "prakritik-distemper",
    title: "Prepare & prime the wall",
    subtitle: "Limewash primer coat",
    duration: "30 min",
    serves: "Per wall",
    accent: "oklch(0.62 0.08 45)",
    steps: [
      { title: "Clean the wall", detail: "Brush off loose dust and lime. Patch cracks with a lime-mortar mix; let cure 24 hours." },
      { title: "Dampen the surface", detail: "Lightly mist the wall with water so it accepts the primer evenly. No standing water." },
      { title: "Apply limewash primer", detail: "Roll one thin coat of Prakritik Limewash Primer. Coverage ~160 sq ft per kg." },
      { title: "Let it set", detail: "Wait 4–6 hours until dry to a soft matte. Do not let the wall freeze during curing." },
    ],
  },
  {
    id: "distemper-two-coats",
    productId: "prakritik-distemper",
    title: "Apply Prakritik Distemper",
    subtitle: "Two-coat interior finish",
    duration: "2–3 hr",
    serves: "Per wall",
    accent: "oklch(0.78 0.15 80)",
    steps: [
      { title: "Mix the distemper", detail: "Gradually add clean water to Prakritik Distemper powder while stirring to a lump-free, brushable consistency." },
      { title: "First coat", detail: "Roll the first coat evenly. Work top-to-bottom in 3-ft sections. Coverage ~130 sq ft/kg/coat." },
      { title: "Let it dry", detail: "Wait 2–4 hours until touch-dry. The wall will deepen to a soft matte." },
      { title: "Second coat", detail: "Apply the second coat at right angles to the first for an even, breathable finish." },
    ],
  },
  {
    id: "emulsion-exterior",
    productId: "prakritik-emulsion",
    title: "Apply Prakritik Emulsion",
    subtitle: "Interior & sheltered exterior",
    duration: "2–3 hr",
    serves: "Per wall",
    accent: "oklch(0.42 0.05 150)",
    steps: [
      { title: "Stir, do not thin", detail: "Stir Prakritik Emulsion well. Do not over-thin with water — it is ready to apply." },
      { title: "First coat", detail: "Roll one even coat. Coverage ~150 sq ft per litre per coat. Keep a wet edge." },
      { title: "Let it flash-off", detail: "Wait 3–5 hours until touch-dry. The finish deepens as it sets." },
      { title: "Second coat", detail: "Apply the second coat cross-grain. Allow 24 hours before wiping or touching." },
    ],
  },
]
