<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller;

use Shop\Service\FaqService;
use UthandoCommon\Controller\AbstractCrudController;

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
