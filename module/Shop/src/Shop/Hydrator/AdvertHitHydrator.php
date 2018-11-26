<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

/**
 * Class Hit
 *
 * @package Shop\Hydrator
 */
class AdvertHitHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('dateCreated', new DateTimeStrategy());
    }
    
    /**
     * @param \Shop\Model\AdvertHitModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'advertHitId'   => $object->getAdvertHitId(),
            'advertId'      => $object->getAdvertId(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];
    }
}
