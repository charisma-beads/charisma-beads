<?php

namespace Events\InputFilter;

use Laminas\Filter\Boolean;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;


class SettingsInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'date_format',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ]
        ]);

        $this->add([
            'name' => 'sort_order',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ]
        ]);

        $this->add([
            'name' => 'show_expired_events',
            'required' => false,
            'allow_empty' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Boolean::class],
            ]
        ]);

        $this->add([
            'name' => 'number_of_events_to_show',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => ToInt::class],
            ]
        ]);
    }
}
