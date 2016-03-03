<?php
namespace Tashi\CompanyBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompanyBundle
 *
 * @author Administrator
 */
class CompanyConstant {
    
    
    //SERVICE CONSTANT
    
    const SERVICE_COMPANY='tashi.company.service';
    //////// Fix Project Path for supplier////////
    const PROJECT_PATH = '/Tashi/web/app_dev.php/company/';
    //TWIG CONSTANT for supplier module
    const TWIG_COMPANY_DASHBOARD = 'TashiCompanyBundle:Company:companyDashboard.html.twig';
    const TWIG_COMPANY_INFO = 'TashiCompanyBundle:Company:newCompany.html.twig';
//    const TWIG_DISPLAY_COMPANY = 'TashiCompanyBundle:Company:displayCompany.html.twig';
    const TWIG_COMPANY_LOCATION = 'TashiCompanyBundle:Company:CompanyLocationLoadList.html.twig';
    const TWIG_COMPANY_MOBILE_DISPLAY = 'TashiCompanyBundle:Company:displayCompanyMobile.html.twig';
    const TWIG_COMPANY_MOBILE = 'TashiCompanyBundle:Company:companyMobileNo.html.twig';
    const TWIG_COMPANY_EMAIL = 'TashiCompanyBundle:Company:companyEmail.html.twig';
    const TWIG_COMPANY_EMAIL_DISPLAY = 'TashiCompanyBundle:Company:displayCompanyEmail.html.twig';
    const TWIG_COMPANY_TELEPHONE_NO = 'TashiCompanyBundle:Company:companyTelephoneNo.html.twig';
    const TWIG_COMPANY_TELEPHONE_NO_DISPLAY = 'TashiCompanyBundle:Company:displayCompanyTelephoneNo.html.twig';
    const TWIG_COMPANY_FAX_NO = 'TashiCompanyBundle:Company:companyFaxNo.html.twig';
    const TWIG_COMPANY_FAX_NO_DISPLAY = 'TashiCompanyBundle:Company:displayCompanyFaxNo.html.twig';
//    const TWIG_COMPANY_MASTER = 'TashiCompanyBundle:Company:MasterCompany.html.twig';
//    const TWIG_COMPANY_ADDRESS = 'TashiCompanyBundle:Company:addCompanyAddress.html.twig';
//    const TWIG_CMN_COMPANY_ADDFORM = 'TashiCompanyBundle:Company:cim_addressForm.html.twig';
//    const TWIG_COMPANY_ADDRESS_ATTRIBUTE = 'TashiCompanyBundle:Company:cim_customer_address_list.html.twig';
//    const TWIG_COMPANY_MOBILE = 'TashiCompanyBundle:Company:addSuppliermobile.html.twig';
//    const TWIG_COMPANY_MOBILE_FORM = 'TashiCompanyBundle:Company:sup_mobileform.html.twig';
//    const TWIG_COMPANY_DISPLAY_MOBILE = 'TashiCompanyBundle:Company:displaymobile.html.twig';
//    const TWIG_COMPANY_MOBILE_LIST = 'TashiCompanyBundle:Company:Sup_mobile_list.html.twig';
//    const TWIG_COMPANY_SEARCH='TashiCompanyBundle:Company:cim_search.html.twig';
//    const TWIG_SEARCH_RESULT='TashiCompanyBundle:Company:customerSearchResult.html.twig';
    //Entity section
    
    
    const ENT_COMPANY_ADDRESS_MASTER_TXN='TashiCommonBundle:ShippingAddressTxn';
    const ENT_COMPANY_MASTER='TashiCommonBundle:CompanyMaster';
    const ENT_COMPANY_CONTACT_TXN='TashiCommonBundle:ShippingContactTxn';
    const ENT_COMPANY_MOBILE_TXN='TashiCommonBundle:ShippingContactMobileNoTxn';
    const ENT_COMPANY_COMMON_PERSON_ADDRESS='TashiCommonBundle:CmnPerson';
    const ENT_COMMON_CONTACT='TashiCommonBundle:CmnMobileNoMaster';
    
    
    
    
    
    
    
    
    
    
    
