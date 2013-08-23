<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Users for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;

use Application\Controller\AbstractController;
use Zend\View\Helper\ViewModel;

class UserController extends AbstractController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function registerAction()
    {
        return new ViewModel();
    }
    
    public function listAction()
    {
        return new ViewModel();
    }
    
    public function addAction()
    {
        return new ViewModel();
	}
	
	public function editAction()
	{
	    return new ViewModel();
	}

	public function deleteAction()
	{
	    return new ViewModel();
	}
}
