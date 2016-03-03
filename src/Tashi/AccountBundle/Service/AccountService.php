<?php
namespace Tashi\AccountBundle\Service;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\Container;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\AccountHeadMaster;
use Tashi\CommonBundle\Entity\AccountDetailsMaster;
use Tashi\CommonBundle\Entity\AccountCompanyBankTxn;
use Tashi\CommonBundle\Entity\CmnBankDetailsMaster;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\AccountBankCurrentBalance;
use Tashi\CommonBundle\Entity\AccountBankDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountCashCurrentBalance;
use Tashi\CommonBundle\Entity\AccountCashDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountSourceType;
use Tashi\CommonBundle\Entity\PayrolPaymentDetails;
use Tashi\CommonBundle\Entity\ProjectAdvancePayment;
use Tashi\CommonBundle\Entity\TransactionDate;
use Tashi\CommonBundle\Entity\EmpAccountExpenses;
use Tashi\CommonBundle\Entity\AccountTransactionContraReciept;
use Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster;
use Tashi\PayrollBundle\Helper\PayrollConstant;
use Tashi\CommonBundle\Entity\InvoicePaymentTxn;
use Tashi\CommonBundle\Entity\ContraTransactionMaster;
use Tashi\CommonBundle\Entity\CashTransactionRecord;
use Tashi\CommonBundle\Entity\BankTransactionRecord;
/*
 * To change this template, choose Tools | Templates   
 * and open the template in the editor. 
 */

/**
 * Description of AccountService
 *
 * @author Administrator
 */
class AccountService {
    //put your code here
    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;
    protected $mailer;
    protected $container;
    protected $pdf;
    protected $twig;

