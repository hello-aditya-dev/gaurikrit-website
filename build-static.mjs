/**
 * Gaurikrit Bio Products — Static HTML build script for GitHub Pages.
 *
 * Task ID: STATIC-BUILD
 *
 * Reads the PHP source in /home/z/my-project/dist-hostinger/ and produces
 * a static HTML site in /home/z/my-project/docs/ that can be deployed to
 * GitHub Pages (served from a subdirectory, so all paths are relative).
 *
 * Run with: `bun run build-static.mjs`
 */

import { readFileSync, writeFileSync, mkdirSync, copyFileSync, existsSync, readdirSync, rmSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

const __dirname = dirname(fileURLToPath(import.meta.url));
const SRC = join(__dirname, 'dist-hostinger');
const OUT = join(__dirname, 'docs');

// ============================================================
// 1. DATA — exact mirror of dist-hostinger/includes/data.php
// ============================================================

const SITE_URL = 'https://hello-aditya-dev.github.io/gaurikrit-website';

const COMPANY = {
    name: 'Gaurikrit',
    devanagari: 'गौरीकृत',
    legalName: 'Gaurikrit Bio Products (OPC) Private Limited',
    brandLine: 'Good for Nature. Good for Life.',
    mission: 'Transforming waste into wonder, one wall at a time.',
    hindiTagline: 'प्रकृति से, दीवारों तक.',
    headline: 'Walls that Breathe Sustainability',
    email: 'seva@gaurikrit.com',
    phones: ['+91 9999624446', '+91 9837638842'],
    gstin: '09AAMCG8400F1ZK',
    address: [
        'House No. 55',
        'Village Khuriyawali',
        'Post Arniya',
        'Khurja',
        'District Bulandshahr',
        'Uttar Pradesh – 203131',
        'India',
    ],
    siteUrl: SITE_URL,
};

const BRAND_PHRASES = ['100% Natural', 'Chemical Free', 'Eco Friendly', 'Sustainable Living'];

const PRODUCTS = [
    {
        id: 'prakritik-distemper',
        slug: 'prakritik-distemper',
        name: 'Prakritik Distemper Paint',
        descriptor: 'Eco-Friendly Cow Dung Paint',
        packaging: ['1 kg', '5 kg', '10 kg', '20 kg'],
        packagingShort: '1, 5, 10 & 20 kg',
        colour: 'White',
        finish: 'Matt',
        dryingTime: '4 hrs',
        coverage: '200 sq.ft.**',
        voc: 'Negligible',
        usage: 'Interior & Exterior',
        officialImage: '/assets/products/prakritik-distemper.png',
        image: 'prakritik-distemper',
        accent: 'indigo',
        route: '/products/prakritik-distemper/',
    },
    {
        id: 'prakritik-emulsion',
        slug: 'prakritik-emulsion',
        name: 'Prakritik Emulsion Paint',
        descriptor: 'Eco-Friendly Cow Dung Paint',
        packaging: ['1 litre', '4 litre', '10 litre', '20 litre'],
        packagingShort: '1, 4, 10 & 20 litre',
        colour: 'White',
        finish: 'Matt',
        dryingTime: '4 hrs',
        coverage: '300 sq.ft.**',
        voc: 'Negligible',
        usage: 'Interior & Exterior',
        officialImage: '/assets/products/prakritik-emulsion.png',
        image: 'prakritik-emulsion',
        accent: 'haldi',
        route: '/products/prakritik-emulsion/',
    },
];

const COVERAGE_DISCLAIMER =
    'Actual coverage may vary from mentioned coverage due to factors such as method, condition of application surface, roughness and porosity.';

const ASHTA_LAABH = [
    { name: 'Antibacterial', hindi: 'जीवाणुरोधी' },
    { name: 'Antifungal', hindi: 'कवकरोधी' },
    { name: 'Eco-Friendly', hindi: 'पर्यावरण-मित्र' },
    { name: 'Natural Thermal Insulator', hindi: 'प्राकृतिक ऊष्मीय इन्सुलेटर' },
    { name: 'Cost-Effective', hindi: 'किफ़ायती' },
    { name: 'Free from Heavy Metals', hindi: 'भारी धातुओं से मुक्त' },
    { name: 'Non-Toxic', hindi: 'गैर-विषाक्त' },
    { name: 'Odourless', hindi: 'गंधरहित' },
];

const COLOUR_STUDY = [
    { name: 'Haldi', hex: '#E3A51A', label: 'Turmeric' },
    { name: 'Mitti', hex: '#A86E4B', label: 'Earth' },
    { name: 'Neem', hex: '#748468', label: 'Leaf' },
    { name: 'Geru', hex: '#B65432', label: 'Ochre' },
    { name: 'Indigo', hex: '#365B67', label: 'Indigo' },
    { name: 'Chuna', hex: '#F4EFE2', label: 'Lime' },
];

const MATERIAL_JOURNEY = [
    { num: '01', title: 'Natural origin', desc: 'The material begins with the cow.' },
    { num: '02', title: 'Raw material', desc: 'Cow dung, gathered and prepared.' },
    { num: '03', title: 'Preparation', desc: 'Processed into a workable binder.' },
    { num: '04', title: 'Prakritik Paint', desc: 'Blended into a contemporary paint format.' },
    { num: '05', title: 'Finished wall', desc: 'Applied to interior and exterior walls.' },
];

const PROJECT_PATHWAYS = [
    { title: 'Homeowners', desc: 'Explore Prakritik Paint for your space.' },
    { title: 'Architects & Builders', desc: 'Discuss product and project requirements.' },
    { title: 'Institutions / CSR', desc: 'Talk to Gaurikrit about institutional or sustainability-led projects.' },
    { title: 'Gaushalas / Partners', desc: 'Explore collaboration around cow-dung-based bio-products.' },
];

const INTEREST_OPTIONS = {
    general: 'General enquiry',
    'prakritik-distemper': 'Prakritik Distemper',
    'prakritik-emulsion': 'Prakritik Emulsion',
    'bulk-project': 'Bulk / Project',
    'business-partnership': 'Business Partnership',
    'gaushala-collaboration': 'Gaushala Collaboration',
};

const PROJECT_TYPES = [
    'Residential',
    'Commercial',
    'Institutional',
    'CSR / NGO',
    'Gaushala Collaboration',
    'Other',
];

const FAQ = [
    { q: 'What products are available?', a: 'Prakritik Distemper Paint and Prakritik Emulsion Paint.' },
    { q: 'What is the finish?', a: 'Matt.' },
    { q: 'What is the drying time?', a: '4 hrs.' },
    { q: 'Can they be used indoors and outdoors?', a: 'The supplied product specifications list usage as Interior &amp; Exterior.' },
    { q: 'What pack sizes are available for Distemper?', a: '1 kg, 5 kg, 10 kg and 20 kg.' },
    { q: 'What pack sizes are available for Emulsion?', a: '1 litre, 4 litre, 10 litre and 20 litre.' },
    { q: 'What coverage is listed for Distemper?', a: '200 sq.ft.**' },
    { q: 'What coverage is listed for Emulsion?', a: '300 sq.ft.**' },
    { q: 'What is the listed V.O.C. information?', a: 'V.O.C.: Negligible.' },
];

const NAV = [
    { label: 'Home', href: '/' },
    { label: 'Products', href: '/products/' },
    { label: 'Why Prakritik', href: '/why-prakritik/' },
    { label: 'About', href: '/about/' },
    { label: 'For Business', href: '/for-business/' },
    { label: 'Calculator', href: '/paint-calculator/' },
    { label: 'Contact', href: '/contact/' },
];

const NAV_PRODUCTS = [
    { label: 'Prakritik Distemper', href: '/products/prakritik-distemper/' },
    { label: 'Prakritik Emulsion', href: '/products/prakritik-emulsion/' },
    { label: 'View All Products', href: '/products/' },
];

function getProduct(slug) {
    return PRODUCTS.find((p) => p.slug === slug) || null;
}

// ============================================================
// 2. HELPERS
// ============================================================

/** HTML-escape a string for output (mirrors PHP e()). with & -> &amp;, < -> &lt;, etc. */
function e(value) {
    if (value === null || value === undefined) return '';
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

/** sprintf-style %02d. */
function pad2(n) {
    return String(n).padStart(2, '0');
}

/**
 * Load a coded SVG illustration partial. Reads the .php file in
 * includes/illustrations/<name>.php, strips the PHP header (everything
 * up to and including the first `?>`), then replaces
 * `<?= htmlspecialchars($class, ENT_QUOTES) ?>` with the supplied
 * class attribute value (HTML-escaped).
 */
function loadSvg(name, className = '') {
    const file = join(SRC, 'includes/illustrations', `${name}.php`);
    if (!existsSync(file)) return '';
    const raw = readFileSync(file, 'utf8');
    // Strip the PHP header. Each illustration file starts with
    // <?php ... ?> (a doc comment + $class default) then the SVG markup.
    const closeIdx = raw.indexOf('?>');
    if (closeIdx === -1) return raw;
    let svg = raw.slice(closeIdx + 2);
    // Replace the class placeholder. PHP partials emit:
    //   class="<?= htmlspecialchars($class, ENT_QUOTES) ?>"
    svg = svg.replace(/<\?=\s*htmlspecialchars\(\$class,\s*ENT_QUOTES\)\s*\?>/g, e(className));
    return svg.trim();
}

/**
 * Convert an absolute site path (e.g. '/products/') to a relative
 * path from the current page's depth.
 *   depth 0 (docs/index.html)  -> './products/'
 *   depth 1 (docs/about/...)   -> '../products/'
 *   depth 2 (docs/products/prakritik-distemper/...) -> '../../products/'
 */
function relUrl(absolutePath, depth) {
    const stripped = absolutePath.replace(/^\//, '');
    const prefix = depth === 0 ? './' : '../'.repeat(depth);
    return prefix + stripped;
}

/** Asset paths — same logic as relUrl but explicit. */
function assetUrl(absoluteAssetPath, depth) {
    return relUrl(absoluteAssetPath, depth);
}

/** Compose a query-string-bearing URL. */
function relUrlWithQuery(absolutePath, query, depth) {
    return relUrl(absolutePath, depth) + (query ? '?' + query : '');
}

// ============================================================
// 3. HEADER + FOOTER (mirror includes/header.php and footer.php)
// ============================================================

function renderHeader(pageMeta, depth) {
    const title = e(pageMeta.title);
    const desc = e(pageMeta.description);
    const canonical = relUrl(pageMeta.canonical, depth);
    const fullCanonical = SITE_URL.replace(/\/$/, '') + pageMeta.canonical;
    const ogImage = SITE_URL.replace(/\/$/, '') + '/assets/brand/gaurikrit-logo-mark.png';

    // Address lines for JSON-LD
    const addr = COMPANY.address;
    const streetAddress = addr.slice(0, 3).filter(Boolean).join(', ');

    const ld = {
        '@context': 'https://schema.org',
        '@type': 'Organization',
        name: COMPANY.name,
        legalName: COMPANY.legalName,
        alternateName: COMPANY.devanagari,
        url: SITE_URL,
        email: COMPANY.email,
        telephone: COMPANY.phones,
        vatID: COMPANY.gstin,
        address: {
            '@type': 'PostalAddress',
            streetAddress,
            addressLocality: addr[3] || 'Khurja',
            addressRegion: addr[4] || 'Uttar Pradesh',
            postalCode: '203131',
            addressCountry: 'IN',
        },
    };

    const cssHref = assetUrl('/assets/css/app.css', depth) + '?v=static';
    const brandMarkHref = assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth);
    const fallbackMarkHref = assetUrl('/assets/brand/gaurikrit-mark-temp.svg', depth);
    const navLinks = NAV.map(
        (link) =>
            `        <a href="${relUrl(link.href, depth)}" class="site-nav__link" data-nav-link="${e(link.href)}">${e(link.label)}</a>`,
    ).join('\n');

    const mobileLinks = NAV.map(
        (link) =>
            `                <a href="${relUrl(link.href, depth)}" class="mobile-menu__link" data-nav-link="${e(link.href)}">${e(link.label)}<span class="mobile-menu__arrow">→</span></a>`,
    ).join('\n');

    return `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="${brandMarkHref}" type="image/png" onerror="this.onerror=null;this.href='${fallbackMarkHref}'">
    <title>${title}</title>
    <meta name="description" content="${desc}">
    <link rel="canonical" href="${e(fullCanonical)}">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="${title}">
    <meta property="og:description" content="${desc}">
    <meta property="og:url" content="${e(fullCanonical)}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Gaurikrit Bio Products">
    <meta property="og:image" content="${e(ogImage)}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="${title}">
    <meta name="twitter:description" content="${desc}">
    <script type="application/ld+json">
${JSON.stringify(ld, null, 2)}
    </script>

    <!-- Fonts: Manrope (sans), Newsreader (display), Noto Serif Devanagari -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Newsreader:opsz,wght@6..72,400;6..72,600;6..72,700&family=Noto+Serif+Devanagari:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="${cssHref}">
</head>
<body class="page-${e(pageMeta.pageClass)}">
    <a href="#main" class="skip-link">Skip to content</a>

    <!-- ===== Site header ===== -->
    <header class="site-header" id="site-header" data-scrolled="false">
        <div class="container site-header__inner">
            <a href="${relUrl('/', depth)}" class="brand" aria-label="Gaurikrit home">
                <span class="brand__mark" data-official-image="${brandMarkHref}">
                    <img class="brand__official" src="${brandMarkHref}" alt="Gaurikrit" width="36" height="36">
                    <span class="brand__fallback">${loadSvg('gaurikrit-cow-mark', 'brand__mark-svg')}</span>
                </span>
                <span class="brand__text">
                    <span class="brand__name">Gaurikrit</span>
                    <span class="brand__sub">Bio Products</span>
                </span>
            </a>

            <nav class="site-nav" aria-label="Primary" data-spy>
${navLinks}
            </nav>

            <div class="site-header__actions">
                <a href="${relUrl('/contact/', depth)}" class="btn btn--primary btn--sm site-header__cta">Talk to Us</a>
                <button class="menu-toggle" aria-label="Open menu" data-menu-toggle aria-expanded="false">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile menu sheet -->
    <div class="mobile-menu" data-mobile-menu hidden>
        <div class="mobile-menu__panel">
            <div class="mobile-menu__head">
                <span class="mobile-menu__title">Menu</span>
                <button class="mobile-menu__close" aria-label="Close menu" data-menu-close>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="mobile-menu__nav" aria-label="Mobile">
${mobileLinks}
            </nav>
            <div class="mobile-menu__foot">
                <a href="${relUrl('/contact/', depth)}" class="btn btn--primary btn--block">Talk to Us</a>
            </div>
        </div>
    </div>

    <main id="main" class="site-main">
`;
}

function renderFooter(depth) {
    const phones = COMPANY.phones;
    const phoneLinks = phones
        .map(
            (phone) =>
                `                <p class="site-footer__contact-line"><a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a></p>`,
        )
        .join('\n');
    const navLinks = NAV.map(
        (link) => `                <a href="${relUrl(link.href, depth)}">${e(link.label)}</a>`,
    ).join('\n');

    const year = new Date().getFullYear();
    const cowMarkSvg = loadSvg('gaurikrit-cow-mark', 'brand__mark-svg');
    const brandMarkHref = assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth);

    const jsBase = assetUrl('/assets/js/', depth);

    return `    </main>

    <!-- ===== Site footer ===== -->
    <footer class="site-footer" id="footer">
        <div class="container site-footer__main">
            <div class="site-footer__brand">
                <a href="${relUrl('/', depth)}" class="brand brand--footer">
                    <span class="brand__mark" data-official-image="${brandMarkHref}">
                        <img class="brand__official" src="${brandMarkHref}" alt="Gaurikrit" width="36" height="36">
                        <span class="brand__fallback">${cowMarkSvg}</span>
                    </span>
                    <span class="brand__name">Gaurikrit</span>
                </a>
                <p class="site-footer__brandline">${e(COMPANY.brandLine)}</p>
                <p class="site-footer__legal-name">${e(COMPANY.legalName)}</p>
            </div>
            <nav class="site-footer__col" aria-label="Navigate">
                <h4 class="site-footer__heading">Navigate</h4>
${navLinks}
            </nav>
            <nav class="site-footer__col" aria-label="Products">
                <h4 class="site-footer__heading">Products</h4>
                <a href="${relUrl('/products/prakritik-distemper/', depth)}">Prakritik Distemper</a>
                <a href="${relUrl('/products/prakritik-emulsion/', depth)}">Prakritik Emulsion</a>
                <a href="${relUrl('/downloads/', depth)}">Brochure</a>
                <a href="${relUrl('/for-business/', depth)}">For Business</a>
            </nav>
            <div class="site-footer__col">
                <h4 class="site-footer__heading">Contact</h4>
                <p class="site-footer__contact-line">
                    <a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a>
                </p>
${phoneLinks}
            </div>
        </div>

        <div class="site-footer__bottom">
            <div class="container site-footer__bottom-inner">
                <p>© ${year} ${e(COMPANY.legalName)}. GSTIN: ${e(COMPANY.gstin)}.</p>
            </div>
        </div>
    </footer>

    <!-- Back-to-top -->
    <button class="back-to-top" data-back-to-top aria-label="Back to top" hidden>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
    </button>

    <!-- Toast region -->
    <div class="toast-region" data-toast-region aria-live="polite" aria-atomic="true"></div>

    <!--
      Module scripts. Order matters: each module registers
      window.GaurikritApp.<Name> = { init: fn, ... } and app.js
      (loaded last) calls .init() on each. calculator.js is included
      after forms.js so it can reuse the toast helper if needed, and
      before app.js so app.js can include 'Calculator' in its boot
      sequence.
    -->
    <script src="${jsBase}navigation.js?v=static"></script>
    <script src="${jsBase}animations.js?v=static"></script>
    <script src="${jsBase}ashta-laabh.js?v=static"></script>
    <script src="${jsBase}colour-study.js?v=static"></script>
    <script src="${jsBase}forms.js?v=static"></script>
    <script src="${jsBase}calculator.js?v=static"></script>
    <script src="${jsBase}app.js?v=static"></script>
</body>
</html>
`;
}

/** Wrap a page body (the inline <style> + section HTML) in a full HTML document. */
function generatePage(pageMeta, depth, bodyContent) {
    return renderHeader(pageMeta, depth) + bodyContent + renderFooter(depth);
}

// ============================================================
// 4. PAGE BODIES — one function per route.
//    Each function returns the inline <style> + section HTML as a
//    single string (everything between the header include and the
//    footer include in the PHP source).
// ============================================================

// ---- Homepage (index.html) ----
function homeBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const groupImage = '/assets/products/prakritik-group.png';

    // Build the two product panels inline.
    const panels = [
        { product: distemper, modifier: 'mat-panel--distemper', cta: 'Explore Distemper' },
        { product: emulsion, modifier: 'mat-panel--emulsion', cta: 'Explore Emulsion' },
    ];
    const panelHtml = panels
        .map((panel) => {
            const p = panel.product;
            if (!p) return '';
            const img = assetUrl(p.officialImage, depth);
            return `            <article class="mat-panel ${e(panel.modifier)}">
                <div class="mat-panel__media">
                    <div class="product-media" data-official-image="${img}">
                        <img class="product-media__official" src="${img}" alt="${e(p.name)}" width="640" height="480">
                        <div class="product-media__fallback">${loadSvg(p.image + '-bucket')}</div>
                    </div>
                </div>
                <div class="mat-panel__body">
                    <span class="mat-panel__eyebrow">${e(p.descriptor)}</span>
                    <h3 class="mat-panel__name">${e(p.name)}</h3>
                    <p class="mat-panel__desc">Cow dung-based Prakritik paint for interior and exterior walls.</p>
                    <dl class="mat-panel__specs">
                        <div class="mat-panel__spec"><dt>Packaging</dt><dd>${e(p.packagingShort)}</dd></div>
                        <div class="mat-panel__spec"><dt>Finish</dt><dd>${e(p.finish)}</dd></div>
                        <div class="mat-panel__spec"><dt>Usage</dt><dd>${e(p.usage)}</dd></div>
                    </dl>
                    <div class="mat-panel__cta">
                        <a href="${relUrl(p.route, depth)}">${e(panel.cta)}
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>`;
        })
        .join('\n');

    // Journey steps
    const journeySteps = MATERIAL_JOURNEY.map(
        (stage) => `                <li class="journey-step">
                    <div class="journey-step__num">${e(stage.num)}</div>
                    <div class="journey-step__title">${e(stage.title)}</div>
                    <div class="journey-step__desc">${e(stage.desc)}</div>
                </li>`,
    ).join('\n');

    // Ashta Laabh list items
    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = 'al-' + (i + 1);
        return `                <li class="ashta-benefit" data-ashta-node="${e(bid)}">
                    <span class="ashta-benefit__num">${pad2(i + 1)}</span>
                    <span class="ashta-benefit__name">${e(benefit.name)}</span>
                    <span class="ashta-benefit__deva" lang="hi">${e(benefit.hindi)}</span>
                </li>`;
    }).join('\n');

    // Colour swatches
    const swatches = COLOUR_STUDY.map(
        (swatch) => `                <button type="button" class="colours-swatch" role="radio" aria-checked="false"
                        data-shade="${e(swatch.hex)}"
                        data-shade-name="${e(swatch.name)} — ${e(swatch.label)}"
                        aria-label="${e(swatch.name)} — ${e(swatch.label)}"
                        style="background:${e(swatch.hex)};">
                    <span class="colours-swatch__label">${e(swatch.name)}</span>
                </button>`,
    ).join('\n');

    // Project pathways
    const pathways = PROJECT_PATHWAYS.map(
        (path, i) => `            <li class="pathway-col">
                <div class="pathway-col__num">${pad2(i + 1)}</div>
                <h3 class="pathway-col__title">${e(path.title)}</h3>
                <p class="pathway-col__desc">${e(path.desc)}</p>
            </li>`,
    ).join('\n');

    // Hero art assets
    const groupImgUrl = assetUrl(groupImage, depth);

    return `<style>
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
            <span class="hero__devanagari" aria-label="Gaurikrit in Devanagari">${e(COMPANY.devanagari)}</span>
            <span class="hero__brand-sub">Gaurikrit Bio Products</span>
            <h1 class="hero__title">${e(COMPANY.headline)}</h1>
            <p class="hero__sub">Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls.</p>
            <div class="hero__ctas">
                <a href="${relUrl('/products/', depth)}" class="btn btn--primary btn--lg">
                    Explore Prakritik Paint
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="${relUrl('/why-prakritik/', depth)}" class="btn btn--outline btn--lg">Why Prakritik?</a>
            </div>
        </div>
        <div class="hero__art" aria-hidden="true">
            <div class="hero__stroke">${loadSvg('paint-brush-stroke', 'hero__stroke-inner')}</div>
            <div class="hero__group product-media" data-official-image="${groupImgUrl}">
                <img class="product-media__official" src="${groupImgUrl}" alt="Prakritik Paint group" width="640" height="480">
                <div class="product-media__fallback">${loadSvg('prakritik-emulsion-bucket')}</div>
            </div>
            <div class="hero__cow">${loadSvg('indian-cow')}</div>
        </div>
    </div>
    <div class="container">
        <div class="hero__landscape" aria-hidden="true">${loadSvg('rural-landscape')}</div>
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
                <div class="ms-cow">${loadSvg('indian-cow')}</div>
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
${panelHtml}
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
            <div class="material-journey__svg" aria-hidden="true">${loadSvg('material-journey')}</div>
            <ol class="journey-steps" data-reveal-stagger>
${journeySteps}
            </ol>
        </div>
    </div>
</section>

<!-- ===== 5. ASHTA LAABH ===== -->
<section class="ashta-section" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="ashta-section__head">
            <div class="ashta-section__deva" lang="hi">अष्ट लाभ</div>
            <p class="ashta-section__sub">Eight benefits presented in Prakritik Paint.</p>
            <p class="ashta-section__note">A reading of the material, not a verified claim.</p>
        </div>
        <div class="ashta-grid" data-ashta-laabh>
            <div class="ashta-grid__diagram" aria-hidden="true">${loadSvg('ashta-laabh-diagram')}</div>
            <ol class="ashta-grid__list" data-reveal-stagger>
${ashtaItems}
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
                <div class="colours-wall__art" aria-hidden="true">${loadSvg('indian-courtyard')}</div>
                <span class="colours-wall__label" data-colour-label>Chuna — Lime</span>
            </div>
            <div class="colours-swatches" role="radiogroup" aria-label="Colour study swatches">
${swatches}
            </div>
        </div>
    </div>
</section>

<!-- ===== 7. MISSION ===== -->
<section class="mission" id="mission" data-reveal>
    <div class="mission__botanical" aria-hidden="true">${loadSvg('field-botanicals')}</div>
    <div class="container">
        <div class="mission__inner">
            <div>
                <span class="mission__eyebrow">Mission</span>
                <div class="mission__deva">प्रकृति से, दीवारों तक</div>
            </div>
            <div>
                <h2 class="mission__title">${e(COMPANY.mission)}</h2>
                <p class="mission__body">Gaurikrit Bio Products works with a familiar Indian material — cow dung — and brings it into a contemporary paint format. The work sits at the intersection of agricultural reuse, rural opportunity, and eco-friendly wall coatings.</p>
                <div class="mission__cta">
                    <a href="${relUrl('/about/', depth)}" class="btn btn--haldi btn--lg">About Gaurikrit</a>
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
                    <a href="${relUrl('/paint-calculator/', depth)}" class="btn btn--primary btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="calc-teaser__art" aria-hidden="true">
                ${loadSvg('paint-brush-stroke')}
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
${pathways}
        </ol>
        <div class="pathways-foot">
            <a href="${relUrl('/for-business/', depth)}" class="btn btn--outline btn--lg">Talk to Gaurikrit
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

<!-- ===== 10. BRAND CLOSE ===== -->
<section class="brand-close" id="brand-close" data-reveal>
    <div class="container">
        <div class="brand-close__deva" lang="hi">${e(COMPANY.devanagari)}</div>
        <p class="brand-close__phrase">${e(COMPANY.brandLine)}</p>
        <div class="brand-close__stroke" aria-hidden="true">${loadSvg('paint-brush-stroke')}</div>
    </div>
</section>
`;
}

