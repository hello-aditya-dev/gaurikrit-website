# Gaurikrit Website Build — Worklog

This is the shared worklog for all agents building the Gaurikrit website.
Each agent appends a section after finishing its Task ID.

---
Task ID: 0
Agent: main
Task: Project setup, foundation, design system, data, DB, APIs, layout primitives, header, footer, product visuals.

Work Log:
- Created `Gaurikrit_Website_Master_Pack/` with full strategy/design/technical/content/implementation/research docs.
- Wrote `src/app/globals.css` with turmeric-gold + charcoal + paper white tokens (light + dark), custom utilities (`gold-gradient`, `gold-text-gradient`, `shadow-gold`, `bg-grain`).
- Created `src/components/theme-provider.tsx` + `src/components/theme-toggle.tsx`.
- Updated `src/app/layout.tsx`: Inter + Playfair Display + Geist Mono fonts, JSON-LD Organization, full metadata, ThemeProvider + Sonner Toaster.
- Created data layer: `src/data/company.json`, `navigation.json`, `products.json` (8 products: 3 Haldi + 5 Paint), `claims-register.json` (12 claims).
- Copied data JSONs into `Gaurikrit_Website_Master_Pack/05_CONTENT_DATA/`.
- Created `src/types/index.ts` (CompanyData, NavigationData, ProductsData, ClaimsData + sub-types).
- Created `src/lib/data.ts` (typed loaders: `company`, `navigation`, `productsData`, `claimsData`, helpers).
- Updated `prisma/schema.prisma` with `ContactMessage`, `NewsletterSubscriber`, `ProductInquiry` (+ existing `User`). Ran `bun run db:push` successfully.
- Created `src/lib/validations.ts` (Zod schemas for contact / newsletter / inquiry).
- Created `src/lib/rate-limit.ts` (in-memory token bucket, 5/min per IP).
- Created API routes: `/api/contact` (POST + GET), `/api/newsletter` (POST, upsert), `/api/inquiry` (POST), `/api/products` (GET with category filter).
- Created layout primitives: `src/components/layout/site-shell.tsx` (`SiteShell`, `Container`, `Section`, `SectionHeading`).
- Created `src/components/header/site-header.tsx` (sticky, transparent→solid on scroll, desktop nav, mobile Sheet menu, theme toggle, CTA).
- Created `src/components/sections/site-footer.tsx` (charcoal, newsletter strip, 4-column footer, legal bar, sticky via `mt-auto`).
- Created `src/components/product/product-visual.tsx` (SVG illustrations for all 8 products).

Stage Summary:
- Foundation complete. Design system, data, DB, APIs, header, footer, product visuals all in place.
- Ready for section components (Hero, About, TrustBar, Products, Features, Process, ClaimsRegister, Testimonials, FAQ, ContactSection) and homepage assembly.
- Key tokens: turmeric gold `oklch(0.72 0.15 75)`, charcoal `oklch(0.20 0.012 60)`, paper `oklch(0.99 0.006 85)`.
- Fonts: `--font-playfair` (display/headings), `--font-inter` (body), `--font-geist-mono` (mono).
- Helpers available: `cn()`, `Section`, `SectionHeading`, `Container`, `SiteShell`, `company`/`navigation`/`productsData`/`claimsData` from `@/lib/data`, `allProducts`/`allClaims` arrays, `getProductById`/`getClaimById`/`getClaimsByIds`.
- shadcn/ui components available in `@/components/ui/*`.
- Toaster: `sonner` via `<Toaster />` in layout. Import `toast` from `sonner`.

---
Task ID: 6-a
Agent: sections-agent
Task: Build Hero, TrustBar, and About section components.

