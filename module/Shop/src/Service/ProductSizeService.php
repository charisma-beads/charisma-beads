<?php

namespace Shop\Service;

use Shop\Form\ProductSizeForm;
use Shop\Hydrator\ProductSizeHydrator;
use Shop\InputFilter\ProductSizeInputFilter;
use Shop\Mapper\ProductSizeMapper;
use Shop\Model\ProductSizeModel;
use Common\Service\AbstractMapperService;

/**
 * Class Size
 *
 * @package Shop\Service
 */
class ProductSizeService extends AbstractMapperService
{
    protected $form         = ProductSizeForm::class;
    protected $hydrator     = ProductSizeHydrator::class;
    protected $inputFilter  = ProductSizeInputFilter::class;
    protected $mapper       = ProductSizeMapper::class;
    protected $model        = ProductSizeModel::class;
    
    protected $tags = [
        'size',
    ];
}
