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

/**
 * Class Code
 *
 * @package Shop\Hydrator\Tax
 */
class Code extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Tax\Code $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'taxCodeId'		=> $object->getTaxCodeId(),
			'taxRateId'		=> $object->getTaxRateId(),
			'taxCode'		=> $object->getTaxCode(),
			'description'	=> $object->getDescription()
        ];
	}
}
