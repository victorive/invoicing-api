<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function (string $message, mixed $data, int $status) {
            return Response::json([
                'status' => true,
                'message' => $message,
                'data' => $data,
            ], $status);
        });

        Response::macro('error', function (string $message, int $status) {
            return Response::json([
                'status' => false,
                'message' => $message,
            ], $status);
        });
    }
}
