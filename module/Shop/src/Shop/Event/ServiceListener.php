<?php
namespace Shop\Event;

use Shop\Model\Customer\Customer;
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
            'Shop\Service\Customer\Customer',
            'Shop\Service\Customer\Address',
        ], 'form.init', [$this, 'formInit']);

        $this->listeners[] = $events->attach([
            'Shop\Service\Customer\Customer',
        ], ['pre.form', 'post.add'], [$this, 'checkCustomerNumber']);

        $this->listeners[] = $events->attach([
            'Shop\Service\Order\Order',
        ], ['post.add'], [$this, 'generateOrderNumber']);

        $this->listeners[] = $events->attach([
            'Shop\Service\Product\Category',
        ], 'pre.form', [$this, 'preForm']);
        
        $this->listeners[] = $events->attach([
            'Shop\Service\Product\Product'
        ], ['pre.add', 'pre.edit'], [$this, 'setProductIdent']);
        
        $this->listeners[] = $events->attach([
    		'Shop\Service\Customer\Address'
		], ['pre.add', 'pre.edit'], [$this, 'setCountryValidation']);

        $this->listeners[] = $events->attach([
            'Shop\Controller\Customer\CustomerAddress',
            'Shop\Controller\Country\CountryProvince',
            'Shop\Controller\Product\ProductOption',
        ], ['add.action'], [$this, 'addAction']);

        $this->listeners[] = $events->attach([
            'Shop\Service\Customer\Customer',
        ], ['pre.add'], [$this, 'setCustomerValidation']);

        $this->listeners[] = $events->attach([
            'UthandoFileManager\Service\ImageUploader',
        ], ['pre.upload'], [$this, 'preImageUpload']);

        $this->listeners[] = $events->attach([
            'UthandoFileManager\Service\ImageUploader',
        ], ['post.upload'], [$this, 'postImageUpload']);

        $this->listeners[] = $events->attach([
            'Shop\Service\Product\Image',
        ], ['post.delete'], [$this, 'deleteImage']);
    }

    public function deleteImage(Event $e)
    {
        /* @var $model \Shop\Model\Product\Image */
        $model = $e->getParam('model');
        $file = './public/userfiles/shop/images/' . $model->getFull();
        $thumb = './public/userfiles/shop/images/' . $model->getThumbnail();
        unlink($file);
        // TODO: generate thumbnail to delete.
        //unlink($thumb);
    }

    public function preImageUpload(Event $e)
    {
        /* @var $options \UthandoFileManager\Options\FileManagerOptions */
        $options = $e->getParam('options');
        $path = $options->getDestination() . 'shop/images/';
        $options->setDestination($path);
    }

    public function postImageUpload(Event $e)
    {
        $data = $e->getParam('data');

        /* @var $model \UthandoFileManager\Model\Image */
        $model = $e->getParam('model');

        /* @var $service \Shop\Service\Product\Image */
        $service = $e->getTarget()->getService('Shop\Service\Product\Image');
        $post = [
            'productId' => $data['productId'],
            'thumbnail' => $model->getFileName(),
            'full'      => $model->getFileName(),
            'isDefault' => 0,
        ];

        $service->add($post);
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
    
    public function setProductIdent(Event $e)
    {
        $post = $e->getParam('post');
        
        if (!$post['ident']) {
        	$post['ident'] = $post['name'] . ' ' . $post['shortDescription'];
        }
        
        $e->setParam('post', $post);
    }

    public function setCustomerValidation(Event $e)
    {
        $form = $e->getParam('form');
        $form->setValidationGroup('prefixId', 'firstname', 'lastname', 'email');
    }
    
    public function setCountryValidation(Event $e)
    {
        $form = $e->getParam('form');
        $post = $e->getParam('post');
        
        /* @var $service \Shop\Service\Country\Country */
        $service = $e->getTarget()->getService('Shop\Service\Country');
        $countryId = $post['countryId'];
        
        $country = $service->getById($countryId);
        
        $validator = $form->getInputFilter();
        
        $phone = $validator->get('phone')->getValidatorChain()->getValidators()[0]['instance'];
        $postcode = $validator->get('postcode')->getValidatorChain()->getValidators()[0]['instance'];
        
        $phone->setCountry($country->getCode());
        $postcode->setCountry($country->getCode());
    }

    public function preForm(Event $e)
    {
        $model = $e->getParam('model');
        $service = $e->getTarget();

        $service->setFormOptions([
            'productCategoryId' => $model->getProductCategoryId(),
        ]);
    }
    
    public function formInit(Event $e)
    {
        $form = $e->getParam('form');
        $data = $e->getParam('data');
        $model = $e->getParam('model');
        
        switch (get_class($model)) {
        	case 'Shop\Model\Customer\Customer':
        	    $this->customerForm($form, $model, $e);
        	    break;
        	case 'Shop\Model\Customer\Address':
        	    $this->customerAddressForm($form, $model, $data);
        	    break;
            case 'Shop\Model\Product\Category':
                $this->categoryForm($form, $model);
                break;
        }
    }

    public function categoryForm($form, $model)
    {
        $form->setCategoryId($model->getProductCategoryId());
    }

    /**
     * BC add customer numbers as we go.
     *
     * @param Event $e
     * @return mixed
     */
    public function checkCustomerNumber(Event $e)
    {
        $model = $e->getParam('model');
        $insertId = $e->getParam('saved');

        if (!$model && $insertId) {
            $model = $e->getTarget()->getById($insertId);
        }


        if (!$model instanceof Customer) {
            return $model;
        }

        if (!$model->getNumber() && $model->getCustomerId()) {
            $cusNum = $e->getTarget()->generateCustomerNumber($model);
            $model->setNumber($cusNum);
            $e->getTarget()->save($model);
            $model = $e->getTarget()->getById($model->getCustomerId());
        }

        return $model;
    }

    public function generateOrderNumber(Event $e)
    {
        $insertId = $e->getParam('saved');
        $model = $e->getTarget()->getById($insertId);
        $e->getTarget()->generateOrderNumber($model);
    }

    public function customerForm($form, $model, $e)
    {
    	$form->get('billingAddressId')->setCustomerId($model->getCustomerId());
    	$form->get('deliveryAddressId')->setCustomerId($model->getCustomerId());
    }
    
    public function customerAddressForm($form, $model, $data)
    {
        if (isset($data['countryId'])) {
        	$countryId = $data['countryId'];
        } elseif ($model) {
        	$countryId = $model->getCountryId();
        } else {
        	$countryId = $form->get('countryId')->getCountryId();
        }
         
        $form->get('provinceId')->setCountryId($countryId);
    }
}