Work Log:
- Created `src/components/sections/hero.tsx` (`<Hero />`):
  - Section `id="home"`, `min-h-[88vh]` (lg: `min-h-screen`), relative, overflow-hidden, `bg-grain` + two layered radial gold glows.
  - 2-column grid on lg (text left, collage right), stacked on mobile.
  - Eyebrow pill (`rounded-full border`, gold dot + uppercase tracking text).
  - H1 renders `company.hero.headlineLines` with word-by-word stagger; the words "haldi" and "paint" wrapped in `gold-text-gradient font-display italic` span. Sizes `text-4xl sm:text-5xl md:text-6xl lg:text-7xl`, leading tight, tracking tight, `text-balance`.
  - Subheadline (`text-base md:text-lg text-muted-foreground`, max-w prose).
  - CTAs: primary gold-gradient pill button (shadow-gold) with ArrowRight; secondary outline pill button. Both via shadcn `Button` with `asChild` + Next `Link`.
  - Right collage: turmeric mound card (gold-gradient, rounded-3xl, shadow-gold) with inline mound SVG + circular seal badge showing `company.hero.seal.label` + sublabel; paint swatch card (charcoal-gradient, rounded-3xl, 3 color dots + "1,200+"); floating stat chip ("25+ years"); decorative dashed ring. All positioned absolute + rotated, with motion y-drift (y:[0,-10,0], duration 4, Infinity, easeInOut) and a slower drift for the paint card.
  - Scroll cue: "Scroll" text + bouncing ChevronDown via motion (y:[0,6,0]); gated to static when `useReducedMotion` is true.
  - Entrance: `motion.div` container with `delayChildren` + `staggerChildren` fade-up variants; respect `useReducedMotion()` (renders final state immediately when reduced).
- Created `src/components/sections/trust-bar.tsx` (`<TrustBar />`):
  - Charcoal strip (`bg-accent text-accent-foreground`), `py-12 md:py-16`.
  - Top row: 4 stats from `company.stats` in `grid-cols-2 md:grid-cols-4`, hairline dividers via `gap-px bg-white/5`. Big number in `font-display text-3xl md:text-4xl text-primary` (gold), label below in `text-xs uppercase tracking-[0.18em] text-muted-foreground`.
  - Bottom row: certification pills from `company.certifications` with `BadgeCheck` icon (gold). Row wraps on mobile (`flex flex-wrap`).
  - Stagger reveal via `whileInView` + viewport `once: true, amount: 0.3`. Reduced motion supported.
- Created `src/components/sections/about.tsx` (`<About />`):
  - Section `id="about"`, paper tone, `py-20 md:py-28` via `Section` primitive.
  - `SectionHeading` with eyebrow "Our Story", title "Haldi and paint, crafted by the same hands.", description from `company.story.lead`, center aligned.
  - Two-column grid (lg:grid-cols-2, gap-12):
    - Left: `AboutCollage` — gold-tinted main panel with inline turmeric root SVG (curving root shape in gold gradient + secondary root, knob rings, highlight stripe, sprinkled dots, "CURCUMA LONGA" caption); overlapping "Since 1998" charcoal card (rotated -3deg); floating paint swatch chip (3 color dots + "1,200+ shades", rotated +4deg). Hover lift + shadow.
    - Right: `company.story.body` split on `\n\n` into 2 paragraphs (`text-muted-foreground`, leading-relaxed); founder quote card (gold-tinted border, `bg-secondary`, shadow-soft) with `company.story.founderQuote` in `font-display italic text-lg md:text-xl`, attribution with initial-badge + `company.story.founderName` + `company.story.founderRole`.
  - Below columns: 3 mini-cards from `company.aboutCards` (`md:grid-cols-3`). Each: gold-gradient icon tile (lucide `Sparkles`, `Hammer`, `ShieldCheck`), title bold (`font-display`), desc small. Cards have border, rounded-2xl, hover lift + shadow-gold on hover.
  - Stagger reveal via `whileInView` on both the two-column body and the mini-cards. Reduced motion supported.
- Lint verification: `bun run lint` — passes with zero errors or warnings across the new files.

