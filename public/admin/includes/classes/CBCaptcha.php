<?php

use Zend\Form\Element\Captcha as ZendCaptcha;

class CBCaptcha extends ZendCaptcha 
{	
	protected $captchaOptions = array(
		'class' 	=> 'image',
		'options' 	=> array(
			'imgDir' 			=> 'admin/tmp',
			'fontDir' 			=> 'admin/TTF',
			'font' 				=> array(
				//'actionj.ttf',
				'arial.ttf',
				'bboron.ttf',
				'comic.ttf',
				'comicbd.ttf',
				//'epilog.ttf',
				//'expr.ttf',
				//'JUICE.TTF',
				//'lexo.ttf',
				//'tomnr.ttf',
			),
			'width' 			=> 231,
			'height' 			=> 72,
			'dotNoiseLevel' 	=> 20,
			'lineNoiseLevel'	=> 3,
			'expiration'    	=> 60,
		),
	);
	
	public function init()
	{
		$spec = $this->captchaOptions;
	
		if ('image' === $spec['class']) {
	
			$font = $spec['options']['font'];
	
			if (is_array($font)) {
				$rand = array_rand($font);
				$randFont = $font[$rand];
				$font = $randFont;
			}
	
			$spec['options']['font'] = join('/', array(
				$_SERVER['DOCUMENT_ROOT'],
				$spec['options']['fontDir'],
				$font
			));
	
			$spec['options']['imgUrl'] = '/'.$spec['options']['imgDir'];
			
			$spec['options']['imgDir'] = join('/', array(
				$_SERVER['DOCUMENT_ROOT'],
				$spec['options']['imgDir']
			));
		}
	
		$this->setCaptcha($spec);
	}
	
}

?>