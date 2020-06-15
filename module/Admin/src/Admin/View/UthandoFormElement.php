<?php declare(strict_types=1);

namespace Admin\View;

use Zend\Form\Form;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormElement;
use Zend\View\Helper\Partial;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class UthandoFormElement
 *
 * @package Admin\View
 * @method PhpRenderer getView()
 */
class UthandoFormElement extends AbstractHelper
{
    protected $partial = 'admin/partial/tb-form-element';
    
    protected $checkboxRadio = '<div class="%s col-md-offset-2"><label>%s %s</label></div><br>';

    protected $options = [
        'labelWidth'    => '2',
        'elementWidth'  => '4',
    ];

    /**
     * @param array $options
     * @return string
     */
    public function __invoke(array $options)
    {
        $options            = array_merge($this->options, $options);
        $view               = $this->getView();
        /* @var Form $form */
        $form               = $view->get('form');
        /* @var FormElement $formElementHelper */
        $formElementHelper  = $view->plugin('formElement');
        /* @var Partial $partialHelper */
        $partialHelper      = $view->plugin('partial');
        $html               = '';
        $formElements       = ($view->get('formElements')) ?: [];
        
        foreach ($formElements as $element) {
            switch ($form->get($element)->getAttribute('type')) {
            	case 'hidden':
            	    $html .= $formElementHelper($form->get($element));
            	    break;
            	case 'checkbox':
            	case 'radio':
            	    $html .= sprintf(
            	       $this->checkboxRadio,
            	       $element,
            	       $form->get($element)->getLabel(),
            	       $formElementHelper($form->get($element))
                    );
            	    break;
            	default:
            	    $html .= $partialHelper($this->partial, [
                        'element'   => $form->get($element),
                        'options'   => $options,
            	    ]);
            }
        }
        
        return $html;
    }
}