// ---- Products Overview (products/index.html) ----
function productsBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const ashtaItems = ASHTA_LAABH.map(
        (benefit, i) => `            <li class="ashta-compact__item">
                <span class="ashta-compact__num">${pad2(i + 1)}</span>
                <span class="ashta-compact__name">${e(benefit.name)}</span>
                <span class="ashta-compact__deva-item" lang="hi">${e(benefit.hindi)}</span>
            </li>`,
    ).join('\n');

    const distemperImg = assetUrl(distemper.officialImage, depth);
    const emulsionImg = assetUrl(emulsion.officialImage, depth);

    return `<style>
  /* HERO */
  .products-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: 2rem; }
  .products-hero__inner { max-width: 56rem; }
  .products-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .products-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .products-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .products-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .products-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* CATALOGUE — large presentation blocks (not cards) */
  .catalogue { padding-block: clamp(3rem, 6vw, 5rem); }
  .catalogue-block { display: grid; gap: 2rem; align-items: center; padding-block: clamp(2rem, 4vw, 3.5rem); border-bottom: 1px solid var(--border); }
  .catalogue-block:last-of-type { border-bottom: 0; }
  @media (min-width: 1024px) { .catalogue-block { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .catalogue-block--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) { .catalogue-block--reverse > :first-child { order: 0; } }
  .catalogue-media { position: relative; aspect-ratio: 1; background: var(--secondary-bg); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); }
  .catalogue-media .product-media { width: 100%; height: 100%; }
  .catalogue-media .product-media__official { object-fit: contain; padding: 2.5rem; }
  .catalogue-media .product-media__fallback { padding: 2rem; }
  .catalogue-media__chip { position: absolute; top: 1rem; left: 1rem; padding: 0.3125rem 0.75rem; border-radius: var(--radius-full); font-size: 0.625rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; background: var(--bg-card); color: var(--primary); border: 1px solid var(--border); z-index: 3; }
  .catalogue-text__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .catalogue-text__name { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.1; margin-top: 0.75rem; letter-spacing: -0.02em; }
  .catalogue-text__desc { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .catalogue-text__spec-row { display: flex; flex-wrap: wrap; gap: 0.375rem; margin-top: 1.25rem; }
  .catalogue-text__spec { padding: 0.3125rem 0.75rem; border-radius: var(--radius-full); background: var(--secondary-bg); font-size: 0.75rem; font-weight: 500; border: 1px solid var(--border); }
  .catalogue-text__cta { margin-top: 1.5rem; }
  .catalogue-block--distemper .catalogue-media { border-top: 4px solid var(--indigo); }
  .catalogue-block--emulsion .catalogue-media { border-top: 4px solid var(--haldi-deep); }

  /* SPEC COMPARISON TABLE */
  .spec-table-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .spec-table-section__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .spec-table-section__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .spec-table { width: 100%; border-collapse: collapse; background: var(--bg-card); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); border: 1px solid var(--border); }
  .spec-table thead th { background: var(--forest); color: var(--primary-fg); padding: 1rem 1.25rem; text-align: left; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; }
  .spec-table thead th:first-child { width: 9rem; }
  .spec-table tbody td { padding: 0.875rem 1.25rem; border-top: 1px solid var(--border); font-size: 0.9375rem; vertical-align: top; }
  .spec-table tbody th { padding: 0.875rem 1.25rem; border-top: 1px solid var(--border); font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--fg-muted); text-align: left; }
  @media (max-width: 640px) {
    .spec-table thead { display: none; }
    .spec-table, .spec-table tbody, .spec-table tr, .spec-table td, .spec-table th { display: block; width: 100%; }
    .spec-table tr { border-bottom: 1px solid var(--border); padding: 0.5rem 0; }
    .spec-table tbody td, .spec-table tbody th { border: 0; padding: 0.375rem 1rem; }
    .spec-table tbody th { background: var(--secondary-bg); }
    .spec-table tbody td[data-col]::before { content: attr(data-col) ' — '; font-weight: 700; color: var(--fg-muted); text-transform: uppercase; font-size: 0.6875rem; letter-spacing: 0.1em; }
  }
  .disclaimer-note { margin-top: 1.5rem; padding: 1rem 1.25rem; background: var(--bg-card); border-left: 3px solid var(--haldi); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; }

  /* ASHTA LAABH compact */
  .ashta-compact { padding-block: clamp(3rem, 6vw, 5rem); }
  .ashta-compact__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .ashta-compact__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 3vw, 2rem); color: var(--haldi-deep); }
  .ashta-compact__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .ashta-compact__grid { display: grid; gap: 0.75rem; }
  @media (min-width: 640px) { .ashta-compact__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .ashta-compact__grid { grid-template-columns: repeat(4, 1fr); } }
  .ashta-compact__item { padding: 1rem 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.25rem; }
  .ashta-compact__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .ashta-compact__name { font-weight: 600; font-size: 0.9375rem; }
  .ashta-compact__deva-item { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA STRIP */
  .help-cta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--forest); color: var(--primary-fg); text-align: center; }
  .help-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .help-cta__sub { margin-top: 0.5rem; color: oklch(0.85 0.01 75); }
  .help-cta__btn { margin-top: 1.5rem; }
</style>

<!-- ===== HERO ===== -->
<section class="products-hero" id="products-hero" data-reveal>
    <div class="container products-hero__inner">
        <span class="products-hero__eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>Prakritik Paint</span>
        <h1 class="products-hero__title">Cow dung-based paint in Distemper and Emulsion formats.</h1>
        <p class="products-hero__sub">Two Prakritik Paint formats — both matt, both suitable for interior and exterior walls, both carrying the same material lineage.</p>
        <hr class="products-hero__rule">
    </div>
</section>

<!-- ===== CATALOGUE ===== -->
<section class="catalogue" id="catalogue" data-reveal>
    <div class="container">

        <!-- Distemper -->
        <article class="catalogue-block catalogue-block--distemper" id="prakritik-distemper">
            <div class="catalogue-media">
                <span class="catalogue-media__chip">01 · Distemper</span>
                <div class="product-media" data-official-image="${distemperImg}">
                    <img class="product-media__official" src="${distemperImg}" alt="${e(distemper.name)}" width="640" height="640">
                    <div class="product-media__fallback">${loadSvg('prakritik-distemper-bucket')}</div>
                </div>
            </div>
            <div class="catalogue-text">
                <span class="catalogue-text__eyebrow">${e(distemper.descriptor)}</span>
                <h2 class="catalogue-text__name">${e(distemper.name)}</h2>
                <p class="catalogue-text__desc">A powdered cow dung-based paint format. Packaged in kilograms, suitable for interior and exterior walls, with a matt finish.</p>
                <div class="catalogue-text__spec-row">
                    <span class="catalogue-text__spec">${e(distemper.packagingShort)}</span>
                    <span class="catalogue-text__spec">Finish: ${e(distemper.finish)}</span>
                    <span class="catalogue-text__spec">${e(distemper.usage)}</span>
                    <span class="catalogue-text__spec">Coverage: ${e(distemper.coverage)}</span>
                </div>
                <div class="catalogue-text__cta">
                    <a href="${relUrl(distemper.route, depth)}" class="btn btn--primary btn--lg">Explore Distemper
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Emulsion (reversed) -->
        <article class="catalogue-block catalogue-block--emulsion catalogue-block--reverse" id="prakritik-emulsion">
            <div class="catalogue-media">
                <span class="catalogue-media__chip">02 · Emulsion</span>
                <div class="product-media" data-official-image="${emulsionImg}">
                    <img class="product-media__official" src="${emulsionImg}" alt="${e(emulsion.name)}" width="640" height="640">
                    <div class="product-media__fallback">${loadSvg('prakritik-emulsion-bucket')}</div>
                </div>
            </div>
            <div class="catalogue-text">
                <span class="catalogue-text__eyebrow">${e(emulsion.descriptor)}</span>
                <h2 class="catalogue-text__name">${e(emulsion.name)}</h2>
                <p class="catalogue-text__desc">A liquid cow dung-based paint format. Packaged in litres, suitable for interior and exterior walls, with a matt finish.</p>
                <div class="catalogue-text__spec-row">
                    <span class="catalogue-text__spec">${e(emulsion.packagingShort)}</span>
                    <span class="catalogue-text__spec">Finish: ${e(emulsion.finish)}</span>
                    <span class="catalogue-text__spec">${e(emulsion.usage)}</span>
                    <span class="catalogue-text__spec">Coverage: ${e(emulsion.coverage)}</span>
                </div>
                <div class="catalogue-text__cta">
                    <a href="${relUrl(emulsion.route, depth)}" class="btn btn--primary btn--lg">Explore Emulsion
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </article>
    </div>
</section>

<!-- ===== SPEC COMPARISON TABLE ===== -->
<section class="spec-table-section" id="spec-comparison" data-reveal>
    <div class="container">
        <div class="spec-table-section__head">
            <span class="section-heading__eyebrow">Specifications side by side</span>
            <h2 class="spec-table-section__title">Compare the two formats.</h2>
        </div>
        <div style="overflow-x:auto;">
            <table class="spec-table">
                <thead>
                    <tr>
                        <th scope="col">Specification</th>
                        <th scope="col">${e(distemper.name)}</th>
                        <th scope="col">${e(emulsion.name)}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Packaging</th>
                        <td data-col="Distemper">${e(distemper.packagingShort)}</td>
                        <td data-col="Emulsion">${e(emulsion.packagingShort)}</td>
                    </tr>
                    <tr>
                        <th scope="row">Colour</th>
                        <td data-col="Distemper">${e(distemper.colour)}</td>
                        <td data-col="Emulsion">${e(emulsion.colour)}</td>
                    </tr>
                    <tr>
                        <th scope="row">Finish</th>
                        <td data-col="Distemper">${e(distemper.finish)}</td>
                        <td data-col="Emulsion">${e(emulsion.finish)}</td>
                    </tr>
                    <tr>
                        <th scope="row">Drying time</th>
                        <td data-col="Distemper">${e(distemper.dryingTime)}</td>
                        <td data-col="Emulsion">${e(emulsion.dryingTime)}</td>
                    </tr>
                    <tr>
                        <th scope="row">Coverage</th>
                        <td data-col="Distemper">${e(distemper.coverage)}</td>
                        <td data-col="Emulsion">${e(emulsion.coverage)}</td>
                    </tr>
                    <tr>
                        <th scope="row">V.O.C.</th>
                        <td data-col="Distemper">${e(distemper.voc)}</td>
                        <td data-col="Emulsion">${e(emulsion.voc)}</td>
                    </tr>
                    <tr>
                        <th scope="row">Usage</th>
                        <td data-col="Distemper">${e(distemper.usage)}</td>
                        <td data-col="Emulsion">${e(emulsion.usage)}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="disclaimer-note"><strong>Coverage note —</strong> ${e(COVERAGE_DISCLAIMER)}</p>
    </div>
</section>

<!-- ===== ASHTA LAABH (compact) ===== -->
<section class="ashta-compact" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="ashta-compact__head">
            <div class="ashta-compact__deva" lang="hi">अष्ट लाभ</div>
            <h2 class="ashta-compact__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <ol class="ashta-compact__grid" data-reveal-stagger>
${ashtaItems}
        </ol>
    </div>
</section>

<!-- ===== HELP CTA ===== -->
<section class="help-cta" id="help-cta" data-reveal>
    <div class="container">
        <h2 class="help-cta__title">Need help choosing?</h2>
        <p class="help-cta__sub">Talk to Gaurikrit about your project and we'll help you compare formats.</p>
        <div class="help-cta__btn">
            <a href="${relUrl('/contact/', depth)}" class="btn btn--haldi btn--lg">Talk to Gaurikrit</a>
        </div>
    </div>
</section>
`;
}

