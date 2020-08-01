<?php

namespace Contact\Form;

use Laminas\Form\Form;


class ContactSettings extends Form
{
    public function init()
    {
        $this->add([
            'type' => FormFieldSet::class,
            'name' => 'form',
            'options' => [
                'label' => 'Form Options',
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => DetailsFieldSet::class,
            'name' => 'details',
            'options' => [
                'label' => 'Details',
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => CompanyFieldSet::class,
            'name' => 'company',
            'options' => [
                'label' => 'Company',
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);

        $this->add([
            'type' => GoogleMapFieldSet::class,
            'name' => 'google_map',
            'options' => [
                'label' => 'Google Map',
            ],
            'attributes' => [
                'class' => 'col-md-6',
            ],
        ]);
    }
}
