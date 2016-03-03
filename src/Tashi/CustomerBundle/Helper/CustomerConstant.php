<?php

/**
 * Module Name :
 * Purpose or objective of the  page :This class is defined all the string contants and configurable across the
 * application
 * Created By :
 * Created Date :
 * Last Modified Date :
 * Last Modified By :
 * Test Carried Out :
 * Test Carried By :
 * Version :
 */
namespace Tashi\CustomerBundle\Helper;                                         // package declaration 

class CustomerConstant {
    /**service Constant*/
    const SERVICE_CUSTOMER = 'tashi.customer.service';
    
    /* Twig Constant file */
    const TWIG_CUS_DASHBOARD='TashiCustomerBundle:Customer:customerDashboard.html.twig';
    const TWIG_NEW_CUSTOMER = 'TashiCustomerBundle:Customer:addnewcustomer.html.twig'; 
    const TWIG_NEW_CUST_DETAIL='TashiCustomerBundle:Customer:newCustomerDetails.html.twig';
    const TWIG_CUST_MASTER_PROJECT='TashiCustomerBundle:Customer:customerMasterProjectService.html.twig';
    const TWIG_CUST_NEW_ADDRESS='TashiCustomerBundle:Employee:newCustomerAddress.html.twig';
    const TWIG_CUST_ADVANCE_PAYMENT='TashiCustomerBundle:Customer:cus_advance_payment.html.twig';
    const TWIG_CUST_APPROVE_ADVANCE_PAYMENT='TashiCustomerBundle:Customer:cus_advance_payment_approve.html.twig';
    const TWIG_CUST_APPROVE_ADVANCE_PAYMENT_BY_HOD='TashiCustomerBundle:Customer:cus_advance_hod_approve.html.twig';
    const TWIG_CUST_APPROVE_ADVANCE_PAYMENT_AJAX='TashiCustomerBundle:Customer:cus_advance_payment_approve_ajax.html.twig';
    const TWIG_CUST_ADVANCE_PAY_PAYMENT='TashiCustomerBundle:Customer:cus_advance_payment_pay.html.twig';
    
    /*ENTITY CONSTANT*/
    const CUSTOMER_ADVANCE_PAYMENT_RECIEPT = 'TashiCommonBundle:CusAdvancePaymentReceipt';
    /*********************ERP***********************/
  /* Twig Constant file */
    const TWIG_HOME_PAGE = 'TashiCustomerBundle:Customer:cim_home.html.twig';  
    const TWIG_CIM_SEARCH = 'TashiCustomerBundle:Customer:cim_search.html.twig';
    const TWIG_CIM_CREATE_CUSTOMER = 'TashiCustomerBundle:Customer:cim_create_customer.html.twig';
    const TWIG_CIM_APPRV_CUSTOMER_FORM = 'TashiCustomerBundle:Customer:loadCustomerApprv_form.html.twig';
    const TWIG_CIM_CUS_CHNGE_ATTR_FORM = 'TashiCustomerBundle:Customer:cus_changeAttr_form.html.twig';
    const TWIG_CIM_CUS_APPRV_ADDR_FORM = 'TashiCustomerBundle:Customer:cim_approve_chngeAddr_form.html.twig';
    const TWIG_CIM_CUS_COMM_SEARCH_FORM = 'TashiCustomerBundle:Customer:cim_cusCommunication_Searchform.html.twig';
    const TWIG_CIM_CUS_SEARCH_RESULT = 'TashiCustomerBundle:Customer:customerSearchResult.html.twig';
    const TWIG_CIM_CUS_LIKE_SEARCH_LIST = 'TashiCustomerBundle:Customer:cim_customer_like_search_list.html.twig';
    
    const TWIG_CIM_CUS_DETAIL_VIEW = 'TashiCustomerBundle:Customer:cim_cusDetailView.html.twig';   
    const TWIG_CIM_CUS_CAPTUREALL_VIEW = 'TashiCustomerBundle:Customer:cim_captureAll_cusDetail.html.twig';
    const TWIG_CIM_CUS_ADDFORM = 'TashiCustomerBundle:Customer:cim_addressForm.html.twig';
    const TWIG_CIM_STATE_LIST = 'TashiCustomerBundle:Customer:cim_state_list.html.twig';
    const TWIG_CIM_CITY_LIST = 'TashiCustomerBundle:Customer:cim_city_list.html.twig';
    const TWIG_CUSTOMER_DISTRICT_LIST = 'TashiCustomerBundle:Customer:cim_load_district_list.html.twig';
    const TWIG_CUSTOMER_ADDRESS_ATTRIBUTE = 'TashiCustomerBundle:Customer:cim_customer_address_list.html.twig';
    
    const TWIG_CUSTOMER_CONTACT = 'TashiCustomerBundle:Customer:customer_contact.html.twig';
    const TWIG_CIM_FORM_CONTACT_DETAILS = 'TashiCustomerBundle:Customer:cim_form_Contact_Details.html.twig';
    const TWIG_CIM_LOAD_CONTACT_DETAILS = 'TashiCustomerBundle:Customer:cim_load_Contact_Details.html.twig';
    const TWIG_COM_CUST_SEARCH_INDEX = 'TashiCustomerBundle:Customer:com_searchcustomer.html.twig';
    const TWIG_COM_CUST_SEARCH_RESULT = 'TashiCustomerBundle:Customer:com_custsearchresult.html.twig';
    const TWIG_COM_SMS_TEMPLATE = 'TashiCustomerBundle:Customer:com_smstemplate.html.twig';
    const TWIG_COM_COMM_HISTORY = 'TashiCustomerBundle:Customer:com_communicationhistory.html.twig';
    const TWIG_COM_SEND_EMAIL = 'TashiCustomerBundle:Customer:com_sendemail.html.twig';
          
    const TWIG_CUS_ADVANCE_PAYMENT_FORM = 'TashiCustomerBundle:Customer:cus_advance_payment_form.html.twig';
    const TWIG_CUS_ADVANCE_PAYMENT_LOAD_ACCOUNT = 'TashiCustomerBundle:Customer:cus_advance_payment_load_account.html.twig';
    const TWIG_CUS_ADVANCE_PAYMENT_HISTORY = 'TashiCustomerBundle:Customer:cus_advance_payment_history.html.twig';
    const TWIG_CUS_OUTSTANDING_BILL='TashiCustomerBundle:Customer:OutstandingBill.html.twig';
    const TWIG_CUS_ADVANCE_LOAD_LIST = 'TashiCustomerBundle:Customer:cus_advance_payment_load_list.html.twig';
    const TWIG_CUS_ADVANCE_PAYMENT_RECEIPT = 'TashiCustomerBundle:Customer:cus_advance_payment_receipt.html.twig';
    const TWIG_RECEIPT = 'TashiCustomerBundle:Customer:receiptTemplate.html.twig';
    const TWIG_CUS_ADVANCE_LOAD_ACCOUNT_SOURCE_LIST = 'TashiCustomerBundle:Customer:cus_advance_load_account_source_list.html.twig';
    const TWIG_CUS_ADVANCE_REVENUE_REPORT = 'TashiCustomerBundle:Customer:cus_advance_revenue_report.html.twig';
    const TWIG_CUS_ADVANCE_REVENUE_REPORT_SEARCH_RESULT = 'TashiCustomerBundle:Customer:cus_advance_revenue_report_search_result.html.twig';
    
    
}