// ---- Prakritik Distemper detail ----
function distemperBody(depth) {
    const product = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const productImg = assetUrl(product.officialImage, depth);

    const ashtaItems = ASHTA_LAABH.map(
        (benefit, i) => `            <li class="distemper-ashta__item">
                <span class="distemper-ashta__num">${pad2(i + 1)}</span>
                <span class="distemper-ashta__name">${e(benefit.name)}</span>
                <span class="distemper-ashta__deva" lang="hi">${e(benefit.hindi)}</span>
            </li>`,
    ).join('\n');

    return `<style>
  .distemper-detail { padding-top: calc(var(--header-h) + 2rem); }
  .breadcrumb { font-size: 0.8125rem; color: var(--fg-muted); margin-bottom: 1.5rem; padding-top: 0.5rem; }
  .breadcrumb a { color: var(--primary); }
  .breadcrumb a:hover { text-decoration: underline; }
  .breadcrumb span { color: var(--fg-muted); margin: 0 0.375rem; }

  .distemper-hero { display: grid; gap: 2rem; align-items: center; padding-bottom: clamp(2rem, 4vw, 3rem); border-bottom: 1px solid var(--border); }
  @media (min-width: 1024px) { .distemper-hero { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .distemper-hero__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .distemper-hero__name { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; margin-top: 0.75rem; }
  .distemper-hero__descriptor { margin-top: 0.5rem; font-size: clamp(1rem, 2vw, 1.25rem); color: var(--indigo); font-weight: 600; }
  .distemper-hero__body { margin-top: 1rem; color: var(--fg-muted); line-height: 1.65; max-width: 36rem; }
  .distemper-hero__chips { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
  .distemper-hero__chip { padding: 0.3125rem 0.875rem; border-radius: var(--radius-full); background: var(--bg-card); border: 1px solid var(--border); font-size: 0.75rem; font-weight: 600; color: var(--indigo); }
  .distemper-hero__cta-row { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  .distemper-media { position: relative; aspect-ratio: 1; background: linear-gradient(160deg, var(--bg-card), var(--secondary-bg)); border: 1px solid var(--border); border-top: 4px solid var(--indigo); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); }
  .distemper-media .product-media { width: 100%; height: 100%; }
  .distemper-media .product-media__official { object-fit: contain; padding: 3rem; }
  .distemper-media .product-media__fallback { padding: 2.5rem; }
  .distemper-media__num { position: absolute; top: 1rem; right: 1.25rem; font-family: var(--font-display); font-size: 4rem; font-weight: 700; color: var(--indigo); opacity: 0.18; line-height: 1; }

  /* SPEC SHEET */
  .spec-sheet { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 2.5rem; }
  .spec-sheet__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--indigo); }
  .spec-sheet__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .spec-sheet__list { display: grid; gap: 0; border-top: 1px solid var(--border); }
  @media (min-width: 640px) { .spec-sheet__list { grid-template-columns: repeat(2, 1fr); } }
  .spec-sheet__row { padding: 1.25rem 0; border-bottom: 1px solid var(--border); display: grid; grid-template-columns: 2.5rem 1fr; gap: 1rem; align-items: start; }
  @media (min-width: 640px) { .spec-sheet__row { padding: 1.25rem 1.5rem; } .spec-sheet__row:nth-child(odd) { border-right: 1px solid var(--border); } }
  .spec-sheet__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); }
  .spec-sheet__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .spec-sheet__value { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; margin-top: 0.25rem; color: var(--fg); }
  .spec-sheet__value small { font-family: var(--font-sans); font-size: 0.75rem; font-weight: 500; color: var(--fg-muted); display: block; margin-top: 0.25rem; }

  .disclaimer-card { padding: 1.25rem 1.5rem; background: var(--bg-card); border-left: 3px solid var(--indigo); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; margin-top: 2rem; }

  /* ASHTA LAABH */
  .distemper-ashta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .distemper-ashta__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .distemper-ashta__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.75rem, 4vw, 2.5rem); color: var(--indigo); }
  .distemper-ashta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .distemper-ashta__grid { display: grid; gap: 0.75rem; }
  @media (min-width: 640px) { .distemper-ashta__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .distemper-ashta__grid { grid-template-columns: repeat(4, 1fr); } }
  .distemper-ashta__item { padding: 1rem 1.25rem; background: var(--bg-card); border-left: 2px solid var(--indigo); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.25rem; }
  .distemper-ashta__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .distemper-ashta__name { font-weight: 600; font-size: 0.9375rem; }
  .distemper-ashta__deva { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA + CROSS-LINK */
  .distemper-cta { padding-block: clamp(3rem, 6vw, 5rem); }
  .distemper-cta__inner { display: grid; gap: 1.5rem; padding: clamp(1.75rem, 4vw, 3rem); background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  @media (min-width: 768px) { .distemper-cta__inner { grid-template-columns: 1.4fr 1fr; gap: 2.5rem; align-items: center; } }
  .distemper-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); letter-spacing: -0.02em; }
  .distemper-cta__body { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .distemper-cta__actions { display: flex; flex-direction: column; gap: 0.75rem; }
  .distemper-cta__cross { padding: 1.25rem; border: 1px dashed var(--border); border-radius: var(--radius); }
  .distemper-cta__cross-title { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .distemper-cta__cross-name { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.375rem; }
  .distemper-cta__cross-link { margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.8125rem; font-weight: 600; color: var(--primary); }
  .distemper-cta__cross-link:hover { gap: 0.5rem; }
</style>

<section class="distemper-detail" id="distemper-detail">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="${relUrl('/', depth)}">Home</a><span>›</span>
            <a href="${relUrl('/products/', depth)}">Products</a><span>›</span>
            Prakritik Distemper
        </nav>

        <!-- HERO -->
        <div class="distemper-hero" data-reveal>
            <div class="distemper-hero__lockup">
                <span class="distemper-hero__eyebrow">Prakritik Paint</span>
                <h1 class="distemper-hero__name">${e(product.name)}</h1>
                <div class="distemper-hero__descriptor">${e(product.descriptor)}</div>
                <p class="distemper-hero__body">A powdered cow dung-based paint format. White, matt, and suitable for interior and exterior walls — a quieter material sheet in the Prakritik range.</p>
                <div class="distemper-hero__chips">
                    <span class="distemper-hero__chip">${e(product.packagingShort)}</span>
                    <span class="distemper-hero__chip">${e(product.finish)} finish</span>
                    <span class="distemper-hero__chip">${e(product.usage)}</span>
                </div>
                <div class="distemper-hero__cta-row">
                    <a href="${relUrl('/contact/', depth)}?interest=prakritik-distemper" class="btn btn--primary btn--lg">Enquire About Distemper</a>
                    <a href="${relUrl('/paint-calculator/', depth)}" class="btn btn--outline btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="distemper-media">
                <span class="distemper-media__num" aria-hidden="true">01</span>
                <div class="product-media" data-official-image="${productImg}">
                    <img class="product-media__official" src="${productImg}" alt="${e(product.name)}" width="640" height="640">
                    <div class="product-media__fallback">${loadSvg('prakritik-distemper-bucket')}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SPEC SHEET (numbered 01-07) -->
<section class="spec-sheet section--paper" id="spec-sheet" data-reveal>
    <div class="container">
        <div class="spec-sheet__head">
            <span class="spec-sheet__eyebrow">Specification sheet</span>
            <h2 class="spec-sheet__title">Material specifications.</h2>
        </div>
        <ol class="spec-sheet__list" data-reveal-stagger>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">01</span>
                <div>
                    <div class="spec-sheet__label">Packaging</div>
                    <div class="spec-sheet__value">${e(product.packagingShort)}</div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">02</span>
                <div>
                    <div class="spec-sheet__label">Colour</div>
                    <div class="spec-sheet__value">${e(product.colour)}</div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">03</span>
                <div>
                    <div class="spec-sheet__label">Finish</div>
                    <div class="spec-sheet__value">${e(product.finish)}</div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">04</span>
                <div>
                    <div class="spec-sheet__label">Drying time</div>
                    <div class="spec-sheet__value">${e(product.dryingTime)}</div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">05</span>
                <div>
                    <div class="spec-sheet__label">Coverage</div>
                    <div class="spec-sheet__value">${e(product.coverage)}
                        <small>${e(COVERAGE_DISCLAIMER)}</small>
                    </div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">06</span>
                <div>
                    <div class="spec-sheet__label">V.O.C.</div>
                    <div class="spec-sheet__value">${e(product.voc)}</div>
                </div>
            </li>
            <li class="spec-sheet__row">
                <span class="spec-sheet__num">07</span>
                <div>
                    <div class="spec-sheet__label">Usage</div>
                    <div class="spec-sheet__value">${e(product.usage)}</div>
                </div>
            </li>
        </ol>
        <div class="disclaimer-card">
            <strong>Coverage note —</strong> ${e(COVERAGE_DISCLAIMER)}
        </div>
    </div>
</section>

<!-- ASHTA LAABH -->
<section class="distemper-ashta" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="distemper-ashta__head">
            <div class="distemper-ashta__deva" lang="hi">अष्ट लाभ</div>
            <h2 class="distemper-ashta__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <ol class="distemper-ashta__grid" data-reveal-stagger>
${ashtaItems}
        </ol>
    </div>
</section>

<!-- CTA + CROSS-LINK -->
<section class="distemper-cta section--paper" id="enquire" data-reveal>
    <div class="container">
        <div class="distemper-cta__inner">
            <div>
                <h2 class="distemper-cta__title">Want to know more about Prakritik Distemper?</h2>
                <p class="distemper-cta__body">Send an enquiry about packaging, project sizes, or collaboration. We'll respond with what's currently available.</p>
                <div class="distemper-cta__actions">
                    <a href="${relUrl('/contact/', depth)}?interest=prakritik-distemper" class="btn btn--primary btn--lg btn--block">Enquire About Distemper</a>
                    <a href="${relUrl('/for-business/', depth)}" class="btn btn--outline btn--lg btn--block">Discuss a Project</a>
                </div>
            </div>
            <div class="distemper-cta__cross">
                <span class="distemper-cta__cross-title">Also in the Prakritik range</span>
                <h3 class="distemper-cta__cross-name">${e(emulsion.name)}</h3>
                <a href="${relUrl(emulsion.route, depth)}" class="distemper-cta__cross-link">Explore Emulsion
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
`;
}

