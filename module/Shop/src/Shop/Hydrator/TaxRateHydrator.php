<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\PercentStrategy;

/**
 * Class Rate
 *
 * @package Shop\Hydrator
 */
class TaxRateHydrator extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    
    	$this->addStrategy('taxRate', new PercentStrategy());
    }
    
	/**
	 * @param \Shop\Model\TaxRateModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'taxRateId'	=> $object->getTaxRateId(),
			'taxRate'	=> $this->extractValue('taxRate', $object->getTaxRate()),
        ];
	}
}
