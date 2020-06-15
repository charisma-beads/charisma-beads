<?php

declare(strict_types=1);


namespace Common\Filter;

use HTMLPurifier;
use Zend\Filter\AbstractFilter;

class HtmlPurifierFilter extends AbstractFilter
{
    /**
     * @var HTMLPurifier
     *
     */
    protected $instance;

    public function __construct(HTMLPurifier $htmlPurifier)
    {
        $this->instance = $htmlPurifier;
    }

    public function filter($value): string
    {
        return $this->instance->purify($value);
    }
}
