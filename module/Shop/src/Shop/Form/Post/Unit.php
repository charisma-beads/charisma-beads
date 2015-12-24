<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Post;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Form;

/**
 * Class Unit
 *
 * @package Shop\Form\Post
 */
class Unit extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'postUnitId',
            'type'	=> 'hidden',
        ]);
        
        $this->add([
            'name'			=> 'postUnit',
            'type'			=> 'number',
            'attributes'	=> [
                'placeholder'	=> 'Unit:',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ],
            'options'		=> [
                'label'			=> 'Unit:',
                'help-inline'	=> 'This should be weight in grams.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'md-4',
                'label_attributes' => [
                    'class' => 'col-md-2',
                ],
            ],
        ]);
    }
}
