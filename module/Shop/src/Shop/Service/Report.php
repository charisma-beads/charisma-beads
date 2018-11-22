<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Service
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Service;

use UthandoCommon\Service\ServiceManager;
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

    /**
     * @var array
     */
    public static $writerTypeMap = [
        'csv'   => 'CSV',
        'html'  => 'HTML',
        'ods'   => 'OpenDocument',
        'pdf'   => 'PDF',
        'xls'   => 'Excel5',
        'xlsx'  => 'Excel2007',
    ];

    /**
     * Set the PHP memory limit
     */
    public function setReportMemoryLimit()
    {
        $memoryLimit = $this->getReportsOptions()
            ->getMemoryLimit();

        if ($memoryLimit) {
            ini_set('memory_limit', $memoryLimit);
        }
    }

    /**
     * Checks if we are running out of memory
     *
     * @throws \Exception
     */
    public function checkMemoryLimit()
    {
        if((str_replace('M','',ini_get('memory_limit'))*1048576) - memory_get_usage() < 1048576*16){ // 16 MB headroom
            throw new \Exception('Almost out of memory, ' . (memory_get_usage(true) / 1024 / 1024) . ' MB used.
                    Try increasing the "reports memory limit" in the shop settings.
                    Current limit is: ' . ini_get('memory_limit') . '.' );
        }
    }

    /**
     * @param $report
     * @param null|array $params
     * @return mixed
     */
    public function create($report, $params = null)
    {
        $reportMethod = 'create' . ucfirst($report);

        if ($params) {
            $report = $this->$reportMethod($params);
        } else {
            $report = $this->$reportMethod();
        }

        return $report;
    }

    /**
     * Create a product report
     *
     * @param array $post
     * @return string
     * @throws \Exception
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function createProductList(array $post)
    {
        $this->setReportMemoryLimit();

        $options    = $this->getReportsOptions();
        $writerExt  = $options->getWriterType();
        $writerType = self::$writerTypeMap[$writerExt];

        $objPHPExcel = new \PHPExcel();
        
        $arrayData = [
            ['A' => 'Sku', 'B' => 'Product Name', 'C' => 'Category', 'D' => 'Price', 'E' => 'Size', 'F' => 'Weight'],
        ];
        
        $productService         = $this->getProductService();
        $productCategoryService = $this->getProductCategoryService();
        
        $products               = $productService->search($post);
        $filename               = ($productCategoryService->getById($post['productCategoryId'])->getIdent()) ?: 'all-products';
        $fileExtension          = '.' . $writerExt;
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

                /* @var $category \Shop\Model\Product\Category */
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

        if ($writerExt == 'pdf') {
            \PHPExcel_Settings::setPdfRenderer(
                \PHPExcel_Settings::PDF_RENDERER_DOMPDF,
                './vendor/dompdf/dompdf'
            );

            $sheet->setShowGridLines(false);
            $sheet->getPageSetup()
                ->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        }
        
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $writerType);
        $objWriter->save('./data/'.$filename.$fileExtension);
        
        return $filename.$fileExtension;
    }

    /**
     * Create a report on monthly sales totals
     *
     * @return string
     * @throws \Exception
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function createMonthlyTotals()
    {
        $this->setReportMemoryLimit();

        $options = $this->getReportsOptions();

        $totals = $this->getOrderService()
            ->getMonthlyTotals(null, null, $options->getMonthFormat());

        $totals = Json::decode($totals);

        $objPHPExcel        = new \PHPExcel();
        $sheet              = $objPHPExcel->getActiveSheet();
        $column             = 1;
        $previousColumnRef  = null;

        $sheet->getCell('A1')->setValue('Year');
        $sheet->getCell('A16')->setValue('Total');
        $sheet->getCell('A17')->setValue('Inc %');

        foreach ($totals as $row) {
            $this->checkMemoryLimit();
            $sheet->setCellValueByColumnAndRow($column, 1, $row->label);

            $columnRow = 1;

            foreach ($row->data as $data) {
                $columnRow++;
                $sheet->setCellValueByColumnAndRow(0, $columnRow, $data[0]);
                $dataCell = $sheet->getCellByColumnAndRow($column, $columnRow);
                $dataCell->setValue($data[1]);
            }

            // column totals
            $totalCell  = $sheet->getCellByColumnAndRow($column, 16);
            $incCell    = $sheet->getCellByColumnAndRow($column, 17);
            $columnRef  = $totalCell->getColumn();

            $totalCell->setValue('=SUM(' . $columnRef . '2:' . $columnRef . '13)');

            if ($columnRef == 'B') {
                $incCell->setValue('=B16');
            } else {
                $incCell->setValue('=((' . $columnRef . '16-' . $previousColumnRef . '16)/' . $previousColumnRef .'16)*100');
            }

            $previousColumnRef = $columnRef;
            $column++;
        }

        // row increase percentage
        $totalColumns      = count($totals);
        $incCol            = $totalColumns + 1;
        $lastColumnData    = end($totals);
        $rowCount          = 1;

        $sheet->setCellValueByColumnAndRow($incCol, $rowCount, 'Inc %');

        for($i=1;$i <= count($lastColumnData->data); $i++) {
            $rowCount++;

            $newCell    = $sheet->getCellByColumnAndRow($totalColumns, $rowCount)->getCoordinate();
            $prevCell   = $sheet->getCellByColumnAndRow($totalColumns - 1, $rowCount)->getCoordinate();
            $incCell    = $sheet->getCellByColumnAndRow($incCol, $rowCount);

            $incCell->setValue(
                '=((' . $newCell . '-' . $prevCell . ')/' . $prevCell . ')*100'
            );
        }

        // format numbers
        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle('B2:' . $lastColumn . '17')
            ->getNumberFormat()
            ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);

        foreach($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())
                ->setAutoSize(true);
        }

        $writerExt  = $options->getWriterType();
        $writerType = self::$writerTypeMap[$writerExt];
        $filename   = 'monthly-totals.' . $writerExt;

        if ($writerExt == 'pdf') {
            \PHPExcel_Settings::setPdfRenderer(
                \PHPExcel_Settings::PDF_RENDERER_DOMPDF,
                './vendor/dompdf/dompdf'
            );

            $sheet->setShowGridLines(false);
            $sheet->getPageSetup()
                ->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $writerType);

        $objWriter->save('./data/' . $filename);

        return $filename;
    }

    /**
     * @return \Shop\Options\ReportsOptions
     */
    public function getReportsOptions()
    {
        $sl = $this->getServiceLocator();
        $service = $sl->get('Shop/Options/Reports');

        return $service;
    }
    
    /**
     * @return \Shop\Service\Product\Product
     */
    public function getProductService()
    {
        $sl = $this->getServiceLocator()
            ->get(ServiceManager::class);
        $service = $sl->get('ShopProduct');
        
        return $service;
    }
    
    /**
     * @return \Shop\Service\Product\Category
     */
    public function getProductCategoryService()
    {
        $sl = $this->getServiceLocator()
        ->get(ServiceManager::class);
        $service = $sl->get('ShopProductCategory');
    
        return $service;
    }

    /**
     * @return \Shop\Service\Order\Order
     */
    public function getOrderService()
    {
        $sl = $this->getServiceLocator()
            ->get(ServiceManager::class);
        $service = $sl->get('ShopOrder');

        return $service;
    }
}
