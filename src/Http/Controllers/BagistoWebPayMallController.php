<?php

namespace Twgroup\WebPay\Http\Controllers;

use Freshwork\Transbank\CertificationBagFactory;
use Freshwork\Transbank\RedirectorHelper;
use Freshwork\Transbank\TransbankServiceFactory;
use Illuminate\Http\Request;
use Transbank\Webpay\Configuration;
use Transbank\Webpay\Webpay;
use Twgroup\WebPay\Repositories\WebPayPlusMallOrderRepository;
use Twgroup\WebPay\Repositories\WebPayPlusOrderRepository;
use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Marketplace\Repositories\OrderRepository as MkOrderRepository;

class BagistoWebPayMallController extends Controller
{
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var \Webkul\Sales\Repositories\OrderRepository
     */
    protected $orderRepository;
    protected $mkOrderRepository;

    public function __construct(OrderRepository $orderRepository, WebPayPlusMallOrderRepository $webpayPlusRepository, MkOrderRepository $mkOrderRepository)
    {
        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;
        $this->webpayPlusRepository = $webpayPlusRepository;
        $this->mkOrderRepository = $mkOrderRepository;
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
        return view('webpay::webpay_mall.webpay_mall_redirect');
    }

    /**
     * Cancel payment from paypal.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        session()->flash('error', 'El pago vía WebPayMall ha sido cancelado.');

        return redirect()->route('shop.checkout.cart.index');
    }

    /**
     * Success payment
     *
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        session()->flash('success', 'Tu pago vía WebPayMall se ha procesado correctamente.');

        return redirect()->route('shop.checkout.success');
    }

    /**
     * WebPay Ipn listener
     *
     * @return \Illuminate\Http\Response
     */
    public function ipn()
    {
        $configuration = new Configuration();

        $configuration = $configuration->forTestingWebpayPlusMall();

        $transaction = (new Webpay($configuration))->getMallNormalTransaction();

        $response = $transaction->getTransactionResult(request()->input('token_ws'));

        foreach ($response->detailOutput as $output) {
            if ($output->responseCode == 0) {
                Cart::deActivateCart();

                $this->mkOrderRepository->findOneWhere(['id' => $output->buyOrder])->update([
                    'status' => 'completed',
                ]);

                $this->webpayPlusRepository->findOneWhere(['order_id' => $response->buyOrder])->update([
                    'status' => 'completed',
                ]);
            }
        }

        return RedirectorHelper::redirectBackNormal($response->urlRedirection);
    }
}
