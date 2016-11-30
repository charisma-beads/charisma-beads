<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator\Strategy
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Hydrator\Strategy;

use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class CreditCardNumberStrategy
 *
 * @package Shop\Hydrator\Strategy
 */
class CreditCardNumberStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    protected $numberSeperator = ' ';

    /**
     * @param string $value
     * @return string
     */
    public function extract($value)
    {
        return str_replace($this->numberSeperator, '', $value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function hydrate($value)
    {
        return preg_replace(
            '/^([0-9]{4})([0-9]{4})([0-9]{4})([0-9]{4})$/',
            '$1 $2 $3 $4',
            $value
        );
    }
}
