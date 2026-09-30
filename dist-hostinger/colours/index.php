<?php
/**
 * Gaurikrit Bio Products — Colours (V18 NEW route /colours/).
 *
 * The client-backed colour experience (§6–12, §42–45):
 *   01 HERO       Colours Inspired by Nature. — restrained shade ribbon,
 *                 NOT the brochure poster
 *   02 WALL       wall-only visualizer (SVG mask, multiply blend) +
 *                 selected-shade readout + collection tabs
 *   03 SIGNATURE  12 client-supplied shades, real HTML swatch grid
 *   04 PREMIUM    shades in the five supplied groups (no numeric count claimed)
 *   05 NOTE       quiet permanent digital-colour disclaimer
 *   06 CTA        Eco-Paints family + calculator
 *
 * Shade names + codes are transcribed from the supplied Gaurikrit shade
 * references (V20: softened per §43; count discrepancy logged in
 * CLIENT_VERIFICATION_REQUIRED.md).
 * Hex values are pixel-sampled approximations (see ASSET_PROVENANCE.md).
 * Selected colour tints ONLY the wall plane — door, window, trim, ground
 * and plants stay untouched (SVG evenodd mask over the elevation photo).
 */
declare(strict_types=1);

$pageTitle       = 'Prakritik Paint Colours — Gaurikrit';
$pageDescription = 'Explore Gaurikrit Prakritik Paint Signature and Premium shade collections, with interactive wall colour previews.';
$pageCanonical   = '/colours/';
$pageClass       = 'colours';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $SHADE_SIGNATURE, $SHADE_PREMIUM_GROUPS;
?>
<style>
  /* ===== V18 §43–45 — Colours page. Page-local structures only; grounds
     come from the five section families; the wall + copy-btn components
     are shared (app.css §19). Brush-stroke chips are pure CSS/SVG masks —
     no raster swatch images. ===== */

  /* Hero shade ribbon — a restrained colour composition (§7). */
  .colours-hero__grid {
    display: grid; gap: clamp(1.5rem, 3vw, 3rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .colours-hero__grid { grid-template-columns: 7fr 5fr; } }
  .story-hero__ctas { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.75rem; }
  .colours-hero__ribbon { display: flex; gap: 0.5rem; margin-top: 0; }
  .colours-hero__stroke {
    flex: 1 1 0; min-width: 0; aspect-ratio: 5 / 2.2;
    border-radius: 999px 999px 40% 30% / 70% 60% 30% 25%;
    border: 1px solid rgba(23, 63, 43, 0.10);
  }
  .colours-hero__stroke:nth-child(odd) { transform: translateY(0.45rem) rotate(-0.4deg); }
  .colours-hero__stroke:nth-child(even) { transform: translateY(-0.2rem) rotate(0.5deg); }

  /* The interactive unit: wall left / readout right (§12). */
  .colour-experience { position: relative; }
  .colour-unit { display: grid; gap: clamp(1.5rem, 3vw, 3rem); grid-template-columns: 1fr; }
  @media (min-width: 1024px) { .colour-unit { grid-template-columns: 7fr 5fr; align-items: start; } }
  .colour-unit .colours-wall { border: 1px solid var(--border); border-radius: var(--r-panel); }

  .colour-readout { display: flex; flex-direction: column; gap: 1.25rem; }
  .colour-readout__label {
    font-size: 0.75rem; letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--fg-muted); font-weight: 600;
  }
  .colour-readout__name {
    font-family: var(--font-display); font-size: clamp(1.75rem, 3vw, 2.5rem);
    line-height: 1.05; color: var(--charcoal); min-height: 2.6rem;
  }
  .colour-readout__code {
    font-size: 0.9375rem; font-weight: 600; color: var(--haldi-deep, #8A6A1F);
    letter-spacing: 0.06em; font-variant-numeric: tabular-nums;
  }
  .colour-readout__hint { font-size: 0.9375rem; color: var(--fg-muted); max-width: 26rem; }

  /* Collection segmented control (§12 / §44). */
  .colour-tabs {
    display: inline-flex; border: 1px solid var(--border); border-radius: var(--r-pill);
    overflow: hidden; background: var(--paper);
  }
  .colour-tabs__tab {
    min-height: 44px; padding: 0.5rem 1.25rem; border: 0; background: transparent;
    font: inherit; font-weight: 600; font-size: 0.9375rem; color: var(--fg-muted);
    cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;
  }
  .colour-tabs__tab + .colour-tabs__tab { border-left: 1px solid var(--border); }
  .colour-tabs__tab[aria-pressed="true"] { background: var(--forest); color: var(--primary-fg); }
  .colour-tabs__count { font-size: 0.75rem; opacity: 0.75; font-variant-numeric: tabular-nums; }

  /* Shade grids — ruled editorial groups, NOT chunky cards (§43). */
  .shade-grid { display: grid; gap: clamp(1rem, 2vw, 1.5rem); grid-template-columns: repeat(2, 1fr); }
  @media (min-width: 640px)  { .shade-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (min-width: 1024px) { .shade-grid { grid-template-columns: repeat(4, 1fr); } }
  @media (min-width: 1280px) { .shade-grid { grid-template-columns: repeat(6, 1fr); } }

  .shade {
    border: 0; background: none; padding: 0; text-align: left; cursor: pointer;
    display: flex; flex-direction: column; gap: 0.5rem; min-width: 0;
    border-radius: 8px; font: inherit; color: inherit;
  }
  .shade:focus-visible { outline: 2px solid var(--forest); outline-offset: 3px; }
  .shade__chip {
    aspect-ratio: 4 / 3; width: 100%; display: block; position: relative;
    background: var(--shade);
    -webkit-mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 90'%3E%3Cpath d='M8,11 C30,6.5 90,5.5 112,9.5 C116,26 115,63 113,81.5 C88,85.5 31,86.5 10.5,81.5 C5.5,60 5,30 8,11 Z' fill='%23000'/%3E%3C/svg%3E");
    mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 120 90'%3E%3Cpath d='M8,11 C30,6.5 90,5.5 112,9.5 C116,26 115,63 113,81.5 C88,85.5 31,86.5 10.5,81.5 C5.5,60 5,30 8,11 Z' fill='%23000'/%3E%3C/svg%3E");
    -webkit-mask-size: 100% 100%; mask-size: 100% 100%;
    -webkit-mask-repeat: no-repeat; mask-repeat: no-repeat;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
    transition: transform 0.2s var(--ease);
  }
  .shade:hover .shade__chip { transform: translateY(-2px); }
  .shade[data-active="true"] .shade__chip { outline: 2px solid var(--forest); outline-offset: 3px; }
  .shade__name { font-weight: 600; font-size: 0.9375rem; color: var(--charcoal); line-height: 1.25; }
  .shade__code {
    font-size: 0.8125rem; color: var(--fg-muted); letter-spacing: 0.05em;
    font-variant-numeric: tabular-nums;
  }

  /* Premium groups — ruled blocks with a quiet group index. */
  .premium-groups { display: flex; flex-direction: column; gap: clamp(2rem, 4vw, 3.25rem); }
  .premium-group__head {
    border-top: 1px solid var(--border); padding-top: 1rem; margin-bottom: 1.25rem;
    display: flex; align-items: baseline; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
  }
  .premium-group__name {
    font-family: var(--font-display); font-size: clamp(1.25rem, 2vw, 1.5rem);
    color: var(--charcoal);
  }
  .premium-group__range { font-size: 0.8125rem; color: var(--fg-muted); font-variant-numeric: tabular-nums; }
  .premium-index { display: flex; flex-wrap: wrap; gap: 0.5rem 1.25rem; margin-bottom: 1.5rem; }
  .premium-index a { color: var(--forest); text-decoration-color: rgba(23, 63, 43, 0.35); font-size: 0.875rem; }
  .premium-index a:hover, .premium-index a:focus-visible { text-decoration-thickness: 2px; }

  /* Mobile sticky selected-shade bar (§44). */
  .shade-sticky {
    position: sticky; top: calc(4.75rem + 0.5rem); z-index: 30;
    display: none; align-items: center; gap: 0.625rem;
    background: var(--paper); border: 1px solid var(--border); border-radius: var(--r-pill);
    padding: 0.4rem 0.9rem; margin: 0 auto 1.25rem; width: fit-content;
    box-shadow: 0 6px 18px rgba(23, 63, 43, 0.10);
    visibility: hidden; opacity: 0; transform: translateY(-6px);
    transition: opacity 0.25s var(--ease), transform 0.25s var(--ease);
  }
  @media (max-width: 767px) { .shade-sticky { display: flex; } }
  .shade-sticky[data-has-selection="true"] { visibility: visible; opacity: 1; transform: none; }
  .shade-sticky__dot { width: 0.875rem; height: 0.875rem; border-radius: 50%; border: 1px solid var(--border); background: var(--limewash); }
  .shade-sticky__name { font-weight: 600; font-size: 0.875rem; }
  .shade-sticky__code { font-size: 0.75rem; color: var(--fg-muted); font-variant-numeric: tabular-nums; }

  /* Quiet permanent disclaimer (§10) — a ruled note, never an alert box. */
  .colour-note {
    max-width: 46rem; border-top: 1px solid var(--border);
    padding-top: 1.25rem; font-size: 0.9375rem; color: var(--fg-muted);
    display: flex; flex-direction: column; gap: 0.75rem;
  }
  .colour-note strong { color: var(--charcoal); font-weight: 600; }

  /* Forest CTA layout (§42.06). */
  .colours-cta__grid {
    display: grid; gap: clamp(1.5rem, 3vw, 3rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .colours-cta__grid { grid-template-columns: 7fr 5fr; } }
  .colours-cta__actions { display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .colours-cta__actions .btn { min-width: 12rem; }

  @media (prefers-reduced-motion: reduce) {
    .shade__chip, .shade-sticky { transition: none; }
    .shade:hover .shade__chip { transform: none; }
  }
</style>

<!-- ============================================================
     01. HERO — Colours Inspired by Nature.
     ============================================================ -->
<section class="story-hero bg-limewash" aria-labelledby="colours-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Colours</span>
    </nav>
    <div class="colours-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Prakritik Paint</span>
        <h1 class="story-hero__title" id="colours-title">Colours Inspired by Nature.</h1>
        <p class="story-hero__lead">
          Explore the Signature and Premium shade collections supplied for
          Gaurikrit Prakritik Paint. Shade names and codes are transcribed
          from the supplied Gaurikrit shade references — confirm the current
          physical shade card and availability with Gaurikrit before
          specification.
        </p>
        <div class="story-hero__ctas">
          <a class="btn btn--primary" href="#wall-preview">Preview Shades on the Wall</a>
          <a class="btn btn--secondary" href="/products/#eco-paints">Eco-Paints Family</a>
        </div>
      </div>
      <div class="colours-hero__ribbon" aria-hidden="true">
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[0]['hex']) ?>"></span>
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[3]['hex']) ?>"></span>
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[4]['hex']) ?>"></span>
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[6]['hex']) ?>"></span>
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[8]['hex']) ?>"></span>
        <span class="colours-hero__stroke" style="background: <?= e($SHADE_SIGNATURE[10]['hex']) ?>"></span>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     02–05. THE COLOUR EXPERIENCE — one shared visualizer state:
     wall preview + readout + tabs + both collections + note.
     ============================================================ -->