// ---- Prakritik Emulsion detail ----
function emulsionBody(depth) {
    const product = getProduct('prakritik-emulsion');
    const distemper = getProduct('prakritik-distemper');
    const productImg = assetUrl(product.officialImage, depth);

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = 'em-al-' + (i + 1);
        return `                <li class="emulsion-ashta__item" data-ashta-node="${e(bid)}">
                    <span class="emulsion-ashta__num">${pad2(i + 1)}</span>
                    <span class="emulsion-ashta__name">${e(benefit.name)}</span>
                    <span class="emulsion-ashta__deva" lang="hi">${e(benefit.hindi)}</span>
                </li>`;
    }).join('\n');

    return `<style>
  .emulsion-detail { padding-top: calc(var(--header-h) + 2rem); background: linear-gradient(180deg, var(--bg) 0%, var(--haldi-light) 100%); }
  .breadcrumb { font-size: 0.8125rem; color: var(--fg-muted); margin-bottom: 1.5rem; padding-top: 0.5rem; }
  .breadcrumb a { color: var(--primary); }
  .breadcrumb a:hover { text-decoration: underline; }
  .breadcrumb span { color: var(--fg-muted); margin: 0 0.375rem; }

  /* HERO — REVERSED: image RIGHT, text LEFT (opposite of Distemper) */
  .emulsion-hero { display: grid; gap: 2rem; align-items: center; padding-bottom: clamp(2rem, 4vw, 3rem); border-bottom: 1px solid var(--haldi-deep); }
  @media (min-width: 1024px) { .emulsion-hero { grid-template-columns: 1fr 1fr; gap: 4rem; } }
  .emulsion-hero__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi-deep); }
  .emulsion-hero__name { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); line-height: 1.05; letter-spacing: -0.02em; margin-top: 0.75rem; }
  .emulsion-hero__descriptor { margin-top: 0.5rem; font-size: clamp(1rem, 2vw, 1.25rem); color: var(--geru); font-weight: 600; }
  .emulsion-hero__body { margin-top: 1rem; color: var(--fg-muted); line-height: 1.65; max-width: 36rem; }
  .emulsion-hero__chips { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.5rem; }
  .emulsion-hero__chip { padding: 0.3125rem 0.875rem; border-radius: var(--radius-full); background: var(--bg-card); border: 1px solid var(--haldi-deep); font-size: 0.75rem; font-weight: 600; color: var(--haldi-deep); }
  .emulsion-hero__cta-row { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* MEDIA on the RIGHT — reverse grid order */
  .emulsion-hero > :first-child { order: 2; }
  @media (min-width: 1024px) { .emulsion-hero > :first-child { order: 0; } }
  .emulsion-hero__media { position: relative; aspect-ratio: 1; background: var(--bg-card); border: 1px solid var(--haldi-deep); border-top: 4px solid var(--haldi); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-haldi); }
  .emulsion-hero__media .product-media { width: 100%; height: 100%; }
  .emulsion-hero__media .product-media__official { object-fit: contain; padding: 3rem; }
  .emulsion-hero__media .product-media__fallback { padding: 2.5rem; }
  .emulsion-hero__media__num { position: absolute; top: 1rem; right: 1.25rem; font-family: var(--font-display); font-size: 4rem; font-weight: 700; color: var(--haldi-deep); opacity: 0.22; line-height: 1; }
  .emulsion-hero__media__leaf { position: absolute; left: -0.5rem; bottom: -0.5rem; width: 4rem; height: 4rem; opacity: 0.65; pointer-events: none; }

  /* SPEC SHEET — horizontal row cards (different from Distemper's numbered list) */
  .spec-sheet { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 2.5rem; max-width: 48rem; }
  .spec-sheet__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--haldi-deep); }
  .spec-sheet__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .spec-sheet__grid { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .spec-sheet__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .spec-sheet__grid { grid-template-columns: repeat(4, 1fr); } }
  .spec-card { padding: 1.5rem; background: var(--bg-card); border: 1px solid var(--border); border-bottom: 3px solid var(--haldi); border-radius: var(--radius); display: flex; flex-direction: column; gap: 0.375rem; }
  .spec-card__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .spec-card__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .spec-card__value { font-family: var(--font-display); font-size: 1.375rem; font-weight: 700; color: var(--fg); line-height: 1.15; }
  .spec-card__note { font-size: 0.75rem; color: var(--fg-muted); line-height: 1.5; margin-top: 0.25rem; }

  .disclaimer-card { padding: 1.25rem 1.5rem; background: var(--bg-card); border-left: 3px solid var(--haldi-deep); border-radius: var(--radius); font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.65; margin-top: 2rem; }

  /* ASHTA LAABH — radial + side list (different from Distemper's 4-col grid) */
  .emulsion-ashta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--bg-card); }
  .emulsion-ashta__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .emulsion-ashta__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.75rem, 4vw, 2.5rem); color: var(--haldi-deep); }
  .emulsion-ashta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; }
  .emulsion-ashta__grid { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .emulsion-ashta__grid { grid-template-columns: 1fr 1fr; } }
  .emulsion-ashta__diagram { max-width: 28rem; margin-inline: auto; width: 100%; aspect-ratio: 1; }
  .emulsion-ashta__diagram svg { width: 100%; height: 100%; }
  .emulsion-ashta__list { display: grid; gap: 0.625rem; }
  .emulsion-ashta__item { padding: 0.875rem 1.125rem; background: var(--bg); border-left: 3px solid var(--haldi); border-radius: var(--radius); display: grid; grid-template-columns: 2rem 1fr auto; gap: 0.75rem; align-items: center; cursor: pointer; transition: background var(--dur), border-color var(--dur), transform var(--dur); }
  .emulsion-ashta__item:hover, .emulsion-ashta__item:focus-visible, .emulsion-ashta__item[data-active="true"] { background: oklch(0.82 0.14 82 / 0.12); border-left-color: var(--forest); transform: translateX(2px); outline: none; }
  .emulsion-ashta__item:focus-visible { outline: 2px solid var(--primary); outline-offset: 2px; }
  .emulsion-ashta__num { font-family: var(--font-display); font-size: 0.75rem; font-weight: 700; color: var(--haldi-deep); }
  .emulsion-ashta__name { font-weight: 600; font-size: 0.9375rem; }
  .emulsion-ashta__deva { font-family: var(--font-deva); font-size: 0.8125rem; color: var(--fg-muted); }

  /* CTA + CROSS-LINK */
  .emulsion-cta { padding-block: clamp(3rem, 6vw, 5rem); }
  .emulsion-cta__inner { display: grid; gap: 1.5rem; padding: clamp(1.75rem, 4vw, 3rem); background: linear-gradient(135deg, var(--haldi-light), var(--haldi)); border-radius: var(--radius-lg); box-shadow: var(--shadow-haldi); color: var(--charcoal); }
  @media (min-width: 768px) { .emulsion-cta__inner { grid-template-columns: 1.4fr 1fr; gap: 2.5rem; align-items: center; } }
  .emulsion-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); letter-spacing: -0.02em; }
  .emulsion-cta__body { margin-top: 0.75rem; color: oklch(0.30 0.02 50); line-height: 1.65; }
  .emulsion-cta__actions { display: flex; flex-direction: column; gap: 0.75rem; }
  .emulsion-cta__actions .btn--primary { background: var(--forest); color: var(--primary-fg); }
  .emulsion-cta__actions .btn--outline { background: transparent; border-color: var(--forest-deep); color: var(--forest-deep); }
  .emulsion-cta__cross { padding: 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); }
  .emulsion-cta__cross-title { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .emulsion-cta__cross-name { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.375rem; }
  .emulsion-cta__cross-link { margin-top: 0.5rem; display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.8125rem; font-weight: 600; color: var(--primary); }
  .emulsion-cta__cross-link:hover { gap: 0.5rem; }
</style>

<section class="emulsion-detail" id="emulsion-detail">
    <div class="container">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="${relUrl('/', depth)}">Home</a><span>›</span>
            <a href="${relUrl('/products/', depth)}">Products</a><span>›</span>
            Prakritik Emulsion
        </nav>

        <!-- HERO (REVERSED: image right, text left) -->
        <div class="emulsion-hero" data-reveal>
            <div class="emulsion-hero__lockup">
                <span class="emulsion-hero__eyebrow">Prakritik Paint</span>
                <h1 class="emulsion-hero__name">${e(product.name)}</h1>
                <div class="emulsion-hero__descriptor">${e(product.descriptor)}</div>
                <p class="emulsion-hero__body">A liquid cow dung-based paint format. White, matt, and suitable for interior and exterior walls — the warmer half of the Prakritik range.</p>
                <div class="emulsion-hero__chips">
                    <span class="emulsion-hero__chip">${e(product.packagingShort)}</span>
                    <span class="emulsion-hero__chip">${e(product.finish)} finish</span>
                    <span class="emulsion-hero__chip">${e(product.usage)}</span>
                </div>
                <div class="emulsion-hero__cta-row">
                    <a href="${relUrl('/contact/', depth)}?interest=prakritik-emulsion" class="btn btn--primary btn--lg">Enquire About Emulsion</a>
                    <a href="${relUrl('/paint-calculator/', depth)}" class="btn btn--outline btn--lg">Estimate Your Project</a>
                </div>
            </div>
            <div class="emulsion-hero__media">
                <span class="emulsion-hero__media__num" aria-hidden="true">02</span>
                <div class="product-media" data-official-image="${productImg}">
                    <img class="product-media__official" src="${productImg}" alt="${e(product.name)}" width="640" height="640">
                    <div class="product-media__fallback">${loadSvg('prakritik-emulsion-bucket')}</div>
                </div>
                <div class="emulsion-hero__media__leaf" aria-hidden="true">${loadSvg('field-botanicals')}</div>
            </div>
        </div>
    </div>
</section>

<!-- SPEC SHEET — 4-col row cards (different from Distemper's 2-col list) -->
<section class="spec-sheet section--paper" id="spec-sheet" data-reveal>
    <div class="container">
        <div class="spec-sheet__head">
            <span class="spec-sheet__eyebrow">Specification sheet</span>
            <h2 class="spec-sheet__title">Material specifications.</h2>
        </div>
        <div class="spec-sheet__grid" data-reveal-stagger>
            <div class="spec-card">
                <span class="spec-card__num">01</span>
                <span class="spec-card__label">Packaging</span>
                <span class="spec-card__value">${e(product.packagingShort)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">02</span>
                <span class="spec-card__label">Colour</span>
                <span class="spec-card__value">${e(product.colour)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">03</span>
                <span class="spec-card__label">Finish</span>
                <span class="spec-card__value">${e(product.finish)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">04</span>
                <span class="spec-card__label">Drying time</span>
                <span class="spec-card__value">${e(product.dryingTime)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">05</span>
                <span class="spec-card__label">Coverage</span>
                <span class="spec-card__value">${e(product.coverage)}</span>
                <span class="spec-card__note">${e(COVERAGE_DISCLAIMER)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">06</span>
                <span class="spec-card__label">V.O.C.</span>
                <span class="spec-card__value">${e(product.voc)}</span>
            </div>
            <div class="spec-card">
                <span class="spec-card__num">07</span>
                <span class="spec-card__label">Usage</span>
                <span class="spec-card__value">${e(product.usage)}</span>
            </div>
            <div class="spec-card" style="background: var(--secondary-bg);">
                <span class="spec-card__num">∞</span>
                <span class="spec-card__label">Also see</span>
                <a href="${relUrl('/products/', depth)}" class="spec-card__value" style="color: var(--primary); font-size: 1.125rem; text-decoration: underline;">Compare both formats</a>
            </div>
        </div>
        <div class="disclaimer-card">
            <strong>Coverage note —</strong> ${e(COVERAGE_DISCLAIMER)}
        </div>
    </div>
</section>

<!-- ASHTA LAABH — radial + list -->
<section class="emulsion-ashta" id="ashta-laabh" data-reveal>
    <div class="container">
        <div class="emulsion-ashta__head">
            <div class="emulsion-ashta__deva" lang="hi">अष्ट लाभ</div>
            <h2 class="emulsion-ashta__title">Eight benefits presented in Prakritik Paint.</h2>
        </div>
        <div class="emulsion-ashta__grid" data-ashta-laabh>
            <div class="emulsion-ashta__diagram" aria-hidden="true">${loadSvg('ashta-laabh-diagram')}</div>
            <ol class="emulsion-ashta__list" data-reveal-stagger>
${ashtaItems}
            </ol>
        </div>
    </div>
</section>

<!-- CTA + CROSS-LINK -->
<section class="emulsion-cta section--paper" id="enquire" data-reveal>
    <div class="container">
        <div class="emulsion-cta__inner">
            <div>
                <h2 class="emulsion-cta__title">Want to know more about Prakritik Emulsion?</h2>
                <p class="emulsion-cta__body">Send an enquiry about packaging, project sizes, or collaboration. We'll respond with what's currently available.</p>
                <div class="emulsion-cta__actions">
                    <a href="${relUrl('/contact/', depth)}?interest=prakritik-emulsion" class="btn btn--primary btn--lg btn--block">Enquire About Emulsion</a>
                    <a href="${relUrl('/for-business/', depth)}" class="btn btn--outline btn--lg btn--block">Discuss a Project</a>
                </div>
            </div>
            <div class="emulsion-cta__cross">
                <span class="emulsion-cta__cross-title">Also in the Prakritik range</span>
                <h3 class="emulsion-cta__cross-name">${e(distemper.name)}</h3>
                <a href="${relUrl(distemper.route, depth)}" class="emulsion-cta__cross-link">Explore Distemper
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
`;
}

