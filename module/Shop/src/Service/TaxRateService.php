<?php

namespace Shop\Service;

use Shop\Form\TaxRateForm;
use Shop\Hydrator\TaxRateHydrator;
use Shop\InputFilter\TaxRateInputFilter;
use Shop\Mapper\TaxRateMapper;
use Shop\Model\TaxRateModel;
use Common\Service\AbstractMapperService;

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
