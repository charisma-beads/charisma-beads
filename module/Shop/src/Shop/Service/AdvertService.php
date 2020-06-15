<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Advert
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Service;

use Shop\Form\AdvertForm;
use Shop\Hydrator\AdvertHydrator;
use Shop\InputFilter\AdvertInputFiler;
use Shop\Mapper\AdvertMapper;
use Shop\Model\AdvertModel;
use Common\Service\AbstractMapperService;
use Zend\Json\Json;

/**
 * Class Advert
 *
 * @package Shop\Service
 */
class AdvertService extends AbstractMapperService
{
    protected $form         = AdvertForm::class;
    protected $hydrator     = AdvertHydrator::class;
    protected $inputFilter  = AdvertInputFiler::class;
    protected $mapper       = AdvertMapper::class;
    protected $model        = AdvertModel::class;
    
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

    public function toggleEnabled(AdvertModel $advert)
    {
        $this->removeCacheItem($advert->getAdvertId());

        $enabled = (true === $advert->isEnabled()) ? false : true;

        $advert->setEnabled($enabled);

        return parent::save($advert);
    }
}
