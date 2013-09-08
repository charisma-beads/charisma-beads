<?php

namespace Article\Model;

use Article\Model\Entity\ArticleEntity;
use Application\Model\AbstractModel;

class Article extends AbstractModel
{
	protected $classMap = array(
		'gateways' => array(
			'article' => 'Article\Model\DbTable\ArticleTable',
		),
		'entities' => array(
			'article' => 'Article\Model\Entity\ArticleEntity',
		),
		'forms' => array(
			'article' => 'Article\Form\ArticleForm'
		)
	);
	
	/*
	 * @var Navigation\Model\Navigation
	 */
	protected $navigation;

	public function getArticleById($id)
	{
		$id = (int) $id;
		return $this->getGateway('article')->getById($id);
	}
	
	public function getArticleBySlug($slug)
	{
		$slug = (string) $slug;
		return $this->getGateway('article')->getArticleBySlug($slug);
	}
	
	public function fetchAllArticles()
	{
		return $this->getGateway('article')->fetchAll();
	}
	
	public function addPageHit(ArticleEntity $page)
	{
		$page->pageHits++;
		$this->saveArticle($page);
	}
	
	protected function savePage($insertId, $article, $post)
	{
		if ($insertId && $post['position']) {
				
			$ids = split('-', $post['position']);
			$data = array(
				'menuId' => $ids[0],
				'label' => $article->title,
				'position' => $ids[1],
				'params' => 'slug=' . $article->slug,
				'route' => 'application/article',
				'resource' => '',
				'visible' => 1,
				'menuInsertType' => $post['menuInsertType']
			);
				
			$this->getNavigation()->addPage($data);
		}
	}
	
	public function addArticle($post)
	{
		if (!$post['slug']) {
			$post['slug'] = $post['title'];
		}
		
		$form  = $this->getForm('article');
		$article = $this->getEntity('article');
		$article->setColumns($this->getGateway('article')->getColumns());
		
		$form->setInputFilter($article->getInputFilter());
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$article->exchangeArray($form->getData());
		
		$insertId = $this->saveArticle($article);
		
		if ($insertId && $post['position'] && $post['menuInsertType'] != 'noInsert') {
				
			$ids = split('-', $post['position']);
			$data = array(
				'menuId' => $ids[0],
				'label' => $article->title,
				'position' => $ids[1],
				'params' => 'slug=' . $article->slug,
				'route' => 'application/article',
				'resource' => '',
				'visible' => 1,
				'menuInsertType' => $post['menuInsertType']
			);
				
			$this->getNavigation()->addPage($data);
		}
		
		return $insertId;
	}
	
	public function editArticle(ArticleEntity $article, $post)
	{
		$form  = $this->getForm('article');
		
		$form->setInputFilter($article->getInputFilter());
		$form->bind($article);
		$form->setData($post);
		
		if (!$form->isValid()) {
			return $form;
		}
		
		$insertId = $this->saveArticle($form->getData());
		
		// find page first, if exists delete it before updating.
		
		if ($insertId && $post['position'] && $post['menuInsertType'] != 'noInsert') {
		
		    $ids = split('-', $post['position']);
		    $data = array(
		        'menuId' => $ids[0],
		        'label' => $article->title,
		        'position' => $ids[1],
		        'params' => 'slug=' . $article->slug,
		        'route' => 'application/article',
		        'resource' => '',
		        'visible' => 1,
		        'menuInsertType' => $post['menuInsertType']
		    );
		    
		    $page = $this->getNavigation()->getPageByMenuIdAndLabel($ids[0], $article->title);
		    
		    if (!$page) {
		        $this->getNavigation()->addPage($data);
		    } else {
		        $this->getNavigation()->editPage($page, $data);
		    }
		}
		
		return $insertId;
	}
	
	public function saveArticle(ArticleEntity $article)
	{
		$id = (int) $article->articleId;
		$data = $article->getArrayCopy();
		
		if (0 === $id) $data['dateCreated'] = $this->currentDate();
		$data['dateModified'] = $this->currentDate();
	
		if (0 === $id) {
			$result = $this->getGateway('article')->insert($data);
		} else {
			if ($this->getArticleById($id)) {
				$result = $this->getGateway('article')->update($id, $data);
			} else {
				throw new \Exception('Article id does not exist');
			}
		}
	
		return $result;
	}
	
	public function deleteArticle($id)
	{
		$id = (int) $id;
		
		// find all links in menus first, if exists delete them before after deleting.
		return $this->getGateway('article')->delete($id);
	}
	
	/**
	 * @return \Article\Model\Article
	 */
	protected function setNavigation()
	{
	    $this->navigation = $this->getServiceLocator()->get('Navigation\Model\Navigation');
	    return $this;
	}
	
	/**
	 * @return \Navigation\Model\Navigation
	 */
	protected function getNavigation()
	{
	    if (!$this->navigation) {
	        $this->setNavigation();
	    }
	    
	    return $this->navigation;
	}
}
