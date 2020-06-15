<?php

declare(strict_types=1);


namespace Contact\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;


class AbstractLine implements ModelInterface
{
    use Model;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $text;

    /**
     * @param array $array
     */
    public function __construct(array $array = [])
    {
        if (isset($array['label'])) {
            $this->setLabel($array['label']);
        }

        if (isset($array['text'])) {
            $this->setText($array['text']);
        }
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
}
