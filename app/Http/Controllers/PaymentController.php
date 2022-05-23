<?php

namespace App\Http\Controllers;

use Omnipay\Omnipay;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class PaymentController extends Controller
{

private $gatway;

public function __construct(){
    $this->gatway = Omnipay::create('PayPal_Reset');
    $this->gatway->setClientId(env('PAYPAL_CLIENT_ID'));
    $this->gatway->setSecret(env('PAYPAL_CLIENT_SECRET'));
    $this->gatway->setTestMode(true);

}


    public function payment(Request $request)
    {

        $request->validate([
            'name'           => 'required',
            'email'          => 'required|email',
        ]);
        $amount = $request->amount;
              try{
            $response = $this->gatway->purchase(array(
                'amount'=>$amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'return' => url('success'),
                'cancelUrl'=> url('error '),
            ))->send();
            if($response->isRedirect()){
                $response->redirect();
            }else{
                return $response->getMessage();
            }


    }catch(\Throwable $th){
        // throw $th;
    }

    return response()->json([ 'success'=> 'Form is successfully submitted!']);
    }

    public function success(Request $request)
    {
        if($request->input('paymemtId') && $request->input('PayerID'))
        {
            $transaction = $this->gatway->completePurchase(array(
                 'payer_id' => $request->input('PayerID'),
                 'transactionReference'=> $request->input('paymentId')
            ));

            $response = $transaction->send();
            if($response->isSuccessful()){
                $arr = $response->getData();

                $payment = new Payment();
                $payment->name =$request->name;
                $payment->email = $arr['payer']['payer_info']['email'];
                $payment->email = $arr['transactions'][0]['amount']['total'];
                $details = $payment->save();

                \Mail::to($request->email)->send(new \App\Mail\completepayemnt($details));

                return "Payment is Successful. Your transaction id is: ".$arr['id'];
            }
        }
    }

}
