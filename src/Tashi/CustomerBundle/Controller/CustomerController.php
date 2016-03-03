<?php
/**
 * Module Name :
 * Purpose or objective of the  Controller : This controller is used to describe 
 * the functionalaties of the module of Customer Information Management(CIM)
 * Links : ERP\CustomerBundle\Controller\DefaultController.php
 * Created By : 5066
 * Created Date : 13-February-2015
 * 
 * Last Modified Date :
 * Last Modified By : 
 * Test Carried Out :
 * Test Carried By :
 * Version : 1.0
 */
namespace Tashi\CustomerBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // symfony annotation route for defining the module
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tashi\CustomerBundle\Helper\CustomerConstant;  
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * 
 * @Route("/cim")
 * 
 */
class CustomerController extends Controller
{
   // private $CustomerMessage;
    private $em;
    private $erpMessage;
    
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
       // $this->CustomerMessage = new CustomerMessage();
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage=new ERPMessage();
    }
    /**
     * @Route ("/customer/master_dashboard", name="_cus_master_dashboard")
     */
    public function customerDashboardAction() {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('customerDashboardAction');
	if($accessRight==1){
            try {
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_DASHBOARD));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'unknown'));
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/customer/createcustomer", name="_create_customer")
     */
    public function createCustomerAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('customerDashboardAction');
	if($accessRight==1){
            try {           
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_NEW_CUSTOMER));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
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
     * @Route ("/customer/addnewcustomer", name="_add_new_customer")
     */
    public function addNewCustomerAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->addCreateCustomerMaster($request);
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_NEW_CUST_DETAIL));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage('Record inserted');
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    /**
     * @Route ("/employee/address_details", name="_customer_address_details")
     */
    public function customerAddressDetialsAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $city = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCityMaster');
            $state = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationStateMaster');
            $country = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationCountryMaster');
            $district = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnLocationDistrictMaster');
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_NEW_ADDRESS, 
                       array('city' => $city, 'state' => $state, 'country' => $country, 'district' => $district)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    } 
    
    
    /**
     * @Route ("/customer/customer_advance_payment", name="_customer_advance_payment")
     */
    public function cusAdvancePaymentAction() { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em=$this->getDoctrine()->getManager();
            $pendingHodApprovalCount=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->GetPendingHodPaymentCount();
            if($pendingHodApprovalCount){
                $apprCount=$pendingHodApprovalCount[0][1];
            }
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_ADVANCE_PAYMENT,array('ApprCount'=>$apprCount)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    } 
        
    /**
     * @Route ("/customer/customer_approve_advance_payment_from_hod", name="_customer_approve_advance_payment_from_hod")
     */
    public function cusApproveAdvancePaymentFromHodAction() { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('cusApproveAdvancePaymentAction');
	if($accessRight==1){
            try {
                $em=$this->getDoctrine()->getManager();
                $session=$this->getRequest()->getSession();            
                $empid=$session->get('EMPID');
                $transactionDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                $pendingApprovalCusAdvPayment = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)
                                    ->findBy(array('paymentStatus' => 'C', 'hodApprove'=>0, 'recordActiveFlag' => 1), array('advancePaymentPk' => 'DESC'));           
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_APPROVE_ADVANCE_PAYMENT_BY_HOD,
                        array('pendingApprovalCusAdvPayment' => $pendingApprovalCusAdvPayment,'tranDate'=>$transactionDate)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
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
     * @Route ("/customer/customer_approve_advance_payment", name="_customer_approve_advance_payment")
     */
    public function cusApproveAdvancePaymentAction() { 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
            try {
                $em=$this->getDoctrine()->getManager();
                $session=$this->getRequest()->getSession();            
                $empid=$session->get('EMPID');
                $allEmp=$em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employementTypeFk'=>1,'recordActiveFlag'=>1));
                $transactionDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                $pendingApprovalCusAdvPayment = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)
                                    ->findBy(array('paymentStatus' => 'C', 'hodApprove'=>1, 'recordActiveFlag' => 1), array('advancePaymentPk' => 'DESC'));           
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_APPROVE_ADVANCE_PAYMENT,
                        array('pendingApprovalCusAdvPayment' => $pendingApprovalCusAdvPayment,'tranDate'=>$transactionDate,'allEmp'=>$allEmp)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
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
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          scustomerSearchResult.html.twig                              
     * @Route("/customer/edit_advance_payment/{advPayID}/{key}", name="_edit_cus_advance_payment") 
     */
      public function editCusAdvancePaymentAction($advPayID, $key) 
      {    
           try{   
//                $var_key = '';
//                switch($key){
//                    case 'E':   $var_key = 'advPay';
//                                break;
//                    case 'V':   $var_key = 'viwHis';
//                                break;
//                }
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->editCusAdvancePayment($advPayID);   
                $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));               
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_FORM, array('paymentMode' => $paymentMode, 'cusPkid' => $result['cus_id'], 'key' => $key)));
                $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($advPayID);
                
                $result['enter_account_id']=$cusAdvPayObj->getAmountEnterAccountId();
                $accountKey = '';
                if($result['payment_mode_id'] == 1){
                    $accountKey = 'cash';
                    $accountList = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag' => 1));
                }else{
                    $accountKey = 'bank';
                    $accountList = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findBy(array('recordActiveFlag' => 1));
                }         
                $this->erpMessage->setSecondHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_LOAD_ACCOUNT_SOURCE_LIST, array('accountList' => $accountList, 'key' => $accountKey)));
                
                $result['key'] = $key;
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                throw new \Exception ($ex->getMessage());
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_payment_approve.html.twig                              
     * @Route("/customer/_save_approved_advance_payment_by_hod", name="_save_approved_cus_advance_payment_by_hod") 
     */
      public function saveApprovedCusAdvancePaymentByHodAction(Request $request) 
      {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
           try{   
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->approvedCusCreatedAdvancePaymentByHod($request);                  
                $this->erpMessage->setMessage($result);
                $this->erpMessage->setSuccess(true);
                $em=$this->getDoctrine()->getManager();               
                $pendingApprovalCount=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->GetPendingHodPaymentCount();
                if($pendingApprovalCount){
                    $this->erpMessage->setJsonData($pendingApprovalCount[0][1]);
                }
                $em=$this->getDoctrine()->getManager();
                $session=$this->getRequest()->getSession();            
                $empid=$session->get('EMPID');
                $transactionDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                $pendingApprovalCusAdvPayment = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)
                                    ->findBy(array('paymentStatus' => 'C', 'hodApprove'=>0, 'recordActiveFlag' => 1), array('advancePaymentPk' => 'DESC'));           
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_APPROVE_ADVANCE_PAYMENT_BY_HOD,
                        array('pendingApprovalCusAdvPayment' => $pendingApprovalCusAdvPayment,'tranDate'=>$transactionDate)));
                
            }
            catch (\Exception $ex) {
                throw new \Exception ($ex->getMessage());
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);

    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_payment_approve.html.twig                              
     * @Route("/customer/_save_approved_advance_payment", name="_save_approved_cus_advance_payment") 
     */
      public function saveApprovedCusAdvancePaymentAction(Request $request) 
      {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
           try{   
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->approvedCusCreatedAdvancePayment($request);                  
                $this->erpMessage->setMessage($result);
                $this->erpMessage->setSuccess(true);
                $em=$this->getDoctrine()->getManager();
                $pendingApprovalCount=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->GetPendingPaymentCount();
                if($pendingApprovalCount){
                    $this->erpMessage->setJsonData($pendingApprovalCount[0][1]);
                }
                $em=$this->getDoctrine()->getManager();
                $session=$this->getRequest()->getSession();            
                $empid=$session->get('EMPID');
                $transactionDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                $pendingApprovalCusAdvPayment = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)
                                    ->findBy(array('paymentStatus' => 'C', 'hodApprove'=>1, 'recordActiveFlag' => 1), array('advancePaymentPk' => 'DESC'));           
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUST_APPROVE_ADVANCE_PAYMENT_AJAX,
                        array('pendingApprovalCusAdvPayment' => $pendingApprovalCusAdvPayment,'tranDate'=>$transactionDate)));
                
            }
            catch (\Exception $ex) {
                throw new \Exception ($ex->getMessage());
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);

    }
    
    /**
     * This method is used to Load New Customer Add Form a customer with all credentials                         
     * @Route("/cimSaveCustadd/{mode}", name="_savecust_add") 
     */
    public function cimSaveCustaddAction(Request $request,$mode) 
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        if($mode=='INS'){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateCustomer');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                goto _exitsavecust;
            }
        }else{
            if($mode=='UPD'){
                $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditCustomer');
                if($accessRight!=1){
                    $this->erpMessage->setJsonData('AD');
                    $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                    goto _exitsavecust;
                }
            }
        }
