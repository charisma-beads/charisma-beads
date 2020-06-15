<?php

namespace Mail\View\Helper;

use Common\View\AbstractViewHelper;
use Mail\Model\MailQueueModel;
use Mail\Options\MailOptions;
use Zend\Mail\Address;
use Zend\View\Exception\InvalidArgumentException;


class MailAddress extends AbstractViewHelper
{
    /**
     * @var MailOptions
     */
    protected $mailOptions;

    /**
     * @param MailQueueModel $row
     * @param string $type
     * @return string
     */
    public function __invoke(MailQueueModel $row, $type)
    {
        if (!$row->has($type)) {
            throw new InvalidArgumentException('wrong type given in class ' . __CLASS__);
        }

        $method = 'get' . ucwords($type);

        $address = $row->$method();

        if (null === $address) {
            $address = $this->getMailOptions()
                ->getAddressList()[$row->getTransport()];

            if (!$address instanceof Address) {
                $address = new Address(
                    $address['address'],
                    $address['name']
                );
            }
        }

        if ($address instanceof Address) {
            $address = $address->toString();
        }

        return $address;
    }

    /**
     * @return MailOptions
     */
    public function getMailOptions()
    {
        if (!$this->mailOptions instanceof MailOptions) {
            $options = $this->getServiceLocator()
                ->getServiceLocator()
                ->get('UthandoMail\Options\MailOptions');
            $this->mailOptions = $options;
        }

        return $this->mailOptions;
    }
}
