<?php

namespace FileManager\Form;

use Zend\Form\Form;


class FileManagerSettingsForm extends Form
{
    /**
     * Set up elements
     */
    public function init()
    {
        $this->add([
            'type' => LegacyFieldSet::class,
            'name' => 'options',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                //'use_as_base_fieldset' => true,
                'label' => 'Legacy Upload Options',
            ],
        ]);

        $this->add([
            'type' => ElfinderFieldSet::class,
            'name' => 'elfinder',
            'attributes' => [
                'class' => 'col-md-6',
            ],
            'options' => [
                //'use_as_base_fieldset' => true,
                'label' => 'Elfinder Config',
            ],
        ]);
    }
}
