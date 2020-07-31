<?php

namespace Newsletter\Form\Element;

use Common\Service\ServiceManager;
use Newsletter\Model\TemplateModel;
use Newsletter\Service\TemplateService;
use Laminas\Form\Element\Select;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;


class TemplateList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @return array
     */
    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getTemplates();
    }

    /**
     * @return array
     */
    public function getTemplates()
    {
        $templates = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(TemplateService::class)
            ->fetchAll();

        $templateOptions = [];

        /* @var $template TemplateModel */
        foreach($templates as $template) {
            $templateOptions[$template->getTemplateId()] = $template->getName();
        }

        return $templateOptions;
    }
}