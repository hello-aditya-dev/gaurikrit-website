<?php
/**
 * Gaurikrit Bio Products — locked factual brand data.
 * SINGLE SOURCE OF TRUTH. Only data explicitly supplied by the client.
 * No fabricated stats, claims, certifications, socials, prices, or history.
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
        'officialImage' => '/assets/products/prakritik-distemper.jpg',
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
        'officialImage' => '/assets/products/prakritik-emulsion.jpg',
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
 * Contact form interest options — canonical set. Frontend + backend MUST match.
 */
$INTEREST_OPTIONS = [
    'general'              => 'General enquiry',
    'prakritik-distemper'  => 'Prakritik Distemper',
    'prakritik-emulsion'   => 'Prakritik Emulsion',
    'bulk-project'         => 'Bulk / Project',
    'business-partnership' => 'Business Partnership',
    'gaushala-collaboration' => 'Gaushala Collaboration',
];

/**
 * Business form project types.
 */
$PROJECT_TYPES = ['Residential', 'Commercial', 'Institutional', 'CSR / NGO', 'Gaushala Collaboration', 'Other'];

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
 * Navigation — real routes, NO anchor links. Includes Calculator.
 */
$NAV = [
    ['label' => 'Home',           'href' => '/'],
    ['label' => 'Products',       'href' => '/products/'],
    ['label' => 'Why Prakritik',  'href' => '/why-prakritik/'],
    ['label' => 'About',          'href' => '/about/'],
    ['label' => 'For Business',   'href' => '/for-business/'],
    ['label' => 'Calculator',     'href' => '/paint-calculator/'],
    ['label' => 'Contact',        'href' => '/contact/'],
];

/**
 * Products dropdown items (for the nav).
 */
$NAV_PRODUCTS = [
    ['label' => 'Prakritik Distemper', 'href' => '/products/prakritik-distemper/'],
    ['label' => 'Prakritik Emulsion',  'href' => '/products/prakritik-emulsion/'],
    ['label' => 'View All Products',    'href' => '/products/'],
];

function get_product(string $slug): ?array
{
    global $PRODUCTS;
    foreach ($PRODUCTS as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}
