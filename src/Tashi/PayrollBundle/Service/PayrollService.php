<?php





namespace Tashi\PayrollBundle\Service;


use Symfony\Component\HttpFoundation\Session\Session;

//use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
//use Symfony\Component\DependencyInjection\IntrospectableContainerInterface;

use Doctrine\ORM\EntityManager;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\PayrollBundle\Helper\PayrollConstant;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\WalletBundle\Helper\WalletConstant;
use Tashi\CommonBundle\Entity\PayrolMaster;
use Tashi\CommonBundle\Entity\CmnPaymentModeMaster;
use Tashi\CommonBundle\Entity\PayrolPaymentStatus;
use Tashi\CommonBundle\Entity\PayrolAdvancePayment;
use Tashi\CommonBundle\Entity\PayrolSalarySlip;
use Tashi\CommonBundle\Entity\PayrolRepaymentCollection;
use Tashi\CommonBundle\Entity\EmpAccountExpenses;
use Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster;
use Tashi\CommonBundle\Entity\PayrolSalarySlipEmolumentdeductionAmount;
use Tashi\CommonBundle\Entity\AccountDetailsMaster;
use Tashi\CommonBundle\Entity\EmpWorkerWageDetails;
use Tashi\CommonBundle\Entity\AccountCashDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountBankDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\PayrolPaymentDetails;
use Tashi\CommonBundle\Entity\PayrolSanctionSalaryId;
use Tashi\CommonBundle\Entity\PayrolSanctionSalarySlip;



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayrollService
 *
 * @author 5080
 */
class PayrollService {
    //put your code here
    
