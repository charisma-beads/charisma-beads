<?php
namespace Mail\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
 
class MailQueueController extends AbstractActionController
{
    public function sendAction()
    {
        $request = $this->getRequest();
        
        if (!$request instanceof ConsoleRequest){
            throw new \RuntimeException('You can only use this action from a console!');
        }
 
        return "Sending mail queue\r\n";
    }
}
