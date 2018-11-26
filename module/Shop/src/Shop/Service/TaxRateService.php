<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\TaxRateForm;
use Shop\Hydrator\TaxRateHydrator;
use Shop\InputFilter\TaxRateInputFilter;
use Shop\Mapper\TaxRateMapper;
use Shop\Model\TaxRateModel;
use UthandoCommon\Service\AbstractMapperService;

/**
 * Class Rate
 *
 * @package Shop\Service
 */
class TaxRateService extends AbstractMapperService
{
    protected $form         = TaxRateForm::class;
    protected $hydrator     = TaxRateHydrator::class;
    protected $inputFilter  = TaxRateInputFilter::class;
    protected $mapper       = TaxRateMapper::class;
    protected $model        = TaxRateModel::class;
    
    protected $tags = [
        'tax-rate',
    ];
    
}
