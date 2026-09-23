# QA Acceptance Criteria

## Functional
- [ ] Page loads on `/` with no console errors or hydration warnings.
- [ ] All 6 nav anchors smooth-scroll to the right section.
- [ ] Mobile hamburger opens Sheet; links close it on click.
- [ ] Products tabs (All / Haldi / Paint) filter the grid correctly.
- [ ] Product card "View details" opens a Dialog with description + claims.
- [ ] Product Dialog "Enquire" opens contact section / prefills interest.
- [ ] Claims Register search filters rows live.
- [ ] Claims Register category filter works.
- [ ] FAQ accordion expands/collapses; only logic-correct multiple open.
- [ ] Contact form rejects empty / invalid email; accepts valid; shows toast; writes DB row.
- [ ] Honeypot field blocks bots.
- [ ] Newsletter form accepts valid email; dedupes; shows toast.
- [ ] Product inquiry form (from dialog) writes DB row.
- [ ] Theme toggle switches light/dark and persists.

## Non-functional
- [ ] Lighthouse mobile: Perf ≥ 85, A11y ≥ 95, BP ≥ 90, SEO ≥ 95.
- [ ] No layout shift above 0.1.
- [ ] All images have alt text.
- [ ] Keyboard: tab order logical; dialog traps focus; ESC closes.
- [ ] `prefers-reduced-motion`: animations disabled.
- [ ] 320px viewport: no horizontal scroll, text legible, tap targets ≥ 44px.
- [ ] Sticky footer: on short page, footer sits at viewport bottom; on long page, pushed down.

## Content
- [ ] All copy in English.
- [ ] No lorem ipsum.
- [ ] Every product has a claim link that resolves in the Claims Register.
- [ ] Contact details (address, phone, email) present and consistent.

## SEO
- [ ] Title, description, OG, Twitter, JSON-LD present.
- [ ] One H1.
- [ ] robots.txt allows indexing.
