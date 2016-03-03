<?php

namespace Tashi\CommonBundle\Helper;

/**
 * Description of CommonConstant
 *
 * @author 5066
 */
class CommonConstant 
{       
    
    ///////////// Fix Project Path////////
    const RECEIPT_NO='K';

    /*   Twig Constant   */
    /* USER MANAGEMENT */
    const TWIG_USER_MANAGEMENT_PAGE = 'TashiConfigurationBundle:UserManagement:userManagement.html.twig';
    const TWIG_USER_SEARCH_USER = 'TashiConfigurationBundle:UserManagement:user_search_user.html.twig';
    const TWIG_USER_SEARCH_USER_BY_USER_ID = 'TashiConfigurationBundle:UserManagement:user_search_user_by_user_ids.html.twig';
    const TWIG_USER_CREATE_USER_FORM = 'TashiConfigurationBundle:UserManagement:user_create_new_user_form.html.twig';
    const TWIG_USER_CREATE_USER = 'TashiConfigurationBundle:UserManagement:user_create_user.html.twig';
   
    /*common entity*/
     const SMS_MASTER='TashiCommonBundle:SmsMaster';
    
    
    /*common entity*/
    const ENTITY_ERP_CMN_SEARCH_PARAM = 'TashiCommonBundle:CmnSearchParam';
    const PAYMENT_MASTER = 'TashiCommonBundle:CmnPaymentMaster';
    const PAYMENT_MODE_MASTER = 'TashiCommonBundle:CmnPaymentModeMaster';
    const SALES_PAYMENT_COLLETION = 'TashiCommonBundle:SalPaymentCollectionTxn';
    const SALES_PAYMENT_MODE_TXN = 'TashiCommonBundle:SalModeOfPaymentTxn';
    const SMS_PAYMENT_COLLETION = 'TashiCommonBundle:SmsOrdPaymentProductTxn';
    const SMS_PAYMENT_AMOUNT = 'TashiCommonBundle:SmsOrderPaymentAmount';
    const ENT_CMN_BANK_ACC_TYPE = 'TashiCommonBundle:CmnBankAccountType';
    const ENT_CMN_BANK_MASTER = 'TashiCommonBundle:CmnBankDetailsMaster';
    const ENT_CMN_CASHACCOUNT_MASTER = 'TashiCommonBundle:AccountCashCurrentBalance';
    const ENT_CMN_PAYMENT_MODE_MASTER = 'TashiCommonBundle:CmnPaymentModeMaster';
    const ENT_CMN_MONTH = 'TashiCommonBundle:CmnMonth'; 
    const ENT_CMN_DOCUMENT_MASTER='TashiCommonBundle:CmnDocumentMaster';
    const ENT_BANK_ACC_TYPE='TashiCommonBundle:CmnBankAccountType';
    
    /* customer entity */
    const ENTITY_ERP_CIM_CUSTOMERTYPE = 'TashiCommonBundle:CusTypeMaster';
    const CUSTOMER_ADD_RELATION='TashiCommonBundle:CusAddressTxn';
    const CUSTOMER_DETAIL='TashiCommonBundle:CusCustomer';
    const CUSTOMER_ADDRESS_MASTER='TashiCommonBundle:CusAddressTxn';
    const CUSTOMER_TYPE_MASTER='TashiCommonBundle:CusTypeMaster';
    const CUSTOMER_ADVANCE_PAYMENT = 'TashiCommonBundle:CusAdvancePayment';
    const CUSTOMER_ADVANCE_PAYMENT_RECEIPT = 'TashiCommonBundle:CusAdvancePaymentReceipt';
    
    
    //Contact Person and Mobile Entity
    const ENT_CONTACT_PERSON_MASTER='TashiCommonBundle:CmnPerson';
    const ENT_CONTACT_TXT='TashiCommonBundle:CusContactTxn';
    const ENT_MOBILE_MASTER='TashiCommonBundle:CmnMobileNoMaster';
    const ENT_MOBILE_CONTACT_TXN='TashiCommonBundle:CusContactMobileNoTxn';
    
    //EMPLOYEE
    const ENT_EMP_BANK_TXN='TashiCommonBundle:EmpBankTxn';
    
    /* STOCK entity */
    const ENTITY_ERP_STOCK_MASTER = 'TashiCommonBundle:StockMaster';
    
   
    
    

