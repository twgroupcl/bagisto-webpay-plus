@php
$configuration = new Transbank\Webpay\Configuration();

$configuration = $configuration->forTestingWebpayPlusMall();

$webPayPlus = app('Twgroup\WebPay\Payment\WebPayPlusMall');
$webPayPlusRepository = app('Twgroup\WebPay\Repositories\WebPayPlusMallOrderRepository');
$orderRepository = app('Webkul\Sales\Repositories\OrderRepository');
$mkOrderRepository = app('Webkul\Marketplace\Repositories\OrderRepository');

$transaction = (new Transbank\Webpay\Webpay($configuration))->getMallNormalTransaction();

$order = $orderRepository->create(Cart::prepareDataForOrder());

$marketplaceOrders = $mkOrderRepository->findWhere(['order_id' => $order->id]);

$items = collect();

foreach ($marketplaceOrders as $mkOrder) {
    foreach ($mkOrder->items as $item) {
        $item['seller_id'] = $mkOrder->marketplace_seller_id;
        $items->push($item);
    }
}

$cart = $webPayPlus->getCart();

$transactions = [];

$store = [
    '1' => '597044444402',
    '2' => '597044444403',
];

foreach ($items as $item) {
    $transactions[] = [
        'storeCode' => $store[$item['seller_id']],
        'amount' => $item->item->total,
        'buyOrder' => $item->marketplace_order_id,
    ];
}

$response = $transaction->initTransaction($order->id, strval(rand(100000, 999999999)), route('webpay_plus_mall.ipn'), route('webpay_plus_mall.success'), $transactions);

$webPayPlusRepository->create([
	'total_amount' => $cart['grand_total'],
	'transaction_detail' => json_encode($response),
	'status' => 'pending',
	'order_id' => $order->id,
]);

session()->flash('order', $order);

@endphp


<body data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    Se te redireccionará a WebPay en unos segundos...
    

    <form action="{{ $response->url }}" id="webpay_plus_post" method="POST">
        <input value="Haz click aquí si no has sido redireccionado..." type="submit">

        <input type="hidden" name="TBK_TOKEN" value="{{ $response->token }}">
    </form>

    <script type="text/javascript">
        document.getElementById("webpay_plus_post").submit();
    </script>
</body>