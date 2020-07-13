<?php

namespace Twgroup\WebPay\Payment;

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Illuminate\Support\Facades\Config;
use Webkul\Payment\Payment\Payment;

/**
 * WebPayPlusMall payment method class
 *
 * @author   Guillermo Lobos <guillermo.lobos@twgroup.cl>
 * @copyright 2020
 */
class WebPayPlusMall extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'webpay_plus_mall';


    public function getRedirectUrl()
    {
        return route('webpay_plus_mall.redirect');
    }
}
