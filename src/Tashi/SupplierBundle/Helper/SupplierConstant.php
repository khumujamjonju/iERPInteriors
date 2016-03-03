<?php
namespace Tashi\SupplierBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockConstant
 *
 * @author Administrator
 */
class SupplierConstant {
    
    
  
    const SERVICE_SUPPLIER='tashi.supplier.service';
    const PROJECT_PATH = '/Tashi/web/app_dev.php/supplier/';
    
    //TWIG CONSTANT for supplier module
    const TWIG_STOCK_DASHBOARD = 'TashiSupplierBundle:Supplier:stockDashboard.html.twig';
    const TWIG_STOCK_SUPPLIER_MOBILE_LIST = 'TashiSupplierBundle:Supplier:Sup_mobile_list.html.twig';
    const TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST = 'TashiSupplierBundle:Supplier:displaymobile.html.twig';
    const TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST = 'TashiSupplierBundle:Supplier:displaybank.html.twig';
    const TWIG_STOCK_SEARCH_SUPPLIER = 'TashiSupplierBundle:Supplier:SearchSupplier.html.twig';
    const TWIG_STOCK_SUPPLIER_MOBILE = 'TashiSupplierBundle:Supplier:addSuppliermobile.html.twig';
    const TWIG_STOCK_SUPPLIER_ADDRESS = 'TashiSupplierBundle:Supplier:addSupplierAddress.html.twig';
    const TWIG_STOCK_DASH_MASTER_SUPPLIER = 'TashiSupplierBundle:Supplier:newSupplier.html.twig';
    const TWIG_STOCK_MASTER_SUPPLIER = 'TashiSupplierBundle:Supplier:MasterSupplier.html.twig';
    const TWIG_STOCK_SUPPIER_BANK_DETAILS = 'TashiSupplierBundle:Supplier:MasterSupplierBankDetail.html.twig';
    const TWIG_COM_SEARCH = 'TashiSupplierBundle:Supplier:searchSupplierCom.html.twig';
    const TWIG_COM_RESULT='TashiSupplierBundle:Supplier:supplierCommunicationSearchResult.html.twig';
    
    const TWIG_SMS_TEMPLATE = 'TashiSupplierBundle:Supplier:com_smstemplate.html.twig';
    const TWIG_COMM_HISTORY = 'TashiSupplierBundle:Supplier:com_communicationhistory.html.twig';
    const TWIG_SEND_EMAIL = 'TashiSupplierBundle:Supplier:com_sendemail.html.twig';
    //from erp
    
    const TWIG_CMN_SUP_ADDFORM = 'TashiSupplierBundle:Supplier:cim_addressForm.html.twig';
    const TWIG_CIM_CUS_SEARCH='TashiSupplierBundle:Supplier:cim_search.html.twig';
    const TWIG_CIM_CUS_SEARCH_RESULT='TashiSupplierBundle:Supplier:customerSearchResult.html.twig';
    const TWIG_SUP_ADDRESS_ATTRIBUTE = 'TashiSupplierBundle:Supplier:cim_customer_address_list.html.twig';
    const TWIG_CMN_SUP_BANKFORM = 'TashiSupplierBundle:Supplier:sup_bankform.html.twig';
    const TWIG_CMN_SUP_MOBILE_FORM = 'TashiSupplierBundle:Supplier:sup_mobileform.html.twig';
    
    //transport twig
    const TWIG_Transport = 'TashiSupplierBundle:Supplier:transport.html.twig';
    const TWIG_Display_Transport = 'TashiSupplierBundle:Supplier:displaytransport.html.twig';
    const TWIG_MobileTransport = 'TashiSupplierBundle:Supplier:tranport_mobile_list.html.twig';
    const TWIG_COM_HISTORY = 'TashiSupplierBundle:Supplier:com_communicationhistory.html.twig';
    
    const ENT_COMMONDOCUMENT='TashiCommonBundle:CmnDocumentMaster';
    const ENT_STOCK_SUPPLIER_MASTER='TashiCommonBundle:SupplierMaster';
    const ENT_STOCK_SUPPLIER_COMMON_ADDRESS_MASTER='TashiCommonBundle:CmnLocationAddressMaster';
    const ENT_STOCK_SUPPLIER_ADDRESS_MASTER_TXN='TashiCommonBundle:SupplierAddressTxn';
    const ENT_STOCK_SUPPLIER_COMMON_PERSON_ADDRESS='TashiCommonBundle:CmnPerson';
    const ENT_STOCK_SUPPLIER_CONTACT_TXN='TashiCommonBundle:SupplierContactTxn';
    const ENT_STOCK_SUPPLIER_CONTACT='TashiCommonBundle:CmnMobileNoMaster';
    //const ENT_STOCK_SUPPLIER_Account_Type='TashiCommonBundle:CmnMobileNoMaster';
    const ENT_STOCK_SUPPLIER_MOBILE_TXN='TashiCommonBundle:SupplierContactMobileNoTxn';
    const ENT_STOCK_SUPPLIER_BANK_TXN='TashiCommonBundle:SupplierBankTxn'; 
    const ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER='TashiCommonBundle:CmnBankDetailsMaster';
    const ENT_STOCK_COMMON_BANK_ACCOUNTTYPE='TashiCommonBundle:CmnBankAccountType';
    const ENT_SUP_TRANSPORT='TashiCommonBundle:TransporterMaster';
    
    //displaying result for supplier
    const TWIG_STOCK_DISPLAYING_RESULT = 'TashiSupplierBundle:Supplier:displaySupplier.html.twig';
    //ends here
    
    
    const ENT_COUNTRY_MASTER='TashiCommonBundle:CmnLocationCountryMaster';
    const ENT_STATE_MASTER='TashiCommonBundle:CmnLocationStateMaster';
    const ENT_DISTRICT_MASTER='TashiCommonBundle:CmnLocationDistrictMaster';
    const ENT_CITY_MASTER='TashiCommonBundle:CmnLocationCityMaster';
    const ENT_ADDRESSTYPE_MASTER='TashiCommonBundle:CmnLocationAddressTypeMaster';
    const ENT_SUP_Pro_Category_Txn='TashiCommonBundle:SupplierProductCategoryTxn';
    const ENT_TransportMobileTxn ='TashiCommonBundle:TransporterMobileTxn';
    //supplier twig constant ends here
    
    
    
  
}



