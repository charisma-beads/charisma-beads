<?php

namespace Testimonial\Service;

use Common\Service\AbstractMapperService;
use Testimonial\Form\TestimonialForm;
use Testimonial\Hydrator\TestimonialHydrator;
use Testimonial\InputFilter\TestimonialInputFilter;
use Testimonial\Mapper\TestimonialMapper;
use Testimonial\Model\TestimonialModel;


class TestimonialService extends AbstractMapperService
{
    protected $form         = TestimonialForm::class;
    protected $hydrator     = TestimonialHydrator::class;
    protected $inputFilter  = TestimonialInputFilter::class;
    protected $mapper       = TestimonialMapper::class;
    protected $model        = TestimonialModel::class;
} 