//        try{
            $em=$this->getDoctrine()->getManager();          
                  
            $primayStatus=$request->request->get('inputisPrimaryAdd');
            $addtxnid=$request->request->get('inputAddTxnId');
            $custId=$request->request->get('inputAddAddresscustId');
            $addCode=$request->request->get('addCode');
            $isAddCodeExist=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('customerFk'=>$custId,'addressCode'=>$addCode));
            if($isAddCodeExist && $isAddCodeExist[0]->getPkid()!=$addtxnid){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setHtml('');
                $this->erpMessage->setMessage('Address Code already exist for the same customer.');
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            if($primayStatus==0) //if the new address is not primary or removed existing primary value
            {
                $existingAdd=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findByCustomerFk($custId);
                $isotherprimaryExist=false;
                foreach($existingAdd as $add){
                    if($add){
                        if($add->getPkid()!=$addtxnid && $add->getIsPrimaryAddress()==1)
                        {
                            $isotherprimaryExist=true;
                            break;
                        }
                    }                
                }
                if(!$isotherprimaryExist){
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setHtml('');
                    $this->erpMessage->setMessage('Cannot proceed as there is no Primary Address for the customer.');
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }
            }       
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->saveAddressDetails($request,$mode);
            if($result['code']==1){
                //$addressTxn=$result['msg'];
                $addressInfo=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('customerFk'=>$request->request->get('inputAddAddresscustId'),'approvalFlag'=>1,'recordActiveFlag'=>1),array('isPrimaryAddress'=>'DESC','addressCode'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUSTOMER_ADDRESS_ATTRIBUTE,array('addressinfo' => $addressInfo)));
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
//        }
//        catch(\Exception $ex){
//            $this->erpMessage->setSuccess(false);
//            $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
//        }
        _exitsavecust:
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);

    }
    
    /**
     * This method is used to Update Customer Detail                          
     * @Route("/cimupdateCusDetail/", name="_cim_updateCusDetail") 
     */
     public function cimupdateCusDetailAction(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditCustomer');
	if($accessRight==1){
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->UpdateCustomer($request);
            if ($result['code']== 1){
                $this->erpMessage->setSuccess(true);         
            } else {
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
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_revenue_report.twig                              
     * @Route("/customer/revenue_report", name="_revenue_report") 
     */
      public function revenueReportAction() 
      {   
           try{   
                $employee = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employementTypeFk' => 1, 'recordActiveFlag' => 1)); 
                $distinctEmpOfCollectionPayment = $this->get(CustomerConstant::SERVICE_CUSTOMER)->findDistinctEmpOfPaymentCollection();
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_REVENUE_REPORT, array('employee' => $employee, 'distinctEmpOfCollectionPayment' => $distinctEmpOfCollectionPayment)));             
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_revenue_report.twig                              
     * @Route("/customer/search_revenue_report", name="_search_revenue_report") 
     */
      public function searchRevenueReportAction(Request $request) 
      {   
           try{   
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->searchRevenueReport($request); 
                $employee = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employementTypeFk' => 1, 'recordActiveFlag' => 1)); 
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_REVENUE_REPORT_SEARCH_RESULT, array('result' => $result, 'employee' => $employee)));             
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    /**
     * This method is used to delete selected Customer(i.e set Record active flag to 0                     
     * @Route("/deletecustomer/{custid}", name="_deletecustomer") 
     */
    public function DeleteCustomerAction($custid){
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->DeleteCustomer($custid);
            if ($result['code']== 1) {
                $this->erpMessage->setSuccess(true);         
            } else {
                $this->erpMessage->setSuccess(false);                    
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    }
    /**
     * This method is used to search customer to validate no duplicate value
     * is entered ( E.g: Customer, Proprietor & Directors )
     * use by
     *     cim_home.html.twig	
     * @Route("/searchCustomer", name="_erpcim_search_customer")
     */
    public function searchCustomerAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchCustomer');
	if($accessRight==1){
            try {                
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_SEARCH));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
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
    /**
     * This method is used to Load Customer Detail Form Using
     * use by
     *          cim_home.html.twig                              
     * @Route("/cimLoadCustomerDetailForm/{pkid}}", name="_load_cus_detailForm") 
     */
      public function cimLoadCustomerDetailFormAction($pkid) 
      {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchCustomer');
	if($accessRight==1){
            try{
            $em = $this->getDoctrine()->getManager();                
                $customerDetailInfo = $em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findOneBy(array('customerFk' => $pkid));
                $primaryContactMobileInfo = $em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneByContact($customerDetailInfo);
                $addressType = $em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findAll();
                $contactSearchParam = $this->em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor' => 2));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage("success");
                $addressInfo = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->listAddressOrderByType($pkid, CommonConstant::ENT_CUS_ADD_TXN);
                $contactList = $this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$pkid,'recordActiveFlag'=>1));
                $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contactList,'recordActiveFlag'=>1));
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_CAPTUREALL_VIEW, array('customerDetailInfo' => $customerDetailInfo, 'primaryContactMobileInfo' => $primaryContactMobileInfo,
                            'addressType' => $addressType, 'contactSearchParam' => $contactSearchParam, 'contactInfo' => $contactInfo,
                            'mode' => 'EDT','addressinfo'=>$addressInfo)));              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          customerSearchResult.html.twig                              
     * @Route("/customer/laod_cus_advance_payment_form/{pkid}", name="_load_cus_advance_payment_form") 
     */
      public function cimLoadCusAdvancePaymentFormAction(Request $request, $pkid) 
      {    
           $dataUI = json_decode($request->getContent());
           $key = $dataUI->key; 
           try{ 
                $session=$this->getRequest()->getSession();
                $em=$this->getDoctrine()->getManager();
                $empid=$session->get('EMPID');
                $lastTranDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'RCPT','recordActiveFlag'=>1));
                $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1)); 
                $customer=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($pkid);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_FORM, 
                        array('paymentMode' => $paymentMode, 'cusPkid' => $customer->getCustomerIdPk(), 
                            'key' => $key,'tranDate'=>$lastTranDate)));               
                $this->erpMessage->setSuccess(true);  
                $this->erpMessage->setJsonData($pkid);
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                
             }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);      
    }
    
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_payment_form.html.twig                              
     * @Route("/customer/load_account_source_type", name="_load_account_source_type") 
     */
      public function loadAccountSourceAction(Request $request) 
      {     
           $key = $request->request->get('key');  
           $session = $this->getRequest()->getSession(); 
           $emp_id = $session->get('EMPID');          
           $branch_id = $this->get(CommonConstant::SERVICE_COMMON)->getBranchIdByGivingEmpId($emp_id);  
           try{    
                switch($key){
                    case 'cash': $accountList = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag' => 1, 'branchOfficeCode' => $branch_id)); 
                                 if($accountList){
                                     $current_cash_bal = $accountList->getCurrentAmount();
                                 }else{
                                     $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->createNewCashAccount($branch_id);  
                                     $current_cash_bal = 0;
                                 }                    
                                 $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_LOAD_ACCOUNT_SOURCE_LIST, array('accountList' => $accountList, 'key' => $key)));  
                                 break;
                    case 'bank': $accountList = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findBy(array('recordActiveFlag' => 1)); 
                                 $current_cash_bal = '';
                                 $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_LOAD_ACCOUNT_SOURCE_LIST, array('accountList' => $accountList, 'key' => $key))); 
                                 break;
                }      
                $this->erpMessage->setJsonData(array('key' => $key, 'current_cash_bal' => $current_cash_bal));
                $this->erpMessage->setSuccess(true);               
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
             }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);      
    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_payment_form.html.twig                              
     * @Route("/customer/load_current_bank_balance", name="_load_current_bank_balance") 
     */
      public function loadBankCurentBalanceAction(Request $request) 
      {     
           $bankPkid = $request->request->get('bankPkid');  
           try{   
                $bankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($bankPkid);         
                $this->erpMessage->setJsonData(array('bank_current_balace' => $bankObj->getCurrentAmount()));
                $this->erpMessage->setSuccess(true);               
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
             }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);      
    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          scustomerSearchResult.html.twig                              
     * @Route("/customer/save_advance_payment", name="_save_advance_payment") 
     */
      public function saveCusAdvancePaymentAction(Request $request) 
      {     $dataUI = json_decode($request->getContent());  
            $key = $dataUI->key;  
            $amt=$dataUI->txt_advance_amount;  
            $amtWord=$this->get(CommonConstant::SERVICE_COMMON)->NumberToWords($amt);
            $save_from_approval_page = $dataUI->txt_page_identified_key;     
           try{   
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->saveCusAdvancePayment($request);                
                $findCompany = $this->em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findOneBy(array('recordActiveFlag' => 1));
                $code = 0;
                if($findCompany){
                    $code = 1;
                    $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->findBy(array('customerFk' => $result['customer_id'], 'recordActiveFlag' => 1), array('createdDate' => 'DESC'));
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_HISTORY, array('cusAdvPayObj' => $cusAdvPayObj, 'key' => $key))); 
                    if($save_from_approval_page !== ''){ 
                       $pendingApprovalCusAdvPayment = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)
                                    ->findBy(array('paymentStatus' => 'C', 'recordActiveFlag' => 1));                 
                       $this->erpMessage->setSecondHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_LOAD_LIST,array('pendingApprovalCusAdvPayment' => $pendingApprovalCusAdvPayment)));
                    }
                    //customer advance payment receipt page printDetails
                    
