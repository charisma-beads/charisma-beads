<?php

namespace Shop\Controller;

use Shop\Service\FaqService;
use Common\Controller\AbstractCrudController;

/**
 * Class Faq
 *
 * @package Shop\Controller
 * @method \Shop\Service\FaqService getService()
 */
class FaqController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'lft');
    protected $serviceName = FaqService::class;
    protected $route = 'admin/shop/faq';

    public function faqAction()
    {
        $faqs = $this->getService()
            ->fetchAll();

        return [
            'faqs' => $faqs,
        ];
    }
}