    const ENT_EMPLOYEE_MASTER='TashiCommonBundle:EmpEmployeeMaster';
    const ENT_EMPLOYEE_STATUS_MASTER='TashiCommonBundle:EmpStatusMaster';
    const ENT_EMPOYMENT_TYPE='TashiCommonBundle:EmpEmploymentType';
    const ENTITY_HR_TYPE_OF_EMPLOYEE = 'TashiCommonBundle:HrTypeOfEmployee';
    const ENTITY_CMN_USER = 'TashiCommonBundle:TbCmnUser';
    const ENTITY_LMS_CMN_COMMITTEE_USER = 'TashiCommonBundle:TbCmnCommitteeUser';
    const ENTITY_LMS_CMN_ALLOCATION_COMMITTEE = 'TashiCommonBundle:TbCmnAllocationCommittee';
    //Product Entity
    const ENT_PRODUCT_TABLE = 'TashiCommonBundle:PrdProductMaster';
    const ENTITY_ERP_PROD_PRICE = 'TashiCommonBundle:PrdProductPriceTxn';
    const ENTITY_ERP_PROD_CAT_MASTER = 'TashiCommonBundle:PrdProductCategoryMaster';
    const ENTITY_ERP_PROD_CAT_LEVEL_MASTER = 'TashiCommonBundle:CmnLevelMaster';
    const ENTITY_ERP_PROD_ATTR_MASTER = 'TashiCommonBundle:PrdProductAttributeMaster';
    const ENTITY_ERP_PROD_UNIT_MASTER = 'TashiCommonBundle:PrdProductUnitMaster';
    const ENTITY_ERP_PROD_CAT_ATTR_TXN= 'TashiCommonBundle:PrdProductCategoryAttributeTxn';
    const ENTITY_ERP_PROD_ATTR_UNIT_TXN= 'TashiCommonBundle:PrdProductAttributeUnitTxn';
    const ENTITY_ERP_PROD_ATTR_UNIT_VALUE_TXN= 'TashiCommonBundle:PrdProductAttributeValueTxn';
    const ENTITY_PROD_UNIT_TXN='TashiCommonBundle:ProductUnitTxn';  
    const ENT_PRD_SERVICES='TashiCommonBundle:PrdServiceTxn';
    const ENT_SUPPLIER_PRODUCT_TXN='TashiCommonBundle:SupplierProductTxn';
    //Order Entity
    const ENT_ORD_MASTER_TABLE = 'TashiCommonBundle:OrdOrderMaster';
    const ENT_ORD_PRODUCT_TABLE = 'TashiCommonBundle:OrdOrderProductTxn';
    const ORD_STATUS_MASTER='TashiCommonBundle:OrdStatusMaster';
    const ORD_STATUS_TXN='TashiCommonBundle:OrdOrderStatusTxn';
    //Store Entity
    const ENT_ADD_STORE = 'TashiCommonBundle:StoreMaster';
    const ENT_ADD_STORE_BUILDING ='TashiCommonBundle:StoreBuildingMaster';
    const ENT_BUILDING_FLOOR ='TashiCommonBundle:StoreFloorMaster';
    const ENT_BUILDING_ROOM ='TashiCommonBundle:StoreRoomMaster';
    const ENT_BUILDING_RACK ='TashiCommonBundle:StoreRackMaster';
    const ENT_BIN_MASTER ='TashiCommonBundle:StoreBinMaster';
    
    
    
    //Address Entity
    const ENT_ADD_MASTER = 'TashiCommonBundle:CmnLocationAddressMaster';
    const ENT_ADDTYPE_MASTER = 'TashiCommonBundle:CmnLocationAddressTypeMaster';
    const ENT_STATE_MASTER = 'TashiCommonBundle:CmnLocationStateMaster';
    const ENT_DISTRICT_MASTER = 'TashiCommonBundle:CmnLocationDistrictMaster';
    const ENT_COUNTRY_MASTER = 'TashiCommonBundle:CmnLocationCountryMaster';
    const ENT_CITY_MASTER = 'TashiCommonBundle:CmnLocationCityMaster';
    const ENT_CUS_ADD_TXN = 'TashiCommonBundle:CusAddressTxn';
    const ENT_EMPPLOYEE_ADDRESS_TXN = 'TashiCommonBundle:EmpAddressTxn';
    const ENT_BRANCH_OFFICE = 'TashiCommonBundle:BranchMaster';
    const ENT_BRANCH_OFFICE_ADDRESS_TXN = 'TashiCommonBundle:BranchAddressTxn';
    
    /*  PURCHASE ORDER  */
    const ENT_PO_MASTER='TashiCommonBundle:PoMaster';
    const ENT_PO_PRODUCTS='TashiCommonBundle:PoProductDetails';
    /*   TAX    */
    const ENT_TAX_MASTER = 'TashiCommonBundle:TaxMaster';
    
    /*      STOCK   */
    const ENT_STOCK_MASTER='TashiCommonBundle:StockMaster';
    const ENT_STOCK_TAX_TXN='TashiCommonBundle:StockTaxTxn';
    
    /*   CMS String Constant   */
    const COBIGENT = 'cobigent';
    
    /* Service Common  */ 
     const SERVICE_COMMON = 'tashi.common.service';
     const SERVICE_USER_MANAGEMENT = 'erp.service.user';
     const SERVICE_SYSTEM_CONFIGURATION = 'erp.service.SystemConfiguration';
     
     const GENERAL_EXCEPTION = 'Request cannot be process right now!';
     const SUCCESS_INFORMATION = 'Record inserted successfully!!!';
     
         /* USER MANAGEMENT */
    const USER_STS_APPROVED = 1;
    const USER_STS_REJECTED = 2;
    const USER_STS_CREATED = 3;
    
