<?php

namespace Shop\View;

use Shop\Model\Product\Product;
use UthandoCommon\View\AbstractViewHelper;

class ProductOptions extends AbstractViewHelper
{
    public function __invoke(Product $product)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $formManager = $sl->get('FormElementManager');

        $options = $formManager->get('ProductOptionList', [
            'product' => $product,
        ]);

        $select = $this->view->plugin('formSelect');

        return $select($options);
    }
} 