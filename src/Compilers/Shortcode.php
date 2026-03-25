<?php
namespace App\Support\Shortcodes\Compilers;
use Illuminate\Contracts\Support\Arrayable;
class Shortcode implements Arrayable {
    /**
     * Shortcode nombre
     **/
    protected $name;
    /**
     * Shortcode Atributos
     **/
    protected $attributes = [];
    /**
     * Shortcode contenido
     **/
    public $content;
    public function __construct($name, $content, $attributes = []){
        $this->name = $name;
        $this->content = $content;
        $this->attributes = $attributes;
    }
    /**
     * optiene html attributos
     **/
    public function get($attribute, $fallback = null){
        $value = $this->{$attribute};
        if (!is_null($value)) {
            return $attribute . '="' . $value . '"';
        } elseif (!is_null($fallback)) {
            return $attribute . '="' . $fallback . '"';
        }
    }
    /**
     * muestra nombre shortcode
     **/
    public function getName(){
        return $this->name;
    }
    /**
     * Muestra shortcode contenido
     **/
    public function getContent(){
        return $this->content;
    }
    /**
     * Muestra array de attributos;
     **/
    public function toArray(){
        return $this->attributes;
    }
    /**
     * obtiene atributo por nombre
     **/
    public function __get($param){
        return isset($this->attributes[$param]) ? $this->attributes[$param] : null;
    }
}
