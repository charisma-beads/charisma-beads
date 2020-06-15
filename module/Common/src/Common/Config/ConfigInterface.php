<?php

declare(strict_types=1);

namespace Common\Config;

interface ConfigInterface
{
    public function getUthandoConfig(): array;

    public function getModulePath(): string;
}
