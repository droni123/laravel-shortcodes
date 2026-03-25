<?php 
namespace App\Support\Shortcodes\Compilers;
use Illuminate\Support\Str;
class ShortcodeCompiler{
    /**
     * Enabled estado
     **/
    protected $enabled = false;
    /**
     * Enable strip estado
     **/
    protected $strip = false;
    protected $matches;
    /**
     * Registra laravel-shortcodes
     **/
    protected $registered = [];
    /**
     * Ajunta datos de View
     **/
    protected $data = [];
    protected $_viewData;
    /**
     * Habilita
     **/
    public function enable(){
        $this->enabled = true;
    }
    /**
     * Desactiva
     */
    public function disable(){
        $this->enabled = false;
    }
    /**
     * Agrega nuevo shortcode
     */
    public function add($name, $callback){
        $this->registered[$name] = $callback;
    }
    public function attachData($data){
        $this->data = $data;
    }
    /**
     * Compila el contenido
     **/
    public function compile($value){
        if (!$this->enabled || !$this->hasShortcodes()) {
            return $value;
        }
        $result = '';
        foreach (token_get_all($value) as $token) {
            $result .= is_array($token) ? $this->parseToken($token) : $token;
        }
        return $result;
    }
    /**
     * valida laravel-shortcodes
     *
     * @return boolean
     */
    public function hasShortcodes(){
        return !empty($this->registered);
    }
    /**
     * Analizando tokens
     **/
    protected function parseToken($token){
        list($id, $content) = $token;
        if ($id == T_INLINE_HTML) {
            $content = $this->renderShortcodes($content);
        }
        return $content;
    }
    /**
     * Render laravel-shortcodes
     **/
    protected function renderShortcodes($value){
        $pattern = $this->getRegex();
        return preg_replace_callback("/{$pattern}/s", [$this, 'render'], $value);
    }
    public function viewData( $viewData ){
        $this->_viewData = $viewData;
        return $this;
    }
    /**
     * Renderiza el actual shortcode.
     **/
    public function render($matches){
        $compiled = $this->compileShortcode($matches);
        $name = $compiled->getName();
        $viewData = $this->_viewData;
        return call_user_func_array($this->getCallback($name), [
            $compiled,
            $compiled->getContent(),
            $this,
            $name,
            $viewData
        ]);
    }
    /**
     * Optiene atributos compilados
     **/
    protected function compileShortcode($matches){
        $this->setMatches($matches);
        $attributes = $this->parseAttributes($this->matches[3]);
        return new Shortcode(
            $this->getName(),
            $this->getContent(),
            $attributes
        );
    }
    /**
     * Envia coincidencias
     **/
    protected function setMatches($matches = []){
        $this->matches = $matches;
    }
    /**
     * Regresa el nombre de shortcode
     **/
    public function getName(){
        return $this->matches[2];
    }
    /**
     * Regresa el contenido de shortcode
     **/
    public function getContent(){
        return $this->compile($this->matches[5]);
    }
    /**
     * Regresa datos de vista
     **/
    public function getData(){
        return $this->data;
    }
    /**
     * Callback de shortcode actual (class or callback)
     **/
    public function getCallback($name){
        $callback = $this->registered[$name];
        if (is_string($callback)) {
            list($class, $method) = Str::parseCallback($callback, 'register');
            if (class_exists($class)) {
                return [ app($class), $method ];
            }
        }
        return $callback;
    }
    /**
     * Parse the shortcode attributes
     * @author Wordpress
     */
    protected function parseAttributes($text){
        $text = htmlspecialchars_decode($text, ENT_QUOTES);
        $attributes = [];
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', " ", $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $attributes[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $attributes[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $attributes[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $attributes[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $attributes[] = stripcslashes($m[8]);
                }
            }
        } else {
            $attributes = ltrim($text);
        }
        return is_array($attributes) ? $attributes : [$attributes];
    }
    /**
     * shortcode nombres
     **/
    protected function getShortcodeNames(){
        return join('|', array_map('preg_quote', array_keys($this->registered)));
    }
    /**
     * shortcode regex.
     * @author Wordpress
     */
    protected function getRegex(){
        $shortcodeNames = $this->getShortcodeNames();
        return "\\[(\\[?)($shortcodeNames)(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)";
    }
    /**
     * Elimina shortcode del contenido
     **/
    public function strip($content){
        if (empty($this->registered)) {
            return $content;
        }
        $pattern = $this->getRegex();
        return preg_replace_callback("/{$pattern}/s", [$this, 'stripTag'], $content);
    }
    public function getStrip(){
        return $this->strip;
    }
    public function setStrip($strip){
        $this->strip = $strip;
    }
    protected function stripTag($m){
        if ($m[1] == '[' && $m[6] == ']') {
            return substr($m[0], 1, -1);
        }
        return $m[1] . $m[6];
    }
    /**
     * Obtiene shortcodes registrados
     **/
    public function getRegistered(){
        return $this->registered;
    }
}
