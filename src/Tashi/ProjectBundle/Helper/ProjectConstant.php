<?php
namespace Tashi\ProjectBundle\Helper;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectConstant
 *
 * @author Administrator
 */
class ProjectConstant {
    //put your code here
//SERVICE CONSTANT
const SERVICE_PROJECT='tashi.project.service';
const SERVICE_MASTER='tashi.master.service';
//TWIG CONSTANT    
const TWIG_PRO_DASHBOARD = 'TashiProjectBundle:Project:projectDashboard.html.twig';
const TWIG_NEW_PROJECT='TashiProjectBundle:Project:NewProject.html.twig';
const TWIG_PROJ_STEP_2='TashiProjectBundle:Project:ProjectStep2.html.twig';
const TWIG_PROJ_ITEM_LIST='TashiProjectBundle:Project:ProjectItemList.html.twig';
const TWIG_PROJ_PRODUCT_LIST='TashiProjectBundle:Project:appendprojectitems.html.twig';
const TWIG_PROJ_ADD_ITEM_LIST='TashiProjectBundle:Project:projectSearchAddNewItem.html.twig';
const TWIG_PROJ_STEP_3='TashiProjectBundle:Project:ProjectStep3.html.twig';
const TWIG_PROJ_STEP_4='TashiProjectBundle:Project:ProjectStep4.html.twig';
const TWIG_PROJ_STEP_5='TashiProjectBundle:Project:ProjectStep5.html.twig';
const TWIG_PROJ_CONFIRM='TashiProjectBundle:Project:ProjectConfirmationpage.html.twig';
const TWIG_PROJ_DETAIL_INDEX='TashiProjectBundle:Project:ProjectDetailIndex.html.twig';
const TWIG_PROJ_DETAIL='TashiProjectBundle:Project:ProjectDetail.html.twig';
const TWIG_PROJ_DETAIL_ONLY='TashiProjectBundle:Project:ProjectDetailOnly.html.twig';
const TWIG_PROJ_EDIT_DETAIL='TashiProjectBundle:Project:EditProjectDetail.html.twig';
const TWIG_PROJ_REF_DETAIL_='TashiProjectBundle:Project:ProjectRefDetail.html.twig';
const TWIG_PROJ_COORDINATOR_DETAIL='TashiProjectBundle:Project:ProjectCoordinatorOnly.html.twig';
const TWIG_PROJ_EDIT_REF='TashiProjectBundle:Project:EditProjectRefDetail.html.twig';
const TWIG_PROJ_ITEM_DETAIL_LIST='TashiProjectBundle:Project:ProjectItemdetaillist.html.twig';
const TWIG_PROJ_ADV_PAY_LIST='TashiProjectBundle:Project:ProjectAdvancePayList.html.twig';
const TWIG_PROJ_EXPENDITURE_LIST='TashiProjectBundle:Project:ProjectExpenditureList.html.twig';
const TWIG_PROJ_ADD_ITEM_DETAIL='TashiProjectBundle:Project:ProjectAddItemDetail.html.twig';
const TWIG_PROJ_ITEM_DETAIL='TashiProjectBundle:Project:ProjectItemDetail.html.twig';
const TWIG_PROJ_ITEM_STATUS='TashiProjectBundle:Project:ProjectItemStatus.html.twig';
const TWIG_PROJ_EDIT_ITEM='TashiProjectBundle:Project:EditProjectItem.html.twig';
const TWIG_PROJ_PRODUCT_STATUS='TashiProjectBundle:Project:ProjectProductStatus.html.twig';
const TWIG_PROJ_ADD_DAILY_RPT='TashiProjectBundle:Project:AddDailyReport.html.twig';
const TWIG_PROJ_DAILY_RPT='TashiProjectBundle:Project:DailyReport.html.twig';
const TWIG_PROJ_DOC_LIST='TashiProjectBundle:Project:ProjectDocumentList.html.twig';
const TWIG_PROJ_DOC_UPLOAD='TashiProjectBundle:Project:UploadProjectDocument.html.twig';
const TWIG_PROJ_STATUS_LOG='TashiProjectBundle:Project:ProjectStatusLog.html.twig';
const TWIG_PROJ_STATUS_UPDATE='TashiProjectBundle:Project:ProjectStatusUpdate.html.twig';
const TWIG_PROJ_SEARCH='TashiProjectBundle:Project:SearchProject.html.twig';
const TWIG_PROJ_SEARCH_RESULT='TashiProjectBundle:Project:ProjectSearchResult.html.twig';
const TWIG_PROJ_MASTER_SETTING='TashiProjectBundle:Project:projectMasterSetting.html.twig';
const TWIG_PROJ_CATEGORY='TashiProjectBundle:Project:projectCategory.html.twig';
const TWIG_PROJ_CUSTOMER_LIST='TashiProjectBundle:Project:CustomerList.html.twig';
const TWIG_PROJ_WORKTYPE='TashiProjectBundle:Project:projectWorkType.html.twig';
const TWIG_PROJ_WORK_CATEGORY='TashiProjectBundle:Project:projectWorkCategory.html.twig';
const TWIG_PROJ_ACTIVITY='TashiProjectBundle:Project:projectActivity.html.twig';
const TWIG_PROJ_ACTIVITY_MASTER='TashiProjectBundle:Project:activityMaster.html.twig';
const TWIG_PROJ_ORDER='TashiProjectBundle:Project:projectOrder.html.twig';
const TWIG_PROJ_EXECUTION='TashiProjectBundle:Project:projectExecution.html.twig';
const TWIG_PROJ_ASSIGN='TashiProjectBundle:Project:projectAssign.html.twig';
const TWIG_PROJ_SERVICE_ASSING='TashiProjectBundle:Project:projectServiceAssignment.html.twig';
const TWIG_PROJ_ORDER_CUSTOMER='TashiProjectBundle:Project:OrderCustomerProject.html.twig';
const TWIG_PROJ_ORDER_CUST_DETAIL='TashiProjectBundle:Project:OrderCustomerProjectDetails.html.twig';
const TWIG_PROJ_ESTIMATION='TashiProjectBundle:Project:projectEstimation.html.twig';
const TWIG_PROJ_ESTIMATION_APPROVAL='TashiProjectBundle:Project:projectEstimationApproval.html.twig';
const TWIG_PROJ_APPROVAL='TashiProjectBundle:Project:projectApprove.html.twig';
const TWIG_PROJ_MONITOR='TashiProjectBundle:Project:projectMonitor.html.twig';
const TWIG_PROJ_CAPTURE_PROJECT_STATUS='TashiProjectBundle:Project:captureProjectStatus.html.twig';
const TWIG_PROJ_REPORT='TashiProjectBundle:Project:projectReports.html.twig';
const TWIG_PROJ_COMMUNICATION='TashiProjectBundle:Project:projectCommunication.html.twig';
const TWIG_PROJ_CUST_ORD_LIST='TashiProjectBundle:Project:CustomerOrderListDetails.html.twig';
const TWIG_PROJ_WALLET='TashiProjectBundle:Project:projectWallet.html.twig';
const TWIG_PROJ_ASSIGN_ACTIVITY='TashiProjectBundle:Project:projectActivityAssign.html.twig';
const TWIG_PROJ_ITEM_SERVICE_LIST='TashiProjectBundle:Project:ProjectItemServiceList.html.twig';
const TWIG_PROJ_ITEM_SERVICE_DETAIL='TashiProjectBundle:Project:ProjectItemService.html.twig';
const TWIG_PROJ_ADDITIONAL_SERVICE_LIST='TashiProjectBundle:Project:ProjectAdditionalServiceList.html.twig';
const TWIG_PROJ_ADDITIONAL_SERVICE_DETAIL='TashiProjectBundle:Project:ProjectAdditionalService.html.twig';
const TWIG_NOTIFICATION_TEMPLATE='TashiProjectBundle:Project:NotificationTemplate.html.twig';
//const TWIG_PROJ_
//const TWIG_PROJ_

///////////////////////////////////
///////  PROJECT AREA      ////////
///////////////////////////////////
const TWIG_ADD_AREA='TashiProjectBundle:Area:AddNewArea.html.twig';
const TWIG_AREA_LIST='TashiProjectBundle:Area:AreaList.html.twig';
const TWIG_EDIT_AREA='TashiProjectBundle:Area:EditArea.html.twig';

///////////////////////////////////
///////  INDUSTRY TYPE      ////////
///////////////////////////////////
const TWIG_ADD_INDUSTR_TYPE='TashiProjectBundle:Industry:Add.html.twig';
const TWIG_INDUSTRY_LIST='TashiProjectBundle:Industry:IndustryList.html.twig';
const TWIG_EDIT_INDUSTRY='TashiProjectBundle:Industry:Edit.html.twig';
}

