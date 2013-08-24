<?php

namespace Article\Form;

use Zend\Form\Form;

class ArticleForm extends Form
{
	public function __construct()
	{
		parent::__construct('Article');
		
		$this->add(array(
			'name' => 'articleId',
			'type' => 'hidden',
		));
		
		$this->add(array(
		    'name' => 'title',
		    'type' => 'text',
		    'options' => array(
				'label' => 'Title:',
				'required' => true,
			),
			'attributes' => array(
			    'placeholder' => 'Article Title:',
			),
		));
		
		$this->add(array(
		    'name' => 'slug',
		    'type' => 'text',
		    'options' => array(
		        'label' => 'Slug:',
		        'required' => false,
		    	'help-inline' => 'If you leave this blank the the title will be used for the slug.'
		    ),
		    'attributes' => array(
		        'placeholder' => 'Slug:',
		    ),
		));
		
		$this->add(array(
		    'name' => 'content',
		    'type' => 'textarea',
		    'options' => array(
		        'label' => 'HTML Content:'
		    ),
		    'attributes' => array(
		        'placeholder' => 'HTML Content:',
		        'class' => 'editable-textarea',
		    	'id' => 'article-content-textarea'
		    ),
		));
		
		$this->add(array(
		    'name' => 'keywords',
		    'type' => 'text',
		    'options' => array(
				'label' => 'Keywords:',
			),
			'attributes' => array(
			    'placeholder' => 'Article Keywords:',
			),
		));
		
		$this->add(array(
		    'name' => 'description',
		    'type' => 'text',
		    'options' => array(
				'label' => 'Description:',
			),
			'attributes' => array(
			    'placeholder' => 'Description:',
			),
		));
		
		$this->add(array(
			'name' => 'pageHits',
			'type' => 'hidden',
		));
	}
}