    public function __construct(EntityManager $em, Session $session, $rootDir,$commonService,$mailer,$pdf,$twig) 
    {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService=$commonService; 
        $this->mailer=$mailer;
        $this->pdf = $pdf; 
        $this->twig=$twig;
    }
    
    
    public function saveAccountHead($request){
                    
        $dataUI = json_decode($request->getContent());
        $acc_head_id = $dataUI->txt_acc_head_id;
        $acc_type = $dataUI->txt_acc_type;
        $acc_head_name = $dataUI->txt_acc_head_name;         
        $description = $dataUI->txt_description;
        try{     
            if($acc_head_id == ''){
               $accHeadObj = new AccountHeadMaster();                     
            }else{
                $accHeadObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find($acc_head_id);
            }

            $accHeadObj->setHeadName($acc_head_name);
            $accHeadObj->setDescription($description);
            $accHeadObj->setAccountTypeFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_TYPE_MASTER)->find($acc_type));
            $accHeadObj->setApplicationUserId($this->session->get('EMPID'));
            $accHeadObj->setApplicationUserIpAddress($this->session->get('IP'));
            $accHeadObj->setIsReserve(0);
            if ($acc_head_id == "") {
                 $accHeadObj->setRecordActiveFlag(1);
                 $accHeadObj->setRecordInsertDate(new \Datetime('NOW'));                
                 $this->em->persist($accHeadObj);
            } else {
                 $accHeadObj->setRecordUpdateDate(new \Datetime('NOW'));                
            }       
            $this->em->flush();
//            if ($acc_head_id == "") {
//            $returnmsg = 'Inserted new record successfully';
//        }else{
//            $returnmsg = 'Updated record successfully';
//        }
//                $result=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->findByRecordActiveFlag(1);
//                $id=$accHeadObj->getPkid();             
//            } catch (\Exception $ex) {
//            $returnmsg= $this->commonService->CommonError($ex,'dberror');
//        }
//        return array('msg' => $returnmsg,
//                                'all_acc_head' => $result,
//                                'acc_head_id' => $id,
//                            );
//    }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        if ($acc_head_id == "") {
            $msg = 'Inserted new record successfully';
        }else{
            $msg = 'Updated record successfully';
        }

        return array('msg' => $msg,
                     'all_acc_head' => $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->findByRecordActiveFlag(1),
                     'acc_head_id' => $accHeadObj->getPkid(),                   
                  ); 
        
        }
        
        
      public function loadAccountCommonList($account_type_id){
          try{     
            $accHeadObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->findBy(array('accountTypeFk' => $account_type_id, 'recordActiveFlag' => 1));            
        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $accHeadObj; 
      }
        
      public function retriveAccountHeadRecord($pkid){    
        try{     
            $accHeadObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find($pkid);
            $return_Arr = array(
                'acc_head_id' => $accHeadObj->getPkid(),
                'account_type' => $accHeadObj->getAccountTypeFk()->getPkid(),
                'account_head_name' => $accHeadObj->getHeadName(),
                'description' => $accHeadObj->getDescription()
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
     public function deleteAccountHeadRecord($pkid){    
        try{     
            $accHeadObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find($pkid);
            $accHeadObj->setRecordActiveFlag(0);               
            $accHeadObj->setRecordUpdateDate(new \Datetime('NOW'));  
            $accHeadObj->setApplicationUserId($this->session->get('EMPID'));
            $accHeadObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $msg = 'Deleted account head record successfully'; 
        
     }
     
           
     public function saveAcountEntry($request){
        $conn = $this->em->getConnection();  
        $conn->beginTransaction(); 
        
        $dataUI = json_decode($request->getContent());
        $account_id = $dataUI->txt_acc_id;
        $acc_head_id = $dataUI->txt_acc_head;         
        $acc_amount = $dataUI->txt_ammount; 
        $acc_entry_date = $dataUI->txt_entry_date; 
        $description = $dataUI->txt_description;
        $payment_mode = $dataUI->txt_payment_mode;
        $payment_number = $dataUI->txt_payment_number;
        $source_account_id = $dataUI->txt_enter_account_id;
        if($payment_mode == 1){
            $accountKey = 'cash';
        }else{
            $accountKey = 'bank';
        }
        $cashAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneByPkid(1);
        $cashBalance=$cashAcc?$cashAcc->getCurrentAmount():0;
        if($accountKey=='cash' && $cashBalance<$acc_amount){
            return array('code'=>0,'msg'=>'Your current balance is not sufficient.');
        }
        try{  
            $accHead=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find($acc_head_id);
            $accType=$accHead->getAccountTypeFk()->getPkid();
            $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
            $Empname = $EmpObj->getPersonFk()->getPersonName(); 
            
            if($accType==1){
                $suffix='R';
            }elseif($accType==2){
                $suffix='P';
            }
            if($account_id == ''){
               $accObj = new AccountDetailsMaster();               
            }else{
                $accObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->find($account_id);                
            }
            $accObj->setAmount($acc_amount);            
            $accObj->setDate(new \Datetime($acc_entry_date));
            $accObj->setDescription($description);
            $accObj->setAccountKey($accountKey);
            $accObj->setAccountId($source_account_id);
            $accObj->setAccountHeadFk($accHead);            
            $accObj->setApplicationUser($EmpObj);
            $accObj->setApplicationUserIpAddress($this->session->get('IP'));
            if ($account_id == "") {
                 $accObj->setRecordActiveFlag(1);
                 $accObj->setRecordInsertDate(new \Datetime('NOW'));                
                 $this->em->persist($accObj);
            } else {
                 $accObj->setRecordUpdateDate(new \Datetime('NOW'));                
            }            
            $this->em->flush();
            $accObj->setPrcFormat($suffix.$accObj->getPkid());
            $this->em->flush($accObj);
            //account part
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            if($accountKey == 'cash'){  
                //paymentMode = 1 is cash mode, then we select cash account                                     
                $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($source_account_id); 
                $currentCashBal = $cashObj->getCurrentAmount();
                $newBalance = $currentCashBal - $acc_amount;                             
                $cashObj->setCurrentAmount($newBalance);
                $cashObj->setRecordUpdateDate(new \Datetime('NOW'));
                $cashObj->setApplicationUserId($this->session->get('EMPID'));
                $this->em->flush();
                
                //for inserting into cash Deposit history
                $cashDepositHisObj = new AccountCashDipositWithdrawalHistory();
                $cashDepositHisObj->setDepositWithdrawalKey('W');
                $cashDepositHisObj->setAmount($acc_amount);
                $cashDepositHisObj->setDate(new \Datetime());
                $cashDepositHisObj->setDescription($description);
                $cashDepositHisObj->setRecordActiveFlag(1);
                $cashDepositHisObj->setRecordInsertDate(new \Datetime());
                $cashDepositHisObj->setCashAccountFk($cashObj);
                $cashDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

                                                                             

                $cashDepositHisObj->setDepositWithdrawalBy($Empname);
                $cashDepositHisObj->setBranchOfficeCode($branch_id);
                $cashDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($cashDepositHisObj);
                $this->em->flush();

            }else{
                //paymentMode != 1 is other mode, then we select bank account
                $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($source_account_id); 
                $currentBankBal = $findBankObj->getCurrentAmount();
                $newBalance = $currentBankBal - $acc_amount;
                $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid()); 
                $bankAccObj->setCurrentAmount($newBalance);
                $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
                $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
                $this->em->flush();

                //for inserting into bank Deposit history
                $bankDepositHisObj = new AccountBankDipositWithdrawalHistory();
                $bankDepositHisObj->setDepositWithdrawalKey('W');
                $bankDepositHisObj->setAmount($acc_amount);
                $bankDepositHisObj->setDate(new \Datetime());
                $bankDepositHisObj->setDescription($description);
                $bankDepositHisObj->setRecordActiveFlag(1);
                $bankDepositHisObj->setRecordInsertDate(new \Datetime());
                $bankDepositHisObj->setBankFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($source_account_id));
                $bankDepositHisObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));
                $bankDepositHisObj->setPaymentNo($payment_number);
                $bankDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

                $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                $Empname = $EmpObj->getPersonFk()->getPersonName();                                                              

                $bankDepositHisObj->setDepositWithdrawalBy($Empname);
                $bankDepositHisObj->setBranchOfficeCode($branch_id);
                $bankDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($bankDepositHisObj);
                $this->em->flush(); 
            }                                                                              
            //Saving transaction date
            $empid=$this->session->get('EMPID');
            $tranDate=$this->em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findBy(array('employeeId'=>$empid,'moduleId'=>'AE','recordActiveFlag'=>1));
            if(!$tranDate){
                $tranDate=new TransactionDate();
                $tranDate->setModuleId('AE');
                $tranDate->setEmployeeId($this->session->get('EMPID'));
                $tranDate->setLastSelectedDate(new \DateTime($acc_entry_date));
                $tranDate->setRecordInsertDate(new \DateTime("NOW"));
                $tranDate->setRecordActiveFlag(1);
                $this->em->persist($tranDate);
            }else{
                $tranDate[0]->setLastSelectedDate(new \DateTime($acc_entry_date));
                $tranDate[0]->setRecordUpdateDate(new \DateTime("NOW"));
            }    
            $this->em->flush($tranDate);                        
            $conn->commit();
            $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
            $currentYear =  date_format(new \Datetime('NOW'), 'Y'); 
            if ($account_id == "") {
                $msg = 'Successfully save account record';
            }else{
                $msg = 'Successfully updated account record';
            }
            return array('code'=>1,'msg' => $msg,
                'allIncomeAccountEntry' =>$this->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 1),
                'allExpenseAccountEntry' =>$this->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 2),
                'allContraTansaction'=>$this->selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, 3),
                'account_id' => $accObj->getPkid(),
                'currentMonth' => (int) $currentMonth,
                'currentYear' => $currentYear
            ); 
        } catch (\Exception $ex) {
            $conn->rollback();            
            $this->em->close();
            $msg='Could not complete your request at the moment. Error: '.$ex->getMessage();
            return array('code'=>0,'msg'=>$msg);
        }
        
        
        
        
        
      }
      
      public function searchAccountEntryAction($request) {
        try {      
            $dataUI = json_decode($request->getContent());
            $search_by = $dataUI->txt_search_by;
            $month = $dataUI->txt_month;
            $year = $dataUI->txt_year;
            $start_date = $dataUI->txt_startDate;
            $end_date = $dataUI->txt_endDate;
            
            //all incomes
            $allIncomeAccountEntry = $this->searchQueryForAccountEntryAction($search_by,$start_date,$end_date,$month,$year,1);
            //all expense
            $allExpenseAccountEntry = $this->searchQueryForAccountEntryAction($search_by,$start_date,$end_date,$month,$year,2);
            //all contra
            $allContraTansaction = $this->searchQueryForAccountEntryAction($search_by,$start_date,$end_date,$month,$year,3);
            
            
            $header = '';
            if($search_by == 'period'){
                $header = "From  &nbsp;&nbsp;&nbsp; ". $this->commonService->reverseDate($start_date)."&nbsp;&nbsp;&nbsp;   To    &nbsp;&nbsp;&nbsp;".$this->commonService->reverseDate($end_date);              
            }else if($search_by == 'month&year'){
                $month_Arr = array('January','February','March','April','May','June','July','August','September','October','November','December');
                $header = " Of ".  $month_Arr[$month-1]. ", ". $year;             
            } 
            if($month=='' && $year=='' && $start_date=='' && $end_date==''){
                $header = '';
            }
         
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('allIncomeAccountEntry'=>$allIncomeAccountEntry,
                     'allExpenseAccountEntry'=>$allExpenseAccountEntry, 
                     'allContraTansaction'=>$allContraTansaction,
                     'header'=>$header);
    }
    
    
    public function searchQueryForAccountEntryAction($search_by,$start_date,$end_date,$month,$year,$accountType) {
        try {
            $parameters = array();
            $queryString = "SELECT a 
                            FROM " . AccountConstant::ENT_ACCOUNT_DETAILS_MASTER . " a 
                            JOIN a.accountHeadFk accHead
                            WHERE a.recordActiveFlag = 1
                            AND accHead.accountTypeFk = :accountType ";
            
            if($search_by == 'period'){
                $queryString .= " AND a.date BETWEEN :startDate AND :endDate ";
                $parameters['startDate'] = $start_date;
                $parameters['endDate'] = $end_date;
            }else if($search_by == 'month&year'){
                $queryString .= " AND substring(a.date, 6, 2) = :month  
                                  AND substring(a.date, 1, 4) = :year ";
                $parameters['month'] = $month;
                $parameters['year'] = $year;
            }  
            $parameters['accountType'] = $accountType;
            $queryString .= " ORDER BY a.pkid desc ";
            // print_r($parameters) ; die(); 
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }
    
      public function selectAccountEntryRecordsByMonthOfYear($currentMonth, $currentYear, $accountTypePkid){
         try{ 
              
              $queryString = "SELECT a 
                              FROM ".AccountConstant::ENT_ACCOUNT_DETAILS_MASTER." a 
                              JOIN a.accountHeadFk accHead
                              WHERE substring(a.date, 6, 2) = :month
                              AND substring(a.date, 1, 4) = :year
                              AND a.recordActiveFlag = :activeFlag
                              AND accHead.accountTypeFk = :accountType
                              ORDER BY a.pkid desc";
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('month' => $currentMonth, 'year' => $currentYear, 'accountType' => $accountTypePkid, 'activeFlag' => 1));
              $result = $query->getResult(); 
                
         } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
           
        return $result;
      }
     
      public function selectAccountEntryAnyPeriod($periodDate, $accountTypePkid){ 
         try{          
              $queryString = "SELECT a 
                              FROM ".AccountConstant::ENT_ACCOUNT_DETAILS_MASTER." a 
                              JOIN a.accountHeadFk accHead
                              WHERE  a.recordActiveFlag = :activeFlag
                              AND a.date =:periodDate
                              AND accHead.accountTypeFk = :accountType
                              ORDER BY a.pkid desc";
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('accountType' => $accountTypePkid,'periodDate'=>$periodDate, 'activeFlag' => 1));
              $result = $query->getResult(); 
                
         } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
           
        return $result;
      }
      
      public function retriveAccountEntryRecord($pkid){    
        try{     
            $accObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->find($pkid);
            $acc_type_id = $accObj->getAccountHeadFk()->getAccountTypeFk()->getPkid();
            $return_Arr = array(
                'acc_id' => $accObj->getPkid(),
                'acc_type_id' => $accObj->getAccountHeadFk()->getAccountTypeFk()->getPkid(),
                'acc_head_id' => $accObj->getAccountHeadFk()->getPkid(),
                'acc_head_list' => $this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->findBy(array('accountTypeFk' => $acc_type_id, 'recordActiveFlag' => 1)),
                'amount' => $accObj->getAmount(),
                'date' => date_format($accObj->getDate(), 'Y-m-d'),
                'description' => $accObj->getDescription()
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
     public function deleteAccountEntryRecord($pkid){    
        try{     
            $accObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_DETAILS_MASTER)->find($pkid);
            $accObj->setRecordActiveFlag(0);               
            $accObj->setRecordUpdateDate(new \Datetime('NOW'));  
            $accObj->setApplicationUserId($this->session->get('EMPID'));
            $accObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $msg = 'Deleted entry account record successfully'; 
        
     }
     
     public  function saveCompanyBankAccount($request){ 
            $conn = $this->em->getConnection();       
         try{  
            $company_bank_id =  $request->request->get('txt_company_bank_id');
            //$company =  $request->request->get('txt_company');
            $bank_name =  $request->request->get('txt_bank_name');
            $branch_name =  $request->request->get('txt_branch_name');
            $branch_code =  $request->request->get('txt_branch_code');
            $account_type =  $request->request->get('txt_account_type');
            $micr_code =  $request->request->get('txt_micr_code');
            $ifsc_code =  $request->request->get('txt_ifsc_code');
            $account_name =  $request->request->get('txt_account_name');
            $account_no =  $request->request->get('txt_account_no');
            $contact_no =  $request->request->get('txt_contact_no');
            $account_balance =  $request->request->get('txt_account_balance');
            $location =  $request->request->get('txt_location');
            $balance=$request->request->get('txtBalance');
            $fileupload =  $request->files->get('txt_photoPassbook');
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            $document = '';
            $prevfilepath = '';          
            $uploadedFiles=array();
            $validFileTypes=array('');
            $conn->beginTransaction(); 
             
            // check account number already exist
            $account_flag = 0;
            $company=$this->em->getRepository(CommonConstant::ENT_COMPANY_MASTER)->findAll();
            if($company){
                $company=$company[0];
            }else{
                return array('account_flag' => $account_flag, 'msg' => 'Your Company\'s detail has not been entered yet. Please contact your administrator.');
            }
            if ($company_bank_id == '') {
                 $cmnBankObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->
                         findOneBy(array('accountNumber' => $account_no,'bankName'=>$bank_name, 'recordActiveFlag' => 1));
                 if($cmnBankObj){
                    $account_flag = 1;
                    return array('account_flag' => $account_flag, 'msg' => 'Account Number with the given Bank already exist !');
                }
             }else{
                $queryString = "SELECT bank
                               FROM ".CommonConstant::ENT_CMN_BANK_MASTER." bank 
                               WHERE bank.accountNumber = :accountNo
                               AND bank.bankPk != :bankID ";
                $query = $this->em->createQuery($queryString)
                                ->setParameters(array('accountNo' => $account_no, 'bankID' => $company_bank_id));
                $result = $query->getResult();
                if($result){ 
                     $account_flag = 1;
                     return array('account_flag' => $account_flag, 'msg' => 'Account Number already exist !');
                 }
             }
            /////// end of bank account checking /////////////
            
            
            if($company_bank_id == ''){                
               $compBankObj =  new CmnBankDetailsMaster();  
               $isDocNew=true;
            }else{              
               $compBankObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($company_bank_id);                          
               if($compBankObj->getPhotoScanDocFk()){
                    $isDocNew=false;
                    $document=$compBankObj->getPhotoScanDocFk();
               }else{
                    $isDocNew=true;
               }
            }
            
            if($document){
                $prevfilepath=$document->getPath();
            }
            //scan copy of bank passport file upload
                if(isset($fileupload)){        
                $path='upload/ACCOUNT/BANK DOCUMENTS/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);             
                if($fuploadresult['code']==1){  
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save image in document master
                    if(!$document){
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew=true;
                    }else{
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }                   
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if($isDocNew){
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if(file_exists($prevfilepath)){ 
                        unlink($prevfilepath);
                    }
                }
                else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                } 
            }  
                //end file upload $branch_id
            if($isDocNew){  
                if($document !== ''){  
                     $compBankObj->setPhotoScanDocFk($document);                   
                }
            } 
           
            $compBankObj->setBankName($bank_name);
            $compBankObj->setBranchName($branch_name);
            $compBankObj->setBranchCode($branch_code);
            $compBankObj->setMicrCode($micr_code);
            $compBankObj->setIfscCode($ifsc_code);
            $compBankObj->setAccountName($account_name);
            $compBankObj->setAccountNumber($account_no);
            $compBankObj->setContactNumber($contact_no);
            $compBankObj->setLocation($location);
            $compBankObj->setAccountTypeMasterFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_ACC_TYPE)->find($account_type));
            $compBankObj->setApplicationUserId($this->session->get('EMPID'));
            $compBankObj->setApplicationUserIpAddress($this->session->get('IP'));
            $compBankObj->setBranchOfficeCode($branch_id);
            if ($company_bank_id == "") {
                 $compBankObj->setRecordActiveFlag(1);
                 $compBankObj->setRecordInsertDate(new \Datetime('NOW'));                
                 $this->em->persist($compBankObj);
            } else {
                 $compBankObj->setRecordUpdateDate(new \Datetime('NOW'));               
            }       
            $this->em->flush();
            
            if($company_bank_id == ''){ 
               $compBankTxnObj =  new AccountCompanyBankTxn();
               $compBankTxnObj->setBankFk($compBankObj);
               $compBankTxnObj->setCompanyFk($company);             
               $compBankTxnObj->setRecordActiveFlag(1);
               $compBankTxnObj->setRecordInsertDate(new \Datetime('NOW'));
               $compBankTxnObj->setApplicationUserId($this->session->get('EMPID'));
               $compBankTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
               $compBankTxnObj->setBranchOfficeCode($branch_id);
               $this->em->persist($compBankTxnObj);
               $this->em->flush();
               
                //create new account zero balance
               $AccountBankCurrentBalanceObj = new AccountBankCurrentBalance();
               $AccountBankCurrentBalanceObj->setBankFk($compBankObj);
               $AccountBankCurrentBalanceObj->setCurrentAmount($account_balance);
               $AccountBankCurrentBalanceObj->setRecordActiveFlag(1);
               $AccountBankCurrentBalanceObj->setRecordInsertDate(new \Datetime('NOW'));
               $AccountBankCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
               $AccountBankCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
               $AccountBankCurrentBalanceObj->setBranchOfficeCode($branch_id);
               $this->em->persist($AccountBankCurrentBalanceObj);
               $this->em->flush();
               
               //Bank Transaction Record
               $bankTransaction=new BankTransactionRecord();
               $bankTransaction->setBankFk($compBankObj);
               $bankTransaction->setAmount($account_balance);
               $bankTransaction->setDrCr('Cr');
               $bankTransaction->setTransactionDate(new \DateTime("NOW"));
               $bankTransaction->setRemarks('Account Created.');
               $bankTransaction->setRecordActiveFlag(1);
               $bankTransaction->setRecordInsertDate(new \DateTime('NOW'));
               $bankTransaction->setApplicationUserId($this->session->get("EMPID"));
               $bankTransaction->setIpAddress($this->session->get('IP'));
               $this->em->persist($bankTransaction);
               $this->em->flush($bankTransaction);
            }                   
            
            $conn->commit(); 
            $account_flag=1;
         }catch (\Exception $ex) {
            $conn->rollback(); 
            $this->em->close();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $account_flag=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }  
        
        if ($company_bank_id == "") {
            $returnmsg = 'Bank Account detail has been saved successfully.';
            $company_bank_id = $compBankObj->getBankPk();
        }else{
            $returnmsg = 'Bank Account detail has been updated successfully.';
        }
        return array(
                     'account_flag' => $account_flag,
                     //'code' => $returncode,
                     'msg' => $returnmsg,
                     'allCompanyBank' => $this->findAllBankAccount($branch_id),
                     'company_bank_id' => $company_bank_id,                    
                  );       
     }
     
     
     
     
     
     public  function saveCompanyCashAccount($request){ 
            $conn = $this->em->getConnection();       
         try{  
            $company_cash_id =  $request->request->get('txt_company_cash_id');
            $balance =  $request->request->get('cash_amount');
            $description =  $request->request->get('description');
            //echo $company_cash_id.$balance.$description;die();
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            $conn->beginTransaction(); 
             
            // check account number already exist
            $account_flag = 0;
            
            if ($company_cash_id == '') {
                 $cmnCashObj = $this->em->getRepository(CommonConstant::ENT_CMN_CASHACCOUNT_MASTER)->
                         findOneBy(array('recordActiveFlag' => 1));
                 if($cmnCashObj){
                    $account_flag = 0;
                    return array('account_flag' => $account_flag, 'msg' => 'Cash Account already exist !');
                }
             }
            /////// end of bank account checking /////////////
             
            //for both insert and update part. 
            if ($company_cash_id == '') {
                $cmnCashObj = new AccountCashCurrentBalance();
            } else {
                $cmnCashObj = $this->em->getRepository(CommonConstant::ENT_CMN_CASHACCOUNT_MASTER)->find($company_cash_id);
            }
            
            if ($company_cash_id == "") {
                $cmnCashObj->setCreatedDate(new \Datetime('NOW'));
                $cmnCashObj->setRecordActiveFlag(1);
                $cmnCashObj->setRecordInsertDate(new \Datetime('NOW'));
                $cmnCashObj->setApplicationUserId($this->session->get('EMPID'));
                $cmnCashObj->setApplicationUserIpAddress($this->session->get('IP'));
                $cmnCashObj->setBranchOfficeCode($branch_id);
                $this->em->persist($cmnCashObj);
                $account_flag=1;
            } else {
                $cmnCashObj->setRecordUpdateDate(new \Datetime('NOW'));
                $cmnCashObj->setRecordActiveFlag(1);
                $cmnCashObj->setApplicationUserId($this->session->get('EMPID'));
                $cmnCashObj->setApplicationUserIpAddress($this->session->get('IP'));
                $cmnCashObj->setBranchOfficeCode($branch_id);
                $account_flag=1;
            }
                $cmnCashObj->setCurrentAmount($balance);
                $cmnCashObj->setDescription($description);
                $this->em->flush();

                $conn->commit();
            
            
         }catch (\Exception $ex) {
            $conn->rollback(); 
            $this->em->close();
            $account_flag=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
        }  
        
        if ($company_cash_id == "") {
            $returnmsg = 'Cash Account detail has been saved successfully.';
           
        }else{
            $returnmsg = 'Cash Account detail has been updated successfully.';
        }
        return array(
                     'account_flag' => $account_flag,'msg' => $returnmsg);       
     }
     
     public function findAllBankAccount($branch_id) {
        try {
            $result = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findBy(array('branchOfficeCode' => $branch_id, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }

        return $result;
    }
     
     public function retriveBankAccountRecord($pkid){    
        try{  
            
            $bankAccObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($pkid);
            $accBankTxnObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findOneByBankFk($bankAccObj->getBankPk());
            $balance='';
            if($bankAccObj->getPhotoScanDocFk()){
                $scan_doc_file = $bankAccObj->getPhotoScanDocFk()->getPath();
            }else{
                $scan_doc_file = '';
            }
            $return_Arr = array(               
                'company_bank_id' => $bankAccObj->getBankPk(),
                'company_id' => $accBankTxnObj->getCompanyFk()->getPkid(),
                'bankName' => $bankAccObj->getBankName(),
                'branchName' => $bankAccObj->getBranchName(),
                'branchCode' => $bankAccObj->getBranchCode(),
                'contactNo' => $bankAccObj->getContactNumber(),
                'accountName'=> $bankAccObj->getAccountName(),
                'accountNo' => $bankAccObj->getAccountNumber(),
                'accountBalance' => $bankAccObj->getAccountBalance(),
                'ifsc' => $bankAccObj->getIfscCode(),
                'micr' => $bankAccObj->getMicrCode(),
                'location' => $bankAccObj->getLocation(),
                'accountType' => $bankAccObj->getAccountTypeMasterFk()->getBankAccTypePk(),
                'scan_doc_file' => $scan_doc_file
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
     
     
     
     public function retriveAllCashAccountRecord($pkid){    
        try{  
            
            $cashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($pkid);
            
           
            $return_Arr = array(               
                'id' => $cashAccObj->getPkid(),
                'amount' => $cashAccObj->getCurrentAmount(),
                'des' =>$cashAccObj->getDescription()
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
    public function deleteBankAccountRecord($pkid){    
            $conn = $this->em->getConnection();       
        try{  
            $conn->beginTransaction();
            $bankAccObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($pkid);
            $bankAccObj->setRecordActiveFlag(0);               
            $bankAccObj->setRecordUpdateDate(new \Datetime('NOW')); 
            $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
            $bankAccObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            $accBankTxnObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findOneByBankFk($bankAccObj->getBankPk());           
            $accBankTxnObj->setRecordActiveFlag(0);               
            $accBankTxnObj->setRecordUpdateDate(new \Datetime('NOW')); 
            $accBankTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $accBankTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit(); 
        } catch (\Exception $ex) {
             $conn->rollback();  
             $this->em->close();
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $msg = 'Deleted Bank Account record successfully'; 
        
     }
     
     public function loadCurrentBankStatus($cash_or_bank_id, $account_key){    
        try{   
            $current_balance = 0;
            switch($account_key){
            case 'CA':  $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($cash_or_bank_id);
                        if($cashObj){
                            $current_balance = $cashObj->getCurrentAmount();
                        }
                        $return_Arr = array('current_balance' => $current_balance, 'account_key' => $account_key);
                        break;
                    
            case 'BA':  $bankObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($cash_or_bank_id);                       
                        $currentBankStatusObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($cash_or_bank_id); 
                        if($currentBankStatusObj){
                            $current_balance = $currentBankStatusObj->getCurrentAmount();
                        }
                        $return_Arr = array('account_no' => $bankObj->getAccountNumber(),
                                            'current_balance' => $current_balance,
                                            'account_key' => $account_key);
                        break;
           }  
            

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
    
    public  function saveBankDepositWidrawal($request){
        $conn = $this->em->getConnection();       
        try{ 
            $bank_deposite_withdrawal_id =  $request->request->get('txt_bank_deposite_withdrawal_id');
            $tranTypeCode=$request->request->get('inputTranType'); 
            $sourceBankId=$request->request->get('sourceBank'); 
            $targetBankId=$request->request->get('targetBank');        
            $amount =  $request->request->get('txt_deposit_withdrawal_amount');
            $date =  $request->request->get('txt_deposit_withdrawal_date');
            $deposit_withdrawal_by =  $request->request->get('txt_deposit_withdrawal_by');      
            $description =  $request->request->get('txt_description');      
            $fileupload =  $request->files->get('txt_deposit_withdrawal_reciept');
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            $tranType=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE)->findOneByCustom1($tranTypeCode);
            //$paymentmode=$this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->find($payment_mode_id);
            $sourceBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($sourceBankId);
            $targetBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($targetBankId);
            $cashAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
            $document = '';
            $prevfilepath = '';          
            $uploadedFiles=array();
            $validFileTypes=array('');   
            
            if($tranTypeCode=="CB"){
                if($cashAcc->getCurrentAmount()-$amount<0){
                    return array('msg'=>'There is no sufficient amount in cash account.','code' => 0);
                }
            }
            $conn->beginTransaction(); 
            if(isset($fileupload)){        
                $path='upload/ACCOUNT/BANK RECEIPT/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);             
                if($fuploadresult['code']==1){  
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save image in document master
                    if(!$document){
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));                       
                        $isDocNew=true;
                    }else{
                        $document->setRecordInsertDate(new \DateTime("NOW"));                        
                    }   
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if($isDocNew){
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if(file_exists($prevfilepath)){ 
                        unlink($prevfilepath);
                    }
                }else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                } 
            }
            
                      
            $contraMaster=new ContraTransactionMaster();
            $cashTransaction=new CashTransactionRecord();
            $bankTransaction=new BankTransactionRecord();            
            
            if(isset($document)){
                $contraMaster->setProofFk($document);
            }
            $contraMaster->setTransactionTypeFk($tranType);                
            switch($tranTypeCode){
                case 'CB':                    
                    $contraMaster->setTargetFk($targetBank);
                    break;
                case 'BC':
                    $contraMaster->setSourceFk($sourceBank);
                    break;
                case 'BB':
                    $contraMaster->setSourceFk($sourceBank);
                    $contraMaster->setTargetFk($targetBank);
                    break;
            }
            $contraMaster->setTransactionDate(new \DateTime($date));
            $contraMaster->setTransactionBy($deposit_withdrawal_by);
            //$contraMaster->setTransactionNo($payment_no);
            $contraMaster->setRemarks($description);
            $contraMaster->setRecordActiveFlag(1);
            if($bank_deposite_withdrawal_id == ''){
                $contraMaster->setRecordInsertDate(new \DateTime("NOW"));
            }else{
                $contraMaster->setRecordUpdateDate(new \DateTime("NOW"));
            }
            $contraMaster->setApplicationUserIpAddress($this->session->get('IP'));
            $contraMaster->setApplicationUserId($branch_id);
            $this->em->persist($contraMaster);
            $this->em->flush($contraMaster);
            //SAVE IN CASH/BANK TRANSACTION RECORD
            switch($tranType){
                case 'CB':
                    //Cash Transaction
                    $cashTransaction->setCashFk($cashAcc);
                    $cashTransaction->setContraFk($contraMaster);
                    $cashTransaction->setAmount($amount);
                    $cashTransaction->setDrCr('Dr');
                    $cashTransaction->setTransactionDate($date);
                    $cashTransaction->setRemarks($description);
                    $cashTransaction->setRecordActiveFlag(1);
                    $cashTransaction->setIpAddress($this->session->get("IP"));
                    $cashTransaction->setApplicationUserId($branch_id);                    
                    $cashTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($cashTransaction);                    
                    $this->em->flush($cashTransaction);
                    
                    //Deduct From Cash Account
                    
                    $currentCashBal=$cashAcc->getCurrentAmount();
                    $cashAcc->setCurrentAmount($currentCashBal-$amount);
                    $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $cashAcc->setApplicationUserIdAddress($this->session->get('IP'));
                    $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($cashAcc);
                    //Bank Transaction
                    $bankTransaction->setBankFk($targetBank);
                    $bankTransaction->setContraFk($contraMaster);
                    $bankTransaction->setAmount($amount);
                    $bankTransaction->setDrCr('Dr');
                    $bankTransaction->setTransactionDate($date);
                    $bankTransaction->setRemarks($description);
                    $bankTransaction->setRecordActiveFlag(1);
                    $bankTransaction->setIpAddress($this->session->get("IP"));
                    $bankTransaction->setApplicationUserId($this->session->get('EMPID'));                    
                    $bankTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($bankTransaction);
                    $this->em->flush($bankTransaction);
                    //Add to Bank Balance
                    $bankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy($targetBank);
                    $currBankBal=$bankAcc->getCurrentAmount();
                    $bankAcc->setCurrentAmount($currBankBal+$amount);
                    $bankAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $bankAcc->setApplicationUserIdAddress($this->session->get('IP'));
                    $bankAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($bankAcc);
                    break;
                case 'BB':
                    break;
                case 'BC':
                    break;
            }            
            $conn->commit(); 
            $returncode=1;
         }catch (\Exception $ex) {
            $conn->rollback(); 
            $this->em->close();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
            return array('msg'=>$returnmsg,'code' => $returncode);
        }  
        
        if ($bank_deposite_withdrawal_id == "") {
            $returnmsg = 'Transaction Detail has been saved successfully.';            
        }else{
            $returnmsg = 'Changes has been saved successfully.';
        }
        $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
        $currentYear =  date_format(new \Datetime('NOW'), 'Y');
        return array(                   
                     'code' => $returncode,
                     'msg' => $returnmsg,
                     //'bankDepositWithdrawalRecord' => $this->selectBankDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id),
                     //'bank_deposite_withdrawal_id' => $AccountBankObj->getPkid(),
                     'currentMonth' => (int) $currentMonth, 
                     'currentYear' => $currentYear
                  );       
    }
    public function SaveContraTransaction($request){
        $conn = $this->em->getConnection();
        try{ 
            $bank_deposite_withdrawal_id =  $request->request->get('txt_bank_deposite_withdrawal_id');
            //$deposit_withdrawal_key =  $request->request->get('txt_deposit_withdrawal_key'); 
            $tranTypeCode=$request->request->get('inputTranType'); 
            $sourceBankId=$request->request->get('sourceBank'); 
            $targetBankId=$request->request->get('targetBank');            
            $amount =  $request->request->get('txt_deposit_withdrawal_amount');
            $date =  $request->request->get('txt_deposit_withdrawal_date');
            $deposit_withdrawal_by =  $request->request->get('txt_deposit_withdrawal_by');      
            $description =  $request->request->get('txt_description');      
            $fileupload =  $request->files->get('txt_deposit_withdrawal_reciept');
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            $tranType=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE)->findOneByCustom1($tranTypeCode);
            if(!empty($sourceBankId)){
                $sourceBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find(explode('&',$sourceBankId)[1]);
            }
            if(!empty($targetBankId)){
                $targetBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find(explode('&',$targetBankId)[1]);
            }
            $cashAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
            //$document = '';
            $prevfilepath = '';          
            $uploadedFiles=array();
            $validFileTypes=array('');   
            
            if($tranTypeCode=="CB"){
                if($cashAcc->getCurrentAmount()-$amount<0){
                    return array('msg'=>'There is no sufficient amount in cash account.','code' => 0);
                }
            }
            $conn->beginTransaction(); 
            if(isset($fileupload)){        
                $path='upload/ACCOUNT/BANK RECEIPT/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);             
                if($fuploadresult['code']==1){  
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save/upate cmb_document_master
                    $existingFilepath='';
                    $document = new CmnDocumentMaster();
                    $document->setRecordActiveFlag(1);
                    $document->setRecordInsertDate(new \DateTime("NOW"));            
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);                    
                    $this->em->persist($document);                    
                    $this->em->flush($document);
                    if(file_exists($existingFilepath)){ //delete existing file if exist.
                        unlink($existingFilepath);
                    }
                    if(file_exists($prevfilepath)){ 
                        unlink($prevfilepath);
                    }
                }else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                } 
            }
            $contraMaster=new ContraTransactionMaster();
            $cashTransaction=new CashTransactionRecord();
            $bankTransaction=new BankTransactionRecord();            
            if(isset($document)){
                $contraMaster->setProofFk($document);
            }
            $contraMaster->setTransactionTypeFk($tranType);
            $contraMaster->setAmount($amount);
            //$contraMaster->setTransactionModeFk($paymentmode);                
            switch($tranTypeCode){
                case 'CB':                    
                    if(isset($targetBank)){
                        $contraMaster->setTargetFk($targetBank);
                    }
                    break;
                case 'BC':
                    if(isset($sourceBank)){
                        $contraMaster->setSourceFk($sourceBank);
                    }
                    break;
                case 'BB':
                    if(isset($sourceBank) && isset($targetBank)){
                        $contraMaster->setSourceFk($sourceBank);
                        $contraMaster->setTargetFk($targetBank);
                    }
                    break;
            }
            $contraMaster->setTransactionDate(new \DateTime($date));
            $contraMaster->setTransactionBy($deposit_withdrawal_by);
            //$contraMaster->setTransactionNo($payment_no);
            $contraMaster->setRemarks($description);
            $contraMaster->setRecordActiveFlag(1);

            $contraMaster->setRecordInsertDate(new \DateTime("NOW"));
            $contraMaster->setApplicationUserIpAddress($this->session->get('IP'));
            $contraMaster->setApplicationUserId($branch_id);
            $this->em->persist($contraMaster);
            $this->em->flush($contraMaster);
            $latestNo=$contraMaster->getPkid();
            $contraMaster->setReceiptNo('C'.$latestNo);
            $this->em->flush($contraMaster);
            //SAVE IN CASH/BANK TRANSACTION RECORD
            switch($tranTypeCode){
                case 'CB':
                    //Cash Transaction
                    $cashTransaction->setCashFk($cashAcc);
                    $cashTransaction->setContraFk($contraMaster);
                    $cashTransaction->setAmount($amount);
                    $cashTransaction->setDrCr('Dr');
                    $cashTransaction->setTransactionDate(new \DateTime($date));
                    $cashTransaction->setRemarks($description);
                    $cashTransaction->setRecordActiveFlag(1);
                    $cashTransaction->setIpAddress($this->session->get("IP"));
                    $cashTransaction->setApplicationUserId($branch_id);
                    $cashTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($cashTransaction);                    
                    $this->em->flush($cashTransaction);
                    //Deduct From Cash Account
                    $currentCashBal=$cashAcc->getCurrentAmount();
                    $cashAcc->setCurrentAmount($currentCashBal-$amount);
                    $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $cashAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($cashAcc);
                    //Bank Transaction
                    $bankTransaction->setBankFk($targetBank);
                    $bankTransaction->setContraFk($contraMaster);
                    $bankTransaction->setAmount($amount);
                    $bankTransaction->setDrCr('Cr');
                    $bankTransaction->setTransactionDate(new \DateTime($date));
                    $bankTransaction->setRemarks($description);
                    $bankTransaction->setRecordActiveFlag(1);
                    $bankTransaction->setIpAddress($this->session->get("IP"));
                    $bankTransaction->setApplicationUserId($this->session->get('EMPID'));
                    $bankTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($bankTransaction);                   
                    $this->em->flush($bankTransaction);
                    //Add to Bank Balance
                    $bankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$targetBank,'recordActiveFlag'=>1));
                    $currBankBal=$bankAcc->getCurrentAmount();
                    $bankAcc->setCurrentAmount($currBankBal+$amount);
                    $bankAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $bankAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $bankAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($bankAcc);
                    break;
                case 'BB':
                    //Source Bank Transaction
                    $sBankTran=new BankTransactionRecord();                        
                    $sBankTran->setContraFk($contraMaster);
                    $sBankTran->setRecordActiveFlag(1);
                    $sBankTran->setRecordInsertDate(new \DateTime("NOW"));
                    $sBankTran->setBankFk($sourceBank);
                    $sBankTran->setAmount($amount);
                    $sBankTran->setDrCr('Dr');
                    $sBankTran->setTransactionDate(new \DateTime($date));
                    $sBankTran->setRemarks($description);                    
                    $sBankTran->setIpAddress($this->session->get("IP"));
                    $sBankTran->setApplicationUserId($branch_id);                     
                    $this->em->persist($sBankTran);
                        
                    //Deduct From Source Bank Account
                    $sBankBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$sourceBank,'recordActiveFlag'=>1));
                    $sBankBal->setCurrentAmount($sBankBal->getCurrentAmount()-$amount);
                    $sBankBal->setRecordUpdateDate(new \DateTime("NOW"));
                    $sBankBal->setApplicationUserIpAddress($this->session->get('IP'));
                    $sBankBal->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($sBankBal);
                    
                    //Target Bank Transaction
                    $tBankTran=new BankTransactionRecord();                        
                    $tBankTran->setContraFk($contraMaster);  
                    $tBankTran->setRecordActiveFlag(1);
                    $tBankTran->setRecordInsertDate(new \DateTime("NOW"));                         
                    $tBankTran->setBankFk($targetBank);
                    $tBankTran->setDrCr('Cr');
                    $tBankTran->setAmount($amount);                    
                    $tBankTran->setTransactionDate(new \DateTime($date));
                    $tBankTran->setRemarks($description);                    
                    $tBankTran->setIpAddress($this->session->get("IP"));
                    $tBankTran->setApplicationUserId($this->session->get('EMPID'));                                          
                    $this->em->persist($tBankTran);
                    $this->em->flush($tBankTran);
                    //Add to Target Bank Balance
                    $tBankBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$targetBank,'recordActiveFlag'=>1));
                    $currBankBal=$tBankBal->getCurrentAmount();
                    $tBankBal->setCurrentAmount($currBankBal+$amount);
                    $tBankBal->setRecordUpdateDate(new \DateTime("NOW"));
                    $tBankBal->setApplicationUserIpAddress($this->session->get('IP'));
                    $tBankBal->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($tBankBal);
                    break;
                case 'BC':
                    //Cash Transaction
                    $cashTransaction->setCashFk($cashAcc);
                    $cashTransaction->setContraFk($contraMaster);
                    $cashTransaction->setAmount($amount);
                    $cashTransaction->setDrCr('Cr');
                    $cashTransaction->setTransactionDate(new \DateTime($date));
                    $cashTransaction->setRemarks($description);
                    $cashTransaction->setRecordActiveFlag(1);
                    $cashTransaction->setIpAddress($this->session->get("IP"));
                    $cashTransaction->setApplicationUserId($branch_id);                    
                    $cashTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($cashTransaction);                    
                    $this->em->flush($cashTransaction);
                    //Add to Cash Account
                    $currentCashBal=$cashAcc->getCurrentAmount();
                    $cashAcc->setCurrentAmount($currentCashBal+$amount);
                    $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $cashAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($cashAcc);
                    //Bank Transaction
                    $bankTransaction->setBankFk($sourceBank);
                    $bankTransaction->setContraFk($contraMaster);
                    $bankTransaction->setAmount($amount);
                    $bankTransaction->setDrCr('Dr');
                    $bankTransaction->setTransactionDate(new \DateTime($date));
                    $bankTransaction->setRemarks($description);
                    $bankTransaction->setRecordActiveFlag(1);
                    $bankTransaction->setIpAddress($this->session->get("IP"));
                    $bankTransaction->setApplicationUserId($this->session->get('EMPID'));
                    //if($bank_deposite_withdrawal_id==''){
                        $bankTransaction->setRecordInsertDate(new \DateTime("NOW"));
                        $this->em->persist($bankTransaction);
//                    }else{
//                        $cashTransaction->setRecordUpdateDate(new \DateTime("NOW"));
//                    }
                    $this->em->flush($bankTransaction);
                    //Deduct from Source Bank Balance
                    $bankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$sourceBank,'recordActiveFlag'=>1));
                    $currBankBal=$bankAcc->getCurrentAmount();
                    $bankAcc->setCurrentAmount($currBankBal-$amount);
                    $bankAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $bankAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $bankAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($bankAcc);
                break;            
            }
            //If user chose to delete the file then delete it.
            $existingDoc=$contraMaster->getProofFk();
            if($existingDoc){                
                if($request->request->get('inputIsDel')==1){
                    if(file_exists($existingDoc->getPath())){
                        unlink($existingDoc->getPath());
                    }
                    $this->em->remove($existingDoc);
                    $this->em->flush($existingDoc);
                }
            }
            $conn->commit(); 
            $returncode=1;
            $returnmsg = 'Transaction Detail has been saved successfully.';  
         }catch (\Exception $ex) {
            $conn->rollback(); 
            $this->em->close();
            foreach($uploadedFiles as $file){
                if(file_exists($file)){
                    unlink($file);
                }
            }
            $returncode=0;
            $returnmsg='Unable to process due to an unexpected server error. Error:'.$ex->getMessage();
            return array('msg'=>$returnmsg,'code' => $returncode);
        }
        return array('code' => $returncode,'msg' => $returnmsg);
    }
    public function EditContraTransaction($request){
        $conn = $this->em->getConnection();
        try{
            $bank_deposite_withdrawal_id =  $request->request->get('txt_bank_deposite_withdrawal_id');
            //$deposit_withdrawal_key =  $request->request->get('txt_deposit_withdrawal_key'); 
            $tranTypeCode=$request->request->get('inputTranType'); 
            $sourceBankId=$request->request->get('sourceBank'); 
            $targetBankId=$request->request->get('targetBank');            
            $amount =  $request->request->get('txt_deposit_withdrawal_amount');
            $date =  $request->request->get('txt_deposit_withdrawal_date');
            $deposit_withdrawal_by =  $request->request->get('txt_deposit_withdrawal_by');      
            $description =  $request->request->get('txt_description');      
            $fileupload =  $request->files->get('txt_deposit_withdrawal_reciept');
            $isDelete=$request->files->get('inputIsDel');
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            $tranType=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE)->findOneByCustom1($tranTypeCode);
            if(!empty($sourceBankId)){
                $sourceBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find(explode('&',$sourceBankId)[1]);
            }
            if(!empty($targetBankId)){
                $targetBank=$this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find(explode('&',$targetBankId)[1]);
            }
            $cashAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
            //$document = '';
            $prevfilepath = '';          
            $uploadedFiles=array();
            $validFileTypes=array('');   
            $conn->beginTransaction();
            //Deactivate all related Existing Record
            $prevcontraMaster=$this->em->getRepository(AccountConstant::ENT_CONTRA_TRANSACTION)->find($bank_deposite_withdrawal_id);
            $prevRcptNo=$prevcontraMaster->getReceiptNo();
            $prevDoc=$prevcontraMaster->getProofFk();
            if($isDelete=='1' || $fileupload!=null){
                if($prevDoc){
                    $prevDoc->setRecordActiveFlag(0);
                    $prevDoc->setRecordUpdateDate(new \DateTime());
                    $prevDoc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($prevDoc);
                }
            }
            $prevCashTransaction=$this->em->getRepository(AccountConstant::ENT_CASH_TRANSACTION)->findByContraFk($prevcontraMaster);
            if($prevCashTransaction){
                foreach($prevCashTransaction as $ctran){
                    $camt=$ctran->getAmount();
                    $ctrantype=$ctran->getDrCr();
                    $ctran->setRecordActiveFlag(0);
                    $ctran->setRecordUpdateDate(new \DateTime("NOW"));
                    $this->em->flush($ctran);
                    if($ctrantype=='Dr'){
                        $cbal=$cashAcc->getCurrentAmount();
                        $cashAcc->setCurrentAmount($cbal+$camt);
                        $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                        $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->flush($cashAcc);
                    }elseif($ctrantype=='Cr'){
                        $cbal=$cashAcc->getCurrentAmount();
                        if($cbal-$camt<0){
                            $conn->rollBack();
                            $conn->close();
                            return array('code'=>1,'msg'=>'You request could not be completed as this could affect your account history.');
                        }
                        $cashAcc->setCurrentAmount($cbal-$camt);
                        $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                        $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->flush($cashAcc);
                    }                    
                }
            }
            $prevBankTransaction=$this->em->getRepository(AccountConstant::ENT_BANK_TRANSACTION)->findByContraFk($prevcontraMaster);
            if($prevBankTransaction){
                foreach($prevBankTransaction as $btran){
                    $bamt=$btran->getAmount();
                    $btrantype=$btran->getDrCr();
                    $bbank=$btran->getBankFk();
                    $bBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$bbank,'recordActiveFlag'=>1));
                    $bBal=$bBalAcc->getCurrentAmount();
                    
                    $btran->setRecordActiveFlag(0);
                    $btran->setRecordUpdateDate(new \DateTime("NOW"));
                    $this->em->flush($btran);
                    if($btrantype=='Dr'){
                        $bBalAcc->setCurrentAmount($bBal+$bamt);
                        $bBalAcc->setRecordUpdateDate(new \DateTime("NOW"));
                        $bBalAcc->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->flush($bBalAcc);
                    }elseif($btrantype=='Cr'){                
                        $bBalAcc->setCurrentAmount($bBal-$bamt);
                        $bBalAcc->setRecordUpdateDate(new \DateTime("NOW"));
                        $bBalAcc->setApplicationUserId($this->session->get('EMPID'));
                        $this->em->flush($bBalAcc);
                    }                    
                }
            }
            $prevcontraMaster->setRecordActiveFlag(0);         
            $prevcontraMaster->setRecordUpdateDate(new \DateTime("NOW"));
            $prevcontraMaster->setApplicationUserId($this->session->get('EMPID'));
            $this->em->flush($prevcontraMaster);
            
            //Add new transaction
            $cashAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
            if($tranTypeCode=="CB"){
                if($cashAcc->getCurrentAmount()-$amount<0){
                    return array('msg'=>'There is no sufficient amount in cash account.','code' => 0);
                }
            }
            if(isset($fileupload)){        
                $path='upload/ACCOUNT/BANK RECEIPT/';
                $fuploadresult=$this->commonService->UploadFile($fileupload,$path,0,$validFileTypes);             
                if($fuploadresult['code']==1){  
                    $uploadedFiles[]=$fuploadresult['fullpath'];
                    //save/upate cmb_document_master
                    $existingFilepath='';
                    $document = new CmnDocumentMaster();
                    $document->setRecordActiveFlag(1);
                    $document->setRecordInsertDate(new \DateTime("NOW"));            
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $document->setPath($path.$fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);                    
                    $this->em->persist($document);                    
                    $this->em->flush($document);
                    if(file_exists($existingFilepath)){ //delete existing file if exist.
                        unlink($existingFilepath);
                    }
                    if(file_exists($prevfilepath)){ 
                        unlink($prevfilepath);
                    }
                }else{
                    $conn->rollBack();
                    foreach($uploadedFiles as $file){
                        if(file_exists($file)){
                            unlink($file);
                        }
                    }
                    return array('code'=>0,'msg'=>$fuploadresult['msg']);
                } 
            }
            $contraMaster=new ContraTransactionMaster();
            $cashTransaction=new CashTransactionRecord();
            $bankTransaction=new BankTransactionRecord();         
            if($isDelete!='1' && $fileupload==null){ //if file/document of proof
                $contraMaster->setProofFk($prevDoc);
            }
            if(isset($document)){
                $contraMaster->setProofFk($document);
            }
            $contraMaster->setTransactionTypeFk($tranType);
            $contraMaster->setAmount($amount);
            //$contraMaster->setTransactionModeFk($paymentmode);                
            switch($tranTypeCode){
                case 'CB':                    
                    if(isset($targetBank)){
                        $contraMaster->setTargetFk($targetBank);
                    }
                    break;
                case 'BC':
                    if(isset($sourceBank)){
                        $contraMaster->setSourceFk($sourceBank);
                    }
                    break;
                case 'BB':
                    if(isset($sourceBank) && isset($targetBank)){
                        $contraMaster->setSourceFk($sourceBank);
                        $contraMaster->setTargetFk($targetBank);
                    }
                    break;
            }
            $contraMaster->setTransactionDate(new \DateTime($date));
            $contraMaster->setTransactionBy($deposit_withdrawal_by);            
            //$contraMaster->setTransactionNo($payment_no);
            $contraMaster->setRemarks($description);
            $contraMaster->setRecordActiveFlag(1);
            $contraMaster->setReceiptNo($prevRcptNo);
            $contraMaster->setRecordInsertDate(new \DateTime("NOW"));
            $contraMaster->setApplicationUserIpAddress($this->session->get('IP'));
            $contraMaster->setApplicationUserId($branch_id);
            $this->em->persist($contraMaster);
            //SAVE IN CASH/BANK TRANSACTION RECORD
            switch($tranTypeCode){
                case 'CB':
                    //Cash Transaction
                    $cashTransaction->setCashFk($cashAcc);
                    $cashTransaction->setContraFk($contraMaster);
                    $cashTransaction->setAmount($amount);
                    $cashTransaction->setDrCr('Dr');
                    $cashTransaction->setTransactionDate(new \DateTime($date));
                    $cashTransaction->setRemarks($description);
                    $cashTransaction->setRecordActiveFlag(1);
                    $cashTransaction->setIpAddress($this->session->get("IP"));
                    $cashTransaction->setApplicationUserId($branch_id);
                    $cashTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($cashTransaction);                    
                    $this->em->flush($cashTransaction);
                    //Deduct From Cash Account
                    $currentCashBal=$cashAcc->getCurrentAmount();
                    $cashAcc->setCurrentAmount($currentCashBal-$amount);
                    $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $cashAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($cashAcc);
                    //Bank Transaction
                    $bankTransaction->setBankFk($targetBank);
                    $bankTransaction->setContraFk($contraMaster);
                    $bankTransaction->setAmount($amount);
                    $bankTransaction->setDrCr('Cr');
                    $bankTransaction->setTransactionDate(new \DateTime($date));
                    $bankTransaction->setRemarks($description);
                    $bankTransaction->setRecordActiveFlag(1);
                    $bankTransaction->setIpAddress($this->session->get("IP"));
                    $bankTransaction->setApplicationUserId($this->session->get('EMPID'));
                    $bankTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($bankTransaction);                   
                    $this->em->flush($bankTransaction);
                    //Add to Bank Balance
                    $bankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$targetBank,'recordActiveFlag'=>1));
                    $currBankBal=$bankAcc->getCurrentAmount();
                    $bankAcc->setCurrentAmount($currBankBal+$amount);
                    $bankAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $bankAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $bankAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($bankAcc);
                    break;
                case 'BB':
                    //Source Bank Transaction
                    $sBankTran=new BankTransactionRecord();                        
                    $sBankTran->setContraFk($contraMaster);
                    $sBankTran->setRecordActiveFlag(1);
                    $sBankTran->setRecordInsertDate(new \DateTime("NOW"));
                    $sBankTran->setBankFk($sourceBank);
                    $sBankTran->setAmount($amount);
                    $sBankTran->setDrCr('Dr');
                    $sBankTran->setTransactionDate(new \DateTime($date));
                    $sBankTran->setRemarks($description);                    
                    $sBankTran->setIpAddress($this->session->get("IP"));
                    $sBankTran->setApplicationUserId($branch_id);                     
                    $this->em->persist($sBankTran);
                        
                    //Deduct From Source Bank Account
                    $sBankBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$sourceBank,'recordActiveFlag'=>1));
                    $sBankBal->setCurrentAmount($sBankBal->getCurrentAmount()-$amount);
                    $sBankBal->setRecordUpdateDate(new \DateTime("NOW"));
                    $sBankBal->setApplicationUserIpAddress($this->session->get('IP'));
                    $sBankBal->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($sBankBal);
                    
                    //Target Bank Transaction
                    $tBankTran=new BankTransactionRecord();                        
                    $tBankTran->setContraFk($contraMaster);  
                    $tBankTran->setRecordActiveFlag(1);
                    $tBankTran->setRecordInsertDate(new \DateTime("NOW"));                         
                    $tBankTran->setBankFk($targetBank);
                    $tBankTran->setDrCr('Cr');
                    $tBankTran->setAmount($amount);                    
                    $tBankTran->setTransactionDate(new \DateTime($date));
                    $tBankTran->setRemarks($description);                    
                    $tBankTran->setIpAddress($this->session->get("IP"));
                    $tBankTran->setApplicationUserId($this->session->get('EMPID'));                                          
                    $this->em->persist($tBankTran);
                    $this->em->flush($tBankTran);
                    //Add to Target Bank Balance
                    $tBankBal=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$targetBank,'recordActiveFlag'=>1));
                    $currBankBal=$tBankBal->getCurrentAmount();
                    $tBankBal->setCurrentAmount($currBankBal+$amount);
                    $tBankBal->setRecordUpdateDate(new \DateTime("NOW"));
                    $tBankBal->setApplicationUserIpAddress($this->session->get('IP'));
                    $tBankBal->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($tBankBal);
                    break;
                case 'BC':
                    //Cash Transaction
                    $cashTransaction->setCashFk($cashAcc);
                    $cashTransaction->setContraFk($contraMaster);
                    $cashTransaction->setAmount($amount);
                    $cashTransaction->setDrCr('Cr');
                    $cashTransaction->setTransactionDate(new \DateTime($date));
                    $cashTransaction->setRemarks($description);
                    $cashTransaction->setRecordActiveFlag(1);
                    $cashTransaction->setIpAddress($this->session->get("IP"));
                    $cashTransaction->setApplicationUserId($branch_id);                    
                    $cashTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($cashTransaction);                    
                    $this->em->flush($cashTransaction);
                    //Add to Cash Account
                    $currentCashBal=$cashAcc->getCurrentAmount();
                    $cashAcc->setCurrentAmount($currentCashBal+$amount);
                    $cashAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $cashAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $cashAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($cashAcc);
                    //Bank Transaction
                    $bankTransaction->setBankFk($sourceBank);
                    $bankTransaction->setContraFk($contraMaster);
                    $bankTransaction->setAmount($amount);
                    $bankTransaction->setDrCr('Dr');
                    $bankTransaction->setTransactionDate(new \DateTime($date));
                    $bankTransaction->setRemarks($description);
                    $bankTransaction->setRecordActiveFlag(1);
                    $bankTransaction->setIpAddress($this->session->get("IP"));
                    $bankTransaction->setApplicationUserId($this->session->get('EMPID'));
                    $bankTransaction->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($bankTransaction);                    
                    $this->em->flush($bankTransaction);
                    //Deduct from Source Bank Balance
                    $bankAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$sourceBank,'recordActiveFlag'=>1));
                    $currBankBal=$bankAcc->getCurrentAmount();
                    $bankAcc->setCurrentAmount($currBankBal-$amount);
                    $bankAcc->setRecordUpdateDate(new \DateTime("NOW"));
                    $bankAcc->setApplicationUserIpAddress($this->session->get('IP'));
                    $bankAcc->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->flush($bankAcc);
                break;            
            }
            $rcode=1;
            $rmsg='Transaction detail has been updated successfully.';
            $conn->commit();
        } catch (\Exception $ex){
            $conn->rollBack();
            $rcode=0;
            $rmsg='An unexpected error were encountered while processing your request. Error:'.$ex->getMessage();
        }
        return(array('code'=>$rcode,'msg'=>$rmsg));
    }
    public function DeleteContraTransaction($pkid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $userId=$this->session->get('EMPID');
            $ipadd=$this->session->get('IP');
            $contra=$this->em->getRepository(AccountConstant::ENT_CONTRA_TRANSACTION)->find($pkid);
            $tranType=$contra->getTransactionTypeFk();
            $tranAmt=$contra->getAmount();
            switch($tranType->getCustom1()){
                case 'CB':
                    $cTran=$this->em->getRepository(AccountConstant::ENT_CASH_TRANSACTION)->findOneByContraFk($contra);                    
                    $bTran=$this->em->getRepository(AccountConstant::ENT_BANK_TRANSACTION)->findOneByContraFk($contra);       
                    $bank=$contra->getTargetFk();
                    $cashBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
                    $cashBal=$cashBalAcc->getCurrentAmount();
                    $bankBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$bank,'recordActiveFlag'=>1));
                    $bankBal=$bankBalAcc->getCurrentAmount();
                    
                    //since the amount was debited from Cash we need to refund the amount back to the Cash Ac
                    $cashBalAcc->setCurrentAmount($cashBal+$tranAmt);
                    $this->em->flush($cashBalAcc);
                    //deduct the amount from the credited Bank
                    $bankBalAcc->setCurrentAmount($bankBal-$tranAmt);
                    $this->em->flush($bankBalAcc);
                    
                    //delete the related record from Cash Transaction
                    $cTran->setRecordActiveFlag(0);
                    $cTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $cTran->setApplicationUserId($userId);
                    $cTran->setIpAddress($ipadd);
                    $this->em->flush($cTran);
                    //delete the related record from Bank Transaction
                    $bTran->setRecordActiveFlag(0);
                    $bTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $bTran->setApplicationUserId($userId);
                    $bTran->setIpAddress($ipadd);
                    $this->em->flush($bTran);
                    
                    //Insert into Cash Transaction as new statement for the credited amount
                    $newCTran=new CashTransactionRecord();
                    $newCTran->setCashFk($cashBalAcc);
                    $newCTran->setAmount($tranAmt);
                    $newCTran->setDrCr('Cr');
                    $newCTran->setTransactionDate(new \DateTime("NOW"));
                    $newCTran->setRemarks('Refund: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newCTran->setRecordActiveFlag(1);
                    $newCTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newCTran->setApplicationUserId($userId);
                    $newCTran->setIpAddress($ipadd);
                    $this->em->persist($newCTran);
                    $this->em->flush($newCTran);                    
                
                    //Insert into Bank Transaction as new statement for the debited amount
                    $newBTran=new BankTransactionRecord();
                    $newBTran->setBankFk($bankBalAcc);
                    $newBTran->setAmount($tranAmt);
                    $newBTran->setDrCr('Dr');
                    $newBTran->setTransactionDate(new \DateTime("NOW"));
                    $newBTran->setRemarks('Deducted: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newBTran->setRecordActiveFlag(1);
                    $newBTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newBTran->setApplicationUserId($userId);
                    $newBTran->setIpAddress($ipadd);
                    $this->em->persist($newBTran);
                    $this->em->flush($newBTran);
                    break;
                case 'BC':
                    $cTran=$this->em->getRepository(AccountConstant::ENT_CASH_TRANSACTION)->findOneByContraFk($contra);
                    $bTran=$this->em->getRepository(AccountConstant::ENT_BANK_TRANSACTION)->findOneByContraFk($contra);
                    $bank=$bTran->getBankFk(); 
                    $cashBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
                    $cashBal=$cashBalAcc->getCurrentAmount();
                    $bankBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$bank,'recordActiveFlag'=>1));
                    $bankBal=$bankBalAcc->getCurrentAmount();
                    
                    //since the amount was Credited to Cash Balance we need to deduct the amount back from the Cash Ac
                    if($cashBal-$tranAmt<0){
                        $conn->rollBack();
                        return array('code'=>1,'msg'=>'Deleting this record will make Cash Balance (-)ve which is not allowed. Process Terminated.');
                    }
                    $cashBalAcc->setCurrentAmount($cashBal-$tranAmt);
                    $this->em->flush($cashBalAcc);
                    //refund the amount to the Bank from which the amount was debited
                    $bankBalAcc->setCurrentAmount($bankBal+$tranAmt);
                    $this->em->flush($bankBalAcc);
                    
                    //delete the related record from Cash Transaction
                    $cTran->setRecordActiveFlag(0);
                    $cTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $cTran->setApplicationUserId($userId);
                    $cTran->setIpAddress($ipadd);
                    $this->em->flush($cTran);
                    //delete the related record from Bank Transaction
                    $bTran->setRecordActiveFlag(0);
                    $bTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $bTran->setApplicationUserId($userId);
                    $bTran->setIpAddress($ipadd);
                    $this->em->flush($bTran);
                    
                    //Insert into Cash Transaction as new statement for the credited amount
                    $newCTran=new CashTransactionRecord();
                    $newCTran->setCashFk($cashBalAcc);
                    $newCTran->setAmount($tranAmt);
                    $newCTran->setDrCr('Dr');
                    $newCTran->setTransactionDate(new \DateTime("NOW"));
                    $newCTran->setRemarks('Deducted: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newCTran->setRecordActiveFlag(1);
                    $newCTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newCTran->setApplicationUserId($userId);
                    $newCTran->setIpAddress($ipadd);
                    $this->em->persist($newCTran);
                    $this->em->flush($newCTran);                    
                
                    //Insert into Bank Transaction as new statement for the debited amount
                    $newBTran=new BankTransactionRecord();
                    $newBTran->setBankFk($bankBalAcc);
                    $newBTran->setAmount($tranAmt);
                    $newBTran->setDrCr('Cr');
                    $newBTran->setTransactionDate(new \DateTime("NOW"));
                    $newBTran->setRemarks('Refund: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newBTran->setRecordActiveFlag(1);
                    $newBTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newBTran->setApplicationUserId($userId);
                    $newBTran->setIpAddress($ipadd);
                    $this->em->persist($newBTran);
                    $this->em->flush($newBTran);
                    break;
                case 'BB':                    
                    $sBank=$contra->getSourceFk();
                    $tBank=$contra->getSourceFk();
                    $bank=$bTran->getBankFk(); 
                    $cashBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
                    $cashBal=$cashBalAcc->getCurrentAmount();
                    $bankBalAcc=$this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneBy(array('bankFk'=>$bank,'recordActiveFlag'=>1));
                    $bankBal=$bankBalAcc->getCurrentAmount();
                    
                    //since the amount was Credited to Cash Balance we need to deduct the amount back from the Cash Ac
                    if($cashBal-$tranAmt<0){
                        $conn->rollBack();
                        return array('code'=>1,'msg'=>'Deleting this record will make Cash Balance (-)ve which is not allowed. Process Terminated.');
                    }
                    $cashBalAcc->setCurrentAmount($cashBal-$tranAmt);
                    $this->em->flush($cashBalAcc);
                    //refund the amount to the Bank from which the amount was debited
                    $bankBalAcc->setCurrentAmount($bankBal+$tranAmt);
                    $this->em->flush($bankBalAcc);
                    
                    //delete the related record from Cash Transaction
                    $cTran->setRecordActiveFlag(0);
                    $cTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $cTran->setApplicationUserId($userId);
                    $cTran->setIpAddress($ipadd);
                    $this->em->flush($cTran);
                    //delete the related record from Bank Transaction
                    $bTran->setRecordActiveFlag(0);
                    $bTran->setRecordUpdateDate(new \DateTime("NOW"));
                    $bTran->setApplicationUserId($userId);
                    $bTran->setIpAddress($ipadd);
                    $this->em->flush($bTran);
                    
                    //Insert into Cash Transaction as new statement for the credited amount
                    $newCTran=new CashTransactionRecord();
                    $newCTran->setCashFk($cashBalAcc);
                    $newCTran->setAmount($tranAmt);
                    $newCTran->setDrCr('Dr');
                    $newCTran->setTransactionDate(new \DateTime("NOW"));
                    $newCTran->setRemarks('Deducted: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newCTran->setRecordActiveFlag(1);
                    $newCTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newCTran->setApplicationUserId($userId);
                    $newCTran->setIpAddress($ipadd);
                    $this->em->persist($newCTran);
                    $this->em->flush($newCTran);                    
                
                    //Insert into Bank Transaction as new statement for the debited amount
                    $newBTran=new BankTransactionRecord();
                    $newBTran->setBankFk($bankBalAcc);
                    $newBTran->setAmount($tranAmt);
                    $newBTran->setDrCr('Cr');
                    $newBTran->setTransactionDate(new \DateTime("NOW"));
                    $newBTran->setRemarks('Refund: For Deletion of the Record with Receipt No: '.$contra->getReceipNo());
                    $newBTran->setRecordActiveFlag(1);
                    $newBTran->setRecordInsertDate(new \DateTime("NOW"));
                    $newBTran->setApplicationUserId($userId);
                    $newBTran->setIpAddress($ipadd);
                    $this->em->persist($newBTran);
                    $this->em->flush($newBTran);
                    break;
            }
            $code=1; $msg='Record has been deleted successfully.'; $conn->commit();
        }catch (\Exception $ex){
            $conn->rollBack();
            $code=0;
            $msg='An unexpected error were encountered while processing your request. Error:'.$ex->getMessage();
        }
        return(array('code'=>$code,'msg'=>$msg));
    }
    public function selectBankDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id){
         try{             
            $queryString = "SELECT a 
                              FROM ".AccountConstant::ENT_ACCOUNT_BANK_DEPOSIT_WITHDRAWAL_HISTORY." a                             
                              WHERE substring(a.date, 6, 2) = :month
                              AND substring(a.date, 1, 4) = :year
                              AND a.recordActiveFlag = :activeFlag
                              AND a.branchOfficeCode = :branchOffice
                              ORDER BY a.pkid desc";
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('month' => $currentMonth, 'year' => $currentYear, 'branchOffice' => $branch_id, 'activeFlag' => 1));
              $result = $query->getResult(); 
                
         } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        
        return $result;
      }
   public function loadBankDepositWithdrawalRecordsByDate($branch_id, $date){
         try{             
              $queryString = "SELECT a 
                              FROM ".AccountConstant::ENT_ACCOUNT_BANK_DEPOSIT_WITHDRAWAL_HISTORY." a                             
                              WHERE a.date = :date
                              AND a.recordActiveFlag = :activeFlag
                              AND a.branchOfficeCode = :branchOffice
                              ORDER BY a.pkid desc";
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('date' => $date, 'branchOffice' => $branch_id, 'activeFlag' => 1));
              $result = $query->getResult(); 
                
         } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        
        return $result;
      }
     
    public function retriveBankDepositWidrawalHistory($pkid){  
        try{     
            $bankDepositWithdrawObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_DEPOSIT_WITHDRAWAL_HISTORY)->find($pkid);
            $currentBankAccStatusObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($bankDepositWithdrawObj->getBankFk()->getBankPk());
            if($bankDepositWithdrawObj->getReceiptDocFk()){
                $receipt_doc_file = $bankDepositWithdrawObj->getReceiptDocFk()->getPath();
            }else{
                $receipt_doc_file = '';
            }
            $return_Arr = array(               
                'bank_deposite_withdrawal_id' => $pkid,                
                'bank_id' => $bankDepositWithdrawObj->getBankFk()->getBankPk(),
                'deposit_widrawal_key' => $bankDepositWithdrawObj->getDepositWithdrawalKey(),
                'account_no' => $bankDepositWithdrawObj->getBankFk()->getAccountNumber(),
                'current_balance' => $currentBankAccStatusObj->getCurrentAmount(),
                'amount' => $bankDepositWithdrawObj->getAmount(),
                'date' =>  date_format($bankDepositWithdrawObj->getDate(), 'Y-m-d'),
                'payment_mode_id' => $bankDepositWithdrawObj->getPaymentModeFk()->getPkid(),
                'payement_no' => $bankDepositWithdrawObj->getPaymentNo(),
                'payement_mode_cash_check_val' => $bankDepositWithdrawObj->getPaymentModeFk()->getIspaymentNoRequired(),
                'deposit_withdraw_by' => $bankDepositWithdrawObj->getDepositWithdrawalBy(),
                'description' => $bankDepositWithdrawObj->getDescription(),
                'receipt_doc_file' => $receipt_doc_file               
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
     public function deleteBankDepositWidrawalRecord($pkid){    
            $conn = $this->em->getConnection();       
        try{  
            $conn->beginTransaction();
            $bankDepositWithdrawObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_DEPOSIT_WITHDRAWAL_HISTORY)->find($pkid);
            $bankDepositWthdrawalKey = $bankDepositWithdrawObj->getDepositWithdrawalKey();
            $amount = $bankDepositWithdrawObj->getAmount();
            
            $bankDepositWithdrawObj->setRecordActiveFlag(0);               
            $bankDepositWithdrawObj->setRecordUpdateDate(new \Datetime('NOW')); 
            $bankDepositWithdrawObj->setApplicationUserId($this->session->get('EMPID'));
            $bankDepositWithdrawObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($bankDepositWithdrawObj->getBankFk()->getBankPk()); 
            $currentBankAccStatusObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid());
            $current_balance = $currentBankAccStatusObj->getCurrentAmount();
            switch($bankDepositWthdrawalKey){
               case 'D' :  $current_balance = $current_balance - $amount;
                           break;
               case 'W' :  $current_balance = $current_balance + $amount;
                           break;
            }
            $currentBankAccStatusObj->setCurrentAmount($current_balance);                         
            $currentBankAccStatusObj->setRecordUpdateDate(new \Datetime('NOW'));
            $currentBankAccStatusObj->setApplicationUserId($this->session->get('EMPID'));
            $currentBankAccStatusObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            $conn->commit(); 
        } catch (\Exception $ex) {
             $conn->rollback();  
             $this->em->close();
             throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $msg = 'Deleted  record successfully'; 
        
     }
     
     public function createCashAccount($request){    
        $dataUI = json_decode($request->getContent());
        $cash_acc_id = $dataUI->txt_cash_acc_id;
        $employee_pkid = $dataUI->txt_employee_pkid;         
        $create_date = $dataUI->txt_create_date;        
        $description = $dataUI->txt_description; 
        $status = $dataUI->txt_record_active_key;
        $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
        try{    
            // check cash account already exist
            $cash_acc_flag = 0;
            if ($cash_acc_id == '') {
                 $findCashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('empFk' => $employee_pkid, 'branchOfficeCode' => $branch_id, 'recordActiveFlag' => 1));
                 if($findCashAccObj){
                    $cash_acc_flag = 1;
                    return array('cash_acc_flag' => $cash_acc_flag, 'msg' => 'Already created Cash Account for the selected employee !');
                }else{
                    $cashAccObj = new AccountCashCurrentBalance();  
                }
             }else{
                $cashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($cash_acc_id);
             }
            /////// end of cash account checking /////////////
            
            $cashAccObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($employee_pkid));           
            $cashAccObj->setCreatedDate(new \Datetime($create_date));
            $cashAccObj->setDescription($description);  
            $cashAccObj->setCurrentAmount(0);
            $cashAccObj->setApplicationUserId($this->session->get('EMPID'));
            $cashAccObj->setApplicationUserIpAddress($this->session->get('IP'));
            $cashAccObj->setBranchOfficeCode($branch_id);
            $cashAccObj->setStatus($status);
            if($cash_acc_id == "") {        
                 $cashAccObj->setRecordActiveFlag(1);
                 $cashAccObj->setRecordInsertDate(new \Datetime('NOW'));               
                 $this->em->persist($cashAccObj);
            } else {
                 $cashAccObj->setRecordUpdateDate(new \Datetime('NOW'));                
            }       
            $this->em->flush();

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        if ($cash_acc_id == "") {
            $msg = 'Inserted new record successfully';
        }else{
            $msg = 'Updated record successfully';
        }             
        return array('msg' => $msg,
                     'cash_acc_flag' => $cash_acc_flag,                    
                     'allCashAccount' => $this->findCashAccount($branch_id)                                     
                  ); 
        
      }
       
      public function findCashAccount($branch_id) {
        try {
            $result = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('branchOfficeCode' => $branch_id, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }

        return $result;
    }
    
    public function retriveCashAccountRecord($pkid){  
        try{     
            $cashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($pkid);                
            $return_Arr = array(               
                'cash_acc_id' => $pkid,                
                'emp_pkid' => $cashAccObj->getEmpFk()->getEmployeePk(),
                'emp_id' => $cashAccObj->getEmpFk()->getEmployeeId(),
                'emp_designation' => $cashAccObj->getEmpFk()->getEmpJobTitleFk()->getJobTitleName(),                          
                'create_date' =>  date_format($cashAccObj->getCreatedDate(), 'Y-m-d'),
                'status' => $cashAccObj->getStatus(),              
                'description' => $cashAccObj->getDescription(),                          
            );

        } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }   

        return $return_Arr; 
        
     }
     
      public function deleteCashAccountRecord($pkid){              
        try{            
            $cashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($pkid); 
            $branch_id = $cashAccObj->getBranchOfficeCode(); 
            $cashAccObj->setRecordActiveFlag(0);             
            $cashAccObj->setRecordUpdateDate(new \Datetime('NOW')); 
            $cashAccObj->setApplicationUserId($this->session->get('EMPID'));
            $cashAccObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();                    
        } catch (\Exception $ex) {           
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }         
        return array('msg' => 'Deleted Bank Account record successfully',                                  
                     'allCashAccount' => $this->findCashAccount($branch_id)                                     
                  ); 
        
     }
     
     public function laodSourceCategory($request){              
        try{           
            $source_type_id = $request->request->get('source_type_id');   
                    
            $employees = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('departmentFk' => $branch_id, 'employementTypeFk' => 1, 'recordActiveFlag' => 1));  
            $allCashAccount = $this->get(AccountConstant::SERVICE_ACCOUNT)->findCashAccount($branch_id);
            $resultObj = '';
            if($source_type_id == 1){
                  //bank account
                  $resultObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_COMPANY_BANK_TXN)->findOneByBankFk();
            }
                       
                           
        } catch (\Exception $ex) {           
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }         
        return array('msg' => 'Deleted Bank Account record successfully',                                  
                     'allCashAccount' => $this->findCashAccount($branch_id)                                     
                  ); 
        
     }
     
     
     public  function saveCashDepositWithdrawal($request){
            $conn = $this->em->getConnection();       
      try{         
            $deposit_withdrawal_key =  $request->request->get('txt_deposit_withdrawal_key'); 
            $cash_account =  $request->request->get('txt_cash_account');        
            $amount =  $request->request->get('txt_deposit_withdrawal_amount');
            $current_cash_balance =  $request->request->get('txt_current_balance');
            $date =  $request->request->get('txt_deposit_withdrawal_date');  
            $deposit_withdraw_by =  $request->request->get('txt_deposit_withdrawal_by');            
            if(!null == $request->request->get('txt_source_type')){
                $source_type =  $request->request->get('txt_source_type');   
            }else{
                $source_type =  ''; 
            }
            if(!null == $request->request->get('txt_source_id')){
                $source_id =  $request->request->get('txt_source_id');  
            }else{
                $source_id =  ''; 
            }
            $description =  $request->request->get('txt_description'); 
            $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
            
            $conn->beginTransaction();    
            $accCashDipositWithdrawHisObj = new AccountCashDipositWithdrawalHistory();
            $accCashDipositWithdrawHisObj->setDepositWithdrawalKey($deposit_withdrawal_key);
            $accCashDipositWithdrawHisObj->setAmount($amount);
            $accCashDipositWithdrawHisObj->setDate(new \Datetime($date));
            $accCashDipositWithdrawHisObj->setDepositWithdrawalBy($deposit_withdraw_by);
            $accCashDipositWithdrawHisObj->setDescription($description);
            $accCashDipositWithdrawHisObj->setCashAccountFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($cash_account));
            $accCashDipositWithdrawHisObj->setSourceTypeFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_SOURCE)->find($source_type));           
            $accCashDipositWithdrawHisObj->setSourceId($source_id);
            $accCashDipositWithdrawHisObj->setApplicationUserId($this->session->get('EMPID'));
            $accCashDipositWithdrawHisObj->setApplicationUserIpAddress($this->session->get('IP'));
            $accCashDipositWithdrawHisObj->setBranchOfficeCode($branch_id);  
            $accCashDipositWithdrawHisObj->setRecordActiveFlag(1);
            $accCashDipositWithdrawHisObj->setRecordInsertDate(new \Datetime('NOW'));               
            $this->em->persist($accCashDipositWithdrawHisObj);
            $this->em->flush();
            
            //adjust cash or bank balance
            if($source_type != ''){
                if($deposit_withdrawal_key == 'D'){
                    if($source_type == 1){
                        //adjust bank balance        
                        $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($source_id);           
                        $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid());                       
                        $db_current_bank_balance = $bankAccObj->getCurrentAmount();                           
                        $bankAccObj->setCurrentAmount(($db_current_bank_balance - $amount));                                     
                        $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
                        $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
                        $bankAccObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $bankAccObj->setBranchOfficeCode($branch_id); 
                        $this->em->flush();                                                           
                        
                    }
                }
            }
                       
            //update current cash account 
            $cashAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($cash_account);    
            if($deposit_withdrawal_key == 'D'){
                $cashAccObj->setCurrentAmount(($current_cash_balance + $amount));
            }elseif ($deposit_withdrawal_key == 'W') {
                $cashAccObj->setCurrentAmount(($current_cash_balance - $amount));
            }           
            $cashAccObj->setRecordUpdateDate(new \Datetime('NOW'));
            $cashAccObj->setApplicationUserId($this->session->get('EMPID'));
            $cashAccObj->setApplicationUserIpAddress($this->session->get('IP'));
            $cashAccObj->setBranchOfficeCode($branch_id); 
            $this->em->flush();
            
            //Saving transaction date
            $empid=$this->session->get('EMPID');
            $tranDate=$this->em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findBy(array('employeeId'=>$empid,'moduleId'=>'CT','recordActiveFlag'=>1));
            if(!$tranDate){
                $tranDate=new TransactionDate();
                $tranDate->setModuleId('CT');
                $tranDate->setEmployeeId($this->session->get('EMPID'));
                $tranDate->setLastSelectedDate(new \DateTime($date));
                $tranDate->setRecordInsertDate(new \DateTime("NOW"));
                $tranDate->setRecordActiveFlag(1);
                $this->em->persist($tranDate);
            }else{
                $tranDate[0]->setLastSelectedDate(new \DateTime($date));
                $tranDate[0]->setRecordUpdateDate(new \DateTime("NOW"));
            }    
            $this->em->flush($tranDate);
            
            $conn->commit(); 
            
            $cashAccountDetails = $this->findCashAccount($branch_id);          
            
         }catch (\Exception $ex) {
            $conn->rollback();  
            $this->em->close();
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }  
           
        $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
        $currentYear =  date_format(new \Datetime('NOW'), 'Y');
        return array(                                     
                     'msg' => 'Save record successfully',
                     'cashDepositWithdrawalRecord' => $this->selectCaseDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id),                   
                     'currentMonth' => (int) $currentMonth, 
                     'currentYear' => $currentYear,
                     'cashAcountPkid' => $cashAccountDetails->getPkid(),
                     'cashAccountCurrentBalance' => $cashAccountDetails->getCurrentAmount()
                  );       
     }
     
     public function selectCaseDepositWithdrawalRecordsByMonthOfYear($currentMonth, $currentYear, $branch_id){
         try{             
              $queryString = "SELECT a 
                              FROM ".AccountConstant::ENT_ACCOUNT_CASH_DEPOSIT_WITHDRAWAL_HISTORY." a                             
                              WHERE substring(a.date, 6, 2) = :month
                              AND substring(a.date, 1, 4) = :year
                              AND a.recordActiveFlag = :activeFlag
                              AND a.branchOfficeCode = :branchOffice
                              ORDER BY a.pkid desc";
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('month' => $currentMonth, 
                                               'year' => $currentYear, 
                                               'branchOffice' => $branch_id, 
                                               'activeFlag' => 1));
              $result = $query->getResult(); 
                
         } catch (\Exception $ex) {
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        
        return $result;
      }
      
    public function saveAdjustedCustomerAdvance($request) {
            $conn = $this->em->getConnection();  
            $conn->beginTransaction(); 
       try{
            $dataUI = json_decode($request->getContent());
            //$customer_id = $dataUI->txt_customer_id;
                     
            //all advance collection pkid of the particular customer
            $advance_collection_pkid_Arr = array();
            if (is_string($dataUI->txt_customer_advance_pkid)) {
                $advance_collection_pkid_Arr[0] = $dataUI->txt_customer_advance_pkid; //for only one 
            } else {
                $advance_collection_pkid_Arr = $dataUI->txt_customer_advance_pkid;     //for more than one       
            }
            $this->updateCustomerAdvanceToAdjusted($advance_collection_pkid_Arr);
            
            //all due invoice pkid of the project of a particular customer          
            if(isset($dataUI->txt_customer_due_invoice_pkid)){ 
                $due_invoice_pkid_Arr = array();
                if (is_string($dataUI->txt_customer_due_invoice_pkid)) {
                    $due_invoice_pkid_Arr[0] = $dataUI->txt_customer_due_invoice_pkid; //for only one 
                } else {
                    $due_invoice_pkid_Arr = $dataUI->txt_customer_due_invoice_pkid;     //for more than one       
                }
                $this->saveProjectInvoiceDueAdjust($due_invoice_pkid_Arr, $dataUI); 
            }                
            
            //all project pkid of the particular customer
            $project_pkid_Arr = array();
            if (is_string($dataUI->txt_customer_project_pkid)) {
                $project_pkid_Arr[0] = $dataUI->txt_customer_project_pkid; //for only one 
            } else {
                $project_pkid_Arr = $dataUI->txt_customer_project_pkid;     //for more than one       
            }
            $this->saveCustomerProjectAdvanceAmount($project_pkid_Arr, $dataUI);                                
            
            $conn->commit(); 
        }catch (\Exception $ex) {
            $conn->rollback();  
            $this->em->close();
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
        }

        return;
    }
    
    public function saveProjectInvoiceDueAdjust($due_invoice_pkid_Arr, $dataUI){
        try{
            if(count($due_invoice_pkid_Arr) > 0){
                foreach($due_invoice_pkid_Arr as $pkid){
                    $txt_adjust_invoice_due_balance = 'txt_invoice_adjust_due_amount'.$pkid;    // invoice advance field name              
                    $adjust_invoice_due_balance = $dataUI->$txt_adjust_invoice_due_balance;
                    
                    $invoiceObj = $this->em->getRepository(CommonConstant::ENT_INVOICE_MASTER)->find($pkid);
                    $invoiceDueBalance_db = $invoiceObj->getBalance();
                    $differ_balance = $invoiceDueBalance_db - $adjust_invoice_due_balance;
                    if($differ_balance == 0){                       
                        $invoiceObj->setIsDue(0);
                    }elseif($differ_balance > 0) {
                        $invoiceObj->setIsDue(1);
                    }
                    $invoiceObj->setBalance($differ_balance);
                    $invoiceObj->setDeposit($adjust_invoice_due_balance);
                    $invoiceObj->setApplicationUserId($this->session->get('EMPID'));
                    $invoiceObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $invoiceObj->setRecordActiveFlag(1);
                    $invoiceObj->setRecordInsertDate(new \Datetime('NOW'));               
                    $this->em->persist($invoiceObj);
                    $this->em->flush($invoiceObj);
                    //inserting into invoice payment txn
                    $paytxn=new InvoicePaymentTxn();
                    $paytxn->setInvoiceFk($invoiceObj);
                    $paytxn->setAmount($adjust_invoice_due_balance);
                    $paytxn->setRecordActiveFlag(1);
                    $paytxn->setRecordInsertDate(new \DateTime("NOW"));
                    $this->em->persist($paytxn);
                    $this->em->flush($paytxn);                                       
                }               
            }         
            
        }catch (\Exception $ex) {          
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
        }  
        return;
    }
    
    public function saveCustomerProjectAdvanceAmount($project_pkid_Arr, $dataUI){
        try{
            foreach ($project_pkid_Arr as $pkid) {
                $txt_project_advance_amount = 'txt_project_advance_amount'.$pkid; // project advance field name     
                $project_advance_amount = $dataUI->$txt_project_advance_amount;
                
                //set project advance amount
                if(!empty($project_advance_amount) &&  !is_null($project_advance_amount)){
                      $txt_alert_amount = 'txt_alert_amount'.$pkid; // alert amount field name
                      $txt_alert_pc = 'txt_alert_pc'.$pkid;         // alert pc field name
                      $alert_amount = $dataUI->$txt_alert_amount;
                      $alert_pc = $dataUI->$txt_alert_pc;
                      
                      $proAdvanceObj = new ProjectAdvancePayment();
                      $proAdvanceObj->setAmount($project_advance_amount);
                      $proAdvanceObj->setProjectFk($this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($pkid));
                      $proAdvanceObj->setAlertPc($alert_amount);
                      $proAdvanceObj->setApplicationUserId($this->session->get('EMPID'));  
                      $proAdvanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                      $proAdvanceObj->setRecordActiveFlag(1);
                      $proAdvanceObj->setRecordInsertDate(new \Datetime('NOW'));               
                      $this->em->persist($proAdvanceObj);
                      $this->em->flush();
                      
                      //update project master to amount limit 
                      $projectMasterObj = $this->em->getRepository(CommonConstant::ENT_PROJ_MASTER)->find($pkid);
                      $projectMasterObj->setAmtLimit($alert_amount);                    
                      $projectMasterObj->setRecordUpdateDate(new \Datetime('NOW'));                                   
                      $this->em->flush();
                }                
            }
            
        }catch (\Exception $ex) {          
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.'.$ex->getMessage());
        }
        return;
    }
    
    public function updateCustomerAdvanceToAdjusted($advance_collection_pkid_Arr){
        try{
            foreach ($advance_collection_pkid_Arr as $pkid) {
                $cusAvanceObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($pkid);
                $cusAvanceObj->setIsAdjusted(1);
                $cusAvanceObj->setRecordUpdateDate(new \Datetime('NOW')); 
                $cusAvanceObj->setApplicationUserId($this->session->get('EMPID')); 
                $cusAvanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }
            
        }catch (\Exception $ex) {          
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        return;
    }
    
    public function findDistinctCustomerFromPaymentCollection(){
        try{
            $queryString = "SELECT DISTINCT(cus) customerIdPk, cus.customerId, cus.customerName
                              FROM ".CommonConstant::CUSTOMER_ADVANCE_PAYMENT." c
                              JOIN c.customerFk cus
                              WHERE c.paymentStatus = 'A'                             
                              AND c.recordActiveFlag = 1
                              AND c.isAdjusted = 0 ";                             
                      
              $query = $this->em->createQuery($queryString);
              $result = $query->getResult();           
        }catch (\Exception $ex) {          
            throw new \Exception($ex->getMessage());
        }
        return $result;            
    }
    
    public function findByParticularProjectTotalExpense($projectPkid){
        try{
            $queryString = "SELECT SUM(e.amount) total_expense
                              FROM ".CommonConstant::ENT_PROJ_EXPENSE." e                             
                              WHERE e.projectFk = :projectPkid                             
                              AND e.recordActiveFlag = :activeFlag
                              AND e.approvalFlag = :approvalFlag ";                             
                      
              $query = $this->em->createQuery($queryString)
                         ->setParameters(array('projectPkid' => $projectPkid, 
                                               'activeFlag' => 1,
                                               'approvalFlag' => 1));
              $result = $query->getSingleResult();           
        }catch (\Exception $ex) {          
            throw new \Exception('An unexpected error were encountered while processing your request. Please try later.');
        }
        if($result){
             return array('project_id' => $projectPkid, 'total_expense' => $result['total_expense']);  
        }else{
            return array('project_id' => $projectPkid, 'total_expense' => 0); 
        }      
    }
    
    public function GetBankBalance($bankid){       
        $query=$this->em->createQuery('select max(bal.currentAmount) from TashiCommonBundle:AccountBankCurrentBalance bal where bal.bankFk='.$bankid.' and bal.recordActiveFlag=1');
        return $query->getResult();        
    }
    
    public function adjustAdvancePayment($advance_payment_id, $total_collection, $adjusted_bal, $paymentStatus){
        try{          
            $advancePaymentObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->find($advance_payment_id);
            $advancePaymentObj->setTotalCollection($total_collection);
            $advancePaymentObj->setDueAmount($adjusted_bal);
            if($paymentStatus !== ''){
                $advancePaymentObj->setPaymentStatus($paymentStatus);
            }           
            $advancePaymentObj->setRecordUpdateDate(new \DateTime('now'));
            $advancePaymentObj->setApplicationUserId($this->session->get('EMPID'));
            $advancePaymentObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
       
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
        return;
    }
    
    public function sanctionSalaryAmount($request) { 
            $conn = $this->em->getConnection();  
            $conn->beginTransaction(); 
         try {
                $dataUI = json_decode($request->getContent());
                $date = $dataUI->txt_date;
                $description = $dataUI->txt_description;
                $payment_mode = $dataUI->txt_payment_mode;
                $payment_number = $dataUI->txt_payment_number;
                $sanctionPkid = $dataUI->txt_sanctionPkid;
                $actionkey = $dataUI->key; 
                
                if($payment_mode == ''){
                    $payment_mode = 1;
                }
                
                $account_type_field = 'txt_accountType'.$sanctionPkid;
                $account_type = $dataUI->$account_type_field; //cash or bank
                
                $source_account_field = 'txt_source_account_id'.$sanctionPkid;
                $account_source_id = $dataUI->$source_account_field; //source account 
                
                $sanction_amount_field = 'txt_sanction_amount'.$sanctionPkid;
                $sanction_amount = $dataUI->$sanction_amount_field; //sanction account 
                
                $account_balance_field = 'txt_account_balance'.$sanctionPkid;
                $account_balance = $dataUI->$account_balance_field; //account balance
                
                $selectedSalSlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY)->findBy(array('sanctionKeyFk'=>$sanctionPkid, 'recordActiveFlag'=>1));
                $msg = '';
               
                $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
                
                $pdfpathArr = array();
                foreach ($selectedSalSlipObj as $salarySlipID) { 
                    $salarySlipPkid = $salarySlipID->getSalarySlipFk()->getSalarySlipPk();
                    $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salarySlipPkid);
                    $empID = $salarySlipObj->getEmployeeFk()->getEmployeePk();
                    $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                    $Empname = $EmpObj->getPersonFk()->getPersonName();
                    switch($actionkey){
                        case 'Sanction' :  //A means approval                                  
                                    //if re-paid  advance due, then adjustment advance balance here 
                                    //firstly, check if re-paid amount is given                           
                                    if($salarySlipObj->getDeductionAdjustedAdvancePay() !== 0 && !is_null($salarySlipObj->getDeductionAdjustedAdvancePay())){ 
                                        $re_paid_amount =  $salarySlipObj->getDeductionAdjustedAdvancePay(); 
                                        $findAllAdvancePaymentObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)
                                                             ->findBy(array('employeeFk' => $empID, 'paymentStatus' => 'P', 'recordActiveFlag' => 1), array('recordInsertDate' => 'ASC'));
                                        
                                        foreach ($findAllAdvancePaymentObj as $val) {
                                            $advance_payment_id = $val->getAdvancePaymentPk();
                                            $advancePayAmt = $val->getAdvanceAmount();
                                            //check if advance amount is greater than re-paid amount
                                            if($advancePayAmt > $re_paid_amount){
                                                $adjusted_bal = $advancePayAmt - $re_paid_amount; 
                                                $paymentStatus = '';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $adjusted_bal, $paymentStatus);                                              
                                                break;
                                            }elseif ($advancePayAmt == $re_paid_amount) {
                                                $adjusted_bal = $advancePayAmt - $re_paid_amount;   
                                                $paymentStatus = 'Clear';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $adjusted_bal, $paymentStatus);                                              
                                                break;
                                            }elseif($advancePayAmt < $re_paid_amount){                                              
                                                $re_paid_amount = $re_paid_amount - $advancePayAmt;
                                                $adjusted_bal = 0;   
                                                $paymentStatus = 'Clear';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $advancePayAmt, $paymentStatus);                                               
                                            }                                          
                                        } 
                                    }                                                                   
                            
                                    //if paid wallet balance then adjust here  
                                    //firstly, check if adjustment wallet amount is given   
                                    
                                    if($salarySlipObj->getDeductionAdjustedWalletBal() > 0){
                                        $empExpenseObj = new EmpAccountExpenses();
                                        $empExpenseObj->setAmount($salarySlipObj->getDeductionAdjustedWalletBal());
                                        $empExpenseObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                                        $empExpenseObj->setExpensesType($this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find(7));
                                        $empExpenseObj->setExpensesDescription('Salary adjust from employee acoount balance');
                                        $empExpenseObj->setApprovedBy(7); //not implemented, value 7 is just demo
                                        $empExpenseObj->setStatus(1);
                                        $empExpenseObj->setRecordActiveFlag(1);
                                        $empExpenseObj->setRecordInsertDate(new \DateTime('now'));
                                        $empExpenseObj->setApplicationUserId($this->session->get('EMPID'));
                                        $empExpenseObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($empExpenseObj);
                                        $this->em->flush();

                                        $empAccObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empID);
                                        $emp_current_acc_bal = $empAccObj->getBalanceAmount(); // employee current account balance                                       
                                        $adjusted_acc_bal = $emp_current_acc_bal - $salarySlipObj->getDeductionAdjustmentWalletBal();
                                        //update employee account balance
                                        $empAccObj1 = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->find($empAccObj->getPkid());
                                        $empAccObj1->setBalanceAmount($adjusted_acc_bal);
                                        $empAccObj1->setRecordUpdateDate(new \DateTime('now'));
                                        $empAccObj1->setApplicationUserId($this->session->get('EMPID'));
                                        $empAccObj1->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->flush();
                                    }                                   
                                                                  
                                    //after then update salary slip status to approved 
                                    
                                    $salarySlipObj->setStatus('A');                                  
                                    $salarySlipObj->setApprovedDate(new \Datetime($date)); 
                                    $salarySlipObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                                    $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->flush();
                                                                                                        
                                    //---Maintain payment record for each salary slip---------
                                    $PayrolPaymentDetailsObj = new PayrolPaymentDetails();
                                    $PayrolPaymentDetailsObj->setEntityKey('salary');  //this key to detect, this payment is for salary(office employee)
                                    $PayrolPaymentDetailsObj->setSourceId($account_source_id);
                                    $PayrolPaymentDetailsObj->setCmnEntityId($salarySlipPkid);
                                    $PayrolPaymentDetailsObj->setPaymentNo($payment_number);
                                    $PayrolPaymentDetailsObj->setPaymentDate(new \Datetime($date));
                                    $PayrolPaymentDetailsObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));                                    
                                    $PayrolPaymentDetailsObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                                    $PayrolPaymentDetailsObj->setRecordActiveFlag(1);
                                    $PayrolPaymentDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $PayrolPaymentDetailsObj->setRecordInsertDate(new \Datetime('now'));
                                    $this->em->persist($PayrolPaymentDetailsObj);
                                    $this->em->flush();                                  
                                    
                                    //after approved salary slip it will entry to account details                                  
                                    $accDetailsObj = new AccountDetailsMaster();                                    
                                    //set to salary account head(fixed)
                                    $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(5));
                                    $accDetailsObj->setAmount($sanction_amount);
                                    $accDetailsObj->setDate(new \Datetime($date));
                                    $accDetailsObj->setDescription($description);
                                    $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                                    $accDetailsObj->setRecordActiveFlag(1);
                                    $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $accDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->persist($accDetailsObj); 
                                    $this->em->flush();  
                                    
                                    //email section part for tashi employee
                                    
                                    //section for sending email along with pdf attachment
                                    $EmolumentDeductionObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findBy(array('salarySlipFk' => $salarySlipID,'emolumentDeductionMasterFk' => 1, 'recordActiveFlag' => 1 )); 
                                    $EmolumentEmolutionObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findBy(array('salarySlipFk' => $salarySlipID,'emolumentDeductionMasterFk' => 2, 'recordActiveFlag' => 1 )); 
                                   
                                    
                                    $SalaryemployeeID = $salarySlipObj->getEmployeeFk()->getEmployeeId();
                                    $Month = $salarySlipObj->getMonthFk()->getMonthName();
                                    $Year = $salarySlipObj->getYear();
                                    $name = $salarySlipObj->getEmployeeFk()->getPersonFk()->getPersonName();
                                    $designation = $salarySlipObj->getEmployeeFk()->getEmpJobTitleFk()->getJobTitleName();
                                    
                                    $deducted = $salarySlipObj->getDeductionTotal();
                                    $walletbalance = $salarySlipObj->getDeductionAdjustedWalletBal();
                                    $repayAdvance =  $salarySlipObj->getDeductionAdjustedAdvancePay();
                                    
                                    
                                    $basic = $salarySlipObj->getEarningBasicSalary();
                                    $gross = $salarySlipObj->getEarningHraAmount();
                                    $netSal = $salarySlipObj->getNetSalary();
                                    $GrossSal = $salarySlipObj->getGrossSalary();
                                    
                                    $officemail = $salarySlipObj->getEmployeeFk()->getPersonFk()->getEmailIdOffice();
                                    $personalmail = $salarySlipObj->getEmployeeFk()->getPersonFk()->getEmailId();
                                    $Empmail = $EmpObj->getPersonFk()->getEmailIdOffice();  
                                    //echo $Empmail;die();
                                    $env = new \Twig_Environment(new \Twig_Loader_String());  
                                    $path='upload/Payslip/';
                                    
                                    
                                    if(is_dir($path)){
                                        $dirStatus=true;
                                    }
                                    else{
                                        $dirStatus=mkdir($path,0777,true);
                                    }
                                    if($dirStatus){ 
                                        
                                    $pdf =  $this->pdf->generateFromHtml($this->twig->render('TashiPayrollBundle:Payroll:Payslip.html.twig',
                                    array('month'=>$Month,'empname'=>$name,'allowance'=>$EmolumentDeductionObj,'emolution'=>$EmolumentEmolutionObj,
                                        'basic'=>$basic,'gross'=>$gross,'netsal'=>$netSal,'grossSal'=>$GrossSal,
                                        'desig'=>$designation,'deduct'=>$deducted,'wallet'=>$walletbalance,'repay'=>$repayAdvance)),$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                    }
//                                    $pdf =  $this->pdf->generateFromHtml($this->twig->render('TashiPayrollBundle:Payroll:Payslip.html.twig',
//                                    array('month'=>$Month,'empname'=>$name)),$path);
                                    
                                    
                                    //checking whether email works or not  
                                        if($officemail)
                                        {
                                                //sending email to tashi
                                                $messageObject = \Swift_Message::newInstance()
                                                ->setSubject('Pay slip details for tashi interiors particular employee')
                                                ->setFrom($Empmail)
                                                ->setTo($officemail)
                                                ->setBody($name . 'pay slip for the month of' . $Month. ',' .$Year)
                                                ->attach(\Swift_Attachment::fromPath($path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf'));

                                                $this->mailer->send($messageObject);
                                                //sending email along pdf attachment ends here.
                                                array_push($pdfpathArr ,$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                                //email validation section ends here
                                        }
                                        else
                                        {
                                            if($personalmail)
                                            {
                                                //sending email to tashi
                                                $messageObject = \Swift_Message::newInstance()
                                                ->setSubject('Pay slip details for tashi interiors particular employee')
                                                ->setFrom($Empmail)
                                                ->setTo($personalmail)
                                                ->setBody($name . 'pay slip for the month of' . $Month. ',' .$Year)
                                                ->attach(\Swift_Attachment::fromPath($path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf'));

                                                $this->mailer->send($messageObject);
                                                //sending email along pdf attachment ends here.
                                                array_push($pdfpathArr ,$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                                //email validation section ends here
                                            }
                                            else
                                            {
                                                $msg = "No email assigned for particular employee";
                                                return array('msg'=>$msg);
                                            }
                                            
                                        } 
                                    
                                    
                                    
                                    
                                    
                                    //email sectioin ends here.
                                    break;
                        case 'Reject' :  //R means rejected
                                    $salarySlipObj->setStatus('R');                                 
                                    $salarySlipObj->setRejectedDate(new \Datetime($date));
                                    $salarySlipObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                                    $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->flush();
                                    
                                    break;
                    }
                }
            
                if($actionkey == 'Sanction'){
                    //here sanction amount will be adjusted from the selected account balance   
                    if($account_type == 'cash'){  
                       // cash account  balance adjust                                   
                       $this->adjustCashAccountBalance($account_source_id, $account_balance, $sanction_amount, $description, $branch_id);

                   }else{
                       // bank account balance adjust
                       $this->adjustBankAccountBalance($account_source_id, $account_balance, $sanction_amount, $description, $payment_mode, $payment_number, $branch_id);
                   }
                   
                   //after update sanction salary id table 
                   $sanctionSalaryObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->find($sanctionPkid);                 
                   $sanctionSalaryObj->setIsSanction(1);// 1 is sanction key
                   $sanctionSalaryObj->setDescription($description);
                   $sanctionSalaryObj->setSanctionDate(new \Datetime($date));
                   $sanctionSalaryObj->setRecordUpdateDate(new \Datetime('NOW'));
                   $sanctionSalaryObj->setApplicationUserId($this->session->get('EMPID'));
                   $sanctionSalaryObj->setApplicationUserIpAddress($this->session->get('IP'));
                   $this->em->flush();                           
                   $msg = 'Successfully sanctioned, the selected amount';
                }else if($actionkey == 'Reject'){
                    $sanctionSalaryObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SANCTION_SALARY_ID)->find($sanctionPkid);                 
                    $sanctionSalaryObj->setIsSanction(2); // 2 is reject sanction key
                    $sanctionSalaryObj->setDescription($description);
                    $sanctionSalaryObj->setSanctionDate(new \Datetime($date));
                    $sanctionSalaryObj->setRecordUpdateDate(new \Datetime('NOW'));
                    $sanctionSalaryObj->setApplicationUserId($this->session->get('EMPID'));
                    $sanctionSalaryObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush();
                    
                    $msg = 'Rejected, the selected amount';
                }     
                $conn->commit();
          
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            return array('msg'=>$msg,'pdfpatharray'=>$pdfpathArr);
   }
   
   public function adjustCashAccountBalance($account_source_id, $account_balance, $sanction_amount, $description, $branch_id){
        try{          
            $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($account_source_id);              
            $newBalance = $account_balance - $sanction_amount;                             
            $cashObj->setCurrentAmount($newBalance);
            $cashObj->setRecordUpdateDate(new \Datetime('NOW'));
            $cashObj->setApplicationUserId($this->session->get('EMPID'));
            $this->em->flush();

            //for inserting into cash Deposit history
            $cashDepositHisObj = new AccountCashDipositWithdrawalHistory();
            $cashDepositHisObj->setDepositWithdrawalKey('W');
            $cashDepositHisObj->setAmount($sanction_amount);
            $cashDepositHisObj->setDate(new \Datetime());
            $cashDepositHisObj->setDescription($description);
            $cashDepositHisObj->setRecordActiveFlag(1);
            $cashDepositHisObj->setRecordInsertDate(new \Datetime());
            $cashDepositHisObj->setCashAccountFk($cashObj);
            $cashDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

            $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
            $Empname = $EmpObj->getPersonFk()->getPersonName();                                                              

            $cashDepositHisObj->setDepositWithdrawalBy($Empname);
            $cashDepositHisObj->setBranchOfficeCode($branch_id);
            $cashDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($cashDepositHisObj);
            $this->em->flush(); 
       
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
        return;
    }
   public function adjustBankAccountBalance($account_source_id, $account_balance, $sanction_amount, $description, $payment_mode, $payment_number, $branch_id){
        try{          
            $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($account_source_id);                
            $newBalance = $account_balance - $sanction_amount;   
            $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid()); 
            $bankAccObj->setCurrentAmount($newBalance);
            $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
            $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
            $this->em->flush();

            //for inserting into bank Deposit history
            $bankDepositHisObj = new AccountBankDipositWithdrawalHistory();
            $bankDepositHisObj->setDepositWithdrawalKey('W');
            $bankDepositHisObj->setAmount($sanction_amount);
            $bankDepositHisObj->setDate(new \Datetime());
            $bankDepositHisObj->setDescription($description);
            $bankDepositHisObj->setRecordActiveFlag(1);
            $bankDepositHisObj->setRecordInsertDate(new \Datetime());
            $bankDepositHisObj->setBankFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($account_source_id));
            $bankDepositHisObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));
            $bankDepositHisObj->setPaymentNo($payment_number);
            $bankDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

            $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
            $Empname = $EmpObj->getPersonFk()->getPersonName();                                                              

            $bankDepositHisObj->setDepositWithdrawalBy($Empname);
            $bankDepositHisObj->setBranchOfficeCode($branch_id);
            $bankDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($bankDepositHisObj);
            $this->em->flush(); 
       
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
        return;
    }
    
    public function approvedOrRejectSalarySlip($request) { 
            $conn = $this->em->getConnection();  
            $conn->beginTransaction(); 
         try {
                $dataUI = json_decode($request->getContent());
                $approveOrRejectDate = $dataUI->txt_approved_or_rejected_date;
                $key = $dataUI->key; 
                
                $payment_mode = $dataUI->txt_payment_mode;
                $payment_number = $dataUI->txt_payment_number;
                $source_account_id = $dataUI->txt_enter_account_id;
                if ($payment_mode == 1) {
                    $accountKey = 'cash';
                } else {
                    $accountKey = 'bank';
                }
                
                $selectedSalSlipArr = array();
                $pdfpathArr = array();
                if (is_string($dataUI->txt_selected_salary_slip)) {
                    $selectedSalSlipArr[0] = $dataUI->txt_selected_salary_slip; //for only one 
                } else {
                    $selectedSalSlipArr = $dataUI->txt_selected_salary_slip;     //for more than one       
                }
                $msg = '';
                $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
                foreach ($selectedSalSlipArr as $salarySlipID) { 
                    $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salarySlipID);
                    $empID = $salarySlipObj->getEmployeeFk()->getEmployeePk();
                    switch($key){
                        case 'A' :  //A means approval                                  
                                    //if re-paid  advance due, then adjustment advance balance here 
                                    //firstly, check if re-paid amount is given
                                    if($salarySlipObj->getDeductionAdjustedAdvancePay() !== 0 && !is_null($salarySlipObj->getDeductionAdjustedAdvancePay())){ 
                                        $re_paid_amount =  $salarySlipObj->getDeductionAdjustedAdvancePay(); 
                                        $findAllAdvancePaymentObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)
                                                             ->findBy(array('employeeFk' => $empID, 'paymentStatus' => 'P', 'recordActiveFlag' => 1), array('recordInsertDate' => 'ASC'));
                                        
                                        foreach ($findAllAdvancePaymentObj as $val) {
                                            $advance_payment_id = $val->getAdvancePaymentPk();
                                            $advancePayAmt = $val->getAdvanceAmount();
                                            //check if advance amount is greater than re-paid amount
                                            if($advancePayAmt > $re_paid_amount){
                                                $adjusted_bal = $advancePayAmt - $re_paid_amount; 
                                                $paymentStatus = '';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $adjusted_bal, $paymentStatus);                                              
                                                break;
                                            }elseif ($advancePayAmt == $re_paid_amount) {
                                                $adjusted_bal = $advancePayAmt - $re_paid_amount;   
                                                $paymentStatus = 'Clear';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $adjusted_bal, $paymentStatus);                                              
                                                break;
                                            }elseif($advancePayAmt < $re_paid_amount){                                              
                                                $re_paid_amount = $re_paid_amount - $advancePayAmt;
                                                $adjusted_bal = 0;   
                                                $paymentStatus = 'Clear';
                                                $this->adjustAdvancePayment($advance_payment_id, $re_paid_amount, $advancePayAmt, $paymentStatus);                                               
                                            }                                          
                                        } 
                                    }                                                                   

                                    //if paid wallet balance then adjust here  
                                    //firstly, check if adjustment wallet amount is given   
                                    
                                    if($salarySlipObj->getDeductionAdjustedWalletBal() > 0){
                                        $empExpenseObj = new EmpAccountExpenses();
                                        $empExpenseObj->setAmount($salarySlipObj->getDeductionAdjustedWalletBal());
                                        $empExpenseObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                                        $empExpenseObj->setExpensesType($this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find(7));
                                        $empExpenseObj->setExpensesDescription('Salary adjust from employee account balance');
                                        $empExpenseObj->setApprovedBy(7); //not implemented, value 7 is just demo
                                        $empExpenseObj->setStatus(1);
                                        $empExpenseObj->setRecordActiveFlag(1);
                                        $empExpenseObj->setRecordInsertDate(new \DateTime('now'));
                                        $empExpenseObj->setApplicationUserId($this->session->get('EMPID'));
                                        $empExpenseObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($empExpenseObj);
                                        $this->em->flush();

                                        $empAccObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empID);
                                        $emp_current_acc_bal = $empAccObj->getBalanceAmount(); // employee current account balance                                       
                                        $adjusted_acc_bal = $emp_current_acc_bal - $salarySlipObj->getDeductionAdjustmentWalletBal();
                                        //update employee account balance
                                        $empAccObj1 = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->find($empAccObj->getPkid());
                                        $empAccObj1->setBalanceAmount($adjusted_acc_bal);
                                        $empAccObj1->setRecordUpdateDate(new \DateTime('now'));
                                        $empAccObj1->setApplicationUserId($this->session->get('EMPID'));
                                        $empAccObj1->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->flush();
                                    }                                   
                                                                  
                                    //after then update salary slip status to approved 
                                    
                                    $salarySlipObj->setStatus('A');                                  
                                    $salarySlipObj->setApprovedDate(new \Datetime($approveOrRejectDate)); 
                                    $salarySlipObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                                    $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->flush();
                                    
                                    
                                    //-----------------------   
                                    $description_field_name = 'txt_description'.$salarySlipID;
                                    $salary_field_name = 'txt_salary'.$salarySlipID;
                                    $txt_description = $dataUI->$description_field_name;
                                    $txt_salary = $dataUI->$salary_field_name;
                                    
                                    if($accountKey == 'cash'){  
                                        //paymentMode = 1 is cash mode, then we select cash account                                      
                                        $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($source_account_id); 
                                        $currentCashBal = $cashObj->getCurrentAmount();
                                        $newBalance = $currentCashBal - $txt_salary;                             
                                        $cashObj->setCurrentAmount($newBalance);
                                        $cashObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $cashObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();

                                        //for inserting into cash Deposit history
                                        $cashDepositHisObj = new AccountCashDipositWithdrawalHistory();
                                        $cashDepositHisObj->setDepositWithdrawalKey('W');
                                        $cashDepositHisObj->setAmount($txt_salary);
                                        $cashDepositHisObj->setDate(new \Datetime());
                                        $cashDepositHisObj->setDescription($txt_description);
                                        $cashDepositHisObj->setRecordActiveFlag(1);
                                        $cashDepositHisObj->setRecordInsertDate(new \Datetime());
                                        $cashDepositHisObj->setCashAccountFk($cashObj);
                                        $cashDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

                                        $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                                        $Empname = $EmpObj->getPersonFk()->getPersonName();                                                              

                                        $cashDepositHisObj->setDepositWithdrawalBy($Empname);
                                        $cashDepositHisObj->setBranchOfficeCode($branch_id);
                                        $cashDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($cashDepositHisObj);
                                        $this->em->flush(); 
                                       
                                    }else{
                                        //paymentMode != 1 is other mode, then we select bank account
                                        $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($source_account_id); 
                                        $currentBankBal = $findBankObj->getCurrentAmount();
                                        $newBalance = $currentBankBal - $txt_salary;
                                        $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid()); 
                                        $bankAccObj->setCurrentAmount($newBalance);
                                        $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();

                                        //for inserting into bank Deposit history
                                        $bankDepositHisObj = new AccountBankDipositWithdrawalHistory();
                                        $bankDepositHisObj->setDepositWithdrawalKey('W');
                                        $bankDepositHisObj->setAmount($txt_salary);
                                        $bankDepositHisObj->setDate(new \Datetime());
                                        $bankDepositHisObj->setDescription($txt_description);
                                        $bankDepositHisObj->setRecordActiveFlag(1);
                                        $bankDepositHisObj->setRecordInsertDate(new \Datetime());
                                        $bankDepositHisObj->setBankFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($source_account_id));
                                        $bankDepositHisObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));
                                        $bankDepositHisObj->setPaymentNo($payment_number);
                                        $bankDepositHisObj->setApplicationUserId($this->session->get('EMPID'));

                                        $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                                        $Empname = $EmpObj->getPersonFk()->getPersonName();                                                              

                                        $bankDepositHisObj->setDepositWithdrawalBy($Empname);
                                        $bankDepositHisObj->setBranchOfficeCode($branch_id);
                                        $bankDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($bankDepositHisObj);
                                        $this->em->flush(); 
                                    }
                                    //---Maintain payment record for each salary slip---------
                                    $PayrolPaymentDetailsObj = new PayrolPaymentDetails();
                                    $PayrolPaymentDetailsObj->setEntityKey('salary');  //this key to detect, this payment is for salary(office employee)
                                    $PayrolPaymentDetailsObj->setSourceId($source_account_id);
                                    $PayrolPaymentDetailsObj->setCmnEntityId($salarySlipID);
                                    $PayrolPaymentDetailsObj->setPaymentNo($payment_number);
                                    $PayrolPaymentDetailsObj->setPaymentDate(new \Datetime($approveOrRejectDate));
                                    $PayrolPaymentDetailsObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));                                    
                                    $PayrolPaymentDetailsObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                                    $PayrolPaymentDetailsObj->setRecordActiveFlag(1);
                                    $PayrolPaymentDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $PayrolPaymentDetailsObj->setRecordInsertDate(new \Datetime('now'));
                                    $this->em->persist($PayrolPaymentDetailsObj);
                                    $this->em->flush();
                                    $Employeepkid = $PayrolPaymentDetailsObj->getEmpFk()->getEmployeePk();
                                    
                                    //after approved salary slip it will entry to account details                                  
                                    $accDetailsObj = new AccountDetailsMaster();                                    
                                    //set to salary account head(fixed)
                                    $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(5));
                                    $accDetailsObj->setAmount($txt_salary);
                                    $accDetailsObj->setDate(new \Datetime($approveOrRejectDate));
                                    $accDetailsObj->setDescription($txt_description);
                                    $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                                    $accDetailsObj->setRecordActiveFlag(1);
                                    $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $accDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->persist($accDetailsObj); 
                                    $this->em->flush();  
                                    
                                    
