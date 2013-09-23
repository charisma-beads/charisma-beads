<?php
namespace Application\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class SessionFactory extends  AbstractDbTableFactory
{
	protected function getName() 
	{
		return 'Application\Model\DbTable\Session';		
	}
}
