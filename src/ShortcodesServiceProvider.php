<?php
namespace App\Support\Shortcodes;
use App\Support\Shortcodes\View\Factory;
use Illuminate\Support\ServiceProvider;
use App\Support\Shortcodes\Compilers\ShortcodeCompiler;
class ShortcodesServiceProvider extends ServiceProvider {
    /**
     * Realizar el arranque de los servicios después del registro.
     **/
    public function boot(){
        $this->enableCompiler();
    }
    /**
     * Habilitar el compilador.
     */
    public function enableCompiler(){
        // Comprobar si el compilador está habilitado automáticamente
        $state = $this->app['config']->get('laravel-shortcodes::enabled', false);
        // Habilitar cuando sea necesario
        if ($state) {
            $this->app['shortcode.compiler']->enable();
        }
    }
    /**
     * Registro de service provider.
     **/
    public function register(){
        $this->registerShortcodeCompiler();
        $this->registerShortcode();
        $this->registerView();
    }
    /**
     * Registro short code compilador.
     */
    public function registerShortcodeCompiler(){
        $this->app->singleton('shortcode.compiler', function ($app) {
            return new ShortcodeCompiler();
        });
    }
    /**
     * Registro de shortcode.
     */
    public function registerShortcode(){
        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });
    }
    /**
     * Registro Laravel view.
     */
    public function registerView(){
        $finder = $this->app['view']->getFinder();
        $this->app->singleton('view', function ($app) use ($finder) {
            // desde php &|| blade.
            $resolver = $app['view.engine.resolver'];
            $env = new Factory($resolver, $finder, $app['events'], $app['shortcode.compiler']);
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
    }
    /**
     * Obtiene los services provided de el provider.
     **/
    public function provides(){
        return ['shortcode','shortcode.compiler','view'];
    }
}