Stage Summary:
- Three primary section components delivered: `Hero`, `TrustBar`, `About`.
- All use `framer-motion` (`motion`, `useReducedMotion`, `Variants`), lucide-react icons, shadcn `Button`, existing layout primitives (`Section`, `SectionHeading`), and `cn()` from `@/lib/utils`.
- All decorative SVG/visuals are inline — no external images. ARIA labels and `aria-hidden` set appropriately on decorative elements.
- Reduced-motion paths fully implemented across all three components (entrance + ambient drift + hover).
- Files are valid TSX, ESLint-clean, responsive (mobile-first, `sm:`/`md:`/`lg:` breakpoints), and use only brand tokens (turmeric gold, charcoal, paper) — no indigo/blue.
- Ready for next agents to build: Products, Features, Process, ClaimsRegister, Testimonials, FAQ, Contact sections + homepage assembly in `src/app/page.tsx`.

---
Task ID: 6-b
Agent: products-section-builder
Task: Build the Products section components — product card, product dialog, and the Products section wrapper with filter tabs + animated grid.

Work Log:
- Read worklog + existing layout primitives (`Section`, `Container`, `SectionHeading`), `ProductVisual`, `@/types`, `@/lib/data` helpers, shadcn `Dialog`/`Button`/`Badge`, and `globals.css` design tokens before writing any code.
- Created `src/components/product/product-card.tsx` — `<ProductCard product onOpen />`:
  - `motion.article` with `layout`, `whileInView` fade-up (with `useReducedMotion` guard), `whileHover={{ y: -6 }}`, plus `rounded-2xl border bg-card shadow-soft hover:-translate-y-1 hover:shadow-xl transition-all` per spec.
  - Aspect-square visual container with `<ProductVisual id={product.image} />`, casting the string `image` field to `React.ComponentProps<typeof ProductVisual>["id"]` since the JSON-driven type is `string` while ProductVisual expects a literal union.
  - Category chip absolute top-left: Haldi → `bg-primary text-primary-foreground` (gold), Paint → `bg-accent text-accent-foreground` (charcoal). Uppercase, tracking-[0.14em], rounded-full.
  - Body (p-5): name (`font-display text-lg font-bold`), tagline (`text-sm text-muted-foreground`), up to 3 highlight pill chips (`bg-secondary text-secondary-foreground`), footer row with price range + ghost "View details" button with `ArrowRight` (icon nudges on group-hover).
- Created `src/components/product/product-dialog.tsx` — `<ProductDialog product open onOpenChange />`:
  - shadcn `Dialog` with `DialogContent` (max-h-[90vh] overflow-y-auto, sm:max-w-3xl, p-0), `DialogHeader` is `sr-only` with `DialogTitle` + `DialogDescription` for screen-reader accessibility.
  - 2-column layout: left = large aspect-square `ProductVisual` with the same chip overlay; right = chip + name (`font-display text-2xl font-bold`) + tagline, full description (`text-sm text-muted-foreground leading-relaxed`), "How to use" block (with `Sparkles` icon + small heading), sizes as pill chips, price-range in a bordered panel, verified-claims list (each row: gold `ShieldCheck` + claim text + `#reference` in mono, via `getClaimById` from `@/lib/data`, skipped if not found), CTA "Enquire about this product" gold-gradient pill button.
  - CTA handler: closes the dialog, then (only if `window` exists) dispatches `gaurikrit:inquiry` CustomEvent with `{ productId, productName }` payload so ContactSection can prefill, then smooth-scrolls to `#contact` via `document.getElementById('contact')?.scrollIntoView({behavior:'smooth'})`. Wrapped in `if (typeof window !== 'undefined')` and deferred with a 60ms timeout so the dialog close tick runs first.
  - Inner `motion.div` keyed by product id animates content in subtly (`opacity 0→1, y 12→0`); uses `useReducedMotion`.
  - Hooks (`useReducedMotion`, `useCallback`) called before the `if (!product) return null` early return.
