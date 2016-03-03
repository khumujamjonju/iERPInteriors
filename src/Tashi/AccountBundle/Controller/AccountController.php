<?php

namespace Tashi\AccountBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\CommonBundle\Helper\ERPMessage; 
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CustomerBundle\Helper\CustomerConstant;
use Tashi\PayrollBundle\Helper\PayrollConstant;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
class AccountController extends Controller 
{   
    private $em;
    private $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage = new ERPMessage();
    }
      
    /**
     * @Route ("/Account/_account_dashboard", name="_account_dashboard")
     */
    public function dashboardAccountAction()
    { 
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
            try{                    
                  $pendingApprovalCount=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->GetPendingPaymentCount();
                  if($pendingApprovalCount){
                     $apprCount=$pendingApprovalCount[0][1];
                  }
                  $totalSanctionSalary = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->GetTotalNoOfSalarySanction();                              
                  $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_CONTROL,
                          array('totalSanctionSalary' => $totalSanctionSalary['totalSanctionSalary'],
                                'ApprCount'=>$apprCount)));
                  $this->erpMessage->setSuccess(true);        
              }
              catch (\Exception $ex) {
                  //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                     $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/account_master", name="_account_master")
     */
    public function accountMasterAction()
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
        try{            
            $accountType = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountTypeMaster');
            $allAccountHead = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountHeadMaster');
            $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_MASTER, array('accountType' => $accountType, 'allAccountHead' => $allAccountHead)));
            $this->erpMessage->setSuccess(true);        
        }
        catch (\Exception $ex) {           
            //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);    
//            $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/save_account_head", name="_save_account_head")
     */
    public function saveAccountHeadAction(Request $request)
    {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
       try{                   
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveAccountHead($request);
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_HEAD_LIST, array('allAccountHead' => $result['all_acc_head'])));
           $this->erpMessage->setMessage($result['msg']);
           $this->erpMessage->setId($result['acc_head_id']);
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/retrive_account_head_record/{pkid}", name="_retrive_account_head_record")
     */
    public function retriveAccountHeadRecordAction($pkid)
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
        try{                   
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveAccountHeadRecord($pkid);          
           $this->erpMessage->setJsonData($result);
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
//            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);             
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/delete_account_head_record/{pkid}", name="_delete_account_head_record")
     */
    public function deleteAccountHeadRecordAction($pkid)
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
        try{                   
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->deleteAccountHeadRecord($pkid);          
            $this->erpMessage->setMessage($result);
            $this->erpMessage->setSuccess(true);        
        }
        catch (\Exception $ex) {
            //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//            $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/account_entry", name="_account_entry")
     */
    public function accountEntryAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
        try{
            $em=$this->getDoctrine()->getManager();
            $session=$this->getRequest()->getSession();            
            $empid=$session->get('EMPID');
            $transactionDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$empid,'moduleId'=>'AE','recordActiveFlag'=>1));
            $accountTypes = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountTypeMaster');
            $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1)); 
            $accountHeads =$this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->findBy(array('accountTypeFk' => 2, 'isReserve' => 0, 'recordActiveFlag' => 1));         
            $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
            $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
            $currentYear =  date_format(new \Datetime('NOW'), 'Y');          
            $allIncomeAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 1);
            $allExpenseAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 2);
            $allContraTansaction = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 3);
            $allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1));          
            $contraTransactionType = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE)->findBy(array('recordActiveFlag'=>1));
            $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
            $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
            $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY, 
                   array('accountTypes' => $accountTypes,
                         'accountHeads' => $accountHeads,
                         'paymentMode' => $paymentMode,
                         'month' => $month,
                         'currentMonth' => (int) $currentMonth,
                         'currentYear' => $currentYear,
                         'allIncomeAccountEntry' => $allIncomeAccountEntry,
                         'allExpenseAccountEntry' => $allExpenseAccountEntry,
                         'allContraTansaction' => $allContraTansaction,
                         'allContraTansactionDetails'=>$allContraTansactionDetails,
                         'contraTransactionType' => $contraTransactionType,
                         'allCompanyBankDetails'=>$allCompanyBankDetails,
                         'cashAccountDetails'=>$cashAccountDetails,
                         'tranDate'=>$transactionDate,
                         'account_income_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST,
                         'account_expense_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST,
                         'account_contra_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_CONTRA_LIST
                       )));      
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {             
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * @Route ("/Account/save_account_entry", name="_save_account_entry")
     */
    public function saveAccountEntryAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
       try{           //allContraTansaction
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveAcountEntry($request);         
            if($result['code']==1){
            $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST, 
                    array('allIncomeAccountEntry' => $result['allIncomeAccountEntry'])));    
            $this->erpMessage->setSecondHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST, 
                    array('allExpenseAccountEntry' => $result['allExpenseAccountEntry']))); 

            $allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1)); 
            $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
            $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
            $this->erpMessage->setPage($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_CONTRA_LIST, 
                    array('allContraTansaction' => $result['allContraTansaction'],
                          'allContraTansactionDetails'=>$allContraTansactionDetails,
                          'cashAccountDetails'=>$cashAccountDetails,
                          'allCompanyBankDetails'=>$allCompanyBankDetails
                    )));
            $this->erpMessage->setJsonData($result);            
            $this->erpMessage->setSuccess(true);
            }else{
                $this->erpMessage->setSuccess(false);
            }
            $this->erpMessage->setMessage($result['msg']);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
  //              $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/view_account_report", name="_view_account_report")
     */
    public function viewAccountReportAction()
    {  
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
        try{    
           $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ENTRY_VIEW_REPORT,array('month'=>$month)));      
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {             
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * @Route ("/Account/search_account_entry", name="_search_account_entry")
     */
    public function searchAccountEntryAction(Request $request)
    {  
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
	if($accessRight==1){
        try{    
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->searchAccountEntryAction($request);
           $allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1)); 
           $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
           $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ENTRY_SEARCH_RESULT,
                   array('header'=> $result['header'],
                         'allIncomeAccountEntry' => $result['allIncomeAccountEntry'],
                         'allExpenseAccountEntry' => $result['allExpenseAccountEntry'],
                         'allContraTansactionDetails'=>$allContraTansactionDetails,
                         'cashAccountDetails'=>$cashAccountDetails,
                         'allCompanyBankDetails'=>$allCompanyBankDetails,
                         'allContraTansaction'=>$result['allContraTansaction'],
                         'account_income_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST,
                         'account_expense_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST,
                         'account_contra_list_twig' => AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_CONTRA_LIST
                       )));      
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {             
                $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
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
     * @Route ("/Account/load_account_common_list", name="_load_account_common_list")
     */
    public function loadAccountCommonListAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{     
           $account_type_id = $request->request->get('account_type_id');
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->loadAccountCommonList($account_type_id);  
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_LOAD_COMMON_LIST, array('accountHeadList' => $result)));                         
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/load_account_entry_details", name="_load_account_entry_details")
     */
    public function loadAccountEntryDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{           
           $currentMonth =  $request->request->get('month'); 
           if($currentMonth < 10){
               $currentMonth =  '0'.$currentMonth;
           }
           $currentYear =  $request->request->get('year'); 
           $allIncomeAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 1);
           $allExpenseAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 2); 
           $allContraTansaction = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 3);           
           $allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1)); 
           $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
           $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST, 
                   array('allIncomeAccountEntry' => $allIncomeAccountEntry)));    
           $this->erpMessage->setSecondHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST, 
                   array('allExpenseAccountEntry' => $allExpenseAccountEntry))); 
           
           $this->erpMessage->setPage($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_CONTRA_LIST, 
                   array('allContraTansaction' => $allContraTansaction,
                         'allContraTansactionDetails'=>$allContraTansactionDetails,
                         'cashAccountDetails'=>$cashAccountDetails,
                         'allCompanyBankDetails'=>$allCompanyBankDetails
                   ))); 
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/load_account_entry_any_peroid", name="_load_account_entry_any_peroid")
     */
    public function loadAccountEntryAnyPeriodAction(Request $request)
    {  
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
           $periodDate = $request->request->get('periodDate');
           $allIncomeAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryAnyPeriod($periodDate, 1);
           $allExpenseAccountEntry = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectAccountEntryAnyPeriod($periodDate, 2);         
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST, 
                   array('allIncomeAccountEntry' => $allIncomeAccountEntry)));    
           $this->erpMessage->setSecondHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST, 
                   array('allExpenseAccountEntry' => $allExpenseAccountEntry))); 
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    
    
    /**
     * @Route ("/Account/retrive_account_entry_record/{pkid}", name="_retrive_account_entry_record")
     */
    public function retriveAccountEntryRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{           
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveAccountEntryRecord($pkid);  
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_ACCOUNT_LOAD_COMMON_LIST, array('accountHeadList' => $result['acc_head_list']))); 
           $this->erpMessage->setJsonData($result);         
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/delete_account_entry_record/{pkid}", name="_delete_account_entry_record")
     */
    public function deleteAccountEntryRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->deleteAccountEntryRecord($pkid);          
           $this->erpMessage->setMessage($result);
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    
    /**
     * @Route ("/Account/bank_acount", name="_bank_account")
     */
    public function bankAccountAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{              
             $bankAccType = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnBankAccountType');
             $company = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CompanyMaster');
             $companyBankDetail = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountCompanyBankTxn');
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_BANK_ACCOUNT, array('bankAccType' => $bankAccType, 'company' => $company, 'companyBankDetail' => $companyBankDetail) ));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
   }
   
   /**
     * @Route ("/Account/mastercash_acount", name="_mastercash_account")
     */
    public function MasterCashAccountAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{              
             $cashBankDetail = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountCashCurrentBalance');
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_MASTERCASH_ACCOUNT, array('cashAccount' => $cashBankDetail)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
   }
   
   
   
   
   
   /**
     * @Route ("/Account/save_company_bank_acount", name="_save_company_bank_account")
     */
    public function saveBankAccountAction(Request $request)
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
//	if($accessRight==1){
        try{            
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveCompanyBankAccount($request);
            // account_flag = 0, means bank account no is new, if 1 then already exist
            if($result['account_flag'] == 0){ 
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_BANK_ACCOUNT_LIST, array('companyBankDetail' => $result['allCompanyBank']) ));
            }             
            $this->erpMessage->setMessage($result['msg']);
            $this->erpMessage->setJsonData($result);                    
            $this->erpMessage->setSuccess(true);        
          }
        catch (\Exception $ex) {
            //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//            $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
            $this->erpMessage->setSuccess(false);
        }
