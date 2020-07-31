<?php

namespace FileManager\Validator;

use Laminas\Validator\File\MimeType as ZendMimeType;


class MimeType extends ZendMimeType
{
    protected $magicFiles = [];
}
