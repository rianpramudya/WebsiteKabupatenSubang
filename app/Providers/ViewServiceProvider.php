<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\NavigationComposer;

class ViewServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {

        View::composer('layouts.app', NavigationComposer::class);
    }
}