# Motion & Interactions

## Principles
1. **Motion explains, never decorates.** Reveal on scroll = "here's the next idea".
2. **Respect `prefers-reduced-motion`.** All animations gate on a hook.
3. **Durations:** 200ms for micro, 500ms for reveal, 700ms max for hero.
4. **Easing:** `[0.22, 1, 0.36, 1]` (expo-out) for reveals; `ease-out` for hovers.

## Scroll reveals
- Container `stagger` with `staggerChildren: 0.08`.
- Item variants: `opacity 0→1`, `y 16→0`, duration 0.5.
- Trigger once on enter (no re-animate on scroll up).

## Hover
- Cards: `hover:-translate-y-1` + `hover:shadow-xl`, 200ms.
- Buttons: scale `1.02` on hover, 150ms.
- Links: underline grow from left.

## Hero
- Eyebrow fades in (0.3s).
- Headline words stagger up (0.5s, stagger 0.08).
- Subhead slides up (0.6s, delay 0.4).
- CTAs fade up (delay 0.6).
- Floating cards drift gently (y ±8px, 4s loop, reduced-motion off).

## Products
- Tab switch: cards `layout` animate via Framer Motion `AnimatePresence` (fade + scale 0.98→1).
- Dialog: slide-up + fade.

## Claims Register
- Search/filter: rows fade reorder (no layout flip animation in v1 — keep simple).
- Row hover: subtle bg tint.

## Forms
- Submit button: spinner replaces text while pending.
- Success: form card does a 200ms scale-down then toast.

## Nav
- Active link: 2px gold underline grows from left on activation.
- Mobile sheet: slides from right, backdrop fade.

## Micro-interactions
- Theme toggle: icon rotate 180° + cross-fade.
- Scroll cue: bouncing chevron (gated on reduced-motion).
