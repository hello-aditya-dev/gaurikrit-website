<?php
/**
 * Gaurikrit Bio Products — Our Story (V29 Story1.1 implementation).
 * Route stays /about/; NAV LABEL stays "Our Story".
 *
 * Primary content source: GBP Story1.1.docx (client-selected).
 * Story2.docx is secondary reference only — its purchasing claim
 * and alternate closing quote are NOT included.
 *
 * Five-section narrative + opening + closing, with client-supplied
 * images. Product statuses preserved: Bio-Briquettes and Eco Utility
 * Products are Futureline; Cow-Dung Logs is a development direction.
 * The campus image is qualified as a concept visual until the client
 * confirms it depicts an actual operational facility.
 */
declare(strict_types=1);

$pageTitle       = 'Our Story — When Reverence Becomes Responsibility | Gaurikrit';
$pageDescription = 'The Gaurikrit story: when reverence becomes responsibility. A story of compassion, circularity and a sustainable India — transforming cow dung into sustainable products while restoring the dignity of Gau Mata.';
$pageCanonical   = '/about/';
$pageClass       = 'about';

require_once __DIR__ . '/../../includes/bootstrap.php';
require ROOT_PATH . '/includes/header.php';

global $COMPANY;
$address   = $COMPANY['address'];
$addressLine = implode("\n", array_slice($address, 0, 6));
?>
<style>
  /* ===== STORY PAGE — premium editorial long-form ===== */
  .story-page { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1rem; }

  .story-hero {
    display: grid; gap: clamp(2rem, 5vw, 4rem); align-items: center;
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 1024px) {
    .story-hero { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: clamp(2.5rem, 5vw, 5rem); }
  }
  .story-hero__lockup { display: flex; flex-direction: column; gap: 1rem; }
  .story-hero__quote {
    font-family: var(--font-display); font-size: clamp(1rem, 2vw, 1.25rem);
    font-style: italic; color: var(--forest); line-height: 1.5;
    border-left: 3px solid var(--haldi); padding-left: 1rem;
    max-width: 36rem;
  }
  .story-hero__title {
    font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700; letter-spacing: -0.02em; line-height: 1.1;
    text-wrap: balance; color: var(--primary);
  }
  .story-hero__subtitle {
    font-size: clamp(1rem, 2vw, 1.25rem); color: var(--fg-muted);
    line-height: 1.4; max-width: 36rem;
  }
  .story-hero__image {
    position: relative; aspect-ratio: 5 / 4; overflow: hidden;
    border-radius: var(--r-panel); background: var(--paper-warm);
    box-shadow: 0 4px 24px rgba(16, 47, 32, 0.12);
  }
  .story-hero__image img {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }

  /* ===== Story sections ===== */
  .story-section {
    padding-block: clamp(2.5rem, 5vw, 4.5rem);
  }
  .story-section__inner {
    max-width: 48rem; margin: 0 auto;
  }
  .story-section__inner--wide { max-width: 60rem; }
  .story-section__num {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.2em;
    text-transform: uppercase; color: var(--haldi); margin-bottom: 0.5rem;
  }
  .story-section__title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem);
    font-weight: 700; letter-spacing: -0.01em; line-height: 1.2;
    margin-bottom: 1.25rem; text-wrap: balance;
  }
  .story-section__body {
    font-size: clamp(1rem, 1.5vw, 1.125rem); line-height: 1.75;
    color: var(--fg); max-width: 42rem;
  }
  .story-section__body p { margin-bottom: 1rem; text-align: justify; hyphens: auto; }
  .story-section__list { list-style: none; padding: 0; margin: 0 0 1rem 0; }
  .story-section__list li { position: relative; padding-left: 1.5rem; margin-bottom: 0.625rem; text-align: justify; line-height: 1.6; }
  .story-section__list li::before { content: ''; position: absolute; left: 0; top: 0.55em; width: 0.5rem; height: 0.5rem; border-radius: 50%; background: var(--haldi); }
  .story-section__body--forest .story-section__list li::before { background: var(--haldi); }
  .story-section__body p:last-child { margin-bottom: 0; }
  .story-section__image {
    margin-top: 2rem; position: relative; overflow: hidden;
    border-radius: var(--r-panel); background: var(--paper-warm);
    box-shadow: 0 2px 16px rgba(16, 47, 32, 0.08);
  }
  .story-section__image picture { display: block; }
  .story-section__image img {
    width: 100%; height: auto; display: block;
  }
  .story-section__image--contain img {
    object-fit: contain; max-height: 36rem;
  }
  .story-section__image figcaption {
    padding: 0.75rem 1.25rem; font-size: 0.75rem; color: var(--fg-muted);
    border-top: 1px solid var(--border); letter-spacing: 0.02em;
    font-style: italic;
  }

  /* Alternating layouts for visual rhythm — V37: explicit grid order, no direction:rtl */
  .story-section--alt .story-section__inner {
    max-width: none; display: grid; gap: clamp(2rem, 5vw, 4rem); align-items: center;
    grid-template-columns: minmax(0, 1fr);
  }
  @media (min-width: 1024px) {
    .story-section--alt .story-section__inner {
      grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
    }
    .story-section--alt-reverse .story-section__inner {
      grid-template-columns: minmax(0, 7fr) minmax(0, 5fr);
    }
  }
  /* Mobile: copy first, image second for ALL sections (predictable reading order) */
  .story-section--alt .story-section__copy { order: 1; }
  .story-section--alt .story-section__image { order: 2; margin-top: 0; }
  /* Desktop: reverse sections swap copy/image via grid order, not direction */
  @media (min-width: 1024px) {
    .story-section--alt-reverse .story-section__copy { order: 2; }
    .story-section--alt-reverse .story-section__image { order: 1; margin-top: 0; }
  }

  /* Forest section scoped classes (V38: explicit contrast — no opacity dimming) */
  .story-section__inner--forest { color: var(--paper); }
  .story-section__num--forest { color: var(--haldi); }
  .story-section__title--forest { color: var(--paper); }
  .story-section__body--forest { color: var(--paper); }
  .story-section__body--forest p { color: var(--paper); }
  .story-section__body--forest strong,
  .story-section__body--forest em { color: var(--paper); }
  .story-section__sequence {
    text-align: center; font-weight: 600; font-size: 1.125em; line-height: 1.6;
    color: var(--paper); padding: 1rem 0;
    border-top: 1px solid color-mix(in srgb, var(--paper) 20%, transparent);
    border-bottom: 1px solid color-mix(in srgb, var(--paper) 20%, transparent);
  }
  @media (max-width: 768px) {
    .story-section__sequence { font-size: 0.875em; line-height: 1.8; }
  }

  /* Closing statement */
  .story-closing {
    padding-block: clamp(3rem, 6vw, 5rem); text-align: center;
  }
  .story-closing__statement {
    font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.5rem);
    font-weight: 700; font-style: italic; line-height: 1.35;
    color: var(--forest); max-width: 42rem; margin: 0 auto;
    text-wrap: balance;
    padding: clamp(1.5rem, 3vw, 2.5rem) clamp(1rem, 3vw, 3rem);
    background: color-mix(in srgb, var(--haldi) 8%, var(--paper));
    border-left: 3px solid var(--haldi);
    border-radius: var(--r-card);
  }
  .story-closing__divider {
    width: 3rem; height: 2px; background: var(--haldi);
    margin: 2rem auto;
  }

  /* Concept-visual qualifier */
  .concept-qualifier {
    display: inline-block; font-size: 0.6875rem; font-weight: 600;
    letter-spacing: 0.1em; text-transform: uppercase; color: var(--fg-muted);
    background: color-mix(in srgb, var(--haldi) 10%, transparent);
    padding: 0.25rem 0.625rem; border-radius: 0.1875rem; margin-bottom: 1rem;
    border: 1px solid color-mix(in srgb, var(--haldi) 30%, transparent);
  }

  /* Product status inline */
  .product-status-inline {
    font-size: 0.75rem; font-weight: 600; color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 12%, transparent);
    padding: 0.125rem 0.5rem; border-radius: 0.1875rem;
    white-space: nowrap;
  }
