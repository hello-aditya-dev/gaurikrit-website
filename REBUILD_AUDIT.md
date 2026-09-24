# Rebuild Audit — Gaurikrit Website

## Old fabricated data removed
- Founded year (2019), founder name, company timeline, office hours
- Fake stats (5+ gaushala partners, 1.2M homes, 14,000 pin-codes)
- Fake certifications (FSSAI, NABL, ISO 9001, GreenPro) and cert modal
- Fake claims register (all GK-* reference IDs deleted)
- Fake testimonials (Anita Rao, Mahesh K., Sunita Devi — all deleted)
- Newsletter functionality (form, JS, CSS, API calls — all deleted)
- Coverage calculator with invented rates/pack breakdown/primer
- Fake prices (₹180, ₹320, ₹2,400, ₹4,200 — all deleted)
- Fake social media accounts
- Fake "Pan-India shipping/delivery"
- Fake "within 24 hours" / "one business day" response-time promises
- Dark mode toggle (removed for a deliberate branded light experience)
- 8 old haldi/paint products (replaced with 2 confirmed Prakritik products)

## New factual data inserted
- Company: Gaurikrit Bio Products (OPC) Private Limited
- Address: House No. 55, Village Khuriyawali, Post Arniya, Khurja, District Bulandshahr, Uttar Pradesh – 203131, India
- GSTIN: 09AAMCG8400F1ZK
- Email: seva@gaurikrit.com
- Phones: +91 9999624446, +91 9837638842
- Brand line: Good for Nature. Good for Life.
- Mission: Transforming waste into wonder, one wall at a time.
- 2 products with exact specs (Distemper 200 sq.ft.** / Emulsion 300 sq.ft.**)
- 8 Ashta Laabh benefits (client-supplied, no invented evidence)
- 6 Colours of India moods (editorial study, NOT product shades)
- 5-stage material journey
- 4 project pathways (enquiry categories, NOT existing clients)
- 6 canonical contact interest values + 6 business project types
- 9 FAQ items (only answerable from supplied data)

## Routes retained + new
- / (homepage — 10-section editorial IA)
- /products/ (architectural catalogue)
- /products/prakritik-distemper/ (cool spec sheet, indigo accent)
- /products/prakritik-emulsion/ (warm spec sheet, haldi accent, reversed layout)
- /why-prakritik/ (illustrated editorial essay)
- /about/ (institutional manifesto)
- /for-business/ (project-oriented + business form)
- /paint-calculator/ (NEW — 4-step, no invented rates, configurable engine)
- /downloads/ (brochure with graceful absent-state)
- /contact/ (real address/phones/GSTIN + contact form)
- 404.php (branded)

## Forms corrected
- Contact form: 6 canonical interest values, CSRF, honeypot, rate-limit, server-side validation
- Business form: 6 project types, same security
- Both return truthful success/failure based on SMTP result (no masking)
- No response-time promises
- Interest pre-fill from query params (calculator handoff)

## Image handoff completed
- 7 official asset paths defined (see IMAGE_HANDOFF.md)
- Every image region has coded SVG fallback
- JS auto-swaps on load/error
- No broken images, no layout shift

## Homepage final section order
1. Hero
2. Material Statement
3. Two Product Preview
4. Material Journey
5. Ashta Laabh
6. Colours of India
7. Mission
8. Calculator Teaser
9. Project Pathways
10. Brand Close / Footer

## Page-specific design differences
- Home: brand/editorial
- Products: architectural catalogue
- Distemper: cool material specification (indigo accent)
- Emulsion: warm material specification (haldi accent, reversed layout)
- Why Prakritik: illustrated essay
- About: institutional manifesto
- For Business: project/professional
- Calculator: functional design tool
- Downloads: document/library
- Contact: quiet direct utility

## Calculator architecture
- `includes/calculator-config.php` — rate config (all null, enabled=false)
- `assets/js/calculator.js` — 4-step UX, no rupee values
- Result shows project summary + "rates not yet configured" + "Request Estimate" → contact
- Future rates go in the config file only (no template/JS edits)

## Deployment ZIP regenerated
- `gaurikrit-hostinger-deploy.zip` — contents for public_html/
- Excludes: .git, node_modules, Next.js archive, internal docs, config.php, prompts
