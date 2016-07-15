<?php

return [
    'operator' => [
        'required' => true,
        'type'     => 'anomaly.field_type.select',
        'config'   => [
            'options' => [
                'is_in'     => 'anomaly.extension.category_discount_filter::configuration.operator.options.is_in',
                'is_not_in' => 'anomaly.extension.category_discount_filter::configuration.operator.options.is_not_in',
            ]
        ],
    ],
    'value'    => [
        'required' => true,
        'type'     => 'anomaly.field_type.relationship',
        'config'   => [
            'related' => 'Anomaly\ProductsModule\Category\CategoryModel',
        ]
    ],
];
