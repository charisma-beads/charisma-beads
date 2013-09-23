<?php
namespace Navigation\Model\Mapper;

use Application\Model\AbstractMapper;
use Navigation\Model\Entity\Page as PageEntity;
use Zend\Form\FormInterface;
use Exception;

class Page extends AbstractMapper
{
	/**
	 * @var \Navigation\Model\DbTable\Page
	 */
	protected $pageGateway;
	
	/**
	 * @var \Navigation\Form\Page
	 */
	protected $pageForm;
	
	public function getPageById($id)
	{
		$id = (int) $id;
		return $this->getPageGateway()->getById($id);
	}
	
	public function getPageByMenuIdAndLabel($menuId, $label)
	{
		$menuId = (int) $menuId;
		$label = (string) $label;
	
		return $this->getPageGateway()->getPageByMenuIdAndLabel($menuId, $label);
	}
	
	public function getPagesByMenuId($id)
	{
		$id = (int) $id;
		return $this->getPageGateway()->getPagesByMenuId($id);
	}
	
	public function addPage($post)
	{
		$form  = $this->getPageForm();
		$page = new PageEntity();
		$position = (int) $post['position'];
		$insertType = (string) $post['menuInsertType'];
	
		$form->setInputFilter($page->getInputFilter());
	
		$form->setData($post);
	
		if (!$form->isValid()) {
			return $form;
		}
	
		$page->exchangeArray($form->getData(FormInterface::VALUES_AS_ARRAY));
	
		return $this->getPageGateway()->insert($page->getArrayCopy(), $position, $insertType);
	}
	
	public function editPage(PageEntity $page, $post)
	{
		$form  = $this->getPageForm();
	
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
				$page = $form->getData();
				$result = $this->getPageGateway()->update($page->pageId, $page->getArrayCopy());
			}
		} else {
			throw new Exception('Page id does not exist');
		}
	
		return $result;
	}
	
	public function deletePage($id)
	{
		$id = (int) $id;
		return $this->getPageGateway()->delete($id);
	}
	
	/**
	 * @return \Navigation\From\Page
	 */
	public function getPageForm()
	{
		if (!$this->pageForm) {
			$sl = $this->getServiceLocator();
			$this->pageForm = $sl->get('Navigation\Form\Page');
		}
	
		return $this->pageForm;
	}
	
	/**
	 * @return \Navigation\Model\DbTable\Page
	 */
	protected function getPageGateway()
	{
		if (!$this->pageGateway) {
			$sl = $this->getServiceLocator();
			$this->pageGateway = $sl->get('Navigation\Gateway\Page');
		}
	
		return $this->pageGateway;
	}
}
