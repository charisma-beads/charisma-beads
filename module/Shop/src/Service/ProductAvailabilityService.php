<?php

namespace Shop\Service;

use PDO;

class ProductAvailabilityService
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
