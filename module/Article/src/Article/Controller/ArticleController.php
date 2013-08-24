<?php

namespace Article\Controller;

use Article\Form\ArticleForm;
use Application\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class ArticleController extends AbstractController
{
	public function viewAction()
	{
		$slug = $this->params()->fromRoute('slug');
		$page = $this->getModel('Article\Model\Article')->getArticleBySlug($slug);
		
		if (!$page) {
			$model = new ViewModel();
			$model->setTemplate('article/article/404');
			return $model;
		}
		
		$this->getModel('Article\Model\Article')->addPageHit($page);
		
		return new ViewModel(array(
            'page' => $page
        ));
	}
	
	public function listAction()
	{
		if (!$this->isAllowed('Article', 'view')) {
			return $this->redirect()->toRoute('home');
		}
		
		$this->layout('layout/admin');
		
		return new ViewModel(array(
			'articles' => $this->getModel('Article\Model\Article')->fetchAllArticles()
		));
	}
	
	public function addAction()
	{
		if (!$this->isAllowed('Article', 'add')) {
			return $this->redirect()->toRoute('home');
		}
		
		$this->layout('layout/admin');
		
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$result = $this->getModel('Article\Model\Article')->addArticle($request->getPost());
			
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
			'form' => $this->getModel('Article\Model\Article')->getForm('article'),
		    'pageForm' => $this->getModel('Navigation\Model\Navigation')->getForm('page')
		));	
	}
	
	public function editAction()
	{
		if (!$this->isAllowed('Article', 'edit')) {
			return $this->redirect()->toRoute('home');
		}
		
		$this->layout('layout/admin');
		
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/article', array(
				'action' => 'add'
			));
		}
		
		// Get the Article with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$article = $this->getModel('Article\Model\Article')->getArticleById($id);
		} catch (\Exception $e) {
			return $this->redirect()->toRoute('admin/article', array(
				'action' => 'list'
			));
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			
			$result = $this->getModel('Article\Model\Article')->editArticle($article, $request->getPost());
			
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
            'form' => $this->getModel('Article\Model\Article')->getForm('article')->bind($article),
            'article' => $article
        ));
	}
	
	public function deleteAction()
	{
		if (!$this->isAllowed('Article', 'delete')) {
			return $this->redirect()->toRoute('home');
		}
		
		$request = $this->getRequest();
		
		$id = (int) $request->getPost('articleId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/article');
		}
		
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
		
			if ($del == 'delete') {
				$id = (int) $request->getPost('articleId');
				$result = $this->getModel('Article\Model\Article')->deleteArticle($id);
				
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
}
