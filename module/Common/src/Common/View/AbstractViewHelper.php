<?php

namespace Common\View;

use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\View\Helper\AbstractHelper;
use Laminas\View\Renderer\PhpRenderer;

/**
 * Class AbstractViewHelper
 *
 * @package Common\View
 * @method PhpRenderer getView()
 */
class AbstractViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ConfigTrait;
}
