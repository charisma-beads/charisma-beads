<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service\Voucher;

use Shop\Form\Voucher\Voucher;
use Shop\Mapper\Product\Category;
use Shop\Model\Product\Category as CategoryModel;
use Shop\Model\Voucher\Code as CodeModel;
use Shop\Model\Voucher\ProductCategory;
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Code
 *
 * @package Shop\Service\Voucher
 * @method \Shop\Mapper\Voucher\Code getMapper($mapperClass = null, array $options = [])
 */
class Code extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopVoucherCode';

    /**
     * @var array
     */
    protected $tags = [
        'voucher',
    ];

    /**
     * setup events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setupForm']);

        $this->getEventManager()->attach([
            'pre.save',
        ], [$this, 'checkChildCategories']);
    }

    /**
     * @param Event $e
     */
    public function checkChildCategories(Event $e)
    {
        /* @var CodeModel $data */
        $data = $e->getParam('data');

        /* @var $mapper Category */
        $mapper = $this->getMapper('ShopProductCategory');

        $categories = [];

        /* @var ProductCategory $productCategory */
        foreach ($data->getProductCategories() as $productCategory) {
            $childCategories = $mapper->getSubCategoriesByParentId($productCategory->getCategoryId());

            /* @var CategoryModel $category */
            foreach ($childCategories as $category) {
                $categories[] = $category->getProductCategoryId();
            }
        }

        $data->getProductCategories()->fromArray($categories);
        $e->setParam('data', $data);
    }

    /**
     * @param Event $e
     */
    public function setupForm(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        $post = $e->getParam('post');

        $code = ($model instanceof CodeModel && $model->getCode() === $post['code']) ? $model->getCode() : null;

        /* @var $inputFilter \Shop\InputFilter\Voucher\Code */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addNoRecordExists($code);

        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('startDate');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
        $dateTimeStrategy = $hydrator->getStrategy('expiry');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
    }

    public function storeVoucher(array $data)
    {
        $code = $data['code'] ?? null;


    }
}