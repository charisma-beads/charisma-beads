<?php

namespace Events\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime;


class EventsHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('dateTime', new DateTime());
    }

    /**
     * @param \Events\Model\EventModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'eventId'       => $object->getEventId(),
            'title'         => $object->getTitle(),
            'description'   => $object->getDescription(),
            'html'          => $object->getHtml(),
            'dateTime'      => $this->extractValue('dateTime', $object->getDateTime()),
        ];
    }
}