//    }
//    else{
//        $this->erpMessage->setJsonData('AD');
//        $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//    }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
   }
    
   /**
     * @Route ("/Account/retrive_bank_account_record/{pkid}", name="_retrive_bank_account_record")
     */
    public function retriveBankAccountRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                     
           $balance=$this->get(AccountConstant::SERVICE_ACCOUNT)->GetBankBalance($pkid);
           if($balance){
               $balance=$balance[0][1];
           }else{
               $balance='0';
           }
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveBankAccountRecord($pkid); 
           
           $this->erpMessage->setJsonData(array('result'=>$result,'bal'=>$balance));         
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
     /**
     * @Route ("/Account/delete_bank_account_record/{pkid}", name="_delete_bank_account_record")
     */
    public function deleteBankAccountRecordAction($pkid)
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
//	if($accessRight==1){
        try{                   
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->deleteBankAccountRecord($pkid);          
            $this->erpMessage->setMessage($result);
            $this->erpMessage->setSuccess(true);        
        }
        catch (\Exception $ex) {
            //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //           $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
            $this->erpMessage->setSuccess(false);
        }        
//    }
//    else{
//        $this->erpMessage->setJsonData('AD');
//        $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//    }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    
    
    
    /**
     * @Route ("/Account/save_company_cash_acount", name="_save_company_cash_account")
     */
    public function savecashAccountAction(Request $request)
    {
       
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       
//	if($accessRight==1){
        try{    
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveCompanyCashAccount($request);
            $cashBankDetail = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountCashCurrentBalance');
            // account_flag = 0, means bank account no is new, if 1 then already exist
            if($result['account_flag'] == 1){ 
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_DISPLAY_CAHSACCOUNTFORMASTER, array('cashAccount' => $cashBankDetail)));
             $this->erpMessage->setMessage($result['msg']);
             $this->erpMessage->setSuccess(true);}
            else{
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(false);
            }
            
            $this->erpMessage->setJsonData($result);                    
                   
          }
        catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
            //$this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
            $this->erpMessage->setSuccess(false);
        }
