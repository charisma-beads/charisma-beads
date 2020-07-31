<?php

namespace Article\Service;

use Article\Form\ArticleForm;
use Article\Hydrator\ArticleHydrator;
use Article\InputFilter\ArticleInputFilter;
use Article\Mapper\ArticleMapper;
use Article\Model\ArticleModel;
use Common\Mapper\AbstractNestedSet;
use Common\Service\AbstractRelationalMapperService;
use Navigation\Service\MenuItemService;
use User\Service\UserService;
use Laminas\EventManager\Event;


class ArticleService extends AbstractRelationalMapperService
{
    /**
     * @var \Navigation\Service\MenuItemService
     */
    protected $menuItemService;

    protected $form         = ArticleForm::class;
    protected $hydrator     = ArticleHydrator::class;
    protected $inputFilter  = ArticleInputFilter::class;
    protected $mapper       = ArticleMapper::class;
    protected $model        = ArticleModel::class;

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
     * (non-PHPdoc)
     * @see \Common\Service\AbstractService::attachEvents()
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach(
            self::EVENT_PRE_PREPARE_FORM, [$this, 'setSlug']
        );

        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setValidation']);

        $this->getEventManager()->attach([
            'post.add', 'post.edit'
        ], [$this, 'updateMenu']);
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

        if ($data instanceof ArticleModel) {
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

        if ($model instanceof ArticleModel) {
            $model->setDateModified();
        }

        $form->setValidationGroup([
            'articleId', 'userId', 'title', 'slug',
            'content', 'description', 'resource',
            'image', 'lead', 'layout',
        ]);
    }

    /**
     * @param Event $e
     */
    public function updateMenu(Event $e)
    {
        $saved = $e->getParam('saved');
        $post = $e->getParam('post');
        $service = $e->getTarget();

        if ($saved) {
            $article = $e->getParam('form')->getData();

            if ($post['menuInsertType'] !== AbstractNestedSet::INSERT_NO) {
                $ids = explode('-', $post['position']);
                $data = [
                    'menuId' => $ids[0],
                    'label' => $article->getTitle(),
                    'position' => $post['position'],
                    'params' => 'params.slug=' . $article->getSlug(),
                    'route' => 'article',
                    'resource' => '',
                    'visible' => 1,
                    'menuInsertType' => $post['menuInsertType'],
                    'security' => $post['security'],
                ];

                $page = $service->getMenuItemService()->getMenuItemByMenuIdAndLabel($ids[0], $article->getTitle());

                if (!$page) {
                    $result = $service->getMenuItemService()->add($data);
                } else {
                    $service->getMenuItemService()->edit($page, $data);
                }
            }
        }
    }

    /**
     * @param int $id
     * @param null $col
     * @return array|mixed|\Common\Model\ModelInterface
     */
    public function getById($id, $col = null)
    {
        $article = parent::getById($id, $col);
        $this->populate($article, true);

        return $article;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getArticleBySlug($slug)
    {
        $slug = (string)$slug;
        $article = $this->getMapper()->getArticleBySlug($slug);

        if ($article) {
            $this->populate($article, true);
        }

        return $article;
    }

    /**
     * @param ArticleModel $article
     */
    public function addPageHit(ArticleModel $article)
    {
        $pageHits = $article->getPageHits();
        $pageHits++;
        $article->setPageHits($pageHits);
        $this->save($article);
    }

    /**
     * @param $limit
     * @return \Laminas\Db\ResultSet\HydratingResultSet|\Laminas\Db\ResultSet\ResultSet|\Laminas\Paginator\Paginator
     */
    public function getRecentPosts($limit)
    {
        $limit = (int)$limit;
        /* @var $mapper ArticleModel */
        $mapper = $this->getMapper();
        return $mapper->getArticlesByDate($limit);
    }

    /**
     * @return \Navigation\Service\MenuItemService
     */
    protected function getMenuItemService()
    {
        if (!$this->menuItemService) {
            $sl = $this->getServiceLocator();
            $this->menuItemService = $sl->get(MenuItemService::class);
        }

        return $this->menuItemService;
    }
}
