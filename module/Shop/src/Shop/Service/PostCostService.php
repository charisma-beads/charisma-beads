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

use Shop\Form\PostCostForm;
use Shop\Hydrator\PostCostHydrator;
use Shop\InputFilter\PostCostInputFilter;
use Shop\Mapper\PostCostMapper;
use Shop\Model\PostCostModel;
use UthandoCommon\Service\AbstractRelationalMapperService;

/**
 * Class Cost
 *
 * @package Shop\Service
 */
class PostCostService extends AbstractRelationalMapperService
{
    protected $form         = PostCostForm::class;
    protected $hydrator     = PostCostHydrator::class;
    protected $inputFilter  = PostCostInputFilter::class;
    protected $mapper       = PostCostMapper::class;
    protected $model        = PostCostModel::class;
    
    protected $tags = [
        'post-cost', 'post-level', 'post-zone',
    ];

    /**
     * @var array
     */
    protected $referenceMap = [
        'postLevel' => [
            'refCol'    => 'postLevelId',
            'service'   => PostLevelService::class,
        ],
        'postZone'  => [
            'refCol'    => 'postZoneId',
            'service'   => PostZoneService::class,
        ],
    ];
}
