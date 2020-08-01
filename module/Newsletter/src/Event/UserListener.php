<?php

namespace Newsletter\Event;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Newsletter\Form\Element\SubscriptionList;
use Newsletter\Model\SubscriberModel;
use Newsletter\Service\SubscriberService;
use User\Form\RegisterForm;
use User\Model\UserModel;
use User\Service\UserService;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;

class UserListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var UserModel
     */
    protected $userEmail;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['pre.add', 'post.form.init'], [$this, 'getSubscriptionList']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.add'], [$this, 'addSubscriber']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.edit'], [$this, 'emailUpdate']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['pre.edit'], [$this, 'setUserModel']);
    }

    public function setUserModel(Event $e)
    {
        $this->userEmail = $e->getParam('model')->getEmail();
    }

    /**
     * @param Event $e
     */
    public function getSubscriptionList(Event $e)
    {
        /* @var $form \User\Form\RegisterForm */
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        if (!$form instanceof RegisterForm) {
            return;
        }

        /* @var \Newsletter\Form\Element\SubscriptionList $subscriptionList */
        $subscriptionList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get(SubscriptionList::class);

        if (0 === count($subscriptionList->getValueOptions())) {
            return;
        }

        $subscriptionList->setOptions([
            'label' => 'Newsletter',
            'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            'column-size' => 'sm-10',
            'label_attributes' => [
                'class' => 'col-sm-2',
            ],
        ]);

        if (isset($post['subscribe'])) {
            $subscriptionList->setValue($post['subscribe']);
        }

        $form->add($subscriptionList);

        $validationGroup = $form->getValidationGroup();
        $validationGroup[] = 'subscribe';
        $form->setValidationGroup($validationGroup);

        $e->setParam('form', $form);
    }

    /**
     * @param Event $e
     */
    public function addSubscriber(Event $e)
    {
        $data = $e->getParam('post');

        if (isset($data['subscribe'])) {
            $userId = $e->getParam('saved', null);
            /* @var UserModel $model */
            $model = $e->getTarget()->getById($userId);

            if ($model instanceof UserModel) {
                /* @var $subscriberService SubscriberService */
                $subscriberService = $e->getTarget()->getService(SubscriberService::class);

                $subscriber = $subscriberService->getSubscriberByEmail($model->getEmail());

                if (!$subscriber instanceof SubscriberModel || $subscriber->getSubscriberId()) {
                    return;
                }

                $subscriberData = [
                    'name'      => $model->getFullName(),
                    'email'     => $model->getEmail(),
                    'subscribe' => $data['subscribe'],
                ];

                $form = $subscriberService->prepareForm($subscriber, $subscriberData, true, true);
                $form->setValidationGroup(['name', 'email', 'subscribe']);

                $subscriberService->add($subscriberData, $form);
            }
        }
    }

    /**
     * @param Event $e
     */
    public function emailUpdate(Event $e)
    {
        $data = $e->getParam('post');

        /* @var $subscriberService SubscriberService */
        $subscriberService = $e->getTarget()->getService(SubscriberService::class);

        $subscriber = $subscriberService->getSubscriberByEmail($this->userEmail);

        if (!$subscriber instanceof SubscriberModel || null === $subscriber->getSubscriberId()) {
            return;
        }

        if ($this->userEmail !== $data['email']) {
            $subscriber->setEmail($data['email']);
            $subscriberService->save($subscriber);
        }
    }
}
