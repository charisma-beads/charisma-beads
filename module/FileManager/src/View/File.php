<?php

namespace FileManager\View;

use Common\View\AbstractViewHelper;


abstract class File extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $fileDirectory;

    /**
     * @var string
     */
    protected $publicDirectory;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->renderFile();
    }

    /**
     * Must be implemented in parent class
     *
     * @param bool $withBasePath
     * @return string
     */
    abstract public function renderFile($withBasePath = true);

    /**
     * Checks to see if file exists
     *
     * @param null $directory
     * @return bool
     */
    public function fileExists($directory = null)
    {
        $directory = ($directory) ?: $this->fileDirectory;
        $fileExists = file_exists($this->publicDirectory . $directory . $this->file);
        return $fileExists;
    }

    /**
     * Checks to see if file is a file
     *
     * @param null $directory
     * @return bool
     */
    public function isFile($directory = null)
    {
        $directory = ($directory) ?: $this->fileDirectory;
        $isFile = is_file($this->publicDirectory . $directory . $this->file);
        return $isFile;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }

    /**
     * @param string $fileDirectory
     * @return $this
     */
    public function setFileDirectory($fileDirectory)
    {
        $this->fileDirectory = $fileDirectory;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublicDirectory()
    {
        return $this->publicDirectory;
    }

    /**
     * @param string $publicDirectory
     * @return $this
     */
    public function setPublicDirectory($publicDirectory)
    {
        $this->publicDirectory = $publicDirectory;
        return $this;
    }
}