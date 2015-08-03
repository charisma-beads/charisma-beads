<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Mapper\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Mapper\Advert;

use UthandoCommon\Mapper\AbstractDbMapper;

/**
 * Class Hit
 *
 * @package Shop\Mapper\Advert
 */
class Hit extends AbstractDbMapper
{
    protected $table = 'advertHit';
    protected $primary = 'advertHitId';
}
