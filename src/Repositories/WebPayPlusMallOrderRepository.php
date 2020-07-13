<?php

namespace Twgroup\WebPay\Repositories;

use Webkul\Core\Eloquent\Repository;

class WebPayPlusMallOrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Twgroup\WebPay\Contracts\WebPayPlusMallOrder';
    }
}
