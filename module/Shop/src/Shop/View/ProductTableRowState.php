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
 * Class ProductTableRowState
 *
 * @package Shop\View
 */
class ProductTableRowState extends AbstractHelper
{
    /**
     * @param \Shop\Model\Product\Product||shop\Model\Product\Category $model
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
