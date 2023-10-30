<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\HasApiTokens;
use App\Models\Course;
use App\Models\Bill;
use App\Models\Secondcourse;
use App\Models\Thirdcourse;
use App\Models\User;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Carbon\Carbon;

class PaypalController extends Controller
{
    public function paymen(Request $request, $id, $date)
    {
        // dd($request->price, $id, $date);
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal-success'),
                "cancel_url" => route('paypal-cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);

        // dd($response);

        if(isset($response['id']) && $response['id'] != null){
            foreach($response['links'] as $link){
                if($link['rel'] === 'approve'){
                    session(['bill_id' => $id, 'paytime' => $date]);
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal-cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
    
        $response = $provider->capturePaymentOrder($request->token);

        if( isset($response['status']) && $response['status'] == "COMPLETED" ){
            // Get the bill from the session
            $billId = session('bill_id');
            $paytime = session('paytime');

            $paytime_timestamp = Carbon::createFromFormat('d-m-Y', $paytime)->format('Y-m-d H:i:s');
            // dd($paytime, $paytime_timestamp);

            // Find the bill in the database
            $bill = Bill::find($billId);
            if ($bill) {
                $bill->is_paid = 1;
                $bill->payment_time = $paytime_timestamp;
                $bill->save();
            }
            return redirect()->route('tuition-student')->with('success', 'Thanh toan hoc phi thanh cong!');
        } else {
            return redirect()->route('paypal-cancel');
        }
    }
    

    public function cancel(Request $request)
    {
        return redirect()->route('tuition-student')->with('error', 'Thanh toan hoc phi that bai!');
    }
}
