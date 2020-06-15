<?php

namespace FileManager\Validator;

use Zend\Validator\File\MimeType as ZendMimeType;


class MimeType extends ZendMimeType
{
    protected $magicFiles = [];
}
