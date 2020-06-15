<?php

declare(strict_types=1);

namespace User\Model;

use Common\Model\ModelInterface;

trait ResourceTrait
{
    /**
     * @var string
     */
    protected $resource;

    public function getResource(): ?string
    {
        return $this->resource;
    }

    public function setResource(?string $resource): ModelInterface
    {
        $this->resource = $resource;
        return $this;
    }
}
