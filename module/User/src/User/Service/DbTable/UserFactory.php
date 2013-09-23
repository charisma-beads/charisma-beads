<?php
namespace User\Service\DbTable;

use Application\Service\AbstractDbTableFactory;

class UserFactory extends AbstractDbTableFactory
{

	protected function getName()
	{
		return 'User\Model\DbTable\User';
	}
}