</style>

<!-- ============================================================
     STORY HERO — Opening
     ============================================================ -->
<section class="story-page bg-limewash" aria-labelledby="story-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>›</span>
      <span>Our Story</span>
    </nav>
    <div class="story-hero" data-reveal>
      <div class="story-hero__lockup">
        <p class="story-hero__quote">
          &ldquo;The cow that nourished us for years should never lose her worth when she stops giving milk&rdquo;
        </p>
        <h1 class="story-hero__title" id="story-hero-title">When Reverence<br>Becomes Responsibility</h1>
        <p class="story-hero__subtitle">A Story of Compassion, Circularity &amp; a Sustainable India</p>
      </div>
      <figure class="story-hero__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('story-gir-cow-calf', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 50vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('story-gir-cow-calf', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 50vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/story-gir-cow-calf-960.jpg') ?>"
               alt="A Gir cow and calf at golden hour — the opening image of the Gaurikrit story"
               width="1254" height="1254" fetchpriority="high" decoding="async">
        </picture>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     Opening narrative
     ============================================================ -->
<section class="section section--paper story-section">
  <div class="container">
    <div class="story-section__inner">
      <div class="story-section__body">
        <p>For centuries, we have worshipped the cow as a mother. But somewhere along the journey of modernization, we began to forget what it truly means to care for her.</p>
        <p>In Indian civilization, the cow has never been merely an animal. She has been revered as <em>Gau Mata</em> &mdash; a symbol of nourishment, compassion, abundance. Deeply woven into our traditions, she has been associated with divine presence, agricultural prosperity, and the very foundation of rural life.</p>
        <p>She gave us so much. Yet today, we must ask ourselves one uncomfortable question:</p>
        <p><strong>What happens to Gau Mata when she can no longer give us milk?</strong></p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     Section 1 — Restoring the Dignity of Gau Mata
     ============================================================ -->
