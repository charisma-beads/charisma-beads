<?php
namespace Navigation\Service;

use Application\Service\AbstractService;
use Navigation\Model\Page as PageModel;
use Exception;

class Page extends AbstractService
{
	protected $mapperClass = 'Navigation\Mapper\Page';
	protected $form = 'Navigation\Form\Page';
	protected $inputFilter = 'Navigation\InputFilter\Page';
	
	public function getPageByMenuIdAndLabel($menuId, $label)
	{
		$menuId = (int) $menuId;
		$label = (string) $label;
	
		return $this->getMapper()->getPageByMenuIdAndLabel($menuId, $label);
	}
	
	public function getPagesByMenuId($id)
	{
		$id = (int) $id;
		return $this->getMapper()->getPagesByMenuId($id);
	}
	
	public function getPagesByMenu($menu)
	{
		$menu = (string) $menu;
		return $this->getMapper()->getPagesByMenu($menu);
	}
	
	public function add($post)
	{
		$page = $this->getMapper()->getModel();
		$form  = $this->getForm($page, $post);
		$position = (int) $post['position'];
		$insertType = (string) $post['menuInsertType'];
	
		if (!$form->isValid()) {
			return $form;
		}
		
		$data = $this->getMapper()->extract($form->getData());
		
		return $this->getMapper()->insert($data, $position, $insertType);
	}
	
	public function edit(PageModel $page, $post)
	{
		$form  = $this->getForm($page, $post);
	
		if (!$form->isValid()) {
			return $form;
		}
		
		$page = $this->getById($page->getPageId());
	
		if ($page) {
			// if page postion has changed then we need to delete it
			// and reinsert it in the new position else just update it.
			if ($post['position']) {
				// TODO find children and move them as well.
				$del = $this->delete($page->getPageId());
	
				if ($del) {
					$result = $this->add($post);
				}
			} else {
				$data = $this->getMapper()->extract($form->getData());
				$result = $this->getMapper()->update($page->getPageId(), $data);
			}
		} else {
			throw new Exception('Page id does not exist');
		}
	
		return $result;
	}
}
