<?php
namespace Tashi\AccountBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountConstant
 *
 * @author Administrator
 */
class AccountConstant {
    //put your code here
    
//SERVICE CONSTANT
    const SERVICE_ACCOUNT='tashi.account.service';
    
//ENTITY 
    const ENT_ACCOUNT_TYPE_MASTER = 'TashiCommonBundle:AccountTypeMaster';
    const ENT_ACCOUNT_HEAD = 'TashiCommonBundle:AccountHeadMaster';
    const ENT_ACCOUNT_CATEGORY = 'TashiCommonBundle:AccountCategoryMaster';
    const ENT_ACCOUNT_DETAILS_MASTER   = 'TashiCommonBundle:AccountDetailsMaster';
    const ENT_ACCOUNT_COMPANY_BANK_TXN = 'TashiCommonBundle:AccountCompanyBankTxn';
    const ENT_ACCOUNT_BANK_DEPOSIT_WITHDRAWAL_HISTORY = 'TashiCommonBundle:AccountBankDipositWithdrawalHistory';
    const ENT_ACCOUNT_BANK_CURRENT_BALANCE = 'TashiCommonBundle:AccountBankCurrentBalance';
    const ENT_ACCOUNT_CASH_CURRENT_BALANCE = 'TashiCommonBundle:AccountCashCurrentBalance';
    const ENT_ACCOUNT_CASH_DEPOSIT_WITHDRAWAL_HISTORY = 'TashiCommonBundle:AccountCashDipositWithdrawalHistory';
    const ENT_ACCOUNT_SOURCE = 'TashiCommonBundle:AccountSourceType';
    const ENT_ACCOUNT_TRANSACTION_CONTRTA_RECEIPT = 'TashiCommonBundle:AccountTransactionContraReciept';
    const ENT_ACCOUNT_TRANSACTION_CONTRTA_TYPE = 'TashiCommonBundle:AccountTransactionContraTypeMaster';
    const ENT_BANK_TRANSACTION = 'TashiCommonBundle:BankTransactionRecord';
    const ENT_CASH_TRANSACTION = 'TashiCommonBundle:CashTransactionRecord';
    const ENT_CONTRA_TRANSACTION = 'TashiCommonBundle:ContraTransactionMaster';    
//TWIG CONSTANT  
    const TWIG_ACCOUNT_CONTROL = 'TashiAccountBundle:Account:accountDashboard.html.twig';
    const TWIG_ACCOUNT_MASTER = 'TashiAccountBundle:Account:account_master.html.twig';
    const TWIG_ACCOUNT_HEAD_LIST = 'TashiAccountBundle:Account:account_master_head_list.html.twig';
    const TWIG_ACCOUNT_LOAD_COMMON_LIST = 'TashiAccountBundle:Account:account_load_common_list.html.twig';
    const TWIG_ACCOUNT_CATEGORY = 'TashiAccountBundle:Account:account_category.html.twig';
    const TWIG_ACCOUNT_CATEGORY_LIST = 'TashiAccountBundle:Account:account_category_list.html.twig';
    const TWIG_ACCOUNT_ACCOUNT_ENTRY = 'TashiAccountBundle:Account:account_account_entry.html.twig';
    const TWIG_ACCOUNT_ENTRY_VIEW_REPORT = 'TashiAccountBundle:Account:account_entry_view_report.html.twig';
    const TWIG_ACCOUNT_ENTRY_SEARCH_RESULT = 'TashiAccountBundle:Account:account_entry_search_result.html.twig';
    const TWIG_ACCOUNT_ACCOUNT_ENTRY_INCOME_LIST = 'TashiAccountBundle:Account:account_entry_income_list.html.twig';
    const TWIG_ACCOUNT_ACCOUNT_ENTRY_EXPENSE_LIST = 'TashiAccountBundle:Account:account_entry_expense_list.html.twig';
    const TWIG_ACCOUNT_ACCOUNT_ENTRY_CONTRA_LIST = 'TashiAccountBundle:Account:account_entry_contra_transaction_list.html.twig';
    const TWIG_ACCOUNT_ACCOUNT_ENTRY_LIST = 'TashiAccountBundle:Account:account_account_entry_list.html.twig';
    const TWIG_PROJECT_WALLET = 'TashiAccountBundle:Account:projectWallet.html.twig';
    const TWIG_BANK_ACCOUNT = 'TashiAccountBundle:Account:bankAccount.html.twig';
    const TWIG_BANK_ACCOUNT_LIST = 'TashiAccountBundle:Account:bankAccountList.html.twig';
    const TWIG_MASTERCASH_ACCOUNT = 'TashiAccountBundle:Account:cashAccount.html.twig';
    const TWIG_BANK_DEPOSIT_WITHDRAWAL = 'TashiAccountBundle:Account:bank_deposit_withdrawal.html.twig';
    const TWIG_CONTRA_TRANSACTION='TashiAccountBundle:Account:contratransaction.html.twig';
    const TWIG_CONTRA_TRANSACTION_LIST='TashiAccountBundle:Account:contratransactionlist.html.twig';
    const TWIG_CONTRA_PROOF='TashiAccountBundle:Account:contraproof.html.twig';
    const TWIG_BANK_DEPOSIT_WITHDRAWAL_LIST = 'TashiAccountBundle:Account:bank_deposit_withdrawal_list.html.twig';
    const TWIG_CASH_ACCOUNT = 'TashiAccountBundle:Account:cash_account.html.twig';
    const TWIG_CASH_ACCOUNT_LIST = 'TashiAccountBundle:Account:cash_account_list.html.twig';
    const TWIG_CASH_DEPOSIT_WITHDRAWAL = 'TashiAccountBundle:Account:cash_deposit_withdrawal.html.twig';
    const TWIG_CASH_DEPOSIT_WITHDRAWAL_LIST = 'TashiAccountBundle:Account:cash_deposit_withdrawal_list.html.twig';
    const TWIG_LOAD_COMMON_ACCOUNTS = 'TashiAccountBundle:Account:load_common_account.html.twig';
    const TWIG_SALES_PAYMENT_COLLECTION_CUSTOMER = 'TashiAccountBundle:Account:sales_payment_collection_customer.html.twig';
    const TWIG_SALES_ADJUSTMENT_ADVANCE_COLLECTION = 'TashiAccountBundle:Account:sales_adjustment_advance_collection.html.twig';
    const TWIG_SALES_PAYMENT_COLLECTION_CUSTOMER_LIST = 'TashiAccountBundle:Account:sales_payment_collection_customer_list.html.twig';
    const TWIG_SANCTION_SALARY_AMOUNT = 'TashiAccountBundle:Account:sanctionSalaryAmount.html.twig';
    const TWIG_SANCTION_SALARY_AMOUNT_AFTER_SANCTION_OR_REJECT = 'TashiAccountBundle:Account:sanctionSalaryAmountAfterSanctionOrReject.html.twig';
    
    const TWIG_DISPLAY_CAHSACCOUNTFORMASTER = 'TashiAccountBundle:Account:displayCashAccount.html.twig';
    
    
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}