<section class="section section--limewash story-section story-section--alt">
  <div class="container">
    <div class="story-section__inner">
      <div class="story-section__copy">
        <span class="story-section__num">Section 1</span>
        <h2 class="story-section__title">Restoring the Dignity of Gau Mata</h2>
        <div class="story-section__body">
          <p>Across India, countless cows face abandonment when they grow old or stop producing milk.</p>
          <p>For a farmer struggling with rising costs, maintaining a non-milking cow can become an economic burden. Fodder, shelter, veterinary care and daily maintenance continue, even when income from milk stops.</p>
          <p>And so, an animal once considered an essential part of the family may find herself wandering through crowded streets, searching for food among garbage, exposed to traffic, disease and neglect.</p>
          <p><em>How can an animal we worship become an animal we abandon?</em></p>
          <p>We believe that reverence must be expressed not only through rituals and traditions, but through meaningful action.</p>
          <p>A cow&rsquo;s dignity should never depend on her ability to produce milk. Her value must continue throughout her life.</p>
        </div>
      </div>
      <figure class="story-section__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('story-tender-moment', [640, 960, 1224]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('story-tender-moment', [640, 960, 1224]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/story-tender-moment-960.jpg') ?>"
               alt="A person sits beside a resting cow, caring for her tenderly — representing compassion for Gau Mata"
               width="1224" height="1285" loading="lazy" decoding="async">
        </picture>
        <figcaption>A moment of compassion &mdash; caring for a cow beyond her milk-producing years.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     Section 2 — Giving Farmers a Reason to Care
     ============================================================ -->
