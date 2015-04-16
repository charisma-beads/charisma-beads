<?php
namespace Shop\Service\Product;

use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

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
