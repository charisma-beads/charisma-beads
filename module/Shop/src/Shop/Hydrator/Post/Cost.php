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
 * Class Cost
 *
 * @package Shop\Hydrator\Post
 */
class Cost extends AbstractHydrator
{   
    /**
     * @param \Shop\Model\Post\Cost $object
     * @return array $data
     */
    public function extract($object)
    {
        return [
        	'postCostId'    => $object->getPostCostId(),
            'postLevelId'   => $object->getPostLevelId(),
            'postZoneId'    => $object->getPostZoneId(),
            'cost'          => $object->getCost(),
            'vatInc'        => $object->getVatInc(),
        ];
    }
}
