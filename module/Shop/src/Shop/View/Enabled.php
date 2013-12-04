<?php
namespace Shop\View;

use Zend\Form\View\Helper\AbstractHelper;

class Enabled extends AbstractHelper
{
    public function __invoke($model, $params)
    {
        $id = 'get' . ucfirst($params['table']) . 'Id';
        
    	$url = $this->view->url($params['route'], array(
    		'action'   => 'set-enabled',
    		'id'       => $model->$id()
    	));
    
    	$format = '<p class="'.$params['table'].'-status"><a href="%s" class="glyphicons %s '.$params['table'].'-%s">&nbsp;</a></p>';
    
    	if ($model->getEnabled()) {
    		$icon = 'ok';
    		$class = 'enabled';
    	} else {
    		$icon = 'remove';
    		$class = 'disabled';
    	}
    
    	return sprintf($format, $url, $icon, $class);
    }
}