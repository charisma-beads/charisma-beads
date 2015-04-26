<?php
namespace Shop\Event;

use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

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
        $userId = $e->getParam('saved');
        
        $sl = $e->getTarget()->getServiceLocator();
        /* @var $service \Shop\Service\Advert\Hit */
        $service = $sl->get('ShopAdvertHit');
        
        /* @var $model \Shop\Model\Advert\Hit */
        $model = $service->getModel();
        $model->setAdvertId($post['advertId'])
            ->setUserId($userId);
        
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
