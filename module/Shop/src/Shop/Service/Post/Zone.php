<?php

namespace Shop\Service\Post;

use UthandoCommon\Service\AbstractMapperService;

class Zone extends AbstractMapperService
{
	protected $mapperClass = 'Shop\Mapper\Post\Zone';
	protected $form = 'Shop\Form\Post\Zone';
	protected $inputFilter = 'Shop\InputFilter\Post\Zone';

    protected $serviceAlias = 'ShopPostZone';
	
}
