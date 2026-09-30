# V20 Reconstruction Record

## What happened

The V20 "source-truth finishing pass" (object-level PDF audit, fact lock,
image fidelity rebuild, page-by-page corrections, full QA, packaging) was
**completed** in the previous working session and committed locally as
`c5b6c52` — but the push failed because that sandbox had no GitHub
credentials, and the sandbox was **reset before the commit could be pushed**.
The local V20 commit was lost with it.

The remote `main` therefore stayed at `9fb8781` (v19) while the finished V20
**deployable artifacts survived** outside the repo:

1. `gaurikrit-hostinger-deploy.zip` — the packaged V20 `dist-hostinger/`
   (PHP site + all assets; 349 entries, extraction-tested at build time).
2. The synced static preview copy (a transform of the V20 `docs/` build).

## How V20 was restored (this commit)

- `dist-hostinger/` — extracted **byte-for-byte** from the V20 deploy ZIP.
  Every PHP template edit, the V20 image ladders, the vector-derived logo
  system, `partners-hero`, the retired `rural-landscape`/zebu assets — all
  exactly as packaged at V20 QA time.
- `docs/` — restored from the preview copy by **reversing the two preview-only
  link rewrites** applied by `scripts-sync-preview.sh`:
  1. `href="<dir>index.html<?q><#frag>"` → `href="<dir><?q><#frag>"`
     (canonical clean directory URLs — the form `docs/` keeps for GitHub
     Pages, per the sync script's own header comment);
  2. `calculator.js` CTA `'../contact/index.html?interest=bulk-project'` →
     `'../contact/?interest=bulk-project'`.
  Verified after reversal: zero `index.html` references remain in hrefs/JS,
  zero absolute (`/…`) asset paths — the site is fully relative and portable.
- **GitHub Pages release additions** (new in this commit):
  - `docs/.nojekyll` — serve files raw, skip Jekyll processing.
  - `docs/robots.txt` — now `Allow` (the previous `Disallow: /` was preview
    protection only) + sitemap reference. Canonical and `og:url`/`og:image`
    tags already pointed at
    `https://hello-aditya-dev.github.io/gaurikrit-website/` from the V20
    build, so the Pages URL is the self-canonical home of the static build.
  - `docs/sitemap.xml` — 13 routes (all pages except `404.html`).
- `gaurikrit-hostinger-deploy.zip` at the repo root — replaced with the V20
  build (repo convention: this ZIP is tracked).

## What is lost from the V20 session (V19 versions remain in-tree)

- `build-static.mjs` — the V20 mirror edits (the subagent pass that mirrored
  every V20 PHP change into the static build). The V19 version in-tree cannot
  regenerate the V20 `docs/`; **treat `docs/` as the source of truth** until
  build-static.mjs is re-mirrored against `dist-hostinger/`.
- `scripts/` — the V20 pipeline scripts (`build_v20_masters.py`,
  `decontam_edge_v20.py`, `build_v20_og.py`, `build_v20_derivatives.py`).
- `FACTS_LOCK.md`, `SOURCE_ASSET_AUDIT_V20.md`, the V20 update of
  `ASSET_PROVENANCE.md` — the governance documents. The fact discipline they
  encoded (no absolute environmental claims, DEVELOPMENT labels, kg/litre
  units, no BIS claims, no shade counts) is fully baked into the restored
  templates; re-create the documents before the next copy-editing pass.

## Facts note

All V20 fact corrections are present in the restored templates
(directional wording for development families, "Registered company" panel,
transcribed shade-card language, kg/litre unit discipline, the two verified
products only). The grep-clean claims list from V20 QA holds because these
are the same files that passed it.
