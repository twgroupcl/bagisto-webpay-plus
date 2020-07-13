<?php

return [
     'webpay_plus' => [
        'code' => 'webpay_plus',
        'title' => 'WebPay Plus',
        'description' => 'WebPay Plus',
        'class' => 'Twgroup\WebPay\Payment\WebPayPlus',
        'sandbox' => true,
        'active' => true,
        'sort' => 4,
    ],

    'webpay_plus_mall' => [
        'code' => 'webpay_plus_mall',
        'title' => 'WebPay Plus Mall',
        'description' => 'WebPay Plus Mall',
        'class' => 'Twgroup\WebPay\Payment\WebPayPlusMall',
        'sandbox' => true,
        'active' => true,
        'sort' => 4,
    ],
 ];