// ---- Why Prakritik ----
function whyPrakritikBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const journeySteps = MATERIAL_JOURNEY.map(
        (stage) => `                    <li class="journey-inline__step">
                        <div class="journey-inline__num">${e(stage.num)}</div>
                        <div class="journey-inline__title">${e(stage.title)}</div>
                        <div class="journey-inline__desc">${e(stage.desc)}</div>
                    </li>`,
    ).join('\n');

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = 'wp-al-' + (i + 1);
        return `                    <li class="ashta-essay__item" data-ashta-node="${e(bid)}">
                        <span class="ashta-essay__num">${pad2(i + 1)}</span>
                        <span class="ashta-essay__name">${e(benefit.name)}</span>
                        <span class="ashta-essay__deva" lang="hi">${e(benefit.hindi)}</span>
                    </li>`;
    }).join('\n');

    return `<style>
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
            <div class="why-hero__cow">${loadSvg('indian-cow')}</div>
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
                <div class="material-journey__svg" aria-hidden="true">${loadSvg('material-journey')}</div>
                <ol class="journey-inline__steps">
${journeySteps}
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
                <div class="ashta-essay__diagram" aria-hidden="true">${loadSvg('ashta-laabh-diagram')}</div>
                <ol class="ashta-essay__list" data-reveal-stagger>
${ashtaItems}
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
                    <div class="two-formats-mini__name">${e(distemper.name)}</div>
                    <div class="two-formats-mini__desc">${e(distemper.packagingShort)} · ${e(distemper.finish)} · ${e(distemper.usage)}</div>
                    <a href="${relUrl(distemper.route, depth)}" class="two-formats-mini__link">Explore Distemper
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="two-formats-mini__item">
                    <div class="two-formats-mini__name">${e(emulsion.name)}</div>
                    <div class="two-formats-mini__desc">${e(emulsion.packagingShort)} · ${e(emulsion.finish)} · ${e(emulsion.usage)}</div>
                    <a href="${relUrl(emulsion.route, depth)}" class="two-formats-mini__link">Explore Emulsion
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
            <a href="${relUrl('/products/', depth)}" class="btn btn--haldi btn--lg">Explore Products</a>
            <a href="${relUrl('/contact/', depth)}" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Talk to Us</a>
        </div>
    </div>
</section>
`;
}

// ---- About ----
function aboutBody(depth) {
    const address = COMPANY.address;
    const phones = COMPANY.phones;
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const addressLines = address.map((line) => e(line)).join('\n');
    const phoneRows = phones
        .map(
            (phone, i) => `                    <div class="company-info__row">
                        <dt>Phone ${i + 1}</dt>
                        <dd><a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a></dd>
                    </div>`,
        )
        .join('\n');

    return `<style>
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
            <span class="about-hero__deva" lang="hi">${e(COMPANY.devanagari)}</span>
            <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
            <h1 class="about-hero__title">Nature. Culture. Useful materials.</h1>
            <hr class="about-hero__rule">
            <p class="about-hero__body">Gaurikrit Bio Products (OPC) Private Limited is based in Khurja, District Bulandshahr, Uttar Pradesh.</p>
        </div>
        <div class="about-hero__art" aria-hidden="true">
            ${loadSvg('gaushala-scene')}
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
                <p><strong>${e(COMPANY.legalName)}</strong> is a private limited company registered in India. The studio is in Khurja, in District Bulandshahr, Uttar Pradesh.</p>
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
                        <div class="manifesto__list-name">${e(distemper.name)}</div>
                        <div class="manifesto__list-desc">${e(distemper.descriptor)} · ${e(distemper.packagingShort)} · ${e(distemper.finish)} · ${e(distemper.usage)}</div>
                    </div>
                    <div class="manifesto__list-item">
                        <div class="manifesto__list-name">${e(emulsion.name)}</div>
                        <div class="manifesto__list-desc">${e(emulsion.descriptor)} · ${e(emulsion.packagingShort)} · ${e(emulsion.finish)} · ${e(emulsion.usage)}</div>
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
                <p class="manifesto__pull" style="font-size: clamp(1.5rem, 3vw, 2.25rem); border-left-width: 4px;">${e(COMPANY.mission)}</p>
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
        <p class="brand-principle__phrase">${e(COMPANY.brandLine)}</p>
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
                        <dd>${e(COMPANY.legalName)}</dd>
                    </div>
                    <div class="company-info__row">
                        <dt>Address</dt>
                        <dd class="company-info__address">${addressLines}</dd>
                    </div>
                    <div class="company-info__row">
                        <dt>GSTIN</dt>
                        <dd>${e(COMPANY.gstin)}</dd>
                    </div>
                </dl>
            </div>
            <div class="company-info__card">
                <h3 class="company-info__card-title">Direct contact</h3>
                <dl>
                    <div class="company-info__row">
                        <dt>Email</dt>
                        <dd><a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a></dd>
                    </div>
${phoneRows}
                </dl>
                <div class="company-info__actions">
                    <a href="mailto:${e(COMPANY.email)}" class="btn btn--outline btn--block">Email Gaurikrit</a>
                    <a href="tel:${e(phones[0].replace(/ /g, ''))}" class="btn btn--primary btn--block">Call Gaurikrit</a>
                    <a href="${relUrl('/contact/', depth)}" class="btn btn--ghost btn--block">Send an enquiry</a>
                </div>
            </div>
        </div>
    </div>
</section>
`;
}

// ---- For Business ----
function forBusinessBody(depth) {
    const projectTypeOptions = PROJECT_TYPES.map(
        (type) => `                            <option value="${e(type)}">${e(type)}</option>`,
    ).join('\n');

    return `<style>
  /* HERO */
  .biz-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2.5rem, 5vw, 4rem); background: linear-gradient(180deg, var(--bg) 0%, var(--secondary-bg) 100%); }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .biz-hero__container { grid-template-columns: 1.1fr 0.9fr; gap: 4rem; } }
  .biz-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); width: fit-content; }
  .biz-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .biz-hero__title { margin-top: 1.25rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .biz-hero__sub { margin-top: 1.25rem; max-width: 36rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .biz-hero__ctas { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .biz-hero__art { position: relative; aspect-ratio: 4/3; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-soft); padding: 1.5rem; display: flex; align-items: flex-end; justify-content: center; }
  .biz-hero__art .biz-hero__bucket { position: absolute; right: 1.5rem; bottom: 1.5rem; width: 30%; height: 60%; }
  .biz-hero__art .biz-hero__brush { position: absolute; left: 1rem; top: 1rem; width: 60%; height: 50%; opacity: 0.7; }
  .biz-hero__art .biz-hero__grid-overlay { position: absolute; inset: 0; background-image: linear-gradient(var(--border) 1px, transparent 1px), linear-gradient(90deg, var(--border) 1px, transparent 1px); background-size: 3rem 3rem; opacity: 0.4; pointer-events: none; }

  /* SECTIONS — architectural columns */
  .biz-sections { padding-block: clamp(3rem, 6vw, 5rem); }
  .biz-sections__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .biz-sections__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .biz-sections__grid { display: grid; gap: 0; border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; background: var(--bg-card); box-shadow: var(--shadow-soft); }
  @media (min-width: 640px) { .biz-sections__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .biz-sections__grid { grid-template-columns: repeat(4, 1fr); } }
  .biz-section { padding: 1.75rem; border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); display: flex; flex-direction: column; gap: 0.625rem; min-height: 14rem; }
  @media (min-width: 1024px) { .biz-section:nth-child(2n) { border-right: 1px solid var(--border); } .biz-section:nth-child(4n) { border-right: 0; } .biz-section:nth-last-child(-n+4) { border-bottom: 0; } }
  .biz-section__num { font-family: var(--font-display); font-size: 0.875rem; font-weight: 700; color: var(--haldi-deep); }
  .biz-section__title { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; line-height: 1.2; }
  .biz-section__desc { font-size: 0.875rem; color: var(--fg-muted); line-height: 1.6; }
  .biz-section__chip { margin-top: auto; padding: 0.3125rem 0.625rem; border-radius: var(--radius-full); background: var(--secondary-bg); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--primary); width: fit-content; }

  /* FORM */
  .biz-form-section { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .biz-form-card { padding: clamp(1.5rem, 4vw, 2.5rem); background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  @media (min-width: 768px) { .biz-form-card { padding: 2.5rem; } }
  .biz-form-card__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .biz-form-card__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.15; margin-top: 0.5rem; letter-spacing: -0.02em; }
  .biz-form-card__intro { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; font-size: 0.9375rem; }
  .biz-form-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; margin-top: 1.5rem; }
  @media (min-width: 640px) { .biz-form-grid { grid-template-columns: 1fr 1fr; } }
  .biz-form-field--full { grid-column: 1 / -1; }
  .biz-form-card .btn { width: 100%; }
  .biz-form-card__note { margin-top: 1rem; font-size: 0.75rem; color: var(--fg-muted); text-align: center; }
</style>

<!-- HERO -->
<section class="biz-hero" id="biz-hero" data-reveal>
    <div class="container biz-hero__container">
        <div>
            <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>For Business</span>
            <h1 class="biz-hero__title">Building with a different kind of material?</h1>
            <p class="biz-hero__sub">Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint.</p>
            <div class="biz-hero__ctas">
                <a href="#enquiry" class="btn btn--primary btn--lg">Discuss a Project</a>
                <a href="${relUrl('/products/', depth)}" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
            </div>
        </div>
        <div class="biz-hero__art" aria-hidden="true">
            <div class="biz-hero__grid-overlay"></div>
            <div class="biz-hero__brush">${loadSvg('paint-brush-stroke')}</div>
            <div class="biz-hero__bucket">${loadSvg('prakritik-emulsion-bucket')}</div>
        </div>
    </div>
</section>

<!-- SECTIONS -->
<section class="biz-sections section--paper" id="audiences" data-reveal>
    <div class="container">
        <div class="biz-sections__head">
            <span class="section-heading__eyebrow">Who this is for</span>
            <h2 class="biz-sections__title">Four conversations, one form.</h2>
        </div>
        <div class="biz-sections__grid">
            <article class="biz-section">
                <div class="biz-section__num">01</div>
                <h3 class="biz-section__title">Architects & Builders</h3>
                <p class="biz-section__desc">Discuss product, packaging, and project requirements for residential and commercial builds.</p>
                <span class="biz-section__chip">Project</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">02</div>
                <h3 class="biz-section__title">Institutions</h3>
                <p class="biz-section__desc">Talk to Gaurikrit about institutional projects that want a bio-based wall coating.</p>
                <span class="biz-section__chip">Institution</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">03</div>
                <h3 class="biz-section__title">CSR / NGOs</h3>
                <p class="biz-section__desc">Sustainability-led CSR or NGO programmes exploring cow-dung-based bio-products.</p>
                <span class="biz-section__chip">CSR</span>
            </article>
            <article class="biz-section">
                <div class="biz-section__num">04</div>
                <h3 class="biz-section__title">Gaushalas</h3>
                <p class="biz-section__desc">Explore collaboration around cow-dung-based bio-products and Prakritik Paint.</p>
                <span class="biz-section__chip">Gaushala</span>
            </article>
        </div>
    </div>
</section>

<!-- BUSINESS FORM -->
<!-- Replace the form action with your Formspree ID or deploy to Hostinger for PHP backend -->
<section class="biz-form-section" id="enquiry" data-reveal>
    <div class="container" style="max-width: 56rem;">
        <div class="biz-form-card">
            <span class="biz-form-card__eyebrow">Business enquiry</span>
            <h2 class="biz-form-card__title">Discuss a project with Gaurikrit.</h2>
            <p class="biz-form-card__intro">Fields marked <span class="req" style="color: var(--mitti);">*</span> are required. The more you share, the more useful the response.</p>

            <form data-business-form method="post" action="https://formspree.io/f/your-form-id" novalidate>
                <div class="biz-form-grid">
                    <div class="form-field">
                        <label class="form-label" for="bz-name">Name <span class="req">*</span></label>
                        <input class="form-input" type="text" id="bz-name" name="name" required maxlength="80" autocomplete="name">
                        <div class="form-error" data-error-for="name"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-organisation">Organisation <span class="req">*</span></label>
                        <input class="form-input" type="text" id="bz-organisation" name="organisation" required maxlength="120" autocomplete="organization">
                        <div class="form-error" data-error-for="organisation"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-role">Role</label>
                        <input class="form-input" type="text" id="bz-role" name="role" maxlength="80" placeholder="Architect, Procurement, Programme lead…" autocomplete="organization-title">
                        <div class="form-error" data-error-for="role"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-phone">Phone</label>
                        <input class="form-input" type="tel" id="bz-phone" name="phone" maxlength="20" autocomplete="tel">
                        <div class="form-error" data-error-for="phone"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-email">Email <span class="req">*</span></label>
                        <input class="form-input" type="email" id="bz-email" name="email" required maxlength="254" autocomplete="email">
                        <div class="form-error" data-error-for="email"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-city">City</label>
                        <input class="form-input" type="text" id="bz-city" name="city" maxlength="80" autocomplete="address-level2">
                        <div class="form-error" data-error-for="city"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-project-type">Project type</label>
                        <select class="form-select" id="bz-project-type" name="project_type">
                            <option value="">Select…</option>
${projectTypeOptions}
                        </select>
                        <div class="form-error" data-error-for="project_type"></div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="bz-requirement">Approximate requirement</label>
                        <input class="form-input" type="text" id="bz-requirement" name="approximate_requirement" maxlength="100" placeholder="e.g. 20 litres of Emulsion, 50 kg of Distemper">
                        <div class="form-error" data-error-for="approximate_requirement"></div>
                    </div>
                    <div class="form-field biz-form-field--full">
                        <label class="form-label" for="bz-message">Message</label>
                        <textarea class="form-textarea" id="bz-message" name="message" maxlength="2000" rows="5" placeholder="A short note about your project, timeline and what you'd like to discuss."></textarea>
                        <div class="form-error" data-error-for="message"></div>
                    </div>
                    <div class="biz-form-field--full" style="margin-top: 0.5rem;">
                        <button type="submit" class="btn btn--primary btn--lg">
                            <span data-submit-label>Discuss a Project</span>
                            <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                        </button>
                    </div>
                </div>
            </form>
            <p class="biz-form-card__note">This form requires a backend. Deploy to Hostinger for full functionality, or connect a Formspree form ID.</p>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
`;
}

