<?php
/**
 * Gaurikrit Bio Products — Our Story (V18 restructure of /about/).
 * Route stays /about/; NAV LABEL stays "Our Story".
 *
 * The brand narrative (V18 §40), in order:
 *   01 THE RESOURCE                cow dung as a traditionally useful material
 *   02 THE IDEA                    resource → practical applications
 *   03 FROM RESOURCE TO            three REAL stages — natural material /
 *      APPLICATION                 documented paint / client-supplied logs
 *                                  (qualitative only — NO dates, §25/§29)
 *   04 VISION + MISSION            forest two-column (shared §42.9)
 *   05 REGISTERED COMPANY          verified legal ledger (retained)
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

global $COMPANY, $PRODUCTS;

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
  /* V18 §47B: white-ground client photography sits in a DELIBERATE
     catalogue plate (visible border + padding) — never an accidental
     white rectangle on the paper ground. */
  .resource-step__figure--plate {
    background: #fff; display: flex; align-items: center;
    padding: clamp(0.5rem, 1vw, 0.75rem);
  }
  .resource-step__figure--plate img {
    position: static; inset: auto; width: auto; max-width: 100%;
    max-height: 100%; height: auto; object-fit: contain;
  }
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
            <source type="image/avif" srcset="<?= eco_srcset('rawmat', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
            <source type="image/webp" srcset="<?= eco_srcset_webp('rawmat', [640, 960, 1280, 1920]) ?>"
                    sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
            <img src="<?= asset_url('/assets/images/ecosystem/rawmat-960.jpg') ?>"
                 alt="Raw natural biomass material with straw fibre — the resource"
                 width="960" height="549"
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
              <source type="image/avif" srcset="<?= eco_srcset('innovation-research', [640, 960, 1280, 1920]) ?>"
                      sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
              <source type="image/webp" srcset="<?= eco_srcset_webp('innovation-research', [640, 960, 1280, 1920]) ?>"
                      sizes="(min-width: 1024px) 42vw, calc(100vw - 2.5rem)">
              <img src="<?= asset_url('/assets/images/ecosystem/innovation-research-960.jpg') ?>"
                   alt="Material research samples — raw biomass, processed log and finished coating"
                   width="960" height="600"
                   loading="lazy" decoding="async">
            </picture>
          <figcaption>Developed material study — the resource carried into a finished surface.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     04. FROM RESOURCE TO APPLICATION (V18 §40 / §25)
     The story's widening, told with REAL assets: the natural material,
     the documented application (real paint), the expanding direction
     (client-supplied cow-dung logs). NOT the same beige plaster three
     times; NOT the kraft-box mockup. The journey is stages, not dates.
     ============================================================ -->
<section class="section section--paper story-wrap" id="from-resource-to-application" aria-labelledby="application-ch-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">03</span>
        <span class="story-chapter__kicker">From Resource to Application</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="application-ch-title">
          A journey of material stages — not dates.
        </h2>
        <div class="story-chapter__body">
          <p>
            Gaurikrit's story is told through what the material became, not when.
            The resource became a documented wall coating — and the same material
            now widens into fuel and utility directions.
          </p>
        </div>

        <div class="resource-steps" data-reveal-stagger>
          <article class="resource-step">
            <figure class="resource-step__figure">
                              <picture>
                  <source type="image/avif" srcset="<?= eco_srcset('rawmat', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <source type="image/webp" srcset="<?= eco_srcset_webp('rawmat', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <img src="<?= asset_url('/assets/images/ecosystem/rawmat-960.jpg') ?>"
                       alt="Raw natural biomass material — the resource"
                       width="960" height="549"
                       loading="lazy" decoding="async">
                </picture>
            </figure>
            <div class="resource-step__caption">
              <span class="resource-step__kicker">Stage 01 — Resource</span>
              <h3 class="resource-step__title">The natural material</h3>
              <p class="resource-step__desc">
                Cow dung — a material traditional India never wasted.
              </p>
            </div>
          </article>
          <article class="resource-step">
            <figure class="resource-step__figure">
                              <picture>
                  <source type="image/avif" srcset="<?= eco_srcset('eco-paints-pair', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <source type="image/webp" srcset="<?= eco_srcset_webp('eco-paints-pair', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <img src="<?= asset_url('/assets/images/ecosystem/eco-paints-pair-960.jpg') ?>"
                       alt="Prakritik Distemper and Prakritik Emulsion paint packs — the documented application"
                       width="960" height="600"
                       loading="lazy" decoding="async">
                </picture>
            </figure>
            <div class="resource-step__caption">
              <span class="resource-step__kicker">Stage 02 — Application</span>
              <h3 class="resource-step__title">Prakritik Paint</h3>
              <p class="resource-step__desc">
                The documented family — Distemper and Emulsion, walls done.
              </p>
            </div>
          </article>
          <article class="resource-step">
            <figure class="resource-step__figure resource-step__figure--plate">
                              <picture>
                  <source type="image/avif" srcset="<?= eco_srcset('gocast-material', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <source type="image/webp" srcset="<?= eco_srcset_webp('gocast-material', [640, 960, 1280]) ?>"
                          sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)">
                  <img src="<?= asset_url('/assets/images/ecosystem/gocast-material-960.jpg') ?>"
                       alt="Client-supplied cow-dung log material — the widening direction"
                       width="960" height="640"
                       loading="lazy" decoding="async">
                </picture>
            </figure>
            <div class="resource-step__caption">
              <span class="resource-step__kicker">Stage 03 — Widening</span>
              <h3 class="resource-step__title">Expanding directions</h3>
              <p class="resource-step__desc">
                Client-supplied cow-dung log material — fuel, traditional and
                utility directions in development.
              </p>
            </div>
          </article>
        </div>

        <p class="impact-note" style="margin-top: 1.75rem;">
          The four-direction ecosystem lives on
          <a href="/products/">Products →</a> — the circular framework on
          <a href="/sustainability/">Sustainability →</a>
        </p>
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
