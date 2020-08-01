<?php

namespace Mail\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\Serialize;

class MailQueueHydrator extends AbstractHydrator
{
    /**
     * Constructor
     */
    public Function __construct()
    {
        parent::__construct();

        $serialize = new Serialize();

        $this->addStrategy('dateCreated', new DateTimeStrategy());
        $this->addStrategy('layout', $serialize);
        $this->addStrategy('body', $serialize);
        $this->addStrategy('sender', $serialize);
        $this->addStrategy('recipient', $serialize);

    }

    /**
     * @param \Mail\Model\MailQueueModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'mailQueueId'   => $object->getMailQueueId(),
            'recipient'     => $this->extractValue('recipient', $object->getRecipient()),
            'sender'        => $this->extractValue('sender', $object->getSender()),
            'subject'       => $object->getSubject(),
            'body'          => $this->extractValue('body', $object->getBody()),
            'layout'        => $this->extractValue('layout', $object->getLayout()),
            'transport'     => $object->getTransport(),
            'renderer'      => $object->getRenderer(),
            'priority'      => $object->getPriority(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];

    }
}