- Created `src/components/sections/products.tsx` — `<Products />`:
  - `<Section id="products" tone="paper" className="bg-grain">` (paper tone + subtle grain dot texture), with `SectionHeading` eyebrow "Our Craft", title "Two crafts, one discipline.", description "Naturally crafted haldi and lab-tested, premium paint — explore the full Gaurikrit range."
  - Custom filter tab pill bar (role="tablist"): maps `productsData.categories` (All / Haldi / Paint). Active state uses a shared `motion.span` with `layoutId="products-tab-pill"` + `gold-gradient shadow-gold` so the gold pill slides between tabs (with reduced-motion guard).
  - Grid `grid gap-6 sm:grid-cols-2 lg:grid-cols-3` with `AnimatePresence mode="popLayout"` and per-card `motion.div` (`layout` + initial/animate/exit fade+scale) so cards animate when the filter changes.
  - State: `active` (default `"all"`), `selected` (Product | null), `dialogOpen` (boolean). `handleOpen` memoised with `useCallback`. Filter computed with `React.useMemo` keyed on `active`.
  - Empty-state fallback if no products match.
  - Renders `<ProductDialog>` at the end with the selected product + dialog open state.
- Verification: ran `bun run lint` from `/home/z/my-project` — clean output, zero lint errors in any of the three files.

Stage Summary:
- Three new client components delivered: `ProductCard`, `ProductDialog`, `Products`.
- All three are `"use client"` and rely on `framer-motion` (`motion`, `AnimatePresence`, `useReducedMotion`), `lucide-react` (`ArrowRight`, `ShieldCheck`, `Sparkles`), and existing shadcn primitives (`Dialog`, `Button`) + existing layout primitives (`Section`, `SectionHeading`) + existing `ProductVisual` + existing `cn()` util.
- Design tokens used exactly as defined: `bg-primary/text-primary-foreground` (gold), `bg-accent/text-accent-foreground` (charcoal), `bg-secondary/text-secondary-foreground` (sand), `bg-card`, `text-foreground/muted-foreground`, `gold-gradient`, `shadow-gold`, `shadow-soft`, `font-display`, `font-mono`, `bg-grain`. NO indigo/blue, NO emojis.
- Accessibility: tablist/tab roles + aria-selected on filter, sr-only DialogHeader with DialogTitle/Description for screen readers, aria-labels on action buttons, focus trap + Escape + scroll-lock inherited from shadcn Dialog, prefers-reduced-motion respected throughout.
- Integration note for the homepage-assembler agent (next stage): drop `<Products />` into `src/app/page.tsx` inside `<SiteShell>` between the About/TrustBar area and any Features/Process section. The `#contact` smooth-scroll + `gaurikrit:inquiry` CustomEvent listeners must be wired by the ContactSection component (separate task) — the event payload shape is `{ productId: string, productName: string }`.
- ESLint: passes clean.

---
Task ID: 6-c
Agent: sections-builder (Features, Process, Testimonials)
Task: Build three React client section components — `<Features />`, `<Process />`, `<Testimonials />` — using framer-motion scroll reveals, lucide icons, and the existing layout primitives (`Section`, `SectionHeading`).

Work Log:
- Read prior worklog + `site-shell.tsx`, `globals.css`, `card.tsx`, `separator.tsx`, `avatar.tsx`, `package.json` to confirm tokens, primitives, and available deps (framer-motion 12, lucide-react, shadcn/ui, sonner).
- Created `src/components/sections/features.tsx` — `<Features />`:
  - `Section id="features" tone="gold-tint"` (soft sand background, `bg-secondary`) — section already gets `py-20 md:py-28` from the `Section` primitive.
  - `SectionHeading` eyebrow "Why Gaurikrit", title "Six reasons families and contractors trust us.", description "From field to shelf, every step is built to earn trust."
  - 6 features in `motion.ul` grid `mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3` with staggered `motion.li` children.
  - Each card: `<article>` with `rounded-2xl border bg-card p-6 shadow-soft transition-all hover:-translate-y-1 hover:shadow-xl`, gold icon disc (`bg-primary/10`, `h-12 w-12`) holding a `text-primary` lucide icon, `font-display text-lg font-bold` title, `text-sm text-muted-foreground` description.
  - Icons: `Leaf`, `FlaskConical`, `Ruler`, `Wind`, `BookOpen`, `Truck` — exact titles + descriptions per spec.
