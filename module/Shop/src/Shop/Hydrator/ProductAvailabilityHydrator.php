<?php


namespace Shop\Hydrator;


use Shop\Hydrator\Strategy\JsonStrategy;
use Shop\Model\ProductAvailabilityModel;
use Zend\Hydrator\AbstractHydrator;

class ProductAvailabilityHydrator extends AbstractHydrator
{

    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('jsonData', new JsonStrategy());
    }

    /**
     * @param array $data
     * @param object|ProductAvailabilityModel $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        $object->setId($data['id'])
            ->setProductType($data['product_type'])
            ->setJsonData($this->extractValue('jsonData', $data['json_data']));
        return $object;
    }

    /**
     * @param object|ProductAvailabilityModel $object
     * @return array|void
     */
    public function extract($object)
    {
        return [
            'id'            => $object->getId(),
            'product_type'  => $object->getProductType(),
            'json_data'     => $this->extractValue('jsonData', $object->getJsonData()),
        ];
    }
}