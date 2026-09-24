<?php
/**
 * Gaurikrit Bio Products — Homepage.
 * Task PAGES-LOCK: 10-section locked order, locked data only.
 *
 * 1. Hero
 * 2. Material Statement
 * 3. Two Products
 * 4. Material Journey
 * 5. Ashta Laabh
 * 6. Colours of India
 * 7. Mission
 * 8. Calculator Teaser
 * 9. Project Pathways
 * 10. Brand Close (footer.php renders the footer)
 */
declare(strict_types=1);

$pageTitle       = 'Gaurikrit Bio Products — Prakritik Paint & Bio Products';
$pageDescription = 'Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls. Gaurikrit Bio Products, Khurja, District Bulandshahr, Uttar Pradesh.';
$pageCanonical   = '/';
$pageClass       = 'home';

require_once __DIR__ . '/includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $COLOUR_STUDY, $MATERIAL_JOURNEY, $PROJECT_PATHWAYS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
$groupImage = '/assets/products/prakritik-group.png';
?>
<style>
  /* ===== 1. HERO ===== */
  .hero { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1.5rem; min-height: 92svh; display: flex; align-items: center; }
  @media (min-width: 1024px) { .hero { min-height: 96svh; padding-top: calc(var(--header-h) + 2rem); padding-bottom: 2rem; } }
  .hero__container { display: grid; gap: 2.5rem; align-items: center; }
  @media (min-width: 1024px) { .hero__container { grid-template-columns: 1.05fr 0.95fr; gap: 3rem; } }
  .hero__lockup { display: flex; flex-direction: column; gap: 0; }
  .hero__devanagari { font-family: var(--font-deva); font-weight: 700; font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1; color: var(--haldi-deep); }
  .hero__brand-sub { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.28em; text-transform: uppercase; color: var(--primary); margin-top: 0.5rem; }
  .hero__title { margin-top: 1.25rem; font-family: var(--font-display); font-size: clamp(2.25rem, 5.5vw, 4rem); line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance; }
  .hero__sub { margin-top: 1.25rem; max-width: 40rem; font-size: clamp(1rem, 2vw, 1.125rem); color: var(--fg-muted); line-height: 1.65; }
  .hero__ctas { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; }
  @media (min-width: 640px) { .hero__ctas { flex-direction: row; align-items: center; flex-wrap: wrap; } }

  /* Hero composition — art panel */
  .hero__art { position: relative; min-height: 22rem; max-width: 32rem; margin-inline: auto; width: 100%; }
  @media (min-width: 768px) { .hero__art { min-height: 26rem; } }
  @media (min-width: 1024px) { .hero__art { min-height: 30rem; max-width: 100%; } }
  .hero__stroke { position: absolute; inset: -2rem -1rem 1rem; display: flex; align-items: center; justify-content: center; z-index: 0; }
  .hero__group { position: absolute; left: 50%; top: 38%; width: 60%; height: 50%; transform: translate(-50%, -50%); z-index: 2; }
  .hero__group .product-media { width: 100%; height: 100%; }
  .hero__group .product-media__official { object-fit: contain; }
  .hero__cow { position: absolute; right: -0.5rem; bottom: 1.5rem; width: 50%; height: 38%; z-index: 3; opacity: 0.9; }
  .hero__landscape { position: relative; margin-top: 1.5rem; height: 3.5rem; z-index: 1; }
  @media (min-width: 1024px) { .hero__landscape { margin-top: 2.5rem; height: 4rem; } }

  /* ===== 2. MATERIAL STATEMENT ===== */
  .material-statement { display: grid; gap: 1.5rem; padding-block: clamp(3rem, 6vw, 5rem); }
  @media (min-width: 1024px) { .material-statement { grid-template-columns: 1fr 1.4fr; gap: 4rem; align-items: start; } }
  .material-statement__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .material-statement__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; color: var(--haldi-deep); }
  .material-statement__title { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.75rem); line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance; margin-top: 1rem; }
  .material-statement__body { font-size: clamp(1.0625rem, 1.6vw, 1.25rem); line-height: 1.75; color: var(--fg-muted); }
  .material-statement__body p + p { margin-top: 1.25rem; }
  .material-statement__rule { width: 4rem; height: 2px; background: var(--haldi); margin-block: 1.5rem; border: 0; }
  .material-statement__visual { position: relative; aspect-ratio: 5/4; border-radius: var(--radius-lg); background: var(--secondary-bg); border: 1px solid var(--border); overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 2rem; }
  .material-statement__visual .ms-cow { position: absolute; left: 1.5rem; bottom: 1.5rem; width: 38%; opacity: 0.85; }
  .material-statement__visual .ms-arrow { position: absolute; left: 38%; top: 50%; transform: translateY(-50%); color: var(--haldi-deep); font-family: var(--font-display); font-size: 2rem; }
  .material-statement__visual .ms-wall { position: absolute; right: 1.5rem; top: 1.5rem; bottom: 1.5rem; width: 42%; border-radius: var(--radius); background: linear-gradient(135deg, var(--haldi-light), var(--haldi)); border: 1px solid var(--haldi-deep); overflow: hidden; }
  .material-statement__visual .ms-wall::after { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, oklch(0.28 0.04 150 / 0.08) 0.5px, transparent 0); background-size: 14px 14px; }

  /* ===== 3. TWO PRODUCTS (material panels, NOT cards) ===== */
  .two-products { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .two-products__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 3rem; }
  .two-products__eyebrow { display: block; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); margin-bottom: 0.75rem; }
  .two-products__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 3rem); letter-spacing: -0.02em; text-wrap: balance; }
  .two-products__grid { display: grid; gap: 2rem; }
  @media (min-width: 1024px) { .two-products__grid { grid-template-columns: 1fr 1fr; } }
  .mat-panel { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); transition: transform var(--dur) var(--ease), box-shadow var(--dur); display: flex; flex-direction: column; }
  .mat-panel:hover { transform: translateY(-4px); box-shadow: var(--shadow-forest); }
  .mat-panel__media { position: relative; aspect-ratio: 4/3; background: var(--secondary-bg); border-bottom: 1px solid var(--border); }
  .mat-panel__media .product-media { width: 100%; height: 100%; }
  .mat-panel__media .product-media__official { object-fit: contain; padding: 1.5rem; }
  .mat-panel__media .product-media__fallback { padding: 1.5rem; }
  .mat-panel__body { padding: 1.75rem; display: flex; flex-direction: column; gap: 0.75rem; flex: 1; }
  .mat-panel__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; color: var(--primary); }
  .mat-panel__name { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; line-height: 1.1; }
  .mat-panel__desc { color: var(--fg-muted); font-size: 0.9375rem; line-height: 1.6; }
  .mat-panel__specs { margin-top: 0.5rem; display: grid; gap: 0.625rem; }
  .mat-panel__spec { display: flex; justify-content: space-between; gap: 1rem; padding-bottom: 0.625rem; border-bottom: 1px dashed var(--border); font-size: 0.875rem; }
  .mat-panel__spec:last-child { border-bottom: 0; padding-bottom: 0; }
  .mat-panel__spec dt { font-weight: 600; color: var(--fg); }
  .mat-panel__spec dd { color: var(--fg-muted); text-align: right; }
  .mat-panel__cta { margin-top: auto; padding-top: 1rem; }
  .mat-panel__cta a { display: inline-flex; align-items: center; gap: 0.25rem; font-weight: 600; color: var(--primary); transition: gap var(--dur); }
  .mat-panel__cta a:hover { gap: 0.5rem; }
  .mat-panel--distemper { border-top: 4px solid var(--indigo); }
  .mat-panel--emulsion { border-top: 4px solid var(--haldi-deep); }

  /* ===== 4. MATERIAL JOURNEY ===== */
  .journey-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .journey-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .journey-section__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); letter-spacing: -0.02em; }
  .journey-wrap { padding: 1.5rem; background: var(--secondary-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); }
  @media (min-width: 768px) { .journey-wrap { padding: 2.5rem; } }
  .journey-wrap .material-journey__svg { max-height: 8rem; margin-inline: auto; }
  .journey-steps { display: grid; gap: 1rem; margin-top: 2rem; }
  @media (min-width: 768px) { .journey-steps { grid-template-columns: repeat(5, 1fr); position: relative; } }
  .journey-step { padding: 0.75rem; position: relative; }
  .journey-step__num { font-family: var(--font-display); font-size: 1.75rem; font-weight: 700; color: var(--haldi-deep); line-height: 1; }
  .journey-step__title { font-size: 0.9375rem; font-weight: 700; margin-top: 0.375rem; }
  .journey-step__desc { font-size: 0.8125rem; color: var(--fg-muted); margin-top: 0.25rem; line-height: 1.5; }
  @media (min-width: 768px) {
    .journey-step:not(:last-child)::after {
      content: ''; position: absolute; top: 1.5rem; right: -0.5rem; width: 1rem; height: 1px;
      background: var(--haldi-deep); opacity: 0.6;
    }
  }

  /* ===== 5. ASHTA LAABH ===== */
  .ashta-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--bg-card); }
  .ashta-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .ashta-section__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(2rem, 5vw, 3rem); color: var(--haldi-deep); line-height: 1; }
  .ashta-section__sub { margin-top: 0.75rem; font-family: var(--font-display); font-size: clamp(1.125rem, 2vw, 1.375rem); color: var(--fg); }
  .ashta-section__note { margin-top: 0.5rem; font-size: 0.875rem; color: var(--fg-muted); }
  .ashta-grid { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .ashta-grid { grid-template-columns: 1fr 1fr; } }
  .ashta-grid__diagram { max-width: 32rem; margin-inline: auto; width: 100%; aspect-ratio: 1; }
  .ashta-grid__diagram svg { width: 100%; height: 100%; }
  .ashta-grid__list { display: grid; gap: 0.75rem; }
  .ashta-benefit { padding: 1rem 1.25rem; border-left: 3px solid var(--haldi); background: var(--bg); border-radius: var(--radius); display: flex; align-items: center; justify-content: space-between; gap: 1rem; box-shadow: var(--shadow-soft); cursor: pointer; transition: border-color var(--dur), background var(--dur), transform var(--dur); }
  .ashta-benefit:hover, .ashta-benefit:focus-visible, .ashta-benefit[data-active="true"] { border-left-color: var(--forest); background: oklch(0.42 0.05 150 / 0.06); transform: translateX(2px); outline: none; }
  .ashta-benefit:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
  .ashta-benefit__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); flex-shrink: 0; }
  .ashta-benefit__name { font-weight: 600; font-size: 0.9375rem; }
  .ashta-benefit__deva { font-family: var(--font-deva); font-size: 0.875rem; color: var(--fg-muted); }

  /* ===== 6. COLOURS OF INDIA ===== */
  .colours-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .colours-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .colours-section__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); letter-spacing: -0.02em; }
  .colours-section__sub { margin-top: 0.75rem; font-size: clamp(1rem, 2vw, 1.125rem); color: var(--fg-muted); }
  .colours-section__tag { display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.25rem 0.75rem; border-radius: var(--radius-full); border: 1px solid var(--border); background: var(--bg-card); font-size: 0.625rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-muted); margin-top: 1rem; }
  .colours-wall { position: relative; aspect-ratio: 16/7; border-radius: var(--radius-lg); border: 1px solid var(--border); background: #f4efe2; overflow: hidden; transition: background 0.6s var(--ease); max-width: 56rem; margin-inline: auto; }
  .colours-wall__art { position: absolute; right: 1rem; bottom: 0; width: 50%; height: 100%; display: flex; align-items: flex-end; justify-content: center; opacity: 0.85; pointer-events: none; }
  .colours-wall__overlay { position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, oklch(0.42 0.05 150 / 0.06) 0.5px, transparent 0); background-size: 14px 14px; pointer-events: none; }
  .colours-wall__label { position: absolute; bottom: 1rem; left: 1rem; font-size: 0.875rem; font-weight: 600; color: var(--charcoal); background: oklch(1 0 0 / 0.78); padding: 0.375rem 0.875rem; border-radius: var(--radius-full); backdrop-filter: blur(6px); }
  .colours-swatches { display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; margin-top: 1.5rem; }
  .colours-swatch { width: 3rem; height: 3rem; border-radius: var(--radius-full); border: 2px solid var(--border); cursor: pointer; transition: transform var(--dur), border-color var(--dur), box-shadow var(--dur); display: flex; align-items: center; justify-content: center; padding: 0; position: relative; }
  .colours-swatch:hover { transform: scale(1.08); }
  .colours-swatch[data-active="true"] { border-color: var(--primary); transform: scale(1.12); box-shadow: var(--shadow-soft); }
  .colours-swatch__label { position: absolute; bottom: -1.5rem; left: 50%; transform: translateX(-50%); font-size: 0.625rem; font-weight: 600; color: var(--fg-muted); white-space: nowrap; text-transform: uppercase; letter-spacing: 0.08em; }

  /* ===== 7. MISSION ===== */
  .mission { padding-block: clamp(3.5rem, 7vw, 6rem); background: var(--forest); color: var(--primary-fg); position: relative; overflow: hidden; }
  .mission__inner { display: grid; gap: 1.5rem; position: relative; z-index: 1; }
  @media (min-width: 1024px) { .mission__inner { grid-template-columns: 0.9fr 1.1fr; gap: 4rem; align-items: center; } }
  .mission__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi); }
  .mission__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2.25rem); margin-top: 0.5rem; color: oklch(0.88 0.11 85); }
  .mission__title { font-family: var(--font-display); font-size: clamp(2rem, 4.5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; margin-top: 1rem; }
  .mission__body { font-size: clamp(1.0625rem, 1.6vw, 1.1875rem); line-height: 1.75; color: oklch(0.85 0.01 75); margin-top: 1.25rem; max-width: 36rem; }
  .mission__cta { margin-top: 2rem; }
  .mission__botanical { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); width: 8rem; height: 8rem; opacity: 0.18; pointer-events: none; }
  @media (max-width: 1023px) { .mission__botanical { display: none; } }

  /* ===== 8. CALCULATOR TEASER ===== */
  .calc-teaser { padding-block: clamp(3rem, 6vw, 5rem); }
  .calc-teaser__inner { display: grid; gap: 1.5rem; align-items: center; padding: clamp(1.75rem, 4vw, 3rem); border: 1px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); box-shadow: var(--shadow-soft); position: relative; overflow: hidden; }
  @media (min-width: 768px) { .calc-teaser__inner { grid-template-columns: 1.3fr 1fr; gap: 2.5rem; } }
  .calc-teaser__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-teaser__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); line-height: 1.1; margin-top: 0.75rem; letter-spacing: -0.02em; }
  .calc-teaser__body { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .calc-teaser__cta { margin-top: 1.5rem; }
  .calc-teaser__art { aspect-ratio: 4/3; background: var(--secondary-bg); border-radius: var(--radius); border: 1px dashed var(--border); display: flex; align-items: center; justify-content: center; padding: 1.5rem; }
  .calc-teaser__steps { display: grid; gap: 0.5rem; margin-top: 1rem; font-size: 0.8125rem; color: var(--fg-muted); }
  .calc-teaser__steps span { display: inline-flex; align-items: center; gap: 0.5rem; }
  .calc-teaser__steps span::before { content: counter(step, decimal-leading-zero); counter-increment: step; font-family: var(--font-display); font-weight: 700; color: var(--haldi-deep); }
  .calc-teaser__steps { counter-reset: step; }

  /* ===== 9. PROJECT PATHWAYS ===== */
  .pathways-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--bg-card); }
  .pathways-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .pathways-section__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); letter-spacing: -0.02em; }
  .pathways-grid { display: grid; gap: 0; border-left: 1px solid var(--border); border-top: 1px solid var(--border); }
  @media (min-width: 640px) { .pathways-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .pathways-grid { grid-template-columns: repeat(4, 1fr); } }
  .pathway-col { padding: 1.75rem; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); display: flex; flex-direction: column; gap: 0.625rem; transition: background var(--dur); }
  .pathway-col:hover { background: var(--secondary-bg); }
  .pathway-col__num { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--haldi-deep); line-height: 1; }
  .pathway-col__title { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; }
  .pathway-col__desc { font-size: 0.875rem; color: var(--fg-muted); line-height: 1.6; }
  .pathways-foot { text-align: center; margin-top: 2.5rem; }

  /* ===== 10. BRAND CLOSE ===== */
  .brand-close { padding-block: clamp(2.5rem, 5vw, 4rem); text-align: center; }
  .brand-close__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2.25rem); color: var(--haldi-deep); }
  .brand-close__phrase { margin-top: 0.5rem; font-family: var(--font-display); font-style: italic; font-size: clamp(1.125rem, 2.5vw, 1.5rem); color: var(--fg); }
  .brand-close__stroke { margin: 1.5rem auto 0; max-width: 12rem; height: 3rem; }
