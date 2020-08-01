<?php

namespace Common\Model;

use DateTime;

trait DateModifiedTrait
{
    /**
     * @var DateTime
     */
    protected $dateModified;

    /**
     * @return DateTime $dateModified
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param DateTime $dateModified
     * @return $this
     */
    public function setDateModified(DateTime $dateModified = null)
    {
        $this->dateModified = $dateModified;
        return $this;
    }
}
