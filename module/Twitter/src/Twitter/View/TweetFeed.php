<?php

namespace Twitter\View;

use Common\View\AbstractViewHelper;
use Twitter\Service\Twitter;
use Zend\Stdlib\Exception\RuntimeException;
use Zend\Stdlib\Exception\InvalidArgumentException;
use Zend\View\Helper\Partial;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class TweetFeed
 *
 * @package Twitter\View
 * @method PhpRenderer getView()
 */
class TweetFeed extends AbstractViewHelper
{
    /**
     * @var \Twitter\Service\Twitter
     */
    protected $twitter;

    /**
     * Partial view script to use for rendering tweet feed
     *
     * @var string|array
     */
    protected $partial = 'twitter/twitter/twitter-feed';

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    public function getScreenName()
    {
        $config = $this->getConfig('uthando_social_media');

        return $config['twitter']['screen_name'] ?? '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render()
    {
        $partial = $this->getPartial();

        return $this->renderPartial($partial);
    }

    /**
     * Returns partial view script to use for rendering tweets
     *
     * @return string|array|null
     */
    public function getPartial()
    {
        return $this->partial;
    }

    /**
     * Sets which partial view script to use for rendering tweets
     *
     * @param  string|array $partial
     * @return \Twitter\View\TweetFeed
     */
    public function setPartial($partial)
    {
        if (null === $partial || is_string($partial) || is_array($partial)) {
            $this->partial = $partial;
        }

        return $this;
    }

    /**
     * @param null $partial
     * @return string
     */
    public function renderPartial($partial = null)
    {
        if (null === $partial) {
            $partial = $this->getPartial();
        }

        if (empty($partial)) {
            throw new RuntimeException(
                'Unable to render menu: No partial view script provided'
            );
        }

        $timeLine = $this->getTwitter()->getUserTimeLine($this->getScreenName());

        $model = array(
            'tweets' => $timeLine
        );

        /** @var Partial $partialHelper */
        $partialHelper = $this->getView()->plugin('partial');

        if (is_array($partial)) {
            if (count($partial) != 2) {
                throw new InvalidArgumentException(
                    'Unable to render menu: A view partial supplied as '
                    . 'an array must contain two values: partial view '
                    . 'script and module where script can be found'
                );
            }

            return $partialHelper($partial[0], /*$partial[1], */
                $model);
        }

        return $partialHelper($partial, $model);
    }

    /**
     * Gets the twitter instance
     *
     * @return \Twitter\Service\Twitter
     */
    public function getTwitter()
    {
        if (!$this->twitter) {
            $this->twitter = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(Twitter::class);
        }

        return $this->twitter;
    }
}
