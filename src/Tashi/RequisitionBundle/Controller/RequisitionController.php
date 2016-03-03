<?php
namespace Tashi\RequisitionBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // symfony annotation route for defining the module
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\RequisitionBundle\Helper\RequisitionConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Entity\EmpEmployeeMaster;
use Tashi\PurchaseBundle\Helper\PurchaseConstant;


class RequisitionController extends Controller
{
    private $em;
    private $erpMessage;
    
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
       // $this->CustomerMessage = new CustomerMessage();
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage=new ERPMessage();
    }
    
    /**
     * @Route ("/requisition/masterdashboard", name="_requisitiondashboard")
    */
    public function requisitionDashboardAction()
    { 
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateRequisition');
	if($accessRight==1){
            try{                   
                 $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_REQUISITION_DASHBOARD));
                 $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }                
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }
    
    /**
     * @Route ("/requisition/createRequisition", name="_createRequisition")
    */
    public function createRequitionAction()
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try
         {   
             $result=$this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpEmployeeMaster');
             $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_CREATE_REQUISITION,array('emp'=>$result)));
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
      * Action: for viewing details for create requisition order
      * Use Twig file: views\requisition\createOrder.html
     * @Route ("/requisition/requisition_order ", name="_requisition_order")
     */
    public function ViewRequisitionOrderAction(Request $request)
    {
           
           $em=$this->getDoctrine()->getManager();      
           try
           {
                
             //$dataUI = json_decode($request->getContent());
             $empid = $this->getRequest()->getSession()->get('EMPID');
             
             $area= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                        (array('recordActiveFlag'=>1),array('area'=>'ASC'));
            //$emp=$this->em->getRepository(RequisitionConstant::ENT_EMP)->find($empid);
            $emp= $em->getRepository(RequisitionConstant::ENT_EMP)->findOneByEmployeeId($empid);
            $POStatus=$this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findAll();
           //$transporter=$this->em->getRepository(PurchaseConstant::ENT_Transporter)->findAll();
          // $transmode=$this->em->getRepository(PurchaseConstant::ENT_MODE)->findAll();
           //$POStatus=$this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findAll();
          // $Payment=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->findAll();
          // $Employeelist=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchEMmployee();
           $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_CREATE_ORDER,array('area'=>$area,'emp'=>$emp,'status'=>$POStatus)));
           $this->erpMessage->setSuccess(true);
           }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
         }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);    
  }
    
    
  
    /**
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/orderappendprdsubcat/{pkid}", name="_orderappendprdsubcat")
     */
    public function AppendSubCatAction($pkid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();  
            
            $ProjectAreaObj=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($pkid);//Single parent category
            
            $projectAreaCategoryTxnObj=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findByProjectAreaFk($pkid);//Single parent category
            
            
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy
            (array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$pkid),array('productName'=>'ASC'));

            if($projectAreaCategoryTxnObj){
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_APPEND_SUB_CATEGORY,
                                    array('catMaster'=>$projectAreaCategoryTxnObj,'obj'=>$ProjectAreaObj)));                            
            }       
//            $this->erpMessage->setSecondHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCTS,
//                                    array('productArr'=>$projectAreaCategoryTxnObj)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    /**
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/reqappendproduct/{catid}", name="_reqappendproduct")
     */
    public function AppendProductsAction($catid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();  
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                    array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$catid),array('productName'=>'ASC'));
            