    /*      PROJECT        */
    const ENT_PROJ_ADV_PAYMENT='TashiCommonBundle:ProjectAdvancePayment';
    const ENT_PROJ_CONTACT='TashiCommonBundle:ProjectContactDetails';
    const ENT_PROJ_DAILY_RPT='TashiCommonBundle:ProjectDailyReport';
    const ENT_PROJ_ITEM_STATUS_MASTER='TashiCommonBundle:ProjectItemStatusMaster';    
    const ENT_PROJ_ITEM_STATUS_TXN='TashiCommonBundle:ProjectItemStatusTxn';    
    const ENT_PROJ_ITEM_TXN='TashiCommonBundle:ProjectItemTxn';    
    const ENT_PROJ_ITEM_WORKER_TXN='TashiCommonBundle:ProjectItemWorkerTxn';
    const ENT_PROJ_MASTER='TashiCommonBundle:ProjectMaster';
    const ENT_PROJ_PROD_STATUS_MASTER='TashiCommonBundle:ProjectProductStatusMaster';
    const ENT_PROJ_PRODUCT_STATUS_TXN='TashiCommonBundle:ProjectProductStatusTxn';
    const ENT_PROJ_STATUS_MASTER='TashiCommonBundle:ProjectStatusMaster';
    const ENT_PROJ_STATUS_TXN='TashiCommonBundle:ProjectStatusTxn';    
    const ENT_PROJ_EXPENSE='TashiCommonBundle:ProjectExpenses';
    const ENT_PROJ_DOCUMENT='TashiCommonBundle:ProjectDocumentTxn';
    const ENT_PROJ_AREA_MASTER='TashiCommonBundle:ProjectAreaMaster';
    const ENT_PROJ_PROD_CAT_TXN='TashiCommonBundle:ProjectAreaProdCategoryTxn';
    const ENT_INDUSTRY_TYPE_MASTER='TashiCommonBundle:IndustryTypeMaster';
    const ENT_OPPORTUNITY_TYPE_MASTER='TashiCommonBundle:OpportunityTypeMaster';    
    const ENT_PROJ_MODIFICATION_LOG='TashiCommonBundle:ProjectModificationLog';    
    const ENT_PROJ_NOTIFICATION='TashiCommonBundle:ProjectNotification';    
    /*   INVOICE  */
    const ENT_INVOICE_MASTER='TashiCommonBundle:InvoiceMaster';
    const ENT_INVOICE_ITEM_TXN='TashiCommonBundle:InvoiceItemTxn';
    const ENT_INVOICE_PAY_TERM='TashiCommonBundle:InvoicePaymentTerms';
    const ENT_INVOICE_PAYMENT_TXN='TashiCommonBundle:InvoicePaymentTxn';
    
    /*COMPANY*/
    const ENT_COMPANY_MASTER='TashiCommonBundle:CompanyMaster';
    const ENT_COMPANY_MOBILE='TashiCommonBundle:CompanyContactTxn';
    const ENT_COMPANY_ADDRESS_TXN='TashiCommonBundle:CompanyAddressTxn';
    const ENT_COMPANY_PHONE='TashiCommonBundle:CompanyPhoneTxn';    
    const ENT_COMPANY_EMAIL='TashiCommonBundle:CompanyEmailTxn';
    const ENT_COMPANY_FAX='TashiCommonBundle:CompanyFaxnoTxn';
    /*SYSTEM SETTING*/
    const ENT_ACTIVITY_MASTER='TashiCommonBundle:SystemActivityMaster';
    const ENT_CONTROLLER_MASTER='TashiCommonBundle:SystemControllerMaster';
    const ENT_MODULE_MASTER='TashiCommonBundle:SystemModuleMaster';
    
    /*USER*/
    const ENT_GROUP_MASTER='TashiCommonBundle:UserGroupMaster';
    const ENT_USER_GROUP_TXN='TashiCommonBundle:UserGroupTxn';
    const ENT_GROUP_ACTIVITY_TXN='TashiCommonBundle:SystemGroupActivityTxn';
    const ENT_USER_TABLE='TashiCommonBundle:UserTbl';
    const ENT_USER_STATUS_MASTER='TashiCommonBundle:UserStatusMaster';
    const ENT_USER_STATUS_TXN='TashiCommonBundle:UserStatusTxn';
    const ENT_ACTIVITY_LOG='TashiCommonBundle:UserActivityLog';
    
    const ENT_TRANSACTION_DATE='TashiCommonBundle:TransactionDate';
    
    /*TWIG ACCESS DENIED*/
    const TWIG_AUTH_ACCESS_DENIED='TashiCommonBundle:Default:AccessDenied.html.twig';
    
    /*COMMON ERROR MESSAGE*/
    const ERR_DATA_RETRIEVAL='Sorry! Something went wrong while retreiving data.';
    const ERR_DB_OPERATION='Something went wrong while performing database operation.';
    const ERR_UNKNOWN='An unknown error was encountered while processing your request. Please try again later or contact your application vendor';
    const ERR_EMAIL_SENDING='Sorry! The Email count not be sent.Please check your internet connectivity.';
}
