<?php

namespace Shop\View;

use Shop\ShopException;
use Shop\Options\InvoiceOptions;
use Common\View\AbstractViewHelper;

/**
 * Class InvoiceOption
 *
 * @package Shop\View
 */
class InvoiceOption extends AbstractViewHelper
{
    /**
     * @var InvoiceOptions
     */
    protected $invoiceOptions;

    /**
     * @param null $key
     * @return mixed|InvoiceOptions
     * @throws ShopException
     */
    public function __invoke($key=null)
    {
        if (!$this->invoiceOptions instanceof InvoiceOptions) {
            $service = $this->getServiceLocator()
                ->getServiceLocator()
                ->get(InvoiceOptions::class);
            $this->invoiceOptions = $service;
        }

        if (is_string($key) && isset($this->invoiceOptions->$key)) {
            return $this->invoiceOptions->$key;
        } else {
            throw new ShopException('option ' . $key . ' does not exist.');
        }

        return $this->invoiceOptions;
    }
}