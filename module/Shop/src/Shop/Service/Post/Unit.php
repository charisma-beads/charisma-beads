<?php
namespace Shop\Service\Post;

use Application\Service\AbstractService;

class Unit extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\PostUnit';
    protected $form = 'Shop\Form\PostUnit';
    protected $inputFilter = 'Shop\InputFilter\PostUnit';
}
