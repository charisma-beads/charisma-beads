<?php

declare(strict_types=1);

namespace ThemeManager\Model;


use Zend\Config\Reader\Ini;

trait WidgetParamsTrait
{
    /**
     * @var string
     */
    protected $params;

    /**
     * @return array|bool
     */
    public function parseParams()
    {
        $params = new Ini();
        return $params->fromString($this->getParams());
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $params
     * @return WidgetModel
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}
