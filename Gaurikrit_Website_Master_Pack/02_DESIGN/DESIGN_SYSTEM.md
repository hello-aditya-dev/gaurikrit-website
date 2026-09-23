# Design System

## Brand words
Warm · Golden · Pure · Disciplined · Trustworthy · Crafted · Industrial-precise

## Color tokens (OKLCH)

### Light
| Token | Value | Use |
|-------|-------|-----|
| `--background` | `oklch(0.99 0.005 85)` | Page paper |
| `--foreground` | `oklch(0.18 0.01 60)` | Charcoal text |
| `--primary` | `oklch(0.72 0.15 75)` | Turmeric gold (buttons, accents) |
| `--primary-foreground` | `oklch(0.18 0.01 60)` | Text on gold |
| `--secondary` | `oklch(0.96 0.01 85)` | Soft sand |
| `--muted` | `oklch(0.95 0.01 85)` | Muted panels |
| `--muted-foreground` | `oklch(0.45 0.02 60)` | Subdued text |
| `--accent` | `oklch(0.18 0.01 60)` | Charcoal accent |
| `--accent-foreground` | `oklch(0.99 0.005 85)` | Text on charcoal |
| `--border` | `oklch(0.90 0.01 80)` | Hairline |
| `--ring` | `oklch(0.72 0.15 75)` | Focus ring |
| `--card` | `oklch(1 0 0)` | Card surface |
| `--destructive` | `oklch(0.58 0.22 27)` | Errors |

### Dark
| Token | Value |
|-------|-------|
| `--background` | `oklch(0.16 0.01 60)` |
| `--foreground` | `oklch(0.96 0.01 85)` |
| `--primary` | `oklch(0.80 0.14 80)` |
| `--primary-foreground` | `oklch(0.16 0.01 60)` |
| `--secondary` | `oklch(0.22 0.01 60)` |
| `--muted` | `oklch(0.22 0.01 60)` |
| `--muted-foreground` | `oklch(0.70 0.02 75)` |
| `--accent` | `oklch(0.28 0.02 60)` |
| `--accent-foreground` | `oklch(0.96 0.01 85)` |
| `--border` | `oklch(1 0 0 / 12%)` |
| `--card` | `oklch(0.20 0.01 60)` |

## Typography

- **Display / Headings:** `Playfair Display` (700, 600) — serif warmth.
- **Body / UI:** `Inter` (400, 500, 600) — clean sans.
- **Mono / specs:** `Geist Mono` — specs, numbers, references.

### Scale
| Role | Class | Size (desktop) |
|------|-------|----------------|
| Hero H1 | `text-5xl md:text-7xl` | 48–72px |
| Section H2 | `text-3xl md:text-5xl` | 30–48px |
| Sub H3 | `text-xl md:text-2xl` | 20–24px |
| Body | `text-base md:text-lg` | 16–18px |
| Small | `text-sm` | 14px |
| Eyebrow | `text-xs uppercase tracking-widest` | 12px |

## Spacing & radius
- Section vertical padding: `py-20 md:py-28`.
- Container max-width: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`.
- Card radius: `rounded-2xl`.
- Button radius: `rounded-full` (pill) for primary, `rounded-lg` for utility.
- Section gap between header and content: handled by hero.

## Elevation
- Cards: `shadow-sm` default, `hover:shadow-xl hover:-translate-y-1` on interactives.
- Hero accent: gold radial glow behind headline.
- Charcoal panels: no shadow, rely on contrast.

## Iconography
- `lucide-react` line icons, 1.5 stroke.
- Gold-tinted where they sit on charcoal panels.

## Imagery direction
- Warm, daylight photography for haldi.
- Crisp, lit interior shots for paint.
- Charcoal backgrounds for product cutouts.
- No stock-photo clichés; favour close-ups of texture.
