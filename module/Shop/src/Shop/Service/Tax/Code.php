<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Code
 *
 * @package Shop\Service\Tax
 */
class Code extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopTaxCode';
    
    protected $tags = [
        'tax-code', 'tax-rate',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'taxRate'   => [
            'refCol'    => 'taxRateId',
            'service'   => 'ShopTaxRate',
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
