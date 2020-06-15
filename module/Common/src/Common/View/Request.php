<?php

namespace Common\View;


class Request extends AbstractViewHelper
{
    public function __invoke()
    {
        return $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Request');
    }
}
