<?php
/**
 * Gaurikrit Bio Products — locked factual brand data.
 * SINGLE SOURCE OF TRUTH. Only data explicitly supplied by the client.
 * No fabricated stats, claims, certifications, socials, prices, or history.
 *
 * V16 STORY RESTRUCTURE — one resource, four directions, one circular mission:
 *   - $FAMILIES         the four product-family chapters (names/lines from the
 *                       client strategy; descriptions stay directional, never
 *                       numerical).
 *   - $CIRCULAR_STAGES  the seven-stage circular model (qualitative only).
 *   - $IMPACT_AREAS     five qualitative impact areas — NO numbers, no fake
 *                       counters (verification items logged in
 *                       CLIENT_VERIFICATION_REQUIRED.md).
 *   - $INNOVATION_AREAS five research FOCUS areas — directions, not claims.
 *   - $APPLICATION_GROUPS where the ecosystem works (application directions).
 *   - $WHY_PRINCIPLES   the four differentiators.
 */

declare(strict_types=1);

$COMPANY = [
    'name'              => 'Gaurikrit',
    'devanagari'        => 'गौरीकृत',
    'legalName'         => 'Gaurikrit Bio Products (OPC) Private Limited',
    'brandLine'         => 'Good for Nature. Good for Life.',
    'mission'           => 'Transforming waste into wonder, one wall at a time.',
    'hindiTagline'      => 'गौरीकृत',
    'headline'          => 'Walls that Breathe Sustainability',
    'email'             => 'seva@gaurikrit.com',
    'phones'            => ['+91 9999624446', '+91 9837638842'],
    'gstin'             => '09AAMCG8400F1ZK',
    'address'           => [
        'House No. 55',
        'Village Khuriyawali',
        'Post Arniya',
        'Khurja',
        'District Bulandshahr',
        'Uttar Pradesh – 203131',
        'India',
    ],
    'siteUrl'           => $config['site_url'] ?? 'https://gaurikrit.com',
    'vision'            => 'To become a leading circular-economy company transforming natural and agricultural resources into sustainable products for homes, industries and communities.',
];

/**
 * Client-supplied brand positioning phrases (use sparingly, NOT as certified claims).
 */


/**
 * Exactly two confirmed products. No prices. No primer.
 * Coverage values are supplied as-is with the ** marker — never converted.
 */
$PRODUCTS = [
    [
        'id'            => 'prakritik-distemper',
        'slug'          => 'prakritik-distemper',
        'name'          => 'Prakritik Distemper Paint',
        'descriptor'    => 'Eco-Friendly Cow Dung Paint',
        'packaging'     => ['1 kg', '5 kg', '10 kg', '20 kg'],
        'packagingShort'=> '1, 5, 10 & 20 kg',
        'colour'        => 'White',
        'finish'        => 'Matt',
        'dryingTime'    => '4 hrs',
        'coverage'      => '200 sq.ft.**',
        'voc'           => 'Negligible',
        'usage'         => 'Interior & Exterior',
        'officialImage' => '/assets/products/prakritik-distemper-from-pair.png',
        'officialImageWebp' => '/assets/products/prakritik-distemper-from-pair.webp',
        'officialImageW' => 649,
        'officialImageH' => 612,
        'image'         => 'prakritik-distemper',
        'accent'        => 'indigo',
        'route'         => '/products/prakritik-distemper/',
    ],
    [
        'id'            => 'prakritik-emulsion',
        'slug'          => 'prakritik-emulsion',
        'name'          => 'Prakritik Emulsion Paint',
        'descriptor'    => 'Eco-Friendly Cow Dung Paint',
        'packaging'     => ['1 litre', '4 litre', '10 litre', '20 litre'],
        'packagingShort'=> '1, 4, 10 & 20 litre',
        'colour'        => 'White',
        'finish'        => 'Matt',
        'dryingTime'    => '4 hrs',
        'coverage'      => '300 sq.ft.**',
        'voc'           => 'Negligible',
        'usage'         => 'Interior & Exterior',
        'officialImage' => '/assets/products/prakritik-emulsion-from-pair.png',
        'officialImageWebp' => '/assets/products/prakritik-emulsion-from-pair.webp',
        'officialImageW' => 638,
        'officialImageH' => 612,
        'image'         => 'prakritik-emulsion',
        'accent'        => 'haldi',
        'route'         => '/products/prakritik-emulsion/',
    ],
];

$COVERAGE_DISCLAIMER = 'Actual coverage may vary from mentioned coverage due to factors such as method, condition of application surface, roughness and porosity.';

/**
 * Ashta Laabh — 8 client-supplied product benefits.
 * NOT independently tested claims. No invented explanations or percentages.
 */
