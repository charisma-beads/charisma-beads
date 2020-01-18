<?php


namespace Shop\Model;


use UthandoCommon\Model\Model;
use UthandoCommon\Model\ModelInterface;

class ProductAvailabilityModel implements ModelInterface
{
    use Model;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $productType;

    /**
     * @var array
     */
    protected $jsonData;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ProductAvailabilityModel
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     * @return ProductAvailabilityModel
     */
    public function setProductType(string $productType)
    {
        $this->productType = $productType;
        return $this;
    }

    /**
     * @return array
     */
    public function getJsonData(): array
    {
        return $this->jsonData;
    }

    /**
     * @param array $jsonData
     * @return ProductAvailabilityModel
     */
    public function setJsonData(array $jsonData)
    {
        $this->jsonData = $jsonData;
        return $this;
    }
}