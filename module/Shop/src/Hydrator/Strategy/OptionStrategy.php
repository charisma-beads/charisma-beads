<?php

namespace Shop\Hydrator\Strategy;

use Shop\Model\ProductOptionModel;
use Laminas\Hydrator\Strategy\StrategyInterface;

/**
 * Class OptionStrategy
 *
 * @package Shop\Hydrator\Strategy
 */
class OptionStrategy implements StrategyInterface
{
    /**
     * @var int
     */
    protected $optionId;

    /**
     * @param ProductOptionModel $value
     * @return ProductOptionModel
     */
    public function extract($value)
    {
        return $value;
    }

    /**
     * @param ProductOptionModel $value
     * @return ProductOptionModel
     */
    public function hydrate($value)
    {
        if (is_array($value) && !empty($value)) {
            /* @var $option ProductOptionModel */
            foreach ($value as $option) {
                if ($this->getOptionId() == $option->getProductOptionId()) {
                    return $option;
                }
            }
        };

        return null;
    }

    /**
     * @return int
     */
    public function getOptionId(): int
    {
        return $this->optionId;
    }

    /**
     * @param int $optionId
     * @return $this
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }
}