</style>

<!-- ===== 1. HERO ===== -->
<section class="hero" id="hero" data-reveal>
    <div class="container hero__container">
        <div class="hero__lockup">
            <span class="hero__devanagari" aria-label="Gaurikrit in Devanagari"><?= e($COMPANY['devanagari']) ?></span>
            <span class="hero__brand-sub">Gaurikrit Bio Products</span>
            <h1 class="hero__title"><?= e($COMPANY['headline']) ?></h1>
            <p class="hero__sub">Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls.</p>
            <div class="hero__ctas">
                <a href="/products/" class="btn btn--primary btn--lg">
                    Explore Prakritik Paint
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="/why-prakritik/" class="btn btn--outline btn--lg">Why Prakritik?</a>
            </div>
        </div>
        <div class="hero__art" aria-hidden="true">
            <div class="hero__stroke"><?php render_illustration('paint-brush-stroke', ['class' => 'hero__stroke-inner']); ?></div>
            <div class="hero__group product-media" data-official-image="<?= e($groupImage) ?>">
                <img class="product-media__official" src="<?= e($groupImage) ?>" alt="Prakritik Paint group" width="640" height="480">
                <div class="product-media__fallback"><?php render_illustration('prakritik-emulsion-bucket'); ?></div>
            </div>
            <div class="hero__cow"><?php render_illustration('indian-cow'); ?></div>
        </div>
    </div>
    <div class="container">
        <div class="hero__landscape" aria-hidden="true"><?php render_illustration('rural-landscape'); ?></div>
    </div>
