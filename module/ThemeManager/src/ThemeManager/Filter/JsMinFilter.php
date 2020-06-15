<?php

declare(strict_types=1);

namespace ThemeManager\Filter;

use Assetic\Asset\AssetInterface;
use Assetic\Filter\FilterInterface;


class JsMinFilter implements FilterInterface
{
    public function filterLoad(AssetInterface $asset)
    {
    }

    public function filterDump(AssetInterface $asset)
    {
        $asset->setContent(JSMin::minify($asset->getContent()));
    }
}