<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service\Advert;

use UthandoCommon\Service\AbstractMapperService;
use Zend\Json\Json;

/**
 * Class Advert
 *
 * @package Shop\Service\Advert
 */
class Advert extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopAdvert';
    
    protected $tags = [
        'advert',
    ];
    
    public function getStats()
    {
        $resultSet = $this->getMapper()->getStats();
        
        $statsArray = [];
        
        foreach ($resultSet as $value) {
            $percentage = round(($value->numAdHits / $value->totalHits) * 100, 2);
            $statsArray[] = ['label' => $value->advert, 'data' => $percentage];
        }
        
        return Json::encode($statsArray);
    }
}
