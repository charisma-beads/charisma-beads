<?php

namespace Application\Model\DbTable;

use Application\Model\DbTable\AbstractTable;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;

abstract class AbstractNestedSet extends AbstractTable
{
    /**
     * Gets the full tree from database
     * 
     * @param bool $topLevelOnly
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getFullTree($topLevelOnly=false)
    {   
        $select = $this->sql->select();
        $select->from(array('child' => $this->table))
            ->columns(array(
                Select::SQL_STAR,
                'depth' => new Expression('(COUNT(parent.'.$this->primary.') - 1)')
            ))
            ->join(
                array('parent' => $this->table),
                'child.lft BETWEEN parent.lft AND parent.rgt',
                array(),
                Select::JOIN_INNER
            )
            ->group('child.'.$this->primary)
            ->order('child.lft');
		
        if (true === $topLevelOnly) {
        	$select->having('depth = 0');;
        }
        
        return $this->fetchResult($select);
    }

    /**
     * Get the pathway of of the child by its id.
     * 
     * @param int $id
     */
    public function getPathwayByChildId($id)
    {
    	
        $select = $this->sql->select();
        $select->from(array('child' => $this->table))
        	->columns(array())
            ->join(
                array('parent' => $this->table),
                'child.lft BETWEEN parent.lft AND parent.rgt', 
                array(Select::SQL_STAR),
                Select::JOIN_INNER
            )
            ->where(array('child.'.$this->primary.' = ?' => $id))
            ->order('parent.lft');
        
        return $this->fetchResult($select);
    }
    
    /**
     *  
        SELECT `child`.*, (COUNT(`parent`.`productCategoryId`) - (`subTree`.`depth` + 1)) AS `depth` 
		FROM `productCategory` AS `child` 
		INNER JOIN `productCategory` AS `parent` ON `child`.`lft` BETWEEN `parent`.`lft` AND `parent`.`rgt` 
		INNER JOIN `productCategory` AS `subParent` ON `child`.`lft` BETWEEN `subParent`.`lft` AND `subParent`.`rgt` 
		INNER JOIN (
			SELECT `child`.`productCategoryId`, (COUNT(`parent`.`productCategoryId`) - 1) AS `depth` 
		        FROM `productCategory` AS `child` 
		        INNER JOIN `productCategory` AS `parent` ON `child`.`lft` BETWEEN `parent`.`lft` AND `parent`.`rgt` 
		        WHERE `child`.`productCategoryId` = '2' 
		        GROUP BY `child`.`productCategoryId` 
		        ORDER BY `child`.`lft` ASC
		) AS `subTree` ON `subParent`.`productCategoryId` = `subTree`.`productCategoryId` 
		GROUP BY `child`.`productCategoryId` 
		ORDER BY `child`.`lft` ASC
     * 
     * @param int $parentId
     * @param string $immediate
     */
    public function getDecendentsByParentId($parentId, $immediate=true)
    {
        $subTree = $this->sql->select()
            ->from(array('child' => $this->table))
            ->columns(array(
            	'productCategoryId',
            	'depth' => new Expression('(COUNT(parent.'.$this->primary.') - 1)')
            ))
            ->join(
                array('parent' => $this->table),
                'child.lft BETWEEN parent.lft AND parent.rgt',
                array(),
                Select::JOIN_INNER
            )
            ->where(array('child.'.$this->primary.' = ?' => $parentId))
            ->group('child.'.$this->primary)
            ->order('child.lft');
    
        $select = $this->sql->select()
            ->from(array('child' => $this->table))
            ->columns(array(
            	Select::SQL_STAR,
            	'depth' => new Expression('(COUNT(parent.'.$this->primary.') - (subTree.depth + 1))')
            ))
            ->join(
                array('parent' => $this->table),
                'child.lft BETWEEN parent.lft AND parent.rgt',
                array(),
                Select::JOIN_INNER
            )
            ->join(
                array('subParent' => $this->table),
                'child.lft BETWEEN subParent.lft AND subParent.rgt',
                array(),
                Select::JOIN_INNER
            )
            ->join(
                array('subTree' => $subTree),
                'subParent.'.$this->primary.' = subTree.'.$this->primary,
                array(),
                Select::JOIN_INNER
            )
            ->group('child.'.$this->primary)
            ->order('child.lft');
    
        if (true === $immediate) {
            $select->having('depth = 1');
        }
    
        return $this->fetchResult($select);
    }
    
