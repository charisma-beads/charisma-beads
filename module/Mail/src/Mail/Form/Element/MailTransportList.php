<?php

namespace Mail\Form\Element;

use Mail\Options\MailOptions;
use Laminas\Form\Element\Select;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;


class MailTransportList extends Select implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * Set up value options
     */
    public function init()
    {
        /* @var $options MailOptions */
        $options = $this->getServiceLocator()
            ->getServiceLocator()
            ->get(MailOptions::class);

        $emailAddresses = $options->getAddressList();

        $addressList = [];

        foreach ($emailAddresses as $transport => $address) {

            $addressList[] = [
                'label' => $address['name'] . ' <' . $address['address'] . '>',
                'value' => $transport,
            ];
        }

        $this->setValueOptions($addressList);
    }
}
