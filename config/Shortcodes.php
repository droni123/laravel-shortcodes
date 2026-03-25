<?php
namespace App\Traits;

use Auth;

class Shortcodes {
	//SLIDER
	public function carrusel($shortcode, $content, $compiler, $name, $viewData){
		$otros = '';
		$atts = $shortcode->toArray();
		$proporcion = 'p16x9';
		$responsivo='';
		$class = '';
		foreach($atts as $k => $a){
			switch ($k) {
				case 'p': $proporcion = $k.$a; break;
				case 'r': $responsivo = $a; break;
				case 'class': $class .= $a.' '; break;
				default: 
					if($k != 0 && $a != ''){ 
						$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
					}
			}
		}
		$proporcion = trim($proporcion);
		$proporcion = ($proporcion != ''? ' '.$proporcion : '');
		$class = trim($class);
		$class = ($class != ''? ' '.$class : '');
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		$responsivo = trim($responsivo);
		$responsivo = ($responsivo != ''? '="'.$responsivo.'"' : '');
		return sprintf('<section class="vrespon%s" carruselcontenedor%s><article class="carrusel"%s><div items>%s</div><div botones><div izquierda></div><div botones-selec></div><div derecha></div></div></article></section>',
			$proporcion,
			$responsivo,
			$otros,
			trim($content)
		);
	}
	//divisor
	public function divisor($shortcode, $content, $compiler, $name, $viewData){
		$contenido = '<section><article class="container"><div class="row"><div class="col-md-12"><hr class="divisorfull"></div></div></article></section>';
		return $contenido;
	}
	//SECCIONES
	public function seccion($shortcode, $content, $compiler, $name, $viewData){
		$tipo = ''; $tipo2 = ''; $tipo3 = '';
		$class = ''; $class2 = ''; $class3 = '';
		$atts = $shortcode->toArray();
		foreach($atts as $k => $a){
			switch ($k) {
				case 'tipo':
					$tipo .= $a;
					break;
				case 'tipo2':
					$tipo2 .= $a;
					break;
				case 'tipo3':
					$tipo3 .= $a;
					break;
				case 'class':
					$class .= $a.' ';
					break;
				case 'class2':
					$class2 .= $a.' ';
					break;
				case 'class3':
					$class3 .= $a.' ';
					break;
				default:
					if($k != 0 && $a != ''){
						$tipo .= ' '.$k.'="'.$a.'" ';
					}
			}
		}
		$tipo = trim($tipo);
		$tipo = ($tipo != ''? ' '.$tipo : '');
		$tipo2 = trim($tipo2);
		$tipo2 = ($tipo2 != ''? ' '.$tipo2 : '');
		$tipo3 = trim($tipo3);
		$tipo3 = ($tipo3 != ''? ' '.$tipo3 : '');
		$class = trim($class);
		$class = ($class != ''? ' class="'.$class.'"' : '');
		$class2 = trim($class2);
		$class2 = ($class2 != ''? ' '.$class2 : '');
		$class3 = trim($class3);
		$class3 = ($class3 != ''? ' '.$class3 : '');
		return sprintf('<section%s%s><article class="container%s"%s><div class="row%s"%s>%s</div></article></section>',
			$class,
			$tipo,
			$class2,
			$tipo2,
			$class3,
			$tipo3,
			trim($content)
		);
    }
	//COLUMAS
	public function c($shortcode, $content, $compiler, $name, $viewData){
		$t = '';
		$class = '';
		$otros = '';
		$atts = $shortcode->toArray();
		foreach($atts as $k=>$a){
			switch ($k) {
				case 't':
					$cadena = explode(' ', $a);
					foreach ($cadena as $palabra) { $t .= 'col-'.$palabra.' ';}
					break;
				case 'class':
					$class .= $a.' ';
					break;
				default:
					$patron = '/^(sm|md|lg|xl)-(1[0-2]|[1-9])$/';
					if(preg_match($patron, $a) === 1){
						$t .= 'col-'.$a.' ';
					} else {
						$rev = explode('=',trim($a));
						//dd($rev, $a);
						if($k != 0 && $a != ''){
							if(count($rev) == 2){
								$otros .= ' '.trim($rev[0]).'="'.trim(str_replace('"','',$rev[1])).'" ';
							} else {
								$otros .= ' '.$k.'="'.$a.'" ';
							}
						} else if($k == 0) {
							if(count($rev) == 2){
								$otros .= ' '.trim($rev[0]).'="'.trim(str_replace('"','',$rev[1])).'" ';
							}
						}
					}
			}
		}
		$t = trim($t);
		$t = ($t != ''? $t : 'col-12');
		$class = trim($class);
		$class = ($class != ''? ' '.$class : '');
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		return sprintf('<div class="%s%s"%s>%s</div>',
			$t,
			$class,
			$otros,
			trim($content)
		);
    }
	//DIV
	public function div($shortcode, $content, $compiler, $name, $viewData){
		$otros = '';
		$atts = $shortcode->toArray();
		foreach($atts as $k=>$a){
			if(!is_int($k)){
				$otros .= ' '.$k.'="'.$a.'"';
			} else {
				$otros .= ' '.$a.'';
			}
		}
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		return sprintf('<div%s>%s</div>',
			$otros,
			trim($content)
		);
    }
	public function txtzoom($shortcode, $content, $compiler, $name, $viewData){
		$atts = $shortcode->toArray();
		$otros = '';
		$proporcion = 'p4x3';
		$img = '/imagenes/img-4-3.svg';
		$color = '';
		$class = '';
		foreach($atts as $k => $a){
			switch ($k) {
				case 'p': $proporcion = $k.$a; break;
				case 'src': $img = $a; break;
				case 'color': $color = $a; break;
				case 'class': $class .= $a.' '; break;
				default: 
					if($k != 0 && $a != ''){ 
						$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
					}
			}
		}
		$proporcion = trim($proporcion);
		$proporcion = ($proporcion != ''? ' '.$proporcion : '');
		$class = trim($class);
		$class = ($class != ''? ' '.$class : '');
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		$img = trim($img);
		$img = ($img != ''? ''.$img : '');
		$color = trim($color);
		$color = ($color != ''? '="'.$color.'"' : '');
		return sprintf('<div txtzoom class="vrespon%s%s"%s><div txtfondo><div class="vrespon%s"><img src="%s"><div data-color%s></div></div></div><div txtpie>%s</div></div>',
			$proporcion,
			$class,
			$otros,
			$proporcion,
			$img,
			$color,
			trim($content)
		);
	}
	public function imgzoom($shortcode, $content, $compiler, $name, $viewData){
		$atts = $shortcode->toArray();
		$proporcion = 'p1x1';
		$img = '/imagenes/img-1-1.svg';
		$otros = '';
		$class = '';
		foreach($atts as $k => $a){
			switch ($k) {
				case 'p': $proporcion = $k.$a; break;
				case 'src': $img = $a; break;
				case 'class': $class .= $a.' '; break;
				default: 
					if($k != 0 && $a != ''){ 
						$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
					}
			}
		}
		$proporcion = trim($proporcion);
		$proporcion = ($proporcion != ''? ' '.$proporcion : '');
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		$img = trim($img);
		$img = ($img != ''? ''.$img : '');
		$class = trim($class);
		$class = ($img != ''? ''.$class : '');
		return sprintf('<div imgzoom%s><div ximg class="vrespon%s%s"><img src="%s"></div>%s</div>',
			$otros,
			$proporcion,
			$class,
			$img,
			(trim($content) ? '<div imgpie>'.trim($content).'</div>' : '')
		);
	}
	public function imgzoommodal($shortcode, $content, $compiler, $name, $viewData){
		$atts = $shortcode->toArray();
		$proporcion = 'p1x1';
		$img = '/imagenes/img-1-1.svg';
		$imgmodal = '';
		$otros = '';
		$titulo = '';
		$class = '';
		foreach($atts as $k => $a){
			switch ($k) {
				case 'p': $proporcion = $k.$a; break;
				case 'src': $img = $a; break;
				case 'srcmodal': $imgmodal = $a; break;
				case 'titulo': $titulo = $a; break;
				case 'class': $class .= $a.' '; break;
				default: 
					if($k != 0 && $a != ''){ 
						$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
					}
			}
		}
		$proporcion = trim($proporcion);
		$proporcion = ($proporcion != ''? ' '.$proporcion : '');
		$img = trim($img);
		$img = ($img != ''? ''.$img : '');
		$imgmodal = trim($imgmodal);
		$imgmodal = ($imgmodal != ''? ''.$imgmodal : $img);
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		$titulo = trim($titulo);
		$titulo = ($titulo != ''? ' '.$titulo : '');
		$class = trim($class);
		$class = ($img != ''? ''.$class : '');
		return sprintf('<div imgzoom%s><div ximg class="vrespon%s%s" data-acion="open_img_modal" data-img-src="%s" data-tiulo="%s" showcursor><img src="%s"></div>%s</div>',
			$otros,
			$proporcion,
			$class,
			$imgmodal,
			$titulo,
			$img,
			(trim($content) ? '<div imgpie2>'.trim($content).'</div>' : '')
		);

	}
	public function convocatorias($shortcode, $content, $compiler, $name, $viewData){
		$atts = $shortcode->toArray();
		$id = 'id="uno"';
        $f = '';
        $extra = '';
		foreach($atts as $k => $a){
			switch ($k) {
				case 'id': $id = 'id="'.$a.'"'; break;
				case 'f':  $f = 'data-f="'.$a.'"'; break;
				default: 
					if($k != 0 && $a != ''){ 
						$extra .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
					}
			}
		}
		$id = trim($id);
		$id = ($id != ''? ' '.$id : '');
		$f = trim($f);
		$f = ($f != ''? ''.$f : '');
		$extra = trim($extra);
		$extra = ($extra != ''? ' '.$extra : '');
		return sprintf('<div%s data-printajax="convocatorias"%s%s>%s</div>',
			$id,
			$f,
			$extra,
			trim($content)
		);
	}
	public function css($shortcode, $content, $compiler, $name, $viewData){
		$is_link = false;
		$otros = '';
		$atts = $shortcode->toArray();
		foreach($atts as $k=>$a){
			if($k == 'src'){ $k = 'href'; }
			$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
			if($k == 'href'){ $is_link = true; }
		}
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		if($is_link){
			return sprintf('<link rel="stylesheet"%s>',
				$otros
			);
		}else{
			return sprintf('<style%s>%s</style>',
				$otros,
				trim($content)
			);
		}
    }
	public function js($shortcode, $content, $compiler, $name, $viewData){
		$is_link = false;
		$otros = '';
		$atts = $shortcode->toArray();
		foreach($atts as $k=>$a){
			if($k == 'href'){ $k = 'src'; }
			$otros .= ' '.(!is_int($k) ? $k.'="'.$a.'"' : $a );
			if($k == 'src'){ $is_link = true; }
		}
		$otros = trim($otros);
		$otros = ($otros != ''? ' '.$otros : '');
		return sprintf('<script type="text/javascript"%s>%s</script>',
			$otros,
			$is_link ? '' : trim($content)
		);
    }

}