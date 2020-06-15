<?php

namespace Navigation\Service;

use Common\Service\AbstractMapperService;
use Common\Stdlib\ArrayUtils;
use Navigation\Form\MenuForm;
use Navigation\Hydrator\MenuHydrator;
use Navigation\InputFilter\MenuInputFilter;
use Navigation\Mapper\MenuMapper;
use Navigation\Model\MenuItemModel;
use Navigation\Model\MenuModel;
use Zend\Config\Reader\Ini;
use Zend\Navigation\Navigation;

/**
 * Class Menu
 * @package Navigation\Service
 * @method MenuMapper getMapper($mapperClass = null, array $options = [])
 */
class MenuService extends AbstractMapperService
{
    use NavigationTrait;

    protected $form         = MenuForm::class;
    protected $hydrator     = MenuHydrator::class;
    protected $inputFilter  = MenuInputFilter::class;
    protected $mapper       = MenuMapper::class;
    protected $model        = MenuModel::class;

    /**
     * @var bool
     */
    protected $multiArray;

    /**
     * @param $menuName
     * @return MenuModel
     */
    public function getMenu($menuName)
    {
        $menuName = (string) $menuName;
        return $this->getMapper()->getMenu($menuName);
    }

    /**
     * @param null $menu
     * @param bool|true $multiArray
     * @return Navigation
     */
    public function getPages($menu = null, $multiArray = true)
    {
        /* @var $service MenuItemService */
        $service = $this->getService(MenuItemService::class);

        $config = new Ini();

        if (null === $menu) {
            $pages = $service->fetchAll();
        } else {
            $pages = $service->getMenuItemsByMenu($menu);
        }

        $pageArray = [];

        /* @var $page MenuItemModel */
        foreach ($pages as $page) {
            $p = $page->getArrayCopy();
            $params = $config->fromString($p['params']);

            // need to initialise params array else error occurs
            $p['params'] = [];

            // params contain route params and other element params like:
            // id, class etc.
            foreach ($params as $key => $value) {
                $p[$key] = $value;
            }

            switch ($p['route']) {
                case 'heading':
                    $p['uri'] ='#';
                    unset($p['route']);
                    break;
                case 'link':
                    unset($p['route']);
                    break;
                default:
                    unset($p['uri']);
                    break;
            }

            if ($p['resource'] == null) {
                unset($p['resource']);
            }

            $pageArray[] = $p;
        }

        if ($multiArray) {
            $pageArray = ArrayUtils::listToMultiArray($pageArray);
        }

        return new Navigation($this->preparePages($pageArray));
    }
}
