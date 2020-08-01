<?php

namespace Newsletter\View\Model;

use Laminas\View\Model\ViewModel;


class NewsletterViewModel extends ViewModel
{
    /**
     * Newsletter probably won't need to be captured into a
     * a parent container by default.
     *
     * @var string
     */
    protected $captureTo = null;

    /**
     * Newsletter is usually terminal
     *
     * @var bool
     */
    protected $terminate = true;
}