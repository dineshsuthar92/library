<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($status, $message, $data) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
            ]);
        });
    }
}
