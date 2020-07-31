<?php

namespace Shop\Hydrator;

use PayPal\Api\Item;
use PayPal\Api\ItemList as PalPayItemList;
use Laminas\Hydrator\AbstractHydrator;

/**
 * Class ItemList
 *
 * @package Shop\Hydrator
 */
class PaypalItemListHydrator extends AbstractHydrator
{
    /**
     * @param array $data
     * @param PaypalItemListHydrator $object
     * @return PaypalItemListHydrator $object
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
     * @param PaypalItemListHydrator $object
     * @return array|PaypalItemListHydrator
     */
    public function extract($object)
    {
    	if (!$object instanceof PalPayItemList) {
    		return $object;
    	}
        
    	return $object->toArray();
    }
}
