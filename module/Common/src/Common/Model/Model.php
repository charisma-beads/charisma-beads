<?php

namespace Common\Model;


trait Model
{
    /**
     * Check to see if this class has a 'get' or 'is' method defined
     *
     * @param string $prop
     * @return boolean
     */
    public function has($prop)
    {
        $getter = 'get' . ucfirst($prop);
        $return = method_exists($this, $getter);

        if (!$return) {
            $is = 'is' . ucfirst($prop);
            $return = method_exists($this, $is);
        }

        return $return;
    }

    /**
     * Returns object properties as an array
     *
     * @return array:
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
