<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Form;

use TwbBundle\Form\View\Helper\TwbBundleForm;
use UthandoCommon\Mapper\AbstractNestedSet as NestedSet;
use Zend\Form\Form;

/**
 * Class Faq
 *
 * @package Shop\Form
 */
class Faq extends Form
{
    /**
     * @var int
     */
    protected $faqId;

    /**
     * @param array|\Traversable $options
     * @return \Zend\Form\Element|\Zend\Form\ElementInterface
     */
    public function setOptions($options)
    {
        if (isset($options['faqId'])) {
            $this->faqId = $options['faqId'];
        }

        return parent::setOptions($options);
    }

    public function init()
    {
        $this->add([
            'name'	=> 'faqId',
            'type'	=> 'hidden',
        ]);

        $this->add([
            'name'			=> 'question',
            'type'			=> 'text',
            'attributes'	=> [
                'placeholder'		=> 'Question',
                'autofocus'			=> true,
                'autocapitalize'	=> 'on',
            ],
            'options'		=> [
                'label'	=> 'Question',
            ]
        ]);

        $this->add([
            'name'			=> 'answer',
            'type'			=> 'textarea',
            'attributes'	=> [
                'placeholder'		=> 'Answer',
                'autofocus'			=> true,
                'autocapitalize'	=> 'off',
                'class'             => 'form-control tiny-mce-textarea',
            ],
            'options'		=> [
                'label'			=> 'Answer',
            ],
        ]);

        $this->add([
            'name'			=> 'parent',
            'type'			=> 'FaqList',
            'attributes'	=> [
                'class' => 'input-xlarge',
            ],
            'options'		=> [
                'label'			=> 'Parent',
                'required'		=> false,
                'add_top'       => true,
            ],
        ]);

        $faqInsertOptions = [
            NestedSet::INSERT_NODE	=> 'insert after this faq.',
            //NestedSet::INSERT_CHILD	=> 'insert as a new sub-faq at the top.',

        ];

        if ($this->getFaqId()) {
            $faqInsertOptions['noInsert'] = [
                'value' => 'noInsert',
                'selected' => true,
                'label' => 'no change',
            ];
        }

        $this->add([
            'name'			=> 'faqInsertType',
            'type'			=> 'radio',
            'options'		=> [
                'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
                'required'		=> true,
                'value_options' => array_reverse($faqInsertOptions, true),
                'column-size' => 'md-8 col-md-offset-4',
                'label_attributes' => [
                    'class' => 'col-md-8',
                ],
            ],

        ]);
    }

    /**
     * @return int
     */
    public function getFaqId()
    {
        return $this->faqId;
    }

    /**
     * @param int $faqId
     * @return $this
     */
    public function setFaqId($faqId)
    {
        $this->faqId = $faqId;
        return $this;
    }
}
