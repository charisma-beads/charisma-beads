<?php

namespace Shop\Options;

use Laminas\Stdlib\AbstractOptions;

/**
 * Class InvoiceOptions
 *
 * @package Shop\Options
 */
class InvoiceOptions extends AbstractOptions
{
    /**
     * @var string
     */
    protected $fontSize;

    /**
     * @var string
     */
    protected $panelTitleFontSize;

    /**
     * @var string
     */
    protected $footerFontSize;

    /**
     * @return string
     */
    public function getFontSize()
    {
        return $this->fontSize;
    }

    /**
     * @param string $fontSize
     * @return $this
     */
    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getPanelTitleFontSize()
    {
        return $this->panelTitleFontSize;
    }

    /**
     * @param string $panelTitleFontSize
     * @return $this
     */
    public function setPanelTitleFontSize($panelTitleFontSize)
    {
        $this->panelTitleFontSize = $panelTitleFontSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getFooterFontSize()
    {
        return $this->footerFontSize;
    }

    /**
     * @param string $footerFontSize
     * @return $this
     */
    public function setFooterFontSize($footerFontSize)
    {
        $this->footerFontSize = $footerFontSize;
        return $this;
    }
}