</section>

<!-- ===== 2. MATERIAL STATEMENT ===== -->
<section class="section section--paper" id="material-statement" data-reveal>
    <div class="container">
        <div class="material-statement">
            <div>
                <span class="material-statement__eyebrow">The material idea</span>
                <div class="material-statement__deva">प्रकृति से</div>
                <h2 class="material-statement__title">An old Indian material idea, reconsidered for modern walls.</h2>
                <hr class="material-statement__rule">
                <div class="material-statement__body">
                    <p>Traditional Indian homes have long used cow-dung-based wall coatings. Prakritik Paint brings that material idea into a contemporary paint format.</p>
                    <p>The result is a wall coating that carries a familiar material lineage — re-expressed as a workable modern paint.</p>
                </div>
            </div>
            <div class="material-statement__visual" aria-hidden="true">
                <div class="ms-cow"><?php render_illustration('indian-cow'); ?></div>
                <span class="ms-arrow">→</span>
                <div class="ms-wall"></div>
            </div>
        </div>
    </div>
</section>

<!-- ===== 3. TWO PRODUCTS ===== -->
<section class="two-products" id="two-products" data-reveal>
    <div class="container">
        <div class="two-products__head">
            <span class="two-products__eyebrow">Prakritik Paint</span>
            <h2 class="two-products__title">Two formats. One Prakritik idea.</h2>
        </div>
        <div class="two-products__grid">
            <?php
            $panels = [
                ['product' => $distemper, 'modifier' => 'mat-panel--distemper', 'cta' => 'Explore Distemper'],
                ['product' => $emulsion,  'modifier' => 'mat-panel--emulsion',  'cta' => 'Explore Emulsion'],
            ];
            foreach ($panels as $panel):
                $p = $panel['product'];
                if (!$p) continue;
            ?>
            <article class="mat-panel <?= e($panel['modifier']) ?>">
                <div class="mat-panel__media">
                    <div class="product-media" data-official-image="<?= e($p['officialImage']) ?>">
                        <img class="product-media__official" src="<?= e($p['officialImage']) ?>" alt="<?= e($p['name']) ?>" width="640" height="480">
                        <div class="product-media__fallback"><?php render_illustration($p['image'] . '-bucket'); ?></div>
                    </div>
                </div>
                <div class="mat-panel__body">
                    <span class="mat-panel__eyebrow"><?= e($p['descriptor']) ?></span>
                    <h3 class="mat-panel__name"><?= e($p['name']) ?></h3>
                    <p class="mat-panel__desc">Cow dung-based Prakritik paint for interior and exterior walls.</p>
                    <dl class="mat-panel__specs">
                        <div class="mat-panel__spec"><dt>Packaging</dt><dd><?= e($p['packagingShort']) ?></dd></div>
                        <div class="mat-panel__spec"><dt>Finish</dt><dd><?= e($p['finish']) ?></dd></div>
                        <div class="mat-panel__spec"><dt>Usage</dt><dd><?= e($p['usage']) ?></dd></div>
                    </dl>
                    <div class="mat-panel__cta">
                        <a href="<?= e($p['route']) ?>"><?= e($panel['cta']) ?>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== 4. MATERIAL JOURNEY ===== -->
