<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\PhpEnvironment\Response;
use Zend\Config\Writer\PhpArray;

/**
 * Class Settings
 *
 * @package Shop\Controller
 */
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
        }
        
        return ['form' => $form,];
    }
}
