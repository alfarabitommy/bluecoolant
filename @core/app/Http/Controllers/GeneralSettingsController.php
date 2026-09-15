<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeneralSettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function payment_settings()
    {
        return view('backend.general-settings.payment-gateway');
    }

    public function update_payment_settings(Request $request)
    {

        $this->validate($request, [
            'paypal_preview_logo'=> 'nullable|string|max:191',
            'paypal_mode'=> 'nullable|string|max:191',
            'paypal_sandbox_client_id'=> 'nullable|string|max:191',
            'paypal_sandbox_client_secret'=> 'nullable|string|max:191',
            'paypal_sandbox_app_id'=> 'nullable|string|max:191',
            'paypal_live_app_id'=> 'nullable|string|max:191',
            'paypal_payment_action'=> 'nullable|string|max:191',
            'paypal_currency'=> 'nullable|string|max:191',
            'paypal_notify_url'=> 'nullable|string|max:191',
            'paypal_locale'=> 'nullable|string|max:191',
            'paypal_validate_ssl'=> 'nullable|string|max:191',
            'paypal_live_client_id'=> 'nullable|string|max:191',
            'paypal_live_client_secret'=> 'nullable|string|max:191',

            'razorpay_preview_logo' => 'nullable|string|max:191',
            'stripe_preview_logo' => 'nullable|string|max:191',
            'paypal_gateway' => 'nullable|string|max:191',
            'paytm_gateway' => 'nullable|string|max:191',
            'paytm_preview_logo' => 'nullable|string|max:191',
            'paytm_merchant_key' => 'nullable|string|max:191',
            'paytm_merchant_mid' => 'nullable|string|max:191',
            'paytm_merchant_website' => 'nullable|string|max:191',
            'site_global_currency' => 'nullable|string|max:191',
            'site_manual_payment_name' => 'nullable|string|max:191',
            'manual_payment_preview_logo' => 'nullable|string|max:191',
            'site_manual_payment_description' => 'nullable|string|max:191',
            'razorpay_key' => 'nullable|string|max:191',
            'razorpay_secret' => 'nullable|string|max:191',
            'stripe_publishable_key' => 'nullable|string|max:191',
            'stripe_secret_key' => 'nullable|string|max:191',
            'site_global_payment_gateway' => 'nullable|string|max:191',
            'paystack_merchant_email' => 'nullable|string|max:191',
            'paystack_preview_logo' => 'nullable|string|max:191',
            'paystack_public_key' => 'nullable|string|max:191',
            'paystack_secret_key' => 'nullable|string|max:191',
            'cash_on_delivery_gateway' => 'nullable|string|max:191',
            'cash_on_delivery_preview_logo' => 'nullable|string|max:191',
            'mollie_preview_logo' => 'nullable|string|max:191',
            'mollie_public_key' => 'nullable|string|max:191',
            'marcado_pagp_client_id' => 'nullable|string|max:191',
            'marcado_pago_client_secret' => 'nullable|string|max:191',
            'marcado_pago_test_mode' => 'nullable|string|max:191',
        ]);

        $global_currency = get_static_option('site_global_currency');

        $save_data = [
            'cash_on_delivery_preview_logo',
            'stripe_preview_logo',
            'paystack_preview_logo',
            'paystack_public_key',
            'paystack_secret_key',
            'paystack_merchant_email',
            'razorpay_preview_logo',
            'paytm_preview_logo',
            'paytm_merchant_key',
            'paytm_merchant_mid',
            'paytm_merchant_website',
            'site_global_currency',
            'manual_payment_preview_logo',
            'site_manual_payment_name',
            'site_manual_payment_description',
            'razorpay_api_key',
            'razorpay_api_secret',
            'stripe_public_key',
            'stripe_secret_key',
            'site_global_payment_gateway',
            'site_usd_to_ngn_exchange_rate',
            'site_euro_to_ngn_exchange_rate',
            'mollie_public_key',
            'mollie_preview_logo',
            'flutterwave_preview_logo',
            'flw_public_key',
            'flw_secret_key',
            'flw_secret_hash',
            'site_currency_symbol_position',
            'site_default_payment_gateway',

            'paypal_preview_logo',
            'paypal_mode',
            'paypal_sandbox_client_id',
            'paypal_sandbox_client_secret',
            'paypal_sandbox_app_id',
            'paypal_live_client_id',
            'paypal_live_client_secret',
            'paypal_live_app_id',
            'paypal_payment_action',
            'paypal_currency',
            'paypal_notify_url',
            'paypal_locale',
            'paypal_validate_ssl',

            'site_' . strtolower($global_currency) . '_to_idr_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_inr_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_ngn_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_zar_exchange_rate',
            'site_' . strtolower($global_currency) . '_to_brl_exchange_rate',


            'midtrans_preview_logo',
            'midtrans_merchant_id',
            'midtrans_server_key',
            'midtrans_client_key',
            'midtrans_environment',

            'payfast_preview_logo',
            'payfast_merchant_id',
            'payfast_merchant_key',
            'payfast_passphrase',
            'payfast_merchant_env',
            'payfast_itn_url',

            'cashfree_preview_logo',
            'cashfree_test_mode',
            'cashfree_app_id',
            'cashfree_secret_key',

            'instamojo_preview_logo',
            'instamojo_client_id',
            'instamojo_client_secret',
            'instamojo_username',
            'instamojo_password',
            'instamojo_test_mode',

            'marcadopago_preview_logo',
            'marcado_pago_client_id',
            'marcado_pago_client_secret',
            'marcado_pago_test_mode',



        ];
        foreach ($save_data as $item) {
            update_static_option($item, $request->$item);
        }

        update_static_option('manual_payment_gateway', $request->manual_payment_gateway);
        update_static_option('paypal_gateway', $request->paypal_gateway);
        update_static_option('paytm_test_mode', $request->paytm_test_mode);
        update_static_option('paypal_test_mode', $request->paypal_test_mode);
        update_static_option('paytm_gateway', $request->paytm_gateway);
        update_static_option('razorpay_gateway', $request->razorpay_gateway);
        update_static_option('stripe_gateway', $request->stripe_gateway);
        update_static_option('paystack_gateway', $request->paystack_gateway);
        update_static_option('mollie_gateway', $request->mollie_gateway);
        update_static_option('cash_on_delivery_gateway', $request->cash_on_delivery_gateway);
        update_static_option('flutterwave_gateway', $request->flutterwave_gateway);
        update_static_option('midtrans_gateway', $request->midtrans_gateway);
        update_static_option('midtrans_test_mode', $request->midtrans_test_mode);
        update_static_option('payfast_gateway', $request->payfast_gateway);
        update_static_option('cashfree_test_mode', $request->cashfree_test_mode);
        update_static_option('cashfree_gateway', $request->cashfree_gateway);
        update_static_option('instamojo_gateway', $request->instamojo_gateway);
        update_static_option('instamojo_test_mode', $request->instamojo_test_mode);
        update_static_option('marcadopago_gateway', $request->marcadopago_gateway);
        update_static_option('marcadopago_test_mode', $request->marcadopago_test_mode);



        //Paypal
        $env_val['SITE_GLOBAL_CURRENCY'] = $request->site_global_currency ;
        $env_val['PAYPAL_MODE'] =  !empty($request->paypal_mode) ? 'sandbox' : 'live';
        $env_val['PAYPAL_SANDBOX_CLIENT_ID'] = $request->paypal_sandbox_client_id ? : 'AUP7AuZMwJbkee-2OmsSZrU-ID1XUJYE-YB-2JOrxeKV-q9ZJZYmsr-UoKuJn4kwyCv5ak26lrZyb-gb';
        $env_val['PAYPAL_SANDBOX_CLIENT_SECRET'] = $request->paypal_sandbox_client_secret ? : 'EEIxCuVnbgING9EyzcF2q-gpacLneVbngQtJ1mbx-42Lbq-6Uf6PEjgzF7HEayNsI4IFmB9_CZkECc3y';
        $env_val['PAYPAL_SANDBOX_APP_ID'] = $request->paypal_sandbox_app_id ? : '456345645645';
        $env_val['PAYPAL_LIVE_CLIENT_ID'] = $request->paypal_live_client_id ? : '';
        $env_val['PAYPAL_LIVE_CLIENT_SECRET'] = $request->paypal_live_client_secret ? : '';
        $env_val['PAYPAL_LIVE_APP_ID'] = $request->paypal_live_app_id ? : '';
        $env_val['PAYPAL_PAYMENT_ACTION'] = $request->paypal_payment_action ? : '';
        $env_val['PAYPAL_CURRENCY'] = $request->paypal_currency ? : 'USD';
        $env_val['PAYPAL_NOTIFY_URL'] = $request->paypal_notify_url ? : 'http://gateway.test/paypal/ipn';
        $env_val['PAYPAL_LOCALE'] = $request->paypal_locale ? : 'en_GB';
        $env_val['PAYPAL_VALIDATE_SSL'] = $request->paypal_validate_ssl ? : 'false';

        $env_val['PAYSTACK_PUBLIC_KEY'] = $request->paystack_public_key ?: 'pk_test_081a8fcd9423dede2de7b4c3143375b5e5415290';
        $env_val['PAYSTACK_SECRET_KEY'] = $request->paystack_secret_key ?: 'sk_test_c874d38f8d08760efc517fc83d8cd574b906374f';
        $env_val['MERCHANT_EMAIL'] = $request->paystack_merchant_email ?: 'example@gmail.com';
        $env_val['MOLLIE_KEY'] = $request->mollie_public_key ?: 'test_SMWtwR6W48QN2UwFQBUqRDKWhaQEvw';

        $env_val['FLW_PUBLIC_KEY'] = $request->flw_public_key ?: 'FLWPUBK_TEST-86cce2ec43c63e09a517290a8347fcab-X';
        $env_val['FLW_SECRET_KEY'] = $request->flw_secret_key ?: 'FLWSECK_TEST-d37a42d8917db84f1b2f47c125252d0a-X';
        $env_val['FLW_SECRET_HASH'] = $request->flw_secret_hash ?: 'oxo';

        $env_val['RAZORPAY_API_KEY'] = $request->razorpay_api_key ? : 'rzp_test_SXk7LZqsBPpAkj';
        $env_val['RAZORPAY_API_SECRET'] = $request->razorpay_api_secret ? : 'Nenvq0aYArtYBDOGgmMH7JNv';

        $env_val['STRIPE_PUBLIC_KEY'] = $request->stripe_public_key ? : 'pk_test_51GwS1SEmGOuJLTMsIeYKFtfAT3o3Fc6IOC7wyFmmxA2FIFQ3ZigJ2z1s4ZOweKQKlhaQr1blTH9y6HR2PMjtq1Rx00vqE8LO0x';
        $env_val['STRIPE_SECRET_KEY'] = $request->stripe_secret_key ? : 'sk_test_51GwS1SEmGOuJLTMs2vhSliTwAGkOt4fKJMBrxzTXeCJoLrRu8HFf4I0C5QuyE3l3bQHBJm3c0qFmeVjd0V9nFb6Z00VrWDJ9Uw';

        $env_val['PAYTM_MERCHANT_ID'] = $request->paytm_merchant_mid ?: 'Digita57697814558795';
        $env_val['PAYTM_MERCHANT_KEY'] = '"' . $request->paytm_merchant_key . '"' ?: 'dv0XtmsPYpewNag&';
        $env_val['PAYTM_MERCHANT_WEBSITE'] = '"' . $request->paytm_merchant_website . '"' ?: 'WEBSTAGING';
        $env_val['PAYTM_CHANNEL'] = '"' . $request->paytm_channel . '"' ?: 'WEB';
        $env_val['PAYTM_INDUSTRY_TYPE'] = '"' . $request->paytm_industry_type . '"' ? : 'Retail';

        $global_currency = get_static_option('site_global_currency');
        $currency_filed_name = 'site_' . strtolower($global_currency) . '_to_usd_exchange_rate';
        update_static_option('site_' . strtolower($global_currency) . '_to_usd_exchange_rate', $request->$currency_filed_name);

        $idr_currency_filed_name = 'site_' . strtolower($global_currency) . '_to_idr_exchange_rate';
        $inr_currency_filed_name = 'site_' . strtolower($global_currency) . '_to_inr_exchange_rate';
        $ngn_currency_filed_name = 'site_' . strtolower($global_currency) . '_to_ngn_exchange_rate';
        $zar_currency_filed_name = 'site_' . strtolower($global_currency) . '_to_zar_exchange_rate';
        $brl_currency_filed_name = 'site_' . strtolower($global_currency) . '_to_brl_exchange_rate';

        $env_val['IDR_EXCHANGE_RATE'] = $request->$idr_currency_filed_name ? $request->$idr_currency_filed_name : '14365.30';
        $env_val['INR_EXCHANGE_RATE'] = $request->$inr_currency_filed_name ? $request->$inr_currency_filed_name : '74.85';
        $env_val['NGN_EXCHANGE_RATE'] = $request->$ngn_currency_filed_name ? $request->$ngn_currency_filed_name : '409.91';
        $env_val['ZAR_EXCHANGE_RATE'] = $request->$zar_currency_filed_name ? $request->$zar_currency_filed_name : '15.86';
        $env_val['BRL_EXCHANGE_RATE'] = $request->$brl_currency_filed_name ? $request->$brl_currency_filed_name : '5.70';

        $env_val['MIDTRANS_MERCHANT_ID'] = $request->midtrans_merchant_id ? : 'G770543580';
        $env_val['MIDTRANS_SERVER_KEY'] =  $request->midtrans_server_key ? : 'SB-Mid-server-9z5jztsHyYxEdSs7DgkNg2on';
        $env_val['MIDTRANS_CLIENT_KEY'] =  $request->midtrans_client_key ? : 'SB-Mid-client-iDuy-jKdZHkLjL_I';

        $env_val['PF_MERCHANT_ID'] = $request->payfast_merchant_id ? : '10024000';
        $env_val['PF_MERCHANT_KEY'] =  $request->payfast_merchant_key ? : '77jcu5v4ufdod';
        $env_val['PAYFAST_PASSPHRASE'] =  $request->payfast_passphrase ? : 'testpayfastsohan';
        $env_val['PF_ITN_URL'] = $request->payfast_itn_url  ? : 'https://fundorex.test/donation-payfast';

        $env_val['CASHFREE_TEST_MODE'] = $request->cashfree_test_mode ? : 'true';
        $env_val['CASHFREE_APP_ID'] =  $request->cashfree_app_id ? : '94527832f47d6e74fa6ca5e3c72549';
        $env_val['CASHFREE_SECRET_KEY'] =  $request->cashfree_secret_key ? : 'ec6a3222018c676e95436b2e26e89c1ec6be2830';

        $env_val['INSTAMOJO_CLIENT_ID'] = $request->instamojo_client_id ? : 'test_nhpJ3RvWObd3uryoIYF0gjKby5NB5xu6S9Z';
        $env_val['INSTAMOJO_CLIENT_SECRET'] =  $request->instamojo_client_secret ? : 'test_iZusG4P35maQVPTfqutbCc6UEbba3iesbCbrYM7zOtDaJUdbPz76QOnBcDgblC53YBEgsymqn2sx3NVEPbl3b5coA3uLqV1ikxKquOeXSWr8Ruy7eaKUMX1yBbm';
        $env_val['INSTAMOJO_USERNAME'] =  $request->instamojo_username ? : '';
        $env_val['INSTAMOJO_PASSWORD'] =  $request->instamojo_password ? : '';

        $env_val['MERCADO_PAGO_CLIENT_ID'] = $request->marcado_pago_client_id ? : 'TEST-0a3cc78a-57bf-4556-9dbe-2afa06347769';
        $env_val['MERCADO_PAGO_CLIENT_SECRET'] = $request->marcado_pago_client_secret ? : 'TEST-4644184554273630-070813-7d817e2ca1576e75884001d0755f8a7a-786499991';


        setEnvValue($env_val);

        return redirect()->back()->with([
            'msg' => __('Payment Settings Updated..'),
            'type' => 'success'
        ]);
    }


    public function typography_settings()
    {
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        return view('backend.general-settings.typograhpy')->with(['google_fonts' => json_decode($all_google_fonts)]);
    }

    public function get_single_font_variant(Request $request)
    {
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        $decoded_fonts = json_decode($all_google_fonts, true);
        return response()->json($decoded_fonts[$request->font_family]);
    }

    public function update_typography_settings(Request $request)
    {
        $this->validate($request, [
            'body_font_family' => 'required|string|max:191',
            'body_font_variant' => 'required',
            'heading_font' => 'nullable|string',
            'heading_font_family' => 'nullable|string|max:191',
            'heading_font_variant' => 'nullable',
        ]);

        $save_data = [
            'body_font_family',
            'heading_font_family',
        ];
        foreach ($save_data as $item) {
            update_static_option($item, $request->$item);
        }
        $body_font_variant = !empty($request->body_font_variant) ?  $request->body_font_variant: ['regular'];
        $heading_font_variant = !empty($request->heading_font_variant) ?  $request->heading_font_variant: ['regular'];

        update_static_option('heading_font', $request->heading_font);
        update_static_option('body_font_variant', serialize($body_font_variant));
        update_static_option('heading_font_variant', serialize($heading_font_variant));

        return redirect()->back()->with(['msg' => __('Typography Settings Updated..'), 'type' => 'success']);
    }


    public function license_settings()
    {
        return view('backend.general-settings.license-settings');
    }

    public function update_license_settings(Request $request)
    {
        $this->validate($request, [
            'item_purchase_key' => 'required|string|max:191'
        ]);
        $response = Http::post('https://xgenious.com/api/v2/license/new', [
            'purchase_code' => $request->item_purchase_key,
            'site_url' => url('/'),
            'item_unique_key' => 'OCDic7XaYsv55kMq1ZKFHnkBWyavBson',
        ]);
        $result = $response->json();

        update_static_option('item_purchase_key', $request->item_purchase_key);
        update_static_option('item_license_status', $result['license_status']);
        update_static_option('item_license_msg', $result['msg']);

        $type = 'verified' == $result['license_status'] ? 'success' : 'danger';
        setcookie("site_license_check", "", time() - 3600,'/');
        $license_info = [
            "item_license_status" => $result['license_status'],
            "last_check" => time(),
            "purchase_code" => get_static_option('item_purchase_key'),
            "xgenious_app_key" => env('XGENIOUS_API_KEY'),
            "author" => env('XGENIOUS_API_AUTHOR'),
            "message" => $result['msg']
        ];

        @file_put_contents('@core/license.json', json_encode($license_info));

        return redirect()->back()->with(['msg' => $result['msg'], 'type' => $type]);
    }

}

