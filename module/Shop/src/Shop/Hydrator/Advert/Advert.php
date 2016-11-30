<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Hydrator\Advert;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

/**
 * Class Advert
 *
 * @package Shop\Hydrator\Advert
 */
class Advert extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('enabled', new TrueFalse());
    }
    
    /**
     * @param \Shop\Model\Advert\Advert $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'advertId'  => $object->getAdvertId(),
            'advert'    => $object->getAdvert(),
            'enabled'   => $this->extractValue('enabled', $object->isEnabled()),
        ];
    }
}
