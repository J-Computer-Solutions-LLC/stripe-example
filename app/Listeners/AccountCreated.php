<?php

namespace App\Listeners;

use App\Events\AccountCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class AccountCreated
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
     * @param  AccountCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {

        Mail::raw('This is a message', function($m) use ($event) {
          $m->to($event->user->email);
          // $m->from('green.koopa667@gmail.com');
        });
    }
}
