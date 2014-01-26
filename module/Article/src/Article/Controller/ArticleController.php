<?php

namespace Article\Controller;

use Article\Form\Article as ArticleForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractActionController
{
	/**
	 * @var \Article\Service\Article;
	 */
	protected $articleService;
	
	public function viewAction()
	{
		$slug = $this->params()->fromRoute('slug');
		$page = $this->getArticleService()->getArticleBySlug($slug);
		
		if (!$page) {
			$model = new ViewModel();
			$model->setTemplate('article/article/404');
			return $model;
		}
		
		$this->getArticleService()->addPageHit($page);
		
		return new ViewModel(array(
            'page' => $page
        ));
	}
	
	public function listAction()
	{
		return new ViewModel(array(
			'articles' => $this->getArticleService()->fetchAll()
		));
	}
	
	public function addAction()
	{
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$result = $this->getArticleService()->add($request->getPost());
			
			if ($result instanceof ArticleForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result
				));
				
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Article has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Article could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/article');
			}
		}
		
		return new ViewModel(array(
			'form' => $this->getArticleService()->getForm()
		));	
	}
	
	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/article', array(
				'action' => 'add'
			));
		}
		
		// Get the Article with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$article = $this->getArticleService()->getById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/article', array(
				'action' => 'list'
			));
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			
			$result = $this->getArticleService()->edit($article, $request->getPost());
			
			if ($result instanceof ArticleForm) {
				
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				
				return new ViewModel(array(
					'form' => $result,
					'article' => $article,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Article has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Article could not be saved due to a database error.'
					);
				}
				
				// Redirect to list of articles
				return $this->redirect()->toRoute('admin/article');
			}
		}
		
		return new ViewModel(array(
            'form' => $this->getArticleService()->getForm($article),
            'article' => $article
        ));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
		
		$id = (int) $request->getPost('articleId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/article');
		}
		
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
		
			if ($del == 'delete') {
				$id = (int) $request->getPost('articleId');
				$result = $this->getArticleService()->delete($id);
				
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Article has been deleted from the database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Article could not be deleted due to a database error.'
					);
				}
			}
		
			// Redirect to list of albums
			return $this->redirect()->toRoute('admin/article');
		}
		
		return $this->redirect()->toRoute('admin/article');
	}
	
	/**
	 * @return \Article\Service\Article
	 */
	protected function getArticleService()
	{
		if (!$this->articleService) {
			$sl = $this->getServiceLocator();
			$this->articleService = $sl->get('Article\Service\Article');
		}
		
		return $this->articleService;
	}
}
