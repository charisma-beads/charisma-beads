<?php

namespace Common\Model;

use DateTime;


trait DateCreatedTrait
{
    /**
     * @var DateTime
     */
    protected $dateCreated;

    /**
     * @return DateTime $dateCreated
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param DateTime $dateCreated
     * @return $this
     */
    public function setDateCreated(DateTime $dateCreated = null)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }
}
