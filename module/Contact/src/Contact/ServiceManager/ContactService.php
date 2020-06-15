<?php

declare(strict_types=1);

namespace Contact\ServiceManager;

use Common\Service\AbstractService;
use Contact\Form\ContactForm;
use Contact\InputFilter\ContactInputFilter;
use Contact\Options\FormOptions;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;

class ContactService extends AbstractService
{
    /**
     * @var FormOptions
     */
    protected $formOptions;

    /**
     * @param $data
     * @return bool
     */
    public function sendEmail($data): bool
    {
        if ($data instanceof Form) {
            $data = $data->getData();
        }

        $formOptions = $this->getOptions();

        $emailView = new ViewModel([
            'data' => $data,
        ]);

        $emailView->setTemplate('contact/email-template/default-content');

        $this->getEventManager()->trigger('mail.send', $this, [
            'sender' => [
                'name'      => $data['name'],
                'address'   => $data['email']
            ],
            'layout'            => 'contact/email-template/default-layout',
            'layout_params'     => [],
            'body'              => $emailView,
            'subject'           => '[Contact Form] ' . $data['subject'],
            'transport'         => $data['transport'],
        ]);

        if ($formOptions->getSendCopyToSender()) {

            $emailView->setTemplate('contact/email-template/default-sender-copy');

            $this->getEventManager()->trigger('mail.send', $this, [
                'recipient' => [
                    'name' => $data['name'],
                    'address' => $data['email']
                ],

                'layout'            => 'contact/email-template/default-layout',
                'layout_params'     => [],
                'body'              => $emailView,
                'subject' => '[ContactService Form] ' . $data['subject'],
                'transport' => $data['transport'],
            ]);
        }

        return true;
    }

    public function getContactForm(array $data = null): ContactForm
    {
        $sl = $this->getServiceLocator();
        $formManager = $sl->get('FormElementManager');
        $inputFilterManager = $sl->get('InputFilterManager');
        /* @var ContactInputFilter $inputFilter */
        $inputFilter = $inputFilterManager->get(ContactInputFilter::class);
        $formOptions = $this->getOptions();

        /* @var ContactForm $form */
        $form = $formManager->get(ContactForm::class, [
            'name'              => $formOptions->getName(),
            'enable_captcha'    => $formOptions->getEnableCaptcha(),
            'transport_list'    => $formOptions->getTransportList(),
        ]);
        $form->setInputFilter($inputFilter);
        $form->init();

        if ($data) {
            $form->setData($data);
        }

        return $form;
    }

    public function getOptions(): FormOptions
    {
        $sl = $this->getServiceLocator();
        /** @var FormOptions $options */
        $options = $sl->get(FormOptions::class);
        return $options;
    }
}
