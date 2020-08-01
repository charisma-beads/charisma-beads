<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;

/**
 * Class ProductCategory
 *
 * @package Shop\Model
 */
class VoucherProductCategoryModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return VoucherProductCategoryModel
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }
}