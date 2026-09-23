# Technical Architecture

## Stack (locked)
- **Framework:** Next.js 16 App Router
- **Language:** TypeScript 5 (strict)
- **Styling:** Tailwind CSS 4 + shadcn/ui (New York)
- **DB:** Prisma ORM + SQLite
- **Forms:** react-hook-form + zod
- **State:** Zustand (client UI), TanStack Query (server)
- **Motion:** Framer Motion
- **Theme:** next-themes
- **AI SDK:** z-ai-web-dev-sdk (server-only, ready for future chatbot/FAQ)

## Project layout (within `src/`)
```
src/
├── app/
│   ├── layout.tsx          # Root layout, fonts, ThemeProvider, Toaster
│   ├── page.tsx            # Single-page assembly
│   ├── globals.css         # Design tokens
│   └── api/
│       ├── contact/route.ts
│       ├── newsletter/route.ts
│       ├── inquiry/route.ts
│       └── products/route.ts
├── components/
│   ├── ui/                 # shadcn primitives (existing)
│   ├── layout/             # SiteShell, Container, Section
│   ├── header/             # SiteHeader, Nav, MobileNav, ThemeToggle
│   ├── sections/           # Hero, About, Products, ... SiteFooter
│   └── product/            # ProductCard, ProductDialog
├── lib/
│   ├── db.ts               # Prisma client (existing)
│   ├── utils.ts            # cn() (existing)
│   ├── data.ts             # typed loaders for content JSON
│   └── validations.ts     # zod schemas
├── hooks/                  # use-toast, use-mobile (existing) + custom
├── data/                   # company.json, products.json, navigation.json, claims-register.json (bundled)
└── types/                  # shared TS types
```

## Data flow
- **Static content** (company, products, navigation, claims) → `src/data/*.json` imported directly by components. No DB for read paths.
- **Lead capture** (contact, newsletter, inquiry) → POST to API → Prisma → SQLite.
- **Products API** → returns the bundled JSON (enables future headless/CMS swap).

## Security
- Zod validation on every API body.
- Honeypot field `company` on contact form — 400 if filled.
- Rate limit: in-memory token bucket (per-IP), 5/min on form endpoints.
- No raw SQL. Prisma parameterised.
- Environment: `DATABASE_URL` from `.env`. No secrets in client.

## Build/deploy
- `bun run dev` for local (port 3000).
- `bun run lint` for quality gate.
- Single route `/` — no SSG of other routes needed.
- Static assets in `/public`.

## Extensibility hooks
- Swap `src/data/*.json` for a CMS later without touching components.
- Products API ready for pagination/filter when catalogue grows.
- `z-ai-web-dev-sdk` available for a future AI concierge.
