<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Strategy
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Hydrator\Strategy;

use Shop\Model\ProductImageModel;
use Zend\Hydrator\Strategy\StrategyInterface;

class ProductImageStrategy implements StrategyInterface
{

    /**
     * @param mixed $value
     * @return mixed
     */
    public function extract($value)
    {
        return $value;
    }

    /**
     * @param array|null $value
     * @return mixed
     */
    public function hydrate($value)
    {
        if (!is_array($value)) return $value;

        if (empty($value)) return new ProductImageModel();

        foreach ($value as $row) {
            if ($row->getIsDefault() || !$row->getProductImageId()) {
                return $row;
            }
        }
    }
}
