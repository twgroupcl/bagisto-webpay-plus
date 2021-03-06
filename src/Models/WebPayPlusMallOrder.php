<?php

namespace Twgroup\WebPay\Models;

use Illuminate\Database\Eloquent\Model;
use Twgroup\WebPay\Contracts\WebPayPlusMallOrder as WebPayPlusMallOrderContract;
use Webkul\Sales\Models\Order as Order;

class WebPayPlusMallOrder extends Model implements WebPayPlusMallOrderContract
{
    protected $table = 'webpay_plus_mall_orders';

    protected $fillable = [
        'total_amount', 'transaction_detail', 'status',
        'order_id', 'created_at', 'updated_at',
    ];

    protected $statusLabel = [
        'pending' => 'Pendiente',
        'processing' => 'Pendiente',
        'completed' => 'Completo',
        'canceled' => 'Cancelado',
        'refunded' => 'Devuelto'
    ];

    public function getStatusLabelAttribute()
    {
        return $this->statusLabel[$this->status];
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
