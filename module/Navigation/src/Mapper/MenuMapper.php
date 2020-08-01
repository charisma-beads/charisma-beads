<?php

namespace Navigation\Mapper;

use Common\Mapper\AbstractDbMapper;


class MenuMapper extends AbstractDbMapper
{
	protected $table = 'menu';
	protected $primary = 'menuId';

    /**
     * @param int $menu
     * @return null|\Navigation\Model\MenuModel
     */
	public function getMenu($menu)
	{
	    $select = $this->getSelect()->where(['menu' => $menu]);
        $rowSet = $this->fetchResult($select);
	    $row = $rowSet->current();
	    return $row;
	}
}
