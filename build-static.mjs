/**
 * Gaurikrit Bio Products — Static HTML build script for GitHub Pages.
 *
 * Task ID: V5-FINISH
 *
 * Reads the PHP source in /home/z/my-project/dist-hostinger/ and produces
 * a static HTML site in /home/z/my-project/docs/ that can be deployed to
 * GitHub Pages (served from a subdirectory, so all paths are relative).
 *
 * Mirrors the V5 page compositions: REAL client photography + high-quality
 * editorial artwork via `<picture>` tags (WebP source + JPEG fallback) with
 * correct intrinsic width/height on every `<img>`. Coded SVG illustrations
 * are kept ONLY for interactive elements (ashta-laabh-seal,
 * calculator-wall-scene) and the brand-mark fallback (gaurikrit-cow-mark)
 * and the 404 page decorative accent (field-botanicals) + the V5 inline
 * calc-teaser wall-with-dimension-lines SVG.
 *
 * V10 asset policy (supersedes V5):
 *   - zebu-study           → RETIRED from all pages (decorative cow
 *     illustration removed per art-direction pass; files kept on disk).
 *   - raw-material-study   → NEW in V10 (1344×768) — natural material
 *     texture. Home material statement + material step 01 + Why 01.
 *   - finished-surface-study → NEW in V10 (1344×768) — finished wall
 *     surface. Home material step 03 + Why 03.
 *   - interior-finish-study → NEW in V10 (1344×768) — Distemper chapter /
 *     detail plate wall-finish strip.
 *   - exterior-finish-study → NEW in V10 (1344×768) — Emulsion chapter /
 *     detail plate wall-finish strip.
 *   - colour-wall-study    → NEW in V10 (1344×768) — purpose-built wall
 *     elevation for the Colours of India SVG paint mask.
 *   - rural-landscape      → rural-landscape.webp/.jpg (1344×768)
 *   - architectural-elevation → REPLACED by business-context-study.webp/.jpg
 *     (1344×768) on For Business hero. architectural-elevation files are
 *     still copied to docs/assets/editorial/ for backward compatibility but
 *     are NOT referenced anywhere in V5.
 *   - interior-wall-study  → interior-wall-study.webp/.jpg (1344×768)
 *     (detail hero + calculator scene + about hero)
 *   - exterior-wall-study  → REPLACED by exterior-wall-study-v2.webp/.jpg
 *     (1344×768) (Emulsion detail hero). exterior-wall-study files are
 *     still copied to docs/assets/editorial/ for backward compatibility.
 *   - finished-wall-study  → V5 (1344×768) — retired from Home/Why step
 *     cards in V10 (replaced by finished-surface-study); file kept.
 *   - business-context-study → NEW in V5 (1344×768) — used on Home
 *     pathways, Why Prakritik Section 06 context, For Business hero.
 *   - prakritik-distemper-bucket → real product photo prakritik-distemper.jpg (490×621, complete bucket)
 *   - prakritik-emulsion-bucket  → real product photo prakritik-emulsion.jpg (450×621, complete bucket)
 *   - ashta-laabh-seal           → SVG KEPT (interactive radial seal)
 *   - calculator-wall-scene      → SVG KEPT (interactive wall scene, with photo bg)
 *   - gaurikrit-cow-mark          → SVG KEPT (logo fallback in header/footer + 404)
 *   - field-botanicals           → SVG KEPT (small 404 decorative accent)
 *   - calc-teaser wall SVG       → V5 inline SVG (wall + dimension lines)
 *
 * Static-specific adjustments:
 *   - Forms use mailto: placeholder action (no CSRF, no honeypot).
 *   - Calculator config: inline {"enabled":false} JSON.
 *   - Brochure: JS HEAD-fetch detection module (data-brochure-state="unknown"
 *     initially; both data-brochure-if-available and data-brochure-if-missing
 *     divs present; CSS shows available by default, swaps on missing state).
 *   - V5 paint-calculator: calc-helper hidden by default; an inline script
 *     watches [data-calc-result] for `hidden` removal and toggles .is-shown
 *     on the helper so the post-result CTA appears only after 4 steps are
 *     complete.
 *
 * Run with: `bun run build-static.mjs`
 */

import { readFileSync, writeFileSync, mkdirSync, copyFileSync, existsSync, readdirSync, rmSync, cpSync } from 'fs';
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
        officialImage: '/assets/products/prakritik-distemper.jpg',
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
        officialImage: '/assets/products/prakritik-emulsion.jpg',
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

// Map Ashta Laabh names to ashta-laabh-seal SVG node IDs (so the seal
// reacts when the corresponding list row is hovered/active).
const ASHTA_IDS = {
    'Antibacterial': 'antibacterial',
    'Antifungal': 'antifungal',
    'Eco-Friendly': 'eco-friendly',
    'Natural Thermal Insulator': 'thermal-insulator',
    'Cost-Effective': 'cost-effective',
    'Free from Heavy Metals': 'heavy-metal-free',
    'Non-Toxic': 'non-toxic',
    'Odourless': 'odourless',
};

const COLOUR_STUDY = [
    { name: 'Haldi', hex: '#E3A51A', label: 'Turmeric' },
    { name: 'Mitti', hex: '#A86E4B', label: 'Earth' },
    { name: 'Neem', hex: '#748468', label: 'Leaf' },
    { name: 'Geru', hex: '#B65432', label: 'Ochre' },
    { name: 'Indigo', hex: '#365B67', label: 'Indigo' },
    { name: 'Chuna', hex: '#F4EFE2', label: 'Lime' },
];

