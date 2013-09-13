<?php
namespace Shop\View;

use Zend\Form\View\Helper\AbstractHelper;

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
			
			$html .= '<li><a href="' . $urlHelper('shop') . '">Shop Front</a><span class="divider">/</span></li>';
			
			foreach ($bread as $category) {
				
				$href = $urlHelper('shop/catalog', array(
					'categoryIdent' => $category->ident,
				));
				
				if (null === $product && $this->view->category->ident !== $category->ident) {
					$crumbs[] = '<li><a href="' . $href . '">' . $escapeHtml($category->category) . '</a> <span class="divider">/</span></li>';
				} else {
					$crumbs[] = '<li class="active">' . $escapeHtml($category->category) . '</li>';
				}
			}
		
			if (null !== $product) {
				$crumbs[] = '<li class="active">' . $escapeHtml($product->name) . '</li>';
			}
			
			$html .= implode(' ', $crumbs);
			
			$html .= '</ul>';
		
			return $html;
		}
	}
}
