<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Tax
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Tax;

use UthandoCommon\Hydrator\AbstractHydrator;
use Shop\Hydrator\Strategy\Percent;

/**
 * Class Rate
 *
 * @package Shop\Hydrator\Tax
 */
class Rate extends AbstractHydrator
{
    public Function __construct()
    {
    	parent::__construct();
    
    	$this->addStrategy('taxRate', new Percent());
    }
    
	/**
	 * @param \Shop\Model\Tax\Rate $object
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
