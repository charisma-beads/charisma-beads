<?php
namespace Shop\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

ini_set('memory_limit', '512M');

class Report implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
    
    public function createProductList($post)
    {
        $objPHPExcel = new \PHPExcel();
        
        $arrayData = [
            ['Sku', 'Product Name', 'Category', 'Price', 'Size', 'Weight'],
        ];
        
        $objPHPExcel->getActiveSheet()
            ->fromArray($arrayData);
        
        $productService         = $this->getProductService();
        $productCategoryService = $this->getProductCategoryService();
        
        $productService->getMapper()
            ->setFetchEnabled(false)
            ->setFetchDisabled(true);
        
        $products               = $productService->search($post);
        $filename               = ($productCategoryService->getById($post['productCategoryId'])->getIdent()) ?: 'catelogue';
        $fileExtension          = '.xlsx';
        $lastRowNumber          = $products->count() + 1;
        $c                      = 2;
        $previousCategory       = '';
        
        /* @var $product \Shop\Model\Product\Product */
        foreach ($products as $key => $product) {
            
            $sheet = $objPHPExcel->getActiveSheet();
            
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
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:F1')
            ->getAlignment()
            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('A1:F1')
            ->getFont()
            ->setBold(true);
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('D2:D'.$lastRowNumber)
            ->getNumberFormat()
            ->setFormatCode('£#,##0.00_-');
        
        $objPHPExcel->getActiveSheet()
            ->getStyle('F2:F'.$lastRowNumber)
            ->getNumberFormat()
            ->setFormatCode('0" gms"');
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./data/'.$filename.$fileExtension);
        
        return $filename.$fileExtension;
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
}