$ASHTA_LAABH = [
    ['name' => 'Antibacterial', 'hindi' => 'जीवाणुरोधी'],
    ['name' => 'Antifungal', 'hindi' => 'कवकरोधी'],
    ['name' => 'Eco-Friendly', 'hindi' => 'पर्यावरण-मित्र'],
    ['name' => 'Natural Thermal Insulator', 'hindi' => 'प्राकृतिक ऊष्मीय इन्सुलेटर'],
    ['name' => 'Cost-Effective', 'hindi' => 'किफ़ायती'],
    ['name' => 'Free from Heavy Metals', 'hindi' => 'भारी धातुओं से मुक्त'],
    ['name' => 'Non-Toxic', 'hindi' => 'गैर-विषाक्त'],
    ['name' => 'Odourless', 'hindi' => 'गंधरहित'],
];

/**
 * Colours of India — editorial design moods. NOT available product shades.
 */
$COLOUR_STUDY = [
    ['name' => 'Haldi',  'hex' => '#E3A51A', 'label' => 'Turmeric'],
    ['name' => 'Mitti',  'hex' => '#A86E4B', 'label' => 'Earth'],
    ['name' => 'Neem',   'hex' => '#748468', 'label' => 'Leaf'],
    ['name' => 'Geru',   'hex' => '#B65432', 'label' => 'Ochre'],
    ['name' => 'Indigo', 'hex' => '#365B67', 'label' => 'Indigo'],
    ['name' => 'Chuna',  'hex' => '#F4EFE2', 'label' => 'Lime'],
];

/**
 * Material journey stages (high-level only).
 */
$MATERIAL_JOURNEY = [
    ['num' => '01', 'title' => 'Natural material', 'desc' => 'Cow dung is the material inspiration.'],
    ['num' => '02', 'title' => 'Prakritik Paint', 'desc' => 'Available as Distemper and Emulsion.'],
    ['num' => '03', 'title' => 'Finished wall', 'desc' => 'Both are listed for interior and exterior use.'],
];

/**
 * Project pathways (enquiry categories, NOT existing clients/partners).
 */
$PROJECT_PATHWAYS = [
    ['title' => 'Homeowners', 'desc' => 'Explore Prakritik Paint for your space.'],
    ['title' => 'Architects & Builders', 'desc' => 'Discuss product and project requirements.'],
    ['title' => 'Institutions / CSR', 'desc' => 'Talk to Gaurikrit about institutional or sustainability-led projects.'],
    ['title' => 'Gaushalas / Partners', 'desc' => 'Explore collaboration around cow-dung-based bio-products.'],
];

/**
 * Partner audiences (§27 / §41) — categories, NOT current clients.
 */
$PARTNER_AUDIENCES = [
    'Distributors',
    'Dealers',
    'Architects',
    'Contractors',
    'Institutions',
    'Industries',
    'Sustainability Partners',
];

/**
 * Contact form interest options — canonical set. Frontend + backend MUST match.
 * V16: broadened for the whole ecosystem (no invented products — the
 * family entries are enquiry topics, which the team can answer directly).
 */
$INTEREST_OPTIONS = [
    'general'              => 'General enquiry',
    'eco-paints'           => 'Eco-Paints',
    'prakritik-distemper'  => 'Prakritik Distemper',
    'prakritik-emulsion'   => 'Prakritik Emulsion',
    'gocast-logs'          => 'GoCast Logs',
    'bio-coal-logs'        => 'Bio-Coal Logs',
    'utility-products'     => 'Utility Products',
    'bulk-project'         => 'Bulk / Project',
    'business-partnership' => 'Business Partnership',
    'gaushala-collaboration' => 'Gaushala Collaboration',
];

/**
 * Business form project types — V16 broadened for ecosystem enquiries
 * (kept the useful paint project fields; family categories map to the
 * enquiry dropdown where relevant).
 */
