<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Settings\Paypal
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Settings\Paypal;

use Zend\Form\Fieldset;

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