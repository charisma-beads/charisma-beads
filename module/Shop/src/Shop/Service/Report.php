<?php
namespace Shop\Service;

use Zend\Json\Json;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

/**
 * Class Report
 *
 * @package Shop\Service
 */
class Report implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function setReportMemoryLimit()
    {
        $memoryLimit = $this->getShopOptions()
            ->getReportsMemoryLimit();

        if ($memoryLimit) {
            ini_set('memory_limit', $memoryLimit);
        }
    }

    public function checkMemoryLimit()
    {
        if((str_replace('M','',ini_get('memory_limit'))*1048576) - memory_get_usage() < 1048576*16){ // 16 MB headroom
            throw new \Exception('Almost out of memory, ' . (memory_get_usage(true) / 1024 / 1024) . ' MB used.
                    Try increasing the "reports memory limit" in the shop settings.
                    Current limit is: ' . ini_get('memory_limit') . '.' );
        }
    }
    
    public function createProductList($post)
    {
        $this->setReportMemoryLimit();

        $objPHPExcel = new \PHPExcel();
        
        $arrayData = [
            ['A' => 'Sku', 'B' => 'Product Name', 'C' => 'Category', 'D' => 'Price', 'E' => 'Size', 'F' => 'Weight'],
        ];
        
        $productService         = $this->getProductService();
        $productCategoryService = $this->getProductCategoryService();
        
        $products               = $productService->search($post);
        $filename               = ($productCategoryService->getById($post['productCategoryId'])->getIdent()) ?: 'all-products';
        $fileExtension          = '.xlsx';
        $lastRowNumber          = $products->count() + 1;
        $c                      = 2;
        $previousCategory       = '';
        $sheet                  = $objPHPExcel->getActiveSheet();

        $sheet->fromArray($arrayData);
        
        /* @var $product \Shop\Model\Product\Product */
        foreach ($products as $key => $product) {

            $this->checkMemoryLimit();
            
            $currentCategory = $product->getProductCategory()->getCategory();
            
            if ($previousCategory !== $currentCategory) {
                $pathway = $productCategoryService->getParentCategories($product->getProductCategoryId());
                $categoryTitle = [];
                
                foreach ($pathway as $category) {
                    $categoryTitle[] = $category->getCategory();
                }
                
                $sheet->getCell('A'.$c)
                    ->setValue(join(' / ', $categoryTitle));
                
                $sheet->getStyle('A'.$c)
                    ->getFont()
                    ->setBold(true);
                
                $sheet->mergeCells('A'.$c.':F'.$c);
                
                $previousCategory = $currentCategory;
                $lastRowNumber++;
                $c++;
            }
            
            $sheet->getCell('A'.$c)
                ->setValue($product->getSku());
            
            $sheet->getCell('B'.$c)
                ->setValue($product->getName());
            
            $sheet->getCell('C'.$c)
                ->setValue($product->getProductCategory()->getCategory());
            
            $sheet->getCell('D'.$c)
                ->setValue($product->getPrice());
            
            $sheet->getCell('E'.$c)
                ->setValue($product->getProductSize()->getSize());
            
            $sheet->getCell('F'.$c)
                ->setValue($product->getPostUnit()->getPostUnit());
            
            $c++;
        }
        
        $sheet->getStyle('A1:F1')
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $sheet->getStyle('A1:F1')
            ->getFont()
            ->setBold(true);
        
        $sheet->getStyle('D2:D'.$lastRowNumber)
            ->getNumberFormat()
            ->setFormatCode('£#,##0.00_-');
        
       $sheet->getStyle('F2:F'.$lastRowNumber)
            ->getNumberFormat()
            ->setFormatCode('0" gms"');

        foreach ($arrayData[0] as $column => $title) {
            $sheet->getColumnDimension($column)
                ->setAutoSize(true);
        }
        
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./data/'.$filename.$fileExtension);
        
        return $filename.$fileExtension;
    }

    public function createMonthlyTotals()
    {
        $this->setReportMemoryLimit();

        $totals = $this->getOrderService()
            ->getMonthlyTotals();

        $totals = Json::decode($totals);

        $objPHPExcel    = new \PHPExcel();
        $sheet          = $objPHPExcel->getActiveSheet();
        $column         = 1;

        foreach ($totals as $row) {
            $this->checkMemoryLimit();
            $sheet->setCellValueByColumnAndRow($column, 1, $row->label);

            $columnRow = 2;

            foreach ($row->data as $data) {
                $sheet->setCellValueByColumnAndRow(0, $columnRow, $data[0]);
                $sheet->setCellValueByColumnAndRow($column, $columnRow, $data[1]);
                $columnRow++;
            }

            $column++;
        }

        // footer totals

        $sheet->getCell('A1')->setValue('Year');

        $filename = 'monthly-totals.xlsx';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./data/' . $filename);

        return $filename;
    }

    /**
     * @return \Shop\Options\ShopOptions
     */
    public function getShopOptions()
    {
        $sl = $this->getServiceLocator();
        $service = $sl->get('Shop/Options/Shop');

        return $service;
    }
    
    /**
     * @return \Shop\Service\Product\Product
     */
    public function getProductService()
    {
        $sl = $this->getServiceLocator()
            ->get('UthandoServiceManager');
        $service = $sl->get('ShopProduct');
        
        return $service;
    }
    
    /**
     * @return \Shop\Service\Product\Category
     */
    public function getProductCategoryService()
    {
        $sl = $this->getServiceLocator()
        ->get('UthandoServiceManager');
        $service = $sl->get('ShopProductCategory');
    
        return $service;
    }

    /**
     * @return \Shop\Service\Order\Order
     */
    public function getOrderService()
    {
        $sl = $this->getServiceLocator()
            ->get('UthandoServiceManager');
        $service = $sl->get('ShopOrder');

        return $service;
    }
}
