<?php

namespace FileManager\Service;

use FileManager\Form\ImageForm;
use FileManager\Hydrator\ImageHydrator;
use FileManager\InputFilter\ImageInputFilter;
use FileManager\Model\ImageModel;
use FileManager\FileManagerException;


class ImageUploader extends Uploader
{
    const MAX_WIDTH = 'MaxWidth';
    const MAX_HEIGHT = 'MaxHeight';
    const MIN_WIDTH = 'MinHeight';
    const MIN_HEIGHT = 'MinHeight';
    const NO_RESIZE = 'NoResize';
    const MIME_NOT_SUPPORTED = 'MimeNotSupported';

    protected $form         = ImageForm::class;
    protected $hydrator     = ImageHydrator::class;
    protected $inputFilter  = ImageInputFilter::class;
    protected $model        = ImageModel::class;

    /**
     * ImageUploader constructor.
     */
    public function __construct()
    {
        $this->messageTemplates = array_merge($this->messageTemplates, [
            self::MAX_WIDTH             => 'Image exceeds max width: %s',
            self::MAX_HEIGHT            => 'Image exceeds max height: %s',
            self::MIN_WIDTH             => 'Image is below the min width: %s',
            self::MIN_HEIGHT            => 'Image is below the min height: %s',
            self::NO_RESIZE             => '%s - Options do not allow resize',
            self::MIME_NOT_SUPPORTED    => 'Image type %s is not supported for resizing.'
        ]);
    }

    /**
     * @param $data
     * @return string
     */
    public function uploadImage($data)
    {
        /* @var $model \FileManager\Model\Image */
        $model = $this->getModel();
        $form = $this->prepareForm(null, $data, true, false);

        $options = $this->getOptions();

        $argv = compact('data', 'options');

        $this->getEventManager()->trigger('pre.upload', $this, $this->prepareEventArguments($argv));

        /* @var $inputFilter \FileManager\InputFilter\ImageInputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addImageFile($options);

        if (!$form->isValid()) {
            return $form;
        }

        $formData = $form->getData();

        $hydrator = $this->getHydrator();
        $model = $hydrator->hydrate($formData['fileupload'], $model);

        //change file permissions to default
        chmod($model->getTempName(), octdec($options->getDefaultFilePermissions()));

        if (true === $this->getOptions()->getResizeOverSized()) {
            $model = $this->resizeImage($model);
        }

        if (true === $this->getOptions()->getCreateThumbnail()) {
            $model = $this->generateThumbnail($model);
        }

        $argv = compact('data', 'options', 'model');

        $this->getEventManager()->trigger('post.upload', $this, $this->prepareEventArguments($argv));

        return $hydrator->extract($model);
    }

    /**
     * @param ImageModel $model
     * @return ImageModel
     * @throws FileManagerException
     */
    public function generateThumbnail(ImageModel $model)
    {
        $options            = $this->getOptions();
        $imageDirectory     = $options->getDestination();
        $thumbnailDirectory = $imageDirectory . $options->getThumbnailDirectory();
        $image              = $model->getTempName();
        $oldX               = $model->getWidth();
        $oldY               = $model->getHeight();

        if (!is_dir($thumbnailDirectory)) {
            mkdir($thumbnailDirectory, octdec('755'));
        }

        switch ($model->getMimeType()) {
            case IMAGETYPE_JPEG:
                $imageIn = imageCreateFromJpeg($image);
                break;
            case IMAGETYPE_PNG:
                $imageIn = imageCreateFromPng($image);
                break;
            case IMAGETYPE_GIF:
                $imageIn = imageCreateFromGif($image);
                break;
            default:
                throw new FileManagerException($this->error(self::MIME_NOT_SUPPORTED, $model->getMimeType()));
        }

        if ($model->getWidth() > $options->getThumbnailWidth()) {
            $model->setHeight(round(($options->getThumbnailWidth() * $model->getHeight()) / $model->getWidth()));
            $model->setWidth($options->getThumbnailWidth());
        }

        if ($model->getHeight() > $options->getThumbnailHeight()) {
            $model->setWidth(round(($model->getWidth() * $options->getThumbnailHeight()) / $model->getHeight()));
            $model->setHeight($options->getThumbnailHeight());
        }

        $imageOut = imageCreateTrueColor($model->getWidth(), $model->getHeight());

        imageCopyResampled(
            $imageOut, $imageIn,
            0, 0, 0, 0,
            $model->getWidth(), $model->getHeight(),
            $oldX, $oldY
        );

        $image = $thumbnailDirectory . $model->getFileName();
        $model->setThumbnail($model->getFileName());

        switch ($model->getMimeType()) {
            case IMAGETYPE_JPEG:
                imageJpeg($imageOut, $image);
                break;
            case IMAGETYPE_PNG:
                imagePng($imageOut, $image);
                break;
            case IMAGETYPE_GIF:
                imageGif($imageOut, $image);
                break;
        }

        imageDestroy($imageIn);
        imageDestroy($imageOut);

        return $model;
    }

    /**
     * @param ImageModel $model
     * @return ImageModel
     * @throws FileManagerException
     */
    public function resizeImage(ImageModel $model) : ImageModel
    {
        $options    = $this->getOptions();
        $image      = $model->getTempName();
        $oldX       = $model->getWidth();
        $oldY       = $model->getHeight();

        switch ($model->getMimeType()) {
            case IMAGETYPE_JPEG:
                $imageIn = imageCreateFromJpeg($image);
                break;
            case IMAGETYPE_PNG:
                $imageIn = imageCreateFromPng($image);
                break;
            case IMAGETYPE_GIF:
                $imageIn = imageCreateFromGif($image);
                break;
            default:
                throw new FileManagerException($this->error(self::MIME_NOT_SUPPORTED, $model->getMimeType()));
        }

        if ($model->getWidth() > $options->getMaxWidth()) {
            $model->setHeight(round(($options->getMaxWidth() * $model->getHeight()) / $model->getWidth()));
            $model->setWidth($options->getMaxWidth());
        }

        if ($model->getHeight() > $options->getMaxHeight()) {
            $model->setWidth(round(($model->getWidth() * $options->getMaxHeight()) / $model->getHeight()));
            $model->setHeight($options->getMaxHeight());
        }

        $imageOut = imageCreateTrueColor($model->getWidth(), $model->getHeight());

        imageCopyResampled(
            $imageOut, $imageIn,
            0, 0, 0, 0,
            $model->getWidth(), $model->getHeight(),
            $oldX, $oldY
        );

        switch ($model->getMimeType()) {
            case IMAGETYPE_JPEG:
                imageJpeg($imageOut, $image);
                break;
            case IMAGETYPE_PNG:
                imagePng($imageOut, $image);
                break;
            case IMAGETYPE_GIF:
                imageGif($imageOut, $image);
                break;
        }

        imageDestroy($imageIn);
        imageDestroy($imageOut);

        return $model;
    }
}
