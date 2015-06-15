<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Zend\Form\Element\Radio;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class PayOptionsList extends Radio implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function init()
    {
        $options = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Shop\Options\Checkout');
        
        $options = $options->toArray();
        $optionsArray = [];
        
        foreach($options as $key => $value) {
            $ex_key = explode('_', $key);
            
            if ('pay' === $ex_key[0]  && true == $value) {
                $ex_key[0] = $ex_key[0] . ' by';
                $optionsArray[$key] = '<i></i>' . ucwords(implode(' ', $ex_key));
            }
        }
        
        $this->setValueOptions($optionsArray);
    }

}
