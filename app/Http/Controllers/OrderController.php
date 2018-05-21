<?php

namespace App\Http\Controllers;

use PaytmWallet;
use Illuminate\Http\Request;
use App\User;
use App\Transaction;
use Validator;
use DB;
use Log;
use Mail;
use Redirect;

class OrderController extends Controller
{

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $transaction_id = $request->query->get('transaction_id');
        if(isset($transaction_id)) {
            $transaction = Transaction::where('transaction_id',$transaction_id)->first();
            if($transaction && $transaction->status == 2) {
                return view('register')->with('successOfTransaction', "You are registered successfully and ticket sent in your email.");
            } elseif($transaction && ($transaction->status == 1 || $transaction->status == 0)) {
                return view('register')->with('errorOfTransaction', "Your Payment Failed.Try Again.");
            } else {
                return view('register')->with('errorOfTransaction', "Your transaction doesn't exist.");
            }
        } else {
            return view('register');
        }

    }

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function order(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:60',
            'adhar_no' => 'required|numeric|digits:12',
            'mobile_no' => 'required|numeric|digits:10',
            'address' => 'required',
        ];
        // Build the validation constraint set.
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:60',
            'adhar_no' => 'required|numeric|digits:12',
            'mobile_no' => 'required|numeric|digits:10',
            'address' => 'required',
        ]);

        DB::beginTransaction();

        $input['order_id'] = $request->mobile_no.rand(1,100);
        $input['fee'] = 50;

        $user = User::where('adhar_no','=', $input['adhar_no'])->first();

        if(!$user) {
            $user_id = User::insertGetId([
                'email' => $input['email'],
                'adhar_no' => $input['adhar_no'],
                'name' => trim($input['name']),
                'address' => $input['address'],
                'mobile_no' => $input['mobile_no'],
                'adhar_no' => $input['adhar_no'],
            ]);
        } else {
            $user_id = $user->id;
        }

        $transaction_total_count = Transaction::where('status', '=', 2)->count();

        if($transaction_total_count == 25000) {
            return Redirect::to('/user-registration')
                ->with('errorOfTransaction', "You can't proceed because registration limit exceed.");
        }

        $transaction_data = User::with('transactions')->where('adhar_no','=', $input['adhar_no'])
            ->withCount('transactions')
            ->first();

        if($transaction_data && $transaction_data->transactions_count < 5) {
            Transaction::insert([
                'user_id' => $user_id,
                'fee' => $input['fee'],
                'order_id' => $input['order_id'],
            ]);
        } else {
            return Redirect::to('/user-registration')
                ->with('errorOfTransaction', 'Your transactions limit exceed to 5.');
        }

        DB::commit();

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $input['order_id'],
          'user' => config('services.paytm-wallet.user'),
          'mobile_number' => config('services.paytm-wallet.mobile_number'),
          'email' => config('services.paytm-wallet.email'),
          'amount' => $input['fee'],
          'callback_url' => url('api/payment/status')
        ]);

        return $payment->receive();
    }


    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        if($response->STATUS != 'TXN_FAILURE') {
            if($transaction->isSuccessful()){
                Transaction::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId()]);

                $user_data = Transaction::with('user')->where('order_id', $order_id)->first();

                $data = [
                    'text' => $user_data->user->id,
                    'toEmail' => $user_data->user->email,
                    'subject' => 'Get register successfully',
                ];

                try {
                    Mail::send('email', $data, function ($message) use ($data) {
                        Log::info('callled');
                        $message->to($data['toEmail'])->subject($data['subject']);
                    });

                    return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
                } catch (Exception $e) {
                    log::info($e);
                    return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
                }

            } else if($transaction->isFailed()){
                Transaction::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);

                return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
            }
        }
        return redirect()->route('user-registration', ['transaction_id' => 0]);
    }
}
