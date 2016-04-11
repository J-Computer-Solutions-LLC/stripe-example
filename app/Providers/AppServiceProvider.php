<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\User;
use Mail;
use App\Events\AccountCreated;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function($user) {
            event(new AccountCreated($user));
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