const MATERIAL_JOURNEY = [
    { num: '01', title: 'Natural material', desc: 'Cow dung is the material inspiration.' },
    { num: '02', title: 'Prakritik Paint', desc: 'Available as Distemper and Emulsion.' },
    { num: '03', title: 'Finished wall', desc: 'Both are listed for interior and exterior use.' },
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

/** HTML-escape a string for output (mirrors PHP e()). */
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
 *
 * V4: only used for ashta-laabh-seal, calculator-wall-scene,
 * gaurikrit-cow-mark, field-botanicals.
 */
function loadSvg(name, className = '') {
    const file = join(SRC, 'includes/illustrations', `${name}.php`);
    if (!existsSync(file)) return '';
    const raw = readFileSync(file, 'utf8');
    const closeIdx = raw.indexOf('?>');
    if (closeIdx === -1) return raw;
    let svg = raw.slice(closeIdx + 2);
    svg = svg.replace(/<\?=\s*htmlspecialchars\(\$class,\s*ENT_QUOTES\)\s*\?>/g, e(className));
    return svg.trim();
}

/**
 * Build a <picture> tag with WebP source + JPEG fallback for editorial
 * artwork. V4 standard image integration pattern.
 *
 *   pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
 *       'Raw lime-plastered wall surface', 1344, 768, depth,
 *       'class="editorial-image"')
 *
 * Default loading is "lazy" + decoding="async". For eager/above-the-fold
 * images, pass extra containing `loading="eager" fetchpriority="high"` —
 * the helper places extra BEFORE the default loading attribute so the
 * browser's first-attribute-wins rule applies the override.
 */
function pic(absWebpPath, absJpgPath, alt, w, h, depth, extra = '') {
    const webp = assetUrl(absWebpPath, depth);
    const jpg = assetUrl(absJpgPath, depth);
    return `<picture><source type="image/webp" srcset="${webp}"><img ${extra} src="${jpg}" alt="${e(alt)}" width="${w}" height="${h}" loading="lazy" decoding="async"></picture>`;
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

// ============================================================
// 3. HEADER + FOOTER (mirror includes/header.php and footer.php)
// ============================================================

function renderHeader(pageMeta, depth) {
    const title = e(pageMeta.title);
    const desc = e(pageMeta.description);
    const fullCanonical = SITE_URL.replace(/\/$/, '') + pageMeta.canonical;
    const socialSlug = ({'/':'home','/products/':'products',
        '/products/prakritik-distemper/':'distemper',
        '/products/prakritik-emulsion/':'emulsion',
        '/why-prakritik/':'why-prakritik','/about/':'about',
        '/for-business/':'for-business','/paint-calculator/':'calculator',
        '/downloads/':'downloads','/contact/':'contact'})[pageMeta.canonical] || 'home';
    const ogImage = SITE_URL.replace(/\/$/, '') + '/assets/social/og-' + socialSlug + '.jpg';
    const ogAlt = 'Gaurikrit — ' + pageMeta.title;

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
    const faviconHref = assetUrl('/favicon.ico', depth);
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
    <link rel="icon" href="${faviconHref}" sizes="any">
    <link rel="icon" href="${assetUrl('/favicon-32x32.png', depth)}" type="image/png" sizes="32x32">
    <link rel="icon" href="${assetUrl('/favicon-16x16.png', depth)}" type="image/png" sizes="16x16">
    <link rel="apple-touch-icon" href="${assetUrl('/apple-touch-icon.png', depth)}">
    <link rel="manifest" href="${assetUrl('/site.webmanifest', depth)}">
    <title>${title}</title>
    <meta name="description" content="${desc}">
    <link rel="canonical" href="${e(fullCanonical)}">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#173F2B">
    <meta property="og:title" content="${title}">
    <meta property="og:description" content="${desc}">
    <meta property="og:url" content="${e(fullCanonical)}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Gaurikrit Bio Products">
    <meta property="og:image" content="${e(ogImage)}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="${e(ogAlt)}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="${title}">
    <meta name="twitter:description" content="${desc}">
    <meta name="twitter:image" content="${e(ogImage)}">
    <meta name="twitter:image:alt" content="${e(ogAlt)}">
    <script type="application/ld+json">
${JSON.stringify(ld, null, 2)}
    </script>

    <!-- Fonts are served locally from assets/fonts. -->
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
      (loaded last) calls .init() on each.
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

/** Wrap a page body in a full HTML document. */
function generatePage(pageMeta, depth, bodyContent) {
    return renderHeader(pageMeta, depth) + bodyContent + renderFooter(depth);
}

// ============================================================
// 4. PAGE BODIES — one function per route.
//    Each function returns the inline <style> + section HTML as a
//    single string (mirrors the V4 PHP pages exactly).
// ============================================================

// ---- Homepage (index.html) — V4 ----
function homeBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const groupImage = '/assets/products/prakritik-group.jpg';
    const groupImg = assetUrl(groupImage, depth);

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = ASHTA_IDS[benefit.name] || `benefit-${i + 1}`;
        return `          <li class="ashta-benefit" data-ashta-node="${e(bid)}">
            <span class="ashta-benefit__num">${pad2(i + 1)}</span>
            <span class="ashta-benefit__name">${e(benefit.name)}</span>
            <span class="ashta-benefit__deva">${e(benefit.hindi)}</span>
          </li>`;
    }).join('\n');

    const swatches = COLOUR_STUDY.map(
        (sw) => `        <button type="button"
                class="colours-swatch"
                role="radio"
                aria-checked="false"
                style="background: ${e(sw.hex)};"
                data-shade="${e(sw.hex)}"
                data-shade-name="${e(sw.name)} (${e(sw.label)})"
                aria-label="${e(sw.name)} — ${e(sw.label)}">
          <span class="colours-swatch__label">${e(sw.name)}</span>
        </button>`,
    ).join('\n');

    const pathways = PROJECT_PATHWAYS.map(
        (p, i) => `        <div class="pathway">
          <span class="pathway__num">${pad2(i + 1)}</span>
          <h3 class="pathway__title">${e(p.title)}</h3>
          <p class="pathway__desc">${e(p.desc)}</p>
        </div>`,
    ).join('\n');

    // Picture tags (V10 — the zebu/courtyard editorial art is retired from
    // the home page; the material story now uses surface studies and the
    // colour study uses the purpose-built wall elevation).
    const rawMaterialMaterialPic = pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
        'Raw lime-plastered wall surface — an Indian natural wall material', 1344, 768, depth, 'class="editorial-image"');
    const ruralLandscapePic = pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');
    const interiorFinishStripPic = pic('/assets/editorial/interior-finish-study.webp', '/assets/editorial/interior-finish-study.jpg',
        '', 1344, 768, depth, 'class="chapter-strip"');
    const exteriorFinishStripPic = pic('/assets/editorial/exterior-finish-study.webp', '/assets/editorial/exterior-finish-study.jpg',
        '', 1344, 768, depth, 'class="chapter-strip"');
    const rawMaterialJourneyPic = pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
        'Raw lime-plastered wall surface — natural material', 1344, 768, depth, 'class="editorial-image"');
    const finishedSurfaceJourneyPic = pic('/assets/editorial/finished-surface-study.webp', '/assets/editorial/finished-surface-study.jpg',
        'Finished matte limewash wall surface', 1344, 768, depth, 'class="editorial-image"');
    const colourWallColoursPic = pic('/assets/editorial/colour-wall-study.webp', '/assets/editorial/colour-wall-study.jpg',
        'Indian lime-plastered wall elevation with door and window', 1344, 768, depth, 'class="colours-wall__art"');
    const ruralMissionPic = pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');
    // V5: pathways uses business-context-study (connects to homes/architects/institutions).
    const businessContextPathwaysPic = pic('/assets/editorial/business-context-study.webp', '/assets/editorial/business-context-study.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .editorial-image--contain { object-fit: contain; }

  /* ===== 1. HERO — group photo dominant + CSS haldi field + cow engraving ===== */
  .hero { padding-top: calc(var(--header-h) + 1.5rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) {
    .hero { display: flex; align-items: center;
            padding-top: calc(var(--header-h) + 2rem); padding-bottom: 2rem; }
  }
  .hero__grid { align-items: center; position: relative; }
  @media (min-width: 1200px) {
    .hero__grid { grid-template-columns: 5fr 7fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  @media (min-width: 900px) and (max-width: 1199px) {
    .hero__grid { grid-template-columns: 6fr 6fr; gap: clamp(1.5rem, 3vw, 3rem); }
  }
  @media (max-width: 899px) {
    .hero__grid { grid-template-columns: 1fr; }
    .hero__visual { order: 5; }
  }
  .hero__eyebrow-chip { margin-bottom: 0.875rem; }
  .hero__title { font-size: clamp(2.5rem, 6vw, 5.5rem); line-height: 1.02; }
  .hero__body { max-width: 38rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V7 hero visual: the real group photo deliberately placed inside a
     paper/material plate whose background visually merges with the page.
     No generic haldi semicircle, no faint cow engraving, no landscape band. */
  .hero__visual { position: relative; min-height: 0; width: 100%; }
  .hero__plate {
    position: relative; z-index: 2;
    background: var(--paper);
    border: 1px solid var(--border);
    border-top: 3px solid var(--haldi);
    border-radius: var(--r-panel);
    padding: clamp(1rem, 2.5vw, 2rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .hero__plate img.hero-group-photo {
    display: block;
    width: 100%; height: auto;
    object-fit: contain;
    aspect-ratio: 1280 / 621;
  }
  /* A restrained, irregular haldi paint field — reads as a painted wall
     sample (plaster swash), placed BEHIND the plate's bottom edge only. */
  .hero__paint-sample {
    position: absolute;
    left: -4%; right: 6%; bottom: -1.25rem;
    height: 34%;
    z-index: 0;
    pointer-events: none;
    border-radius: 46% 54% 48% 52% / 60% 54% 46% 40%;
    background:
      radial-gradient(ellipse 70% 62% at 50% 40%,
        color-mix(in srgb, var(--haldi) 26%, transparent) 0%,
        transparent 78%);
    opacity: 0.5;
  }
  @media (max-width: 899px) { .hero__paint-sample { display: none; } }

  /* ===== 2. MATERIAL STATEMENT — raw-material-study large right (58%) ===== */
  .material-statement__visual {
    aspect-ratio: 1344/768;
    background: var(--limewash);
    overflow: hidden;
    padding: 0;
    position: relative;
  }
  .material-statement__visual .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }

  /* ===== 3/4. PRODUCT CHAPTERS — catalogue plates. Structure lives in
     app.css §14 (white product stage + wall-finish strip); nothing
     page-local needed. ===== */

  /* ===== 5. MATERIAL JOURNEY — 3 equal step cards (structure in app.css
     §17 .material-step); page-local rhythm only. ===== */
  .material-flow { padding-block: clamp(3rem, 6vw, 5rem); }
  .material-flow__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 6. ASHTA LAABH — strengthened (V5): darker warm bg, larger seal,
     bolder benefit labels. SVG seal kept interactive. ===== */
  .ashta-section {
    position: relative; overflow: hidden;
    /* Slightly darker warm tone — overrides section--limewash. */
    background: color-mix(in srgb, var(--haldi) 10%, var(--limewash));
  }
  /* V7: the giant faded cow background is REMOVED — two clear layers only:
     seal + list. Slightly stronger warm ground for the seal to read dark. */
  .ashta-section { background: color-mix(in srgb, var(--haldi) 12%, var(--limewash)); }
  .ashta-section__inner { position: relative; z-index: 1; }
  .ashta-section__grid { position: relative; z-index: 1; }
  /* V5: enlarge seal from 38rem → 44rem for more authority. */
  .ashta-section__seal { max-width: 44rem; margin-inline: auto; }
  .ashta-benefit__num { font-feature-settings: "tnum"; }
  /* V5: bolder / larger benefit labels (page-local override). */
  .ashta-benefit__name {
    font-weight: 700 !important;
    font-size: 1.0625rem !important;
    letter-spacing: 0.005em;
  }
  .ashta-benefit__deva {
    font-size: 0.9375rem !important;
    color: color-mix(in srgb, var(--haldi-deep) 60%, var(--fg-muted)) !important;
  }
  .ashta-benefit {
    padding: 1.25rem 0 !important;
  }

  /* ===== 7. COLOURS OF INDIA — wall plane + SVG paint mask (structure in
     app.css §19: natural-aspect elevation photo + aligned mask path);
     page-local: label typography + swatch row only. ===== */
  .colours-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .colours-wall__label {
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
    z-index: 2;
  }
  .colours-wall__label small {
    display: block; font-family: var(--font-sans); font-size: 0.625rem;
    font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--fg-muted); margin-top: 0.125rem;
  }
  .colours-swatches {
    display: flex; flex-wrap: wrap; gap: 1.5rem 1.75rem;
    margin-top: 2.5rem; justify-content: flex-start;
  }
  .colours-swatch {
    width: 2.75rem; height: 2.75rem; border-radius: 50%;
    border: 2px solid var(--border); padding: 0; cursor: pointer;
    position: relative; transition: transform var(--dur), border-color var(--dur);
  }
  .colours-swatch:hover { transform: translateY(-2px); }
  .colours-swatch[data-active="true"] {
    border-color: var(--forest); transform: translateY(-2px);
  }
  .colours-swatch__label {
    position: absolute; top: calc(100% + 0.5rem); left: 50%;
    transform: translateX(-50%); white-space: nowrap;
    font-size: 0.6875rem; font-weight: 600; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }

  /* ===== 8. MISSION — forest band with rural-landscape engraving ===== */
  .mission-band {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .mission-band__bg {
    position: absolute; inset: 0; opacity: 0.15; pointer-events: none;
    overflow: hidden;
  }
  .mission-band__bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  .mission-band__inner {
    position: relative; z-index: 1; max-width: 48rem;
  }
  .mission-band__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--haldi);
  }
  .mission-band__title {
    margin-top: 0.875rem; font-family: var(--font-display); font-style: italic;
    font-size: clamp(1.75rem, 4vw, 3.25rem); line-height: 1.15;
    letter-spacing: -0.01em; color: var(--paper); text-wrap: balance;
  }
  .mission-band__sub {
    margin-top: 1.5rem; font-size: 1rem; line-height: 1.7;
    color: rgba(250, 248, 241, 0.78); max-width: 60ch;
  }
  .mission-band__cta { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* ===== 9. CALCULATOR TEASER (V7: a miniature of the actual calculator
     UI — 'this is an interactive estimator', not a W × H poster) ===== */
  .calc-teaser { padding-block: clamp(3.5rem, 6vw, 5.5rem); }
  .calc-teaser__art {
    position: relative;
    background: var(--paper);
    /* V9 fix: reset the legacy app.css .calc-teaser__art (flex + 4/3 aspect
       meant for the old single-artwork composition). The V7 mini-calculator
       sheet is a header + four stacked rows — block flow, content height. */
    display: block;
    aspect-ratio: auto;
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    overflow: hidden;
    padding: clamp(1.25rem, 2vw, 1.75rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .calc-teaser__sheet-head {
    display: flex; align-items: baseline; justify-content: space-between;
    gap: 1rem; padding-bottom: 0.875rem; margin-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
  }
  .calc-teaser__sheet-title {
    font-family: var(--font-display); font-size: 1.125rem; font-weight: 700;
    color: var(--primary);
  }
  .calc-teaser__sheet-tag {
    font-size: 0.625rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .calc-teaser__step {
    display: grid; grid-template-columns: 2.25rem 1fr auto; gap: 0.875rem;
    align-items: center;
    padding: 0.875rem 0;
    border-bottom: 1px dashed var(--border);
  }
  .calc-teaser__step:last-child { border-bottom: 0; }
  .calc-teaser__step-num {
    width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    background: color-mix(in srgb, var(--haldi) 22%, transparent);
    border: 1px solid var(--forest);
    font-size: 0.75rem; font-weight: 700; color: var(--forest);
  }
  .calc-teaser__step-label {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .calc-teaser__step-value {
    font-family: var(--font-display); font-size: 0.9375rem; font-weight: 700;
    color: var(--primary); text-align: right;
  }

  /* ===== 10. PROJECT PATHWAYS (V7: audiences are the design — no generic
     suburban house artwork) ===== */
  .pathways-section { padding-block: clamp(3rem, 6vw, 5rem); }
</style>

<!-- ============================================================
     1. HERO — 12-col (text 5 / visual 7), dominant group photo
     ============================================================ -->
<section class="hero bg-limewash" aria-labelledby="hero-title">
  <div class="container">
    <div class="hero__grid">
      <div class="hero__lockup">
        <span class="hero__eyebrow-chip">
          <span class="hero__eyebrow-dot" aria-hidden="true"></span>
          GAURIKRIT BIO PRODUCTS
        </span>
        <span class="hero__devanagari" aria-hidden="true">${e(COMPANY.devanagari)}</span>
        <h1 class="hero__title" id="hero-title">${e(COMPANY.headline)}</h1>
        <p class="hero__body">
          Cow dung-based Prakritik Paint in Distemper and Emulsion formats for interior and exterior walls.
        </p>
        <div class="hero__ctas">
          <a class="btn btn--primary btn--lg" href="${relUrl('/products/', depth)}">Explore Prakritik Paint</a>
          <a class="btn btn--secondary btn--lg" href="${relUrl('/why-prakritik/', depth)}">Why Prakritik?</a>
        </div>
      </div>

      <div class="hero__visual" data-reveal>
        <div class="hero__paint-sample" aria-hidden="true"></div>
        <div class="hero__plate">
          <img class="hero-group-photo"
               src="${assetUrl(groupImage, depth)}"
               alt="Prakritik Distemper and Emulsion paint packs"
               width="1280" height="621"
               loading="eager" fetchpriority="high" decoding="async">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. MATERIAL STATEMENT — copy 42 / raw-material-study 58
     ============================================================ -->
<section class="section section--paper" aria-labelledby="material-title">
  <div class="container">
    <div class="material-statement" data-reveal style="grid-template-columns: 42fr 58fr;">
      <div class="material-statement__copy">
        <span class="material-statement__eyebrow">An old Indian material idea</span>
        <h2 class="material-statement__headline" id="material-title">
          An old Indian material idea, reconsidered for modern walls.
        </h2>
        <hr class="material-statement__rule">
        <div class="material-statement__body">
          <p>
            Traditional Indian homes have long used cow-dung-based coatings on
            walls and floors. Prakritik Paint brings that material idea into
            contemporary Distemper and Emulsion formats.
          </p>
          <p>
            Both formats are listed for interior and exterior use.
          </p>
        </div>
      </div>
      <div class="material-statement__visual">
        ${rawMaterialMaterialPic}
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. DISTEMPER PRODUCT CHAPTER (cool section, indigo accent)
     Catalogue plate: complete pack photo + interior-finish strip.
     ============================================================ -->
<section class="product-chapter product-chapter--distemper" aria-labelledby="distemper-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <img class="chapter-product chapter-product--distemper"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="${e(distemper.name)} paint pack"
               width="490" height="621"
               loading="lazy" decoding="async">
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          ${interiorFinishStripPic}
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 01 — Distemper</span>
        <h3 class="product-chapter__name" id="distemper-chapter-title">
          ${e(distemper.name)}
        </h3>
        <p class="product-chapter__desc">
          ${e(distemper.descriptor)}. A paint listed for interior
          and exterior walls. Supplied in ${e(distemper.packagingShort)} packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row">
            <dt>Finish</dt><dd>${e(distemper.finish)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>Drying time</dt><dd>${e(distemper.dryingTime)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>Coverage</dt><dd>${e(distemper.coverage)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>V.O.C.</dt><dd>${e(distemper.voc)}</dd>
          </div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="${relUrl(distemper.route, depth)}">View Distemper</a>
          <a class="btn btn--outline" href="${relUrl('/contact/', depth)}?interest=prakritik-distemper">Enquire About Distemper</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     4. EMULSION PRODUCT CHAPTER (warm section, leaf accent, reversed)
     Catalogue plate: complete pack photo + exterior-finish strip.
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <img class="chapter-product chapter-product--emulsion"
               src="${assetUrl(emulsion.officialImage, depth)}"
               alt="${e(emulsion.name)} paint pack"
               width="450" height="621"
               loading="lazy" decoding="async">
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          ${exteriorFinishStripPic}
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 02 — Emulsion</span>
        <h3 class="product-chapter__name" id="emulsion-chapter-title">
          ${e(emulsion.name)}
        </h3>
        <p class="product-chapter__desc">
          ${e(emulsion.descriptor)}. A paint listed for interior
          and exterior walls. Supplied in ${e(emulsion.packagingShort)} packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row">
            <dt>Finish</dt><dd>${e(emulsion.finish)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>Drying time</dt><dd>${e(emulsion.dryingTime)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>Coverage</dt><dd>${e(emulsion.coverage)}</dd>
          </div>
          <div class="duo-panel__row">
            <dt>V.O.C.</dt><dd>${e(emulsion.voc)}</dd>
          </div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="${relUrl(emulsion.route, depth)}">View Emulsion</a>
          <a class="btn btn--outline" href="${relUrl('/contact/', depth)}?interest=prakritik-emulsion">Enquire About Emulsion</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     5. MATERIAL JOURNEY — three equal step cards
     ============================================================ -->
<section class="section section--limewash material-flow" aria-labelledby="journey-title">
  <div class="container">
    <div class="material-flow__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Material to wall</span>
      <h2 class="section-heading__title" id="journey-title">From a natural material to a finished wall.</h2>
      <p class="section-heading__desc">
        The raw material, the paint made from it, and the finished surface —
        three steps, one material idea.
      </p>
    </div>
    <div class="material-steps" data-reveal>
      <article class="material-step">
        <figure class="material-step__figure">
          ${rawMaterialJourneyPic}
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">01</span>
          <h3 class="material-step__title">Natural material</h3>
          <p class="material-step__desc">Cow dung is the material inspiration.</p>
        </div>
      </article>
      <article class="material-step material-step--product">
        <figure class="material-step__figure">
          <img class="material-step__product"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="Prakritik Distemper paint pack"
               width="490" height="621"
               loading="lazy" decoding="async">
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">02</span>
          <h3 class="material-step__title">Prakritik Paint</h3>
          <p class="material-step__desc">Available as Distemper and Emulsion.</p>
        </div>
      </article>
      <article class="material-step">
        <figure class="material-step__figure">
          ${finishedSurfaceJourneyPic}
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">03</span>
          <h3 class="material-step__title">Finished wall</h3>
          <p class="material-step__desc">Both are listed for interior and exterior use.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     6. ASHTA LAABH — interactive SVG seal + benefit list
     ============================================================ -->
<section class="section ashta-section section--limewash" aria-labelledby="ashta-title" data-ashta-laabh>
  <div class="container ashta-section__inner">
    <div class="ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="ashta-section__deva">अष्ट लाभ</span>
      <h2 class="section-heading__title" id="ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="ashta-section__sub">
        Eight benefits listed in the supplied Prakritik Paint material.
      </p>
      <p class="ashta-section__note">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>
    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        ${loadSvg('ashta-laabh-seal')}
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
${ashtaItems}
      </ol>
    </div>
  </div>
</section>

<!-- ============================================================
     7. COLOURS OF INDIA — wall-plane colour preview (SVG paint mask)
     The mask path traces ONLY the wall plane of the elevation photo
     (1344x768 pixel space); the door and window are cut out with
     fill-rule evenodd so they never recolour. preserveAspectRatio
     "xMidYMid slice" keeps the mask aligned with object-fit: cover.
     ============================================================ -->
<section class="section section--paper colour-study colours-section" aria-labelledby="colours-title" data-colour-study>
  <div class="container">
    <div class="colours-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Editorial colour study</span>
      <h2 class="colours-section__title" id="colours-title">Colours of India.</h2>
      <p class="colours-section__sub">
        Tap a swatch to preview the colour on the wall — only the wall plane
        changes; the door, window and surroundings stay as they are. These are
        editorial design moods — not currently available product shades.
      </p>
    </div>

    <div class="colours-wall" data-colour-wall data-reveal>
      ${colourWallColoursPic}
      <svg class="colours-wall__tint" viewBox="0 0 1344 768"
           preserveAspectRatio="xMidYMid slice" aria-hidden="true" focusable="false">
        <path class="colours-wall__paint" fill-rule="evenodd"
              d="M0,104 H1344 V724 H0 Z
                 M80,370 H304 V768 H80 Z
                 M894,346 H1180 V654 H894 Z" />
      </svg>
      <span class="colours-wall__label">
        <span data-colour-label>Limewash</span>
        <small>Editorial colour study</small>
      </span>
    </div>

    <div class="colours-swatches" data-reveal-stagger role="radiogroup" aria-label="Wall colour swatches">
${swatches}
    </div>
  </div>
</section>

<!-- ============================================================
     8. MISSION — deep forest band with rural-landscape engraving
     ============================================================ -->
<section class="mission-band" aria-labelledby="mission-title">
  <div class="mission-band__bg" aria-hidden="true">
    ${ruralMissionPic}
  </div>
  <div class="container">
    <div class="mission-band__inner" data-reveal>
      <span class="mission-band__eyebrow">Our direction</span>
      <h2 class="mission-band__title" id="mission-title">
        ${e(COMPANY.mission)}
      </h2>
      <p class="mission-band__sub">
        ${e(COMPANY.legalName)} — ${e(COMPANY.brandLine)}
      </p>
      <div class="mission-band__cta">
        <a class="btn btn--haldi" href="${relUrl('/about/', depth)}">About Gaurikrit</a>
        <a class="btn btn--secondary" href="${relUrl('/why-prakritik/', depth)}">Why Prakritik</a>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     9. CALCULATOR TEASER — mini project-summary + wall elevation
     ============================================================ -->
<section class="section section--limewash calc-teaser" aria-labelledby="calc-teaser-title">
  <div class="container">
    <div class="calc-teaser__inner" data-reveal>
      <div>
        <span class="calc-teaser__eyebrow">Planning to paint?</span>
        <h2 class="calc-teaser__heading" id="calc-teaser-title">Estimate your project.</h2>
        <p class="calc-teaser__body">
          Walk through four quick choices — what you are painting, where, which
          Prakritik format, and the wall area. We summarise the project for you to
          send to Gaurikrit to discuss your project.
        </p>
        <div class="calc-teaser__cta">
          <a class="btn btn--primary btn--lg" href="${relUrl('/paint-calculator/', depth)}">Open Painting Calculator</a>
        </div>
      </div>
      <div class="calc-teaser__art" aria-hidden="true">
        <div class="calc-teaser__sheet-head">
          <span class="calc-teaser__sheet-title">Your project</span>
          <span class="calc-teaser__sheet-tag">4 steps</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">01</span>
          <span class="calc-teaser__step-label">Painting type</span>
          <span class="calc-teaser__step-value">Fresh / Repaint</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">02</span>
          <span class="calc-teaser__step-label">Location</span>
          <span class="calc-teaser__step-value">Interior / Exterior</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">03</span>
          <span class="calc-teaser__step-label">Paint</span>
          <span class="calc-teaser__step-value">Distemper / Emulsion</span>
        </div>
        <div class="calc-teaser__step">
          <span class="calc-teaser__step-num">04</span>
          <span class="calc-teaser__step-label">Wall area</span>
          <span class="calc-teaser__step-value">sq.ft.</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     10. PROJECT PATHWAYS — V5: business-context-study shared + 4 ruled columns
     ============================================================ -->
<section class="section section--paper pathways-section" aria-labelledby="pathways-title">
  <div class="container">
    <div class="pathways-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Project pathways</span>
      <h2 class="pathways-section__title" id="pathways-title">Who is Prakritik Paint for?</h2>
    </div>

    <div class="pathways" data-reveal-stagger>
${pathways}
    </div>

    <div class="pathways-foot">
      <a class="btn btn--secondary" href="${relUrl('/for-business/', depth)}">Talk to Gaurikrit</a>
    </div>
  </div>
</section>

<!-- Inline bridge: copy the seal SVG node data-benefit → data-ashta-node
     so ashta-laabh.js can drive the seal's active state. -->
<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
`;
}

// ---- Products Overview (products/index.html) — V4 ----
function productsBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const groupImage = '/assets/products/prakritik-group.jpg';
    const groupImg = assetUrl(groupImage, depth);

    const benefitsItems = ASHTA_LAABH.map(
        (benefit) => `        <li class="benefits-strip__item">
          <span class="benefits-strip__num" aria-hidden="true">
            <span class="benefits-strip__dot"></span>
          </span>
          <span>
            <span class="benefits-strip__name">${e(benefit.name)}</span>
            <span class="benefits-strip__deva">${e(benefit.hindi)}</span>
          </span>
        </li>`,
    ).join('\n');

    const faqItems = FAQ.map(
        (item) => `        <div class="faq-item">
          <button type="button" class="faq-item__q" aria-expanded="false">
            <span>${e(item.q)}</span>
            <svg class="faq-item__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="faq-item__a">
            <div class="faq-item__a-inner">${item.a}</div>
          </div>
        </div>`,
    ).join('\n');

    // V10 picture tags for the catalogue-plate wall-finish strips.
    const interiorFinishStripPic = pic('/assets/editorial/interior-finish-study.webp', '/assets/editorial/interior-finish-study.jpg',
        '', 1344, 768, depth, 'class="chapter-strip"');
    const exteriorFinishStripPic = pic('/assets/editorial/exterior-finish-study.webp', '/assets/editorial/exterior-finish-study.jpg',
        '', 1344, 768, depth, 'class="chapter-strip"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== 1. PRODUCTS HERO (45 / 55) — real group photo, no empty beige ===== */
  .products-hero {
    padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 1.5rem;
  }
  .products-hero__grid {
    display: grid; gap: 2.5rem; align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) {
    .products-hero__grid { grid-template-columns: 45fr 55fr; gap: clamp(2rem, 4vw, 4rem); }
  }
  .products-hero__lockup { max-width: 42rem; }
  .products-hero__visual {
    position: relative; min-height: 22rem; width: 100%;
    background: transparent; border-radius: 0;
    overflow: hidden; display: flex; align-items: center; justify-content: center;
    padding: 0;
  }
  @media (min-width: 768px) { .products-hero__visual { min-height: 28rem; } }
  @media (min-width: 1024px) { .products-hero__visual { min-height: 32rem; } }
  .products-hero__visual .hero-group-photo {
    display: block;
    width: 100%; height: 100%;
    object-fit: contain;
  }

  /* ===== 2/3. PRODUCT CHAPTERS — catalogue plates (structure in
     app.css §14: white product stage + wall-finish strip); nothing
     page-local needed. ===== */

  /* ===== SPEC MATRIX (V5: header row + zebra striping + taller rows
     + bolder labels — a real product comparison, not a sparse list) ===== */
  .spec-matrix-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-matrix-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  /* V5: wrap the matrix in a soft paper panel so the striping reads. */
  .spec-matrix {
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    overflow: hidden;
    background: var(--paper);
  }
  .spec-matrix__row {
    grid-template-columns: 1fr; gap: 0.75rem;
    padding: 1.75rem 1.25rem;  /* V5: taller, more padding */
    border-bottom: 1px solid var(--border);
  }
  @media (min-width: 768px) {
    .spec-matrix__row {
      grid-template-columns: 12rem 1fr 1fr; gap: 1.5rem; padding: 1.75rem 1.5rem;
    }
  }
  /* V5: zebra striping — alternating rows at haldi 3% opacity. */
  .spec-matrix__row:nth-child(even) {
    background: color-mix(in srgb, var(--haldi) 3%, transparent);
  }
  /* V7: header row clearly legible — forest text, tinted ground, strong rule. */
  .spec-matrix__row:first-child {
    border-bottom: 2px solid var(--forest);
    background: color-mix(in srgb, var(--limewash) 80%, var(--paper));
  }
  .spec-matrix__row:last-child { border-bottom: 0; }
  .spec-matrix__col-head {
    font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--forest);
  }
  .spec-matrix__col-head--distemper { color: var(--indigo); }
  .spec-matrix__col-head--emulsion { color: var(--leaf); }
  /* V5: bolder spec labels. */
  .spec-matrix__label {
    font-weight: 700 !important;
    font-size: 0.875rem !important;
    color: var(--fg) !important;
    letter-spacing: 0.02em;
  }
  .spec-matrix__value {
    font-weight: 600 !important;
    color: var(--fg) !important;
  }
  /* V7: below 640px the 3-column matrix is unreadable — two stacked spec
     sheets instead (Distemper block + Emulsion block). */
  .spec-matrix-mobile { display: none; }
  @media (max-width: 639px) {
    .spec-matrix { display: none; }
    .spec-matrix-mobile { display: grid; gap: 1.5rem; }
  }
  .spec-matrix-mobile__block {
    border: 1px solid var(--border);
    border-top: 3px solid var(--forest);
    border-radius: var(--r-panel);
    background: var(--paper);
    overflow: hidden;
  }
  .spec-matrix-mobile__block--emulsion { border-top-color: var(--leaf); }
  .spec-matrix-mobile__name {
    padding: 1rem 1.25rem;
    font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--forest);
    background: color-mix(in srgb, var(--limewash) 80%, var(--paper));
    border-bottom: 1px solid var(--border);
  }
  .spec-matrix-mobile__block--emulsion .spec-matrix-mobile__name { color: var(--leaf); }
  .spec-matrix-mobile__row {
    display: flex; justify-content: space-between; align-items: baseline; gap: 1rem;
    padding: 0.75rem 1.25rem;
    border-bottom: 1px solid var(--border);
  }
  .spec-matrix-mobile__row:last-child { border-bottom: 0; }
  .spec-matrix-mobile__row .k {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .spec-matrix-mobile__row .v { font-weight: 600; color: var(--fg); text-align: right; }

  /* ===== BENEFITS STRIP (V5: haldi dot indicators + bolder name typography) ===== */
  .benefits-strip { padding-block: clamp(3rem, 6vw, 5rem); }
  .benefits-strip__head { max-width: 48rem; margin-bottom: 2rem; }
  .benefits-strip__list {
    display: grid; gap: 0;
    border-top: 1px solid var(--border);
    counter-reset: benefit;
  }
  @media (min-width: 640px) { .benefits-strip__list { grid-template-columns: 1fr 1fr; column-gap: 3rem; } }
  @media (min-width: 1024px) { .benefits-strip__list { grid-template-columns: repeat(4, 1fr); } }
  .benefits-strip__item {
    padding: 1.5rem 0; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 3rem 1fr; gap: 1rem;
    align-items: center; counter-increment: benefit;
  }
  /* V5: number column now holds the counter + a haldi dot indicator. */
  .benefits-strip__num {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-family: var(--font-display); font-weight: 700;
    color: var(--haldi-deep); font-size: 0.9375rem; letter-spacing: 0.04em;
  }
  .benefits-strip__num::before {
    content: counter(benefit, decimal-leading-zero);
  }
  .benefits-strip__dot {
    display: inline-block;
    width: 0.5rem; height: 0.5rem; border-radius: 50%;
    background: var(--haldi);
    box-shadow: 0 0 0 2px color-mix(in srgb, var(--haldi) 22%, transparent);
  }
  /* V5: bolder name typography (more memorable). */
  .benefits-strip__name {
    font-weight: 700; font-size: 1rem; color: var(--fg); line-height: 1.3;
  }
  .benefits-strip__deva {
    font-family: var(--font-deva); font-size: 0.875rem; color: var(--fg-muted);
    display: block; margin-top: 0.375rem;
  }

  /* ===== FAQ (V5: more spacing above + haldi divider line) ===== */
  .faq-section {
    padding-block: clamp(4.5rem, 8vw, 6.5rem);  /* V5: increased */
    position: relative;
  }
  /* V7: haldi divider line aligned to the content grid (container), never
     the viewport edge. FAQ constrained to a readable 64rem measure. */
  .faq-section .container::before {
    content: ''; display: block;
    width: 4rem; height: 2px;
    background: var(--haldi);
    margin: 0 0 3rem;
  }
  .faq-section__head { max-width: 48rem; margin-bottom: 2rem; }
  .faq-section .faq-list { max-width: 64rem; }
</style>

<!-- ============================================================
     1. HERO — 45 / 55 (text / product group visual)
     ============================================================ -->
<section class="products-hero bg-limewash" aria-labelledby="products-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Products</span>
    </nav>
    <div class="products-hero__grid">
      <div class="products-hero__lockup" data-reveal>
        <span class="eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>Prakritik Paint</span>
        <hr class="products-hero__rule">
        <h1 class="products-hero__title" id="products-hero-title">Two formats of Prakritik Paint.</h1>
        <p class="products-hero__sub">
          Cow dung-based paint, made for interior and exterior walls. Prakritik
          Distemper and Prakritik Emulsion. Two formats, one
          material idea.
        </p>
      </div>
      <div class="products-hero__visual" data-reveal>
        <img class="hero-group-photo"
             src="${groupImg}"
             alt="Prakritik Distemper and Emulsion paint packs"
             width="1280" height="621"
             loading="eager" fetchpriority="high" decoding="async">
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. DISTEMPER PRODUCT CHAPTER — catalogue plate
     (complete pack photo + interior-finish strip; structure in app.css §14)
     ============================================================ -->
<section class="product-chapter product-chapter--distemper" aria-labelledby="distemper-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <img class="chapter-product chapter-product--distemper"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="${e(distemper.name)} paint pack"
               width="490" height="621"
               loading="lazy" decoding="async">
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          ${interiorFinishStripPic}
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 01 — Distemper</span>
        <h2 class="product-chapter__name" id="distemper-chapter-title">
          ${e(distemper.name)}
        </h2>
        <p class="product-chapter__desc">
          ${e(distemper.descriptor)}. A paint listed for
          interior and exterior walls. Supplied in ${e(distemper.packagingShort)} packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row"><dt>Finish</dt><dd>${e(distemper.finish)}</dd></div>
          <div class="duo-panel__row"><dt>Drying time</dt><dd>${e(distemper.dryingTime)}</dd></div>
          <div class="duo-panel__row"><dt>Coverage</dt><dd>${e(distemper.coverage)}</dd></div>
          <div class="duo-panel__row"><dt>V.O.C.</dt><dd>${e(distemper.voc)}</dd></div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="${relUrl(distemper.route, depth)}">View Distemper</a>
          <a class="btn btn--outline" href="${relUrl('/contact/', depth)}?interest=prakritik-distemper">Enquire About Distemper</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. EMULSION PRODUCT CHAPTER (reversed) — catalogue plate
     (complete pack photo + exterior-finish strip; structure in app.css §14)
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <img class="chapter-product chapter-product--emulsion"
               src="${assetUrl(emulsion.officialImage, depth)}"
               alt="${e(emulsion.name)} paint pack"
               width="450" height="621"
               loading="lazy" decoding="async">
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          ${exteriorFinishStripPic}
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Format 02 — Emulsion</span>
        <h2 class="product-chapter__name" id="emulsion-chapter-title">
          ${e(emulsion.name)}
        </h2>
        <p class="product-chapter__desc">
          ${e(emulsion.descriptor)}. A paint listed for
          interior and exterior walls. Supplied in ${e(emulsion.packagingShort)} packs.
        </p>
        <dl class="product-chapter__specs">
          <div class="duo-panel__row"><dt>Finish</dt><dd>${e(emulsion.finish)}</dd></div>
          <div class="duo-panel__row"><dt>Drying time</dt><dd>${e(emulsion.dryingTime)}</dd></div>
          <div class="duo-panel__row"><dt>Coverage</dt><dd>${e(emulsion.coverage)}</dd></div>
          <div class="duo-panel__row"><dt>V.O.C.</dt><dd>${e(emulsion.voc)}</dd></div>
        </dl>
        <div class="product-chapter__cta">
          <a class="btn btn--secondary" href="${relUrl(emulsion.route, depth)}">View Emulsion</a>
          <a class="btn btn--outline" href="${relUrl('/contact/', depth)}?interest=prakritik-emulsion">Enquire About Emulsion</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     4. SPEC MATRIX — large ruled comparison, NO outer card
     ============================================================ -->
<section class="section section--paper spec-matrix-section" aria-labelledby="compare-title">
  <div class="container">
    <div class="spec-matrix-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Side by side</span>
      <h2 class="section-heading__title" id="compare-title">Compare the two formats.</h2>
    </div>

    <div class="spec-matrix" data-reveal>
      <div class="spec-matrix__row">
        <span class="spec-matrix__col-head">Specification</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--distemper">Prakritik Distemper</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--emulsion">Prakritik Emulsion</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Pack sizes</span>
        <span class="spec-matrix__value">${e(distemper.packagingShort)}</span>
        <span class="spec-matrix__value">${e(emulsion.packagingShort)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Colour</span>
        <span class="spec-matrix__value">${e(distemper.colour)}</span>
        <span class="spec-matrix__value">${e(emulsion.colour)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Finish</span>
        <span class="spec-matrix__value">${e(distemper.finish)}</span>
        <span class="spec-matrix__value">${e(emulsion.finish)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Drying time</span>
        <span class="spec-matrix__value">${e(distemper.dryingTime)}</span>
        <span class="spec-matrix__value">${e(emulsion.dryingTime)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Coverage</span>
        <span class="spec-matrix__value">${e(distemper.coverage)}</span>
        <span class="spec-matrix__value">${e(emulsion.coverage)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">V.O.C.</span>
        <span class="spec-matrix__value">${e(distemper.voc)}</span>
        <span class="spec-matrix__value">${e(emulsion.voc)}</span>
      </div>
      <div class="spec-matrix__row">
        <span class="spec-matrix__label">Usage</span>
        <span class="spec-matrix__value">${e(distemper.usage)}</span>
        <span class="spec-matrix__value">${e(emulsion.usage)}</span>
      </div>
    </div>

    <div class="spec-matrix-mobile" data-reveal>
      <div class="spec-matrix-mobile__block">
        <div class="spec-matrix-mobile__name">${e(distemper.name)}</div>
        <div class="spec-matrix-mobile__row"><span class="k">Pack sizes</span><span class="v">${e(distemper.packagingShort)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Colour</span><span class="v">${e(distemper.colour)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Finish</span><span class="v">${e(distemper.finish)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Drying time</span><span class="v">${e(distemper.dryingTime)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Coverage</span><span class="v">${e(distemper.coverage)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">V.O.C.</span><span class="v">${e(distemper.voc)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Usage</span><span class="v">${e(distemper.usage)}</span></div>
      </div>
      <div class="spec-matrix-mobile__block spec-matrix-mobile__block--emulsion">
        <div class="spec-matrix-mobile__name">${e(emulsion.name)}</div>
        <div class="spec-matrix-mobile__row"><span class="k">Pack sizes</span><span class="v">${e(emulsion.packagingShort)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Colour</span><span class="v">${e(emulsion.colour)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Finish</span><span class="v">${e(emulsion.finish)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Drying time</span><span class="v">${e(emulsion.dryingTime)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Coverage</span><span class="v">${e(emulsion.coverage)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">V.O.C.</span><span class="v">${e(emulsion.voc)}</span></div>
        <div class="spec-matrix-mobile__row"><span class="k">Usage</span><span class="v">${e(emulsion.usage)}</span></div>
      </div>
    </div>

    <p class="coverage-disclaimer" style="margin-top: 2rem;">
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text">${e(COVERAGE_DISCLAIMER)}</span>
    </p>
  </div>
</section>

<!-- ============================================================
     5. BENEFITS STRIP — numbered typographic list, NO 8 cards
     ============================================================ -->
<section class="section section--limewash benefits-strip" aria-labelledby="benefits-title">
  <div class="container">
    <div class="benefits-strip__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="benefits-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>
    <ol class="benefits-strip__list" data-reveal-stagger>
${benefitsItems}
    </ol>
  </div>
</section>

<!-- ============================================================
     6. FAQ (consumed here per spec — only styled for Products / Why-Prakritik)
     ============================================================ -->
<section class="section section--paper faq-section" aria-labelledby="faq-title">
  <div class="container">
    <div class="faq-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Common questions</span>
      <h2 class="section-heading__title" id="faq-title">Frequently asked.</h2>
    </div>
    <div class="faq-list" data-reveal>
${faqItems}
    </div>
  </div>
</section>

<!-- ============================================================
     7. NEED HELP CHOOSING — CTA
     ============================================================ -->
<section class="section section--forest" aria-labelledby="choose-cta-title">
  <div class="container">
    <div class="why-cta" data-reveal>
      <span class="why-cta__eyebrow">Still deciding?</span>
      <h2 class="why-cta__title" id="choose-cta-title">Need help choosing? Talk to Gaurikrit.</h2>
      <p class="why-cta__sub">
        We can walk through your project — interior or exterior, fresh walls or
        repainting — and help you pick the right Prakritik format.
      </p>
      <div class="why-cta__actions">
        <a class="btn btn--haldi" href="${relUrl('/contact/', depth)}">Talk to Us</a>
        <a class="btn btn--secondary" href="${relUrl('/paint-calculator/', depth)}">Estimate Your Project</a>
      </div>
    </div>
  </div>
</section>
`;
}

// ---- Prakritik Distemper detail — V4 ----
function distemperBody(depth) {
    const product = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const specRows = [
        { num: '01', label: 'Packaging',  value: product.packagingShort, note: '1 kg / 5 kg / 10 kg / 20 kg packs' },
        { num: '02', label: 'Colour',     value: product.colour },
        { num: '03', label: 'Finish',     value: product.finish },
        { num: '04', label: 'Drying time', value: product.dryingTime },
        { num: '05', label: 'Coverage',   value: product.coverage, note: '** ' + COVERAGE_DISCLAIMER },
        { num: '06', label: 'V.O.C.',     value: product.voc },
        { num: '07', label: 'Usage',      value: product.usage },
    ];

    const specItems = specRows.map((row) => {
        const note = row.note ? `\n              <small>${e(row.note)}</small>` : '';
        return `        <div class="spec-sheet__item">
          <span class="spec-sheet__num">${e(row.num)}</span>
          <div>
            <dt class="spec-sheet__label">${e(row.label)}</dt>
            <dd class="spec-sheet__value">
              ${e(row.value)}${note}
            </dd>
          </div>
        </div>`;
    }).join('\n');

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = ASHTA_IDS[benefit.name] || `benefit-${i + 1}`;
        return `        <li class="ashta-benefit distemper-ashta__item" data-ashta-node="${e(bid)}">
          <span class="ashta-benefit__num">${pad2(i + 1)}</span>
          <span class="ashta-benefit__name">${e(benefit.name)}</span>
          <span class="ashta-benefit__deva">${e(benefit.hindi)}</span>
        </li>`;
    }).join('\n');

    // V10: hero media is a clean catalogue plate — white product stage (the
    // real 490×621 pack photo, eager+high-priority, complete) + an
    // interior-finish strip below.
    const interiorFinishStripPic = pic('/assets/editorial/interior-finish-study.webp', '/assets/editorial/interior-finish-study.jpg',
        '', 1344, 768, depth, 'class="media-strip"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO (copy 5 / product 7 — cool env) ===== */
  .product-detail { padding-bottom: clamp(3rem, 6vw, 5rem); }
  .product-detail__hero {
    display: grid; gap: 2rem; padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 2rem; align-items: center;
  }
  @media (min-width: 1024px) {
    .product-detail__hero {
      grid-template-columns: 5fr 7fr; gap: clamp(2.5rem, 5vw, 4rem);
    }
  }
  /* V10: media is a clean catalogue plate (same language as the home
     product chapters) — white product stage + slim wall-finish strip.
     The complete pack photo is shown at its natural proportion. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: var(--paper);
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
    border-radius: var(--r-panel); overflow: hidden;
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .product-detail__stage {
    position: relative;
    height: clamp(17rem, 36vw, 25rem);
    display: grid; place-items: center;
    padding: clamp(1.25rem, 3vw, 2.25rem);
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). */
    position: absolute;
    top: clamp(1.25rem, 3vw, 2.25rem);
    left: clamp(1.25rem, 3vw, 2.25rem);
    width: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
    height: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
    object-fit: contain;
  }
  .product-detail__strip {
    height: clamp(6rem, 13vw, 9rem);
    border-top: 1px solid var(--border);
    overflow: hidden;
    background: var(--limewash);
  }
  .product-detail__strip .media-strip {
    display: block; width: 100%; height: 100%;
    object-fit: cover;
  }
  .product-detail__info { display: flex; flex-direction: column; gap: 0.75rem; }
  .product-detail__name { margin-top: 0.5rem; }
  .product-detail__descriptor { color: var(--indigo); }

  /* ===== SPEC SHEET (numbered 01-07 ruled rows, NOT pills) ===== */
  .distemper-specs-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 1.5rem; }
  .spec-sheet__list {
    grid-template-columns: 1fr;
  }

  /* ===== COVERAGE DISCLAIMER ===== */
  .coverage-disclaimer { margin-top: 2rem; border-left-color: var(--indigo); }

  /* ===== ASHTA LAABH GRID ===== */
  .distemper-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); position: relative; overflow: hidden; }
  .distemper-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ===== HERO (cool env, copy 5 / product 7) ===== -->
<section class="product-detail product-detail--cool" aria-labelledby="distemper-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <a href="${relUrl('/products/', depth)}">Products</a><span>›</span>
      <span>Prakritik Distemper</span>
    </nav>

    <div class="product-detail__hero" data-reveal>
      <div class="product-detail__info">
        <span class="distemper-hero__eyebrow">Format 01 — Distemper</span>
        <h1 class="product-detail__name" id="distemper-title">${e(product.name)}</h1>
        <p class="product-detail__descriptor">${e(product.descriptor)}</p>
        <p class="distemper-hero__body">
          Cow dung-based paint listed for interior and exterior
          walls. Supplied in ${e(product.packagingShort)} packs.
        </p>
        <div class="distemper-hero__cta-row">
          <a class="btn btn--primary btn--lg"
             href="${relUrl('/contact/', depth)}?interest=prakritik-distemper">Enquire About Distemper</a>
          <a class="btn btn--outline" href="${relUrl('/products/', depth)}">View All Products</a>
        </div>
      </div>

      <figure class="product-detail__media">
        <div class="product-detail__stage">
          <img class="media-product"
               src="${assetUrl(product.officialImage, depth)}"
               alt="${e(product.name)} paint pack"
               width="490" height="621"
               loading="eager" fetchpriority="high" decoding="async">
        </div>
        <div class="product-detail__strip" aria-hidden="true">
          ${interiorFinishStripPic}
        </div>
      </figure>
    </div>
  </div>
</section>

<!-- ===== SPEC SHEET (numbered 01-07 ruled rows) ===== -->
<section class="section section--paper distemper-specs-section" aria-labelledby="specs-title">
  <div class="container">
    <div class="spec-sheet__head section-heading section-heading--left" data-reveal>
      <span class="spec-sheet__eyebrow">Specifications</span>
      <h2 class="spec-sheet__title" id="specs-title">Product specifications.</h2>
      <!-- V9: print affordance — window.print() + the app.css §36 print
           stylesheet turns this page into a printable spec sheet. -->
      <button type="button" class="spec-sheet__print" data-print-spec>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
        <span>Print spec sheet</span>
      </button>
    </div>

    <dl class="spec-sheet__list" data-reveal>
${specItems}
    </dl>

    <p class="coverage-disclaimer" data-reveal>
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text">${e(COVERAGE_DISCLAIMER)}</span>
    </p>
  </div>
</section>

<!-- ===== ASHTA LAABH ===== -->
<section class="section section--limewash distemper-ashta-section" aria-labelledby="distemper-ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="distemper-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ — Eight benefits</span>
      <h2 class="section-heading__title" id="distemper-ashta-title">Ashta Laabh.</h2>
      <p class="section-heading__desc">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>

    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        ${loadSvg('ashta-laabh-seal')}
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
${ashtaItems}
      </ol>
    </div>
  </div>
</section>

<!-- ===== CROSS-LINK ===== -->
<section class="section section--paper" aria-labelledby="cross-title">
  <div class="container">
    <div class="distemper-cta" data-reveal>
      <div class="distemper-cta__inner">
        <div>
          <span class="distemper-hero__eyebrow">Looking at the other format?</span>
          <h2 class="distemper-cta__title" id="cross-title">Prakritik Emulsion.</h2>
          <p class="distemper-cta__body">
            Cow dung-based Emulsion Paint. Coverage ${e(emulsion.coverage)}.
            Supplied in ${e(emulsion.packagingShort)} packs.
          </p>
        </div>
        <div class="distemper-cta__actions">
          <a class="btn btn--secondary" href="${relUrl(emulsion.route, depth)}">View Emulsion</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
`;
}

// ---- Prakritik Emulsion detail — V4 (reversed) ----
function emulsionBody(depth) {
    const product = getProduct('prakritik-emulsion');
    const distemper = getProduct('prakritik-distemper');

    const specRows = [
        { num: '01', label: 'Packaging',   value: product.packagingShort, note: '1 litre / 4 litre / 10 litre / 20 litre packs' },
        { num: '02', label: 'Colour',      value: product.colour },
        { num: '03', label: 'Finish',      value: product.finish },
        { num: '04', label: 'Drying time', value: product.dryingTime },
        { num: '05', label: 'Coverage',    value: product.coverage, note: '** ' + COVERAGE_DISCLAIMER },
        { num: '06', label: 'V.O.C.',      value: product.voc },
        { num: '07', label: 'Usage',       value: product.usage },
    ];

    const specItems = specRows.map((row) => {
        const note = row.note ? `\n              <small>${e(row.note)}</small>` : '';
        return `        <div class="spec-sheet__item">
          <span class="spec-sheet__num">${e(row.num)}</span>
          <div>
            <dt class="spec-sheet__label">${e(row.label)}</dt>
            <dd class="spec-sheet__value">
              ${e(row.value)}${note}
            </dd>
          </div>
        </div>`;
    }).join('\n');

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = ASHTA_IDS[benefit.name] || `benefit-${i + 1}`;
        return `        <li class="ashta-benefit emulsion-ashta__item" data-ashta-node="${e(bid)}">
          <span class="ashta-benefit__num">${pad2(i + 1)}</span>
          <span class="ashta-benefit__name">${e(benefit.name)}</span>
          <span class="ashta-benefit__deva">${e(benefit.hindi)}</span>
        </li>`;
    }).join('\n');

    // V10: hero media is a clean catalogue plate — white product stage (the
    // real 450×621 pack photo, eager+high-priority, complete) + an
    // exterior-finish strip below.
    const exteriorFinishStripPic = pic('/assets/editorial/exterior-finish-study.webp', '/assets/editorial/exterior-finish-study.jpg',
        '', 1344, 768, depth, 'class="media-strip"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO — REVERSED (product left, copy right — warm env) ===== */
  .product-detail { padding-bottom: clamp(3rem, 6vw, 5rem); }
  .product-detail__hero {
    display: grid; gap: 2rem; padding-top: calc(var(--header-h) + 2rem);
    padding-bottom: 2rem; align-items: center;
  }
  @media (min-width: 1024px) {
    .product-detail__hero {
      grid-template-columns: 7fr 5fr; gap: clamp(2.5rem, 5vw, 4rem);
    }
    /* Reversed: product is the first child, on the left. */
    .product-detail--warm .product-detail__hero > :first-child { order: 1; }
    .product-detail--warm .product-detail__hero > :last-child  { order: 2; }
  }
  /* V10: media is a clean catalogue plate (same language as the home
     product chapters) — white product stage + slim wall-finish strip.
     The complete pack photo is shown at its natural proportion. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: var(--paper);
    border: 1px solid var(--border); border-top: 3px solid var(--leaf);
    border-radius: var(--r-panel); overflow: hidden;
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .product-detail__stage {
    position: relative;
    height: clamp(17rem, 36vw, 25rem);
    display: grid; place-items: center;
    padding: clamp(1.25rem, 3vw, 2.25rem);
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). */
    position: absolute;
    top: clamp(1.25rem, 3vw, 2.25rem);
    left: clamp(1.25rem, 3vw, 2.25rem);
    width: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
    height: calc(100% - 2 * clamp(1.25rem, 3vw, 2.25rem));
    object-fit: contain;
  }
  .product-detail__strip {
    height: clamp(6rem, 13vw, 9rem);
    border-top: 1px solid var(--border);
    overflow: hidden;
    background: var(--limewash);
  }
  .product-detail__strip .media-strip {
    display: block; width: 100%; height: 100%;
    object-fit: cover;
  }
  .product-detail__info { display: flex; flex-direction: column; gap: 0.75rem; }
  .product-detail__name { margin-top: 0.5rem; }
  .product-detail__descriptor { color: var(--leaf); }

  /* ===== SPEC SHEET ===== */
  .emulsion-specs-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-sheet__head { margin-bottom: 1.5rem; }
  .spec-sheet__list { grid-template-columns: 1fr; }

  /* ===== COVERAGE DISCLAIMER ===== */
  .coverage-disclaimer { margin-top: 2rem; border-left-color: var(--leaf); }

  /* ===== ASHTA LAABH ===== */
  .emulsion-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); position: relative; overflow: hidden; }
  .emulsion-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ===== HERO — REVERSED (warm env) ===== -->
<section class="product-detail product-detail--warm" aria-labelledby="emulsion-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <a href="${relUrl('/products/', depth)}">Products</a><span>›</span>
      <span>Prakritik Emulsion</span>
    </nav>

    <div class="product-detail__hero" data-reveal>
      <figure class="product-detail__media">
        <div class="product-detail__stage">
          <img class="media-product"
               src="${assetUrl(product.officialImage, depth)}"
               alt="${e(product.name)} paint pack"
               width="450" height="621"
               loading="eager" fetchpriority="high" decoding="async">
        </div>
        <div class="product-detail__strip" aria-hidden="true">
          ${exteriorFinishStripPic}
        </div>
      </figure>

      <div class="product-detail__info">
        <span class="emulsion-hero__eyebrow">Format 02 — Emulsion</span>
        <h1 class="product-detail__name" id="emulsion-title">${e(product.name)}</h1>
        <p class="product-detail__descriptor">${e(product.descriptor)}</p>
        <p class="emulsion-hero__body">
          Cow dung-based paint listed for interior and exterior
          walls. Supplied in ${e(product.packagingShort)} packs.
        </p>
        <div class="emulsion-hero__cta-row">
          <a class="btn btn--primary btn--lg"
             href="${relUrl('/contact/', depth)}?interest=prakritik-emulsion">Enquire About Emulsion</a>
          <a class="btn btn--outline" href="${relUrl('/products/', depth)}">View All Products</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== SPEC SHEET (numbered 01-07 ruled rows) ===== -->
<section class="section section--paper emulsion-specs-section" aria-labelledby="specs-title">
  <div class="container">
    <div class="spec-sheet__head section-heading section-heading--left" data-reveal>
      <span class="spec-sheet__eyebrow">Specifications</span>
      <h2 class="spec-sheet__title" id="specs-title">Product specifications.</h2>
      <!-- V9: print affordance — window.print() + the app.css §36 print
           stylesheet turns this page into a printable spec sheet. -->
      <button type="button" class="spec-sheet__print" data-print-spec>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
        <span>Print spec sheet</span>
      </button>
    </div>

    <dl class="spec-sheet__list" data-reveal>
${specItems}
    </dl>

    <p class="coverage-disclaimer" data-reveal>
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text">${e(COVERAGE_DISCLAIMER)}</span>
    </p>
  </div>
</section>

<!-- ===== ASHTA LAABH ===== -->
<section class="section section--limewash emulsion-ashta-section" aria-labelledby="emulsion-ashta-title" data-ashta-laabh>
  <div class="container">
    <div class="emulsion-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ — Eight benefits</span>
      <h2 class="section-heading__title" id="emulsion-ashta-title">Ashta Laabh.</h2>
      <p class="section-heading__desc">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>

    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        ${loadSvg('ashta-laabh-seal')}
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
${ashtaItems}
      </ol>
    </div>
  </div>
</section>

<!-- ===== CROSS-LINK ===== -->
<section class="section section--paper" aria-labelledby="cross-title">
  <div class="container">
    <div class="emulsion-cta" data-reveal>
      <div class="emulsion-cta__inner">
        <div>
          <span class="emulsion-hero__eyebrow">Looking at the other format?</span>
          <h2 class="emulsion-cta__title" id="cross-title">Prakritik Distemper.</h2>
          <p class="emulsion-cta__body">
            Cow dung-based Distemper Paint. Coverage ${e(distemper.coverage)}.
            Supplied in ${e(distemper.packagingShort)} packs.
          </p>
        </div>
        <div class="emulsion-cta__actions">
          <a class="btn btn--secondary" href="${relUrl(distemper.route, depth)}">View Distemper</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
`;
}

// ---- Why Prakritik — V4 ----
function whyPrakritikBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const groupImage = '/assets/products/prakritik-group.jpg';
    const groupImg = assetUrl(groupImage, depth);

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        const bid = ASHTA_IDS[benefit.name] || `benefit-${i + 1}`;
        return `        <li class="ashta-benefit" data-ashta-node="${e(bid)}">
          <span class="ashta-benefit__num">${pad2(i + 1)}</span>
          <span class="ashta-benefit__name">${e(benefit.name)}</span>
          <span class="ashta-benefit__deva">${e(benefit.hindi)}</span>
        </li>`;
    }).join('\n');

    // V10 picture tags — the zebu art is retired from this page. The hero
    // shows a single quiet finished-wall study; Section 01 grounds the
    // material in a raw plaster surface; Section 03 uses the shared step
    // cards (raw material / paint / finished wall).
    const heroFinishPic = pic('/assets/editorial/interior-finish-study.webp', '/assets/editorial/interior-finish-study.jpg',
        'Quiet interior wall with a matte mineral finish', 1344, 768, depth, 'class="why-hero__img"');
    const rawMaterialCh1Pic = pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
        'Raw lime-plastered wall surface — natural material', 1344, 768, depth, 'class="editorial-image"');
    const courtyardCh2Pic = pic('/assets/editorial/courtyard-study.webp', '/assets/editorial/courtyard-study.jpg',
        'Indian limewashed courtyard elevation', 1942, 809, depth, 'class="editorial-image"');
    const rawMaterialFlowPic = pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
        'Raw lime-plastered wall surface — natural material', 1344, 768, depth, 'class="editorial-image"');
    const finishedSurfaceFlowPic = pic('/assets/editorial/finished-surface-study.webp', '/assets/editorial/finished-surface-study.jpg',
        'Finished matte limewash wall surface', 1344, 768, depth, 'class="editorial-image"');
    // V5: context uses business-context-study (replaces rural-landscape).
    const businessContextPic = pic('/assets/editorial/business-context-study.webp', '/assets/editorial/business-context-study.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');

        const ruralContextPic = pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .editorial-image--contain { object-fit: contain; }

  /* ===== HERO (V10: single quiet finished-wall study) ===== */
  .why-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .why-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .why-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .why-hero__lockup { max-width: 42rem; }
  .why-hero__art {
    position: relative; aspect-ratio: 1344/768;
    background: var(--paper); border-radius: var(--r-panel);
    overflow: hidden;
    border: 1px solid var(--border);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .why-hero__art .why-hero__img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; display: block;
  }
  .why-hero__title { font-size: clamp(2.2rem, 5vw, 4rem); }

  /* ===== NUMBERED CHAPTERS ===== */
  .why-chapter {
    display: grid; gap: 2rem; padding-block: clamp(3.5rem, 6vw, 5rem);
  }
  @media (min-width: 1024px) {
    .why-chapter { grid-template-columns: 4fr 8fr; gap: 3rem; align-items: start; }
  }
  .why-chapter--reverse > :first-child { order: 2; }
  @media (min-width: 1024px) {
    .why-chapter--reverse > :first-child { order: 0; }
  }
  .why-chapter__num {
    font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 700; color: var(--haldi-deep); line-height: 1;
  }
  .why-chapter__eyebrow {
    display: block; margin-top: 0.875rem; font-size: 0.75rem;
    font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--primary);
  }
  .why-chapter__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(1.75rem, 4vw, 2.75rem); line-height: 1.1;
    letter-spacing: -0.02em; text-wrap: balance;
  }
  .why-chapter__body {
    margin-top: 1.25rem; color: var(--fg-muted);
    font-size: 1.0625rem; line-height: 1.75; max-width: 60ch;
  }
  .why-chapter__body p + p { margin-top: 1.25rem; }
  .why-chapter__pull {
    margin-top: 1.5rem; font-family: var(--font-display);
    font-style: italic; font-size: clamp(1.25rem, 2.5vw, 1.625rem);
    line-height: 1.4; color: var(--primary);
    padding-left: 1.5rem; border-left: 3px solid var(--haldi);
  }

  /* === Chapter 01 — MATERIAL: raw-material-study (plaster surface) === */
  .why-material-sample {
    position: relative; aspect-ratio: 1344/768;
    background: var(--paper); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-material-sample .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  .why-material-sample__patch,
  .why-material-sample__tag { display: none; }

  /* === Chapter 02 — TRADITION: large courtyard === */
  .why-tradition-art {
    width: 100%; aspect-ratio: 1942/809;
    background: var(--limewash); border-radius: var(--r-panel);
    overflow: hidden;
  }
  .why-tradition-art .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }

  /* === Chapter 03 — MATERIAL TO WALL: 3 step cards (structure in
     app.css §17 .material-step — same cards as the homepage journey) === */
  .why-flow-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-flow-section .material-steps { margin-top: 2rem; }

  /* === Chapter 04 — ASHTA: full-size seal === */
  .why-ashta-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .ashta-section__seal { max-width: 38rem; margin-inline: auto; }

  /* === Chapter 05 — FORMATS: two real product visuals === */
  .why-formats-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-formats {
    display: grid; gap: 2rem; margin-top: 2rem;
  }
  @media (min-width: 768px) { .why-formats { grid-template-columns: 1fr 1fr; } }
  .why-format-card {
    position: relative;
    background: linear-gradient(160deg, var(--paper), var(--limewash));
    border: 1px solid var(--border); border-top: 3px solid var(--indigo);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center; padding: 1.5rem;
    min-height: 22rem;
  }
  .why-format-card--emulsion { border-top-color: var(--leaf); }
  .why-format-card .format-product {
    display: block;
    max-height: 26rem; max-width: 100%;
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 14px 20px rgba(34, 36, 27, 0.16));
  }
  .why-format-card__caption {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.9); padding: 0.5rem 0.875rem;
    border-radius: var(--r-pill); font-size: 0.8125rem; font-weight: 600;
  }
  .why-format-card--distemper .why-format-card__caption { color: var(--indigo); }
  .why-format-card--emulsion  .why-format-card__caption { color: var(--leaf); }

  /* === Chapter 06 — CONTEXT: rural-landscape with annotation === */
  .why-context-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  /* V7: no building artwork in the context chapter — a neutral rural
     engraving at 0.08 opacity behind the text instead (no implied facility). */
  .why-context-section { position: relative; overflow: hidden; }
  .why-context-bg {
    position: absolute; inset: 0; opacity: 0.08;
    pointer-events: none; overflow: hidden;
  }
  .why-context-bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  .why-context-section .why-chapter { position: relative; z-index: 1; }
