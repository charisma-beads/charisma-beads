<?php

namespace Common\Stdlib;


abstract class StringUtils
{
    /**
     * Check to see if string starts with a string
     *
     * @param string $string
     * @param string $look
     * @return bool
     */
    public static function endsWith($string, $look)
    {
        return strrpos($string, $look) === strlen($string) - strlen($look);
    }

    /**
     * Checks to see if a string ends with a string.
     *
     * @param string $string
     * @param string $look
     * @return bool
     */
    public static function startsWith($string, $look)
    {
        return strpos($string, $look) === 0;
    }
}
