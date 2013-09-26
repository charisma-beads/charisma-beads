<?php

namespace Article\Model\Mapper;

use Article\Model\Entity\Article as ArticleEntity;
use Application\Model\AbstractMapper;

class Article extends AbstractMapper
{	
	/**
	 * @var Navigation\Model\Mapper\Page
	 */
	protected $pageMapper;
	
	/**
	 * @var \Article\Model\DbTable\Article
	 */
	protected $articleGateway;
	
	/**
	 * @var \Article\Form\Article
	 */
	protected $articleForm;

	public function getArticleById($id)
	{
		$id = (int) $id;
		return $this->getArticleGateway()->getById($id);
	}
	
	public function getArticleBySlug($slug)
	{
		$slug = (string) $slug;
		return $this->getArticleGateway()->getArticleBySlug($slug);
	}
	
	public function fetchAllArticles()
	{
		return $this->getArticleGateway()->fetchAll();
	}
	
	public function addPageHit(ArticleEntity $page)
	{
		$pageHits = $page->getPageHits();
		$pageHits++;
		$page->setPageHits($pageHits);
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
				
			$this->getPageMapper()->addPage($data);
		}
	}
	
	public function addArticle($post)
	{
		if (!$post['slug']) {
			$post['slug'] = $post['title'];
		}
		
		$form  = $this->getArticleForm();
		$article = new ArticleEntity();
		
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
				
			$this->getPageMapper()->addPage($data);
		}
		
		return $insertId;
	}
	
	public function editArticle(ArticleEntity $article, $post)
	{
		$form  = $this->getArticleForm();
		
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
		        $this->getPageMapper()->addPage($data);
		    } else {
		        $this->getPageMapper()->editPage($page, $data);
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
			$result = $this->getArticleGateway()->insert($data);
		} else {
			if ($this->getArticleById($id)) {
				$result = $this->getArticleGateway()->update($id, $data);
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
		return $this->getArticleGateway()->delete($id);
	}
	
	/**
	 * @return \Article\Form\Article
	 */
	public function getArticleForm()
	{
		if (!$this->articleForm) {
			$sl = $this->getServiceLocator();
			$this->articleForm = $sl->get('Article\Form\Article');
		}
		
		return $this->articleForm;
	}
	
	/**
	 * @return \Article\Model\DbTable\Article
	 */
	protected function getArticleGateway()
	{
		if (!$this->articleGateway) {
			$sl = $this->getServiceLocator();
			$this->articleGateway = $sl->get('Article\Gateway\Article');
		}
		
		return $this->articleGateway;
	}
	
	/**
	 * @return \Navigation\Model\Mapper\Page
	 */
	protected function getPageMapper()
	{
	    if (!$this->pageMapper) {
			$sl = $this->getServiceLocator();
			$this->pageMapper = $sl->get('Navigation\Mapper\Page');
		}
		
		return $this->pageMapper;
	}
}
