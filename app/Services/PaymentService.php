<?php


namespace App\Services;


use App\Models\Payments;
use Illuminate\Support\Facades\Http;
use function League\Flysystem\toArray;

class PaymentService
{
    /**
     * @param $statusUpdateUrl
     * @param $status
     * @return \Illuminate\Http\Client\Response
     */
    private function updateStatus($statusUpdateUrl, $status){
        $response = Http::post($statusUpdateUrl, array(
            'status'=> $status,
        ));
        return $response;
    }


    /**
     * @param array $data
     * @return string
     */
    public function establishPayment(array $data){
        $Payments = new Payments();
        $Payments->token=uuid_create();
        $Payments->originUrl=$data['originUrl'];
        $Payments->statusUpdateUrl=$data['statusUpdateUrl'];
        $Payments->toPay=$data['toPay'];
        $Payments->clientEmail=$data['clientEmail'];
        $Payments->save();
        return $Payments->token;
    }

    /**
     * @param array $data
     * @return
     */
    public function finalizePayment(array $data){
        $payment=Payments::where('token','=',$data['token'])->first();
        //todo send success email
        $this->updateStatus($payment->statusUpdateUrl,"finalized");
        $redirect=$payment->originUrl;
        //event(finalized)
        $payment->delete();

        return $redirect;
    }
    public function cancelPayment(array $data){
        $payment=Payments::where('token','=',$data['token'])->first();
        //todo send success email
        $this->updateStatus($payment->statusUpdateUrl,"cancel");
        $redirect=$payment->originUrl;
        //event(canceled)
        //$payment->delete();
        return $redirect;
    }

}
