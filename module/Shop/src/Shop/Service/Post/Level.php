<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractService;

class Level extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\Post\Level';
	protected $form = 'Shop\Form\Post\Level';
	protected $inputFilter = 'Shop\InputFilter\Post\Level';
	
}
