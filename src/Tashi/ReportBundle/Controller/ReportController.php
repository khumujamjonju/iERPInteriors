<?php
namespace Tashi\ReportBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Tashi\ReportBundle\Helper\ReportConstant;

class ReportController extends Controller
{
   /**
     * @Route ("/report/master_dashboard", name="_report_master_dashboard")
     */
    public function reportDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
       $erpMessage = new ERPMessage();
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $erpMessage->setHtml($this->renderView(ReportConstant::TWIG_REP_DASHBOARD ));
             $erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $erpMessage->setMessage($ex->getMessage());
                $erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
    /**
     * @Route ("/report/report_master_stock", name="_report_master_stock")
     */
    public function reportMasterStockAction()
    {
       $erpMessage = new ERPMessage();
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $erpMessage->setHtml($this->renderView(ReportConstant::TWIG_REP_MASTER_STOCK));
             $erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $erpMessage->setMessage($ex->getMessage());
                $erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
    /**
     * @Route ("/report/report_master_account", name="_report_master_account")
     */
    public function reportMasterAccountAction()
    {
       $erpMessage = new ERPMessage();
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $erpMessage->setHtml($this->renderView(ReportConstant::TWIG_REP_MASTER_ACCOUNT));
             $erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $erpMessage->setMessage($ex->getMessage());
                $erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
    /**
     * @Route ("/report/report_master_purchase", name="_report_master_purchase")
     */
    public function reportMasterPurchaseAction()
    {
       $erpMessage = new ERPMessage();
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $erpMessage->setHtml($this->renderView(ReportConstant::TWIG_REP_MASTER_PURCHASE));
             $erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $erpMessage->setMessage($ex->getMessage());
                $erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
    /**
     * @Route ("/report/report_master_project", name="_report_master_project")
     */
    public function reportMasterProjectAction()
    {
       $erpMessage = new ERPMessage();
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $erpMessage->setHtml($this->renderView(ReportConstant::TWIG_REP_MASTER_PROJECT));
             $erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $erpMessage->setMessage($ex->getMessage());
                $erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
}


