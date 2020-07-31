<?php

namespace Shop\Form\Element;

use Shop\Mapper\OrderMapper;
use Common\Mapper\MapperManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class MonthlyTotalYearList
 *
 * @package Shop\Form\Element
 */
class MonthlyTotalYearList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * MonthlyTotalYearList constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        if (is_array($name)) {
            $options = $name;
        }

        if (isset($options['name'])) {
            $name = $options['name'];
            unset($options['name']);
        }

        parent::__construct($name, $options);
    }

    public function init()
    {
        /* @var $mapper \Shop\Mapper\OrderMapper */
        $mapper = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(MapperManager::class)
            ->get(OrderMapper::class);

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