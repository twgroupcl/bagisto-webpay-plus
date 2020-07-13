<?php

namespace Twgroup\WebPay\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Twgroup\WebPay\Models\WebPayPlusOrder::class,
        \Twgroup\WebPay\Models\WebPayPlusMallOrder::class,
    ];
}
