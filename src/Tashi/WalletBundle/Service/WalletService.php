<?php

namespace Tashi\WalletBundle\Service;

//namespace Tashi\CommonBundle\Service;
use Doctrine\ORM\EntityManager;
use Tashi\WalletBundle\Helper\WalletConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Symfony\Component\HttpFoundation\Session\Session;
use Tashi\AccountBundle\Helper\AccountConstant;
use Tashi\CommonBundle\Entity\EmpAccount;
use Tashi\CommonBundle\Entity\EmpAccountAtmMaster;
use Tashi\CommonBundle\Entity\EmpAccountDeposit;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Tashi\CommonBundle\Entity\EmpAccountExpenses;
use Tashi\CommonBundle\Entity\ProjectExpenses;
use Tashi\CommonBundle\Entity\EmpAccountBalance;
use Tashi\CommonBundle\Entity\AccountDetailsMaster;
use Tashi\CommonBundle\Entity\AccountCashDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountCashCurrentBalance;
use Tashi\CommonBundle\Entity\AccountBankDipositWithdrawalHistory;
use Tashi\CommonBundle\Entity\AccountBankCurrentBalance;

class WalletService {

    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;
    protected $mailer;

    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService = $commonService;
    }

    public function addAtmWalletDetails($request) {
        try {

            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $empid = $dataUI->empId;
            $bankName = $dataUI->bankName;
            $accountNo = $dataUI->accountNo;
            $cardNo = $dataUI->cardNo;
            $description = $dataUI->description;

            //creating object for employee master
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);

            $EmpAcAtmObj = new EmpAccountAtmMaster();
            $EmpAcAtmObj->setAtmname($bankName);
            $EmpAcAtmObj->setAccountNumber($accountNo);
            $EmpAcAtmObj->setCardNumber($cardNo);
            $EmpAcAtmObj->setDescription($description);
            $EmpAcAtmObj->setEmpFk($EmpObj);
            $EmpAcAtmObj->setRecordActiveFlag(1);
            $EmpAcAtmObj->setRecordInsertDate(new \Datetime());
            $EmpAcAtmObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAcAtmObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($EmpAcAtmObj);
            $this->em->flush();
            return array('msg' => 'Record Saved Sucessfully', 'id' => $EmpAcAtmObj->getPkid()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function updateAtmWalletDetails($request) {
        try {
            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $id = $dataUI->txt_atmid;
            $empid = $dataUI->empid;
            $bankName = $dataUI->bankName;
            $accountNo = $dataUI->accountNo;
            $cardNo = $dataUI->cardNo;
            $description = $dataUI->description;

            //creating object for employee master
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);

            $EmpAcAtmObj = $this->em->getRepository(WalletConstant::ENT_SOURCE)->find($id);
            $EmpAcAtmObj->setAtmname($bankName);
            $EmpAcAtmObj->setAccountNumber($accountNo);
            $EmpAcAtmObj->setCardNumber($cardNo);
            $EmpAcAtmObj->setDescription($description);
            $EmpAcAtmObj->setEmpFk($EmpObj);
            $EmpAcAtmObj->setRecordActiveFlag(1);
            $EmpAcAtmObj->setRecordUpdateDate(new \Datetime());
            $EmpAcAtmObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAcAtmObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            return array('msg' => 'Record Updated Sucessfully',
                'id' => $EmpAcAtmObj->getPkid()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteWalletATMDetails($atmid) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            //deleting record for Employee Account
            $EmpAccountObj = $this->em->getRepository(WalletConstant::ENT_SOURCE)->find($atmid);
            $EmpAccountObj->setRecordUpdateDate(new \Datetime());
            $EmpAccountObj->setRecordActiveFlag(0);
            $EmpAccountObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Record Deleted Sucessfully');
    }

    public function addWalletDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $empid = $dataUI->selectedEMp;
            $description = $dataUI->description;
            $account_type = 1;

            //creating object for employee master
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $accountObj = $this->em->getRepository(WalletConstant::ENT_ACCOUNTTYPE)->find($account_type);

            //inserting record for Employee Account
            $EmpAccountObj = new EmpAccount();
            $EmpAccountObj->setAccountType($accountObj);
            $EmpAccountObj->setAccDescription($description);
            $EmpAccountObj->setEmpFk($EmpObj);
            $EmpAccountObj->setRecordActiveFlag(1);
            $EmpAccountObj->setRecordInsertDate(new \Datetime());
            $EmpAccountObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($EmpAccountObj);
            $this->em->flush();
            //ends here

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Record Saved Sucessfully',
            'result' => $this->commonService->activeList('EmpAccount'),
            'id' => $EmpAccountObj->getAccntId()
        );
    }

    public function updateWalletDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $id = $dataUI->id;
            $empid = $dataUI->employeepk;
            $description = $dataUI->description;
            $account_type = 1;

            //creating object for employee master
            $EmpAccountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($id);
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $accountObj = $this->em->getRepository(WalletConstant::ENT_ACCOUNTTYPE)->find($account_type);

            //updating record for Employee Account

            $EmpAccountObj->setAccountType($accountObj);
            $EmpAccountObj->setAccDescription($description);
            $EmpAccountObj->setEmpFk($EmpObj);
            $EmpAccountObj->setRecordActiveFlag(1);
            $EmpAccountObj->setRecordUpdateDate(new \Datetime());
            $EmpAccountObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Record Updated Sucessfully',
            'result' => $this->commonService->activeList('EmpAccount'),
            'id' => $EmpAccountObj->getAccntId()
        );
    }

    public function deleteWalletDetails($accountid) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            //deleting record for Employee Account
            $EmpAccountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($accountid);
            $EmpAccountObj->setRecordActiveFlag(0);
            $EmpAccountObj->setRecordUpdateDate(new \Datetime());
            $EmpAccountObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            //ends here
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Record Deleted Sucessfully', 'result' => $this->commonService->activeList('EmpAccount'),);
    }

    //retrieving atm details

    public function getatmdetails($atmid) {

        try {
            $EmpATMObj = $this->em->getRepository(WalletConstant::ENT_SOURCE)->find($atmid);
            $id = $EmpATMObj->getPkid();
            $account_no = $EmpATMObj->getAccountNumber();
            $card_no = $EmpATMObj->getCardNumber();
            $description = $EmpATMObj->getDescription();
            $bank = $EmpATMObj->getAtmname();
            $empid = $EmpATMObj->getEmpFk()->getEmployeePk();
            $eid = $EmpATMObj->getEmpFk()->getEmployeeId();
            $empname = $EmpATMObj->getEmpFk()->getPersonFk()->getPersonName();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array
            ('id' => $id,
            'account' => $account_no,
            'card' => $card_no,
            'description' => $description,
            'bank' => $bank,
            'ename' => $empname,
            'eid' => $eid,
            'empid' => $empid);
    }

    //Searching Record from database


    public function getwalletdetails($accountid) {

        try {
            $EmpAccountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($accountid);
            $id = $EmpAccountObj->getAccntId();
            $description = $EmpAccountObj->getAccDescription();
            $account_type = $EmpAccountObj->getAccountType()->getPkid();
            $empid = $EmpAccountObj->getEmpFk()->getEmployeePk();
            $eid = $EmpAccountObj->getEmpFk()->getEmployeeId();
            $empname = $EmpAccountObj->getEmpFk()->getPersonFk()->getPersonName();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array
            ('empid' => $empid,
            'type' => $account_type,
            'description' => $description,
            'ename' => $empname,
            'eid' => $eid, 'id' => $id);
    }

    public function getwalletExpensesdetails($id) {

        try {
            $EmpAccountExpensesObj = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            $description = $EmpAccountExpensesObj->getExpensesDescription();

            $amount = $EmpAccountExpensesObj->getAmount();
            $item = $EmpAccountExpensesObj->getItem()->getPkid();
            $itemname = $EmpAccountExpensesObj->getItem()->getProductName();
            $expensetype = $EmpAccountExpensesObj->getExpensesType()->getPkid();
            $project = $EmpAccountExpensesObj->getProjectFk()->getPkid();
            $empid = $EmpAccountExpensesObj->getEmpFk()->getEmployeeId();
            $empname = $EmpAccountExpensesObj->getEmpFk()->getPersonFk()->getPersonName();
            $eid = $EmpAccountExpensesObj->getEmpFk()->getEmployeePk();

            //$doc = $EmpAccountExpensesObj->getDocumentFk()->getPkid();
            $accountid = $EmpAccountExpensesObj->getAccntFk()->getAccntId();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array
            ('empid' => $empid,
            'etype' => $expensetype,
            'descrp' => $description,
            'ename' => $empname, 'id' => $id,
            'proid' => $project, 'item' => $item, 'amount' => $amount, 'eid' => $eid, 'account' => $accountid, 'itemname' => $itemname);
    }

    public function autoCompleteEmpWalletDetails($request) {
        try {
            $keyword = $request->request->get('keyword');
            $result = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->findByAutoSuggestKeyword($keyword);
            $list = '';
            foreach ($result as $rs) {
                $fName = $rs->getPersonMasterFk()->getFirstName();
                $mName = $rs->getPersonMasterFk()->getMiddleName();
                $lName = $rs->getPersonMasterFk()->getLastName();
                $avocateID = $rs->getPkid();
                // put in bold the written text  
                $avocate_name = str_replace($keyword, '<b style="text-decoration: underline;">' . $keyword . '</b>', $fName);
                // add new option
                $list .= '<li onclick="set_item(this,\'' . $key . '\',\'' . $lName . '\',\'' . $mName . '\',\'' . $avocateID . '\',\'' . str_replace("'", "\'", $fName) . '\')">' . $avocate_name . ' ' . $lName . '</li>';
            }
            return $list;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function SearchEmployeedetailsForDeposit($request) {

        try {

            $dataUI = json_decode($request->getContent());
            $keyword = $dataUI->employeename;
            //$empid=$this->session->get('EMPID');
            $parameters = array();
            $queryString = " SELECT empaccount  
                             FROM TashiCommonBundle:EmpAccount empaccount  
                             
                             INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp
                             WITH empaccount.empFk = emp.employeePk
                             
                             WHERE emp.recordActiveFlag=:activFlag and emp.employeeId= :keyword";

            $parameters['activFlag'] = 1;
            $parameters['keyword'] = $keyword;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getSingleResult();
            //echo $resultSearch->getEmployeePk();
            //die();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchEmpDetailsDeposit() {

        try {


            $empid = $this->session->get('EMPID');

            $parameters = array();
            $queryString = " SELECT empaccount  
                             FROM TashiCommonBundle:EmpAccount empaccount  
                             
                             INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp
                             WITH empaccount.empFk = emp.employeePk
                             
                             WHERE emp.recordActiveFlag=1 and emp.employeeId= :keyword and empaccount.recordActiveFlag=1";
            $parameters['keyword'] = $empid;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
            //echo $resultSearch->getEmployeePk();
            //die();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    //searching by criteria part
    public function SearchEmployeedetailsForExpenses($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $sdate = $dataUI->start;
            $endate = $dataUI->enddate;

            $parameters = array();
            $queryString = "   SELECT expense
                             FROM TashiCommonBundle:EmpAccountExpenses expense  
                             
                             where expense.expensesDate between '$sdate' and '$endate'  and expense.recordActiveFlag = :activFlag";
//            and expense.status=0

            $parameters['activFlag'] = 1;

            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchEmployeeByID($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $keyword = $dataUI->txtCriteria;


            $parameters = array();
            $queryString = "   SELECT emp
                             FROM TashiCommonBundle:EmpEmployeeMaster emp  
                             
                              where emp.recordActiveFlag = :activFlag and emp.employeeId= :keyword";

            $parameters['activFlag'] = 1;
            $parameters['keyword'] = $keyword;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getSingleResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchAllExpenses() {

        try {
            $parameters = array();
            $queryString = "   SELECT expense
                             FROM TashiCommonBundle:EmpAccountExpenses expense  
                             where expense.recordActiveFlag = :activFlag";
//            and expense.status = 0 
            $parameters['activFlag'] = 1;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    //search by criteria for expense ends here
    //search Criteria for deposit

    public function SearchDepositByCriteria($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $sdate = $dataUI->start;
            $endate = $dataUI->enddate;

            $parameters = array();
            $queryString = "   SELECT deposit
                             FROM TashiCommonBundle:EmpAccountDeposit deposit  
                             
                             where deposit.recordInsertDate between '$sdate' and '$endate' and deposit.recordActiveFlag = :activFlag ";

            $parameters['activFlag'] = 1;

            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchAllDeposit() {

        try {
            $parameters = array();
            $queryString = "   SELECT deposit
                             FROM TashiCommonBundle:EmpAccountDeposit deposit  
                             where deposit.recordActiveFlag = :activFlag ";
            $parameters['activFlag'] = 1;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

//criteria part ends here 
    public function SearchEmployeeAtmdetailsForDeposit($request) {

        try {
            $dataUI = json_decode($request->getContent());
            $keyword = $dataUI->employeename;

            $parameters = array();
            $queryString = "  SELECT empaccount  
                             FROM TashiCommonBundle:EmpAccount empaccount  
                             
                             INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp
                             WITH empaccount.empFk = emp.employeePk
                             
                             WHERE emp.recordActiveFlag=:activFlag and emp.employeeId =:keyword";

            $parameters['activFlag'] = 1;
            $parameters['keyword'] = $keyword;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getSingleResult();
            //echo $resultSearch->getEmployeePk();
            //die();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchAccountant($criteria1) {

        try {
            $parameters = array();
            $queryString = " SELECT emp  
                             FROM TashiCommonBundle:EmpEmployeeMaster emp  
                             INNER JOIN TashiCommonBundle:EmpJobTitleMaster accountant
                             WITH emp.empJobTitleFk = accountant.jobTitlePk
                             WHERE accountant.recordActiveFlag=:activFlag and accountant.jobTitleName=:keyword";

            $parameters['activFlag'] = 1;
            $parameters['keyword'] = $criteria1;
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchProjectDetails() {

        try {
            $queryString = " SELECT pro  
                             FROM TashiCommonBundle:ProjectMaster pro  
                             INNER JOIN TashiCommonBundle:ProjectAreaMaster proarea
                             WITH pro.areaFk = proarea.pkid
                             WHERE pro.recordActiveFlag=1 ";
            $query = $this->em->createQuery($queryString);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $resultSearch;
    }

    public function SearchEmployeeWalletExpenses() {

        try {
            $EmpExpenses = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('status' => 0, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $EmpExpenses;
    }

    public function SearchExpensesByid($id) {

        try {
            $EmpExpensesid = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $EmpExpensesid;
    }

    public function addWalletDepositDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $empid = $dataUI->empid;
            $source = $dataUI->sourcename;
            $amount = $dataUI->amount;
            $description = $dataUI->description;
            $accountid = $dataUI->accountid;


            switch ($source) {   //for accountant section
                case 1:
                    //for cash account section
                    //$session = $this->getRequest()->getSession(); 
                    $emp_id = $this->session->get('EMPID');
                    $branch_id = $this->commonService->getBranchIdByGivingEmpId($emp_id);

                    $AccountCashCurrent = $this->em->getRepository(WalletConstant::ENT_CASHACCOUNT)->findOneBy(array('recordActiveFlag' => 1, 'branchOfficeCode' => $branch_id));
                    if ($AccountCashCurrent) {
                        $currentamount = $AccountCashCurrent->getCurrentAmount();
                        $balance = $currentamount - $amount;
                        $pkid = $AccountCashCurrent->getPkid();
                        $AccountCashCurrentBalanceObj = $this->em->getRepository(WalletConstant::ENT_CASHACCOUNT)->find($pkid);
                        $AccountCashCurrentBalanceObj->setCurrentAmount($balance);
                        $AccountCashCurrentBalanceObj->setDescription($description);
                        $AccountCashCurrentBalanceObj->setRecordUpdateDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $AccountCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush();
                    } else {
                        $currentamount = 0;
                        $balance = $currentamount - $amount;
                        $AccountCashCurrentBalanceObj = new AccountCashCurrentBalance();
                        $AccountCashCurrentBalanceObj->setCurrentAmount($balance);
                        $AccountCashCurrentBalanceObj->setBranchOfficeCode($branch_id);
                        $AccountCashCurrentBalanceObj->setDescription($description);
                        $AccountCashCurrentBalanceObj->setRecordInsertDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setCreatedDate(new \Datetime());
                        $AccountCashCurrentBalanceObj->setRecordActiveFlag(1);
                        $AccountCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $AccountCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->persist($AccountCashCurrentBalanceObj);
                        $this->em->flush();
                    }

                    //for inserting into cash withdrawal history
                    $AccountCashDipositWithdrawalHistoryObj = new AccountCashDipositWithdrawalHistory();
                    $AccountCashDipositWithdrawalHistoryObj->setDepositWithdrawalKey('W');
                    $AccountCashDipositWithdrawalHistoryObj->setAmount($amount);
                    $AccountCashDipositWithdrawalHistoryObj->setDate(new \Datetime());
                    $AccountCashDipositWithdrawalHistoryObj->setDescription($description);
                    $AccountCashDipositWithdrawalHistoryObj->setRecordActiveFlag(1);
                    $AccountCashDipositWithdrawalHistoryObj->setRecordInsertDate(new \Datetime());
                    $AccountCashDipositWithdrawalHistoryObj->setCashAccountFk($AccountCashCurrentBalanceObj);
                    $AccountCashDipositWithdrawalHistoryObj->setApplicationUserId($this->session->get('EMPID'));
                    $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                    $Empname = $EmpObj->getPersonFk()->getPersonName();
                    $AccountCashDipositWithdrawalHistoryObj->setDepositWithdrawalBy($Empname);
                    $AccountCashDipositWithdrawalHistoryObj->setBranchOfficeCode($branch_id);
                    $AccountCashDipositWithdrawalHistoryObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($AccountCashDipositWithdrawalHistoryObj);
                    $this->em->flush();
                    $code = 1;
                    break;
                //for customer section
                case 2:

                    break;
                //for bank account section
                case 3:
                    $mode = $dataUI->selectmode;
                    $selectedlist = $dataUI->selectlist;
                    //for bank account section
                    $BankCurrent = $this->em->getRepository(WalletConstant::ENT_BANKACCOUNT)->findOneBy(array('bankFk' => $selectedlist, 'recordActiveFlag' => 1));

                    if ($BankCurrent) {
                        $currentamount = $BankCurrent->getCurrentAmount();
                        $pkid = $BankCurrent->getPkid();
                    } else {
                        $currentamount = 0;
                    }
                    //for checking bank current amount greater than deposit amount
                    if ($amount > $currentamount) {
                        $code = 0;
                        $customMessage = 'Amount greater than current bank balance amount!';
                        return array('msg' => $customMessage, 'code' => $code);
                    } else {
                        $balance = $currentamount - $amount;
                        $Bank = $this->em->getRepository(WalletConstant::ENT_BANK)->find($selectedlist);

                        $BankCashCurrentBalanceObj = $this->em->getRepository(WalletConstant::ENT_BANKACCOUNT)->find($pkid);
                        $BankCashCurrentBalanceObj->setCurrentAmount($balance);
                        //$BankCashCurrentBalanceObj->setDescription($description);
                        if ($Bank) {
                            $BankCashCurrentBalanceObj->setBankFk($Bank);
                        }
                        $BankCashCurrentBalanceObj->setRecordUpdateDate(new \Datetime());
                        $BankCashCurrentBalanceObj->setApplicationUserId($this->session->get('EMPID'));
                        $BankCashCurrentBalanceObj->setApplicationUserIpAddress($this->session->get('IP'));
                        $this->em->flush();
                        $code = 1;
                    }
                    //ends here
                    //for inserting into bank deposit withdrawal history
                    $AccountBankDipositWithdrawalHistoryObj = new AccountBankDipositWithdrawalHistory();
                    $AccountBankDipositWithdrawalHistoryObj->setDepositWithdrawalKey('W');
                    $AccountBankDipositWithdrawalHistoryObj->setAmount($amount);
                    $AccountBankDipositWithdrawalHistoryObj->setDate(new \Datetime());
                    $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                    $Empname = $EmpObj->getPersonFk()->getPersonName();
                    $AccountBankDipositWithdrawalHistoryObj->setDepositWithdrawalBy($Empname);
                    $AccountBankDipositWithdrawalHistoryObj->setDescription($description);
                    if ($Bank) {
                        $AccountBankDipositWithdrawalHistoryObj->setBankFk($Bank);
                    }

                    if ($mode == 1) {
                        
                    } else {
                        $paymentno = $dataUI->txt_payment_number;
                        $AccountBankDipositWithdrawalHistoryObj->setPaymentNo($paymentno);
                    }
                    $AccountBankDipositWithdrawalHistoryObj->setPaymentModeFk($this->em->getRepository(WalletConstant::ENT_PAYMODE)->find($mode));
                    $AccountBankDipositWithdrawalHistoryObj->setRecordActiveFlag(1);
                    $AccountBankDipositWithdrawalHistoryObj->setRecordInsertDate(new \Datetime());
                    // $AccountBankDipositWithdrawalHistoryObj->setCashAccountFk($BankCashCurrentBalanceObj);
                    $AccountBankDipositWithdrawalHistoryObj->setApplicationUserId($this->session->get('EMPID'));
                    $AccountBankDipositWithdrawalHistoryObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($AccountBankDipositWithdrawalHistoryObj);
                    $this->em->flush();
                    $code = 1;
                    break;
            }
            //creating object for employee master
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $accountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($accountid);
            $SourceObj = $this->em->getRepository(WalletConstant::ENT_SourceMaster)->find($source);

            //inserting record for Employee Account
            $EmpAccountDepositObj = new EmpAccountDeposit();
            $EmpAccountDepositObj->setAmount($amount);
            $EmpAccountDepositObj->setSourceType($SourceObj);
            if ($source == 1) {
                $EmpployeeObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->findOneBy(array('employeeId' => $this->session->get('EMPID')));
                $jobpkid = $EmpployeeObj->getEmpJobTitleFk()->getJobTitlePk();
                $EmpAccountDepositObj->setSourceId($jobpkid);
            } else {
                $selectedlist = $dataUI->selectlist;
                $EmpAccountDepositObj->setSourceId($selectedlist);
            }
            $EmpAccountDepositObj->setAccntFk($accountObj);
            $EmpAccountDepositObj->setEmpFk($EmpObj);
            $EmpAccountDepositObj->setDescription($description);
            $EmpAccountDepositObj->setRecordActiveFlag(1);
            $EmpAccountDepositObj->setRecordInsertDate(new \Datetime());
            $EmpAccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($EmpAccountDepositObj);
            $this->em->flush();

            //ends here


            $AccountDepositObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empid);
            if (isset($AccountDepositObj)) {
                //for inserting into emp_account_balance table
                $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                $depositamount = $EmpDepositBalance[0]['s'];

                $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                $expenseamount = $EmpExpenseBalance[0]['s'];
                $minus = $depositamount - $expenseamount;
                $AccountDepositObj->setBalanceAmount($minus);
                $AccountDepositObj->setDateOfBalance(new\Datetime);
                $AccountDepositObj->setRecordActiveFlag(1);
                $AccountDepositObj->setRecordInsertDate(new\Datetime);
                $AccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
                $AccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
                $AccountDepositObj->setAccntFk($accountObj);
                $AccountDepositObj->setEmpFk($EmpObj);
                $this->em->flush();
                $code = 1;
            } else {
                //for inserting into emp_account_balance table
                //for retreiving total amount from deposit and expense table    
                $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                $depositamount = $EmpDepositBalance[0]['s'];

                $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                $expenseamount = $EmpExpenseBalance[0]['s'];

                $minus = $depositamount - $expenseamount;
                //total calculation ends here

                $EmpAccountExpenseDepositBalance = new EmpAccountBalance();
                $EmpAccountExpenseDepositBalance->setBalanceAmount($minus);
                $EmpAccountExpenseDepositBalance->setDateOfBalance(new\Datetime);
                $EmpAccountExpenseDepositBalance->setRecordActiveFlag(1);
                $EmpAccountExpenseDepositBalance->setRecordInsertDate(new\Datetime);
                $EmpAccountExpenseDepositBalance->setApplicationUserId($this->session->get('EMPID'));
                $EmpAccountExpenseDepositBalance->setApplicationUserIpAddress($this->session->get('IP'));
                $EmpAccountExpenseDepositBalance->setAccntFk($accountObj);
                $EmpAccountExpenseDepositBalance->setEmpFk($EmpObj);
                $this->em->persist($EmpAccountExpenseDepositBalance);
                $this->em->flush();
            }

            $accDetailsObj = new AccountDetailsMaster();
            //set to salary account head(fixed)
            $accDetailsObj->setAccountHeadFk($this->em->getRepository(AccountConstant::ENT_ACCOUNT_HEAD)->find(3));
            $accDetailsObj->setAmount($amount);
            $accDetailsObj->setDate(new \Datetime('NOW'));
            $accDetailsObj->setDescription($description);
            $accDetailsObj->setRecordInsertDate(new \Datetime('NOW'));
            $accDetailsObj->setRecordActiveFlag(1);
            $accDetailsObj->setApplicationUserId($this->session->get('EMPID'));
            $accDetailsObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($accDetailsObj);
            $this->em->flush();
            $code = 1;
            $customMessage = 'Record Save Sucessfully';
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $customMessage, 'code' => $code, 'result' => $this->commonService->activeList('EmpAccountDeposit'));
    }

    public function addWalletExpensesDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        $dataUI = $request->request;
        $empid = $dataUI->get('empid');

        $source = $dataUI->get('sourcename');
        $amount = $dataUI->get('amount');
        $description = $dataUI->get('description');
        $accountid = $dataUI->get('accountid');
        $projectid = $dataUI->get('selectlist');
        if ($projectid) {
            $ProjectObj = $this->em->getRepository(WalletConstant::ENT_PROJECT)->find($projectid);
        }
        $itemid = $dataUI->get('selectlist1');
        if ($itemid) {
            $ProjectItemObj = $this->em->getRepository(WalletConstant::ENT_PRO_ITEM)->findOneBy(array('pkid' => $itemid, 'recordActiveFlag' => 1));
            $itemgetbyId = $ProjectItemObj->getItemFk()->getPkid();
            $ItemObj = $this->em->getRepository(WalletConstant::ENT_PRODUCT)->find($itemgetbyId);
        }
        $fileupload = $request->files->get('fileExpensesImg');
        $uploadedFiles = array();
        $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');

        try {
            if (isset($fileupload)) {
                $path = 'upload/DOCUMENTS/PROJECT/EXPENSES/';
                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 0.5, $validFileTypes);
                if ($fuploadresult['code'] == 1) {
                    $uploadedFiles[] = $fuploadresult['fullpath'];
                    //save image in document master
                    $document = new CmnDocumentMaster();
                    $document->setPath($path . $fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    $document->setRecordActiveFlag(1);
                    $document->setRecordInsertDate(new \DateTime("NOW"));
                    $document->setApplicationUserId($this->session->get('EMPID'));
                    $document->setApplicationUserIpAddress($this->session->get('IP'));
                    $this->em->persist($document);
                    $this->em->flush();
                } else {
                    $conn->rollBack();
                    foreach ($uploadedFiles as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
                }
            }

            $MYAccountDepositObj = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->findOneByEmpFk($empid);

            if ($MYAccountDepositObj) {

                //creating object for employee , Account , Expenses
                $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
                $accountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($accountid);
                $expensesObj = $this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find($source);
                //inserting record for Employee Account Expenses
                $EmpAccountExpensesObj = new EmpAccountExpenses();
                if (isset($ItemObj)) {
                    $EmpAccountExpensesObj->setItem($ItemObj);
                }
                if (isset($ProjectObj)) {
                    $EmpAccountExpensesObj->setProjectFk($ProjectObj);
                }
                $EmpAccountExpensesObj->setExpensesType($expensesObj);
                if (isset($document)) {
                    $EmpAccountExpensesObj->setDocumentFk($document);
                }
                $EmpAccountExpensesObj->setAccntFk($accountObj);
                $EmpAccountExpensesObj->setAmount($amount);
                $EmpAccountExpensesObj->setCreatedDate(new \Datetime());
                $EmpAccountExpensesObj->setExpensesDate(new \Datetime());
                $EmpAccountExpensesObj->setExpensesDescription($projectid);
                $EmpAccountExpensesObj->setEmpFk($EmpObj);
                $EmpAccountExpensesObj->setExpensesDescription($description);
                $EmpAccountExpensesObj->setRecordActiveFlag(1);
                $EmpAccountExpensesObj->setStatus(0);

                $this->em->persist($EmpAccountExpensesObj);
                $this->em->flush();
                //ends here
                //for updating Emp_account_balance
                $AccountDepositObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empid);
                if (isset($AccountDepositObj)) {
                    //for inserting into emp_account_balance table
                    $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                    $depositamount = $EmpDepositBalance[0]['s'];
                    //echo $depositamount;die();
                    $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                    $expenseamount = $EmpExpenseBalance[0]['s'];
                    $minus = $depositamount - $expenseamount;
                    //echo $expenseamount;die();
                    $AccountDepositObj->setBalanceAmount($minus);
                    $AccountDepositObj->setDateOfBalance(new\Datetime);
                    $AccountDepositObj->setRecordActiveFlag(1);
                    $AccountDepositObj->setRecordInsertDate(new\Datetime);
                    $AccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
                    $AccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
                    $AccountDepositObj->setAccntFk($accountObj);
                    $AccountDepositObj->setEmpFk($EmpObj);
                    $this->em->flush();
                }
            } else {
                return array('code' => 0, 'msg' => 'Please add deposit amount for the particular employee');
            }

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            foreach ($uploadedFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }


        return array('code' => 1, 'msg' => 'Record Save Sucessfully');
    }

    public function updateExpensesDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        $dataUI = $request->request;
        $id = $dataUI->get('id');
        $aid = $dataUI->get('account');
        //$doc = $dataUI->get('doc');
        $empid = $dataUI->get('empid');

        $source = $dataUI->get('sourcename');
        $amount = $dataUI->get('amount');

        $description = $dataUI->get('description');
        $accountid = $dataUI->get('accountid');
        $projectid = $dataUI->get('selectlist');
        if ($projectid) {
            $ProjectObj = $this->em->getRepository(WalletConstant::ENT_PROJECT)->find($projectid);
        }
        $itemid = $dataUI->get('selectlist1');
        if ($itemid) {
            $ProjectItemObj = $this->em->getRepository(WalletConstant::ENT_PRO_ITEM)->findOneBy(array('pkid' => $itemid, 'recordActiveFlag' => 1));
            $itemgetbyId = $ProjectItemObj->getItemFk()->getPkid();
            $ItemObj = $this->em->getRepository(WalletConstant::ENT_PRODUCT)->find($itemgetbyId);
        }
//        $fileupload = $request->files->get('fileExpensesImg');
//        $uploadedFiles = array();
//        $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');

        try {
//            if (isset($fileupload)) {
//                $path = 'upload/DOCUMENTS/PROJECT/EXPENSES/';
//                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 0.5, $validFileTypes);
//                if ($fuploadresult['code'] == 1) {
//                    $uploadedFiles[] = $fuploadresult['fullpath'];
//                    //save image in document master
//                    $document = new CmnDocumentMaster();
//                    $document->setPath($path . $fuploadresult['newname']);
//                    $document->setOriginalName($fuploadresult['oriname']);
//                    $document->setSystemName($fuploadresult['newname']);
//                    $document->setDocType($fuploadresult['ext']);
//                    $document->setRecordActiveFlag(1);
//                    $document->setRecordInsertDate(new \DateTime("NOW"));
//                    $document->setApplicationUserId($this->session->get('EMPID'));
//                    $document->setApplicationUserIpAddress($this->session->get('IP'));
//                    $this->em->flush();
//                } else {
//                    $conn->rollBack();
//                    foreach ($uploadedFiles as $file) {
//                        if (file_exists($file)) {
//                            unlink($file);
//                        }
//                    }
//                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
//                }
//            }
            //creating object for employee , Account , Expenses
            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $accountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($aid);
            $expensesObj = $this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find($source);
            //updating record for Employee Account Expenses
            $EmpAccountExpensesObj = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            if (isset($ItemObj)) {
                $EmpAccountExpensesObj->setItem($ItemObj);
            }
            if (isset($ProjectObj)) {
                $EmpAccountExpensesObj->setProjectFk($ProjectObj);
            }
            $EmpAccountExpensesObj->setExpensesType($expensesObj);
//            if (isset($document)) {
//                $EmpAccountExpensesObj->setDocumentFk($document);
//            }
            $EmpAccountExpensesObj->setAccntFk($accountObj);
            $EmpAccountExpensesObj->setAmount($amount);
            $EmpAccountExpensesObj->setCreatedDate(new \Datetime());
            $EmpAccountExpensesObj->setRecordUpdateDate(new \Datetime());
            $EmpAccountExpensesObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpAccountExpensesObj->setApplicationUserIpAddress($this->session->get('IP'));
            $EmpAccountExpensesObj->setExpensesDescription($projectid);
            $EmpAccountExpensesObj->setEmpFk($EmpObj);
            $EmpAccountExpensesObj->setExpensesDescription($description);
            $EmpAccountExpensesObj->setRecordActiveFlag(1);
            $EmpAccountExpensesObj->setStatus(0);
            $this->em->flush();
            //ends here
            //for updating Emp_account_balance
            $AccountDepositObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empid);
            if (isset($AccountDepositObj)) {
                //for inserting into emp_account_balance table
                $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                $depositamount = $EmpDepositBalance[0]['s'];
                //echo $depositamount;die();
                $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                $expenseamount = $EmpExpenseBalance[0]['s'];
                $minus = $depositamount - $expenseamount;
                //echo $expenseamount;die();
                $AccountDepositObj->setBalanceAmount($minus);
                $AccountDepositObj->setDateOfBalance(new\Datetime);
                $AccountDepositObj->setRecordActiveFlag(1);
                $AccountDepositObj->setRecordInsertDate(new\Datetime);
                $AccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
                $AccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
                $AccountDepositObj->setAccntFk($accountObj);
                $AccountDepositObj->setEmpFk($EmpObj);
                $this->em->flush();
            }
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Record Upate Sucessfully');
    }

    public function ApproveExpensesDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {

            $dataUI = json_decode($request->getContent());

            //getting value from data ui
            $id = $dataUI->expid;
            $empid = $dataUI->empid;
            $accntid = $dataUI->accntid;
            //$userid = 7;
            $EmpExpensesObj = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            $EmpExpensesObj->setApprovedBy($this->session->get('EMPID'));
            $EmpExpensesObj->setStatus(1);
            $EmpExpensesObj->setStatusDate(new \DateTime("NOW"));
            $EmpExpensesObj->setRecordUpdateDate(new \Datetime());
            $EmpExpensesObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpExpensesObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $EmpObj = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $accountObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->find($accntid);


            if (isset($dataUI->project) && $dataUI->project != '') {
                //for inserting into project_expenses
                $projectid = $dataUI->project;
                $itemid = $dataUI->item;
                $amount = $dataUI->amount;
                $docfk = $dataUI->docfk;
                $desc = $dataUI->description;
                $expense = $dataUI->expensedate;
                $ProjectObj = $this->em->getRepository(WalletConstant::ENT_PROJECT)->find($projectid);

                $DocObj = $this->em->getRepository(WalletConstant::ENT_DOCUMENT)->find($docfk);

                $ProjectExpenses = new ProjectExpenses();
                $ProjectExpenses->setProofFk($DocObj);
                $ProjectExpenses->setParticulars($itemid);
                $ProjectExpenses->setProjectFk($ProjectObj);
                $ProjectExpenses->setDescription($desc);
                $ProjectExpenses->setAmount($amount);
                $ProjectExpenses->setApprovalFlag(1);
                $ProjectExpenses->setTransactionDate(new\Datetime($expense));
                $ProjectExpenses->setRecordActiveFlag(1);
                $ProjectExpenses->setRecordInsertDate(new\Datetime('NOW'));
                $ProjectExpenses->setApplicationUserId($this->session->get('EMPID'));
                $ProjectExpenses->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($ProjectExpenses);
                $this->em->flush();
            }


            //for updating Emp_account_balance
            $AccountDepositObj = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findOneByEmpFk($empid);
            if (isset($AccountDepositObj)) {
                //for inserting into emp_account_balance table
                $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                $depositamount = $EmpDepositBalance[0]['s'];

                $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                $expenseamount = $EmpExpenseBalance[0]['s'];

//                if ($expenseamount > $depositamount) {
//                    
//                }
                $minus = $depositamount - $expenseamount;

                $AccountDepositObj->setBalanceAmount($minus);
                $AccountDepositObj->setDateOfBalance(new\Datetime);
                $AccountDepositObj->setRecordActiveFlag(1);
                $AccountDepositObj->setRecordInsertDate(new\Datetime);
                $AccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
                $AccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
                $AccountDepositObj->setAccntFk($accountObj);
                $AccountDepositObj->setEmpFk($EmpObj);
                $this->em->flush();
            } else {
                $AccountDepositObj = new EmpAccountBalance();
                $EmpDepositBalance = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->getDepositsumamount($empid);
                $depositamount = $EmpDepositBalance[0]['s'];
                //echo $depositamount;die();
                $EmpExpenseBalance = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->getExpensesumamount($empid);
                $expenseamount = $EmpExpenseBalance[0]['s'];

//                if ($expenseamount > $depositamount) {
////                    return array('code'=>0, 'msg' => 'Deposit amount is less than expense');
//                }
                $minus = $depositamount - $expenseamount;
                $AccountDepositObj->setBalanceAmount($minus);
                $AccountDepositObj->setDateOfBalance(new\Datetime);
                $AccountDepositObj->setRecordActiveFlag(1);
                $AccountDepositObj->setRecordInsertDate(new\Datetime);
                $AccountDepositObj->setApplicationUserId($this->session->get('EMPID'));
                $AccountDepositObj->setApplicationUserIpAddress($this->session->get('IP'));
                $AccountDepositObj->setAccntFk($accountObj);
                $AccountDepositObj->setEmpFk($EmpObj);
                $this->em->persist($AccountDepositObj);
                $this->em->flush();
            }
            $conn->commit();
            $returncode = 1;
            $returnmsg = 'Expense has been approved successfully';
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            $returncode = 0;
            $returnmsg = \Tashi\CommonBundle\Helper\CommonConstant::ERR_DB_OPERATION;
        }
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

    public function CancelExpense($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction(); //suspend auto-commit
        //auto-commit
        try {
            $dataUI = json_decode($request->getContent());
            $id = $dataUI->expid;
            $remark = $dataUI->txtRemark;
            $EmpExpensesObj = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            $EmpExpensesObj->setApprovedBy($this->session->get('EMPID'));
            $EmpExpensesObj->setStatusRemark($remark);
            $EmpExpensesObj->setStatusDate(new \DateTime("NOW"));
            $EmpExpensesObj->setStatus(2);
            $EmpExpensesObj->setRecordUpdateDate(new \Datetime());
            $EmpExpensesObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpExpensesObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $conn->commit();
            $returncode = 1;
            $returnmsg = 'Expense has been cancelled.';
        } catch (\Exception $ex) {
            $conn->rollback();
            $returncode = 0;
            $returnmsg = \Tashi\CommonBundle\Helper\CommonConstant::ERR_DB_OPERATION;
        }
        return array('code' => $returncode, 'msg' => $returnmsg);
    }

}
