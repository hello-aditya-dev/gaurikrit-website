# Content Source Notes

How every piece of copy in `05_CONTENT_DATA/*.json` was derived.

## company.json
- `name`, `legalName` — from client brief "Gaurikrit".
- `tagline` — synthesised from "naturally crafted haldi + premium paint".
- `foundedYear` 1998 — placeholder aligned with "heritage" narrative; confirm with client.
- `story` — derived from brand PDFs' "haldi meets paint" philosophy + traditional craft.
- `stats` — illustrative figures (homes painted, SKUs, pin-codes) — replace with audited numbers pre-launch.
- `contact` — plausible Kolkata address + India phone; replace with real.
- `socials` — placeholder handles; replace with real.
- `certifications` — NABL, FSSAI, ISO 9001, GreenPro as commonly held by Indian paint/spice brands; confirm exact cert numbers.

## products.json
- Haldi entries: derived from brochure + common Indian turmeric SKUs (powder, paste, curcumin-enriched).
- Paint entries: derived from paint brochure — interior emulsion, exterior weather guard, natural turmeric paint (signature), wood coating, primer.
- `sizes`, `priceRange` — indicative market bands, not retail prices.
- `claims` IDs — cross-reference `claims-register.json`.
- `image` — placeholders (`/products/xxx.svg`) replaced with generated visuals for v1.

## navigation.json
- Standard anchor set matching the section order in `02_DESIGN/PAGE_BLUEPRINTS.md`.

## claims-register.json
- 12 claims covering: curcumin %, FSSAI compliance, low-VOC, coverage, weatherability, natural ingredients, no lead, ISO, GreenPro, pan-India delivery, lab-tested, heritage recipe.
- `source` and `reference` are placeholder formats; replace with real cert numbers before launch.

## Tone rules applied
- Short, confident sentences.
- One idea per card.
- Numbers where they build trust.
- "You" voice for CTAs.
- No superlatives without a claim link.
