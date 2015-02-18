<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Shop\View;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormMonthSelect as ZendFormMonthSelect;

class FormMonthSelect extends ZendFormMonthSelect
{   
    public function renderMonths(ElementInterface $element)
    {
        $selectHelper = $this->getSelectElementHelper();
        $pattern      = $this->parsePattern($element->shouldRenderDelimiters());
        
        $monthsOptions = $this->getMonthsOptions($pattern['month']);
        $monthElement = $element->getMonthElement()->setValueOptions($monthsOptions);
        
        if ($element->shouldCreateEmptyOption()) {
            $monthElement->setEmptyOption('');
        }
        
        return $selectHelper->render($monthElement);
    }
    
    public function renderYears(ElementInterface $element)
    {
        $selectHelper = $this->getSelectElementHelper();
        $pattern      = $this->parsePattern($element->shouldRenderDelimiters());
    
        $yearsOptions = $this->getYearsOptions($element->getMinYear(), $element->getMaxYear());
        $yearElement = $element->getYearElement()->setValueOptions($yearsOptions);
    
        if ($element->shouldCreateEmptyOption()) {
            $yearElement->setEmptyOption('');
        }
    
        return $selectHelper->render($yearElement);
    }
}
