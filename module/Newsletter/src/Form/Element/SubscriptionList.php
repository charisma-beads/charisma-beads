<?php

namespace Newsletter\Form\Element;

use Common\Service\ServiceManager;
use Newsletter\Service\SubscriptionService;
use Newsletter\Model\NewsletterModel as NewsletterModel;
use Newsletter\Service\NewsletterService;
use Newsletter\Model\SubscriptionModel as SubscriptionModel;
use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;


class SubscriptionList extends MultiCheckbox implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var int
     */
    protected $subscriberId;

    /**
     * @var bool
     */
    protected $labelPrepend = false;

    /**
     * @var string
     */
    protected $labelHtml = '<i></i>';

    /**
     * @var bool
     */
    protected $preSelect = false;

    /**
     * @var bool
     */
    protected $includeHidden = false;

    /**
     * Setup class
     */
    public function init()
    {
        $this->setName('subscribe');
    }

    /**
     * @return int
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * @param int $subscriberId
     * @return $this
     */
    public function setSubscriberId($subscriberId)
    {
        $this->subscriberId = $subscriberId;
        return $this;
    }

    /**
     * @param array|\Traversable $options
     */
    public function setOptions($options)
    {
        if (isset($options['subscriber_id'])) {
            $this->subscriberId = $options['subscriber_id'];
        }

        if (isset($options['include_hidden'])) {
            $this->setIncludeHidden($options['include_hidden']);
        }

        parent::setOptions($options);
    }

    /**
     * @return array
     */
    public function getValueOptions()
    {
        return ($this->valueOptions) ?: $this->getSubscribers();
    }

    /**
     * @return array
     */
    public function getSubscribers()
    {
        /* @var $sm ServiceManager */
        $sm = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(ServiceManager::class);

        /* @var $newsletterService NewsletterService */
        $newsletterService = $sm->get(NewsletterService::class);

        /* @var $subscriptionsService SubscriptionService */
        $subscriptionsService = $sm->get(SubscriptionService::class);

        $newsletters = ($this->isIncludeHidden()) ? $newsletterService->fetchAll() : $newsletterService->fetchVisibleNewsletters();
        $subscriptions = $subscriptionsService->getMapper()
            ->getSubscriptionsBySubscriberId($this->getSubscriberId());

        $valueOptions = [];
        /* @var $row NewsletterModel */
        foreach ($newsletters as $row) {

            $subscribed = false;

            /* @var $sub SubscriptionModel */
            foreach ($subscriptions as $sub) {
                if ($sub->getNewsletterId() == $row->getNewsletterId()) {
                    $subscribed = true;
                }
            }

            $options = [
                'label' => $row->getName(),
                'value' => $row->getNewsletterId(),
                'selected' => ($this->isPreSelect()) ? true : $subscribed,
            ];

            if ($this->isLabelPrepend()) {
                $options['label'] =  $this->getLabelHtml() . $options['label'];
                $options['label_options']['disable_html_escape'] = true;
            }

            $valueOptions[] = $options;
        }

        return $valueOptions;
    }

    /**
     * This is not a required element so we override parent method.
     *
     * @return array
     */
    public function getInputSpecification()
    {
        $spec = [
            'name' => $this->getName(),
            'required' => false,
        ];

        if ($validator = $this->getValidator()) {
            $spec['validators'] = [
                $validator,
            ];
        }

        return $spec;
    }

    /**
     * @return boolean
     */
    public function isLabelPrepend()
    {
        return $this->labelPrepend;
    }

    /**
     * @param boolean $labelPrepend
     * @return $this
     */
    public function setLabelPrepend($labelPrepend)
    {
        $this->labelPrepend = $labelPrepend;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabelHtml()
    {
        return $this->labelHtml;
    }

    /**
     * @param string $labelHtml
     * @return $this
     */
    public function setLabelHtml($labelHtml)
    {
        $this->labelHtml = $labelHtml;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPreSelect()
    {
        return $this->preSelect;
    }

    /**
     * @param boolean $preSelect
     * @return $this
     */
    public function setPreSelect($preSelect)
    {
        $this->preSelect = $preSelect;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIncludeHidden()
    {
        return $this->includeHidden;
    }

    /**
     * @param boolean $includeHidden
     * @return $this
     */
    public function setIncludeHidden($includeHidden)
    {
        $this->includeHidden = $includeHidden;
        return $this;
    }
}