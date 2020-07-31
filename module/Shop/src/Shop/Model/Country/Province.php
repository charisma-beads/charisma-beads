<?php

namespace Shop\Model\Country;

use Shop\Model\CountryProvinceModel;


/**
 * Class Province
 *
 * @package Shop\Model\Country
 */
class Province extends CountryProvinceModel
{
    protected $lft;

    protected $rgt;

    /**
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @param mixed $lft
     * @return Province
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @param mixed $rgt
     * @return Province
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
        return $this;
    }
}
