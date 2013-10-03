<?php

namespace Navigation\Service;

use Application\Service\AbstractService;

class Menu extends AbstractService
{	
	protected $mapperClass = 'Navigation\Mapper\Menu';
	protected $form = 'Navigation\Form\Menu';
	protected $inputFilter = 'Navigation\InputFilter\Menu';
	
	public function getMenu($menuName)
	{
		$menuName = (string) $menuName;
		return $this->getMapper()->getMenu($menuName);
	}
}
