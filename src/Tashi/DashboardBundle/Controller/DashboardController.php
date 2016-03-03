<?php

namespace Tashi\DashboardBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Tashi\DashboardBundle\Helper\DashboardConstant;

class DashboardController extends Controller{
    /**
     * @Route ("/dashboard/dashboard_onclick", name="_dashboard_onclick")
     */
    public function reportDashboardAction()
    {       
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $erpMessage = new ERPMessage();
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                   
            $erpMessage->setHtml($this->renderView(DashboardConstant::TWIG_DASHBOARD_ONCLICK));
            $erpMessage->setSuccess(true);
        }catch (\Exception $ex) {
            $erpMessage->setMessage($ex->getMessage());
            $erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($erpMessage, 'json');
        return new Response($jsondata);     
    } 
}


