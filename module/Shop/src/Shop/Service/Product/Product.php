<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Product;

use Shop\Model\Product\Product as ProductModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\EventManager\Event;

/**
 * Class Product
 *
 * @package Shop\Service\Product
 * @method \Shop\Mapper\Product\Product getMapper($mapperClass = null, array $options = [])
 */
class Product extends AbstractRelationalMapperService
{
    protected $serviceAlias = 'ShopProduct';

    protected $tags = [
        'image', 'option',
    ];

    protected $referenceMap = [
        'productCategory' => [
            'refCol' => 'productCategoryId',
            'service' => 'ShopProductCategory',
        ],
        'productSize' => [
            'refCol' => 'productSizeId',
            'service' => 'ShopProductSize',
        ],
        'taxCode' => [
            'refCol' => 'taxCodeId',
            'service' => 'ShopTaxCode',
        ],
        'postUnit' => [
            'refCol' => 'postUnitId',
            'service' => 'ShopPostUnit',
        ],
        'productGroup' => [
            'refCol' => 'productGroupId',
            'service' => 'ShopProductGroup',
        ],
        'productImage' => [
            'refCol' => 'productId',
            'service' => 'ShopProductImage',
            'getMethod' => 'getImagesByProductId',
        ],
        'productOption' => [
            'refCol' => 'productId',
            'service' => 'ShopProductOption',
            'getMethod' => 'getOptionsByProductId',
        ],
    ];

    /**
     * @var bool
     */
    protected $populate = true;

    /**
     * @param bool $bool
     * @return $this
     */
    public function setPopulate(bool $bool)
    {
        $this->populate = $bool;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPopulate() : bool
    {
        return $this->populate;
    }

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form'
        ], [$this, 'setProductIdent']);
    }

    /**
     * @param string $ident
     * @return \Shop\Model\Product\Product
     */
    public function getProductByIdent($ident)
    {
        /* @var $mapper \Shop\Mapper\Product\Product */
        $mapper = $this->getMapper();
        $product = $mapper->getProductByIdent($ident);

        if ($product instanceof ProductModel) {
            $this->populate($product, true);
        }

        return $product;
    }

    /**
     * @param string|int $category
     * @param null $order
     * @param bool $deep
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     * @throws \UthandoCommon\Service\ServiceException
     */
    public function getProductsByCategory($category, $order = null, $deep = true)
    {
        /* @var $mapper \Shop\Mapper\Product\Product */
        $mapper = $this->getMapper();

        /* @var $categoryService \Shop\Service\Product\Category */
        $categoryService = $this->getRelatedService('productCategory');

        if (is_string($category)) {
            /* @var $cat \Shop\Model\Product\Category */
            $cat = $categoryService->getCategoryByIdent($category);
            $categoryId = (null === $cat) ? 0 : $cat->getProductCategoryId();
        } else {
            $categoryId = (int) $category;
        }

        if (true === $deep) {
            $ids = $categoryService->getCategoryChildrenIds(
                $categoryId, true
            );

            $ids[] = $categoryId;
            $categoryId = (null === $ids) ? $categoryId : $ids;
        } else {
            $categoryId = (array) $categoryId;
        }

        $products = $mapper->setFetchEnabled(false)
            ->getProductsByCategory($categoryId, $order);

        if ($this->isPopulate()) {
            foreach ($products as $product) {
                $this->populate($product, true);
            }
        }

        return $products;
    }

    public function search(array $post)
    {
        if (isset($post['productCategoryId']) && $post['productCategoryId'] != '') {
            /* @var $categoryService \Shop\Service\Product\Category */
            $categoryService = $this->getRelatedService('productCategory');
            $categoryService->getMapper()->setFetchEnabled(false);

            $ids = $categoryService->getCategoryChildrenIds(
                $post['productCategoryId'], true
            );

            if (!empty($ids)) {
                $ids[] = $post['productCategoryId'];
            }

            $categoryId = (empty($ids)) ? (array)$post['productCategoryId'] : $ids;

            $post['productCategoryId'] = $categoryId;
        }

        $this->getMapper()->setFetchEnabled(false);

        return parent::search($post);
    }

    /**
     * @param $search
     * @param null $sort
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function searchProducts($search, $sort = null)
    {
        $search = [[
            'searchString' => $search['productSearch'],
            'columns' => [
                'sku', 'name', 'shortDescription', 'productCategory.category'
            ],
        ]];

        /* @var $mapper \Shop\Mapper\Product\Product */
        $mapper = $this->getMapper();

        $products = $mapper->setFetchEnabled(false)
            ->searchProducts($search, $sort);

        foreach ($products as $product) {
            $this->populate($product, true);
        }

        return $products;
    }

    public function getLatestProducts($num)
    {
        $products = $this->getMapper()->getLatestProducts($num);

        foreach ($products as $product) {
            $this->populate($product, true);
        }

        return $products;
    }

    /**
     * Make a new product based on a product.
     *
     * @param int $id
     * @return ProductModel $product
     */
    public function makeDuplicate($id)
    {
        $product = $this->getFullProductById($id);

        $product->setProductId(null)
            ->setSku(null)
            ->setName(null)
            ->setIdent(null);

        return $product;
    }

    /**
     * @param int $id
     * @return array|mixed|\UthandoCommon\Model\ModelInterface|ProductModel
     */
    public function getFullProductById($id)
    {
        $id = (int)$id;
        $product = $this->getById($id);

        $this->populate($product, true);

        return $product;

    }

    /**
     * @param ProductModel $product
     * @return int
     */
    public function toggleEnabled(ProductModel $product)
    {
        $this->removeCacheItem($product->getProductId());

        $enabled = (true === $product->isEnabled()) ? false : true;

        $product->setEnabled($enabled);

        return parent::save($product);
    }

    public function setProductIdent(Event $e)
    {
        $data = $e->getParam('data');

        if (null === $data) {
            return;
        }

        if ($data instanceof ProductModel) {
            $data->setIdent($data->getSku() . ' ' . $data->getName());
        } elseif (is_array($data)) {
            $data['ident'] = $data['sku'] . ' ' . $data['name'];
        }

        $e->setParam('data', $data);
    }
}