    const TWIG_STOCK_SUPPLIER_MOBILE_LIST = 'TashiStockBundle:Supplier:Sup_mobile_list.html.twig';
    
    const TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST = 'TashiStockBundle:Supplier:displaybank.html.twig';
    const TWIG_STOCK_SEARCH_SUPPLIER = 'TashiStockBundle:Supplier:SearchSupplier.html.twig';
    
    const TWIG_STOCK_SUPPLIER_ADDRESS = 'TashiStockBundle:Supplier:addSupplierAddress.html.twig';
   
   
    const TWIG_STOCK_SUPPIER_BANK_DETAILS = 'TashiStockBundle:Supplier:MasterSupplierBankDetail.html.twig';
    
    //from erp
    const TWIG_CMN_SUP_ADDFORM = 'TashiStockBundle:Supplier:cim_addressForm.html.twig';
    
    
    const TWIG_SUP_ADDRESS_ATTRIBUTE = 'TashiStockBundle:Supplier:cim_customer_address_list.html.twig';
    const TWIG_CMN_SUP_BANKFORM = 'TashiStockBundle:Supplier:sup_bankform.html.twig';
    
    
    
    
   
    const ENT_STOCK_SUPPLIER_COMMON_ADDRESS_MASTER='TashiCommonBundle:CmnLocationAddressMaster';
   
    
    
    
    //const ENT_STOCK_SUPPLIER_Account_Type='TashiCommonBundle:CmnMobileNoMaster';
    
    const ENT_STOCK_SUPPLIER_BANK_TXN='TashiCommonBundle:SupplierBankTxn'; 
    const ENT_STOCK_SUPPLIER_BANKDETAIL_MASTER='TashiCommonBundle:CmnBankDetailsMaster';
    const ENT_STOCK_COMMON_BANK_ACCOUNTTYPE='TashiCommonBundle:CmnBankAccountType';
    
    
    //displaying result for supplier
    const TWIG_STOCK_DISPLAYING_RESULT = 'TashiStockBundle:Supplier:displaySupplier.html.twig';
    //ends here
    
    
    const ENT_COUNTRY_MASTER='TashiCommonBundle:CmnLocationCountryMaster';
    const ENT_STATE_MASTER='TashiCommonBundle:CmnLocationStateMaster';
    const ENT_DISTRICT_MASTER='TashiCommonBundle:CmnLocationDistrictMaster';
    const ENT_CITY_MASTER='TashiCommonBundle:CmnLocationCityMaster';
    const ENT_ADDRESSTYPE_MASTER='TashiCommonBundle:CmnLocationAddressTypeMaster';
    
    //supplier twig constant ends here
    
    
    
    
    
    
    /////////////////////////////
    /////   CATEGORY ////////////
    ///////////////////////////
    const TWIG_PROD_CATE_MASTER='TashiStockBundle:Product:Cat_Category.html.twig';
    const TWIG_PRODUCT_CAT_LIST='TashiStockBundle:Product:Cat_NewCatList.html.twig';
    const TWIG_CATEGORY_SAVEEDIT='TashiStockBundle:Product:Cat_EditPage.html.twig';
    const TWIG_NEW_CATEGORY='TashiStockBundle:Product:Cat_AddNewCategory.html.twig';
    const TWIG_NEW_SUB_CATEGORY='TashiStockBundle:Product:Cat_SubCategory.html.twig';
    const TWIG_NEW_SUB_CATEGORY_ENTRY='TashiStockBundle:Product:Cat_NewSubCategory.html.twig';
    const TWIG_SHOW_PRODUCT_SUBCAT_LIST = 'TashiStockBundle:Product:Cat_SubCatList_append.html.twig';
    const TWIG_ADD_PRODUCT_SUBCAT_APPEND = 'TashiStockBundle:Product:Cat_AddSubCat_apppend.html.twig';   
    const TWIG_SUBCATEGORY_APPEND = 'TashiStockBundle:Product:Cat_SubCategoryAppend.html.twig';
    const TWIG_ASSIGN_ATTR_LIST = 'TashiStockBundle:Product:Cat_Assign_AttrList.html.twig';
    const TWIG_ATTRIBUTE_APPEND_FOR_ASSIGNMENT= 'TashiStockBundle:Product:Cat_AttributeAppendForAssignment.html.twig';
    const TWIG_CATEGORY_ATTR_ASSIGNMENT = 'TashiStockBundle:Product:Cat_AssignCategoryAttr.html.twig';
    
