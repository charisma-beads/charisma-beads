<?php
namespace Application\Model;

class AbstractModel
{	
	public function has($prop)
	{
		$getter = 'get' . ucfirst($prop);
		
		return method_exists($this, $getter);
	}
}