- Created `src/components/sections/process.tsx` — `<Process />`:
  - `Section tone="charcoal"` (strong dark contrast — the "how we make it" beat).
  - `SectionHeading tone="on-charcoal"`, eyebrow "The Craft", title "From field to your home, in four steps.", description "Every Gaurikrit product follows the same disciplined path."
  - 4 steps in `motion.div > ol` with `grid gap-6 md:grid-cols-2 lg:grid-cols-4`.
  - Each step card: `relative flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 backdrop-blur-sm` (subtle elevated translucent panel on charcoal).
  - Per step: big gold numeral (`font-display text-5xl font-bold text-primary leading-none`), gold icon disc (`bg-primary/10`, `h-10 w-10`) with lucide `Sprout` / `Hammer` / `FlaskConical` / `Truck`, bold title, `text-sm text-muted-foreground` one-line description.
  - Desktop connector: a single absolutely-positioned `div` at `top-12` (numeral mid-height, 48px from row top) with `border-t-2 border-dashed border-primary/40`, hidden below `lg`. Cards render above the line (DOM order + `relative` on `ol`), so the dashed gold line is visible only in the gaps between cards — creating the classic stepper effect of "numerals sitting on the line".
  - Staggered `whileInView` reveal via parent `staggerChildren` + child `variants`.
- Created `src/components/sections/testimonials.tsx` — `<Testimonials />`:
  - `Section id="testimonials" tone="paper"` (paper white).
  - `SectionHeading` eyebrow "Loved by Homes & Pros", title "What families, contractors, and retailers say." (description omitted per spec allowance).
  - 3 testimonials in `motion.div` grid `mt-12 grid gap-6 md:grid-cols-3`.
  - Each card: `<motion.figure>` with `rounded-2xl border bg-card p-6 shadow-soft`, lucide `Quote` icon (`h-10 w-10 text-primary`), `<blockquote><p>` with `text-base leading-relaxed`, `Separator` divider, `<figcaption>` with gold-gradient rounded-full initial disc (`gold-gradient text-accent font-display text-lg font-bold`, `h-11 w-11`) + bold name + `text-sm text-muted-foreground` role/location line.
  - Used `truncate` on name + `min-w-0` on caption wrapper for safe long-text handling.
- Accessibility:
  - Semantic HTML throughout (`<ul>/<li>`, `<ol>/<li>`, `<figure>/<blockquote>/<figcaption>`, `<article>`, `<section>`).
  - `aria-hidden="true"` on all decorative icons, numeral, avatar disc, and connector line.
  - `pointer-events-none` on the connector line so it never blocks clicks.
  - `useReducedMotion()` honored: when `reduceMotion` is true, child `y` offset is 0 and parent `staggerChildren` is 0 — children simply fade in.
- Styling discipline:
  - No indigo/blue. Only turmeric gold (`text-primary`, `bg-primary/10`, `gold-gradient`), charcoal (`bg-accent`, `text-accent-foreground`, `bg-white/[0.04]` on charcoal), paper (`bg-card`, `text-muted-foreground`).
  - Mobile-first: stacked → `md:grid-cols-2` or `md:grid-cols-3` → `lg:grid-cols-3` or `lg:grid-cols-4`.
  - All hover/transition classes use Tailwind utilities; no custom CSS added.
