<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormMonthSelect as ZendFormMonthSelect;

/**
 * Class FormMonthSelect
 *
 * @package Shop\View
 */
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
