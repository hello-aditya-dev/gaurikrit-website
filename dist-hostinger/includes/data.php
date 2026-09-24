<?php
/**
 * Gaurikrit Bio Products — brand data.
 * Single source of truth for all page content.
 */

declare(strict_types=1);

$COMPANY = [
    'name'              => 'Gaurikrit',
    'fullName'          => 'Gaurikrit Bio Products',
    'devanagari'        => 'गौरीकृत',
    'supportingIdentity'=> 'Bio Products',
    'tagline'           => 'Walls that breathe sustainability.',
    'foundedYear'       => 2019,
    'siteUrl'           => $config['site_url'] ?? 'https://gaurikrit.com',
    'email'             => 'seva@gaurikrit.com',
    'phone'             => '+91 90000 00000',
    'hero' => [
        'eyebrow' => 'Prakritik Paint · Made from cow dung',
        'headlineLines' => ['Walls that breathe', 'sustainability.'],
        'subheadline' => 'Cow dung-based Prakritik Paint in distemper and emulsion formats for interior and exterior walls. Naturally breathable, naturally Indian.',
        'primaryCta' => ['label' => 'Explore Prakritik Paint', 'href' => '/products/'],
        'secondaryCta' => ['label' => 'Why Prakritik?', 'href' => '/why-prakritik/'],
    ],
    'story' => [
        'lead' => 'Gaurikrit Bio Products began at a gaushala, where cow dung was abundant and purpose was scarce.',
        'body' => 'Every year, thousands of tonnes of cow dung go unused — a material that Indian homes have used on walls for centuries. We set out to turn it back into paint. Prakritik Paint is made by cleaning, drying, and refining cow dung into a fine natural binder, then blending it with lime, plant pigments, and minerals. The result is a paint that breathes with your walls, contains no lead or VOC-heavy solvents, and carries the warmth of an Indian courtyard.',
        'founderQuote' => 'We did not invent this. Our grandmothers did. We only made it consistent.',
        'founderName' => 'The Gaurikrit team',
        'founderRole' => 'Gaushala-craft, reimagined',
    ],
    'stats' => [
        ['value' => '5+',  'numericValue' => 5,  'suffix' => '+', 'label' => 'Gaushala partners'],
        ['value' => '2',   'numericValue' => 2,  'suffix' => '',  'label' => 'Paint formats'],
        ['value' => '0',   'numericValue' => 0,  'suffix' => '',  'label' => 'Lead & VOC solvents'],
        ['value' => '100%','numericValue' => 100,'suffix' => '%', 'label' => 'Naturally breathable'],
    ],
    'marquee' => [
        'Cow-Dung Based', 'Prakritik Distemper', 'Prakritik Emulsion',
        'Naturally Breathable', 'Zero Lead', 'Limewash Heritage',
        'Gaushala Sourced', 'Interior & Exterior', 'Plant & Mineral Pigments', 'Made in Bharat',
    ],
    'certifications' => [
        ['name' => 'Lead-Free',       'desc' => 'No lead, ever'],
        ['name' => 'Low-VOC',         'desc' => 'Solvent-light'],
        ['name' => 'Breathable',       'desc' => 'Lime-based'],
        ['name' => 'Gaushala-Sourced', 'desc' => 'Cow-dung based'],
    ],
    'aboutCards' => [
        ['title' => 'Gaushala',  'desc' => 'Sourced from partner gaushalas — material with a purpose, not a waste.'],
        ['title' => 'Craft',    'desc' => 'Refined, dried, and blended in small batches the way walls were always meant to be painted.'],
        ['title' => 'Breathable','desc' => 'Lime + cow-dung binder lets walls breathe — no blistering, no trapped moisture.'],
    ],
    'socials' => [
        ['name' => 'Instagram', 'href' => '#', 'handle' => '@gaurikrit.bio'],
        ['name' => 'Facebook',  'href' => '#', 'handle' => '/gaurikritbio'],
        ['name' => 'YouTube',   'href' => '#', 'handle' => '@gaurikrit'],
        ['name' => 'LinkedIn',  'href' => '#', 'handle' => '/company/gaurikrit-bio'],
    ],
];

$PRODUCTS = [
    [
        'id' => 'prakritik-distemper',
        'slug' => 'prakritik-distemper',
        'name' => 'Prakritik Distemper',
        'category' => 'distemper',
        'categoryLabel' => 'Distemper',
        'tagline' => 'Cow dung-based natural distemper for interior walls',
        'description' => 'A breathable, cow dung-based distemper finished with lime and plant pigments. Designed for interior walls where a soft, matte, limewash-like finish is desired. No lead, no solvent-heavy binders. Walls stay breathable and free of trapped moisture.',
        'usage' => 'Living rooms, bedrooms, ceilings, and heritage interiors. Two coats over a limewash primer. Coverage ~130 sq ft per kg per coat.',
        'sizes' => ['5 kg', '10 kg', '20 kg'],
        'priceRange' => '₹180 – ₹2,400',
        'highlights' => ['Cow dung-based', 'Breathable finish', 'Zero lead'],
        'claims' => ['clm-cow-dung-based', 'clm-breathable', 'clm-zero-lead', 'clm-no-voc-solvents'],
        'image' => 'prakritik-distemper',
        'officialImage' => '/assets/products/prakritik-distemper.png',
        'accent' => 'forest',
        'featured' => true,
    ],
    [
        'id' => 'prakritik-emulsion',
        'slug' => 'prakritik-emulsion',
        'name' => 'Prakritik Emulsion',
        'category' => 'emulsion',
        'categoryLabel' => 'Emulsion',
        'tagline' => 'Cow dung-based natural emulsion for interior & exterior',
        'description' => 'A finer, more washable cow dung-based emulsion that carries the same breathable soul as our distemper but with improved scrub resistance and coverage. Suitable for both interior and sheltered exterior walls. Plant and mineral pigments only.',
        'usage' => 'Bedrooms, kitchens, corridors, and sheltered exterior walls. Two coats over a limewash primer. Coverage ~150 sq ft per litre per coat.',
        'sizes' => ['1 L', '4 L', '10 L', '20 L'],
        'priceRange' => '₹320 – ₹4,200',
        'highlights' => ['Scrub-resistant', 'Interior & exterior', 'Plant pigments'],
        'claims' => ['clm-cow-dung-based', 'clm-breathable', 'clm-zero-lead', 'clm-no-voc-solvents', 'clm-scrub-resistant'],
        'image' => 'prakritik-emulsion',
        'officialImage' => '/assets/products/prakritik-emulsion.png',
        'accent' => 'forest',
        'featured' => true,
    ],
];

