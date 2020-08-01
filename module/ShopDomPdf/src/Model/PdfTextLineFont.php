<?php

declare(strict_types=1);

namespace ShopDomPdf\Model;

use Common\Model\Model;
use Common\Model\ModelInterface;
use Laminas\Stdlib\Exception\InvalidArgumentException;


class PdfTextLineFont implements ModelInterface
{
    use Model;

    /**
     * @var string
     */
    protected $family = 'Helvetica';

    /**
     * @var string
     */
    protected $weight = 'normal';

    /**
     * @var int
     */
    protected $size = 8;

    /**
     * @var array
     */
    private $allowedWeights = [
        'normal', 'bold', 'italic', 'bold_italic'
    ];

    /**
     * @param array $font
     */
    public function __construct(array $font = [])
    {
        if (isset($font['family'])) {
            $this->setFamily($font['family']);
        }

        if (isset($font['weight'])) {
            $this->setWeight($font['weight']);
        }

        if (isset($font['size'])) {
            $this->setSize($font['size']);
        }
    }

    /**
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param string $family
     * @return $this
     */
    public function setFamily($family)
    {
        $this->family = $family;
        return $this;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        $weight = (string) $weight;

        if (!in_array($weight, $this->allowedWeights)) {
            $allowedWeights = implode(', ', $this->allowedWeights);
            throw new InvalidArgumentException('"' . $weight . '" must be one of ' . $allowedWeights . ' called in "' . __METHOD__ . '"');
        }

        $this->weight = $weight;
        return $this;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = (int) $size;
        return $this;
    }
}
