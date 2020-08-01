<?php

namespace Shop\Mapper;

use Common\Mapper\AbstractNestedSet;

/**
 * Class Faq
 *
 * @package Shop\Mapper
 */
class FaqMapper extends AbstractNestedSet
{
    protected $table = 'faq';
    protected $primary = 'faqId';
}
