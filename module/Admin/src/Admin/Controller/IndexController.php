<?php declare(strict_types=1);

namespace Admin\Controller;

use Common\Service\ServiceTrait;
use User\Form\ForgotPasswordForm;
use User\Form\LoginForm;
use User\Form\PasswordForm;
use User\Form\UserEditForm;
use User\InputFilter\UserInputFilter as UserInputFilter;
use User\Service\Authentication;
use User\Service\LimitLoginService;
use User\Service\UserService;
use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Admin\Controller
 * @method \Zend\Session\Container sessionContainer()
 */
class IndexController extends AbstractActionController
{
    use ServiceTrait;

    /**
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    public function profileAction()
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
                return $this->redirect()->toRoute('admin');
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

    public function passwordAction(): array
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

    public function forgotPasswordAction()
    {
        $viewModel  = new ViewModel();
        $this->layout()->setTemplate('layout/basic');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $data = $this->params()->fromPost();

            $result = $this->getUserService()->forgotPassword($data);

            if ($result instanceof Form) {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );

                $viewModel->setVariables([
                    'form' => $result,
                ]);

                return $viewModel;

            } else {
                if ($result) {
                    $this->flashMessenger()->addSuccessMessage(
                        'Your new password has been saved and will be emailed to you.'
                    );

                    return $this->redirect()->toRoute('admin/admin', [
                        'action' => 'login',
                    ]);
                } else {
                    $this->flashMessenger()->addErrorMessage(
                        'We could not change password due to database error.'
                    );
                }
            }
        }

        $form = $this->getUserService()->getForm(ForgotPasswordForm::class);
        $viewModel->setVariables([
            'form' => $form,
        ]);

        return $viewModel;
    }

    public function loginAction()
    {
        $viewModel  = new ViewModel();
        $form       = $this->getService('FormElementManager')
            ->get(LoginForm::class);
        $request    = $this->getRequest();

        $viewModel->setVariables([
            'form' => $form,
        ]);
        $this->layout()->setTemplate('layout/basic');
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

                return $viewModel;
            }
        }

        if ($request->isPost()) {
            $post = $this->params()->fromPost();

            if (!isset($post['rememberme'])) {
                $post['rememberme'] = 0;
            }

            /* @var $inputFilter UserInputFilter */
            $inputFilter = $this->getService('InputFilterManager')
                ->get(UserInputFilter::class);
            $inputFilter->addPasswordLength('login');

            $form->setInputFilter($inputFilter);
            $form->setValidationGroup(['email', 'passwd', 'rememberme']);

            $form->setData($post);

            if ($form->isValid()) {

                $data = $form->getData();

                /* @var $auth Authentication */
                $auth = $this->getServiceLocator()->get(AuthenticationService::class);
                $options = $auth->getOptions();
                $options->setAuthenticateMethod('getAdminUserByEmail');
                $auth->setOptions($options);

                if (false === $auth->doAuthentication($data['email'], $data['passwd'])) {
                    if (true === $limitLoginService->getOptions()->getLimitLogin()) {
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
                } else {
                    if (true === $limitLoginService->getOptions()->getLimitLogin()) {
                        $limitLoginService->delete($limitLogin->getId());
                    }

                    $this->flashMessenger()->addSuccessMessage(
                        'You have successfully logged in.'
                    );

                    if (isset($data['rememberme']) && $data['rememberme'] == 1) {
                        $auth->getStorage()->rememberMe(1);
                    }

                    $container = $this->sessionContainer(get_class($this));

                    // clear session varibles now we have redirected.
                    $container->getManager()->getStorage()->clear(get_class($this));

                    $config = $this->getServiceLocator()->get('config');

                    $adminRoute = (isset($config['uthando_user']['default_admin_route'])) ?
                        $this->getServiceLocator()->get('config')['uthando_user']['default_admin_route'] :
                        'admin';

                    return $this->redirect()->toRoute($adminRoute);
                }
            } else {
                $this->flashMessenger()->addErrorMessage(
                    'There were one or more issues with your submission. Please correct them as indicated below.'
                );
            }
        }

        return $viewModel;
    }

    public function logoutAction(): Response
    {
        /* @var $auth Authentication */
        $auth = $this->getService(AuthenticationService::class);
        $auth->clear();
        return $this->redirect()->toRoute('admin/admin', [
            'action' => 'login'
        ]);
    }

    protected function getUserService(): UserService
    {
        /* @var $service UserService */
        $service = $this->getService(UserService::class);
        return $service;
    }

    protected function getLimitLoginService(): LimitLoginService
    {
        /* @var $service LimitLoginService */
        $service = $this->getService(LimitLoginService::class);
        return $service;
    }
}