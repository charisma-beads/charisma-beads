<?php

namespace Navigation\Service;

use Navigation\Model\Menu as MenuModel;
use Application\Service\AbstractService;
use Exception;

class Menu extends AbstractService
{	
	/**
	 * @var \Navigation\Model\DbTable\Menu
	 */
	protected $menuGateway;
	
	/**
	 * @var \Navigation\Form\Menu
	 */
	protected $menuForm;

	public function getMenuById($id)
	{
		$id = (int) $id;
		return $this->getMenuGateway()->getById($id);
	}
	
	public function getPagesByMenu($menuName)
	{
		$menuName = (string) $menuName;
		$menu = $this->getMenuGateway()->getMenu($menuName);
			
		return $this->getPagesByMenuId($menu->menuId);
	}
	
	public function fetchAllMenus()
	{
		return $this->getMenuGateway()->fetchAll();
	}
	
	public function addMenu($post)
	{
		$form  = $this->getMenuForm();
		$menu = new MenuModel();
		
		$form->setInputFilter($menu->getInputFilter());
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$menu->exchangeArray($form->getData());
		
		return $this->saveMenu($menu);
	}
	
	public function editMenu(MenuModel $menu, $post)
	{
		$form  = $this->getMenuForm();
		
		$form->setInputFilter($menu->getInputFilter());
		$form->bind($menu);
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		return $this->saveMenu($form->getData());
	}
	
	public function saveMenu(MenuModel $menu)
	{
		$id = (int) $menu->menuId;
		$data = $menu->getArrayCopy();
		
		// time to find lft and rgt values
		if (0 === $id) {
			$result = $this->getMenuGateway()->insert($data);
		} else {
			if ($this->getMenuById($id)) {
				$result = $this->getMenuGateway()->update($id, $data);
			} else {
				throw new Exception('Menu id does not exist');
			}
		}
	
		return $result;
	}
	
	public function deleteMenu($id)
	{
		$id = (int) $id;
		return $this->getMenuGateway()->delete($id);
	}
	
	/**
	 * @return \Navigation\Model\DbTable\Menu
	 */
	protected function getMenuGateway()
	{
		if (!$this->menuGateway) {
			$sl = $this->getServiceLocator();
			$this->menuGateway = $sl->get('Navigation\Mapper\Menu');
		}
		
		return $this->menuGateway;
	}
	
	/**
	 * @return \Navigation\From\Menu
	 */
	public function getMenuForm()
	{
		if (!$this->menuForm) {
			$sl = $this->getServiceLocator();
			$this->menuForm = $sl->get('Navigation\Form\Menu');
		}
	
		return $this->menuForm;
	}
}