$CLAIMS = [
    ['id' => 'clm-cow-dung-based', 'claim' => 'Prakritik Paint uses refined cow dung as its primary natural binder, sourced from partner gaushalas.', 'category' => 'material', 'categoryLabel' => 'Material', 'source' => 'Internal formulation declaration + gaushala sourcing log', 'reference' => 'GK-MAT-CD-2024', 'verifiedOn' => '2024-09-12'],
    ['id' => 'clm-breathable', 'claim' => 'The lime + cow-dung binder lets walls breathe, reducing trapped moisture and blistering.', 'category' => 'performance', 'categoryLabel' => 'Performance', 'source' => 'Breathability (water-vapour transmission) test', 'reference' => 'GK-BREATH-2024-04', 'verifiedOn' => '2024-09-20'],
    ['id' => 'clm-zero-lead', 'claim' => 'No lead or lead-based driers in any Prakritik Paint product.', 'category' => 'safety', 'categoryLabel' => 'Safety', 'source' => 'BIS lead-content test', 'reference' => 'GK-PB-2024-002', 'verifiedOn' => '2024-10-05'],
    ['id' => 'clm-no-voc-solvents', 'claim' => 'No solvent-heavy VOC binders; formulation is lime and plant-pigment based.', 'category' => 'safety', 'categoryLabel' => 'Safety', 'source' => 'Formulation declaration + VOC screen', 'reference' => 'GK-VOC-2024-03', 'verifiedOn' => '2024-10-20'],
    ['id' => 'clm-scrub-resistant', 'claim' => 'Prakritik Emulsion carries a tested scrub resistance suitable for everyday interior walls.', 'category' => 'performance', 'categoryLabel' => 'Performance', 'source' => 'Scrub-resistance test (emulsion)', 'reference' => 'GK-SCRUB-2024-07', 'verifiedOn' => '2024-11-01'],
    ['id' => 'clm-coverage', 'claim' => 'Distemper coverage ~130 sq ft/kg/coat; emulsion coverage ~150 sq ft/L/coat, as tested.', 'category' => 'performance', 'categoryLabel' => 'Performance', 'source' => 'Internal coverage test on standard substrate', 'reference' => 'GK-COV-2024-01', 'verifiedOn' => '2024-09-18'],
    ['id' => 'clm-gaushala-sourced', 'claim' => 'Cow dung is sourced from partner gaushalas with documented material logs.', 'category' => 'material', 'categoryLabel' => 'Material', 'source' => 'Gaushala sourcing + reconciliation log', 'reference' => 'GK-GS-2024-12', 'verifiedOn' => '2024-09-12'],
    ['id' => 'clm-limewash-heritage', 'claim' => 'The formulation follows the Indian limewash tradition — lime, pigment, and water — updated with a refined cow-dung binder.', 'category' => 'material', 'categoryLabel' => 'Material', 'source' => 'Internal craft audit + documented recipe', 'reference' => 'GK-CRAFT-2019', 'verifiedOn' => '2024-08-01'],
    ['id' => 'clm-no-heavy-metals', 'claim' => 'No heavy-metal-based pigments or driers used; colour comes from plant and mineral sources.', 'category' => 'safety', 'categoryLabel' => 'Safety', 'source' => 'Heavy-metal panel test', 'reference' => 'GK-HM-2024-05', 'verifiedOn' => '2024-10-05'],
];

$NAV = [
    ['label' => 'Home',           'href' => '/'],
    ['label' => 'Products',       'href' => '/products/'],
    ['label' => 'Why Prakritik',  'href' => '/why-prakritik/'],
    ['label' => 'About',          'href' => '/about/'],
    ['label' => 'For Business',   'href' => '/for-business/'],
    ['label' => 'Contact',        'href' => '/contact/'],
];

/**
 * Get a product by slug.
 */
function get_product(string $slug): ?array
{
    global $PRODUCTS;
    foreach ($PRODUCTS as $p) {
        if ($p['slug'] === $slug) return $p;
    }
    return null;
}

/**
 * Get a claim by id.
 */
function get_claim(string $id): ?array
{
    global $CLAIMS;
    foreach ($CLAIMS as $c) {
        if ($c['id'] === $id) return $c;
    }
    return null;
}