//                    $this->erpMessage->setPage($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_RECEIPT,
//                                            array('cusInfo' => $result['printDetails']['cusInfo'], 
//                                                  'advanceRecieptDetails' => $result['printDetails']['advanceRecieptDetails'], 
//                                                  'companyDetails' => $result['printDetails']['companyDetails'],
//                                                  'companyAddress' => $result['printDetails']['companyAddress'],
//                                                  'companyEmail' => $result['printDetails']['companyEmail'],
//                                                  'companyContact' => $result['printDetails']['companyContact']
//                                            )));
                    $address=$result['printDetails']['companyAddress'];                    
                    $emp=$result['printDetails']['employee'];
                    $mobArr=$result['printDetails']['companyContact'];
                    $phoneArr=$result['printDetails']['Phone'];                    
                    $receipt=$result['printDetails']['receipt'];
                    $cusAddTxn=$result['printDetails']['cusInfo'];                    
                    $paymodeArr=$this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
                    
                    $this->erpMessage->setPage($this->renderView(CustomerConstant::TWIG_RECEIPT,
                            array('compAdd'=>$address,'receipt'=>$receipt,'custAdd'=>$cusAddTxn,'employee'=>$emp,
                                'mobArr'=>$mobArr,'phoneArr'=>$phoneArr,'amt'=>$amt,'amtword'=>$amtWord,'paymodeArr'=>$paymodeArr)));
                    $this->erpMessage->setMessage($result['msg']);
                    $result['save_from_approve_page'] = $save_from_approval_page;
                }else{
                    $this->erpMessage->setMessage('Company Detail not found. Please enter company detail first. Goto Company->Add Details to enter.');
                }
                //no of pending approval
                $pendingHodApprovalCount=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->GetPendingHodPaymentCount();
                if($pendingHodApprovalCount){
                    $apprCount=$pendingHodApprovalCount[0][1];
                }
                $result['apprCount'] = $apprCount;
                $result['code'] = $code;
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);           
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          scustomerSearchResult.html.twig                              
     * @Route("/customer/edit_advance_payment/{advancePaymentPk}", name="_edit_advance_payment") 
     */
      public function editAdvancePaymentAction(Request $request,$advancePaymentPk) 
      {  
          $dataUI = json_decode($request->getContent());
          $key = $dataUI->key; 
           try{                   
                $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($advancePaymentPk); 
                $cusPkid = $cusAdvPayObj->getCustomerFk()->getCustomerIdPk();
                switch($key){ 
                    case 'E':$return_Arr = array(
                                    'key' => 'E',
                                    'cusID' => $cusPkid,
                                    'advancePaymentID' => $advancePaymentPk,
                                    'advanceAmount' => $cusAdvPayObj->getAdvanceAmount(),
                                    'paymentDate' => date_format($cusAdvPayObj->getCreatedDate(), 'Y-m-d'),
                                    'paymentNo' => $cusAdvPayObj->getPaymentNo(),
                                    'description' => $cusAdvPayObj->getDescription(),
                                    'paymentModeID' => $cusAdvPayObj->getPaymentModeFk()->getPkid(),
                                    'enterAccountId'=>$cusAdvPayObj->getAmountEnterAccountId()
                                ); 
                             if($cusAdvPayObj->getPaymentModeFk()->getPkid() == 1){
                                    $selectedAccount = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
                              }else{
                                  $selectedAccount = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1)); 
                              }
                             $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_LOAD_ACCOUNT,
                                      array('selectedAccount'=>$selectedAccount,'paymentModeID'=>$cusAdvPayObj->getPaymentModeFk()->getPkid())));
                                
                             break;
                            
                    case 'D':   $cusAdvPayObj->setRecordActiveFlag(0);
                                $cusAdvPayObj->setRecordUpdateDate(new \DateTime('now'));
                                $this->em->flush();
                                $return_Arr = array('key' => 'D');
                                $this->erpMessage->setMessage('Deleted Advance Payment record successfully.'); 
                                break;
                    case 'print':
                                $receipt=$this->getDoctrine()->getManager()->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT_RECEIPT)->findOneByAdvancePaymentFk($advancePaymentPk);
                                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->printCusAdvancePayReceipt($cusPkid, $advancePaymentPk,$receipt);  
                                $address=$result['companyAddress'];                    
                                $emp=$result['employee'];
                                $mobArr=$result['companyContact'];
                                $phoneArr=$result['Phone'];                    
                                //$receipt=$result['receipt'];
                                $cusAddTxn=$result['cusInfo'];   
                                $amt=$receipt->getAdvancePaymentFk()->getAdvanceAmount();
                                $amtWord=$this->get(CommonConstant::SERVICE_COMMON)->NumberToWords($amt);
                                $paymodeArr=$this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));

                                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_RECEIPT,
                                    array('compAdd'=>$address,'receipt'=>$receipt,'custAdd'=>$cusAddTxn,'employee'=>$emp,
                                    'mobArr'=>$mobArr,'phoneArr'=>$phoneArr,'amt'=>$amt,'amtword'=>$amtWord,'paymodeArr'=>$paymodeArr)));
