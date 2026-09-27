<?php
/**
 * Gaurikrit Bio Products — Our Story (V16 restructure of /about/).
 * Route stays /about/; NAV LABEL becomes "Our Story" (§8).
 *
 * The brand narrative (§28), in order:
 *   01 THE RESOURCE          cow dung as a traditionally useful material
 *   02 THE IDEA              resource → practical contemporary applications
 *   03 THE GAURIKRIT JOURNEY RESOURCE → IDEA → APPLICATION → ECOSYSTEM
 *                            (qualitative only — NO dates, §29)
 *   04 THE CIRCULAR MODEL    expanded seven-stage loop
 *   05 THE PRODUCT ECOSYSTEM paint / fuel / traditional-ritual / utility
 *   06 VISION                forest two-column (shared §42.9)
 *   07 MISSION
 *   08 COMPANY INFORMATION   verified legal ledger (retained)
 *
 * No invented milestones, dates, facilities or partners. Factual data
 * unchanged from data.php.
 */
declare(strict_types=1);

$pageTitle       = 'Our Story — Gaurikrit Bio Products';
$pageDescription = 'The Gaurikrit story: one natural resource — cow dung — recognised by traditional India, carried into practical contemporary applications: Eco-Paints, fuel directions and utility products. Khurja, District Bulandshahr, Uttar Pradesh.';
$pageCanonical   = '/about/';
$pageClass       = 'about';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY, $FAMILIES, $CIRCULAR_STAGES, $PRODUCTS;

