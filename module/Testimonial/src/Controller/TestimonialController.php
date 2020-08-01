<?php

namespace Testimonial\Controller;

use Common\Controller\AbstractCrudController;
use Testimonial\Service\TestimonialService;


class TestimonialController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'testimonialId');
    protected $serviceName = TestimonialService::class;
    protected $route = 'admin/testimonial';

    public function viewAction()
    {
        $models = $this->getService()->fetchAll();

        return [
            'models' => $models,
        ];
    }
} 