$PROJECT_TYPES = [
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

/**
 * FAQ — only questions the supplied data can answer.
 */
$FAQ = [
    ['q' => 'What products are available?', 'a' => 'Prakritik Distemper Paint and Prakritik Emulsion Paint.'],
    ['q' => 'What is the finish?', 'a' => 'Matt.'],
    ['q' => 'What is the drying time?', 'a' => '4 hrs.'],
    ['q' => 'Can they be used indoors and outdoors?', 'a' => 'The supplied product specifications list usage as Interior &amp; Exterior.'],
    ['q' => 'What pack sizes are available for Distemper?', 'a' => '1 kg, 5 kg, 10 kg and 20 kg.'],
    ['q' => 'What pack sizes are available for Emulsion?', 'a' => '1 litre, 4 litre, 10 litre and 20 litre.'],
    ['q' => 'What coverage is listed for Distemper?', 'a' => '200 sq.ft.**'],
    ['q' => 'What coverage is listed for Emulsion?', 'a' => '300 sq.ft.**'],
    ['q' => 'What is the listed V.O.C. information?', 'a' => 'V.O.C.: Negligible.'],
];

/**
 * The four Gaurikrit product families — ONE resource, FOUR directions.
 * Family names + core lines come from the client strategy. Eco-Paints is
 * the only family with documented products; the other three are presented
 * as DIRECTIONS (no fake photography, no invented specifications).
 */
$FAMILIES = [
    [
        'num'      => '01',
        'id'       => 'eco-paints',
        'name'     => 'Eco-Paints',
        'line'     => 'Healthy walls inspired by nature.',
        'desc'     => 'Cow dung-based wall coatings in Distemper and Emulsion formats — the most developed family in the Gaurikrit ecosystem, documented with full product specifications.',
        'status'   => 'Documented family',
        'themes'   => ['Eco-conscious formulation', 'Sustainable building applications', 'Natural-finish positioning'],
        'href'     => '/products/#eco-paints',
    ],
    [
        'num'      => '02',
        'id'       => 'gocast-logs',
        'name'     => 'GoCast Logs',
        'line'     => 'Saving trees without changing traditions.',
        'desc'     => 'A dense log format developed as an alternative to conventional wood — directed at ceremonial and traditional applications where wood has long been the default.',
        'status'   => 'Development direction',
        'themes'   => ['Alternative to conventional wood', 'Ceremonial applications', 'Forest-conservation direction'],
        'href'     => '/products/#gocast-logs',
    ],
    [
        'num'      => '03',
        'id'       => 'bio-coal-logs',
        'name'     => 'Bio-Coal Logs',
        'line'     => 'Renewable energy from natural biomass.',
        'desc'     => 'Biomass-based fuel logs — a renewable energy direction that explores how natural material streams can reduce reliance on fossil fuels.',
        'status'   => 'Development direction',
        'themes'   => ['Biomass energy', 'Reduced fossil-fuel reliance direction', 'Sustainable fuel applications'],
        'href'     => '/products/#bio-coal-logs',
    ],
    [
        'num'      => '04',
        'id'       => 'utility-products',
        'name'     => 'Utility Products',
        'line'     => 'Sustainable products for everyday living.',
        'desc'     => 'Practical daily-use products from naturally derived materials — a plastic-reducing direction for homes, gardens and everyday routines.',
        'status'   => 'Development direction',
        'themes'   => ['Plastic-reducing alternatives', 'Practical daily-use applications', 'Circular-economy solutions'],
        'href'     => '/products/#utility-products',
    ],
];

/**
 * The circular model — seven qualitative stages. No factory imagery, no numbers.
 */
$CIRCULAR_STAGES = [
    ['num' => '01', 'name' => 'Collection',      'desc' => 'Natural and agricultural material streams are gathered.'],
    ['num' => '02', 'name' => 'Processing',      'desc' => 'The raw material is prepared and stabilised.'],
    ['num' => '03', 'name' => 'Material Enhancement', 'desc' => 'It is developed into useful working materials.'],
    ['num' => '04', 'name' => 'Manufacturing',   'desc' => 'Materials are formed into product families.'],
    ['num' => '05', 'name' => 'Products',        'desc' => 'Walls, energy and everyday-use applications.'],
    ['num' => '06', 'name' => 'Environmental Impact', 'desc' => 'Each use replaces a less sustainable alternative.'],
    ['num' => '07', 'name' => 'Resource Regeneration', 'desc' => 'The cycle renews — nothing goes to waste.'],
];

/**
 * Impact AREAS — qualitative only. NO numbers, NO live counters.
 * Verified figures will be added only when the client supplies them
 * (see CLIENT_VERIFICATION_REQUIRED.md).
 */
$IMPACT_AREAS = [
    ['label' => 'Trees',     'area' => 'Resource conservation', 'desc' => 'Reducing dependence on conventional resource-intensive alternatives.'],
    ['label' => 'Waste',     'area' => 'Material reuse',        'desc' => 'Creating useful applications for natural and agricultural material streams.'],
    ['label' => 'Energy',    'area' => 'Alternative fuel',      'desc' => 'Exploring renewable biomass-based fuel applications.'],
    ['label' => 'Carbon',    'area' => 'Reduction direction',   'desc' => 'Directional reduction of reliance on fossil-based materials.'],
    ['label' => 'Rural',     'area' => 'Value creation',        'desc' => 'Creating additional value around agricultural ecosystems.'],
];

/**
 * Research & innovation FOCUS areas — directions, not proven accomplishments.
 */
$INNOVATION_AREAS = [
    ['num' => '01', 'name' => 'Natural Coatings',             'desc' => 'Wall coatings and finishes from naturally derived materials.'],
    ['num' => '02', 'name' => 'Biomass Energy',               'desc' => 'Fuel directions from natural biomass material streams.'],
    ['num' => '03', 'name' => 'Bio-Composites',               'desc' => 'Composite materials that carry natural fibres and minerals.'],
    ['num' => '04', 'name' => 'Carbon Reduction Technologies', 'desc' => 'Approaches that reduce reliance on fossil-based alternatives.'],
    ['num' => '05', 'name' => 'Sustainable Building Materials', 'desc' => 'Construction materials from renewable natural resources.'],
];

/**
 * Application map — where the ecosystem works. Sub-items marked as
 * APPLICATION DIRECTIONS, not products currently for sale (except the
 * two documented Prakritik Paint formats).
 */
$APPLICATION_GROUPS = [
    [
        'title' => 'Buildings & Construction',
        'items' => [
            ['name' => 'Eco-Paints',              'href' => '/products/#eco-paints', 'live' => true],
            ['name' => 'Protective Coatings',     'href' => null, 'live' => false],
            ['name' => 'Decorative Finishes',    'href' => null, 'live' => false],
        ],
    ],
    [
        'title' => 'Energy & Fuel',
        'items' => [
            ['name' => 'Bio-Coal Logs',          'href' => '/products/#bio-coal-logs', 'live' => false],
            ['name' => 'Biomass Fuel Solutions', 'href' => null, 'live' => false],
        ],
    ],
    [
        'title' => 'Traditional & Ritual Applications',
        'items' => [
            ['name' => 'GoCast Logs',            'href' => '/products/#gocast-logs', 'live' => false],
            ['name' => 'Eco Cremation Solutions','href' => null, 'live' => false],
        ],
    ],
    [
        'title' => 'Everyday Sustainable Living',
        'items' => [
            ['name' => 'Utility Products',       'href' => '/products/#utility-products', 'live' => false],
            ['name' => 'Home & Garden Products', 'href' => null, 'live' => false],
            ['name' => 'Eco Lifestyle Solutions','href' => null, 'live' => false],
        ],
    ],
];

/**
 * Why Gaurikrit — four principles (qualitative differentiators).
 */
$WHY_PRINCIPLES = [
    ['num' => '01', 'name' => 'Nature-Led Innovation',    'desc' => 'Products begin with a natural material, not a chemical substitute.'],
    ['num' => '02', 'name' => 'Circular Thinking',        'desc' => 'The same resource is designed to serve many applications.'],
    ['num' => '03', 'name' => 'Environmental Responsibility', 'desc' => 'Every direction replaces a less sustainable alternative.'],
    ['num' => '04', 'name' => 'Rural Value Creation',     'desc' => 'Value is created around agricultural ecosystems.'],
];

/**
 * Navigation — story-first, real routes, NO anchor links.
 * Calculator + Downloads are contextual utilities (footer + Eco-Paints
 * context), not primary nav items.
 */
$NAV = [
    ['label' => 'Home',           'href' => '/'],
    ['label' => 'Our Story',      'href' => '/about/'],
    ['label' => 'Products',       'href' => '/products/'],
    ['label' => 'Sustainability', 'href' => '/sustainability/'],
    ['label' => 'Innovation',     'href' => '/innovation/'],
    ['label' => 'Partners',       'href' => '/for-business/'],
    ['label' => 'Contact',        'href' => '/contact/'],
];

/**
 * Mobile-menu secondary utilities (near bottom, §46).
 */
$NAV_UTILITIES = [
    ['label' => 'Painting Calculator', 'href' => '/paint-calculator/'],
    ['label' => 'Downloads / Brochure', 'href' => '/downloads/'],
];

/**
 * Footer product-family links — anchor links into /products/ sections
 * (no family detail pages exist; do NOT link nonexistent pages).
 */
$FOOTER_PRODUCTS = [
    ['label' => 'Eco-Paints',       'href' => '/products/#eco-paints'],
    ['label' => 'Prakritik Distemper', 'href' => '/products/prakritik-distemper/'],
    ['label' => 'Prakritik Emulsion',  'href' => '/products/prakritik-emulsion/'],
    ['label' => 'GoCast Logs',      'href' => '/products/#gocast-logs'],
    ['label' => 'Bio-Coal Logs',    'href' => '/products/#bio-coal-logs'],
    ['label' => 'Utility Products', 'href' => '/products/#utility-products'],
];

function get_product(string $slug): ?array
{
    global $PRODUCTS;
    foreach ($PRODUCTS as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}
