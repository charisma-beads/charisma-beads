<?php

declare(strict_types=1);

namespace ThemeManager\Mapper;

use Common\Mapper\AbstractDbMapper;
use ThemeManager\Model\WidgetGroupModel;

class WidgetGroupMapper extends AbstractDbMapper
{
    protected $table = 'widgetGroup';
    protected $primary = 'widgetGroupId';

    public function getWidgetGroupByName(string $name)
    {
        $select = $this->getSelect();
        $select->where->equalTo('name', $name);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        return $row;
    }
}
