# Project Decisions — LOCKED

These decisions are final for the v1 build. Do not reopen without a brand stakeholder sign-off.

## D-01 · Single-page experience
The entire marketing site lives on `/` as a long, sectioned scroll. No multi-page routing for v1.
**Rationale:** Faster to build, easier to narrate the brand story, better for SEO of a single promise.

## D-02 · Two product families, one brand
Haldi and Paint are presented under one Gaurikrit umbrella. The Products section uses tab filtering, not separate pages.
**Rationale:** Reinforces the "haldi-meets-paint" philosophy; avoids fragmenting the brand.

## D-03 · Turmeric-gold + Black & White palette
Primary: turmeric gold. Neutrals: charcoal black + paper white. No indigo, no blue.
**Rationale:** Mirrors the "Haldi & Black" and "Black & White" brand PDFs.

## D-04 · Claims Register is a first-class section
Every marketing claim (purity, coverage, low-VOC, etc.) is listed in a searchable table with a source and reference ID.
**Rationale:** Trust is the #1 purchase driver for both haldi (food/wellness) and paint (home).

## D-05 · Lead capture over e-commerce
v1 does **not** sell online. CTAs route to a contact form / inquiry, persisted to SQLite.
**Rationale:** Paint is consultative; haldi needs trust before transaction.

## D-06 · Dark mode
Full dark mode support via `next-themes`, default to light.
**Rationale:** Premium feel, accessibility, user preference.

## D-07 · Motion with restraint
Framer Motion for scroll reveals and hover lifts only. No parallax hero, no autoplay video.
**Rationale:** Performance + professionalism.

## D-08 · English-only copy
All user-facing copy in English. Brand keeps the Hindi word "Haldi" as a proper noun.
**Rationale:** Pan-India + international readability.

## D-09 · Prisma + SQLite
Single-file database for v1. Three models: ContactMessage, NewsletterSubscriber, ProductInquiry.
**Rationale:** Zero-ops, instant, sufficient for lead capture.

## D-10 · SEO + performance budget
LCP < 2.5s on mobile. Semantic HTML, meta tags, OpenGraph, sitemap-ready, no render-blocking.
**Rationale:** Discoverability + Core Web Vitals.
