<?php

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\TrueFalse;

/**
 * Class Advert
 *
 * @package Shop\Hydrator
 */
class AdvertHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('enabled', new TrueFalse());
    }
    
    /**
     * @param \Shop\Model\AdvertModel $object
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
