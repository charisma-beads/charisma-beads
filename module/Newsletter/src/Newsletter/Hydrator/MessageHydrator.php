<?php

namespace Newsletter\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\TrueFalse;


class MessageHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $dateTime = new DateTimeStrategy();
        $this->addStrategy('sent', new TrueFalse());
        $this->addStrategy('dateCreated', $dateTime);
        $this->addStrategy('dateSent', $dateTime);
    }

    /**
     * @param \Newsletter\Model\MessageModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'messageId'     => $object->getMessageId(),
            'newsletterId'  => $object->getNewsletterId(),
            'templateId'    => $object->getTemplateId(),
            'subject'       => $object->getSubject(),
            'params'        => $object->getParams(),
            'message'       => $object->getMessage(),
            'sent'          => $this->extractValue('sent', $object->isSent()),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
            'dateSent'      => $this->extractValue('dateSent', $object->getDateSent()),
        ];
    }
}