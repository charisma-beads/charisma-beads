<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Model\Voucher;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

/**
 * Class CategoryMap
 *
 * @package Shop\Model\Voucher
 */
class CategoryMap implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $voucherId;

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @return int
     */
    public function getVoucherId(): int
    {
        return $this->voucherId;
    }

    /**
     * @param int $voucherId
     * @return CategoryMap
     */
    public function setVoucherId(int $voucherId): CategoryMap
    {
        $this->voucherId = $voucherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return CategoryMap
     */
    public function setCategoryId(int $categoryId): CategoryMap
    {
        $this->categoryId = $categoryId;
        return $this;
    }
}