//            echo $CatProduct[0]->getProductCategory()->getPkid();
//            die();
            $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_APPEND_PRODUCTS,
                                    array('productArr'=>$CatProduct)));    

            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    
    
    
    /**
     * Action: 
     * @Route ("/requisition/selectedappend", name="_selectedappend")
     */
    public function SelectedproductaddingAction(Request $request)
    {
       
      
        $em=$this->getDoctrine()->getManager();      
        
        $dataUI = json_decode($request->getContent());
        $poid=$dataUI->prid;
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $ProObj=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findOneByproductCode($poid);
        $pro_pkid=$ProObj->getPkid();
        
        $Pro_id_Obj = $em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findOneByProduct($pro_pkid);
        $Pro_Unit_Obj = $em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findByProductFk($pro_pkid);
        $ProJect_Obj = $em->getRepository(RequisitionConstant::ENT_REQ)->findBy(array('recordActiveFlag'=>1));
        
        try
        {  
             $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_SELECTEDPRODUCT ,
             array('prod'=>$ProObj,'price'=>$Pro_id_Obj,'unit'=>$Pro_Unit_Obj,'project'=>$ProJect_Obj)));
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
      * 
      * @Route ("/requisition/search_requisition", name="_search_requisition")
    */
    public function SearchPurchasedProductAction()
    {  
       $em = $this->getDoctrine()->getManager();  
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  
             $result = $em->getRepository(RequisitionConstant::ENT_REQSTATUS)->findAll();
             $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_REQUISITION,array('status'=>$result)));
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
     * Action: Search Requisition
     * @Route ("/requisition/searchrequisition", name="_searchrequisition")
     */
    public function SearchRequisitionAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchRequisition');
	if($accessRight==1){
            $dataUI=json_decode($request->getContent());
            $criteria=$dataUI->selSearchRequisition;
            try{            

                switch($criteria)
                {
                    case 'all':
                    $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchAllRequisiton();
                    break;

                    case 'requisition':
                    $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchByRequisitionDate($request);
                    break;

                    case 'status':
                    $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchResultByStatus($request);
                    break;
                }
                if(empty($reqArr['allresult'])){
                   $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Matching Record Found!!!');
                }else{
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_VIEW_REQORDER,array('reqArr'=>$reqArr)));
                    $this->erpMessage->setMessage($reqArr['msg']);
                }
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /** 
      * Action: for purchase approve tab
      *
     * @Route ("/requisition/approve", name="_approve")
     */
    public function PurchaseApproveAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  
             $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->getRequisitionforApproval($request);   
             $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_cancel_approve_edit,array('details'=>$result)));
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
      * Action: 
      * 
     * @Route ("/requisition/loadApproveRequisition", name="_loadApproveRequisition")
     */
    public function LoadRequisitionApproveEditAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('RequisitionApproval');
	if($accessRight==1){
            try{  
                 //$em=$this->getDoctrine()->getManager(); 
                 $dataUI = json_decode($request->getContent());
                 $POCode = $dataUI->rid;
                 $Req_id=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($POCode);
                 $productpk=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findByRequisitionFk($POCode);
                 $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_Requisition_cancel_approve,
                 array('prod'=>$productpk,'req'=>$Req_id)));
                 $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                   $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                   $this->erpMessage->setSuccess(false);
            }
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /** 
      * Action: 
      * 
     * @Route ("/requisition/loadRequisitionview", name="_loadRequisitionview")
     */
    public function LoadRequsitionViewDetailsAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('loadRequisitionview');
	//if($accessRight==1){
            try{  
                 $dataUI = json_decode($request->getContent());
                 $POCode = $dataUI->rid;
                 //echo $POCode;die();
                 $Req_id=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($POCode);
                 $productpk=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findByRequisitionFk($POCode);
                 $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_VIEW_REQUISITION,
                 array('prod'=>$productpk,'req'=>$Req_id)));
                 $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                   $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                   $this->erpMessage->setSuccess(false);
            }
