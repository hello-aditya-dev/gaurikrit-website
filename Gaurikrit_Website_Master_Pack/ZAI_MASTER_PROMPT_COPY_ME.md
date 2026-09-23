# ZAI Master Prompt — Gaurikrit Website Build

Copy this prompt into Z.ai Code to drive the end-to-end build.

---

## Context

You are building the public marketing website for **Gaurikrit**, an Indian brand that produces two product families:

1. **Haldi (Turmeric) products** — naturally derived, traditionally crafted turmeric powder, pastes, and wellness variants.
2. **Paint products** — premium interior, exterior, and specialty paints, including a signature turmeric-infused natural paint line.

The brand identity is captured in the supplied "Black & White" and "Haldi & Black" PDFs. The aesthetic is **turmeric-gold warmth meeting disciplined black-and-white structure** — premium, warm, trustworthy, and industrial-grade.

## Goal

Ship a single-route (`/`), production-ready Next.js 16 website that:

- Tells the Gaurikrit brand story end-to-end on one scrollable page.
- Showcases both Haldi and Paint product families with category filtering.
- Captures leads via a contact form and newsletter signup (persisted to SQLite via Prisma).
- Surfaces a "Claims Register" so every marketing claim is backed by a source.
- Answers common questions in an FAQ.
- Is fully responsive, accessible, dark-mode aware, and animated with restraint.
- Is SEO-optimised and fast.

## Non-negotiables

- **Framework:** Next.js 16 App Router, TypeScript, Tailwind CSS 4, shadcn/ui.
- **Single route:** Only `/` is user-visible. Everything lives on the homepage in sections.
- **Database:** Prisma + SQLite. Models: `ContactMessage`, `NewsletterSubscriber`, `ProductInquiry`.
- **APIs:** `/api/contact`, `/api/newsletter`, `/api/inquiry`, `/api/products` — all server-side.
- **Design tokens:** Turmeric gold (`oklch(0.78 0.16 75)`-ish), charcoal black, paper white. No indigo/blue.
- **Layout:** `min-h-screen flex flex-col` root, footer pushed with `mt-auto`.
- **Components:** Reuse the existing shadcn/ui set in `src/components/ui`. Do not rebuild primitives.
- **Motion:** Framer Motion, subtle — fade/slide on scroll, hover lifts. Respect `prefers-reduced-motion`.
- **Content language:** English throughout.
- **Accessibility:** Semantic HTML, ARIA labels, 44px touch targets, alt text, keyboard reachable.

## Information architecture (single-page sections, in order)

1. **Header** — sticky, transparent-over-hero, solid-on-scroll. Logo, nav (Home, About, Products, Claims, FAQ, Contact), CTA "Get a Quote". Mobile: sheet menu.
2. **Hero** — full-viewport. Headline, subhead, dual CTAs (Explore Products, Talk to Us). Floating product cards / gold accent. Scroll cue.
3. **Trust bar** — certifications / stats strip (years, homes painted, SKUs, pin-codes served).
4. **About** — brand story, the haldi-meets-paint philosophy, founder note, two-column with image.
5. **Products** — tabbed/filterable catalogue. Tabs: All / Haldi / Paint. Each product card: image, name, tagline, size, "View details" (opens dialog with full description, usage, claims).
6. **Why Gaurikrit (Features)** — 6 feature cards: Naturally Crafted, Lab-Tested Purity, 100% Coverage, Low-VOC, Heritage Recipe, Pan-India Delivery.
7. **Process** — 4-step horizontal stepper: Source → Craft → Test → Deliver.
8. **Claims Register** — searchable/filterable table of claims, each with source + reference ID. This is the trust engine.
9. **Testimonials** — 3 quotes from homeowners, contractors, retailers.
10. **FAQ** — accordion, 8 questions.
11. **Contact + Newsletter** — two-column: contact form (name, email, phone, product interest, message) + newsletter signup (email only).
12. **Footer** — sticky to bottom. Brand blurb, quick links, contact, social, legal, copyright.

## Content sources

All copy and product data must be read from `05_CONTENT_DATA/*.json`:

- `company.json` — brand name, tagline, story, stats, contact, social.
- `products.json` — full catalogue with category, name, tagline, description, sizes, price, claims, image hints.
- `navigation.json` — nav items and section anchors.
- `claims-register.json` — every claim with `id`, `claim`, `category`, `source`, `reference`, `verifiedOn`.

## Build sequence (do not skip)

1. Lock the design system in `globals.css` (turmeric gold, charcoal, paper). Wire `next-themes`.
2. Write the four JSON content files.
3. Update `prisma/schema.prisma` with the three models. Run `bun run db:push`.
4. Build the API routes (server-side, Zod validation).
5. Build the section components bottom-up: Header, Hero, TrustBar, About, Products, Features, Process, Claims, Testimonials, FAQ, Contact, Newsletter, Footer.
6. Assemble `src/app/page.tsx` with all sections + a sticky footer layout.
7. Lint, start dev server, self-verify with `agent-browser` (load, click, scroll, submit, responsive, dark mode).
8. Fix every issue surfaced by the browser.
9. Commit and push to GitHub.

## Self-verification (mandatory)

Before reporting done, use `agent-browser` to:

- Load `/` and confirm no blank screen / hydration error.
- Click every nav anchor and confirm smooth scroll.
- Toggle the Products filter tabs and confirm the list updates.
- Open a product dialog and confirm claims render.
- Submit the contact form with invalid then valid data; confirm toast + DB row.
- Subscribe to the newsletter; confirm toast + DB row.
- Search the Claims Register; confirm filtering.
- Toggle dark mode; confirm contrast.
- Resize to mobile; confirm the sheet menu opens.
- Confirm the footer sticks to the bottom on short and long pages.

Only after all of the above pass may you report completion.
