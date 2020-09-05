<?php

namespace Mail\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\DateTime as DateTimeStrategy;
use Common\Hydrator\Strategy\Serialize;
use Exception;
use Mail\Model\MailQueueModel;

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
     * @param array $data
     * @param MailQueueModel $object
     * @return MailQueueModel
     * @throws Exception
     */
    public function hydrate(array $data, $object)
    {
        try {
            /** @var MailQueueModel $model */
            $model = parent::hydrate($data, $object);
        } catch (Exception $e) {
            throw new Exception(
                sprintf(
                    "Couldn't hydrate mail with ID:%s \n recipient: %s \n sender: %s \n body: %s \n layout: %s",
                    $data['mailQueueId'],
                    $data['recipient'],
                    $data['sender'],
                    $data['body'],
                    $data['layout']
                )
            );
        }

        return $model;

    }

    /**
     * @param MailQueueModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'mailQueueId'   => $object->getMailQueueId(),
            'recipient'     => $this->extractValue('recipient', $object->getRecipient(), $object),
            'sender'        => $this->extractValue('sender', $object->getSender(), $object),
            'subject'       => $object->getSubject(),
            'body'          => $this->extractValue('body', $object->getBody(), $object),
            'layout'        => $this->extractValue('layout', $object->getLayout(), $object),
            'transport'     => $object->getTransport(),
            'renderer'      => $object->getRenderer(),
            'priority'      => $object->getPriority(),
            'dateCreated'   => $this->extractValue('dateCreated', $object->getDateCreated()),
        ];

    }
}
