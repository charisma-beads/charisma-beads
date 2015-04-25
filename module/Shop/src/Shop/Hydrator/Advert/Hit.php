<?php
namespace Shop\Hydrator\Advert;

use UthandoCommon\Hydrator\AbstractHydrator;
use UthandoCommon\Hydrator\Strategy\DateTime as DateTimeStrategy;

class Hit extends AbstractHydrator
{
    public function __construct()
    {
        $this->addStrategy('dateCreated', new DateTimeStrategy());
    }
    
    /**
     * @param \Shop\Model\Advert\Hit $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'advertHitId'   => $object->getAdvertHitId(),
            'advertId'      => $object->getAdvertId(),
            'userId'        => $object->getUserId(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];
    }
}
