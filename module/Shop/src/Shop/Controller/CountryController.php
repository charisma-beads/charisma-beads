<?php
namespace Shop\Controller;

use Application\Controller\AbstractController;
use Shop\Form\Country as CountryForm;
use Zend\View\Model\ViewModel;

class CountryController extends AbstractController
{
	/**
	 * @var \Shop\Service\Country
	 */
	protected $countryService;
	
	public function indexAction()
	{
		$page = $this->params()->fromRoute('page', 1);
		 
		$params = array(
			'sort' => 'country',
		);
		 
		return new ViewModel(array(
			'countries' => $this->getCountryService()->usePaginator(array(
				'limit' => 25,
				'page' => $page
			))->searchCountries($params)
		));
	}
	
	public function listAction()
	{
		if (!$this->getRequest()->isXmlHttpRequest()) {
			return $this->redirect()->toRoute('admin/shop/country');
		}
		 
		$params = $this->params()->fromPost();
		 
		$viewModel = new ViewModel(array(
			'countries' => $this->getCountryService()->usePaginator(array(
				'limit' => $params['count'],
				'page' => $params['page']
			))->searchCountries($params)
		));
		 
		$viewModel->setTerminal(true);
		 
		return $viewModel;
	}
	
	public function addAction()
	{
		$request = $this->getRequest();
		 
		if ($request->isPost()) {
			 
			$result = $this->getCountryService()->add($request->getPost());
			 
			if ($result instanceof CountryForm) {
				 
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				 
				return new ViewModel(array(
					'form' => $result
				));
				 
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Country has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Country could not be saved due to a database error.'
					);
				}
				 
				// Redirect to list of categories
				return $this->redirect()->toRoute('admin/shop/country');
			}
		}
		 
		return new ViewModel(array(
			'form' => $this->getCountryService()->getForm(),
		));
	}
	
	public function editAction()
	{
		$id = (int) $this->params('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/country', array(
				'action' => 'add'
			));
		}
		 
		// Get the Product Category with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the list page.
		try {
			$country = $this->getCountryService()->getById($id);
		} catch (\Exception $e) {
			$this->setExceptionMessages($e);
			return $this->redirect()->toRoute('admin/shop/country', array(
					'action' => 'list'
			));
		}
		 
		$request = $this->getRequest();
		 
		if ($request->isPost()) {
			 
			$result = $this->getCountryService()->edit($country, $request->getPost());
			 
			if ($result instanceof CountryForm) {
				 
				$this->flashMessenger()->addInfoMessage(
					'There were one or more isues with your submission. Please correct them as indicated below.'
				);
				 
				return new ViewModel(array(
					'form'		=> $result,
					'category'	=> $country,
				));
			} else {
				if ($result) {
					$this->flashMessenger()->addSuccessMessage(
						'Country has been saved to database.'
					);
				} else {
					$this->flashMessenger()->addErrorMessage(
						'Country could not be saved due to a database error.'
					);
				}
				 
				// Redirect to list of categories
				return $this->redirect()->toRoute('admin/shop/country');
			}
		}
		 
		$form = $this->getCountryService()->getForm($country);
		 
		return new ViewModel(array(
			'form'		=> $form,
			'country'	=> $country,
		));
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
		 
		$id = (int) $request->getPost('countryId');
		if (!$id) {
			return $this->redirect()->toRoute('admin/shop/country');
		}
		 
		if ($request->isPost()) {
			$del = $request->getPost('submit', 'No');
			 
			if ($del == 'delete') {
				try {
					$id = (int) $request->getPost('countryId');
					$result = $this->getCountryService()->delete($id);
						
					if ($result) {
						$this->flashMessenger()->addSuccessMessage(
							'Country has been deleted from the database.'
						);
					} else {
						$this->flashMessenger()->addErrorMessage(
							'Country could not be deleted due to a database error.'
						);
					}
				} catch (\Exception $e) {
					$this->setExceptionMessages($e);
				}
			}
			 
			// Redirect to list of categories
			return $this->redirect()->toRoute('admin/shop/country');
		}
		 
		return $this->redirect()->toRoute('admin/shop/country');
	
	}
	
	/**
	 * @return \Shop\Service\Country
	 */
	protected function getCountryService()
	{
		if (null === $this->countryService) {
			$sl = $this->getServiceLocator();
			$this->countryService = $sl->get('Shop\Service\Country');
		}
	
		return $this->countryService;
	}
}
