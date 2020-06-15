<?php

namespace Navigation\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


class RouteList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $emptyOption = '---Please select a Route---';

    /**
     * init
     */
    public function init()
    {
        $config = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('config');
        
        $routes = $config['router']['routes'];
        $this->setValueOptions($this->getRoutes($routes));
    }

    /**
     * @param $routes
     * @return array
     */
    public function getRoutes($routes)
    {
    	$routeArray = [
    	    'heading'   => 'Category Heading',
            'link'      => 'Link'
        ];

    	foreach($routes as $key => $val){
    		$routeArray[$key] = $key;
    		if (isset($val['child_routes'])) {
    			$routeArray = $this->getChildRoutes($routeArray, $key, $val['child_routes']);
    		}
    	}

    	return $routeArray;
    }

    /**
     * @param $routeArray
     * @param $parent
     * @param $routes
     * @param int $depth
     * @return mixed
     */
    protected function getChildRoutes($routeArray, $parent, $routes, $depth = 1)
    {
        if ($parent != 'admin') {
            foreach($routes as $key => $val){
                $routeKey = $parent . '/' . $key;
                $routeValue = $parent . ' : ' . $key;
                $routeArray[$routeKey] = $routeValue;
                if (isset($val['child_routes'])) {
                    $routeArray = $this->getChildRoutes($routeArray, $key, $val['child_routes'], $depth++);
                }
            }
        }
    	 
    	return $routeArray;
    }
}
