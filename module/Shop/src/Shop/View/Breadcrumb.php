<?php
namespace Shop\View;

use Zend\View\Helper\AbstractHelper;

class Breadcrumb extends AbstractHelper
{
	public function __invoke($product=null)
	{
		if ($this->view->bread) {
			$crumbs = array();
			$bread = $this->view->bread;
			$urlHelper = $this->view->plugin('url');
			$escapeHtml = $this->view->plugin('escapeHtml');
			
			$html = '<ul class="breadcrumb">';
			
			$html .= '<li><a href="' . $urlHelper('shop') . '">Shop Front</a></li>';
			
			foreach ($bread as $category) {
				
				$href = $urlHelper('shop/catalog', array(
					'categoryIdent' => $category->getIdent(),
				));
				
				if (null === $product && $this->view->category->getIdent() !== $category->getIdent()) {
					$crumbs[] = '<li><a href="' . $href . '">' . $escapeHtml($category->getCategory()) . '</a></li>';
				} else {
					$crumbs[] = '<li class="active">' . $escapeHtml($category->getCategory()) . '</li>';
				}
			}
		
			if (null !== $product) {
				$crumbs[] = '<li class="active">' . $escapeHtml($product->getName()) . '</li>';
			}
			
			$html .= implode(' ', $crumbs);
			
			$html .= '</ul>';
		
			return $html;
		}
	}
}
