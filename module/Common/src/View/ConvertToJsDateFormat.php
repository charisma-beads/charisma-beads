<?php

namespace Common\View;

use Common\Stdlib\PhpToJsDateFormat;
use Laminas\View\Helper\AbstractHelper;


class ConvertToJsDateFormat extends AbstractHelper
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @param null $format
     * @return $this
     */
    public function __invoke($format = null)
    {
        if ($format) {
            $this->setFormat($format);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function renderJsFormat()
    {
        return PhpToJsDateFormat::convertPhpToJs($this->getFormat());
    }

    /**
     * @return string
     */
    public function renderPhpFormat()
    {
        return PhpToJsDateFormat::convertJsToPhp($this->getFormat());
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }
}
