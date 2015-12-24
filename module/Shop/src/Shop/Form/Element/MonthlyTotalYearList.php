<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Form\Element
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Form\Element;

use Zend\Form\Element\Select;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MonthlyTotalYearList
 *
 * @package Shop\Form\Element
 */
class MonthlyTotalYearList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        /* @var $mapper \Shop\Mapper\Order\Order */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('UthandoMapperManager')
            ->get('ShopOrder');

        $minMaxYear = $mapper->getMinMaxYear();
        $minOrMax = ($this->getOption('minOrMax') == 'min') ? '-01-01' : '-12-31';

        $years = [];

        for ($i = $minMaxYear->minYear; $i <= $minMaxYear->maxYear; $i++) {
            $years[$i . $minOrMax] = $i;
        }

        $this->setValueOptions($years);

        $defaultValue = ($this->getOption('minOrMax') == 'min') ? $minMaxYear->maxYear - 4  : $minMaxYear->maxYear;
        $this->setValue($defaultValue . $minOrMax);
    }
}