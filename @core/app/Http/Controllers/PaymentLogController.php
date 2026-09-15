<?php

namespace App\Http\Controllers;
use App\Mail\PlaceOrder;
use App\Order;
use App\PaymentLogs;
use App\PricePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Xgenious\Paymentgateway\Facades\XgPaymentGateway;

class PaymentLogController extends Controller
{
    const SUCCESS_ROUTE = 'frontend.order.payment.success';
    const CANCEL_ROUTE = 'frontend.order.payment.cancel';

    public function order_payment_form(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'order_id' => 'required|string',
            'payment_gateway' => 'required|string',
        ]);

        $order_details = Order::find($request->order_id);
        $payment_log_id = PaymentLogs::create([
            'email' => $request->email,
            'name' => $request->name,
            'package_name' => $order_details->package_name,
            'package_price' => $order_details->package_price,
            'package_gateway' => $request->payment_gateway,
            'order_id' => $request->order_id,
            'status' => 'pending',
            'track' => Str::random(10) . Str::random(10),
        ])->id;
        $payment_details = PaymentLogs::find($payment_log_id);

        if ($request->payment_gateway === 'paypal') {
            $redirect_url = XgPaymentGateway::paypal()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id, route('frontend.paypal.ipn'))
            );
            session()->put('order_id',$request->order_id);
            return redirect()->away($redirect_url);

        } elseif ($request->payment_gateway === 'paytm') {

            $redirect_url = XgPaymentGateway::paytm()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.paytm.ipn'))
            );

            return $redirect_url;

        } elseif ($request->payment_gateway === 'mollie') {

            $redirect_url = XgPaymentGateway::mollie()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.mollie.ipn'))
            );
            return $redirect_url;

        } elseif ($request->payment_gateway === 'stripe') {

            $redirect_url = XgPaymentGateway::stripe()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.stripe.ipn'))
            );
            return $redirect_url;

        } elseif ($request->payment_gateway === 'razorpay') {

            $redirect_url = XgPaymentGateway::razorpay()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.razorpay.ipn'))
            );
            return $redirect_url;

        } elseif ($request->payment_gateway === 'flutterwave') {

            $redirect_url = XgPaymentGateway::flutterwave()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.flutterwave.ipn'))
            );
            return $redirect_url;

        } elseif ($request->payment_gateway == 'paystack') {

            $redirect_url = XgPaymentGateway::paystack()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request,$payment_details->order_id, route('frontend.paystack.ipn'))
            );
            return $redirect_url;


        } elseif ($request->payment_gateway === 'payfast') {

            $redirect_url = XgPaymentGateway::payfast()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id ,route('frontend.payfast.ipn'))
            );
            session()->put('order_id',$request->order_id);
            return $redirect_url;


        } elseif ($request->payment_gateway === 'midtrans') {

            $redirect_url = XgPaymentGateway::midtrans()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id,route('frontend.midtrans.ipn'))
            );
            return $redirect_url;
        }

        elseif ($request->payment_gateway === 'cashfree') {

            $redirect_url = XgPaymentGateway::cashfree()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id, route('frontend.cashfree.ipn'))
            );
            return $redirect_url;
        }

        elseif ($request->payment_gateway === 'instamojo') {

            $redirect_url = XgPaymentGateway::instamojo()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id, route('frontend.instamojo.ipn'))
            );
            return $redirect_url;
        }

        elseif ($request->payment_gateway === 'marcadopago') {

            $redirect_url = XgPaymentGateway::marcadopago()->charge_customer(
                $this->common_charge_customer_data($payment_details,$request, $payment_details->order_id, route('frontend.marcadopago.ipn'))
            );
            return $redirect_url;
        }

         elseif ($request->payment_gateway == 'manual_payment') {
            $order = Order::where('id', $request->order_id)->first();
            $order->status = 'pending';
            $order->save();
            PaymentLogs::where('order_id', $request->order_id)->update(['transaction_id' => $request->transaction_id]);
            return redirect()->route('frontend.order.payment.success', $request->order_id);
        }

        return redirect()->route('homepage');
    }


    public function paypal_ipn()
    {
        $payment_data = XgPaymentGateway::paypal()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    public function paytm_ipn()
    {
        $payment_data = XgPaymentGateway::paytm()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function flutterwave_ipn(Request $request)
    {
        $payment_data = XgPaymentGateway::flutterwave()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    public function stripe_ipn(Request $request)
    {
        $payment_data = XgPaymentGateway::stripe()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    public function razorpay_ipn(Request $request)
    {
        $payment_data = XgPaymentGateway::razorpay()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    public function payfast_ipn()
    {
        $payment_data = XgPaymentGateway::payfast()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function mollie_ipn()
    {
        $payment_data = XgPaymentGateway::mollie()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function midtrans_ipn()
    {
        $payment_data = XgPaymentGateway::midtrans()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function cashfree_ipn()
    {
        $payment_data = XgPaymentGateway::cashfree()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function instamojo_ipn()
    {
        $payment_data = XgPaymentGateway::instamojo()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }

    public function marcadopago_ipn()
    {
        $payment_data = XgPaymentGateway::marcadopago()->ipn_response();
        return $this->common_ipn_data($payment_data);
    }


    private function common_charge_customer_data($payment_details,$request,$order_id, $ipn_route)
    {
        $data = [
            'amount' => $payment_details->package_price,
            'title' =>'Payment For Package Order Id: #'.$request->order_id,
            'description' => 'Payment For Package Order Id: #' . $request->order_id . ' Package Name: ' . $payment_details->package_name . ' Payer Name: ' . $request->name . ' Payer Email:' . $request->email,
            'order_id' => $order_id,
            'track' => $payment_details->track,
            'cancel_url' => route('frontend.order.payment.cancel',$payment_details->id),
            'success_url' => route('frontend.order.payment.success', $payment_details->id),
            'email' => $payment_details->email, // user email
            'name' => $payment_details->name, // user name
            'payment_type' => 'order', // which kind of payment your are receiving
            'ipn_url' => $ipn_route
        ];
        return $data;
    }

    private function common_ipn_data($payment_data)
    {
        if (isset($payment_data['status']) && $payment_data['status'] === 'complete'){
            $this->update_database($payment_data['order_id'], $payment_data['transaction_id']);
            $this->send_order_mail($payment_data['order_id']);
            $order_id = Str::random(6) . $payment_data['order_id']. Str::random(6);
            return redirect()->route(self::SUCCESS_ROUTE, $order_id);
        }
        return $this->cancel_page();
    }


    private function update_database($order_id, $transaction_id)
    {
        Order::where('id', $order_id)->update(['payment_status' => 'complete']);
        PaymentLogs::where('order_id', $order_id)->update([
            'transaction_id' => $transaction_id,
            'status' => 'complete',
        ]);

    }
    public function send_order_mail($order_id)
    {


        $order_details = Order::find($order_id);
        $package_details = PricePlan::where('id', $order_details->package_id)->first();
        $all_fields = unserialize($order_details->custom_fields,['class'=> false]);
        unset($all_fields['package']);

        $all_attachment = unserialize($order_details->attachment,['class'=> false]);
        $order_mail = get_static_option('order_page_form_mail') ? get_static_option('order_page_form_mail') : get_static_option('site_global_email');

        try {
            Mail::to($order_mail)->send(new PlaceOrder($all_fields, $all_attachment, $package_details));
        }catch(\Exception $e){
            return redirect()->back()->with(['msg'=> $e->getMessage(), 'type'=> 'error']);
        }
    }


    protected function cancel_page(){
        return redirect()->route('frontend.order.payment.cancel.static');
    }


}