</style>

<!-- ===== HERO ===== -->
<section class="why-hero bg-limewash" aria-labelledby="why-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Why Prakritik</span>
    </nav>
    <div class="why-hero__container" data-reveal>
      <div class="why-hero__lockup">
        <span class="why-hero__eyebrow"><span class="why-hero__eyebrow-dot" aria-hidden="true"></span>An old Indian material idea</span>
        <hr class="why-hero__rule">
        <h1 class="why-hero__title" id="why-title">An old material idea, reconsidered for modern walls.</h1>
        <p class="why-hero__sub">
          Traditional Indian homes have long used cow-dung-based coatings on
          walls and floors. Prakritik Paint brings that material idea into a
          contemporary paint format.
        </p>
      </div>
      <div class="why-hero__art">
        ${heroFinishPic}
      </div>
    </div>
  </div>
</section>

<!-- ===== 01 MATERIAL ===== -->
<section class="section section--paper" aria-labelledby="chapter-01-title">
  <div class="container">
    <div class="why-chapter" data-reveal>
      <div>
        <span class="why-chapter__num">01</span>
        <span class="why-chapter__eyebrow">The material</span>
        <h2 class="why-chapter__title" id="chapter-01-title">A natural material for modern walls.</h2>
        <div class="why-chapter__body">
          <p>
            Cow dung has a long history of use on walls and floors in India.
          </p>
          <p>
            Gaurikrit offers cow dung-based Prakritik Paint in Distemper and Emulsion formats.
          </p>
        </div>
        <p class="why-chapter__pull">
          Not a novelty. A useful material, reconsidered.
        </p>
      </div>
      <div class="why-material-sample">
        ${rawMaterialCh1Pic}
      </div>
    </div>
  </div>
