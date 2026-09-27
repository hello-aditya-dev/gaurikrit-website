/**
 * Gaurikrit Bio Products — Static HTML build script for GitHub Pages.
 *
 * Task ID: V12-FINISH
 *
 * Reads the PHP source in dist-hostinger/ and produces
 * a static HTML site in docs/ that can be deployed to
 * GitHub Pages (served from a subdirectory, so all paths are relative).
 *
 * V12 mirrors the finishing pass: the five-family section-background
 * rhythm, the shared typographic eight-benefit grid (the radial
 * ashta-laabh seal and the calculator wall-scene are RETIRED — their
 * partials deleted; only gaurikrit-cow-mark (logo fallback) and
 * field-botanicals (404 accent) remain), quiet catalogue plates for
 * product photography, and the calculator page as a single-column tool.
 * The eight benefits use the shared .benefits-grid classes from app.css
 * §18 on every page that shows them.
 *
 * V15 mirrors: the "Plan your quantity" calculator deep-link row on both
 * product detail pages (?paint=distemper / ?paint=emulsion), the
 * chapter-index contents block on why-prakritik, and the print-only
 * estimate sheet header (.calc-print-sheet) on the calculator page.
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
    vision: 'To become a leading circular-economy company transforming natural and agricultural resources into sustainable products for homes, industries and communities.',
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
        // V18: the sharp client-supplied single-bucket cutout (blue
        // Distemper configuration) — mirrors data.php.
        officialImage: '/assets/images/client/prakritik-distemper-single-cut.png',
        officialImageWebp: '/assets/images/client/prakritik-distemper-single-cut.webp',
        officialImageW: 801,
        officialImageH: 1044,
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
        officialImage: '/assets/products/prakritik-emulsion-from-pair.png',
        officialImageWebp: '/assets/products/prakritik-emulsion-from-pair.webp',
        officialImageW: 638,
        officialImageH: 612,
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
    'eco-paints': 'Eco-Paints',
    'prakritik-distemper': 'Prakritik Distemper',
    'prakritik-emulsion': 'Prakritik Emulsion',
    'gocast-logs': 'GoCast Logs',
    'bio-coal-logs': 'Bio-Coal Logs',
    'utility-products': 'Utility Products',
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
    'Eco-Paints',
    'GoCast Logs',
    'Bio-Coal Logs',
    'Utility Products',
    'Distribution',
    'Sustainability Collaboration',
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
    { label: 'Our Story', href: '/about/' },
    { label: 'Products', href: '/products/' },
    { label: 'Sustainability', href: '/sustainability/' },
    { label: 'Innovation', href: '/innovation/' },
    { label: 'Partners', href: '/for-business/' },
    { label: 'Contact', href: '/contact/' },
];

const NAV_UTILITIES = [
    { label: 'Painting Calculator', href: '/paint-calculator/' },
    { label: 'Downloads / Brochure', href: '/downloads/' },
];

const FAMILIES = [
    {
        num: '01', id: 'eco-paints', name: 'Eco-Paints',
        line: 'Healthy walls inspired by nature.',
        desc: 'Cow dung-based wall coatings in Distemper and Emulsion formats — the most developed family in the Gaurikrit ecosystem, documented with full product specifications.',
        status: 'Documented family',
        themes: ['Eco-conscious formulation', 'Sustainable building applications', 'Natural-finish positioning'],
        href: '/products/#eco-paints',
    },
    {
        num: '02', id: 'gocast-logs', name: 'GoCast Logs',
        line: 'Saving trees without changing traditions.',
        desc: 'A dense log format developed as an alternative to conventional wood — directed at ceremonial and traditional applications where wood has long been the default.',
        status: 'Development direction',
        themes: ['Alternative to conventional wood', 'Ceremonial applications', 'Forest-conservation direction'],
        href: '/products/#gocast-logs',
    },
    {
        num: '03', id: 'bio-coal-logs', name: 'Bio-Coal Logs',
        line: 'Renewable energy from natural biomass.',
        desc: 'Biomass-based fuel logs — a renewable energy direction that explores how natural material streams can reduce reliance on fossil fuels.',
        status: 'Development direction',
        themes: ['Biomass energy', 'Reduced fossil-fuel reliance direction', 'Sustainable fuel applications'],
        href: '/products/#bio-coal-logs',
    },
    {
        num: '04', id: 'utility-products', name: 'Utility Products',
        line: 'Sustainable products for everyday living.',
        desc: 'Practical daily-use products from naturally derived materials — a plastic-reducing direction for homes, gardens and everyday routines.',
        status: 'Development direction',
        themes: ['Plastic-reducing alternatives', 'Practical daily-use applications', 'Circular-economy solutions'],
        href: '/products/#utility-products',
    },
];

const CIRCULAR_STAGES = [
    { num: '01', name: 'Collection', desc: 'Natural and agricultural material streams are gathered.' },
    { num: '02', name: 'Processing', desc: 'The raw material is prepared and stabilised.' },
    { num: '03', name: 'Material Enhancement', desc: 'It is developed into useful working materials.' },
    { num: '04', name: 'Manufacturing', desc: 'Materials are formed into product families.' },
    { num: '05', name: 'Products', desc: 'Walls, energy and everyday-use applications.' },
    { num: '06', name: 'Environmental Impact', desc: 'Each use replaces a less sustainable alternative.' },
    { num: '07', name: 'Resource Regeneration', desc: 'The cycle renews — nothing goes to waste.' },
];

const IMPACT_AREAS = [
    { label: 'Trees', area: 'Resource conservation', desc: 'Reducing dependence on conventional resource-intensive alternatives.' },
    { label: 'Waste', area: 'Material reuse', desc: 'Creating useful applications for natural and agricultural material streams.' },
    { label: 'Energy', area: 'Alternative fuel', desc: 'Exploring renewable biomass-based fuel applications.' },
    { label: 'Carbon', area: 'Reduction direction', desc: 'Directional reduction of reliance on fossil-based materials.' },
    { label: 'Rural', area: 'Value creation', desc: 'Creating additional value around agricultural ecosystems.' },
];

const INNOVATION_AREAS = [
    { num: '01', name: 'Natural Coatings', desc: 'Wall coatings and finishes from naturally derived materials.' },
    { num: '02', name: 'Biomass Energy', desc: 'Fuel directions from natural biomass material streams.' },
    { num: '03', name: 'Bio-Composites', desc: 'Composite materials that carry natural fibres and minerals.' },
    { num: '04', name: 'Carbon Reduction Technologies', desc: 'Approaches that reduce reliance on fossil-based alternatives.' },
    { num: '05', name: 'Sustainable Building Materials', desc: 'Construction materials from renewable natural resources.' },
];

const APPLICATION_GROUPS = [
    {
        title: 'Buildings & Construction',
        items: [
            { name: 'Eco-Paints', href: '/products/#eco-paints', live: true },
            { name: 'Protective Coatings', href: null, live: false },
            { name: 'Decorative Finishes', href: null, live: false },
        ],
    },
    {
        title: 'Energy & Fuel',
        items: [
            { name: 'Bio-Coal Logs', href: '/products/#bio-coal-logs', live: false },
            { name: 'Biomass Fuel Solutions', href: null, live: false },
        ],
    },
    {
        title: 'Traditional & Ritual Applications',
        items: [
            { name: 'GoCast Logs', href: '/products/#gocast-logs', live: false },
            { name: 'Eco Cremation Solutions', href: null, live: false },
        ],
    },
    {
        title: 'Everyday Sustainable Living',
        items: [
            { name: 'Utility Products', href: '/products/#utility-products', live: false },
            { name: 'Home & Garden Products', href: null, live: false },
            { name: 'Eco Lifestyle Solutions', href: null, live: false },
        ],
    },
];

const WHY_PRINCIPLES = [
    { num: '01', name: 'Nature-Led Innovation', desc: 'Products begin with a natural material, not a chemical substitute.' },
    { num: '02', name: 'Circular Thinking', desc: 'The same resource is designed to serve many applications.' },
    { num: '03', name: 'Environmental Responsibility', desc: 'Every direction replaces a less sustainable alternative.' },
    { num: '04', name: 'Rural Value Creation', desc: 'Value is created around agricultural ecosystems.' },
];

const PARTNER_AUDIENCES = [
    'Distributors',
    'Dealers',
    'Architects',
    'Contractors',
    'Institutions',
    'Industries',
    'Sustainability Partners',
];

const FOOTER_PRODUCTS = [
    { label: 'Eco-Paints', href: '/products/#eco-paints' },
    { label: 'Prakritik Distemper', href: '/products/prakritik-distemper/' },
    { label: 'Prakritik Emulsion', href: '/products/prakritik-emulsion/' },
    { label: 'Colours', href: '/colours/' },
    { label: 'GoCast Logs', href: '/products/#gocast-logs' },
    { label: 'Bio-Coal Logs', href: '/products/#bio-coal-logs' },
    { label: 'Utility Products', href: '/products/#utility-products' },
];

// V18 §54 — Products dropdown (desktop) + mobile menu sub-group.
const PRODUCTS_MENU = [
    { label: 'Product Ecosystem', href: '/products/', strong: true },
    { label: 'Eco-Paints', href: '/products/#eco-paints' },
    { label: 'Prakritik Distemper', href: '/products/prakritik-distemper/' },
    { label: 'Prakritik Emulsion', href: '/products/prakritik-emulsion/' },
    { label: 'Colours', href: '/colours/' },
    { label: 'GoCast Logs', href: '/products/#gocast-logs' },
    { label: 'Bio-Coal', href: '/products/#bio-coal-logs' },
    { label: 'Utility Products', href: '/products/#utility-products' },
];

// V18 — Prakritik Paint shade catalogue (client-supplied, 2026-09-27
// batch). Names + codes EXACTLY as printed on the client shade cards;
// hex values are pixel-sampled approximations (ASSET_PROVENANCE.md).
const SHADE_SIGNATURE = [
    { code: 'GK-101', name: 'Ivory White', hex: '#F5EDE0' },
    { code: 'GK-102', name: 'Pearl Cream', hex: '#EFE4CE' },
    { code: 'GK-103', name: 'Sand Beige', hex: '#E0CDA5' },
    { code: 'GK-104', name: 'Mango Yellow', hex: '#F8AE03' },
    { code: 'GK-105', name: 'Turmeric Glow', hex: '#D58F18' },
    { code: 'GK-106', name: 'Earth Brown', hex: '#985A36' },
    { code: 'GK-107', name: 'Forest Green', hex: '#1E4825' },
    { code: 'GK-108', name: 'Neem Green', hex: '#6D9A57' },
    { code: 'GK-109', name: 'Sky Blue', hex: '#8BC3E7' },
    { code: 'GK-110', name: 'Ocean Blue', hex: '#024AA3' },
    { code: 'GK-111', name: 'Terracotta Sunset', hex: '#D14B1D' },
    { code: 'GK-112', name: 'Brick Red', hex: '#A3301E' },
];

const SHADE_PREMIUM_GROUPS = [
    { id: 'natural-neutrals', name: 'Natural Neutrals', shades: [
        { code: 'GK-201', name: 'Ivory White', hex: '#F5F0E6' },
        { code: 'GK-202', name: 'Pearl Cream', hex: '#EFE4CE' },
        { code: 'GK-203', name: 'Sand Beige', hex: '#E0CDA5' },
        { code: 'GK-204', name: 'Desert Dune', hex: '#D6B896' },
        { code: 'GK-205', name: 'Wheat Husk', hex: '#C9A87C' },
        { code: 'GK-206', name: 'Stone Mist', hex: '#B9AF9F' },
    ] },
    { id: 'sunshine', name: 'Sunshine Collection', shades: [
        { code: 'GK-207', name: 'Mango Yellow', hex: '#F8AE03' },
        { code: 'GK-208', name: 'Turmeric Glow', hex: '#D58F18' },
        { code: 'GK-209', name: 'Marigold Gold', hex: '#F69209' },
        { code: 'GK-210', name: 'Golden Harvest', hex: '#E8A00E' },
        { code: 'GK-211', name: 'Saffron Earth', hex: '#E05E04' },
        { code: 'GK-212', name: 'Honey Amber', hex: '#C97F1E' },
    ] },
    { id: 'nature-greens', name: 'Nature Greens', shades: [
        { code: 'GK-213', name: 'Forest Green', hex: '#1E4825' },
        { code: 'GK-214', name: 'Neem Green', hex: '#5E7945' },
        { code: 'GK-215', name: 'Tulsi Green', hex: '#6E9D46' },
        { code: 'GK-216', name: 'Bamboo Leaf', hex: '#7EA162' },
        { code: 'GK-217', name: 'Meadow Green', hex: '#8FBF77' },
        { code: 'GK-218', name: 'Olive Grove', hex: '#6A6A26' },
    ] },
    { id: 'sky-water', name: 'Sky & Water', shades: [
        { code: 'GK-219', name: 'Sky Blue', hex: '#8BC3E7' },
        { code: 'GK-220', name: 'Ocean Blue', hex: '#024AA3' },
        { code: 'GK-221', name: 'River Blue', hex: '#3988B4' },
        { code: 'GK-222', name: 'Monsoon Blue', hex: '#4F7BA5' },
        { code: 'GK-223', name: 'Morning Mist', hex: '#C5D5DF' },
        { code: 'GK-224', name: 'Lake Blue', hex: '#2399D9' },
    ] },
    { id: 'earth-heritage', name: 'Earth & Heritage', shades: [
        { code: 'GK-225', name: 'Earth Brown', hex: '#985A36' },
        { code: 'GK-226', name: 'Terracotta Sunset', hex: '#D14B1D' },
        { code: 'GK-227', name: 'Brick Red', hex: '#A3301E' },
        { code: 'GK-228', name: 'Cinnamon Clay', hex: '#B76C3E' },
        { code: 'GK-229', name: 'Rustic Ochre', hex: '#C18029' },
        { code: 'GK-230', name: 'Copper Rust', hex: '#9C4B22' },
    ] },
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

/** V19 image system — responsive ladder helper for the ecosystem
 *  derivative set (AVIF first, WebP fallback, JPEG <img>). Mirrors the
 *  PHP eco_srcset()/eco_srcset_webp() helpers in includes/helpers.php. */
