# Gaurikrit Website

Production website for **Gaurikrit Bio Products (OPC) Private Limited** —
maker of Prakritik Paint (cow dung-based natural paint in Distemper and
Emulsion formats).

## Stack

- **PHP 8.2+**
- **HTML5**
- **CSS3** (authored, no Tailwind, no build step)
- **Vanilla JavaScript** (no React, no framework, no bundler)
- **Client-supplied product imagery and official logo** with two editorial studies
- **SMTP** (zero-Composer built-in mailer)
- **Optional MySQL** (PDO, for enquiry storage — email works without it)

## Production directory

```
dist-hostinger/
```

This is the deployable website. It is designed for **Hostinger shared
hosting** — upload to `public_html/`, select PHP 8.2+, configure SMTP.
No Node, no npm, no Composer, no build server required.

## Deployment ZIP

```
gaurikrit-hostinger-deploy.zip
```

Extract the contents directly into `public_html/`. See
`dist-hostinger/HOSTINGER_DEPLOYMENT.md` for step-by-step instructions.

**DO NOT deploy the root repository directly.** Deploy only:
- `gaurikrit-hostinger-deploy.zip`, or
- the contents of `dist-hostinger/`

## Routes

```
/                                   Home
/products/                          Products Overview
/products/prakritik-distemper/      Prakritik Distemper
/products/prakritik-emulsion/       Prakritik Emulsion
/why-prakritik/                     Why Prakritik
/about/                             About Gaurikrit
/for-business/                      Projects & Partnerships
/paint-calculator/                  Painting Budget Calculator
/downloads/                         Product Documents
/contact/                           Contact
404                                 Custom branded 404
```

## Visual assets

The official logo, exact-label product packaging images and client brochure are integrated in both outputs. Local font files cover Latin and Devanagari text without a third-party font request. The generated cow and courtyard studies are illustrations of context; neither depicts a product, manufacturing process or built client project. See `ASSET_PROVENANCE.md` for the source-to-output mapping.

Regenerate the prepared public assets with `python3 scripts/prepare_assets.py` (requires Pillow and Poppler). Regenerate the static preview with `node build-static.mjs`; regenerate the Hostinger ZIP from `dist-hostinger/` using the command in `dist-hostinger/HOSTINGER_DEPLOYMENT.md`.

The GitHub Pages preview has `noindex,nofollow`; production uses indexable metadata. The preview forms open an email draft. Hostinger forms require SMTP credentials in the untracked `config.php` and must be tested on that server before launch.

## Documentation

- `IMAGE_HANDOFF.md` — public asset paths
- `CLIENT_VERIFICATION_REQUIRED.md` — items pending client confirmation
- `SECURITY_ACTION_REQUIRED.md` — credential rotation notes
- `REBUILD_AUDIT.md` — summary of corrections made
- `dist-hostinger/HOSTINGER_DEPLOYMENT.md` — deployment guide

## Architecture

- **PHP includes** (reusable, not a framework): `bootstrap`, `config`,
  `data`, `helpers`, `seo`, `header`, `footer`, `mailer`, `calculator-config`
- **Directory-based routes** (clean URLs, no rewrite rules)
- **Vanilla JS modules**: `app`, `navigation`, `animations`, `ashta-laabh`,
  `colour-study`, `calculator`, `forms`
- **Authored CSS**: `assets/css/app.css` with locked design tokens
- **Official asset + illustration system**: real packages and logo, an architectural SVG, and contextual studies

## Archived code

The previous Next.js implementation is archived under `_archive/` for
reference only. Production code (`dist-hostinger/`) has **ZERO dependency**
on Node, npm, React, or Next.js.

## Old planning pack

`Gaurikrit_Website_Master_Pack/` contains old generated planning data. It
is **NOT a factual source** and must not be used at runtime. See
`Gaurikrit_Website_Master_Pack/DO_NOT_USE_AS_FACTUAL_SOURCE.md`.
