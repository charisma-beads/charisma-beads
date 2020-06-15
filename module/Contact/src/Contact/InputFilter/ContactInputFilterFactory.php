<?php

namespace Contact\InputFilter;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ContactInputFilterFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return ContactInputFilter
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config         = $serviceLocator->getServiceLocator()->get('config');
        /* @var $request \Zend\Http\PhpEnvironment\Request */
        $request        = $serviceLocator->getServiceLocator()->get('Request');
        $akismetOptions = $config['uthando_common']['akismet'] ?? [];
        $options        = $config['uthando_contact']['form'] ?? [];
        $inputFilter    = new ContactInputFilter();

        $inputFilter->setAkismetEnabled($options['enable_akismet'] ?? false);
        $inputFilter->setAkismetOptions([
            'api_key'       => $akismetOptions['api_key'] ?? null,
            'blog'          => $akismetOptions['blog'] ?? null,
            'user_agent'    => $request->getServer('HTTP_USER_AGENT'),
            'user_ip'       => $request->getServer('REMOTE_ADDR'),
        ]);

        return $inputFilter;
    }
}