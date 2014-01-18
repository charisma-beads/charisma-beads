<?php

namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Zone extends AbstractService
{
	protected $mapperClass = 'Shop\Mapper\PostZone';
	protected $form = 'Shop\Form\PostZone';
	protected $inputFilter = 'Shop\InputFilter\PostZone';
	
}
