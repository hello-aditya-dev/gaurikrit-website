# ZAI Master Prompt — Gaurikrit Website

This is the master prompt used to drive the Z.ai Code build of the Gaurikrit website.
A copy lives at the repo root as `ZAI_MASTER_PROMPT_COPY_ME.md`.

## Build directive

Build a single-route (`/`) Next.js 16 marketing website for **Gaurikrit**, an Indian brand producing **naturally crafted Haldi (turmeric)** and **premium paint** products. The aesthetic is turmeric-gold warmth meeting disciplined black-and-white structure.

## Constraints (non-negotiable)

- Next.js 16 App Router, TypeScript, Tailwind CSS 4, shadcn/ui, Prisma + SQLite.
- Only `/` is user-visible. All content lives in sections on the homepage.
- English copy only.
- No indigo/blue. Turmeric gold + charcoal + paper white.
- Reuse existing shadcn/ui components in `src/components/ui`.
- Sticky footer (`min-h-screen flex flex-col` root, `mt-auto` footer).
- Framer Motion for scroll reveals + hover lifts; respect `prefers-reduced-motion`.
- Full dark mode via `next-themes`.
- z-ai-web-dev-sdk only on the server.

## Sections (top to bottom)

1. Header (sticky, transparent→solid, mobile sheet)
2. Hero (full-viewport, dual CTA, floating product cards, scroll cue)
3. Trust bar (4 stats + certifications)
4. About (story + founder note)
5. Products (tab filter All/Haldi/Paint, card grid, detail dialog)
6. Why Gaurikrit (6 feature cards)
7. Process (4-step Source → Deliver)
8. Claims Register (searchable table, every claim sourced)
9. Testimonials (3 quotes)
10. FAQ (accordion, 8 items)
11. Contact + Newsletter (forms persisted to SQLite)
12. Footer (sticky bottom, 4 columns, legal bar)

## Data

- Read static content from `src/data/*.json` (company, products, navigation, claims).
- Persist leads via `/api/contact`, `/api/newsletter`, `/api/inquiry`.
- Products also exposed at `/api/products` for future headless use.

## Verification (mandatory before "done")

- `bun run lint` clean.
- Dev server on port 3000.
- `agent-browser` golden path: load, nav, tabs, dialog, claims search, contact submit (invalid + valid), newsletter, theme toggle, mobile sheet, sticky footer on short + long pages.
- Fix everything the browser surfaces.

## Ship

- Commit.
- Create GitHub repo.
- Push.
- Set a 15-minute `webDevReview` cron for continuous improvement.
