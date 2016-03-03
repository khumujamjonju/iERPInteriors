<?php
namespace Tashi\SystemSettingBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\SystemSettingBundle\Helper\SystemSettingConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route("/setting")
 */
class SystemSettingController extends Controller{
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route ("/settingdashboard", name="_settingdashboard")
     */
    public function settingDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('InsertActivityAction');
        if($accessRight==true){
            try{    
                $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_SETTING_DASHBOARD));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/moduleindex", name="_moduleindex")
     */
    public function GotoModuleIndexAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_MODULE_ADD,array('moduleArr'=>$moduleArr)));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        
    }
    /**
     * @Route ("/insertmodule", name="_insertmodule")
     */
    public function InsertModuleAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('InsertModuleAction');
        if($accessRight==true){
            $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->insertModule($request);
            if($result['code']==1){
                try{
                    $em=$this->getDoctrine()->getManager();
                    $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
                    $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_MODULE_ADD,array('moduleArr'=>$moduleArr)));
                    $this->erpMessage->setSuccess(true);
                }
                catch (\Exception $ex) {
                        $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                        $this->erpMessage->setSuccess(false);
                }
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/editmodulepage/{moduleid}", name="_gotoeditmodule")
     */
    public function GotoEditModuleAction($moduleid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('GotoEditModuleAction');
        if($accessRight==true){
            try{
                $em=$this->getDoctrine()->getManager();
                $module=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->find($moduleid);
                $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_MODULE_EDIT,array('module'=>$module)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/updatemodule", name="_updatemodule")
     */
    public function UpdateModuleAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->updateModule($request);
        if($result['code']==1){
            try{
                $em=$this->getDoctrine()->getManager();
                $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_MODULE_LIST,array('moduleArr'=>$moduleArr)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setSuccess(false);
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/deletemodule/{moduleid}", name="_deletemodule")
     */
    public function DeleteModuleAction($moduleid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('UpdateModuleAction');
        if($accessRight==true){
            $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->deleteModule($moduleid);
            if($result['code']==1){
                try{
                    $em=$this->getDoctrine()->getManager();
                    $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
                    $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_MODULE_ADD,array('moduleArr'=>$moduleArr)));
                    $this->erpMessage->setSuccess(true);
                }
                catch (\Exception $ex) {
                        $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                        $this->erpMessage->setSuccess(false);
                }
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);   
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    ////////////////////////////////////////////////////
    ////////////////        ACTIVITY      //////////////
    ////////////////////////////////////////////////////
    /**
     * @Route ("/addactivity", name="_addactivity")
     */
    public function GotoAddActivityAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        try{
            $em=$this->getDoctrine()->getManager();
            $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
            $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->GetAllActiveActivity();
            //$activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('recordActiveFlag'=>1),array('activityName'=>'ASC'));  
            $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_ADD,
                    array('moduleArr'=>$moduleArr,'activityArr'=>$activityArr)));
            $this->erpMessage->setSuccess(true);
//        }
//        catch (\Exception $ex) {
//                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setSuccess(false);
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);         
    }    
    /**
     * @Route ("/insertactivity", name="_insertactivity")
     */
    public function InsertActivityAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('InsertActivityAction');
        if($accessRight==true){
            $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->insertActivity($request);
            if($result['code']==1){
                try{
                    $dataUI=  json_decode($request->getContent());
                    $moduleid=isset($dataUI->selModule)?explode('&',$dataUI->selModule)[1]:'';
                    $em=$this->getDoctrine()->getManager();
                    //$moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
                    //$activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->GetAllActiveActivity();
                    $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('moduleFk'=>$moduleid,'recordActiveFlag'=>1));
                    $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_LIST,
                                                array('activityArr'=>$activityArr)));
                    $this->erpMessage->setSuccess(true);
                }
                catch(\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
                }
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/editactivitypage/{activityid}", name="_gotoeditactivity")
     */
    public function GotoEditActivityAction($activityid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();
            $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
            $activity=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->find($activityid);
            $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_EDIT,array('moduleArr'=>$moduleArr,'activity'=>$activity)));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * @Route ("/updateactivity", name="_updateactivity")
     */
    public function UpdateActivityAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('UpdateActivityAction');
        if($accessRight==true){
            $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->updateActivity($request);
            if($result['code']==1){
                try{
                    $dataUI=  json_decode($request->getContent());
                    $moduleid=isset($dataUI->selModule)?explode('&',$dataUI->selModule)[1]:'';
                    $em=$this->getDoctrine()->getManager();                    
                    $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('moduleFk'=>$moduleid,'recordActiveFlag'=>1));
                    //$activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->GetAllActiveActivity();
                    $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_LIST,
                                                array('activityArr'=>$activityArr)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setMessage($result['msg']);
                }
                catch (\Exception $ex) {
                        $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                        $this->erpMessage->setSuccess(false);
                }
            }else{
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(false);
            }
            
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/deleteactivity/{activityid}", name="_deleteactivity")
     */
    public function DeleteActivityAction($activityid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DeleteActivityAction');
        if($accessRight==true){
            $result=$this->get(SystemSettingConstant::SERVICE_SYSTEMSETTING)->deleteActivity($activityid);
            if($result['code']==1){
                try{
                    $em=$this->getDoctrine()->getManager();
                    $moduleArr=$em->getRepository(CommonConstant::ENT_MODULE_MASTER)->findBy(array('recordActiveFlag'=>1),array('moduleName'=>'ASC'));
                    $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->GetAllActiveActivity();            
                    $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_ADD,
                    array('moduleArr'=>$moduleArr,'activityArr'=>$activityArr)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setMessage($result['msg']);
                }
                catch (\Exception $ex) {
                        $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                        $this->erpMessage->setSuccess(false);
                }
            }else{
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(false);
            }            
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);   
        }else{
            $this->render(CommonConstant::TWIG_AUTH_ACCESS_DENIED);
        }
    }
    /**
     * @Route ("/loadactivity/{moduleid}", name="_loadactivity")
     */
    public function LoadActivityByModuleAction($moduleid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em=$this->getDoctrine()->getManager();    
            if($moduleid=='0'){
                $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('recordActiveFlag'=>1));
            }else{
                $activityArr=$em->getRepository(CommonConstant::ENT_ACTIVITY_MASTER)->findBy(array('moduleFk'=>$moduleid,'recordActiveFlag'=>1));
            }
            $this->erpMessage->setHtml($this->renderView(SystemSettingConstant::TWIG_ACTIVITY_LIST,
                                        array('activityArr'=>$activityArr)));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
}
