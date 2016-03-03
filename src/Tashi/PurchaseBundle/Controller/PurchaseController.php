<?php


namespace Tashi\PurchaseBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // symfony annotation route for defining the module
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\PurchaseBundle\Helper\PurchaseConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\SupplierBundle\Helper\SupplierConstant;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Entity\PoMaster;
use Tashi\CommonBundle\Entity\PoStatusMaster;

/**
 * 
 * @Route("/purchase")
 * 
 */

class PurchaseController extends Controller 
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
     * @Route ("/purchase/master_dashboard", name="_pur_master_dashboard")
     */
    public function purchaseDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('purchaseDashboardAction');
	if($accessRight==1){
        try{                   
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_DASHBOARD ));
             $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
         }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
   
    //purchase module controller section starts from here.
    
    /** 
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purchaseMasterPurchaseProduct.html
     * @Route ("/purchase/purchase_product", name="_purchase_product")
     */
    public function addNewPurchasedProductAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
            $em=$this->getDoctrine()->getManager();            
            //$comp=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchAllShippingCompany();
            $company=$em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findBy(array('recordActiveFlag'=>1,'isPrimary'=>1));
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_MASTER,array('company'=>$company)));
            $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /** 
      * Action: for viewing company details
      * Use Twig file: views\purchase\purchaseMasterPurchaseProduct.html
     * @Route ("/purchase/company_view_for_supplier", name="_company_view_for_supplier")
     */
    public function ViewCompanyForSelectingSupplierAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
           
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /** 
      * Action: for viewing details for purchase order
      * Use Twig file: views\purchase\purchaseSupplierlist.html
      * @Route ("/purchase/sup_details_form", name="_sup_details_form")
     */
    public function ViewSupDetailsFormAction()
    {           
        $em=$this->getDoctrine()->getManager();      
        try
        { 
            $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('SupplierMaster');
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_SUPLIST,array('sup_list'=>$result)));
            $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    } 
    
     /** 
      * Action: for viewing supplier details
      * Use Twig file: views\purchase\purchaseMasterPurchaseProduct.html
     * @Route ("/purchase/supplier_view_for_purchase", name="_supplier_view_for_purchase")
     */
    public function ViewSupplierForPurchaseAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
	if($accessRight==1){

        try {
            $em = $this->getDoctrine()->getManager();
            //$comp=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchAllShippingCompany();
            $company = $em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findOneBy(array('recordActiveFlag' => 1));
            if ($company) {
                //$comp = $this->get(PurchaseConstant::SERVICE_PURCHASE)->searchAllSupplier();
                $comp =$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->findBy(array('recordActiveFlag'=>1));

                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_SUP_VIEW, array('comp' => $comp, 'company' => $company)));
                $this->erpMessage->setSuccess(true);
            } else {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Add shipping company details');
            }
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
      * Action: for viewing details for purchase order
      * Use Twig file: views\purchase\purchaseOrder.html
     * @Route ("/purchase/purchase_order ", name="_purchase_order")
     */
    public function ViewPurchaseOrderAction(Request $request)
    {
           
           $em=$this->getDoctrine()->getManager();
            try
            {
                $dataUI = json_decode($request->getContent());
                $supid = $dataUI->supid;
                $SupProTxn = $this->em->getRepository(PurchaseConstant::ENT_SUP_Product_TXN)->findBy(array('recordActiveFlag'=>1,'supplierFk'=>$supid));
                $area= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy(array('recordActiveFlag'=>1),array('area'=>'ASC'));
                $sup=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
                $transporter=$this->em->getRepository(PurchaseConstant::ENT_Transporter)->findBy(array('recordActiveFlag'=>1));
                $transmode=$this->em->getRepository(PurchaseConstant::ENT_MODE)->findAll();
                $POStatus=$this->get(PurchaseConstant::SERVICE_PURCHASE)->findAllPOstatusMaster();
                // echo $POStatus[0]->getPkid();die();
                $Payment=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->findAll();
                $Employeelist=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchEMmployee();
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_ORDER,array('details'=>$sup,'area'=>$area
                        ,'trnsport'=>$transporter,'tmode'=>$transmode,'status'=>$POStatus,'emp'=>$Employeelist,'pay'=>$Payment,'procattxn'=>$SupProTxn)));
                $this->erpMessage->setSuccess(true);
           }
            catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);   
  }
    
  
   /** 
      * Action: for viewing details for purchase order
      * Use Twig file: views\purchase\purchaseOrder.html
     * @Route ("/purchase/details/{supid}", name="_details")
     */
    public function ViewDetailOrderEntryAction($supid)
    {
           
           $em=$this->getDoctrine()->getManager();      
           
           try
           {
           $session = $this->getRequest()->getSession();
           $session->set('supId',$supid);
           $category= $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy
                        (array('recordActiveFlag'=>1,'statusFlag'=>1,'parent'=>NULL),array('categoryName'=>'ASC'));
           $sup=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
           //$supdetails =$this->em->getRepository(PurchaseConstant::ENT_SUPPLIER_ADDRESS_TXN)->findBy(array('supplierFk' => $supid,'recordActiveFlag'=>1));
           $transporter=$this->em->getRepository(PurchaseConstant::ENT_Transporter)->findAll();
           $transmode=$this->em->getRepository(PurchaseConstant::ENT_MODE)->findAll();
           $POStatus=$this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findAll();
           $Payment=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->findAll();
           $Employeelist=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchEMmployee();
           
           
           $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_ENTRYORDER,array('details'=>$sup,'category'=>$category
                   ,'trnsport'=>$transporter,'tmode'=>$transmode,'status'=>$POStatus,'emp'=>$Employeelist,'pay'=>$Payment)));
           $this->erpMessage->setSuccess(true);
           }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);     
  }
  
  
  
  /**
     * @Route ("/purchase/employeewallet", name="_employeewallet")
     */