    /////////////////////////////
    /////   ATTRIBUTE ////////////
    ///////////////////////////
    const TWIG_PRODUCT_ATTRIBUTE = 'TashiStockBundle:Product:Attr_AttributeMaster.html.twig';
    const TWIG_PRD_ATTR_LIST_APPEND='TashiStockBundle:Product:Attr_AttributeMasterList.html.twig';
    const TWIG_EDIT_ATTRIBUTE = 'TashiStockBundle:Product:Attr_EditAttributeMaster.html.twig';    
    const TWIG_ATTRIBUTE_APPEND='TashiStockBundle:Product:AttributeAppend.html.twig';
    
    /////////////////////////////
    /////   UNIT ////////////
    ///////////////////////////
    const TWIG_UNIT_MASTER = 'TashiStockBundle:Product:Unit_UnitMaster.html.twig';
    const TWIG_UNIT_MASTER_LIST='TashiStockBundle:Product:Unit_UnitMasterList.html.twig';
    const TWIG_UNIT_UPDATE='TashiStockBundle:Product:Unit_UnitMasterUpdate.html.twig';
    const TWIG_ASSIGN_ATTR_UNIT = 'TashiStockBundle:Product:Unit_AssignAttrUnit.html.twig';
    const TWIG_APPEND_ROW='TashiStockBundle:Product:Unit_UnitAppendRow.html.twig';
    const TWIG_PRD_ADD_SEL_UNIT = 'TashiStockBundle:Product:Unit_AttrUnit_toBeAdded.html.twig';
    
    /////////////////////////////
    /////   PRODUCT ////////////
    ///////////////////////////
    const TWIG_PRD_HOME = 'TashiStockBundle:Product:Prd_Home.html.twig';
    const TWIG_PRD_SUBCAT_APPEND = 'TashiStockBundle:Product:Prd_SubCatAppend.html.twig';
    const TWIG_PRD_PRODLIST_APPEND = 'TashiStockBundle:Product:Prd_ProductListAppend.html.twig';
    const TWIG_PRD_EDIT_SUBCAT_APPEND= 'TashiStockBundle:Product:Prd_Edit_SubCatAppend.html.twig';
    const TWIG_PRD_CREATE_NEW_PROD = 'TashiStockBundle:Product:Prd_CreateNewProduct.html.twig';
    const TWIG_PRD_SHOW_ATTR_UNIT = 'TashiStockBundle:Product:Prd_Product_Attr_Value.html.twig';
    const TWIG_PRD_EDIT_SHOW_ATTR_UNIT = 'TashiStockBundle:Product:Prd_AttrValueEdit.html.twig';
    const TWIG_PRD_SEARCH_APPROVAL='TashiStockBundle:Product:Prd_SearchProdForApproval.html.twig';
    const TWIG_PRD_APPROVE_PRODUCT='TashiStockBundle:Product:Prd_ApproveProduct.html.twig';
    const TWIG_PRD_SUB_CAT_APPEND_SEARCH='TashiStockBundle:Product:Prd_SubCatAppendForSearch.html.twig';
    const TWIG_PRD_SEARCH_PRODUCT='TashiStockBundle:Product:Prd_SearchProduct.html.twig';
    const TWIG_PRD_SEARCH_RESULT='TashiStockBundle:Product:Prd_SearchResult.html.twig';
    
 
}



