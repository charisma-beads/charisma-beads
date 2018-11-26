<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Event
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Event;

use UthandoFileManager\Service\ImageUploader;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

/**
 * Class FileManagerListener
 *
 * @package Shop\Event
 */
class FileManagerListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $events = $events->getSharedManager();

        $this->listeners[] = $events->attach([
            ImageUploader::class,
        ], ['pre.upload'], [$this, 'preImageUpload']);

        $this->listeners[] = $events->attach([
            ImageUploader::class,
        ], ['post.upload'], [$this, 'postImageUpload']);
    }

    public function preImageUpload(Event $e)
    {
        $data = $e->getParam('data');

        if (!isset($data['productId'])) {
            return;
        }

        /* @var $options \UthandoFileManager\Options\FileManagerOptions */
        $options = $e->getParam('options');
        $path = $options->getDestination() . 'shop/images/';
        $options->setDestination($path);
        $options->setCreateThumbnail(true);
    }

    public function postImageUpload(Event $e)
    {
        $data = $e->getParam('data');

        if (!isset($data['productId'])) {
            return;
        }

        /* @var $options \UthandoFileManager\Options\FileManagerOptions */
        $options = $e->getParam('options');
        /* @var $model \UthandoFileManager\Model\ImageModel */
        $model = $e->getParam('model');

        /* @var $service \Shop\Service\ProductImageService */
        $service = $e->getTarget()->getService('ShopProductImage');

        $post = [
            'productId' => $data['productId'],
            'full' => $model->getFileName(),
            'thumbnail' => $options->getThumbnailDirectory() . $model->getThumbnail(),
        ];

        $service->add($post);
    }
}
