<?php

namespace Shop\Service;

use Shop\Form\ProductGroupForm;
use Shop\Hydrator\ProductGroupHydrator;
use Shop\InputFilter\ProductGroupInputFilter;
use Shop\Mapper\ProductGroupMapper;
use Shop\Model\ProductGroupModel;
use Common\Service\AbstractMapperService;
use Laminas\EventManager\Event;

/**
 * Class Group
 *
 * @package Shop\Service
 */
class ProductGroupService extends AbstractMapperService
{
    protected $form         = ProductGroupForm::class;
    protected $hydrator     = ProductGroupHydrator::class;
    protected $inputFilter  = ProductGroupInputFilter::class;
    protected $mapper       = ProductGroupMapper::class;
    protected $model        = ProductGroupModel::class;
    
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
        /* @var $model \Shop\Model\ProductGroupModel */
        $from = $e->getParam('form');
        $model = $from->getData();
        
        $this->getMapper()->updateGroupProductPrices(
            $model->getProductGroupId(), 
            $model->getPrice()
        );
    }
}
