<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\View
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\View;

use Shop\Model\ProductModel;
use UthandoCommon\View\AbstractViewHelper;
use Zend\Json\Json;
use Zend\Paginator\Paginator;

/**
 * Class StructuredData
 *
 * @package Shop\View
 */
class StructuredData extends AbstractViewHelper
{
    /**
     * @var string
     */
    protected $format = '<script type="application/ld+json">%s</script>';

    /**
     * @var string
     */
    protected $schema = 'http://schema.org';

    /**
     * @var ProductModel|Paginator
     */
    protected $productOrList;

    /**
     * @param null $productOrList
     * @return $this|null|string
     */
    public function __invoke($productOrList = null)
    {
        if ($productOrList instanceof ProductModel || $productOrList instanceof Paginator) {
            $this->productOrList = $productOrList;
            return $this->render();
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function render()
    {
        $html = null;
        $json = null;

        if ($this->productOrList instanceof ProductModel) {
            $json = Json::encode($this->item($this->productOrList));
        }

        if ($this->productOrList instanceof  Paginator) {
            $json = Json::encode($this->itemList($this->productOrList));
        }

        if ($json) {
            $html = sprintf($this->format, $json);
        }

        return $html;
    }

    /**
     * @param ProductModel $product
     * @param bool $addSchema
     * @return array
     */
    public function item(ProductModel $product, $addSchema = true)
    {
        $array = [
            '@type'         => 'Product',
            'description'   => $product->getShortDescription(),
            'sku'           => $product->getSku(),
            'name'          => join(' ', [
                $product->getProductCategory()->getCategory(),
                $product->getSku(),
                $product->getName(),
            ]),
            'image'         => $this->view->serverUrl() . $this->view->productImage($product, 'thumb'),
            'url'           => $this->view->serverUrl() . $this->view->url('shop/catalog/product', [
                'categoryIdent' => $product->getProductCategory()->getIdent(),
                'productIdent' => $product->getIdent(),
            ]),
            'offers' => [
                '@type'         => 'Offer',
                'price'         => $product->getPrice(),
                'priceCurrency' => 'GBP',
            ],
        ];

        if (true === $addSchema) {
            $array['@context'] = $this->schema;
        }

        return $array;
    }

    /**
     * @param Paginator $list
     * @return array
     */
    public function itemList(Paginator $list)
    {
        $array = [
            '@context'          => $this->schema,
            '@type'             =>  'ItemList',
            'url'               =>  $this->view->serverUrl(true),
            'numberOfItems'     => $list->getCurrentItemCount(),
        ];

        foreach ($list as $item) {
            $array['itemListElement'][] = $this->item($item, false);
        }

        return $array;
    }
}
