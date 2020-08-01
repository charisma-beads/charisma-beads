<?php

namespace Newsletter\Model;


use Common\Model\Model;
use Common\Model\ModelInterface;


class NewsletterModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $newsletterId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var bool
     */
    protected $visible;

    /**
     * @return int
     */
    public function getNewsletterId()
    {
        return $this->newsletterId;
    }

    /**
     * @param int $newsletterId
     * @return $this
     */
    public function setNewsletterId($newsletterId)
    {
        $this->newsletterId = $newsletterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param boolean $visible
     * @return $this
     */
    public function setVisible($visible)
    {
        $this->visible = (bool) $visible;
        return $this;
    }
}