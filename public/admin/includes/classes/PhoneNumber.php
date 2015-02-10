<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Zend\I18n\Validator\PhoneNumber as ZendPhoneNumber;

class PhoneNumber extends ZendPhoneNumber
{

    protected $trunkCodes = array(
        'GB' => '0',
    );

    /**
     * Returns true if and only if $value matches phone number format
     *
     * @param  string $value
     * @param  array  $context
     * @return bool
     */
    public function isValid($value = null, $context = null)
    {
        if (!is_scalar($value)) {
            $this->error(self::INVALID);

            return false;
        }
        $this->setValue($value);

        $country = $this->getCountry();

        if (!$countryPattern = $this->loadPattern($country)) {
            if (isset($context[$country])) {
                $country = $context[$country];
            }

            if (!$countryPattern = $this->loadPattern($country)) {
                $this->error(self::UNSUPPORTED);

                return false;
            }
        }

        $codeLength = strlen($countryPattern['code']);

        /*
         * Check for existence of either:
         *   1) E.123/E.164 international prefix
         *   2) International double-O prefix
         *   3) Bare country prefix
         */
        if (('+' . $countryPattern['code']) == substr($value, 0, $codeLength + 1)) {
            $valueNoCountry = substr($value, $codeLength + 1);
        } elseif (('00' . $countryPattern['code']) == substr($value, 0, $codeLength + 2)) {
            $valueNoCountry = substr($value, $codeLength + 2);
        } elseif ($countryPattern['code'] == substr($value, 0, $codeLength)) {
            $valueNoCountry = substr($value, $codeLength);
        }

        // Check for trunk codes
        if (!isset($valueNoCountry) && array_key_exists($country, $this->trunkCodes)) {
            $trunkLength = strlen($this->trunkCodes[$country]);

            if ($this->trunkCodes[$country] == substr($value, 0, $trunkLength)) {
                $valueNoTrunk = substr($value, $trunkLength);
            }
        }

        // check against allowed types strict match:
        foreach ($countryPattern['patterns']['national'] as $type => $pattern) {
            if (in_array($type, $this->allowedTypes)) {
                // check pattern:
                if (preg_match($pattern, $value)) {
                    return true;
                } elseif (isset($valueNoCountry) && preg_match($pattern, $valueNoCountry)) {
                    // this handles conditions where the country code and prefix are the same
                    return true;
                } elseif (isset($valueNoTrunk) && preg_match($pattern, $valueNoTrunk)) {
                    return true;
                }
            }
        }

        // check for possible match:
        if ($this->allowPossible()) {
            foreach ($countryPattern['patterns']['possible'] as $type => $pattern) {
                if (in_array($type, $this->allowedTypes)) {
                    // check pattern:
                    if (preg_match($pattern, $value)) {
                        return true;
                    } elseif (isset($valueNoCountry) && preg_match($pattern, $valueNoCountry)) {
                        // this handles conditions where the country code and prefix are the same
                        return true;
                    } elseif (isset($valueNoTrunk) && preg_match($pattern, $valueNoTrunk)) {
                        return true;
                    }
                }
            }
        }

        $this->error(self::NO_MATCH);

        return false;
    }
}
