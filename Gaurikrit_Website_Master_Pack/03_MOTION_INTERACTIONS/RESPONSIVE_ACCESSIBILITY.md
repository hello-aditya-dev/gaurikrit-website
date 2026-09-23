# Responsive & Accessibility

## Breakpoints (Tailwind defaults)
- `sm` 640, `md` 768, `lg` 1024, `xl` 1280, `2xl` 1536.

## Layout rules per breakpoint

| Section | Mobile | Tablet (md) | Desktop (lg+) |
|---------|--------|-------------|----------------|
| Hero | stacked, H1 text-4xl | H1 text-6xl | split 2-col, H1 text-7xl |
| Trust bar | 2×2 grid | 4 in a row | 4 in a row |
| About | 1-col | 2-col | 2-col with image collage |
| Products grid | 1-col | 2-col | 3-col |
| Features | 1-col | 2-col | 3×2 |
| Process | vertical stepper | 2×2 | 4 horizontal |
| Claims table | card list (stacked rows) | full table | full table |
| Testimonials | 1-col | 3-col | 3-col |
| FAQ | 1-col accordion | 2-col | 2-col |
| Contact | 1-col stacked | 2-col | 2-col |
| Footer | stacked columns | 2×2 grid | 4 columns |

## Touch targets
- Minimum 44×44px for all interactive elements.
- Nav links: 40px tall tap area on mobile (padding).

## Accessibility

### Semantics
- `<header>`, `<main>`, `<nav>`, `<section>` (with `aria-labelledby`), `<footer>`.
- Skip link "Skip to content" first focusable.

### ARIA
- Tabs: `role="tablist"`, `aria-selected`.
- Dialog: labelled by heading, focus trap, ESC to close.
- Accordion: `aria-expanded`, `aria-controls`.
- Form errors: `aria-describedby` + `role="alert"`.

### Color contrast
- Charcoal text on paper: ratio 14:1.
- Gold on charcoal: ratio 7:1.
- Muted-foreground on paper: ratio 5.5:1.
- All ≥ AA.

### Reduced motion
- `useReducedMotion()` from Framer Motion gates all non-essential motion.

### Keyboard
- Tab order logical, visible focus ring (`--ring`).
- Dialog trap focus, return on close.
- ESC closes dialogs/sheets/menus.

### Images
- All `<img>`/`next/image` have descriptive `alt`.
- Decorative SVGs: `aria-hidden`.

### Forms
- Labels associated with inputs.
- Required fields marked, errors announced.
- Submit disabled until valid (optional) but never silently.
