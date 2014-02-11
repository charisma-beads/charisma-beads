<?php

namespace Article\Service;

use Article\Model\Article as ArticleModel;
use Application\Service\AbstractService;
use Application\Model\ModelInterface;
use Zend\Form\Form;

class Article extends AbstractService
{	
	/**
	 * @var Navigation\Service\Page
	 */
	protected $pageService;
	
	protected $mapperClass = 'Article\Mapper\Article';
	protected $form = 'Article\Form\Article';
	protected $inputFilter = 'Article\InputFilter\Article';
	
	public function getArticleBySlug($slug)
	{
		$slug = (string) $slug;
		return $this->getMapper()->getArticleBySlug($slug);
	}
	
	public function addPageHit(ArticleModel $page)
	{
		$pageHits = $page->getPageHits();
		$pageHits++;
		$page->setPageHits($pageHits);
		$this->save($page);
	}
	
	protected function savePage($article, $post)
	{
	    if ($post['position'] && $post['menuInsertType'] != 'noInsert') {
    		$ids = split('-', $post['position']);
    		$data = array(
    			'menuId' => $ids[0],
    			'label' => $article->getTitle(),
    			'position' => $ids[1],
    			'params' => 'slug=' . $article->getSlug(),
    			'route' => 'article',
    			'resource' => '',
    			'visible' => 1,
    			'menuInsertType' => $post['menuInsertType']
    		);
    			
    		$page = $this->getPageService()->getPageByMenuIdAndLabel($ids[0], $article->getTitle());
    		    
    	    if (!$page) {
    	        $this->getPageService()->add($data);
    	    } else {
    	        $this->getPageService()->edit($page, $data);
    	    }
        }
	}
	
	public function add(array $post)
	{
		if (!$post['slug']) {
			$post['slug'] = $post['title'];
		}
		
		$insertId = parent::add($post);
		
		if ($insertId) {
    		$pageResult = $this->savePage(
    		    $this->getById($insertId),
    		    $post
    		);
    	}
		
		return $insertId;
	}
	
	public function edit(ModelInterface $article, array $post, Form $form = null)
	{
		
		$result = parent::edit($article, $post);
		
		// find page first, if exists delete it before updating.
		
		if ($result) {
		    $pageResult = $this->savePage(
		        $this->getById($article->getArticleId()), $post
	        );
		}
		
		return $result;
	}
	
	/**
	 * @return \Navigation\Service\Page
	 */
	protected function getPageService()
	{
	    if (!$this->pageService) {
			$sl = $this->getServiceLocator();
			$this->pageService = $sl->get('Navigation\Service\Page');
		}
		
		return $this->pageService;
	}
}
