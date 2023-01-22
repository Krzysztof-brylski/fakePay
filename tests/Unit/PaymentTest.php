<?php

namespace Tests\Unit;

use App\Models\Payments;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
class PaymentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_establish_payment()
    {
        $response = $this->post('/',array(
            'originUrl'=>'http://xd.xd.pl',
            'statusUpdateUrl'=>'http://xd.xd.pl',
            'toPay'=>200,
            'clientEmail'=>'test@test.pl'
        ));
        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'originUrl'=>'http://xd.xd.pl',
            'statusUpdateUrl'=>'http://xd.xd.pl',
            'toPay'=>200,
            'clientEmail'=>'test@test.pl'
        ]);
    }

    public function test_finalize_payment()
    {
        $token = (new PaymentService())->establishPayment([
            'originUrl'=>'http://xd.xd.pl',
            'statusUpdateUrl'=>'http://xd.xd.pl',
            'toPay'=>200,
            'clientEmail'=>'test@test.pl'
        ]);

        $this->assertDatabaseHas('payments', [
            'token'=>$token,
        ]);
        $response=$this->post(route("finalize.payment"),['token'=>$token]);
        $response->assertStatus(302);
        $response->assertRedirect('http://xd.xd.pl');

    }
    public function test_cancel_payment()
    {
        $token = (new PaymentService())->establishPayment([
            'originUrl'=>'http://xd.xd.pl',
            'statusUpdateUrl'=>'http://xd.xd.pl',
            'toPay'=>200,
            'clientEmail'=>'test@test.pl'
        ]);

        $this->assertDatabaseHas('payments', [
            'token'=>$token,
        ]);
        $response=$this->post(route("cancel.payment"),['token'=>$token]);
        $response->assertStatus(302);
        $response->assertRedirect('http://xd.xd.pl');
    }

    public function test_show_payment()
    {
        $token = (new PaymentService())->establishPayment([
            'originUrl'=>'http://xd.xd.pl',
            'statusUpdateUrl'=>'http://xd.xd.pl',
            'toPay'=>200,
            'clientEmail'=>'test@test.pl'
        ]);
        $response=$this->get(route("show.payment",['Payments'=>$token]));
        $response->assertStatus(200);
    }


}
