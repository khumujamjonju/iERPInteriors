<?php
namespace Tashi\StockBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StockConstant
 *
 * @author Administrator
 */
class StockConstant {
    
    
    //SERVICE CONSTANT
    const SERVICE_STOCK='tashi.stock.service';
    /*const SERVICE_PRODUCT='tashi.product.service';*/
    const SERVICE_SUPPLIER='tashi.supplier.service';
    //////// Fix Project Path for supplier////////
    const PROJECT_PATH = '/Tashi/web/app_dev.php/stock/';
    
    //TWIG CONSTANT for supplier module
    const TWIG_STOCK_DASHBOARD = 'TashiStockBundle:Stock:stockDashboard.html.twig';
    const TWIG_STOCK_SUPPLIER_MOBILE_LIST = 'TashiStockBundle:Supplier:Sup_mobile_list.html.twig';
    const TWIG_STOCK_DISPLAY_SUPPLIER_MOBILE_LIST = 'TashiStockBundle:Supplier:displaymobile.html.twig';
    const TWIG_STOCK_DISPLAY_SUPPLIER_BANK_DETAILS_LIST = 'TashiStockBundle:Supplier:displaybank.html.twig';
    const TWIG_STOCK_SEARCH_SUPPLIER = 'TashiStockBundle:Supplier:SearchSupplier.html.twig';
    const TWIG_STOCK_SUPPLIER_MOBILE = 'TashiStockBundle:Supplier:addSuppliermobile.html.twig';
    const TWIG_STOCK_SUPPLIER_ADDRESS = 'TashiStockBundle:Supplier:addSupplierAddress.html.twig';
    const TWIG_STOCK_DASH_MASTER_SUPPLIER = 'TashiStockBundle:Supplier:newSupplier.html.twig';
    const TWIG_STOCK_MASTER_SUPPLIER = 'TashiStockBundle:Supplier:MasterSupplier.html.twig';
    const TWIG_STOCK_SUPPIER_BANK_DETAILS = 'TashiStockBundle:Supplier:MasterSupplierBankDetail.html.twig';
    
    //from erp
    const TWIG_CMN_SUP_ADDFORM = 'TashiStockBundle:Supplier:cim_addressForm.html.twig';
    const TWIG_CIM_CUS_SEARCH='TashiStockBundle:Supplier:cim_search.html.twig';
    const TWIG_CIM_CUS_SEARCH_RESULT='TashiStockBundle:Supplier:customerSearchResult.html.twig';
    const TWIG_SUP_ADDRESS_ATTRIBUTE = 'TashiStockBundle:Supplier:cim_customer_address_list.html.twig';
    const TWIG_CMN_SUP_BANKFORM = 'TashiStockBundle:Supplier:sup_bankform.html.twig';
    const TWIG_CMN_SUP_MOBILE_FORM = 'TashiStockBundle:Supplier:sup_mobileform.html.twig';
    
    
    
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
    
    /////////////////////////////
    /////   STOCK ////////////
    ///////////////////////////
    const TWIG_STOCK_ENTRY='TashiStockBundle:Stock:StockEntry.html.twig';
    const TWIG_APPEND_BLDG='TashiStockBundle:Stock:AppendBuilding.html.twig';
    const TWIG_APPEND_FLOOR='TashiStockBundle:Stock:AppendFloor.html.twig';
    const TWIG_APPEND_ROOM='TashiStockBundle:Stock:AppendRoom.html.twig';
    const TWIG_APPEND_RACK='TashiStockBundle:Stock:AppendRack.html.twig';
    const TWIG_APPEND_BIN='TashiStockBundle:Stock:AppendBin.html.twig';
    const TWIG_APPEND_PRODUCTS='TashiStockBundle:Stock:AppendProducts.html.twig';
    const TWIG_APPEND_SUB_CATEGORY='TashiStockBundle:Stock:AppendProductSubCat.html.twig';
    const TWIG_STOCK_ENTRY_DETAIL='TashiStockBundle:Stock:StockEntryDetail.html.twig';
    const TWIG_STOCK_SEARCH='TashiStockBundle:Stock:SearchStock.html.twig';
    const TWIG_STOCK_SEARCH_RESULT='TashiStockBundle:Stock:StockSearchResult.html.twig';
    const TWIG_STOCK_VIEW_EDIT='TashiStockBundle:Stock:ViewEditStock.html.twig';
    const TWIG_APPEND_BLDG_SEARCH='TashiStockBundle:Stock:AppendBuildingSearch.html.twig';
    const TWIG_APPEND_FLOOR_SEARCH='TashiStockBundle:Stock:AppendFloorSearch.html.twig';
    const TWIG_APPEND_ROOM_SEARCH='TashiStockBundle:Stock:AppendRoomSearch.html.twig';
    const TWIG_APPEND_RACK_SEARCH='TashiStockBundle:Stock:AppendRackSearch.html.twig';
    const TWIG_PO_PRODUCT_LIST='TashiStockBundle:Stock:POProductList.html.twig';
    const TWIG_INVENTORY_LIST='TashiStockBundle:Stock:InventoryList.html.twig';
}



