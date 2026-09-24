<?php
/**
 * Gaurikrit Bio Products — About.
 * Task PAGES-LOCK. Institutional / brand manifesto.
 * Sections: WHO WE ARE / WHAT WE CURRENTLY PRESENT / OUR MATERIAL DIRECTION /
 * MISSION / BRAND PRINCIPLE / COMPANY INFORMATION.
 * No timeline, no founder.
 */
declare(strict_types=1);

$pageTitle       = 'About — Gaurikrit Bio Products';
$pageDescription = 'Gaurikrit Bio Products (OPC) Private Limited — based in Khurja, District Bulandshahr, Uttar Pradesh. Presenting cow dung-based Prakritik Paint in Distemper and Emulsion formats.';
$pageCanonical   = '/about/';
$pageClass        = 'about';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $PRODUCTS, $PROJECT_PATHWAYS;

$address = $COMPANY['address'] ?? [];
$phones  = $COMPANY['phones'] ?? [];
$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
?>
<style>
  /* HERO */
  .about-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2.5rem, 5vw, 4rem); background: var(--bg); position: relative; overflow: hidden; }
  .about-hero__container { display: grid; gap: 2rem; align-items: center; position: relative; z-index: 1; }
  @media (min-width: 1024px) { .about-hero__container { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .about-hero__lockup { display: flex; flex-direction: column; gap: 0.625rem; }
  .about-hero__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(2rem, 5vw, 3rem); color: var(--haldi-deep); line-height: 1; }
  .about-hero__brand-sub { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.28em; text-transform: uppercase; color: var(--primary); }
  .about-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance; }
  .about-hero__body { margin-top: 1.25rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .about-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }
  .about-hero__art { position: relative; aspect-ratio: 4/3; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); padding: 1rem; display: flex; align-items: center; justify-content: center; }

  /* MANIFESTO sections */
  .manifesto { padding-block: clamp(3rem, 6vw, 5rem); }
  .manifesto__section { display: grid; gap: 1.5rem; padding-block: clamp(2rem, 4vw, 3rem); border-top: 1px solid var(--border); }
  .manifesto__section:first-of-type { border-top: 0; }
  @media (min-width: 1024px) { .manifesto__section { grid-template-columns: 0.7fr 1.3fr; gap: 4rem; align-items: start; } }
  .manifesto__section--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) { .manifesto__section--reverse > :first-child { order: 0; } }
  .manifesto__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .manifesto__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); margin-top: 0.25rem; }
  .manifesto__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.15; margin-top: 0.5rem; letter-spacing: -0.02em; text-wrap: balance; }
  .manifesto__body { color: var(--fg-muted); font-size: clamp(1rem, 1.5vw, 1.125rem); line-height: 1.75; }
  .manifesto__body p + p { margin-top: 1.25rem; }
  .manifesto__pull { font-family: var(--font-display); font-style: italic; font-size: clamp(1.125rem, 2vw, 1.5rem); color: var(--primary); padding-left: 1.25rem; border-left: 3px solid var(--haldi); margin: 1.5rem 0; }
  .manifesto__rule { width: 4rem; height: 2px; background: var(--haldi); margin-block: 1.5rem; border: 0; }
  .manifesto__list { display: grid; gap: 0.75rem; margin-top: 1rem; }
  .manifesto__list-item { padding: 0.875rem 1.125rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); }
  .manifesto__list-name { font-family: var(--font-display); font-size: 1.0625rem; font-weight: 700; }
  .manifesto__list-desc { font-size: 0.8125rem; color: var(--fg-muted); margin-top: 0.125rem; }

  /* BRAND PRINCIPLE — large type forest section */
  .brand-principle { padding-block: clamp(3.5rem, 7vw, 6rem); background: var(--forest); color: var(--primary-fg); text-align: center; position: relative; overflow: hidden; }
  .brand-principle__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi); }
  .brand-principle__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2.25rem); margin-top: 0.75rem; color: oklch(0.88 0.11 85); }
  .brand-principle__phrase { font-family: var(--font-display); font-style: italic; font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.1; margin-top: 1.5rem; text-wrap: balance; }
  .brand-principle__rule { width: 4rem; height: 2px; background: var(--haldi); margin: 1.5rem auto; border: 0; }
  .brand-principle__body { max-width: 36rem; margin-inline: auto; color: oklch(0.85 0.01 75); line-height: 1.75; }

  /* COMPANY INFORMATION */
  .company-info { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .company-info__head { margin-bottom: 2.5rem; }
  .company-info__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .company-info__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .company-info__grid { display: grid; gap: 2rem; }
  @media (min-width: 768px) { .company-info__grid { grid-template-columns: 1fr 1fr; } }
  .company-info__card { padding: clamp(1.5rem, 4vw, 2.5rem); background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  .company-info__card-title { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; }
  .company-info__row { display: grid; grid-template-columns: 7rem 1fr; gap: 0.75rem; padding: 0.5rem 0; border-bottom: 1px dashed var(--border); }
  .company-info__row:last-child { border-bottom: 0; }
  .company-info__row dt { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); padding-top: 0.125rem; }
  .company-info__row dd { font-size: 0.9375rem; }
  .company-info__row dd a { color: var(--primary); font-weight: 600; }
  .company-info__address { white-space: pre-line; }
  .company-info__actions { margin-top: 1.5rem; display: flex; flex-direction: column; gap: 0.625rem; }
</style>

<!-- HERO -->
<section class="about-hero" id="about-hero" data-reveal>
    <div class="container about-hero__container">
        <div class="about-hero__lockup">
            <span class="about-hero__deva" lang="hi"><?= e($COMPANY['devanagari']) ?></span>
            <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
            <h1 class="about-hero__title">Nature. Culture. Useful materials.</h1>
            <hr class="about-hero__rule">
            <p class="about-hero__body">Gaurikrit Bio Products (OPC) Private Limited is based in Khurja, District Bulandshahr, Uttar Pradesh.</p>
        </div>
        <div class="about-hero__art" aria-hidden="true">
            <?php render_illustration('gaushala-scene'); ?>
        </div>
    </div>
</section>

<!-- MANIFESTO -->
<section class="manifesto" id="manifesto">
    <div class="container">

        <!-- WHO WE ARE -->
        <article class="manifesto__section" id="who-we-are" data-reveal>
            <div>
                <div class="manifesto__num">01</div>
                <div class="manifesto__label">Who we are</div>
                <h2 class="manifesto__title">Legal identity.</h2>
            </div>
            <div class="manifesto__body">
                <p><strong><?= e($COMPANY['legalName']) ?></strong> is a private limited company registered in India. The studio is in Khurja, in District Bulandshahr, Uttar Pradesh.</p>
                <p class="manifesto__pull">A small, named organisation — not a faceless brand.</p>
                <p>Gaurikrit works with bio-based materials. Prakritik Paint is the company's current paint presentation.</p>
            </div>
        </article>

        <!-- WHAT WE CURRENTLY PRESENT -->
        <article class="manifesto__section manifesto__section--reverse" id="what-we-present" data-reveal>
            <div>
                <div class="manifesto__num">02</div>
                <div class="manifesto__label">What we currently present</div>
                <h2 class="manifesto__title">Two products, today.</h2>
            </div>
            <div>
                <div class="manifesto__body">
                    <p>Currently, Prakritik Paint is presented in two formats — Distemper and Emulsion. Both are white, matt, and suitable for interior and exterior walls.</p>
                </div>
                <div class="manifesto__list">
                    <div class="manifesto__list-item">
                        <div class="manifesto__list-name"><?= e($distemper['name']) ?></div>
                        <div class="manifesto__list-desc"><?= e($distemper['descriptor']) ?> · <?= e($distemper['packagingShort']) ?> · <?= e($distemper['finish']) ?> · <?= e($distemper['usage']) ?></div>
                    </div>
                    <div class="manifesto__list-item">
                        <div class="manifesto__list-name"><?= e($emulsion['name']) ?></div>
                        <div class="manifesto__list-desc"><?= e($emulsion['descriptor']) ?> · <?= e($emulsion['packagingShort']) ?> · <?= e($emulsion['finish']) ?> · <?= e($emulsion['usage']) ?></div>
                    </div>
                </div>
            </div>
        </article>

        <!-- OUR MATERIAL DIRECTION -->
        <article class="manifesto__section" id="material-direction" data-reveal>
            <div>
                <div class="manifesto__num">03</div>
                <div class="manifesto__label">Our material direction</div>
                <h2 class="manifesto__title">Cow dung, reconsidered.</h2>
            </div>
            <div class="manifesto__body">
                <p>Gaurikrit works with cow dung as a wall-coating material. The direction is material-first — what traditional Indian homes have long used, brought into a contemporary paint format.</p>
                <p class="manifesto__pull">प्रकृति से, दीवारों तक।</p>
                <p>The wider context — agricultural-waste reuse, gaushala-led bio-products, rural material opportunity — is where the work sits, without quantifying it.</p>
            </div>
        </article>

        <!-- MISSION -->
        <article class="manifesto__section manifesto__section--reverse" id="mission" data-reveal>
            <div>
                <div class="manifesto__num">04</div>
                <div class="manifesto__label">Mission</div>
                <h2 class="manifesto__title">A simple statement.</h2>
            </div>
            <div class="manifesto__body">
                <p class="manifesto__pull" style="font-size: clamp(1.5rem, 3vw, 2.25rem); border-left-width: 4px;"><?= e($COMPANY['mission']) ?></p>
                <p>One wall at a time. The work is patient — gathered, prepared, blended, applied.</p>
            </div>
        </article>
    </div>
</section>

<!-- BRAND PRINCIPLE (forest section) -->
<section class="brand-principle" id="brand-principle" data-reveal>
    <div class="container">
        <span class="brand-principle__eyebrow">05 · Brand principle</span>
        <div class="brand-principle__deva" lang="hi">प्रकृति से, दीवारों तक</div>
        <hr class="brand-principle__rule">
        <p class="brand-principle__phrase"><?= e($COMPANY['brandLine']) ?></p>
        <p class="brand-principle__body">The principle is short, on purpose. The work is to bring a familiar material into a contemporary paint format — and to keep that material honest.</p>
    </div>
</section>

<!-- COMPANY INFORMATION -->
<section class="company-info" id="company-info" data-reveal>
    <div class="container">
        <div class="company-info__head">
            <div class="company-info__eyebrow">06 · Company information</div>
            <h2 class="company-info__title">Reach Gaurikrit directly.</h2>
        </div>
        <div class="company-info__grid">
            <div class="company-info__card">
                <h3 class="company-info__card-title">Registered address</h3>
                <dl>
                    <div class="company-info__row">
                        <dt>Legal name</dt>
                        <dd><?= e($COMPANY['legalName']) ?></dd>
                    </div>
                    <div class="company-info__row">
                        <dt>Address</dt>
                        <dd class="company-info__address"><?php foreach ($address as $line) { echo e($line) . "\n"; } ?></dd>
                    </div>
                    <div class="company-info__row">
                        <dt>GSTIN</dt>
                        <dd><?= e($COMPANY['gstin']) ?></dd>
                    </div>
                </dl>
            </div>
            <div class="company-info__card">
                <h3 class="company-info__card-title">Direct contact</h3>
                <dl>
                    <div class="company-info__row">
                        <dt>Email</dt>
                        <dd><a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a></dd>
                    </div>
                    <?php foreach ($phones as $i => $phone): ?>
                    <div class="company-info__row">
                        <dt>Phone <?= $i + 1 ?></dt>
                        <dd><a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a></dd>
                    </div>
                    <?php endforeach; ?>
                </dl>
                <div class="company-info__actions">
                    <a href="mailto:<?= e($COMPANY['email']) ?>" class="btn btn--outline btn--block">Email Gaurikrit</a>
                    <?php if (!empty($phones[0])): ?>
                    <a href="tel:<?= e(str_replace(' ', '', $phones[0])) ?>" class="btn btn--primary btn--block">Call Gaurikrit</a>
                    <?php endif; ?>
                    <a href="/contact/" class="btn btn--ghost btn--block">Send an enquiry</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require ROOT_PATH . '/includes/footer.php';