- Verification:
  - `bun run lint` — passes with zero errors in the three new files.
  - `bunx tsc --noEmit` — the three new files have zero type errors. (Pre-existing errors in `examples/`, `skills/`, `product-card.tsx`, and the `LinkedIn`/`Linkedin` typo in `site-footer.tsx` are from other agents' work and out of scope for 6-c.)

Stage Summary:
- Three new section components delivered and ready for homepage assembly:
  - `src/components/sections/features.tsx` → `<Features />` (gold-tint, 6 differentiator cards, staggered reveal).
  - `src/components/sections/process.tsx` → `<Process />` (charcoal, 4-step stepper with desktop dashed connector line at numeral mid-height).
  - `src/components/sections/testimonials.tsx` → `<Testimonials />` (paper, 3 quote cards with gold-gradient initial avatars).
- All use `Section` + `SectionHeading` primitives, framer-motion `whileInView` with `useReducedMotion` fallback, lucide-react icons, and `cn()`-compatible Tailwind utility classes.
- Import paths for homepage assembly:
  - `import { Features } from "@/components/sections/features"`
  - `import { Process } from "@/components/sections/process"`
  - `import { Testimonials } from "@/components/sections/testimonials"`
- Suggested homepage section order: Hero → TrustBar → About → Products → Features → Process → ClaimsRegister → Testimonials → FAQ → ContactSection → Footer. (Features and Process pair well as adjacent trust-building beats; Testimonials sits naturally after the proof-heavy ClaimsRegister.)
- Lint-clean. Type-clean (in scope). Ready for the next agent to assemble `src/app/page.tsx`.

---

Task ID: 6-d
Agent: sections-builder-d
Task: Build three section components — ClaimsRegister, FAQ, ContactSection.

Work Log:
- Created `src/components/sections/claims-register.tsx` — `<ClaimsRegister />`:
  - Section `id="claims"`, tone `paper`, with `bg-grain` overlay.
  - `SectionHeading` with eyebrow "Claims Register", title "Every claim, sourced. No exceptions.", description copy from spec.
  - Toolbar: search `Input` (h-11, with `Search` lucide icon absolute-positioned inside relative wrapper) + shadcn `Select` for category filter (h-11, options from `claimsData.categories`: All / Haldi / Paint / Process).
  - Results count `p[role=status][aria-live=polite]` showing "Showing X of Y claims".
  - Desktop table (`hidden md:block`) in a rounded bordered card with `shadow-soft`. Columns: Claim (w-[42%]), Category (Badge), Source, Reference (mono code + `Copy` ghost icon button), Verified (date). Row hover `bg-secondary/50`. Empty state row with `SearchX`.
  - Mobile (`md:hidden`) stacked card list using `Card`/`CardContent`. Each claim shows bold claim text + Badge, then a `<dl>` grid of Source / Reference (mono + copy) / Verified.
  - `copyReference(ref)` uses `navigator.clipboard.writeText` with a textarea/execCommand fallback, then `toast.success("Reference copied: " + ref)`.
  - Category badge colors: haldi=`bg-primary text-primary-foreground`, paint=`bg-accent text-accent-foreground`, process=`bg-secondary text-secondary-foreground`.
  - State `query` + `category`; filtered with `useMemo`. Reveal on scroll via `motion` + `useReducedMotion` (skips animation when reduced motion preferred).
  - `formatDate()` uses `Date.toLocaleDateString("en-IN", ...)` for verified dates.

- Created `src/components/sections/faq.tsx` — `<Faq />`:
  - Section `id="faq"`, tone `gold-tint` (soft sand).
  - `SectionHeading` eyebrow "Questions", title "Before you ask.", brief description.
  - Single shadcn `Accordion` (`type="single"`, `collapsible`) with CSS grid `lg:grid-cols-2` applied to the root so items lay out in two columns on desktop and stack on mobile. Each `AccordionItem` styled as a card (`rounded-xl border bg-card px-4 shadow-soft`).
  - 8 questions exactly per spec (verbatim question + answer strings).
  - `AccordionTrigger` carries the question (`font-medium`, `text-left`, `hover:no-underline`); `AccordionContent` carries the answer (`text-sm text-muted-foreground leading-relaxed`).
  - Reveal via `motion` + `useReducedMotion`.

- Created `src/components/sections/contact-section.tsx` — `<ContactSection />`:
  - Section `id="contact"`, tone `charcoal` (`bg-accent text-accent-foreground`) for conversion contrast.
  - `SectionHeading` tone `on-charcoal`, eyebrow "Get in Touch", title "Let's craft something golden together.", description per spec.
  - Two-column grid `lg:grid-cols-2 gap-8`.
  - LEFT — contact form inside a `Card` (`bg-card text-card-foreground shadow-soft`) so it pops on charcoal:
    - Fields: Name (required), Email (required), Phone (optional), Interest (Select: Haldi / Paint / Partnership / General), Message (textarea, min 10 chars required).
    - Hidden honeypot `<input>` named `company` registered with `sr-only`, `tabIndex={-1}`, `autoComplete="off"`, `aria-hidden="true"`.
    - Submit button: pill (`rounded-full`), `gold-gradient` background, `text-accent`, `shadow-gold`, full-width on mobile (`w-full sm:w-auto`), `h-11`. While pending shows `Loader2` spinner + "Sending…", otherwise `Send` icon + "Send Message".
    - `react-hook-form` (`useForm<ContactInput>`) + `zodResolver(contactSchema)`. Cast the resolver as `Resolver<ContactInput>` to bypass a generic mismatch between `@hookform/resolvers` v5 and `react-hook-form` v7.60's third generic `TFieldValues` on `Resolver`/`Control`.
    - shadcn `Form`/`FormField`/`FormItem`/`FormLabel`/`FormControl`/`FormMessage` for accessible labels + `aria-describedby` + `aria-invalid` wiring. `FormMessage` overridden to `text-xs`. `role="alert"` on each `FormMessage` for screen readers.
    - All inputs/textarea/select trigger bumped to `h-11` for 44px touch target.
    - On submit: `POST /api/contact` with JSON. 201 → `toast.success` + `form.reset()`. 400 → map `data.issues` to field errors via `form.setError` + `toast.error`. 429 → `toast.error("Too many attempts. Please wait a minute.")`. 5xx → `toast.error("Something went wrong. Please email us directly.")`. Network failure → `toast.error` with direct email.
    - `useEffect` listens for `gaurikrit:inquiry` custom event (detail `{ productName }`). On receipt: `form.setValue("interest", "Paint")`, `form.setValue("message", `I'd like to know more about ${productName}.`)`, and an info toast. Cleaned up on unmount.
  - RIGHT — newsletter card + contact details:
    - Newsletter card: `border-primary/40 bg-card/95`, heading "Join 12,000+ readers", subtext per spec, email `Input` + Subscribe button (gold-gradient, pill, `Loader2` while pending). Client-side pre-validation via `newsletterSchema.safeParse`. POST `/api/newsletter`. Toasts for success/429/error/network.
    - Contact details card: `border-white/10 bg-white/5`, listing address (`MapPin`), phone (`Phone`, tel: link), email (`Mail`, mailto: link), hours (`Clock`) from `company.contact`. Each icon in gold (`text-primary`).

- Lint: `bun run lint` clean (no errors). 
- TypeScript: `npx tsc --noEmit` reports zero errors in the three new files (remaining TS errors elsewhere — pre-existing site-footer typo `LinkedIn`→`Linkedin`, product-card framer-motion typing, examples/, skills/ — not in scope for Task 6-d).

Stage Summary:
- Three section components delivered: `<ClaimsRegister />`, `<Faq />`, `<ContactSection />`.
- All three are `"use client"` React components, fully responsive (mobile-first), with 44px touch targets, accessible labels/roles/aria, framer-motion reveals gated on `useReducedMotion`, and sonner toasts for user feedback.
- Design tokens used: `gold-gradient`, `shadow-gold`, `shadow-soft`, `bg-grain`, `bg-primary/text-primary-foreground` (haldi), `bg-accent/text-accent-foreground` (charcoal + paint badge), `bg-secondary/text-secondary-foreground` (process badge + sand tint). No indigo/blue, no emojis.
- Reusable API: imports from `@/lib/data` (`claimsData`, `allClaims`, `company`), `@/types` (`Claim`), `@/lib/validations` (`contactSchema`, `newsletterSchema`, `ContactInput`), `@/components/layout/site-shell` (`Section`, `SectionHeading`), `@/lib/utils` (`cn`), shadcn primitives (`Input`, `Textarea`, `Select`, `Button`, `Card`, `Table`, `Accordion`, `Badge`, `Form`).
- Ready for homepage assembly: import these three along with prior sections (Hero, About, TrustBar, Products, Features, Process, Testimonials) into `src/app/page.tsx`.
- Pre-flight note for next agent/homme assembly: existing `site-footer.tsx` has a `LinkedIn` (capital) typo in the socialIcons map — should be `Linkedin` (lucide-react exports `Linkedin`). Not in 6-d scope but worth fixing before launch.
