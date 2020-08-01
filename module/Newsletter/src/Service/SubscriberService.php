<?php

namespace Newsletter\Service;

use Common\Service\AbstractRelationalMapperService;
use Newsletter\Form\PreferencesForm;
use Newsletter\Form\SubscriberForm as SubscriberForm;
use Newsletter\Hydrator\SubscriberHydrator;
use Newsletter\InputFilter\SubscriberInputFilter;
use Newsletter\Mapper\SubscriberMapper;
use Newsletter\Model\SubscriberModel as SubscriberModel;
use Laminas\EventManager\Event;

/**
 * Class Newsletter
 *
 * @package Newsletter\Service
 * @method SubscriberModel getModel($model = null)
 */
class SubscriberService extends AbstractRelationalMapperService
{
    protected $form         = SubscriberForm::class;
    protected $hydrator     = SubscriberHydrator::class;
    protected $inputFilter  = SubscriberInputFilter::class;
    protected $mapper       = SubscriberMapper::class;
    protected $model        = SubscriberModel::class;

    /**
     * @var array
     */
    protected $referenceMap = [
        'subscriptions'      => [
            'refCol'    => 'subscriberId',
            'service'   => SubscriptionService::class,
            'getMethod' => 'getSubscriptionsBySubscriberId',
        ],
    ];

    /**
     * attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add'
        ], [$this, 'preAdd']);

        $this->getEventManager()->attach([
            'pre.edit'
        ], [$this, 'preEdit']);
        
        $this->getEventManager()->attach([
            'post.edit', 'post.add',
        ], [$this, 'updateSubscriptions']);
    }

    /**
     * @param $email
     * @return SubscriberModel|null
     */
    public function getSubscriberByEmail($email)
    {
        $model = $this->getMapper()->getByEmail($email);

        return $model;
    }

    /**
     * @param array $post
     * @param PreferencesForm $form
     * @return bool|int|PreferencesForm
     */
    public function removeSubscriberFromList(array $post, PreferencesForm $form)
    {
        $form->setInputFilter($this->getInputFilter());
        $form->setValidationGroup(['email', 'captcha', 'security']);

        $form->setData($post);

        if (!$form->isValid()) {
            return $form;
        }

        $data = $form->getData();

        $subscriber = $this->getSubscriberByEmail($data['email']);

        $result = false;

        if ($subscriber->getSubscriberId()) {
            $result = $this->delete($subscriber->getSubscriberId());
        }

        return $result;
    }

    /**
     * @param $id
     * @return SubscriberModel
     */
    public function getSubscriberWithSubscriptions($id)
    {
        $model = parent::getById($id);

        $this->populate($model, true);

        return $model;
    }

    /**
     * Pre subscriber add checks
     *
     * @param Event $e
     */
    public function preAdd(Event $e)
    {
        $form = $e->getParam('form');
        /* @var $inputFilter \User\InputFilter\UserInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists();
    }

    /**
     * prepare data to be updated and saved into database.
     *
     * @param Event $e
     */
    public function preEdit(Event $e)
    {
        $model = $e->getParam('model');
        $form = $e->getParam('form');
        $post = $e->getParam('post');

        // we need to find if this email has changed,
        // if not then exclude it from validation,
        // if changed then reevaluate it.
        $email = ($model->getEmail() === $post['email']) ? $model->getEmail() : null;

        /* @var $inputFilter \User\InputFilter\UserInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addEmailNoRecordExists($email);
    }

    /**
     * @param Event $e
     * @throws \Common\Service\ServiceException
     */
    public function updateSubscriptions(Event $e)
    {
        /* @var $form SubscriberForm */
        $form = $e->getParam('form');
        /* @var $model SubscriberModel */
        $model = $form->getData();
        $subscriberId = ($model->getSubscriberId()) ?: $e->getParam('saved');

        /* @var $newsletterService NewsletterService */
        $newsletterService = $this->getService(NewsletterService::class);

        /* @var $subscriptionService SubscriptionService */
        $subscriptionService =  $this->getService(SubscriptionService::class);

        $newsletters = $newsletterService->fetchAll();

        $subscriber = $this->getSubscriberWithSubscriptions($subscriberId);

        $subscribe = $model->getSubscribe();

        $result = false;

        // if we have a subscriber id then update subscriptions
        // where values are positive
        if ($subscriberId) {
            /* @var $newsletter \Newsletter\Model\NewsletterModel */
            foreach ($newsletters as $newsletter) {
                $subscribeToNewsletter = in_array($newsletter->getNewsletterId(), $subscribe);
                $subscription = $subscriber->getSubscriptions($newsletter->getNewsletterId());

                // if we want to subscribe and no record exists
                if (!$subscription && $subscribeToNewsletter) {
                    $result = $subscriptionService->save([
                        'subscriptionId' => null,
                        'newsletterId' => $newsletter->getNewsletterId(),
                        'subscriberId' => $subscriber->getSubscriberId(),
                    ]);
                }

                // if we want to un-subscribe
                if ($subscription && !$subscribeToNewsletter) {
                    $result = $subscriptionService->delete($subscription->getSubscriptionId());
                }
            }
        }

        $e->setParam('result', $result);
    }
}