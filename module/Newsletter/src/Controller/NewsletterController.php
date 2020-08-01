<?php

namespace Newsletter\Controller;

use Common\Controller\AbstractCrudController;
use Newsletter\Model\NewsletterModel as NewsletterModel;
use Newsletter\Service\NewsletterService;

/**
 * Class Newsletter
 *
 * @package Newsletter\Mvc\Controller
 * @method NewsletterService getService()
 */
class NewsletterController extends AbstractCrudController
{
    protected $controllerSearchOverrides = ['sort' => 'newsletterId'];
    protected $serviceName = NewsletterService::class;
    protected $route = 'admin/newsletter';

    /**
     * @return \Laminas\Http\Response
     */
    public function setVisibleAction()
    {
        $id = (int) $this->params('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        try {
            /* @var $model NewsletterModel */
            $model = $this->getService()->getById($id);
            $this->getService()->toggleVisible($model);
        } catch (\Exception $e) {
            $this->setExceptionMessages($e);
            return $this->redirect()->toRoute($this->getRoute(), [
                'action' => 'list'
            ]);
        }

        return $this->redirect()->toRoute($this->getRoute(), [
            'action' => 'list'
        ]);
    }
}