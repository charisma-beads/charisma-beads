<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Zone extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\Post\Zone';
	protected $form = 'Shop\Form\Post\Zone';
	protected $inputFilter = 'Shop\InputFilter\Post\Zone';
}
