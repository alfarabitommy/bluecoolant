<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Donation;
use App\DonationLogs;
use App\EventAttendance;
use App\Gig;
use App\GigMessage;
use App\Order;
use App\PaymentLogs;
use App\GigOrder;
use App\Mail\GigNewMessage;
use App\Mail\UserEmailVerify;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Mail\BasicMailTemplate;


class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function user_index(){
        $user_details = User::find(Auth::guard('web')->user()->id);
        $package_orders = Order::where('user_id',$user_details->id)->orderBy('id','DESC')->paginate(10);
        $total_orders = Order::where('user_id',$user_details->id)->count();

        return view('frontend.user.dashboard.user-home')->with(
            [
                'user_details' => $user_details,
                'package_orders' => $package_orders,
                'total_orders' => $total_orders,

            ]);
    }

        public function user_email_verify_index(){
            $user_details = Auth::guard('web')->user();
            if ($user_details->email_verified == 1){
                return redirect()->route('user.home');
            }
            if (empty($user_details->email_verify_token)){
                User::find($user_details->id)->update(['email_verify_token' => \Str::random(20)]);
                $user_details = User::find($user_details->id);
                Mail::to($user_details->email)->send(new UserEmailVerify($user_details));
            }
            return view('frontend.user.email-verify');
        }


    public function reset_user_email_verify_code(){
        $user_details = Auth::guard('web')->user();
        if ($user_details->email_verified == 1){
            return redirect()->route('user.home');
        }
        Mail::to($user_details->email)->send(new UserEmailVerify($user_details));

        return redirect()->route('user.email.verify')->with(['msg' => 'Resend Verify Email Success','type' => 'success']);
    }

    public function user_email_verify(Request $request){
        $this->validate($request,[
            'verification_code' => 'required'
        ]);
        $user_details = Auth::guard('web')->user();
        $user_info = User::where(['id' =>$user_details->id,'email_verify_token' => $request->verification_code])->first();
        if (empty($user_info)){
            return redirect()->back()->with(['msg' => 'your verification code is wrong, try again','type' => 'danger']);
        }
        $user_info->email_verified = 1;
        $user_info->save();
        return redirect()->route('user.home');
    }

    public function user_profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'nullable|string|max:191',
            'state' => 'nullable|string|max:191',
            'city' => 'nullable|string|max:191',
            'zipcode' => 'nullable|string|max:191',
            'country' => 'nullable|string|max:191',
            'address' => 'nullable|string',
        ]);
        User::find(Auth::guard('web')->user()->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $request->image,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
            'address' => $request->address,
            ]
        );

        return redirect()->back()->with(['msg' => 'Profile Update Success', 'type' => 'success']);
    }

    public function user_password_change(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail(Auth::guard('web')->user()->id);

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::guard('web')->logout();

            return redirect()->route('user.login')->with(['msg' => 'Password Changed Successfully', 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => 'Somethings Going Wrong! Please Try Again or Check Your Old Password', 'type' => 'danger']);
    }



        public function package_order_cancel(Request $request){
            $this->validate($request,[
                'order_id' => 'required'
            ]);
            $order_details = Order::where(['id' => $request->order_id,'user_id' => Auth::guard('web')->user()->id])->first();
            $payment_log = PaymentLogs::where('order_id',$request->order_id)->first();

            //send mail to admin
            $order_page_form_mail =  get_static_option('order_page_form_mail');
            $order_mail = $order_page_form_mail ? $order_page_form_mail : get_static_option('site_global_email');
            $order_details->status = 'cancel';
            $order_details->save();
            //send mail to customer
            $data['subject'] = __('one of your package order has been cancelled');
            $data['message'] = __('hello').'<br>';
            $data['message'] .= __('your package order ').' #'.$order_details->id.' ';
            $data['message'] .= __('has been cancelled by the user');

            //send mail while order status change
            Mail::to($order_mail)->send(new BasicMailTemplate($data));
            if (!empty($payment_log)){
                //send mail to customer
                $data['subject'] = __('your order status has been cancel');
                $data['message'] = __('hello'). '<br>';
                $data['message'] .= __('your order').' #'.$order_details->id.' ';
                $data['message'] .= __('status has been changed to cancel');
                //send mail while order status change
                Mail::to($payment_log->email)->send(new BasicMailTemplate($data));
            }
            return redirect()->back()->with(['msg' => __('Order Cancel'), 'type' => 'warning']);
        }
}
