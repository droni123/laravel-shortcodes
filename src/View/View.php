<?php

namespace App\Support\Shortcodes\View;

use ArrayAccess;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View as IlluminateView;
use App\Support\Shortcodes\Compilers\ShortcodeCompiler;
use Illuminate\Contracts\View\Engine as EngineInterface;

class View extends IlluminateView implements ArrayAccess, Renderable{
    public $shortcode;
    public function __construct(ShortcodeCompiler $shortcode, Factory $factory, EngineInterface $engine, $view, $path, $data = []){
        parent::__construct($factory, $engine, $view, $path, $data);
        $this->shortcode = $shortcode;
    }
    public function withShortcodes(){
        $this->shortcode->enable();
        return $this;
    }
    public function withoutShortcodes(){
        $this->shortcode->disable();
        return $this;
    }
    public function withStripShortcodes(){
        $this->shortcode->setStrip(true);
        return $this;
    }
    protected function renderContents(){
        $this->shortcode->viewData($this->getData());
        $this->factory->incrementRender();
        $this->factory->callComposer($this);
        $contents = $this->getContents();
        if ($this->shortcode->getStrip()) {
            $contents = $this->shortcode->strip($contents);
        } else {
            $contents = $this->shortcode->compile($contents);
        }
        $this->factory->decrementRender();

        return $contents;
    }
}
