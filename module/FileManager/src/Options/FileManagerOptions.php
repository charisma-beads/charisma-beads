<?php

declare(strict_types=1);

namespace FileManager\Options;

use Laminas\Stdlib\AbstractOptions;


class FileManagerOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $allowImageTypes = [
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    /**
     * @var bool
     */
    protected $caseSensitive = false;

    /**
     * @var string
     */
    protected $defaultFileType = 'jpg';

    /**
     * @var bool
     */
    protected $convertToDefault = false;

    /**
     * @var int
     */
    protected $maxHeight = 1024;

    /**
     * @var int
     */
    protected $maxWidth = 1024;

    /**
     * @var bool
     */
    protected $useMax = true;

    /**
     * @var int
     */
    protected $minHeight = 100;

    /**
     * @var int
     */
    protected $minWidth = 128;

    /**
     * @var bool
     */
    protected $useMin = true;

    /**
     * @var bool
     */
    protected $resizeOverSized = false;

    /**
     * @var int
     */
    protected $defaultFilePermissions = '644';

    /**
     * @var string
     */
    protected $destination = './public/userfiles/';

    /**
     * @var bool
     */
    protected $overwrite = false;

    /**
     * @var bool
     */
    protected $createThumbnail = false;

    /**
     * @var string
     */
    protected $thumbnailDirectory = 'thumbnails';

    /**
     * @var int
     */
    protected $thumbnailHeight = 300;

    /**
     * @var int
     */
    protected $thumbnailWidth = 300;

    /**
     * @return array
     */
    public function getAllowImageTypes()
    {
        return $this->allowImageTypes;
    }

    /**
     * @param $allowImageTypes
     * @return $this
     */
    public function setAllowImageTypes($allowImageTypes)
    {
        $this->allowImageTypes = $allowImageTypes;
        return $this;
    }

    /**
     * @return boolean $caseSensitive
     */
    public function getCaseSensitive()
    {
        return $this->caseSensitive;
    }

    /**
     * @param boolean $caseSensitive
     * @return $this
     */
    public function setCaseSensitive($caseSensitive)
    {
        $this->caseSensitive = (bool) $caseSensitive;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getConvertToDefault()
    {
        return $this->convertToDefault;
    }

    /**
     * @param $convertToDefault
     * @return $this
     */
    public function setConvertToDefault($convertToDefault)
    {
        $this->convertToDefault = (bool) $convertToDefault;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultFileType()
    {
        return $this->defaultFileType;
    }

    /**
     * @param $defaultFileType
     * @return $this
     */
    public function setDefaultFileType($defaultFileType)
    {
        $this->defaultFileType = $defaultFileType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * @param $maxHeight
     * @return $this
     */
    public function setMaxHeight($maxHeight)
    {
        $this->maxHeight = $maxHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxWidth()
    {
        return $this->maxWidth;
    }

    /**
     * @param $maxWidth
     * @return $this
     */
    public function setMaxWidth($maxWidth)
    {
        $this->maxWidth = $maxWidth;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinHeight()
    {
        return $this->minHeight;
    }

    /**
     * @param $minHeight
     * @return $this
     */
    public function setMinHeight($minHeight)
    {
        $this->minHeight = $minHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getMinWidth()
    {
        return $this->minWidth;
    }

    /**
     * @param $minWidth
     * @return $this
     */
    public function setMinWidth($minWidth)
    {
        $this->minWidth = $minWidth;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->overwrite;
    }

    /**
     * @param $overwrite
     * @return $this
     */
    public function setOverwrite($overwrite)
    {
        $this->overwrite = (bool) $overwrite;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getResizeOverSized()
    {
        return $this->resizeOverSized;
    }

    /**
     * @param $resizeOverSized
     * @return $this
     */
    public function setResizeOverSized($resizeOverSized)
    {
        $this->resizeOverSized = (bool) $resizeOverSized;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getUseMax()
    {
        return $this->useMax;
    }

    /**
     * @param $useMax
     * @return $this
     */
    public function setUseMax($useMax)
    {
        $this->useMax = (bool) $useMax;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getUseMin()
    {
        return $this->useMin;
    }

    /**
     * @param $useMin
     * @return $this
     */
    public function setUseMin($useMin)
    {
        $this->useMin = (bool) $useMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultFilePermissions()
    {
        return $this->defaultFilePermissions;
    }

    /**
     * @param $defaultFilePermissions
     * @return $this
     */
    public function setDefaultFilePermissions($defaultFilePermissions)
    {
        $this->defaultFilePermissions = $defaultFilePermissions;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCreateThumbnail()
    {
        return $this->createThumbnail;
    }

    /**
     * @param boolean $createThumbnail
     * @return $this
     */
    public function setCreateThumbnail($createThumbnail)
    {
        $this->createThumbnail = (bool) $createThumbnail;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnailDirectory()
    {
        return $this->thumbnailDirectory;
    }

    /**
     * @param string $thumbnailDirectory
     * @return $this
     */
    public function setThumbnailDirectory($thumbnailDirectory)
    {
        $this->thumbnailDirectory = $thumbnailDirectory;
        return $this;
    }

    /**
     * @return int
     */
    public function getThumbnailHeight()
    {
        return $this->thumbnailHeight;
    }

    /**
     * @param int $thumbnailHeight
     * @return $this
     */
    public function setThumbnailHeight($thumbnailHeight)
    {
        $this->thumbnailHeight = $thumbnailHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getThumbnailWidth()
    {
        return $this->thumbnailWidth;
    }

    /**
     * @param int $thumbnailWidth
     * @return $this
     */
    public function setThumbnailWidth($thumbnailWidth)
    {
        $this->thumbnailWidth = $thumbnailWidth;
        return $this;
    }
} 