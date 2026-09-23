# Performance, SEO & Security

## Performance budget
| Metric | Target | Strategy |
|--------|--------|----------|
| LCP (mobile) | < 2.5s | `next/image` for hero, AVIF/WebP, font-display swap |
| CLS | < 0.1 | Reserve aspect-ratio for all media |
| TBT | < 200ms | No heavy client JS; code-split sections |
| JS bundle (initial) | < 120KB gzip | Tree-shake, dynamic import heavy dialogs |
| Total page weight (mobile) | < 800KB | Optimised images, system fonts fallback |

## Image strategy
- `next/image` with `sizes` for responsive.
- Hero: 1 AVIF, 1 WebP fallback.
- Product images: 480×480 WebP.
- Logo: inline SVG.

## Fonts
- `Playfair Display` + `Inter` via `next/font/google`, `display: swap`, preloaded.
- Variable font subsets (latin).

## SEO
- `<title>`: "Gaurikrit — Naturally Crafted Haldi & Premium Paint".
- `<meta description>`: brand promise + keywords.
- OpenGraph + Twitter card with hero image.
- JSON-LD `Organization` + `Product` list.
- Semantic headings (one H1).
- `robots.txt` allow all + sitemap-ready.
- Canonical URL.

## Security
- HTTPS only (gateway enforced).
- CSRF: same-site cookies + origin check on mutations (v1.1).
- Honeypot + rate limit on forms.
- No `dangerouslySetInnerHTML` with user data.
- `Content-Security-Policy` ready (gateway).
- Secrets via `.env`, never client.
- Prisma parameterised — no SQL injection surface.
- Dependency hygiene: `bun audit` in CI (future).

## Privacy
- Newsletter: opt-in only, one-click unsubscribe (future email).
- No third-party analytics in v1.
- Cookie banner not needed for v1 (no non-essential cookies).
- Contact data stored only to fulfil the enquiry; deletable on request.
