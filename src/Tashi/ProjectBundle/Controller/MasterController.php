<?php

namespace Tashi\ProjectBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\ProjectBundle\Helper\ProjectConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @Route(path="/category")
 */
class MasterController extends Controller {
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->erpMessage = new ERPMessage();
    }
    /**
     * Action: Goto to Add New Category Page
     * @Route ("/addarea", name="_gotoaddarea")
     */
    public function GotoAreaCategoryAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){      
            try{ 
                $em = $this->getDoctrine()->getManager();
                $areaArr= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                            (array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_ADD_AREA,array('areaArr'=>$areaArr)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage('Unexpected error was encountered.'.$ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    } 
    /**
     * Action: Add/Edit Project Area
     * @Route("/projectarea/{mode}", name="_manageprojectarea")
     * 
     */        
    public function ManageProjectAreaAction(Request $request,$mode)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){  
            $result=$this->get(ProjectConstant::SERVICE_MASTER)->InsertEditProjectArea($request,$mode);
            try {
                if ($result['code'] ==1) 
                {
                    $em = $this->getDoctrine()->getManager();
                    $areaArr= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                            (array('recordActiveFlag'=>1),array('area'=>'ASC'));

                    $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_AREA_LIST,array('areaArr'=>$areaArr)));
                    $this->erpMessage->setSuccess(true);
                } 
                else {
                    $this->erpMessage->setSuccess(false); 
                }
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Unexpected error was encountered.'.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata); 

    }
    /**
     * Action: Edit Area 
     * @Route ("/editarea/{areaid}", name="_gotoeditarea")
     */
    public function GotoProjectAreaAction($areaid)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){
        try 
        {
            $em = $this->getDoctrine()->getManager();
            $area= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($areaid); 
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_EDIT_AREA,array('area'=>$area)));
            $this->erpMessage->setSuccess(true);
        } 
        catch (\Exception $ex) 
        {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Delete Category Master(set recordActiveFlag=0
     * @Route ("/deletearea/{areaid}", name="_deletearea")
     */
    public function DeleteProjectAreaAction($areaid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();   
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){
            $result=$this->get(ProjectConstant::SERVICE_MASTER)->deleteArea($areaid);
            if($result['code']==1){ 
                $em=$this->getDoctrine()->getManager();
                $areaArr= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                            (array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_ADD_AREA,array('areaArr'=>$areaArr)));
                $this->erpMessage->setSuccess(true);
            }
            else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']); 
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
       
    }  
    /*********************************************/
    /*****************  INDUSTRY TYPE*************/
    /*********************************************/
    /**
     * @Route ("/addindustry", name="_addindustry")
     */
    public function GotoAddIndustryTypeAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();     

            try{
                $em=$this->getDoctrine()->getManager();
                $indusryArr=$em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('industryType'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_ADD_INDUSTR_TYPE,array('industryArr'=>$indusryArr)));
                $this->erpMessage->setSuccess(true);       

            }catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            }     
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);  

    }
    
    /**
     * Action: Add/Edit Industry Type Master
     * @Route("/manageindustrytype/{mode}", name="_manageindustrytype")
     * 
     */        
    public function ManageIndustryTypeAction(Request $request,$mode)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();   
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_MASTER)->InsertEditIndustryType($request,$mode);
        if ($result['code'] ==1) 
        {
            $em = $this->getDoctrine()->getManager();
            $indusryArr=$em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('industryType'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_INDUSTRY_LIST,array('industryArr'=>$indusryArr)));
            $this->erpMessage->setSuccess(true);
        } 
        else {
            $this->erpMessage->setSuccess(false); 
        }
        $this->erpMessage->setMessage($result['msg']);      
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    /**
     * Action: Edit Industry Type 
     * @Route ("/editindustry/{industryid}", name="_gotoeditindustry")
     */
    public function GotoEditIndustryAction($industryid)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){
        try 
        {
            $em = $this->getDoctrine()->getManager();
            $industry= $em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->find($industryid); 
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_EDIT_INDUSTRY,array('industry'=>$industry)));
            $this->erpMessage->setSuccess(true);
        } 
        catch (\Exception $ex) 
        {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * Action: Delete Industry Type(set recordActiveFlag=0
     * @Route ("/deleteindustry/{industryid}", name="_deleteindustry")
     */
    public function DeleteIndustryAction($industryid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ProjectMasterSetting');
	if($accessRight==1){
        $result=$this->get(ProjectConstant::SERVICE_MASTER)->deleteIndustry($industryid);
        if($result['code']==1){ 
            $em=$this->getDoctrine()->getManager();
            $indusryArr=$em->getRepository(CommonConstant::ENT_INDUSTRY_TYPE_MASTER)->findBy(array('recordActiveFlag'=>1),array('industryType'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(ProjectConstant::TWIG_ADD_INDUSTR_TYPE,array('industryArr'=>$indusryArr)));
            $this->erpMessage->setSuccess(true);
        }
        else{
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $this->erpMessage->setMessage($result['msg']);        
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);       
    } 
}
