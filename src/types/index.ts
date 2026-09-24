export type Accent = "forest" | "haldi" | "mitti" | "charcoal"

export interface CompanyStats {
  value: string
  numericValue?: number
  suffix?: string
  prefix?: string
  decimals?: number
  label: string
}

export interface CompanyCertification {
  name: string
  desc: string
}

export interface CompanyAboutCard {
  title: string
  desc: string
}

export interface CompanySocial {
  name: string
  href: string
  handle: string
}

export interface CompanyContact {
  address: string
  phone: string
  email: string
  hours: string
}

export interface CompanyData {
  name: string
  fullName?: string
  legalName?: string
  devanagari?: string
  supportingIdentity?: string
  tagline: string
  foundedYear: number
  hero: {
    eyebrow: string
    headlineLines: string[]
    subheadline: string
    primaryCta: { label: string; href: string }
    secondaryCta: { label: string; href: string }
    seal: { label: string; sublabel: string }
  }
  story: {
    lead: string
    body: string
    founderQuote: string
    founderName: string
    founderRole: string
  }
  stats: CompanyStats[]
  marquee?: string[]
  certifications: CompanyCertification[]
  aboutCards: CompanyAboutCard[]
  contact: CompanyContact
  socials: CompanySocial[]
}

export interface NavLink {
  label: string
  href: string
}

export interface NavigationData {
  primary: NavLink[]
  cta: { label: string; href: string }
  footer: {
    company: NavLink[]
    products: NavLink[]
    support: NavLink[]
  }
}

export interface ProductCategory {
  id: string
  label: string
}

export interface Product {
  id: string
  name: string
  category: "distemper" | "emulsion"
  categoryLabel: string
  tagline: string
  description: string
  usage: string
  sizes: string[]
  priceRange: string
  highlights: string[]
  claims: string[]
  image: string
  accent: Accent
  featured?: boolean
}

export interface ProductsData {
  categories: ProductCategory[]
  items: Product[]
}

export interface ClaimCategory {
  id: string
  label: string
}

export interface Claim {
  id: string
  claim: string
  category: "material" | "performance" | "safety"
  categoryLabel: string
  source: string
  reference: string
  verifiedOn: string
}

export interface ClaimsData {
  categories: ClaimCategory[]
  items: Claim[]
}