// ---- Paint Calculator ----
function paintCalculatorBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    // Calculator config — static: disabled (rates not supplied by client).
    // calculator.js reads this from a #calculator-config inline JSON script.
    const calcConfig = { enabled: false };

    return `<style>
  /* HERO */
  .calc-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .calc-hero__inner { max-width: 56rem; }
  .calc-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .calc-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .calc-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .calc-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* STEPS */
  .calc-steps { padding-block: clamp(2.5rem, 5vw, 4rem); }
  .calc-step { padding-block: clamp(1.75rem, 4vw, 2.5rem); border-top: 1px solid var(--border); }
  .calc-step:first-of-type { border-top: 0; }
  .calc-step__head { display: flex; align-items: baseline; gap: 1rem; margin-bottom: 1.5rem; }
  .calc-step__num { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 3.5rem); font-weight: 700; color: var(--haldi-deep); line-height: 0.9; }
  .calc-step__label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-step__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); line-height: 1.15; letter-spacing: -0.02em; }
  .calc-step__sub { margin-top: 0.25rem; font-size: 0.9375rem; color: var(--fg-muted); }

  /* RADIO CARDS */
  .radio-card-grid { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .radio-card-grid { grid-template-columns: repeat(2, 1fr); } }
  .radio-card { position: relative; display: flex; flex-direction: column; gap: 0.375rem; padding: 1.25rem 1.5rem; border: 1.5px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); cursor: pointer; transition: border-color var(--dur), box-shadow var(--dur), transform var(--dur); min-height: 5rem; }
  .radio-card:hover { transform: translateY(-2px); border-color: var(--primary); box-shadow: var(--shadow-soft); }
  .radio-card input { position: absolute; opacity: 0; inset: 0; cursor: pointer; }
  .radio-card:has(input:checked) { border-color: var(--primary); background: oklch(0.42 0.05 150 / 0.06); box-shadow: var(--shadow-forest); }
  .radio-card:has(input:focus-visible) { outline: 2px solid var(--primary); outline-offset: 2px; }
  .radio-card__title { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; }
  .radio-card__desc { font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.5; }
  .radio-card__check { position: absolute; top: 0.75rem; right: 0.75rem; width: 1.25rem; height: 1.25rem; border-radius: var(--radius-full); border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: center; transition: background var(--dur), border-color var(--dur); }
  .radio-card:has(input:checked) .radio-card__check { background: var(--primary); border-color: var(--primary); }
  .radio-card:has(input:checked) .radio-card__check svg { display: block; }
  .radio-card__check svg { display: none; color: var(--primary-fg); }

  /* WALL AREA INPUT */
  .wall-input-wrap { display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: stretch; max-width: 32rem; }
  .wall-input-wrap .form-input { height: 3.25rem; flex: 1 1 14rem; font-size: 1.125rem; font-family: var(--font-display); font-weight: 600; padding: 0 1rem; }
  .wall-input-wrap .wall-input-unit { display: inline-flex; align-items: center; padding: 0 1.25rem; border: 1.5px solid var(--border); border-radius: var(--radius); background: var(--secondary-bg); font-size: 0.9375rem; font-weight: 600; color: var(--fg-muted); }
  .wall-input-hint { margin-top: 0.625rem; font-size: 0.8125rem; color: var(--fg-muted); }

  /* CALCULATE BUTTON */
  .calc-actions { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-start; }
  @media (min-width: 640px) { .calc-actions { flex-direction: row; align-items: center; gap: 1rem; } }

  /* RESULT SECTION (hidden until calculated) */
  .calc-result { margin-top: 2rem; padding: clamp(1.5rem, 4vw, 2.5rem); background: var(--bg-card); border: 1px solid var(--border); border-top: 4px solid var(--haldi-deep); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
  .calc-result[hidden] { display: none; }
  .calc-result__eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .calc-result__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem); margin-top: 0.5rem; letter-spacing: -0.02em; }
  .calc-result__grid { display: grid; gap: 1rem; margin-top: 1.5rem; }
  @media (min-width: 640px) { .calc-result__grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 1024px) { .calc-result__grid { grid-template-columns: repeat(4, 1fr); } }
  .calc-result__cell { padding: 1rem 1.25rem; background: var(--secondary-bg); border-radius: var(--radius); border-left: 3px solid var(--haldi); }
  .calc-result__cell-label { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
  .calc-result__cell-value { font-family: var(--font-display); font-size: 1.125rem; font-weight: 700; margin-top: 0.25rem; line-height: 1.2; }
  .calc-result__note { margin-top: 1.5rem; padding: 1rem 1.25rem; border-left: 3px solid var(--mitti); background: var(--secondary-bg); border-radius: var(--radius); font-size: 0.875rem; color: var(--fg-muted); line-height: 1.65; }
  .calc-result__cta { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* Helper / contact strip */
  .calc-helper { padding-block: clamp(2.5rem, 5vw, 4rem); background: var(--forest); color: var(--primary-fg); }
  .calc-helper__inner { display: grid; gap: 1rem; text-align: center; max-width: 48rem; margin-inline: auto; }
  .calc-helper__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .calc-helper__body { color: oklch(0.85 0.01 75); line-height: 1.65; }
  .calc-helper__actions { margin-top: 1rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- HERO -->
<section class="calc-hero" id="calc-hero" data-reveal>
    <div class="container calc-hero__inner">
        <span class="calc-hero__eyebrow"><span class="calc-hero__eyebrow-dot" aria-hidden="true"></span>Painting Budget Calculator</span>
        <h1 class="calc-hero__title">Painting Budget Calculator.</h1>
        <p class="calc-hero__sub">Get an indicative project estimate using your wall area and paint requirements.</p>
        <hr class="calc-hero__rule">
    </div>
</section>

<!-- CALC FORM -->
<section class="calc-steps" id="calc-steps" data-reveal>
    <div class="container" style="max-width: 60rem;">
        <form data-calculator-form novalidate>

            <!-- STEP 1 — Painting type -->
            <fieldset class="calc-step" data-step="1">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 01</div>
                        <h2 class="calc-step__title">What are you painting?</h2>
                        <p class="calc-step__sub">Fresh painting on a new wall, or repainting an existing one?</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Painting type">
                    <label class="radio-card">
                        <input type="radio" name="painting_type" value="fresh" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Fresh Painting</span>
                        <span class="radio-card__desc">New wall, first coat.</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="painting_type" value="repaint" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Repainting</span>
                        <span class="radio-card__desc">Existing wall, refresh.</span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 2 — Location -->
            <fieldset class="calc-step" data-step="2">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 02</div>
                        <h2 class="calc-step__title">Where?</h2>
                        <p class="calc-step__sub">Both Prakritik formats list usage as Interior &amp; Exterior.</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Painting location">
                    <label class="radio-card">
                        <input type="radio" name="location" value="interior" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Interior</span>
                        <span class="radio-card__desc">Inside walls.</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="location" value="exterior" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Exterior</span>
                        <span class="radio-card__desc">Outside walls.</span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 3 — Paint choice -->
            <fieldset class="calc-step" data-step="3">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 03</div>
                        <h2 class="calc-step__title">Choose Paint.</h2>
                        <p class="calc-step__sub">Two Prakritik Paint formats — Distemper (powder, by kilogram) or Emulsion (liquid, by litre).</p>
                    </div>
                </div>
                <div class="radio-card-grid" role="radiogroup" aria-label="Paint format">
                    <label class="radio-card">
                        <input type="radio" name="paint" value="distemper" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Prakritik Distemper</span>
                        <span class="radio-card__desc">Coverage listed: ${e(distemper.coverage)} · ${e(distemper.packagingShort)}</span>
                    </label>
                    <label class="radio-card">
                        <input type="radio" name="paint" value="emulsion" required>
                        <span class="radio-card__check"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6L9 17l-5-5"/></svg></span>
                        <span class="radio-card__title">Prakritik Emulsion</span>
                        <span class="radio-card__desc">Coverage listed: ${e(emulsion.coverage)} · ${e(emulsion.packagingShort)}</span>
                    </label>
                </div>
            </fieldset>

            <!-- STEP 4 — Wall area -->
            <fieldset class="calc-step" data-step="4">
                <div class="calc-step__head">
                    <div>
                        <div class="calc-step__label">Step 04</div>
                        <h2 class="calc-step__title">Wall Area.</h2>
                        <p class="calc-step__sub">Enter the wall area you plan to paint, in square feet.</p>
                    </div>
                </div>
                <div class="wall-input-wrap">
                    <input class="form-input" type="number" name="wall_area" id="calc-wall-area" min="1" step="1" inputmode="numeric" placeholder="e.g. 1200" required>
                    <span class="wall-input-unit">sq.ft.</span>
                </div>
                <p class="wall-input-hint">Tip: a typical room of 10 × 12 ft with 9-ft ceiling has roughly 396 sq.ft. of wall (minus doors and windows).</p>
            </fieldset>

            <!-- ACTIONS -->
            <div class="calc-actions">
                <button type="submit" class="btn btn--primary btn--lg" data-calc-submit>
                    <span data-submit-label>Calculate Estimate</span>
                    <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                </button>
                <button type="reset" class="btn btn--ghost btn--lg" data-calc-reset>Start over</button>
            </div>

            <!-- RESULT (hidden until calculate) -->
            <div class="calc-result" data-calc-result hidden role="status" aria-live="polite">
                <span class="calc-result__eyebrow">Your project</span>
                <h3 class="calc-result__title">Here's your indicative project summary.</h3>
                <div class="calc-result__grid">
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Painting type</div>
                        <div class="calc-result__cell-value" data-result-painting-type>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Location</div>
                        <div class="calc-result__cell-value" data-result-location>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Paint</div>
                        <div class="calc-result__cell-value" data-result-paint>—</div>
                    </div>
                    <div class="calc-result__cell">
                        <div class="calc-result__cell-label">Wall area</div>
                        <div class="calc-result__cell-value" data-result-area>—</div>
                    </div>
                </div>
                <p class="calc-result__note">Automatic commercial rates have not yet been configured. For an accurate estimate, send these project details to Gaurikrit.</p>
                <div class="calc-result__cta">
                    <a href="${relUrl('/contact/', depth)}?interest=bulk-project" class="btn btn--primary btn--lg" data-calc-request-cta>Request Estimate</a>
                    <a href="${relUrl('/products/', depth)}" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- HELPER STRIP -->
<section class="calc-helper" id="calc-helper" data-reveal>
    <div class="container">
        <div class="calc-helper__inner">
            <h2 class="calc-helper__title">Want a more accurate estimate?</h2>
            <p class="calc-helper__body">Send your project details and Gaurikrit will respond with what's currently available for your scale and format.</p>
            <div class="calc-helper__actions">
                <a href="${relUrl('/contact/', depth)}?interest=bulk-project" class="btn btn--haldi btn--lg">Request Estimate</a>
                <a href="${relUrl('/for-business/', depth)}" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Discuss a Project</a>
            </div>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

<script type="application/json" id="calculator-config">
${JSON.stringify(calcConfig)}
</script>

<script>
// Minimal inline calculator — works even before /assets/js/calculator.js
// loads. Once that file lands it can replace or augment this handler.
(function () {
    var form = document.querySelector('[data-calculator-form]');
    if (!form) return;
    var result = form.querySelector('[data-calc-result]');
    var requestCta = form.querySelector('[data-calc-request-cta]');
    var submit = form.querySelector('[data-calc-submit]');
    var submitLabel = form.querySelector('[data-submit-label]');
    var spinner = form.querySelector('[data-submit-spinner]');

    function val(name) {
        var el = form.querySelector('[name="' + name + '"]:checked');
        return el ? el.value : '';
    }
    function pretty(v, fallback) {
        if (!v) return fallback || '—';
        return v.charAt(0).toUpperCase() + v.slice(1);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (typeof form.reportValidity === 'function' && !form.reportValidity()) return;

        var paintType = pretty(val('painting_type'));
        var location = pretty(val('location'));
        var paint = val('paint');
        var paintLabel = paint === 'distemper' ? 'Prakritik Distemper' : paint === 'emulsion' ? 'Prakritik Emulsion' : '—';
        var area = (form.querySelector('[name="wall_area"]') || {}).value || '';

        form.querySelector('[data-result-painting-type]').textContent = paintType;
        form.querySelector('[data-result-location]').textContent = location;
        form.querySelector('[data-result-paint]').textContent = paintLabel;
        form.querySelector('[data-result-area]').textContent = area ? (parseInt(area, 10).toLocaleString('en-IN') + ' sq.ft.') : '—';

        // Build the Request Estimate URL with the project details.
        // Use a relative path so it works on GitHub Pages.
        var params = new URLSearchParams();
        params.set('interest', 'bulk-project');
        if (paintType && paintType !== '—') params.set('painting_type', paintType);
        if (location && location !== '—') params.set('location', location);
        if (paint) params.set('paint', paint);
        if (area) params.set('wall_area', String(area));
        if (requestCta) requestCta.href = '${relUrl('/contact/', depth)}?' + params.toString();

        if (result) result.removeAttribute('hidden');

        // Tiny submit affordance.
        if (submitLabel && spinner) {
            spinner.hidden = false;
            submit.setAttribute('disabled', 'disabled');
            setTimeout(function () {
                spinner.hidden = true;
                submit.removeAttribute('disabled');
                result.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        } else if (result) {
            result.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });

    var resetBtn = form.querySelector('[data-calc-reset]');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (result) result.setAttribute('hidden', '');
        });
    }
})();
</script>
`;
}