function ecoSrcset(stem, widths, depth) {
    return widths.map((w) => `${assetUrl(`/assets/images/ecosystem/${stem}-${w}.avif`, depth)} ${w}w`).join(', ');
}
function ecoSrcsetWebp(stem, widths, depth) {
    return widths.map((w) => `${assetUrl(`/assets/images/ecosystem/${stem}-${w}.webp`, depth)} ${w}w`).join(', ');
}
function ecoPic(stem, widths, sizes, fallbackW, w, h, alt, depth, extra = '') {
    return `<picture><source type="image/avif" srcset="${ecoSrcset(stem, widths, depth)}" sizes="${sizes}"><source type="image/webp" srcset="${ecoSrcsetWebp(stem, widths, depth)}" sizes="${sizes}"><img ${extra} src="${assetUrl(`/assets/images/ecosystem/${stem}-${fallbackW}.jpg`, depth)}" alt="${e(alt)}" width="${w}" height="${h}" loading="lazy" decoding="async"></picture>`;
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
        '/sustainability/':'sustainability','/innovation/':'innovation',
        '/for-business/':'for-business','/paint-calculator/':'calculator',
        '/downloads/':'downloads','/contact/':'contact',
        '/colours/':'colours'})[pageMeta.canonical] || 'home';
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

    // ---- V14: BreadcrumbList JSON-LD (every page except home). Mirrors the
    // visible breadcrumb; product detail pages include the Products level. ----
    const crumbNames = {
        '/products/': 'Products',
        '/products/prakritik-distemper/': 'Prakritik Distemper Paint',
        '/products/prakritik-emulsion/': 'Prakritik Emulsion Paint',
        '/why-prakritik/': 'Why Prakritik',
        '/about/': 'Our Story',
        '/sustainability/': 'Sustainability',
        '/innovation/': 'Innovation',
        '/for-business/': 'Partners',
        '/paint-calculator/': 'Paint Calculator',
        '/downloads/': 'Downloads',
        '/contact/': 'Contact',
        '/colours/': 'Colours',
    };
    let ldExtra = '';
    if (pageMeta.canonical !== '/' && crumbNames[pageMeta.canonical]) {
        const items = [
            { '@type': 'ListItem', position: 1, name: 'Home', item: SITE_URL.replace(/\/$/, '') + '/' },
        ];
        if (pageMeta.canonical.indexOf('/products/prakritik-') === 0) {
            items.push({ '@type': 'ListItem', position: 2, name: 'Products', item: SITE_URL.replace(/\/$/, '') + '/products/' });
            items.push({ '@type': 'ListItem', position: 3, name: crumbNames[pageMeta.canonical], item: fullCanonical });
        } else {
            items.push({ '@type': 'ListItem', position: 2, name: crumbNames[pageMeta.canonical], item: fullCanonical });
        }
        ldExtra += `
    <script type="application/ld+json">
${JSON.stringify({ '@context': 'https://schema.org', '@type': 'BreadcrumbList', itemListElement: items }, null, 2)}
    </script>`;
    }

    // ---- V14: Product JSON-LD on the two product detail pages. Factual
    // fields only (no offers/price/rating — those would be fabricated). ----
    const productSlugs = {
        '/products/prakritik-distemper/': 'prakritik-distemper',
        '/products/prakritik-emulsion/': 'prakritik-emulsion',
    };
    if (productSlugs[pageMeta.canonical]) {
        const p = getProduct(productSlugs[pageMeta.canonical]);
        if (p) {
            const ldProduct = {
                '@context': 'https://schema.org',
                '@type': 'Product',
                name: p.name,
                description: pageMeta.description,
                brand: { '@type': 'Brand', name: 'Gaurikrit' },
                category: p.name,
                url: fullCanonical,
                image: SITE_URL.replace(/\/$/, '') + '/assets/social/og-' + socialSlug + '.jpg',
            };
            ldExtra += `
    <script type="application/ld+json">
${JSON.stringify(ldProduct, null, 2)}
    </script>`;
        }
    }

    const cssHref = assetUrl('/assets/css/app.css', depth) + '?v=static';
    const brandMarkHref = assetUrl('/assets/brand/gaurikrit-logo-mark.png', depth);
    const faviconHref = assetUrl('/favicon.ico', depth);
    // V18 §54: Products becomes a dropdown (real routes/anchors only).
    const navLinks = NAV.map((link) => {
        if (link.label === 'Products') {
            const menuLinks = PRODUCTS_MENU.map(
                (item) =>
                    `                            <a href="${relUrl(item.href, depth)}" class="nav-menu__link${item.strong ? ' nav-menu__link--strong' : ''}">${e(item.label)}</a>`,
            ).join('\n');
            return `                    <div class="site-nav__item" data-nav-menu>
                        <button type="button" class="site-nav__link site-nav__link--parent"
                                data-nav-link="${e(link.href)}"
                                aria-expanded="false" aria-haspopup="true" aria-controls="nav-products-menu">
                            Products
                            <svg class="site-nav__chevron" width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M2 3.5 5 6.5 8 3.5"/></svg>
                        </button>
                        <div class="nav-menu" id="nav-products-menu" hidden>
${menuLinks}
                        </div>
                    </div>`;
        }
        return `        <a href="${relUrl(link.href, depth)}" class="site-nav__link" data-nav-link="${e(link.href)}">${e(link.label)}</a>`;
    }).join('\n');

    // V18 §54: the mobile menu gains the Products sub-group.
    const mobileLinks = NAV.map((link) => {
        const base = `                <a href="${relUrl(link.href, depth)}" class="mobile-menu__link" data-nav-link="${e(link.href)}">${e(link.label)}<span class="mobile-menu__arrow">→</span></a>`;
        if (link.label !== 'Products') return base;
        const subLinks = PRODUCTS_MENU.map(
            (item) => `                          <a href="${relUrl(item.href, depth)}" class="mobile-menu__sub-link">${e(item.label)}</a>`,
        ).join('\n');
        return `${base}
                      <div class="mobile-menu__sub">
${subLinks}
                      </div>`;
    }).join('\n');

    const utilityLinks = NAV_UTILITIES.map(
        (link) =>
            `                    <a href="${relUrl(link.href, depth)}" class="mobile-menu__utility-link">${e(link.label)}</a>`,
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
    </script>${ldExtra}

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
            <!-- V16 §46: secondary utilities near the bottom of the menu. -->
            <div class="mobile-menu__utilities">
                <p class="mobile-menu__utilities-label">Tools</p>
${utilityLinks}
            </div>
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
    const productLinks = FOOTER_PRODUCTS.map(
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
            <nav class="site-footer__col site-footer__col--company" aria-label="Company">
                <h4 class="site-footer__heading">Company</h4>
                <a href="${relUrl('/', depth)}">Home</a>
                <a href="${relUrl('/about/', depth)}">Our Story</a>
                <a href="${relUrl('/sustainability/', depth)}">Sustainability</a>
                <a href="${relUrl('/innovation/', depth)}">Innovation</a>
            </nav>
            <nav class="site-footer__col" aria-label="Products">
                <h4 class="site-footer__heading">Products</h4>
${productLinks}
            </nav>
            <nav class="site-footer__col site-footer__col--work" aria-label="Work with us">
                <h4 class="site-footer__heading">Work With Us</h4>
                <a href="${relUrl('/for-business/', depth)}">Partners</a>
                <a href="${relUrl('/paint-calculator/', depth)}">Painting Calculator</a>
                <a href="${relUrl('/downloads/', depth)}">Downloads</a>
                <a href="${relUrl('/contact/', depth)}">Contact</a>
            </nav>
            <div class="site-footer__col site-footer__col--contact">
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
    <script src="${jsBase}colour-study.js?v=static"></script>
    <script src="${jsBase}forms.js?v=static"></script>
    <script src="${jsBase}calculator.js?v=static"></script>
    <script src="${jsBase}story.js?v=static"></script>
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
    // V19 §28: the three stages share one image system (3:2, same
    // derivatives ladder, same frame treatment).
    const STAGE_SIZES = '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)';
    const rawMaterial = ecoPic('rawmat', [640, 960, 1280, 1920], STAGE_SIZES, 960, 960, 549, 'Raw material — natural biomass with straw fibre', depth);
    const finishedSurface = ecoPic('colours-wall', [640, 960, 1280, 1920], STAGE_SIZES, 960, 960, 549, 'Finished limewash wall in a furnished room — a useful application', depth);
    const distemperProduct = ecoPic('material-development', [640, 960, 1280, 1920], STAGE_SIZES, 960, 960, 640, 'Prakritik Distemper paint pack — developed material product with studio context', depth);

    const familiesMarkup = FAMILIES.map((family) => {
        // V19 §29-30: every family carries a visually strong image — real
        // client photography for Eco-Paints + GoCast, representative
        // category visuals for Bio-Coal + Utility (alt text keeps the
        // distinction honest). One system: 3:2 frames.
        const mediaSpec = {
            'eco-paints':       { stem: 'eco-paints-pair', alt: 'Prakritik Distemper and Prakritik Emulsion paint packs - the documented Eco-Paints family', note: false },
            'gocast-logs':      { stem: 'gocast-editorial', alt: 'Client-supplied cow-dung logs on a terracotta plate with straw', note: false },
            'bio-coal-logs':    { stem: 'biocoal-editorial', alt: 'Representative biomass briquette material study for the Bio-Coal category', note: true },
            'utility-products': { stem: 'utility-material-direction', alt: 'Representative moulded natural-material utility forms for the Utility Products direction', note: true },
        };
        const spec = mediaSpec[family.id];
        const media = `            <figure class="family__media family__media--photo">
                ${ecoPic(spec.stem, [640, 960, 1280, 1920], '(min-width: 768px) 45vw, calc(100vw - 2.5rem)', 960, 960, 640, spec.alt, depth)}
${spec.note ? '                <span class="family__media-note">Category visual</span>\n' : ''}            </figure>`;
        const themes = family.themes.map((t) => `              <li>${e(t)}</li>`).join('\n');
        const statusClass = family.status === 'Documented family' ? '' : ' family__status--direction';
        return `        <article class="family" id="family-${e(family.id)}">
${media}

          <div class="family__head">
            <span class="family__num" aria-hidden="true">${e(family.num)}</span>
            <h3 class="family__name">${e(family.name)}</h3>
          </div>
          <p class="family__line">${e(family.line)}</p>
          <p class="family__desc">${e(family.desc)}</p>
          <p class="family__meta">
            <span class="family__status${statusClass}">
              ${e(family.status)}
            </span>
          </p>
          <ul class="family__themes">
${themes}
          </ul>
          <a class="family__cta" href="${relUrl(family.href, depth)}">
            Explore ${e(family.name)} <span aria-hidden="true">→</span>
          </a>
        </article>`;
    }).join('\n');

    const circularStages = CIRCULAR_STAGES.map((stage) => `          <li class="stage">
            <span class="stage__num">${e(stage.num)}</span>
            <h3 class="stage__name">${e(stage.name)}</h3>
            <p class="stage__desc">${e(stage.desc)}</p>
          </li>`).join('\n');

    const appGroups = APPLICATION_GROUPS.map((group) => {
        const items = group.items.map((item) => {
            const cls = item.live ? ' app-group__item--live' : ' app-group__item--direction';
            const name = item.href
                ? `<a href="${relUrl(item.href, depth)}">${e(item.name)}</a>`
                : `<span>${e(item.name)}</span>`;
            return `            <li class="app-group__item${cls}">
              ${name}
              <span class="app-group__item-tag">${item.live ? 'Family' : 'Direction'}</span>
            </li>`;
        }).join('\n');
        return `        <div class="app-group">
          <h3 class="app-group__title">${e(group.title)}</h3>
          <ul class="app-group__list">
${items}
          </ul>
        </div>`;
    }).join('\n');

    const principles = WHY_PRINCIPLES.map((p) => `        <div class="principle">
          <span class="principle__num" aria-hidden="true">${e(p.num)}</span>
          <h3 class="principle__name">${e(p.name)}</h3>
          <p class="principle__desc">${e(p.desc)}</p>
        </div>`).join('\n');

    const impactRows = IMPACT_AREAS.map((area) => `        <div class="impact-row">
          <span class="impact-row__label">${e(area.label)}</span>
          <span class="impact-row__area">${e(area.area)}</span>
          <p class="impact-row__desc">${e(area.desc)}</p>
        </div>`).join('\n');

    const focusRows = INNOVATION_AREAS.map((focus) => `          <div class="focus-row">
            <span class="focus-row__num" aria-hidden="true">${e(focus.num)}</span>
            <h3 class="focus-row__name">${e(focus.name)}</h3>
            <p class="focus-row__desc">${e(focus.desc)}</p>
          </div>`).join('\n');

    const audienceItems = PARTNER_AUDIENCES.map((a) => `        <li class="partner-strip__item">${e(a)}</li>`).join('\n');

    return `<style>
  /* ===== 01. HERO — story lockup 5 / one composed photograph 7 ===== */
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
  .hero__title { font-size: clamp(2.375rem, 5.5vw, 5rem); line-height: 1.04; }
  .hero__body { max-width: 40rem; }
  .hero__ctas { margin-top: 2.25rem; }

  /* V19 §25-27: ONE designed composition — the master carries its own
     seamless studio sweep; the page just frames it. */
  .hero__composition { margin: 0; }
  .hero__composition img {
    width: 100%; height: auto; display: block;
    border-radius: 0.1875rem;
  }
  .hero__composition-captions {
    display: flex; flex-wrap: wrap; gap: 0.5rem 1.75rem;
    margin-top: 0.875rem;
  }
  .hero__caption {
    font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .hero__caption em {
    display: block; font-style: normal; font-weight: 500;
    letter-spacing: 0.08em; color: var(--fg-muted); opacity: 0.72;
    margin-top: 0.1875rem; text-transform: none; font-size: 0.6875rem;
  }

  /* ===== 02. RESOURCE STEPS — one frame system for all three (§28) ===== */
  .resource-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 03. FOUR SOLUTIONS — page-local rhythm (structure §42.3) ===== */
  .families-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 04. CIRCULAR MODEL — page-local rhythm (structure §42.4) ===== */
  .circular-section__head { max-width: 48rem; margin-bottom: 2.75rem; }

  /* ===== 05. DOCUMENTED ECO-PAINT FAMILY — page-local rhythm ===== */
  .eco-documented .section-heading { max-width: 48rem; margin-bottom: 2.5rem; }

  /* ===== 06. INNOVATION TEASER — one research composition (§33) ===== */
  .innov-teaser__grid {
    display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: center;
  }
  @media (min-width: 1024px) { .innov-teaser__grid { grid-template-columns: 5fr 7fr; gap: 3.5rem; } }
  .innov-composition { margin: 0; }
  .innov-composition img {
    width: 100%; height: auto; display: block; border-radius: 0.1875rem;
  }
  .innov-composition__captions {
    display: flex; gap: 1rem; margin-top: 0.875rem;
  }
  .innov-composition__caption {
    flex: 1; font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em;
    text-transform: uppercase; color: var(--fg-muted);
    padding-top: 0.5rem; border-top: 1px solid var(--border);
  }
  .innov-composition__caption em {
    display: block; font-style: normal; font-weight: 500; letter-spacing: 0.04em;
    color: var(--fg-muted); opacity: 0.75; margin-top: 0.1875rem;
    text-transform: none; font-size: 0.6875rem;
  }

  /* ===== 08. PARTNERSHIP — page-local rhythm ===== */
  .partnership__head { max-width: 48rem; margin-bottom: 1.5rem; }
</style>

<!-- ============================================================
     01. HERO — one resource, many applications (§13-14)
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
        <h1 class="hero__title" id="hero-title">
          Reimagining cow dung as a resource for sustainable living.
        </h1>
        <p class="hero__body">
          Nature provides the resource. Gaurikrit explores how cow dung can be
          carried into practical material solutions — from Prakritik Paint to
          fuel and utility applications.
        </p>
        <div class="hero__ctas">
          <a class="btn btn--primary btn--lg" href="${relUrl('/products/', depth)}">Explore the Ecosystem</a>
          <a class="btn btn--secondary btn--lg" href="${relUrl('/about/', depth)}">Our Story</a>
        </div>
      </div>

      <div class="hero__visual" data-reveal>
        <figure class="hero__composition" role="img"
                aria-label="Prakritik Distemper and Prakritik Emulsion paint packs with client-supplied cow-dung logs on a terracotta plate — one natural resource, multiple applications">
          <picture>
            <source type="image/avif" media="(max-width: 899px)"
                    srcset="${ecoSrcset('home-hero-ecosystem-mobile', [640, 960, 1600], depth)}"
                    sizes="calc(100vw - 2.5rem)">
            <source type="image/webp" media="(max-width: 899px)"
                    srcset="${ecoSrcsetWebp('home-hero-ecosystem-mobile', [640, 960, 1600], depth)}"
                    sizes="calc(100vw - 2.5rem)">
            <source type="image/avif"
                    srcset="${ecoSrcset('home-hero-ecosystem', [640, 960, 1280, 1600, 1920, 2560], depth)}"
                    sizes="(min-width: 1200px) 58vw, (min-width: 900px) 50vw, calc(100vw - 2.5rem)">
            <source type="image/webp"
                    srcset="${ecoSrcsetWebp('home-hero-ecosystem', [640, 960, 1280, 1600, 1920, 2560], depth)}"
                    sizes="(min-width: 1200px) 58vw, (min-width: 900px) 50vw, calc(100vw - 2.5rem)">
            <img src="${assetUrl('/assets/images/ecosystem/home-hero-ecosystem-1280.jpg', depth)}"
                 alt="Prakritik Distemper and Prakritik Emulsion paint packs with client-supplied cow-dung logs on a terracotta plate"
                 width="1280" height="853"
                 fetchpriority="high" loading="eager" decoding="async">
          </picture>
          <figcaption class="hero__composition-captions">
            <span class="hero__caption">Eco-Paints
              <em>Documented family</em>
            </span>
            <span class="hero__caption">Cow-Dung Logs
              <em>Client-supplied reference</em>
            </span>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     02. FROM WASTE TO RESOURCE — the Gaurikrit story (§15-16)
     ============================================================ -->
<section class="section section--paper resource-section" aria-labelledby="resource-title">
  <div class="container">
    <div class="resource-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Gaurikrit Story</span>
      <h2 class="section-heading__title" id="resource-title">From Waste to Resource.</h2>
      <p class="section-heading__desc">
        Traditional India has long recognised cow dung as a useful material.
        Gaurikrit's direction is to carry that resource into practical
        contemporary applications — from naturally derived material to products
        for walls, energy and everyday use.
      </p>
    </div>

    <div class="resource-steps" data-reveal-stagger>
      <article class="resource-step">
        <figure class="resource-step__figure">
          ${rawMaterial}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 01</span>
          <h3 class="resource-step__title">Raw Material</h3>
          <p class="resource-step__desc">
            Cow dung — a natural material long valued in traditional Indian homes.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          ${distemperProduct}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 02</span>
          <h3 class="resource-step__title">Material Development</h3>
          <p class="resource-step__desc">
            The resource is processed and developed into useful working materials.
          </p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          ${finishedSurface}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Stage 03</span>
          <h3 class="resource-step__title">Useful Applications</h3>
          <p class="resource-step__desc">
            Products for walls, energy and everyday use — nothing goes to waste.
          </p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     03. ONE RESOURCE, FOUR SOLUTIONS — the ecosystem (§17-18)
     ============================================================ -->
<section class="section section--haldi-wash families-section" aria-labelledby="families-title">
  <div class="container">
    <div class="families-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Gaurikrit Ecosystem</span>
      <h2 class="section-heading__title" id="families-title">One resource. Four directions.</h2>
      <p class="section-heading__desc">
        Cow dung is the shared material beginning. Gaurikrit develops it in four
        directions — Eco-Paints is the documented family; the others are
        development directions presented without invented products.
      </p>
    </div>

    <div class="families" data-reveal-stagger>
${familiesMarkup}
    </div>
  </div>
</section>

<!-- ============================================================
     04. NOTHING GOES TO WASTE — the circular model (§19-20)
     ============================================================ -->
<section class="section section--paper circular-section" aria-labelledby="circular-title">
  <div class="container">
    <div class="circular-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Circular Model</span>
      <h2 class="section-heading__title" id="circular-title">Nothing Goes to Waste.</h2>
      <p class="section-heading__desc">
        One continuous cycle: the resource enters, is developed, becomes useful
        products — and creates a new value cycle.
      </p>
    </div>

    <div class="circular" data-circular data-reveal>
      <ol class="circular__track">
${circularStages}
      </ol>
      <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
        <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
      </svg>
      <span class="circular__loop-label" aria-hidden="true">Resource regeneration</span>
    </div>
  </div>
</section>

<!-- ============================================================
     05. THE DOCUMENTED ECO-PAINT FAMILY (V18 §39.05)
     ============================================================ -->
<section class="section section--cool eco-documented" aria-labelledby="eco-documented-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">The Documented Family</span>
      <h2 class="section-heading__title" id="eco-documented-title">
        Eco-Paints, documented end to end.
      </h2>
      <p class="section-heading__desc">
        The one family with full product documentation — two formats, supplied
        specifications, real client photography and a shade catalogue.
      </p>
    </div>

    <div class="eco-documented__grid" data-reveal-stagger>
      <figure class="eco-documented__plate">
        ${ecoPic('eco-paints-pair', [640, 960, 1280, 1920], '(min-width: 1024px) 40vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Prakritik Distemper and Prakritik Emulsion paint packs', depth)}
      </figure>

      <div class="eco-documented__rows">
${PRODUCTS.map((product) => `          <div class="eco-documented__row">
            <h3 class="eco-documented__row-name">
              <a href="${relUrl(product.route, depth)}">${e(product.name)}</a>
            </h3>
            <p class="eco-documented__row-meta">
              <strong>${e(product.packagingShort)}</strong> ·
              ${e(product.colour)} · ${e(product.finish)} ·
              ${e(product.coverage)}
            </p>
            <a class="eco-documented__row-cta" href="${relUrl(product.route, depth)}">
              View specifications <span aria-hidden="true">→</span>
            </a>
          </div>`).join('\n')}
        <div class="eco-documented__links">
          <a href="${relUrl('/colours/', depth)}">Explore Colours</a>
          <a href="${relUrl('/paint-calculator/', depth)}">Painting Calculator</a>
          <a href="${relUrl('/why-prakritik/', depth)}">Why Prakritik?</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     06. RESEARCH & INNOVATION — focus areas teaser (§25 / §28)
     Real material samples — paint surface + cow-dung log material.
     ============================================================ -->
<section class="section section--limewash innov-teaser" aria-labelledby="innov-title">
  <div class="container">
    <div class="section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Research &amp; Innovation</span>
      <h2 class="section-heading__title" id="innov-title">Where Tradition Meets Technology.</h2>
    </div>
    <div class="innov-teaser__grid" data-reveal>
      <figure class="innov-composition" aria-label="Material research samples — raw biomass, processed log and finished coating">
        ${ecoPic('innovation-research', [640, 960, 1280, 1920], '(min-width: 1024px) 40vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Material research samples — raw biomass, processed log and finished coating', depth)}
        <figcaption class="innov-composition__captions">
          <span class="innov-composition__caption">Raw material<em>biomass sample</em></span>
          <span class="innov-composition__caption">Processed<em>log sample</em></span>
          <span class="innov-composition__caption">Coating<em>finished sample</em></span>
        </figcaption>
      </figure>
      <div class="focus-rows">
${focusRows}
        <p class="impact-note" style="margin-top:1.25rem;">
          These are FOCUS AREAS — research directions, not proven
          accomplishments. <a href="${relUrl('/innovation/', depth)}">Explore Innovation →</a>
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     07. VISION + MISSION — strong Forest section (§26)
     ============================================================ -->
<section class="section section--forest vision-mission" aria-labelledby="vision-title">
  <div class="container">
    <div class="vision-mission__grid">
      <div class="vision-mission__col">
        <span class="vision-mission__eyebrow">Vision</span>
        <h2 class="vision-mission__title" id="vision-title">
          A circular-economy company in the making.
        </h2>
        <p class="vision-mission__text">
          ${e(COMPANY.vision)}
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
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     08. PARTNERSHIP CTA (§27)
     ============================================================ -->
<section class="section section--paper partnership" aria-labelledby="partnership-title">
  <div class="container">
    <div class="partnership__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Partnership</span>
      <h2 class="section-heading__title" id="partnership-title">Let's Build a Greener Future Together.</h2>
    </div>
    <div class="partner-strip" data-reveal>
      <ul class="partner-strip__list">
${audienceItems}
      </ul>
      <div class="partner-strip__ctas">
        <a class="btn btn--primary" href="${relUrl('/for-business/', depth)}">Become a Partner</a>
        <a class="btn btn--secondary" href="${relUrl('/contact/', depth)}">Request Product Information</a>
      </div>
    </div>
  </div>
</section>
`;
}

function productsBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');

    const appGroups = APPLICATION_GROUPS.map((group) => {
        const items = group.items.map((item) => {
            const cls = item.live ? ' app-group__item--live' : ' app-group__item--direction';
            const name = item.href
                ? `<a href="${relUrl(item.href, depth)}">${e(item.name)}</a>`
                : `<span>${e(item.name)}</span>`;
            return `            <li class="app-group__item${cls}">
              ${name}
              <span class="app-group__item-tag">${item.live ? 'Family' : 'Direction'}</span>
            </li>`;
        }).join('\n');
        return `        <div class="app-group">
          <h3 class="app-group__title">${e(group.title)}</h3>
          <ul class="app-group__list">
${items}
          </ul>
        </div>`;
    }).join('\n');

    const familySection = (num, id, name, line, desc, themes, note, texture, interest, reverse, hlevel) => {
        // V19: the type plate is retired — every direction section now
        // carries its representative editorial image.
        const photoSpec = {
            'bio-coal-logs':    { stem: 'biocoal-editorial', alt: 'Representative biomass briquette material study for the Bio-Coal category' },
            'utility-products': { stem: 'utility-material-direction', alt: 'Representative moulded natural-material utility forms for the Utility Products direction' },
        };
        const photoStem = photoSpec[id] ? photoSpec[id].stem : texture;
        const photoAlt = photoSpec[id] ? photoSpec[id].alt : name;
        const themeList = themes.map((t) => `          <li>${e(t)}</li>`).join('\n');
        const rev = reverse ? ' family-section--reverse' : '';
        return `<!-- ============================================================
     ${num}. ${name.toUpperCase()} — development direction
     ============================================================ -->
<section class="section section--${reverse ? 'limewash' : 'paper'} family-section${rev}" id="${id}" aria-labelledby="${id}-title">
  <div class="container">
    <div class="family-section__grid" data-reveal>
      <div class="family-section__copy">
        <span class="family-section__num" aria-hidden="true">${num}</span>
        <h${hlevel} class="family-section__name" id="${id}-title">${e(name)}</h${hlevel}>
        <p class="family-section__line">${e(line)}</p>
        <p class="family-section__desc">
          ${e(desc)}
        </p>
        <ul class="family-section__themes">
${themeList}
        </ul>
        <p class="family-section__note">
          ${e(note)}
        </p>
        <div class="family-section__cta">
          <a class="btn btn--outline" href="${relUrl('/contact/', depth)}?interest=${interest}">Enquire About ${e(name.replace('Eco-Friendly ', ''))}</a>
        </div>
      </div>
      <figure class="family-section__photo" aria-label="${e(name)} — representative category visual">
        ${ecoPic(photoStem, [640, 960, 1280, 1600], '(min-width: 1024px) 42vw, calc(100vw - 2.5rem)', 1280, 1280, 960, photoAlt, depth)}
        <figcaption>Representative ${id === 'bio-coal-logs' ? 'category' : 'material-direction'} visual — not a documented product photograph.</figcaption>
      </figure>
    </div>
  </div>
</section>`;
    };

    // V18 §16–17: GoCast gets the REAL client log photography in an
    // editorial 45/55 composition — never a fake "product card".
    const gocastSection = `
<!-- ============================================================
     07. GOCAST / COW-DUNG LOGS (V18 §16-17)
     ============================================================ -->
<section class="section section--paper family-section" id="gocast-logs" aria-labelledby="gocast-title">
  <div class="container">
    <div class="gocast-feature" data-reveal>
      <figure class="gocast-feature__figure">
        ${ecoPic('gocast-editorial', [640, 960, 1280, 1600], '(min-width: 1024px) 45vw, calc(100vw - 2.5rem)', 1280, 1280, 960, 'Client-supplied cow-dung logs on a terracotta plate with straw', depth)}
        <figcaption>Client-supplied cow-dung log reference.</figcaption>
      </figure>
      <div class="gocast-feature__copy">
        <span class="family-section__num" aria-hidden="true">02</span>
        <h2 class="family-section__name" id="gocast-title">GoCast Logs</h2>
        <p class="family-section__line">Saving trees without changing traditions.</p>
        <p>
          A dense log format developed as an alternative to conventional wood —
          directed at ceremonial and traditional applications where wood has
          long been the default.
        </p>
        <ul class="family-section__themes">
          <li>Alternative to conventional wood</li>
          <li>Traditional / ceremonial application direction</li>
          <li>Resource-conservation direction</li>
        </ul>
        <p class="muted">
          GoCast is a development direction — the photographs show
          client-supplied log material, not a documented product specification.
          Dimensions, composition and availability will be published when the
          client supplies verified information.
        </p>
        <div class="family-section__cta">
          <a class="btn btn--outline" href="${relUrl('/contact/?interest=gocast-logs', depth)}">Enquire About GoCast</a>
        </div>
      </div>
    </div>
  </div>
</section>`;

    const biocoalSection = familySection('03', 'bio-coal-logs', 'Bio-Coal Logs',
        'Renewable energy from natural biomass.',
        'Biomass-based fuel logs — a renewable energy direction that explores how natural material streams can reduce reliance on fossil fuels.',
        ['Biomass energy', 'Reduced fossil-fuel reliance direction', 'Alternative fuel applications', 'Circular material use'],
        'Bio-Coal is a development direction. Composition, calorific value and test data will be published when the client supplies verified information.',
        '/assets/editorial/exterior-finish-study.jpg', 'bio-coal-logs', true, '2');

    const utilitySection = familySection('04', 'utility-products', 'Eco-Friendly Utility Products',
        'Sustainable products for everyday living.',
        'Practical daily-use products from naturally derived materials — a plastic-reducing direction for homes, gardens and everyday routines.',
        ['Plastic-reducing alternatives', 'Material reuse', 'Home / garden / lifestyle direction', 'Circular-economy solutions'],
        'Utility Products is a development direction. A confirmed product list will be published when the client supplies verified information.',
        '/assets/editorial/courtyard-study.jpg', 'utility-products', false, '2');

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => `        <li class="benefits-grid__item">
          <span class="benefits-grid__num" aria-hidden="true">${pad2(i + 1)}</span>
          <span class="benefits-grid__name">${e(benefit.name)}</span>
          <span class="benefits-grid__deva">${e(benefit.hindi)}</span>
        </li>`).join('\n');

    const faqItems = FAQ.map((item) => `        <div class="faq-item">
          <button type="button" class="faq-item__q" aria-expanded="false">
            <span>${e(item.q)}</span>
            <svg class="faq-item__icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </button>
          <div class="faq-item__a">
            <div class="faq-item__a-inner">${item.a}</div>
          </div>
        </div>`).join('\n');

    const specMatrixRows = [
        ['Pack sizes', distemper.packagingShort, emulsion.packagingShort],
        ['Colour', distemper.colour, emulsion.colour],
        ['Finish', distemper.finish, emulsion.finish],
        ['Drying time', distemper.dryingTime, emulsion.dryingTime],
        ['Coverage', distemper.coverage, emulsion.coverage],
        ['V.O.C.', distemper.voc, emulsion.voc],
        ['Usage', distemper.usage, emulsion.usage],
    ].map(([label, d, m]) => `      <div class="spec-matrix__row">
        <span class="spec-matrix__label">${e(label)}</span>
        <span class="spec-matrix__value">${e(d)}</span>
        <span class="spec-matrix__value">${e(m)}</span>
      </div>`).join('\n');

    const specMobile = (product) => specMatrixRowsSource(product).map(([label, v]) => `        <div class="spec-matrix-mobile__row"><span class="k">${e(label)}</span><span class="v">${e(v)}</span></div>`).join('\n');

    function specMatrixRowsSource(product) {
        return [
            ['Pack sizes', product.packagingShort],
            ['Colour', product.colour],
            ['Finish', product.finish],
            ['Drying time', product.dryingTime],
            ['Coverage', product.coverage],
            ['V.O.C.', product.voc],
            ['Usage', product.usage],
        ];
    }

    return `<style>
  /* ===== Editorial image reset (V4) ===== */
  .editorial-image { display: block; width: 100%; height: 100%; object-fit: cover; }

  /* ===== 1. ECOSYSTEM HERO ===== */
  .products-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .products-hero__grid { display: grid; gap: 2.5rem; align-items: center; grid-template-columns: 1fr; }
  @media (min-width: 1024px) { .products-hero__grid { grid-template-columns: 45fr 55fr; gap: clamp(2rem, 4vw, 4rem); } }
  .products-hero__lockup { max-width: 42rem; }
  .products-hero__visual { position: relative; width: 100%; overflow: hidden; }
  .products-hero__visual .hero-group-photo { display: block; width: 100%; height: auto; border-radius: 0.1875rem; }

  /* V19 §36: representative category photos for Bio-Coal + Utility. */
  .family-section__photo {
    border: 1px solid var(--border); border-radius: var(--r-panel);
    overflow: hidden; background: var(--paper); margin: 0;
  }
  .family-section__photo img {
    display: block; width: 100%; height: auto;
    transition: transform var(--dur) var(--ease);
  }
  .family-section__photo:hover img { transform: scale(1.015); }
  .family-section__photo figcaption {
    padding: 0.625rem 1rem; font-size: 0.75rem; color: var(--fg-muted);
    border-top: 1px solid var(--border); letter-spacing: 0.02em;
  }

  /* ===== 2. ECO-PAINTS FAMILY SECTION ===== */
  .eco-family { padding-block: clamp(3rem, 6vw, 5rem); }
  .eco-family__grid { display: grid; gap: 2.5rem; align-items: center; grid-template-columns: 1fr; }
  @media (min-width: 1024px) { .eco-family__grid { grid-template-columns: 5fr 7fr; gap: clamp(2rem, 4vw, 4rem); } }
  .eco-family__plate { background: none; border: 0; border-radius: 0; padding: 0; }
  .eco-family__plate img { display: block; width: 100%; height: auto; }
  .eco-family__head { display: flex; align-items: baseline; gap: 0.875rem; }
  .eco-family__num { font-family: var(--font-display); font-size: clamp(2rem, 3vw, 2.75rem); font-weight: 700; color: var(--haldi-deep); line-height: 1; font-variant-numeric: tabular-nums; }
  .eco-family__name { font-family: var(--font-display); font-size: clamp(1.875rem, 3.5vw, 3rem); font-weight: 700; letter-spacing: -0.02em; line-height: 1.05; }
  .eco-family__line { font-family: var(--font-display); font-style: italic; font-size: 1.125rem; color: var(--primary); margin-top: 0.75rem; }
  .eco-family__sub { margin-top: 1rem; max-width: 40rem; line-height: 1.65; }
  .eco-family__links { margin-top: 1.75rem; display: flex; flex-wrap: wrap; gap: 0.75rem; }

  /* ===== UNDOCUMENTED FAMILY SECTIONS ===== */
  .family-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .family-section__grid { display: grid; gap: 2.5rem; align-items: center; grid-template-columns: 1fr; }
  @media (min-width: 1024px) {
    .family-section__grid { grid-template-columns: 7fr 5fr; gap: clamp(2.5rem, 5vw, 4.5rem); }
    .family-section--reverse .family-section__grid { grid-template-columns: 5fr 7fr; }
    .family-section--reverse .family-section__copy { order: 2; }
  }
  .family-section__num { font-family: var(--font-display); font-size: clamp(2rem, 3vw, 2.75rem); font-weight: 700; color: var(--haldi-deep); line-height: 1; font-variant-numeric: tabular-nums; }
  .family-section__name { font-family: var(--font-display); font-size: clamp(1.75rem, 3.5vw, 2.75rem); font-weight: 700; letter-spacing: -0.02em; line-height: 1.05; margin-top: 0.5rem; }
  .family-section__line { font-family: var(--font-display); font-style: italic; font-size: 1.125rem; color: var(--primary); margin-top: 0.625rem; }
  .family-section__desc { margin-top: 1rem; max-width: 40rem; line-height: 1.7; }
  .family-section__themes { list-style: none; margin-top: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; border-top: 1px solid var(--border); padding-top: 1.125rem; }
  .family-section__themes li { font-size: 0.875rem; color: var(--fg-muted); padding-left: 1.125rem; position: relative; line-height: 1.5; }
  .family-section__themes li::before { content: ""; position: absolute; left: 0; top: 0.5em; width: 0.4375rem; height: 1px; background: var(--primary); }
  .family-section__note { margin-top: 1.5rem; font-size: 0.8125rem; color: var(--fg-muted); line-height: 1.55; border-left: 2px solid var(--haldi); padding-left: 1rem; max-width: 40rem; }
  .family-section__plate { display: none; }
  .family-section__plate-texture { position: absolute; inset: 0; opacity: 0.15; }
  .family-section__plate-texture img { width: 100%; height: 100%; object-fit: cover; }
  .family-section__plate-word { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; text-align: center; padding: 2rem; font-family: var(--font-display); font-weight: 700; font-size: clamp(1.5rem, 2.5vw, 2.25rem); color: var(--primary); line-height: 1.15; }
  .family-section__plate-tag { position: absolute; left: 1rem; bottom: 0.875rem; font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--fg-muted); }
  .family-section__cta { margin-top: 1.75rem; }

  /* ===== SPEC MATRIX ===== */
  .spec-matrix-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .spec-matrix-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .spec-matrix { border: 1px solid var(--border); border-radius: var(--r-panel); overflow: hidden; background: var(--paper); }
  .spec-matrix__row { grid-template-columns: 1fr; gap: 0.75rem; padding: 1.75rem 1.25rem; border-bottom: 1px solid var(--border); }
  @media (min-width: 768px) { .spec-matrix__row { grid-template-columns: 12rem 1fr 1fr; gap: 1.5rem; padding: 1.75rem 1.5rem; } }
  .spec-matrix__row:nth-child(even) { background: color-mix(in srgb, var(--haldi) 3%, transparent); }
  .spec-matrix__row:first-child { border-bottom: 2px solid var(--forest); background: color-mix(in srgb, var(--limewash) 80%, var(--paper)); }
  .spec-matrix__row:last-child { border-bottom: 0; }
  .spec-matrix__col-head { font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--forest); }
  .spec-matrix__col-head--distemper { color: var(--indigo); }
  .spec-matrix__col-head--emulsion { color: var(--leaf); }
  .spec-matrix__label { font-weight: 700 !important; font-size: 0.875rem !important; color: var(--fg) !important; letter-spacing: 0.02em; }
  .spec-matrix__value { font-weight: 600 !important; color: var(--fg) !important; }
  .spec-matrix-mobile { display: none; }
  @media (max-width: 639px) { .spec-matrix { display: none; } .spec-matrix-mobile { display: grid; gap: 1.5rem; } }
  .spec-matrix-mobile__block { border: 1px solid var(--border); border-top: 3px solid var(--forest); border-radius: var(--r-panel); background: var(--paper); overflow: hidden; }
  .spec-matrix-mobile__block--emulsion { border-top-color: var(--leaf); }
  .spec-matrix-mobile__name { padding: 1rem 1.25rem; font-size: 0.8125rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--forest); background: color-mix(in srgb, var(--limewash) 80%, var(--paper)); border-bottom: 1px solid var(--border); }
  .spec-matrix-mobile__block--emulsion .spec-matrix-mobile__name { color: var(--leaf); }
  .spec-matrix-mobile__row { display: flex; justify-content: space-between; align-items: baseline; gap: 1rem; padding: 0.75rem 1.25rem; border-bottom: 1px solid var(--border); }
  .spec-matrix-mobile__row:last-child { border-bottom: 0; }
  .spec-matrix-mobile__row .k { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--fg-muted); }
  .spec-matrix-mobile__row .v { font-weight: 600; color: var(--fg); text-align: right; }

  /* ===== APP MAP / COLOUR CTA / GOCAST FEATURE (V18) ===== */
  .appmap-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .appmap-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .colour-cta-section { padding-block: clamp(2.75rem, 5vw, 4rem); }
  .gocast-feature__copy .family-section__num { display: block; margin-bottom: 0.75rem; }
  .gocast-feature__copy .family-section__name { margin-bottom: 0.5rem; }
  .gocast-feature__copy .family-section__line { margin-bottom: 1.125rem; }
  .gocast-feature__copy .family-section__themes { margin-top: 1.25rem; }
  .gocast-feature__copy .family-section__cta { margin-top: 1.75rem; }
</style>

<!-- ============================================================
     1. HERO — THE GAURIKRIT PRODUCT ECOSYSTEM (§30)
     ============================================================ -->
<section class="products-hero bg-limewash" aria-labelledby="products-hero-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Products</span>
    </nav>
    <div class="products-hero__grid">
      <div class="products-hero__lockup" data-reveal>
        <span class="eyebrow"><span class="products-hero__eyebrow-dot" aria-hidden="true"></span>The Gaurikrit Product Ecosystem</span>
        <hr class="products-hero__rule">
        <h1 class="products-hero__title" id="products-hero-title">One natural resource. Multiple useful applications.</h1>
        <p class="products-hero__sub">
          Cow dung is the shared material beginning. Gaurikrit develops it in
          four directions — Eco-Paints is the documented family; GoCast Logs,
          Bio-Coal Logs and Utility Products are development directions.
        </p>
      </div>
      <div class="products-hero__visual" data-reveal>
        ${ecoPic('eco-paints-pair', [640, 960, 1280, 1600, 1920], '(min-width: 1200px) 52vw, (min-width: 900px) 48vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints family', depth, 'class="hero-group-photo" loading="eager" fetchpriority="high" ')}
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     2. ECO-PAINTS — the documented family (§31)
     ============================================================ -->
<section class="section section--paper eco-family" id="eco-paints" aria-labelledby="eco-family-title">
  <div class="container">
    <div class="eco-family__grid" data-reveal>
      <div class="eco-family__copy">
        <div class="eco-family__head">
          <span class="eco-family__num" aria-hidden="true">01</span>
          <h2 class="eco-family__name" id="eco-family-title">Eco-Paints</h2>
        </div>
        <p class="eco-family__line">Healthy walls inspired by nature.</p>
        <p class="eco-family__sub">
          Cow dung-based wall coatings in Distemper and Emulsion formats — the
          most developed family in the Gaurikrit ecosystem, documented with
          full product specifications.
        </p>
        <div class="eco-family__links">
          <a class="btn btn--primary" href="${relUrl(distemper.route, depth)}">View Distemper</a>
          <a class="btn btn--secondary" href="${relUrl(emulsion.route, depth)}">View Emulsion</a>
          <a class="btn btn--outline" href="${relUrl('/paint-calculator/', depth)}">Painting Calculator</a>
          <a class="btn btn--outline" href="${relUrl('/why-prakritik/', depth)}">Why Prakritik?</a>
        </div>
      </div>
      <div class="eco-family__plate" data-reveal>
        ${ecoPic('eco-paints-pair', [640, 960, 1280, 1920], '(min-width: 1024px) 45vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Prakritik Distemper and Emulsion paint packs — real Eco-Paints product photography', depth)}
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     3. DISTEMPER PRODUCT CHAPTER — catalogue plate
     ============================================================ -->
<section class="product-chapter product-chapter--distemper" aria-labelledby="distemper-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <picture>
            <source type="image/webp" srcset="${assetUrl(distemper.officialImageWebp, depth)}">
            <img class="chapter-product chapter-product--distemper"
                 src="${assetUrl(distemper.officialImage, depth)}"
                 alt="${e(distemper.name)} paint pack"
                 width="${distemper.officialImageW}" height="${distemper.officialImageH}"
                 loading="lazy" decoding="async">
          </picture>
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="${assetUrl('/assets/editorial/interior-finish-study.webp', depth)}">
            <img class="chapter-strip"
                 src="${assetUrl('/assets/editorial/interior-finish-study.jpg', depth)}"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Eco-Paints — Distemper</span>
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
     4. EMULSION PRODUCT CHAPTER (reversed) — catalogue plate
     ============================================================ -->
<section class="product-chapter product-chapter--emulsion" aria-labelledby="emulsion-chapter-title">
  <div class="container">
    <div class="product-chapter__inner" data-reveal>
      <figure class="product-chapter__visual">
        <div class="product-chapter__stage">
          <picture>
            <source type="image/webp" srcset="${assetUrl(emulsion.officialImageWebp, depth)}">
            <img class="chapter-product chapter-product--emulsion"
                 src="${assetUrl(emulsion.officialImage, depth)}"
                 alt="${e(emulsion.name)} paint pack"
                 width="${emulsion.officialImageW}" height="${emulsion.officialImageH}"
                 loading="lazy" decoding="async">
          </picture>
        </div>
        <div class="product-chapter__strip" aria-hidden="true">
          <picture>
            <source type="image/webp" srcset="${assetUrl('/assets/editorial/exterior-finish-study.webp', depth)}">
            <img class="chapter-strip"
                 src="${assetUrl('/assets/editorial/exterior-finish-study.jpg', depth)}"
                 alt=""
                 width="1344" height="768"
                 loading="lazy" decoding="async">
          </picture>
        </div>
      </figure>
      <div class="product-chapter__copy">
        <span class="product-chapter__eyebrow">Eco-Paints — Emulsion</span>
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
     5. SPEC MATRIX — factual comparison of the two documented formats
     ============================================================ -->
<section class="section section--paper spec-matrix-section" aria-labelledby="compare-title">
  <div class="container">
    <div class="spec-matrix-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Eco-Paints — side by side</span>
      <h2 class="section-heading__title" id="compare-title">Compare the two formats.</h2>
    </div>

    <div class="spec-matrix" data-reveal>
      <div class="spec-matrix__row">
        <span class="spec-matrix__col-head">Specification</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--distemper">Prakritik Distemper</span>
        <span class="spec-matrix__col-head spec-matrix__col-head--emulsion">Prakritik Emulsion</span>
      </div>
${specMatrixRows}
    </div>

    <div class="spec-matrix-mobile" data-reveal>
      <div class="spec-matrix-mobile__block">
        <div class="spec-matrix-mobile__name">${e(distemper.name)}</div>
${specMobile(distemper)}
      </div>
      <div class="spec-matrix-mobile__block spec-matrix-mobile__block--emulsion">
        <div class="spec-matrix-mobile__name">${e(emulsion.name)}</div>
${specMobile(emulsion)}
      </div>
    </div>

    <p class="coverage-disclaimer" style="margin-top: 2rem;">
      <span class="coverage-disclaimer__label">Coverage note</span>
      <span class="coverage-disclaimer__text">${e(COVERAGE_DISCLAIMER)}</span>
    </p>
  </div>
</section>

<!-- ============================================================
     06. COLOUR COLLECTIONS — quiet callout after the format
     comparison (V18 §20). TWO separate collections.
     ============================================================ -->
<section class="section section--haldi-wash colour-cta-section" aria-labelledby="colour-cta-title">
  <div class="container">
    <div class="colour-cta" data-reveal>
      <div>
        <span class="colour-cta__eyebrow">Colour Collections</span>
        <h3 class="colour-cta__title" id="colour-cta-title">
          Two shade collections, inspired by nature.
        </h3>
        <p class="colour-cta__body">
          <strong>12 Signature shades</strong> and a <strong>Premium
          collection in five groups</strong> — names and codes exactly as
          supplied on the client shade card, previewed live on the wall.
        </p>
      </div>
      <div class="colour-cta__swatch-strip" aria-hidden="true">
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[0].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[3].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[4].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[6].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[8].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[10].hex}"></span>
        <a class="btn btn--primary" href="${relUrl('/colours/', depth)}">Explore Colours</a>
      </div>
    </div>
  </div>
</section>

${gocastSection}

${biocoalSection}

${utilitySection}

<!-- ============================================================
     10. APPLICATION MAP — where the ecosystem works (§35)
     ============================================================ -->
<section class="section section--haldi-wash appmap-section" aria-labelledby="appmap-title">
  <div class="container">
    <div class="appmap-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Application map</span>
      <h2 class="section-heading__title" id="appmap-title">Where the Ecosystem Works.</h2>
    </div>
    <div class="app-matrix" data-reveal-stagger>
${appGroups}
    </div>
    <p class="app-matrix-note" data-reveal>
      Entries marked <strong>Direction</strong> are application areas under exploration —
      not products currently for sale.
    </p>
  </div>
</section>

<!-- ============================================================
     11. NEED HELP CHOOSING — CTA (V18 §41: FAQ retired)
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
        return `        <li class="benefits-grid__item">
          <span class="benefits-grid__num" aria-hidden="true">${pad2(i + 1)}</span>
          <span class="benefits-grid__name">${e(benefit.name)}</span>
          <span class="benefits-grid__deva">${e(benefit.hindi)}</span>
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
  /* V12: media is ONE designed catalogue panel (same language as the home
     product chapters, app.css §14) — soft neutral wall plate tinted with
     the format wash, complete pack anchored toward the base, slim
     wall-finish strip. Hairline border only: no 3px accent stripe,
     no shadow. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: color-mix(in srgb, var(--paper-cool) 25%, var(--paper));
    border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden;
  }
  .product-detail__stage { display: none; }
  .product-detail__panel { position: relative; aspect-ratio: 5 / 5.6; }
  @media (max-width: 640px) { .product-detail__panel { aspect-ratio: 1 / 1; } }
  .product-detail__panel img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; object-position: center 38%;
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). The box
       is biased downward so the pack stands toward the panel's base. */
    position: absolute;
    top: clamp(1.5rem, 3.5vw, 3rem);
    left: clamp(1.5rem, 3.5vw, 3rem);
    width: calc(100% - 2 * clamp(1.5rem, 3.5vw, 3rem));
    height: calc(100% - clamp(1.5rem, 3.5vw, 3rem) - clamp(0.75rem, 1.5vw, 1.25rem));
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
  .distemper-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); }
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
        <div class="product-detail__panel">
          ${ecoPic('prakritik-distemper', [640, 960, 1280, 1600], '(min-width: 1024px) 52vw, calc(100vw - 2.5rem)', 1280, 1280, 1564, 'Prakritik Distemper paint pack - complete label and pack photograph', depth, 'class="media-product" loading="eager" fetchpriority="high" ')}
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

    <!-- V15: calculator partial-prefill deep link (?paint=distemper) —
         opens the tool with step 3 already chosen. -->
    <p class="spec-plan" data-reveal>
      <span class="spec-plan__label">Plan your quantity</span>
      <a class="spec-plan__link" href="${relUrl('/paint-calculator/', depth)}?paint=distemper">
        Open the paint calculator, pre-set for Prakritik Distemper
        <span class="spec-plan__arrow" aria-hidden="true">→</span>
      </a>
    </p>
  </div>
