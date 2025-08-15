<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\NavigationComposer;

class ViewServiceProvider extends ServiceProvider
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
     * Ini adalah tempat untuk mendaftarkan View Composer.
     */
    public function boot(): void
    {
        // Memberitahu Laravel: "Setiap kali view 'layouts.app' akan ditampilkan,
        // jalankan class NavigationComposer terlebih dahulu."
        View::composer('layouts.app', NavigationComposer::class);
    }
}