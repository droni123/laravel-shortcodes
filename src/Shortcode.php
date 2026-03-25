<?php 
namespace App\Support\Shortcodes;
use App\Support\Shortcodes\Compilers\ShortcodeCompiler;
class Shortcode {
    /**
     * Shortcode compilador
     **/
    protected $compiler;
    public function __construct(ShortcodeCompiler $compiler){
        $this->compiler = $compiler;
    }
    /**
     * Registro de nuevo shortcode
     **/
    public function register($name, $callback) {
        $this->compiler->add($name, $callback);
        return $this;
    }
    /**
     * Habilita laravel-shortcodes
     **/
    public function enable(){
        $this->compiler->enable();
        return $this;
    }
    /**
     * Desabilita laravel-shortcodes
     */
    public function disable(){
        $this->compiler->disable();
        return $this;
    }
    /**
     * Compila el string
     **/
    public function compile($value){
        // Habilitamos
        $this->enable();
        // Compilamos
        return $this->compiler->compile($value);
    }
    /**
     * Elimina shortcode del contenido.
     **/
    public function strip($value){
        return $this->compiler->strip($value);
    }
}
