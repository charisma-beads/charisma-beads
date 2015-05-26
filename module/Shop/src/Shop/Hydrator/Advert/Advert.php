<?php
namespace Shop\Hydrator\Advert;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\TrueFalse;

class Advert extends AbstractHydrator
{
    public function __construct()
    {
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
