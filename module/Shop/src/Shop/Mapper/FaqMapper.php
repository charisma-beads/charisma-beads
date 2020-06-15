<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

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
