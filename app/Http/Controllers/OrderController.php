<?php

namespace App\Http\Controllers;

use PaytmWallet;
use Illuminate\Http\Request;
use App\Ticket;
use Validator;
use DB;
use Log;
use Mail;
use Redirect;
use App;
use Storage;
use View;

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
            $transaction = Ticket::where('transaction_id',$transaction_id)->first();
            if($transaction && $transaction->status == 2) {
                return view('register')->with('successOfTransaction', "You are registered successfully and ticket sent in your email.");
            } elseif($transaction && $transaction->status == 1) {
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
        if(strtotime(date('Y-m-d H:i:s')) > strtotime(config('app.validity_date'))){
            return Redirect::to('/user-registration')
                ->with('errorOfTransaction', "You are late to registration.");
        }

        $input = $request->all();
        // Build the validation constraint set.
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:60',
            'adhar_no' => 'required|numeric|digits:12',
            'mobile_no' => 'required|numeric|digits:10',
            'agreed' => 'required|accepted'
        ]);

        DB::beginTransaction();

        $input['order_id'] = $request->mobile_no.str_random(6);
        $input['fee'] = config('app.ticket_price');

        $tickets = Ticket::where('adhar_no','=', $input['adhar_no'])->where('status', '=', 2)->count();

        if($tickets == 5) {
            return Redirect::to('/user-registration')
                ->with('errorOfTransaction', 'Your transactions limit exceed to 5.');
        }

        $uniqueId = uniqid();

        $ticket_id = Ticket::insertGetId([
            'adhar_no' => $input['adhar_no'],
            'ticket_unique_id' => $uniqueId,
            'fee' => $input['fee'],
            'order_id' => $input['order_id'],
            'email' => $input['email'],
            'name' => trim($input['name']),
            'address' => $input['address'],
            'mobile_no' => $input['mobile_no'],
            'agreed' => $input['agreed'],
        ]);

        $transaction_total_count = Ticket::where('status', '=', 2)->count();

        if($transaction_total_count == config('app.registration_limit')) {
            return Redirect::to('/user-registration')
                ->with('errorOfTransaction', "You can't proceed because registration limit exceed.");
        }

        DB::commit();

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $input['order_id'],
          'user' => config('services.paytm-wallet.user'),
          'mobile_number' => config('services.paytm-wallet.mobile_number'),
          'email' => config('services.paytm-wallet.email'),
          'amount' => $input['fee'],
          'callback_url' => config('services.paytm-wallet.callback_url'),
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

        if($transaction->isSuccessful()){

            $count = Ticket::where('status', '=', 2)->count();

            $ticket_uni_id = $count == 0 ? 1 : uniqid();

            $ticket_data = Ticket::where('status', '=', 2)
                ->pluck('ticket_unique_id')
                ->toArray();

            $numeric_ticket_ids = array();

            foreach ($ticket_data as $value) {
                if(is_numeric($value)) {
                    array_push($numeric_ticket_ids, $value);
                }
            }

            $max_unique_id = 0;

            if(sizeof($numeric_ticket_ids) > 0) {
                $max_unique_id = max($numeric_ticket_ids);
            }

            if($count != 0) {
                $ticket_uni_id = $max_unique_id + 1;
            }

            Ticket::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId(), 'ticket_unique_id'=>$ticket_uni_id]);

            $user_data = Ticket::where('order_id', $order_id)->first();

            $data = [
                'user_id' => $user_data->id,
                'toEmail' => $user_data->email,
                'name' => $user_data->name,
                'mobile_no' => $user_data->mobile_no,
                'adhar_no' => $user_data->adhar_no,
                'subject' => 'Get register successfully',
                'orderId' => $order_id,
                'uniqueId' => $ticket_uni_id,
                'price' => config('app.ticket_price'),
                'orderDate' => $user_data->updated_at,
            ];

            $htmlData = View::make('ticketview')
                ->with('data', $data)
                ->render();

            self::generateDomPdfandSavetoServer($ticket_uni_id, $htmlData);


            if (config('filesystems.default') == 'local') {
                $path = public_path('/storage/ticket_pdf/'.$ticket_uni_id.'_ticket.pdf');
            } else {
                $path = Storage::url('ticket_pdf/'.$ticket_uni_id.'_ticket.pdf');
            }

            try {
                Mail::send('email', $data, function ($message) use ($data, $path) {
                    Log::info('callled');
                    $message->to($data['toEmail'])
                        ->subject($data['subject'])
                        ->attach($path, [
                            'mime' => 'application/pdf',
                        ]);
                });

                return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
            } catch (Exception $e) {
                Log::info($e);
                return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
            }

        } else if($transaction->isFailed()){
            Ticket::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);

            return redirect()->route('user-registration', ['transaction_id' => $transaction->getTransactionId()]);
        }
    }

    public static function generateDomPdfandSavetoServer($ticket_unique_id, $htmlData)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHtml($htmlData);
        $pdf->setPaper('A4', 'portrait');
        $output = $pdf->output();
        Storage::put(
            'public/ticket_pdf/'.$ticket_unique_id.'_ticket.pdf', $output
        );
    }

    public function termsConditions()
    {
        return view('termsConditions');
    }
}
