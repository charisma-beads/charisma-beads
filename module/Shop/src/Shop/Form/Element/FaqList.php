<?php

namespace Shop\Form\Element;


use Shop\Service\FaqService;
use Common\Service\ServiceManager;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;

class FaqList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var string
     */
    protected $emptyOption = '---Please select a faq---';

    /**
     * @var bool
     */
    protected $addTop = false;

    public function setOptions($options)
    {
        parent::setOptions($options);

        if (isset($options['add_top'])) {
            $this->addTop = $options['add_top'];
        }
    }

    public function getValueOptions()
    {
        $options = ($this->valueOptions) ?: $this->getOptionList();
        return $options;
    }

    public function getOptionList()
    {
        /* @var $faqService \Shop\Service\FaqService */
        $faqService = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(FaqService::class);

        $faqService->getMapper();
        $faqs = $faqService->fetchAll();

        $faqOptions = [];

        if ($this->isAddTop()) {
            $faqOptions[0] = 'Top';
        }

        /* @var $faq \Shop\Model\FaqModel */
        foreach($faqs as $faq) {
            $parent = ($faq->hasChildren() || $faq->getDepth() == 0) ? 'bold ' : '';
            $faqOptions[] = [
                'label'	=> $faq->getQuestion(),
                'value'	=> $faq->getFaqId(),
                'attributes'	=> [
                    'class'	=> $parent,
                    'style' => 'text-indent:' . $faq->getDepth() . 'em;',
                ],
            ];
        }

        return $faqOptions;
    }

    /**
     * @return boolean
     */
    public function isAddTop()
    {
        return $this->addTop;
    }

    /**
     * @param boolean $addTopOption
     * @return $this
     */
    public function setAddTop($addTopOption)
    {
        $this->addTop = $addTopOption;
        return $this;
    }
}
