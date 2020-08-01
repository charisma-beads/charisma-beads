<?php

namespace Events\View\Helper;

use Common\View\AbstractViewHelper;
use Events\Options\EventsOptions;


class ConvertDateFormat extends AbstractViewHelper
{
    /**
     * @var EventOptions
     */
    protected $options;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param null|string $type
     * @return $this
     */
    public function __invoke($type = null)
    {
        if ($type) {
            $this->setType($type);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $renderMethod   = 'render' . $this->getType() . 'Format';
        $format         = $this->getOptions()->getDateFormat();

        return $this->getDateFormatHelper()
            ->setFormat($format)
            ->$renderMethod();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function getType()
    {
        return ucfirst($this->type);
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = strtolower($type);
        return $this;
    }

    /**
     * @return \Common\View\ConvertToJsDateFormat
     */
    protected function getDateFormatHelper()
    {
        return $this->getView()->plugin('convertToJsDateFormat');
    }

    /**
     * @return EventsOptions
     */
    protected function getOptions()
    {
        if (!$this->options instanceof EventsOptions) {
            $this->options = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(EventsOptions::class);
        }

        return $this->options;

    }
}
