<?php

namespace Navigation\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Navigation\Form\Element\MenuItemList;
use Navigation\Form\Element\MenuItemRadio;
use Navigation\Form\Element\ResourceList;
use Navigation\Form\Element\RouteList;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\Url;
use Zend\Form\Form;


class MenuItemForm extends Form
{
	public function init()
	{
		$this->add([
			'name' => 'label',
			'type' => Text::class,
			'options' => [
				'label' => 'Label',
				'required' => true,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
			'attributes' =>[
				'placeholder' => 'Label',
			],
		]);
		
		$this->add([
			'name' => 'params',
			'type' => Textarea::class,
			'options' => [
				'label' => 'Params',
				'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
			'attributes' => [
				'placeholder' => 'Params',
			],
		]);
		
		$this->add([
			'name' => 'route',
			'type' => RouteList::class,
			'options' => [
				'label' => 'Route',
				'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);
		
		$this->add([
			'name' => 'resource',
			'type' => ResourceList::class,
			'options' => [
				'label' => 'Resource',
				'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
			'attributes' => [
				'placeholder' => 'Resource:',
			],
		]);

        $this->add([
            'name' => 'uri',
            'type' => Url::class,
            'options' => [
                'label' => 'URI',
                'required' => false,
                'column-size' => 'sm-10',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
		
		$this->add([
			'name' => 'visible',
			'type' => Select::class,
			'options' => [
				'label' => 'Is Visible',
				'required' => true,
				'empty_option' => '---Please select option---',
				'value_options' => [
					'0'	=> 'No',
					'1'	=> 'Yes',
				],
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
			],
		]);

        $this->add([
            'name' => 'position',
            'type' => MenuItemList::class,
            'options' => [
                'label' => 'Menu Placement',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'menuInsertType',
            'type' => MenuItemRadio::class,
            'options' => [
                'label' => 'Insert Type',
                'required' => false,
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);

        $this->add([
            'name' => 'menuItemId',
            'type' => Hidden::class,
        ]);

        $this->add([
            'name' => 'menuId',
            'type' => Hidden::class,
        ]);


        $this->add([
            'name' => 'security',
            'type' => Csrf::class,
        ]);
	}
}
