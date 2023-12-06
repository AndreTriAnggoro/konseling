<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */

     public function boot(): void
     {
         view()->composer('*', function ($view) {
             $user = Auth::user();
             
             if ($user) {
                 $notifikasiDosenwali = Jadwal::where('nip_dosenwali', $user->username)->get();
                 $view->with('notifikasiDosenwali', $notifikasiDosenwali);
             }
         });
     }
}
