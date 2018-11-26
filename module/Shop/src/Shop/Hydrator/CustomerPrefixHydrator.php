<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Prefix
 *
 * @package Shop\Hydrator
 */
class CustomerPrefixHydrator extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\CustomerPrefixModel $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'prefixId'   => $object->getPrefixId(),
		    'prefix'     => $object->getPrefix()
        ];
	}
}
