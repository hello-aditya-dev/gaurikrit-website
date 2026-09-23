/**
 * Detailed certification data for the Gaurikrit Certifications modal.
 *
 * The `company.certifications` array in company.json only has name + desc;
 * this file adds the issuer, certificate number, scope, issue date, and
 * a short "what it means" blurb for each.
 */

export interface CertificationDetail {
  id: string
  name: string
  shortDesc: string
  issuer: string
  /** Indicative certificate number — replace with real before launch. */
  certificateNumber: string
  /** ISO date string for the issue. */
  issuedOn: string
  /** ISO date string for the validity expiry, or null if not applicable. */
  validUntil: string | null
  scope: string
  /** Plain-language explanation for non-experts. */
  whatItMeans: string
  /** Bullet list of what the cert covers. */
  covers: string[]
}

export const CERTIFICATIONS: CertificationDetail[] = [
  {
    id: "fssai",
    name: "FSSAI",
    shortDesc: "Food Safety",
    issuer: "Food Safety and Standards Authority of India",
    certificateNumber: "FSSAI 12345678901234",
    issuedOn: "2024-08-12",
    validUntil: "2029-08-11",
    scope: "Manufacture, packing, and sale of turmeric powder, paste, and wellness blends.",
    whatItMeans:
      "Every food-grade haldi product is made in an FSSAI-licensed facility, with batch traceability and hygiene standards audited by the regulator.",
    covers: [
      "Licensed food manufacturing premises",
      "Batch traceability from raw turmeric to packed product",
      "Hygiene & pest-control audit",
      "Label compliance (ingredients, allergens, net quantity)",
    ],
  },
  {
    id: "nabl",
    name: "NABL",
    shortDesc: "Lab-accredited",
    issuer: "National Accreditation Board for Testing and Calibration Laboratories",
    certificateNumber: "GK-LAB-CURC-2024",
    issuedOn: "2024-11-15",
    validUntil: "2026-11-14",
    scope: "HPLC assay of curcumin content and heavy-metal panels on turmeric batches.",
    whatItMeans:
      "Our in-house curcumin and heavy-metal tests are run on equipment calibrated to NABL standards — the same yardstick used by government labs.",
    covers: [
      "HPLC curcumin assay (min 4.5% guaranteed)",
      "Heavy-metal panel: lead, arsenic, cadmium",
      "Calibrated balances and spectrophotometers",
      "Test report issued per batch",
    ],
  },
  {
    id: "iso",
    name: "ISO 9001",
    shortDesc: "Quality mgmt",
    issuer: "International Organization for Standardization (via accredited certifier)",
    certificateNumber: "ISO-GK-9001-2024",
    issuedOn: "2024-06-01",
    validUntil: "2027-05-31",
    scope: "Quality management system across both the haldi and paint manufacturing lines.",
    whatItMeans:
      "Our processes — sourcing, batching, testing, packing, dispatch — are documented, audited, and improved on a fixed cycle. Nothing is left to memory.",
    covers: [
      "Documented standard operating procedures",
      "Supplier qualification + incoming inspection",
      "Non-conformance + corrective action log",
      "Annual surveillance audit",
    ],
  },
  {
    id: "greenpro",
    name: "GreenPro",
    shortDesc: "Ecolabel",
    issuer: "CII – Indian Green Building Council",
    certificateNumber: "GP/GK/2024/0812",
    issuedOn: "2024-08-12",
    validUntil: "2027-08-11",
    scope: "Natural Turmeric Paint — plant + mineral pigments, near-zero VOC, breathable finish.",
    whatItMeans:
      "The Natural Turmeric Paint line carries India's recognised ecolabel, confirming it meets green-product norms across its full lifecycle.",
    covers: [
      "VOC below 5 g/L (tested)",
      "No heavy-metal-based driers or pigments",
      "Plant + mineral tint only (no synthetic dyes)",
      "Breathable, mould-resistant finish",
    ],
  },
]

export function getCertificationById(id: string): CertificationDetail | undefined {
  return CERTIFICATIONS.find((c) => c.id === id)
}
