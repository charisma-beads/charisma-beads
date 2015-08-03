<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Group
 *
 * @package Shop\Service\Product
 */
class Group extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopProductGroup';
    
    protected $tags = [
        'group', 'product'
    ];
    
    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'post.edit',
        ], [$this, 'updateProductPrices']);
    }
    
    public function updateProductPrices(Event $e)
    {
        /* @var $model \Shop\Model\Product\Group */
        $from = $e->getParam('form');
        $model = $from->getData();
        
        $this->getMapper()->updateGroupProductPrices(
            $model->getProductGroupId(), 
            $model->getPrice()
        );
    }
}
