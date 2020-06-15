<?php

namespace Contact\View\Helper;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use TwbBundle\Form\View\Helper\TwbBundleForm;
use Common\I18n\View\Helper\LibPhoneNumber;
use Common\View\AbstractViewHelper;
use Mail\Form\Element\MailTransportList;
use Zend\Config\Config;
use Zend\View\Renderer\PhpRenderer;

/**
 * Class ContactService
 *
 * @package Contact\View
 * @method PhpRenderer getView()
 */
class Contact extends AbstractViewHelper
{
    /**
     * @var Config
     */
    protected $contactConfig;

    /**
     * @var PhoneNumber
     */
    protected $phoneNumber;

    /**
     * @var LibPhoneNumber
     */
    protected $libPhoneNumberHelper;

    /**
     * @param null $key
     * @return $this|Config|string
     */
    public function __invoke($key = null)
    {
        if (!$this->contactConfig instanceof Config) {
            $config = $this->getConfig('uthando_contact');

            if (!$config instanceof Config) {
                $config = new Config($config);
            }

            $this->contactConfig = $config;
        }

        if (is_string($key)) {
            return $this->get($key);
        }

        return $this;
    }

    /**
     * @param $key
     * @return Config|string|null
     */
    public function get($key)
    {
        $keys = explode('.', $key);
        $returnValue = null;
        $config = $this->contactConfig;

        foreach ($keys as $key) {

            $returnValue = $config->get($key);

            if ($returnValue instanceof Config) {
                $config = $returnValue;
            }
        }

        return $returnValue;
    }

    /**
     * @param string $type
     * @param bool|false $localise
     * @return null|string|Config
     */
    public function formatPhoneNumber($type, $localise = false)
    {
        $phoneNumber        = $this->get('details.' . $type);
        $region             = $this->get('details.phone_region');
        $format             = (true === $localise) ? PhoneNumberFormat::NATIONAL : PhoneNumberFormat::E164;
        $phoneNumberHelper  = $this->getLibPhoneNumberHelper();

        return $phoneNumberHelper($phoneNumber, $region, $format);
    }

    /**
     * @return LibPhoneNumber
     */
    public function getLibPhoneNumberHelper()
    {
        if (!$this->libPhoneNumberHelper instanceof LibPhoneNumber) {
            $this->libPhoneNumberHelper = $this->getView()->plugin(LibPhoneNumber::class);
        }

        return $this->libPhoneNumberHelper;
    }

    /**
     * @return \Mail\Form\Element\MailTransportList
     */
    public function getTransportSelect()
    {
        /* @var FormElementManager $formManager */
        $formManager = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('FormElementManager');
        $select = $formManager->get(MailTransportList::class);
        $select->setName('transport_options');
        $select->setOptions([
            'label'	=> 'Email',
            'twb-layout' => TwbBundleForm::LAYOUT_HORIZONTAL,
            'column-size' => 'md-10',
            'label_attributes' => [
                'class' => 'col-md-2',
            ],
        ]);
        $select->setAttribute('id', 'mail-transport-select');
        return $select;
    }

    /**
     * @return string
     */
    public function businessHours()
    {
        $businessHours  = $this->get('details.business_hours');
        $html           = '';

        foreach ($businessHours as $daysAndHours) {
            $html .= '<span class="block"><strong>' . $daysAndHours['label'] . ':</strong> ' . $daysAndHours['text'] . '</span>';
        }

        return $html;
    }

    /**
     * @param $address
     * @param bool|false $newLines
     * @return mixed|string
     */
    public function formatAddress($address, $newLines = false)
    {
        $address    = $this->get($address);
        $html       = '';

        foreach($address as $key => $line) {
            $html .= $line['text'] . ', ';
        }

        $html = rtrim($html, ', ');

        if (true === $newLines) {
            $html = str_replace(',', '<br>', $html);
        }

        return $html;
    }
}
