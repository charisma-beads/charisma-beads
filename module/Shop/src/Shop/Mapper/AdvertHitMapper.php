<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Hit
 *
 * @package Shop\Mapper
 */
class AdvertHitMapper extends AbstractDbMapper
{
    protected $table = 'advertHit';
    protected $primary = 'advertHitId';
}
