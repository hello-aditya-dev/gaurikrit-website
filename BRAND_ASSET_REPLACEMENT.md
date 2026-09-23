# Brand Asset Replacement

The current coded brand mark (`/public/brand/gaurikrit-mark-temp.svg`) and
wordmark (`/public/brand/gaurikrit-wordmark-temp.svg`) are **temporary digital
interpretations** based on the supplied textual description:

- a front-facing Indian cow head
- framed inside a decorative rounded floral/scalloped emblem
- haldi/yellow background
- black/dark outline
- the word "Gaurikrit"
- supporting identity "Bio Products"

Since the original client logo could not be inspected, these marks must be
treated as stand-ins.

## Before final production launch

1. Replace `/public/brand/gaurikrit-mark-temp.svg` with the client's official
   vector logo file (exported as SVG, with all strokes expanded).
2. Replace `/public/brand/gaurikrit-wordmark-temp.svg` with the official
   wordmark.
3. Update `src/app/layout.tsx` `metadata.icons.icon` to point to the final
   file (currently `/brand/gaurikrit-mark-temp.svg`).
4. Update the inline `G` mark in the site header (`src/components/header/site-header.tsx`)
   and footer (`src/components/sections/site-footer.tsx`) to use the official mark.

All other visuals on the site are coded SVG illustrations (in
`src/components/illustrations/`) — see `VISUAL_ASSET_RULE` in the build brief.
No photography is used anywhere in the v1 site.
