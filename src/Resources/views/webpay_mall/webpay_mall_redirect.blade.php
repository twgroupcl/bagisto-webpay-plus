@php
$configuration = new Transbank\Webpay\Configuration();

$webPayPlus = app('Twgroup\WebPay\Payment\WebPayPlusMall');

$onProduction = (bool) $webPayPlus->getConfigData('production');

if (!$onProduction) {
    $configuration = $configuration->forTestingWebpayPlusMall();
} else {
    $configuration->setEnvironment('PRODUCCION');

    $configuration->setCommerceCode($webPayPlus->getConfigData('commerce_code'));

    //dd($webPayPlus->getConfigData('production'));

    $certificate = $webPayPlus->getConfigData('production_certificate');
    $publicCertificate = $webPayPlus->getConfigData('production_public_certificate');

    $certificateContent = file_get_contents(storage_path().'/app/public/'.$certificate);
    $publicCertificateContent = file_get_contents(storage_path().'/app/public/'.$publicCertificate);

    $configuration->setPublicCert($publicCertificateContent);
    $configuration->setPrivateKey($certificateContent);
}


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

$itemsCart = $cart->items;

$deliveryAmounts = collect();
foreach ($itemsCart as $item) {
    $chilexpressCalculation = App\ChilexpressPaymentCalculation::where('cart_item_id', $item->id)->get();

    $deliveryAmounts->push([
        'amount' => $chilexpressCalculation->sum('amount'),
        'seller' => $chilexpressCalculation->count() > 0 ? $chilexpressCalculation->first()->marketplace_seller_id : null,
    ]);
}

$transactions = [];

$store = [
    
];

foreach (range(1,1000) as $i) {
    $store[$i] = '597035635572';
}

foreach ($items as $item) {
    $totalAmount = $deliveryAmounts->where('seller', $item['seller_id'])->sum('amount');

    $transactions[] = [
        'storeCode' => $store[$item['seller_id']],
        'amount' => $item->item->total + $totalAmount,
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

session('order', $order);

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