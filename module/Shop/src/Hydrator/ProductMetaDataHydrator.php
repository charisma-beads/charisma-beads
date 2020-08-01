<?php

namespace Shop\Hydrator;

use Shop\Hydrator\Strategy\OptionStrategy;
use Shop\Hydrator\Strategy\PostUnitStrategy;
use Shop\Hydrator\Strategy\ProductImageStrategy;
use Common\Hydrator\BaseHydrator;

/**
 * Class MetaData
 *
 * @package Shop\Hydrator
 */
class ProductMetaDataHydrator extends BaseHydrator
{
    protected $map = [
        'productId'         => 'productId',
        'sku'               => 'sku',
        'name'              => 'name',
        'postUnit'          => 'postUnit',
        'productImage'      => 'image',
        'productCategory'   => 'category',
        'shortDescription'  => 'description',
        'taxable'           => 'taxable',
        'vatInc'            => 'vatInc',
        'addPostage'        => 'addPostage',
        'showImage'         => 'showImage',
        'productOption'     => 'option',
    ];

    /**
     * @var int
     */
    protected $optionId;

    public function __construct($optionId = null)
    {
        parent::__construct();

        $optionStrategy = new OptionStrategy();
        $optionStrategy->setOptionId($optionId);
        $this->addStrategy('postUnit', new PostUnitStrategy());
        $this->addStrategy('option', $optionStrategy);
        $this->addStrategy('image', new ProductImageStrategy());
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @param int $optionId
     * @return $this
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;
        return $this;
    }
}