//        }
//        else{
//            $this->erpMessage->setJsonData('AD');
//            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    
    
    
    /** 
      * Action: for purchase product tab
      * Use Twig file: views\Requisition\Edit.html 
     * @Route ("/requisition/updaterequisitionapprove", name="_updaterequisitionapprove")
     */
    public function UpdateRequisitionApproveEditAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditRequisition');
	if($accessRight==1){
            try{                
                $dataUI = json_decode($request->getContent());
                $reqid = $dataUI->rid;
                $Req_id=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($reqid);


                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->getRequisitionProductUnit($request); 
                $area= $this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                            (array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $ProJect_Obj = $this->em->getRepository(RequisitionConstant::ENT_REQ)->findBy(array('recordActiveFlag'=>1));
               // $all= $this->get(PurchaseConstant::SERVICE_PURCHASE)->getAllDetails($POCode); 


               $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_EDITREQUISITION,array('area'=>$area,'ro'=>$Req_id,'all'=>$result,'project'=>$ProJect_Obj)));
               $this->erpMessage->setSuccess(true);
               //$this->erpMessage->setJsonData($all);

            }
            catch (\Exception $ex) {
                   $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION.$ex->getMessage());
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
     * @Route ("/requisition/add_requisition", name="_add_requisition")
   */
   public function RequisitionDetailsAction(Request $request)
    {   
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateRequisition');
	if($accessRight==1){
            try{         
                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->AddRequisitondetails($request);   
                
                if($result['code']==0)
                {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                }else
                {   //for showing new form
                    $empid = $this->getRequest()->getSession()->get('EMPID');
                    $area= $this->em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
                    $emp= $this->em->getRepository(RequisitionConstant::ENT_EMP)->findOneByEmployeeId($empid);
                    $POStatus=$this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findAll();
                    $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_CREATE_ORDERNEWFORM,array('area'=>$area,'emp'=>$emp,'status'=>$POStatus)));
                    //section for new form ends here
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                }

                $this->erpMessage->setMessage($result['msg']);
             }
             catch (\Exception $ex) {
                    $this->erpMessage->setMessage($ex->getMessage());
                    //$this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
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
     * @Route ("/requisition/update_reqdetails", name="_update_reqdetails")
   */
   public function RequisitionUpdateDetailsAction(Request $request)
    {     
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditRequisition');
	if($accessRight==1){
            try{  

                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->updateRequisitionDetails($request);   
                if($result['code']==0)
                {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                }else
                {
                    $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchAllRequisiton();
                    $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_VIEW_REQORDER,array('reqArr'=>$reqArr)));
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                }
                $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($ex->getMessage());
                    //$this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                    $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
    
   //approve requisition details
    
     /**
     * @Route ("/requisition/apprv_requisitiondetails", name="_apprv_requisitiondetails")
   */
    public function ApproveRequisitionDetailsAction(Request $request)
    {  
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('RequisitionApproval');
	if($accessRight==1){
            try{  

                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->ApproveRequisitionDetails($request);   
                
                $result1 = $this->get(RequisitionConstant::SERVICE_REQUISITION)->getRequisitionforApproval($request);   
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_APPROVE_VIEW,array('details'=>$result1)));
                $this->erpMessage->setJsonData($result1);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
                    $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
      * Action: for requisition product tab
      * Use Twig file: views\requisition\purApprove.html 
     * @Route ("/requisition/cancel", name="_cancel")
     */
    public function CancelRequisitionApproveEditAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CancelRequisition');
	if($accessRight==1){
            try{         
                $dataUI = json_decode($request->getContent());
                $reqid = $dataUI->rid;
                $Req_id=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->find($reqid);

                //$Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->find($POCode);
                $productpk=$this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findByRequisitionFk($Req_id); 

                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_Requisition_cancel_approve,
                        array('prod'=>$productpk,'req'=>$Req_id)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    
     //approve po details
    /**
     * @Route ("/requisition/cancelreqdetails", name="_cancelreqdetails")
   */
    public function CancelRequisitionDetailsAction(Request $request)
    {      
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CancelRequisition');
	if($accessRight==1){
            try{      
                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->CancelRequisitionDetails($request);    
                $this->erpMessage->setJsonData($result);
                $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchAllRequisiton();
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_VIEW_REQORDER,array('reqArr'=>$reqArr)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
      * Action: for requisition product tab
      * Use Twig file: views\requisition\dispatch.html 
     * @Route ("/requisition/dispatchrequisition", name="_dispatchrequisition")
     */
    public function StockUpdateForRequisitionAction(Request $request)
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DispatchRequisition');
//	if($accessRight==1){
            try{  
                $em=$this->getDoctrine()->getManager();    
                $dataUI = json_decode($request->getContent());
                $reqid = $dataUI->rid;

                $result=$this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpEmployeeMaster');
                $req_pro = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION_PRODUCT)->findByRequisitionFk($reqid);

                $requisition = $this->get(RequisitionConstant::SERVICE_REQUISITION)->getstockresult($reqid);
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_DISPATCH,array('emp'=>$result,
                    'requisition'=>$req_pro,'details'=>$requisition)));
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
//        }else{
//            $this->erpMessage->setJsonData('AD');
//            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    } 
    
    
    
                
    /**
     * @Route ("/requisition/dispatch_stock/{rid}", name="_dispatch_stock")
   */
    public function DispatchStockRequisitionDetailsAction(Request $request,$rid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('DispatchRequisition');
	if($accessRight==1){
            try{  

                 $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->DispatchStockRequisitionDetails($rid,$request);   

                 $this->erpMessage->setJsonData($result);
                 $this->erpMessage->setSuccess(true);
                 $this->erpMessage->setMessage($result['msg']);
              }
              catch (\Exception $ex) {
                     $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
      *
      * @Route ("/requisition/returnstock", name="_returnstock")
     */
    public function StockReturnAction()
    {       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ReturnItem');
        if($accessRight==1){
            try{  
                  $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_STOCKRETURN));
                  $this->erpMessage->setSuccess(true);
               }
              catch (\Exception $ex) {
                     $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                     $this->erpMessage->setSuccess(false);
              }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    //approve requisition details
    
     /**
     * @Route ("/requisition/serachbyReqNo", name="_serachbyReqNo")
   */
   public function SearchByReqNoDetailsAction(Request $request)
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  
            $dataUI = json_decode($request->getContent());
            $reqno = $dataUI->requisition_no;
            $purpose = $this->em->getRepository(RequisitionConstant::ENT_STOCKRETURNPURPOSE)->findBy(array('recordActiveFlag'=>1));    
            $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchRequisitionbyReqNo($reqno); 
            
            $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_SHOWPRODUCT,array('req'=>$result,'purpose'=>$purpose)));
            $this->erpMessage->setJsonData($result);
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
     * @Route ("/requisition/return_stock/{sid}", name="_return_stock")
   */
   public function ReturnStockQuantityDetailsAction(Request $request,$sid)
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ReturnItem');
        if($accessRight==1){
       try{  
            $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->StockReturnQuantityDetails($sid,$request);  
            if($result['code']==0)
            {
                 $this->erpMessage->setJsonData($result);
                 $this->erpMessage->setSuccess(false);
            }else
            {    $this->erpMessage->setJsonData($result);
                 $this->erpMessage->setSuccess(true);
            }
            $this->erpMessage->setMessage($result['msg']);
            
            
         }
         catch (\Exception $ex) {
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
     * @Route ("/requisition/viewhistory/{sid}", name="_viewhistory")
   */
   public function ViewReturnStockQuantityDetailsAction($sid)
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  
            $result = $this->em->getRepository(RequisitionConstant::ENT_STOCKRETURN)->findBy(array('reqProFk'=>$sid));
            $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_VIEW_HISTORY,array('req'=>$result)));
            $this->erpMessage->setJsonData($result);
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
     * @Route ("/requisition/master_setting", name="_requisition_master_setting")
     */
    public function RequisitionMasterSettingdAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(RequisitionConstant::SERVICE_REQUISITION)->displayAllResult('StockReturnPurpose');
            $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_REQUISITION_TRANSPORT, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/employee/add_update_emp_requisition_transport", name="_add_update_emp_requisition_transport")
     */
    public function addUpdateEmpJobTitleAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('StockReturnPurpose');
	if($accessRight==1){
            try {
                $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->addUpdateTransport($request);
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_DISPLAY_REQUISITION_TRANSPORT, array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/requisition/retrieve_transport/{transportorId}", name="_retrieve_transport")
     */
    public function retrieveTransportAction($transportorId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('StockReturnPurpose');
	if($accessRight==1){
        try {
            $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->retrieveTransport($transportorId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route ("/requisition/delete_transprotor/{transportorId}", name="_delete_transportor")
     * 
     */
    public function deleteTransportorAction($transportorId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('StockReturnPurpose');
	if($accessRight==1){
        try {
            $result = $this->get(RequisitionConstant::SERVICE_REQUISITION)->deleteTransportorMaster($transportorId);
            $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_DISPLAY_REQUISITION_TRANSPORT, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * Action: View My Requisition
     * @Route ("/requisition/myrequisition", name="_myrequisition")
     */
    public function MyRequisitionAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        //=json_decode($request->getContent());
        //$criteria=$dataUI->selSearchRequisition;
        try{           
            $session=$this->getRequest()->getSession();
            $empid=$session->get('EMPID');         
//            switch($criteria)
//            {
//                case 'all':
//                $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchAllRequisiton();
//                break;
//                
//                case 'requisition':
//                $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchByRequisitionDate($request);
//                break;
//                
//                case 'status':
//                $reqArr=$this->get(RequisitionConstant::SERVICE_REQUISITION)->SearchResultByStatus($request);
//                break;
//            }
            $reqArr = $this->em->getRepository(RequisitionConstant::ENT_REQUISITION)->findBy(array( 'applicationUserId' => $empid, 'recordActiveFlag' => 1)); 
            if(!$reqArr){
               $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Requisition Record Found!!!');
            }else{
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(RequisitionConstant::TWIG_MY_REQUISITION,array('reqArr'=>$reqArr)));
                //$this->erpMessage->setMessage($reqArr['msg']);
            }
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage('Could not process you request at the moment. Please try later. Error: '.$ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

}