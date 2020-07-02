<?php

namespace Twgroup\WebPay\Http\Controllers;

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\RedirectorHelper;
use Freshwork\Transbank\TransbankServiceFactory;
use Illuminate\Http\Request;
use Twgroup\WebPay\Repositories\WebPayPlusOrderRepository;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;

class BagistoWebPayController extends Controller
{
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository, WebPayPlusOrderRepository $webpayPlusRepository)
    {
        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;
        $this->webpayPlusRepository = $webpayPlusRepository;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Redirects to the paypal.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        return view('webpay::webpay.webpay_plus_redirect');
    }

    /**
     * Cancel payment from paypal.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', 'El pago vía WebPay ha sido cancelado.');

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        session()->flash('success', 'Tu pago vía WebPay se ha procesado correctamente.');

        return redirect()->route('shop.checkout.success');
    }

    /**
     * WebPay Ipn listener
     *
     * @return \Illuminate\Http\Response
     */
    public function ipn()
    {
        $bag = CertificationBagFactory::integrationWebpayNormal();
  
        $plus = TransbankServiceFactory::normal($bag);

        $response = $plus->getTransactionResult();

        if ($response->detailOutput->responseCode == 0) {
            $plus->acknowledgeTransaction();

            Cart::deActivateCart();

            // Update order
            $this->orderRepository->findOneWhere(['id' => $response->buyOrder])->update([
                'status' => 'completed',
            ]);

            $this->webpayPlusRepository->findOneWhere(['order_id' => $response->buyOrder])->update([
                'status' => 'completed',
            ]);
        }

        return RedirectorHelper::redirectBackNormal($response->urlRedirection);
    }
}
