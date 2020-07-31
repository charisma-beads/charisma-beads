<?php

namespace Newsletter\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Element\Submit;


class SubscriberEditForm extends SubscriberForm
{
    public function init()
    {
        parent::init();

        $this->get('name')->setAttribute('readonly', true);
        $this->get('email')->setAttribute('readonly', true);
        $this->get('subscribe')->setIncludeHidden(false);

        $this->add([
            'name' => 'submit',
            'type' => Submit::class,
            'options' => [
                'label' => 'Update',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10 col-sm-offset-2',
            ],
        ]);
    }
}
