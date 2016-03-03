<?php
namespace Tashi\RequisitionBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseConstant
 *
 * @author SANATOMBA
 */
class RequisitionConstant 

{  const SERVICE_REQUISITION = 'tashi.requisition.service'   ;
   
   const PROJECT_PATH = '/Tashi/web/app_dev.php/Requisition/';
   //twig file
   const TWIG_REQUISITION_DASHBOARD = 'RequisitionBundle:Requisition:RequisitionDashboard.html.twig';
   const TWIG_CREATE_REQUISITION = 'RequisitionBundle:Requisition:createRequisition.html.twig';
   const TWIG_CREATE_ORDER = 'RequisitionBundle:Requisition:createOrder.html.twig';
   const TWIG_CREATE_ORDERNEWFORM = 'RequisitionBundle:Requisition:createOrderNewForm.html.twig';
   const TWIG_SELECTEDPRODUCT = 'RequisitionBundle:Requisition:Selected_product_toBeAdded.html.twig';
   const TWIG_APPEND_PRODUCTS = 'RequisitionBundle:Requisition:AppendProducts.html.twig';
   const TWIG_APPEND_SUB_CATEGORY = 'RequisitionBundle:Requisition:AppendProductSubCat.html.twig';
   const TWIG_REQUISITION = 'RequisitionBundle:Requisition:SearchRequisition.html.twig';
   const TWIG_VIEW_REQORDER = 'RequisitionBundle:Requisition:ViewrOrder.html.twig';
   const TWIG_MY_REQUISITION = 'RequisitionBundle:Requisition:MyRequisition.html.twig';
   const TWIG_EDITREQUISITION ='RequisitionBundle:Requisition:Edit.html.twig';
   const TWIG_Requisition_cancel_approve ='RequisitionBundle:Requisition:Cancel.html.twig';
   const TWIG_cancel_approve_edit ='RequisitionBundle:Requisition:ApproveCancelEdit.html.twig';
   const TWIG_APPROVE_VIEW ='RequisitionBundle:Requisition:displayApprove.html.twig';
   const TWIG_DISPATCH ='RequisitionBundle:Requisition:dispatch.html.twig';
   const TWIG_STOCKRETURN ='RequisitionBundle:Requisition:stockReturn.html.twig';
   const TWIG_SHOWPRODUCT ='RequisitionBundle:Requisition:showproduct.html.twig';
   const TWIG_VIEW_HISTORY ='RequisitionBundle:Requisition:viewHistory.html.twig';
   const TWIG_VIEW_REQUISITION ='RequisitionBundle:Requisition:ViewRequisition.html.twig';
   const TWIG_REQUISITION_TRANSPORT ='RequisitionBundle:Requisition:StockReturnPurpose.html.twig';
   const TWIG_DISPLAY_REQUISITION_TRANSPORT ='RequisitionBundle:Requisition:displayRequisitionTransport.html.twig';
   //ends here
   
   //entity
   const ENT_EMP = 'TashiCommonBundle:EmpEmployeeMaster';
   const ENT_STOCK = 'TashiCommonBundle:StockMaster';
   const ENT_REQ = 'TashiCommonBundle:RequisitionPurpose';
   const ENT_REQSTATUS = 'TashiCommonBundle:RequisitionStatusMaster';
   const ENT_REQUISITION = 'TashiCommonBundle:RequisitionMaster';
   const ENT_REQUISITION_PRODUCT = 'TashiCommonBundle:RequisitionProductDetails';
   const ENT_REQUISITION_Status_txn = 'TashiCommonBundle:RequisitionStatusTxn';
   const ENT_PRODUCT_UNIT = 'TashiCommonBundle:ProductUnitTxn';
   const ENT_PRODUCT = 'TashiCommonBundle:PrdProductMaster';
   const ENT_REQUISITION_PRODUCT_HISTORY = 'TashiCommonBundle:RequisitionProductDetailsHistory';
   const ENT_STOCKRETURN = 'TashiCommonBundle:StockReturn';
   const ENT_BRANCHMASTER = 'TashiCommonBundle:BranchMaster';
   const ENT_PROJECTMASTER = 'TashiCommonBundle:ProjectMaster';
   const ENT_EMPLOYEEMASTER = 'TashiCommonBundle:EmpEmployeeMaster';
   const ENT_STOCKRETURNPURPOSE = 'TashiCommonBundle:StockReturnPurpose';
   
   //ends here
   
}


   
    
    
    
    
    
    

