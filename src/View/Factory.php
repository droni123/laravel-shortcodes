<?php

namespace App\Support\Shortcodes\View;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\View\ViewFinderInterface;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory as IlluminateViewFactory;
use App\Support\Shortcodes\Compilers\ShortcodeCompiler;

class Factory extends IlluminateViewFactory {
    /**
     * Short code
     **/
    public $shortcode;
    /**
     * Creando nueva instancia factory (view).
     **/
    public function __construct(EngineResolver $engines, ViewFinderInterface $finder, Dispatcher $events, ShortcodeCompiler $shortcode){
        parent::__construct($engines, $finder, $events);
        $this->shortcode = $shortcode;
    }
    /**
     * Contenido de la vista analizada
     **/
    public function make($view, $data = [], $mergeData = []){
        $path = $this->finder->find(
            $view = $this->normalizeName($view)
        );
        $data = array_merge($mergeData, $this->parseData($data));
        return tap(new View($this->shortcode, $this, $this->getEngineFromPath($path), $view, $path, $data), function ($view) {
            $this->callCreator($view);
        });
    }
}
