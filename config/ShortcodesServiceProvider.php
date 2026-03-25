<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register(){
		Shortcode::register('carrusel','App\Traits\Shortcodes@carrusel');
		Shortcode::register('divisor','App\Traits\Shortcodes@divisor');
		Shortcode::register('seccion','App\Traits\Shortcodes@seccion');
		Shortcode::register('c','App\Traits\Shortcodes@c');
		Shortcode::register('div','App\Traits\Shortcodes@div');
		Shortcode::register('txtzoom','App\Traits\Shortcodes@txtzoom');
		Shortcode::register('imgzoom','App\Traits\Shortcodes@imgzoom');
		Shortcode::register('imgzoommodal','App\Traits\Shortcodes@imgzoommodal');
		Shortcode::register('convocatorias','App\Traits\Shortcodes@convocatorias');
		Shortcode::register('css','App\Traits\Shortcodes@css');
		Shortcode::register('js','App\Traits\Shortcodes@js');
	}
	public function boot(){
	}
}