import companyJson from "@/data/company.json"
import navigationJson from "@/data/navigation.json"
import productsJson from "@/data/products.json"
import claimsJson from "@/data/claims-register.json"
import type {
  CompanyData,
  NavigationData,
  ProductsData,
  ClaimsData,
  Product,
  Claim,
} from "@/types"

export const company = companyJson as CompanyData
export const navigation = navigationJson as NavigationData
export const productsData = productsJson as ProductsData
export const claimsData = claimsJson as ClaimsData

export const allProducts: Product[] = productsData.items
export const allClaims: Claim[] = claimsData.items

export function getProductById(id: string): Product | undefined {
  return allProducts.find((p) => p.id === id)
}

export function getClaimById(id: string): Claim | undefined {
  return allClaims.find((c) => c.id === id)
}

export function getClaimsByIds(ids: string[]): Claim[] {
  return ids
    .map((id) => getClaimById(id))
    .filter((c): c is Claim => Boolean(c))
}
