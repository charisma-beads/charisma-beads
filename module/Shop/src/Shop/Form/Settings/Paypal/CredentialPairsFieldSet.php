<?php

namespace Shop\Form\Settings\Paypal;

use Laminas\Form\Fieldset;

/**
 * Class CredentialPairsFieldSet
 *
 * @package Shop\Form\Settings\Paypal
 */
class CredentialPairsFieldSet extends Fieldset
{
    public function init()
    {
        $this->add([
            'type' => CredentialSetFieldSet::class,
            'name' => 'sandbox',
            'attributes' => [
                'class' => 'col-md-12',
            ],
            'options' => [
                'label' => 'Sandbox',
            ],
        ]);

        $this->add([
            'type' => CredentialSetFieldSet::class,
            'name' => 'live',
            'attributes' => [
                'class' => 'col-md-12',
            ],
            'options' => [
                'label' => 'Live',
            ],
        ]);
    }
}