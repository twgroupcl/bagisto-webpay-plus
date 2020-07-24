<?php

return [
    [
        'key'  => 'sales',
        'name' => 'admin::app.admin.system.sales',
        'sort' => 1
    ], [
        'key'  => 'sales.paymentmethods',
        'name' => 'admin::app.admin.system.payment-methods',
        'sort' => 2,
    ], [
        'key'    => 'sales.paymentmethods.webpay_plus',
        'name'   => 'WebPay Plus',
        'sort'   => 1,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'type' => 'textarea',
                'channel_based' => false,
                'locale_based' => true,
            ],[
                'name' => 'commerce_code',
                'title' => 'Código comercio',
                'type' => 'text',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'active',
                'title' => 'Activo',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name' => 'production',
                'title' => 'Modo Producción',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name' => 'production_certificate',
                'title' => 'Certificado WebPayPlus',
                'type' => 'file',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name' => 'sort',
                'title' => 'admin::app.admin.system.sort_order',
                'type' => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1
                    ], [
                        'title' => '2',
                        'value' => 2
                    ], [
                        'title' => '3',
                        'value' => 3
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ]
                ],
            ]
        ],
    ],
    [
        'key'    => 'sales.paymentmethods.webpay_plus_mall',
        'name'   => 'WebPay Plus Mall',
        'sort'   => 1,
        'fields' => [
            [
                'name' => 'title',
                'title' => 'admin::app.admin.system.title',
                'type' => 'text',
                'validation' => 'required',
                'channel_based' => false,
                'locale_based'  => true,
            ], [
                'name' => 'description',
                'title' => 'admin::app.admin.system.description',
                'type' => 'textarea',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'active',
                'title' => 'Activo',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ],[
                'name' => 'commerce_code',
                'title' => 'Código comercio',
                'type' => 'text',
                'channel_based' => false,
                'locale_based' => true,
            ], [
                'name' => 'production',
                'title' => 'Modo Producción',
                'type' => 'boolean',
                'validation' => 'required',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name' => 'production_certificate',
                'title' => 'Certificado WebPayPlus Mall',
                'type' => 'file',
                'channel_based' => true,
                'locale_based'  => true,
            ],[
                'name' => 'production_public_certificate',
                'title' => 'Certificado Público WebPayPlus Mall',
                'type' => 'file',
                'channel_based' => true,
                'locale_based'  => true,
            ], [
                'name' => 'sort',
                'title' => 'admin::app.admin.system.sort_order',
                'type' => 'select',
                'options' => [
                    [
                        'title' => '1',
                        'value' => 1
                    ], [
                        'title' => '2',
                        'value' => 2
                    ], [
                        'title' => '3',
                        'value' => 3
                    ], [
                        'title' => '4',
                        'value' => 4,
                    ]
                ],
            ]
        ],
    ],
];
