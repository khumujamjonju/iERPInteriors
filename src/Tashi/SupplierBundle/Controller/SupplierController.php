<?php
namespace Tashi\SupplierBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\SupplierBundle\Helper\SupplierConstant;
use Tashi\StockBundle\Helper\StockConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;

/**
 * @Route("/Supplier")
 */
class SupplierController extends Controller{
    
     
    private $em;
    private $erpMessage;
    
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
       
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage=new ERPMessage();
    }
    
    
    /**
     * @Route ("/sup_dashboard", name="_sup_dashboard")
     */
    public function supplierDashboardAction()
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('supplierDashboardAction');
	if($accessRight==1){
        
        try{                   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DASHBOARD));
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
    
    
    
    
    /**
     * @Route ("/supplier/add_newdash_supplier", name="_add_newdash_supplier")
     */
    public function addDashSupplierDetailsAction()
    {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){       
            try{                   
                 $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DASH_MASTER_SUPPLIER));
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
    
    /**
     * @Route ("/supplier/add_new_transport", name="_add_new_transport")
     */
    public function addNewTransportAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
       try{  $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('TransporterMaster');                
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Transport,array('trans'=>$result)));
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
    
                /**
     * @Route ("/supplier/transportor", name="_transportor")
     */
    public function TransportSettingdAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(SupplierConstant::SERVICE_SUPPLIER)->displayAllResult('TransporterMaster');
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Transport, array('allRecord' => $allRecord)));
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
     * @Route ("/supplier/add_update_transportor", name="_add_update_transportor")
     */
    public function addUpdateTransportorAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
            try {
                $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->addUpdateSupTransportor($request);
                $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Display_Transport, array('allRecord' => $result)));
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
     * @Route ("/supplier/retrieve_transportor/{transportId}", name="_retrieve_transportor")
     */
    public function retrieveTransportsAction($transportId) {
         
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
        try {
            $mobileTxnObj = $this->em->getRepository(SupplierConstant::ENT_TransportMobileTxn)->findby(array('transporterFk'=>$transportId,'recordActiveFlag'=>1));
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->retrieveTransportor($transportId);
            $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('TransporterMaster'); 
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_MobileTransport, array('mobile' =>$mobileTxnObj,'pkid'=>$transportId)));
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
            
        } catch (\Exception $ex) {
             //$this->erpMessage->setMessage($ex->getMessage());
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
     * @Route ("/supplier/delete_transprot/{transportId}", name="_delete_transport")
     * 
     */
    public function deleteTransportsAction($transportId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
        try {
           
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->deleteTransportsMaster($transportId);
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Display_Transport, array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            //$this->erpMessage->setMessage($ex->getMessage());
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
     * @Route ("/supplier/addtransport", name="_addtransport")
     */
    public function addTransportAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
       try
       {     $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->addTransportMaster($request);                
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Display_Transport,array('trans'=>$result)));
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
     * @Route ("/supplier/updatetransport", name="_updatetransport")
     */
    public function updateTransportAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
       try
       {     $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->updateTransportMaster($request);                
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Display_Transport,array('trans'=>$result)));
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
     * @Route ("/supplier/deletetransport/{tid}", name="_deletetransport")
     */
    public function deleteTransportAction(Request $request,$tid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageTransporter');
	if($accessRight==1){
       try
       {  
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->deleteTransportMaster($tid);                
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_Display_Transport,array('trans'=>$result)));
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
     * @Route ("/supplier/retrive_transport/{tid}", name="_retrive_transport")
     */
    public function RetrieveTransportDetailsAction($tid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       
        try 
        {                
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getTransportdetails($tid); 
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    
    /** This method is mainly for displaying supplier form whenever click on supplier tab on edit mode.
     * 
     * @Route ("/supplier/add_newdash_supplier1", name="_add_newdash_supplier1")
     */
    public function DashSupplierDetails1Action(Request $request)
    {
       
       $em=$this->getDoctrine()->getManager();    
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{      
            $dataUI = json_decode($request->getContent());
            $supid=$dataUI->supid; 
           
             $ProuctCategory = $this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('recordActiveFlag'=>1)); 
             $SupProCategory = $em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->findBy(array('recordActiveFlag'=>1,'supFk'=>$supid));
             $SupplierTxnInfo = $em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBySupplierFk($supid);
             $this->erpMessage->setSuccess(true);
             $this->erpMessage->setMessage("success");
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_MASTER_SUPPLIER,array('supinfo'=>$SupplierTxnInfo,'Category'=>$ProuctCategory,'subcategory'=>$SupProCategory))); 
          
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /**
     * @Route ("/supplier/add_new_supplier", name="_add_new_supplier")
     */
    public function addSupplierDetailsAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  $ProuctCategory = $this->em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('recordActiveFlag'=>1)); 
             $subcategory='';
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_MASTER_SUPPLIER,array('Category'=>$ProuctCategory,'subcategory'=>$subcategory)));
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
     * @Route ("/supplier/add_supplier", name="_add_supplier")
   */
    
   public function SuppllieraddingDetailsAction(Request $request)
    {
       
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
            try{  
                 $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->addSupplierMaster($request);   

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
     * @Route ("/supplier/update_supplier", name="_update_supplier")
     */
   public function UpadateSuppllieraddingDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->updateSupplierMaster($request);   
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
         
    }
    
    
    /**
    * @Route ("/supplier/supplier_Mobile_Detail", name="_supplier_Mobile_Detail")
    */
    public function addSupplierMobileDetailAction(Request $request)
    {
        
        $em=$this->getDoctrine()->getManager();     
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try
        {    $dataUI = json_decode($request->getContent());
             $supid=$dataUI->supid;

             $isMobileCodeExist =$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBy(array('supplierFk' => $supid,'recordActiveFlag'=>1));

             $mobileno_txn =$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->findOneBy(array('supContactFk' => $isMobileCodeExist,'recordActiveFlag'=>1));
             if($mobileno_txn=='')
             {
                  $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->addSupplierMobileMaster($request);   
                  $result1 = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobileNodetails($supid);  
                  $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST,array('result'=>$result,'result1'=>$result1)));
                  $this->erpMessage->setJsonData(1) ;  
                  $this->erpMessage->setMessage($result['msg']);
                  $this->erpMessage->setSuccess(true);
             }
             else
             {      
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData(0) ;  
                $this->erpMessage->setMessage('Contact list already have one!,Please edit contact list and add multiple mobile no');                 
             }     
             
        }
        catch (\Exception $ex) {
            //$this->erpMessage->setMessage($ex->getMessage());
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
    * @Route ("/supplier/Supplier_Bank_Detail", name="_Supplier_Bank_Detail")
    */
    public function addSupplierBankDetailAction(Request $request)
    {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{  
             $supid=$request->request->get('loadID');
             $result1 = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierBankDetails($supid);   
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnBankAccountType');
             
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_SUPPIER_BANK_DETAILS ,array('account_type'=>$result,'bankdetail'=>$result1)));
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
    * @Route ("/supplier/insert_Bank_Detail", name="_insert_Bank_Detail")
    */
    public function SupplierBankDetailInsertAction(Request $request)
    { 
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{                   
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->addSupplierBankDetailsMaster($request);   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST,array('bankdetails' => $result)));  
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
    * @Route ("/supplier/update_Bank_Detail", name="_update_Bank_Detail")
    */
    public function UpdateSupplierBankDetailAction(Request $request)
    { 
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{ 
            
            
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->UpdateSupplierBankDetailsMaster($request);   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST,array('bankdetails' => $result)));  
             $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnBankAccountType'); 
             $this->erpMessage->setSecondHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_BANKFORM,array('account_type'=>$result1)));

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
    * @Route ("/supplier/delete_Bank_Detail/{bankid}", name="_delete_Bank_Detail")
    */
    public function DeleteSupplierBankDetailAction(Request $request,$bankid)
    { 
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{ 
            
           
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->DeleteSupplierBankDetailsMaster($request,$bankid);   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST,array('bankdetails' => $result)));  
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
    * @Route ("/supplier/update_mobile_Detail", name="_update_mobile_Detail")
    */
    public function UpdateSupplierMobileNoDetailAction(Request $request)
    { 
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try
        {   $dataUI = json_decode($request->getContent());
            $supid=$dataUI->supid;
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->UpdateSupplierMobileDetailsMaster($request);
            $result1 = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobileNodetails($supid);
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST,array('result'=>$result,'result1'=>$result1)));
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
    * @Route ("/supplier/delete_Mobile_Detail/{supid}", name="_delete_Mobile_Detail")
    */
    public function DeleteSupplierMobileDetailAction(Request $request,$supid)
    { 
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{ 
             
             
             //$result = $this->get(StockConstant::SERVICE_SUPPLIER)->UpdateSupplierMobileDetailsMaster($request);
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->DeleteSupplierContactDetailsMaster($request,$supid);  
             $result1 = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobileNodetails($supid);
             
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST,array('result'=>$result,'result1'=>$result1)));
             $this->erpMessage->setSecondHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_MOBILE_FORM));
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
    * @Route ("/supplier/update_mobilelist_Detail/{mob_id}", name="_update_mobilelist_Detail")
    */
    public function UpdateSupplierMobileNoListDetailAction(Request $request,$mob_id)
    { 
        
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{ 
             $dataUI = json_decode($request->getContent());
             $supid=$dataUI->supid;
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->UpdateSupplierMobileListDetailsMaster($request,$mob_id);   
             $result1 = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobileNodetails($supid);   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST,array('result1'=>$result1)));
             $this->erpMessage->setSuccess(true);
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
    
    /**
    * @Route ("/supplier/update_transportmobilelist/{mob_id}", name="_update_transportmobilelist_")
    */
    public function UpdateTransportMobileNoListDetailAction(Request $request,$mob_id)
    { 
        
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
        try{                   
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->UpdateTransportMobileListDetailsMaster($request,$mob_id);   
             $this->erpMessage->setSuccess(true);
             $this->erpMessage->setMessage($result['msg']);
        }
        catch (\Exception $ex) {
                //$this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
    * @Route ("/supplier/delete_mobilelist_Detail/{mob_id}", name="_delete_mobilelist_Detail")
    */
    public function DeleteSupplierMobileNoListDetailAction(Request $request,$mob_id)
    { 
       
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                   
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->DeleteSupplierMobileMaster($request,$mob_id);   
             $this->erpMessage->setSuccess(true);
             $this->erpMessage->setMessage($result['msg']);
        }
        catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /**
    * @Route ("/supplier/deletetransportMobile/{mob_id}", name="_deletetransportMobile")
    */
    public function DeleteTransportMobileNoListDetailAction(Request $request,$mob_id)
    { 
       
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{                   
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->DeleteTransportMobileMaster($request,$mob_id);   
             $this->erpMessage->setSuccess(true);
             $this->erpMessage->setMessage($result['msg']);
        }
        catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /**
     * @Route ("/supplier/search_supplier", name="_search_supplier")
     */
    public function SearchSupplierDetailsAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
       {                   
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CIM_CUS_SEARCH));
            $this->erpMessage->setSuccess(true);
       }
         catch (\Exception $ex) {
                $$this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /**
     * @Route ("/supplier/search_edit_supplier", name="_search_edit_supplier")
     */
    public function SearchSupplierforEditAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->searchSupplierDetails($request);    
             
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_DISPLAYING_RESULT ,array('supplier' => $result)));
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
     * @Route ("/supplier/view_supplier{supid}", name="_view_supplier")
     */
    public function ViewSupplierAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
       {   
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
     * @Route ("/supplier/add_supplier_address", name="_add_supplier_address")
     */
    public function AddSupplierAddressDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//       $dataUI = json_decode($request->getContent());
        $em=$this->getDoctrine()->getManager();    
       $supid = $request->request->get('loadID');
      
       try{                   
          $addressInfo = $em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supplierFk'=>$supid,'recordActiveFlag'=>1));
          $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_SUPPLIER_ADDRESS, array('addressinfo' => $addressInfo)));
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
     * @Route("/supviewaddress/{addtxnid}/{supid}", name="_supviewaddress") 
     */
    public function ViewAddress($addtxnid,$supid) 
    {   
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();       
            $em = $this->getDoctrine()->getManager();            
            $addtxn=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->find($addtxnid);            
                   
            if($addtxn){
                $country = $em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('recordActiveFlag'=>1));
                $state = $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findByCountryCodeFk($addtxn->getAddressFk()->getCountryCodeFk()->getCountryPk());
                $district = $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findByStateFk($addtxn->getAddressFk()->getStateCodeFk()->getStatePk());
                $city=$em->getRepository(CommonConstant::ENT_CITY_MASTER)->findByDistrictFk($addtxn->getAddressFk()->getDistrictFk()->getPkid());
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_ADDFORM, 
                array('country'=>$country,'state'=>$state,'district'=>$district,'addtxn'=>$addtxn,'custid'=>$supid,'city'=>$city)));
            }
            else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Unable to load Address detail.');            
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
     /**
     * This method is used to soft delete Address of a supplier                          
     * @Route("/supDeleteSupAddress/{addtxnid}/{supid}", name="_sup_del_sup_address") 
     */
    public function cimDeleteCustAddressAction($addtxnid,$supid){
        
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $em=$this->getDoctrine()->getManager();
            $isPrimary=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supAddPk'=>$addtxnid,'isPrimaryAddress'=>1));
            if($isPrimary){
                $this->erpMessage->setMessage('You cannot delete a Primary Address. If you wish to delete this address then you must first set/add another address as primary.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            $result=$this->get(SupplierConstant::SERVICE_SUPPLIER)->SupDeleteAddress($addtxnid);
            
            ////this sections by sanatomba
            
            
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);
                $addressInfo=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supplierFk'=>$supid,'approvalFlag'=>1,'recordActiveFlag'=>1),array('isPrimaryAddress'=>'DESC','addressCode'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_SUP_ADDRESS_ATTRIBUTE,array('addressinfo' => $addressInfo)));
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
    
    
    
    
    /**
     * This method is used to delete selected Supplier(i.e set Record active flag to 0                     
     * @Route("/deletesupplier/{supid}", name="_deletesupplier") 
     */
    public function DeleteSupplierAction($supid){
         
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->DeleteSupplier($supid);
            if ($result['code']== 1) {
               $this->erpMessage->setSuccess(true);         
            } else {
                $this->erpMessage->setSuccess(false);                    
            }
            $this->erpMessage->setMessage($result['msg']);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $jsondata = $serializer->serialize($this->erpMessage , 'json');
            return new Response($jsondata);        
    }
    
    
    
    
    
    /**
     * @Route ("/supplier/add_supplier_mobile", name="_add_supplier_mobile")
     */
    public function AddSupplierMobileNoDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $supid=$request->request->get('loadID');
             $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobileNodetails($supid);   
             $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_SUPPLIER_MOBILE,array('result'=>$result)));
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
     * @Route ("/supplier/retrive_supplier_mobile/{supid}", name="_retrive_supplier_mobile")
     */
    public function RetrieveMobileNoDetailsAction($supid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       
        try 
        {
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->getsupplierMobiledetails($supid); 
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_MOBILE_FORM,array('sup'=>$supid)));
            $this->erpMessage->setSecondHtml($this->renderView(SupplierConstant::TWIG_STOCK_SUPPLIER_MOBILE_LIST,array('result'=>$result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/supplier/retrive_supplier_bank/{bankid}", name="_retrive_supplier_bank")
     */
    public function RetrieveSupplierBankDetailsAction($bankid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       
        try 
        {
            $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->retrievesupplierBankDetails($bankid); 
            $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnBankAccountType');
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_BANKFORM,array('result'=>$result,'account_type'=>$result1)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    //from erp

/**
     * This method is used to search customer and list the result
     * is entered ( E.g: Customer, Proprietor & Directors )
     * use by
     *     cim_home.html.twig	
     * @Route("/search_supplier", name="_erplms_cim_search_supplier_viewinformation")
     */
    public function searchCustmrAction(Request $request) {
            try
            { 
                $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->searchSupplierDetails($request);    
               
                if(empty($result['result'])) 
                {
                     $this->erpMessage->setSuccess(false);
                     $this->erpMessage->setMessage('No record found');
                } 
                else 
                { 
                    $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CIM_CUS_SEARCH_RESULT, array('supplier' => $result)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($result);
                }
            }
            catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    
    //from erp customer
    
    
    /**
     * This method is used to Load New Supplier Add Form a supplier with all credentials                         
     * @Route("/SaveSuptadd/{mode}", name="_savesup_add") 
     */
    public function SaveSuppaddAction(Request $request,$mode) 
    {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
            $em=$this->getDoctrine()->getManager();      
            try{
                $dataUI = json_decode($request->getContent());
                $supid=$dataUI->supid;
                
                $em=$this->getDoctrine()->getManager();
                $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
                
                $primayStatus=$dataUI->inputisPrimaryAdd;
                
                $addtxnid=$dataUI->inputAddTxnId;
                //$custId=$request->request->get('inputAddAddresscustId');
                $addCode=$dataUI->addCode;
                
                
                $isAddCodeExist=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supplierFk'=>$supid,'addressCode'=>$addCode));
                
               
                if($isAddCodeExist && $isAddCodeExist[0]->getSupAddPk()!=$addtxnid){
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setHtml('');
                    $this->erpMessage->setMessage('Address Code already exist for the same supplier.');
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }
                if($primayStatus==0) //if the new address is not primary or removed existing primary value
                {   
                    $existingAdd=$em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBysupplierFk($supid);
                    $isotherprimaryExist=false;
                    foreach($existingAdd as $add){
                        if($add){
                            if($add->getSupAddPk()!=$addtxnid && $add->getIsPrimaryAddress()==1)
                            {
                                $isotherprimaryExist=true;
                                break;
                            }
                        }                
                    }
                    if(!$isotherprimaryExist){
                       
                        $this->erpMessage->setSuccess(false);
                        $this->erpMessage->setHtml('');
                        $this->erpMessage->setMessage('Cannot proceed as there is no Primary Address for the supplier.');
                        $jsondata = $serializer->serialize($this->erpMessage, 'json');
                        return new Response($jsondata);
                    }
                }       
                $result=$this->get(SupplierConstant::SERVICE_SUPPLIER)->newsaveAddressDetails($request,$mode);
                
              if($result['code']==1){
                     $addressTxn=$result['msg'];
                    // $addressInfo=$em->getRepository(StockConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supplierFk'=>$request->request->get('inputAddAddresscustId'),'approvalFlag'=>1,'recordActiveFlag'=>1),array('isPrimaryAddress'=>'DESC','addressCode'=>'ASC'));
                     $addressInfo = $em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN)->findBy(array('supplierFk'=>$supid,'recordActiveFlag'=>1));
         
                     
                     
                     $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_SUP_ADDRESS_ATTRIBUTE,array('addressinfo' => $addressInfo)));
                     $this->erpMessage->setSuccess(true);
                     if($mode=='INS'){
                         $this->erpMessage->setMessage("Address has been saved successfully.");
                     }
                     elseif($mode=='UPD'){
                         $this->erpMessage->setMessage("Address detial has been updated successfully.");
                     }                        
                 }
                 else{
                     $this->erpMessage->setSuccess(false);
                     $this->erpMessage->setMessage($result['msg']);
                 } 
            }
            catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
            }
            
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    
    /**
     * This method is used to Load Supplier Detail Form Using
     * use by
     *          cim_home.html.twig                              
     * @Route("/supLoadSupplierDetailForm/{supid}", name="_load_sup_detailForm") 
     */
      public function cimLoadSupllierDetailFormAction($supid) 
      {        
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
            
            try{
  
            $em=$this->getDoctrine()->getManager();  
            $session = $this->getRequest()->getSession();
               
            $session->set('supId',$supid);
               
             
            $SupplierTxnInfo = $em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_CONTACT_TXN)->findOneBySupplierFk($supid);
            
            //$SupProCategory = $em->getRepository(SupplierConstant::ENT_SUP_Pro_Category_Txn)->findBy(array('recordActiveFlag'=>1,'supFk'=>$supid));
            //$Category = $em->getRepository(CommonConstant::ENTITY_ERP_PROD_CAT_MASTER)->findBy(array('recordActiveFlag'=>1));

            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage("success");
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_STOCK_MASTER_SUPPLIER,
                   array('supinfo'=>$SupplierTxnInfo,'mode'==1)));      
            
            
                              
            }
            catch (\Exception $ex) {
                throw new \Exception ($ex->getMessage());
             }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
    }
    
    
     /**
     * This method is used to Load New Customer Add Form a customer with all credentials 
     *  Pre Assumption is that it would be used only for 
     *       1.Customer
     *       2.Creation Only-----   
     * use by
     *          loadCustomerApprv_form                             
     * @Route("/supLoadAddForm", name="_loadSupAddForm") 
     */
    public function supLoadAddFormAction() 
    {
      
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $this->erpMessage = new ERPMessage();
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage("success");
            $em = $this->getDoctrine()->getManager();
            
            //$selectedAddressType = $em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addType);
            $city = $em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('recordActiveFlag'=>1));
            $state = $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('recordActiveFlag'=>1));
            $district = $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('recordActiveFlag'=>1));
            $country = $em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('recordActiveFlag'=>1));
            
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_ADDFORM,
            array('country'=>$country,'state'=>$state,'district'=>$district,'city'=>$city,'addressDetail'=>'')));
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }      
      
    
     /**
     * This method is used to Load New Bank Details Add Form a supplier with all credentials 
     *  Pre Assumption is that it would be used only for 
     *       1.Customer
     *       2.Creation Only-----   
     * use by
     *          loadCustomerApprv_form                             
     * @Route("/supLoadBankAddForm", name="_loadSupBankAddForm") 
     */
    public function supLoadAddBankFormAction() 
    {
      
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
       try{                   
             
           
           
         $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnBankAccountType'); 
         $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_BANKFORM,array('account_type'=>$result)));
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
    
    /**
     * This method is used to Load New Mobile Details Add Form a supplier with all credentials 
     *  Pre Assumption is that it would be used only for 
     *       
     *        
     * use by
     *                               
     * @Route("/supLoadMobileAddForm", name="_loadSupMobileAddForm") 
     */
    public function supLoadAddMobileFormAction() 
    {
      
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageSupplier');
	if($accessRight==1){
       try
        {                   
             
         $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_CMN_SUP_MOBILE_FORM));
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
    
    
     /************************SUPPLIER COMMUNICATION********************************/
    /**
    * This method is for searching Supplier and for communication purpose. 
    * @Route("/comsearchSupplier", name="_comsearchSupplier")
    */
    public function ComSearchSupplierAction(){
            
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_COM_SEARCH));
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    /**
     * This method is used to search supplier and list the result
     * is entered ( E.g: Customer, Proprietor & Directors )
     * use by
     *     cim_home.html.twig	
     * @Route("/supplier_viewinformation", name="_supplier_viewinformation")
     */
    public function searchSupplierListDetailsAction(Request $request) {
        
         
            try
             { 
                $result = $this->get(SupplierConstant::SERVICE_SUPPLIER)->searchSupplierDetails($request);                   
                if (empty($result['result'])) 
                {
                    $this->erpMessage->setMessage('No record found!');
                    $this->erpMessage->setSuccess(false);
                } 
                else 
                { 
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_COM_RESULT, array('supplier' => $result)));
                }
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
     * @Route("/supmessagetemplate/{comtype}", name="_supmessagetemplate")
     */
    public function commessagetemplatection(Request $request,$comtype){
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCommunication');
	if($accessRight==1){
        
            try{          
                $dataUI=  json_decode($request->getContent());
                $mobnos=array();
                $supIds=array();
                $emails=array();
                $contactId=array();
                $isSelected=$dataUI->inputisSelected;
                $mobnofromui=$dataUI->inputComMobno;  
                $supIdfromui=$dataUI->inputComSupId;  
                $emailfromui=$dataUI->inputComEmail;  
                $contactidsfromui=$dataUI->inputComContId;
                if(is_array($isSelected)){
                    for($i=0;$i<count($isSelected);$i++){
                        if($isSelected[$i]){
                            array_push($mobnos, $mobnofromui[$i]);
                            array_push($emails, $emailfromui[$i]);
                            array_push($supIds, $supIdfromui[$i]);
                            array_push($contactId, $contactidsfromui[$i]);
                        }
                    }
                }
                else{
                    array_push($mobnos, $mobnofromui);
                    array_push($emails, $emailfromui);
                    array_push($supIds, $supIdfromui);
                    array_push($contactId, $contactidsfromui);
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage('');
                //$this->erpMessage->setMessage($result);
                if(strcasecmp($comtype, 'sms')==0){
                   $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_SMS_TEMPLATE, 
                            array('mobilenos' => $mobnos,'supid'=>$supIds,'contactids'=>$contactId)));
                }
                elseif(strcasecmp($comtype, 'email')==0){
                    $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_SEND_EMAIL,
                            array('emails'=>$emails,'supid'=>$supIds,'contactids'=>$contactId)));
                }
            }
            catch (\Exception $ex) 
            {
               $this->erpMessage->setSuccess(false);
               $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
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
     * @Route("/sendsuppliersms}", name="_sendsuppliersms")
     */
    public function SendSMSAction(Request $request){
        
         
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCommunication');
        if($accessRight==1){
            $result=$this->get(SupplierConstant::SERVICE_SUPPLIER)->SendSupplierSMS($request);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);                      
            }
            else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
            
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
    }
    
    
    
    /**
     * This method will send mail to all selected email
     * @Route("/sendsupemail", name="_sendsupemail")
     */
    public function SendSupplierEmailAction(Request $request){
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCommunication');
        if($accessRight==1){
            $result=$this->get(SupplierConstant::SERVICE_SUPPLIER)->SendSupplierEmail($request);
            if($result['code']==1){
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
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage , 'json');
            return new Response($jsondata);
    }
    
    
    //view history section need to be updated
    
    /**
     * This method is used to load and display existing communication history for a particular supplier
     * @Route("/viewsuppliercomhistory/{supid}", name="_viewsuppliercomhistory")
     * 
     */
    public function ViewSupplierCommunicationAction($supid,Request $request){
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageCommunication');
	if($accessRight==1){
            try{ 
                $dataUI=  json_decode($request->getContent());
                $mobilepk=$dataUI->mid;
                $supplier=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MASTER)->find($supid); 
                $mobtxn=$this->em->getRepository(SupplierConstant::ENT_STOCK_SUPPLIER_MOBILE_TXN)->find($mobilepk);
                $comtxn = $this->em->getRepository('TashiCommonBundle:CmnSupplierCommunicationTxn')->
                        findBy(array('supidFk'=>$supid,'approvalFlag'=>1,'recordActiveFlag'=>1),
                                array('sentDatetime'=>'DESC'));
                $this->get(SupplierConstant::SERVICE_SUPPLIER)->UpdateBulkSmsStatus($supid);
                $comtxn=$this->em->getRepository('TashiCommonBundle:CmnSupplierCommunicationTxn')->
                        findBy(array('supidFk'=>$supid,'approvalFlag'=>1,'recordActiveFlag'=>1),
                                array('sentDatetime'=>'DESC'));
                if($comtxn){
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(SupplierConstant::TWIG_COM_HISTORY,array('mobtxn'=>$mobtxn,'comtxn'=>$comtxn,'sup'=>$supplier)));
                }
                else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Communication History exist for the selected supplier.');
                }                
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Could not load Communication History.Error: '.$ex->getMessage());
            } 
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}




