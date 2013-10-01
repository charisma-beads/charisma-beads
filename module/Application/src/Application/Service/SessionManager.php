<?php

namespace Application\Service;

class SessionManager extends AbstractService
{	
	public function getSessionById($id)
	{
		$id = (string) $id;
		return $this->getMapper()->getById($id);
	}
	
	public function fetchAllSessions($post = array())
	{
		return $this->getMapper()->fetchAllSessions($post);
	}
	
	public function deleteSession($id)
	{
		$id = (string) $id;
		return $this->getMapper()->delete($id);
	}
	
	/**
	 * @return \Application\Mapper\Session
	 */
	public function getMapper()
	{
		if (!$this->mapper){
			$sl = $this->getServiceLocator();
			$this->mapper = $sl->get('Application\Mapper\Session');
		}
		 
		return $this->mapper;
	}
}
