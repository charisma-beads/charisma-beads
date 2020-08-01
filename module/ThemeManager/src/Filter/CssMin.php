<?php

namespace ThemeManager\Filter;

class CssMin
{
    public function minify($content, $filters, $plugins)
    {
        // remove comments, tabs, spaces, newlines, etc.
        $search = array(
            "/\/\*(.*?)\*\/|[\t\r\n]/s" => "",
            "/ +\{ +|\{ +| +\{/" => "{",
            "/ +\} +|\} +| +\}/" => "}",
            "/ +: +|: +| +:/" => ":",
            "/ +; +|; +| +;/" => ";",
            "/ +, +|, +| +,/" => ","
        );
        $buffer = preg_replace(array_keys($search), array_values($search), $content);
        return $buffer;
    }
}