// ---- Downloads ----
function downloadsBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    // Brochure assets — relative paths.
    const brochurePdf = assetUrl('/assets/documents/prakritik-paint-brochure.pdf', depth);
    const brochureCover = assetUrl('/assets/documents/prakritik-paint-brochure-cover.png', depth);

    return `<style>
  /* HERO */
  .dl-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .dl-hero__inner { max-width: 56rem; }
  .dl-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .dl-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .dl-hero__title { margin-top: 1rem; font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .dl-hero__sub { margin-top: 1rem; max-width: 40rem; color: var(--fg-muted); font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; }
  .dl-hero__rule { width: 4rem; height: 2px; background: var(--haldi); margin-top: 1.5rem; border: 0; }

  /* BROCHURE BLOCK */
  .brochure { padding-block: clamp(3rem, 6vw, 5rem); }
  .brochure__inner { display: grid; gap: 2.5rem; align-items: center; }
  @media (min-width: 1024px) { .brochure__inner { grid-template-columns: 1fr 1.2fr; gap: 4rem; } }
  .brochure__cover { position: relative; aspect-ratio: 3/4; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-forest); display: flex; align-items: center; justify-content: center; padding: 2rem; }
  @media (max-width: 1023px) { .brochure__cover { max-width: 24rem; margin-inline: auto; } }
  .brochure__cover .product-media { width: 100%; height: 100%; }
  .brochure__cover .product-media__official { object-fit: contain; }
  .brochure__cover .product-media__fallback { padding: 0; width: 100%; height: 100%; }
  /* Coded fallback cover — uses illustration + brand typography */
  .brochure__cover-fallback { position: relative; width: 100%; height: 100%; background: linear-gradient(160deg, var(--forest), var(--forest-deep)); color: var(--primary-fg); border-radius: var(--radius); overflow: hidden; display: flex; flex-direction: column; padding: 2rem; }
  .brochure__cover-fallback .cover-mark { width: 4rem; height: 4rem; }
  .brochure__cover-fallback .cover-deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.5rem, 4vw, 2.25rem); color: var(--haldi); margin-top: auto; }
  .brochure__cover-fallback .cover-name { font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.5rem); font-weight: 700; line-height: 1.1; margin-top: 0.25rem; }
  .brochure__cover-fallback .cover-phrase { font-style: italic; font-family: var(--font-display); color: oklch(0.88 0.11 85); margin-top: 0.75rem; }
  .brochure__cover-fallback .cover-stamp { position: absolute; top: 1rem; right: 1rem; padding: 0.3125rem 0.625rem; border: 1px solid var(--haldi); border-radius: var(--radius-full); font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--haldi); }
  .brochure__cover-fallback .cover-art { position: absolute; right: 0; bottom: 0; width: 60%; height: 60%; opacity: 0.18; pointer-events: none; }

  /* Brochure detail */
  .brochure__detail-eyebrow { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .brochure__detail-title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); line-height: 1.1; margin-top: 0.5rem; letter-spacing: -0.02em; }
  .brochure__detail-desc { margin-top: 0.75rem; color: var(--fg-muted); line-height: 1.65; }
  .brochure__detail-meta { margin-top: 1.5rem; padding: 1rem 1.25rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: grid; gap: 0.625rem; }
  .brochure__detail-meta dt { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .brochure__detail-meta dd { font-size: 0.9375rem; margin-top: 0.125rem; }
  .brochure__detail-actions { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }
  .brochure__detail-note { margin-top: 1rem; padding: 1rem 1.25rem; border-left: 3px solid var(--mitti); background: var(--secondary-bg); border-radius: var(--radius); font-size: 0.875rem; color: var(--fg-muted); line-height: 1.65; }
  .brochure__detail-note a { color: var(--primary); font-weight: 600; }

  /* WHAT'S INSIDE list */
  .inside { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .inside__head { margin-bottom: 2rem; max-width: 48rem; }
  .inside__eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); }
  .inside__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); margin-top: 0.75rem; letter-spacing: -0.02em; }
  .inside__list { display: grid; gap: 1rem; }
  @media (min-width: 640px) { .inside__list { grid-template-columns: 1fr 1fr; } }
  .inside__item { padding: 1.25rem 1.5rem; background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; gap: 1rem; align-items: start; }
  .inside__item-num { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; color: var(--haldi-deep); flex-shrink: 0; line-height: 1; }
  .inside__item-title { font-weight: 600; font-size: 0.9375rem; }
  .inside__item-desc { font-size: 0.8125rem; color: var(--fg-muted); margin-top: 0.25rem; line-height: 1.5; }

  /* CTA */
  .dl-cta { padding-block: clamp(3rem, 6vw, 5rem); background: var(--forest); color: var(--primary-fg); }
  .dl-cta__inner { text-align: center; max-width: 48rem; margin-inline: auto; }
  .dl-cta__title { font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem); }
  .dl-cta__body { margin-top: 0.75rem; color: oklch(0.85 0.01 75); line-height: 1.65; }
  .dl-cta__actions { margin-top: 1.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem; justify-content: center; }
</style>

<!-- HERO -->
<section class="dl-hero" id="dl-hero" data-reveal>
    <div class="container dl-hero__inner">
        <span class="dl-hero__eyebrow"><span class="dl-hero__eyebrow-dot" aria-hidden="true"></span>Product Documents</span>
        <h1 class="dl-hero__title">Prakritik Paint Brochure.</h1>
        <p class="dl-hero__sub">Product information for Prakritik Distemper and Prakritik Emulsion.</p>
        <hr class="dl-hero__rule">
    </div>
</section>

<!-- BROCHURE -->
<section class="brochure section--paper" id="brochure" data-reveal>
    <div class="container">
        <div class="brochure__inner">

            <!-- COVER with image handoff -->
            <div class="brochure__cover">
                <div class="product-media" data-official-image="${brochureCover}">
                    <img class="product-media__official" src="${brochureCover}" alt="Prakritik Paint brochure cover" width="480" height="640">
                    <div class="product-media__fallback">
                        <div class="brochure__cover-fallback">
                            <span class="cover-stamp">Brochure</span>
                            <div class="cover-mark" aria-hidden="true">${loadSvg('gaurikrit-cow-mark')}</div>
                            <div class="cover-deva" lang="hi">${e(COMPANY.devanagari)}</div>
                            <div class="cover-name">Prakritik Paint</div>
                            <div class="cover-phrase">${e(COMPANY.brandLine)}</div>
                            <div class="cover-art" aria-hidden="true">${loadSvg('paint-brush-stroke')}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL + ACTIONS -->
            <div class="brochure__detail">
                <span class="brochure__detail-eyebrow">Brochure</span>
                <h2 class="brochure__detail-title">Prakritik Paint Brochure.</h2>
                <p class="brochure__detail-desc">A short document with product information for Prakritik Distemper and Prakritik Emulsion.</p>
                <dl class="brochure__detail-meta">
                    <div>
                        <dt>Products covered</dt>
                        <dd>${e(distemper.name)} &amp; ${e(emulsion.name)}</dd>
                    </div>
                    <div>
                        <dt>Document type</dt>
                        <dd>Product brochure</dd>
                    </div>
                </dl>

                <!-- Static build: assume brochure PDF is missing. JS
                     brochure-detection module does a HEAD fetch and will
                     flip data-brochure-state to "available" or "missing"
                     accordingly. On GitHub Pages this will 404 and show
                     the "Contact Gaurikrit" message — correct behaviour. -->
                <div data-brochure-detect="${brochurePdf}" data-brochure-state="missing">
                    <div class="brochure__detail-actions" data-brochure-if-available hidden>
                        <a href="${brochurePdf}" class="btn btn--primary btn--lg" target="_blank" rel="noopener">View Brochure</a>
                        <a href="${brochurePdf}" class="btn btn--outline btn--lg" download>Download PDF</a>
                    </div>
                    <p class="brochure__detail-note" data-brochure-if-missing>
                        <strong>Contact Gaurikrit for the current product brochure.</strong>
                        The brochure PDF will be available here once published. Until then, send an enquiry and we'll share what's currently available — <a href="${relUrl('/contact/', depth)}?interest=general">send an enquiry</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHAT'S INSIDE -->
<section class="inside" id="inside" data-reveal>
    <div class="container">
        <div class="inside__head">
            <span class="inside__eyebrow">What's inside</span>
            <h2 class="inside__title">What the brochure covers.</h2>
        </div>
        <ol class="inside__list" data-reveal-stagger>
            <li class="inside__item">
                <span class="inside__item-num">01</span>
                <div>
                    <div class="inside__item-title">Both Prakritik formats</div>
                    <div class="inside__item-desc">A short presentation of Distemper and Emulsion — packaging, finish, drying time, coverage and usage.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">02</span>
                <div>
                    <div class="inside__item-title">Specifications side by side</div>
                    <div class="inside__item-desc">The supplied product specifications, presented as a comparison.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">03</span>
                <div>
                    <div class="inside__item-title">Material direction</div>
                    <div class="inside__item-desc">A short note on the cow-dung-based material lineage Prakritik Paint carries.</div>
                </div>
            </li>
            <li class="inside__item">
                <span class="inside__item-num">04</span>
                <div>
                    <div class="inside__item-title">Coverage disclaimer</div>
                    <div class="inside__item-desc">The supplied coverage note, carried into the brochure as written.</div>
                </div>
            </li>
        </ol>
    </div>
</section>

<!-- CTA -->
<section class="dl-cta" id="dl-cta" data-reveal>
    <div class="container">
        <div class="dl-cta__inner">
            <h2 class="dl-cta__title">Have a project in mind?</h2>
            <p class="dl-cta__body">Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint.</p>
            <div class="dl-cta__actions">
                <a href="${relUrl('/contact/', depth)}" class="btn btn--haldi btn--lg">Talk to Us</a>
                <a href="${relUrl('/for-business/', depth)}" class="btn btn--outline btn--lg" style="border-color: var(--haldi); color: var(--haldi);">Discuss a Project</a>
            </div>
        </div>
    </div>
</section>
`;
}

// ---- Contact ----
function contactBody(depth) {
    const address = COMPANY.address;
    const phones = COMPANY.phones;

    const addressLines = address.map((line) => e(line)).join('\n');
    const phoneLines = phones
        .map(
            (phone) => `                                <a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a><br>`,
        )
        .join('\n');
    const interestOptions = Object.entries(INTEREST_OPTIONS).map(
        ([key, label]) => `                                <option value="${e(key)}">${e(label)}</option>`,
    ).join('\n');
    const faqItems = FAQ.map((item, i) => {
        const fid = 'faq-' + (i + 1);
        return `                <div class="faq-item" data-faq-item>
                    <button type="button" class="faq-item__q" aria-expanded="false" aria-controls="${e(fid)}-a" id="${e(fid)}-q">
                        <span>${e(item.q)}</span>
                        <svg class="faq-item__icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                    <div class="faq-item__a" id="${e(fid)}-a" role="region" aria-labelledby="${e(fid)}-q">
                        <div class="faq-item__a-inner">${item.a}</div>
                    </div>
                </div>`;
    }).join('\n');

    return `<style>
  /* HERO */
  .contact-hero { padding-top: calc(var(--header-h) + 2.5rem); padding-bottom: clamp(2rem, 4vw, 3rem); }
  .contact-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) { .contact-hero__container { grid-template-columns: 1.1fr 0.9fr; } }
  .contact-hero__lockup { display: flex; flex-direction: column; gap: 0.625rem; }
  .contact-hero__eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.3125rem 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-full); background: var(--bg-card); font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--primary); width: fit-content; }
  .contact-hero__eyebrow-dot { width: 0.375rem; height: 0.375rem; border-radius: 50%; background: var(--haldi); }
  .contact-hero__title { font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.25rem); line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance; }
  .contact-hero__sub { max-width: 36rem; font-size: clamp(1rem, 2vw, 1.125rem); color: var(--fg-muted); line-height: 1.65; }
  .contact-hero__art { aspect-ratio: 4/3; border-radius: var(--radius-lg); background: var(--bg-card); border: 1px solid var(--border); box-shadow: var(--shadow-soft); overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 2rem; }

  /* CONTACT INFO CARD */
  .contact-info-card { padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); box-shadow: var(--shadow-soft); }
  .contact-info-card h2 { font-size: 1.5rem; margin-bottom: 1rem; }
  .contact-info-card dl { display: grid; gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
  .contact-info-card__row { display: grid; grid-template-columns: 8rem 1fr; background: var(--bg-card); }
  @media (max-width: 480px) { .contact-info-card__row { grid-template-columns: 1fr; } .contact-info-card__row dt { background: var(--secondary-bg); } }
  .contact-info-card__row dt, .contact-info-card__row dd { padding: 0.75rem 1rem; }
  .contact-info-card__row dt { font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .contact-info-card__row dd { font-size: 0.9375rem; }
  .contact-info-card__row dd a { color: var(--primary); font-weight: 600; }
  .contact-info-card__address { white-space: pre-line; }

  /* FORM */
  .contact-form-card { padding: clamp(1.5rem, 4vw, 2.5rem); border: 1px solid var(--border); border-radius: var(--radius-lg); background: var(--bg-card); box-shadow: var(--shadow-soft); }
  .contact-form-card h2 { font-size: 1.5rem; margin-bottom: 0.5rem; }
  .contact-form-card__intro { font-size: 0.9375rem; color: var(--fg-muted); margin-bottom: 1.5rem; }
  .contact-form-card .form-grid { display: grid; gap: 1rem; grid-template-columns: 1fr; }
  @media (min-width: 640px) { .contact-form-card .form-grid { grid-template-columns: 1fr 1fr; } }
  .contact-form-card .form-field--full { grid-column: 1 / -1; }

  /* FAQ */
  .contact-faq { padding-block: clamp(3rem, 6vw, 5rem); background: var(--secondary-bg); }
  .contact-faq__head { text-align: center; max-width: 48rem; margin-inline: auto; margin-bottom: 2.5rem; }
  .contact-faq__title { font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem); letter-spacing: -0.02em; }
  .contact-faq__list { max-width: 48rem; margin-inline: auto; }
</style>

<!-- HERO -->
<section class="contact-hero" id="contact-hero" data-reveal>
    <div class="container contact-hero__container">
        <div class="contact-hero__lockup">
            <span class="contact-hero__eyebrow"><span class="contact-hero__eyebrow-dot" aria-hidden="true"></span>Contact</span>
            <h1 class="contact-hero__title">Talk to Gaurikrit.</h1>
            <p class="contact-hero__sub">Product questions, project requirements or partnership conversations — send an enquiry or contact Gaurikrit directly.</p>
        </div>
        <div class="contact-hero__art" aria-hidden="true">
            ${loadSvg('indian-courtyard')}
        </div>
    </div>
</section>

<!-- CONTACT INFO + FORM -->
<section class="section section--paper" id="reach" data-reveal>
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info-card">
                <h2>Company information</h2>
                <dl>
                    <div class="contact-info-card__row">
                        <dt>Legal name</dt>
                        <dd>${e(COMPANY.legalName)}</dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Address</dt>
                        <dd class="contact-info-card__address">${addressLines}</dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>GSTIN</dt>
                        <dd>${e(COMPANY.gstin)}</dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Email</dt>
                        <dd><a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a></dd>
                    </div>
                    <div class="contact-info-card__row">
                        <dt>Phone</dt>
                        <dd>
${phoneLines}
                        </dd>
                    </div>
                </dl>
                <div style="margin-top:1.25rem; display:flex; flex-direction:column; gap:0.75rem;">
                    <a href="mailto:${e(COMPANY.email)}" class="btn btn--outline btn--block">Email Gaurikrit</a>
                    <a href="tel:${e(phones[0].replace(/ /g, ''))}" class="btn btn--primary btn--block">Call Gaurikrit</a>
                </div>
            </div>

            <div class="contact-form-card">
                <h2>Send an enquiry</h2>
                <p class="contact-form-card__intro">Fields marked <span class="req" style="color: var(--mitti);">*</span> are required.</p>
                <!-- Replace the form action with your Formspree ID or deploy to Hostinger for PHP backend -->
                <form data-contact-form method="post" action="https://formspree.io/f/your-form-id" novalidate>
                    <div class="form-grid">
                        <div class="form-field">
                            <label class="form-label" for="ct-name">Name <span class="req">*</span></label>
                            <input class="form-input" type="text" id="ct-name" name="name" required maxlength="80" autocomplete="name">
                            <div class="form-error" data-error-for="name"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-email">Email <span class="req">*</span></label>
                            <input class="form-input" type="email" id="ct-email" name="email" required maxlength="254" autocomplete="email">
                            <div class="form-error" data-error-for="email"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-phone">Phone</label>
                            <input class="form-input" type="tel" id="ct-phone" name="phone" maxlength="20" autocomplete="tel">
                            <div class="form-error" data-error-for="phone"></div>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="ct-interest">Interest</label>
                            <select class="form-select" id="ct-interest" name="interest">
                                <option value="">Select…</option>
${interestOptions}
                            </select>
                            <div class="form-error" data-error-for="interest"></div>
                        </div>
                        <div class="form-field form-field--full">
                            <label class="form-label" for="ct-message">Message <span class="req">*</span></label>
                            <textarea class="form-textarea" id="ct-message" name="message" required minlength="10" maxlength="2000" rows="6" placeholder="Tell us a little about your question or project."></textarea>
                            <div class="form-error" data-error-for="message"></div>
                        </div>
                    </div>
                    <div style="margin-top:1rem; display:flex; flex-direction:column; gap:0.75rem;">
                        <button type="submit" class="btn btn--primary btn--lg btn--block">
                            <span data-submit-label>Send Enquiry</span>
                            <svg data-submit-spinner hidden width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12a9 9 0 1 1-6.219-8.56" style="animation: spin 1s linear infinite"/></svg>
                        </button>
                        <p style="font-size:0.75rem; color:var(--fg-muted); text-align:center;">This form requires a backend. Deploy to Hostinger for full functionality, or connect a Formspree form ID.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="contact-faq" id="faq" data-reveal>
    <div class="container">
        <div class="contact-faq__head">
            <span class="section-heading__eyebrow">Quick answers</span>
            <h2 class="contact-faq__title">Frequently asked questions.</h2>
            <p class="section-heading__desc">A short list of questions the supplied product information can answer.</p>
        </div>
        <div class="faq-list contact-faq__list" data-reveal-stagger>
${faqItems}
        </div>
        <div style="text-align:center; margin-top:2rem;" data-reveal>
            <a href="${relUrl('/downloads/', depth)}" class="btn btn--outline btn--lg">See the brochure</a>
        </div>
    </div>
</section>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
`;
}

