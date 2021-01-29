<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('admin', function () {
            $isAdmin = false;
            if (Auth::check()) {
                $isAdmin = Auth::user()->isAdmin();
            }
            return "<?php if ($isAdmin) { ?>";
        });

        Blade::directive('endadmin', function () {
            return "<?php } ?>";
        });
    }
}
