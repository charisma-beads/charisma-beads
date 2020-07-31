<?php

declare(strict_types=1);

namespace ThemeManager\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use ThemeManager\Form\Element\WidgetGroupSelect;
use ThemeManager\Form\Element\WidgetSelect;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Form;

class WidgetForm extends Form
{
    public function init()
    {
        $this->add([
            'type'  => Checkbox::class,
            'name'  => 'enabled',
            'options'   => [
                'label' => 'Enabled',
                'use_hidden_element'    => true,
                'checked_value' => 1,
                'unchecked_value'   => 0,
                'column-size'   => 'md-10 col-md-offset-2',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name'  => 'title',
            'options'   => [
                'label' => 'Title',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'type'  => Checkbox::class,
            'name'  => 'showTitle',
            'options'   => [
                'label' => 'Show Title',
                'use_hidden_element'    => true,
                'checked_value' => 1,
                'unchecked_value'   => 0,
                'column-size'   => 'md-10 col-md-offset-2',
            ],
        ]);

        $this->add([
            'type'  => Text::class,
            'name'  => 'name',
            'options'   => [
                'label' => 'Name',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'type'  => WidgetSelect::class,
            'name'  => 'widget',
            'options'   => [
                'label' => 'Widget',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'name'      => 'widgetGroupId',
            'type'      => WidgetGroupSelect::class,
            'options'   => [
                'label'             => 'Widget Group',
                'twb-layout'        => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'       => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'type'  => Number::class,
            'name'  => 'sortOrder',
            'options'   => [
                'label' => 'Sort Order',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);

        $this->add([
            'type'  => Textarea::class,
            'name'  => 'params',
            'options'   => [
                'label' => 'Params',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
            'attributes'    => [
                'rows'  => 5,
            ]
        ]);

        $this->add([
            'type'  => Checkbox::class,
            'name'  => 'summernote_enable',
            'options'   => [
                'label' => 'Toggle Summernote',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'checked_value' => 1,
                'column-size'   => 'md-10 col-md-offset-2',
            ],
            'attributes'    => [
                'id' => 'toggle-summernote',
                'checked' => false,
            ],
        ]);

        $this->add([
            'type'  => Textarea::class,
            'name'  => 'html',
            'options'   => [
                'label' => 'HTML',
                'twb-layout'    => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size'   => 'md-10',
                'label_attributes'  => [
                    'class' => 'col-md-2',
                ],
            ],
            'attributes'    => [
                'rows'  => 10,
                'class'       => 'editable-textarea',
                'id'          => 'widget-content-textarea',
            ],
        ]);

        $this->add([
            'type'  => Hidden::class,
            'name'  => 'widgetId',
        ]);
    }
}
