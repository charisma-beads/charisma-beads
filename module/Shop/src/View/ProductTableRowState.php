<?php

namespace Shop\View;

use Shop\Model\ProductModel;
use Laminas\View\Helper\AbstractHelper;

/**
 * Class ProductTableRowState
 *
 * @package Shop\View
 */
class ProductTableRowState extends AbstractHelper
{
    /**
     * @param ProductModel|\Shop\Model\ProductCategoryModel $model
     * @return string
     */
    public function __invoke($model)
    {
        if ($model->isDiscontinued()) {
            return 'danger';
        }
        
        if (!$model->isEnabled()) {
            return 'warning';
        }
        
        return '';
    }
}
