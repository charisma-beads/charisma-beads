<?php
namespace Shop\Service;

use Application\Model\AbstractCollection;
use Application\Model\CollectionException;
use Shop\Model\CartItem;
use Shop\Model\Product as ProductModel;
use Zend\Session\Container;
use SeekableIterator;

class Cart extends AbstractCollection implements SeekableIterator
{	
	/**
	 * Total before shipping
	 * 
	 * @var decimal
	*/
	protected $subTotal = 0;
	
	/**
	 * Total with shipping
	 * 
	 * @var decimal
	 */
	protected $total = 0;
	
	/**
	 * The shipping cost
	 * 
	 * @var decimal
	 */
	protected $shipping = 0;
	
	/**
	 * Total of tax
	 * 
	 * @var decimal
	 */
	protected $taxTotal = 0;
	
	/**
	 * ZNS for Persistance
	 *
	 * @var Zend\Session\Container
	 */
	protected $container;
	
	/**
	 * entity class name
	 *
	 * @var string
	 */
	protected $entityClass = 'Shop\Model\CartItem';
	
	/**
	 * @var \Shop\Service\Taxation
	 */
	protected $taxService;
	
	/**
	 * Constructor
	 */
	public function  __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Adds or updates an item contained with the shopping cart
	 *
	 * @param Shop\Model\Product $product
	 * @param int $qty
	 * @return Shop\Model\CartItem
	 */
	public function addItem(ProductModel $product, $qty)
	{
		if (0 > $qty) {
			return false;
		}
	
		if (0 == $qty) {
			$this->removeItem($product);
			return false;
		}
		
		$cartItem = new CartItem();
		
		$cartItem->setProduct($product)
		  ->setQty($qty);
		
		$this->entities[$cartItem->getProductId()] = $cartItem;
		
		$this->persist();
		
		return $cartItem;
	}
	
	/**
	 * Remove an item for the shopping cart
	 *
	 * @param int|Shop\Model\Product $product
	 */
	public function removeItem($product)
	{
		if (is_int($product)) {
			unset($this->entities[$product]);
		}
	   
		if ($product instanceof ProductModel) {
			unset($this->entities[$product->getProductId()]);
		}
	
		return $this->persist();
	}
	
	/**
	 * clears shopping cart of all items
	 */
	public function clear()
	{
		parent::clear();
		return $this->persist();
	}
	
	/**
	 * Setter for the session namespace
	 *
	 * @param Zend\Session\Container $ns
	 */
	public function setContainer(Container $ns)
	{
		$this->container = $ns;
	}
	
	/**
	 * Getter for session namespace
	 *
	 * @return  Zend\Session\Container
	 */
	public function getContainer()
	{   
        if (!$this->container instanceof Container) {
        	$this->setContainer(new Container(__CLASS__));
        }
        
        return $this->container;
	}
	
	/**
	 * Persist the cart data in the session
	 */
	public function persist()
	{   
		$this->getContainer()->items = $this->entities;
		$this->getContainer()->shipping = $this->getShippingCost();
	}
	
	/**
	 * Load any presisted data
	 */
	public function loadSession()
	{
	    
		if (isset($this->getContainer()->items)) {
			$this->entities = $this->getContainer()->items;
		}
	
		if (isset($this->getContainer()->shipping)) {
			$this->setShippingCost($this->getContainer()->shipping);
		}
		
	}
	
	/**
	 * calulates the item line price
	 * 
	 * @param CartItem $item
	 * @return number
	 */
	public function getLineCost(CartItem $item)
	{
	    $price = $item->getPrice();
	
	    if (0 !== $item->getDiscountPercent()) {
	        $discounted = ($price*$item->getDiscountPercent())/100;
	        $price = round($price-$discounted, 2);
	    }
	    
	    if (true === $item->getTaxable()) {
	        $taxService = $this->getTaxService();
	        $taxService->setTaxInc($item->getVatInc());
	        $price = $taxService->addTax($price, $item->getTaxRate());
	        $this->taxTotal += $price['tax'] * $item->getQty();
	    }
	
	    return ($price['price'] + $price['tax']) * $item->getQty();
	}
	
	/**
	 * Calculate the totals
	 */
	public function calculateTotals()
	{
		$sub = 0;
		$this->taxTotal = 0;
	
		foreach($this->getEntities() as $item) {
			$sub = $sub + $this->getLineCost($item);
		}
	
		$this->subTotal = $sub;
		$this->total = $this->subTotal + $this->shipping;
	}
	
	/**
	 * Set the shipping cost
	 *
	 * @param float $cost
	 */
	public function setShippingCost($cost)
	{
		$this->shipping = $cost;
		$this->calculateTotals();
		$this->persist();
	}
	
	/**
	 * Get the shipping cost
	 *
	 * @return float
	 */
	public function getShippingCost()
	{
		$this->calculateTotals();
		return $this->shipping;
	}
	
	/**
	 * Get the sub total
	 *
	 * @return float
	 */
	public function getSubTotal()
	{
		$this->calculateTotals();
		return $this->subTotal;
	}
	
	/**
	 * Get the basket total
	 *
	 * @return float
	 */
	public function getTotal()
	{
		$this->calculateTotals();
		return $this->total;
	}
	
	/**
	 * Seek to the given index.
	 *
	 * @param int $index seek index
	 */
	public function seek($index)
	{
		$this->rewind();
		$position = 0;
	
		while ($position < $index && $this->valid()) {
			$this->next();
			$position++;
		}
	
		if (!$this->valid()) {
			throw new CollectionException('Invalid seek position');
		}
	}
	
	/**
	 * @return \Shop\Service\Tax $taxService
	 */
	public function getTaxService()
	{
		return $this->taxService;
	}

	/**
	 * @param \Shop\Service\Tax $taxService
	 */
	public function setTaxService($taxService)
	{
		$this->taxService = $taxService;
		return $this;
	}

}
