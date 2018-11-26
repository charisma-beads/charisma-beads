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

use Shop\Form\Element\ProductOptionsList;
use Shop\Model\ProductModel;
use UthandoCommon\View\AbstractViewHelper;

/**
 * Class ProductOptions
 *
 * @package Shop\View
 */
class ProductOptions extends AbstractViewHelper
{
    public function __invoke(ProductModel $product)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $formManager = $sl->get('FormElementManager');

        $options = $formManager->get(ProductOptionsList::class, [
            'name' => 'ProductOptionList',
            'product' => $product,
        ]);

        $select = $this->view->plugin('formSelect');

        return $select($options);
    }
} 