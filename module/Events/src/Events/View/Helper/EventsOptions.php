<?php

namespace Events\View\Helper;

use Common\View\AbstractViewHelper;
use Common\View\ConfigTrait;

class EventsOptions extends AbstractViewHelper
{
    use ConfigTrait;

    /**
     * @param $key
     * @return string
     */
    public function __invoke($key)
    {
        $config = $this->getConfig('uthando_events');

        return $config[$key];
    }
}
