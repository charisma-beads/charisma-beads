<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\ProductOptionForm;
use Shop\Hydrator\ProductOptionHydrator;
use Shop\InputFilter\ProductOptionInputFilter;
use Shop\Mapper\ProductOptionMapper;
use Shop\Model\ProductOptionModel;
use Common\Service\AbstractRelationalMapperService;

/**
 * Class Option
 *
 * @package Shop\Service
 */
class ProductOptionService extends AbstractRelationalMapperService
{
    protected $form         = ProductOptionForm::class;
    protected $hydrator     = ProductOptionHydrator::class;
    protected $inputFilter  = ProductOptionInputFilter::class;
    protected $mapper       = ProductOptionMapper::class;
    protected $model        = ProductOptionModel::class;
    
    protected $tags = [
        'product', 'post-unit', 'option',
    ];

    protected $referenceMap = [
        'product'   => [
            'refCol'    => 'productId',
            'service'   => ProductService::class,
        ],
        'postUnit'          => [
            'refCol'    => 'postUnitId',
            'service'   => PostUnitService::class,
        ],
    ];

    /**
     * @param $id
     * @return \Zend\Db\ResultSet\HydratingResultSet
     */
    public function getOptionsByProductId($id)
    {
        $id = (int) $id;
        
        $ProductOptions = $this->getCacheItem($id.'-productOptions');

        if (null === $ProductOptions) {
            /* @var $mapper \Shop\Mapper\ProductOptionMapper */
            $mapper = $this->getMapper();
            $options = $mapper->getOptionsByProductId($id);
            
            $ProductOptions = [];
            
            foreach ($options as $row) {
                $ProductOptions[] = $this->populate($row, ['postUnit']);
            }
            
            $this->setCacheItem($id.'-productOptions', $ProductOptions);
        }

        return $ProductOptions;
    }
} 