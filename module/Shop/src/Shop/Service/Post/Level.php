<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

class Level extends AbstractMapperService
{
	protected $mapperClass = 'Shop\Mapper\Post\Level';
	protected $form = 'Shop\Form\Post\Level';
	protected $inputFilter = 'Shop\InputFilter\Post\Level';

    protected $serviceAlias = 'ShopPostLevel';
	
}