</section>

<!-- ===== ASHTA LAABH — the shared typographic eight-benefit grid ===== -->
<section class="section section--haldi-wash distemper-ashta-section" aria-labelledby="distemper-ashta-title">
  <div class="container">
    <div class="distemper-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="distemper-ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">
        Benefits listed in the supplied Prakritik Paint material.
      </p>
    </div>

    <ol class="benefits-grid" data-reveal-stagger>
${ashtaItems}
    </ol>
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
        return `        <li class="benefits-grid__item">
          <span class="benefits-grid__num" aria-hidden="true">${pad2(i + 1)}</span>
          <span class="benefits-grid__name">${e(benefit.name)}</span>
          <span class="benefits-grid__deva">${e(benefit.hindi)}</span>
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
  /* V12: media is ONE designed catalogue panel (same language as the home
     product chapters, app.css §14) — soft neutral wall plate tinted with
     the format wash, complete pack anchored toward the base, slim
     wall-finish strip. Hairline border only: no 3px accent stripe,
     no shadow. */
  .product-detail__media {
    display: flex; flex-direction: column;
    background: color-mix(in srgb, var(--paper-leaf) 25%, var(--paper));
    border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden;
  }
  .product-detail__stage { display: none; }
  .product-detail__panel { position: relative; aspect-ratio: 5 / 5.6; }
  @media (max-width: 640px) { .product-detail__panel { aspect-ratio: 1 / 1; } }
  .product-detail__panel img {
    position: absolute; inset: 0; width: 100%; height: 100%;
    object-fit: cover; object-position: center 38%;
  }
  .product-detail__stage .media-product {
    /* Absolute-fill + object-fit: contain — the pack photo stays
       COMPLETE inside the fixed-height stage (never cropped). The box
       is biased downward so the pack stands toward the panel's base. */
    position: absolute;
    top: clamp(1.5rem, 3.5vw, 3rem);
    left: clamp(1.5rem, 3.5vw, 3rem);
    width: calc(100% - 2 * clamp(1.5rem, 3.5vw, 3rem));
    height: calc(100% - clamp(1.5rem, 3.5vw, 3rem) - clamp(0.75rem, 1.5vw, 1.25rem));
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
  .emulsion-ashta-section { padding-block: clamp(3rem, 6vw, 5rem); }
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
        <div class="product-detail__panel">
          ${ecoPic('prakritik-emulsion', [640, 960, 1280, 1600], '(min-width: 1024px) 52vw, calc(100vw - 2.5rem)', 1280, 1280, 1564, 'Prakritik Emulsion paint pack - complete label and pack photograph', depth, 'class="media-product" loading="eager" fetchpriority="high" ')}
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

    <!-- V15: calculator partial-prefill deep link (?paint=emulsion) —
         opens the tool with step 3 already chosen. -->
    <p class="spec-plan" data-reveal>
      <span class="spec-plan__label">Plan your quantity</span>
      <a class="spec-plan__link" href="${relUrl('/paint-calculator/', depth)}?paint=emulsion">
        Open the paint calculator, pre-set for Prakritik Emulsion
        <span class="spec-plan__arrow" aria-hidden="true">→</span>
      </a>
    </p>
  </div>
</section>

<!-- ===== ASHTA LAABH — the shared typographic eight-benefit grid ===== -->
<section class="section section--haldi-wash emulsion-ashta-section" aria-labelledby="emulsion-ashta-title">
  <div class="container">
    <div class="emulsion-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="emulsion-ashta-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">
        Benefits listed in the supplied Prakritik Paint material.
      </p>
    </div>

    <ol class="benefits-grid" data-reveal-stagger>
${ashtaItems}
    </ol>
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
`;
}

