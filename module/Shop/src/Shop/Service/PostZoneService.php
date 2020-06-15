<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service\Post
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use Shop\Form\PostZoneForm;
use Shop\Hydrator\PostZoneHydrator;
use Shop\InputFilter\PostZoneInputFilter;
use Shop\Mapper\PostZoneMapper;
use Shop\Model\PostZoneModel;
use Common\Service\AbstractMapperService;

/**
 * Class Zone
 *
 * @package Shop\Service
 */
class PostZoneService extends AbstractMapperService
{
    protected $form         = PostZoneForm::class;
    protected $hydrator     = PostZoneHydrator::class;
    protected $inputFilter  = PostZoneInputFilter::class;
    protected $mapper       = PostZoneMapper::class;
    protected $model        = PostZoneModel::class;
    
    protected $tags = [
        'post-zone',
    ];
	
}
