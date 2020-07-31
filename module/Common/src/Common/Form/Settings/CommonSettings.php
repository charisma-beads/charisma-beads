<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Common\Form\Settings
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Common\Form\Settings;

use Laminas\Form\Form;

/**
 * Class Settings
 *
 * @package Common\Form\Settings
 */
class CommonSettings extends Form
{
    /**
     * Init
     */
    public function init()
    {
        $this->add([
            'type' => GeneralFieldSet::class,
            'name' => 'general',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'General',
            ],
        ]);

        $this->add([
            'type' => CacheFieldSet::class,
            'name' => 'cache',
            'attributes' => [
                'class' => 'col-sm-6',
            ],
            'options' => [
                'label' => 'Cache',
            ],
        ]);
    }
}
