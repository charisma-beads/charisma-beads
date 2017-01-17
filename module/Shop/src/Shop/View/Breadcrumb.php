<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link      https://github.com/uthando-cms for the canonical source repository
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\View;

use Zend\View\Helper\AbstractHelper;

/**
 * Class Breadcrumb
 *
 * @package Shop\View
 */
class Breadcrumb extends AbstractHelper
{
	public function __invoke($product=null)
	{
        $crumbs = [];
        $bread = $this->view->bread;

        $urlHelper = $this->view->plugin('url');
        $escapeHtml = $this->view->plugin('escapeHtml');

        $html = '<ul class="breadcrumb">';

        $html .= '<li><a href="' . $urlHelper('shop') . '">Shop Front</a></li>';

        foreach ($bread as $category) {

            $href = $urlHelper('shop/catalog', [
                'categoryIdent' => $category->getIdent(),
            ]);

            if ($product || $this->view->category->getIdent() !== $category->getIdent()) {
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
