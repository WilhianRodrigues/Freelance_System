<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The base path where the routes are stored, relative to the "routes" directory.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route group here.  You can define all the routes that belong to the
     * application via this. Just provide a route group with the routes you wish to be included.
     *
     * @return void
     */
    public function map()
    {
        Route::group(
            [
                'namespace' => $this->namespace,
                'middleware' => 'api',
            ],
            function ($router) {
                require base_path('routes/api.php');
            }
        );

        Route::group(
            [
                'middleware' => 'web',
                'namespace' => $this->namespace,
            ],
            function ($router) {
                require base_path('routes/web.php');
                // Add your other route groups here.
            }
        );
    }

    public function redirectTo()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user->role === 'cliente') {
            return '/cliente/dashboard';
        } elseif ($user->role === 'freelancer') {
            return '/freelancer/dashboard';
        }

        return '/'; // Redirecionamento padrão
    }

}