@php
$webPayPlus = app('Twgroup\WebPay\Payment\WebPayPlus');
$webPayPlusRepository = app('Twgroup\WebPay\Repositories\WebPayPlusOrderRepository');
$orderRepository = app('Webkul\Sales\Repositories\OrderRepository');

$order = $orderRepository->create(Cart::prepareDataForOrder());

$bag = Freshwork\Transbank\CertificationBagFactory::integrationWebpayNormal();  
  
$plus = Freshwork\Transbank\TransbankServiceFactory::normal($bag);  

$cart = $webPayPlus->getCart();

$plus->addTransactionDetail($cart['grand_total'], $order->id);

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