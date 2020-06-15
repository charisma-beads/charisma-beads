<?php

namespace FileManager\Validator;

use Zend\Validator\File\IsImage as ZendIsImage;


class IsImage extends ZendIsImage
{
    protected $magicFiles = [];
}
