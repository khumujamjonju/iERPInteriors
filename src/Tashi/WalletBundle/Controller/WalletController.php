<?php

namespace Tashi\WalletBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\WalletBundle\Helper\WalletConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\CommonBundle\Helper\ERPMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;

class WalletController extends Controller {

    private $em;
    private $erpMessage;

    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        // $this->CustomerMessage = new CustomerMessage();
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage = new ERPMessage();
    }

    /**
     * @Route ("/wallet_dashboard", name="_wallet_dashboard")
     */
    public function WalletDashboardAction() {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('WalletDashboardAction');
        if ($accessRight == 1) {
            try {
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_DASHBOARD));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/createwallet", name="_createwallet")
     */
    public function CreateWalletDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {
                $result = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpEmployeeMaster');
                $result1 = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccount');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_CREATE_WALLET, array('emp' => $result, 'wallet' => $result1)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/mastersetting", name="_mastersetting")
     */
    public function MasterSettingDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_MASTER_SETTING));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/createdeposit", name="_createdeposit")
     */
    public function CreateDepositDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_CREATE_DEPOSIT));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/createexpenses", name="_createexpenses")
     */
    public function CreateExpensesDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_CREATE_EXPENSES));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/approve_expenses", name="_approve_expenses")
     */
    public function ApproveExpensesDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {
                $result = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeeWalletExpenses();
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_APPROVE, array('expense' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($result);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/approve_exp/{id}", name="_approve_exp")
     */
    public function ApproveExpDashboardAction($id) {
//        
//        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        try{ $result = $this->get(WalletConstant::SERVICE_WALLET)->SearchExpensesByid($id);                 
//             $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_APPRV,array('expense'=>$result)));
//             $this->erpMessage->setSuccess(true);
//             $this->erpMessage->setJsonData($result);
//        }
//        catch (\Exception $ex) {
//                $this->erpMessage->setMessage($ex->getMessage());
//                $this->erpMessage->setSuccess(false);
//        }
//        $jsondata = $serializer->serialize($this->erpMessage, 'json');
//        return new Response($jsondata); 
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $expense = $em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_EXPENSE_DETAIL, array('exp' => $expense, 'action' => 'Approve')));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/cancleapprove_exp/{id}", name="_cancleapprove_exp")
     */
    public function CancelApproveExpDashboardAction($id) {
//        
//        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
//        try{ $result = $this->get(WalletConstant::SERVICE_WALLET)->SearchExpensesByid($id);                 
//             $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_APPRV,array('expense'=>$result)));
//             $this->erpMessage->setSuccess(true);
//             $this->erpMessage->setJsonData($result);
//        }
//        catch (\Exception $ex) {
//                $this->erpMessage->setMessage($ex->getMessage());
//                $this->erpMessage->setSuccess(false);
//        }
//        $jsondata = $serializer->serialize($this->erpMessage, 'json');
//        return new Response($jsondata);  
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $expense = $em->getRepository(WalletConstant::ENT_EXPENSES)->find($id);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_EXPENSE_DETAIL, array('exp' => $expense, 'action' => 'Cancel')));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/search_expenses", name="_search_expenses")
     */
    public function SearchExpensesDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewDepositExpense');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->SearchProjectDetails();


                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_EXPENSE, array('project' => $result)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/search_deposit", name="_search_deposit")
     */
    public function SearchDepositDashboardAction() {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewDepositExpense');
        if ($accessRight == 1) {

            try {
                $source = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountSourceMaster');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_DEPOSIT, array('source' => $source)));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/searchEmployee", name="_searchEmployee")
     *    
     */
    public function searchEmployeeAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $dataUI = json_decode($request->getContent());
            $empid = $dataUI->selectedEMp;
            $empdetails = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $account = $this->em->getRepository(WalletConstant::ENT_ACCOUNTTYPE)->findByRecordActiveFlag(1);
            $result = $this->em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->findOneBy(array('empFk' => $empid, 'recordActiveFlag' => 1));
            if ($result) {
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Employee Wallet Already Exist!');
            } else {
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_DISPLAY_WALLET, array('empid' => $empdetails, 'account' => $account)));
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/retreivewallet/{accountid}", name="_retreivewallet")
     *    
     */
    public function RetreiveWalletDetailsAction(Request $request, $accountid) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $result = $this->get(WalletConstant::SERVICE_WALLET)->getwalletdetails($accountid);
            $dataUI = json_decode($request->getContent());
            $empid = $dataUI->empid;
            $empdetails = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $account = $this->em->getRepository(WalletConstant::ENT_ACCOUNTTYPE)->findByRecordActiveFlag(1);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_DISPLAY_WALLET, array('empid' => $empdetails, 'wallet' => $result, 'account' => $account)));
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
     * 
     * 
     * @Route("/retreiveatm/{atmid}", name="_retreiveatm")
     *    
     */
    public function RetreiveATMDetailsAction(Request $request, $atmid) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $result = $this->get(WalletConstant::SERVICE_WALLET)->getatmdetails($atmid);
            //$dataUI = json_decode($request->getContent());
            //$empid = $dataUI->empid;
            //$empdetails = $this->em->getRepository(WalletConstant::ENT_EMP_MASTER)->find($empid);
            $res = $this->em->getRepository(WalletConstant::ENT_SOURCE)->findByRecordActiveFlag(1);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_ATM_DEPOSIT, array('walet' => $result, 'wallet' => $res)));
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
     * @Route ("/searchEmpwallet", name="_searchEmpwallet")
     */
    public function autoCompleteSearchEmpwalletAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {

            $searchResult = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeedetailsForDeposit($request);

            $source = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountSourceMaster');
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_DEPOSIT, array('empdetails' => $searchResult, 'source' => $source)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($searchResult);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/searchEmpAtmwallet", name="_searchEmpAtmwallet")
     */
    public function autoCompleteSearchEmpAtmWalletAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();


        try {
            $searchResult = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeeAtmdetailsForDeposit($request);
            $WalletMasterSettingObj = $this->em->getRepository(WalletConstant::ENT_SOURCE)->findByRecordActiveFlag(1);


            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_ATM_DEPOSIT, array('empdetails' => $searchResult, 'wallet' => $WalletMasterSettingObj)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($searchResult);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/searchdeposite", name="_searchdeposite")
     */
    public function autoCompleteSearchDepositeAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewDepositExpense');
        if ($accessRight == 1) {
            try {
                //$searchResult = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeedetailsForDeposit($request);
                $dataUI = json_decode($request->getContent());
                $criteria = $dataUI->selSearchDeposit;
                switch ($criteria) {
                    case 'all':
                        $expenseArr = $this->get(WalletConstant::SERVICE_WALLET)->SearchAllDeposit();
                        break;
                    case 'empID':
                        $emp = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeeByID($request);
                        $expenseArr = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->findBy(array('empFk' => $emp, 'recordActiveFlag' => 1));
                        break;
                    case 'date':
                        $expenseArr = $this->get(WalletConstant::SERVICE_WALLET)->SearchDepositByCriteria($request);
                        break;
                    case 'type':
                        $proid = $dataUI->projectid;
                        $expenseArr = $this->em->getRepository(WalletConstant::ENT_DEPOSIT)->findBy(array('sourceType' => $proid, 'recordActiveFlag' => 1));
                        break;
                }
                if (empty($expenseArr)) {
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No record found!');
                } else {
                    $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_SEARCH_DEPOSIT, array('deposit' => $expenseArr)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($expenseArr);
                }
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/searchexpenses", name="_searchexpenses")
     */
    public function autoCompleteSearchExpensesAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ViewDepositExpense');
        if ($accessRight == 1) {
            try {
                $dataUI = json_decode($request->getContent());
                $criteria = $dataUI->selSearchExpense;
                switch ($criteria) {
                    case 'all':
                        $expenseArr = $this->get(WalletConstant::SERVICE_WALLET)->SearchAllExpenses();
                        break;
                    case 'empID':
                        $emp = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeeByID($request);
                        $expenseArr = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('empFk' => $emp, 'recordActiveFlag' => 1));
                        //$expenseArr = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('empFk' => $emp, 'recordActiveFlag' => 1));
                        break;
                    case 'date':
                        $expenseArr = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmployeedetailsForExpenses($request);
                        break;
                    case 'project':
                        $proid = $dataUI->projectid;
                        $expenseArr = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('projectFk' => $proid, 'recordActiveFlag' => 1));
                        //$expenseArr = $this->em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('projectFk' => $proid, 'recordActiveFlag' => 1));
                        break;
                }

                if (empty($expenseArr)) {
                    $this->erpMessage->setSuccess(false);
                    $this->erpMessage->setMessage('No record found!');
                } else {
                    $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_SEARCH_EXPENSES, array('expense' => $expenseArr)));
                    $this->erpMessage->setSuccess(true);
                    $this->erpMessage->setJsonData($expenseArr);
                }
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/addexpense", name="_addexpense")
     */
    public function SearchEmpwalletAction(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $searchResult = $this->get(WalletConstant::SERVICE_WALLET)->SearchEmpDetailsDeposit();
            if (!$searchResult) {
                $this->erpMessage->setMessage('Your wallet has not been created yet. Please contact the authorised person.');
                $this->erpMessage->setSuccess(false);
            } else {
                $balanceAmt = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->GetBalanceByEmpID($this->getRequest()->getSession()->get('EMPID'));
                if (!$balanceAmt) {
                    $balanceAmt = 0;
                } else {
                    $balanceAmt = $balanceAmt[0]['balanceAmount'];
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage('');
                $sourcetype = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountSourcetype');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_EXPENSES, array('balance' => $balanceAmt, 'empdetails' => $searchResult[0], 'source' => $sourcetype)));
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL . ' ' . $ex->getMessage());
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/showatmcusaccountant", name="_showatmcusaccountant")
     */
    public function showingSourceTypeDetailsAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->sourcename;
            $empid = $dataUI->empid;
            $sourcedetails = $this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find($criteria);
            // $code = $sourcedetails->getPkid();

            if ($criteria == 3) {
                $atmdetails = $this->em->getRepository(WalletConstant::ENT_AccountCompanyBankTxn)->findBy(array('recordActiveFlag' => 1));
                $paymode = $this->em->getRepository(WalletConstant::ENT_PAYMODE)->findBy(array('recordActiveFlag' => 1));
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_SOURCEID, array('sty' => $atmdetails, 'pay' => $paymode)));
                $this->erpMessage->setJsonData($atmdetails);
                $this->erpMessage->setSuccess(true);
            }
            if ($criteria == 2) {
                $cusdetails = $this->em->getRepository(WalletConstant::ENT_CUSTOMER)->findByRecordActiveFlag(1);
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_CUSTOMER, array('customer' => $cusdetails)));
                $this->erpMessage->setSuccess(true);
            }
            if ($criteria == 1) {
                $criteria1 = 'Accountant';
                //$atmdetails = $this->get(WalletConstant::SERVICE_WALLET)->SearchAccountant($criteria1);
                $balance = $this->em->getRepository(WalletConstant::ENT_CASHACCOUNT)->findOneBy(array('recordActiveFlag' => 1));
                if ($balance) {
                    $current = $balance->getCurrentAmount();
                } else {
                    $current = 0;
                }
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_ACCOUNTANT, array('cur' => $current)));
                $this->erpMessage->setSuccess(true);
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/showcurrentbalance", name="_showcurrentbalance")
     */
    public function ShowcurrentbalanceAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->selectlist;
            // echo $criteria;die();
            $bankDetails = $this->em->getRepository(WalletConstant::ENT_BANKACCOUNT)->findOneBy(array('bankFk' => $criteria));
            if ($bankDetails) {
                $balance = $bankDetails->getCurrentAmount();
            } else {
                $balance = 0;
            }
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_BALANCEDETAILS, array('amount' => $balance)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/showlist", name="_showlist")
     */
    public function showingTypeofExpensesDetailsAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->sourcename;

            $sourcedetails = $this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find($criteria);
            $code = $sourcedetails->getIsRelated();
            if ($code == 1) {
                $projectdetails = $this->get(WalletConstant::SERVICE_WALLET)->SearchProjectDetails();
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_PROJECT, array('project' => $projectdetails)));
                $this->erpMessage->setJsonData($projectdetails);
                $this->erpMessage->setSuccess(true);
            } else {
                $this->erpMessage->setJsonData(0);
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
     * @Route ("/showlistitems", name="_showlistitems")
     */
    public function showingITemsDetailsAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->selectlist;

            $itemsdetails = $this->em->getRepository(WalletConstant::ENT_PRO_ITEM)->findBy(array('projectFk' => $criteria, 'recordActiveFlag' => 1));

            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_ITEMS, array('item' => $itemsdetails)));
            $this->erpMessage->setJsonData($itemsdetails);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/showEmpwallet", name="_showEmpwallet")
     */
    public function showEmpwalletAction(Request $request) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $dataUI = json_decode($request->getContent());
            $criteria = $dataUI->sourcetype;
            $sourcedetails = $this->em->getRepository(WalletConstant::ENT_EMP_SOURCETYPE)->find($criteria);
            $code = $sourcedetails->getPkid();

            if ($code == 1) {
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_DEPOSITOTHER));
                $this->erpMessage->setSuccess(true);
            } else {
                //$this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_DEPOSIT));
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/retreivexpenses/{id}", name="_retreivexpenses")
     */
    public function EditWalletExpensesDetailsAction(Request $request, $id) {


        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $sourcetype = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountSourcetype');
            $result = $this->get(WalletConstant::SERVICE_WALLET)->getwalletExpensesdetails($id);
            $proid = $result['proid'];
            $empcode = $result['empid'];
            $empname = $result['ename'];

            $eid = $result['eid'];
            $aid = $result['account'];
            $projectdetails = $this->get(WalletConstant::SERVICE_WALLET)->SearchProjectDetails();
            $itemsdetails = $this->em->getRepository(WalletConstant::ENT_PRO_ITEM)->findBy(array('projectFk' => $proid, 'recordActiveFlag' => 1));

            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_EDITEXPENSES, array('result' => $result, 'source' => $sourcetype,
                        'project' => $projectdetails, 'item' => $itemsdetails, 'code' => $empcode, 'name' => $empname, 'eid' => $eid, 'id' => $id, 'aid' => $aid)));
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
     * 
     * 
     * @Route("/saveAtmWallet", name="_saveAtmWallet")
     *    
     */
    public function SaveAtmWalletAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->addAtmWalletDetails($request);
                $res = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountAtmMaster');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_ATM, array('wallet' => $res)));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/updateAtmWallet", name="_updateAtmWallet")
     */
    public function UpdateAtmWalletAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->updateAtmWalletDetails($request);
                $res = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountAtmMaster');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_ATM, array('wallet' => $res)));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/deleteWalletAtm/{atmid}", name="_deleteWalletAtm")
     *    
     */
    public function DeleteWalletATMAction($atmid) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->deleteWalletATMDetails($atmid);
                $res = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpAccountAtmMaster');
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_ATM, array('wallet' => $res)));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/saveWallet", name="_saveWallet")
     *    
     */
    public function SaveWalletAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->addWalletDetails($request);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/updateWallet", name="_updateWallet")
     *    
     */
    public function UpdateWalletAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->updateWalletDetails($request);
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_WALLET, array('wallet' => $result)));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/deleteWallet/{accountid}", name="_deleteWallet")
     *    
     */
    public function DeleteWalletAction($accountid) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->deleteWalletDetails($accountid);

                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_WALLET, array('wallet' => $result)));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/saveWalletDeposit", name="_saveWalletDeposit")
     *    
     */
    public function SaveWalletDepositAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            try {

                $result = $this->get(WalletConstant::SERVICE_WALLET)->addWalletDepositDetails($request);
                if ($result['code'] == 0) {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(false);
                } else {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setSuccess(true);
                }
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                //$this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView($ex->getMessage()));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/approveWalletExpenses", name="_approveWalletExpenses")
     *    
     */
    public function ApproveWalletExpensesAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            $result = $this->get(WalletConstant::SERVICE_WALLET)->ApproveExpensesDetails($request);
            if ($result['code'] == 1) {
                $this->erpMessage->setSuccess(true);
            } else {
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/cancelWalletExpenses", name="_cancelWalletExpenses")   
     */
    public function CancelWalletExpensesAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageWallet');
        if ($accessRight == 1) {
            $result = $this->get(WalletConstant::SERVICE_WALLET)->CancelExpense($request);
            if ($result['code'] == 1) {
                $this->erpMessage->setSuccess(true);
            } else {
                $this->erpMessage->setSuccess(false);
            }
        } else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $this->erpMessage->setMessage($result['msg']);
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/pendingexpenses", name="_pendingexpenses")   
     */
    public function LoadPendingExpensesAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $expArr = $em->getRepository(WalletConstant::ENT_EXPENSES)->findBy(array('status' => 0, 'recordActiveFlag' => 1), array('pkid' => 'ASC'));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_PENDING_EXPENSE, array('expense' => $expArr)));
        } catch (\Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/saveWalletExpenses/{btn}", name="_saveWalletExpenses")
     *    
     */
    public function SaveWalletExpensesAction($btn, Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            if ($btn == 'before') {
                $em = $this->getDoctrine()->getManager();
                $dataUI = $request->request;
                $empid = $dataUI->get('empid');
                $expamt = $dataUI->get('amount');
               
                $empbalance = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNTBALANCE)->findBy(array('empFk' => $empid, 'recordActiveFlag' => 1));
                if ($empbalance) {
                    $balAmt = $empbalance[0]->getBalanceAmount();
                    if ($expamt > $balAmt) {
                        $this->erpMessage->setJsonData(true);
                        goto _exit;
                    } else {
                        $result = $this->get(WalletConstant::SERVICE_WALLET)->addWalletExpensesDetails($request);//print_r($result);die();
                        if ($result['code'] == 1) {
                            $this->erpMessage->setSuccess(true);
                        }else {
                            $this->erpMessage->setSuccess(false);
                        }
                        $this->erpMessage->setMessage($result['msg']);
                        goto _exit;
                    }
                } else {
                    $this->erpMessage->setMessage('It seems your wallet has not been created yet. Please contact Accountant/Authorised person');
                    $this->erpMessage->setSuccess(false);
                }
            } else {
                $result = $this->get(WalletConstant::SERVICE_WALLET)->addWalletExpensesDetails($request);
                if ($result['code'] == 1) {
                    $this->erpMessage->setSuccess(true);
                } else {
                    $this->erpMessage->setSuccess(false);
                }
                $this->erpMessage->setMessage($result['msg']);
                goto _exit;
            }
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
                _exit:
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
        
    }

    /**
     * @Route("/updateWalletExpenses", name="_updateWalletExpenses") 
     */
    public function UpdateWalletExpensesAction(Request $request) {

        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(WalletConstant::SERVICE_WALLET)->updateExpensesDetails($request);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/mywallet", name="_mywallet") 
     */
    public function MyWalletAction() {
        try {
            $em = $this->getDoctrine()->getManager();
            $employee=$em->getRepository(CommonConstant::ENT_EMPLOYEE_MASTER)->findOneBy(array('employeeId'=>$this->getRequest()->getSession()->get('EMPID')));
            $checkWallet=$em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->findBy(array('empFk'=>$employee,'recordActiveFlag'=>1));
            if($checkWallet){
                $balanceAmt = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->GetBalanceByEmpID($this->getRequest()->getSession()->get('EMPID'));
                if (!$balanceAmt) {
                    $balanceAmt = 0;
                } else {
                    $balanceAmt = $balanceAmt[0]['balanceAmount'];
                }
                //LAST 10 TRANSACTION
                $lastTenTrans = array('Date' => array(), 'Desc' => array(), 'Amount' => array(), 'Type' => array());
                $lastTenDeposit = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->GetTopTenDeposit($this->getRequest()->getSession()->get('EMPID'));
                $lastTenExpense = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->GetTopTenExpense($this->getRequest()->getSession()->get('EMPID'));
                if (!$lastTenDeposit && $lastTenExpense) {
                    foreach ($lastTenExpense as $exp) {
                        if (count($lastTenTrans['Date']) <= 3) {
                            array_push($lastTenTrans['Date'], $exp->getExpensesDate());
                            array_push($lastTenTrans['Desc'], $exp->getExpensesDescription());
                            array_push($lastTenTrans['Amount'], $exp->getAmount());
                            array_push($lastTenTrans['Type'], 'Expense');
                        }
                    }
                } elseif (!$lastTenExpense && $lastTenDeposit) {
                    foreach ($lastTenDeposit as $dep) {
                        if (count($lastTenTrans['Date']) <= 3) {
                            array_push($lastTenTrans['Date'], $dep->getRecordInsertDate());
                            array_push($lastTenTrans['Desc'], $dep->getDescription());
                            array_push($lastTenTrans['Amount'], $dep->getAmount());
                            array_push($lastTenTrans['Type'], 'Deposits');
                        }
                    }
                } elseif ($lastTenDeposit && $lastTenExpense) {
                    $i = 0;
                    $j = 0;
                    while ($i < count($lastTenDeposit) && $j < count($lastTenExpense)) {
                        if (count($lastTenTrans['Date']) <= 9) {
                            $dDate = $lastTenDeposit[$i]->getRecordInsertDate();
                            $eDate = $lastTenExpense[$j]->getExpensesDate();
                            if ($dDate > $eDate) {
                                $dep = $lastTenDeposit[$i];
                                array_push($lastTenTrans['Date'], $dep->getRecordInsertDate());
                                array_push($lastTenTrans['Desc'], $dep->getDescription());
                                array_push($lastTenTrans['Amount'], $dep->getAmount());
                                array_push($lastTenTrans['Type'], 'Deposits');
                                $i++;
                            } else {
                                $exp = $lastTenExpense[$j];
                                array_push($lastTenTrans['Date'], $exp->getExpensesDate());
                                array_push($lastTenTrans['Desc'], $exp->getExpensesDescription());
                                array_push($lastTenTrans['Amount'], $exp->getAmount());
                                array_push($lastTenTrans['Type'], 'Expense');
                                $j++;
                            }
                        } else {
                            break;
                        }
                    }
                    while ($i < count($lastTenDeposit)) {
                        if (count($lastTenTrans['Date']) <= 9) {
                            $dep = $lastTenDeposit[$i];
                            array_push($lastTenTrans['Date'], $dep->getRecordInsertDate());
                            array_push($lastTenTrans['Desc'], $dep->getDescription());
                            array_push($lastTenTrans['Amount'], $dep->getAmount());
                            array_push($lastTenTrans['Type'], 'Deposits');
                            $i++;
                        } else {
                            break;
                        }
                    }
                    while ($j < count($lastTenExpense)) {
                        if (count($lastTenTrans['Date']) <= 9) {
                            $exp = $lastTenExpense[$j];
                            array_push($lastTenTrans['Date'], $exp->getExpensesDate());
                            array_push($lastTenTrans['Desc'], $exp->getExpensesDescription());
                            array_push($lastTenTrans['Amount'], $exp->getAmount());
                            array_push($lastTenTrans['Type'], 'Expense');
                            $j++;
                        } else {
                            break;
                        }
                    }
                }
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_MY_WALLET, array('balance' => $balanceAmt, 'trans' => $lastTenTrans)));
            }else{
                $this->erpMessage->setSuccess(false);
                $this->erpMessage->setMessage('Your wallet has not been created yet. Please contact the Authorised person.');
            }
        } catch (Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/viewmytrans", name="_viewmytrans") 
     */
    public function ViewMyTransactionAction() {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $this->erpMessage->setSuccess(true);
        $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_MY_TRANSACTIONS));
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/searchmytrans", name="_searchmytrans") 
     */
    public function SearchMyTransactionAction(Request $request) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $session = $this->getRequest()->getSession();
            $empid = $session->get('EMPID');
            $dataUI = json_decode($request->getContent());
            $view = $dataUI->tranradio;
            $fDate = $dataUI->txtfdate;
            $tDate = $dataUI->txttdate;
            $status = $dataUI->statusradio;
            $transArr = array('Date' => array(), 'Desc' => array(), 'Exp' => array(), 'Dep' => array(),
                'Project' => array(), 'Type' => array(), 'Item' => array(), 'Proof' => array(),
                'ExpID' => array(), 'Status' => array(), 'ExpensesType' => array());
            if ($view == 'a') {
                $depositArr = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->SearchMyDeposits($empid, $fDate, $tDate);
                $expenseArr = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->SearchMyExpenses($empid, $fDate, $tDate, $status);
                $i = 0;
                $j = 0;
                while ($i < count($depositArr) && $j < count($expenseArr)) {
                    $dDate = $depositArr[$i]->getRecordInsertDate();
                    $eDate = $expenseArr[$j]->getExpensesDate();
                    if ($dDate < $eDate) {
                        $dep = $depositArr[$i];
                        array_push($transArr['Date'], $dep->getRecordInsertDate());
                        array_push($transArr['Desc'], $dep->getDescription());
                        array_push($transArr['Dep'], $dep->getAmount());
                        array_push($transArr['Exp'], '');
                        array_push($transArr['Project'], '');
                        array_push($transArr['Item'], '');
                        array_push($transArr['Proof'], '');
                        array_push($transArr['Type'], 'D');
                        array_push($transArr['ExpID'], '');
                        array_push($transArr['Status'], '');
                        array_push($transArr['ExpensesType'], '');
                        $i++;
                    } else {
                        $exp = $expenseArr[$j];
                        array_push($transArr['Date'], $exp->getExpensesDate());
                        array_push($transArr['Desc'], $exp->getExpensesDescription());
                        array_push($transArr['Exp'], $exp->getAmount());
                        array_push($transArr['Dep'], '');
                        array_push($transArr['Project'], $exp->getProjectFk());
                        array_push($transArr['Item'], $exp->getItem());
                        array_push($transArr['Proof'], $exp->getDocumentFk());
                        array_push($transArr['Type'], 'E');
                        array_push($transArr['ExpID'], $exp->getPkid());
                        array_push($transArr['Status'], $exp->getStatus());
                        array_push($transArr['ExpensesType'], $exp->getExpensesType()->getPkid());
                        $j++;
                    }
                }
                while ($i < count($depositArr)) {
                    $dep = $depositArr[$i];
                    array_push($transArr['Date'], $dep->getRecordInsertDate());
                    array_push($transArr['Desc'], $dep->getDescription());
                    array_push($transArr['Exp'], '');
                    array_push($transArr['Dep'], $dep->getAmount());
                    array_push($transArr['Project'], '');
                    array_push($transArr['Item'], '');
                    array_push($transArr['Proof'], '');
                    array_push($transArr['Type'], 'D');
                    array_push($transArr['ExpID'], '');
                    array_push($transArr['Status'], '');
                    array_push($transArr['ExpensesType'], '');
                    $i++;
                }
                while ($j < count($expenseArr)) {
                    $exp = $expenseArr[$j];
                    array_push($transArr['Date'], $exp->getExpensesDate());
                    array_push($transArr['Desc'], $exp->getExpensesDescription());
                    array_push($transArr['Exp'], $exp->getAmount());
                    array_push($transArr['Dep'], '');
                    array_push($transArr['Project'], $exp->getProjectFk());
                    array_push($transArr['Item'], $exp->getItem());
                    array_push($transArr['Proof'], $exp->getDocumentFk());
                    array_push($transArr['Type'], 'E');
                    array_push($transArr['ExpID'], $exp->getPkid());
                    array_push($transArr['Status'], $exp->getStatus());
                    array_push($transArr['ExpensesType'], $exp->getExpensesType()->getPkid());
                    $j++;
                }
            } elseif ($view == 'd') {
                $depositArr = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->SearchMyDeposits($empid, $fDate, $tDate);
                foreach ($depositArr as $dep) {
                    array_push($transArr['Date'], $dep->getRecordInsertDate());
                    array_push($transArr['Desc'], $dep->getDescription());
                    array_push($transArr['Dep'], $dep->getAmount());
                    array_push($transArr['Exp'], '');
                    array_push($transArr['Project'], '');
                    array_push($transArr['Item'], '');
                    array_push($transArr['Proof'], '');
                    array_push($transArr['Type'], 'D');
                    array_push($transArr['ExpID'], '');
                    array_push($transArr['Status'], '');
                    array_push($transArr['ExpensesType'],'');
                }
            } elseif ($view == 'e') {
                $expenseArr = $em->getRepository(WalletConstant::ENT_EMP_ACCOUNT)->SearchMyExpenses($empid, $fDate, $tDate, $status);
                foreach ($expenseArr as $exp) {
                    array_push($transArr['Date'], $exp->getExpensesDate());
                    array_push($transArr['Desc'], $exp->getExpensesDescription());
                    array_push($transArr['Exp'], $exp->getAmount());
                    array_push($transArr['Dep'], '');
                    array_push($transArr['Project'], $exp->getProjectFk());
                    array_push($transArr['Item'], $exp->getItem());
                    array_push($transArr['Proof'], $exp->getDocumentFk());
                    array_push($transArr['Type'], 'E');
                    array_push($transArr['ExpID'], $exp->getPkid());
                    array_push($transArr['Status'], $exp->getStatus());
                    array_push($transArr['ExpensesType'], $exp->getExpensesType()->getPkid());
                }
            }
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_MY_TRANSACTION_LIST, array('trans' => $transArr)));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route("/viewmyexpensedetail/{pkid}", name="_viewmyexpensedetail")
     */
    public function ViewMyExpenseDetailAction($pkid) {
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $em = $this->getDoctrine()->getManager();
            $expense = $em->getRepository(WalletConstant::ENT_EXPENSES)->find($pkid);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setHtml($this->renderView(WalletConstant::TWIG_VIEW_EXPENSE_DETAIL, array('exp' => $expense, 'action' => '')));
        } catch (Exception $ex) {
            $this->erpMessage->setSuccess(false);
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

}

