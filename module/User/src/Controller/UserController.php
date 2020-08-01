<?php

declare(strict_types=1);

namespace User\Controller;

use User\Form\ForgotPasswordForm;
use User\Form\LoginForm;
use User\Form\PasswordForm;
use User\Form\RegisterForm;
use User\Form\UserEditForm;
use User\InputFilter\UserInputFilter as UserInputFilter;
use User\Model\UserModel;
use User\Service\Authentication;
use User\Service\LimitLoginService;
use User\Service\UserService as UserService;
use User\Service\UserRegistrationService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Form\Form;
use Laminas\View\Model\ViewModel;
use Common\Service\ServiceTrait;

class UserController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct()
    {
        $this->serviceName = UserService::class;
    }

    public function thankYouAction()
    {
        $container = $this->sessionContainer(get_class($this));

        $email = $container->offsetGet('email');

        if (null === $email) {
            return $this->redirect()->toRoute('user', [
                'action' => 'login',
            ]);
        }

        /* @var $service \User\Service\UserRegistrationService */
        $service = $this->getService(UserRegistrationService::class);
        $service->sendVerificationEmail($email);

        return [];
    }

    public function registerAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {

            $post = $this->params()->fromPost();
            $post['role'] = 'registered';

            $result = $this->getUserService()->register($post);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return new ViewModel([
                    'registerForm' => $result
                ]);

            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Thank you, you have successfully registered with us.'
                    );

                    // add return and email to session.
                    $this->sessionContainer(get_class($this))
                        ->exchangeArray([
                            'email' => $post['email'],
                            'returnTo' => $post['returnTo'],
                        ]);

                    return $this->redirect()->toRoute('user', [
                        'action' => 'thank-you',
                    ]);

                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not register you due to a database error. Please try again later.'
                    );
                }
            }
        }

        $form = $this->getUserService()
            ->getForm(RegisterForm::class);

        return new ViewModel(array(
            'registerForm' => $form,
        ));
    }

    /**
     * @return UserService
     */
    protected function getUserService()
    {
        return $this->getService();
    }

    public function forgotPasswordAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $result = $this->getUserService()->forgotPassword($data);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return [
                    'form' => $result,
                ];
            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Your new password has been saved and will be emailed to you.'
                    );

                    return $this->redirect()->toRoute('user');
                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not change password due to database error.'
                    );
                }
            }
        }

        $form = $this->getUserService()->getForm(ForgotPasswordForm::class);

        return [
            'form' => $form,
        ];
    }

    public function passwordAction()
    {
        $request = $this->getRequest();
        /* @var $user \User\Model\UserModel */
        $user = $this->identity();

        if ($request->isPost()) {
            $params = $this->params()->fromPost();

            $result = $this->getUserService()->changePassword($params, $user);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return [
                    'form' => $result,
                ];
            }

            $this->flashMessenger()->addSuccessMessage(
                'Your new password has been saved.'
            );
        }

        $form = $this->getUserService()->getForm(PasswordForm::class);

        return [
            'form' => $form,
        ];
    }

    public function editAction()
    {
        /* @var $user \User\Model\UserModel */
        $user = $this->identity();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $params = $this->params()->fromPost();

            if ($params['userId'] === $user->getUserId()) {
                $result = $this->getUserService()->editUser($user, $params);
            } else {
                // Redirect to user
                return $this->redirect()->toRoute('user');
            }

            if ($result instanceof Form) {

                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                return new ViewModel([
                    'form' => $result,
                    'user' => $user,
                ]);
            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Your changes have been saved.'
                    );

                    // Redirect to user
                    return $this->redirect()->toRoute('user');

                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not save your changes due to a database error.'
                    );
                }
            }
        }

        /* @var \User\Form\UserEditForm $form */
        $form = $this->getUserService()->getForm(UserEditForm::class);
        $form->bind($user);

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function loginAction()
    {
        $form = $this->getService('FormElementManager')
            ->get(LoginForm::class);

        $limitLoginService = $this->getLimitLoginService();

        if (true === $limitLoginService->getOptions()->getLimitLogin()) {
            $limitLogin = $limitLoginService->getByIp();

            if (true === $limitLoginService->checkBanIp($limitLogin)) {
                $this->flashMessenger()->addErrorMessage(
                    sprintf(
                        'Too many failed login attempts. Please try again in %s.',
                        $limitLoginService->normalizeTime(
                            $limitLoginService->getTimeDiff($limitLogin)
                        )
                    )
                );

                return [
                    'loginForm' => $form
                ];
            }
        }

        return [
            'loginForm' => $form
        ];
    }

    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get(AuthenticationService::class);

        $auth->clear();
        return $this->redirect()->toRoute('home');
    }

    public function authenticateAction()
    {
        $request = $this->getRequest();

        $limitLoginService = $this->getLimitLoginService();

        if (true === $limitLoginService->getOptions()->getLimitLogin()) {
            $limitLogin = $limitLoginService->getByIp();

            if (true === $limitLoginService->checkBanIp($limitLogin)) {
                return $this->redirect()->toRoute('user', [
                    'action' => 'login',
                ]);
            }
        }

        if (!$request->isPost()) {
            return $this->redirect()->toRoute('user', [
                'action' => 'login',
            ]);
        }

        // Validate
        $post = $this->params()->fromPost();

        //if remember me is not in post then set it to zero.
        if (!isset($post['rememberme'])) {
            $post['rememberme'] = 0;
        }

        /* @var $form \User\Form\LoginForm */
        $form = $this->getUserService()->getForm(LoginForm::class);

        /* @var $inputFilter UserInputFilter */
        $inputFilter = $this->getService('InputFilterManager')
            ->get(UserInputFilter::class);
        $inputFilter->addPasswordLength('login');

        $form->setInputFilter($inputFilter);
        $form->setValidationGroup(['email', 'passwd', 'rememberme']);

        $form->setData($post);

        $viewModel = new ViewModel();

        $viewModel->setTemplate('user/user/login');

        if (!$form->isValid()) {
            $this->flashMessenger()->addErrorMessage(
                'There were one or more issues with your submission. Please correct them as indicated below.'
            );

            return $viewModel->setVariables(['loginForm' => $form]); // re-render the login form
        }

        $data = $form->getData();

        /* @var $auth Authentication */
        $auth = $this->getServiceLocator()->get(AuthenticationService::class);

        if (false === $auth->doAuthentication($data['email'], $data['passwd'])) {

            // check if user has regisitered but not activated their account
            $user = $this->getUserService()->getUserByEmail($data['email'], null, true, false);
            if ($user instanceof UserModel && false === $user->getActive()) {
                $message = 'You have not activated you account.';
            } elseif (true === $limitLoginService->getOptions()->getLimitLogin()) {
                $attempts = $limitLogin->getAttempts() + 1;
                $limitLogin->setAttempts($attempts);
                $limitLogin->setAttemptTime(strtotime('now'));
                $message = ($attempts < $limitLoginService->getOptions()->getMaxLoginAttempts()) ?
                    sprintf(
                        'Login failed, Please try again. %s attempt remaining.',
                        $limitLoginService->getOptions()->getMaxLoginAttempts() - $attempts
                    ) :
                    sprintf(
                        'Too many failed login attempts. Please try again in %s.',
                        $limitLoginService->normalizeTime(
                            $limitLoginService->getTimeDiff($limitLogin)
                        )
                    );
                $limitLoginService->save($limitLogin);
            } else {
                $message = 'Login failed, Please try again.';
            }
            $this->flashMessenger()->addErrorMessage($message);

            return $viewModel->setVariables(['loginForm' => $form]); // re-render the login form
        }

        $this->flashMessenger()->addSuccessMessage(
            'You have successfully logged in.'
        );

        if (isset($data['rememberme']) && $data['rememberme'] == 1) {
            $auth->getStorage()->rememberMe(1);
        }

        $container = $this->sessionContainer(get_class($this));
        $returnTo = ($container->offsetGet('returnTo')) ?: $this->params()->fromPost('returnTo', null);

        // clear session varibles now we have redirected.
        $container->getManager()->getStorage()->clear(get_class($this));

        $config = $this->getServiceLocator()->get('config');

        $adminRoute = (isset($config['user']['default_admin_route'])) ?
            $this->getServiceLocator()->get('config')['user']['default_admin_route'] :
            'admin';

        $return = ($returnTo) ? $returnTo : ('admin' === $auth->getIdentity()->getRole()) ? $adminRoute : 'home';

        return $this->redirect()->toRoute($return);
    }

    protected function getLimitLoginService(): LimitLoginService
    {
        /* @var $service LimitLoginService */
        $service = $this->getService(LimitLoginService::class);
        return $service;
    }
}

