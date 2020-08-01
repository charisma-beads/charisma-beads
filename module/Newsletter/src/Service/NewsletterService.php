<?php

namespace Newsletter\Service;

use Common\Service\AbstractMapperService;
use Newsletter\Form\NewsletterForm;
use Newsletter\Hydrator\NewsletterHydrator;
use Newsletter\InputFilter\NewsletterInputFilter;
use Newsletter\Mapper\NewsletterMapper;
use Newsletter\Model\NewsletterModel;

/**
 * Class Newsletter
 *
 * @package Newsletter\Service
 * @method NewsletterModel|array|null getById($id, $col = null)
 * @method NewsletterMapper getMapper($mapperClass = null, array $options = [])
 */
class NewsletterService extends AbstractMapperService
{
    protected $form         = NewsletterForm::class;
    protected $hydrator     = NewsletterHydrator::class;
    protected $inputFilter  = NewsletterInputFilter::class;
    protected $mapper       = NewsletterMapper::class;
    protected $model        = NewsletterModel::class;

    /**
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function fetchVisibleNewsletters()
    {
        $models = $this->getMapper()->fetchAllVisible();
        return $models;
    }

    /**
     * @param NewsletterModel $model
     * @return int
     * @throws \Common\Service\ServiceException
     */
    public function toggleVisible(NewsletterModel $model)
    {
        $this->removeCacheItem($model->getNewsletterId());

        $visible = (true === $model->isVisible()) ? false : true;

        $model->setVisible($visible);

        return parent::save($model);
    }
}