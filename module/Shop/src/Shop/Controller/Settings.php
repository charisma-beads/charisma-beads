<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Zend\Config\Writer\PhpArray;

class Settings extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('ShopSettings');
        
        $prg = $this->prg();
        
        $config = $this->getServiceLocator()->get('config');
        $settings = $config['shop'];
        
        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            $form->setData($settings);
            return ['form' => $form,]; 
        }
        
        $form->setData($prg);
        
        if ($form->isValid()) {
            $array = $form->getData();
            unset($array['button-submit']);
            
            $config = new PhpArray();
            $config->toFile('./config/autoload/shop.local.php', ['shop' => $array]);
            
            $this->flashMessenger()->addSuccessMessage('Settings have been updated!');
            
            //return $this->redirect()->toRoute('admin/shop/settings');
        }
        
        return ['form' => $form,];
    }
}
