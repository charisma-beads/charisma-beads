<?php
namespace Shop\View;

use Zend\View\Helper\AbstractHelper;

class ProductTableRowState extends AbstractHelper
{
    /**
     * @param \Shop\Model\Product\Product||shop\Model\Product\Category $model
     * @return string
     */
    public function __invoke($model)
    {
        if ($model->getDiscontinued()) {
            return 'danger';
        }
        
        if (!$model->getEnabled()) {
            return 'warning';
        }
        
        return '';
    }
}
