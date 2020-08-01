<?php

namespace Newsletter\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;


class TemplateModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $templateId;

    /**
     * @var strin
     */
    protected $name;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string
     */
    protected $params;

    /**
     * @return int
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param int $templateId
     * @return $this
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * @return strin
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param strin $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
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
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }
}