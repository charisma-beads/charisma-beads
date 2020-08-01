<?php

namespace Shop\View;

use Shop\Form\Element\ProductOptionsList;
use Shop\Model\ProductModel;
use Common\View\AbstractViewHelper;

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