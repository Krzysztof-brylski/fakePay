<?php


namespace App\Services;


use App\Events\PaymentStatusUpdateEvent;
use App\Models\Payments;
use http\Message;
use Illuminate\Support\Facades\Http;
use function League\Flysystem\toArray;

class PaymentService
{
    /**
     * @param Payments $payments
     * @param $status
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function updateStatus($payment, $status){
        $payment->status=$status;
        $payment->save();
        $response = Http::post("$payment->statusUpdateUrl/$payment->token", array(
            'status'=> $status,
        ));
        if($response->status() == 200 ){
            return $payment;
        }
        throw new \Exception("Updaing status filed with code: {$response->status()}");
    }


    /**
     * @param array $data
     * @return string
     */
    public function establishPayment(array $data){
        $payment = new Payments();
        $payment->token=uuid_create();
        $payment->originUrl=$data['originUrl'];
        $payment->statusUpdateUrl=$data['statusUpdateUrl'];
        $payment->toPay=$data['toPay'];
        $payment->clientEmail=$data['clientEmail'];
        $payment->save();
        return $payment->token;
    }

    /**
     * @param array $data
     * @return
     * @throws \Exception
     */
    public function finalizePayment(array $data){
        $payment=Payments::where('token','=',$data['token'])->first();

        $this->updateStatus($payment,"success");
        $redirect=$payment->originUrl;
        event(new PaymentStatusUpdateEvent($payment->clientEmail,'success'));
        return $redirect;
    }
    public function cancelPayment(array $data){
        $payment=Payments::where('token','=',$data['token'])->first();

        $response = $this->updateStatus($payment,"canceled");
        if($response->status() == 200){
            $redirectUrl=$payment->originUrl;
            event(new PaymentStatusUpdateEvent($payment->clientEmail,'canceled'));
            return $redirectUrl;
        }
        throw new \Exception("Updaing status filed with code: {$response->status()}");
    }

}
