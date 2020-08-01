<?php

namespace Newsletter\Service;

use Common\Service\AbstractMapperService;
use Newsletter\Form\TemplateForm;
use Newsletter\Hydrator\TemplateHydrator;
use Newsletter\InputFilter\TemplateInputFilter;
use Newsletter\Mapper\TemplateMapper;
use Newsletter\Model\TemplateModel;

/**
 * Class Template
 *
 * @package Newsletter\Service
 * @method TemplateModel|array|null getById($id, $col = null)
 */
class TemplateService extends AbstractMapperService
{
    protected $form         = TemplateForm::class;
    protected $hydrator     = TemplateHydrator::class;
    protected $inputFilter  = TemplateInputFilter::class;
    protected $mapper       = TemplateMapper::class;
    protected $model        = TemplateModel::class;
}