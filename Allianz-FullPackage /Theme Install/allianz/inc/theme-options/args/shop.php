<?php
// Silence is golden.
$args = [
    'title'    => esc_html__('Shop', 'allianz'),
    'sections' => [ 
        'single'   => allianz_single_product_opts(),
    ]
];

return $args;