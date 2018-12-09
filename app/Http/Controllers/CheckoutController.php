<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Order;
use Carbon\Carbon;
use App\Jobs\SetExpiredOrder;

class CheckoutController extends Controller
{

    public function prepaidbalance()
    {
        return view('prepaid-balance');
    }

    public function product()
    {
        return view('product');
    }

    public function checkout_prepaidbalance(Request $request)
    {
        $validatedData = $request->validate([
            'mobilephone'  => 'required|numeric|digits_between:7,12|regex:/(081)[0-9]/',
            'prepaidvalue' => 'required|in:10000,50000,100000',
        ]);

        DB::beginTransaction();
        try {
            $order_no = mt_rand(1000000000, mt_getrandmax());
            $fee      = (5/100) * $request->input('prepaidvalue');
            $total    = $request->input('prepaidvalue') + $fee;
            $order    = new Order;
            $order->order_no         = $order_no;
            $order->user_id          = Auth::id();
            $order->product          = 'Prepaid Balance';
            $order->shipping_address = $request->input('mobilephone');
            $order->price            = $request->input('prepaidvalue');
            $order->fee              = $fee;
            $order->total            = $total;
            $order->expired_at       = Carbon::now()->addMinutes(5);
            $order->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('prepaidbalance');
        }
        return redirect()->route('checkoutsuccess',['inv' => $order_no]);
    }

    public function checkout_product(Request $request)
    {
        $validatedData = $request->validate([
            'product'         => 'required|between:10,150',
            'shippingaddress' => 'required|between:10,150',
            'price'           => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $order_no = mt_rand(1000000000, mt_getrandmax());
            $fee      = 10000;
            $total    = $request->input('price') + $fee;
            $order = new Order;
            $order->order_no         = $order_no;
            $order->user_id          = Auth::id();
            $order->product          = $request->input('product');
            $order->shipping_address = $request->input('shippingaddress');
            $order->price            = $request->input('price');
            $order->fee              = $fee;
            $order->total            = $total;
            $order->expired_at       = Carbon::now()->addMinutes(5);
            $order->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('product');
        }
        return redirect()->route('checkoutsuccess',['inv' => $order_no]);
    }

    public function checkout_success(Request $request)
    {
        $order = Order::where('order_no', $request->input('inv'))->first();
        return view('success-checkout', ['order' => $order]);
    }

    public function payment(Request $request)
    {
        $invoice = $request->input('inv') ?? '';
        return view('payment', ['invoice' => $invoice]);
    }

    public function do_payment(Request $request)
    {
        $validatedData = $request->validate([
            'ordernumber' => 'required|min:10',
        ]);
        
        $order = Order::where('order_no', $request->input('ordernumber'))
        ->where('user_id', Auth::id())
        ->first();
        if(!$order){
            return redirect()->route('checkoutpayment',['inv' => $request->input('ordernumber')])->with('error_status', 'Order No Not Found!');
        }
        if(strtolower($order->status) == 'paid' || strtolower($order->status) == 'canceled' || strtolower($order->status) == 'failed'){
            return redirect()->route('checkoutpayment',['inv' => $order->order_no])->with('error_status', 'Failed paid Order because order status is ' . $order->status);
        }

        $status_paid       = 'paid';
        $current_date_time = Carbon::now()->toTimeString();
        //START random success rate
        if('Prepaid Balance' == $order->product){
            if($current_date_time >= '09:00:00' && $current_date_time <= '17:00:00'){
                $chance_rate = [1,1,1,1,1,1,1,1,1,0];
                $random_rate = rand(0,9);
                $rate        = $chance_rate[$random_rate];
            }else{
                $chance_rate = [1,1,1,1,0,0,0,0,0,0];
                $random_rate = rand(0,9);
                $rate        = $chance_rate[$random_rate];
            }
            $status_paid = ($rate) ? 'paid' : 'failed';
        }
        //END random success rate
        
        DB::beginTransaction();
        try {
            $order->update([
                'status'        => $status_paid,
                'payment_at'    => Carbon::now(),
                'shipping_code' => ('Prepaid Balance' != $order->product) ? substr(md5(time()), 0, 8) : NULL,
            ]);
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('checkoutpayment');
        }

        if('paid' == $status_paid){
            return redirect()->route('checkoutpayment')->with('success_status', 'Success pay Order ' . $order->order_no);
        }else{
            return redirect()->route('checkoutpayment')->with('error_status', 'Fail pay Order ' . $order->order_no);
        }
        
    }

    public function order(Request $request)
    {
        $q = $request->input('search') ?? '';
        $orders = Order::where('user_id', Auth::id())
        ->where('order_no', 'LIKE', '%' . $q . '%')
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        $orders->appends(['search' => $q]);
        return view('order', ['orders' => $orders, 'search_query' => $q]);
    }

    public function orderexpired()
    {
        //call this method every 5 minutes (cronjob/taskscheduler) to set expired order
        $orders = Order::where('status', 'unpaid')->get();
        foreach ($orders as $order) {
            if(Carbon::now() > $order->expired_at){
                //set expired job
                //send to queue
                echo $order->expired_at . ' ==> ' .  Carbon::now(). ' <br>';
                $set_expired = dispatch(new SetExpiredOrder($order->order_no));
            }
        }
    }
}