<?php

namespace Newsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Newsletter\Form\Element\SubscriptionList;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Email;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class SubscriberForm extends Form
{
    /**
     * Subscriber constructor.
     *
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        if (is_array($name)) {
            $options = $name;
            $name = (isset($options['name'])) ? $options['name'] : null;
            unset($options['name']);
        }

        parent::__construct($name, $options);
    }

    /**
     * Setup elements
     */
    public function init()
    {
        $this->add([
            'name' => 'subscriberId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'name',
            'type' => Text::class,
            'options' => [
                'label' => 'Name',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => Email::class,
            'options' => [
                'label' => 'Email Address',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'subscribe',
            'type' => SubscriptionList::class,
            'options' => [
                'label' => 'Subscriptions',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'subscriber_id' => $this->getOption('subscriber_id'),
                'include_hidden' => true,
            ],
        ]);

        $this->add([
            'name' => 'dateCreated',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date Created',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
                'format' => 'd/m/Y H:i:s'
            ],
            'attributes' => [
                'disabled' => true,
            ]
        ]);
    }
}