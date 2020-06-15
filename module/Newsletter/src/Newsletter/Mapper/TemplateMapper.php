<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;


class TemplateMapper extends AbstractDbMapper
{
    protected $table = 'newsletterTemplate';
    protected $primary = 'templateId';
}