// ---- Why Prakritik ----
function whyPrakritikBody(depth) {
    const distemper = getProduct('prakritik-distemper');
    const emulsion = getProduct('prakritik-emulsion');
    const groupImage = '/assets/products/prakritik-group.jpg';
    const groupImg = assetUrl(groupImage, depth);

    const ashtaItems = ASHTA_LAABH.map((benefit, i) => {
        return `        <li class="benefits-grid__item">
          <span class="benefits-grid__num" aria-hidden="true">${pad2(i + 1)}</span>
          <span class="benefits-grid__name">${e(benefit.name)}</span>
          <span class="benefits-grid__deva">${e(benefit.hindi)}</span>
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
    const rawMaterialFlowPic = ecoPic('rawmat', [640, 960, 1280],
        '(min-width: 1024px) 28vw, (min-width: 640px) 42vw, calc(100vw - 2.5rem)', 960, 960, 549,
        'Raw natural biomass material', depth, 'class="editorial-image"');
    const finishedSurfaceFlowPic = pic('/assets/editorial/finished-surface-study.webp', '/assets/editorial/finished-surface-study.jpg',
        'Finished matte limewash wall surface', 1344, 768, depth, 'class="editorial-image"');
        const ruralContextPic = pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg',
        '', 1344, 768, depth, 'class="editorial-image"');

    // V16: the Colours of India study moved here from Home (Eco-Paints
    // educational context, §64). Wall-only SVG paint mask + swatches.
    const colourSwatches = COLOUR_STUDY.map((sw) => {
        const id = sw.name.toLowerCase();
        return `        <button type="button"
                class="colours-swatch"
                role="radio"
                aria-checked="false"
                style="background: ${e(sw.hex)};"
                data-shade="${e(sw.hex)}"
                data-shade-name="${e(sw.name)} (${e(sw.label)})"
                data-colour-id="${e(id)}"
                aria-label="${e(sw.name)} — ${e(sw.label)}">
          <span class="colours-swatch__label">${e(sw.name)}</span>
        </button>`;
    }).join('\n');

    return `<style>
  /* ===== Editorial image reset (V4 — NO mix-blend-mode, NO blur filters) ===== */
  .editorial-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .editorial-image--contain { object-fit: contain; }

  /* ===== 07 COLOURS OF INDIA (V16 move from home — page-local share row;
     structural colours CSS lives in app.css §19) ===== */
  .colours-share {
    min-height: 2rem;
    margin: 3.5rem 0 0;
    display: flex;
    align-items: center;
  }
  .colours-share .copy-btn { margin-left: 0; }

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
  /* V12: Section 02 TRADITION — the courtyard elevation is the chapter's
     dominant visual: copy ~45 / image ~55 on desktop; copy first, image
     second at every breakpoint. */
  @media (min-width: 1024px) {
    .why-chapter--wide-art { grid-template-columns: 45fr 55fr; gap: 3rem; align-items: center; }
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

  /* === Chapter 04 — ASHTA: the shared typographic grid (app.css §18) === */
  .why-ashta-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-ashta-section__head { max-width: 48rem; margin-bottom: 2.5rem; }

  /* === Chapter 05 — FORMATS: two real product visuals on quiet
     format-wash grounds (hairline border, no gradient, no accent
     stripe; soft grounded product shadow only). === */
  .why-formats-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-formats {
    display: grid; gap: 2rem; margin-top: 2rem;
  }
  @media (min-width: 768px) { .why-formats { grid-template-columns: 1fr 1fr; } }
  .why-format-card {
    position: relative;
    background: color-mix(in srgb, var(--paper-cool) 25%, var(--paper));
    border: 1px solid var(--border);
    border-radius: var(--r-panel); overflow: hidden;
    display: flex; align-items: center; justify-content: center; padding: 1.5rem;
    min-height: 22rem;
  }
  .why-format-card--emulsion {
    background: color-mix(in srgb, var(--paper-leaf) 25%, var(--paper));
  }
  .why-format-card .format-product {
    display: block;
    max-height: 26rem; max-width: 100%;
    width: auto; height: auto;
    object-fit: contain;
    filter: drop-shadow(0 10px 16px rgba(34, 36, 27, 0.12));
  }
  .why-format-card__caption {
    position: absolute; bottom: 1rem; left: 1rem;
    background: rgba(250, 248, 241, 0.9); padding: 0.5rem 0.875rem;
    border-radius: var(--r-pill); font-size: 0.8125rem; font-weight: 600;
  }
  .why-format-card--distemper .why-format-card__caption { color: var(--indigo); }
  .why-format-card--emulsion  .why-format-card__caption { color: var(--leaf); }

  /* === Chapter 06 — CONTEXT: framed editorial band (rural-landscape
     = regional context only, never company premises). Copy ~4 / band ~8. === */
  .why-context-section { padding-block: clamp(3.5rem, 6vw, 5rem); }
  .why-context-bg {
    position: relative; width: 100%; aspect-ratio: 1344/768;
    background: var(--limewash); border-radius: var(--r-panel);
    border: 1px solid var(--border);
    overflow: hidden; align-self: center;
  }
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

    <!-- V15: chapter index — a quiet book-style contents list linking the
         six chapter headings below. Stays inside the limewash hero band
         (no new section background family). -->
    <nav class="chapter-index" aria-label="Page contents" data-reveal>
      <p class="chapter-index__eyebrow">Contents</p>
      <ol class="chapter-index__list">
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-01-title">
            <span class="chapter-index__num" aria-hidden="true">01</span>
            <span class="chapter-index__name">A natural material for modern walls.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-02-title">
            <span class="chapter-index__num" aria-hidden="true">02</span>
            <span class="chapter-index__name">Limewashed walls, courtyard elevations.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-03-title">
            <span class="chapter-index__num" aria-hidden="true">03</span>
            <span class="chapter-index__name">From a natural material to a finished wall.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-04-title">
            <span class="chapter-index__num" aria-hidden="true">04</span>
            <span class="chapter-index__name">Eight benefits of Prakritik Paint.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-05-title">
            <span class="chapter-index__num" aria-hidden="true">05</span>
            <span class="chapter-index__name">Distemper and Emulsion.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="#chapter-06-title">
            <span class="chapter-index__num" aria-hidden="true">06</span>
            <span class="chapter-index__name">From Bulandshahr, Uttar Pradesh.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
        <li class="chapter-index__item">
          <a class="chapter-index__link" href="${relUrl('/colours/', depth)}">
            <span class="chapter-index__num" aria-hidden="true">07</span>
            <span class="chapter-index__name">Explore the shade collections.</span>
            <span class="chapter-index__arrow" aria-hidden="true">→</span>
          </a>
        </li>
      </ol>
    </nav>
    <!-- V18 §21: Explore Colours — the end of the paint/formats story. -->
    <div class="colour-cta" data-reveal style="margin-top: 2rem;">
      <div>
        <span class="colour-cta__eyebrow">Colour Collections</span>
        <h3 class="colour-cta__title">Colours Inspired by Nature.</h3>
        <p class="colour-cta__body">
          Two client-supplied collections — <strong>12 Signature shades</strong>
          and a <strong>Premium collection in five groups</strong> — previewed
          live on the wall.
        </p>
      </div>
      <div class="colour-cta__swatch-strip" aria-hidden="true">
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[0].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[3].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[4].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[6].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[8].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[10].hex}"></span>
        <a class="btn btn--primary" href="${relUrl('/colours/', depth)}">Explore Colours</a>
      </div>
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

<!-- ===== 02 TRADITION — courtyard elevation: copy ~45 / image ~55 ===== -->
<section class="section section--haldi-wash" aria-labelledby="chapter-02-title">
  <div class="container">
    <div class="why-chapter why-chapter--wide-art" data-reveal>
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
      <div class="why-tradition-art" aria-hidden="true">
        ${courtyardCh2Pic}
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
          <picture>
            <source type="image/webp" srcset="${assetUrl(distemper.officialImageWebp, depth)}">
            <img class="material-step__product"
                 src="${assetUrl(distemper.officialImage, depth)}"
                 alt="Prakritik Distemper paint pack"
                 width="${distemper.officialImageW}" height="${distemper.officialImageH}"
                 loading="lazy" decoding="async">
          </picture>
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

<!-- ===== 04 ASHTA — the shared typographic eight-benefit grid ===== -->
<section class="section section--haldi-wash why-ashta-section" aria-labelledby="chapter-04-title">
  <div class="container">
    <div class="why-ashta-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Ashta Laabh — अष्ट लाभ</span>
      <h2 class="section-heading__title" id="chapter-04-title">Eight benefits of Prakritik Paint.</h2>
      <p class="section-heading__desc">
        Benefits listed in the supplied Prakritik Paint material.
      </p>
    </div>
    <ol class="benefits-grid" data-reveal-stagger>
${ashtaItems}
    </ol>
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
        <picture>
          <source type="image/webp" srcset="${assetUrl(distemper.officialImageWebp, depth)}">
          <img class="format-product"
               src="${assetUrl(distemper.officialImage, depth)}"
               alt="${e(distemper.name)}"
               width="${distemper.officialImageW}" height="${distemper.officialImageH}"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-format-card__caption">${e(distemper.packagingShort)} packs</span>
      </div>
      <div class="why-format-card why-format-card--emulsion">
        <picture>
          <source type="image/webp" srcset="${assetUrl(emulsion.officialImageWebp, depth)}">
          <img class="format-product"
               src="${assetUrl(emulsion.officialImage, depth)}"
               alt="${e(emulsion.name)}"
               width="${emulsion.officialImageW}" height="${emulsion.officialImageH}"
               loading="lazy" decoding="async">
        </picture>
        <span class="why-format-card__caption">${e(emulsion.packagingShort)} packs</span>
      </div>
    </div>

    <!-- V18 §21: Explore Colours — the end of the paint/formats story. -->
    <div class="colour-cta" data-reveal style="margin-top: 2rem;">
      <div>
        <span class="colour-cta__eyebrow">Colour Collections</span>
        <h3 class="colour-cta__title">Colours Inspired by Nature.</h3>
        <p class="colour-cta__body">
          Two client-supplied collections — <strong>12 Signature shades</strong>
          and a <strong>Premium collection in five groups</strong> — previewed
          live on the wall.
        </p>
      </div>
      <div class="colour-cta__swatch-strip" aria-hidden="true">
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[0].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[3].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[4].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[6].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[8].hex}"></span>
        <span class="colour-cta__swatch" style="background: ${SHADE_SIGNATURE[10].hex}"></span>
        <a class="btn btn--primary" href="${relUrl('/colours/', depth)}">Explore Colours</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== 06 CONTEXT — framed editorial context band (regional context,
     never company premises): copy ~4 / band ~8 on desktop ===== -->
<section class="section section--limewash why-context-section" aria-labelledby="chapter-06-title">
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
          <a class="btn btn--outline" href="${relUrl('/about/', depth)}">Our Story</a>
        </div>
      </div>
      <div class="why-context-bg" aria-hidden="true">
        ${ruralContextPic}
      </div>
    </div>
  </div>
</section>

`;
}

// ---- About — V4 ----
function aboutBody(depth) {
    const rawMaterialAbout = ecoPic('rawmat', [640, 960, 1280], '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)', 960, 960, 549, 'Raw natural biomass material - the resource', depth);

    const address = COMPANY.address;
    const addressLine = address.slice(0, 6).join('\n');
    const groupImage = assetUrl('/assets/products/prakritik-group.jpg', depth);

    const journeyStops = [
        ['Stage 01', 'Resource', 'Cow dung — recognised and gathered.'],
        ['Stage 02', 'Idea', 'A practical direction for a traditional material.'],
        ['Stage 03', 'Application', 'Prakritik Paint — walls, documented.'],
        ['Stage 04', 'Ecosystem', 'Fuel and utility directions around one resource.'],
    ].map(([stage, name, desc]) => `        <div class="journey-stop">
            <span class="journey-stop__stage">${e(stage)}</span>
            <h3 class="journey-stop__name">${e(name)}</h3>
            <p class="journey-stop__desc">${e(desc)}</p>
        </div>`).join('\n');

    const circularStages = CIRCULAR_STAGES.map((stage) => `          <li class="stage">
            <span class="stage__num">${e(stage.num)}</span>
            <h3 class="stage__name">${e(stage.name)}</h3>
            <p class="stage__desc">${e(stage.desc)}</p>
          </li>`).join('\n');

    const familiesMarkup = FAMILIES.map((family) => {
        const themes = family.themes.map((t) => `              <li>${e(t)}</li>`).join('\n');
        return `          <article class="family">
              <div class="family__head">
                <span class="family__num" aria-hidden="true">${e(family.num)}</span>
                <h3 class="family__name">${e(family.name)}</h3>
              </div>
              <p class="family__line">${e(family.line)}</p>
              <ul class="family__themes">
${themes}
              </ul>
              <a class="family__cta" href="${relUrl(family.href, depth)}">
                Explore ${e(family.name)} <span aria-hidden="true">→</span>
              </a>
            </article>`;
    }).join('\n');

    const phoneRows = COMPANY.phones.map((phone) => `      <div class="company-plate__row">
        <dt>Phone</dt>
        <dd>
          <a href="tel:${e(phone.replace(/ /g, ''))}">${e(phone)}</a>
        </dd>
      </div>`).join('\n');

    return `<style>
  /* ===== STORY HERO — brand identity left, real product plate right ===== */
  .about-hero { padding-top: calc(var(--header-h) + 2rem); padding-bottom: 1.5rem; }
  .about-hero__container { display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center; grid-template-columns: 1fr; }
  @media (min-width: 1024px) { .about-hero__container { grid-template-columns: 5fr 7fr; } }
  .about-hero__lockup { display: flex; flex-direction: column; gap: 0.75rem; }
  .about-hero__deva { font-family: var(--font-deva); font-size: 1.75rem; color: var(--primary); line-height: 1.2; }
  .about-hero__brand-sub { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: var(--fg-muted); }
  .about-hero__title { font-family: var(--font-display); font-size: clamp(2.25rem, 4.5vw, 3.75rem); line-height: 1.06; letter-spacing: -0.02em; }
  .about-hero__body { max-width: 38rem; font-size: 1.0625rem; line-height: 1.65; color: var(--fg-muted); }
  .about-hero__plate { background: var(--paper); border: 1px solid var(--border); border-radius: var(--r-panel); padding: clamp(1rem, 2vw, 1.5rem); display: flex; flex-direction: column; gap: 1rem; }
  .about-hero__plate-head { display: flex; align-items: center; gap: 0.875rem; padding-bottom: 0.875rem; border-bottom: 1px solid var(--border); }
  .about-hero__plate-mark { border-radius: 6px; }
  .about-hero__plate-brand { font-family: var(--font-deva); font-size: 1.25rem; color: var(--primary); line-height: 1.2; display: flex; flex-direction: column; gap: 0.125rem; }
  .about-hero__plate-brand small { font-family: var(--font-sans); font-size: 0.5625rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-muted); }
  .about-hero__plate-photo { display: block; width: 100%; height: auto; object-fit: contain; }

  /* ===== STORY WRAP ===== */
  .story-wrap { padding-block: clamp(3.5rem, 6vw, 5.5rem); }
  .story-wrap--first { padding-top: clamp(3rem, 5vw, 4.5rem); }

  /* ===== ECOSYSTEM (compact families, no media) ===== */
  .story-families { margin-top: 2rem; }
  /* V18 §47B: white-ground client photography in a deliberate plate. */
  .resource-step__figure--plate { background: #fff; display: flex; align-items: center; justify-content: center; padding: clamp(0.5rem, 1vw, 0.75rem); }
  .resource-step__figure--plate img { position: static; inset: auto; width: auto; max-width: 100%; max-height: 100%; height: auto; object-fit: contain; }

  /* ===== COMPANY PLATE ===== */
  .company-plate-section { padding-block: clamp(3rem, 6vw, 5rem); }
  .company-plate__head { max-width: 48rem; margin-bottom: 2.5rem; }
  .company-plate { display: grid; gap: 0; border: 1px solid var(--border); border-radius: var(--r-panel); background: var(--paper); overflow: hidden; max-width: 56rem; }
  .company-plate__row { display: grid; gap: 0.75rem; padding: 1.125rem 1.5rem; border-bottom: 1px solid var(--border); }
  .company-plate__row:last-child { border-bottom: 0; }
  @media (min-width: 768px) { .company-plate__row { grid-template-columns: 12rem 1fr; align-items: baseline; } }
  .company-plate dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; color: var(--fg-muted); }
  .company-plate dd { color: var(--fg); }
  .company-plate__address { white-space: pre-line; }
</style>

<!-- ===== STORY HERO ===== -->
<section class="about-hero bg-limewash" aria-labelledby="about-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Our Story</span>
    </nav>
    <div class="about-hero__container" data-reveal>
      <div class="about-hero__lockup">
        <span class="about-hero__deva">${e(COMPANY.devanagari)}</span>
        <span class="about-hero__brand-sub">Gaurikrit Bio Products</span>
        <h1 class="about-hero__title" id="about-title">One resource. One idea. A widening material story.</h1>
        <p class="about-hero__body">
          ${e(COMPANY.legalName)} builds a material ecosystem around one
          natural resource — cow dung — from Prakritik Paint to fuel and utility
          directions. Based in ${e(address[3] || '')},
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
             src="${groupImage}"
             alt="Prakritik Distemper and Emulsion paint packs — the documented Eco-Paints family"
             width="1280" height="621"
             loading="eager" fetchpriority="high" decoding="async">
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     01. THE RESOURCE
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
          ${ecoPic('rawmat', [640, 960, 1280, 1920], '(min-width: 1024px) 42vw, calc(100vw - 2.5rem)', 960, 960, 549, 'Raw natural biomass material with straw fibre - the resource', depth)}
          <figcaption>Raw material study — natural surface traditions of Indian homes.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     02. THE IDEA
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
          ${ecoPic('innovation-research', [640, 960, 1280, 1920], '(min-width: 1024px) 42vw, calc(100vw - 2.5rem)', 960, 960, 600, 'Material research samples - raw biomass, processed log and finished coating', depth)}
          <figcaption>Developed material study — the resource carried into a finished surface.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     04. FROM RESOURCE TO APPLICATION (V18 §40 / §25)
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
              ${rawMaterialAbout}
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
              ${ecoPic('eco-paints-pair', [640, 960, 1280], '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)', 960, 960, 600, 'Prakritik Distemper and Prakritik Emulsion paint packs - the documented application', depth)}
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
              ${ecoPic('gocast-material', [640, 960, 1280], '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)', 960, 960, 640, 'Client-supplied cow-dung log material - the widening direction', depth)}
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
          <a href="${relUrl('/products/', depth)}">Products →</a> — the circular framework on
          <a href="${relUrl('/sustainability/', depth)}">Sustainability →</a>
        </p>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     06 + 07. VISION + MISSION
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
          ${e(COMPANY.vision)}
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
          <a class="btn btn--haldi" href="${relUrl('/products/', depth)}">Explore the Ecosystem</a>
          <a class="btn btn--secondary" href="${relUrl('/contact/', depth)}">Talk to Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     08. COMPANY INFORMATION — verified legal ledger
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
      <a class="btn btn--outline" href="${relUrl('/for-business/', depth)}">Partners</a>
    </div>
  </div>
</section>
`;
}

function forBusinessBody(depth) {
    const phones = COMPANY.phones;

    const audiences = [
        { num: '01', title: 'Distributors & Dealers',
          desc: 'Bring Prakritik Paint — and future Gaurikrit families — to your market.' },
        { num: '02', title: 'Architects & Contractors',
          desc: 'Discuss product and project requirements for residential, commercial, or institutional work.' },
        { num: '03', title: 'Institutions, CSR & NGOs',
          desc: 'Talk to Gaurikrit about institutional or sustainability-led projects.' },
        { num: '04', title: 'Industries & Sustainability Partners',
          desc: 'Explore collaboration around cow-dung-based bio-products and material directions.' },
    ];

    const helpfulInclude = [
        { label: 'Interest',           hint: 'Eco-Paints, GoCast, Bio-Coal, Utility Products — or a partnership' },
        { label: 'City',               hint: 'Where the site or market is located' },
        { label: 'Approximate wall area', hint: 'In sq.ft. if you have a number (for paint projects)' },
        { label: 'Paint format',      hint: 'Distemper, Emulsion, or not sure yet' },
        { label: 'Approximate requirement', hint: 'Approximate quantity, if known' },
    ];

    const audienceStripItems = PARTNER_AUDIENCES.map((a) => `        <li class="partner-strip__item">${e(a)}</li>`).join('\n');

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
    const bizTiles = [
        ['eco-paints-pair', 'Prakritik paint packs'],
        ['gocast-editorial', 'Cow-dung logs on a terracotta plate'],
        ['biocoal-editorial', 'Representative biomass briquettes'],
        ['utility-material-direction', 'Representative moulded utility forms'],
    ];
    const archHeroPic = `<div class="biz-hero__ecosystem" role="img" aria-label="The Gaurikrit material ecosystem">
${bizTiles.map(([stem]) => `          <figure class="biz-hero__tile">
            ${ecoPic(stem, [640, 960], '(min-width: 1024px) 17vw, (min-width: 640px) 45vw, calc(50vw - 1.5rem)', 640, 640, 480, '', depth)}
          </figure>`).join('\n')}
        </div>`;

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

  /* ===== AUDIENCES (V16: the seven partner audiences as a flexible
     partner-strip + four audience cards; the 4-ruled-column visual is
     retired) ===== */
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
    border-radius: var(--r-panel); padding: 2rem;
    box-shadow: 0 8px 24px -8px rgba(34, 36, 27, 0.12);
  }
  @media (min-width: 768px) { .biz-form-card { padding: 2.5rem; } }
  .biz-form-card__intro { font-size: 0.875rem; color: var(--fg-muted); margin-bottom: 2rem; }
  .biz-form-card__intro .req { color: var(--mitti); }
  .form-grid { gap: 1.5rem; }
  .biz-form-card .form-input,
  .biz-form-card .form-select,
  .biz-form-card .form-textarea {
    transition: border-color var(--dur), box-shadow var(--dur);
  }
  .biz-form-card .form-input:focus,
  .biz-form-card .form-select:focus,
  .biz-form-card .form-textarea:focus {
    outline: 0;
    border-color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 25%, transparent);
  }
  .biz-aside-card {
    border-top: 1px solid var(--border); padding: 0; background: transparent;
  }
  .biz-aside-card__row { padding-block: 1rem; border-bottom: 1px solid var(--border); }
  .biz-aside-card dt { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; color: var(--fg-muted); }
</style>

<!-- ===== HERO (V16 §41: "Build with Gaurikrit." — the whole ecosystem) ===== -->
<section class="biz-hero bg-limewash" aria-labelledby="biz-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Partners</span>
    </nav>
    <div class="biz-hero__container" data-reveal>
      <div class="biz-hero__lockup">
        <span class="biz-hero__eyebrow"><span class="biz-hero__eyebrow-dot" aria-hidden="true"></span>Partners</span>
        <hr class="biz-hero__rule">
        <h1 class="biz-hero__title" id="biz-title">Build with Gaurikrit.</h1>
        <p class="biz-hero__sub">
          For distributors, dealers, architects, contractors, institutions,
          industries and sustainability partners. Talk to us about
          Eco-Paints today — and the GoCast, Bio-Coal and utility directions
          as they develop.
        </p>
        <div class="biz-hero__ctas">
          <a class="btn btn--primary btn--lg" href="#enquire">Discuss a Project</a>
          <a class="btn btn--outline" href="${relUrl('/products/', depth)}">Explore the Ecosystem</a>
        </div>
      </div>
      <div class="biz-hero__art" aria-hidden="true">
        ${archHeroPic}
      </div>
    </div>
  </div>
</section>

<!-- ===== AUDIENCES — V16: the seven partner audiences as a flexible
     partner-strip + four audience cards. ===== -->
<section class="section section--paper biz-audiences-section" aria-labelledby="audiences-title">
  <div class="container">
    <div class="biz-audiences__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Who this is for</span>
      <h2 class="section-heading__title" id="audiences-title">Partner with a material ecosystem.</h2>
    </div>

    <div class="partner-strip" data-reveal>
      <ul class="partner-strip__list">
${audienceStripItems}
      </ul>
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
          A few practical details up front let us respond with what we can
          supply — pack sizes, format, and how Prakritik Paint fits your project.
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
            Tell us about the project or the partnership. We will respond with
            what we can practically supply — pack sizes, format, and how the
            Gaurikrit ecosystem fits your project.
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
      
           
      <!-- data-static-preview: forms.js opens a pre-filled mailto draft
           instead of POSTing (no PHP endpoint on the static build). -->
      <form class="biz-form-card" action="mailto:seva@gaurikrit.com" method="post"
            data-business-form data-static-preview novalidate>
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
  .calc-hero__grid {
    display: grid; gap: clamp(1.5rem, 3vw, 3rem);
    grid-template-columns: 1fr; align-items: center;
  }
  @media (min-width: 1024px) { .calc-hero__grid { grid-template-columns: 7fr 5fr; } }
  @media (max-width: 1023px) { .calc-hero__plate { order: 5; max-width: 34rem; } }
  .calc-hero__plate { margin: 0; }
  .calc-hero__plate img {
    display: block; width: 100%; height: auto;
    border-radius: 0.1875rem; border: 1px solid var(--border);
  }
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

  /* ===== CALCULATOR PAGE — V12: the tool IS the page. The decorative
     sticky wall-scene (photo + never-driven SVG) is retired — the UI is
     more important than the picture. Single column, max 60rem. ===== */
  .calculator-page {
    padding-top: clamp(1.5rem, 3vw, 2.5rem);
    padding-bottom: clamp(4rem, 7vw, 6rem);
    display: grid; gap: 2.5rem;
    grid-template-columns: minmax(0, 60rem);
    justify-content: center;
  }

  /* The actual calculator mount — JS builds the UI inside it. */
  .calculator-page__steps { display: grid; gap: 1.5rem; }

  .calc__cards { display: grid; gap: 0.875rem; margin-top: 1rem; }
  @media (min-width: 640px) { .calc__cards { grid-template-columns: 1fr 1fr; } }
  .calc__card {
    padding: 1.25rem 1.5rem;
    border: 2px solid var(--border-strong);
    background: var(--paper); border-radius: var(--r-btn);
    text-align: left; cursor: pointer; min-height: 44px;
    display: flex; flex-direction: column; gap: 0.25rem;
    transition: background var(--dur), border-color var(--dur), color var(--dur), transform var(--dur), box-shadow var(--dur);
  }
  .calc__card:hover {
    border-color: var(--forest); color: var(--forest);
    transform: translateY(-1px);
  }
  .calc__card[aria-pressed="true"] {
    background: color-mix(in srgb, var(--haldi) 22%, var(--paper));
    border-color: var(--forest); color: var(--forest);
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--haldi) 30%, transparent);
    transform: translateY(-1px);
  }
  .calc__card-title { font-weight: 700; font-size: 1.0625rem; }
  .calc__card-desc  { font-size: 0.8125rem; color: var(--fg-muted); }

  /* Progress indicator styling */
  .calc__progress {
    list-style: none; display: flex; gap: 0.75rem; margin: 0 0 2rem;
    padding: 0; flex-wrap: wrap;
  }
  .calc__progress-item { display: flex; align-items: center; gap: 0.5rem; }
  .calc__progress-btn {
    background: transparent; border: 0; padding: 0;
    display: flex; align-items: center; gap: 0.5rem;
    cursor: pointer; color: var(--fg-muted);
    font-size: 0.9375rem; font-weight: 600;
  }
  .calc__progress-btn[disabled] { cursor: not-allowed; opacity: 0.5; }
  .calc__progress-dot {
    display: inline-flex; align-items: center; justify-content: center;
    width: 2rem; height: 2rem; border-radius: 50%;
    border: 2px solid var(--border-strong);
    font-family: var(--font-display); font-weight: 700; font-size: 0.8125rem;
    color: var(--fg-muted);
    transition: background var(--dur), border-color var(--dur), color var(--dur), box-shadow var(--dur), transform var(--dur);
  }
  .calc__progress-item.is-current .calc__progress-dot {
    border-color: var(--forest); color: var(--forest);
    background: color-mix(in srgb, var(--haldi) 22%, var(--paper));
    box-shadow: 0 0 0 4px color-mix(in srgb, var(--haldi) 12%, transparent);
    transform: scale(1.05);
  }
  .calc__progress-item.is-done .calc__progress-dot {
    background: var(--forest); border-color: var(--forest); color: var(--paper);
    transform: scale(1.08);
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
    <div class="calc-hero__grid">
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
      <figure class="calc-hero__plate" data-reveal>
        ${ecoPic('colours-wall', [640, 960, 1280], '(min-width: 1024px) 40vw, calc(100vw - 2.5rem)', 960, 960, 549, 'Limewash wall interior - the surfaces your estimate covers', depth, 'loading="eager" ')}
      </figure>
    </div>
  </div>
</section>

<!-- ===== CALCULATOR PAGE — the tool is the page (V12: decorative
     wall-scene visual retired; single quiet column) ===== -->
<section class="bg-limewash" style="padding-top: 0;">
  <div class="container">
    <div class="calculator-page" data-reveal>
      <!-- V15: print-only estimate sheet header — hidden on screen
           (app.css §41.4), revealed in print (§36.8). calculator.js
           stamps the "Prepared on" date line when a result is computed;
           the result panel below it prints the project values. -->
      <div class="calc-print-sheet">
        <p class="calc-print-sheet__brand">Gaurikrit Bio Products (OPC) Pvt Ltd</p>
        <p class="calc-print-sheet__meta">seva@gaurikrit.com &middot; +91 9999624446 &middot; +91 9837638842</p>
        <p class="calc-print-sheet__meta">Khurja, Bulandshahr, Uttar Pradesh 203131 &middot; GSTIN 09AAMCG8400F1ZK</p>
        <hr class="calc-print-sheet__rule">
        <p class="calc-print-sheet__title">Paint requirement summary</p>
        <p class="calc-print-sheet__meta" data-print-date></p>
        <p class="calc-print-sheet__foot">Generated from the Gaurikrit paint calculator. Coverage per listed product specifications. For an accurate estimate, contact Gaurikrit with these project details.</p>
      </div>

      <!-- 4-step calculator mount -->
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
          <a class="btn btn--outline btn--lg" href="${relUrl('/contact/', depth)}">Contact</a>
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
    padding-block: 1.125rem; border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: 1fr; gap: 0.25rem;
    align-items: baseline;
  }
  @media (min-width: 640px) {
    .contact-info__row { grid-template-columns: 11rem 1fr; gap: 1rem; }
  }
  .contact-info__row dt {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--fg-muted);
  }
  .contact-info__row dd { font-size: 1rem; color: var(--fg); }
  .contact-info__row dd a { color: var(--primary); text-decoration: none; }
  .contact-info__row dd a:hover { text-decoration: underline; }
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
    border-radius: var(--r-panel); padding: 2rem;
    box-shadow: 0 8px 24px -8px rgba(34, 36, 27, 0.12);
  }
  @media (min-width: 768px) { .contact-form { padding: 2.5rem; } }
  .contact-form .form-input,
  .contact-form .form-select,
  .contact-form .form-textarea {
    transition: border-color var(--dur), box-shadow var(--dur);
  }
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
  .form-grid { gap: 1.5rem; }
  .contact-form__foot-links {
    margin-top: 1.5rem; padding-top: 1.25rem;
    border-top: 1px solid var(--border);
    display: flex; flex-wrap: wrap; gap: 0.625rem; align-items: center;
    font-size: 0.875rem; color: var(--fg-muted);
  }
  .contact-form__foot-links a {
    color: var(--primary); text-decoration: none; font-weight: 600;
  }
  .contact-form__foot-links a:hover { text-decoration: underline; }
  .contact-form__foot-links span { color: var(--border-strong); }
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

      <!-- RIGHT — enquiry form. Static demo uses a safe email fallback
           (data-static-preview: forms.js opens a pre-filled mailto draft
           instead of POSTing — no PHP endpoint on the static build). -->
      <form class="contact-form" action="mailto:seva@gaurikrit.com" method="post"
            data-contact-form data-static-preview novalidate>
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

        <!-- V5: supporting CTAs as small text links below the form — no
             longer competing as buttons with the form's submit. -->
        <p class="contact-form__foot-links">
          <a href="${relUrl('/for-business/', depth)}">For Business</a>
          <span aria-hidden="true">·</span>
          <a href="${relUrl('/paint-calculator/', depth)}">Estimate Your Project</a>
        </p>
      </form>
    </div>
  </div>
</section>
`;
}

