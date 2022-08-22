<?php

namespace App\Http\Controllers;


use Auth;
use Session;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PartialPaymentController;
use App\Http\Controllers\CustomerPackageController;

class ShurjoPayController extends Controller
{
    public function index(Request $request, $amount = null)
    {
         //dd(Session::get('payment_type'));
        if(Session::has('payment_type')){
            //Session::put('payment_amount', $pay_amount);
            //dd($request->session()->get('payment_type'));
            if(Session::get('payment_type') == 'cart_payment'){
                $order = Order::findOrFail($request->session()->get('order_id'));
                $post_data = array();
                $user = Auth::user();
                $post_data['amount'] = $order->grand_total; # You cant not pay less than 10
                $post_data['custom1'] = $request->session()->get('payment_type');
                $post_data['custom2'] = $request->session()->get('order_id');
                $post_data['custom3'] = $user->name;
                $post_data['custom4'] = $user->phone;
                $post_data['custom5'] = $request->session()->get('payment_type');
                $post_data['custom6'] = $request->session()->get('order_id');
            }
            elseif (Session::get('payment_type') == 'partial') {
                $post_data = array();
                $post_data['amount'] = $request->amount; # You cant not pay less than 10

                $user = Auth::user();

                $post_data['custom1'] = $request->session()->get('payment_type');
                $post_data['custom2'] = $request->session()->get('order_id');
                $post_data['custom3'] = $user->name;
                $post_data['custom4'] = $user->phone;
                $post_data['custom5'] = $request->session()->get('payment_type');
                $post_data['custom6'] = $request->session()->get('order_id');
            }
            elseif (Session::get('payment_type') == 'wallet_payment') {
                $post_data = array();
                $post_data['amount'] = $request->session()->get('payment_data')['amount']; # You cant not pay less than 10

                $user = Auth::user();
                $post_data['custom1'] = $request->session()->get('payment_type');
                $post_data['custom2'] = json_encode($request->session()->get('payment_data'));
                $post_data['custom3'] = $user->name;
                $post_data['custom4'] = $user->phone;
                $post_data['custom5'] = $request->session()->get('payment_type');
                $post_data['custom6'] = json_encode($request->session()->get('payment_data'));
            }
            elseif (Session::get('payment_type') == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
                $post_data = array();
                $post_data['amount'] = $customer_package->amount; # You cant not pay less than 10

                $user = Auth::user();
                $post_data['custom1'] = $request->session()->get('payment_type');
                $post_data['custom2'] = json_encode($request->session()->get('payment_data'));
                $post_data['custom3'] = $user->name;
                $post_data['custom4'] = $user->phone;
                $post_data['custom5'] = $request->session()->get('payment_type');
                $post_data['custom6'] = json_encode($request->session()->get('payment_data'));
            }
            elseif (Session::get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $post_data = array();
                $post_data['amount'] = $seller_package->amount; # You cant not pay less than 10

                $user = Auth::user();
                $post_data['custom1'] = $request->session()->get('payment_type');
                $post_data['custom2'] = json_encode($request->session()->get('payment_data'));
                $post_data['custom3'] = $user->name;
                $post_data['custom4'] = $user->phone;
                $post_data['custom5'] = $request->session()->get('payment_type');
                $post_data['custom6'] = json_encode($request->session()->get('payment_data'));
            }
        }

        $shurjopay = new ShurjoPay();

        $payment_options = $shurjopay->sendPayment($post_data, false);

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }



    }
   public function response(Request $request)
    {

        //$payment = json_encode($request->all());
        //$amount = $request->amount;

        $server_url = env('SHURJOPAY_SERVER_URL');
        $response_encrypted = $request->spdata;
        $response_decrypted = file_get_contents($server_url . "/merchant/decrypt.php?data=" . $response_encrypted);
        $data = simplexml_load_string($response_decrypted) or die("Error: Cannot create object");
        $tx_id = $data->txID;
        $bank_tx_id = $data->bankTxID;
        $amount = $data->txnAmount;
        $bank_status = $data->bankTxStatus;
        $sp_code = $data->spCode;
        $sp_code_des = $data->spCodeDes;
        $sp_payment_option = $data->paymentOption;
        $status = "";
        $payment = json_encode($request->all());
        //dd($sp_code);
        switch ($sp_code) {
            case '000':
                $res = array('status' => true, 'msg' => 'Action Successful');
                $status = "Success";
                break;

            default:
                $status = "Failed";
                $res = array('status' => false, 'msg' => 'Action Failed');
                break;

        }

        if(Session::get('payment_type') == 'cart_payment'){
            $request->session()->put('payment_type', 'cart_payment');
        }elseif (Session::get('payment_type') == 'partial') {
            $request->session()->put('payment_type', 'partial');
        }
          $ss = json_encode(trim($data->custom1));
          $pay = trim($ss, '"');
          //dd(json_encode(trim($data->custom2)));

        if($status == 'Success'){
            if($pay == 'cart_payment'){
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($data->custom2, $payment, $amount, 'ShurjoPay');
            }
            elseif ($pay == 'partial') {
                $partialController = new PartialPaymentController;
                return $partialController->partial_payment_done($data->custom2, $payment, $amount, 'ShurjoPay');
            }
            elseif ($pay == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done(json_decode($request->custom2), $payment);
            }
            elseif ($pay == 'customer_package_payment') {
                $customer_package_controller = new CustomerPackageController;
                return $customer_package_controller->purchase_payment_done(json_decode($request->custom2), $payment);
            }
            elseif ($pay == 'seller_package_payment') {
                $seller_package_controller = new SellerPackageController;
                return $seller_package_controller->purchase_payment_done(json_decode($request->custom2), $payment);
            }
        } else {
            return redirect()->to('dashboard');
        }

        $success_url = $request->get('success_url');

        if ($success_url) {
            header("location:" . $success_url . "?spdata={$response_encrypted}");
            die();
            //return redirect('" . $success_url . "?spdata={$response_encrypted}');
        }

    }
}
