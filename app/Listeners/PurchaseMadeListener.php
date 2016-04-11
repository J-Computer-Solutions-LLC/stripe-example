<?php

namespace App\Listeners;

use Mail;
use App\Events\PurchaseMade;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PurchaseMadeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PurchaseMade  $event
     * @return void
     */
    public function handle(PurchaseMade $event)
    {
        Mail::raw('This is a message', function($m) use($event->user) {
          $m->to($event->user->email);
          // $m->from('green.koopa667@gmail.com');
        } )
    }
}
