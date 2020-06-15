<?php

namespace Common\Form\Element;

use libphonenumber\PhoneNumberUtil;
use Zend\Form\Element\Select;


class LibPhoneNumberCountryList extends Select
{
    /**
     * @var string
     */
    protected $emptyOption = '---Please select a country---';

    /**
     * set up option list
     */
    public function init()
    {
        $libPhoneNumber = PhoneNumberUtil::getInstance();
        $optionsList    = [];

        foreach ($libPhoneNumber->getSupportedRegions() as $code) {
            $fullTextCountry = \Locale::getDisplayRegion('en_' . $code, 'en');
            $optionsList[$code] = $fullTextCountry;
        }

        asort($optionsList);

        $this->setValueOptions($optionsList);
    }
}