$distemper = get_product('prakritik-distemper');
$emulsion  = get_product('prakritik-emulsion');
$address   = $COMPANY['address'];
$addressLine = implode("\n", array_slice($address, 0, 6));
$groupImage = '/assets/products/prakritik-group.jpg';
?>
<style>
  /* ===== STORY HERO — brand identity left, real product plate right ===== */
  .about-hero {
    padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 1.5rem;
  }
  .about-hero__container {
    display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) {
    .about-hero__container { grid-template-columns: 5fr 7fr; }
  }
  .about-hero__lockup { display: flex; flex-direction: column; gap: 0.75rem; }
  .about-hero__deva {
    font-family: var(--font-deva);
    font-size: 1.75rem; color: var(--primary); line-height: 1.2;
  }
  .about-hero__brand-sub {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .about-hero__title {
    font-family: var(--font-display);
    font-size: clamp(2.25rem, 4.5vw, 3.75rem); line-height: 1.06;
    letter-spacing: -0.02em;
  }
  .about-hero__body {
    max-width: 38rem; font-size: 1.0625rem; line-height: 1.65;
    color: var(--fg-muted);
  }
  .about-hero__plate {
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    padding: clamp(1rem, 2vw, 1.5rem);
    display: flex; flex-direction: column; gap: 1rem;
  }
  .about-hero__plate-head {
    display: flex; align-items: center; gap: 0.875rem;
    padding-bottom: 0.875rem; border-bottom: 1px solid var(--border);
  }
  .about-hero__plate-mark { border-radius: 6px; }
  .about-hero__plate-brand {
    font-family: var(--font-deva);
    font-size: 1.25rem; color: var(--primary); line-height: 1.2;
    display: flex; flex-direction: column; gap: 0.125rem;
  }
  .about-hero__plate-brand small {
    font-family: var(--font-sans);
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .about-hero__plate-photo {
    display: block; width: 100%; height: auto;
    object-fit: contain;
  }

  /* ===== STORY WRAP — chapters flow on alternating families ===== */
  .story-wrap { padding-block: clamp(3.5rem, 6vw, 5.5rem); }
  .story-wrap--first { padding-top: clamp(3rem, 5vw, 4.5rem); }

  /* ===== ECOSYSTEM (compact families, no media) ===== */
  .story-families { margin-top: 2rem; }

  /* ===== COMPANY PLATE — modern ledger (retained V5/V12 design) ===== */
  .company-plate-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .company-plate__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .company-plate {
    display: grid; gap: 0;
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    background: var(--paper);
    overflow: hidden;
    max-width: 56rem;
  }
  .company-plate__row {
    display: grid; gap: 0.75rem;
    padding: 1.125rem 1.5rem;
    border-bottom: 1px solid var(--border);
  }
  .company-plate__row:last-child { border-bottom: 0; }
  @media (min-width: 768px) {
    .company-plate__row { grid-template-columns: 12rem 1fr; align-items: baseline; }
  }
  .company-plate dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .company-plate dd { color: var(--fg); }
  .company-plate__address { white-space: pre-line; }
</style>

<!-- ===== STORY HERO ===== -->
<section class="about-hero bg-limewash" aria-labelledby="about-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Our Story</span>
    </nav>
    <div class="about-hero__container" data-reveal>
      <div class="about-hero__lockup">
        <span class="about-hero__deva"><?= e($COMPANY['devanagari']) ?></span>
        <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
        <h1 class="about-hero__title" id="about-title">One resource. One idea. A widening material story.</h1>
        <p class="about-hero__body">
          <?= e($COMPANY['legalName']) ?> builds a material ecosystem around one
          natural resource — cow dung — from Prakritik Paint to fuel and utility
          directions. Based in <?= e($address[3] ?? '') ?>,
          <?= e($address[4] ?? '') ?>, Uttar Pradesh.
        </p>
      </div>
      <div class="about-hero__plate">
        <div class="about-hero__plate-head">
          <img class="about-hero__plate-mark"
               src="<?= asset_url('/assets/brand/gaurikrit-logo-mark.png') ?>"
               alt="Gaurikrit brand mark"
               width="40" height="40"
               loading="eager" decoding="async">
          <div class="about-hero__plate-brand">
            गौरीकृत
            <small>Prakritik Paint</small>
          </div>
        </div>
        <img class="about-hero__plate-photo"
             src="<?= asset_url($groupImage) ?>"
             alt="Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints family"
             width="1280" height="621"
             loading="eager" fetchpriority="high" decoding="async">
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     01. THE RESOURCE — cow dung as a traditionally useful material
     ============================================================ -->
<section class="section section--paper story-wrap story-wrap--first" id="the-resource" aria-labelledby="resource-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">01</span>
        <span class="story-chapter__kicker">The Resource</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="resource-ch-title">A material traditional India never wasted.</h2>
        <div class="story-chapter__body">
          <p>
            Traditional India has long recognised cow dung as a useful material —
            applied to walls and floors, valued in daily rural life, and treated
            as a resource rather than a waste.
          </p>
          <p class="muted">
            Gaurikrit begins from that recognition: a natural, renewable material
            already embedded in Indian material culture.
          </p>
        </div>
        <figure class="story-chapter__visual">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/raw-material-study.webp') ?>">
            <img src="<?= asset_url('/assets/editorial/raw-material-study.jpg') ?>"
                 alt="Raw lime-plastered wall surface — an Indian natural material tradition"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
          <figcaption>Raw material study — natural surface traditions of Indian homes.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     02. THE IDEA — from resource to practical applications
     ============================================================ -->
<section class="section section--limewash story-wrap" id="the-idea" aria-labelledby="idea-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">02</span>
        <span class="story-chapter__kicker">The Idea</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="idea-ch-title">Carry the resource into contemporary applications.</h2>
        <div class="story-chapter__body">
          <p>
            The idea is directional, not nostalgic: take a material India already
            understands and develop it into practical contemporary products —
            from naturally derived wall coatings to fuel and utility directions.
          </p>
          <p class="muted">
            From naturally derived material to products for walls, energy and
            everyday use.
          </p>
        </div>
        <figure class="story-chapter__visual">
          <picture>
            <source type="image/webp" srcset="<?= asset_url('/assets/editorial/finished-surface-study.webp') ?>">
            <img src="<?= asset_url('/assets/editorial/finished-surface-study.jpg') ?>"
                 alt="Finished matte wall surface — a developed natural material"
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
          <figcaption>Developed material study — the resource carried into a finished surface.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     03. THE GAURIKRIT JOURNEY — qualitative, NO dates (§29)
     RESOURCE → IDEA → APPLICATION → ECOSYSTEM
     ============================================================ -->
<section class="section section--paper story-wrap" id="the-journey" aria-labelledby="journey-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">03</span>
        <span class="story-chapter__kicker">The Gaurikrit Journey</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="journey-ch-title">A journey of material stages — not dates.</h2>
        <div class="story-chapter__body">
          <p>
            Gaurikrit's story is told through what the material became, not when.
            Each stage widened the possibility of the resource.
          </p>
        </div>
        <div class="journey-strip" data-reveal>
          <div class="journey-stop">
            <span class="journey-stop__stage">Stage 01</span>
            <h3 class="journey-stop__name">Resource</h3>
            <p class="journey-stop__desc">Cow dung — recognised and gathered.</p>
          </div>
          <div class="journey-stop">
            <span class="journey-stop__stage">Stage 02</span>
            <h3 class="journey-stop__name">Idea</h3>
            <p class="journey-stop__desc">A practical direction for a traditional material.</p>
          </div>
          <div class="journey-stop">
            <span class="journey-stop__stage">Stage 03</span>
            <h3 class="journey-stop__name">Application</h3>
            <p class="journey-stop__desc">Prakritik Paint — walls, documented.</p>
          </div>
          <div class="journey-stop">
            <span class="journey-stop__stage">Stage 04</span>
            <h3 class="journey-stop__name">Ecosystem</h3>
            <p class="journey-stop__desc">Fuel and utility directions around one resource.</p>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     04. THE CIRCULAR MODEL — expanded seven-stage loop
     ============================================================ -->
<section class="section section--limewash story-wrap" id="the-circular-model" aria-labelledby="circular-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">04</span>
        <span class="story-chapter__kicker">The Circular Model</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="circular-ch-title">Nothing goes to waste.</h2>
        <div class="story-chapter__body">
          <p>
            The expanded circular model — how the resource enters, is developed,
            becomes useful products, and renews the cycle.
          </p>
        </div>
        <div class="circular" data-circular data-reveal>
          <ol class="circular__track">
            <?php foreach ($CIRCULAR_STAGES as $stage): ?>
              <li class="stage">
                <span class="stage__num"><?= e($stage['num']) ?></span>
                <h3 class="stage__name"><?= e($stage['name']) ?></h3>
                <p class="stage__desc"><?= e($stage['desc']) ?></p>
              </li>
            <?php endforeach; ?>
          </ol>
          <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
            <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
          </svg>
          <span class="circular__loop-label" aria-hidden="true">Resource regeneration</span>
        </div>
        <p class="impact-note" style="margin-top: 1.5rem;">
          Read the full framework on <a href="/sustainability/">Sustainability →</a>
        </p>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     05. THE PRODUCT ECOSYSTEM — paint / fuel / traditional / utility
     Compact family chapters (no media — the story stays quiet).
     ============================================================ -->
<section class="section section--paper story-wrap" id="the-ecosystem" aria-labelledby="ecosystem-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">05</span>
        <span class="story-chapter__kicker">The Product Ecosystem</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="ecosystem-ch-title">One resource, four directions.</h2>
        <div class="story-chapter__body">
          <p>
            The ecosystem spans walls, energy, traditional applications and
            everyday use. Eco-Paints — Prakritik Distemper and Prakritik
            Emulsion — is the documented family; the other three are
            development directions.
          </p>
        </div>
        <div class="families story-families" data-reveal-stagger>
          <?php foreach ($FAMILIES as $family): ?>
            <article class="family">
              <div class="family__head">
                <span class="family__num" aria-hidden="true"><?= e($family['num']) ?></span>
                <h3 class="family__name"><?= e($family['name']) ?></h3>
              </div>
              <p class="family__line"><?= e($family['line']) ?></p>
              <ul class="family__themes">
                <?php foreach ($family['themes'] as $theme): ?>
                  <li><?= e($theme) ?></li>
                <?php endforeach; ?>
              </ul>
              <a class="family__cta" href="<?= e($family['href']) ?>">
                Explore <?= e($family['name']) ?> <span aria-hidden="true">→</span>
              </a>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     06 + 07. VISION + MISSION — forest two-column (§26 language)
     ============================================================ -->
<section class="section section--forest vision-mission" aria-labelledby="story-vision-title">
  <div class="container">
    <div class="vision-mission__grid">
      <div class="vision-mission__col">
        <span class="vision-mission__eyebrow">Vision</span>
        <h2 class="vision-mission__title" id="story-vision-title">
          A circular-economy company in the making.
        </h2>
        <p class="vision-mission__text">
          <?= e($COMPANY['vision']) ?>
        </p>
      </div>
      <div class="vision-mission__col vision-mission__col--mission">
        <span class="vision-mission__eyebrow">Mission</span>
        <h2 class="vision-mission__title">
          Practical alternatives, responsibly made.
        </h2>
        <p class="vision-mission__text">
          To replace less sustainable alternatives with practical, accessible and
          environmentally responsible product solutions.
        </p>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--haldi" href="/products/">Explore the Ecosystem</a>
          <a class="btn btn--secondary" href="/contact/">Talk to Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     08. COMPANY INFORMATION — verified legal ledger (retained)
     ============================================================ -->
<section class="section section--paper company-plate-section" aria-labelledby="company-info-title">
  <div class="container">
    <div class="company-plate__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Company information</span>
      <h2 class="section-heading__title" id="company-info-title">A registered Indian company.</h2>
    </div>

    <dl class="company-plate" data-reveal>
      <div class="company-plate__row">
        <dt>Legal name</dt>
        <dd><?= e($COMPANY['legalName']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>Brand name</dt>
        <dd><?= e($COMPANY['name']) ?> · <?= e($COMPANY['devanagari']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>GSTIN</dt>
        <dd><?= e($COMPANY['gstin']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>Email</dt>
        <dd>
          <a href="mailto:<?= e($COMPANY['email']) ?>"><?= e($COMPANY['email']) ?></a>
        </dd>
      </div>
      <?php foreach ($COMPANY['phones'] as $phone): ?>
        <div class="company-plate__row">
          <dt>Phone</dt>
          <dd>
            <a href="tel:<?= e(str_replace(' ', '', $phone)) ?>"><?= e($phone) ?></a>
          </dd>
        </div>
      <?php endforeach; ?>
      <div class="company-plate__row">
        <dt>Registered address</dt>
        <dd class="company-plate__address"><?= e($addressLine) ?></dd>
      </div>
    </dl>

    <div class="company-info__actions" style="margin-top: 2.5rem;">
      <a class="btn btn--primary" href="/contact/">Talk to Us</a>
      <a class="btn btn--outline" href="/for-business/">Partners</a>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
