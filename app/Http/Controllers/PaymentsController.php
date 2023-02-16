<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstablishPaymentRequest;
use App\Http\Requests\FinalizePaymentRequest;
use App\Models\Payments;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentsController extends Controller
{
    /**
     * @return View
     */
    public function index(){
        return view('index');
    }

    /**
     * @param EstablishPaymentRequest $request
     * @return JsonResponse
     */
    public function establishPayment(EstablishPaymentRequest $request){
        $data = $request->validated();
        $token = (new PaymentService())->establishPayment($data);
        return Response()->json(['token'=>$token],201);
    }

    /**
     * @param Payments $Payments
     * @return View
     */
    public function showPayment(Payments $Payments){
        return view('payment',["Payments"=>$Payments]);
    }

    /**
     * @param FinalizePaymentRequest $request
     * @return RedirectResponse
     */
    public function finalizePayment(FinalizePaymentRequest $request){
        $data = $request->validated();
        try{
            $redirectTo =  (new PaymentService())->finalizePayment($data);
            return Redirect::away($redirectTo);
        }catch (\Exception $exception) {
            return Redirect::back()->with(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param FinalizePaymentRequest $request
     * @return RedirectResponse
     */
    public function cancelPayment(FinalizePaymentRequest $request){
        $data = $request->validated();
        try{
            $redirectTo = (new PaymentService())->cancelPayment($data);
            return Redirect::away($redirectTo);
        }catch (\Exception $exception) {
            return Redirect::back()->with(['error' => $exception->getMessage()]);
        }

    }
}