</section>

<!-- ===== 02 TRADITION — large courtyard ===== -->
<section class="section section--limewash" aria-labelledby="chapter-02-title">
  <div class="container">
    <div class="why-chapter why-chapter--reverse" data-reveal>
      <div class="why-tradition-art" aria-hidden="true">
        ${courtyardCh2Pic}
      </div>
      <div>
        <span class="why-chapter__num">02</span>
        <span class="why-chapter__eyebrow">The tradition</span>
        <h2 class="why-chapter__title" id="chapter-02-title">Limewashed walls, courtyard elevations.</h2>
        <div class="why-chapter__body">
          <p>
            Indian vernacular architecture is full of limewashed walls, plinths,
            verandahs, and rectangular openings — plaster, lime and earth.
          </p>
          <p>
            The courtyard study shows a wall surface in an everyday Indian setting.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== 03 MATERIAL TO WALL — 3-panel composition ===== -->
<section class="section section--paper why-flow-section" aria-labelledby="chapter-03-title">
  <div class="container">
    <div data-reveal>
      <span class="why-chapter__num">03</span>
      <span class="why-chapter__eyebrow">Material to wall</span>
      <h2 class="why-chapter__title" id="chapter-03-title">From a natural material to a finished wall.</h2>
      <p class="why-chapter__body">
        The raw material, the paint made from it, and the finished surface —
        three steps, one material idea.
      </p>
    </div>
    <div class="material-steps" data-reveal>
      <article class="material-step">
        <figure class="material-step__figure">
          ${rawMaterialFlowPic}
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">01</span>
          <h3 class="material-step__title">Natural material</h3>
          <p class="material-step__desc">Cow dung is the material inspiration.</p>
        </div>
      </article>
      <article class="material-step material-step--product">
        <figure class="material-step__figure">
          <img class="material-step__product"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="Prakritik Distemper paint pack"
               width="490" height="621"
               loading="lazy" decoding="async">
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">02</span>
          <h3 class="material-step__title">Prakritik Paint</h3>
          <p class="material-step__desc">Available as Distemper and Emulsion.</p>
        </div>
      </article>
      <article class="material-step">
        <figure class="material-step__figure">
          ${finishedSurfaceFlowPic}
        </figure>
        <div class="material-step__caption">
          <span class="material-step__num">03</span>
          <h3 class="material-step__title">Finished wall</h3>
          <p class="material-step__desc">Both are listed for interior and exterior use.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ===== 04 ASHTA — full-size seal (interactive SVG kept) ===== -->