    protected $em;
    protected $session;
    protected $commonService;
    protected $webRoot;
    protected $mailer;
    protected $container;
    protected $pdf;
    protected $twig;
    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService,$mailer,$pdf,$twig) {
        $this->em = $em;
        $this->session = $session;
        $this->mailer=$mailer;
        $this->commonService = $commonService;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->pdf = $pdf; 
        $this->twig=$twig;
               
    }
    
    public function savePayrolPercentageCalculation($request){     
            $dataUI = json_decode($request->getContent());
            $payrol_master_id = $dataUI->txt_payrol_master_id;
            $basic_cal_pc = $dataUI->txt_basic_cal_pc; 
            $hra_cal_pc = $dataUI->txt_hra_cal_pc;
            $status = $dataUI->txt_status; 
            $description = $dataUI->txt_description;
            $date_of_use = $dataUI->txt_date_of_use;
            try{                    
                 if($payrol_master_id == ''){
                     //check if there is any record active      
                     $find_record_active_obj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_MASTER)->findByStatus(1);
                     if($find_record_active_obj){
                         return array('existing_flag' => 1, 'msg' => 'Please inactive or delete the existing active record and try again !');
                     }else{
                        $payrolMasterObj = new PayrolMaster(); 
                     }                    
                 }else{
                     //check if there is any record active  
                     $queryString = "SELECT p 
                            FROM TashiCommonBundle:PayrolMaster p                           
                            WHERE p.status = :activFlag 
                            AND p.pkid != :payrolId";

                    $query = $this->em->createQuery($queryString)
                             ->setParameters(array('activFlag' => 1, 'payrolId' => $payrol_master_id));
                    $result = $query->getResult();
                   
                     if($result){
                         return array('existing_flag' => 1, 'msg' => 'Please inactive or delete the existing active record and try again !');
                     }
                     $payrolMasterObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_MASTER)->find($payrol_master_id);
                 }

                 $payrolMasterObj->setBasicCalculationPercent($basic_cal_pc);
                 $payrolMasterObj->setHrCalculationPercent($hra_cal_pc);
                 $payrolMasterObj->setStatus($status);
                 $payrolMasterObj->setDateOfUse(new \DateTime($date_of_use));
                 $payrolMasterObj->setDescription($description);

                 if ($payrol_master_id == "") {
                     $payrolMasterObj->setRecordActiveFlag(1);
                     $payrolMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                     $payrolMasterObj->setApplicationUserId($this->session->get('EMPID'));
                     $payrolMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                     $this->em->persist($payrolMasterObj);
                 } else {
                     $payrolMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
                     $payrolMasterObj->setApplicationUserId($this->session->get('EMPID'));
                     $payrolMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                 }
                 $this->em->flush();
            } catch (\Exception $ex) {
                throw new \Exception($ex->getMessage());
            }

            if ($payrol_master_id == "") {
                $msg = 'Inserted new record successfully';
            }else{
                $msg = 'Updated record successfully';
            }

            return array(
                'msg' => $msg,   
                'existing_flag' => 0,
                'result' => $this->commonService->activeList('PayrolMaster'),
                'payrolMasterID' => $payrolMasterObj->getPkid()
            ); 
        
    }
    
    public function retrivePayrolPercentageCalculation( $pkid ){      
       try{
           $payrolMasterObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_MASTER)->find($pkid);   
           $date_of_use = '';
           if($payrolMasterObj->getDateOfUse()){
               $date_of_use = date_format($payrolMasterObj->getDateOfUse(), 'Y-m-d');
           }
           
           return array('payrolMasterID' => $payrolMasterObj->getPkid(),                                           
                        'basic_cal_pc' => $payrolMasterObj->getBasicCalculationPercent(),
                        'hra_cal_pc' => $payrolMasterObj->getHrCalculationPercent(),   
                        'description' => $payrolMasterObj->getDescription(),
                        'date_of_use' => $date_of_use,  
                        'status' => $payrolMasterObj->getStatus()                                                                                 
            ); 
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    public function deletePayrolPercentageCalculation( $pkid ){
        try{           
            $payrolMasterObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_MASTER)->find($pkid);          
            $payrolMasterObj->setRecordActiveFlag(0);
            $payrolMasterObj->setStatus(0);
            $payrolMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
            $payrolMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $payrolMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            return array('msg' => 'Deleted Record Succesfully');
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    public function saveEmolumentDeductionMaster($request, $page_type){
        try{          
           $dataUI = json_decode($request->getContent());
           $emolument_or_deduction_id = $dataUI->txt_emolument_or_deduction_id;
           $emolument_or_deduction_name = $dataUI->txt_emolument_or_deduction_name;
           $field_type = $dataUI->txt_field_type;         
           $description = $dataUI->txt_description;
            
           if($emolument_or_deduction_id == ''){
               $emoDeducObj = new PayrolEmolumentDeductionMaster();
               //add view of order key 
                 $viewOrderKey = 1;
                 $queryString = "SELECT MAX(v.viewOrder) maxViewOrder
                                 FROM TashiCommonBundle:PayrolEmolumentDeductionMaster v                           
                                 WHERE v.attributeType = :type";

                $query = $this->em->createQuery($queryString)
                         ->setParameters(array('type' => $field_type));
                $result = $query->getSingleResult();
                if($result){
                    $viewOrderKey = $result['maxViewOrder'] + 1;
                }else{
                    $viewOrderKey = 1;
                }
                $emoDeducObj->setViewOrder($viewOrderKey);
           }else{
               $emoDeducObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->find($emolument_or_deduction_id);
           }
           
           $emoDeducObj->setFieldAttributeName($emolument_or_deduction_name);
           $emoDeducObj->setAttributeType($field_type);
           $emoDeducObj->setDescription($description);
           $emoDeducObj->setApplicationUserId($this->session->get('EMPID'));
                $emoDeducObj->setApplicationUserIpAddress($this->session->get('IP'));
           
           if ($emolument_or_deduction_id == "") {
                $emoDeducObj->setRecordActiveFlag(1);
                $emoDeducObj->setRecordInsertDate(new \Datetime('NOW'));
                $this->em->persist($emoDeducObj);
           } else {
                $emoDeducObj->setRecordUpdateDate(new \Datetime('NOW'));
                
           }       
           $this->em->flush();
                            
           $pkid = $emoDeducObj->getPkid();         
           switch($page_type){
               case 'normalForm' : if($emolument_or_deduction_id == "") {
                                        $msg = 'Inserted new record successfully';
                                   } else {
                                       $msg = 'Updated record successfully';
                                  }
                                  $result = $this->commonService->activeList('PayrolEmolumentDeductionMaster');                             
                                  break;
               case 'popUpForm' : $result = $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->find($pkid); 
                                  $msg = 'Added new '. $field_type .' fields';                                 
                                  break;
           }
           
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        
        return array('msg' => $msg,
                     'result' => $result,
                     'emolument_or_deduction_id' => $pkid,
                     'addFieldType' => $field_type
                  );     
    }
    
    public function allEmoluments(){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->findBy(array('attributeType' => 'Emolument','recordActiveFlag' => 1 ), array('viewOrder' => 'ASC'));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
     public function allDeductions(){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->findBy(array('attributeType' => 'Deduction','recordActiveFlag' => 1 ), array('viewOrder' => 'ASC'));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

        public function retriveEmolumentDeductionMasterRecord($pkid){
         try{
             $emoDeducObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->find($pkid);
             return array(
                 'emolument_or_deduction_id' => $pkid,
                 'emolument_or_deduction_name' => $emoDeducObj->getFieldAttributeName(),
                 'attibute_type' => $emoDeducObj->getAttributeType(),
                 'description' => $emoDeducObj->getDescription()
             );
         } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
         }
    }
    
    public function deleteEmolumentDeductionMasterRecord($pkid){
         try{
             $emoDeducObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->find($pkid);           
             $emoDeducObj->setRecordActiveFlag(0);
             $emoDeducObj->setRecordUpdateDate(new \Datetime('NOW'));
             $emoDeducObj->setApplicationUserId($this->session->get('EMPID'));
             $emoDeducObj->setApplicationUserIpAddress($this->session->get('IP'));
             $this->em->flush();                
         } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
         }
         
         return array('msg' => 'Deleted Record Succesfully');      
    }


    public function savePaymentMode($request){
        try{          
           $dataUI = json_decode($request->getContent());
           $payment_mode_id = $dataUI->txt_payment_mode_id;
           $payment_mode = $dataUI->txt_payment_mode;         
           $description = $dataUI->txt_description;
            
           if($payment_mode_id == ''){
               $paymentModeObj = new CmnPaymentModeMaster();
           }else{
               $paymentModeObj = $this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode_id);
           }
           
           $paymentModeObj->setPaymentModeName($payment_mode);
           $paymentModeObj->setDescription($description);
           if ($payment_mode_id == "") {
                $paymentModeObj->setRecordActiveFlag(1);
                $paymentModeObj->setRecordInsertDate(new \Datetime('NOW'));
                $paymentModeObj->setApplicationUserId($this->session->get('EMPID'));
                $paymentModeObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($paymentModeObj);
           } else {
                $paymentModeObj->setRecordUpdateDate(new \Datetime('NOW'));
                $paymentModeObj->setApplicationUserId($this->session->get('EMPID'));
                $paymentModeObj->setApplicationUserIpAddress($this->session->get('IP'));
           }       
           $this->em->flush();
                            
           if ($payment_mode_id == "") {
               $msg = 'Inserted new record successfully';
           } else {
               $msg = 'Updated record successfully';
           }
           
           
           return array('msg' => $msg,
                'result' => $this->commonService->activeList('CmnPaymentModeMaster'),
                'paymentModeID' => $paymentModeObj->getPkid()
            ); 
           
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        
    }
    
    public function retrivePaymentMode($pkid){
       try{
           $paymentModeObj = $this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($pkid);  
           return array('paymentModeID' => $paymentModeObj->getPkid(),
                        'paymentModeName' => $paymentModeObj->getPaymentModeName(),
                        'description' => $paymentModeObj->getDescription()                      
            ); 
           
       } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
        
    }
    
    public function deletePaymentMode($pkid){ 
        try{
            $paymentModeObj = $this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($pkid);  
            $paymentModeObj->setRecordActiveFlag(0);
            $paymentModeObj->setRecordUpdateDate(new \Datetime('NOW'));
            $paymentModeObj->setApplicationUserId($this->session->get('EMPID'));
            $paymentModeObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            
            return array('msg' => 'Deleted Record Succesfully');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function searchEmployeeSalarySlip($request){
        try{
           $dataUI = json_decode($request->getContent());
           $employee_id = $dataUI->txt_employee_id;
           $employee_name = $dataUI->txt_employee_name;         
           $designation = $dataUI->txt_designation;
           $month = $dataUI->txt_month;
           $year = $dataUI->txt_year;
          
           
            $parameters = array();
            $queryString = "SELECT emp 
                            FROM TashiCommonBundle:EmpEmployeeMaster emp 
                            JOIN emp.personFk p 
                            JOIN emp.employementTypeFk empType
                            WHERE emp.recordActiveFlag=:activFlag ";

            $parameters['activFlag'] = 1;
            if (!empty($employee_id) && !is_null($employee_id)) {
                $queryString .= " AND emp.employeeId = :empId ";
                $parameters['empId'] = $employee_id;
            }
            if (!empty($employee_name) && !is_null($employee_name)) {
                $queryString .= " AND p.personName Like :firstName ";
                $parameters['firstName'] = $employee_name . '%';
            }
            
            if (!empty($designation) && !is_null($designation)) {
                $queryString .= " AND emp.empJobTitleFk = :designation ";
                $parameters['designation'] = $designation;
            }
 
            // print_r($parameters) ; die(); 
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $result = $query->getResult();
            //if search found then $searchFlage = 1, else $searchFlage = 0
            $searchFlage = 0;
            if($result){
                 $searchFlage = 0;                
            }
             
            // retriving all salary status for particular month and year
            //$salarySlipObj = $this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($pkid);          
            $queryString1 = "SELECT p 
                            FROM TashiCommonBundle:PayrolSalarySlip p                           
                            JOIN p.monthFk month
                            WHERE p.recordActiveFlag=:activFlag
                            AND month.pkid = :monthID
                            AND p.year=:year";                                                    
         
            $query1 = $this->em->createQuery($queryString1);
            $query1->setParameters(array('activFlag' => 1,'monthID' => $month,'year' => $year ));
            $result1 = $query1->getResult();
                 
            //if search found then $searchFlage1 = 1, else $searchFlage1 = 0
            $searchFlage1 = 0;
            if($result1){
                 $searchFlage1 = 1;              
            }           
            
            return array('month' => $this->em->getRepository(CommonConstant::ENT_CMN_MONTH)->find($month)->getMonthName(),
                         'monthID' => $month,
                         'year' => $year,
                         'empSearchResult' => $result,
                         'empSearchFlag' => $searchFlage,
                         'empSalarySlipSearchResult' => $result1,
                         'empSalarySlipSearchFlag' => $searchFlage1
                        );
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function particularEmployeeDetails($empID){
        try{         
            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);
            return $empMasterObj;     
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function searchEmpAdvancePaymentDetails($empID){
        try{            
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)
                                    ->findBy(array('employeeFk' => $empID, 
                                                   'recordActiveFlag' => 1));
                      
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function empAdvancePaymentStatus($request){
        try{  
               $dataUI = json_decode($request->getContent());
               $month_id = $dataUI->txt_month;
               if($month_id < 10){
                   $month_id = '0'.$month_id;
               } 
               $year = $dataUI->txt_year;
              
               $queryString = "SELECT p
                                FROM TashiCommonBundle:PayrolPaymentStatus p
                                WHERE substring(p.paymentDate,6,2)  = :month 
                                    AND substring(p.paymentDate,1,4)  = :year";  
               
                $query = $this->em->createQuery($queryString)
                         ->setParameters(array('month'=> $month_id, 'year' => $year)); 
                $result = $query->getResult(); 
                
               return $result;
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function particularDueAmountForAdvancePayment($empID){
        try{        
               $queryString = "SELECT SUM(p.dueAmount) totalDueAdvanceAmt
                               FROM TashiCommonBundle:PayrolAdvancePayment p
                               WHERE p.employeeFk = :empID                                  
                                    AND p.paymentStatus = :status 
                                    AND p.dueAmount != :dueAmount ";  
              
                $query = $this->em->createQuery($queryString)
                         ->setParameters(array('empID' => $empID , 'status' => 'P', 'dueAmount' => 0));  
                $result = $query->getSingleResult(); 
          
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }       
        return $result['totalDueAdvanceAmt'];
    }
    
    public function saveAdvancePayment($request){
        try{ 
            $dataUI = json_decode($request->getContent());
            $advance_payment_id = $dataUI->txt_advance_payment_id;
            $employee_id = $dataUI->txt_employee_id;
            $advanceAmount = $dataUI->txt_advance_amount;          
            $createdDate = $dataUI->txt_create_date;  
            $description = $dataUI->txt_description;  
           
            if($advance_payment_id == ''){
                $advPayObj = new PayrolAdvancePayment();
            }else{
                $advPayObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->find($advance_payment_id);
            }
            $advPayObj->setAdvanceAmount($advanceAmount);
            $advPayObj->setCreatedDate(new \DateTime($createdDate));
            $advPayObj->setEmployeeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($employee_id));   
            $advPayObj->setDescription($description);
            $advPayObj->setPaymentStatus('C'); // C means Create
            $advPayObj->setCreateKey(1);
            $advPayObj->setDueAmount($advanceAmount);         
            if ($advance_payment_id == "") {
                $advPayObj->setRecordActiveFlag(1);
                $advPayObj->setRecordInsertDate(new \Datetime('NOW'));
                $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                $advPayObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($advPayObj);
            } else {
                $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                $advPayObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
         
            $this->em->flush();
            
           //for message display 
           if ($advance_payment_id == "") {
               $msg = 'Inserted new record successfully';
           } else {
               $msg = 'Updated record successfully';
           }
                    
           return array('msg' => $msg,              
                        'advancePaymentId' => $advPayObj->getAdvancePaymentPk()
            ); 
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function findAllCreatedAdvancePayment(){
        try{ 
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->findBy(array('paymentStatus' => 'C', 'createKey' => 1, 'recordActiveFlag' => 1)); 
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    
    public function findAllApprovedAdvancePayment(){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->findBy(array('paymentStatus' => 'A','approvedKey' => 1, 'recordActiveFlag' => 1)); 
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        } 
    }
    public function rejectApprovedAdvancePayment($advancePayID){
       try{
            $advPayObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->find($advancePayID);
            $advPayObj->setPaymentStatus('R');
            $advPayObj->setRejectedKey(1);
            $advPayObj->setRejectedDate(new \Datetime('NOW')); 
            $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
            $advPayObj->setApplicationUserId($this->session->get('EMPID'));
            $advPayObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();           
                     
          } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
          } 
          
           return  'Rejected, the approved advance payment';
    }

        public function approvedCreatedAdvancePayment($request) {
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
                    $advPayObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->find($val);
                    switch($key){
                        case 'A' :  //A means approval
                                    $advPayObj->setPaymentStatus('A');
                                    $advPayObj->setApprovedKey(1);
                                    $advPayObj->setApprovedDate(new \Datetime($approveOrRejectDate)); 
                                    $msg = 'Approved, the selected advance payment';
                                    break;
                        case 'R' :  //R means reject
                                    $advPayObj->setPaymentStatus('R');
                                    $advPayObj->setRejectedKey(1);
                                    $advPayObj->setRejectedDate(new \Datetime($approveOrRejectDate)); 
                                    $msg = 'Rejected, the selected advance payment';
                                    break;
                    }                  
                    $advPayObj->setRecordUpdateDate(new \Datetime('NOW'));
                    $advPayObj->setApplicationUserId($this->session->get('EMPID'));
                    $advPayObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->flush();
                }
            } catch (\Exception $ex) {
                throw new \Exception($ex->getMessage());
            }
            
            
            return $msg;
    }
    
    public function payPaymentAdvancePayment($request, $key){
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
       try{ 
           $dataUI = json_decode($request->getContent()); 
           $advancePaymentOrSalarySlipID = '';
           if($key == 'AP'){
               $advancePaymentOrSalarySlipID = $dataUI->txt_advance_payment_id; 
               $payment_amount = $dataUI->txt_advance_amount;  
               $empID = $dataUI->txt_employee_pkid;
           }
           if($key == 'SP'){
               $advancePaymentOrSalarySlipID = $dataUI->txt_salary_slip_id; 
           }          
           $payment_mode = $dataUI->txt_payment_mode;
           $payment_date = $dataUI->txt_payment_date;
           $payment_no = $dataUI->txt_payment_no;                        
               
           $payStatusObj = new PayrolPaymentStatus();
           $payStatusObj->setCmnEntityId($advancePaymentOrSalarySlipID); 
           //AP means Advance Payment use for type of payment 
           //SP means Salary Payment use for type of payment       
           $payStatusObj->setGeneratedReceiptNo($this->generatePaymentReceipt());  
           $payStatusObj->setPaymentTypeKey($key); 
           $payStatusObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));
           $payStatusObj->setPaymentDate(new \Datetime($payment_date));
           $payStatusObj->setPaymentNo($payment_no);
           $payStatusObj->setRecordActiveFlag(1);  
           $payStatusObj->setRecordInsertDate(new \Datetime('NOW'));
           $payStatusObj->setApplicationUserId($this->session->get('EMPID'));
           $payStatusObj->setApplicationUserIpAddress($this->session->get('IP'));
           $this->em->persist($payStatusObj);
           $this->em->flush();
          
           switch($key){
               case 'AP':  
                            $repaymentObj = new PayrolRepaymentCollection();
                            $repaymentObj->setEmployeeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));                         
                            $repaymentObj->setPaymentAmount($payment_amount);                          
                            $repaymentObj->setPaymentDate(new \Datetime($payment_date));                         
                            $repaymentObj->setRecordActiveFlag(1);  
                            $repaymentObj->setRecordInsertDate(new \Datetime('NOW'));
                            $repaymentObj->setApplicationUserId($this->session->get('EMPID'));
                            $repaymentObj->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($repaymentObj);
                            $this->em->flush();
                   
                            $advPayObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_ADVANCE_PAYMENT)->find($advancePaymentOrSalarySlipID);         
                            $advPayObj->setPaymentStatus('P');  
                            break;
                        
               case 'SP':   $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($advancePaymentOrSalarySlipID);         
                            $salarySlipObj->setStatus('P');  
                            break;
           }                          
           $this->em->flush();
          
           $conn->commit();
           
       }catch (\Exception $ex) {
           $conn->rollback();
           $this->em->close();
           throw new \Exception($ex->getMessage());
       }
       
       return array('paidKey' => 1,
                     'advancePaymentOrSalarySlipID' => $advancePaymentOrSalarySlipID,
                     'msg' => 'Payment details has been save successfully'
                  );
       
    }
    
    public function generatePaymentReceipt(){
        try{
                $receipt_no = '';
                $queryString = "SELECT p.generatedReceiptNo receiptNo
                                FROM TashiCommonBundle:PayrolPaymentStatus p
                                WHERE p.paymentMasterPk = ( SELECT MAX(r.paymentMasterPk)
                                                            FROM TashiCommonBundle:PayrolPaymentStatus r )";
                $query = $this->em->createQuery($queryString);
                $result = $query->getResult();  
                if ($result) {  
                    $max_existing_receipt_no = $result[0]['receiptNo'];              
                    $generated_receipt_no = (int) substr($max_existing_receipt_no, 2, strlen($max_existing_receipt_no)) + 1;
                } else {
                    $generated_receipt_no = 1; // firstly generated no.
                }
                $receipt_no = 'R-'.$generated_receipt_no;  
                
        }catch (\Exception $ex) {          
           throw new \Exception($ex->getMessage());
        }
        
        return $receipt_no;
    }
    
    
    public function empSalSlipStatus($request, $empID){
        try{  
            $dataUI = json_decode($request->getContent());
            $month_id = $dataUI->txt_month;              
            $year = $dataUI->txt_year; 
            $advPayObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)
                         ->findOneBy(array('employeeFk' => $empID, 'monthFk' => $month_id, 'year' => $year, 'recordActiveFlag' => 1 )); 
            
           $resultFlag = 0;
           if($advPayObj){              
                return array(
                 'resultFlag' => 1,
                 'salSlipID' => $advPayObj->getSalarySlipPk(),
                 'status' => $advPayObj->getStatus(),
                 'year' => $advPayObj->getMonthFk()->getPkid(),
                 'basic' => $advPayObj->getEarningBasicSalary(),
                 'hra' => $advPayObj->getEarningHraAmount(),                               
                 'deductionAdjustedAdvancePay' => $advPayObj->getDeductionAdjustedAdvancePay(),
                 'deductionAdjustedWalletBal' => $advPayObj->getDeductionAdjustedWalletBal(),
                 'netSalary' => $advPayObj->getNetSalary()

             ); 
           }else{
               return array('resultFlag' => $resultFlag);
           }
            
                    
            
        }catch (\Exception $ex) {          
           throw new \Exception($ex->getMessage());
        }   
    
    }
    
    public function saveCreatedSalarySlip($request){
            $conn = $this->em->getConnection();
            $conn->beginTransaction();
            try{
                    $dataUI = json_decode($request->getContent()); 
                    $salary_slip_id = $dataUI->txt_created_salary_slip_id;
                    $emp_id = $dataUI->txt_emp_id;
                    $month_id = $dataUI->txt_month;  
                    $year = $dataUI->txt_year;                  
                    $gross_sal = $dataUI->txt_gross_sal;
                    $basic_calculate_pc = $dataUI->txt_basic_calculate_pc;
                    $hra_calculate_pc = $dataUI->txt_hra_calculate_pc; 
                    
                    // earning
                    $basic = $dataUI->txt_basic_sal_amt;
                    $hra = $dataUI->txt_hra_amt;                                  
                    $earning_total = $dataUI->txt_earning_total;

                    // deduction     txt_emp_current_bal           
                    $current_due_advance_taken_amount = $dataUI->txt_current_due_advance_taken_amount;
                    $advance_repaid_amount = $dataUI->txt_repaid_advance_amt;                    
                    $emp_current_bal = $dataUI->txt_emp_current_bal;
                    $adjustment_wallet_bal = $dataUI->txt_adjustment_wallet_bal;
                    $deduction_total = $dataUI->txt_total_deduction_amt;

                    // net salary
                    $net_sal_amt = $dataUI->txt_net_sal_amt;
                   

                    if($salary_slip_id == ''){
                        $salarySlipObj = new PayrolSalarySlip();
                    }else{
                        $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salary_slip_id);
                    }
                    $salarySlipObj->setGrossSalary($gross_sal);
                    $salarySlipObj->setBasicCalculationPc($basic_calculate_pc);
                    $salarySlipObj->setHraCalculationPc($hra_calculate_pc);

                    // earning                                                 
                    $salarySlipObj->setEarningBasicSalary($basic);
                    $salarySlipObj->setEarningHraAmount($hra);
                    $salarySlipObj->setEarningTotal($earning_total);

                    // deduction
                    $salarySlipObj->setEmpCurrentAdvanceAmount($current_due_advance_taken_amount);  
                    $salarySlipObj->setDeductionAdjustedAdvancePay($advance_repaid_amount);
                    $salarySlipObj->setEmpCurrentAccountAmount($emp_current_bal);
                    $salarySlipObj->setDeductionAdjustedWalletBal($adjustment_wallet_bal);
                    $salarySlipObj->setDeductionTotal($deduction_total);
                    
                    // net salary
                    $salarySlipObj->setNetSalary($net_sal_amt);

                    $salarySlipObj->setYear($year);
                    $salarySlipObj->setMonthFk($this->em->getRepository(CommonConstant::ENT_CMN_MONTH)->find($month_id));
                    $salarySlipObj->setEmployeeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($emp_id));

                    //set status
                    $salarySlipObj->setStatus('C');
                    $salarySlipObj->setCreatedDate(new \Datetime('NOW'));

                    if ($salary_slip_id == "") {
                        $salarySlipObj->setRecordActiveFlag(1);
                        $salarySlipObj->setRecordInsertDate(new \Datetime('NOW'));
                        $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                        $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($salarySlipObj);
                    } else {
                        $salarySlipObj->setRecordUpdateDate(new \Datetime('NOW'));
                        $salarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                        $salarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                    }
                   $this->em->flush();
                   $salarySlipID = $salarySlipObj->getSalarySlipPk();
                   
                  //*************Set Emolument and Deduction Fields Amount *******************//                                  
                   //set amount to dynamic emoluments field  
                   $this->setSalarySlipFieldsAmount($dataUI, $salary_slip_id, $this->allEmoluments(), $salarySlipObj, 'txt_earning');
                   //set amount to dynamic deductions field  
                   $this->setSalarySlipFieldsAmount($dataUI, $salary_slip_id, $this->allDeductions(), $salarySlipObj, 'txt_deduction');
                   
                   //*************Repayment collection for advance taken *******************//
                   //if advance repayment amount is given then do this code
                   if(!empty($advance_repaid_amount) && !is_null($advance_repaid_amount)){ 
                        $findSalarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_REPAYMENT_COLLECTION)->findOneByPaymentSource($salary_slip_id);
                        if ($salary_slip_id == "" || !$findSalarySlipObj) {
                             $repaymentObj = new PayrolRepaymentCollection();
                        } else {                                               
                             $repaymentObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_REPAYMENT_COLLECTION)->find($findSalarySlipObj->getPkid());
                        }
                        $repaymentObj->setPaymentAmount($advance_repaid_amount);
                        $repaymentObj->setEmployeeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($emp_id));
                        $repaymentObj->setPaymentSource($salarySlipObj); 
                        $repaymentObj->setStatus('NA'); // NA => Not Approved
                        $repaymentObj->setPaymentDate(new \Datetime('NOW'));
                        if ($salary_slip_id == "" || !$findSalarySlipObj) {
                            $repaymentObj->setRecordActiveFlag(1);
                            $repaymentObj->setRecordInsertDate(new \Datetime('NOW'));
                            $repaymentObj->setApplicationUserId($this->session->get('EMPID'));
                            $repaymentObj->setApplicationUserIpAddress($this->session->get('IP'));
                            $this->em->persist($repaymentObj);
                        } else {                       
                            $repaymentObj->setRecordUpdateDate(new \Datetime('NOW'));
                            $repaymentObj->setApplicationUserId($this->session->get('EMPID'));
                            $repaymentObj->setApplicationUserIpAddress($this->session->get('IP'));
                        }
                        
//                        //section for saving image into attachment
//                            $img = $request->request->get('data');
//                            //define('UPLOAD_DIR', $this->webRoot);
//                            $img = str_replace('data:image/png;base64,', '', $img);
//                            $img = str_replace(' ', '+', $img);
//                            $data = base64_decode($img);
//                            $file = $EmpID . '.png';
//
//                            if (!is_dir('Payslip/')) {
//                                mkdir('Payslip/');
//                            }
//                            $success = file_put_contents('Payslip/' . $file, $data);
                        
                        
                        
                        
                        
                        $this->em->flush(); 
                   }                    
                  
                   $this->em->commit();

            }catch (\Exception $ex) {  
               $conn->rollback();
               $this->em->close();
               throw new \Exception($ex->getMessage());
            }
        
            if($salary_slip_id == ''){
                $msg = 'Created Salary Slip Successfully';
            }else{
                $msg = 'Updated Salary Slip Successfully';
            }

            return array('salarySlipID' => $salarySlipID, 'msg' => $msg);
        
    }
    
    public function setSalarySlipFieldsAmount($dataUI, $salary_slip_id, $emolumentOrDeductObj, $salarySlipObj, $fieldString){
        try{
            foreach ($emolumentOrDeductObj as $obj) {
                $field_name = $fieldString . $obj->getPkid();
                $amount = $dataUI->$field_name;
                $findObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->findOneBy(array('emolumentDeductionMasterFk' => $obj->getPkid(), 'salarySlipFk' => $salary_slip_id, 'recordActiveFlag' => 1));
                if($findObj){
                     //record update                 
                    $emoDedAmountObj = $this->em->getRepository(PayrollConstant::ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT)->find($findObj->getPkid());
                    $emoDedAmountObj->setAmount($amount);  
                    $emoDedAmountObj->setRecordUpdateDate(new \Datetime('NOW'));
                    $emoDedAmountObj->setApplicationUserId($this->session->get('EMPID'));
                    $emoDedAmountObj->setApplicationUserIpAddress($this->session->get('IP'));
                }else{
                    //first time record insert
                    $emoDedAmountObj = new PayrolSalarySlipEmolumentdeductionAmount();
                    $emoDedAmountObj->setSalarySlipFk($salarySlipObj);
                    $emoDedAmountObj->setEmolumentDeductionMasterFk($this->em->getRepository(PayrollConstant::ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER)->find($obj->getPkid()));
                    $emoDedAmountObj->setAmount($amount);               
                    $emoDedAmountObj->setRecordActiveFlag(1);
                    $emoDedAmountObj->setRecordInsertDate(new \Datetime('NOW'));
                    $emoDedAmountObj->setApplicationUserId($this->session->get('EMPID'));
                    $emoDedAmountObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($emoDedAmountObj); 
                }                               
                $this->em->flush(); 
            }
        }catch (\Exception $ex) {              
            throw new \Exception($ex->getMessage());
        }
        return;
    }
    
    public function findAllCreatedSalarySlip(){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->findBy(array('status' => 'C', 'recordActiveFlag' => 1));
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
    }
    
    public function findAllApprovedSalarySlip(){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->findBy(array('status' => 'A', 'recordActiveFlag' => 1));
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
    }
    
    public function viewParticularCreatedSalarySlip($salrySlipID){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salrySlipID);
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
    }
    
     public function viewParticularApprovedSalarySlip($salrySlipID){
        try{
            return $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salrySlipID);
        }catch(\Exception $ex) {          
           throw new \Exception($ex->getMessage());
            
        }
    }
    
    
    
    /*---------salary slip approval part by HR--------------*/
    public function approvedOrRejectSalarySlipByHr($request) { 
            $conn = $this->em->getConnection();  
            $conn->beginTransaction(); 
         try {
                $dataUI = json_decode($request->getContent());
                $approveOrRejectDate = $dataUI->txt_approved_or_rejected_date;
                $key = $dataUI->key;                                          
                $source_account_id = $dataUI->txt_enter_account_id;                
                $paymentAccountBy = $dataUI->txt_payment_account;
                if($paymentAccountBy == 1){
                    $paymentAccountBy = 'cash';
                }else{
                    $paymentAccountBy = 'bank';
                }
                
                $description = $dataUI->txt_description;                
                $month =  $dataUI->txt_salary_month;
                $year = $dataUI->txt_salary_year;
                
                $selectedSalSlipArr = array();              
                if (is_string($dataUI->txt_selected_salary_slip)) {
                    $selectedSalSlipArr[0] = $dataUI->txt_selected_salary_slip; //for only one 
                } else {
                    $selectedSalSlipArr = $dataUI->txt_selected_salary_slip;     //for more than one       
                }  
                $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
                 
                //create sanction salary slip id              
                $payrolSanctionSalaryIdObj = new PayrolSanctionSalaryId();
                $payrolSanctionSalaryIdObj->setDescription($description);
                $payrolSanctionSalaryIdObj->setSourceAccountId($source_account_id);
                $payrolSanctionSalaryIdObj->setEntityKey('salary');
                $payrolSanctionSalaryIdObj->setIsSanction(0);          
                $payrolSanctionSalaryIdObj->setPaymentAccountBy($paymentAccountBy);
                $payrolSanctionSalaryIdObj->setMonthFk($this->em->getRepository(CommonConstant::ENT_CMN_MONTH)->find($month));
                $payrolSanctionSalaryIdObj->setYear($year);
                $payrolSanctionSalaryIdObj->setHrApproveDate(new \DateTime($approveOrRejectDate));
                $payrolSanctionSalaryIdObj->setRecordActiveFlag(1);
                $payrolSanctionSalaryIdObj->setRecordInsertDate(new \DateTime('now'));
                $payrolSanctionSalaryIdObj->setApplicationUserId($this->session->get('EMPID'));
                $payrolSanctionSalaryIdObj->setApplicationUserIpAddress($this->session->get('IP'));
                $payrolSanctionSalaryIdObj->setBranchOfficeCode($branch_id);
                $this->em->persist($payrolSanctionSalaryIdObj);
                $this->em->flush();
               
                //list of salary slip submitted to accountant to be sanction 
                foreach ($selectedSalSlipArr as $salarySlipID) {
                    $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salarySlipID);
                    //update salary slip
                    $salarySlipObj->setApprovedDate(new \DateTime($approveOrRejectDate));
                    $salarySlipObj->setStatus('A');
                    $salarySlipObj->setRecordUpdateDate(new \DateTime('now'));
                    $this->em->flush();
                    
                    //list of salary slip to be sanction by the accountant
                    $payrolSanctionSalarySlipObj = new PayrolSanctionSalarySlip();
                    $payrolSanctionSalarySlipObj->setSalarySlipFk($salarySlipObj);
                    $payrolSanctionSalarySlipObj->setSanctionKeyFk($payrolSanctionSalaryIdObj);
                    $payrolSanctionSalarySlipObj->setRecordActiveFlag(1);
                    $payrolSanctionSalarySlipObj->setRecordInsertDate(new \DateTime('now'));
                    $payrolSanctionSalarySlipObj->setApplicationUserId($this->session->get('EMPID'));
                    $payrolSanctionSalarySlipObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $payrolSanctionSalarySlipObj->setBranchOfficeCode($branch_id);
                    $this->em->persist($payrolSanctionSalarySlipObj);
                    $this->em->flush();                   
                }             
                           
                $msg = 'Salary slip has been approved successfully';
                
            $conn->commit();
          
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            
            return array('msg'=>$msg);
    }
    
    public function rejectParticularCreatedSalarySlip($salrySlipID){ 
       try{
           $salarySlipObj = $this->em->getRepository(PayrollConstant::ENT_PAYROL_SALARY_SLIP)->find($salrySlipID);
           //status R => rejected
           $salarySlipObj->setStatus('R');
           $salarySlipObj->setRejectedDate(new \Datetime('NOW'));
           $this->em->flush();
           
       } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
       }
       
       return; 
       
    }
    
    public function searchWorker($request){ 
        try{
           $worker_data = $request->request->get('worker_data');          
           $emp_id = $this->session->get('EMPID');         
//           $branch_id = $this->commonService->getBranchIdByGivingEmpId($emp_id); 
       
           $parameter_Arr = array();
           $queryString = "SELECT salTxn
                           FROM TashiCommonBundle:EmpWorkerSalaryTypeMasterTxn salTxn
                           JOIN salTxn.empMasterFk e
                           JOIN e.personFk p                                                
                           WHERE  e.employementTypeFk = 2                               
                               AND e.status = 1
                               AND e.recordActiveFlag = 1
                               AND salTxn.recordActiveFlag = 1";  
           if(!empty($worker_data) && !is_null($worker_data)){
               $queryString .= " AND p.personName like :personName OR e.employeeId = :workerID";
               $parameter_Arr['personName'] =  '%'.$worker_data . '%';
               $parameter_Arr['workerID'] =  $worker_data;
           }
           
            $query = $this->em->createQuery($queryString)
                    ->setParameters($parameter_Arr);
            $result = $query->getResult(); 
            //expertise
            $expertise_Arr = array();
            $i = 0;
            if($result){
                foreach($result as $obj){
                    if($obj->getEmpMasterFk()){
                        $emp_worker_pkid = $obj->getEmpMasterFk()->getEmployeePk();  
                        $expertiseObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerExpertMasterTxn')->findBy(array('empMasterFk' => $emp_worker_pkid, 'recordActiveFlag' => 1));                     
                        $expertise_Arr[$i]['expertise'] = $expertiseObj;
                        $i++;
                    }                   
                }
            }
       } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
       }
       
       return array('workerSearchResult' => $result, 'wokerExpertise' => $expertise_Arr);
    }
    
    public function findAllCreatedWages(){     
            return $this->em->getRepository('TashiCommonBundle:EmpWorkerWageDetails')->findBy(array('status' => 'C', 'recordActiveFlag' => 1));  
    }

    public function saveWorkerWage($request){
        $conn = $this->em->getConnection();  
        $conn->beginTransaction(); 
         
        $dataUI = json_decode($request->getContent());
        $key = $dataUI->txt_key;
        $wage_details_pkid = $dataUI->txt_wage_details_pkid;  
        $empWorkerPkid = $dataUI->txt_worker_pkid;
        $wage_type_id = $dataUI->txt_wage_type_id;
        $total_wage_type = $dataUI->txt_total_wage_type;
        $wage_type_amount = $dataUI->txt_wage_type_amount;
        $net_wage = $dataUI->txt_net_wage;               
        $working_date_option = $dataUI->txt_working_date_option; 
        $currentMonth =  date_format(new \Datetime('NOW'), 'm'); 
        $currentYear =  date_format(new \Datetime('NOW'), 'Y');
        try { 
                if($wage_details_pkid == ''){
                    $workerWageObj = new EmpWorkerWageDetails();
                }else{
                    $workerWageObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerWageDetails')->find($wage_details_pkid);
                }            
                if($working_date_option == 'single'){
                    $working_date = $dataUI->txt_working_date;                 
                    $workerWageObj->setWorkingDateFrom(new \Datetime($working_date));
                    $workerWageObj->setIsWageDateSingle(1);
                }else{
                    $working_date_from = $dataUI->txt_working_date_from;
                    $working_date_to = $dataUI->txt_working_date_to;                   
                    $workerWageObj->setWorkingDateFrom(new \Datetime($working_date_from));
                    $workerWageObj->setWorkingDateTo(new \Datetime($working_date_to));
                    $workerWageObj->setIsWageDateSingle(2);
                }
                $workerWageObj->setTotalWageType($total_wage_type);
                $workerWageObj->setNetWage($net_wage);
                $workerWageObj->setWageTypeAmount($wage_type_amount);
                $workerWageObj->setStatus('C');
                $workerWageObj->setYear($currentYear);
                $workerWageObj->setMonthFk($this->em->getRepository(CommonConstant::ENT_CMN_MONTH)->find($currentMonth));
                $workerWageObj->setWageTypeFk($this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TYPE_MASTER)->find($wage_type_id));
                $workerWageObj->setEmployeeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empWorkerPkid));
                $workerWageObj->setRecordActiveFlag(1);               
                $workerWageObj->setApplicationUserId($this->session->get('EMPID'));
                if($wage_details_pkid == ''){
                    $workerWageObj->setEntryDate(new \DateTime('now'));
                    $workerWageObj->setCreatedDate(new \DateTime('now'));
                    $workerWageObj->setRecordInsertDate(new \DateTime('now'));
                    $this->em->persist($workerWageObj);
                }else{                   
                    $workerWageObj->setRecordUpdateDate(new \DateTime('now'));
                }
                
                $this->em->flush();
                
                $conn->commit();
         }
         catch(\Exception $ex){
             $conn->rollBack();
             $this->em->close();
             throw new \Exception($ex->getMessage());
         }
        if ($wage_details_pkid == '') {
            $msg = 'Worker wage has been save succesfully';
        } else {
            $msg = 'Worker wage has been updated succesfully';
        }
         
           return array('msg' => $msg, 'key' => $key, 'wage_id' => $workerWageObj->getPkid());
    }
    
    
    public function approvedOrRejectWages($request) { 
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
                
                $selected_wages_Arr = array();
                if (is_string($dataUI->txt_selected_wages)) {
                    $selected_wages_Arr[0] = $dataUI->txt_selected_wages; //for only one 
                } else {
                    $selected_wages_Arr = $dataUI->txt_selected_wages;     //for more than one       
                }
                $msg = '';
                $branch_id = $this->commonService->getBranchIdByGivingEmpId($this->session->get('EMPID')); 
                foreach ($selected_wages_Arr as $wagePkid) { 
                    $workerWageObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerWageDetails')->find($wagePkid);     
                    $empID = $workerWageObj->getEmployeeFk()->getEmployeePk();
                    switch($key){
                        case 'A' :  //A means approval                                                                  
                                    $workerWageObj->setStatus('A');                                  
                                    $workerWageObj->setApprovedDate(new \Datetime($approveOrRejectDate)); 
                                    $workerWageObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $workerWageObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                   
                                    //after approved salary slip it will entry to account details                                                                   
                                    $description_field_name = 'txt_description'.$wagePkid;
                                    $wage_field_name = 'txt_wages'.$wagePkid;
                                    $txt_description = $dataUI->$description_field_name;
                                    $txt_wages_amount = $dataUI->$wage_field_name;
                                    
                                    //------start test-----------
                                    if($accountKey == 'cash'){  
                                        //paymentMode = 1 is cash mode, then we select cash account                                      
                                        $cashObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_CASH_CURRENT_BALANCE)->find($source_account_id); 
                                        $currentCashBal = $cashObj->getCurrentAmount();
                                        $newBalance = $currentCashBal - $txt_wages_amount;                             
                                        $cashObj->setCurrentAmount($newBalance);
                                        $cashObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $cashObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();

                                        //for inserting into cash Deposit history
                                        $cashDepositHisObj = new AccountCashDipositWithdrawalHistory();
                                        $cashDepositHisObj->setDepositWithdrawalKey('W');
                                        $cashDepositHisObj->setAmount($txt_wages_amount);
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
                                        $newBalance = $currentBankBal - $txt_wages_amount; 
                                        $bankAccObj = $this->em->getRepository(AccountConstant::ENT_ACCOUNT_BANK_CURRENT_BALANCE)->find($findBankObj->getPkid()); 
                                        $bankAccObj->setCurrentAmount($newBalance);
                                        $bankAccObj->setRecordUpdateDate(new \Datetime('NOW'));
                                        $bankAccObj->setApplicationUserId($this->session->get('EMPID'));
                                        $this->em->flush();

                                        //for inserting into bank Deposit history
                                        $bankDepositHisObj = new AccountBankDipositWithdrawalHistory();
                                        $bankDepositHisObj->setDepositWithdrawalKey('W');
                                        $bankDepositHisObj->setAmount($txt_wages_amount);
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
                                    $PayrolPaymentDetailsObj->setEntityKey('wage');  //this key to detect, this payment is for salary(office employee)
                                    $PayrolPaymentDetailsObj->setSourceId($source_account_id);
                                    $PayrolPaymentDetailsObj->setCmnEntityId($wagePkid);
                                    $PayrolPaymentDetailsObj->setPaymentNo($payment_number);
                                    $PayrolPaymentDetailsObj->setPaymentDate(new \Datetime($approveOrRejectDate));
                                    $PayrolPaymentDetailsObj->setPaymentModeFk($this->em->getRepository(CommonConstant::ENT_CMN_PAYMENT_MODE_MASTER)->find($payment_mode));                                    
                                    $PayrolPaymentDetailsObj->setEmpFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                                    $PayrolPaymentDetailsObj->setRecordActiveFlag(1);
                                    $PayrolPaymentDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $PayrolPaymentDetailsObj->setRecordInsertDate(new \Datetime('now'));
                                    $this->em->persist($PayrolPaymentDetailsObj);
                                    $this->em->flush();                                    
                                    //-------end----------
                                    //set to salary account head(fixed)
                                    $accDetailsObj = new AccountDetailsMaster();  
                                    $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(5));
                                    $accDetailsObj->setAmount($txt_wages_amount);
                                    $accDetailsObj->setDate(new \Datetime($approveOrRejectDate));
                                    $accDetailsObj->setDescription($txt_description);
                                    $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
                                    $accDetailsObj->setRecordActiveFlag(1);
                                    $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->persist($accDetailsObj); 
                                    $this->em->flush();                                                                      
                                    
                                    $msg = 'Approved, the selected wages';
                                    break;
                        case 'R' :  //R means rejected
                                    $workerWageObj->setStatus('R');                                 
                                    $workerWageObj->setRejectedDate(new \Datetime($approveOrRejectDate));
                                    $workerWageObj->setRecordUpdateDate(new \Datetime('NOW'));
                                    $workerWageObj->setApplicationUserId($this->session->get('EMPID'));
                                    $this->em->flush();
                                    $msg = 'Rejected, the selected wages';
                                    break;
                    }                                    
                }
                
            $conn->commit();
          
            } catch (\Exception $ex) {
                $conn->rollback();
                $this->em->close();
                throw new \Exception($ex->getMessage());
            }
            
            
            return $msg;
    }
    
    
    
     public function createSlipimage($request){ 
           $conn = $this->em->getConnection();  
           $conn->beginTransaction(); 
         try{
             $dataUI = json_decode($request->getContent());
             $empid = $request->request->get('emp');
             $EmpObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empid);
             $EmpID = $EmpObj->getEmployeeId();            
             $Empname = $EmpObj->getPersonFk()->getPersonName();
            
            $img = $request->request->get('data');
            //define('UPLOAD_DIR', $this->webRoot);
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = 1 .'.pdf';
            
            //$file = 'Payslip.png';
            
            //$file = move_uploaded_file(uniqid() . '.png', $this->webRoot);
            
            
           
            
            if(!is_dir('Attachment/'))
            {
                mkdir('Attachment/');
            }
            $success = file_put_contents('Attachment/'.$file, $data);
            $messageObject = \Swift_Message::newInstance()
                    ->setSubject('Subject')
                    ->setFrom('sanatomba@cobigent.com')
                    ->setTo('sanatomba@cobigent.com')
                    ->setBody('Salary slip for '.$Empname)
                    ->attach(\Swift_Attachment::fromPath('Attachment/'.$file));
           
            $this->mailer->send($messageObject);

            $code = 1;
            $showerrormsg = 'Email send sucessfully';
            $conn->commit();
            //unlink('Attachment/'.$file);
                        
          
       } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
            //unlink($file);
       }
       return array('file'=>'Attachment/'.$file,'code'=>$code,'msg'=>$showerrormsg);
       
    }
    
    
    public function Html2pdfconvert($request) {

        try {
            
            $env = new \Twig_Environment(new \Twig_Loader_String());            
            $pdf =  $this->pdf->generateFromHtml($this->twig->render('TashiPayrollBundle:Payroll:Payslip.html.twig'),
                   'D:\wamp\www\TASHI\web\PDF\1.pdf');
            
           
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
            //unlink($file);
        }
        return array('msg' => $msg, 'code' => $code);
    }
    
     
    
}//end of class
