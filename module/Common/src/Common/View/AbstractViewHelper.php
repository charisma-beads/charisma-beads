<?php

namespace Common\View;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

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
