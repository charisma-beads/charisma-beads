<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Post;

use UthandoCommon\Hydrator\AbstractHydrator;

/**
 * Class Unit
 *
 * @package Shop\Hydrator\Post
 */
class Unit extends AbstractHydrator
{
	/**
	 * @param \Shop\Model\Post\Unit $object
	 * @return array $data
	 */
	public function extract($object)
	{
		return [
			'postUnitId'	    => $object->getPostUnitId(),
			'postUnit'			=> $object->getPostUnit()
        ];
	}
}