// ---- 404 ----
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
        <a class="btn btn--outline btn--lg" href="${relUrl('/products/', depth)}">Explore Products</a>
      </div>
    </div>
  </div>
</section>
`;
}

// ---- Sustainability (V16 NEW route /sustainability/) ----
function sustainabilityBody(depth) {
    const circularStages = CIRCULAR_STAGES.map((stage) => `          <li class="stage">
            <span class="stage__num">${e(stage.num)}</span>
            <h3 class="stage__name">${e(stage.name)}</h3>
            <p class="stage__desc">${e(stage.desc)}</p>
          </li>`).join('\n');

    const appGroups = APPLICATION_GROUPS.map((group) => {
        const items = group.items.map((item) => {
            const cls = item.live ? ' app-group__item--live' : ' app-group__item--direction';
            const name = item.href
                ? `<a href="${relUrl(item.href, depth)}">${e(item.name)}</a>`
                : `<span>${e(item.name)}</span>`;
            return `            <li class="app-group__item${cls}">
              ${name}
              <span class="app-group__item-tag">${item.live ? 'Family' : 'Direction'}</span>
            </li>`;
        }).join('\n');
        return `        <div class="app-group">
          <h3 class="app-group__title">${e(group.title)}</h3>
          <ul class="app-group__list">
