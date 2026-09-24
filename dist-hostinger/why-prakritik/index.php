<?php
/**
 * Gaurikrit Bio Products — Why Prakritik.
 * Task PAGES-LOCK. Illustrated editorial essay.
 * 7 numbered sections: 01 THE MATERIAL / 02 THE TRADITION / 03 FROM
 * MATERIAL TO PAINT / 04 ASHTA LAABH / 05 TWO FORMATS / 06 SUSTAINABILITY
 * CONTEXT / 07 CTA.
 */
declare(strict_types=1);

$pageTitle       = 'Why Prakritik Paint — Gaurikrit Bio Products';
$pageDescription = 'Why Prakritik Paint — an old Indian material idea, reconsidered for modern walls. Cow dung-based paint from Gaurikrit Bio Products.';
$pageCanonical   = '/why-prakritik/';
$pageClass       = 'why-prakritik';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $ASHTA_LAABH, $MATERIAL_JOURNEY;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
?>
<style>
  /* HERO */
  .why-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2.5rem, 5vw, 4rem); position: relative; overflow: hidden; }
  .why-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .why-hero__container { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .why-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); width: fit-content; }
  .why-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .why-hero__title { margin-top: 1.25rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance; }
  .why-hero__sub { margin-top: 1.25rem; max-width: 36rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .why-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }
  .why-hero__art { position: relative; aspect-ratio: 4/3; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); }
  .why-hero__art .why-hero__cow { position: absolute; left: 1.5rem; bottom: 1rem; width: 50%; opacity: 0.9; }
  .why-hero__art .why-hero__wall { position: absolute; right: 1rem; top: 1rem; bottom: 1rem; width: 38%; border-radius: var(--radius); background: linear-gradient(135deg, var(--haldi-light), var(--haldi)); border: 1px solid var(--haldi-deep); overflow: hidden; }
  .why-hero__art .why-hero__wall::after { content: ''; position: absolute; inset: 0; background-image: radial-gradient(circle at 1px 1px, oklch(0.28 0.04 150 / 0.08) 0.5px, transparent 0); background-size: 14px 14px; }

  /* ESSAY */
  .essay { padding-block: clamp(3rem, 6vw, 5rem); }
  .essay__section { display: grid; gap: 1.5rem; padding-block: clamp(2rem, 4vw, 3rem); border-top: 1px solid var(--border); }
  .essay__section:first-of-type { border-top: 0; }
  @media (min-width: 1024px) { .essay__section { grid-template-columns: 0.85fr 1.15fr; gap: 4rem; align-items: start; } }
  .essay__section--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) { .essay__section--reverse > :first-child { order: 0; } }
  .essay__num { font-family: var(--font-display); font-size: clamp(3rem, 7vw, 5rem); font-weight: 700; color: var(--haldi-deep); line-height: 0.9; opacity: 0.85; }
  .essay__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); margin-top: 0.75rem; }
  .essay__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.15; margin-top: 0.5rem; letter-spacing: -0.02em; }
  .essay__body { color: var(--fg-muted); font-size: clamp(1rem, 1.5vw, 1.125rem); line-height: 1.75; }
  .essay__body p + p { margin-top: 1.25rem; }
  .essay__pull { font-family: var(--font-display); font-style: italic; font-size: clamp(1.125rem, 2vw, 1.5rem); color: var(--primary); padding-left: 1.25rem; border-left: 3px solid var(--haldi); margin: 1.5rem 0; }
  .essay__body ul { list-style: disc; padding-left: 1.5rem; margin: 1rem 0; }
  .essay__body li { color: var(--fg-muted); margin-bottom: 0.5rem; line-height: 1.65; }
  .essay__rule { width: 4rem; height: 2px; background: var(--haldi); margin-block: 1.5rem; border: 0; }

  /* MATERIAL JOURNEY inline */
  .journey-inline { padding: 1.5rem; background: var(--secondary-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); margin-top: 1rem; }
  .journey-inline .material-journey__svg { max-height: 8rem; margin-inline: auto; }
  .journey-inline__steps { display: grid; gap: 0.75rem; margin-top: 1.5rem; }
  @media (min-width: 768px) { .journey-inline__steps { grid-template-columns: repeat(5, 1fr); } }
  .journey-inline__step { padding: 0.5rem; }
  .journey-inline__num { font-family: var(--font-display); font-size: 1rem; font-weight: 700; color: var(--haldi-deep); }
  .journey-inline__title { font-size: 0.8125rem; font-weight: 700; margin-top: 0.25rem; }
  .journey-inline__desc { font-size: 0.75rem; color: var(--fg-muted); margin-top: 0.125rem; }

  /* ASHTA LAABH full */
  .ashta-essay { padding-block: clamp(2rem, 4vw, 3rem); }
  .ashta-essay__grid { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .ashta-essay__grid { grid-template-columns: 1fr 1fr; } }
  .ashta-essay__diagram { max-width: 28rem; margin-inline: auto; width: 100%; aspect-ratio: 1; }
  .ashta-essay__diagram svg { width: 100%; height: 100%; }
  .ashta-essay__list { display: grid; gap: 0.625rem; }
  .ashta-essay__item { padding: 0.875rem 1.125rem; background: var(--bg-card); border-left: 3px solid var(--haldi); border-radius: var(--radius); display: grid; grid-template-columns: 2rem 1fr auto; gap: 0.75rem; align-items: center; box-shadow: var(--shadow-soft); cursor: pointer; transition: background var(--dur), border-color var(--dur), transform var(--dur); }
  .ashta-essay__item:hover, .ashta-essay__item:focus-visible, .ashta-essay__item[data-active="true"] { background: oklch(0.42 0.05 150 / 0.06); border-left-color: var(--forest); transform: translateX(2px); outline: none; }
  .ashta-essay__item:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
  .ashta-essay__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .ashta-essay__name { font-weight: 600; font-size: 0.9375rem; }
  .ashta-essay__deva { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* TWO FORMATS mini */
  .two-formats-mini { display: grid; gap: 1rem; margin-top: 1.25rem; }
  @media (min-width: 640px) { .two-formats-mini { grid-template-columns: 1fr 1fr; } }
  .two-formats-mini__item { padding: 1rem 1.25rem; border: 1px solid var(--border); border-radius: var(--radius); background: var(--bg-card); }
  .two-formats-mini__name { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; }
  .two-formats-mini__desc { font-size: 0.8125rem; color: var(--fg-muted); margin-top: 0.25rem; }
  .two-formats-mini__link { display: inline-flex; align-items: center; gap: 0.25rem; margin-top: 0.5rem; font-size: 0.8125rem; font-weight: 600; color: var(--primary); }
  .two-formats-mini__link:hover { gap: 0.5rem; }

  /* CTA */
  .why-cta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--forest); color: var(--primary-fg); text-align: center; }
  .why-cta__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi); }
  .why-cta__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); margin-top: 0.75rem; letter-spacing: -0.02em; text-wrap: balance; }
  .why-cta__sub { margin-top: 0.75rem; color: oklch(0.85 0.01 75); max-width: 36rem; margin-inline: auto; }
  .why-cta__actions { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- HERO -->
<section class="why-hero" id="why-hero" data-reveal>
    <div class="container why-hero__container">
        <div>
            <span class="why-hero__eyebrow"><span class="why-hero__eyebrow-dot" aria-hidden="true"></span>Why Prakritik</span>
            <h1 class="why-hero__title">An old material idea, reconsidered for modern walls.</h1>
            <hr class="why-hero__rule">
            <p class="why-hero__sub">A short reading of where Prakritik Paint comes from — the material, the tradition it carries, and the contemporary paint format it has become.</p>
        </div>
        <div class="why-hero__art" aria-hidden="true">
            <div class="why-hero__cow"><?php render_illustration('indian-cow'); ?></div>
            <div class="why-hero__wall"></div>
        </div>
    </div>
</section>

<!-- ESSAY (numbered sections) -->
<section class="essay" id="essay">

    <!-- 01 THE MATERIAL -->
    <article class="container essay__section" id="material" data-reveal>
        <div>
            <div class="essay__num">01</div>
            <div class="essay__eyebrow">The material</div>
            <h2 class="essay__title">Cow dung, as a wall-coating material.</h2>
        </div>
        <div class="essay__body">
            <p>Cow dung is a familiar material in Indian domestic life. It has long been used as a wall and floor coating — a way of refreshing a surface and bringing an everyday material back into the home.</p>
            <p class="essay__pull">The material idea is older than the paint format.</p>
            <p>Prakritik Paint begins with this material — gathered, prepared, and brought into a paint format that can be applied with a brush.</p>
        </div>
    </article>

    <!-- 02 THE TRADITION -->
    <article class="container essay__section" id="tradition" data-reveal>
        <div>
            <div class="essay__num">02</div>
            <div class="essay__eyebrow">The tradition</div>
            <h2 class="essay__title">A traditional Indian wall practice.</h2>
        </div>
        <div class="essay__body">
            <p>Traditional Indian homes have long used cow-dung-based wall coatings. The practice is domestic — part of cleaning and refreshing living spaces — and rural, tied to the rhythms of the household and the herd.</p>
            <p>Prakritik Paint does not replace the practice. It carries the material idea into a contemporary paint format that can be applied to interior and exterior walls.</p>
        </div>
    </article>

    <!-- 03 FROM MATERIAL TO PAINT -->
    <article class="container essay__section essay__section--reverse" id="from-material-to-paint" data-reveal>
        <div>
            <div class="essay__num">03</div>
            <div class="essay__eyebrow">From material to paint</div>
            <h2 class="essay__title">Five stages, from nature to the wall.</h2>
        </div>
        <div>
            <div class="essay__body">
                <p>The journey from cow dung to painted wall passes through five stages — gathered, prepared, blended, applied.</p>
                <hr class="essay__rule">
            </div>
            <div class="journey-inline" data-material-journey>
                <div class="material-journey__svg" aria-hidden="true"><?php render_illustration('material-journey'); ?></div>
                <ol class="journey-inline__steps">
                    <?php foreach ($MATERIAL_JOURNEY as $stage): ?>
                    <li class="journey-inline__step">
                        <div class="journey-inline__num"><?= e($stage['num']) ?></div>
                        <div class="journey-inline__title"><?= e($stage['title']) ?></div>
                        <div class="journey-inline__desc"><?= e($stage['desc']) ?></div>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </article>

    <!-- 04 ASHTA LAABH (full interaction) -->
    <article class="container essay__section" id="ashta-laabh" data-reveal>
        <div>
            <div class="essay__num">04</div>
            <div class="essay__eyebrow">Ashta Laabh</div>
            <h2 class="essay__title">Eight benefits presented in Prakritik Paint.</h2>
            <div class="essay__body">
                <p style="margin-top: 1rem;">A reading of the material, not a verified claim.</p>
                <ul>
                    <li>Antibacterial, Antifungal — material qualities presented as benefits.</li>
                    <li>Eco-Friendly, Non-Toxic, Odourless — read alongside the cow-dung lineage.</li>
                    <li>Cost-Effective, Free from Heavy Metals, Natural Thermal Insulator.</li>
                </ul>
            </div>
        </div>
        <div class="ashta-essay">
            <div class="ashta-essay__grid" data-ashta-laabh>
                <div class="ashta-essay__diagram" aria-hidden="true"><?php render_illustration('ashta-laabh-diagram'); ?></div>
                <ol class="ashta-essay__list" data-reveal-stagger>
                    <?php foreach ($ASHTA_LAABH as $i => $benefit): $bid = 'wp-al-' . ($i + 1); ?>
                    <li class="ashta-essay__item" data-ashta-node="<?= e($bid) ?>">
                        <span class="ashta-essay__num"><?= sprintf('%02d', $i + 1) ?></span>
                        <span class="ashta-essay__name"><?= e($benefit['name']) ?></span>
                        <span class="ashta-essay__deva" lang="hi"><?= e($benefit['hindi']) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </article>

    <!-- 05 TWO FORMATS -->
    <article class="container essay__section essay__section--reverse" id="two-formats" data-reveal>
        <div>
            <div class="essay__num">05</div>
            <div class="essay__eyebrow">Two formats</div>
            <h2 class="essay__title">Distemper and Emulsion.</h2>
        </div>
        <div class="essay__body">
            <p>Prakritik Paint is presented in two formats — Distemper (powder, sold by kilogram) and Emulsion (liquid, sold by litre). Both are white, matt, and suitable for interior and exterior walls.</p>
            <div class="two-formats-mini">
                <div class="two-formats-mini__item">
                    <div class="two-formats-mini__name"><?= e($distemper['name']) ?></div>
                    <div class="two-formats-mini__desc"><?= e($distemper['packagingShort']) ?> · <?= e($distemper['finish']) ?> · <?= e($distemper['usage']) ?></div>
                    <a href="<?= e($distemper['route']) ?>" class="two-formats-mini__link">Explore Distemper
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="two-formats-mini__item">
                    <div class="two-formats-mini__name"><?= e($emulsion['name']) ?></div>
                    <div class="two-formats-mini__desc"><?= e($emulsion['packagingShort']) ?> · <?= e($emulsion['finish']) ?> · <?= e($emulsion['usage']) ?></div>
                    <a href="<?= e($emulsion['route']) ?>" class="two-formats-mini__link">Explore Emulsion
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </article>

    <!-- 06 SUSTAINABILITY CONTEXT -->
    <article class="container essay__section" id="sustainability-context" data-reveal>
        <div>
            <div class="essay__num">06</div>
            <div class="essay__eyebrow">Sustainability context</div>
            <h2 class="essay__title">Where the work sits.</h2>
        </div>
        <div class="essay__body">
            <p>Prakritik Paint sits at the intersection of a few threads — without quantifying any of them.</p>
            <ul>
                <li><strong>Agricultural-waste reuse.</strong> Cow dung is repurposed into a wall-coating material.</li>
                <li><strong>Gaushala context.</strong> A natural fit with gaushala-led bio-product conversations.</li>
                <li><strong>Rural opportunity.</strong> The material and the work sit close to rural India.</li>
                <li><strong>Eco-friendly framing.</strong> A wall coating read alongside the wider eco-friendly conversation.</li>
            </ul>
            <p class="essay__pull">Material reuse, not a quantified claim.</p>
        </div>
    </article>
</section>

<!-- 07 CTA -->
<section class="why-cta" id="explore" data-reveal>
    <div class="container">
        <span class="why-cta__eyebrow">07 · Next step</span>
        <h2 class="why-cta__title">See the formats, then talk to Gaurikrit.</h2>
        <p class="why-cta__sub">Explore the two Prakritik Paint formats — Distemper and Emulsion — or send an enquiry with your project in mind.</p>
        <div class="why-cta__actions">
            <a href="/products/" class="btn btn--haldi btn--lg">Explore Products</a>
            <a href="/contact/" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Talk to Us</a>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
