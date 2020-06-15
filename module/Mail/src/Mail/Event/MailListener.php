<?php

namespace Mail\Event;

use Common\Service\AbstractService;
use Common\Service\ServiceException;
use Common\Service\ServiceManager;
use Mail\Service\Mail;
use Mail\Service\MailQueueService;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception\InvalidPluginException;


class MailListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents = $events->getSharedManager();

        $listeners = [
            AbstractService::class,
            AbstractActionController::class,
        ];

        $this->listeners[] = $sharedEvents->attach($listeners, 'mail.send', [$this, 'sendMail']);
        $this->listeners[] = $sharedEvents->attach($listeners, 'mail.queue', [$this, 'queueMail']);
    }

    /**
     * @param Event $e
     * @throws InvalidPluginException
     */
    public function sendMail(Event $e)
    {
        $data = $e->getParams();
        /* @var ServiceManager $sl */
        $sl = $e->getTarget()->getServiceLocator();

        /* @var $sendMail Mail */
        $sendMail = $sl->get(Mail::class);

        if (isset($data['renderer']) && $sl->getServiceLocator()->has($data['renderer'])) {
            $sendMail->setView(
                $sl->get($data['renderer'])
            );
        }

        if (isset($data['layout'])) {
            $sendMail->setLayout($data['layout']);

            if (isset($data['layout_params'])) {
                $sendMail->getLayout()->setVariables($data['layout_params']);
            }
        }

        $subject = $data['subject'];
        $transport = $data['transport'];
        $body = $data['body'];

        $recipient = (isset($data['recipient'])) ? $data['recipient'] : $sendMail->getOption('AddressList')[$transport];

        if (is_array($recipient)) {
            $to = $sendMail->createAddress($recipient['address'], $recipient['name']);
        } else {
            $to = $recipient;
        }

        $sender = (isset($data['sender'])) ? $data['sender'] : $sendMail->getOption('AddressList')[$transport];

        if (is_array($sender)) {
            $from = $sendMail->createAddress($sender['address'], $sender['name']);
        } else {
            $from = $sender;
        }

        $message = $sendMail->compose($body)
            ->setTo($to)
            ->setFrom($from)
            ->setSubject($subject);

        $sendMail->send($message, $transport);
    }

    /**
     * @param Event $e
     * @throws ServiceException|InvalidPluginException
     */
    public function queueMail(Event $e)
    {
        /* @var ServiceManager $sl */
        $sl = $e->getTarget()->getServiceLocator();
        $data = $e->getParams();

        /* @var $mailQueue MailQueueService */
        $mailQueue = $sl->get(MailQueueService::class);
        $hydrator = $mailQueue->getHydrator();
        $model = $mailQueue->getModel();

        $model = $hydrator->hydrate($data, $model);

        $mailQueue->save($model);
    }
}
