<?php

namespace Newsletter\Form\Element;

use Common\Service\ServiceManager;
use Newsletter\Model\TemplateModel;
use Newsletter\Service\TemplateService;
use Zend\Form\Element\Select;
use Zend\Form\FormElementManager;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;


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