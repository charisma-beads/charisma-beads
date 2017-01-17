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

use UthandoCommon\Controller\AbstractCrudController;

/**
 * Class Faq
 *
 * @package Shop\Controller
 * @method \Shop\Service\Faq getService()
 */
class Faq extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'lft');
    protected $serviceName = 'ShopFaq';
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
