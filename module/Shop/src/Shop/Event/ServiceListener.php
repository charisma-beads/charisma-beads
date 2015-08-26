<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Event;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class ServiceListener
 *
 * @package Shop\Event
 */
class ServiceListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    
    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            'Shop\Controller\Customer\CustomerAddress',
            'Shop\Controller\Country\CountryProvince',
            'Shop\Controller\Product\ProductOption',
        ], ['add.action'], [$this, 'addAction']);

        $this->listeners[] = $events->attach([
            'UthandoFileManager\Service\ImageUploader',
        ], ['pre.upload'], [$this, 'preImageUpload']);

        $this->listeners[] = $events->attach([
            'UthandoFileManager\Service\ImageUploader',
        ], ['post.upload'], [$this, 'postImageUpload']);
        
        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['pre.add'], [$this, 'addAdvertList']);
        
        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['post.add'], [$this, 'addAdvertHit']);

        $this->listeners[] = $events->attach([
            'UthandoUser\Service\User',
        ], ['post.edit'], [$this, 'userEdit']);
    }

    public function userEdit(Event $e)
    {
        $sl = $e->getTarget()->getServiceLocator();
        $data = $e->getParam('post');

        /* @var $customerService \Shop\Service\Customer\Customer */
        $customerService = $sl->get('ShopCustomer');

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

    public function preImageUpload(Event $e)
    {
        $data = $e->getParam('data');

        if (!isset($data['productId'])) {
            return;
        }

        /* @var $options \UthandoFileManager\Options\FileManagerOptions */
        $options = $e->getParam('options');
        $path = $options->getDestination() . 'shop/images/';
        $options->setDestination($path);
    }

    public function postImageUpload(Event $e)
    {
        $data = $e->getParam('data');

        if (!isset($data['productId'])) {
            return;
        }

        /* @var $model \UthandoFileManager\Model\Image */
        $model = $e->getParam('model');

        /* @var $service \Shop\Service\Product\Image */
        $service = $e->getTarget()->getService('ShopProductImage');

        $post = [
            'productId' => $data['productId'],
            'thumbnail' => $model->getFileName(),
            'full'      => $model->getFileName(),
        ];

        $service->add($post);
    }
    
    public function addAdvertList(Event $e)
    {
        /* @var $advertList \Shop\Form\Element\AdvertList */
        $advertList = $e->getTarget()
            ->getServiceLocator()
            ->get('FormElementManager')
            ->get('AdvertList');
        
        $post = $e->getParam('post');
        
        /* @var $form \UthandoUser\Form\Register */
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
        /* @var $service \Shop\Service\Advert\Hit */
        $service = $sl->get('ShopAdvertHit');
        
        /* @var $model \Shop\Model\Advert\Hit */
        $model = $service->getModel();
        $model->setAdvertId($post['advertId']);
        
        $service->save($model);
        
    }

    public function addAction(Event $e)
    {
        $controller = $e->getTarget();
        $params = $controller->params()->fromRoute('id', null);
        $form = $e->getParam('form');

        switch (get_class($controller)) {
            case 'Shop\Controller\Customer\CustomerAddress':
                $form->get('customerId')->setValue($params);
                break;
            case 'Shop\Controller\Country\CountryProvince':
                $form->get('countryId')->setValue($params);
                break;
            case 'Shop\Controller\Product\ProductOption':
                $form->get('productId')->setValue($params);
                break;
        }
    }
}
