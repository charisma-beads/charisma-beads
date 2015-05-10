<?php
namespace Shop\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use UthandoCommon\Controller\ServiceTrait;

/**
 * Class Report
 *
 * @package Shop\Controller
 */
class Report extends AbstractActionController
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
        /* @var $service \Shop\Service\Report */
        $service = $this->getService('Shop\Service\Report');
        
        $post = $this->params()->fromPost();

        $jsonModel = new JsonModel();

        try {
            $report = $service->createProductList($post);
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
        
        if (file_exists('./data/'. $file)) {
            $response = $this->getResponse();
            
            $response->getHeaders()->addHeaders([
                'Content-Type'          => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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
