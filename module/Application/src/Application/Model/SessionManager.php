<?php

namespace Application\Model;

class SessionManager extends AbstractModel
{
	protected $classMap = array(
		'gateways' => array(
			'session' => 'Application\Model\DbTable\SessionTable',
		),
		'entities' => array(
			'session' => 'Application\Model\Entity\SessionEntity',
		),
	);
	
	public function getSessionById($id)
	{
		$id = (string) $id;
		return $this->getGateway('session')->getById($id);
	}
	
	public function fetchAllSessions($post = array())
	{
		return $this->getGateway('session')->fetchAllSessions($post);
	}
	
	public function deleteSession($id)
	{
		$id = (string) $id;
		\FB::info($id);
		return $this->getGateway('session')->delete($id);
	}
}
