<?php

namespace ShopDomPdf\Model;

use Common\Model\AbstractCollection;


class PdfFooterCollection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $entityClass = PdfTextLine::class;

    /**
     * @var bool
     */
    protected $sorted = false;

    /**
     * @param array $array
     */
    public function __construct($array = [])
    {
        $this->addFooterLines($array);
    }

    /**
     * @param array $footerLines
     */
    public function addFooterLines(array $footerLines)
    {
        foreach ($footerLines as $line) {
            $this->addFooterLine($line);
        }
    }

    /**
     * @param $footerLine
     * @return $this
     */
    public function addFooterLine($footerLine)
    {
        if ($footerLine instanceof PdfTextLine) {
            $this->add($footerLine);
        }

        if (is_array($footerLine)) {
            $footerLine = new $this->entityClass($footerLine);
            $this->add($footerLine);
        }

        return $this;
    }

    /**
     * Make sure we have the items in the right order, reverse order
     */
    public function rewind()
    {
        if (!$this->sorted) {
            $this->entities = array_reverse($this->entities);
            $this->sorted = true;
        }

        parent::rewind();
    }
}
