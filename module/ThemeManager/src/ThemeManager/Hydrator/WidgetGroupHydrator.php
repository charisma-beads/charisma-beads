<?php

declare(strict_types=1);

namespace ThemeManager\Hydrator;

use Common\Hydrator\AbstractHydrator;
use ThemeManager\Model\WidgetGroupModel;

class WidgetGroupHydrator extends AbstractHydrator
{
    /**
     * @param WidgetGroupModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'widgetGroupId' => $object->getWidgetGroupId(),
            'name'          => $object->getName(),
            'params'        => $object->getParams(),
        ];
    }
}
