<?php

namespace Newsletter\Controller;

use Common\Service\ServiceTrait;
use Newsletter\Form\PreferencesForm;
use Newsletter\Service\SubscriberService;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\AbstractActionController;


class PreferencesController extends AbstractActionController
{
    use ServiceTrait;

    public function indexAction()
    {
        $prg = $this->prg();

        /* @var SubscriberService $service */
        $service = $this->getService(SubscriberService::class);
        $form = $service->getForm(PreferencesForm::class);

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            return [
                'form' => $form,
            ];
        }

        $result = $service->removeSubscriberFromList($prg, $form);

        if ($result instanceof PreferencesForm) {
            $this->flashMessenger()->addErrorMessage(
                'There were one or more issues with your submission. Please correct them as indicated below.'
            );
            return [
                'form' => $form,
            ];
        }

        return [
            'result' => $result,
        ];
    }
}
