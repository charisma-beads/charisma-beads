<?php

namespace Shop\Event;

use Shop\Service\ProductImageService;
use FileManager\Service\ImageUploader;
use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;

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

        /* @var $options \FileManager\Options\FileManagerOptions */
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

        /* @var $options \FileManager\Options\FileManagerOptions */
        $options = $e->getParam('options');
        /* @var $model \FileManager\Model\ImageModel */
        $model = $e->getParam('model');

        /* @var $service \Shop\Service\ProductImageService */
        $service = $e->getTarget()->getService(ProductImageService::class);

        $post = [
            'productId' => $data['productId'],
            'full' => $model->getFileName(),
            'thumbnail' => $options->getThumbnailDirectory() . $model->getThumbnail(),
        ];

        $service->add($post);
    }
}