<section class="section section--limewash why-ashta-section" aria-labelledby="chapter-04-title" data-ashta-laabh>
  <div class="container">
    <div class="why-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">अष्ट लाभ</span>
      <h2 class="section-heading__title" id="chapter-04-title">Eight benefits.</h2>
      <p class="section-heading__desc">
        Benefits listed in the Prakritik Paint material.
      </p>
    </div>
    <div class="ashta-section__grid" data-reveal>
      <div class="ashta-section__seal">
        ${loadSvg('ashta-laabh-seal')}
      </div>
      <ol class="ashta-section__support" data-reveal-stagger>
${ashtaItems}
      </ol>
    </div>
  </div>
</section>

<!-- ===== 05 FORMATS — real product visuals ===== -->
<section class="section section--paper why-formats-section" aria-labelledby="chapter-05-title">
  <div class="container">
    <div data-reveal>
      <span class="why-chapter__num">05</span>
      <span class="why-chapter__eyebrow">Two formats</span>
      <h2 class="why-chapter__title" id="chapter-05-title">Distemper and Emulsion.</h2>
      <p class="why-chapter__body">
        Two paint formats, one material idea. Both are listed for
        interior and exterior walls.
      </p>
    </div>

    <div class="why-formats" data-reveal-stagger>
      <div class="why-format-card why-format-card--distemper">
        <img class="format-product"
             src="${assetUrl(distemper.officialImage, depth)}"
             alt="${e(distemper.name)}"
             width="490" height="621"
             loading="lazy" decoding="async">
        <span class="why-format-card__caption">${e(distemper.packagingShort)} packs</span>
      </div>
      <div class="why-format-card why-format-card--emulsion">
        <img class="format-product"
             src="${assetUrl(emulsion.officialImage, depth)}"
             alt="${e(emulsion.name)}"
             width="450" height="621"
             loading="lazy" decoding="async">
        <span class="why-format-card__caption">${e(emulsion.packagingShort)} packs</span>
      </div>
    </div>
  </div>
</section>

<!-- ===== 06 CONTEXT — rural-landscape with annotation ===== -->
<section class="section section--limewash why-context-section" aria-labelledby="chapter-06-title">
  <div class="why-context-bg" aria-hidden="true">
    ${ruralContextPic}
  </div>
  <div class="container">
    <div class="why-chapter" data-reveal>
      <div>
        <span class="why-chapter__num">06</span>
        <span class="why-chapter__eyebrow">Context</span>
        <h2 class="why-chapter__title" id="chapter-06-title">From Bulandshahr, Uttar Pradesh.</h2>
        <div class="why-chapter__body">
          <p>
            Prakritik Paint is made by ${e(COMPANY.legalName)}, in
            ${e(COMPANY.address[3] || '')}, ${e(COMPANY.address[4] || '')}.
            The company address is in Bulandshahr, Uttar Pradesh.
          </p>
        </div>
        <div class="mission-band__cta" style="margin-top: 1.5rem;">
          <a class="btn btn--primary" href="${relUrl('/products/', depth)}">Explore Products</a>
          <a class="btn btn--outline" href="${relUrl('/about/', depth)}">About Gaurikrit</a>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  (function () {
    'use strict';
    document.querySelectorAll('[data-ashta-laabh] svg [data-benefit]').forEach(function (node) {
      node.setAttribute('data-ashta-node', node.getAttribute('data-benefit'));
    });
  })();
</script>
`;
}

// ---- About — V4 ----
function aboutBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const address = COMPANY.address;
    const addressLine = address.join('\n');

    const phoneRows = COMPANY.phones.map((phone) => `        <div class="company-plate__row">
          <dt>Phone</dt>
          <dd>
            <a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a>
          </dd>
        </div>`).join('\n');

    // V4 picture tags.
    const rawMaterialDirectionPic = pic('/assets/editorial/raw-material-study.webp', '/assets/editorial/raw-material-study.jpg',
        'Raw lime-plastered wall surface — an Indian natural wall material', 1344, 768, depth, 'class="editorial-image"');
    const ruralMissionPic = pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO (V7: 5/7 — brand identity left, real product plate right) ===== */
  .about-hero { padding-top: calc(var(--header-h) + clamp(1.25rem, 3vw, 2rem)); padding-bottom: clamp(1.25rem, 3vw, 2rem); }
  .about-hero__container { display: grid; gap: clamp(1.5rem, 4vw, 3rem); align-items: center; }
  @media (min-width: 1024px) {
    .about-hero__container { grid-template-columns: 5fr 7fr; }
  }
  .about-hero__lockup { display: flex; flex-direction: column; gap: 0.75rem; max-width: 42rem; }
  .about-hero__deva {
    font-family: var(--font-deva); font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 700; color: var(--haldi-deep);
  }
  .about-hero__brand-sub {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .about-hero__title {
    font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance;
    margin-top: 0.5rem;
  }
  .about-hero__body {
    margin-top: 1rem; font-size: clamp(1rem, 2vw, 1.125rem);
    color: var(--fg-muted); line-height: 1.65; max-width: 60ch;
  }
  /* V7: the hero shows WHO the brand is + WHAT it actually makes — the real
     product group photo as a catalogue plate with the official mark. */
  .about-hero__plate {
    background: var(--paper);
    border: 1px solid var(--border);
    border-top: 3px solid var(--haldi);
    border-radius: var(--r-panel);
    padding: clamp(1rem, 2vw, 1.5rem);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
  }
  .about-hero__plate-head {
    display: flex; align-items: center; gap: 0.625rem;
    padding-bottom: 0.75rem; margin-bottom: 0.75rem;
    border-bottom: 1px solid var(--border);
  }
  .about-hero__plate-mark { width: 40px; height: 40px; flex: none; object-fit: contain; }
  .about-hero__plate-brand {
    font-family: var(--font-deva); font-size: 0.9375rem; color: var(--haldi-deep);
    line-height: 1.2;
  }
  .about-hero__plate-brand small {
    display: block; font-family: var(--font-sans); font-size: 0.5625rem;
    font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--fg-muted); margin-top: 0.125rem;
  }
  .about-hero__plate-photo {
    display: block; width: 100%; height: auto;
    object-fit: contain; aspect-ratio: 1280 / 621;
  }

  /* ===== WHO WE ARE (V7: 35/65 ledger-left, body right) ===== */
  .about-wrap { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-section .about-section__body { max-width: 65ch; }

  /* ===== WHAT WE PRESENT ===== */
  .about-products-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-products { margin-top: 2rem; }
  .about-product-card__media {
    position: relative; aspect-ratio: 4/3; background: var(--limewash);
    border-radius: var(--r-panel); overflow: hidden;
    margin-bottom: 1rem;
    display: flex; align-items: center; justify-content: center;
  }
  .about-product-card__media .about-product-photo {
    display: block;
    max-height: 80%; max-width: 70%;
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 14px 20px rgba(34, 36, 27, 0.16));
  }
  .about-product-card__media--distemper .about-product-photo {
    max-width: min(70%, 420px);
  }
  .about-product-card__media--emulsion .about-product-photo {
    max-width: min(60%, 320px);
  }

  /* ===== MATERIAL DIRECTION (V10: raw plaster surface — the material
     itself, printed onto the page with no panel chrome) ===== */
  .about-direction-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .about-direction__visual {
    background: transparent;
    border-radius: 0;
    overflow: hidden;
    position: relative;
    aspect-ratio: 1344 / 768;
  }
  .about-direction__visual .editorial-image {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover;
  }

  /* ===== MISSION BAND ===== */
  .about-mission {
    position: relative; padding-block: clamp(4rem, 8vw, 6.5rem);
    background: var(--forest-deep); color: var(--primary-fg);
    overflow: hidden;
  }
  .about-mission__bg {
    position: absolute; inset: 0; opacity: 0.15; pointer-events: none;
    overflow: hidden;
  }
  .about-mission__bg .editorial-image { width: 100%; height: 100%; object-fit: cover; }
  .about-mission__inner {
    position: relative; z-index: 1; max-width: 48rem;
  }
  .about-mission__eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--haldi);
  }
  .about-mission__title {
    margin-top: 0.875rem; font-family: var(--font-display); font-style: italic;
    font-size: clamp(1.75rem, 4vw, 3.25rem); line-height: 1.15;
    color: var(--paper); text-wrap: balance;
  }
  .about-mission__sub {
    margin-top: 1.5rem; color: rgba(250, 248, 241, 0.78);
    line-height: 1.7; max-width: 60ch;
  }
  .about-mission__cta { margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* ===== COMPANY PLATE ===== */
  .company-plate-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  /* V7: a formal ledger reads at 56rem, not stretched across 1400px. */
  .company-plate { max-width: 56rem; }
  .company-plate__head { margin-bottom: 2rem; }
  .company-plate dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
  .company-plate dd { color: var(--fg); }
  .company-plate__address { white-space: pre-line; }
</style>

<!-- ===== HERO (V7: 5/7 — brand identity left, real product plate right) ===== -->
<section class="about-hero bg-limewash" aria-labelledby="about-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>About</span>
    </nav>
    <div class="about-hero__container" data-reveal>
      <div class="about-hero__lockup">
        <span class="about-hero__deva">${e(COMPANY.devanagari)}</span>
        <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
        <h1 class="about-hero__title" id="about-title">Nature. Culture. Useful materials.</h1>
        <p class="about-hero__body">
          ${e(COMPANY.legalName)} makes Prakritik Paint — a cow dung-based
          paint in two formats, Distemper and Emulsion, for interior and
          exterior walls. The company is based in ${e(address[3] || '')},
          ${e(address[4] || '')}, Uttar Pradesh.
        </p>
      </div>
      <div class="about-hero__plate">
        <div class="about-hero__plate-head">
          <img class="about-hero__plate-mark"
               src="${assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth)}"
               alt="Gaurikrit brand mark"
               width="40" height="40"
               loading="eager" decoding="async">
          <div class="about-hero__plate-brand">
            गौरीकृत
            <small>Prakritik Paint</small>
          </div>
        </div>
        <img class="about-hero__plate-photo"
             src="${assetUrl('/assets/products/prakritik-group.jpg', depth)}"
             alt="Prakritik Distemper and Emulsion paint packs"
             width="1280" height="621"
             loading="eager" fetchpriority="high" decoding="async">
      </div>
    </div>
  </div>
</section>

<!-- ===== WHO WE ARE — legal identity ===== -->
<section class="section section--paper about-wrap" aria-labelledby="who-title">
  <div class="container">
    <div class="about-section" data-reveal>
      <div>
        <span class="about-section__eyebrow">Who we are</span>
        <p class="about-section__lead">
          ${e(COMPANY.legalName)} — a One Person Company registered in
          ${e(address[4] || '')}, ${e(address[5] || '')}.
        </p>
      </div>
      <div class="about-section__body">
        <p>
          ${e(COMPANY.name)} makes Prakritik Paint, a cow dung-based
          paint in two formats: Prakritik Distemper and Prakritik
          Emulsion. Both are matt finish, listed for interior and
          exterior use.
        </p>
        <p>
          The company carries an old Indian material idea — cow dung on walls —
          into a contemporary paint format. A useful
          material, reconsidered for modern walls.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== WHAT WE CURRENTLY PRESENT — 2 real product photos ===== -->
<section class="section section--limewash about-products-section" aria-labelledby="present-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">What we currently present</span>
      <h2 class="section-heading__title" id="present-title">Two paint formats.</h2>
      <p class="section-heading__desc">
        Cow dung-based, matt finish, interior &amp; exterior usage.
      </p>
    </div>

    <div class="about-products" data-reveal-stagger>
      <article class="about-product-card">
        <div class="about-product-card__media about-product-card__media--distemper">
          <img class="about-product-photo"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="${e(distemper.name)}"
               width="490" height="621"
               loading="lazy" decoding="async">
        </div>
        <h3 class="about-product-card__name">${e(distemper.name)}</h3>
        <p class="about-product-card__desc">
          ${e(distemper.packagingShort)} packs · ${e(distemper.coverage)} coverage · ${e(distemper.finish)} finish.
        </p>
        <a class="about-product-card__link" href="${relUrl(distemper.route, depth)}">View Distemper →</a>
      </article>
      <article class="about-product-card">
        <div class="about-product-card__media about-product-card__media--emulsion">
          <img class="about-product-photo"
               src="${assetUrl(emulsion.officialImage, depth)}"
               alt="${e(emulsion.name)}"
               width="450" height="621"
               loading="lazy" decoding="async">
        </div>
        <h3 class="about-product-card__name">${e(emulsion.name)}</h3>
        <p class="about-product-card__desc">
          ${e(emulsion.packagingShort)} packs · ${e(emulsion.coverage)} coverage · ${e(emulsion.finish)} finish.
        </p>
        <a class="about-product-card__link" href="${relUrl(emulsion.route, depth)}">View Emulsion →</a>
      </article>
    </div>
  </div>
</section>

<!-- ===== MATERIAL DIRECTION — the raw material surface ===== -->
<section class="section section--paper about-direction-section" aria-labelledby="direction-title">
  <div class="container">
    <div class="about-section" data-reveal>
      <div>
        <span class="about-section__eyebrow">Material direction</span>
        <p class="about-section__lead">
          An old Indian material idea, carried into a contemporary paint format.
        </p>
        <div class="about-section__body">
          <p>
            Cow dung has been used on Indian walls and floors for generations.
            Gaurikrit offers cow dung-based Prakritik Paint in two formats.
          </p>
          <p>
            The cow is in the material. The wall is where it goes.
          </p>
        </div>
        <div class="about-mission__cta" style="margin-top: 1.5rem;">
          <a class="btn btn--primary" href="${relUrl('/why-prakritik/', depth)}">Why Prakritik</a>
        </div>
      </div>
      <div class="about-direction__visual">
        ${rawMaterialDirectionPic}
      </div>
    </div>
  </div>
</section>

<!-- ===== MISSION BAND — rural-landscape engraving ===== -->
<section class="about-mission" aria-labelledby="about-mission-title">
  <div class="about-mission__bg" aria-hidden="true">
    ${ruralMissionPic}
  </div>
  <div class="container">
    <div class="about-mission__inner" data-reveal>
      <span class="about-mission__eyebrow">Our direction</span>
      <h2 class="about-mission__title" id="about-mission-title">
        ${e(COMPANY.mission)}
      </h2>
      <p class="about-mission__sub">
        ${e(COMPANY.brandLine)}
      </p>
      <div class="about-mission__cta">
        <a class="btn btn--haldi" href="${relUrl('/products/', depth)}">Explore Prakritik Paint</a>
        <a class="btn btn--secondary" href="${relUrl('/contact/', depth)}">Talk to Us</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== COMPANY INFORMATION — modern ledger plate ===== -->
<section class="section section--paper company-plate-section" aria-labelledby="company-info-title">
  <div class="container">
    <div class="company-plate__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Company information</span>
      <h2 class="section-heading__title" id="company-info-title">A registered Indian company.</h2>
    </div>

    <dl class="company-plate" data-reveal>
      <div class="company-plate__row">
        <dt>Legal name</dt>
        <dd>${e(COMPANY.legalName)}</dd>
      </div>
      <div class="company-plate__row">
        <dt>Brand name</dt>
        <dd>${e(COMPANY.name)} · ${e(COMPANY.devanagari)}</dd>
      </div>
      <div class="company-plate__row">
        <dt>GSTIN</dt>
        <dd>${e(COMPANY.gstin)}</dd>
      </div>
      <div class="company-plate__row">
        <dt>Email</dt>
        <dd>
          <a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a>
        </dd>
      </div>
${phoneRows}
      <div class="company-plate__row">
        <dt>Registered address</dt>
        <dd class="company-plate__address">${e(addressLine)}</dd>
      </div>
    </dl>

    <div class="company-info__actions" style="margin-top: 2.5rem;">
      <a class="btn btn--primary" href="${relUrl('/contact/', depth)}">Talk to Us</a>
      <a class="btn btn--outline" href="${relUrl('/for-business/', depth)}">For Business</a>
    </div>
  </div>
</section>
`;
}

