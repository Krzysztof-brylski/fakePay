<?php

namespace App\Listeners;

use App\Notifications\PaymentStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class PaymentFinalizationListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Notification::route('mail',$event->clientEmail)->notify((new PaymentStatusNotification($event->status)));
    }
}
