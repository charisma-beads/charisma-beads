<?php

namespace Testimonial\Mapper;

use Common\Mapper\AbstractDbMapper;


class TestimonialMapper extends AbstractDbMapper
{
    protected $table = 'testimonial';
    protected $primary = 'testimonialId';
} 