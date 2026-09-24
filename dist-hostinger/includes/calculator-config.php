<?php
/**
 * Painting Budget Calculator — rate configuration.
 *
 * Pricing/rate data has NOT been supplied by the client.
 * All rates are null. The calculator UI works fully but does NOT show
 * rupee values until real rates are inserted here.
 *
 * To enable: set 'enabled' => true and fill in the rate arrays.
 * Rates are per sq.ft. in INR. null = not yet configured.
 *
 * Structure: [paint] => [painting_type] => [location] => rate
 */
return [
    'enabled' => false,

    'distemper' => [
        'fresh' => [
            'interior' => null,
            'exterior' => null,
        ],
        'repaint' => [
            'interior' => null,
            'exterior' => null,
        ],
    ],

    'emulsion' => [
        'fresh' => [
            'interior' => null,
            'exterior' => null,
        ],
        'repaint' => [
            'interior' => null,
            'exterior' => null,
        ],
    ],
];
