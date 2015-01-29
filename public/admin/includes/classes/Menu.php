<?php /* Created on: 07/11/2005 */ 

// Navigaion bar function.
class Menu
{
	public $menu;
    private $db;
	
	function __construct($db)
	{
        $this->db = $db;
		$this->navi_bar('Main', 0);
	}
	
	function __toString()
	{
		return $this->menu;
	}
	
	function shop_menu()
	{	
		$tree = new NestedTree('product_category', 0, 'category', $this->db);
		
		// Retrieve all children
		$row = $tree->getTree(null, false, false);
		
		foreach ($row as $key => $value) {
			//$url = '/shop/'.encodeurl($row[$key]['category']);
			$url = '/shop/'.$row[$key]['ident'];
			$this->menu .= "<li>";
			$this->menu .= "<a href=\"$url\">".$row[$key]['category']."</a>";

			$children = (($row[$key]['rgt'] - $row[$key]['lft']) - 1) / 2;

			if ($children > 0) $this->menu .= "<ul>";

			if ($row[$key]['depth'] > 0) {

				// find the end of the array.
				$end = end($row);
				// closures
				if ($row[$key]['category_id'] == $end['category_id']) {
					$this->menu .= str_repeat("</li></ul>", $row[$key]['depth']);
					$this->menu .= "</li>";
				} else if ($row[$key + 1]['depth'] < $row[$key]['depth']) {
					$this->menu .= str_repeat("</li></ul>", ($row[$key]['depth'] - $row[$key + 1]['depth']));
					$this->menu .= "</li>";
				} else {
					if ($children == 0) $this->menu .= "</li>";
				}
			} else {
				if ($children == 0) $this->menu .= "</li>";
			}
		}
	}
	
	function navi_bar ($parent, $level)
	{
		global $https;
			
		// Retrieve all children
		
		$status = (isset($_SESSION['cid']) || isset ($_SESSION['mid'])) ? "LI" : "LO";
		
		$result = mysql_query ('
			SELECT links_id, title, url, parent, sub_menu, status, (
				SELECT funct 
				FROM menu_parent as sp 
				WHERE sp.parent=title
			) as funct
			FROM menu_links AS l, menu_parent AS p, menu_link_status AS s
			WHERE l.parent_id=p.parent_id 
			AND p.parent="' . $parent . '"
			AND l.status_id=s.status_id ORDER BY l.sort_order;
		', $this->db);
		
		if ($level == 0) { // Main menu start.
			$this->menu .= "<ul id=\"navi\" class=\"menu\">\r\n\r\n";
		}
			
		// Display each menu.
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			
			//$row['url'] = urlencode($row['url']);
			
			if ($row['sub_menu'] == 1 && $status == "LI" && $row['status'] == "LI") { // Print Menu heading.
						
				$this->menu .= ("<li><a href=\"/{$row['url']}\">{$row['title']}</a>\r\n<ul>");
				
				if ($row['funct']) $this->$row['funct']();
					
				// Call this function again to display this child's children
				$this->navi_bar ($row['title'], $level + 1);
						
			} elseif ($row['sub_menu'] == 1 && $row['status'] == "A") { // Print Menu heading.
						
				$this->menu .= ("<li><a href=\"/{$row['url']}\">{$row['title']}</a>\r\n<ul>");
				
				if ($row['funct']) $this->$row['funct']();
					
				// Call this function again to display this child's children
				$this->navi_bar ($row['title'], $level + 1);
						
			} else {
					
				if ($level > 0) { // Print submenu.
					$this->menu .= ("<li><a href=\"/{$row['url']}\">{$row['title']}</a></li>\r\n");
	
				} else { // Print Main Menu.
					
					if ($status == "LI" && $row['status'] == "LI") {
						$this->menu .= ("<li><a href=\"/{$row['url']}\">{$row['title']}</a></li>\r\n\r\n"); 
					}
					
					if ($status == "LO" && $row['status'] == "LO") {
						$this->menu .= ("<li><a href=\"$https/{$row['url']}\">{$row['title']}</a></li>\r\n\r\n"); 
					}
					
					if ($row['status'] == "A"){
						$this->menu .= ("<li><a href=\"/{$row['url']}\">{$row['title']}</a></li>\r\n\r\n");
					}
				}
			}
		}
			
		$this->menu .= "</ul>\r\n"; // Menu Ends.
		if ($level > 0) $this->menu .= "</li>\r\n";
	}	
}

?>
