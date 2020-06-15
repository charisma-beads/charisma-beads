<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Controller
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2014 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE.txt
 */

namespace Shop\Controller;

use Shop\Service\ReportService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Common\Service\ServiceTrait;

/**
 * Class Report
 *
 * @package Shop\Controller
 */
class ReportController extends AbstractActionController
{
    use ServiceTrait;
    
    public function indexAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        
        return $viewModel;
    }
    
    public function productListAction()
    {
        $post = $this->params()->fromPost();
        
        return $this->getReport('productList', $post);
    }

    public function monthlyTotalsAction()
    {
        return $this->getReport('monthlyTotals');

    }

    public function getReport($report, $params = null)
    {
        /* @var $service ReportService */
        $service = $this->getService(ReportService::class);

        $jsonModel = new JsonModel();

        try {
            $report = $service->create($report, $params);
        } catch (\Exception $e) {
            return $jsonModel->setVariables([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        $fileLink = $this->url()->fromRoute('admin/shop/report', [
            'action'    => 'download-report',
            'file'      => $report,
        ]);

        $jsonModel->setVariables([
            'url' => $fileLink,
            'report' => $report,
            'status' => 'success',
        ]);

        return $jsonModel;
    }
    
    public function downloadReportAction()
    {
        $file = $this->params()->fromRoute('file', null);

        $contentTypes = [
            'csv'   => 'text/csv',
            'html'  => 'text/html',
            'ods'   => 'application/vnd.oasis.opendocument.spreadsheet',
            'pdf'   => 'application/pdf',
            'xls'   => 'application/vnd.ms-excel',
            'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        
        if (file_exists('./data/'. $file)) {
            $response = $this->getResponse();
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            $response->getHeaders()->addHeaders([
                'Content-Type'          => $contentTypes[$ext],
                'Content-Disposition'   => 'attachment;filename="' . $file .'"',
                'Cache-Control'         => 'max-age=0',
                'Cache-Control'         => 'max-age=1',
                'Expires'               => 'Mon, 26 Jul 1997 05:00:00 GMT',
                'Last-Modified'         => gmdate('D, d M Y H:i:s') . ' GMT',
                'Cache-Control'         => 'cache, must-revalidate',
                'Pragma'                => 'public',
            ]);
            
            $response->setStatusCode(200);
            $response->setContent(file_get_contents('./data/' . $file));
            
            return $response;
        }
        
        return [
            'file' => $file,
        ];
    }
}
