<?php
namespace Tashi\WalletBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WalletConstant
 *
 * @author Administrator
 */
class WalletConstant {
    
    const SERVICE_WALLET='tashi.wallet.service';
    const PROJECT_PATH = '/Tashi/web/app_dev.php/wallet/';
    //TWIG CONSTANT for wallet module
    const TWIG_DASHBOARD = 'TashiWalletBundle:Wallet:walletDashboard.html.twig';
    const TWIG_MASTER_SETTING = 'TashiWalletBundle:Wallet:walletMasterSetting.html.twig';
    const TWIG_CREATE_WALLET = 'TashiWalletBundle:Wallet:createWallet.html.twig';
    const TWIG_CREATE_DEPOSIT = 'TashiWalletBundle:Wallet:createDeposit.html.twig';
    const TWIG_CREATE_EXPENSES = 'TashiWalletBundle:Wallet:createExpenses.html.twig';
    const TWIG_CONFIRM_EXPENSE = 'TashiWalletBundle:Wallet:ExpenseConfirmation.html.twig';
    const TWIG_DISPLAY_WALLET = 'TashiWalletBundle:Wallet:displayWallet.html.twig'; 
    const TWIG_VIEW_WALLET = 'TashiWalletBundle:Wallet:displayWalletDetails.html.twig';
    const TWIG_VIEW_DEPOSIT = 'TashiWalletBundle:Wallet:displayWalletDeposit.html.twig';
    const TWIG_VIEW_ATM_DEPOSIT = 'TashiWalletBundle:Wallet:displayWalletAtmDeposite.html.twig';
    const TWIG_VIEW_SEARCH_DEPOSIT = 'TashiWalletBundle:Wallet:SearchDepositeDisplay.html.twig';
    const TWIG_VIEW_SEARCH_EXPENSES = 'TashiWalletBundle:Wallet:SearchExpensesDisplay.html.twig';
    const TWIG_VIEW_EXPENSES = 'TashiWalletBundle:Wallet:displayWalletExpenses.html.twig';
    const TWIG_DEPOSITOTHER = 'TashiWalletBundle:Wallet:displayDepositother.html.twig';
    const TWIG_SOURCEID = 'TashiWalletBundle:Wallet:empSourceId.html.twig';
    const TWIG_ACCOUNTANT = 'TashiWalletBundle:Wallet:displayAccountant.html.twig';
    const TWIG_CUSTOMER = 'TashiWalletBundle:Wallet:displayCustomer.html.twig';
    const TWIG_PROJECT = 'TashiWalletBundle:Wallet:displayProject.html.twig';
    const TWIG_ITEMS = 'TashiWalletBundle:Wallet:displayItemlis.html.twig';
    const TWIG_APPROVE = 'TashiWalletBundle:Wallet:ApproveExpenses.html.twig';
    const TWIG_APPRV = 'TashiWalletBundle:Wallet:Approve.html.twig';
    const TWIG_PENDING_EXPENSE = 'TashiWalletBundle:Wallet:PendingExpenses.html.twig';
    const TWIG_EXPENSE = 'TashiWalletBundle:Wallet:SearchExpenses.html.twig';
    const TWIG_DEPOSIT = 'TashiWalletBundle:Wallet:SearchDeposit.html.twig';
    const TWIG_EDITEXPENSES = 'TashiWalletBundle:Wallet:EditExpenses.html.twig';
    const TWIG_ATM = 'TashiWalletBundle:Wallet:displayAtm.html.twig';
    const TWIG_MY_WALLET = 'TashiWalletBundle:Wallet:MyWallet.html.twig';
    const TWIG_VIEW_MY_TRANSACTIONS = 'TashiWalletBundle:Wallet:ViewMyTransactions.html.twig';
    const TWIG_MY_TRANSACTION_LIST = 'TashiWalletBundle:Wallet:MyTransactions.html.twig';
    const TWIG_VIEW_EXPENSE_DETAIL = 'TashiWalletBundle:Wallet:ExpenseDetail.html.twig';
    const TWIG_VIEW_BALANCEDETAILS = 'TashiWalletBundle:Wallet:viewBalance.html.twig';
    
    const ENT_EMP_ACCOUNT='TashiCommonBundle:EmpAccount';
    const ENT_EMP_ACCOUNTBALANCE='TashiCommonBundle:EmpAccountBalance';
    const ENT_EMP_SOURCETYPE='TashiCommonBundle:EmpAccountSourcetype';
    const ENT_EMP_MASTER='TashiCommonBundle:EmpEmployeeMaster';
    const ENT_ACCOUNTTYPE='TashiCommonBundle:EmpAccountType';
    const ENT_SOURCE='TashiCommonBundle:EmpAccountAtmMaster';
    const ENT_CUSTOMER='TashiCommonBundle:CusCustomer';
    const ENT_PRO_ITEM='TashiCommonBundle:ProjectItemTxn';
    const ENT_PROJECT='TashiCommonBundle:ProjectMaster';
    const ENT_PRODUCT='TashiCommonBundle:PrdProductMaster';
    const ENT_DEPOSIT='TashiCommonBundle:EmpAccountDeposit';
    const ENT_EXPENSES='TashiCommonBundle:EmpAccountExpenses';
    const ENT_DOCUMENT='TashiCommonBundle:CmnDocumentMaster';
    const ENT_SourceMaster='TashiCommonBundle:EmpAccountSourceMaster';
    const ENT_AccountCompanyBankTxn='TashiCommonBundle:AccountCompanyBankTxn';
    const ENT_CASHACCOUNT='TashiCommonBundle:AccountCashCurrentBalance';
    const ENT_CASHACCOUNT_WITHDRAWAL='TashiCommonBundle:AccountCashDipositWithdrawalHistory';
    const ENT_BANKACCOUNT='TashiCommonBundle:AccountBankCurrentBalance';
    const ENT_BANK='TashiCommonBundle:CmnBankDetailsMaster';
    const ENT_PAYMODE='TashiCommonBundle:CmnPaymentModeMaster';
    const ENT_BANKACCOUNT_WITHDRAWAL='TashiCommonBundle:AccountBankDipositWithdrawalHistory';
}