    /**
     * Updates right values of tree
     * 
     * @param int $rgt
     * @param string $option
     * @param int $offset
     */
    protected function updateRight($rgt, $option, $offset)
    {
        $operator = (($option === 'add') ? '+' : '-');
        $data = array(
            'rgt' => new Expression('rgt ' . $operator . ' ' . $offset)
        );
        
        $where = new Where();
        $where->greaterThan('rgt', $rgt);
        
        return $this->tableGateway->update($data, $where);
    }
    
    /**
     * Update left values of tree
     * 
     * @param int $lft
     * @param string $option
     * @param int $offset
     */
    protected function updateLeft($lft, $option, $offset)
    {
        $operator = (($option === 'add') ? '+' : '-');
        $data = array(
            'lft' => new Expression('lft ' . $operator . ' ' . $offset)
        );
        
        $where = new Where();
        $where->greaterThan('lft', $lft);
        
        return $this->tableGateway->update($data, $where);
    }
    
    /**
     * Get the position of a child in the tree
     * 
     * @param int $id
     * @param string $option
     * @return array
     */
    protected function getPosition($id, $option)
    {
        $cols = array('width' => new Expression('rgt - lft + 1'));
        
        switch ($option) {
            case 'left':
                $cols[] = 'lft';
                break;
        
            case 'right':
                $cols[] = 'rgt';
                break;
        
            case 'both':
                $cols[] = 'lft';
                $cols[] = 'rgt';
                break;
        }
        
        $select = $this->sql->select($this->table);
        
        $where = new Where();
        $where->equalTo($this->primary, $id);
        $select->columns($cols)->where($where);
        
        $row = $this->fetchResult($select)->current();
        
        return $row;
    }
    
    /**
     * Adds a new record.
     * 
     * @param unknown $lft_rgt
     * @param unknown $data
     */
    protected function addRow($lft_rgt, $data)
    {
        $data['lft'] = $lft_rgt + 1;
        $data['rgt'] = $lft_rgt + 2;
        
        return $this->tableGateway->insert($data);
    }
    
    /**
     * Inserts a row after given id
     * 
     * @param array|object $row
     * @param array $data
     * @return int
     */
    protected function insertAfter($row, $data)
    {
        $rgt = (is_array($row)) ? $row['rgt'] : $row->rgt;
        
        $this->updateRight($rgt, 'add', 2);
        $this->updateLeft($rgt, 'add', 2);
        
        $insertId = $this->addRow($rgt, $data);
        
        return $insertId;
    }
    
    /**
     * Inserts a row before given id
     * 
     * @param array|object $row
     * @param array $data
     * @return int
     */
    protected function insertBefore($row, $data)
    {
        $lft = (is_array($row)) ? $row['lft'] : $row->lft;
        
        $this->updateRight($lft, 'add', 2);
        $this->updateLeft($lft, 'add', 2);
        
        $insertId = $this->addRow($lft, $data);
        
        return $insertId;
    }
    
    /**
     * Insert a row into tree
     * 
     * @param array $data
     * @param number $position
     * @param string $insertType
     * @return int
     */
    public function insert(array $data, $position = 0, $insertType = 'insert')
    {
        $num = $this->fetchAll()->count();
        $row = array();
        
        switch ($insertType) {
            case 'insertSub':
                if ($num && $position != 0) {
                    $row = $this->getPosition($position, 'left');
                } else {
                    $row['lft'] = 0;
                }

                $insertId = $this->insertBefore($row, $data);
                break;
                
            case 'insert':
                if ($num && $position != 0) {
                    $row = $this->getPosition($position, 'right');
                } else {
                    $row['rgt'] = 0;
                }
                
                $insertId = $this->insertAfter($row, $data);
                break;
        }
        
        return $insertId;
    }
    
    /**
     * Deletes a row from tree.
     * 
     * @param unknown $id
     * @return boolean
     */
    public function delete($id)
    {
        $row = $this->getPosition ($id, 'both');
        
        $where = new Where();
        $where->between('lft', $row->lft, $row->rgt);
        $result = $this->tableGateway->delete($where);
        
        if ($result) {
            $this->updateRight ($row->rgt, 'minus', $row->width);
            $this->updateLeft ($row->rgt, 'minus', $row->width);
            return true;
        } else {
            return false;
        }
    }
}