//                                    //section for sending email along with pdf attachment
                                    $EmolumentDeductionObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findBy(array('salarySlipFk' => $salarySlipID,'emolumentDeductionMasterFk' => 1, 'recordActiveFlag' => 1 )); 
                                    $EmolumentEmolutionObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findBy(array('salarySlipFk' => $salarySlipID,'emolumentDeductionMasterFk' => 2, 'recordActiveFlag' => 1 )); 
                                   
                                    
                                    $SalaryemployeeID = $salarySlipObj->getEmployeeFk()->getEmployeeId();
                                    $Month = $salarySlipObj->getMonthFk()->getMonthName();
                                    $Year = $salarySlipObj->getYear();
                                    $name = $salarySlipObj->getEmployeeFk()->getPersonFk()->getPersonName();
                                    $designation = $salarySlipObj->getEmployeeFk()->getEmpJobTitleFk()->getJobTitleName();
                                    
                                    $deducted = $salarySlipObj->getDeductionTotal();
                                    $walletbalance = $salarySlipObj->getDeductionAdjustedWalletBal();
                                    $repayAdvance =  $salarySlipObj->getDeductionAdjustedAdvancePay();
                                    
                                    
                                    $basic = $salarySlipObj->getEarningBasicSalary();
                                    $gross = $salarySlipObj->getEarningHraAmount();
                                    $netSal = $salarySlipObj->getNetSalary();
                                    $GrossSal = $salarySlipObj->getGrossSalary();
                                    
                                    $officemail = $salarySlipObj->getEmployeeFk()->getPersonFk()->getEmailIdOffice();
                                    $personalmail = $salarySlipObj->getEmployeeFk()->getPersonFk()->getEmailId();
                                    $Empmail = $EmpObj->getPersonFk()->getEmailIdOffice();  
                                    
                                    $env = new \Twig_Environment(new \Twig_Loader_String());  
                                    $path='upload/Payslip/';
                                    
                                    
                                    if(is_dir($path)){
                                        $dirStatus=true;
                                    }
                                    else{
                                        $dirStatus=mkdir($path,0777,true);
                                    }
                                    if($dirStatus){ 
                                        
                                    $pdf =  $this->pdf->generateFromHtml($this->twig->render('TashiPayrollBundle:Payroll:Payslip.html.twig',
                                    array('month'=>$Month,'empname'=>$name,'allowance'=>$EmolumentDeductionObj,'emolution'=>$EmolumentEmolutionObj,
                                        'basic'=>$basic,'gross'=>$gross,'netsal'=>$netSal,'grossSal'=>$GrossSal,
                                        'desig'=>$designation,'deduct'=>$deducted,'wallet'=>$walletbalance,'repay'=>$repayAdvance)),$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                    }
//                                    $pdf =  $this->pdf->generateFromHtml($this->twig->render('TashiPayrollBundle:Payroll:Payslip.html.twig',
//                                    array('month'=>$Month,'empname'=>$name)),$path);
                                    
                                    
                                    //checking whether email works or not  
                                        if($officemail)
                                        {
                                                //sending email to tashi
                                                $messageObject = \Swift_Message::newInstance()
                                                ->setSubject('Pay slip details for tashi interiors particular employee')
                                                ->setFrom($Empmail)
                                                ->setTo($officemail)
                                                ->setBody($name . 'pay slip for the month of' . $Month. ',' .$Year)
                                                ->attach(\Swift_Attachment::fromPath($path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf'));

                                                $this->mailer->send($messageObject);
                                                //sending email along pdf attachment ends here.
                                                array_push($pdfpathArr ,$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                                //email validation section ends here
                                        }
                                        else
                                        {
                                            if($personalmail)
                                            {
                                                //sending email to tashi
                                                $messageObject = \Swift_Message::newInstance()
                                                ->setSubject('Pay slip details for tashi interiors particular employee')
                                                ->setFrom($Empmail)
                                                ->setTo($personalmail)
                                                ->setBody($name . 'pay slip for the month of' . $Month. ',' .$Year)
                                                ->attach(\Swift_Attachment::fromPath($path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf'));

                                                $this->mailer->send($messageObject);
                                                //sending email along pdf attachment ends here.
                                                array_push($pdfpathArr ,$path.'EMP'.$SalaryemployeeID.$Month.$Year.'.pdf');
                                                //email validation section ends here
                                            }
                                            else
                                            {
                                                $msg = "No email assigned for particular employee";
                                                return array('msg'=>$msg);
                                            }
                                            
                                        }                                                                   
                                    $msg = 'Approved, the selected salary slip';
                                    break;
                        case 'R' :  //R means rejected
                                    $salarySlipObj->setStatus('R');                                 
                                    $salarySlipObj->setRejectedDate(new \Datetime($approveOrRejectDate));
                                    $salarySlipObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                                    $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                                    $this->em->flush();
                                    $msg = 'Rejected, the selected salary slip';
                                    break;
                    }                                    
                }
                
            $conn->commit();
          
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            
            
            return array('msg'=>$msg,'salarySlipID'=>$salarySlipID,'empid'=>$Employeepkid,'pdfpatharray'=>$pdfpathArr);
    }
    
    
    
    
    
    
    
    
    
    
    

}// end of class

