<?php

namespace Article\Form\Element;

use User\Form\Element\AbstractResourceList;


class ResourceList extends AbstractResourceList
{
    protected $resource = 'article';

    protected $emptyOption = null;
}
