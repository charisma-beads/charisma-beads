<?php
namespace Application\Controller;

use Exception;
use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
    /**
     * stores an array of model instances
     * 
     * @var array
     */
    protected $models = array();
    
    /**
     * Gets a model by its alias.
     * 
     * @param string $model
     * @return \Application\Model\AbstractModel:
     */
    public function getModel($model)
    {
    	if (!isset($this->models[$model])) {
    		$sm = $this->getServiceLocator();
    		$this->models[$model] = $sm->get($model);
    	}
    	return $this->models[$model];
    }
    
    /**
     * Sets a exception message for flash plugin.
     * 
     * @param Exception $exception
     */
    public function setExceptionMessages(Exception $exception)
    {
    	$this->flashMessenger()->addErrorMessage(array(
    			'message' => $exception->getMessage(),
    			'title'   => 'Fatal Error!'
    	));
    
    	$e = $exception->getPrevious();
    		
    	if ($e) {
    		while ($e) {
    			$this->flashMessenger()->addMessage($e->getMessage());
    			$e = $e->getPrevious();
    		}
    	}
    }
}
