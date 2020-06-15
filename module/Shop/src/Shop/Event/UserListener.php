<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Event;

use Shop\Form\Element\AdvertList;
use Shop\Service\AdvertHitService;
use Shop\Service\CustomerService;
use User\Service\UserService;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

class UserListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['pre.add'], [$this, 'addAdvertList']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.add'], [$this, 'addAdvertHit']);

        $this->listeners[] = $events->attach([
            UserService::class,
        ], ['post.edit'], [$this, 'userEdit']);
    }

    public function userEdit(Event $e)
    {
        $sl = $e->getTarget()->getServiceLocator();
        $data = $e->getParam('post');

        /* @var $customerService \Shop\Service\CustomerService */
        $customerService = $sl->get(CustomerService::class);

        $customer = $customerService->getCustomerDetailsFromUserId($data['userId']);

        if ($data['firstname'] != $customer->getFirstname() ||
            $data['lastname'] != $customer->getLastname() ||
            $data['email'] != $customer->getEmail()) {

            $customer->setFirstname($data['firstname'])
                ->setLastname($data['lastname'])
                ->setEmail($data['email'])
                ->setDateModified();

            $customerService->save($customer);
        }
    }

    public function addAdvertList(Event $e)
    {
        /* @var $advertList \Shop\Form\Element\AdvertList */
        $advertList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get(AdvertList::class);

        $post = $e->getParam('post');

        /* @var $form \User\Form\RegisterForm */
        $form = $e->getParam('form');

        if (isset($post['advertId'])) {
            $advertList->setValue($post['advertId']);
        }

        $form->add($advertList);

        $inputFilter = $form->getInputFilter();
        $inputFilter->add($advertList->getInputSpecification());

        $validationGroup = $form->getValidationGroup();
        $validationGroup[] = 'advertId';
        $form->setValidationGroup($validationGroup);

        $e->setParam('form', $form);
    }

    public function addAdvertHit(Event $e)
    {
        $post = $e->getParam('post');

        $sl = $e->getTarget()->getServiceLocator();
        /* @var $service \Shop\Service\AdvertHitService */
        $service = $sl->get(AdvertHitService::class);

        /* @var $model \Shop\Model\AdvertHitModel */
        $model = $service->getModel();
        $model->setAdvertId($post['advertId']);

        $service->save($model);

    }
}
