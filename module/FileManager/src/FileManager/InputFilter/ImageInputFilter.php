<?php

namespace FileManager\InputFilter;

use FileManager\Options\FileManagerOptions;
use FileManager\Validator\IsImage;
use Laminas\Filter\File\RenameUpload;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\File\Extension;
use Laminas\Validator\File\ImageSize;
use Laminas\Validator\File\UploadFile;


class ImageInputFilter extends InputFilter
{
    public function addImageFile(FileManagerOptions $options)
    {
        $allowedExtensions = array_keys($options->getAllowImageTypes());
        $allowedMimeTypes = array_values($options->getAllowImageTypes());

        $this->add([
            'name' => 'fileupload',
            'required' => true,
            'validators' => [
                ['name' => UploadFile::class],
                ['name' => Extension::class, 'options' => [
                    'extension' => $allowedExtensions,
                    'case' => $options->getCaseSensitive(),
                ]],
            ],
            'filters' => [
                ['name' => RenameUpload::class, 'options' => [
                    'target' => $options->getDestination(),
                    'useUploadName' => true,
                    'useUploadExtension' => true,
                    'overwrite' => $options->getOverwrite(),
                ]],
            ],
        ]);

        if (false === $options->getResizeOverSized()) {
            $sizeOptions = [];

            if ($options->getUseMin()) {
                $sizeOptions['minWidth'] = $options->getMinWidth();
                $sizeOptions['minHeight'] = $options->getMinHeight();
            }

            if ($options->getUseMax()) {
                $sizeOptions['maxWidth'] = $options->getMaxWidth();
                $sizeOptions['maxHeight'] = $options->getMaxHeight();
            }

            $this->get('fileupload')->getValidatorChain()
                ->attachByName(ImageSize::class, $sizeOptions);
        }

        // some web hosts have disabled fileinfo, so we check it's there
        // first before adding FileIsImage validator as it depends
        // on SPL FileInfo or mime_content_type function.
        if (extension_loaded('fileinfo') || function_exists('mime_content_type')) {
            $this->get('fileupload')->getValidatorChain()
                ->attachByName(IsImage::class, [
                    'mimeType' => $allowedMimeTypes,
                ]);
        }
    }
} 