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

use Shop\Form\ProductCategoryForm;
use Shop\Hydrator\ProductCategoryHydrator;
use Shop\InputFilter\ProductCategoryInputFilter;
use Shop\Mapper\ProductCategoryMapper;
use Shop\Model\ProductCategoryModel;
use Shop\ShopException;
use Common\Model\ModelInterface;
use Common\Service\AbstractMapperService;
use Zend\EventManager\Event;
use Zend\Form\Form;

/**
 * Class Category
 *
 * @package Shop\Service
 * @method ProductCategoryModel getById($id, $col = null)
 * @method ProductCategoryMapper getMapper($mapperClass = null, array $options = [])
 */
class ProductCategoryService extends AbstractMapperService
{
    protected $form         = ProductCategoryForm::class;
    protected $hydrator     = ProductCategoryHydrator::class;
    protected $inputFilter  = ProductCategoryInputFilter::class;
    protected $mapper       = ProductCategoryMapper::class;
    protected $model        = ProductCategoryModel::class;

    /**
     * @var array
     */
    protected $tags = [
        'product', 'option',
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form'
        ], [$this, 'preForm']);
    }

    /**
     * @param $parentId
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getCategoriesByParentId($parentId)
    {
        $parentId = (int)$parentId;
        $mapper = $this->getMapper();

        return ($parentId != 0) ? $mapper->getSubCategoriesByParentId($parentId) : $this->fetchAll(true);
    }

    /**
     * @param bool $topLevelOnly
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function fetchAll($topLevelOnly = false)
    {
        $mapper = $this->getMapper();

        if ($topLevelOnly) {
            $cats = $mapper->getTopLevelCategories();
        } else {
            $cats = $mapper->getAllCategories();
        }

        return $cats;
    }

    /**
     * @param string $ident
     * @return \Shop\Model\ProductCategoryModel|false
     */
    public function getCategoryByIdent($ident)
    {
        $ident = (string) $ident;
        $mapper = $this->getMapper();
        $cat = $mapper->getCategoryByIdent($ident);

        return $cat;
    }

    /**
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $post)
    {
        foreach ($post as $key => $value) {
            if ($key == 'category') {
                $key = preg_replace('(\w+)', 'child.$0', $key);
                $post[$key] = $value;
                unset($post['category']);
            }
        }

        return parent::search($post);
    }

    /**
     * @param array $post
     * @param Form $form
     * @return int|Form
     */
    public function add(array $post, Form $form = null)
    {
        if (!$post['ident']) {
            $post['ident'] = $post['category'];
        }

        /* @var $mapper ProductCategoryMapper */
        $mapper = $this->getMapper();

        /* @var $model \Shop\Model\ProductCategoryModel */
        $model = $mapper->getModel();

        $form = $this->prepareForm($model, $post, true, true);

        if (!$form->isValid()) {
            return $form;
        }

        $data = $mapper->extract($form->getData());

        $pk = $this->getMapper()->getPrimaryKey();
        unset($data[$pk]);

        $position = (int)$post['parent'];
        $insertType = (string)$post['categoryInsertType'];

        $result = $mapper->insertRow($data, $position, $insertType);

        return $result;
    }

    /**
     * @param ProductCategoryModel|ModelInterface $model
     * @param array $post
     * @param Form $form
     * @return int|Form
     *@throws \Common\Service\ServiceException
     * @throws ShopException
     */
    public function edit(ModelInterface $model, array $post, Form $form = null)
    {
        if (!$model instanceof ProductCategoryModel) {
            throw new ShopException('$model must be an instance of Shop\Model\Product\Category, ' . get_class($model) . ' given.');
        }

        if (!$post['ident']) {
            $post['ident'] = $post['category'];
        }

        $model->setDateModified();

        $form = $this->prepareForm($model, $post, true, true);

        if (!$form->isValid()) {
            return $form;
        }

        $category = $this->getById($model->getProductCategoryId());

        $data = $this->getMapper()
            ->extract($form->getData());

        if ($category) {
            if ('noInsert' !== $post['categoryInsertType']) {

                $position = (int)$post['parent'];
                $insertType = (string)$post['categoryInsertType'];

                $result = $this->getMapper()->move($data, $position, $insertType);

            } else {
                $result = $this->save($model);
            }
            $this->removeCacheItem($model->getProductCategoryId());
        } else {
            throw new ShopException('Product Category id does not exist');
        }

        // cascade enabled and/or discontinued if needed.
        if ($result) {
            $ids = $this->getCategoryChildrenIds($category->getProductCategoryId(), true);
            $ids[] = $category->getProductCategoryId();

            if ($data['enabled'] != (int)$category->isEnabled()) {
                $this->getMapper()->toggleEnabled($category->setEnabled((bool)$data['enabled']));
                $this->getMapper()->cascadeEnabled($ids, $data['enabled']);
            }

            if ($data['discontinued'] != (int)$category->isDiscontinued()) {
                $this->getMapper()->toggleDiscontinued($category->setDiscontinued((bool)$data['discontinued']));
                $this->getMapper()->cascadeDiscontinued($ids, $data['discontinued']);
            }

            $this->removeCacheItem($model->getProductCategoryId());
        }

        return $result;
    }

    /**
     * @param int $categoryId
     * @param bool $recursive
     * @return array
     */
    public function getCategoryChildrenIds($categoryId, $recursive = false)
    {
        $mapper = $this->getMapper();

        $categories = $mapper->getSubCategoriesByParentId($categoryId, $recursive);

        $cats = [];

        /* @var $category ProductCategoryModel */
        foreach ($categories as $category) {
            $cats[] = $category->getProductCategoryId();
        }

        return $cats;
    }

    public function delete($id)
    {
        $id = (int)$id;
        $childIds = $this->getCategoryChildrenIds($id);

        foreach ($childIds as $catId) {
            $this->removeCacheItem($catId);
        }

        return parent::delete($id);
    }

    /**
     * @param ProductCategoryModel $category
     * @return mixed
     * @throws ShopException
     */
    public function toggleEnabled(ProductCategoryModel $category)
    {
        //check for parent and if it's enabled or not, if disabled don't update.
        $parents = $this->getParentCategories(
            $category->getProductCategoryId()
        )->toArray();

        $this->removeCacheItem($category->getProductCategoryId());

        array_pop($parents);
        $parent = array_slice($parents, -1, 1);

        if (count($parent) && !$parent[0]['enabled']) {
            throw new ShopException("Can't change enabled status on child while parent is disabled. First enable the parent category");
        }

        if (true === $category->isEnabled()) {
            $category->setEnabled(false);
        } else {
            $category->setEnabled(true);
        }

        $category->setDateModified();

        /* @var $mapper ProductCategoryMapper */
        $mapper = $this->getMapper();

        $result = $mapper->toggleEnabled($category);

        if ($result) {
            $ids = $this->getCategoryChildrenIds($category->getProductCategoryId(), true);
            $ids[] = $category->getProductCategoryId();
            $mapper->cascadeEnabled($ids, $category->isEnabled());
        }

        return $result;
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function getParentCategories($categoryId)
    {
        /* @var $mapper ProductCategoryMapper */
        $mapper = $this->getMapper();

        return $mapper->getBreadCrumbs($categoryId);
    }

    /**
     * @param Event $e
     */
    public function preForm(Event $e)
    {
        $model = $e->getParam('model');

        if ($model instanceof ProductCategoryModel) {
            $this->setFormOptions([
                'productCategoryId' => $model->getProductCategoryId(),
            ]);
        }
    }
}
