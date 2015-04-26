<?php
namespace Shop\Service\Advert;

use UthandoCommon\Service\AbstractMapperService;
use Zend\Json\Json;

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
            $percentage = round(($value->numAdHits / $value->totalHits) * 100);
            $statsArray[] = [$value->advert, $percentage];
        }
        
        return Json::encode($statsArray);
    }
}
