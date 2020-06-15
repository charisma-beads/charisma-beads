<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller\Customer
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Controller;

use Shop\Service\CustomerService;
use Shop\ShopException;
use Common\Controller\AbstractCrudController;
use Zend\Form\Form;
use Zend\Http\PhpEnvironment\Response;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class Customer
 *
 * @package Shop\Controller
 */
class CustomerController extends AbstractCrudController
{
    protected $controllerSearchOverrides = array('sort' => 'name');
    protected $serviceName = CustomerService::class;
    protected $userRoute = 'shop/customer';
    protected $route = 'admin/shop/customer';
    protected $routes = [
        'edit' => 'admin/shop/customer/edit',
    ];

    public function autoCompleteAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Action not allowed');
        }

        $data = $this->getService()->fetchAll();

        return new JsonModel([
            'results' => $data->toArray(),
        ]);
    }

    public function listNewAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Action not allowed');
        }

        /* @var $service \Shop\Service\CustomerService */
        $service = $this->getService();

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        return $viewModel->setVariables([
            'models' => $service->getCustomersByMonth(date('m')),
        ]);
    }

    public function updateAddressAction()
    {
        if (!$this->getRequest()->isXmlHttpRequest()) {
            throw new ShopException('Action not allowed');
        }

        $jsonModel = new JsonModel();

        /* @var $service \Shop\Service\CustomerService */
        $service = $this->getService();

        try {
            $post = $this->params()->fromPost();
            $result = $service->setCustomerAddress($post);

            return $jsonModel->setVariables([
                'status' => ($result) ? 'success' : 'danger',
                'messages' => ($result) ?
                    'Address was saved to database' :
                    'Could not save address due to an error',
            ]);
        } catch (\Exception $e) {
            return $jsonModel->setVariables([
                'status' => 'danger',
                'messages' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @return array|\Zend\Http\Response
     * @throws \Common\Service\ServiceException
     */
    public function myDetailsAction()
    {
        $prg = $this->prg($this->userRoute);

        /* @var $service \Shop\Service\CustomerService */
        $service = $this->getService();
        $userId = $this->identity()->getUserId();

        $customer = $service->getCustomerByUserId($userId);

        if ($prg instanceof Response) {
            // returned a response to redirect us
            return $prg;
        } elseif ($prg === false) {
            // this wasn't a POST request, but there were no params in the flash messenger
            // probably this is the first time the form was loaded
            return [
                'form' => $this->getService()->prepareForm($customer),
                'model' => $customer,
            ];
        }

        $result = $service->edit($customer, $prg);

        if ($result instanceof Form) {

            $this->flashMessenger()->addInfoMessage(self::FORM_ERROR);

            return [
                'form' => $result,
                'model' => $customer,
            ];
        }

        if ($result) {
            $this->flashMessenger()->addSuccessMessage('Your changes were saved.');
        } else {
            $this->flashMessenger()->addErrorMessage('Your changes could not be save due to database error.');
        }

        return $this->redirect()->toRoute($this->userRoute);
    }
}
