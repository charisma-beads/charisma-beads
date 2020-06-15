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

use Shop\Form\PostUnitForm;
use Shop\Hydrator\PostUnitHydrator;
use Shop\InputFilter\PostUnitInputFilter;
use Shop\Mapper\PostUnitMapper;
use Shop\Model\PostUnitModel;
use Common\Service\AbstractMapperService;

/**
 * Class Unit
 *
 * @package Shop\Service
 */
class PostUnitService extends AbstractMapperService
{
    protected $form         = PostUnitForm::class;
    protected $hydrator     = PostUnitHydrator::class;
    protected $inputFilter  = PostUnitInputFilter::class;
    protected $mapper       = PostUnitMapper::class;
    protected $model        = PostUnitModel::class;
    
    protected $tags = [
        'post-unit',
    ];
}
