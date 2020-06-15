<?php

namespace Common\Form\Element;

use Zend\Form\Element\Captcha as ZendCaptcha;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Captcha
 *
 * @package Common\Form\Element
 */
class Captcha extends ZendCaptcha implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * Set up elements
     */
    public function init()
    {
        $sl = $this->getServiceLocator()
            ->getServiceLocator();

        $config = $sl->get('config');

        $spec = $config['uthando_common']['captcha'];

        if ('image' === $spec['class']) {
            $plugins = $sl->get('ViewHelperManager');
            $urlHelper = $plugins->get('url');

            $font = $spec['options']['font'];

            if (is_array($font)) {
                $rand = array_rand($font);
                $randFont = $font[$rand];
                $font = $randFont;
            }

            $spec['options']['font'] = join('/', [
                $spec['options']['fontDir'],
                $font
            ]);

            $spec['options']['imgUrl'] = $urlHelper('captcha-form-generate');
        }

        $this->setCaptcha($spec);
    }
}
