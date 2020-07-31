<?php

namespace News\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Laminas\Form\Form;


class NewsSettingsForm extends Form
{
    public function init()
    {
        $this->add([
            'type' => NewsOptionsFieldSet::class,
            'name' => 'options',
            'options' => [
                'label' => 'News Settings',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => NewsFeedFieldSet::class,
            'name' => 'feed',
            'options' => [
                'label' => 'News Feed',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}
