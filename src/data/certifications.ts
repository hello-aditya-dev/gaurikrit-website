/**
 * Certification detail data for Gaurikrit Bio Products.
 *
 * These are indicative for v1 — replace with real certificate numbers
 * before public launch.
 */

export interface CertificationDetail {
  id: string
  name: string
  shortDesc: string
  issuer: string
  certificateNumber: string
  issuedOn: string
  validUntil: string | null
  scope: string
  whatItMeans: string
  covers: string[]
}

export const CERTIFICATIONS: CertificationDetail[] = [
  {
    id: "lead-free",
    name: "Lead-Free",
    shortDesc: "No lead, ever",
    issuer: "BIS lead-content test",
    certificateNumber: "GK-PB-2024-002",
    issuedOn: "2024-10-05",
    validUntil: null,
    scope: "All Prakritik Paint products — distemper and emulsion.",
    whatItMeans:
      "No lead or lead-based driers are used in any Prakritik Paint product. Lead-free is tested, not just claimed.",
    covers: [
      "No lead in pigments or driers",
      "No lead-based dryers in binder",
      "Tested per BIS norms",
      "Applies across distemper + emulsion lines",
    ],
  },
  {
    id: "low-voc",
    name: "Low-VOC",
    shortDesc: "Solvent-light",
    issuer: "VOC screen + formulation declaration",
    certificateNumber: "GK-VOC-2024-03",
    issuedOn: "2024-10-20",
    validUntil: null,
    scope: "Prakritik Distemper and Emulsion — both formats.",
    whatItMeans:
      "No solvent-heavy VOC binders. The formulation is lime and plant-pigment based, so you can move back into the room the same day.",
    covers: [
      "No solvent-heavy VOC binders",
      "Lime-based formulation",
      "Plant + mineral pigments only",
      "Same-day re-entry suitable",
    ],
  },
  {
    id: "breathable",
    name: "Breathable",
    shortDesc: "Lime-based",
    issuer: "Water-vapour transmission test",
    certificateNumber: "GK-BREATH-2024-04",
    issuedOn: "2024-09-20",
    validUntil: null,
    scope: "Both Prakritik Paint formats, on interior and sheltered exterior walls.",
    whatItMeans:
      "The lime + cow-dung binder lets water vapour pass through the paint film, so walls breathe and trapped moisture does not blister the finish.",
    covers: [
      "Water-vapour transmission tested",
      "Reduces blistering + peeling",
      "Lime binder heritage",
      "Suitable for damp-prone walls",
    ],
  },
  {
    id: "gaushala-sourced",
    name: "Gaushala-Sourced",
    shortDesc: "Cow-dung based",
    issuer: "Gaushala sourcing + reconciliation log",
    certificateNumber: "GK-GS-2024-12",
    issuedOn: "2024-09-12",
    validUntil: null,
    scope: "Cow dung feedstock used across both Prakritik Paint products.",
    whatItMeans:
      "The cow dung binder is sourced from partner gaushalas with documented material logs — turning a waste stream into a building material.",
    covers: [
      "Partner gaushala sourcing",
      "Material reconciliation log",
      "Waste-to-material approach",
      "Rural supply chain",
    ],
  },
]

export function getCertificationById(id: string): CertificationDetail | undefined {
  return CERTIFICATIONS.find((c) => c.id === id)
}
