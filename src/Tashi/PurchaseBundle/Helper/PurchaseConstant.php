<?php
namespace Tashi\PurchaseBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseConstant
 *
 * @author SANATOMBA
 */
class PurchaseConstant 

{  const SERVICE_PURCHASE = 'tashi.purchase.service'   ;
   
   const PROJECT_PATH = '/Tashi/web/app_dev.php/purchase/';
    
   const TWIG_PUR_DASHBOARD = 'TashiPurchaseBundle:Purchase:purchaseDashboard.html.twig';
   const TWIG_PUR_COMPANY_MASTER = 'TashiPurchaseBundle:Purchase:purchaseMasterPurchaseProduct.html.twig';
   const TWIG_PUR_MASTER = 'TashiPurchaseBundle:Purchase:purchaseMasterPurchaseProduct.html.twig';
   const TWIG_COMPANY_VIEW = 'TashiPurchaseBundle:Purchase:viewCompany.html.twig'; 
   const TWIG_SUP_VIEW = 'TashiPurchaseBundle:Purchase:viewSupplier.html.twig'; 
   const TWIG_PUR_ORDER = 'TashiPurchaseBundle:Purchase:purchaseOrder.html.twig';
   const TWIG_ENTRYORDER = 'TashiPurchaseBundle:Purchase:POEntry.html.twig';
   const TWIG_PRO_RELATED = 'TashiPurchaseBundle:Purchase:isProjectrelated.html.twig';
   const TWIG_PUR_SUPLIST = 'TashiPurchaseBundle:Purchase:purchaseSupplierlist.html.twig';
   const TWIG_APPEND_PRODUCT = 'TashiPurchaseBundle:Purchase:Selected_product_toBeAdded.html.twig';
   const TWIG_APPEND_SUB_CATEGORY='TashiPurchaseBundle:Purchase:AppendProductSubCat.html.twig';
   const TWIG_APPEND_PRODUCTS='TashiPurchaseBundle:Purchase:AppendProducts.html.twig';
   const TWIG_APPROVE_PURCHASE='TashiPurchaseBundle:Purchase:purchaseApprove.html.twig';
   const TWIG_PUR_APPROVE='TashiPurchaseBundle:Purchase:purApprove.html.twig';
   const TWIG_APPEND_APPROVE='TashiPurchaseBundle:Purchase:displayApproved.html.twig';
   const TWIG_UPDATEPURAPPROVE='TashiPurchaseBundle:Purchase:purEdit.html.twig';
   const TWIG_SEARCH='TashiPurchaseBundle:Purchase:SearchPurchase.html.twig';
   const TWIG_VIEWORDER='TashiPurchaseBundle:Purchase:ViewOrder.html.twig';
   const TWIG_EMP_WALLET='TashiPurchaseBundle:Purchase:capture_walletid.html.twig';
   const TWIG_PURCHASEPAYMENT='TashiPurchaseBundle:Purchase:Payment.html.twig';
   const TWIG_PAYMENTDETAILS='TashiPurchaseBundle:Purchase:showPaymentdetails.html.twig';
   const TWIG_QuantityUpdate='TashiPurchaseBundle:Purchase:QuantityUpdate.html.twig';
   const TWIG_POVIEW='TashiPurchaseBundle:Purchase:ViewPO.html.twig';
   const TWIG_DISPLAYCASHBALANCE='TashiPurchaseBundle:Purchase:displayCashBalance.html.twig';
   const TWIG_DISPLAYBANKBALANCE='TashiPurchaseBundle:Purchase:bankDetails.html.twig';
   const TWIG_DISPLAYBAlance='TashiPurchaseBundle:Purchase:viewBalance.html.twig';
   const TWIG_DISPLAYPURCHASELIST='TashiPurchaseBundle:Purchase:displayPurchaseOrderList.html.twig';
   const TWIG_PAYMENTFORM='TashiPurchaseBundle:Purchase:displaywithPaymentDetails.html.twig';
   
   //Entity Table for Purchase Module
   const ENT_SUP_MASTER = 'TashiCommonBundle:SupplierMaster'; 
   const ENT_SUPPLIER_ADDRESS_TXN='TashiCommonBundle:SupplierAddressTxn';
   const ENT_SUPPLIER_MOBILE_TXN='TashiCommonBundle:SupplierContactMobileNoTxn';
   const ENT_SUPPLIER_CONTACT_TXN='TashiCommonBundle:SupplierContactTxn';
   const ENT_Transporter = 'TashiCommonBundle:TransporterMaster'; 
   const ENT_MODE = 'TashiCommonBundle:TransportModeMaster'; 
   const ENT_POMASTER = 'TashiCommonBundle:PoMaster'; 
   const ENT_CMNPAY = 'TashiCommonBundle:CmnPaymentModeMaster'; 
   const ENT_EMP = 'TashiCommonBundle:EmpEmployeeMaster'; 
   const ENT_TransMODE = 'TashiCommonBundle:TransportModeMaster'; 
   const ENT_TRANSPORT = 'TashiCommonBundle:TransporterMaster'; 
   const ENT_Paymode = 'TashiCommonBundle:CmnPaymentModeMaster'; 
   const ENT_Project_status_txn = 'TashiCommonBundle:ProjectStatusTxn'; 
   const ENTITY_PROJECT='TashiCommonBundle:ProjectMaster';
   const ENT_COMPANY_MASTER = 'TashiCommonBundle:CompanyMaster'; 
   const ENT_COMPANY_ADDRESS_TXN = 'TashiCommonBundle:CompanyAddressTxn'; 
   //const ENT_COMPANY_CONTACT_TXN = 'TashiCommonBundle:CompanyContactTxn'; 
   const ENT_COMPANY_MOBILE_TXN = 'TashiCommonBundle:CompanyContactMobileNoTxn'; 
   const ENT_SUP_Product_TXN = 'TashiCommonBundle:SupplierProductTxn';  
   
   const ENT_POSTATUS = 'TashiCommonBundle:PoStatusMaster'; 
   const ENT_POTrasns_txn = 'TashiCommonBundle:PoTransportTxn'; 
   const ENT_POStatus_txn = 'TashiCommonBundle:PoStatusTxn'; 
   const ENT_POpayment_txn = 'TashiCommonBundle:PoPaymentTxn'; 
   const ENT_POProduct = 'TashiCommonBundle:PoProductDetails'; 
   const ENT_POProduct_Unit_txn = 'TashiCommonBundle:ProductUnitTxn'; 
   const ENT_EMPWALLET = 'TashiCommonBundle:EmpWallet'; 
   const ENT_AccountCompanyBankTxn='TashiCommonBundle:AccountCompanyBankTxn';
    const ENT_CASHACCOUNT='TashiCommonBundle:AccountCashCurrentBalance';
    const ENT_CASHACCOUNT_WITHDRAWAL='TashiCommonBundle:AccountCashDipositWithdrawalHistory';
    const ENT_BANKACCOUNT='TashiCommonBundle:AccountBankCurrentBalance';
    const ENT_BANK='TashiCommonBundle:CmnBankDetailsMaster';
    const ENT_BANKACCOUNT_WITHDRAWAL='TashiCommonBundle:AccountBankDipositWithdrawalHistory';
   
}


   
    
    
    
    
    
    

