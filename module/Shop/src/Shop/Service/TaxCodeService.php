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

use Shop\Form\TaxCodeForm;
use Shop\Hydrator\TaxCodeHydrator;
use Shop\InputFilter\TaxCodeInputFilter;
use Shop\Mapper\TaxCodeMapper;
use Shop\Model\TaxCodeModel;
use Common\Service\AbstractRelationalMapperService;

/**
 * Class Code
 *
 * @package Shop\Service
 */
class TaxCodeService extends AbstractRelationalMapperService
{
    protected $form         = TaxCodeForm::class;
    protected $hydrator     = TaxCodeHydrator::class;
    protected $inputFilter  = TaxCodeInputFilter::class;
    protected $mapper       = TaxCodeMapper::class;
    protected $model        = TaxCodeModel::class;
    
    protected $tags = [
        'tax-code', 'tax-rate',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'taxRate'   => [
            'refCol'    => 'taxRateId',
            'service'   => TaxRateService::class,
        ],
    ];

    /**
     * @param int $id
     * @param null $col
     * @return array|mixed|\Common\Model\ModelInterface
     */
    public function getById($id, $col = null)
    {
        $taxCode = parent::getById($id, $col);
        
        $this->populate($taxCode, true);
        
        return $taxCode;
    }
}
