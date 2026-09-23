# Component System

## Layout primitives
- `<SiteShell>` — `min-h-screen flex flex-col` root, holds Header + main + Footer.
- `<Container>` — `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`.
- `<Section>` — `py-20 md:py-28` wrapper, optional `id`, optional `tone` (paper/charcoal/gold-tint).

## Header
- `<SiteHeader />` — sticky, transparent over hero, solid after 24px scroll (IntersectionObserver on hero sentinel).
- `<Nav />` — desktop links.
- `<MobileNav />` — Sheet with menu.
- `<ThemeToggle />` — sun/moon button.

## Sections (one component each)
- `<Hero />`
- `<TrustBar />`
- `<About />`
- `<Products />` + `<ProductCard />` + `<ProductDialog />`
- `<Features />` + `<FeatureCard />`
- `<Process />` + `<ProcessStep />`
- `<ClaimsRegister />` + `<ClaimsTable />`
- `<Testimonials />` + `<TestimonialCard />`
- `<Faq />`
- `<ContactSection />` + `<ContactForm />` + `<NewsletterForm />`
- `<SiteFooter />`

## UI atoms (reuse shadcn/ui)
- `Button`, `Card`, `Input`, `Textarea`, `Label`, `Select`, `Tabs`, `Dialog`, `Accordion`, `Table`, `Badge`, `Sheet`, `Toast`/`Sonner`, `Tooltip`, `Avatar`.

## Data hooks (TanStack Query or direct fetch)
- `useProducts(category?)` — GET `/api/products`.
- `useClaims(query)` — client filter on bundled JSON for v1 (no DB needed for claims).

## Form patterns
- `react-hook-form` + `zod` resolver.
- On submit: POST `/api/contact` or `/api/newsletter` or `/api/inquiry`.
- Toast on success/error via `sonner`.
- Honeypot field `company` (hidden) — reject if filled.
