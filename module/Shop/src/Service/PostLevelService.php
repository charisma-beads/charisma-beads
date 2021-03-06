<?php

namespace Shop\Service;

use Shop\Form\PostLevelForm;
use Shop\Hydrator\PostLevelHydrator;
use Shop\InputFilter\PostLevelInputFilter;
use Shop\Mapper\PostLevelMapper;
use Shop\Model\PostLevelModel;
use Common\Service\AbstractMapperService;

/**
 * Class Level
 *
 * @package Shop\Service
 */
class PostLevelService extends AbstractMapperService
{
    protected $form         = PostLevelForm::class;
    protected $hydrator     = PostLevelHydrator::class;
    protected $inputFilter  = PostLevelInputFilter::class;
    protected $mapper       = PostLevelMapper::class;
    protected $model        = PostLevelModel::class;
    
    protected $tags = [
       'post-level',
    ];
	
}
