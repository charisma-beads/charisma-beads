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

use Shop\Form\ProductSizeForm;
use Shop\Hydrator\ProductSizeHydrator;
use Shop\InputFilter\ProductSizeInputFilter;
use Shop\Mapper\ProductSizeMapper;
use Shop\Model\ProductSizeModel;
use UthandoCommon\Service\AbstractMapperService;

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
