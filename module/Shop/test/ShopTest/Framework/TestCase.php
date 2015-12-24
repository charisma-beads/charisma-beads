<?php

namespace ShopTest\Framework;

use UthandoUser\Model\User as TestUserModel;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class TestCase extends AbstractHttpControllerTestCase
{
    /**
     * @var TestUserModel
     */
    protected $adminUser;

    /**
     * @var TestUserModel
     */
    protected $registeredUser;

    protected $traceError = true;

    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../TestConfig.php.dist'
        );

        parent::setUp();

        $sessionManager = new SessionManager();
        Container::getDefaultManager($sessionManager);

        $sessionMock = $this->getMockBuilder('UthandoSessionManager\Service\Factory\SessionManagerFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $sessionMock->expects($this->once())
            ->method('createService')
            ->will($this->returnValue($sessionManager));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('UthandoSessionManager\SessionManager', $sessionMock);
    }

    protected function setAjaxRequest()
    {
        $request = $this->getRequest();
        $headers = $request->getHeaders();
        $headers->addHeaders(array('X-Requested-With' =>'XMLHttpRequest'));
    }

    protected function getAdminUser()
    {
        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getApplicationServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        $user = new TestUserModel();

        $user->setFirstname('Joe')
            ->setLastname('Bloggs')
            ->setEmail('email@example.com')
            ->setRole('admin')
            ->setDateCreated(new \DateTime())
            ->setDateModified(new \DateTime());
        $auth->getStorage()->write($user);
        $this->adminUser = $user;
    }

    protected function getRegisteredUser()
    {
        /* @var $auth \UthandoUser\Service\Authentication */
        $auth = $this->getApplicationServiceLocator()
            ->get('Zend\Authentication\AuthenticationService');
        $user = new TestUserModel();

        $user->setFirstname('Joe')
            ->setLastname('Bloggs')
            ->setEmail('email@example.com')
            ->setRole('registered')
            ->setDateCreated(new \DateTime())
            ->setDateModified(new \DateTime());
        $auth->getStorage()->write($user);
        $this->registeredUser = $user;
    }
}