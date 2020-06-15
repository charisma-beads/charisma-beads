<?php

declare(strict_types=1);

namespace ThemeManager\Hydrator;


use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\NullStrategy;
use Common\Hydrator\Strategy\TrueFalse;
use ThemeManager\Model\WidgetModel;

class WidgetHydrator extends AbstractHydrator
{
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('bool', new TrueFalse());
        $this->addStrategy('null', new NullStrategy());
    }

    /**
     * @param  WidgetModel $object
     * @return array
     */
    public function extract($object): array
    {
        return [
            'widgetId'          => $object->getWidgetId(),
            'widgetGroupId'     => $this->extractValue('null', $object->getWidgetGroupId()),
            'title'             => $object->getTitle(),
            'name'              => $object->getName(),
            'widget'            => $object->getWidget(),
            'sortOrder'         => $object->getSortOrder(),
            'showTitle'         => $this->extractValue('bool', $object->isShowTitle()),
            'params'            => $object->getParams(),
            'html'              => $object->getHtml(),
            'enabled'           => $this->extractValue('bool', $object->isEnabled()),
        ];
    }
}
