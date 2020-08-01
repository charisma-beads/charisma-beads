<?php

namespace FileManager\Hydrator;

use FileManager\Model\Image as ImageModel;
use Laminas\Hydrator\AbstractHydrator;


class ImageHydrator extends AbstractHydrator
{
    /**
     * Extract values from model
     *
     * @param  ImageModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'name' => $object->getFileName(),
            'type' => $object->getType(),
            'size' => $object->getSize(),
            'tmp_name' => $object->getTempName(),
            'error' => $object->getError(),
            'size' => [
                0 => $object->getWidth(),
                1 => $object->getHeight(),
                2 => $object->getMimeType(),
            ],
        ];
    }

    /**
     * Hydrate model with the provided $data
     * from file upload.
     *
     * @param  array $data
     * @param  ImageModel $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $size = getImageSize($data['tmp_name']);

        $object->setFileName($data['name'])
            ->setType($data['type'])
            ->setSize($data['size'])
            ->setTempName($data['tmp_name'])
            ->setWidth($size[0])
            ->setHeight($size[1])
            ->setMimeType($size[2])
            ->setError($data['error']);
        return $object;
    }
}

