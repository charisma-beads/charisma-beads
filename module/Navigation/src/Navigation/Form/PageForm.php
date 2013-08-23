<?php

namespace Navigation\Form;

use Zend\Form\Form;

class PageForm extends Form
{
    protected $sm;
    
	public function __construct($sm)
	{
		parent::__construct('Page');
		
		$this->sm = $sm;
		
		$this->add(array(
			'name' => 'pageId',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'menuId',
			'type' => 'hidden',
		));
		
		$this->add(array(
			'name' => 'label',
			'type' => 'text',
			'options' => array(
				'label' => 'Label:',
				'required' => true,
			),
			'attributes' => array(
				'placeholder' => 'Label:',
			),
		));
		
		$this->add(array(
		    'name' => 'params',
		    'type' => 'textarea',
		    'options' => array(
		        'label' => 'Params:',
		        'required' => false,
		    ),
		    'attributes' => array(
		        'placeholder' => 'Params:',
		    ),
		));
		
		$config = $sm->get('Config');
		$routes = $config['router']['routes'];
		
		$this->add(array(
			'name' => 'route',
			'type' => 'select',
			'options' => array(
				'label' => 'Route:',
				'required' => false,
			    'empty_option' => '---Please Select a Route---',
			    'value_options' => $this->getRouteSelect($routes)
			),
		));
		
		$resources = $config['app_acl']['appResources'];
		
		$this->add(array(
			'name' => 'resource',
			'type' => 'select',
			'options' => array(
				'label' => 'Resource:',
				'required' => false,
			    'empty_option' => 'None',
			    'value_options' => $this->getResourceSelect($resources)
			),
			'attributes' => array(
				'placeholder' => 'Resource:',
			),
		));
		
		$this->add(array(
			'name' => 'visible',
			'type' => 'select',
			'options' => array(
				'label' => 'Is Visible:',
				'required' => true,
				'empty_option' => '---Please select option---',
				'value_options' => array(
					'0' 		=> 'No',
					'1' 		=> 'Yes',
				),
			),
		));
	}
	
	public function getPageSelect($menuId)
	{
	    $nav = $this->sm->get('Navigation\Model\Navigation');
	     
	    $pages = $nav->getPagesByMenuId($menuId);
	    $pagesOptions = array();
	    
	    $pagesOptions[0] = 'Add to top of menu';
	    
	    foreach($pages as $page){
	        $pagesOptions[$page->pageId] = $page->label;
	    }
	    
	    $this->add(array(
	        'name' => 'position',
	        'type' => 'select',
	        'options' => array(
	            'label' => 'Location In Menu:',
	            'required' => true,
	            'empty_option' => '---Please Select a page---',
	            'value_options' => $pagesOptions
	        ),
	    ));
	    
	    return $this->get('position');
	}
	
	public function getResourceSelect($resources)
	{
	    $routeArray = array();
	    foreach($resources as $val){
	        $routeArray[$val] = $val;
	    }
	
	    return $routeArray;
	}
	
	public function getRouteSelect($routes)
	{
	   $routeArray = array(0 => 'Category Heading');
	   foreach($routes as $key => $val){
	       $routeArray[$key] = $key;
	       if (isset($val['child_routes'])) {
	           $routeArray = $this->getChildRoutes($routeArray, $key, $val['child_routes']);
	       }
	   }
	   
	   return $routeArray;
	}
	
	protected function getChildRoutes($routeArray, $parent, $routes)
	{
	    foreach($routes as $key => $val){
	        $routeArray[$parent . '/' . $key] = $parent . '/' . $key;
	        if (isset($val['child_routes'])) {
	           
	        }
	    }
	    
	    return $routeArray;
	}
}
