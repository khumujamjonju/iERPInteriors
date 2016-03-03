<?php

namespace Tashi\CustomerBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CustomerBundle\Helper\CustomerConstant;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\CommonBundle\Entity\CusCustomer;
use Tashi\CommonBundle\Entity\CmnPerson;
use Tashi\CommonBundle\Entity\CmnMobileNoMaster;
use Tashi\CommonBundle\Entity\CusAddressTxn;
use Tashi\CommonBundle\Entity\CmnCommunicationMessageMaster;
use Tashi\CommonBundle\Entity\CmnCommunicationTxn;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Entity\CusContactTxn;
use Tashi\CommonBundle\Entity\CusContactMobileNoTxn;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\CusAdvancePayment;
use Tashi\CommonBundle\Entity\AccountDetailsMaster;
use Tashi\CommonBundle\Entity\CusAdvancePaymentReceipt;
use Tashi\CommonBundle\Entity\AccountCashCurrentBalance;
use Tashi\CommonBundle\Entity\AccountCashDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountBankDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\TransactionDate;


class CustomerService {
    protected $em;
    protected $session;
    protected $webRoot;
    protected $cmnservice;
    protected $mailer;

    public function __construct(EntityManager $em, Session $session, $rootDir,$cmnservice,$mailer) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->cmnservice=$cmnservice;
        $this->mailer=$mailer;
    }
    
    public function saveCusAdvancePayment($request){        
        $dataUI = json_decode($request->getContent());
        $advance_payment_id =  $dataUI->txt_cus_advance_payment_id;
        $customer_id =  $dataUI->txt_customer_id;     
        $advance_amount =  $dataUI->txt_advance_amount; 
        $payment_date =  $dataUI->txt_payment_date; 
        $payment_mode_id =  $dataUI->txt_payment_mode; 
        $enter_account_id =  $dataUI->txt_enter_account_id; 
        $description =  $dataUI->txt_description; 
        if(!null == $dataUI->txt_payment_number){
            $payment_no =  $dataUI->txt_payment_number; 
        }else{
            $payment_no =  0; 
        }
        $conn = $this->em->getConnection();  
        $conn->beginTransaction(); 
             
        try{
            if($advance_payment_id == ''){
                $cusAdvPayObj = new CusAdvancePayment();
            }else{
                $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($advance_payment_id);
            }  
            $cusAdvPayObj->setAdvanceAmount($advance_amount);
            $cusAdvPayObj->setHodApprove(0);
            $cusAdvPayObj->setCreatedDate(new \Datetime($payment_date)); 
            $cusAdvPayObj->setCustomerFk($this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($customer_id)); 
            $cusAdvPayObj->setPaymentModeFk($this->em->getRepository(CommonConstant::PAYMENT_MODE_MASTER)->find($payment_mode_id));
            $cusAdvPayObj->setAmountEnterAccountId($enter_account_id);
            $cusAdvPayObj->setPaymentNo($payment_no);
            $cusAdvPayObj->setDescription($description);
            $cusAdvPayObj->setPaymentStatus('C');
            $cusAdvPayObj->setIsAdjusted(0);

            if($advance_payment_id == ''){
                $cusAdvPayObj->setRecordActiveFlag(1);
                $cusAdvPayObj->setRecordInsertDate(new \DateTime('now'));
                $cusAdvPayObj->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($cusAdvPayObj);
            }else{
                $cusAdvPayObj->setRecordUpdateDate(new \DateTime('now'));
                $cusAdvPayObj->setApplicationUserId($this->session->get('EMPID'));
            }
            $this->em->flush();                        
         
            //generate receipt no
            $result = $this->cmnservice->getLatestNumber('CusAdvancePaymentReceipt', 'pkid');
            if(count($result) > 0){
                $receipt_no = $result[0]['number'];
                $rcptid = 'R'.$receipt_no;
//                echo $receipt_no;die();
//                $rcp_generate_ID = (int) substr($receipt_no, 3, strlen($receipt_no)) + 1;
            }else{
                $rcptid = 'R'. 1;
            }
            //$rcptid = 'RCP'.$rcp_generate_ID;
            
            
//            if(count($result) > 0){
//                $receipt_no = $result[0]['number'];
//            }else{
//                $receipt_no = 1;
//            }
            
           
//            if ($result) {
//                $po = $result[0]['uiID'];
//
//                $po_generate_ID = (int) substr($po, 2, strlen($po)) + 1;
//            } else {
//                $po_generate_ID = 1;
//            }
//            $po_ID = 'PO' . $po_generate_ID;
            $rDate=new \DateTime('now');
            $CusAdvancePaymentReceiptObj = new CusAdvancePaymentReceipt();
            $CusAdvancePaymentReceiptObj->setReceiptDate(new \Datetime($payment_date));
            $CusAdvancePaymentReceiptObj->setReceiptNo($rcptid);
            $CusAdvancePaymentReceiptObj->setAdvancePaymentFk($cusAdvPayObj);
            $CusAdvancePaymentReceiptObj->setRecordActiveFlag(1);
            $CusAdvancePaymentReceiptObj->setRecordInsertDate($rDate);
            $CusAdvancePaymentReceiptObj->setApplicationUserId($this->session->get('EMPID'));
            $this->em->persist($CusAdvancePaymentReceiptObj);
            $this->em->flush();
            
            //Saving transaction date
            $empid=$this->session->get('EMPID');
            $tranDate=$this->em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findBy(array('employeeId'=>$empid,'moduleId'=>'RCPT','recordActiveFlag'=>1));
            if(!$tranDate){
                $tranDate=new TransactionDate();
                $tranDate->setModuleId('RCPT');
                $tranDate->setEmployeeId($this->session->get('EMPID'));
                $tranDate->setLastSelectedDate(new \DateTime($payment_date));
                $tranDate->setRecordInsertDate(new \DateTime("NOW"));
                $tranDate->setRecordActiveFlag(1);
                $this->em->persist($tranDate);
            }else{
                $tranDate[0]->setLastSelectedDate(new \DateTime($payment_date));
                $tranDate[0]->setRecordUpdateDate(new \DateTime("NOW"));
            }    
            $this->em->flush($tranDate);
            $conn->commit();          
            
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
            return false;
        }
        return array('advPayID' => $cusAdvPayObj->getAdvancePaymentPk(),
                     'paymentModeID' => $payment_mode_id,
                     'customer_id' => $customer_id,
                     'msg' => 'Payment detail saved successfully.',
                     'printDetails' => $this->printCusAdvancePayReceipt($customer_id, $cusAdvPayObj->getAdvancePaymentPk(),$CusAdvancePaymentReceiptObj)
                );
    }    
    
    public function createNewCashAccount($branch_id){
        try{
                $AccountCashCurrentBalanceObj = new AccountCashCurrentBalance();
                $AccountCashCurrentBalanceObj->setCurrentAmount(0);
                $AccountCashCurrentBalanceObj->setDescription('created cash account at the time when customer first advance payment is done');
                $AccountCashCurrentBalanceObj->setBranchOfficeCode($branch_id);
                $AccountCashCurrentBalanceObj->setRecordInsertDate(new \Datetime());
                $AccountCashCurrentBalanceObj->setCreatedDate(new \Datetime());
                $AccountCashCurrentBalanceObj->setRecordActiveFlag(1);
                $AccountCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                $AccountCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($AccountCashCurrentBalanceObj);
                $this->em->flush();
        }catch(\Exception $ex){
            throw new \Exception($ex->getMessage());
            return false;
        }
        return; 
    }


    public function printCusAdvancePayReceipt($cusPkid, $advancePaymentPk,$receipt){
        try{
            $cusObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADDRESS_MASTER)->findOneBy(array('customerFk' => $cusPkid,'recordActiveFlag' => 1));                                 
            $employee=$this->em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID'),'recordActiveFlag' => 1));                              
            $advanceRecieptDetails = $this->em->getRepository(CustomerConstant::CUSTOMER_ADVANCE_PAYMENT_RECIEPT)->findOneBy(array('advancePaymentFk' => $advancePaymentPk,'recordActiveFlag' => 1));
            $companyDetails = $this->em->getRepository('TashiCommonBundle:CompanyMaster')->findOneByRecordActiveFlag(1);
            
            $companyAddress = $this->em->getRepository('TashiCommonBundle:CompanyAddressTxn')->findOneBy(array('companyFk' => $companyDetails->getPkid(), 'recordActiveFlag' => 1)); 
            $companyEmail = $this->em->getRepository('TashiCommonBundle:CompanyEmailTxn')->findOneByRecordActiveFlag(1); 
            $companyContact = $this->em->getRepository('TashiCommonBundle:CompanyContactTxn')->findByRecordActiveFlag(1); 
            $companyPhone = $this->em->getRepository('TashiCommonBundle:CompanyPhoneTxn')->findByRecordActiveFlag(1); 
            
        } 
       catch (\Exception $ex) {          
            throw new \Exception($ex->getMessage());
            return false;
        }      
        return array('code'=>1,
                    'msg'=>'',
                    'cusInfo' => $cusObj, 
                    'employee'=>$employee,
                    'advanceRecieptDetails' => $advanceRecieptDetails, 
                    'companyDetails' => $companyDetails,
                    'companyAddress' => $companyAddress,
                    'companyEmail' => $companyEmail,
                    'companyContact' => $companyContact,
                    'Phone' => $companyPhone,
                    'receipt'=>$receipt);
    }
    
    
    public function addCreateCustomerMaster($request) {
        
        $dataUI = json_decode($request->getContent());
        $cusContactNumber = $dataUI->mobileNo;
        $cusName = $dataUI->txtCustomerName;     
        
//        $cusContactperson = $dataUI->txtContactPerson;
 
        
        try {
            //new mobile master object
            $mobMaster = new CmnMobileNoMaster;
            $mobMaster->setMobileNo($cusContactNumber);
            $mobMaster->setApprovalFlag(1);
            $mobMaster->setRecordActiveFlag(1);
            $mobMaster->setRecordInsertDate(new \DateTime('now'));
            $mobMaster->setApplicationUserId($this->session->get('EMPID'));
            $this->em->persist($mobMaster);
            $this->em->flush();
            
             // New object for Inserting Customer detail
            $custobj = new TbCimCustomer();
            $custobj->setCustomerName($cusName);
            $custobj->setRecordActiveFlag(1);
            $custobj->setStatusFlag(1);
            $this->em->persist($custobj);
            $this->em->flush($custobj);
           
//            //new object for inserting Contact Person Name and phone Number
//            $personpbj = new TbCmnPerson();
//            $personpbj->setPersonName($cusContactperson);
//            $personpbj->setRecordActiveFlag(1);
//            $this->em->persist($personpbj);
//            $this->em->flush($personpbj);          
            return true;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
            return false;
        }
    }
    
    public function editCusAdvancePayment($advPayID){
        try{
            $cusAdvPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($advPayID);
            return array('advPayId' => $advPayID,
                         'cus_id' => $cusAdvPayObj->getCustomerFk()->getCustomerIdPk(),
                         'custName' => $cusAdvPayObj->getCustomerFk()->getCustomerName(),                      
                         'advAmount' => $cusAdvPayObj->getAdvanceAmount(),
                         'paymentDate' => date_format($cusAdvPayObj->getCreatedDate(), 'Y-m-d'),
                         'payment_mode_id' => $cusAdvPayObj->getPaymentModeFk()->getPkid(),
                         'payment_no' => $cusAdvPayObj->getPaymentNo(),
                         'description' => $cusAdvPayObj->getDescription()             
                );
        
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
            return false;
        }
    }
    
    public function approvedCusCreatedAdvancePaymentByHod($request) {
                $conn = $this->em->getConnection();  
                $conn->beginTransaction(); 
            try {
                $dataUI = json_decode($request->getContent());
                $approveOrRejectDate = $dataUI->txt_approved_or_rejected_date;
                $key = $dataUI->key;
                
                $selectedAdvPaymentArr = array();
                if (is_string($dataUI->txt_selected_advance_payment)) {
                    $selectedAdvPaymentArr[0] = $dataUI->txt_selected_advance_payment; //for only one 
                } else {
                    $selectedAdvPaymentArr = $dataUI->txt_selected_advance_payment;     //for more than one       
                }
                $msg = '';
                 
                foreach ($selectedAdvPaymentArr as $val) {
                    $advPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($val);
                    switch($key){
                        case 'A' :  //A means approval
                                    $advPayObj->setHodApprove(1);                                  
                                    $advPayObj->setApprovedDate(new \Datetime($approveOrRejectDate)); 
                                    $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                    
                                    $msg = 'Payment Detail has been approved successfully';
                                    break;
                        case 'R' :  //R means reject
                                    $advPayObj->setHodApprove(0); 
                                    $advPayObj->setPaymentStatus('R');          
                                    $advPayObj->setRejectedDate(new \Datetime($approveOrRejectDate)); 
                                    $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                    $msg = 'Payment Rejected.';
                                    break;
                    }                                                                        
                }
                //Saving transaction date
                $empid=$this->session->get('EMPID');
                $tranDate=$this->em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                if(!$tranDate){
                    $tranDate=new TransactionDate();
                    $tranDate->setModuleId('CRAPPR');
                    $tranDate->setEmployeeId($this->session->get('EMPID'));
                    $tranDate->setLastSelectedDate(new \DateTime($approveOrRejectDate));
                    $tranDate->setRecordInsertDate(new \DateTime("NOW"));
                    $tranDate->setRecordActiveFlag(1);
                    $this->em->persist($tranDate);
                }else{
                    $tranDate[0]->setLastSelectedDate(new \DateTime($approveOrRejectDate));
                    $tranDate[0]->setRecordUpdateDate(new \DateTime("NOW"));
                }    
                $this->em->flush($tranDate);
                $conn->commit();
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            
            
            return $msg;
    }
    
    public function approvedCusCreatedAdvancePayment($request) {
                $conn = $this->em->getConnection();  
                $conn->beginTransaction(); 
            try {
                $dataUI = json_decode($request->getContent());
                $approveOrRejectDate = $dataUI->txt_approved_or_rejected_date;
                $key = $dataUI->key;
                
                $selectedAdvPaymentArr = array();
                if (is_string($dataUI->txt_selected_advance_payment)) {
                    $selectedAdvPaymentArr[0] = $dataUI->txt_selected_advance_payment; //for only one 
                } else {
                    $selectedAdvPaymentArr = $dataUI->txt_selected_advance_payment;     //for more than one       
                }
                $msg = '';
                 
                foreach ($selectedAdvPaymentArr as $val) {
                    $advPayObj = $this->em->getRepository(CommonConstant::CUSTOMER_ADVANCE_PAYMENT)->find($val);
                    switch($key){
                        case 'A' :  //A means approval                                  
                                    $advPayObj->setPaymentStatus('A');                                  
                                    $advPayObj->setApprovedDate(new \Datetime($approveOrRejectDate)); 
                                    $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                    
                                    //updating advance amount to acount cash/bank
                                    $description_field_name = 'txt_description'.$val;
                                    $advanceAmount_field_name = 'txt_advanceAmount'.$val;
                                    $txt_description = $dataUI->$description_field_name; 
                                    $txt_advanceAmount = $dataUI->$advanceAmount_field_name; 
                                    
                                    $paymentMode =  $advPayObj->getPaymentModeFk()->getPkid();
                                    if($paymentMode == 1){  
                                        //paymentMode = 1 is cash mode, then we select cash account                                     
                                        $findCashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->findOneBy(array('recordActiveFlag'=>1));
                                        $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($findCashObj->getPkid());
                                        $currentCashBal = $cashObj->getCurrentAmount();
                                        $newBalance = $currentCashBal + $txt_advanceAmount;                             
                                        $cashObj->setCurrentAmount($newBalance);
                                        $cashObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $cashObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();
                                                                              
                                        //for inserting into cash Deposit history
                                        $cashDepositHisObj = new AccountCashDipositWithdrawalHistory();
                                        $cashDepositHisObj->setDepositWithdrawalKey('D');
                                        $cashDepositHisObj->setAmount($txt_advanceAmount);
                                        $cashDepositHisObj->setDate(new \Datetime());
                                        $cashDepositHisObj->setDescription($txt_description);
                                        $cashDepositHisObj->setRecordActiveFlag(1);
                                        $cashDepositHisObj->setRecordInsertDate(new \Datetime());
                                        $cashDepositHisObj->setCashAccountFk($cashObj);
                                        $cashDepositHisObj->setApplicationUserId($this->session->get('EMPID'));
                                        
                                        $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                                        $Empname = $EmpObj->getPersonFk()->getPersonName();                                               
                                        $branch_id = $this->cmnservice->getBranchIdByGivingEmpId($this->session->get('EMPID'));  
                                        
                                        $cashDepositHisObj->setDepositWithdrawalBy($Empname);
                                        $cashDepositHisObj->setBranchOfficeCode($branch_id);
                                        $cashDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($cashDepositHisObj);
                                        $this->em->flush();
                                        
                                    }else{
                                        //paymentMode != 1 is other mode, then we select bank account
                                        $findBankObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->findOneByBankFk($advPayObj->getAmountEnterAccountId()); 
                                        $currentBankBal = $findBankObj->getCurrentAmount();
                                        $newBalance = $currentBankBal + $txt_advanceAmount;
                                        $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid()); 
                                        $bankAccObj->setCurrentAmount($newBalance);
                                        $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();
                                       
                                        //for inserting into bank Deposit history
                                        $bankDepositHisObj = new AccountBankDipositWithdrawalHistory();
                                        $bankDepositHisObj->setDepositWithdrawalKey('D');
                                        $bankDepositHisObj->setAmount($txt_advanceAmount);
                                        $bankDepositHisObj->setDate(new \Datetime());
                                        $bankDepositHisObj->setDescription($txt_description);
                                        $bankDepositHisObj->setRecordActiveFlag(1);
                                        $bankDepositHisObj->setRecordInsertDate(new \Datetime());
                                        $bankDepositHisObj->setBankFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($advPayObj->getAmountEnterAccountId()));
                                        $bankDepositHisObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($paymentMode));
                                        $bankDepositHisObj->setPaymentNo($advPayObj->getPaymentNo());
                                        $bankDepositHisObj->setApplicationUserId($this->session->get('EMPID'));
                                        
                                        $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                                        $Empname = $EmpObj->getPersonFk()->getPersonName();                                               
                                        $branch_id = $this->cmnservice->getBranchIdByGivingEmpId($this->session->get('EMPID'));  
                                        
                                        $bankDepositHisObj->setDepositWithdrawalBy($Empname);
                                        $bankDepositHisObj->setBranchOfficeCode($branch_id);
                                        $bankDepositHisObj->setApplicationUserIpAddress($this->session->get('IP'));
                                        $this->em->persist($bankDepositHisObj);
                                        $this->em->flush();
                                    }
                                    
                                    
                                    //after approved advance amount  will entry to account details                   
                                    $accDetailsObj = new AccountDetailsMaster();  
                                    
                                    //set to sales account head(fixed) CustomerConstant::CUSTOMER_ADVANCE_PAYMENT_RECIEPT
                                    $cusPaymentReceiptObj = $this->em->getRepository(CustomerConstant::CUSTOMER_ADVANCE_PAYMENT_RECIEPT)->findOneByAdvancePaymentFk($val);
                                    $receiptNo = $cusPaymentReceiptObj->getReceiptNo();
                                    $accDetailsObj->setPrcFormat($receiptNo);
                                    $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(1));
                                    $accDetailsObj->setAmount($txt_advanceAmount);
                                    $accDetailsObj->setDate(new \Datetime($approveOrRejectDate));
                                    $accDetailsObj->setDescription($txt_description);
                                    $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                                    $accDetailsObj->setRecordActiveFlag(1);
                                    $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->persist($accDetailsObj); 
                                    $this->em->flush();                                                                      
                                    
                                    
                                    $msg = 'Payment Detail has been approved successfully';
                                    break;
                        case 'R' :  //R means reject
                                    $advPayObj->setPaymentStatus('R');          
                                    $advPayObj->setRejectedDate(new \Datetime($approveOrRejectDate)); 
                                    $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                    $msg = 'Payment Rejected.';
                                    break;
                    }                                                                        
                }
                //Saving transaction date
                $empid=$this->session->get('EMPID');
                $tranDate=$this->em->getRepository(CommonConstant::ENT_TRANSACTION_DATE)->findBy(array('employeeId'=>$empid,'moduleId'=>'CRAPPR','recordActiveFlag'=>1));
                if(!$tranDate){
                    $tranDate=new TransactionDate();
                    $tranDate->setModuleId('CRAPPR');
                    $tranDate->setEmployeeId($this->session->get('EMPID'));
                    $tranDate->setLastSelectedDate(new \DateTime($approveOrRejectDate));
                    $tranDate->setRecordInsertDate(new \DateTime("NOW"));
                    $tranDate->setRecordActiveFlag(1);
                    $this->em->persist($tranDate);
                }else{
                    $tranDate[0]->setLastSelectedDate(new \DateTime($approveOrRejectDate));
                    $tranDate[0]->setRecordUpdateDate(new \DateTime("NOW"));
                }    
                $this->em->flush($tranDate);
                $conn->commit();
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            
            
            return $msg;
    }
    
  public function findDistinctEmpOfPaymentCollection() {
        try {                   
            $queryString = "SELECT DISTINCT(a.applicationUserId)  emp_id
                            FROM TashiCommonBundle:CusAdvancePayment a                             
                            WHERE a.recordActiveFlag = 1 "; 
            $query = $this->em->createQuery($queryString);          
            $resultSearch = $query->getResult();
                       
            } catch (\Exception $ex) {
            return $this->cmnservice->CommonError($ex,'retrieval');
        }     
        return $resultSearch;
    }
	 
    
    
