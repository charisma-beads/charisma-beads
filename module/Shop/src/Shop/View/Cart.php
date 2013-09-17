<?php
namespace Shop\View;

use Application\View\AbstractViewHelper;
use Shop\Model\Entity\Product;
use Shop\Form\Cart\Add;
use Zend\I18n\View\Helper\CurrencyFormat;

class Cart extends AbstractViewHelper
{
	/**
	 * @var Shop\Model\Cart
	 */
	public $cartModel;
	
	/**
	 * @var CurrencyFormat
	 */
	protected $currencyHelper;
	
	public function __invoke()
	{
		$this->cartModel = $this->getServiceLocator()
			->getServiceLocator()
			->get('Shop\Model\Cart');
	
		return $this;
	}
	
	public function countItems()
	{
		return count($this->cartModel);
	}
	
	public function getSummary()
	{
		$currency = $this->getCurrencyHelper();
		$itemCount = $this->countItems();
	
		if (0 == $itemCount) {
			return '<p>No Items</p>';
		}
	
		$html = '<p>Items: ' . $itemCount;
		$html .= ' | Total: ' . $currency(
			$this->cartModel->getSubTotal()
		);
		$html .= '<br /><a href="';
		$html .= $this->view->url('shop/cart', array(
			'action' => 'view'
		));
		$html .= '">View Cart</a></p>';
	
		return $html;
	}
	
	public function addForm(Product $product)
	{
		$form = new Add();
		
		$form->setData(array(
			'productId' => $product->productId,
			'returnTo'  => $this->view->serverUrl(true)
		));
		
		$form->setAttributes(array(
			'action' =>  $this->view->url('shop/cart', array(
				'action'   => 'add'
			)),
			'class' => 'form-search'
		));
	
		return $form;
	}
	
	/**
	 * @return CurrencyFormat
	 */
	protected function getCurrencyHelper()
	{
		if (!$this->currencyHelper instanceof CurrencyFormat) {
			$this->currencyHelper = $this->view->plugin('currencyFormat')
				->setCurrencyCode("GBP")->setLocale("en_GB");
		}
		
		return $this->currencyHelper;
	}
}