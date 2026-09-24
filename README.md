# Gaurikrit — Naturally Crafted Haldi & Premium Paint

> The public marketing website for **Gaurikrit**, an Indian brand producing naturally crafted turmeric (haldi) and premium, low-VOC paint products. Built end-to-end with Next.js 16, TypeScript, Tailwind CSS 4, shadcn/ui, and Prisma.

[![Built with Next.js 16](https://img.shields.io/badge/Next.js-16-black)](https://nextjs.org/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5-blue)](https://www.typescriptlang.org/)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind-4-38bdf8)](https://tailwindcss.com/)
[![Prisma](https://img.shields.io/badge/Prisma-SQLite-2d3748)](https://www.prisma.io/)

---

## What this is

A single-route (`/`), production-ready marketing website for Gaurikrit. The entire brand story lives on one scrollable page, split into twelve sections — hero, trust bar, about, products, features, process, claims register, testimonials, FAQ, contact, and footer.

The design language is **turmeric-gold warmth meeting disciplined black-and-white structure** — premium, warm, trustworthy, and industrial-grade.

## Features

- **Two product families, one brand** — Haldi (turmeric) + Paint, filterable catalogue with detail dialogs.
- **Claims Register** — every marketing claim is published with a source and reference ID, searchable and filterable.
- **Lead capture** — contact form + product-specific enquiry + newsletter, all persisted to SQLite via Prisma.
- **Dark mode** — full light/dark support via `next-themes`, default light.
- **Motion with restraint** — Framer Motion scroll reveals + hover lifts, gated on `prefers-reduced-motion`.
- **Responsive & accessible** — mobile-first, 44px touch targets, semantic HTML, ARIA, keyboard navigation.
- **SEO-ready** — metadata, OpenGraph, Twitter cards, JSON-LD Organization schema.

## Tech stack

| Layer | Choice |
|-------|--------|
| Framework | Next.js 16 (App Router, Turbopack) |
| Language | TypeScript 5 (strict) |
| Styling | Tailwind CSS 4 + shadcn/ui (New York) |
| Database | Prisma ORM + SQLite |
| Forms | react-hook-form + zod |
| Motion | Framer Motion |
| Theme | next-themes |
| Icons | lucide-react |

## Getting started

```bash
# install
bun install

# push the database schema
bun run db:push

# start the dev server (http://localhost:3000)
bun run dev
```

Environment: a `.env` file with `DATABASE_URL=file:/home/z/my-project/db/custom.db` (already present).

## Project structure

```
src/
├── app/
│   ├── layout.tsx          # Root layout, fonts, ThemeProvider, JSON-LD
│   ├── page.tsx            # Single-page section assembly
│   ├── globals.css         # Turmeric-gold + charcoal design tokens
│   └── api/                # contact, newsletter, inquiry, products
├── components/
│   ├── ui/                 # shadcn primitives
│   ├── layout/             # SiteShell, Container, Section, SectionHeading
│   ├── header/             # SiteHeader, sticky + mobile sheet
│   ├── sections/           # Hero, TrustBar, About, Products, Features, Process,
│   │                       # ClaimsRegister, Testimonials, Faq, ContactSection, SiteFooter
│   ├── product/            # ProductVisual (SVG), ProductCard, ProductDialog
│   ├── theme-provider.tsx
│   └── theme-toggle.tsx
├── data/                   # company.json, products.json, navigation.json, claims-register.json
├── lib/                    # db, data loaders, validations, rate-limit, utils
├── hooks/                  # use-toast, use-mobile
└── types/                  # shared TS types
```

## The Master Pack

The `Gaurikrit_Website_Master_Pack/` directory is the full strategy + design + content + implementation dossier that drove this build:

```
Gaurikrit_Website_Master_Pack/
├── 00_SOURCE_ASSETS/      Original briefs, brochures, brand PDFs
├── 01_STRATEGY/           Locked decisions, IA, user journeys
├── 02_DESIGN/             Design system, page blueprints, components
├── 03_MOTION_INTERACTIONS/ Motion spec, responsive & accessibility
├── 04_TECHNICAL/          Architecture, data/forms/analytics, perf/SEO/security
├── 05_CONTENT_DATA/       company / products / navigation / claims JSON
├── 06_IMPLEMENTATION/     Build plan, QA acceptance, client inputs
├── 07_RESEARCH/           Official research, source inventory
├── 08_ZAI_PROMPT/         Master prompt for the AI build
├── ASSET_MANIFEST.json
├── README.md
└── ZAI_MASTER_PROMPT_COPY_ME.md
```

Read `Gaurikrit_Website_Master_Pack/ZAI_MASTER_PROMPT_COPY_ME.md` end-to-end to understand the build directive.

## Brand promise

> *Gaurikrit brings the golden warmth of haldi and the precision of premium paint into every Indian home — naturally crafted, scientifically trusted.*

## License

© Gaurikrit Naturals & Coatings Pvt. Ltd. All rights reserved.
