<?php

namespace News\Service;

use Common\Service\AbstractRelationalMapperService;
use News\Form\NewsForm;
use News\Hydrator\NewsHydrator;
use News\InputFilter\NewsInputFilter;
use News\Mapper\NewsMapper;
use News\Model\NewsModel;
use News\Options\NewsOptions;
use User\Service\UserService;
use Zend\EventManager\Event;

/**
 * Class NewsForm
 *
 * @package News\Service
 * @method NewsMapper getMapper($mapperClass = null, array $options = [])
 */
class NewsService extends AbstractRelationalMapperService
{
    protected $form         = NewsForm::class;
    protected $hydrator     = NewsHydrator::class;
    protected $inputFilter  = NewsInputFilter::class;
    protected $mapper       = NewsMapper::class;
    protected $model        = NewsModel::class;

    /**
     * @var array
     */
    protected $referenceMap = [
        'user' => [
            'refCol' => 'userId',
            'service' => UserService::class,
        ],
    ];

    /**
     * Attach events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.form'
        ], [$this, 'setSlug']);

        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setValidation']);

        $this->getEventManager()->attach([
            'post.add',
        ], [$this, 'autoPost']);
    }

    public function autoPost(Event $e)
    {
        $saved = $e->getParam('saved');

        if ($saved) {
            /* @var $model NewsModel */
            $model = $this->getMapper()->getById($saved);

            /* @var $options NewsOptions */
            $options = $this->getService(NewsOptions::class);

            $viewManager = $this->getServiceLocator()
                ->get('ViewHelperManager');

            $url = $viewManager->get('Url');
            $scheme = $viewManager->get('ServerUrl');

            $url = $url('news', [
                'news-item'    => $model->getSlug(),
            ]);

            $string = sprintf('%s %s', $model->getTitle(), $scheme($url));

            $argv   = compact('string');
            $argv   = $this->prepareEventArguments($argv);

            foreach ($options->getAutoPost() as $event) {
                $this->getEventManager()->trigger($event, $this, $argv);
            }

        }
    }

    /**
     * @param Event $e
     */
    public function setSlug(Event $e)
    {
        $data = $e->getParam('data');

        if (null === $data) {
            return;
        }

        if ($data instanceof NewsModel) {
            $data->setSlug($data->getTitle());
        } elseif (is_array($data)) {
            $data['slug'] = $data['title'];
        }

        $e->setParam('data', $data);
    }

    /**
     * @param Event $e
     */
    public function setValidation(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        $post = $e->getParam('post');

        if ($model instanceof NewsModel) {
            $model->setDateModified();
        }

        $form->setValidationGroup([
            'newsId', 'userId', 'title', 'slug',
            'content', 'description',
            'image', 'lead', 'layout',
        ]);
    }

    /**
     * @param int $id
     * @param null $col
     * @return array|mixed|\Common\Model\ModelInterface
     */
    public function getById($id, $col = null)
    {
        $model = parent::getById($id, $col);
        $this->populate($model, true);

        return $model;
    }

    /**
     * @param $slug
     * @return NewsModel|null
     */
    public function getBySlug($slug)
    {
        $slug = (string) $slug;
        /* @var $mapper NewsMapper */
        $mapper = $this->getMapper();
        $model = $mapper->getBySlug($slug);

        if ($model) {
            $this->populate($model, true);
        }

        return $model;
    }

    /**
     * @param NewsModel $newsModel
     * @throws \Common\Service\ServiceException
     */
    public function addPageHit(NewsModel $newsModel)
    {
        $pageHits = $newsModel->getPageHits();
        $pageHits++;
        $newsModel->setPageHits($pageHits);
        $this->save($newsModel);
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getPopularNews(int $limit)
    {
        $mapper = $this->getMapper();
        $models = $mapper->getNewsByHits($limit);

        return $models;
    }

    /**
     * @param int $limit
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getRecentNews(int $limit)
    {
        $mapper = $this->getMapper();
        $models = $mapper->getNewsByDate($limit);

        return $models;

    }
} 