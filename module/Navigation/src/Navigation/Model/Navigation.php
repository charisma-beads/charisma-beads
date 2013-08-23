<?php

namespace Navigation\Model;

use Navigation\Model\Entity\MenuEntity;
use Navigation\Model\Entity\PageEntity;
use Application\Model\AbstractModel;
use Zend\Form\FormInterface;

class Navigation extends AbstractModel
{
	protected $classMap = array(
		'gateways' => array(
			'menu' => 'Core\Model\DbTable\MenuTable',
			'page' => 'Core\Model\DbTable\PageTable',
		),
		'entities' => array(
			'menu' => 'Core\Model\Entity\MenuEntity',
			'page' => 'Core\Model\Entity\PageEntity',
		),
		'forms' => array(
			'menu' => 'Core\Form\MenuForm',
			'page' => 'Core\Form\PageForm'
		)
	);

	public function getMenuById($id)
	{
		$id = (int) $id;
		return $this->getGateway('menu')->getById($id);
	}
	
	public function getPageById($id)
	{
		$id = (int) $id;
		return $this->getGateway('page')->getById($id);
	}
	
	public function getPageByMenuIdAndLabel($menuId, $label)
	{
		$menuId = (int) $menuId;
		$label = (string) $label;
		
		return $this->getGateway('page')->getPageByMenuIdAndLabel($menuId, $label);
	}
	
	public function getPagesByMenuId($id)
	{
		$id = (int) $id;
		return $this->getGateway('page')->getPagesByMenuId($id);
	}
	
	public function getPagesByMenu($menuName)
	{
	    $menuName = (string) $menuName;
	    $menu = $this->getGateway('menu')->getMenu($menuName);
	    
	    return $this->getPagesByMenuId($menu->menuId);
	}
	
	public function fetchAllMenus()
	{
		return $this->getGateway('menu')->fetchAll();
	}
	
	public function addMenu($post)
	{
		$form  = $this->getForm('menu');
		$menu = $this->getEntity('menu');
		$menu->setColumns($this->getGateway('menu')->getColumns());
		
		$form->setInputFilter($menu->getInputFilter());
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$menu->exchangeArray($form->getData());
		
		return $this->saveMenu($menu);
	}
	
	public function editMenu(MenuEntity $menu, $post)
	{
		$form  = $this->getForm('menu');
		
		$form->setInputFilter($menu->getInputFilter());
		$form->bind($menu);
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		return $this->saveMenu($form->getData());
	}
	
	public function saveMenu(MenuEntity $menu)
	{
		$id = (int) $menu->menuId;
		$data = $menu->getArrayCopy();
		
		// time to fine lft and rgt values
	
		if (0 === $id) {
			$result = $this->getGateway('menu')->insert($data);
		} else {
			if ($this->getMenuById($id)) {
				$result = $this->getGateway('menu')->update($id, $data);
			} else {
				throw new \Exception('Menu id does not exist');
			}
		}
	
		return $result;
	}
	
	public function deleteMenu($id)
	{
		$id = (int) $id;
		$this->getGateway('page')->deletePagesByMenuId($id);
		return $this->getGateway('menu')->delete($id);
	}
	
	public function addPage($post)
	{
		$form  = $this->getForm('page');
		$page = $this->getEntity('page');
		$page->setColumns($this->getGateway('page')->getColumns());
		$position = (int) $post['position'];
		$insertType = (string) $post['menuInsertType'];
	
		$form->setInputFilter($page->getInputFilter());
		
		$form->setData($post);
	
		if (!$form->isValid()) {
			return $form;
		}
		
		$page->exchangeArray($form->getData(FormInterface::VALUES_AS_ARRAY));
		
		return $this->getGateway('page')->insert($page->getArrayCopy(), $position, $insertType);
	}
	
	public function editPage(PageEntity $page, $post)
	{
		$form  = $this->getForm('page');
	
		$form->setInputFilter($page->getInputFilter());
		$form->bind($page);
		$form->setData($post);
	
		if (!$form->isValid()) {
			return $form;
		}
		
		$page = $this->getPageById($page->pageId);
	
        if ($page) {
            // if page postion has changed then we need to delete it
            // and reinsert it in the new position else just update it.
            if ($post['position']) {
                // TODO find children and move them as well.
                $del = $this->deletePage($page->pageId);
                
                if ($del) {
                    $post = (is_object($post)) ? $post->toArray() : $post;
                    $result = $this->addPage($post);
                }
            } else {
                $result = $this->getGateway('page')->update($page->pageId, $page->getArrayCopy());
            }
		} else {
			throw new \Exception('Page id does not exist');
		}
		
		return $result;
	}
	
	public function deletePage($id)
	{
		$id = (int) $id;
		return $this->getGateway('page')->delete($id);
	}
}
