<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service;

use Shop\Mapper\Faq as FaqMapper;
use Shop\Model\Faq as FaqModel;
use Shop\ShopException;
use UthandoCommon\Model\ModelInterface;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;
use Zend\Form\Form;

/**
 * Class Faq
 *
 * @package Shop\Service
 * @method FaqMapper getMapper($mapperClass = null, array $options = [])
 */
class Faq extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopFaq';

    /**
     * @var array
     */
    protected $tags = [
        'faq',
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
     * @param bool $topLevelOnly
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function fetchAll($topLevelOnly=false)
    {
        $mapper = $this->getMapper();

        if ($topLevelOnly) {
            $faqs = $mapper->fetchTopLevelOnly();
        } else {
            $faqs = $mapper->fetchAll();
        }

        return $faqs;
    }

    /**
     * @param int $faqId
     * @param bool $recursive
     * @return array
     */
    public function getFaqChildrenIds($faqId, $recursive=false)
    {
        $mapper = $this->getMapper();

        $faqs = $mapper->getDecendentsByParentId($faqId, $recursive);

        $ids = [];

        /* @var $faq \Shop\Model\Faq */
        foreach ($faqs as $faq) {
            $ids[] = $faq->getFaqId();
        }

        return $ids;
    }

    /**
     * @param array $post
     * @param Form $form
     * @return int|Form
     */
    public function add(array $post, Form $form = null)
    {
        /* @var $mapper FaqMapper */
        $mapper = $this->getMapper();

        /* @var $model \Shop\Model\Faq */
        $model = $mapper->getModel();

        $form  = $this->getForm($model, $post, true, true);

        if (!$form->isValid()) {
            return $form;
        }

        $data = $mapper->extract($form->getData());

        $pk = $this->getMapper()->getPrimaryKey();
        unset($data[$pk]);

        $position = (int) $post['parent'];
        $insertType = (string) $post['faqInsertType'];

        $result = $mapper->insertRow($data, $position, $insertType);

        return $result;
    }

    /**
     * @param FaqModel|ModelInterface $model
     * @param array $post
     * @param Form $form
     * @throws ShopException
     * @throws \UthandoCommon\Service\ServiceException
     * @return int|Form
     */
    public function edit(ModelInterface $model, array $post, Form $form = null)
    {
        if (!$model instanceof FaqModel) {
            throw new ShopException('$model must be an instance of Shop\Model\Faq, ' . get_class($model) . ' given.');
        }

        $form = $this->getForm($model, $post, true, true);

        if (!$form->isValid()) {
            \FB::info($form->getMessages());
            return $form;
        }

        $faq = $this->getById($model->getFaqId());

        $data = $this->getMapper()
            ->extract($form->getData());

        if ($faq) {
            if ('noInsert' !== $post['faqInsertType']) {

                $position = (int) $post['parent'];
                $insertType = (string) $post['paqInsertType'];

                $result = $this->getMapper()->move($data, $position, $insertType);

            } else {
                $result = $this->save($model);
            }
            $this->removeCacheItem($model->getFaqId());
        } else {
            throw new ShopException('FAQ id does not exist');
        }

        return $result;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete($id)
    {
        $id = (int) $id;
        $childIds = $this->getFaqChildrenIds($id);

        foreach ($childIds as $catId) {
            $this->removeCacheItem($catId);
        }

        return parent::delete($id);
    }

    /**
     * @param Event $e
     */
    public function preForm(Event $e)
    {
        $model = $e->getParam('model');

        if ($model instanceof FaqModel) {
            $this->setFormOptions([
                'faqId' => $model->getFaqId(),
            ]);
        }
    }
}
