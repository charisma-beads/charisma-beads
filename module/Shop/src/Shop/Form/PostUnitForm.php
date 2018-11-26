<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Number;
use Zend\Form\Form;

/**
 * Class Unit
 *
 * @package Shop\Form
 */
class PostUnitForm extends Form
{
    public function init()
    {
        $this->add([
            'name'	=> 'postUnitId',
            'type'	=> Hidden::class,
        ]);
        
        $this->add([
            'name'			=> 'postUnit',
            'type'			=> Number::class,
            'attributes'	=> [
                'placeholder'	=> 'Unit',
                'autofocus'		=> true,
                'step'			=> '0.01'
            ],
            'options'		=> [
                'label'			=> 'Unit',
                'help-block'	=> 'This should be weight in grams.',
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'column-size' => 'sm-10',
                'label_attributes' => [
                    'class' => 'col-sm-2',
                ],
            ],
        ]);
    }
}
