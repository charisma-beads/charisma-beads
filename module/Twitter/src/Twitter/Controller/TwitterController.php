<?php

namespace Twitter\Controller;

use Twitter\Service\Twitter;
use Zend\Mvc\Controller\AbstractActionController;
use Common\Service\ServiceTrait;
use Zend\View\Model\ViewModel;


class TwitterController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * @return ViewModel
     * @throws \Exception
     */
    public function twitterFeedAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        /* @var $service \Twitter\Service\Twitter */
        $service = $this->getService(Twitter::class);

        $tweets = $service->getUserTimeLine();
        $viewModel->setVariable('tweets', $tweets);

        return $viewModel;
    }
}
