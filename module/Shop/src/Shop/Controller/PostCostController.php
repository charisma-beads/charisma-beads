<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Post\Cost as PostCostForm;
use Zend\View\Model\ViewModel;

class PostCostController extends AbstractController
{
	/**
	 * @var \Shop\Service\Post\Cost
	 */
	protected $postCostService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page', 1);
			
		$params = array(
			'sort' => 'cost',
		);
			
		return new ViewModel(array(
			'postCosts' => $this->getPostCostService()->usePaginator(array(
				'limit' => 25,
				'page' => $page
			))->searchCosts($params)
		));
	}
	
	public function listAction()
	{
		if (!$this->getRequest()->isXmlHttpRequest()) {
			return $this->redirect()->toRoute('admin/shop/post/cost');
		}
			
		$params = $this->params()->fromPost();
			
		$viewModel = new ViewModel(array(
			'postCosts' => $this->getPostCostService()->usePaginator(array(
				'limit' => $params['count'],
				'page' => $params['page']
			))->searchCosts($params)
		));
			
		$viewModel->setTerminal(true);
			
		return $viewModel;
	}
	
	public function addAction()
	{
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostCostService()->add($request->getPost());
	
			if ($result instanceof PostCostForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form' => $result
				));
					
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Post Cost has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Post Cost could not be saved due to a database error.'
					);
				}
	
				return $this->redirect()->toRoute('admin/shop/post/cost');
			}
		}
			
		return new ViewModel(array(
			'form' => $this->getPostCostService()->getForm(),
		));
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/cost', array(
				'action' => 'add'
			));
		}
	
		try {
			$postCost = $this->getPostCostService()->getById($id);
		} catch (\Exception $e) {
			$this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/post/cost', array(
				'action' => 'list'
			));
		}
			
		$request = $this->getRequest();
			
		if ($request->isPost()) {
	
			$result = $this->getPostCostService()->edit($postCost, $request->getPost());
	
			if ($result instanceof PostCostForm) {
					
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
					
				return new ViewModel(array(
					'form'		=> $result,
					'postCost'	=> $postCost,
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
	
				return $this->redirect()->toRoute('admin/shop/post/cost');
			}
		}
			
		$form = $this->getPostCostService()->getForm($postCost);
			
		return new ViewModel(array(
			'form'		=> $form,
			'postCost'	=> $postCost,
		));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
			
		$id = (int) $request->getPost('postCostId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/post/cost');
		}
			
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
	
			if ($del == 'delete') {
				try {
					$id = (int) $request->getPost('postCostId');
					$result = $this->getPostCostService()->delete($id);
	
					if ($result) {
						$this->flashMessenger()->addSuccessMessage(
							'Post Cost has been deleted from the database.'
						);
					} else {
						$this->flashMessenger()->addErrorMessage(
							'Post Cost could not be deleted due to a database error.'
						);
					}
				} catch (\Exception $e) {
					$this->setExceptionMessages($e);
				}
			}
		}
			
		return $this->redirect()->toRoute('admin/shop/post/cost');
	}
	
	/**
	 * @return \Shop\Service\Post\Cost
	 */
	protected function getPostCostService()
	{
		if (null === $this->postCostService) {
			$sl = $this->getServiceLocator();
			$this->postCostService = $sl->get('Shop\Service\PostCost');
		}
	
		return $this->postCostService;
	}
}