//    public function EmployeeWalletIDAction(Request $request)
//    {
//       
//       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//       try{  
//            $dataUI = json_decode($request->getContent());
//            $empcode = $dataUI->empid;
//            $empwallet=$this->em->getRepository(PurchaseConstant::ENT_EMPWALLET)->findOneByEmpFk($empcode);
//            
//            
//           
//            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_EMP_WALLET,array('wallet'=>$empwallet)));
//            $this->erpMessage->setSuccess(true);
//         }
//         catch (\Exception $ex) {
//                $this->erpMessage->setMessage($ex->getMessage());
//                $this->erpMessage->setSuccess(false);
//         }
//        $jsondata = $serializer->serialize($this->erpMessage, 'json');
//        return new Response($jsondata);     
//    }
  
  
  
  
  
  
  
  
  
    /**
     * @Route ("/purchase/pur_related", name="_pur_related")
     */
    public function purchaseRelatedItemsAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PRO_RELATED ));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    
    /**
     * Action: This method is used to append selected unit to UI for assigning it to the selected Attribute
     * @Route ("/_appendproduct", name="_appendproduct")
     */
    public function AppendSelectedProductAction(Request $request)
    {
            $em=$this->getDoctrine()->getManager();      
        
            $dataUI = json_decode($request->getContent());
            $poid=$dataUI->prid;
             $pid=$dataUI->poid;
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $ProObj=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->find($poid);
            $pro_pkid=$ProObj->getPkid();
            $Pro_id_Obj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findOneByProduct($pro_pkid);
            $Pro_Unit_Obj=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findByProductFk($pro_pkid);
            $ProJect_Obj=$this->get(PurchaseConstant::SERVICE_PURCHASE)->DisplayAllProjectRecord();
        
        try
        {  
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCT ,
             array('prod'=>$ProObj,'price'=>$Pro_id_Obj,'unit'=>$Pro_Unit_Obj,'project'=>$ProJect_Obj,'pd'=>$pid)));
             $this->erpMessage->setSuccess(true);
        }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage,'json');
        return new Response($jsondata);  
       
        
    }
    
    /**
     * Action: Load selected product detail and display in Stock detail entry page(purchaseOrder.html.twig). 
     * @Route ("/purchaseentrydetail", name="_purchaseentrydetail")
     */
    public function GotoPurchaseEntryDetailAction(Request $request)
    {   
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            //echo 'test';
            //die();
            $dataUI=  json_decode($request->getContent());
            $prdCode=$dataUI->inputProductCode;
            $em = $this->getDoctrine()->getManager();  
            $prd=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->
                    findBy(array('productCode'=>$prdCode,'statusFlag'=>1,'recordActiveFlag'=>1));
            if($prd){
                $prdPrice=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_PRICE)->findBy(
                    array('statusFlag'=>1,'recordActiveFlag' => 1, 'product'=>$prd[0]));      
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCT ,array('prod'=>$ProObj,'price'=>$Pro_id_Obj)));
                $this->erpMessage->setSuccess(true);

            }   
            else{
               $this->erpMessage->setSuccess(false);
               $this->erpMessage->setMessage('Product Code does not exist.');
            }              
        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
        $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
   //Purchase controller module section ends here
    
    /** 
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purchaseMasterPurchaseProduct.html
     * @Route ("/purchase/search_purchase", name="_search_purchase")
     */
    public function SearchPurchasedProductAction()
    {  
        $em = $this->getDoctrine()->getManager();  
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchPO');
        if($accessRight==1){
       try{  
             $result = $em->getRepository(PurchaseConstant::ENT_POSTATUS)->findAll();
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_SEARCH,array('status'=>$result)));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
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
     * Action: Search Purchase
     * @Route ("/searchpurchase", name="_searchpurchase")
     */
    public function SearchPurchaseAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('SearchPO');
	if($accessRight==1){
        $dataUI=json_decode($request->getContent());
        $criteria=$dataUI->selSearchPurchaseOrder;
        try{            
            
            switch($criteria)
            {
                case 'all':
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchAllPurchase();
                break;
                case 'ordno':
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchByOrderNO($request);
                break;
                case 'podate':
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchByDate($request);
                break;
                case 'expdate':
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchByExpDate($request);
                break;
                case 'status':
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchByStatus($request);
                break;
            }
            if(empty($purArr['allresult'])){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('No Matching Record Found!!!');
            }else{
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_VIEWORDER,array('purArr'=>$purArr)));
                $this->erpMessage->setMessage($purArr['msg']);
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
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purchaseMasterPurchaseProduct.html
     * @Route ("/purchase/purchase_approve", name="_purchase_approve")
     */
    public function PurchaseApproveAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApprovePO');
	if($accessRight==1){
       try{  
             $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->getPOforApproval($request);   
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPROVE_PURCHASE,array('podetails'=>$result)));
             $this->erpMessage->setSuccess(true);
          }
         catch (\Exception $ex) {
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
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purApprove.html 
     * @Route ("/purchase/loadapprove", name="_loadapprove")
     */
    public function LoadPurchaseApproveEditAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApprovePO');
	if($accessRight==1){
       try{  
             $em=$this->getDoctrine()->getManager();      
              
             $dataUI = json_decode($request->getContent());
             $POCode = $dataUI->poid;
             $Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneByPoPk($POCode);
            // $supid=$Pur_id->getVendorMasterFk()->getSupplierPk();
             $productpk=$this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk($POCode);
             
             $transportpk=$this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
             $payment=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
             
             
            // $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->getPOforApproval($request);   
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_APPROVE,
             array('prod'=>$productpk,'sup'=>$Pur_id,'p'=>$payment,'t'=>$transportpk)));
             $this->erpMessage->setSuccess(true);
          }
         catch (\Exception $ex) {
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
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purApprove.html 
     * @Route ("/purchase/cancelapprove", name="_cancelapprove")
     */
    public function CancelPurchaseApproveEditAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CancelPO');
	if($accessRight==1){
       try{  
             $em=$this->getDoctrine()->getManager();      
              
             $dataUI = json_decode($request->getContent());
             $POCode = $dataUI->poid;
             $Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneByPoPk($POCode);
             $productpk=$this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk($POCode);
             
             $transportpk=$this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
             $payment=$this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
             
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PUR_APPROVE,
                     array('prod'=>$productpk,'sup'=>$Pur_id,'p'=>$payment,'t'=>$transportpk)));
             $this->erpMessage->setSuccess(true);
          }
         catch (\Exception $ex) {
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
    
    
    
    
    //PURCHASE ORDER DETAILS
    
    /**
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/purappendprdsubcat/{pkid}", name="_pur_appendprdsubcat")
     */
    public function StockAppendSubCatAction($pkid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();       
            $MasterCatObj=$em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('parent'=>$pkid,'statusFlag' => 1, 'recordActiveFlag' => 1));//child category List
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                    array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$pkid),array('productName'=>'ASC'));

            if($MasterCatObj)
                {
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_SUB_CATEGORY,
                                    array('catMaster'=>$MasterCatObj,'obj'=>$CatObj)));                            
            }       
            $this->erpMessage->setSecondHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCTS,
                                    array('productArr'=>$CatProduct)));
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
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/purappendprdsubcat/{pkid}", name="_pur_appendprdsubcat")
     */
    public function PurchaseAppendSubCatAction($pkid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();  
            
            $ProjectAreaObj=$em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->find($pkid);//Single parent category
            
            $projectAreaCategoryTxnObj=$em->getRepository(CommonConstant::ENT_PROJ_PROD_CAT_TXN)->findByProjectAreaFk($pkid);//Single parent category
            
            
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy
            (array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$pkid),array('productName'=>'ASC'));

            if($projectAreaCategoryTxnObj){
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_SUB_CATEGORY,
                                    array('catMaster'=>$projectAreaCategoryTxnObj,'obj'=>$ProjectAreaObj)));                            
            }       
