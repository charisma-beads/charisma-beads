<?php

declare(strict_types=1);

namespace ThemeManager\Mapper;

use Common\Mapper\AbstractDbMapper;
use ThemeManager\Model\WidgetModel;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Select;

class WidgetMapper extends AbstractDbMapper
{
    protected $table = 'widget';
    protected $primary = 'widgetId';

    public function getWidgetByName(string $name): WidgetModel
    {
        $select = $this->getSelect();
        $select->where
            ->equalTo('name', $name)
            ->and->equalTo('enabled', 1);

        $rowSet = $this->fetchResult($select);
        $row = $rowSet->current();

        return $row;
    }

    public function getWidgetsByGroupId(int $id): HydratingResultSet
    {
        $select = $this->getSelect();
        $select->where
            ->equalTo('widgetGroupId', $id)
            ->and->equalTo('enabled', 1);
        $select->order('sortOrder ' . Select::ORDER_ASCENDING);

        $rowSet = $this->fetchResult($select);
        return $rowSet;
    }
}
