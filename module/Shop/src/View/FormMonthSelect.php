<?php

namespace Shop\View;

use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormMonthSelect as LaminasFormMonthSelect;

/**
 * Class FormMonthSelect
 *
 * @package Shop\View
 */
class FormMonthSelect extends LaminasFormMonthSelect
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