//    }
//    else{
//        $this->erpMessage->setJsonData('AD');
//        $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
//    }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
   }
    
     /**
     * @Route ("/Account/retrive_cash_account_record/{pkid}", name="_retrive_cash_account_record")
     */
    public function retrivecashAccountRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                     
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveAllCashAccountRecord($pkid); 
           $this->erpMessage->setJsonData($result);         
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/retreivecashbal", name="_retreivecashbal")
     */
    public function RetrieveCashBalanceAction(){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
        try{ 
            $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
            if($cashAccountDetails){
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($cashAccountDetails->getCurrentAmount());
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setJsonData(0);
                $this->erpMessage->setMessage('Cash Account not opened yet.');
            }
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData(0);
            $this->erpMessage->setMessage('Unable to retrieve current Cash Balance.');
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata); 
    }      
    /**
     * @Route ("/Account/bank_deposit_withdrawal", name="_bank_deposit_widrawal")
     */
    public function bankDepositWithdrawalAction(){       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{     
            $em=$this->getDoctrine()->getManager();
            $session = $this->getRequest()->getSession();
            $emp_id = $session->get('EMPID');
            $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
            if(!$cashAccountDetails){
                $this->erpMessage->setMessage('You have not created Cash Account. You need to create one in order to carry out Contra Transaction.');
                $this->erpMessage->setSuccess(false);
                goto _return;
            }
            $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
            if(!$allCompanyBankDetails){
                $this->erpMessage->setMessage('There is no Bank Account in database. You need to create one in order to carry out Contra Transaction.');
                $this->erpMessage->setSuccess(false);
                goto _return;
            }
            $lastTranDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$emp_id,'moduleId'=>'BT','recordActiveFlag'=>1));
            //$branch_id = $this->get('tashi.common.service')->getBranchIdByGivingEmpId($emp_id);
            //$month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
            $paymentMode = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnPaymentModeMaster');
            $accSourceType = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountSourceType');
            //$currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
            //$currentYear =  date_format(new \Datetime('NOW'), 'Y'); 
            //$bankDepositWithdrawalRecord = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectBankDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id);
            $tranArr=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->GetRecentContraTransaction();
            $companyBanks = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountCompanyBankTxn');
            //$allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1));             
                $tranType=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE)->findBy(array('recordActiveFlag'=>1));
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CONTRA_TRANSACTION, 
                    array('companyBanks' => $companyBanks,
                          'tranTypeArr'=>$tranType,
                          'accSourceType' => $accSourceType,
                          //'currentMonth' => (int) $currentMonth, 
                          //'currentYear' => $currentYear, 
                          //'month' => $month,
                          //'allContraTansactionDetails'=>$allContraTansactionDetails,
                          'cashAccountDetails'=>$cashAccountDetails,
                          'allCompanyBankDetails'=>$allCompanyBankDetails,
                          'paymentMode' => $paymentMode,
                          'tranDate'=>$lastTranDate,
                          'tranArr' => $tranArr)));
            $this->erpMessage->setSuccess(true);        
        }
        catch (\Exception $ex) {
            //            $this->erpMessage->setMessage($ex->getMessage());
           $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
               $this->erpMessage->setSuccess(false);
        }
        _return:
       $jsondata = $serializer->serialize($this->erpMessage, 'json');
       return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/load_current_bank_status/{accid}", name="_load_current_bank_status")
     */
    public function loadCurrentBankSatatusAction(Request $request,$accid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{    
             //$account_key = $request->request->get('account_key');
             //$cash_or_bank_id = $request->request->get('cash_or_bank_id');             
             //$result = $this->get(AccountConstant::SERVICE_ACCOUNT)->loadCurrentBankStatus($cash_or_bank_id, $account_key);  
            $em=$this->getDoctrine()->getManager();
            $balance=$em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($accid);
            $this->erpMessage->setJsonData($balance->getCurrentAmount());
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }   
    
    /**
     * @Route ("/Account/save_bank_deposit_withdrawal", name="_save_bank_deposit_withdrawal")
     */
    public function saveBankDepositWidrawalAction(Request $request)
    {    
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
            try{       
                $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->SaveContraTransaction($request);  
                if($result['code'] == 1){
                    $allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1)); 
                    $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
                    $allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));

                    $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_BANK_DEPOSIT_WITHDRAWAL_LIST, 
                             array('bankDepositWithdrawalRecord' => $result['bankDepositWithdrawalRecord'],
                                   'allContraTansactionDetails'=>$allContraTansactionDetails,
                                   'cashAccountDetails'=>$cashAccountDetails,
                                   'allCompanyBankDetails'=>$allCompanyBankDetails
                             )));
                }
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);        
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
     * @Route ("/Account/contratransaction/{action}", name="_contratransaction")
     */
    public function SaveContraTransactionAction(Request $request,$action)
    {    
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();    
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
            if($action=='INS'){
                $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->SaveContraTransaction($request);  
            }elseif($action=='EDT'){
                $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->EditContraTransaction($request);  
            }
            if($result['code'] == 1){
                $trantype=$request->request->get('inputTranType');
                $sourceid=$request->request->get('sourceBank');
                $targetid=$request->request->get('targetBank');
                if(!empty($sourceid)){
                    $sourceBankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->
                            findOneBy(array('bankFk'=>explode('&',$sourceid)[1],'recordActiveFlag'=>1)); 
                }
                if(!empty($targetid)){
                    $targetBankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->
                            findOneBy(array('bankFk'=>explode('&',$targetid)[1],'recordActiveFlag'=>1)); 
                }
                if(isset($sourceBankAcc)){
                    $sourceBal=$sourceBankAcc->getCurrentAmount();
                }else{
                    $sourceBal=0;
                }
                if(isset($targetBankAcc)){
                    $targetBal=$targetBankAcc->getCurrentAmount();
                }else{
                    $targetBal=0;
                }
                //$allContraTansactionDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT)->findBy(array('recordActiveFlag'=>1)); 
                $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
                //$bankAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1)); 
                //$allCompanyBankDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag'=>1));
                $tranArr=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->GetRecentContraTransaction();
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CONTRA_TRANSACTION_LIST, 
                        array('tranArr'=>$tranArr)));                  
                $this->erpMessage->setJsonData(array('cashbal'=>$cashAccountDetails->getCurrentAmount(),'sourcebal'=>$sourceBal,'targetbal'=>$targetBal));
                $this->erpMessage->setSuccess(true);
            }else{
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
     * @Route ("/Account/retrievecontratransaction/{pkid}", name="_retrievecontratransaction")
     */
    public function RetrieveContraTransactionAction($pkid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try{
            $transaction=$this->em->getRepository(AccountConstant::ENT_CONTRA_TRANSACTION)->find($pkid);
            $source=$transaction->getSourceFk();
            $target=$transaction->getTargetFk();
            $sourceBal=0;
            $targetBal=0;
            if($source){
                $sourceBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$source,'recordActiveFlag'=>1))->getCurrentAmount();
            }
            if($target){
                $targetBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$target,'recordActiveFlag'=>1))->getCurrentAmount();
            }
            if($transaction->getProofFk()){
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CONTRA_PROOF,array('tran'=>$transaction)));
            }else{
                $this->erpMessage->setHtml('');
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData(array('contra'=>$transaction,'sourceBal'=>$sourceBal,'targetBal'=>$targetBal));
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage($ex->getMessage());
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/Account/delcontratransaction/{pkid}", name="_retrievecontratransaction")
     */
    public function DeleteContraTransactionAction($pkid){
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();    
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('AccountMasterSetting');
	if($accessRight==1){
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->DeleteContraTransaction($pkid);
            if($result['code']==1){
                $tranArr=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->GetRecentContraTransaction();
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CONTRA_TRANSACTION_LIST,array('tranArr'=>$tranArr)));
                $this->erpMessage->setSuccess(true);
            }else{
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
     * @Route ("/Account/retrive_bank_deposit_withdrawal_history/{pkid}", name="_retrive_bank_deposit_withdrawal_history")
     */
    public function retriveBankDepositWidrawalRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{           
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveBankDepositWidrawalHistory($pkid);                          
           $this->erpMessage->setJsonData($result);         
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/delete_bank_deposit_withdrawal_record/{pkid}", name="_delete_bank_deposit_withdrawal_record")
     */
    public function deleteBankDepositWidrawalRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->deleteBankDepositWidrawalRecord($pkid);          
           $this->erpMessage->setMessage($result);
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    
    /**
     * @Route ("/Account/load_bank_deposit_withdrawal_history", name="_load_deposit_withdrawal_history")
     */
    public function loadBankDepositWithdrawalHistoryAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{        
            $session = $this->getRequest()->getSession();
            $emp_id = $session->get('EMPID');
            $branch_id = $this->get('tashi.common.service')->getBranchIdByGivingEmpId($emp_id);
            $currentMonth =  $request->request->get('month'); 
           if($currentMonth < 10){
               $currentMonth =  '0'.$currentMonth;
           }
           $currentYear =  $request->request->get('year'); 
           $depositWithdrawalHistoryList = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectBankDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id);  
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_BANK_DEPOSIT_WITHDRAWAL_LIST, array('bankDepositWithdrawalRecord' => $depositWithdrawalHistoryList)));                          
           $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/load_bank_deposit_withdrawal_history_by_date", name="_load_bank_deposit_withdrawal_history_by_date")
     */
    public function loadBankDepositWithdrawalHistoryByDateAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{        
            $session = $this->getRequest()->getSession();
            $emp_id = $session->get('EMPID');
            $date = $request->request->get('date'); 
            $branch_id = $this->get('tashi.common.service')->getBranchIdByGivingEmpId($emp_id);           
            $depositWithdrawalHistoryList = $this->get(AccountConstant::SERVICE_ACCOUNT)->loadBankDepositWithdrawalRecordsByDate($branch_id, $date);  
            $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_BANK_DEPOSIT_WITHDRAWAL_LIST, array('bankDepositWithdrawalRecord' => $depositWithdrawalHistoryList)));                          
            $this->erpMessage->setSuccess(true);
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/project_wallet", name="_acc_project_wallet")
     */
    public function projectWalletAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_PROJECT_WALLET ));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/cash_account", name="_cash_account")
     */
    public function cashAccountAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{        
            $session = $this->getRequest()->getSession(); 
            $emp_id = $session->get('EMPID');          
            $branch_id = $this->get('tashi.common.service')->getBranchIdByGivingEmpId($emp_id);         
            $employees = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('departmentFk' => $branch_id, 'employementTypeFk' => 1, 'recordActiveFlag' => 1));  
            $allCashAccount = $this->get(AccountConstant::SERVICE_ACCOUNT)->findAllCashAccount($branch_id);
            $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CASH_ACCOUNT,array('employees' => $employees, 'allCashAccount' => $allCashAccount)));
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/show_emp_details", name="_show_emp_details")
     */
    public function showEmpDetailsAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
            $empPkid = $request->request->get('empPkid');                              
            $empObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empPkid); 
            $return_Arr = array('emp_id' => $empObj->getEmployeeId(),                              
                                'emp_desigation' => $empObj->getEmpJobTitleFk()->getJobTitleName() );
            $this->erpMessage->setJsonData($return_Arr); 
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/create_cash_account", name="_create_cash_account")
     */
    public function createCashAccountAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{       
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->createCashAccount($request); 
            if($result['cash_acc_flag'] == 0){
                $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CASH_ACCOUNT_LIST,array('allCashAccount' => $result['allCashAccount'])));
            }         
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/retrived_cash_account_record/{pkid}", name="_retrived_cash_account_record")
     */
    public function retrivedCashAccountRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{       
            $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->retriveCashAccountRecord($pkid);                   
            $this->erpMessage->setJsonData($result);            
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    /**
     * @Route ("/Account/delete_cash_account_record/{pkid}", name="_delete_cash_account_record")
     */
    public function deleteCashAccountRecordAction($pkid)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                   
           $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->deleteCashAccountRecord($pkid);   
           $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CASH_ACCOUNT_LIST,array('allCashAccount' => $result['allCashAccount'])));
           $this->erpMessage->setMessage($result['msg']);
           $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    } 
    
     /**
     * @Route ("/Account/cash_deposit_withdrawal", name="_cash_deposit_widrawal")
     */
    public function cashDepositWithdrawalAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('dashboardAccountAction');
       if($accessRight==1){
       try{ 
           $em=$this->getDoctrine()->getManager();
             $session = $this->getRequest()->getSession(); 
             $emp_id = $session->get('EMPID');          
             $lastTranDate=$em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findOneBy(array('employeeId'=>$emp_id,'moduleId'=>'CT','recordActiveFlag'=>1));
             $branch_id = $this->get(CommonConstant::SERVICE_COMMON)->getBranchIdByGivingEmpId($emp_id); 
             $cashAccount = $this->get(AccountConstant::SERVICE_ACCOUNT)->findCashAccount($branch_id);
             $month = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnMonth');
             $paymentMode = $this->get(CommonConstant::SERVICE_COMMON)->activeList('CmnPaymentModeMaster');
             $accSourceType = $this->get(CommonConstant::SERVICE_COMMON)->activeList('AccountSourceType');
             $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
             $currentYear =  date_format(new \Datetime('NOW'), 'Y'); 
             $cashDepositWithdrawalRecord = $this->get(AccountConstant::SERVICE_ACCOUNT)->selectCaseDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id);           
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CASH_DEPOSIT_WITHDRAWAL, 
                     array('cashAccount' => $cashAccount, 
                           'accSourceType' => $accSourceType,
                           'currentMonth' => (int) $currentMonth, 
                           'currentYear' => $currentYear, 
                           'month' => $month,
                           'paymentMode' => $paymentMode,
                            'tranDate'=>$lastTranDate,
                           'cashDepositWithdrawalRecord' => $cashDepositWithdrawalRecord)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
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
     * @Route ("/Account/load_source_type_id", name="_load_source_type_id")
     */
    public function laodSourceTypeIDAction(Request $request)
    {     
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{    
            $source_type_id = $request->request->get('source_type_id');
            $page_type = $request->request->get('page_type');
            $session = $this->getRequest()->getSession(); 
            $emp_id = $session->get('EMPID');          
            $branch_id = $this->get(CommonConstant::SERVICE_COMMON)->getBranchIdByGivingEmpId($emp_id);  
            $result = '';
            $key = '';  
            $current_cash_bal = 0;
            switch($page_type){
                case 'BA':  $bank_account_id = $request->request->get('cash_bank_account_id');
                            switch($source_type_id){
                                case 1: //load all bank account
                                        $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->findAllBankAccount($branch_id);
                                        $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_LOAD_COMMON_ACCOUNTS, array('result' => $result, 'source_type' => $source_type_id, 'bank_account_id' => $bank_account_id)));
                                        break;
                                case 2: //load  cash account
                                        $accountList = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag' => 1, 'branchOfficeCode' => $branch_id)); 
                                        if($accountList){
                                            $current_cash_bal = $accountList->getCurrentAmount();
                                        }else{
                                            $result = $this->get(CustomerConstant::SERVICE_CUSTOMER)->createNewCashAccount($branch_id);  
                                            $current_cash_bal = 0;
                                        }  
                                        $key = 'cash';
                                        $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->findCashAccount($branch_id); 
                                        $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_LOAD_COMMON_ACCOUNTS, array('result' => $result, 'source_type' => $source_type_id, 'cash_account_id' => 0)));
                                        break;
                            }
                            break;
                case 'CA':  $cash_account_id = $request->request->get('cash_bank_account_id');
                            switch($source_type_id){
                                case 1: //load all bank account
                                        $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->findAllBankAccount($branch_id);
                                        $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_LOAD_COMMON_ACCOUNTS, array('result' => $result, 'source_type' => $source_type_id, 'bank_account_id' => 0)));
                                        break;
                                case 2: //load all cash account
                                        $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->findCashAccount($branch_id); 
                                        $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_LOAD_COMMON_ACCOUNTS, array('result' => $result, 'source_type' => $source_type_id, 'cash_account_id' => $cash_account_id)));
                                        break;
                            }
                            break;
            }     
            $this->erpMessage->setJsonData(array('key' => $key, 'current_cash_bal' => $current_cash_bal));
            $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/save_cash_deposit_withdrawal", name="_save_cash_deposit_withdrawal")
     */
    public function saveCashDepositWidrawalAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer(); 
       try{       
             $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveCashDepositWithdrawal($request);  
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_CASH_DEPOSIT_WITHDRAWAL_LIST,array('cashDepositWithdrawalRecord' => $result['cashDepositWithdrawalRecord'])));
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setMessage($result['msg']);         
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    
    /**
     * @Route ("/Account/sales_search_customer", name="_sales_search_customer")
     */
    public function salesSearchCustomerAction()
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{     
             $distinctCustomer = $this->get(AccountConstant::SERVICE_ACCOUNT)->findDistinctCustomerFromPaymentCollection();
             $customerAdvance = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->findBy(array('paymentStatus' => 'A', 'recordActiveFlag' => 1, 'isAdjusted' => 0));
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_SALES_PAYMENT_COLLECTION_CUSTOMER, array('customerAdvance' => $customerAdvance, 'distinctCustomer' => $distinctCustomer)));
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/sales_adjustment_payment_collection}", name="_sales_adjustment_payment_collection")
     */
    public function salesAdjustmentAdvancePaymentCollectionAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                 
             $customerPkid = $request->request->get('customerPkid');
             $cusObj = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($customerPkid); 
             if($cusObj){
                 $customer_details = array('customerFlag' => 1,'customer_id' => $cusObj->getCustomerId(), 'customer_name' => $cusObj->getCustomerName());
             }else{
                 $customer_details = array('customerFlag' => 0);
             }
             $customerAdvance = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->findBy(array('customerFk' => $customerPkid, 'paymentStatus' => 'A', 'recordActiveFlag' => 1, 'isAdjusted' => 0));
             $search_flag = 0;
             $customer_project = '';
             $customer_Due_Invoices_Arr = array();
             $project_total_expense_Arr = array();
             if($customerAdvance){ 
                 $search_flag = 1; 
                 $customer_project = $this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->findBy(array('customerFk' => $customerPkid,  'recordActiveFlag' => 1)); 
                 $i = 0; //array index
                 foreach($customer_project as $cusProObj){
                     //stored all the due invoices of the projects for the particular customer
                     $customer_Due_Invoices_Arr[$i] = $this->em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->findBy(array('projectFk' => $cusProObj->getPkid(),  'recordActiveFlag' => 1, 'isDue' => 1));  
                     //stored all the the total projects expenses for the particular customer
                     $project_total_expense = $this->get(AccountConstant::SERVICE_ACCOUNT)->findByParticularProjectTotalExpense($cusProObj->getPkid()); 
                     $project_total_expense_Arr[$i] = $project_total_expense; 
                     $i++;
                 }      
             }
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_SALES_ADJUSTMENT_ADVANCE_COLLECTION, 
                     array('customerAdvance' => $customerAdvance,                        
                           'searchFlag' => $search_flag, 
                           'customerProject' => $customer_project,
                           'projectTotalExpense' => $project_total_expense_Arr,
                           'customerDueInvoices' => $customer_Due_Invoices_Arr))); 
             $customer_details['cus_advance_search_flag'] = $search_flag;
             $this->erpMessage->setJsonData($customer_details);
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
//                $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.');
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    
    /**
     * @Route ("/Account/save_adjusted_customer_advance", name="_save_adjusted_customer_advance")
     */
    public function saveAdjustedCustomerAdvanceAction(Request $request)
    {
       
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{                 
             $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->saveAdjustedCustomerAdvance($request);  
             $distinctCustomer = $this->get(AccountConstant::SERVICE_ACCOUNT)->findDistinctCustomerFromPaymentCollection();
             $customerAdvance = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->findBy(array('paymentStatus' => 'A', 'recordActiveFlag' => 1, 'isAdjusted' => 0));
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_SALES_PAYMENT_COLLECTION_CUSTOMER_LIST, array('customerAdvance' => $customerAdvance, 'distinctCustomer' => $distinctCustomer)));
             $this->erpMessage->setMessage('Advance collection amount has been adjusted.');
             $this->erpMessage->setSuccess(true);        
         }
         catch (\Exception $ex) {
             //            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setMessage($this->get(CommonConstant::SERVICE_COMMON)->CommonError($ex,'retrieval'));
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
 //               $this->erpMessage->setMessage('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
                $this->erpMessage->setSuccess(false);
         }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);     
    }
    
    /**
     * @Route ("/Account/sanction_salary_slip", name="_sanction_salary_slip")
     */
    public function sanctionSalarySlipAction()
    {   
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{  $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
             $allEmp=$this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employementTypeFk'=>1,'recordActiveFlag'=>1));
             $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag' => 1));
             $bankAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag' => 1));
             $sanctionSalaryGroupId = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->findBy(array('isSanction' => 0, 'recordActiveFlag' => 1));
             $totalSalarySlip = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->GetTotalNoOfSalarySlipToBeSanction();              
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_SANCTION_SALARY_AMOUNT, 
                     array('cashAccountDetails' => $cashAccountDetails,
                           'bankAccountDetails' => $bankAccountDetails,
                           'allEmp'=>$allEmp,
                           'sanctionSalaryGroupId' => $sanctionSalaryGroupId,
                           'totalSalarySlip' => $totalSalarySlip,
                           'paymentMode'=>$paymentMode
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
     * @Route ("/Account/sanction_salary_amount", name="_sanction_salary_amount")
     */
    public function sanctionSalaryAmountAction(Request $request)
    {   
       $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
       try{   
             $result = $this->get(AccountConstant::SERVICE_ACCOUNT)->sanctionSalaryAmount($request);
             
             foreach($result['pdfpatharray'] as $val)
                 {
                      $this->get('swiftmailer.command.spool_send')->run(new ArgvInput(array()), new ConsoleOutput());
                      unlink($val);
                 }
                 //ends here
                
//                $salarySlipInfo = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($result['salarySlipID']);
//               
//                $allCreatedSalarySlip = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedSalarySlip();
//                $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
                
                //for appending twig approval result in ui
               // $this->erpMessage->setPath($this->renderView(PayrollConstant::TWIG_PAYROLL_APPROVAL_LIST,array('createdSalarySlip' => $allCreatedSalarySlip, 'paymentMode' => $paymentMode)));
               
             
             
             
             
             
             
             $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
             $cashAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag' => 1));
             $bankAccountDetails = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findBy(array('recordActiveFlag' => 1));
             $sanctionSalaryGroupId = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->findBy(array('isSanction' => 0, 'recordActiveFlag' => 1));
             $totalSalarySlip = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->GetTotalNoOfSalarySlipToBeSanction();     
             $this->erpMessage->setHtml($this->renderView(AccountConstant::TWIG_SANCTION_SALARY_AMOUNT_AFTER_SANCTION_OR_REJECT, 
                     array('cashAccountDetails' => $cashAccountDetails,
                           'bankAccountDetails' => $bankAccountDetails,
                           'sanctionSalaryGroupId' => $sanctionSalaryGroupId,
                           'totalSalarySlip' => $totalSalarySlip,
                           'paymentMode'=>$paymentMode
                     )));
             $totalSanction = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->GetTotalNoOfSalarySanction();
             $result['totalSanctionSalary'] =  $totalSanction['totalSanctionSalary'];            
             $this->erpMessage->setJsonData($result);
             $this->erpMessage->setMessage($result['msg']);
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
     * @Route ("/payroll/reject_approved_salary_slip", name="_reject_approved_salary_slip")
     */
   /* public function rejectApprovedSalarySlipAction(Request $request)
    {          
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ApproveRejectSalaryWages');
	if($accessRight==1){
            try{   
               
                $result = $this->get(PayrollConstant::SERVICE_PAYROLL)->approvedOrRejectSalarySlip($request);
                
                 
                 //for unlink section for particular pdf file
                 foreach($result['pdfpatharray'] as $val)
                 {
                      $this->get('swiftmailer.command.spool_send')->run(new ArgvInput(array()), new ConsoleOutput());
                      unlink($val);
                 }
                 //ends here
                
                $salarySlipInfo = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($result['salarySlipID']);
               
                $allCreatedSalarySlip = $this->get(PayrollConstant::SERVICE_PAYROLL)->findAllCreatedSalarySlip();
                $paymentMode = $this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->findBy(array('recordActiveFlag' => 1));
                
                //for appending twig approval result in ui
                $this->erpMessage->setPath($this->renderView(PayrollConstant::TWIG_PAYROLL_APPROVAL_LIST,array('createdSalarySlip' => $allCreatedSalarySlip, 'paymentMode' => $paymentMode)));
               
               
                //section for showing salary slip
             $key= 'A';
             $empID =$result['empid'];
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
                
                //salary slip section ends here
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($sal_slip_status);
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
    }  */
    
    
    
    
    
    
    
    
    
    
}//end of class

 