<section class="journey-section section--paper" id="material-journey" data-reveal>
    <div class="container">
        <div class="journey-section__head">
            <span class="section-heading__eyebrow">How the material becomes paint</span>
            <h2 class="journey-section__title">From nature to the wall.</h2>
        </div>
        <div class="journey-wrap" data-material-journey>
            <div class="material-journey__svg" aria-hidden="true"><?php render_illustration('material-journey'); ?></div>
            <ol class="journey-steps" data-reveal-stagger>
                <?php foreach ($MATERIAL_JOURNEY as $stage): ?>
                <li class="journey-step">
                    <div class="journey-step__num"><?= e($stage['num']) ?></div>
                    <div class="journey-step__title"><?= e($stage['title']) ?></div>
                    <div class="journey-step__desc"><?= e($stage['desc']) ?></div>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- ===== 5. ASHTA LAABH ===== -->
<section class="ashta-section" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="ashta-section__head">
            <div class="ashta-section__deva" lang="hi"><?= e('अष्ट लाभ') ?></div>
            <p class="ashta-section__sub">Eight benefits presented in Prakritik Paint.</p>
            <p class="ashta-section__note">A reading of the material, not a verified claim.</p>
        </div>
        <div class="ashta-grid" data-ashta-laabh>
            <div class="ashta-grid__diagram" aria-hidden="true"><?php render_illustration('ashta-laabh-diagram'); ?></div>
            <ol class="ashta-grid__list" data-reveal-stagger>
                <?php foreach ($ASHTA_LAABH as $i => $benefit): $bid = 'al-' . ($i + 1); ?>
                <li class="ashta-benefit" data-ashta-node="<?= e($bid) ?>">
                    <span class="ashta-benefit__num"><?= sprintf('%02d', $i + 1) ?></span>
                    <span class="ashta-benefit__name"><?= e($benefit['name']) ?></span>
                    <span class="ashta-benefit__deva" lang="hi"><?= e($benefit['hindi']) ?></span>
                </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</section>

