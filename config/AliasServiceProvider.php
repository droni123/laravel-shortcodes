<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider{
    public function register(): void{
        $loader = AliasLoader::getInstance();
        $loader->alias('Shortcode', \App\Support\Shortcodes\Facades\Shortcode::class);
    }
    public function boot(): void{
        //
    }
}
