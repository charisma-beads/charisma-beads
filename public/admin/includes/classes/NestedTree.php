<?php

class NestedTree
{
	private $table;							// database table to query
	private $id;							// id primary key
	private $category_field;				// field name of category
	private $decendants = array();			// holds the decendant query
	private $category = array();			// holds the category query
	private $db;						// holds the database class.
	private $full_tree = array();			// holds the full tree query
	private $linked_table;					// not yet implemented

	function __construct ($table, $id=null, $field=null, $db=null)
    {
		$this->table = $table;
		$this->id = $id;
		$this->category_field = $field;
		$this->db = $db;
	}

	private function updateLeft ($lft, $option, $offset)
    {
		switch ($option) {

			case 'add':
				$value = "lft+$offset";
				break;

			case 'minus':
				$value = "lft-$offset";

		}

		mysql_query ("
			UPDATE ".$this->table."
			SET lft=".$value."
			WHERE lft>".$lft.";
		", $this->db);
	}

	private function updateRight ($rgt, $option, $offset)
    {
		switch ($option) {

			case 'add':
				$value = "rgt+$offset";
				break;

			case 'minus':
				$value = "rgt-$offset";

		}

		mysql_query ("
			UPDATE ".$this->table."
			SET rgt=".$value."
			WHERE rgt>".$rgt.";
		", $this->db);
	}

	private function getPosition ($id, $option)
    {
		switch ($option) {

			case 'left':
				$select = "lft";
				break;

			case 'right':
				$select = "rgt";
				break;

			case 'both':
				$select = "lft, rgt";

		}

		$result = mysql_query ("
			SELECT ".$select.", rgt - lft + 1 AS width
			FROM ".$this->table."
			WHERE ".$this->category_field."_id=".$id."
		", $this->db);

		$row = mysql_fetch_assoc ($result);

		return $row;
	}

	private function addCategory ($lft_rgt, $update)
    {
		// Add Category.
		$insert = NULL;
		$value = NULL;

		foreach ($update as $field => $values) {

			$insert .= $field.",";
			if (is_numeric ($values) || $values == 'NULL') {
				$value .= $values.", ";
			} else {
				$value .= "'$values', ";
			}

		}

		mysql_query ("
			INSERT INTO ".$this->table." (".$insert." lft, rgt)
			VALUES (".$value." ".$lft_rgt." + 1, ".$lft_rgt." + 2)
		", $this->db);

		return mysql_insert_id($this->db);
	}

	public function insert ($id, $update, $position)
    {
		$this->queryTree();

		if ($this->numTree() > 0) {
			$num = TRUE;
		} else {
			$num = FALSE;
		}

		switch ($position) {

			case 'new child':
 				if ($num == TRUE && $id != 0) {
					$row = $this->getPosition ($id, 'left');
				} else {
					$row['lft'] = 0;
				}
				$insert_id = $this->insertBefore ($row, $update);
				break;

			case 'after child':
				if ($num == TRUE && $id != 0) {
					$row = $this->getPosition ($id, 'right');
				} else {
					$row['rgt'] = 0;
				}
				$insert_id = $this->insertAfter ($row, $update);
				break;

		}

		return $insert_id;
	}

	private function insertBefore ($row, $update)
    {
		$this->updateRight ($row['lft'], 'add', 2);

		$this->updateLeft ($row['lft'], 'add', 2);

		$insert_id = $this->addCategory ($row['lft'], $update);

		return $insert_id;
	}

	private function insertAfter ($row, $update)
    {
		$this->updateRight ($row['rgt'], 'add', 2);

		$this->updateLeft ($row['rgt'], 'add', 2);

		$insert_id = $this->addCategory ($row['rgt'], $update);

		return $insert_id;
	}

	// delete a record and it children.
	public function removeAll ($id)
    {
		$row = $this->getPosition ($id, 'both');

		mysql_query ("
			DELETE FROM ".$this->table."
			WHERE lft BETWEEN ".$row['lft']." AND ".$row['rgt']."
		", $this->db);

		$this->updateRight ($row['rgt'], 'minus', $row['width']);

		$this->updateLeft ($row['rgt'], 'minus', $row['width']);
	}

	// returns the tree and it's depth.
	private function queryTree ($limit=NULL)
    {
		// reset the tree array.
		$this->full_tree = array();

		/*
		SELECT child.*, (COUNT(parent.category) - 1) AS depth
		FROM product_category AS child, product_category AS parent
		WHERE child.lft BETWEEN parent.lft AND parent.rgt
		GROUP BY child.category_id
		ORDER BY child.lft
		*/

		$result = mysql_query ("
			SELECT child.*, (COUNT(parent.".$this->category_field.") - 1) AS depth
			FROM ".$this->table." AS child, ".$this->table." AS parent
			WHERE child.lft BETWEEN parent.lft AND parent.rgt
			GROUP BY child.category_id
			ORDER BY child.lft
			".$limit."
		", $this->db);

		while ($row = mysql_fetch_assoc($result)) {
			$this->full_tree[] = $row;
		}

        mysql_free_result($result);
	}

	// returns the tree as an array and it's depth.
	public function getTree ($limit=NULL)
    {
		if (!$this->full_tree || $limit != NULL) $this->queryTree($limit);

		return $this->full_tree;
	}

	// returns number of rows returned by tree query.
	public function numTree ($limit=NULL)
    {
		if (!$this->full_tree || $limit != NULL) $this->queryTree($limit);

		$c = count ($this->full_tree);

		return $c;
    }

	// find pathway of a category.
	public function pathway ($id)
    {
		$result = mysql_query ("
			SELECT parent.*
			FROM ".$this->table." AS child,
			".$this->table." AS parent
			WHERE child.lft BETWEEN parent.lft AND parent.rgt
			AND child.".$this->category_field."_id = ".$id."
			ORDER BY parent.lft;
		", $this->db);

        if(is_resource($result) && mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc ($result)) {

                $pathway[$row[$this->category_field.'_id']] = $row;

            }

            mysql_free_result($result);
            return $pathway;
        }
        return array();
	}

	// set field id.
	public function setId ($id)
    {
		$this->id = $id;
	}

	// makes a query on the category database.
	public function getCategory ($id=NULL)
    {
		if ($id == NULL) $id = $this->id;

		if (is_numeric ($id)) {

			$where = "WHERE ".$this->category_field."_id=".$id;

		} else {

			$where = "WHERE ".$this->category_field."='".$id."'";

		}

		$result = mysql_query ("
			SELECT *
			FROM ".$this->table."
			".$where."
		", $this->db);

		$this->category = mysql_fetch_assoc($result);

        $num_rows = mysql_num_rows($result);

		mysql_free_result($result);

		return $num_rows;
	}

	// returns a category field.
	public function getField ($field)
    {
		return $this->category[$field];
	}

	// returns the tree as an array and it's depth.
	public function getDecendants ($immediate_sub=FALSE)
    {
		$this->queryDecendants ($immediate_sub);

		return $this->decendants;
	}

	// returns number of rows returned by decendant query.
	public function numDecendants ($immediate_sub=FALSE)
    {
		$this->queryDecendants ($immediate_sub);

		$c = count ($this->decendants);

		return $c;
	}

	// returns all decendants and thier depth.
	private function queryDecendants ($immediate_sub=FALSE)
    {
		// reset the decendants array.
		$this->decendants = array();

		$query = "
			SELECT child.*, (COUNT( parent.".$this->category_field." ) - ( sub_tree.depth +1 )) AS depth
			FROM ".$this->table." AS child, ".$this->table." AS parent, ".$this->table." AS sub_parent, (
				SELECT child.".$this->category_field.", (COUNT( parent.".$this->category_field.") -1) AS depth
				FROM ".$this->table." AS child, ".$this->table." AS parent
				WHERE child.lft BETWEEN parent.lft AND parent.rgt
				AND child.".$this->category_field."_id = ".$this->id."
				GROUP BY child.".$this->category_field."
				ORDER BY child.lft
			) AS sub_tree
			WHERE child.lft BETWEEN parent.lft AND parent.rgt
			AND child.lft BETWEEN sub_parent.lft AND sub_parent.rgt
			AND sub_parent.".$this->category_field."= sub_tree.".$this->category_field."
			GROUP BY child.category_id ";
			if ($immediate_sub) $query .= "HAVING depth = 1 ";
			$query .= "ORDER BY child.lft";

		$result = mysql_query($query, $this->db);

        if (is_resource($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $this->decendants[] = $row;
            }

            mysql_free_result($result);
        }
	}

}

?>