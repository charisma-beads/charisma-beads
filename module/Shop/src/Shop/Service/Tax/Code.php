<?php
namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Code extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopTaxCode';

    /**
     * @var array
     */
    protected $referenceMap = [
        'taxRate'   => [
            'refCol'    => 'taxRateId',
            'service'   => 'Shop\Service\Tax\Rate',
        ],
    ];

    /**
     * @param int $id
     * @param null $col
     * @return array|mixed|\UthandoCommon\Model\ModelInterface
     */
    public function getById($id, $col = null)
    {
        $taxCode = parent::getById($id, $col);
        
        $this->populate($taxCode, true);
        
        return $taxCode;
    }
}
