<?php

namespace FileManager\Validator;

use Laminas\Validator\File\IsImage as ZendIsImage;


class IsImage extends ZendIsImage
{
    protected $magicFiles = [];
}