//            $this->erpMessage->setSecondHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCTS,
//                                    array('productArr'=>$projectAreaCategoryTxnObj)));
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
     * Action: Append Sub category for the selected Category/SubCategory in Create New Product Page
     * @Route ("/purappendproduct/{catid}", name="_purappendproduct")
     */
    public function PurchaseAppendProductsAction($catid)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $em = $this->getDoctrine()->getManager();  
           
            $CatProduct=$em->getRepository(CommonConstant::ENT_PRODUCT_TABLE)->findBy(
                    array('statusFlag'=>1,'recordActiveFlag' => 1, 'productCategory'=>$catid),array('productName'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_PRODUCTS,
                                    array('productArr'=>$CatProduct)));    

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
     * @Route ("/purchase/add_podetails", name="_add_podetails")
   */
  public function PurchaseDetailsAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
	if($accessRight==1){
        try {

            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->addPODetails($request);
            if ($result['code']==0) {
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(false);
            } else {
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
            }
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
 $this->erpMessage->setMessage($ex->getMessage());
            //$this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
      * Action: for purchase product tab
      * Use Twig file: views\purchase\purEdit.html 
     * @Route ("/purchase/updatepurchaseapprove", name="_updatepurchaseapprove")
     */
    public function UpdatePurchaseApproveEditAction(Request $request)
    {
       
       $em=$this->getDoctrine()->getManager();    
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
	if($accessRight==1){
       try{                
            $dataUI = json_decode($request->getContent());
            $POCode = $dataUI->poid;
            $Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneByPoPk($POCode);
            $supid=$Pur_id->getVendorMasterFk()->getSupplierPk();
            $SupProTxn = $this->em->getRepository(PurchaseConstant::ENT_SUP_Product_TXN)->findBy(array('recordActiveFlag'=>1,'supplierFk'=>$supid));
           // $Pro_Unit_Obj=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findByProductFk($pro_pkid);
            foreach($SupProTxn as $sup_pro)
            {
                $pofk = $sup_pro->getProductFk();
                $unit = $em->getRepository(PurchaseConstant::ENT_POProduct_Unit_txn)->findBy
                        (array('recordActiveFlag'=>1,'productFk'=>$pofk));
            }
            
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->getProductUnit($request); 
            $SupObj=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            
            $area= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                        (array('recordActiveFlag'=>1),array('area'=>'ASC'));
           
            $sup=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            
           $transporter=$this->em->getRepository(PurchaseConstant::ENT_Transporter)->findAll();
           $transmode=$this->em->getRepository(PurchaseConstant::ENT_MODE)->findAll();
                
           //$Payment=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->findAll();
           $Employeelist=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchEMmployee();
           $ProJect_Obj=$this->get(PurchaseConstant::SERVICE_PURCHASE)->DisplayAllProjectRecord(); 
           $POStatus=$this->get(PurchaseConstant::SERVICE_PURCHASE)->findAllPOstatusMaster();
           $all= $this->get(PurchaseConstant::SERVICE_PURCHASE)->getAllDetails($POCode); 
           $details3 = $this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
            
           $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_UPDATEPURAPPROVE,array('details'=>$SupObj,
            'area'=>$area,'po'=>$Pur_id,'all'=>$result ,'trnsport'=>$transporter,'tmode'=>$transmode,
            'status'=>$POStatus,'emp'=>$Employeelist,'tras'=>$all,'p'=>$details3,'project'=>$ProJect_Obj,'procatxn'=>$SupProTxn,'unit'=>$unit)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($all);
            
          }
         catch (\Exception $ex) {
  $this->erpMessage->setMessage($ex->getMessage());
           // $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                //CommonConstant::ERR_DB_OPERATION
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
      * Action: for purchase product tab
      * Use Twig file: views\purchase\QuantityUpdate.html 
     * @Route ("/purchase/updatePurdetailsQuantity", name="_updatePurdetailsQuantity")
     */
    public function UpdatePurchasePurDetailsQuantityAction(Request $request)
    {
       
          
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
        if($accessRight==1){
       try{                
           $em=$this->getDoctrine()->getManager(); 
            $dataUI = json_decode($request->getContent());
            $POCode = $dataUI->poid;
            $Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneByPoPk($POCode);
            $supid=$Pur_id->getVendorMasterFk()->getSupplierPk();
            $SupProCatTxn = $this->em->getRepository(PurchaseConstant::ENT_SUP_Product_TXN)->findBy(array('recordActiveFlag'=>1,'supplierFk'=>$supid));
           // $Pro_Unit_Obj=$em->getRepository(CommonConstant::ENTITY_PROD_UNIT_TXN)->findByProductFk($pro_pkid);
            
            
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->getProductUnit($request); 
            $SupObj=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            
            $area= $em->getRepository(CommonConstant::ENT_PROJ_AREA_MASTER)->findBy
                        (array('recordActiveFlag'=>1),array('area'=>'ASC'));
           
            $sup=$this->em->getRepository(PurchaseConstant::ENT_SUP_MASTER)->find($supid);
            
           $transporter=$this->em->getRepository(PurchaseConstant::ENT_Transporter)->findAll();
           $transmode=$this->em->getRepository(PurchaseConstant::ENT_MODE)->findAll();
                
           //$Payment=$this->em->getRepository(PurchaseConstant::ENT_CMNPAY)->findAll();
           $Employeelist=$this->get(PurchaseConstant::SERVICE_PURCHASE)->searchEMmployee();
           $ProJect_Obj=$this->get(PurchaseConstant::SERVICE_PURCHASE)->DisplayAllProjectRecord(); 
           $POStatus=$this->get(PurchaseConstant::SERVICE_PURCHASE)->findAllPOstatusMaster();
           $all= $this->get(PurchaseConstant::SERVICE_PURCHASE)->getAllDetails($POCode); 
           $details3 = $this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findOneByPoFk($POCode);
            
           $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_QuantityUpdate,array('details'=>$SupObj,
            'area'=>$area,'po'=>$Pur_id,'all'=>$result ,'trnsport'=>$transporter,'tmode'=>$transmode,
            'status'=>$POStatus,'emp'=>$Employeelist,'tras'=>$all,'p'=>$details3,'project'=>$ProJect_Obj,'procatxn'=>$SupProCatTxn)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($all);
            
          }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                //CommonConstant::ERR_DB_OPERATION
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
     * @Route ("/purchase/update_podetails", name="_update_podetails")
   */
   public function PurchaseUpdateDetailsAction(Request $request)
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
	if($accessRight==1){
       try{  
                  
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->updatePODetails($request);   
            if($result['code']==0)
            {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setJsonData($result);
            }
            else
            {
                
            $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchAllPurchase();
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_VIEWORDER,array('purArr'=>$purArr)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($purArr);}
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
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
     * @Route ("/purchase/updatequantityDetails", name="_updatequantityDetails")
   */
   public function PurchaseUpdateQuantityDetailsAction(Request $request)
    {      
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManagePO');
        if($accessRight==1){
       try{  
                  
           $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->updatePurchaseQuantityPODetails($request);
            if ($result['code']==0) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setJsonData($result);
            } else {
                $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchAllPurchase();
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_VIEWORDER,array('purArr'=>$purArr)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($purArr);
            }
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
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
    
    
    
    
    
    
    
    
    
    //approve po details
    
     /**
     * @Route ("/purchase/apprv_podetails", name="_apprv_podetails")
   */
   public function ApprovePurchaseDetailsAction(Request $request)
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApprovePO');
	if($accessRight==1){
       try{  
           
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->ApprovePODetails($request);   
            $result1 = $this->get(PurchaseConstant::SERVICE_PURCHASE)->getPOforApproval($request);   
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_APPEND_APPROVE,array('podetails'=>$result1)));
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
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
    
    
     //approve po details
    /**
     * @Route ("/purchase/cancel_podetails", name="_cancel_podetails")
   */
   public function CancelPurchaseDetailsAction(Request $request)
    {       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CancelPO');
	if($accessRight==1){
       try{  
           
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->CancelPODetails($request);   
            $purArr=$this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchAllPurchase();
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_VIEWORDER,array('purArr'=>$purArr)));
            $this->erpMessage->setJsonData($purArr);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
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
    
    //purchase payment details
    /**
     * @Route ("/purchase/payment_details", name="_payment_details")
   */
   public function PaymentDetailsAction()
    {
       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {  $supdetails = $this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->findBy(array('recordActiveFlag'=>1));
            $result = $this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findBy(array('recordActiveFlag'=>1,'approvalflag'=>1,'dueFlag'=>0), array('orderDate'=>'ASC'));
            
           // $payment = $this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findBy(array('recordActiveFlag'=>1), array('paymentDate'=>'ASC'));
            $payment = $this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchGroupByPurchaseOrderID(); 
            //var_dump($payment);die();
            $paymode = $this->em->getRepository(PurchaseConstant::ENT_Paymode)->findBy(array('recordActiveFlag'=>1));
            if($payment)
            {  
                $payid =1;
            }else
                {
                    $payid = 0;
                }
            //echo $payid;die();
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PURCHASEPAYMENT,array('paymd'=>$paymode,'pay'=>$payment,'podetails'=>$result,'sup'=>$supdetails,'payid'=>$payid)));
            $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
            //$this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
             $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    
    
    
   
    /**
     * @Route ("/purchase/searchBysupplierNameID", name="_searchBysupplierNameID")
   */
   public function SearchBySupplierNameAction(Request $request)
    {
     
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {  $dataUI = json_decode($request->getContent());
            $sup_id = $dataUI->supplierList;
            $details = $this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findBy(array('vendorMasterFk'=>$sup_id,'approvalflag'=>1,'recordActiveFlag'=>1), array('orderDate'=>'ASC'));
            //$purchase = $this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneby(array('uiOrderId'=>$PO_NO,'approvalflag'=>1,'recordActiveFlag'=>1));
            //$payment = $this->em->getRepository(PurchaseConstant::ENT_POpayment_txn)->findBy(array('recordActiveFlag'=>1));
            $payment = $this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchGroupByPurchaseOrderID(); 
            if ($payment) {
                $payid = 1;
            } else {
                $payid = 0;
            }
            if($details)
            {
                 $paymode = $this->em->getRepository(PurchaseConstant::ENT_Paymode)->findBy(array('recordActiveFlag'=>1));
                 //$this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_PAYMENTDETAILS,array('all'=>$details,'pay'=>$paymode,'poid'=>$poidpk,'total'=>$total)));
                 $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_DISPLAYPURCHASELIST,array('paymd'=>$paymode,'podetails'=>$details,'pay'=>$payment,'payid'=>$payid)));
                 //$this->erpMessage->setJsonData($details);
                 $this->erpMessage->setSuccess(true);
            }
            else
            {
                //$poidpk = 0; 
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Particular purchase order for the current supplier is not approved or Process for purchase order is not done!');
            }
            
            //$result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->searchbyPurchaseORderforproductdetails($poidpk);  
            //$grand = $result['total'][0]['grand'];
            //$tax= $result['total'][0]['totaltax'];
           
            
            //$this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
            //$this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
   }
    
   
    /**
     * @Route ("/purchase/paypurchase", name="_paypurchase")
   */
   public function PayPurchaseDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {  
            $result = $this->get(PurchaseConstant::SERVICE_PURCHASE)->PoPurchasePaymentDetails($request); 
            if ($result['code'] == 1) {
                //sectiion for payment is done sucessfully!
            $result1 = $this->em->getRepository(PurchaseConstant::ENT_POMASTER)->findBy(array('recordActiveFlag'=>1,'approvalflag'=>1,'dueFlag'=>0), array('orderDate'=>'ASC'));
            $payment = $this->get(PurchaseConstant::SERVICE_PURCHASE)->SearchGroupByPurchaseOrderID(); 
            $paymode = $this->em->getRepository(PurchaseConstant::ENT_Paymode)->findBy(array('recordActiveFlag'=>1));
            if($payment)
            {  
                $payid =1;
            }else
                {
                    $payid = 0;
                }
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_DISPLAYPURCHASELIST,array('paymd'=>$paymode,'podetails'=>$result1,'pay'=>$payment,'payid'=>$payid)));
                $this->erpMessage->setSecondHtml($this->renderView(PurchaseConstant::TWIG_PAYMENTFORM,array('paymd'=>$paymode)));
                $this->erpMessage->setSuccess(true); 
                $this->erpMessage->setMessage($result['msg']);
                //section for payment ends here
            } else {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($result['msg']);
            }
            $this->erpMessage->setJsonData($result);
           
         }
         catch (\Exception $ex) {
 //$this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
   }
    
   
   
    /**
     * @Route ("/purchase/viewPurchaserorderdetails", name="_viewPurchaserorderdetails")
   */
   public function ViewDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {  $dataUI = json_decode($request->getContent());
            $POCode = $dataUI->poid;
            $Pur_id=$this->em->getRepository(CommonConstant::ENT_PO_MASTER)->findOneByPoPk($POCode);
            $productpk=$this->em->getRepository(CommonConstant::ENT_PO_PRODUCTS)->findByPoFk($POCode);
            $transportpk=$this->em->getRepository(PurchaseConstant::ENT_POTrasns_txn)->findOneByPoFk($POCode);
            
             $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_POVIEW,
             array('prod'=>$productpk,'sup'=>$Pur_id,'t'=>$transportpk)));
             $this->erpMessage->setSuccess(true);
           
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
   }
   
   
   /**
     * @Route ("/purchase/showpaymentforcashorbank", name="_showpaymentforcashorbank")
     */
    public function ShowpaymentforcashorbankAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->pkid;
            $sourcedetails = $this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($criteria);
            // $code = $sourcedetails->getPkid();
            if ($criteria == 1) 
                {
                $session = $this->getRequest()->getSession(); 
                $emp_id = $session->get('EMPID'); 
                $branch_id = $this->get(CommonConstant::SERVICE_COMMON)->getBranchIdByGivingEmpId($emp_id);
                $balance = $this->em->getRepository(PurchaseConstant::ENT_CASHACCOUNT)->findOneBy(array('recordActiveFlag' => 1,'branchOfficeCode'=>$branch_id));
                if ($balance) {
                    $current = $balance->getCurrentAmount();
                } else {
                    $current = 0;
                }
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_DISPLAYCASHBALANCE, array('cur' => $current)));
                $this->erpMessage->setSuccess(true);
            }
            else
            {
                $atmdetails = $this->em->getRepository(PurchaseConstant::ENT_AccountCompanyBankTxn)->findBy(array('recordActiveFlag' => 1));
                $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_DISPLAYBANKBALANCE, array('sty' => $atmdetails)));
                $this->erpMessage->setJsonData($atmdetails);
                $this->erpMessage->setSuccess(true);
            }
           } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
   
   
   /**
     * @Route ("/showbankcurrentbalance", name="_showbankcurrentbalance")
     */
    public function ShowbankcurrentbalanceAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->pkid;
            // echo $criteria;die();
            $bankDetails = $this->em->getRepository(PurchaseConstant::ENT_BANKACCOUNT)->findOneBy(array('bankFk' => $criteria));
            if ($bankDetails) {
                $balance = $bankDetails->getCurrentAmount();
            } else {
                $balance = 0;
            }
            $this->erpMessage->setHtml($this->renderView(PurchaseConstant::TWIG_DISPLAYBAlance, array('amount' => $balance)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
   
    
}


