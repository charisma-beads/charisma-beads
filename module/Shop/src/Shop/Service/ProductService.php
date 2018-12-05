<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Product
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\ProductForm;
use Shop\Hydrator\ProductHydrator;
use Shop\InputFilter\ProductInputFilter;
use Shop\Mapper\ProductMapper;
use Shop\Model\ProductModel;
use UthandoCommon\Service\AbstractRelationalMapperService;
use Zend\EventManager\Event;

/**
 * Class Product
 *
 * @package Shop\Service
 * @method ProductMapper getMapper($mapperClass = null, array $options = [])
 */
class ProductService extends AbstractRelationalMapperService
{
    protected $form         = ProductForm::class;
    protected $hydrator     = ProductHydrator::class;
    protected $inputFilter  = ProductInputFilter::class;
    protected $mapper       = ProductMapper::class;
    protected $model        = ProductModel::class;

    protected $tags = [
        'image', 'option', 'product',
    ];

    protected $referenceMap = [
        'productCategory' => [
            'refCol' => 'productCategoryId',
            'service' => ProductCategoryService::class,
        ],
        'productSize' => [
            'refCol' => 'productSizeId',
            'service' => ProductSizeService::class,
        ],
        'taxCode' => [
            'refCol' => 'taxCodeId',
            'service' => TaxCodeService::class,
        ],
        'postUnit' => [
            'refCol' => 'postUnitId',
            'service' => PostUnitService::class,
        ],
        'productGroup' => [
            'refCol' => 'productGroupId',
            'service' => ProductGroupService::class,
        ],
        'productImage' => [
            'refCol' => 'productId',
            'service' => ProductImageService::class,
            'getMethod' => 'getImagesByProductId',
        ],
        'productOption' => [
            'refCol' => 'productId',
            'service' => ProductOptionService::class,
            'getMethod' => 'getOptionsByProductId',
        ],
    ];

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
     * @return \Shop\Model\ProductModel
     */
    public function getProductByIdent($ident)
    {
        /* @var $mapper \Shop\Mapper\ProductMapper */
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
        /* @var $mapper ProductMapper */
        $mapper = $this->getMapper();

        /* @var $categoryService ProductCategoryService */
        $categoryService = $this->getRelatedService('productCategory');

        if (is_string($category)) {
            /* @var $cat \Shop\Model\ProductCategoryModel */
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
            /* @var $categoryService ProductCategoryService */
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

        /* @var $mapper ProductMapper */
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
     * @throws \UthandoCommon\Service\ServiceException
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
