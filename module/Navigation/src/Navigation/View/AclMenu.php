<?php

namespace Navigation\View;

use Zend\Navigation\Navigation;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface as Router;
use Application\View\AbstractViewHelper;

class AclMenu extends AbstractViewHelper
{
	public function __invoke($container = null, $menu = null, $partial = null, $useZtb = true)
    {
        $acl = $this->getServiceLocator()->getServiceLocator()->get('User\Service\AclFactory');
        
        if ($container == 'model') {
            $container = $this->getPages($menu);
        }
        
        $n = ($useZtb) ? 'ztbNavigation' : 'Navigation';
        $m = ($useZtb) ? 'ztbMenu' : 'Menu';
        
    	$nav = $this->view->$n($container) ;
    	
    	// must set acl before partial.
    	$identity = $this->view->plugin('identity');
    	$role = ($identity()) ? $identity()->role : 'guest';
    	$nav->setAcl($acl)->setRole($role);
    	
    	if ($partial) {
    		if (is_string($partial)) {
    			$partial = array($partial, 'default');
    		}
    		
    		$nav->$m()->setPartial($partial);
    	}
    	
    	return $nav->$m()->render();
    }
    
    protected function getPages($menu)
    {
        $model = $this->getServiceLocator()->getServiceLocator()->get('Navigation\Model\Navigation');
        $pages = $model->getGateway('page')->getPagesByMenu($menu);
        $pageArray = array();
        
        foreach ($pages as $page) {
            $p = $page->toArray();
            $p['params'] = parse_ini_string($p['params']);
            if ($p['route'] == '0') {
                unset($p['route']);
                $p['uri'] = '';
            }
            $pageArray[] = $p;
        }
        
        return new Navigation($this->preparePages($this->listToMultiArray($pageArray)));
    }
    
    /*public function traverseArray(&$array, $keys)
    { 
        foreach ($array as $key => &$value) { 
            if (is_array($value)) { 
                self::traverseArray($value, $keys); 
            } else {
                if (in_array($key, $keys) || '' == $value){
                    unset($array[$key]);
                }
            } 
        }
        return $array;
    }*/
    
    public function listToMultiArray($arrs)
    {
        $nested = array();
        $depths = array();
    
        foreach($arrs as $key => $arr) {
            
            if( $arr['depth'] == 0 ) {
                $nested[$key] = $arr;
            } else {
                $parent =& $nested;
                
                for ($i = 1; $i <= ($arr['depth']); $i++) {
                    $parent =& $parent[$depths[$i]];
                }
                
                $parent['pages'][$key] = $arr;
            }
            
            $depths[$arr['depth'] + 1] = $key;
        }
        
        return $nested;
    }
    
    protected function preparePages($pages)
    {
        $application = $this->getServiceLocator()->getServiceLocator()->get('Application');
        $routeMatch  = $application->getMvcEvent()->getRouteMatch();
        $router      = $application->getMvcEvent()->getRouter();
    
        return $this->injectComponents($pages, $routeMatch, $router);
    }
    
    protected function injectComponents(array $pages, RouteMatch $routeMatch = null, Router $router = null)
    {
        foreach ($pages as &$page) {
            
            $hasMvc = isset($page['action']) || isset($page['controller']) || isset($page['route']);
            if ($hasMvc) {
                if (!isset($page['routeMatch']) && $routeMatch) {
                    $page['routeMatch'] = $routeMatch;
                }
                if (!isset($page['router'])) {
                    $page['router'] = $router;
                }
            }
    
            if (isset($page['pages'])) {
                $page['pages'] = $this->injectComponents($page['pages'], $routeMatch, $router);
            }
        }
        return $pages;
    }
}
