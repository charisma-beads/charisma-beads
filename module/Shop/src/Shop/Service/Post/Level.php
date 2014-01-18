<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Level extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostLevel';
	protected $form = 'Shop\Form\PostLevel';
	protected $inputFilter = 'Shop\InputFilter\PostLevel';
	
}
