<?php

namespace Twgroup\WebPay\Payment;

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\TransbankServiceFactory;
use Illuminate\Support\Facades\Config;
use Webkul\Payment\Payment\Payment;

/**
 * WebPay payment method class
 *
 * @author   Guillermo Lobos <guillermo.lobos@twgroup.cl>
 * @copyright 2020
 */
class WebPayPlus extends Payment
{
    /**
     * Payment method code
     *
     * @var string
     */
    protected $code  = 'webpay_plus';


    public function getRedirectUrl()
    {
        return route('webpay_plus.redirect');
    }
}
