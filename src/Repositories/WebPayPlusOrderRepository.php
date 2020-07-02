<?php

namespace Twgroup\WebPay\Repositories;

use Webkul\Core\Eloquent\Repository;

class WebPayPlusOrderRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Twgroup\WebPay\Contracts\WebPayPlusOrder';
    }
}
