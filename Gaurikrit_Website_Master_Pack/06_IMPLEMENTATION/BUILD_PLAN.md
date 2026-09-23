# Build Plan

## Phase 0 — Foundation (manual)
- [x] Master pack folders created
- [ ] Design tokens in `globals.css` (turmeric gold, charcoal, paper; light + dark)
- [ ] Fonts: Playfair Display + Inter via `next/font`
- [ ] `next-themes` ThemeProvider in `layout.tsx`
- [ ] Root `<SiteShell>` with `min-h-screen flex flex-col`

## Phase 1 — Content layer
- [ ] `src/data/company.json`
- [ ] `src/data/products.json` (8 products: 3 Haldi + 5 Paint)
- [ ] `src/data/navigation.json`
- [ ] `src/data/claims-register.json` (12 claims)
- [ ] `src/lib/data.ts` typed loaders
- [ ] `src/types/index.ts`

## Phase 2 — Database + APIs
- [ ] `prisma/schema.prisma`: ContactMessage, NewsletterSubscriber, ProductInquiry
- [ ] `bun run db:push`
- [ ] `src/lib/validations.ts` zod schemas
- [ ] `src/app/api/contact/route.ts`
- [ ] `src/app/api/newsletter/route.ts`
- [ ] `src/app/api/inquiry/route.ts`
- [ ] `src/app/api/products/route.ts`

## Phase 3 — Layout + Header
- [ ] `components/layout/` SiteShell, Container, Section
- [ ] `components/header/` SiteHeader (sticky + scroll state), Nav, MobileNav (Sheet), ThemeToggle
- [ ] `components/footer/SiteFooter` (sticky bottom via `mt-auto`)

## Phase 4 — Sections (can parallelise)
- [ ] Hero + TrustBar
- [ ] About
- [ ] Products + ProductCard + ProductDialog
- [ ] Features
- [ ] Process
- [ ] ClaimsRegister (client filter)
- [ ] Testimonials
- [ ] FAQ (Accordion)
- [ ] ContactSection + ContactForm + NewsletterForm

## Phase 5 — Assembly
- [ ] `src/app/page.tsx` imports all sections
- [ ] `layout.tsx` metadata + ThemeProvider + Toaster

## Phase 6 — Verify
- [ ] `bun run lint` clean
- [ ] `bun run dev` starts on 3000
- [ ] `agent-browser` golden path: load, nav, tabs, dialog, claims search, contact submit, newsletter, dark mode, mobile sheet, sticky footer

## Phase 7 — Ship
- [ ] Commit
- [ ] Create GitHub repo
- [ ] Push
- [ ] Set 15-min webDevReview cron
