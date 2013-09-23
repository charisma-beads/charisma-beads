<?php

namespace Application\Model;

class SessionManager extends AbstractMapper
{	
	/**
	 * @var Application\Model\DbTable\Session
	 */
	protected $sessionGateway;
	
	public function getSessionById($id)
	{
		$id = (string) $id;
		
		return $this->getSessionGateway()->getById($id);
	}
	
	public function fetchAllSessions($post = array())
	{
		return $this->getSessionGateway()->fetchAllSessions($post);
	}
	
	public function deleteSession($id)
	{
		$id = (string) $id;
		return $this->getSessionGateway()->delete($id);
	}
	
	/**
	 * @return \Application\Model\DbTable\Session
	 */
	protected function getSessionGateway()
	{
		if (!$this->sessionGateway){
			$sl = $this->getServiceLocator();
			$this->sessionGateway = $sl->get('Application\Gateway\Session');
		}
		 
		return $this->sessionGateway;
	}
}
