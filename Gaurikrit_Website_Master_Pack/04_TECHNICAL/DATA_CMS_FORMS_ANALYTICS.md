# Data, CMS, Forms & Analytics

## Data model

### Static JSON (read, bundled)
- `company.json` — brand singleton.
- `products.json` — catalogue array.
- `navigation.json` — nav + footer links.
- `claims-register.json` — claims array.

### Database (SQLite via Prisma)
- `ContactMessage` — name, email, phone, interest, message, createdAt.
- `NewsletterSubscriber` — email (unique), createdAt, source.
- `ProductInquiry` — productId, productName, name, email, phone, message, createdAt.

## Forms

### Contact form
- Fields: name (req), email (req, email), phone (optional, +91…), interest (select: Haldi / Paint / Partnership / General), message (req, min 10).
- Honeypot: `company` (hidden).
- POST `/api/contact` → 201 on success, 400 on validation, 429 on rate-limit.
- Toast: "Thanks! Our team will reach out within 24 hours."

### Newsletter form
- Fields: email (req, email).
- POST `/api/newsletter` → 201, 409 if already subscribed (treated as success to avoid enumeration), 400/429.
- Toast: "You're in. Watch your inbox for golden updates."

### Product inquiry
- Pre-fills productId/productName from the product dialog.
- Fields: name, email, phone, message.
- POST `/api/inquiry`.

## Analytics (v1 — lightweight, no third-party)
- Custom event dispatcher on key interactions: `hero_cta_click`, `product_view`, `claim_search`, `form_submit`, `newsletter_subscribe`.
- Console-logged in dev; wire to Plausible/PostHog later via a single `track()` sink.

## CMS strategy
- v1: JSON in repo, PR-reviewed. Content edits = git commits.
- v2: Decap CMS or direct Prisma admin. Not in scope.

## Backups
- SQLite file (`prisma/dev.db`) versioned out via `.gitignore`; migrations in repo.
- Daily export of `ContactMessage` + `NewsletterSubscriber` to CSV (future cron).
