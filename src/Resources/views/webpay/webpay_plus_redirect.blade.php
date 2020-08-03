@php
$configuration = new Transbank\Webpay\Configuration();

$webPayPlus = app('Twgroup\WebPay\Payment\WebPayPlus');

$webPayPlusRepository = app('Twgroup\WebPay\Repositories\WebPayPlusOrderRepository');

$onProduction = (bool) $webPayPlus->getConfigData('production');

if (!$onProduction) {
    $bag = Freshwork\Transbank\CertificationBagFactory::integrationWebpayNormal();  
  
    $plus = Freshwork\Transbank\TransbankServiceFactory::normal($bag);  
} else {
    $certificate = $webPayPlus->getConfigData('production_certificate');
    $publicCertificate = $webPayPlus->getConfigData('production_public_certificate');

    $certificateContent = file_get_contents(storage_path().'/app/public/'.$certificate);
    $publicCertificateContent = file_get_contents(storage_path().'/app/public/'.$publicCertificate);

    $bag = Freshwork\Transbank\CertificationBagFactory::production($certificateContent, $publicCertificateContent);

    $plus = Freshwork\Transbank\TransbankServiceFactory::normal($bag);  
}

$orderRepository = app('Webkul\Sales\Repositories\OrderRepository');

$order = $orderRepository->create(Cart::prepareDataForOrder());

$cart = $webPayPlus->getCart();

$plus->addTransactionDetail($cart['grand_total'], $order->id);

$cart = $webPayPlus->getCart();

$response = $plus->initTransaction(route('webpay_plus.ipn'), route('webpay_plus.success'));  

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