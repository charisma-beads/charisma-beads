<?php

class SiteMap
{
	public $dom;
	public $root;
	
	function __construct()
	{
		$this->dom = new DOMDocument('1.0', 'utf-8');
		$this->dom->formatOutput = true;
		$this->root = $this->dom->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
		$this->navi_bar('Main', 0);
		$this->dom->appendChild($this->root);
		$this->dom->save($_SERVER['DOCUMENT_ROOT'].'/UserFiles/File/sitemap.xml');
	}
	
	function shop_menu()
	{
		global $dbc;
		global $merchant_website;
		
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/NestedTree.class.php');
		
		$tree = new NestedTree('product_category', $_GET['pcid'], 'category', $dbc);
		
		// Retrieve all children
		$row = $tree->getTree(null, false, false);
		
		foreach ($row as $key => $value) {
// 			$href = $merchant_website.'/shop/'.encodeurl($row[$key]['category']);
			$href = $merchant_website.'/shop/'.$row[$key]['ident'];
			$url = $this->dom->createElement('url');
			$loc = $this->dom->createElement('loc',$href);
			
			$url->appendChild($loc);
			$this->root->appendChild($url);
		}
	}
	
	function navi_bar ($parent, $level)
	{
			
		global $merchant_website;
			
		// Retrieve all children
		
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
		');
			
		// Display each menu.
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			
			if ($row['url'] == '#' || $row['status'] != "A") continue;
			
			$href = $merchant_website.'/'.$row['url'];
			
			$url = $this->dom->createElement('url');
			
			if ($row['sub_menu'] == 1) { // Print Menu heading.
				
				$loc = $this->dom->createElement('loc',$href);
				$url->appendChild($loc);
				$this->root->appendChild($url);
				
				if ($row['funct']) $this->$row['funct']();
					
				// Call this function again to display this child's children
				$this->navi_bar ($row['title'], $level + 1);
				
			} else {
				$loc = $this->dom->createElement('loc',$href);
				$url->appendChild($loc);
				$this->root->appendChild($url);
			}
		}
	}
}

?>