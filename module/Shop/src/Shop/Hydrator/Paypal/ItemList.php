<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Paypal
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Paypal;

use PayPal\Api\Item;
use PayPal\Api\ItemList as PalPayItemList;
use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Class ItemList
 *
 * @package Shop\Hydrator\Paypal
 */
class ItemList extends AbstractHydrator
{
    /**
     * @param array $data
     * @param ItemList $object
     * @return ItemList $object
     */
    public function hydrate(array $data, $object)
    {
    	if (!$object instanceof PalPayItemList) {
    		return $object;
    	}
    	
        $itemList = $data['transactions'][0]['itemList'];
        
        $items = [];
        
        foreach ($itemList['items'] as $item) {
            $itemHydrator = new PaypalHydrator('item');
            $items[] = $itemHydrator->hydrate($item, new Item());
        }
        
        $itemList['items'] = $items;
        
        $object->fromArray($itemList);
    
    	return $object;
    }
    
    /**
     * @param ItemList $object
     * @return array
     */
    public function extract($object)
    {
    	if (!$object instanceof PalPayItemList) {
    		return $object;
    	}
        
    	return $object->toArray();
    }
}
