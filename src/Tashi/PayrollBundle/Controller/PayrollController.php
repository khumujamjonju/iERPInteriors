<?php

namespace Tashi\PayrollBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\PayrollBundle\Helper\PayrollConstant;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
class PayrollController extends Controller{
    
    private $em;
    protected $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage = new ERPMessage();
    }
    /**
     * @Route ("/payroll/dashboard", name="_payroll_dashboard")
     */
    public function payrollDashboardAction()
    {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('payrollDashboardAction');
        if($accessRight==1){
       try{    
             $pendingApprovalSalary = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->GetTotalNoOfPendingApproveSalarySlip(); 
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_DASHBOARD,array('pendingApprovalSalary' => $pendingApprovalSalary['pendingApprovalSalarySlip'])));
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
    
    /**
     * @Route ("/payroll/emp_salary_master", name="_emp_salary_master")
     */
    public function addnewEmployeeSalaryMasterAction()
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
        if($accessRight==1){
        try{          
              $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');          
              $employment = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpEmploymentType');
              $designation = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpJobTitleMaster');
              $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_CREATE_EMP_SALARY,
                      array('month' => $month,'employment' => $employment, 'designation' => $designation)));
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
    
    /**
     * @Route ("/payroll/master_setting", name="_payrol_master_setting")
     */
    public function payrollMasterSettingAction()
    {           
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
        try{   
              $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('PayrolMaster');           
              $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_MASTER_SETTING,array('result' => $result)));
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
    /**
     * @Route ("/payroll/save_master_setting", name="_save_payrol_percentage_calculation")
     */
    public function savePayrolPercentageCalculationAction(Request $request)
    {           
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
            try{                    
                  $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->savePayrolPercentageCalculation($request);
                  //if record save or update successfully
                  if($result['existing_flag'] == 0){
                     $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_MASTER_LIST, array('result' => $result)));
                  }            
                  $this->erpMessage->setMessage($result['msg']);
                  $this->erpMessage->setJsonData($result);
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
    
    /**
     * @Route ("/payroll/retrive_master_setting/{pkid}", name="_retrive_payrol_percentage_calculation")
     */
    public function retrivePayrolPercentageCalculationAction($pkid)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                    
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->retrivePayrolPercentageCalculation( $pkid );   
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/delete_master_setting/{pkid}", name="_delete_payrol_percentage_calculation")
     */
    public function deletePayrolPercentageCalculationAction($pkid)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
       try{                    
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->deletePayrolPercentageCalculation( $pkid );           
             $this->erpMessage->setMessage($result['msg']);
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
    
    /**
     * @Route ("/payroll/emolument_deduction_master", name="_emolument_deduction_master")
     */
    public function emolumentDeductionMasterAction()
    {      
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('PayrolEmolumentDeductionMaster');              
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_EMOLUMENT_DEDUCTION , array('result' => $result)));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {      
             $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/save_emolument_deduction_master", name="_save_emolument_deduction_master")
     */
    public function saveEmolumentDeductionMasterAction(Request $request)
    {           
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
            try{      
                $dataUI = json_decode($request->getContent());
                $page_type = $dataUI->txt_page_key; 
                $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->saveEmolumentDeductionMaster($request, $page_type);            
                switch($page_type){  
                    case 'normalForm' : $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_EMOLUMENT_DEDUCTION_LIST, array('result' => $result['result'])));                                                          
                                        break;
                    case 'popUpForm' :  switch($result['addFieldType']){
                                             case 'Emolument' :  $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_EMOLUMENTS_LIST, array('singleEmolument' => $result['result'])));
                                                                 break;
                                             case 'Deduction' :  $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_DEDUCTIONS_LIST, array('singleDeduction' => $result['result'])));
                                                                 break;
                                        }                                  
                                        break;
                }    
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);          
                $this->erpMessage->setSuccess(true);
            }catch (\Exception $ex) {
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
     * @Route ("/payroll/retrive_emolument_deduction_master_record/{pkid}", name="_retrive_emolument_deduction_master_record")
     */
    public function retriveEmolumentDeductionMasterRecordAction($pkid)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                    
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->retriveEmolumentDeductionMasterRecord($pkid);                     
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    /**
     * @Route ("/payroll/delete_emolument_deduction_master_record/{pkid}", name="_delete_emolument_deduction_master_record")
     */
    public function deleteEmolumentDeductionMasterRecordAction($pkid)
    {           
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
        if($accessRight==1){
        try{                    
              $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->deleteEmolumentDeductionMasterRecord($pkid);                     
              $this->erpMessage->setMessage($result['msg']);
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
    
    /**
     * @Route ("/payroll/payment_mode", name="_payroll_payment_mode")
     */
    public function paymentModeAction()
    {
           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
             $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnPaymentModeMaster');            
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_PAYMENT_MODE, array('paymentMode' => $result)));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/save_payment_mode", name="_save_payment_mode")
     */
    public function savePaymentModeAction(Request $request)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
        try{                    
              $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->savePaymentMode($request);
              $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_PAYMENT_MODE_LIST, array('result' => $result['result'])));
              $this->erpMessage->setMessage($result['msg']);
              $this->erpMessage->setJsonData($result['paymentModeID']);
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
    
    
    /**
     * @Route ("/payroll/retrive_payment_mode/{pkid}", name="_retrive_payment_mode")
     */
    public function retrivePaymentModeAction($pkid)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                    
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->retrivePaymentMode($pkid);     
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    /**
     * @Route ("/payroll/delete_payment_mode/{pkid}", name="_delete_payment_mode")
     */
    public function deletePaymentModeAction($pkid)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollMasterSettings');
	if($accessRight==1){
       try{                    
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->deletePaymentMode($pkid);              
             $this->erpMessage->setMessage($result['msg']);
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    
    /**
     * @Route ("/payroll/advance_payment", name="_advance_payment")
     */
    public function advancePaymentAction()
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
        try{      
              $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
              $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT,array('month' => $month)));
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
    
    /**
     * @Route ("/payroll/search_employee_for_advance_payment", name="_search_employee_for_advance_payment")
     */
    public function searchEmployeeToCreateAdvancePaymentAction(Request $request)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{      
             $empSearchResult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->searchEmployeeDetails($request);
             //$empAdvancePaymentDetails = $this->get(PayrollConstant::SERVICE_PAYROLL)->searchEmpAdvancePaymentDetails();          
            // $empAdvancePaymentStatus = $this->get(PayrollConstant::SERVICE_PAYROLL)->empAdvancePaymentStatus($request);
            // 'empAdvancePaymentStatus' => $empAdvancePaymentStatus
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_SEARCH_EMP_RESULT_FOR_ADVANCE_PAYMENT,
                     array('empSearchResult' => $empSearchResult )));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/view_advance_payment_history/{empID}", name="_view_emp_advance_payment_history")
     */
    public function viewAdvancePaymentHistoryAction(Request $request, $empID)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{      
             $key = $request->request->get('key');    
             $empAdvPaymentDetails = $this->get(PayrollConstant::SERVICE_PAYROLL)->searchEmpAdvancePaymentDetails($empID); 
             $empDetails = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);   
             $rePayment = $this->em->getRepository(PayrollConstant::ENT_PAYROL_REPAYMENT_COLLECTION)->findBy(array('employeeFk' => $empID,'recordActiveFlag' => 1));
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_HISTORY,
                     array('empAdvPaymentDetails' => $empAdvPaymentDetails, 
                           'empDetails' => $empDetails,
                           'rePayment' => $rePayment,
                           'key' => $key
                         )));
             $this->erpMessage->setSuccess(true);           
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/show_advance_payment/{empID}", name="_show_advance_payment")
     */
    public function showAdvancePaymentAction(Request $request, $empID)
    {          
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{     
             $key = $request->request->get('key');            
             $empDetails = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);              
             $particularEmpDetail = $this->get(PayrollConstant::SERVICE_PAYROLL)->particularEmployeeDetails($empID);
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_FORM,
                     array('empID' =>$empID, 'particularEmpDetail' => $particularEmpDetail,'empDetails' => $empDetails, 'key' => $key))); 
             $this->erpMessage->setSuccess(true);
        }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/save_emp_advance_payment", name="_save_emp_advance_payment")
     */
    public function saveEmpAdvancePaymentAction(Request $request)
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
       try{         
             $dataUI = json_decode($request->getContent());         
             $empID = $dataUI->txt_employee_id;
             $particularEmpDetail = $this->get(PayrollConstant::SERVICE_PAYROLL)->saveAdvancePayment($request);
             $empAdvPaymentDetails = $this->get(PayrollConstant::SERVICE_PAYROLL)->searchEmpAdvancePaymentDetails($empID); 
             $empDetails = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);   
             $rePayment = $this->em->getRepository(PayrollConstant::ENT_PAYROL_REPAYMENT_COLLECTION)->findBy(array('employeeFk' => $empID,'recordActiveFlag' => 1));
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_HISTORY,
                     array('empAdvPaymentDetails' => $empAdvPaymentDetails, 
                           'empDetails' => $empDetails,
                           'rePayment' => $rePayment,                         
                         )));
             $this->erpMessage->setSuccess(true);
             $this->erpMessage->setJsonData($particularEmpDetail['advancePaymentId']);
             $this->erpMessage->setMessage($particularEmpDetail['msg']);
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
    
    /**
     * @Route ("/payroll/approval_for_created_advance_payment", name="_approval_for_created_advance_payment")
     */
    public function approvalForCreatedAdvancePaymentAction()
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
            try{                                          
                  $createdAdvancePayment = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedAdvancePayment();           
                  $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_APROVAL,array('createdAdvancePayment' => $createdAdvancePayment)));
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
    
    
    
    /**
     * @Route ("/payroll/approved_created_advance_payment", name="_approved_created_advance_payment")
     */
    public function approvedCreatedAdvancePaymentAction(Request $request)
    {          
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApproveRejectSalaryWages');
	if($accessRight==1){
            try{     
                $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->approvedCreatedAdvancePayment($request);          
                $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_APROVAL));
                $this->erpMessage->setSuccess(true);   
                $this->erpMessage->setMessage($result);
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
    
    /**
     * @Route ("/payroll/list_of_approved_advance_payment", name="_list_of_approved_advance_payment")
     */
    public function listOfApprovedAdvancePaymentAction()
    {          
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
            try{                                          
                 $approvedAdvancePayment = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllApprovedAdvancePayment();   
                 $paymentMode = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnPaymentModeMaster');
                 $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_PAID,array('approvedAdvancePayment' => $approvedAdvancePayment, 'paymentMode' => $paymentMode)));
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
    
    /**
     * @Route ("/payroll/reject_approved_advance_payment/{advancePayID}", name="_reject_approved_advance_payment")
     */
    public function rejectApprovedAdvancePaymentAction($advancePayID)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                                          
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->rejectApprovedAdvancePayment($advancePayID); 
             $approvedAdvancePayment = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllApprovedAdvancePayment();
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_ADVANCE_PAYMENT_PAID,array('approvedAdvancePayment' => $approvedAdvancePayment)));
             $this->erpMessage->setMessage($result);
             $this->erpMessage->setSuccess(true);           
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/pay_payment_advance_payment/{key}", name="_pay_payment_advance_payment")
     */
    public function payPaymentAdvancePaymentAction(Request $request, $key)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                                          
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->payPaymentAdvancePayment($request, $key);            
             $this->erpMessage->setMessage($result['msg']);
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setSuccess(true);           
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
       
    /**
     * @Route ("/payroll/search_employee_salary_slip", name="_search_employee_salary_slip")
     */
    public function searchEmployeeSalarySlipAction(Request $request)
    {
           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{       
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->searchEmployeeSalarySlip($request); 
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_EMPLOYEE_SEARCH_LIST, array('result' => $result)));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/popup_form_emolument_deduction_master", name="_popup_form_emolument_deduction_master")
     */
    public function popupFormEmolumentDeductionMasterAction()
    {       
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                  
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_POPUP_EMOLUMENT_DEDUCTION));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/create_emp_salary_slip/{empID}", name="_create_emp_salary_slip")
     */
    public function createEmpSalarySlipAction(Request $request, $empID)
    {           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
       try{       
             $dataUI = json_decode($request->getContent()); 
             $key = $dataUI->key;
             //emp information
             $empDetails = $this->get(PayrollConstant::SERVICE_PAYROLL)->particularEmployeeDetails($empID);  
             //emp salary slip status
             $sal_slip_status = $this->get(PayrollConstant::SERVICE_PAYROLL)->empSalSlipStatus($request, $empID);   
             //emp account balance
             $empAccountObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ACCOUNT_BAL)->findOneByEmpFk($empID); 
             //check emp advance taken due amount 
             $totalDueAdvancePaymentAmount = $this->get(PayrollConstant::SERVICE_PAYROLL)->particularDueAmountForAdvancePayment($empID); 
             //salary slip dynamic field from database 
             $allEmoluments = $this->get(PayrollConstant::SERVICE_PAYROLL)->allEmoluments(); 
             $allDeductions = $this->get(PayrollConstant::SERVICE_PAYROLL)->allDeductions(); 
             //retrive data from payroll master ie.basic, hra  calculation%
             $payrollMaster = $this->em->getRepository(PayrollConstant::ENT_PAYROL_MASTER)->findOneBy(array('status' => 1, 'recordActiveFlag' => 1));
             
             //find all amount for dynamic salary slip fields    
             $salary_slip_id = 0;
             if(isset($sal_slip_status['salSlipID'])){
                $salary_slip_id = $sal_slip_status['salSlipID'];
             } 
            
             $salary_slip_field_amount = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findBy(array('salarySlipFk' => $salary_slip_id, 'recordActiveFlag' => 1 )); 
             
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_EMOLUMENTS_LIST, array('allEmoluments' => $allEmoluments, 'field_amount' => $salary_slip_field_amount)));
             $this->erpMessage->setSecondHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_DEDUCTIONS_LIST, array('allDeductions' => $allDeductions, 'field_amount' => $salary_slip_field_amount)));
             $this->erpMessage->setPage($this->renderView(PayrollConstant::TWIG_PAYROLL_CREATE_EMP_SALARY_SLIP_FORM, 
             array('empDetails' => $empDetails,
                                 'empAccountObj' => $empAccountObj,
                                 'totalDueAdvancePaymentAmount' => $totalDueAdvancePaymentAmount,
                                 'payrollMaster' => $payrollMaster,
                                 'key' => $key
                               )));
           
             $this->erpMessage->setJsonData($sal_slip_status);
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
    
    /**
     * @Route ("/payroll/save_created_salary_slip", name="_save_created_salary_slip")
     */
    public function saveCreatedSalarySlipAction(Request $request)
    {            
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
	if($accessRight==1){
       try{     
             $dataUI = json_decode($request->getContent());                         
             $page_type = $dataUI->txt_page_type; 
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->saveCreatedSalarySlip($request); 
             //if salay slip is update from approval page then do this 
             if($page_type == 'approvePage'){
                 $salarySlipInfo = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($result['salarySlipID']);
                 $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_PARTICULAR_SALARY_SLIP_INFO,array('salarySlipInfo' => $salarySlipInfo)));
             }
             $pendingApprovalSalary = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->GetTotalNoOfPendingApproveSalarySlip(); 
             $this->erpMessage->setPage($page_type);
             $this->erpMessage->setMessage($result['msg']);
             $this->erpMessage->setJsonData(array('salarySlipID'=>$result['salarySlipID'], 'pendingApprovalSalary'=>$pendingApprovalSalary['pendingApprovalSalarySlip']));
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
    
    /**
     * @Route ("/payroll/view_salary_slip_details/{salrySlipID}", name="_view_salary_slip_details")
     */
    public function viewSalarySlipDetailsAction($salrySlipID)
    {     
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{      
             //$result = $this->get(PayrollConstant::SERVICE_PAYROLL)->viewParticularCreatedSalarySlip($salrySlipID);  
             //,array('salSlip' => $result)
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_VIEW_SALARY_SLIP));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/reject_salary_slip/{salrySlipID}", name="_reject_salary_slip")
     */
    public function rejectSalarySlipDetailsAction($salrySlipID)
    {
           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{      
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->rejectParticularCreatedSalarySlip($salrySlipID);
             $approved_salary_slip = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllApprovedSalarySlip();            
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_AJX_APPROVED_LIST,array('allAprovedSalarySlip' => $approved_salary_slip)));
             $this->erpMessage->setMessage('Salary Slip has been rejected ');
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/reject_approved_salary_slip_by_hr", name="_reject_approved_salary_slip_by_hr")
     */
    public function rejectApprovedSalarySlipByHrAction(Request $request)
    {                  
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApproveRejectSalaryWages');
	if($accessRight==1){
            try{                 
                $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->approvedOrRejectSalarySlipByHr($request);                              
                $createdSalarySlip = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedSalarySlip();
                $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
                $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
                $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_APPROVAL_LIST,
                        array('createdSalarySlip' => $createdSalarySlip,
                              'paymentMode' => $paymentMode,
                              'month' => $month
                            )));
                $pendingApprovalSalary = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->GetTotalNoOfPendingApproveSalarySlip(); 
                 $this->erpMessage->setJsonData($pendingApprovalSalary['pendingApprovalSalarySlip']);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            }
            catch (\Exception $ex) {
                //$this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'dberror'));
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
     * @Route ("/payroll/generate_salary_slip", name="_generate_salary_slip")
     */
    public function generateSalarySlipAction()
    {
           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                 
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_GENERATE_SALARY_SLIP));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/approved_salary_slip", name="_approved_salary_slip")
     */
    public function approvedSalarySlipAction()
    {                
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApproveRejectSalaryWages');
	if($accessRight==1){
       try{      
             $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
             $results = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedSalarySlip();
             $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1)); 
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_APPROVE_SALARY,
                     array('month'=> $month,
                           'createdSalarySlip' => $results, 
                           'paymentMode' => $paymentMode)));
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
    
    /**
     * @Route ("/payroll/salary_payment_slip", name="_salary_payment_slip")
     */
    public function salaryPaymentSlipAction()
    {
           
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{            
             $results = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllApprovedSalarySlip();
             $paymentMode = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnPaymentModeMaster');                       
             $this->erpMessage->setHtml($this->renderView(PayrollConstant::TWIG_PAYROLL_SALARY_PAY_SLIP,array('allAprovedSalarySlip' => $results, 'paymentMode' => $paymentMode)));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/worker_wage", name="_worker_wage")
     */
    public function workerWageAction()
    {        
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
        if($accessRight==1){
            try{                                                        
                  $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_create_wage.html.twig'));
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
    
    /**
     * @Route ("/payroll/search_worker_to_create_wage", name="_search_worker_to_create_wage")
     */
    public function searchWorkerToCreateWageAction(Request $request)
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{        
             $results = $this->get(PayrollConstant::SERVICE_PAYROLL)->searchWorker($request); 
             $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_search_result.html.twig',array('workerList' => $results['workerSearchResult'], 'wokerExpertise' => $results['wokerExpertise'] )));
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/load_create_worker_wage_from/{empWorkerPkid}", name="_load_create_worker_wage_from")
     */
    public function loadCreateWorkerWageFormAction(Request $request,$empWorkerPkid)
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
        if($accessRight==1){
       try{       
             $key = $request->request->get('key'); 
             $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_create_wage_form.html.twig',array('key' => $key)));
             $this->erpMessage->setId($empWorkerPkid);
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
    
    /**
     * @Route ("/payroll/save_worker_wage", name="_save_worker_wage")
     */
    public function saveWorkerWageFormAction(Request $request)
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
        if($accessRight==1){
       try{                       
             $results = $this->get(PayrollConstant::SERVICE_PAYROLL)->saveWorkerWage($request); 
             if($results['key'] == 'viewEdit'){
                 $createdWorkerWage = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedWages();
                 $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_wages_approval_list.html.twig',array('createdWorkerWage' => $createdWorkerWage)));  
             }             
             $this->erpMessage->setMessage($results['msg']);
             $this->erpMessage->setJsonData($results);
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'dberror'));
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
     * @Route ("/payroll/approve_created_worker_wage", name="_approve_created_worker_wage")
     */
    public function approvedCreatedWorkerWageAction(Request $request)
    {        
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{               
             //query for all created worker wage 
             $createdWorkerWage = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedWages();
             $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
             $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_wages_approval.html.twig',array('createdWorkerWage' => $createdWorkerWage, 'paymentMode' => $paymentMode)));           
             $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'dberror'));
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
    }
    
    /**
     * @Route ("/payroll/reject_approved_wages", name="_reject_approved_wages")
     */
    public function rejectApprovedWagesAction(Request $request)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApproveRejectSalaryWages');
	if($accessRight==1){
       try{                                          
             $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->approvedOrRejectWages($request);            
             $createdWorkerWage = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedWages();
             $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
             $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_wages_approval_list.html.twig',array('createdWorkerWage' => $createdWorkerWage, 'paymentMode' => $paymentMode)));
             $this->erpMessage->setMessage($result);
             $this->erpMessage->setSuccess(true);           
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'dberror'));
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
     * @Route ("/payroll/view_edit_wages/{pkid}", name="_view_edit_wages")
     */
    public function viewEditWageAction(Request $request, $pkid)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('PayrollManagement');
        if($accessRight==1){
       try{        
             $key = $request->request->get('key'); 
             $result = $this->em->getRepository('TashiCommonBundle:EmpWorkerWageDetails')->find($pkid);                      
             $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:worker_create_wage_form.html.twig',array('key' => $key, 'wageDetails' => $result)));
             $this->erpMessage->setMessage($result);
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
 
    
    
    /**
     * @Route ("/payroll/Payrolsendingmailwithattachment", name="_Payrolsendingmailwithattachment")
     */
    public function SendMailWithAttachmentAction(Request $request)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {
            $image = $this->get(PayrollConstant::SERVICE_PAYROLL)->createSlipimage($request);
            $filename = $image['file'];
            $this->get('swiftmailer.command.spool_send')->run(new ArgvInput(array()), new ConsoleOutput());
            unlink($filename);
            //$this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:test.html.twig',array('file'=>$image['file'])));
            if ($image['code'] == 1) {
                $this->erpMessage->setSuccess(true);
                //unlink($filename);
             } else {
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($image['msg']);
            $this->erpMessage->setJsonData($image);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
    }
    
    
    /**
     * @Route ("/payroll/convertpdf", name="_convertpdf")
     */
    public function ConvertToPDFAction(Request $request)
    {          
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try
         {
           $image = $this->get(PayrollConstant::SERVICE_PAYROLL)->Html2pdfconvert($request);
           //echo 1;die();
//           $pdf =  $this->get('knp_snappy.pdf')->generateFromHtml($this->renderView('TashiPayrollBundle:Payroll:Payslip.html.twig'),
//                   'C:\wamp\www\TASHI\web\PDF\1.pdf');
            
            
            
            
//            $this->erpMessage->setHtml($this->renderView('TashiPayrollBundle:Payroll:test.html.twig'));
//            if ($image['code'] == 1) {
//                $this->erpMessage->setSuccess(true);
//                } else {
//                $this->erpMessage->setSuccess(false);
//            }
            $this->erpMessage->setSuccess(true);
            //$this->erpMessage->setMessage($pdf['msg']);
           // $this->erpMessage->setJsonData($pdf);
         }
         catch (\Exception $ex) {
                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  
        
    }
    
    
    
    
    
    
}

