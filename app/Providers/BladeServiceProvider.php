<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Директива для проверки роли админа
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Директива для проверки роли пользователя
        Blade::if('user', function () {
            return auth()->check() && auth()->user()->isUser();
        });
    }

    public function register()
    {
        //
    }
} 