<?php

namespace Newsletter\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Newsletter\Model\TemplateModel as TemplateModel;


class TemplateHydrator extends AbstractHydrator
{
    /**
     * @param TemplateModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'templateId'    => $object->getTemplateId(),
            'name'          => $object->getName(),
            'params'        => $object->getParams(),
            'body'          => $object->getBody(),
        ];
    }
}