<section class="section section--paper story-section story-section--alt story-section--alt-reverse">
  <div class="container">
    <div class="story-section__inner">
      <div class="story-section__copy">
        <span class="story-section__num">Section 2</span>
        <h2 class="story-section__title">Giving Farmers a Reason to Care &mdash; Turning Compassion into Livelihood</h2>
        <div class="story-section__body">
          <p>Through modern innovation, GAURIKRIT&reg; transforms natural resources into sustainable products &mdash; including cow-dung logs, bio-briquettes, eco-friendly paints, and biodegradable utility products.</p>
          <p>Our biomass fuel solutions aim to reduce dependence on conventional firewood, help protect trees, and promote responsible energy alternatives.</p>
          <p>What was once considered waste becomes a resource. What was once a burden becomes an opportunity.</p>
          <p>
            <span class="product-status-inline">Bio-Briquettes: Futureline &middot; Not yet in production</span><br>
            <span class="product-status-inline">Eco Utility Products: Futureline &middot; Not yet in production</span><br>
            <span class="product-status-inline">Cow-Dung Logs: Development direction</span>
          </p>
        </div>
      </div>
      <figure class="story-section__image story-section__image--contain">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('story-product-showcase', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('story-product-showcase', [640, 960, 1254]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/story-product-showcase-960.jpg') ?>"
               alt="Gaurikrit product showcase — Prakritik Paint and dhoop cups representing the product ecosystem. Bio-Briquettes and Eco Utility Products are Futureline directions, not yet in production."
               width="1254" height="1254" loading="lazy" decoding="async">
        </picture>
        <figcaption>Client-supplied product artwork. Bio-Briquettes and Eco Utility Products are Futureline directions, not yet in production.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     Section 3 — Saving Trees by Rethinking Fuel
     ============================================================ -->
<section class="section section--limewash story-section story-section--alt">
  <div class="container">
    <div class="story-section__inner">
      <div class="story-section__copy">
        <span class="story-section__num">Section 3</span>
        <h2 class="story-section__title">Saving Trees by Rethinking Fuel &mdash; From Cow Dung to Green Energy</h2>
        <div class="story-section__body">
          <p>Every tree has a story. It absorbs carbon dioxide, supports biodiversity, protects soil, and provides life-sustaining ecological services.</p>
          <p>Yet wood continues to be consumed as fuel in many traditional and commercial applications, adding pressure to forest and tree resources.</p>
          <p>Why should valuable trees be cut for fuel when agricultural and livestock by-products can be transformed into useful alternatives?</p>
          <p>This thinking inspired our focus on renewable biomass-based fuel solutions.</p>
          <p>Through products such as Cow-Dung Logs, Bio-Briquettes, and other biomass fuels, GAURIKRIT&reg; aims to provide alternatives to conventional firewood and selected fossil-based fuels wherever technically and environmentally appropriate.</p>
          <p>Our vision is to help reduce dependence on wood-based fuel, promote responsible biomass utilization, and encourage cleaner, more resource-efficient energy practices.</p>
          <p>We believe that the future of energy should not come at the cost of our forests. Every responsible alternative to harvested firewood is an opportunity to protect trees. Every underutilized natural resource transformed into a useful product is a step toward a more circular economy. And every innovation that reduces unnecessary resource extraction brings us closer to a sustainable tomorrow.</p>
        </div>
      </div>
      <figure class="story-section__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('story-cattle-shelter', [640, 960, 1028]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('story-cattle-shelter', [640, 960, 1028]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/story-cattle-shelter-960.jpg') ?>"
               alt="A cattle shelter with cows and a caretaker — representing organized cattle care and the connection to biomass fuel alternatives"
               width="1028" height="1188" loading="lazy" decoding="async">
        </picture>
        <figcaption>Organized cattle care connects to biomass fuel alternatives &mdash; an illustrative direction, not a verified GAURIKRIT facility.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     Section 4 — Cleaner Streets, Healthier Communities
     ============================================================ -->
<section class="section section--paper story-section story-section--alt story-section--alt-reverse">
  <div class="container">
    <div class="story-section__inner">
      <div class="story-section__copy">
        <span class="story-section__num">Section 4</span>
        <h2 class="story-section__title">Cleaner Streets, Healthier Communities &mdash; Giving Waste a Purpose</h2>
        <span class="concept-qualifier">Concept visual &mdash; not a photograph of an operational facility</span>
        <div class="story-section__body">
          <p>In many Indian towns and cities, abandoned cattle are a familiar sight. They wander along roads, gather near garbage dumps, and sometimes feed on plastic and contaminated waste.</p>
          <p>Their unmanaged dung and urine can contribute to sanitation problems in public spaces, while their presence on busy roads creates risks for both animals and people.</p>
          <p>But the problem is not the cow. The problem is a system that has failed to recognize the value of what she naturally produces.</p>
          <p>We envision a different approach. What was once left unattended can become an input for useful products. What was once considered a sanitation burden can become a source of livelihood. What was once discarded can become part of a sustainable manufacturing ecosystem.</p>
          <p>We do not see cow dung as waste. We see an opportunity waiting to be transformed.</p>
          <p>Our aspiration is to support cleaner communities, healthier surroundings, and a more dignified existence for cattle.</p>
        </div>
      </div>
      <figure class="story-section__image">
        <picture>
          <source type="image/avif" srcset="<?= eco_srcset('story-campus', [640, 960, 1101]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <source type="image/webp" srcset="<?= eco_srcset_webp('story-campus', [640, 960, 1101]) ?>"
                  sizes="(min-width: 1024px) 45vw, calc(100vw - 2.5rem)">
          <img src="<?= asset_url('/assets/images/ecosystem/story-campus-960.jpg') ?>"
               alt="Conceptual visual of a sustainable bioproducts campus at sunrise &mdash; an artist's impression, not a photograph of an existing operational GAURIKRIT facility"
               width="1101" height="618" loading="lazy" decoding="async">
        </picture>
        <figcaption>Concept visual &mdash; artist&rsquo;s impression. Not a photograph of an operational GAURIKRIT facility unless the client confirms otherwise.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     Section 5 — From India's Traditions to India's Tomorrow
     ============================================================ -->
<section class="section section--forest story-section story-section--forest">
  <div class="container">
    <div class="story-section__inner story-section__inner--forest">
      <span class="story-section__num story-section__num--forest">Section 5</span>
      <h2 class="story-section__title story-section__title--forest">From India&rsquo;s Traditions to India&rsquo;s Tomorrow &mdash; Building a Circular Economy</h2>
      <div class="story-section__body story-section__body--forest">
        <p>India has always understood something that the modern world is rediscovering: Nature operates in cycles, not in waste. What comes from the earth can often return to the earth or be transformed into something useful.</p>
        <p>Through cow-dung-based products, renewable biomass fuels, eco-friendly paints, biodegradable utility products, and future sustainable technologies, we envision an ecosystem where natural resources are continuously reimagined for productive use.</p>
        <p>An ecosystem that connects:</p>
        <p class="story-section__sequence">
          Animal Welfare &rarr; Farmer Livelihoods &rarr; Resource Recovery &rarr; Sustainable Products &rarr; Environmental Responsibility &rarr; National Growth
        </p>
        <p>This is the circular economy we want to help build:</p>
        <ul class="story-section__list">
          <li>One where farmers become stakeholders in sustainability.</li>
          <li>One where rural resource creates new economic opportunities.</li>
          <li>One where innovation supports resource conservation and responsible energy production.</li>
          <li>One where traditional Indian knowledge becomes the foundation for modern sustainable enterprise.</li>
          <li>And one where India&rsquo;s economic progress can advance alongside environmental stewardship.</li>
        </ul>
        <p>We aspire to contribute to a more self-reliant, resource-efficient, and environmentally responsible India. Not merely by manufacturing products, but by helping create value from resources that society has overlooked.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     Closing Statement
     ============================================================ -->
<section class="section section--paper story-closing">
  <div class="container">
    <p class="story-closing__statement">
      &ldquo;She Gave Us a Lifetime of Nourishment.<br>
      We Owe Her a Lifetime of Dignity&rdquo;
    </p>
    <div class="story-closing__divider"></div>
    <p style="font-size: 0.875rem; color: var(--fg-muted); letter-spacing: 0.1em; text-transform: uppercase;">
      GAURIKRIT&reg; &mdash; Redefining Resources. Regenerating the Future.
    </p>
  </div>
</section>

<!-- ============================================================
     Company Information — verified legal ledger (preserved)
     ============================================================ -->
<section class="section section--paper company-plate-section" aria-labelledby="company-info-title">
  <div class="container">
    <div class="company-plate__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Company information</span>
      <h2 class="section-heading__title" id="company-info-title">A registered Indian company</h2>
    </div>

    <dl class="company-plate" data-reveal>
      <div class="company-plate__row">
        <dt>Legal name</dt>
        <dd><?= e($COMPANY['legalName']) ?></dd>
      </div>
      <div class="company-plate__row">
        <dt>Brand name</dt>
        <dd><?= e($COMPANY['name']) ?> &middot; <?= e($COMPANY['devanagari']) ?></dd>
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
      <?php foreach ($COMPANY['phones'] as $i => $phone): ?>
        <div class="company-plate__row">
          <dt><?= $i === 0 ? 'Phone' : 'Phone (alternate)' ?></dt>
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
      <a class="btn btn--secondary" href="/for-business/">Partners</a>
      <a class="btn btn--secondary" href="/products/">Explore the Ecosystem</a>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/includes/footer.php';
