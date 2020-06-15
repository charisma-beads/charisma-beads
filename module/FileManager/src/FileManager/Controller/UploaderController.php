<?php

namespace FileManager\Controller;

use Common\Service\ServiceManager;
use FileManager\Service\ImageUploader;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ProgressBar\Upload\SessionProgress;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class UploaderController extends AbstractActionController
{
    public function uploadFormAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        /* @var $service ImageUploader */
        $service = $this->getServiceLocator()
            ->get(ServiceManager::class)
            ->get(ImageUploader::class);

        $request = $this->getRequest();

        if ($request->isPost()) {
            // Make certain to merge the files info!
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $result = $service->uploadImage($post);

            if ($result instanceof Form) {
                return new JsonModel([
                    'status' => false,
                    'formErrors' => $result->getMessages(),
                    'formData' => $result->getData(),
                ]);
            } else {
                return new JsonModel([
                    'status' => true,
                    'image' => $result,
                ]);
            }
        }

        return $viewModel->setVariable('form', $service->prepareForm());
    }

    public function uploadProgressAction()
    {
        $id = $this->params()->fromQuery('id', null);
        $progress = new SessionProgress();
        return new JsonModel($progress->getProgress($id));
    }
}