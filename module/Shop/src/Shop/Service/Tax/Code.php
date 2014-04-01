<?php
namespace Shop\Service\Tax;

use Application\Service\AbstractService;

class Code extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\TaxCode';
    protected $form = 'Shop\Form\TaxCode';
    protected $inputFilter = 'Shop\InputFilter\TaxCode';
    
    /**
     * @var \Shop\Service\Tax\Rate
     */
    protected $taxRateService;
    
    public function getById($id)
    {
        $taxCode = parent::getById($id);
        $this->populate($taxCode, true);
        
        return $taxCode;
    }
    
    
    
    public function search(array $post)
    {
        $models = parent::search($post);
        
        foreach ($models as $model) {
        	$this->populate($model, true);
        }
     
        return $models;
    }
    
    /**
     * @param \Shop\Model\Tax\Code $model
     */
    public function populate($model, $children = false)
    {
        $allChildren = ($children === true) ? true : false;
        $children = (is_array($children)) ? $children : array();
        	
        if ($allChildren || in_array('taxRate', $children)) {
            $model->setTaxRate(
                $this->getTaxRateService()
                    ->getById($model->getTaxRateId())
            );
        }
    }
    
    
    public function getTaxRateService()
    {
        if (!$this->taxRateService) {
            $sl = $this->getServiceLocator();
            $this->taxRateService = $sl->get('Shop\Service\TaxRate');
        }
        
        return $this->taxRateService;
    }
}
