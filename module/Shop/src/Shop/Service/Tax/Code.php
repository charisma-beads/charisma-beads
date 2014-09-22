<?php
namespace Shop\Service\Tax;

use UthandoCommon\Service\AbstractRelationalMapperService;

class Code extends AbstractRelationalMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopTaxCode';

    /**
     * @var array
     */
    protected $referenceMap = [
        'taxRate'   => [
            'refCol'    => 'taxRateId',
            'service'   => 'Shop\Service\Tax\Rate',
        ],
    ];

    /**
     * @param int $id
     * @return array|mixed|\UthandoCommon\Model\ModelInterface
     */
    public function getById($id)
    {
        $taxCode = parent::getById($id);
        $this->populate($taxCode, true);
        
        return $taxCode;
    }

    /**
     * @param array $post
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function search(array $post)
    {
        $models = parent::search($post);

        /* @var $model \Shop\Model\Tax\Code */
        foreach ($models as $model) {
        	$this->populate($model, true);
        }
     
        return $models;
    }
}