//                                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_RECEIPT,
//                                        array('cusInfo' => $result['cusInfo'], 
//                                              'advanceRecieptDetails' => $result['advanceRecieptDetails'], 
//                                              'companyDetails' => $result['companyDetails'],
//                                              'companyAddress' => $result['companyAddress'],
//                                              'companyEmail' => $result['companyEmail'],
//                                              'companyContact' => $result['companyContact']
//                                        )));                                
                                $return_Arr = array('key' => 'print');
                                break;
                    
                }
                               
                $this->erpMessage->setJsonData($return_Arr);
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    
    /**
     * This method is used to Load Customer Advance Payment Form Using
     * use by
     *          cus_advance_payment_form.html.twig                              
     * @Route("/customer/view_advance_payment_history/{cusID}", name="_view_advance_payment_history") 
     */
      public function viewCusAdvancePaymenthistoryAction(Request $request,$cusID) 
      {   $dataUI = json_decode($request->getContent());
          $key = $dataUI->key;
           try{    
                $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->findBy(array('customerFk' => $cusID, 'recordActiveFlag' => 1), array('createdDate' => 'DESC'));
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_ADVANCE_PAYMENT_HISTORY, array('cusAdvPayObj' => $cusAdvPayObj, 'key' => $key)));             
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    /**
     * This method is used to Show Customer Outstanding Bill
     * use by
     *          cus_advance_payment_form.html.twig                              
     * @Route("/customer/outstandingbill/{cusID}", name="_showoutstandingbill") 
     */
      public function ShowOutstandingBillAction($cusID) 
      {   
            try{    
                $em=$this->getDoctrine()->getManager();
                $invoiceArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoiceByCustId($cusID);
                $payArr=$em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->GetInvoicePaymentByCustId($cusID);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUS_OUTSTANDING_BILL, 
                        array('invoiceArr' => $invoiceArr, 'payArr' => $payArr)));             
                $this->erpMessage->setSuccess(true);              
            }
            catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    
    /**                                 
     * @Route("/cimviewaddress/{addtxnid}/{custid}", name="_cimviewaddress") 
     */
    public function cimViewAddress($addtxnid,$custid) 
    {

            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();       
            $em = $this->getDoctrine()->getManager();            
            $addtxn=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($addtxnid);            
                   
            if($addtxn){
                $country = $em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('recordActiveFlag'=>1),array('countryName'=>'ASC'));
                $stateArr = $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findByCountryCodeFk($addtxn->getAddressFk()->getCountryCodeFk()->getCountryPk());                
                $districtArr = $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findByStateFk($addtxn->getAddressFk()->getStateCodeFk()->getStatePk());
                $city='';
                $district=$addtxn->getAddressFk()->getDistrictFk();
                if($district){
                    $city=$em->getRepository(CommonConstant::ENT_CITY_MASTER)->findByDistrictFk($addtxn->getAddressFk()->getDistrictFk()->getPkid());
                }
                
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_ADDFORM, 
                        array('country'=>$country,'state'=>$stateArr,'district'=>$districtArr,'addtxn'=>$addtxn,'custid'=>$custid,'city'=>$city)));
            }
            else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Unable to load Address detail.');            
            }
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);   
  
    }
    
    /**
     * This method is used to soft delete Address of a customer                          
     * @Route("/cimDeleteCustAddress/{addtxnid}/{custid}", name="_erpcim_del_cust_address") 
     */
    public function cimDeleteCustAddressAction($addtxnid,$custid){        

            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $em=$this->getDoctrine()->getManager();
            $isPrimary=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('pkid'=>$addtxnid,'isPrimaryAddress'=>1));
            if($isPrimary){
                $this->erpMessage->setMessage('You cannot delete a Primary Address. If you wish to delete this address then you must first set/add another address as primary.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->CimDeleteAddress($addtxnid);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true);
                $addressInfo=$em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findBy(array('customerFk'=>$custid,'approvalFlag'=>1,'recordActiveFlag'=>1),array('isPrimaryAddress'=>'DESC','addressCode'=>'ASC'));
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUSTOMER_ADDRESS_ATTRIBUTE,array('addressinfo' => $addressInfo)));
            }
            else{
                $this->erpMessage->setSuccess(false);                
            }
            $this->erpMessage->setMessage($result['msg']);
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**   
     * This method is used to load state list  for the selected Country
     * @Route("/loadstate", name="_erp_load_statelist")
     *  
     */
    public function LoadStateListAction(Request $request) {

            try{
                $em=$this->getDoctrine()->getManager();   
                $dataUI = json_decode($request->getContent());
                $countrycode = $dataUI->countryId;
                $states=$em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBycountryCodeFk($countrycode,array('stateName' => 'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_STATE_LIST,array('state'=>$states)));
            }
            catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    } 
    /**
     * This method is used to load district list  for the given state             
     * @Route("/loadDistrictList", name="_erp_load_districtlist")
     */
    public function loadDistrictListAction(Request $request) {
        
            try{
                $em=$this->getDoctrine()->getManager();   
                $dataUI = json_decode($request->getContent());
                $stateId = $dataUI->stateId;
                $districtlist=$em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBystateFk($stateId,array('districtName' => 'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CUSTOMER_DISTRICT_LIST,array('district'=>$districtlist)));
            }
            catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    } 
    
    /**
     * This method is used to load city             
     * @Route("/loadcity", name="_erp_load_citylist")
     */
    public function loadCityListAction(Request $request) {

            try{
                $em=$this->getDoctrine()->getManager();   
                $dataUI = json_decode($request->getContent());
                $distid = $dataUI->districtId;
                $city=$em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBydistrictFk($distid,array('cityName' => 'ASC'));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CITY_LIST,array('city'=>$city)));
            }
            catch(\Exception $ex){
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    } 
    
    /**
     * This method is used to view or create new contact
     * 
     * @Route("/contactperson/{mode}/{contactid}/{custid}", name="_contactperson")
     */
    public function ContactPersonAction($mode,$contactid, $custid){        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        if($mode=='EDT'){
            $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditCustomer');
            if($accessRight!=1){
                $this->erpMessage->setJsonData('AD');
                $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
                goto _exitcontperson;
            }
        }
        try{
            $conmobtxn=null;
            if($mode=='EDT'){          
                $em = $this->getDoctrine()->getManager();                
                $conmobtxn=$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneBy(array('contact'=>$contactid,'recordActiveFlag'=>1));
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_FORM_CONTACT_DETAILS, array('mode' => $mode,'contactinfo'=>$conmobtxn,'custid' => $custid)));
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
        }
        _exitcontperson:
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }    
    
    /**
     * This method is used to create contact person's detail of a customer                  	             
     * @Route("/addupdatecontactperson", name="_saveconntactperson")
     */
    public function insertContactDetails1Action(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateCustomer');
	if($accessRight==1){
            $dataUI=  json_decode($request->getContent());
            $isPrimary=$dataUI->selPrimaryContact;
            $custid=$dataUI->inputcustId;
            $emailid=$dataUI->emailId;
            $mobno=$dataUI->mobileNo;
            $em=$this->getDoctrine()->getManager();
            $primaryContacts=$em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid,'isPrimaryContact'=>1));
            if(!$isPrimary && !$primaryContacts){            
                $this->erpMessage->setMessage('Every customer must have one primary contact.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            $mobileNoCheck=$em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->findBy(array('mobileNo'=>$mobno,'recordActiveFlag'=>1));
            if($mobileNoCheck){
                $this->erpMessage->setMessage('Mobile Number already in used. Please use a different Number.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            if(!empty($emailid)){
            $emailCheck=$em->getRepository(CommonConstant::ENT_CONTACT_PERSON_MASTER)->findBy(array('emailId'=>$emailid,'recordActiveFlag'=>1));
                if($emailCheck){
                    $this->erpMessage->setMessage('Email already in used. Please use a different Email Id.');
                    $this->erpMessage->setSuccess(false); 
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }
            }
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->insertContactFormDetails($dataUI);
            if($result['code']==1){
                $contactList = $this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
                $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contactList,'recordActiveFlag'=>1));
                $this->erpMessage->setSuccess(true);    
                $this->erpMessage->setMessage('Contact detail has been added successfully.');
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_LOAD_CONTACT_DETAILS,array('contactInfo'=>$contactInfo,'custid'=>$custid)));
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
     * This method is used to delete customer contact
     * 
     * @Route("/deletecontactperson/{contactid}/{custid}", name="_deletecontactperson")
     */
    public function DeleteContactPersonAction($contactid,$custid){        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{  
            $em=$this->getDoctrine()->getManager();
            $contact=$em->getRepository(CommonConstant::ENT_CONTACT_TXT)->find($contactid);
            if($contact){
                if($contact->getIsPrimaryContact()){
                    $this->erpMessage->setMessage('You cannot delete a primary contact.');
                    $this->erpMessage->setSuccess(false); 
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }
            }
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->DeleteContact($contactid);
            if($result['code']==1){
                $contactList = $this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
                $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contactList,'recordActiveFlag'=>1));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_LOAD_CONTACT_DETAILS,array('contactInfo'=>$contactInfo,'custid'=>$custid)));
            }else{
                $this->erpMessage->setSuccess(false);
            }  
            $this->erpMessage->setMessage($result['msg']);
        }catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
        }
        _exitcontperson:
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * This method will update contact person's detail of a customer                  	             
     * @Route("/updatecontact", name="_updatecontact")
     */
    public function UpdateContactAction(Request $request) {        
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EditCustomer');
	if($accessRight==1){
            $dataUI=  json_decode($request->getContent());
            $isPrimary=$dataUI->selPrimaryContact;
            $contactid=$dataUI->inputcontId;
            $custid=$dataUI->inputcustId;
            $emailid=$dataUI->emailId;
            $mobno=$dataUI->mobileNo;
            $em=$this->getDoctrine()->getManager();
            $primaryContacts=$em->getRepository(CommonConstant::CUSTOMER_DETAIL)->FindOtherPrimaryContact($contactid,$custid);
            if(!$isPrimary && !$primaryContacts){            
                $this->erpMessage->setMessage('Every customer must have one primary contact.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            $mobileNoCheck=$em->getRepository(CommonConstant::CUSTOMER_DETAIL)->CheckOtherMobileExist($contactid,$mobno);
            if($mobileNoCheck){
                $this->erpMessage->setMessage('Mobile Number already in used. Please use a different Number.');
                $this->erpMessage->setSuccess(false); 
                $jsondata = $serializer->serialize($this->erpMessage, 'json');
                return new Response($jsondata);
            }
            if(!empty($emailid)){
                $emailCheck=$em->getRepository(CommonConstant::CUSTOMER_DETAIL)->CheckOtherEmailExist($contactid,$emailid);
                if($emailCheck){
                    $this->erpMessage->setMessage('Email already in used. Please use a different Email Id.');
                    $this->erpMessage->setSuccess(false); 
                    $jsondata = $serializer->serialize($this->erpMessage, 'json');
                    return new Response($jsondata);
                }
            }
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->UpdateContact($dataUI);
            if($result['code']==1){
                $contactList = $this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
                $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contactList,'recordActiveFlag'=>1));
                $this->erpMessage->setSuccess(true);    
                $this->erpMessage->setMessage('Contact detail has been added successfully.');
                $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_LOAD_CONTACT_DETAILS,array('contactInfo'=>$contactInfo,'custid'=>$custid)));
            }
            else{
                $this->erpMessage->setSuccess(false);                        
            }
            $this->erpMessage->setMessage($result['msg']); 
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /************************CUSTOMER COMMUNICATION********************************/
    /**
    * This method is used to navigate to Search Customer Page for Communication. 
    * @Route("/comsearchcustindex", name="_comsearchcustindex")
    */
    public function ComSearchCustIndexAction(){
        
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_COM_CUST_SEARCH_INDEX));
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
        
    }
    /**
     * This method is used to search customers for communication purpose
     * @Route("/comsearchcust", name="_comsearchcust")
     */
    public function ComSearchCustomerAction(Request $request){
        
            try{          
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->SearchCustomerforComm($request);         
                if (!$result) 
                {
                    $this->erpMessage->setMessage('No data Found');
                    $this->erpMessage->setSuccess(false);
                } 
                else 
                {
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setMessage('');
                    //$this->erpMessage->setMessage($result);
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_COM_CUST_SEARCH_RESULT, array('mobtxn' => $result)));
                }
            }
            catch (\Exception $ex) 
            {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * @Route("/commessagetemplate/{comtype}", name="_commessagetemplate")
     */
    public function commessagetemplatection(Request $request,$comtype){
        
            try{          
                $dataUI=  json_decode($request->getContent());
                $mobnos=array();
                $custIds=array();
                $emails=array();
                $contactId=array();
                $isSelected=$dataUI->inputisSelected;
                $mobnofromui=$dataUI->inputComMobno;  
                $custIdfromui=$dataUI->inputComCustId;  
                $emailfromui=$dataUI->inputComEmail;  
                $contactidsfromui=$dataUI->inputComContId;
                if(is_array($isSelected)){
                    for($i=0;$i<count($isSelected);$i++){
                        if($isSelected[$i]){
                            array_push($mobnos, $mobnofromui[$i]);
                            array_push($emails, $emailfromui[$i]);
                            array_push($custIds, $custIdfromui[$i]);
                            array_push($contactId, $contactidsfromui[$i]);
                        }
                    }
                }
                else{
                    array_push($mobnos, $mobnofromui);
                    array_push($emails, $emailfromui);
                    array_push($custIds, $custIdfromui);
                    array_push($contactId, $contactidsfromui);
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage('');
                //$this->erpMessage->setMessage($result);
                if(strcasecmp($comtype, 'sms')==0){
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_COM_SMS_TEMPLATE, 
                            array('mobilenos' => $mobnos,'custids'=>$custIds,'contactids'=>$contactId)));
                }
                elseif(strcasecmp($comtype, 'email')==0){
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_COM_SEND_EMAIL,
                            array('emails'=>$emails,'custids'=>$custIds,'contactids'=>$contactId)));
                }
            }
            catch (\Exception $ex) 
            {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    }
    /**
     * This method is used to load and display existing communication history for a particular customer
     * @Route("/viewcommhistory/{custid}/{mobtxnid}", name="_viewcommhistory")
     * 
     */
    public function ViewCommunicationHistoryAction($custid,$mobtxnid){
        
            try{ 
                $mobtxn=$this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->find($mobtxnid);
                $comtxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->
                        findBy(array('customerFk'=>$custid,'approvalFlag'=>1,'recordActiveFlag'=>1),
                                array('sentDatetime'=>'DESC'));
                $this->get(CustomerConstant::SERVICE_CUSTOMER)->UpdateBulkSmsDeliveryStatus($custid);
                $comtxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->
                        findBy(array('customerFk'=>$custid,'approvalFlag'=>1,'recordActiveFlag'=>1),
                                array('sentDatetime'=>'DESC'));
                if($comtxn){
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_COM_COMM_HISTORY,array('mobtxn'=>$mobtxn,'comtxn'=>$comtxn)));
                }
                else{
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No Communication History exist for the selected customer.');
                }                
            } catch (Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            }            
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * @Route("/sendsms}", name="_sendsms")
     */
    public function SendSMSAction(Request $request){
        
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->SendSMS($request);
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
    }
    /**
     * This method will send mail to all selected email
     * @Route("/sendemail", name="_sendemail")
     */
    public function SendEmailAction(Request $request){        
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->SendEmail($request);
            if($result['code']==1){
                $this->get('swiftmailer.command.spool_send')->run(new ArgvInput(array()), new ConsoleOutput());
                $this->erpMessage->setSuccess(true);   
                $files=$result['files'];
                foreach($files as $file){
                    unlink($file);
                }
            }
            else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
            
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);
    }
    /**
     * @Route("/checksmsdeliverystatus/{smsid}", name="_checksmsdeliverystatus")
     */
    public function CheckSMSDeliveryStatusAction($smsid){
        
            $result=$this->get(CustomerConstant::SERVICE_CUSTOMER)->CheckSMSDeliveryStatus($smsid);
            if($result['code']==1){
                $this->erpMessage->setSuccess(true); 
                $this->erpMessage->setHtml($result['status']);
            }
            else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Unable to check delivery status. Please check your internet connectivity and try again.Error: '.$result['msg']);
            }     
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $jsondata = $serializer->serialize($this->erpMessage, 'json');
            return new Response($jsondata);

    } 
    
    
    /**
     * This method is used to search customer and list the result
     * is entered ( E.g: Customer, Proprietor & Directors )
     * use by
     *     cim_home.html.twig	
     * @Route("/searchCustmr/{key}", name="_erplms_cim_search_customer_viewinformation")
     */
    public function searchCustmrAction(Request $request, $key) {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewSearchCustomer');
	if($accessRight==1){
            try{          
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->SearchCustomer($request);         
                if ($result == false) 
                {
                    $this->erpMessage->setMessage('No data Found');
                    $this->erpMessage->setSuccess(false);
                } 
                else 
                {
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setMessage('');
                    //$this->erpMessage->setMessage($result);
                  
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_SEARCH_RESULT, array('result' => $result, 'key' => $key)));
                }
            }
            catch (\Exception $ex) 
            {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * This method is used to create a customer with all credentials
     * use by
     *          cim_home.html.twig                              
     * @Route("/cimCreateCustomer/{attrib}/{value}", name="_erpcim_create_customer") 
     */
    public function cimCreateCustomerAction($attrib,$value) {
        
            $em = $this->getDoctrine()->getManager();
            $cusType = $em->getRepository(CommonConstant::CUSTOMER_TYPE_MASTER)->findAll();
            return $this->render(CustomerConstant::TWIG_CIM_CREATE_CUSTOMER,array('cust'=>$cusType,'attrib'=>$attrib,'value'=>$value));                
 
    }
        
        /**
     * This method is used to create a customer with all credentials
     * use by
     *          cim_home.html.twig                              
     * @Route("/cimCreateNewCustomer", name="_erplms_cim_createNewCustomer") 
     */
    public function cimCreateNewCustomerAction(Request $request) {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateCustomer');
	if($accessRight==1){
            try {
                $dataUI = json_decode($request->getContent());
                $cusName = $dataUI->txtCustomerName;
                $cusContactperson = $dataUI->txtContactPerson;
                $em = $this->getDoctrine()->getManager();
                $customerSearchList = $em->getRepository(CommonConstant::CUSTOMER_DETAIL)->listOfCustomerLike($cusName,$cusContactperson);
                $mobileNOs = $em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->findBy(array('mobileNo'=>$dataUI->txtcontactMobNo,'recordActiveFlag'=>1));
                if ($mobileNOs) {
                    $this->erpMessage->setMessage("Mobile Already In Use For Contact");
                    $searchCustomerList='';
                    foreach($mobileNOs as $key=>$customerLike){
                        $searchCustomerList[$key] = $em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneByMobileNo($customerLike);
                    }
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_LIKE_SEARCH_LIST, array('result' => $searchCustomerList)));
                    $this->erpMessage->setSuccess(false);
                } elseif ($customerSearchList) {
                     /*---logic to play around for like Search in Name */
                     $searchCustomerList='';
                    foreach($customerSearchList as $key=>$customerLike){
                        $customerPrimary = $em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findOneBy(array('customerFk'=>$customerLike,'isPrimaryContact'=>1));
                        $searchCustomerList[$key] = $em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneByContact($customerPrimary);
                    }
                    $this->erpMessage->setMessage("Customer/Contact Person  With Same Name Exist");
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_LIKE_SEARCH_LIST, array('result' => $searchCustomerList)));
                    $this->erpMessage->setSuccess(false);
                } else {
                    $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->CreateCustomer($request);
                    if($result['code']==1) {
                        $session = $this->getRequest()->getSession();
                        $custdetail = $em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($session->get('customerId'));
                        $customerDetailInfo = $em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findOneBy(array('customerFk'=>$session->get('customerId'),'isPrimaryContact'=>1));
                        $primaryContactMobileInfo = $em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneByContact($customerDetailInfo);
                        //$customerType = $em->getRepository(CommonConstant::CUSTOMER_TYPE_MASTER)->findAll();
                        $addressType = $em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findAll();
                        $contactSearchParam = $this->em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor'=>2));
                        $this->erpMessage->setSuccess(true);
                        $addressInfo = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->listAddressOrderByType($session->get('customerId'), CommonConstant::ENT_CUS_ADD_TXN);
                        $contactList=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findByCustomerFk($session->get('customerId'));
                        $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findByContact($contactList);
                        $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_CAPTUREALL_VIEW,
                            array('customerDetailInfo' => $customerDetailInfo,'primaryContactMobileInfo'=>$primaryContactMobileInfo,
                                    'addressType' => $addressType, 'contactSearchParam'=>$contactSearchParam,'contactInfo'=>$contactInfo,'addressinfo'=>$addressInfo,
                                    'mode' => 'INS')));
                    }
                    else{
                        $this->erpMessage->setSuccess(false);
                    }
                    $this->erpMessage->setMessage($result['msg']);
                }
            } catch (\Exception $ex) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * This method is used to create a customer with all credentials
     * use by
     *          cim_home.html.twig                              
     * @Route("/cimSaveCustomerAfterConfirmAction", name="_erplms_cim_create_customer_after_confirmation") 
     */
    public function cimSaveCustomerAfterConfirmAction(Request $request) {        
        try {
            $dataUI = json_decode($request->getContent());
            $em = $this->getDoctrine()->getManager();
            $mobileNOs = $em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->findByMobileNo($dataUI->txtcontactMobNo);
            $searchCustomerList='';
            if ($mobileNOs) {
                $searchCustomerList = '';
                foreach ($mobileNOs as $key => $customerLike) {
                    if ($em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneBy($customerLike)->getContact()->getCustomerFk()->getCustomerName() == $dataUI->txtCustomerName) {
                        $searchCustomerList = 1;
                        break;
                    }
                }
            }
            if ($searchCustomerList) {
                $this->erpMessage->setMessage("Customer With The Same Name And Mobile Number Exist!");
                $this->erpMessage->setSuccess(false);
            } else {
                $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->CreateCustomer($request);
                if ($result == false) {
                    $this->erpMessage->setMessage("failed");
                    $this->erpMessage->setSuccess(false);
                } else {
                    $session = $this->getRequest()->getSession();
                    //$custdetail = $em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($session->get('customerId'));
                    $customerDetailInfo = $em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findOneBy(array('customerFk' => $session->get('customerId'), 'isPrimaryContact' => 1));
                    $primaryContactMobileInfo = $em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneByContact($customerDetailInfo);
                    $customerType = $em->getRepository(CommonConstant::CUSTOMER_TYPE_MASTER)->findAll();
                    $addressType = $em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findAll();
                    $contactSearchParam = $this->em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor' => 2));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setMessage("success");
                    $addressInfo = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->listAddressOrderByType($session->get('customerId'), CommonConstant::ENT_CUS_ADD_TXN);
                    $contactList=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findByCustomerFk($session->get('customerId'));
                    $contactInfo = $this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findByContact($contactList);
                    $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_CAPTUREALL_VIEW, array('customerDetailInfo' => $customerDetailInfo, 'customerType' => $customerType, 'primaryContactMobileInfo' => $primaryContactMobileInfo,
                                'addressType' => $addressType, 'contactSearchParam' => $contactSearchParam,'contactInfo'=>$contactInfo,
                                'mode' => 'INS', 'addressinfo'=>$addressInfo)));
                }
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
        
     
    
        
     /**
     * This method is used to Load New Customer Add Form a customer with all credentials 
     *  Pre Assumption is that it would be used only for 
     *       1.Customer
     *       2.Creation Only-----   
     * use by
     *          loadCustomerApprv_form                             
     * @Route("/cimLoadAddForm/{custid}/{addType}/{typeIdentifierForAddress}", name="_loadAddForm") 
     */
    public function cimLoadAddFormAction($custid,$addType,$typeIdentifierForAddress) 
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('CreateCustomer');
//	if($accessRight==1){
            
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage("success");
            $em = $this->getDoctrine()->getManager();
            $selectedAddressType = $em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addType);
