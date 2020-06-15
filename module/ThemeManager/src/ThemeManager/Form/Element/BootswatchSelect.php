<?php

declare(strict_types=1);

namespace ThemeManager\Form\Element;

use Zend\Form\Element\Select;
use Zend\Json\Json;

class BootswatchSelect extends Select
{
    protected $emptyOption = 'Bootstrap';

    public function init()
    {
        // this needs to go somewhere else!
        if (file_exists('./data/cache/bootswatch.json')) {
            $json = file_get_contents('./data/cache/bootswatch.json');
        } else {
            $json = file_get_contents('https://bootswatch.com/api/3.json');
            file_put_contents('./data/cache/bootswatch.json', $json);
        }

        $bootswatch     = Json::decode($json);
        $optionsList    = [];

        foreach ($bootswatch->themes as $theme) {
            $optionsList[] = [
                'label' => $theme->name,
                'value' => strtolower($theme->name),
            ];
        }

        $this->setValueOptions($optionsList);
    }
}