${items}
          </ul>
        </div>`;
    }).join('\n');

    const impactRows = IMPACT_AREAS.map((area) => `        <div class="impact-row">
          <span class="impact-row__label">${e(area.label)}</span>
          <span class="impact-row__area">${e(area.area)}</span>
          <p class="impact-row__desc">${e(area.desc)}</p>
        </div>`).join('\n');

    const measurementItems = [
        ['Trees / Resource conservation', 'Trees saved through GoCast and material directions — measured when verified project data is available.'],
        ['Waste / Material reuse', 'Natural and agricultural material streams carried into products.'],
        ['Energy / Fossil fuel replaced', 'Biomass fuel applications replacing conventional fuel use.'],
        ['Carbon / Reduction', 'Emissions reduction from verified lifecycle analysis.'],
        ['Rural livelihoods', 'Additional value created around agricultural ecosystems.'],
    ].map(([name, desc]) => `        <div class="measure-item">
          <span class="measure-item__name">${e(name)}</span>
          <p class="measure-item__desc">${e(desc)}</p>
        </div>`).join('\n');

    return `<style>
  /* ===== PAGE HERO — story-hero (shared §42.11) + material plate ===== */
  .sustain-hero__grid {
    display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .sustain-hero__grid { grid-template-columns: 7fr 5fr; } }
  .sustain-hero__plate {
    position: relative; aspect-ratio: 4 / 3;
    border: 1px solid var(--border); border-radius: var(--r-panel);
    overflow: hidden; background: var(--paper);
  }
  .sustain-hero__plate img {
    position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;
  }
  .sustain-hero__plate::after {
    content: ""; position: absolute; left: 0; top: 0; width: 2.5rem; height: 0.25rem;
    background: var(--haldi);
  }
  .sustain-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
  /* V18 §47B: white-ground client imagery in a deliberate plate. */
  .resource-step__figure--plate { background: #fff; display: flex; align-items: center; justify-content: center; padding: clamp(0.5rem, 1vw, 0.75rem); }
  .resource-step__figure--plate img { position: static; inset: auto; width: auto; max-width: 100%; max-height: 100%; height: auto; object-fit: contain; }
</style>

<!-- ============================================================
     HERO — One Resource. A Wider Material Cycle.
     ============================================================ -->
<section class="story-hero bg-limewash" aria-labelledby="sustain-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Sustainability</span>
    </nav>
    <div class="sustain-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Sustainability &amp; Circular Economy</span>
        <h1 class="story-hero__title" id="sustain-title">One Resource. A Wider Material Cycle.</h1>
        <p class="story-hero__lead">
          Gaurikrit's sustainability approach is a material system, not a
          marketing dashboard: one natural resource, developed into useful
          products, in a cycle designed so nothing goes to waste.
        </p>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--primary" href="#impact-areas">How Impact Is Created</a>
          <a class="btn btn--secondary" href="${relUrl('/about/', depth)}">Our Story</a>
        </div>
      </div>
      <figure class="sustain-hero__plate">
        ${ecoPic('rawmat', [960, 1280, 1920], '(min-width: 1024px) 44vw, calc(100vw - 2.5rem)', 1280, 1280, 731, 'Natural biomass material with straw fibre - the resource beginning of the material cycle', depth, 'loading="eager" fetchpriority="high" ')}
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     S1. CIRCULAR ECONOMY — the seven-stage loop
     ============================================================ -->
<section class="section section--paper" id="circular-economy" aria-labelledby="circ-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 01 — Circular Economy</span>
      <h2 class="section-heading__title" id="circ-title">The cycle is the product system.</h2>
      <p class="section-heading__desc">
        Gaurikrit's circular model describes how the resource enters, is
        developed, becomes useful products — and renews the cycle.
      </p>
    </div>
    <div class="circular" data-circular data-reveal>
      <ol class="circular__track">
${circularStages}
      </ol>
      <svg class="circular__loop-path" viewBox="0 0 1000 28" preserveAspectRatio="none" aria-hidden="true">
        <path d="M8,2 L8,20 C8,26 16,26 26,26 L974,26 C984,26 992,26 992,20 L992,10" />
      </svg>
      <span class="circular__loop-label" aria-hidden="true">Resource regeneration</span>
    </div>
  </div>
</section>

<!-- ============================================================
     S2. RESOURCE UTILISATION
     ============================================================ -->
<section class="section section--haldi-wash" id="resource-utilisation" aria-labelledby="util-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 02 — Resource Utilisation</span>
      <h2 class="section-heading__title" id="util-title">One resource, used many ways.</h2>
      <p class="section-heading__desc">
        The same natural material base is developed into wall coatings, fuel
        directions and utility directions — value multiplied by application,
        not extraction.
      </p>
    </div>
    <!-- V18 §26: three REAL outcomes — wall coatings (real paint), fuel /
         log application (client-supplied cow-dung logs), wider directions. -->
    <div class="resource-steps" data-reveal-stagger>
      <article class="resource-step">
        <figure class="resource-step__figure resource-step__figure--plate">
          ${ecoPic('prakritik-distemper', [640, 960, 1280], '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)', 960, 960, 1173, 'Prakritik Distemper paint pack - the documented wall-coating outcome', depth)}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Outcome — Wall Coatings</span>
          <h3 class="resource-step__title">Prakritik Paint</h3>
          <p class="resource-step__desc">The documented family — real wall coatings in Distemper and Emulsion formats.</p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          ${ecoPic('gocast-material', [640, 960, 1280], '(min-width: 1024px) 30vw, (min-width: 640px) 45vw, calc(100vw - 2.5rem)', 960, 960, 640, 'Client-supplied cow-dung log material - the widening direction', depth)}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Outcome — Fuel &amp; Log Application</span>
          <h3 class="resource-step__title">Cow-dung log material</h3>
          <p class="resource-step__desc">Client-supplied log material for fuel and traditional applications, in development.</p>
        </div>
      </article>
      <article class="resource-step">
        <figure class="resource-step__figure">
          ${pic('/assets/editorial/courtyard-study.webp', '/assets/editorial/courtyard-study.jpg', 'Lime-plastered courtyard — wider material directions', 1344, 768, depth)}
        </figure>
        <div class="resource-step__caption">
          <span class="resource-step__kicker">Outcome — Wider Directions</span>
          <h3 class="resource-step__title">Everyday material directions</h3>
          <p class="resource-step__desc">Utility and everyday-use directions from the same material base.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============================================================
     S3. IMPACT AREAS — qualitative, NO counters
     ============================================================ -->
<section class="section section--paper" id="impact-areas" aria-labelledby="imp-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 03 — Impact Areas</span>
      <h2 class="section-heading__title" id="imp-title">How impact is created.</h2>
      <p class="section-heading__desc">
        Five areas, described qualitatively — no numbers until verified data
        exists.
      </p>
    </div>
    <div class="impact-list" data-reveal-stagger>
${impactRows}
    </div>
    <p class="impact-note" data-reveal>
      Verified figures will be published as project data becomes available —
      see the measurement framework below.
    </p>
  </div>
</section>

<!-- ============================================================
     S4. APPLICATIONS THAT REPLACE LESS SUSTAINABLE ALTERNATIVES
     ============================================================ -->
<section class="section section--limewash" id="replacing" aria-labelledby="rep-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 04 — Replacement</span>
      <h2 class="section-heading__title" id="rep-title">Applications that replace less sustainable alternatives.</h2>
      <p class="section-heading__desc">
        Every ecosystem direction exists to substitute a conventional,
        resource-intensive alternative.
      </p>
    </div>
    <div class="app-matrix" data-reveal-stagger>
${appGroups}
    </div>
  </div>
</section>

<!-- ============================================================
     S5. RURAL VALUE CREATION
     ============================================================ -->
<section class="section section--haldi-wash" id="rural-value" aria-labelledby="rural-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">05</span>
        <span class="story-chapter__kicker">Rural Value Creation</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="rural-title">Value created where the resource already is.</h2>
        <div class="story-chapter__body">
          <p>
            Cow dung is gathered in rural and agricultural ecosystems. Developing
            it into products creates additional value around those ecosystems —
            for households, gaushalas and agricultural communities.
          </p>
          <p class="muted">
            Gaurikrit works with Gaushalas and institutions exploring
            cow-dung-based bio-products — see <a href="${relUrl('/for-business/', depth)}">Partners</a>.
          </p>
        </div>
        <figure class="story-chapter__visual">
          ${pic('/assets/editorial/rural-landscape.webp', '/assets/editorial/rural-landscape.jpg', 'Rural agricultural landscape — where the material cycle begins', 1344, 768, depth)}
          <figcaption>Rural landscape study — the resource context of the material cycle.</figcaption>
        </figure>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     S6. MEASUREMENT FRAMEWORK — numbers only when verified
     ============================================================ -->
<section class="section section--paper" id="measurement" aria-labelledby="meas-title">
  <div class="container">
    <div class="sustain-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Section 06 — Measurement Framework</span>
      <h2 class="section-heading__title" id="meas-title">What we will measure — and how it appears.</h2>
      <p class="section-heading__desc">
        Quantified impact is published only when verified project data exists.
        Nothing on this page is a projected, estimated or aspirational number.
      </p>
    </div>
    <div class="measure-list" data-reveal-stagger>
${measurementItems}
    </div>
    <div style="margin-top: 2.5rem; display: flex; flex-wrap: wrap; gap: 0.75rem;" data-reveal>
      <a class="btn btn--primary" href="${relUrl('/innovation/', depth)}">Research &amp; Innovation</a>
      <a class="btn btn--outline" href="${relUrl('/contact/', depth)}">Discuss a Collaboration</a>
    </div>
  </div>
</section>
`;
}

// ---- Innovation (V16 NEW route /innovation/) ----
function innovationBody(depth) {
    const focusRows = INNOVATION_AREAS.map((focus) => `        <div class="focus-row">
          <span class="focus-row__num" aria-hidden="true">${e(focus.num)}</span>
          <h3 class="focus-row__name">${e(focus.name)}</h3>
          <p class="focus-row__desc">${e(focus.desc)}</p>
        </div>`).join('\n');

    const methodItems = [
        ['Material-first', 'Each direction begins with a natural material and its properties, not a market template.'],
        ['Application-led', 'Research is guided by real applications — walls, fuel, ritual and daily use.'],
        ['Tradition-aware', 'Indian material traditions inform where technologies should serve, not erase.'],
        ['Verified before published', 'Directions are shared as directions. Results are shared only once verified.'],
    ].map(([name, desc]) => `        <div class="measure-item">
          <span class="measure-item__name">${e(name)}</span>
          <p class="measure-item__desc">${e(desc)}</p>
        </div>`).join('\n');

    return `<style>
  /* ===== PAGE HERO — story-hero + research composition ===== */
  .innov-hero__grid {
    display: grid; gap: clamp(2rem, 4vw, 4rem); align-items: center;
    grid-template-columns: 1fr;
  }
  @media (min-width: 1024px) { .innov-hero__grid { grid-template-columns: 6fr 6fr; } }
  .innov-hero__composition { margin: 0; position: relative; }
  .innov-hero__composition img {
    display: block; width: 100%; height: auto; border-radius: 0.1875rem;
  }
  .innov-hero__composition figcaption {
    margin-top: 0.875rem; font-size: 0.75rem; color: var(--fg-muted);
    letter-spacing: 0.02em;
  }
  .innov-section__head { max-width: 48rem; margin-bottom: 2.5rem; }
</style>

<!-- ============================================================
     HERO — Where Tradition Meets Technology.
     ============================================================ -->
<section class="story-hero bg-limewash" aria-labelledby="innov-title">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Innovation</span>
    </nav>
    <div class="innov-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Research &amp; Innovation</span>
        <h1 class="story-hero__title" id="innov-title">Where Tradition Meets Technology.</h1>
        <p class="story-hero__lead">
          Gaurikrit's research direction explores how a natural material
          understood by tradition can be developed with contemporary methods —
          into coatings, fuels, composites and building materials.
        </p>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--primary" href="#focus-areas">The Five Focus Areas</a>
          <a class="btn btn--secondary" href="${relUrl('/sustainability/', depth)}">Sustainability</a>
        </div>
      </div>
      <figure class="innov-hero__composition" role="img"
              aria-label="Material research samples - raw biomass, processed log and finished coating on one studio sweep">
        ${ecoPic('innovation-research', [960, 1280, 1920, 2560], '(min-width: 1024px) 48vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Material research samples - raw biomass, processed log and finished coating', depth, 'loading="eager" fetchpriority="high" ')}
        <figcaption>Raw material, processed biomass, finished coating - one research line.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============================================================
     FOCUS AREAS — five horizontal rows
     ============================================================ -->
<section class="section section--paper" id="focus-areas" aria-labelledby="focus-title">
  <div class="container">
    <div class="innov-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">Focus Areas</span>
      <h2 class="section-heading__title" id="focus-title">Five directions under exploration.</h2>
      <p class="section-heading__desc">
        These are FOCUS AREAS — research directions. They are not presented as
        proven accomplishments, patents or facilities.
      </p>
    </div>
    <div class="focus-rows" data-reveal-stagger>
${focusRows}
    </div>
  </div>
</section>

<!-- ============================================================
     METHOD — how Gaurikrit explores materials
     ============================================================ -->
<section class="section section--haldi-wash" id="method" aria-labelledby="method-title">
  <div class="container">
    <div class="innov-section__head section-heading section-heading--left" data-reveal>
      <span class="section-heading__eyebrow">How we explore</span>
      <h2 class="section-heading__title" id="method-title">Material-first, application-led.</h2>
    </div>
    <div class="measure-list" data-reveal-stagger>
${methodItems}
    </div>
  </div>
</section>

<!-- ============================================================
     ECO-PAINTS CONTEXT — the documented research outcome
     ============================================================ -->
<section class="section section--paper" id="documented" aria-labelledby="doc-title">
  <div class="container">
    <article class="story-chapter" data-reveal>
      <div>
        <span class="story-chapter__num" aria-hidden="true">01</span>
        <span class="story-chapter__kicker">Documented outcome</span>
      </div>
      <div>
        <h2 class="story-chapter__title" id="doc-title">Eco-Paints — where the direction became products.</h2>
        <div class="story-chapter__body">
          <p>
            The natural-coatings focus is the most developed: Prakritik
            Distemper and Prakritik Emulsion are documented, specified
            products — the reference point for how a research direction
            becomes a Gaurikrit family.
          </p>
        </div>
        <figure class="story-chapter__visual">
          ${ecoPic('eco-paints-pair', [640, 960, 1280, 1920], '(min-width: 1024px) 42vw, calc(100vw - 2.5rem)', 1280, 1280, 800, 'Prakritik Distemper and Emulsion paint packs - the documented Eco-Paints outcome', depth)}
          <figcaption>Prakritik Distemper and Emulsion — the documented Eco-Paints family.</figcaption>
        </figure>
        <div style="margin-top: 2rem; display: flex; flex-wrap: wrap; gap: 0.75rem;">
          <a class="btn btn--secondary" href="${relUrl('/products/', depth)}#eco-paints">Explore Eco-Paints</a>
          <a class="btn btn--outline" href="${relUrl('/why-prakritik/', depth)}">Why Prakritik</a>
        </div>
      </div>
    </article>
  </div>
</section>

<!-- ============================================================
     CTA — Discuss a Collaboration
     ============================================================ -->
<section class="section section--forest" aria-labelledby="collab-title">
  <div class="container">
    <div class="why-cta" data-reveal>
      <span class="why-cta__eyebrow">Collaboration</span>
      <h2 class="why-cta__title" id="collab-title">Discuss a Collaboration.</h2>
      <p class="why-cta__sub">
        Research programmes, institutions and sustainability partners —
        talk to Gaurikrit about material directions and collaboration.
      </p>
      <div class="why-cta__actions">
        <a class="btn btn--haldi" href="${relUrl('/for-business/', depth)}">Become a Partner</a>
        <a class="btn btn--secondary" href="${relUrl('/contact/', depth)}">Contact Gaurikrit</a>
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
// ============================================================
// V18 — COLOURS PAGE (/colours/): the client-backed colour experience.
// Wall-only visualizer (SVG evenodd mask + multiply blend), 12 Signature
// + 24 Premium client-supplied shades, tabs, #shade=GK-xxx deep links.
// ============================================================

function coloursBody(depth) {
    const wallPic = ecoPic('colours-wall', [960, 1280, 1920, 2560],
        '(min-width: 1024px) 56vw, calc(100vw - 2.5rem)', 1280, 1280, 731,
        'Minimal interior with a large flat limewash wall above a wooden bench and jute rug', depth,
        'class="colours-wall__art" loading="eager" ');

    const shadeBtn = (shade) => `          <button type="button" class="shade" role="radio" aria-checked="false"
                  style="--shade: ${shade.hex};"
                  data-shade="${shade.hex}"
                  data-shade-name="${e(shade.name)}"
                  data-shade-code="${e(shade.code)}"
                  aria-label="${e(shade.name)} — ${e(shade.code)}">
            <span class="shade__chip" aria-hidden="true"></span>
            <span class="shade__name">${e(shade.name)}</span>
            <span class="shade__code">${e(shade.code)}</span>
          </button>`;

    const signatureShades = SHADE_SIGNATURE.map(shadeBtn).join('\n');

    const premiumGroups = SHADE_PREMIUM_GROUPS.map((group) => `          <div class="premium-group" id="${e(group.id)}">
            <div class="premium-group__head">
              <h3 class="premium-group__name">${e(group.name)}</h3>
              <span class="premium-group__range">
                ${e(group.shades[0].code)} – ${e(group.shades[group.shades.length - 1].code)}
              </span>
            </div>
            <div class="shade-grid" role="radiogroup" aria-label="${e(group.name)} shades">
${group.shades.map(shadeBtn).join('\n')}
            </div>
          </div>`).join('\n');

    const premiumIndex = SHADE_PREMIUM_GROUPS.map(
        (group) => `          <a href="#${e(group.id)}">${e(group.name)}</a>`,
    ).join('\n');

    const heroStrokes = [0, 3, 4, 6, 8, 10].map(
        (i) => `        <span class="colours-hero__stroke" style="background: ${SHADE_SIGNATURE[i].hex}"></span>`,
    ).join('\n');

    return `<style>
  /* ===== V18 §43-45 — Colours page (page-local structures only). ===== */
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

  .colour-note {
    max-width: 46rem; border-top: 1px solid var(--border);
    padding-top: 1.25rem; font-size: 0.9375rem; color: var(--fg-muted);
    display: flex; flex-direction: column; gap: 0.75rem;
  }
  .colour-note strong { color: var(--charcoal); font-weight: 600; }

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
      <a href="${relUrl('/', depth)}">Home</a><span>›</span>
      <span>Colours</span>
    </nav>
    <div class="colours-hero__grid" data-reveal>
      <div>
        <span class="eyebrow">Prakritik Paint</span>
        <h1 class="story-hero__title" id="colours-title">Colours Inspired by Nature.</h1>
        <p class="story-hero__lead">
          Explore the Signature and Premium shade collections supplied for
          Gaurikrit Prakritik Paint — every shade name and code exactly as
          printed on the client shade card, previewed live on the wall.
        </p>
        <div class="story-hero__ctas">
          <a class="btn btn--primary" href="#wall-preview">Preview Shades on the Wall</a>
          <a class="btn btn--secondary" href="${relUrl('/products/#eco-paints', depth)}">Eco-Paints Family</a>
        </div>
      </div>
      <div class="colours-hero__ribbon" aria-hidden="true">
${heroStrokes}
      </div>
    </div>
  </div>
</section>

<!-- ============================================================
     02-05. THE COLOUR EXPERIENCE — one shared visualizer state.
     ============================================================ -->
<div class="colour-experience" data-colour-study>

  <div class="shade-sticky" data-shade-sticky data-has-selection="false" aria-live="polite">
    <span class="shade-sticky__dot" data-shade-sticky-dot aria-hidden="true"></span>
    <span class="shade-sticky__name" data-shade-sticky-name>—</span>
    <span class="shade-sticky__code" data-shade-sticky-code>—</span>
  </div>

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
          ${wallPic}
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
                Premium <span class="colour-tabs__count">GK-201-230</span>
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

  <section class="section section--limewash" id="signature" aria-labelledby="signature-title" data-collection-panel="signature">
    <div class="container">
      <div class="section-heading section-heading--left" data-reveal>
        <span class="section-heading__eyebrow">Signature Collection</span>
        <h2 class="section-heading__title" id="signature-title">Twelve signature shades.</h2>
        <p class="section-heading__desc">
          The Signature Collection as printed on the client shade card —
          codes GK-101 to GK-112.
        </p>
      </div>
      <div class="shade-grid" data-reveal-stagger role="radiogroup" aria-label="Signature Collection shades">
${signatureShades}
      </div>
    </div>
  </section>

  <section class="section section--paper" id="premium" aria-labelledby="premium-title" data-collection-panel="premium" hidden>
    <div class="container">
      <div class="section-heading section-heading--left" data-reveal>
        <span class="section-heading__eyebrow">Premium Collection</span>
        <h2 class="section-heading__title" id="premium-title">The Premium Collection, in five groups.</h2>
        <p class="section-heading__desc">
          As printed on the client shade card — Natural Neutrals, Sunshine,
          Nature Greens, Sky &amp; Water and Earth &amp; Heritage, codes
          GK-201 to GK-230.
        </p>
      </div>

      <nav class="premium-index" data-reveal aria-label="Premium Collection groups">
${premiumIndex}
      </nav>

      <div class="premium-groups">
${premiumGroups}
      </div>
    </div>
  </section>

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
          Gaurikrit. Shade names and codes are shown exactly as printed on the
          shade card — confirm physical shade cards, availability across the
          Distemper and Emulsion formats, and current stock with Gaurikrit
          before specifying. <a href="${relUrl('/contact/', depth)}">Ask about shade availability →</a>
        </p>
      </div>
    </div>
  </section>

</div>

<!-- ============================================================
     06. ECO-PAINT CTA
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
        <a class="btn btn--primary" href="${relUrl('/products/#eco-paints', depth)}">Explore Eco-Paints</a>
        <a class="btn btn--secondary" href="${relUrl('/paint-calculator/', depth)}">Plan Your Quantity</a>
      </div>
    </div>
  </div>
</section>
`;
}

const PAGES = [
    {
        route: 'index.html',
        depth: 0,
        pageMeta: {
            title: 'Gaurikrit — Circular Material Solutions from Natural Resources',
            description:
                'Gaurikrit builds a material ecosystem around one natural resource — cow dung — from Prakritik Eco-Paints to GoCast and Bio-Coal fuel directions and utility products. Circular economy from Khurja, Uttar Pradesh.',
            canonical: '/',
            pageClass: 'home',
        },
        body: homeBody,
    },
    {
        route: 'products/index.html',
        depth: 1,
        pageMeta: {
            title: 'Products — Eco-Paints, Biomass & Sustainable Material Solutions | Gaurikrit',
            description:
                'The Gaurikrit product ecosystem: Eco-Paints (Prakritik Distemper and Emulsion, fully documented) plus GoCast Logs, Bio-Coal Logs and Utility Product development directions — one natural resource, multiple applications.',
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
        route: 'colours/index.html',
        depth: 1,
        pageMeta: {
            title: 'Prakritik Paint Colours — Gaurikrit',
            description:
                'Explore Gaurikrit Prakritik Paint Signature and Premium shade collections, with interactive wall colour previews.',
            canonical: '/colours/',
            pageClass: 'colours',
        },
        body: coloursBody,
    },
    {
        route: 'about/index.html',
        depth: 1,
        pageMeta: {
            title: 'Our Story — Gaurikrit Bio Products',
            description:
                'The Gaurikrit story: one natural resource — cow dung — recognised by traditional India, carried into practical contemporary applications: Eco-Paints, fuel directions and utility products. Khurja, District Bulandshahr, Uttar Pradesh.',
            canonical: '/about/',
            pageClass: 'about',
        },
        body: aboutBody,
    },
    {
        route: 'sustainability/index.html',
        depth: 1,
        pageMeta: {
            title: 'Sustainability & Circular Economy — Gaurikrit',
            description:
                "Gaurikrit's sustainability framework: circular economy, resource utilisation, qualitative impact areas, applications that replace less sustainable alternatives, rural value creation and the measurement framework.",
            canonical: '/sustainability/',
            pageClass: 'sustainability',
        },
        body: sustainabilityBody,
    },
    {
        route: 'innovation/index.html',
        depth: 1,
        pageMeta: {
            title: 'Research & Innovation — Gaurikrit',
            description:
                "Gaurikrit's research focus areas: natural coatings, biomass energy, bio-composites, carbon reduction technologies and sustainable building materials — where tradition meets technology.",
            canonical: '/innovation/',
            pageClass: 'innovation',
        },
        body: innovationBody,
    },
    {
        route: 'for-business/index.html',
        depth: 1,
        pageMeta: {
            title: 'Partners & Business Enquiries — Gaurikrit',
            description:
                'Build with Gaurikrit: distribution, dealership, architecture, contracting, institutional, industrial and sustainability partnerships around the Gaurikrit material ecosystem — Eco-Paints, GoCast, Bio-Coal and utility directions.',
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
    for (const dir of ['brand', 'products', 'editorial', 'documents', 'social', 'fonts', 'images']) {
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