//            $city = $em->getRepository(CommonConstant::ENT_CITY_MASTER)->findAll();
//            $state = $em->getRepository(CommonConstant::ENT_STATE_MASTER)->findAll();
//            $district = $em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findAll(array('recordActiveFlag'=>1),array('countryName'=>'ASC'));
            $country = $em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findBy(array('recordActiveFlag'=>1),array('countryName'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(CustomerConstant::TWIG_CIM_CUS_ADDFORM, 
                    array('selectedAddressType' => $selectedAddressType,'country'=>$country,
                          'state'=>array(),'district'=>array(),'city'=>array(),'addressDetail'=>'','typeIdentifierForAddress'=>$typeIdentifierForAddress,
                          'custid'=>$custid)));
//        }else{
//            $this->erpMessage->setSuccess(true);
//            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }      
      
     
     /**
     * This method is used to Load New Customer Approval Form a customer with all credentials
     * use by
     *          loadCustomerApprv_form                             
     * @Route("/cimApproveNewCustomer", name="_erpcim_apprv_new_customer") 
     */
    public function cimApproveNewCustomerAction() 
    {       
               
            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->getPendingCus();             
            return $this->render(CustomerConstant::TWIG_CIM_APPRV_CUSTOMER_FORM, array('result' => $result));                     
    }
     /**
     * This method is used to Load Customer change Approval Approval Form
     * use by
     *          cus_changeAttr_form.html                            
     * @Route("/cimChangeCustomerAttrform", name="_erpcim_change_customer_attrForm") 
     */
    public function cimChangeCustomerAttrformAction() {
              
               // $em = $this->getDoctrine()->getManager();
               // $cusSearchParam = $em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor' => 1, 'moduleFlag' => 1, 'recordActiveFlag' => 1));
               // $cusTypeList = $em->getRepository(CommonConstant::ENTITY_ERP_CIM_CUSTOMERTYPE)->findBy(array('recordActiveFlag' => 1));

            return $this->render(CustomerConstant::TWIG_CIM_CUS_CHNGE_ATTR_FORM);
    }
        
     /**
     * This method is used to Load Customer Change Attribute Approval 
     * use by
     *          cus_changeAttr_form.html                            
     * @Route("/cimChangeCustomerAddr", name="_erpcim_change_customer_AddForm") 
     */
    public function cimChangeCustomerAddrformAction() {
        
            // $em = $this->getDoctrine()->getManager();
            // $cusSearchParam = $em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor' => 1, 'moduleFlag' => 1, 'recordActiveFlag' => 1));
            // $cusTypeList = $em->getRepository(CommonConstant::ENTITY_ERP_CIM_CUSTOMERTYPE)->findBy(array('recordActiveFlag' => 1));

             return $this->render(CustomerConstant::TWIG_CIM_CUS_APPRV_ADDR_FORM);
      
    }
        /**
     * This method is used to Load Customer Communication search Form 
     * use by
     *         cim_cusCommunication_Searchform.html                          
     * @Route("/cimCommunicationSearchform", name="_erpcim_cus_Communcatn_SearchForm") 
     */
    public function cimCommunicationSearchformAction() {

            // $em = $this->getDoctrine()->getManager();
            // $cusSearchParam = $em->getRepository(CommonConstant::ENTITY_ERP_CMN_SEARCH_PARAM)->findBy(array('searchFor' => 1, 'moduleFlag' => 1, 'recordActiveFlag' => 1));
            // $cusTypeList = $em->getRepository(CommonConstant::ENTITY_ERP_CIM_CUSTOMERTYPE)->findBy(array('recordActiveFlag' => 1));

             return $this->render(CustomerConstant::TWIG_CIM_CUS_COMM_SEARCH_FORM);
  
    }
        /*   ########################  Contact Controller ###################################   */

    /**
     * This method is used to search contact and display if exist in list, if not : create new contact
     * use by
     *        customer_create.html.twig	    
     *  @Route("/searchForContactCreation", name="_erplms_search_for_contact_creation")
     * 
     * @param Request $request Data contained in the URL as a post
     * @return twig LMSConstant::TWIG_CUSTOMER_CONTACT
     * @see LMSConstant 
     * Used JS : on('click','#contactDynamicSearch',function()
     */
    public function searchForContactCreateAction(Request $request) {
        
            $em = $this->getDoctrine()->getManager();
            $dataUI = json_decode($request->getContent());
            $entityName = $dataUI->entityName;
            $fieldValue = $dataUI->fieldValue;
            $fieldName = $dataUI->fieldName;
            $existingList = $this->get(CustomerConstant::SERVICE_CUSTOMER)->searchAnySingleFieldByLike($entityName, $fieldName, $fieldValue);
            $existingContactList=($existingList)?$em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findByMobileNo($existingList):'';
            return $this->render(CustomerConstant::TWIG_CUSTOMER_CONTACT, array('existingList' => $existingContactList,
                        'entityName' => $entityName, 'fieldName' => $fieldName,
                        'fieldValue' => $fieldValue
            ));

    }
    
    
    

}

