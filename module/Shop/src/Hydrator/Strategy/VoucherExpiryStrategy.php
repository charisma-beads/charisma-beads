<?php

namespace Shop\Hydrator\Strategy;

use Common\Hydrator\Strategy\DateTime;

/**
 * Class VoucherExpiryStrategy
 *
 * @package Shop\Hydrator\Strategy
 */
class VoucherExpiryStrategy extends DateTime
{
    /**
     * @param mixed $value
     * @return string
     */
    public function extract($value)
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return parent::extract($value);
    }

    /**
     * @param mixed $value
     * @return DateTimeClass|mixed|null
     * @throws Exception
     */
    public function hydrate($value)
    {
        if ('' === $value || null === $value) {
            return null;
        }

        return parent::hydrate($value);
    }
}