// ---- For Business — V4 ----
function forBusinessBody(depth) {
    const phones = COMPANY.phones;

    const audiences = [
        { num: '01', title: 'Architects & Builders',
          desc: 'Discuss product and project requirements for residential, commercial, or institutional work.' },
        { num: '02', title: 'Institutions / CSR',
          desc: 'Talk to Gaurikrit about institutional or sustainability-led projects.' },
        { num: '03', title: 'CSR / NGOs',
          desc: 'Discuss sustainability-led projects and community paint programmes.' },
        { num: '04', title: 'Gaushalas / Partners',
          desc: 'Explore collaboration around cow-dung-based bio-products.' },
    ];

    const helpfulInclude = [
        { label: 'Project type',      hint: 'Residential / Commercial / Institutional / CSR-NGO / Gaushala / Other' },
        { label: 'City',              hint: 'Where the site is located' },
        { label: 'Approximate wall area', hint: 'In sq.ft. if you have a number' },
        { label: 'Paint format',      hint: 'Distemper, Emulsion, or not sure yet' },
        { label: 'Approximate requirement', hint: 'Approximate quantity, if known' },
    ];

    const audienceCards = audiences.map((a) => `        <div class="audience-card">
          <span class="audience-card__num">${e(a.num)}</span>
          <h3 class="audience-card__title">${e(a.title)}</h3>
          <p class="audience-card__desc">${e(a.desc)}</p>
        </div>`).join('\n');

    const helpfulItems = helpfulInclude.map((item) => `        <li class="biz-practical__item">
          <span class="biz-practical__item-label">${e(item.label)}</span>
          <span class="biz-practical__item-hint">${e(item.hint)}</span>
        </li>`).join('\n');

    const phoneAsideRows = phones.map((phone) => `        <div class="biz-aside-card__row">
          <dt>Phone</dt>
          <dd><a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a></dd>
        </div>`).join('\n');

    const projectTypeOptions = PROJECT_TYPES.map(
        (type) => `                <option value="${e(type)}">${e(type)}</option>`,
    ).join('\n');

    // V4 picture tags.
    const archHeroPic = `<picture><source type="image/webp" srcset="${assetUrl('/assets/editorial/business-context-study.webp', depth)}"><img class="editorial-image" src="${assetUrl('/assets/editorial/business-context-study.jpg', depth)}" alt="Architectural building elevation study" width="1344" height="768" loading="eager" decoding="async"></picture>`;

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO (text left / architectural-elevation right — NO floating blob) ===== */
  .biz-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  @media (min-width: 1024px) { .biz-hero { padding-bottom: 2.5rem; } }
  .biz-hero__container { display: grid; gap: 2rem; align-items: center; }
  @media (min-width: 1024px) {
    .biz-hero__container { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-hero__lockup { max-width: 42rem; }
  .biz-hero__art {
    position: relative; aspect-ratio: 1344/768; background: var(--paper-cool);
    border-radius: var(--r-panel); overflow: hidden;
  }
  .biz-hero__art .editorial-image {
    width: 100%; height: 100%; object-fit: cover; display: block;
  }

  /* ===== AUDIENCES (shared editorial image + 4 ruled columns) ===== */
  .biz-audiences-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-audiences__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== PRACTICAL SECTION ===== */
  .biz-practical { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-practical__grid {
    display: grid; gap: 2rem; align-items: start;
  }
  @media (min-width: 768px) {
    .biz-practical__grid { grid-template-columns: 5fr 7fr; gap: 3rem; }
  }
  .biz-practical__head { max-width: 36rem; }
  .biz-practical__title {
    font-family: var(--font-display); font-size: clamp(1.75rem, 4vw, 2.5rem);
    line-height: 1.1; letter-spacing: -0.02em; text-wrap: balance;
  }
  .biz-practical__body {
    margin-top: 1rem; color: var(--fg-muted); line-height: 1.65;
  }
  .biz-practical__list {
    display: grid; gap: 0;
    border-top: 1px solid var(--border);
  }
  .biz-practical__item {
    display: grid; gap: 0.5rem; padding: 1rem 0;
    border-bottom: 1px solid var(--border);
    grid-template-columns: 1fr;
  }
  @media (min-width: 768px) {
    .biz-practical__item { grid-template-columns: 14rem 1fr; gap: 1rem; align-items: baseline; }
  }
  .biz-practical__item-label {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .biz-practical__item-hint { font-size: 0.9375rem; color: var(--fg); }

  /* ===== FORM (12-col: left 4 help/contact, right 8 fields) ===== */
  .biz-form-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .biz-form-layout__aside { display: flex; flex-direction: column; gap: 1.5rem; }
  .biz-form-layout__aside .help-cta { padding: 1.5rem; }
  .biz-form-card {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 1.5rem;
  }
  @media (min-width: 768px) { .biz-form-card { padding: 2rem; } }
  .biz-form-card__intro { font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 1.5rem; }
  .biz-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.25rem; }
  .biz-aside-card {
    border-top: 1px solid var(--border); padding: 0; background: transparent;
  }
  .biz-aside-card__row { padding-block: 1rem; border-bottom: 1px solid var(--border); }
  .biz-aside-card dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
</style>

<!-- ===== HERO ===== -->
<section class="biz-hero bg-limewash" aria-labelledby="biz-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>For Business</span>
    </nav>
    <div class="biz-hero__container" data-reveal>
      <div class="biz-hero__lockup">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>For Business</span>
        <hr class="biz-hero__rule">
        <h1 class="biz-hero__title" id="biz-title">Discuss a project with Gaurikrit.</h1>
        <p class="biz-hero__sub">
          For architects, builders, institutions, CSR programmes, NGOs and
          Gaushalas. Tell us about the project — site, scale, and what you are
          painting — and we will talk through Prakritik Distemper and Emulsion
          for your context.
        </p>
        <div class="biz-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#enquire">Discuss a Project</a>
          <a class="btn btn--outline" href="${relUrl('/products/', depth)}">Explore Products</a>
        </div>
      </div>
      <div class="biz-hero__art" aria-hidden="true">
        ${archHeroPic}
      </div>
    </div>
  </div>
</section>

<!-- ===== AUDIENCES — shared editorial image + 4 ruled columns ===== -->
<section class="section section--paper biz-audiences-section" aria-labelledby="audiences-title">
  <div class="container">
    <div class="biz-audiences__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Who this is for</span>
      <h2 class="section-heading__title" id="audiences-title">Audiences.</h2>
    </div>

    <div class="biz-audiences" data-reveal-stagger>
${audienceCards}
    </div>
  </div>
</section>

<!-- ===== PRACTICAL SECTION — "When you enquire, it helps to include" ===== -->
<section class="section section--limewash biz-practical" aria-labelledby="include-title">
  <div class="container">
    <div class="biz-practical__grid" data-reveal>
      <div class="biz-practical__head">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>Practical</span>
        <h2 class="biz-practical__title" id="include-title">Include these details for a faster response.</h2>
        <p class="biz-practical__body">
          A few project details help Gaurikrit understand your requirement
          before responding.
        </p>
      </div>
      <ul class="biz-practical__list">
${helpfulItems}
      </ul>
    </div>
  </div>
</section>

<!-- ===== FORM (12-col) ===== -->
<section class="section section--paper biz-form-section" id="enquire" aria-labelledby="form-title">
  <div class="container">
    <div class="biz-form-layout" data-reveal>
      <!-- LEFT 4 col: heading/help/direct contact -->
      <aside class="biz-form-layout__aside">
        <div>
          <span class="biz-form-card__eyebrow">Project enquiry</span>
          <h2 class="biz-form-card__title" id="form-title">Discuss a Project.</h2>
          <p class="biz-form-card__note">
            Tell us about the site and the wall. We will respond with what we
            can practically supply — pack sizes, format, and how Prakritik Paint
            fits your project.
          </p>
        </div>

        <div class="help-cta">
          <h3 class="help-cta__title">Prefer to talk first?</h3>
          <p class="help-cta__sub">
            Call ${e(phones[0] || '')} or email ${e(COMPANY.email)}.
          </p>
          <div class="help-cta__btn">
            <a class="btn btn--secondary btn--block" href="${relUrl('/contact/', depth)}">Contact Gaurikrit</a>
          </div>
        </div>

        <dl class="biz-aside-card">
${phoneAsideRows}
          <div class="biz-aside-card__row">
            <dt>Email</dt>
            <dd><a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a></dd>
          </div>
          <div class="biz-aside-card__row">
            <dt>Location</dt>
            <dd>${e(COMPANY.address[3] || '')}, ${e(COMPANY.address[4] || '')}</dd>
          </div>
        </dl>
      </aside>

      <!-- RIGHT 8 col: form fields -->
      
           
      <form class="biz-form-card" action="mailto:seva@gaurikrit.com" method="post"
            data-business-form novalidate>
        <p class="biz-form-card__intro">
          Fields marked <span class="req">*</span> are required.
        </p>

        <div class="form-grid">
          <div class="form-field">
            <label class="form-label" for="biz-name">Name <span class="req">*</span></label>
            <input class="form-input" type="text" id="biz-name" name="name"
                   required maxlength="80" autocomplete="name">
            <div class="form-error" data-error-for="name" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-phone">Phone <span class="req">*</span></label>
            <input class="form-input" type="tel" id="biz-phone" name="phone"
                   required maxlength="20" autocomplete="tel"
                   placeholder="+91 ...">
            <div class="form-error" data-error-for="phone" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-email">Email <span class="req">*</span></label>
            <input class="form-input" type="email" id="biz-email" name="email"
                   required maxlength="254" autocomplete="email">
            <div class="form-error" data-error-for="email" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-organisation">Organisation</label>
            <input class="form-input" type="text" id="biz-organisation"
                   name="organisation" maxlength="120" autocomplete="organization">
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-role">Role</label>
            <input class="form-input" type="text" id="biz-role" name="role"
                   maxlength="80" autocomplete="organization-title">
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-city">City <span class="req">*</span></label>
            <input class="form-input" type="text" id="biz-city" name="city"
                   required maxlength="80" autocomplete="address-level2">
            <div class="form-error" data-error-for="city" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-project-type">Project type <span class="req">*</span></label>
            <select class="form-select" id="biz-project-type" name="project_type" required>
              <option value="" disabled selected>Choose…</option>
${projectTypeOptions}
            </select>
            <div class="form-error" data-error-for="project_type" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="biz-requirement">Approximate requirement</label>
            <input class="form-input" type="text" id="biz-requirement"
                   name="approximate_requirement" maxlength="100"
                   placeholder="e.g. 20 packs / 80 litres / not sure yet">
          </div>
          <div class="form-field form-field--full">
            <label class="form-label" for="biz-message">About the project <span class="req">*</span></label>
            <textarea class="form-textarea" id="biz-message" name="message" required
                      maxlength="2000" rows="6"
                      placeholder="Tell us about the site, the walls, and what you are painting."></textarea>
            <div class="form-error" data-error-for="message" role="alert"></div>
          </div>
        </div>

        <div class="calc-actions">
          <button type="submit" class="btn btn--primary btn--lg">
            <span data-submit-label>Discuss a Project</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
`;
}

// ---- Paint Calculator — V4 ----
function paintCalculatorBody(depth) {
    // V4: real interior-wall-study background layer behind the interactive
    // calculator-wall-scene SVG (kept). The picture loads eager so the
    // environment is visible immediately; the SVG sits on top at z-index 1.
    const interiorWallPic = `<picture><source type="image/webp" srcset="${assetUrl('/assets/editorial/interior-wall-study.webp', depth)}"><img class="visual-env" src="${assetUrl('/assets/editorial/interior-wall-study.jpg', depth)}" alt="" width="1344" height="768" loading="eager" decoding="async"></picture>`;

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* ===== HERO ===== */
  .calc-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .calc-hero__inner { display: grid; gap: 1rem; max-width: 60rem; }
  .calc-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .calc-hero__eyebrow-dot {
    display: inline-block; width: 0.375rem; height: 0.375rem;
    border-radius: 50%; background: var(--haldi);
  }
  .calc-hero__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: -0.02em;
    text-wrap: balance; line-height: 1.05;
  }
  .calc-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); max-width: 60ch;
  }

  /* ===== CALCULATOR PAGE — 42% sticky visual / 58% steps ===== */
  .calculator-page {
    padding-top: clamp(2rem, 4vw, 3rem);
    padding-bottom: clamp(4rem, 7vw, 6rem);
    display: grid; gap: 2.5rem;
  }
  @media (min-width: 1024px) {
    .calculator-page {
      grid-template-columns: 42fr 58fr;
      align-items: start;
    }
  }
  @media (max-width: 1023px) {
    .calculator-page { grid-template-columns: 1fr; }
  }
  /* V4: sticky visual = real interior-wall-study behind the interactive SVG.
     The SVG stays interactive; the photo gives the wall environment. */
  .calculator-page__visual {
    position: sticky; top: calc(var(--header-h) + 1rem);
    background: var(--limewash); border: 1px solid var(--border);
    border-radius: var(--r-panel); aspect-ratio: 4/3;
    display: flex; align-items: center; justify-content: center;
    padding: 0; overflow: hidden;
  }
  @media (max-width: 1023px) {
    .calculator-page__visual { position: relative; top: auto; aspect-ratio: 16/9; }
  }
  .calculator-page__visual .visual-env {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.55;
    pointer-events: none;
  }
  .calculator-page__visual svg {
    position: relative; z-index: 1;
    width: 86%; height: 86%; display: block;
  }

  /* The actual calculator mount — JS builds the UI inside it. */
  .calculator-page__steps { display: grid; gap: 1.5rem; }

  /* Override the JS-built .calc-step / .calc-result styles to match V3. */
  .calc-step {
    padding: 1.5rem; background: var(--paper);
    border: 1px solid var(--border); border-radius: var(--r-panel);
    transition: border-color var(--dur);
  }
  .calc-step[data-selected="true"] {
    border-color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 6%, var(--paper));
  }
  .calc__cards { display: grid; gap: 0.75rem; margin-top: 1rem; }
  @media (min-width: 640px) { .calc__cards { grid-template-columns: 1fr 1fr; } }
  .calc__card {
    padding: 1rem 1.25rem; border: 1.5px solid var(--border-strong);
    background: var(--paper); border-radius: var(--r-btn);
    text-align: left; cursor: pointer; min-height: 44px;
    display: flex; flex-direction: column; gap: 0.25rem;
    transition: background var(--dur), border-color var(--dur), color var(--dur);
  }
  .calc__card:hover { border-color: var(--forest); color: var(--forest); }
  .calc__card[aria-pressed="true"] {
    background: color-mix(in srgb, var(--haldi) 18%, var(--paper));
    border-color: var(--forest); color: var(--forest);
  }
  .calc__card-title { font-weight: 600; font-size: 1rem; }
  .calc__card-desc  { font-size: 0.8125rem; color: var(--fg-muted); }

  /* Progress indicator styling */
  .calc__progress {
    list-style: none; display: flex; gap: 0.5rem; margin: 0 0 1.5rem;
    padding: 0; flex-wrap: wrap;
  }
  .calc__progress-item { display: flex; align-items: center; gap: 0.5rem; }
  .calc__progress-btn {
    background: transparent; border: 0; padding: 0;
    display: flex; align-items: center; gap: 0.5rem;
    cursor: pointer; color: var(--fg-muted);
    font-size: 0.875rem; font-weight: 500;
  }
  .calc__progress-btn[disabled] { cursor: not-allowed; opacity: 0.5; }
  .calc__progress-dot {
    display: inline-flex; align-items: center; justify-content: center;
    width: 1.5rem; height: 1.5rem; border-radius: 50%;
    border: 1.5px solid var(--border-strong);
    font-family: var(--font-display); font-weight: 700; font-size: 0.75rem;
    color: var(--fg-muted);
  }
  .calc__progress-item.is-current .calc__progress-dot {
    border-color: var(--forest); color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 18%, var(--paper));
  }
  .calc__progress-item.is-done .calc__progress-dot {
    background: var(--forest); border-color: var(--forest); color: var(--paper);
  }

  .calc__step { padding: 0; background: transparent; border: 0; }
  .calc__step-title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2rem);
    margin-bottom: 0.5rem;
  }
  .calc__step-help { color: var(--fg-muted); margin-bottom: 1rem; font-size: 0.9375rem; }
  .calc__field { margin-bottom: 1.25rem; }
  .calc__result-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--haldi); }
  .calc__result-list { display: grid; gap: 0; margin-top: 1rem; }
  .calc__result-row {
    display: flex; justify-content: space-between; align-items: baseline;
    gap: 1rem; padding-block: 0.75rem;
    border-bottom: 1px solid rgba(250, 248, 241, 0.18);
  }
  .calc__result-key { color: rgba(250, 248, 241, 0.78); font-size: 0.875rem; }
  .calc__result-val {
    font-family: var(--font-display); font-weight: 700; color: var(--haldi);
    font-size: 1.125rem;
  }
  .calc__result-note {
    margin-top: 1rem; font-size: 0.8125rem;
    color: rgba(250, 248, 241, 0.6); line-height: 1.5;
  }
  .calc__result-cta-copy {
    margin-top: 0.5rem; font-size: 0.9375rem; color: rgba(250, 248, 241, 0.85);
  }
  .calc__result-actions { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.5rem; }

  /* Helper / contact aside — V7: hidden by default, revealed ONLY after
     the user completes all four calculator steps. */
  .calc-helper {
    display: none;
    margin-top: 2.5rem; padding: 1.5rem;
    background: var(--limewash); border-left: 3px solid var(--haldi);
    border-radius: var(--r-input);
  }
  .calc-helper.is-shown { display: block; }
</style>

<!-- ===== HERO ===== -->
<section class="calc-hero bg-limewash" aria-labelledby="calc-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Calculator</span>
    </nav>
    <div class="calc-hero__inner" data-reveal>
      <span class="calc-hero__eyebrow">
        <span class="calc-hero__eyebrow-dot" aria-hidden="true"></span>
        Estimate your project
      </span>
      <hr class="calc-hero__rule">
      <h1 class="calc-hero__title" id="calc-title">Planning to paint?</h1>
      <p class="calc-hero__sub">
        Walk through four quick choices — what you are painting, where, which
        Prakritik format, and how much wall area. We summarise the project for
        you to send to Gaurikrit.
      </p>
    </div>
  </div>
</section>

<!-- ===== CALCULATOR PAGE — 42% sticky visual / 58% steps ===== -->
<section class="bg-limewash" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-page" data-reveal>
      <!-- LEFT: sticky interactive wall scene (SVG kept) -->
      <div class="calculator-page__visual" aria-hidden="true">
        ${interiorWallPic}
        ${loadSvg('calculator-wall-scene')}
      </div>

      <!-- RIGHT: 4-step calculator mount -->
      <div class="calculator-page__steps">
        <script type="application/json" id="calculator-config">{"enabled":false}</script>
        <div data-calculator></div>

        <div class="calc-helper" data-calc-helper>
          <h2 class="calc-helper__title">Need a more specific estimate?</h2>
          <p class="calc-helper__body">
            Send the project summary to Gaurikrit and we will respond with what
            we can practically supply for your site.
          </p>
          <div class="calc-helper__actions">
            <a class="btn btn--secondary" href="${relUrl('/contact/', depth)}?interest=bulk-project">Talk to Us</a>
            <a class="btn btn--outline" href="${relUrl('/products/', depth)}">Explore Products</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- V7: reveal the calc-helper only after the result panel becomes visible. -->
<script>
(function () {
  'use strict';
  var helper = document.querySelector('[data-calc-helper]');
  if (!helper) return;
  var shown = false;
  function check() {
    if (shown) return;
    var result = document.querySelector('[data-calc-result]');
    if (result && !result.hidden) {
      shown = true;
      helper.classList.add('is-shown');
    }
  }
  if (window.MutationObserver) {
    var mo = new MutationObserver(check);
    mo.observe(document.body, { attributes: true, attributeFilter: ['hidden'], subtree: true });
  }
  setInterval(check, 700);
  check();
})();
</script>
`;
}

// ---- Downloads — V4 ----
function downloadsBody(depth) {
    const coverImage = '/assets/documents/prakritik-paint-brochure-cover.jpg';
    const brochureUrl = '/assets/documents/prakritik-paint-brochure.pdf';
    const brochureCover = assetUrl(coverImage, depth);
    const brochurePdf = assetUrl(brochureUrl, depth);

    return `<style>
  /* ===== HERO ===== */
  .dl-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .dl-hero__inner { display: grid; gap: 1rem; max-width: 60rem; }
  .dl-hero__eyebrow {
    display: inline-flex; align-items: center; gap: 0.5rem;
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em;
    text-transform: uppercase; color: var(--primary);
  }
  .dl-hero__eyebrow-dot {
    display: inline-block; width: 0.375rem; height: 0.375rem;
    border-radius: 50%; background: var(--haldi);
  }
  .dl-hero__title {
    margin-top: 0.5rem; font-family: var(--font-display);
    font-size: clamp(2.2rem, 5vw, 4rem); letter-spacing: -0.02em;
    text-wrap: balance; line-height: 1.05;
  }
  .dl-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); max-width: 60ch;
  }

  /* ===== DOWNLOADS SPLIT — real brochure cover left, details right ===== */
  .downloads-split {
    padding-block: clamp(2.5rem, 5vw, 4rem);
  }
  /* Real brochure cover — display at its true aspect ratio (848×1200). */
  .dl-cover {
    position: relative;
    aspect-ratio: 848/1200;
    background: var(--paper-warm);
    border: 1px solid var(--border-strong);
    border-radius: var(--r-panel);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
  }
  .dl-cover .dl-cover__image {
    display: block;
    width: 100%; height: 100%;
    object-fit: contain;
  }
  .dl-cover:has(.dl-cover__image) .dl-cover__fallback { display: none; }
  .dl-cover__fallback {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 100%; height: 100%;
    text-align: center; padding: 2rem;
    color: rgba(32, 30, 25, 0.4);
    font-family: var(--font-display); font-weight: 700;
    font-size: clamp(1.5rem, 4vw, 3rem);
    line-height: 1.15; letter-spacing: 0.02em;
  }

  /* Right column — details + actions */
  .dl-card { gap: 1.25rem; }
  .brochure__detail-eyebrow {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--primary);
  }
  .brochure__detail-title {
    font-family: var(--font-display); font-size: clamp(1.5rem, 3vw, 2.25rem);
    margin-top: 0.5rem; line-height: 1.15; letter-spacing: -0.01em;
    text-wrap: balance;
  }
  .brochure__detail-desc { color: var(--fg-muted); line-height: 1.7; max-width: 60ch; }
  .brochure__detail-meta {
    display: flex; justify-content: space-between; gap: 1rem;
    padding-block: 0.75rem; border-bottom: 1px solid var(--border);
    font-size: 0.9375rem;
  }
  .brochure__detail-meta:last-of-type { border-bottom: 0; }
  .brochure__detail-meta dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .brochure__detail-meta dd { color: var(--fg); }
  .brochure__detail-actions {
    display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.5rem;
  }
  .brochure__detail-note {
    margin-top: 1.25rem; font-size: 0.8125rem; color: var(--fg-muted);
    line-height: 1.6;
  }

  /* Missing brochure note */
  .dl-missing {
    padding: 1.5rem; background: var(--limewash);
    border: 1px dashed var(--border-strong); border-radius: var(--r-panel);
    font-size: 0.9375rem; color: var(--fg-muted); line-height: 1.6;
  }
  .dl-missing strong { color: var(--fg); }

  /* ===== Brochure detection (V4 static) — JS HEAD-fetches the PDF and
     toggles data-brochure-state on the wrapper. Default (unknown /
     checking / available): show available, hide missing. State="missing":
     swap. Graceful fallback if JS fails: available block stays visible. ===== */
  [data-brochure-detect] [data-brochure-if-missing] { display: none; }
  [data-brochure-detect][data-brochure-state="missing"] [data-brochure-if-available] { display: none; }
  [data-brochure-detect][data-brochure-state="missing"] [data-brochure-if-missing] { display: block; }
</style>

<!-- ===== HERO ===== -->
<section class="dl-hero bg-limewash" aria-labelledby="dl-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Downloads</span>
    </nav>
    <div class="dl-hero__inner" data-reveal>
      <span class="dl-hero__eyebrow">
        <span class="dl-hero__eyebrow-dot" aria-hidden="true"></span>
        Brochure
      </span>
      <hr class="dl-hero__rule">
      <h1 class="dl-hero__title" id="dl-title">Prakritik Paint brochure.</h1>
      <p class="dl-hero__sub">
        Browse the supplied Prakritik Paint brochure or download a copy.
      </p>
    </div>
  </div>
</section>

<!-- ===== DOWNLOADS SPLIT ===== -->
<section class="section section--paper">
  <div class="container">
    <div class="downloads-split" data-reveal>
      <!-- LEFT — real brochure cover (848×1200) -->
      <div class="dl-cover">
        <img class="dl-cover__image"
             src="${brochureCover}"
             alt="Prakritik Paint brochure cover"
             width="848" height="1200"
             loading="eager" fetchpriority="high" decoding="async">
        <div class="dl-cover__fallback" aria-hidden="true">
          PRAKRITIK<br>PAINT<br>BROCHURE
        </div>
      </div>

      <!-- RIGHT — title + details + actions.
           V4 static: both data-brochure-if-available and
           data-brochure-if-missing blocks are present. The wrapper has
           data-brochure-state="unknown" initially. app.js's
           initBrochureDetection() HEAD-fetches the PDF and sets state
           to "available" (HEAD 2xx) or "missing" (HEAD 4xx/5xx).
           CSS shows available by default, swaps to missing on demand. -->
      <div class="dl-card" data-brochure-detect="${e(brochurePdf)}" data-brochure-state="unknown">
        <div data-brochure-if-available>
          <span class="brochure__detail-eyebrow">Current edition</span>
          <h2 class="brochure__detail-title">Prakritik Paint — product brochure.</h2>
          <p class="brochure__detail-desc">
            The brochure covers both Prakritik Distemper and Prakritik Emulsion:
            pack sizes, listed specifications, finish, drying time, coverage,
            V.O.C. and usage. Suitable for architects, builders, institutions and
            homeowners.
          </p>

          <dl>
            <div class="brochure__detail-meta">
              <dt>Format</dt><dd>PDF</dd>
            </div>
            <div class="brochure__detail-meta">
              <dt>Source</dt><dd>${e(COMPANY.name)}</dd>
            </div>
            <div class="brochure__detail-meta">
              <dt>Use</dt><dd>Read online or print</dd>
            </div>
          </dl>

          <div class="brochure__detail-actions">
            <a class="btn btn--primary btn--lg" href="${brochurePdf}"
               target="_blank" rel="noopener">View Brochure</a>
            <a class="btn btn--outline" href="${brochurePdf}" download>Download PDF</a>
          </div>
          <p class="brochure__detail-note">
            If the file does not open, the PDF may not be reachable from your
            network. Contact Gaurikrit directly for a current copy.
          </p>
        </div>
        <div data-brochure-if-missing>
          <span class="brochure__detail-eyebrow">Brochure pending</span>
          <h2 class="brochure__detail-title">The current brochure is not yet published here.</h2>
          <p class="brochure__detail-desc">
            Please contact Gaurikrit for a copy of the product brochure.
          </p>
          <div class="brochure__detail-actions">
            <a class="btn btn--primary btn--lg" href="${relUrl('/contact/', depth)}?interest=general">Contact Gaurikrit for the current product brochure</a>
          </div>
          <p class="brochure__detail-note">
            In the meantime, product specifications for both formats are listed
            on the Distemper and Emulsion detail pages.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
`;
}

// ---- Contact — V4 ----
function contactBody(depth) {
    const address = COMPANY.address;
    const phones = COMPANY.phones;
    const addressLine = address.join('\n');

    const phoneRows = phones.map((phone) => `          <div class="contact-info__row">
            <dt>Phone</dt>
            <dd>
              <a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a>
            </dd>
          </div>`).join('\n');

    const interestOptions = Object.entries(INTEREST_OPTIONS).map(
        ([key, label]) => `                <option value="${e(key)}">${e(label)}</option>`,
    ).join('\n');

    return `<style>
  /* ===== HERO (V7: 7/5 — copy left, direct-lines plate right) ===== */
  .contact-hero { padding-top: calc(var(--header-h) + clamp(1.25rem, 3vw, 2rem)); padding-bottom: clamp(1.25rem, 3vw, 2rem); }
  .contact-hero__container { display: grid; gap: clamp(1.5rem, 4vw, 3rem); align-items: start; }
  @media (min-width: 1024px) {
    .contact-hero__container { grid-template-columns: 7fr 5fr; align-items: center; }
  }
  .contact-hero__lockup { max-width: 42rem; }
  .contact-hero__title {
    font-family: var(--font-display); font-size: clamp(2.2rem, 5vw, 4rem);
    line-height: 1.05; letter-spacing: -0.02em; text-wrap: balance;
    margin-top: 0.5rem;
  }
  .contact-hero__sub {
    margin-top: 1rem; color: var(--fg-muted);
    font-size: clamp(1rem, 2vw, 1.125rem); line-height: 1.65; max-width: 60ch;
  }
  .contact-direct {
    display: flex; flex-direction: column; gap: 0;
    background: var(--paper);
    border: 1px solid var(--border);
    border-radius: var(--r-panel);
    box-shadow: 0 2px 12px -4px rgba(32, 30, 25, 0.06);
    padding: 1.5rem 1.5rem 1.25rem;
  }
  @media (min-width: 768px) { .contact-direct { padding: 2rem 2rem 1.5rem; } }
  .contact-direct__head {
    display: flex; align-items: center; gap: 0.75rem;
    padding-bottom: 1rem; border-bottom: 1px solid var(--border);
  }
  .contact-direct__mark { width: 44px; height: 44px; flex: none; object-fit: contain; }
  .contact-direct__brand {
    font-family: var(--font-deva); font-size: 1rem; color: var(--haldi-deep);
    line-height: 1.2;
  }
  .contact-direct__brand small {
    display: block; font-family: var(--font-sans); font-size: 0.625rem;
    font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase;
    color: var(--fg-muted); margin-top: 0.125rem;
  }
  .contact-direct__row {
    padding: 0.875rem 0; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.125rem;
  }
  .contact-direct__row:last-child { border-bottom: 0; }
  .contact-direct__row dt {
    font-size: 0.6875rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-direct__row dd { font-size: 1rem; color: var(--fg); }
  .contact-direct__row dd a {
    color: var(--primary); text-decoration: none; font-weight: 600;
    min-height: 24px; display: inline-block;
  }
  .contact-direct__row dd a:hover { text-decoration: underline; }

  /* ===== CONTACT SECTION (5 / 7 — info left, form right) ===== */
  .contact-section { padding-top: clamp(1.5rem, 3vw, 2.5rem); }

  /* Contact info as a modern plate / ledger (ruled rows, no card chrome). */
  .contact-info {
    padding: 0; background: transparent; border: 0;
    border-top: 1px solid var(--border); border-radius: 0; box-shadow: none;
  }
  .contact-info__row {
    padding-block: 1rem; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.25rem;
    align-items: baseline;
  }
  @media (min-width: 640px) {
    .contact-info__row { grid-template-columns: 11rem 1fr; gap: 1rem; }
  }
  .contact-info__row dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-info__row dd { font-size: 0.9375rem; color: var(--fg); }
  .contact-info__address { white-space: pre-line; }
  /* V7: subtle links instead of redundant CTA buttons. */
  .contact-info__links {
    margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid var(--border);
    display: flex; flex-wrap: wrap; gap: 0.625rem; align-items: center;
    font-size: 0.875rem; color: var(--fg-muted);
  }
  .contact-info__links a { color: var(--primary); text-decoration: none; font-weight: 600; }
  .contact-info__links a:hover { text-decoration: underline; }
  .contact-info__links span { color: var(--border-strong); }

  /* Form (right). */
  .contact-form {
    background: var(--paper); border: 1px solid var(--border);
    border-radius: var(--r-panel); padding: 1.5rem;
    box-shadow: 0 8px 24px -8px rgba(34, 36, 27, 0.12);
  }
  @media (min-width: 768px) { .contact-form { padding: 2.5rem; } }
  .contact-form .form-input:focus,
  .contact-form .form-select:focus,
  .contact-form .form-textarea:focus {
    outline: 0;
    border-color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 25%, transparent);
  }
  .contact-form-card__intro {
    font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 1.5rem;
  }
  .contact-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.25rem; }
</style>

<!-- ===== HERO (V7: 7/5 — copy left, direct-lines plate right) ===== -->
<section class="contact-hero bg-limewash" aria-labelledby="contact-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Contact</span>
    </nav>
    <div class="contact-hero__container" data-reveal>
      <div class="contact-hero__lockup">
        <span class="contact-hero__eyebrow">
          <span class="contact-hero__eyebrow-dot" aria-hidden="true"></span>
          Get in touch
        </span>
        <hr class="contact-hero__rule">
        <h1 class="contact-hero__title" id="contact-title">Talk to Gaurikrit.</h1>
        <p class="contact-hero__sub">
          For product questions, project requirements or partnership enquiries,
          contact Gaurikrit directly or send a message below.
        </p>
      </div>
      <dl class="contact-direct" data-reveal>
        <div class="contact-direct__head">
          <img class="contact-direct__mark"
               src="${assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth)}"
               alt="Gaurikrit brand mark"
               width="44" height="44"
               loading="eager" decoding="async">
          <div class="contact-direct__brand">
            गौरीकृत
            <small>Gaurikrit Bio Products</small>
          </div>
        </div>
        <div class="contact-direct__row">
          <dt>Email</dt>
          <dd>
            <a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a>
            <button type="button" class="copy-btn" data-copy="${e(COMPANY.email)}" aria-label="Copy email address">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              <span class="copy-btn__label">Copy</span>
            </button>
          </dd>
        </div>
        <div class="contact-direct__row">
          <dt>Phone</dt>
          <dd>
            <a href="tel:${e(phones[0].replace(/ /g, ''))}">${e(phones[0])}</a>
            <button type="button" class="copy-btn" data-copy="${e(phones[0].replace(/ /g, ''))}" aria-label="Copy phone number">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              <span class="copy-btn__label">Copy</span>
            </button>
          </dd>
        </div>
        <div class="contact-direct__row">
          <dt>Phone</dt>
          <dd>
            <a href="tel:${e(phones[1].replace(/ /g, ''))}">${e(phones[1])}</a>
            <button type="button" class="copy-btn" data-copy="${e(phones[1].replace(/ /g, ''))}" aria-label="Copy phone number">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
              <span class="copy-btn__label">Copy</span>
            </button>
          </dd>
        </div>
        <div class="contact-direct__row">
          <dt>Location</dt>
          <dd>Khurja, District Bulandshahr<br>Uttar Pradesh</dd>
        </div>
      </dl>
    </div>
  </div>
</section>

<!-- ===== CONTACT SECTION — 5 / 7 (info left / form right) ===== -->
<section class="section section--paper" style="padding-top: clamp(2rem, 4vw, 3rem);">
  <div class="container">
    <div class="contact-section" data-reveal>
      <!-- LEFT — company info / contact plate -->
      <aside>
        <span class="contact-hero__eyebrow">Direct lines</span>
        <h2 class="spec-sheet__title" style="margin-top: 0.5rem;">Company &amp; contact.</h2>

        <dl class="contact-info">
          <div class="contact-info__row">
            <dt>Legal name</dt>
            <dd>${e(COMPANY.legalName)}</dd>
          </div>
          <div class="contact-info__row">
            <dt>GSTIN</dt>
            <dd>${e(COMPANY.gstin)}</dd>
          </div>
          <div class="contact-info__row">
            <dt>Email</dt>
            <dd>
              <a href="mailto:${e(COMPANY.email)}">${e(COMPANY.email)}</a>
            </dd>
          </div>
${phoneRows}
          <div class="contact-info__row">
            <dt>Address</dt>
            <dd class="contact-info__address">${e(addressLine)}</dd>
          </div>
        </dl>

        <!-- V7: one subtle link row instead of competing CTA buttons. -->
        <p class="contact-info__links">
          <a href="${relUrl('/for-business/', depth)}">For Business</a>
          <span aria-hidden="true">·</span>
          <a href="${relUrl('/paint-calculator/', depth)}">Painting Calculator</a>
        </p>
      </aside>

      <!-- RIGHT — enquiry form. Static demo uses a safe email fallback. -->
      <form class="contact-form" action="mailto:seva@gaurikrit.com" method="post"
            data-contact-form novalidate>
        <p class="contact-form-card__intro">
          Fields marked <span class="req">*</span> are required.
        </p>

        <div class="form-grid">
          <div class="form-field">
            <label class="form-label" for="contact-name">Name <span class="req">*</span></label>
            <input class="form-input" type="text" id="contact-name" name="name"
                   required maxlength="80" autocomplete="name">
            <div class="form-error" data-error-for="name" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-phone">Phone</label>
            <input class="form-input" type="tel" id="contact-phone" name="phone"
                   maxlength="20" autocomplete="tel" placeholder="+91 ...">
            <div class="form-error" data-error-for="phone" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-email">Email <span class="req">*</span></label>
            <input class="form-input" type="email" id="contact-email" name="email"
                   required maxlength="254" autocomplete="email">
            <div class="form-error" data-error-for="email" role="alert"></div>
          </div>
          <div class="form-field">
            <label class="form-label" for="contact-interest">Enquiry is about <span class="req">*</span></label>
            <select class="form-select" id="contact-interest" name="interest" required>
              <option value="" disabled selected>Choose…</option>
${interestOptions}
            </select>
            <div class="form-error" data-error-for="interest" role="alert"></div>
          </div>
          <div class="form-field form-field--full">
            <label class="form-label" for="contact-message">Message <span class="req">*</span></label>
            <textarea class="form-textarea" id="contact-message" name="message" required
                      maxlength="2000" rows="6"
                      placeholder="Tell us a bit about what you are painting."></textarea>
            <div class="form-error" data-error-for="message" role="alert"></div>
          </div>
        </div>

        <div class="calc-actions">
          <button type="submit" class="btn btn--primary btn--lg">
            <span data-submit-label>Send Enquiry</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</section>
`;
}

// ---- 404 — V4 ----
function error404Body(depth) {
    return `<style>
  .error-page {
    min-height: 80vh; display: flex; align-items: center; justify-content: flex-start;
    text-align: left; padding-block: clamp(3rem, 8vw, 6rem);
    padding-top: calc(var(--header-h) + 3rem);
    position: relative; overflow: hidden;
  }
  /* V4: field-botanicals SVG kept as small decorative accent at low opacity. */
  .error-page__bg {
    position: absolute; right: -2rem; top: 50%; transform: translateY(-50%);
    width: 22rem; height: 22rem; opacity: 0.08; z-index: 0;
    pointer-events: none; color: var(--forest);
  }
  @media (max-width: 768px) {
    .error-page__bg { width: 14rem; height: 14rem; right: -3rem; opacity: 0.06; }
  }
  .error-page__inner {
    position: relative; z-index: 1; max-width: 40rem;
  }
  /* V4: use the real official logo mark (696×700) for the brand seal.
     Falls back to the gaurikrit-cow-mark SVG if the PNG is missing. */
  .error-page__seal {
    position: relative;
    width: 4rem; height: 4rem; margin: 0 0 1.5rem;
    display: flex; align-items: center; justify-content: center;
    background: radial-gradient(circle at 50% 45%, #f9f5eb, #e7ebdf);
    border-radius: var(--r-card);
    overflow: hidden;
  }
  .error-page__seal .error-page__seal-img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: contain;
    padding: 0.375rem;
    z-index: 2;
  }
  .error-page__seal .error-page__seal-fallback {
    position: absolute; inset: 0; z-index: 1;
    display: flex; align-items: center; justify-content: center;
    color: var(--forest);
  }
  .error-page__seal .error-page__seal-fallback svg { width: 70%; height: 70%; }
  .error-page__code {
    font-family: var(--font-display); font-size: clamp(3rem, 10vw, 5.5rem);
    font-weight: 700; color: var(--primary); line-height: 1;
    letter-spacing: -0.02em;
  }
  .error-page__deva {
    font-family: var(--font-deva); font-size: clamp(1.25rem, 2.5vw, 1.625rem);
    color: var(--haldi-deep); margin-top: 0.75rem;
  }
  .error-page__msg {
    font-family: var(--font-display); font-size: clamp(1.5rem, 4vw, 2.25rem);
    margin-top: 1.25rem; color: var(--fg); line-height: 1.2;
    text-wrap: balance;
  }
  .error-page__sub {
    margin-top: 1.25rem; font-size: 1rem; color: var(--fg-muted);
    line-height: 1.7; max-width: 50ch;
  }
  .error-page__actions {
    margin-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem;
  }
  @media (min-width: 480px) {
    .error-page__actions { flex-direction: row; align-items: center; }
  }
</style>

<section class="error-page bg-limewash" aria-labelledby="error-title">
  <div class="error-page__bg" aria-hidden="true">
    ${loadSvg('field-botanicals')}
  </div>
  <div class="container">
    <div class="error-page__inner" data-reveal>
      <div class="error-page__seal" aria-hidden="true">
        <img class="error-page__seal-img"
             src="${assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth)}"
             alt=""
             width="696" height="700"
             loading="eager" decoding="async"
             onerror="this.style.visibility='hidden';">
        <span class="error-page__seal-fallback">
          ${loadSvg('gaurikrit-cow-mark')}
        </span>
      </div>
      <p class="error-page__code">404</p>
      <p class="error-page__deva">${e(COMPANY.devanagari)}</p>
      <h1 class="error-page__msg" id="error-title">
        This wall hasn't been painted yet.
      </h1>
      <p class="error-page__sub">
        The page you were looking for is not here. The wall it would have
        painted hasn't been finished — or the URL has moved. Head back to the
        Gaurikrit homepage, or explore Prakritik Paint directly.
      </p>
      <div class="error-page__actions">
        <a class="btn btn--primary btn--lg" href="${relUrl('/', depth)}">Back to Home</a>
        <a class="btn btn--outline" href="${relUrl('/products/', depth)}">Explore Products</a>
      </div>
    </div>
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
//   - pageMeta: {title, description, canonical, pageClass} — mirrors PHP pages
//   - body: function (depth) => string
const PAGES = [
    {
        route: 'index.html',
        depth: 0,
        pageMeta: {
            title: 'Gaurikrit — Prakritik Paint & Bio Products',
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
            title: 'Prakritik Paint Products — Distemper & Emulsion | Gaurikrit',
            description:
                'Two formats of Prakritik Paint: Distemper (1, 5, 10 and 20 kg packs) and Emulsion (1, 4, 10 and 20 litre packs). Matt finish, interior & exterior use. Cow-dung-based, from Gaurikrit Bio Products.',
            canonical: '/products/',
            pageClass: 'products',
        },
        body: productsBody,
    },
    {
        route: 'products/prakritik-distemper/index.html',
        depth: 2,
        pageMeta: {
            title: 'Prakritik Distemper Paint — Cow Dung-Based | Gaurikrit',
            description:
                'Prakritik Distemper Paint: cow dung-based, matt finish, 1-20 kg packs, 200 sq.ft.** coverage, Interior & Exterior usage. From Gaurikrit Bio Products, Khurja, Uttar Pradesh.',
            canonical: '/products/prakritik-distemper/',
            pageClass: 'product-distemper',
        },
        body: distemperBody,
    },
    {
        route: 'products/prakritik-emulsion/index.html',
        depth: 2,
        pageMeta: {
            title: 'Prakritik Emulsion Paint — Cow Dung-Based | Gaurikrit',
            description:
                'Prakritik Emulsion Paint: cow dung-based, matt finish, 1-20 litre packs, 300 sq.ft.** coverage, Interior & Exterior usage. From Gaurikrit Bio Products, Khurja, Uttar Pradesh.',
            canonical: '/products/prakritik-emulsion/',
            pageClass: 'product-emulsion',
        },
        body: emulsionBody,
    },
    {
        route: 'why-prakritik/index.html',
        depth: 1,
        pageMeta: {
            title: 'Why Prakritik Paint — An Old Material, Reconsidered | Gaurikrit',
            description:
                'Cow dung has been used on Indian walls for generations. Prakritik Paint carries that material into a contemporary paint format. The material, the tradition, the wall.',
            canonical: '/why-prakritik/',
            pageClass: 'why-prakritik',
        },
        body: whyPrakritikBody,
    },
    {
        route: 'about/index.html',
        depth: 1,
        pageMeta: {
            title: 'About Gaurikrit Bio Products — Nature. Culture. Useful materials.',
            description:
                'Gaurikrit Bio Products (OPC) Private Limited — Khurja, District Bulandshahr, Uttar Pradesh. Makers of Prakritik Distemper and Emulsion Paint. GSTIN 09AAMCG8400F1ZK.',
            canonical: '/about/',
            pageClass: 'about',
        },
        body: aboutBody,
    },
    {
        route: 'for-business/index.html',
        depth: 1,
        pageMeta: {
            title: 'For Business — Architects, Builders, CSR, NGOs, Gaushalas | Gaurikrit',
            description:
                'Discuss Prakritik Paint for residential, commercial, institutional, CSR / NGO and Gaushala collaboration projects with Gaurikrit Bio Products.',
            canonical: '/for-business/',
            pageClass: 'for-business',
        },
        body: forBusinessBody,
    },
    {
        route: 'paint-calculator/index.html',
        depth: 1,
        pageMeta: {
            title: 'Paint Calculator — Estimate Your Project | Gaurikrit',
            description:
                'Walk through four quick choices to estimate your Prakritik Paint project. What you are painting, where, which format, and how much wall area. Send the summary to Gaurikrit.',
            canonical: '/paint-calculator/',
            pageClass: 'paint-calculator',
        },
        body: paintCalculatorBody,
    },
    {
        route: 'downloads/index.html',
        depth: 1,
        pageMeta: {
            title: 'Downloads — Prakritik Paint Brochure | Gaurikrit',
            description:
                'View or download the Prakritik Paint brochure for Distemper and Emulsion.',
            canonical: '/downloads/',
            pageClass: 'downloads',
        },
        body: downloadsBody,
    },
    {
        route: 'contact/index.html',
        depth: 1,
        pageMeta: {
            title: 'Talk to Gaurikrit — Contact | Gaurikrit Bio Products',
            description:
                'Email, phones, address and GSTIN for Gaurikrit Bio Products (OPC) Private Limited. Send an enquiry about Prakritik Distemper, Emulsion, bulk projects, partnerships or Gaushala collaboration.',
            canonical: '/contact/',
            pageClass: 'contact',
        },
        body: contactBody,
    },
];

function build() {
    console.log('STATIC-BUILD (V4): starting static site generation for GitHub Pages.');
    console.log('STATIC-BUILD (V4): source = ' + SRC);
    console.log('STATIC-BUILD (V4): output = ' + OUT);

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
        console.log('STATIC-BUILD (V4): wrote ' + page.route + ' (' + html.length + ' bytes)');
        generated++;
    }

    // Generate 404.html at the docs root.
    const err404Body = error404Body(0);
    const err404Meta = {
        title: "404 — This wall hasn't been painted yet | Gaurikrit",
        description: "The page you were looking for has not been painted yet. Return to the Gaurikrit homepage.",
        canonical: '/',
        pageClass: 'error-404',
    };
    const err404Html = generatePage(err404Meta, 0, err404Body);
    writeFileSync(join(OUT, '404.html'), err404Html, 'utf8');
    console.log('STATIC-BUILD (V4): wrote 404.html (' + err404Html.length + ' bytes)');
    generated++;

    // Copy static assets: CSS + JS (the kept SVG illustrations — ashta-laabh-
    // seal, calculator-wall-scene, gaurikrit-cow-mark, field-botanicals —
    // are inlined directly into the HTML, so the PHP partials need not be
    // copied. The V4 picture tags reference real images in editorial/ etc.)
    const cssSrc = join(SRC, 'assets/css/app.css');
    const cssDestDir = join(OUT, 'assets/css');
    mkdirSync(cssDestDir, { recursive: true });
    copyFileSync(cssSrc, join(cssDestDir, 'app.css'));
    console.log('STATIC-BUILD (V4): copied assets/css/app.css');

    const jsSrcDir = join(SRC, 'assets/js');
    const jsDestDir = join(OUT, 'assets/js');
    mkdirSync(jsDestDir, { recursive: true });
    const jsFiles = readdirSync(jsSrcDir).filter((f) => f.endsWith('.js'));
    for (const f of jsFiles) {
        copyFileSync(join(jsSrcDir, f), join(jsDestDir, f));
        console.log('STATIC-BUILD (V4): copied assets/js/' + f);
    }

    // Copy ALL V4 asset directories to docs/assets/.
    // brand/ — gaurikrit-logo-full.png + gaurikrit-logo-mark.png
    // products/ — prakritik-group.jpg, prakritik-distemper.jpg, prakritik-emulsion.jpg
    // editorial/ — 12 files (6 editorial images × 2 formats: webp + jpg)
    // documents/ — prakritik-paint-brochure.pdf + prakritik-paint-brochure-cover.jpg
    // illustrations/ — legacy SVG fallbacks (zebu-study.png, courtyard-study.png + webp)
    // social/ — 10 OG images (og-home.jpg, og-products.jpg, etc.)
    // fonts/ — 3 woff2 files (noto-serif-devanagari, manrope-latin, newsreader-latin)
    for (const dir of ['brand', 'products', 'editorial', 'documents', 'illustrations', 'social', 'fonts']) {
        cpSync(join(SRC, 'assets', dir), join(OUT, 'assets', dir), { recursive: true });
        console.log('STATIC-BUILD (V4): copied assets/' + dir + '/');
    }

    // Favicon + manifest files (root-level static assets).
    for (const file of ['favicon.ico', 'favicon-16x16.png', 'favicon-32x32.png', 'favicon-48x48.png',
        'apple-touch-icon.png', 'android-chrome-192x192.png', 'android-chrome-512x512.png', 'site.webmanifest']) {
        copyFileSync(join(SRC, file), join(OUT, file));
    }
    console.log('STATIC-BUILD (V4): copied favicon + manifest files');

    // .nojekyll — tells GitHub Pages NOT to process the site with Jekyll
    // (Jekyll ignores folders starting with `_` and would skip assets).
    writeFileSync(join(OUT, '.nojekyll'), '', 'utf8');
    console.log('STATIC-BUILD (V4): wrote .nojekyll');

    // The GitHub Pages copy is a noindex demonstration, not a second site.
    writeFileSync(
        join(OUT, 'robots.txt'),
        `User-agent: *\nDisallow: /\n`,
        'utf8',
    );
    console.log('STATIC-BUILD (V4): wrote robots.txt');

    console.log('STATIC-BUILD (V4): done — ' + generated + ' HTML files generated.');
}

build();