// ---- 404 page ----
function error404Body(depth) {
    return `<style>
  .error-page { min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding-block: clamp(3rem, 8vw, 6rem); padding-top: calc(var(--header-h) + 3rem); position: relative; overflow: hidden; }
  .error-page__bg { position: absolute; right: -2rem; top: 50%; transform: translateY(-50%); width: 18rem; height: 18rem; opacity: 0.12; pointer-events: none; color: var(--primary); }
  .error-page__inner { position: relative; z-index: 1; max-width: 40rem; }
  .error-page__seal { width: 4rem; height: 4rem; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; }
  .error-page__code { font-family: var(--font-display); font-size: clamp(3rem, 10vw, 5.5rem); font-weight: 700; color: var(--primary); line-height: 1; letter-spacing: -0.02em; }
  .error-page__msg { font-family: var(--font-display); font-size: clamp(1.25rem, 3vw, 1.875rem); margin-top: 1rem; color: var(--fg); line-height: 1.3; text-wrap: balance; }
  .error-page__sub { margin-top: 1rem; font-size: 0.9375rem; color: var(--fg-muted); line-height: 1.6; }
  .error-page__actions { margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; justify-content: center; }
  @media (min-width: 480px) { .error-page__actions { flex-direction: row; align-items: center; justify-content: center; } }
  .error-page__stroke { margin: 2rem auto 0; max-width: 16rem; }
  .error-page__deva { font-family: var(--font-deva); font-weight: 700; font-size: clamp(1.25rem, 3vw, 1.75rem); color: var(--haldi-deep); margin-top: 1.5rem; }
</style>

<section class="error-page" id="error-404">
    <div class="error-page__bg" aria-hidden="true">${loadSvg('field-botanicals')}</div>
    <div class="container error-page__inner" data-reveal>
        <div class="error-page__seal" aria-hidden="true">${loadSvg('gaurikrit-cow-mark')}</div>
        <div class="error-page__code">404</div>
        <h1 class="error-page__msg">This wall hasn't been painted yet.</h1>
        <p class="error-page__sub">The page you were looking for doesn't exist — or hasn't been built yet. Let's get you back to a painted wall.</p>
        <div class="error-page__actions">
            <a href="${relUrl('/', depth)}" class="btn btn--primary btn--lg">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Back to home
            </a>
            <a href="${relUrl('/products/', depth)}" class="btn btn--outline btn--lg">Explore Prakritik Paint</a>
        </div>
        <div class="error-page__deva" lang="hi">${e(COMPANY.devanagari)}</div>
        <div class="error-page__stroke" aria-hidden="true">${loadSvg('paint-brush-stroke')}</div>
    </div>
</section>
`;
}

// ============================================================
// 5. BUILD ORCHESTRATION
// ============================================================

// Each entry defines:
//   - route: file path under docs/ to write the generated HTML to.
//   - depth: number of directory levels below docs/ (used for rel-path prefix).
//   - pageMeta: {title, description, canonical, pageClass}
//   - body: function (depth) => string
const PAGES = [
    {
        route: 'index.html',
        depth: 0,
        pageMeta: {
            title: 'Gaurikrit Bio Products — Prakritik Paint & Bio Products',
            description:
                'Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls. Gaurikrit Bio Products, Khurja, District Bulandshahr, Uttar Pradesh.',
            canonical: '/',
            pageClass: 'home',
        },
        body: homeBody,
    },
    {
        route: 'products/index.html',
        depth: 1,
        pageMeta: {
            title: 'Prakritik Paint — Distemper & Emulsion — Gaurikrit Bio Products',
            description:
                'Prakritik Paint from Gaurikrit — cow dung-based paint in Distemper and Emulsion formats for interior and exterior walls. Specifications, packaging and coverage.',
            canonical: '/products/',
            pageClass: 'products-overview',
        },
        body: productsBody,
    },
    {
        route: 'products/prakritik-distemper/index.html',
        depth: 2,
        pageMeta: {
            title: 'Prakritik Distemper Paint — Gaurikrit Bio Products',
            description:
                'Prakritik Distemper Paint — eco-friendly cow dung paint. White, matt finish, 4 hrs drying time, 200 sq.ft. coverage, interior and exterior use. 1, 5, 10 and 20 kg packaging.',
            canonical: '/products/prakritik-distemper/',
            pageClass: 'product-distemper',
        },
        body: distemperBody,
    },
    {
        route: 'products/prakritik-emulsion/index.html',
        depth: 2,
        pageMeta: {
            title: 'Prakritik Emulsion Paint — Gaurikrit Bio Products',
            description:
                'Prakritik Emulsion Paint — eco-friendly cow dung paint. White, matt finish, 4 hrs drying time, 300 sq.ft. coverage, interior and exterior use. 1, 4, 10 and 20 litre packaging.',
            canonical: '/products/prakritik-emulsion/',
            pageClass: 'product-emulsion',
        },
        body: emulsionBody,
    },
    {
        route: 'why-prakritik/index.html',
        depth: 1,
        pageMeta: {
            title: 'Why Prakritik Paint — Gaurikrit Bio Products',
            description:
                'Why Prakritik Paint — an old Indian material idea, reconsidered for modern walls. Cow dung-based paint from Gaurikrit Bio Products.',
            canonical: '/why-prakritik/',
            pageClass: 'why-prakritik',
        },
        body: whyPrakritikBody,
    },
    {
        route: 'about/index.html',
        depth: 1,
        pageMeta: {
            title: 'About — Gaurikrit Bio Products',
            description:
                'Gaurikrit Bio Products (OPC) Private Limited — based in Khurja, District Bulandshahr, Uttar Pradesh. Presenting cow dung-based Prakritik Paint in Distemper and Emulsion formats.',
            canonical: '/about/',
            pageClass: 'about',
        },
        body: aboutBody,
    },
    {
        route: 'for-business/index.html',
        depth: 1,
        pageMeta: {
            title: 'For Business — Gaurikrit Bio Products',
            description:
                'Talk to Gaurikrit about project, bulk and collaboration requirements for Prakritik Paint. Architects, builders, institutions, CSR, NGOs and gaushalas.',
            canonical: '/for-business/',
            pageClass: 'for-business',
        },
        body: forBusinessBody,
    },
    {
        route: 'paint-calculator/index.html',
        depth: 1,
        pageMeta: {
            title: 'Painting Budget Calculator — Gaurikrit Bio Products',
            description:
                'Estimate your Prakritik Paint project. Pick painting type, location, paint format and wall area. An indicative project estimate from Gaurikrit Bio Products.',
            canonical: '/paint-calculator/',
            pageClass: 'paint-calculator',
        },
        body: paintCalculatorBody,
    },
    {
        route: 'downloads/index.html',
        depth: 1,
        pageMeta: {
            title: 'Product Documents — Gaurikrit Bio Products',
            description:
                'Prakritik Paint Brochure — product information for Prakritik Distemper and Prakritik Emulsion. Download or contact Gaurikrit for the current brochure.',
            canonical: '/downloads/',
            pageClass: 'downloads',
        },
        body: downloadsBody,
    },
    {
        route: 'contact/index.html',
        depth: 1,
        pageMeta: {
            title: 'Contact — Gaurikrit Bio Products',
            description:
                'Talk to Gaurikrit. Send an enquiry about Prakritik Paint products, projects or partnerships. Based in Khurja, District Bulandshahr, Uttar Pradesh.',
            canonical: '/contact/',
            pageClass: 'contact',
        },
        body: contactBody,
    },
];

function build() {
    console.log('STATIC-BUILD: starting static site generation for GitHub Pages.');
    console.log('STATIC-BUILD: source = ' + SRC);
    console.log('STATIC-BUILD: output = ' + OUT);

    // Clean & recreate the output directory.
    if (existsSync(OUT)) {
        rmSync(OUT, { recursive: true, force: true });
    }
    mkdirSync(OUT, { recursive: true });

    // Generate the 10 main pages.
    let generated = 0;
    for (const page of PAGES) {
        const body = page.body(page.depth);
        const html = generatePage(page.pageMeta, page.depth, body);
        const fullPath = join(OUT, page.route);
        mkdirSync(dirname(fullPath), { recursive: true });
        writeFileSync(fullPath, html, 'utf8');
        console.log('STATIC-BUILD: wrote ' + page.route + ' (' + html.length + ' bytes)');
        generated++;
    }

    // Generate 404.html at the docs root.
    const err404Body = error404Body(0);
    const err404Meta = {
        title: 'Page not found — ' + COMPANY.name + ' Bio Products',
        description: "This wall hasn't been painted yet. Return to the Gaurikrit homepage.",
        canonical: '/404',
        pageClass: 'error-404',
    };
    const err404Html = generatePage(err404Meta, 0, err404Body);
    writeFileSync(join(OUT, '404.html'), err404Html, 'utf8');
    console.log('STATIC-BUILD: wrote 404.html (' + err404Html.length + ' bytes)');
    generated++;

    // Copy static assets: CSS + JS (the SVG illustrations are inlined
    // directly in the HTML, so no need to copy the PHP partials).
    const cssSrc = join(SRC, 'assets/css/app.css');
    const cssDestDir = join(OUT, 'assets/css');
    mkdirSync(cssDestDir, { recursive: true });
    copyFileSync(cssSrc, join(cssDestDir, 'app.css'));
    console.log('STATIC-BUILD: copied assets/css/app.css');

    const jsSrcDir = join(SRC, 'assets/js');
    const jsDestDir = join(OUT, 'assets/js');
    mkdirSync(jsDestDir, { recursive: true });
    const jsFiles = readdirSync(jsSrcDir).filter((f) => f.endsWith('.js'));
    for (const f of jsFiles) {
        copyFileSync(join(jsSrcDir, f), join(jsDestDir, f));
        console.log('STATIC-BUILD: copied assets/js/' + f);
    }

    // .nojekyll — tells GitHub Pages NOT to process the site with Jekyll
    // (Jekyll ignores folders starting with `_` and would skip assets).
    writeFileSync(join(OUT, '.nojekyll'), '', 'utf8');
    console.log('STATIC-BUILD: wrote .nojekyll');

    // robots.txt + sitemap.xml for SEO. Use relative-friendly paths
    // (absolute URLs that point at the GitHub Pages deployment).
    writeFileSync(
        join(OUT, 'robots.txt'),
        `User-agent: *\nAllow: /\nSitemap: ${SITE_URL}/sitemap.xml\n`,
        'utf8',
    );
    console.log('STATIC-BUILD: wrote robots.txt');

    const sitemapUrls = ['', 'products/', 'products/prakritik-distemper/', 'products/prakritik-emulsion/',
        'why-prakritik/', 'about/', 'for-business/', 'paint-calculator/', 'downloads/', 'contact/'];
    const today = new Date().toISOString().slice(0, 10);
    const sitemapXml = `<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n${sitemapUrls
        .map((u) => `  <url><loc>${SITE_URL}/${u}</loc><lastmod>${today}</lastmod><changefreq>monthly</changefreq><priority>0.7</priority></url>`)
        .join('\n')}\n</urlset>\n`;
    writeFileSync(join(OUT, 'sitemap.xml'), sitemapXml, 'utf8');
    console.log('STATIC-BUILD: wrote sitemap.xml');

    console.log('STATIC-BUILD: done — ' + generated + ' HTML files generated.');
}

build();
