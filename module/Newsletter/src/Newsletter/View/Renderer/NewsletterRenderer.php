<?php

namespace Newsletter\View\Renderer;

use Newsletter\Model\MessageModel;
use Newsletter\Model\TemplateModel;
use Newsletter\View\Model\NewsletterViewModel;
use Newsletter\View\Resolver\NewsletterResolver;
use Zend\View\Exception\DomainException;
use Zend\View\Exception\RuntimeException;
use Zend\View\Renderer\RendererInterface;
use Zend\View\Resolver\ResolverInterface;


class NewsletterRenderer implements RendererInterface
{
    /**
     * @var NewsletterResolver
     */
    protected $resolver = null;

    /**
     * @var NewsletterEngine
     */
    protected $engine;

    /**
     * @param ResolverInterface $resolver
     * @return $this
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
        return $this;
    }

    /**
     * @param null $name
     * @return array|null|MessageModel|TemplateModel|NewsletterResolver
     */
    public function resolver($name = null)
    {
        if (null !== $name) {
            return $this->resolver->resolve($name, $this);
        }

        return $this->resolver;
    }

    /**
     * @return NewsletterEngine
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * @param NewsletterEngine $engine
     * @return $this
     */
    public function setEngine(NewsletterEngine $engine)
    {
        $this->engine = $engine;
        return $this;
    }

    /**
     * @param string|\Zend\View\Model\ModelInterface $nameOrModel
     * @param null $values
     * @return string
     */
    public function render($nameOrModel, $values = null)
    {
        if ($nameOrModel instanceof NewsletterViewModel) {
            $model       = $nameOrModel;
            $nameOrModel = $model->getTemplate();

            if (empty($nameOrModel)) {
                throw new DomainException(sprintf(
                    '%s: received View Model argument, but template is empty',
                    __METHOD__
                ));
            }

            $parseImages = $model->getOption('parse_images');
            $this->getEngine()->setParseImages($parseImages);

            $this->getEngine()->setVariables($model->getVariables());
            unset($model);
        }

        $model = $this->resolver($nameOrModel);

        if (!$model) {
            throw new RuntimeException(sprintf(
                '%s: Unable to render template "%s"; resolver could not resolve to a table row',
                __METHOD__,
                $nameOrModel
            ));
        }

        return $this->getEngine()->render($model);
    }
}