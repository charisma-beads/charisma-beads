<?php

namespace Navigation\View;

use Zend\Navigation\Navigation;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\RouteStackInterface as Router;
use Application\View\AbstractViewHelper;

class AclMenu extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $ulClass;
    
    /**
     * @var string
     */
    protected $menu;
    
    /**
     * @var string
     */
    protected $partial;
    
    /**
     * @var bool
     */
    protected $useZtb = true;
    
    /**
     * @var string|\Zend\View\Helper\Navigation\Menu
     */
    protected $container;
    
	public function __invoke($container)
    {   
        $this->setUlClass(null);
        $this->setContainer($container);
        
    	return $this;
    }
    
    public function __toString()
    {
        try {
            return $this->render();
        } catch (\Exception $e) {
            $msg = get_class($e) . ': ' . $e->getMessage();
            trigger_error($msg, E_USER_ERROR);
            return '';
        }
    }
    
    public function render()
    {   
        $acl = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('User\Service\Acl');
        
        $container = ($this->getContainer() !== 'model') ? $this->getContainer() : $this->getPages($this->getMenu());
        
        $n = ($this->useZtb) ? 'ztbNavigation' : 'Navigation';
        $m = ($this->useZtb) ? 'ztbMenu' : 'Menu';
        
        $nav = $this->view->$n($container);
         
        // must set acl before partial.
        $identity = $this->view->plugin('identity');
        $role = ($identity()) ? $identity()->getRole() : 'guest';
        $nav->setAcl($acl)->setRole($role);
        $partial = $this->getPartial();
        
        if ($partial) {
            if (is_string($partial)) {
                $partial = array($partial, 'default');
            }
        
            $nav->$m()->setPartial($partial);
        }
        
        $ulClass = ($this->getUlClass()) ?: $nav->$m()->getUlClass();
         
        return $nav->$m()->setUlClass($ulClass)->render();
    }
    
    protected function getPages($menu)
    {
    	/* @var $gateway \Navigation\Service\Page */
        $service = $this->getServiceLocator()->getServiceLocator()->get('Navigation\Service\Page');
        
        $pages = $service->getPagesByMenu($menu, true);
        
        $pageArray = array();
        
        /* @var $page \Navigation\Model\Page */
        foreach ($pages as $page) {
            $p = $pages->getHydrator()->extract($page);
            $p['params'] = parse_ini_string($p['params']);
            
            if ($p['route'] == '0') {
                unset($p['route']);
            } else {
            	unset($p['uri']);
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
    
	public function getUlClass()
    {
        return $this->ulClass;
    }

	public function setUlClass($ulClass)
    {
        $this->ulClass = $ulClass;
        return $this;
    }

	public function getMenu()
    {
        return $this->menu;
    }

	public function setMenu($menu)
    {
        $this->menu = $menu;
        return $this;
    }

	public function getPartial()
    {
        return $this->partial;
    }

	public function setPartial($partial)
    {
        $this->partial = $partial;
        return $this;
    }

	public function getUseZtb()
    {
        return $this->useZtb;
    }

	public function setUseZtb($useZtb)
    {
        $this->useZtb = $useZtb;
        return $this;
    }

	public function getContainer()
    {
        return $this->container;
    }

	public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }
}