<div class="colour-experience" data-colour-study>

  <!-- Mobile sticky selection bar (§44) -->
  <div class="shade-sticky" data-shade-sticky data-has-selection="false" aria-live="polite">
    <span class="shade-sticky__dot" data-shade-sticky-dot aria-hidden="true"></span>
    <span class="shade-sticky__name" data-shade-sticky-name>—</span>
    <span class="shade-sticky__code" data-shade-sticky-code>—</span>
  </div>

  <!-- ===== 02. WALL PREVIEW + selected shade + collection tabs (§11–12) ===== -->
  <section class="section section--paper" id="wall-preview" aria-labelledby="wall-preview-title">
    <div class="container">
      <div class="section-heading section-heading--left" data-reveal>
        <span class="section-heading__eyebrow">Wall Preview</span>
        <h2 class="section-heading__title" id="wall-preview-title">See a shade on the wall.</h2>
        <p class="section-heading__desc">
          Select any shade below — only the wall plane changes. The door,
          window and surroundings stay exactly as they are.
        </p>
      </div>

      <div class="colour-unit" data-reveal>
        <div class="colours-wall" data-colour-wall>
          <picture>
            <source type="image/avif" srcset="<?= eco_srcset('colours-wall', [960, 1280, 1920, 2560]) ?>"
                    sizes="(min-width: 1024px) 56vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('colours-wall', [960, 1280, 1920, 2560]) ?>"
                    sizes="(min-width: 1024px) 56vw, calc(100vw - 2.5rem)">
            <img class="colours-wall__art"
                 src="<?= asset_url('/assets/images/ecosystem/colours-wall-1280.jpg') ?>"
                 alt="Minimal interior with a large flat limewash wall above a wooden bench and jute rug"
                 width="1280" height="731"
                 loading="eager" decoding="async">
          </picture>
          <svg class="colours-wall__tint" viewBox="0 0 1344 768"
               preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
            <path class="colours-wall__paint" fill-rule="evenodd"
                  d="M101,115 H1236 V645 H101 Z
                     M1042,578 H1236 V645 H1042 Z" />
          </svg>
          <span class="colours-wall__label">
            <span data-colour-label>Natural limewash</span>
          </span>
        </div>

        <div class="colour-readout">
          <div>
            <p class="colour-readout__label">Selected shade</p>
            <p class="colour-readout__name" data-shade-name-el>—</p>
            <p class="colour-readout__code" data-shade-code-el>—</p>
          </div>
          <div role="group" aria-label="Shade collections">
            <div class="colour-tabs">
              <button type="button" class="colour-tabs__tab" data-collection-tab="signature" aria-pressed="true">
                Signature <span class="colour-tabs__count">12</span>
              </button>
              <button type="button" class="colour-tabs__tab" data-collection-tab="premium" aria-pressed="false">
                Premium <span class="colour-tabs__count">GK-201–230</span>
              </button>
            </div>
          </div>
          <p class="colour-readout__hint">
            Signature and Premium are two separate client-supplied collections.
            Every swatch shows the shade name and its card code.
          </p>
          <p class="colours-share">
            <button type="button" class="copy-btn" data-colour-copy data-copy="" hidden
                    aria-label="Copy a link to this shade">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              <span class="copy-btn__label">Copy link to this shade</span>
            </button>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== 03. SIGNATURE COLLECTION — 12 shades (§8) ===== -->
  <section class="section section--limewash" id="signature" aria-labelledby="signature-title" data-collection-panel="signature">
    <div class="container">
      <div class="section-heading section-heading--left" data-reveal>
        <span class="section-heading__eyebrow">Signature Collection</span>
        <h2 class="section-heading__title" id="signature-title">Twelve signature shades.</h2>
        <p class="section-heading__desc">
          The Signature Collection, transcribed from the supplied shade references —
          codes GK-101 to GK-112.
        </p>
      </div>
      <div class="shade-grid" data-reveal-stagger role="radiogroup" aria-label="Signature Collection shades">
        <?php foreach ($SHADE_SIGNATURE as $shade): ?>
          <button type="button" class="shade" role="radio" aria-checked="false"
                  style="--shade: <?= e($shade['hex']) ?>;"
                  data-shade="<?= e($shade['hex']) ?>"
                  data-shade-name="<?= e($shade['name']) ?>"
                  data-shade-code="<?= e($shade['code']) ?>"
                  aria-label="<?= e($shade['name']) ?> — <?= e($shade['code']) ?>">
            <span class="shade__chip" aria-hidden="true"></span>
            <span class="shade__name"><?= e($shade['name']) ?></span>
            <span class="shade__code"><?= e($shade['code']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== 04. PREMIUM COLLECTION — five supplied groups (§9; V20 §42: no numeric count) ===== -->
  <section class="section section--paper" id="premium" aria-labelledby="premium-title" data-collection-panel="premium" hidden>
    <div class="container">
      <div class="section-heading section-heading--left" data-reveal>
        <span class="section-heading__eyebrow">Premium Collection</span>
        <h2 class="section-heading__title" id="premium-title">The Premium Collection, in five groups.</h2>
        <p class="section-heading__desc">
          Five supplied groups — Natural Neutrals, Sunshine,
          Nature Greens, Sky &amp; Water and Earth &amp; Heritage, codes
          GK-201 to GK-230.
        </p>
      </div>

      <nav class="premium-index" data-reveal aria-label="Premium Collection groups">
        <?php foreach ($SHADE_PREMIUM_GROUPS as $group): ?>
          <a href="#<?= e($group['id']) ?>"><?= e($group['name']) ?></a>
        <?php endforeach; ?>
      </nav>

      <div class="premium-groups">
        <?php foreach ($SHADE_PREMIUM_GROUPS as $group): ?>
          <div class="premium-group" id="<?= e($group['id']) ?>">
            <div class="premium-group__head">
              <h3 class="premium-group__name"><?= e($group['name']) ?></h3>
              <span class="premium-group__range">
                <?= e($group['shades'][0]['code']) ?> – <?= e($group['shades'][count($group['shades']) - 1]['code']) ?>
              </span>
            </div>
            <div class="shade-grid" role="radiogroup" aria-label="<?= e($group['name']) ?> shades">
              <?php foreach ($group['shades'] as $shade): ?>
                <button type="button" class="shade" role="radio" aria-checked="false"
                        style="--shade: <?= e($shade['hex']) ?>;"
                        data-shade="<?= e($shade['hex']) ?>"
                        data-shade-name="<?= e($shade['name']) ?>"
                        data-shade-code="<?= e($shade['code']) ?>"
                        aria-label="<?= e($shade['name']) ?> — <?= e($shade['code']) ?>">
                  <span class="shade__chip" aria-hidden="true"></span>
                  <span class="shade__name"><?= e($shade['name']) ?></span>
                  <span class="shade__code"><?= e($shade['code']) ?></span>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ===== 05. SHADE DISCLAIMER + application note (§10 / §42) ===== -->
  <section class="section section--haldi-wash" id="shade-note" aria-labelledby="shade-note-title">
    <div class="container">
      <div class="colour-note" data-reveal>
        <h2 class="section-heading__eyebrow" id="shade-note-title">About these previews</h2>
        <p>
          <strong>Digital previews are indicative.</strong> Actual colour may
          vary with surface, application, lighting and display.
        </p>
        <p>
          Signature and Premium are two separate shade collections supplied by
          Gaurikrit. Shade names and codes are transcribed from the supplied
          shade card — confirm physical shade cards, availability across the
          Distemper and Emulsion formats, and current stock with Gaurikrit
          before specifying. <a href="/contact/">Ask about shade availability →</a>
        </p>
      </div>
    </div>
  </section>

</div>

<!-- ============================================================
     06. ECO-PAINT CTA (§42)
     ============================================================ -->
<section class="section section--forest" aria-labelledby="colours-cta-title">
  <div class="container">
    <div class="colours-cta__grid" data-reveal>
      <div>
        <span class="section-heading__eyebrow">The Documented Family</span>
        <h2 class="vision-mission__title" id="colours-cta-title">
          Colours for the Eco-Paints family.
        </h2>
        <p class="vision-mission__text">
          These collections belong to Gaurikrit's documented Eco-Paints
          direction — Prakritik Distemper and Prakritik Emulsion, finished in
          a natural matt.
        </p>
      </div>
      <div class="colours-cta__actions">
        <a class="btn btn--primary" href="/products/#eco-paints">Explore Eco-Paints</a>
        <a class="btn btn--secondary" href="/paint-calculator/">Plan Your Quantity</a>
      </div>
    </div>
  </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