public function searchRevenueReport($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $collect_by = $dataUI->txt_collection_by;  
            $start_date = $dataUI->txt_startDate;
            $end_date = $dataUI->txt_endDate;
            

            $parameters = array();
            $queryString = "SELECT a 
                             FROM TashiCommonBundle:CusAdvancePayment a                             
                             WHERE a.recordActiveFlag=:activFlag ";                                     
            $parameters['activFlag'] = 1;
            if (!empty($collect_by) && !is_null($collect_by)) {
                $queryString .= " AND a.applicationUserId = :collectBy ";
                $parameters['collectBy'] = $collect_by;
            }
            if (!empty($end_date) && !is_null($end_date)) {
                $queryString .= " AND a.createdDate BETWEEN :startDate AND :endDate ";
                $parameters['startDate'] = $start_date;
                $parameters['endDate'] = $end_date;
            }else{
                if (!empty($start_date) && !is_null($start_date)) {
                    $queryString .= " AND a.createdDate = :startDate ";
                    $parameters['startDate'] = $start_date;
                }
            }
            $queryString .= " ORDER BY a.createdDate ASC";
            
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
            
        } catch (\Exception $ex) {
            return $this->cmnservice->CommonError($ex,'retrieval');
        }
        
        return $resultSearch;
    }    
    public function SearchCustomer($request) {

        $dataUI = json_decode($request->getContent());
        $cusName = $dataUI->txtCustomerName;
        $cusId = $dataUI->txtCustomerId;
        //$cusPanNo=$dataUI->txtPanCardNo;
        $mobileNo = $dataUI->txtMobileNo;

        $keyword = '';
        $parameterValues = array();
        if(!(empty($cusId) && empty($cusName) && empty($mobileNo)))
        {
            if (!is_null($cusName) && !empty($cusName)) {
                $keyword = ' customer.customerName LIKE :custName AND cu.isPrimaryContact=1';
                $parameterValues['custName'] = '%' . $cusName . '%';
            }

            if (!is_null($cusId) && !empty($cusId)) {
                if (!empty($keyword)) {
                    $keyword .= ' AND';
                }
                $keyword .= ' customer.customerId LIKE :custiD AND cu.isPrimaryContact=1';
                $parameterValues['custiD'] = $cusId . '%';
            }



            if (!is_null($mobileNo) && !empty($mobileNo)) {
                if (!empty($keyword)) {
                    $keyword .= ' AND';
                }
                $keyword .= ' mobile.mobileNo LIKE :mobileno ';
                $parameterValues['mobileno'] = $mobileNo . '%';
            }
        }

        try {
            $user = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->findcustByAnyCondition($keyword, $parameterValues);
        } catch (\Exception $ex) {
            return $this->cmnservice->CommonError($ex,'retrieval');
        }
        if (!is_null($user)) {
            return $user;
        } else {
            return false;
        }
    }
    
    public function insertContactFormDetails($dataUI) {
        $custid=$dataUI->inputcustId;
        $contactName = $dataUI->txt_name;
        $emailId = $dataUI->emailId;
        $telephoneNo = $dataUI->phoneNo;
        $mobileNo = $dataUI->mobileNo;
        $selPrimaryContact = $dataUI->selPrimaryContact;       
        $contactTxnObj = $personObj = $contactTxnObj = '';
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $mobMaster=$this->em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->findBy(array('mobileNo'=>$mobileNo,'recordActiveFlag'=>1));
            if($mobMaster){
                return array('code'=>0,'msg'=>'Mobile Number already in used.');
            }else{
                $mobMaster=new CmnMobileNoMaster();
                $mobMaster->setMobileNo($mobileNo);
                $mobMaster->setApprovalFlag(1);
                $mobMaster->setRecordActiveFlag(1);
                $mobMaster->setRecordInsertDate(new \DateTime("NOW"));
                $mobMaster->setApplicationUserId($this->session->get('EMPID'));
                $mobMaster->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($mobMaster);
                $this->em->flush($mobMaster);
            }
            $person=new CmnPerson();
            $person->setPersonName($contactName);
            $person->setEmailId($emailId);
            $person->setTelephoneNo($telephoneNo);
            $person->setRecordActiveFlag(1);
            $person->setRecordInsertDate(new \DateTime("NOW"));
            $person->setApplicationUserId($this->session->get('EMPID'));
            $person->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($person);
            $this->em->flush($person);
            //customer_cont_txn
            $customer=$this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($custid);
            $contTxn=new CusContactTxn();
            if($selPrimaryContact){
                $exContacts=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid));
                foreach($exContacts as $cont){
                    $cont->setIsPrimaryContact(0);
                    $this->em->flush($cont);
                }
                $contTxn->setIsPrimaryContact(1);
            }else{
                $contTxn->setIsPrimaryContact(0);
            }            
            $contTxn->setCustomerFk($customer);
            $contTxn->setPersonFk($person);
            $contTxn->setApprovalFlag(1);
            $contTxn->setRecordActiveFlag(1);
            $contTxn->setRecordInsertDate(new \DateTime("NOW"));
            $contTxn->setApplicationUserId($this->session->get('EMPID'));
            $contTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($contTxn);
            $this->em->flush($contTxn);
            // contact_mobileno_txn
            $conMobTxn=new CusContactMobileNoTxn();
            $conMobTxn->setContact($contTxn);
            $conMobTxn->setMobileNo($mobMaster);
            $conMobTxn->setApprovalFlag(1);
            $conMobTxn->setRecordActiveFlag(1);
            $conMobTxn->setRecordInsertDate(new \DateTime('NOW'));
            $conMobTxn->setApplicationUserId($this->session->get('EMPID'));
            $conMobTxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($conMobTxn);
            $this->em->flush($conMobTxn);
            $conn->commit();
            $returncode=1;
            $returnmsg= 'Contact Detail has been saved successfully';            
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=  CommonConstant::ERR_DB_OPERATION;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function UpdateContact($dataUI){
        $custid=$dataUI->inputcustId;
        $contactid=$dataUI->inputcontId;
        $contactName = $dataUI->txt_name;
        $emailId = $dataUI->emailId;
        $telephoneNo = $dataUI->phoneNo;
        $mobileNo = $dataUI->mobileNo;
        $selPrimaryContact = $dataUI->selPrimaryContact;       
        $contactTxnObj = $personObj = $contactTxnObj = '';
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $contact=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->find($contactid);
            
            $conmobtxn=$this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findOneBy(array('contact'=>$contactid,'recordActiveFlag'=>1));
            if($conmobtxn){
                $prevMobObj=$conmobtxn->getMobileNo(); //existing mobile number
                $prevMobNo=$prevMobObj->getMobileNo();
                if($prevMobNo!=$mobileNo){ //if existing mobile no. !=new then deactivate previous and insert new one otherwise ignore it.
                    $prevMobObj->setRecordActiveFlag(0);
                    $prevMobObj->setRecordUpdateDate(new \DateTime('NOW'));
                    $this->em->flush($prevMobObj);
                    //deactivate contact mobile txn
                    $conmobtxn->setRecordActiveFlag(0);
                    $conmobtxn->setRecordUpdateDate(new \DateTime('NOW'));
                    $this->em->flush($conmobtxn);
                    //insert new mobile
                    $mobMaster=new CmnMobileNoMaster();
                    $mobMaster->setMobileNo($mobileNo);
                    $mobMaster->setApprovalFlag(1);
                    $mobMaster->setRecordActiveFlag(1);
                    $mobMaster->setRecordInsertDate(new \DateTime("NOW"));
                    $mobMaster->setApplicationUserId($this->session->get('EMPID'));
                    $mobMaster->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($mobMaster);
                    $this->em->flush($mobMaster);  
                    //insert new mobile contact txn;
                    $conMobTxn=new CusContactMobileNoTxn();
                    $conMobTxn->setContact($contact);
                    $conMobTxn->setMobileNo($mobMaster);
                    $conMobTxn->setApprovalFlag(1);
                    $conMobTxn->setRecordActiveFlag(1);
                    $conMobTxn->setRecordInsertDate(new \DateTime('NOW'));
                    $conMobTxn->setApplicationUserId($this->session->get('EMPID'));
                    $conMobTxn->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($conMobTxn);
                    $this->em->flush($conMobTxn);                    
                }
            }
            if($selPrimaryContact){
                if($contact->getIsPrimaryContact()==0){
                    $contactArr=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBy(array('customerFk'=>$custid,'recordActiveFlag'=>1));
                    foreach($contactArr as $cont){
                        $cont->setIsPrimaryContact(0);
                        $cont->setRecordUpdateDate(new \DateTime("NOW"));
                        $this->em->flush($cont);
                    }
                    $contact->setIsPrimaryContact(1);
                    $this->em->flush($contact);
                }
            }            
            
            $person=$contact->getPersonFk();
            $person->setPersonName($contactName);
            $person->setEmailId($emailId);
            $person->setTelephoneNo($telephoneNo);           
            $person->setRecordUpdateDate(new \DateTime("NOW"));
            $person->setApplicationUserId($this->session->get('EMPID'));
            $person->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush($person);   
            
            $conn->commit();
            $returncode=1;
            $returnmsg= 'Contact Detail has been updated successfully';            
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=  CommonConstant::ERR_DB_OPERATION;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function DeleteContact($contactid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $contact=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->find($contactid);
            $conmobtxn=$this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBy(array('contact'=>$contact,'recordActiveFlag'=>1));
            if($conmobtxn){
                foreach($conmobtxn as $cmob){
                    $mobilemaster=$cmob->getMobileNo();
                    if($mobilemaster){
                        $mobilemaster->setRecordActiveFlag(0);
                        $mobilemaster->setRecordUpdateDate(new \DateTime('now')); 
                        $this->em->flush($mobilemaster);
                    }
                    $cmob->setRecordActiveFlag(0);
                    $cmob->setRecordUpdateDate(new \DateTime('now')); 
                    $this->em->flush($cmob);
                }
                $contact->setRecordActiveFlag(0);
                $contact->setRecordUpdateDate(new \DateTime('now')); 
                $this->em->flush($contact);
                $conn->commit();
                $returncode=1;
                $returnmsg= 'Contact has been deleted successfully';
            }
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=  CommonConstant::ERR_DB_OPERATION;
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    /*************************************/
    /******************ERP****************/
    /*************************************/
    /*
     * Like search by passing any entity , fieldname and value to search
     * return true if found or false if not found
     */

    public function searchAnySingleFieldByLike($entityName, $fieldName, $fieldValue) {

        $sql = "SELECT r FROM TashiCommonBundle:" . $entityName . " r WHERE r." . $fieldName . " LIKE '" . $fieldValue . "'";
        $query = $this->em->createQuery($sql);

        // Execute Query
        return $query->getResult();
    }    
    
    public function SearchCustomerforComm($request) {
        $dataUI = json_decode($request->getContent());
        $cusName = $dataUI->txtCustomerName;
        $cusId = $dataUI->txtCustomerId;
        //$cusPanNo=$dataUI->txtPanCardNo;
        $mobileNo = $dataUI->txtMobileNo;

        $keyword = '';
        $parameterValues = array();
        if(!(empty($cusId) && empty($cusName) && empty($mobileNo)))
        {
            if (!is_null($cusName) && !empty($cusName)) {
                $keyword = ' customer.customerName LIKE :custName';
                $parameterValues['custName'] = '%' . $cusName . '%';
            }

            if (!is_null($cusId) && !empty($cusId)) {
                if (!empty($keyword)) {
                    $keyword .= ' AND';
                }
                $keyword .= ' customer.customerId LIKE :custiD';
                $parameterValues['custiD'] = $cusId . '%';
            }



            if (!is_null($mobileNo) && !empty($mobileNo)) {
                if (!empty($keyword)) {
                    $keyword .= ' AND';
                }
                $keyword .= ' mobile.mobileNo LIKE :mobileno';
                $parameterValues['mobileno'] = $mobileNo . '%';
            }
        }

        try {
            $user = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->findcustforComByAnyCondition($keyword, $parameterValues);
        } catch (\Exception $ex) {
            return $this->cmnservice->CommonError($ex,'retrieval');
        }
        if (!is_null($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public function getPendingCus() {
        try {

            $user = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->findpendingCust();
        } catch (\Exception $ex) {
            return $this->cmnservice->CommonError($ex,'retrieval');
        }
        if (!is_null($user)) {
            return $user;
        } else {
            return false;
        }
    }

    public function CreateCustomer($request) {
        $dataUI = json_decode($request->getContent());
        $cusName = $dataUI->txtCustomerName;
        $cusContactperson = $dataUI->txtContactPerson;
        $cusContactNumber = $dataUI->txtcontactMobNo;
        $email = $dataUI->emailId;
        $about= $dataUI->txtAbout;
        $conn=$this->em->getConnection();
        try {
            $conn->beginTransaction();
            // New object for Inserting Customer detail
            $customerid=$this->cmnservice->AutoGenerate('CUS',5,'CusCustomer','customerIdPk');
            $custobj = new CusCustomer();
            $custobj->setCustomerId($customerid);
            $custobj->setCustomerName($cusName);
            $custobj->setAbout($about);
            $custobj->setRecordActiveFlag(1);
            $custobj->setStatusFlag(1);
            $this->em->persist($custobj);
            $this->em->flush();

//            //update customer Id in customer Table
//            $pkid = $custobj->getCustomerIdPk();
//            $updatecusID = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($pkid);
//            $updatecusID->setCustomerId($pkid);
            $this->session->set('customerId', $custobj->getCustomerIdPk());
//            $this->em->flush();

            //new object for inserting Contact Person Name and phone Number
            $personobj = new CmnPerson();
            $personobj->setPersonName($cusContactperson);
            $personobj->setEmailId($email);
            $personobj->setRecordActiveFlag(1);
            $this->em->persist($personobj);
            $this->em->flush();
            $person=$this->em->getRepository('TashiCommonBundle:CmnPerson')->find($personobj->getPersonPk());
            //new object for inserting Customer-Contact relation             
            $contactTxnObj = new CusContactTxn();
            $contactTxnObj->setCustomerFk($custobj);
            $contactTxnObj->setIsPrimaryContact(1);
            $contactTxnObj->setApprovalFlag(1);
            $contactTxnObj->setRecordActiveFlag(1);            
            $contactTxnObj->setRecordInsertDate(new \DateTime("NOW"));
            $contactTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $contactTxnObj->setPersonFk($person);
            //print_r($contactTxnObj);
            $this->em->persist($contactTxnObj);
            $this->em->flush();
            //new mobile master object
            $mobMaster = new CmnMobileNoMaster;
            $mobMaster->setMobileNo($cusContactNumber);
            $mobMaster->setApprovalFlag(1);
            $mobMaster->setRecordActiveFlag(1);
            $mobMaster->setRecordInsertDate(new \DateTime('now'));
            $mobMaster->setApplicationUserId($this->session->get('EMPID'));
            $this->em->persist($mobMaster);
            $this->em->flush($mobMaster);
            //new mobileTxn Object
            $mobMasterTxn = new CusContactMobileNoTxn();
            $mobMasterTxn->setMobileNo($mobMaster);
            $mobMasterTxn->setContact($contactTxnObj);
            $mobMasterTxn->setApprovalFlag(1);
            $mobMasterTxn->setRecordActiveFlag(1);
            $mobMasterTxn->setRecordInsertDate(new \DateTime('now'));
            $mobMasterTxn->setApplicationUserId($this->session->get('EMPID'));
            $this->em->persist($mobMasterTxn);
            $this->em->flush($mobMasterTxn);
            $conn->commit();
            $returncode=1;
            $returnmsg='Customer detail has been saved successfully';
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->cmnservice->CommonError($ex,'dberror');
            
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function UpdateCustomer($request) {

        $dataUI = json_decode($request->getContent());
        $custid = $dataUI->inputUpdCustId;
        $custname=$dataUI->customerName;
        $about=$dataUI->txtAbout;
        try {
            $customer = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($custid);  
            $customer->setCustomerName($custname);
            $customer->setAbout($about);
            $this->em->flush();
            $returncode=1;
            $returnmsg='Customer detail has been updated successfully.';
        } catch (\exception $ex) {
            $returncode=0;
            $returnmsg=$this->cmnservice->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function DeleteCustomer($custid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $customer=$this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custid);
            $conTxn=$this->em->getRepository(CommonConstant::ENT_CONTACT_TXT)->findBycustomerFk($customer);
            $conmobTxn=$this->em->getRepository(CommonConstant::ENT_MOBILE_CONTACT_TXN)->findBycontact($conTxn);
            if($conTxn){
                //delete corresponding Contact Txn and Contact                
                foreach ($conTxn as $cont){
                    $cont->setApprovalFlag(0);
                    $cont->setRecordActiveFlag(0);
                    
                    $person=$cont->getPersonFk();
                    $person->setRecordActiveFlag(0);
                }                
            }
            if($conmobTxn){
                //Delete Contact_Mobile_Txn and Mobile Number
                foreach($conmobTxn as $cmob){
                    $cmob->setApprovalFlag(0);
                    $cmob->setRecordActiveFlag(0);
                    
                    $mobile=$cmob->getMobileNo();
                    $mobile->setApprovalFlag(0);
                    $mobile->setRecordActiveFlag(0);
                }
                
            }
            $customer->setStatusFlag(0);
            $customer->setRecordActiveFlag(0);
            
            $this->em->flush();
            $conn->commit();
            $returncode=1;
            $returnmsg='Customer and other related detail has been deleted successfully';            
        } catch (Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->cmnservice->CommonError($ex,'dberror');
        }
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }

    /**
     * This method is used to insertion only
     * 
     * @see ORMException,ApplicationController,CustomerController     
     */
    public function saveAddressDetails($request) {
        //$addressTypeId = $request->request->get('addressTypeId');
        $addmasterId=$request->request->get('inputmasterAddId');
        $addtxnId=$request->request->get('inputAddTxnId');
        $custid=$request->request->get('inputAddAddresscustId');
        $addCode=$request->request->get('addCode');
        $primayStatus=$request->request->get('inputisPrimaryAdd');
        $address1 = $request->request->get('address1');
        $address2 = $request->request->get('address2');
        $country = $request->request->get('country');
        $state = $request->request->get('state');
        $city = $request->request->get('city');
        $district = $request->request->get('district');
        $route = $request->request->get('route');
        $locality = $request->request->get('locality');
        $block = $request->request->get('block');
        $postOffice = $request->request->get('postOffice');
        $policeStation = $request->request->get('policeStation');
        $zipcode = $request->request->get('zipcode');
        $landmark = $request->request->get('landmark');
        $gpsLatitude = $request->request->get('gpsLatitude');
        $gpsLongitude = $request->request->get('gpsLongitude');
        //$recodeActiveFlag = $request->request->get('rec_status');
        $conn=$this->em->getConnection();
        try {
            $conn->beginTransaction();
            if ($addmasterId) {
                $address = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addmasterId);
                $address->setRecordUpdateDate(new \DateTime('now'));
                $address->setApplicationUserId($this->session->get('EMPID'));
            }
            else{
                $address = new CmnLocationAddressMaster();
                $address->setRecordInsertDate(new \DateTime('now'));
                $address->setApplicationUserId($this->session->get('EMPID'));
            }
            $address->setAddressTypeFk($this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find(1));
            $address->setAddress1($address1);
            $address->setAddress2($address2);
            //$address->setCityName($city);
            $address->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city));
            if ($state != '') {
                $address->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            }
            if ($country != '') {
                $address->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            }
            $address->setPinNumber($zipcode);
            $address->setPoliceStation($policeStation);
            $address->setPostOffice($postOffice);
            $address->setGpsLatitude($gpsLatitude);
            $address->setGpsLogitude($gpsLongitude);
            $address->setLandmark($landmark);
            if ($district != '') {
                $address->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            }
            //$address->setRoute($route);
            //$address->setLocality($locality);
            $address->setBlockVillage($block);
            $address->setRecordActiveFlag(1);
            if (!$addmasterId){
                $this->em->persist($address);
            }
            $this->em->flush();
            //address txn
            //if the new address is primary then set other existing address to value 0(non-primary)
            
            if($primayStatus==1){
                $exAddTxn=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findByCustomerFk($custid);                
                foreach($exAddTxn as $addtxn){
                    $addtxn->setIsPrimaryAddress(0);
                    $this->em->flush();
                }
            }
            else{
                
            }
            //add/update the new/existing address
            if ($addtxnId) {
                $addressTxn = $this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($addtxnId);
                $addressTxn->setRecordUpdateDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
            }
            else{
                $addressTxn = new CusAddressTxn();
                $addressTxn->setAddressFk($address);
                $addressTxn->setCustomerFk($this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custid));
                $addressTxn->setRecordInsertDate(new \DateTime("now"));
                $addressTxn->setApplicationUserId($this->session->get('EMPID'));
            }   
            $addressTxn->setAddressCode($addCode);
            $addressTxn->setIsPrimaryAddress($primayStatus);
            $addressTxn->setApprovalFlag(1);
            $addressTxn->setRecordActiveFlag(1);
            if (!$addtxnId) {                
                $this->em->persist($addressTxn);
            }
            $this->em->flush();
            $returncode=1;//1 for successfull operation and O for failed orperation
            $returnmsg=$addressTxn;
            $conn->commit();
        }
        catch (\Doctrine\DBAL\DBALException $dbalex){
            $conn->rollBack();
            $returncode=0;
            $returnmsg='Duplicate Address Code';
            if($this->cmnservice->isDuplicateEntry($dbalex,'Unique_AddCode')){
                $returnmsg='Address Code is already in use by the same customer.';
            }            
        }
        catch (\Exception $ex) {
            $conn->rollBack();
            $returncode=0;
            $returnmsg=$this->cmnservice->CommonError($ex,'dberror');            
        }
        //$conn->close();
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    public function CimDeleteAddress($addtxnid){
        $conn=$this->em->getConnection();
        try{
            $conn->beginTransaction();
            $addtxn=$this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->find($addtxnid);
            $addmaster=$addtxn->getAddressFk();
            //update address master
            $addmaster->setRecordActiveFlag(0);
            $addmaster->setRecordUpdateDate(new \DateTime("now"));
            $addmaster->setApplicationUserId($this->session->get('EMPID'));
            $this->em->flush();
            //update address txn
            $addtxn->setApprovalFlag(0);
            $addtxn->setRecordActiveFlag(0);
            $addtxn->setRecordUpdateDate(new \DateTime("now"));
            $addtxn->setApplicationUserId($this->session->get('EMPID'));
            $this->em->flush();
            $conn->commit();
            $returnmsg='Address has been removed successfully.';
            $returncode=1;
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg=$this->cmnservice->CommonError($ex,'dberror');
            $returncode=0;
        }
        $conn->close();
        return array('code'=>$returncode,'msg'=>$returnmsg);
    }
    /**
     * This method is used to insert in the CusAddressTxn table for a customer at the time when 
     * the customer Save address Detail
     * 
     * @see ORMException,CustomerController     
     */
    public function fnForInsertionIntoCustomerAddressTxn($insertedAddrId, $updateDate, $mode,$addressCode,$isPrimary) {
        if ($mode == 'INS') {
            $customerAddressTxn = new CusAddressTxn();
            $customerAddressTxn->setAddressCode($addressCode);
            if($isPrimary){
             $customerAddressTxn->setIsPrimaryAddress($isPrimary);   
            }
            $customerAddressTxn->setCustomerFk($this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->find($this->session->get('customerId')));
            $customerAddressTxn->setAddressFk($this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($insertedAddrId));
            $customerAddressTxn->setRecordActiveFlag(1);
        } else {
            $customerAddressTxn = $this->em->getRepository(CommonConstant::ENT_CUS_ADD_TXN)->findOneBy(array('customerFk' => $this->session->get('customerId'), 'addressFk' => $insertedAddrId));
        }
//     $customerAddressTxn->setRecordUpdateDate(new \DateTime($updateDate));
        if ($mode == 'INS') {
            $this->em->persist($customerAddressTxn);
        }
        $this->em->flush();
        $addressInfo = $this->em->getRepository(CommonConstant::CUSTOMER_DETAIL)->listAddressOrderByType($this->session->get('customerId'), CommonConstant::ENT_CUS_ADD_TXN);
        return $addressInfo;
    }

    /**
     * This method is used to list all the district for the particular state---
     * 
     * @see ORMException,CustomerController     
     */
    public function loadDistrictList($request) {
        $dataUI = json_decode($request->getContent());
        $stateId = $dataUI->stateId;
        $typeIdentifierForAddress = $dataUI->typeIdentifierForAddress;
        $district = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findByStateFk($stateId, array('districtName' => 'ASC'));

        return array('district' => $district, 'typeIdentifierForAddress' => $typeIdentifierForAddress);
    }    
    public function SendSMS($request){
        $dataUI=  json_decode($request->getContent());
        $mobnosui=$dataUI->inputMobNos;
        $custidui=$dataUI->inputSmscustid;
        $contidui=$dataUI->inputSmscontid;
        $subject=$dataUI->txtSubject;
        $message=$dataUI->txtSmsMessage;
        $uniquesmsids=array();
        $errCount=0;
        $successCount=0;
        if(is_array($mobnosui)){
            for($i=0;$i<count($mobnosui);$i++){
                $conn=$this->em->getConnection();
                $conn->beginTransaction();
                try{
                    $comMaster=new CmnCommunicationMessageMaster();
                    $comTxn=new CmnCommunicationTxn();
                    $customer=$this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custidui[$i]);
                    $contact=$this->em->getRepository('TashiCommonBundle:CusContactTxn')->find($contidui[$i]);
                    $comMaster->setCommunicationType('SMS');
                    $comMaster->setMessageContent($message);
                    $comMaster->setApprovalFlag(1);
                    $comMaster->setRecordActiveFlag(1);
                    $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                    $comMaster->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->persist($comMaster);
                    $this->em->flush();

                    $comTxn->setMessageFk($comMaster);
                    $comTxn->setCustomerFk($customer);
                    $comTxn->setContactFk($contact);
                    $comTxn->setSentDatetime(new \DateTime("NOW"));
                    $comTxn->setStatus(0);
                    $comTxn->setApprovalFlag(1);
                    $comTxn->setRecordActiveFlag(1);
                    $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                    $comTxn->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->persist($comTxn);
                    $this->em->flush();
                    $smsid=$this->ReplyMessage($message,$mobnosui[$i]);
                    if($smsid!=null){
                        $comTxn->setUniqueSmsId($smsid);
                        $this->em->flush(); 
                        //array_push($uniquesmsids, $smsid);
                        $conn->commit();   
                        $successCount++;
                    }
                    else{    
                        $errCount++;
                    }

                } catch (Exception $ex) {
                    $conn->rollBack(); 
                    $errCount++;
                }                
            }
            if($successCount>0 && $errCount<=0){
                $returncode=1;
                $returnmsg='SMS has been sent to all the numbers successfully.';
            }
            elseif($successCount>0 && $errCount>0){
                $returncode=1;
                $returnmsg='Not all SMS were sent only few were sent.';
            }
            elseif($successCount<=0 && $errCount>0){
                $returncode=1;
                $returnmsg='Could not sent SMS. Please check your internet connectivity and try again.';
            }
        }
        else{
            $conn=$this->em->getConnection();
            $conn->beginTransaction();
            try{
                $comMaster=new CmnCommunicationMessageMaster();
                $comTxn=new CmnCommunicationTxn();
                $customer=$this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custidui);
                $contact=$this->em->getRepository('TashiCommonBundle:CusContactTxn')->find($contidui);
                $comMaster->setCommunicationType('SMS');
                $comMaster->setMessageSubject($subject);
                $comMaster->setMessageContent($message);
                $comMaster->setApprovalFlag(1);
                $comMaster->setRecordActiveFlag(1);
                $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                $comMaster->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($comMaster);
                $this->em->flush();
                
                $comTxn->setMessageFk($comMaster);
                $comTxn->setCustomerFk($customer);
                $comTxn->setContactFk($contact);
                $comTxn->setSentDatetime(new \DateTime("NOW"));
                $comTxn->setStatus(0);
                $comTxn->setApprovalFlag(1);
                $comTxn->setRecordActiveFlag(1);
                $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                $comTxn->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($comTxn);
                $this->em->flush();
                $smsid=$this->ReplyMessage($message,$mobnosui);
                if($smsid!=null){
                    $comTxn->setUniqueSmsId($smsid);
                    $this->em->flush();
//                    if($this->CheckDelivery($smsid)){
//                        $comTxn->setStatus(1);
//                        $this->em->flush();
//                    }  
                    //array_push($uniquesmsids, $smsid);
                    $conn->commit();
                    $returncode=1;
                    $returnmsg='SMS has been sent successfully';
                }
                else{
                    $returncode=0;
                    $returnmsg='Could not sent SMS. Please make sure you are connected to internet and you have enough balance in your account and try again.';
                }
                
            } catch (Exception $ex) {
                $conn->rollBack();
                $returncode=0;
                $returnmsg='Could not sent SMS.Error: '.$ex->getMessage();
            }
            //UPDATE DELIVERY STATUS
//            if(count($uniquesmsids)>0){
//                foreach($uniquesmsids as $smsid){
//                    $comtxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->findByUniqueSmsId($smsid)[0];
//                    if($comMaster){
//                     $comtxn->setStatus(1);
//                     $this->em->flush();
//                    }                        
//                }
//            }
        }
        return array('code'=>$returncode,'msg'=>$returnmsg,'smsid'=>$smsid);
    }
    public function SendEmail($request){
        //$dataUI=  json_decode($request->getContent());
        $dataUI=$request->request;
        $emailui=$dataUI->get('inputEmails');
        $custidui=$dataUI->get('inputSmscustid');
        $contidui=$dataUI->get('inputSmscontid');
        $subject=$dataUI->get('txtSubject');
        $actualMsg=$dataUI->get('txtareaEmail');
        $attachArr=$request->files->get('attachemnt');
        $errCount=0;
        $successCount=0;
        if(is_array($emailui)){
            for($i=0;$i<count($emailui);$i++){
                $conn=$this->em->getConnection();
                $conn->beginTransaction();
                try{
                    $comMaster=new CmnCommunicationMessageMaster();
                    $comTxn=new CmnCommunicationTxn();
                    $customer=$this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custidui[$i]);
                    $contact=$this->em->getRepository('TashiCommonBundle:CusContactTxn')->find($contidui[$i]);
                    $comMaster->setCommunicationType('EMAIL');
                    $comMaster->setMessageContent($actualMsg);
                    $comMaster->setApprovalFlag(1);
                    $comMaster->setRecordActiveFlag(1);
                    $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                    $comMaster->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->persist($comMaster);
                    $this->em->flush();

                    $comTxn->setMessageFk($comMaster);
                    $comTxn->setCustomerFk($customer);
                    $comTxn->setContactFk($contact);
                    $comTxn->setSentDatetime(new \DateTime("NOW"));
                    $comTxn->setStatus(0);
                    $comTxn->setApprovalFlag(1);
                    $comTxn->setRecordActiveFlag(1);
                    $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                    $comTxn->setApplicationUserId($this->session->get('EMPID'));
                    $this->em->persist($comTxn);
                    $this->em->flush();
                    $emailResult=$this->SendMail($actualMsg,$subject,$emailui,$attachArr);
                    if($emailResult['code']==1){
                        $comTxn->setStatus(1);
                        $this->em->flush(); 
                        //array_push($uniquesmsids, $smsid);
                        $conn->commit();   
                        $successCount++;                
                    }
                    else{    
                        $errCount++;
                    }
                    $files=$emailResult['files'];
                } catch (Exception $ex) {
                    $conn->rollBack(); 
                    $errCount++;
                }                
            }
            if($successCount>0 && $errCount<=0){
                $returncode=1;
                $returnmsg='Email has been sent to all the numbers successfully.';
            }
            elseif($successCount>0 && $errCount>0){
                $returncode=1;
                $returnmsg='Not all Email were sent only few were sent.';
            }
            elseif($successCount<=0 && $errCount>0){
                $returncode=1;
                $returnmsg='Could not sent Email. Please check your internet connectivity and try again.';
            }
        }
        else{
            $conn=$this->em->getConnection();
            $conn->beginTransaction();
            try{
                $comMaster=new CmnCommunicationMessageMaster();
                $comTxn=new CmnCommunicationTxn();
                $customer=$this->em->getRepository('TashiCommonBundle:CusCustomer')->find($custidui);
                $contact=$this->em->getRepository('TashiCommonBundle:CusContactTxn')->find($contidui);
                $comMaster->setCommunicationType('EMAIL');
                $comMaster->setMessageSubject($subject);
                $comMaster->setMessageContent($actualMsg);
                $comMaster->setApprovalFlag(1);
                $comMaster->setRecordActiveFlag(1);
                $comMaster->setRecordInsertDate(new \DateTime("NOW"));
                $comMaster->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($comMaster);
                $this->em->flush();
                
                $comTxn->setMessageFk($comMaster);
                $comTxn->setCustomerFk($customer);
                $comTxn->setContactFk($contact);
                $comTxn->setSentDatetime(new \DateTime("NOW"));
                $comTxn->setStatus(0);
                $comTxn->setApprovalFlag(1);
                $comTxn->setRecordActiveFlag(1);
                $comTxn->setRecordInsertDate(new \DateTime("NOW"));
                $comTxn->setApplicationUserId($this->session->get('EMPID'));
                $this->em->persist($comTxn);
                $this->em->flush();                
                $emailResult=$this->SendMail($actualMsg,$subject,$emailui,$attachArr);
                if($emailResult['code']==1){
                    $comTxn->setStatus(1);
                    $this->em->flush();
                    $conn->commit();
                    $returncode=1;
                }else{
                    $returncode=0;                    
                }
                $returnmsg=$emailResult['msg'];
                $files=$emailResult['files'];
            } catch (Exception $ex) {
                $conn->rollBack();
                $returncode=0;
                $returnmsg=$this->cmnservice->CommonError($ex,'email');
            }
        }
        return array('code'=>$returncode,'msg'=>$returnmsg,'files'=>$files);
    }
    
    public function UpdateBulkSmsDeliveryStatus($custid){
        try{
            $comtxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->
                        findBy(array('customerFk'=>$custid,'approvalFlag'=>1,'recordActiveFlag'=>1,'status'=>0));
            if($comtxn){
                foreach($comtxn as $com){
                    $smsuniqueid=$com->getUniqueSmsId();
                    if($this->CheckDelivery($smsuniqueid)){
                        $com->setStatus(1);
                        $this->em->flush();
                    }
                }
            } 
       }catch (Exception $ex) {           
       }
       //return $comtxn;
    }
    public function CheckSMSDeliveryStatus($smsid){       
       $status=0;
       try{
           $comTxn=$this->em->getRepository('TashiCommonBundle:CmnCommunicationTxn')->find($smsid);
           $smsuniqueid=$comTxn->getUniqueSmsId();
           if($smsuniqueid){
               if($this->CheckDelivery($smsuniqueid)){
                   $comTxn->setStatus(1);
                   $status=1;
                   $this->em->flush();
               }               
           }else{
                   $status=2;//message not sent
               }
           $returncode=1;
           $returnmsg='';
       } catch (Exception $ex) {
           $returncode=0;
           $returnmsg=$this->cmnservice->CommonError($ex,'dberror');
       }
       return array('code'=>$returncode,'msg'=>$returnmsg,'status'=>$status);
    }
    public function SendMail($msg,$subject,$recipient,$attachArr){
        try{
            $uploadedFileArr=array();
            $env = new \Twig_Environment(new \Twig_Loader_String());
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom('itsupport@tashiinteriors.com','TASHI-INTERIORS')
                ->setTo($recipient)
                ->setBody($env->render('{{msg}}',array('msg'=>$msg)));
            if($attachArr){
                foreach($attachArr as $attachment){
                    $path='upload/COMMUNICATION/ATTACHMENT/';
                    $fuploadresult=$this->cmnservice->UploadFileWithOriginalName($attachment,$path,25,'');
                    if($fuploadresult['code']==1){
                        $uploadedFile=$fuploadresult['fullpath'];               
                        $message->attach(\Swift_Attachment::fromPath($uploadedFile));
                        array_push($uploadedFileArr,$uploadedFile);
                    }else{                            
                        //foreach($uploadedFiles as $file){
//                            if(file_exists($file)){
//                                unlink($file);
//                            }
                        //}
                        return array('code'=>0,'msg'=>$fuploadresult['msg'],'files'=>$uploadedFileArr);                        
                    }
                }
            }

            if($this->mailer->send($message)==1){                
                return array('code'=>1,'msg'=> 'Email sent successfully','files'=>$uploadedFileArr);
            }else{
                return array('code'=>0,'msg'=>  CommonConstant::ERR_EMAIL_SENDING,'files'=>$uploadedFileArr);
            }
        }
        catch(\Swift_TransportException $se){
            return array('code'=>0,'msg'=>  $this->cmnservice->CommonError($se,'email'));
        }
        catch (\Exception $ex){
            return array('code'=>0,'msg'=>  $this->cmnservice->CommonError($ex,'email'));
        }        
    }
    
    
    public function ReplyMessage($msg,$sendto){
        try{
            $msg=  str_replace('.','%2E',$msg);
            $msg=  str_replace('\'','%27',$msg);
            $url='http://login.smsgatewayhub.com/smsapi/pushsms.aspx?user=kangla&pwd=kangla123&to='.$sendto.'&sid=NESDET&msg='.$msg.'&fl=0&gwid=2';
            $response = file_get_contents(str_replace(' ','%20',$url));                
            return $response; 
        }
        catch(\Exception $ex){
            return null;
        }
    }
    public function CheckDelivery($smsid){
        try{
            $url='https://api.smsgatewayhub.com/smsapi/checkdelivery.aspx?user=kangla&password=kangla123&messageid='.$smsid;    
            if(file_get_contents($url)=='#DELIVRD'){
                return true;
            }
            else{
                return false;
            }
        }catch(\Exception $ex){
            return false;
        }
    }
}

