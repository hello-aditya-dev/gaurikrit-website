# Information Architecture

## Single-page section map (top → bottom)

| # | Section | Anchor | Purpose |
|---|---------|--------|---------|
| 1 | Header | `#top` | Navigation + primary CTA |
| 2 | Hero | `#home` | Brand promise + dual CTAs |
| 3 | Trust bar | `#trust` | Stats & certifications strip |
| 4 | About | `#about` | Story + founder note |
| 5 | Products | `#products` | Filterable catalogue (Haldi / Paint) |
| 6 | Why Gaurikrit | `#features` | 6 differentiators |
| 7 | Process | `#process` | 4-step Source→Deliver |
| 8 | Claims Register | `#claims` | Searchable trust table |
| 9 | Testimonials | `#testimonials` | Social proof |
| 10 | FAQ | `#faq` | Objection handling |
| 11 | Contact + Newsletter | `#contact` | Lead capture |
| 12 | Footer | `#footer` | Sticky footer, links, legal |

## Navigation model

- Desktop: logo left, 6 anchor links center, "Get a Quote" button right.
- Mobile: logo left, hamburger right → Sheet menu with same links + CTA.
- Active state: underline accent on scroll-spy (v1.1).

## Product taxonomy

```
Products
├── Haldi
│   ├── Pure Turmeric Powder
│   ├── Organic Haldi Paste
│   └── Wellness Haldi (curcumin-enriched)
└── Paint
    ├── Interior Emulsion
    ├── Exterior Weather Guard
    ├── Natural Turmeric Paint (signature)
    └── Prime Wood Coating
```

## Data entities

- **Company** — singleton, brand-level facts.
- **Products** — array, category-tagged, each with claims[] referencing the claims register.
- **Claims** — array, each with source + reference + verified date.
- **ContactMessage** — DB, form submissions.
- **NewsletterSubscriber** — DB, email-only signups.
- **ProductInquiry** — DB, product-specific enquiries.
