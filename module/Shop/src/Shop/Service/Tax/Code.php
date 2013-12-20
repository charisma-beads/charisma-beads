<?php
namespace Shop\Service\Tax;

use Application\Service\AbstractService;
use Shop\Model\Tax\Code as TaxCode;

class Code extends AbstractService
{
    protected $mapperClass = 'Shop\Mapper\TaxCode';
    protected $form = '';
    protected $inputFilter = '';
    
    /**
     * @var \Shop\Service\Tax\Rate
     */
    protected $taxRateService;
    
    public function getById($id)
    {
        $taxCode = parent::getById($id);
        $this->populate($taxCode);
        
        return $taxCode;
    }
    
    /**
     * @param TaxCode $taxCode
     */
    public function populate(TaxCode $taxCode)
    {
        $taxCode->setRelationalModel($this->getTaxRateService()->getById($taxCode->getTaxRateId()));
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
