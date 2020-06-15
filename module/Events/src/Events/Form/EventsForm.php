<?php

namespace Events\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Events\Options\EventsOptions;
use Zend\Form\Element\DateTime;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


class EventsForm extends Form implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        /* @var EventsOptions $options */
        $options = $this->getServiceLocator()
            ->getServiceLocator()->get(EventsOptions::class);

        $this->add([
            'name' => 'eventId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label' => 'Title',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'Title',
            ],
        ]);

        $this->add([
            'name' => 'dateTime',
            'type' => DateTime::class,
            'options' => [
                'label' => 'Date/Time',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4 date-time-pick',
                'add-on-append' => '<i class="fa fa-calendar"></i>',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
                'format' => $options->getDateFormat(),
            ],
            'attributes' => [
                'class' => 'date-time-pick',
                'placeholder' => 'Date Time',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => Textarea::class,
            'options' => [
                'label' => 'Description',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-10',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
                'attributes' => [
                    'placeholder' => 'Description',
                    'class'       => 'editable-textarea',
                    'id'          => 'article-content-textarea',
                    'rows'        => 10,
                ],
            ],
        ]);

        $this->add([
            'name' => 'html',
            'type' => Textarea::class,
            'options' => [
                'label' => 'HTML Content',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
            'attributes' => [
                'placeholder' => 'HTML Content',
                'class'       => 'editable-textarea',
                'id'          => 'article-content-textarea',
                'rows'        => 25,
            ],
        ]);
    }
}
