<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Post\Level as PostLevelForm;
use Zend\View\Model\ViewModel;

class PostLevelController extends AbstractController
{
	/**
	 * @var \Shop\Service\Post\Level
	 */
	protected $postLevelService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page', 1);
			
		$params = array(
			'sort' => 'postLevel',
		);
			
		return new ViewModel(array(
			'postLevels' => $this->getPostLevelService()->usePaginator(array(
				'limit' => 25,
				'page' => $page
			))->searchLevels($params)
		));
	}
	
	public function listAction()
	{
		if (!$this->getRequest()->isXmlHttpRequest()) {
			return $this->redirect()->toRoute('admin/shop/post/level');
		}
			
		$params = $this->params()->fromPost();
			
		$viewModel = new ViewModel(array(
			'postLevels' => $this->getPostLevelService()->usePaginator(array(
				'limit' => $params['count'],
				'page' => $params['page']
			))->searchLevels($params)
		));
			
		$viewModel->setTerminal(true);
			
		return $viewModel;
	}
	
	public function addAction()
	{
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostLevelService()->add($request->getPost());
	
			if ($result instanceof PostLevelForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form' => $result
				));
					
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Post Level has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Post Level could not be saved due to a database error.'
					);
				}
	
				return $this->redirect()->toRoute('admin/shop/post/level');
			}
		}
			
		return new ViewModel(array(
			'form' => $this->getPostLevelService()->getForm(),
		));
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/level', array(
				'action' => 'add'
			));
		}
	
		try {
			$postLevel = $this->getPostLevelService()->getById($id);
		} catch (\Exception $e) {
			$this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/post/level', array(
				'action' => 'list'
			));
		}
			
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostLevelService()->edit($postLevel, $request->getPost());
	
			if ($result instanceof PostLevelForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form'		=> $result,
					'postLevel'	=> $postLevel,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Post Level has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Post Levle could not be saved due to a database error.'
					);
				}
	
				return $this->redirect()->toRoute('admin/shop/post/level');
			}
		}
			
		$form = $this->getPostLevelService()->getForm($postLevel);
			
		return new ViewModel(array(
			'form'		=> $form,
			'postLevel'	=> $postLevel,
		));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
			
		$id = (int) $request->getPost('postLevelId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/level');
		}
			
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
	
			if ($del == 'delete') {
				try {
					$id = (int) $request->getPost('postLevelId');
					$result = $this->getPostLevelService()->delete($id);
	
					if ($result) {
						$this->flashMessenger()->addSuccessMessage(
							'Post Level has been deleted from the database.'
						);
					} else {
						$this->flashMessenger()->addErrorMessage(
							'Post Level could not be deleted due to a database error.'
						);
					}
				} catch (\Exception $e) {
					$this->setExceptionMessages($e);
				}
			}
		}
			
		return $this->redirect()->toRoute('admin/shop/post/level');
	}
	
	/**
	 * @return \Shop\Service\Post\Level
	 */
	protected function getPostLevelService()
	{
		if (null === $this->postLevelService) {
			$sl = $this->getServiceLocator();
			$this->postLevelService = $sl->get('Shop\Service\PostLevel');
		}
	
		return $this->postLevelService;
	}
}
