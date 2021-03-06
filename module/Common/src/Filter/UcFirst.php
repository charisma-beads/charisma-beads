<?php

namespace Common\Filter;

use Laminas\Filter\AbstractUnicode;
use Traversable;


class UcFirst extends AbstractUnicode
{
    /**
     * @var array
     */
    protected $options = [
        'encoding' => null,
    ];

    /**
     * Constructor
     *
     * @param string|array|Traversable $encodingOrOptions OPTIONAL
     */
    public function __construct($encodingOrOptions = null)
    {
        if ($encodingOrOptions !== null) {
            if (!static::isOptions($encodingOrOptions)) {
                $this->setEncoding($encodingOrOptions);
            } else {
                $this->setOptions($encodingOrOptions);
            }
        }
    }

    /**
     * Defined by Laminas\Filter\FilterInterface
     *
     * Returns the string $value, converting words to have an uppercase first character as necessary
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return string|mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }

        $value = (string)$value;

        if ($this->options['encoding'] !== null) {
            $string = mb_strtolower($value, $this->options['encoding']);
            $upper = mb_strtoupper($string, $this->options['encoding']);
            preg_match('#(.)#us', $upper, $matches);
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $this->options['encoding']), $this->options['encoding']);
            return $string;
        }

        return ucfirst(strtolower($value));
    }
}