<!-- ===== 6. COLOURS OF INDIA ===== -->
<section class="colours-section" id="colours-of-india" data-reveal>
    <div class="container">
        <div class="colours-section__head">
            <h2 class="colours-section__title">Colours of India.</h2>
            <p class="colours-section__sub">An editorial colour study inspired by Indian material landscapes.</p>
            <span class="colours-section__tag">Editorial colour study</span>
        </div>
        <div data-colour-study>
            <div class="colours-wall" data-colour-wall style="background:#f4efe2;">
                <div class="colours-wall__overlay" aria-hidden="true"></div>
                <div class="colours-wall__art" aria-hidden="true"><?php render_illustration('indian-courtyard'); ?></div>
                <span class="colours-wall__label" data-colour-label>Chuna — Lime</span>
            </div>
            <div class="colours-swatches" role="radiogroup" aria-label="Colour study swatches">
                <?php foreach ($COLOUR_STUDY as $i => $swatch): ?>
                <button type="button" class="colours-swatch" role="radio" aria-checked="false"
                        data-shade="<?= e($swatch['hex']) ?>"
                        data-shade-name="<?= e($swatch['name']) ?> — <?= e($swatch['label']) ?>"
                        aria-label="<?= e($swatch['name']) ?> — <?= e($swatch['label']) ?>"
                        style="background:<?= e($swatch['hex']) ?>;">
                    <span class="colours-swatch__label"><?= e($swatch['name']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ===== 7. MISSION ===== -->
<section class="mission" id="mission" data-reveal>
    <div class="mission__botanical" aria-hidden="true"><?php render_illustration('field-botanicals'); ?></div>
    <div class="container">
        <div class="mission__inner">
            <div>
                <span class="mission__eyebrow">Mission</span>
                <div class="mission__deva">प्रकृति से, दीवारों तक</div>
            </div>
            <div>
                <h2 class="mission__title"><?= e($COMPANY['mission']) ?></h2>
                <p class="mission__body">Gaurikrit Bio Products works with a familiar Indian material — cow dung — and brings it into a contemporary paint format. The work sits at the intersection of agricultural reuse, rural opportunity, and eco-friendly wall coatings.</p>
                <div class="mission__cta">
                    <a href="/about/" class="btn btn--haldi btn--lg">About Gaurikrit</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== 8. CALCULATOR TEASER ===== -->
<section class="calc-teaser section--paper" id="calculator-teaser" data-reveal>
    <div class="container">
        <div class="calc-teaser__inner">
            <div>
                <span class="calc-teaser__eyebrow">Project planning</span>
                <h2 class="calc-teaser__title">Planning to paint?</h2>
                <p class="calc-teaser__body">Start with your project size and paint type. A short indicative estimate takes a few steps.</p>
                <ol class="calc-teaser__steps">
                    <span>Fresh painting or repainting</span>
                    <span>Interior or exterior</span>
                    <span>Distemper or Emulsion</span>
                    <span>Wall area in sq.ft.</span>
                </ol>
                <div class="calc-teaser__cta">
                    <a href="/paint-calculator/" class="btn btn--primary btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="calc-teaser__art" aria-hidden="true">
                <?php render_illustration('paint-brush-stroke'); ?>
            </div>
        </div>
    </div>
</section>

<!-- ===== 9. PROJECT PATHWAYS ===== -->
<section class="pathways-section" id="pathways" data-reveal>
    <div class="container">
        <div class="pathways-section__head">
            <span class="section-heading__eyebrow">Who is this for</span>
            <h2 class="pathways-section__title">Planning a project?</h2>
        </div>
        <ol class="pathways-grid">
            <?php foreach ($PROJECT_PATHWAYS as $i => $path): ?>
            <li class="pathway-col">
                <div class="pathway-col__num"><?= sprintf('%02d', $i + 1) ?></div>
                <h3 class="pathway-col__title"><?= e($path['title']) ?></h3>
                <p class="pathway-col__desc"><?= e($path['desc']) ?></p>
            </li>
            <?php endforeach; ?>
        </ol>
        <div class="pathways-foot">
            <a href="/for-business/" class="btn btn--outline btn--lg">Talk to Gaurikrit
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ===== 10. BRAND CLOSE ===== -->
<section class="brand-close" id="brand-close" data-reveal>
    <div class="container">
        <div class="brand-close__deva" lang="hi"><?= e($COMPANY['devanagari']) ?></div>
        <p class="brand-close__phrase"><?= e($COMPANY['brandLine']) ?></p>
        <div class="brand-close__stroke" aria-hidden="true"><?php render_illustration('paint-brush-stroke'); ?></div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
