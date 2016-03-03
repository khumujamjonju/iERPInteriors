<?php

namespace Tashi\EmployeeBundle\Helper;
class EmployeeConstant {
    
    ///////////// Employee ID prefix String////////
    const WORKER_EMP_ID_PREFIX = 'WEMP-';
    
    ///////////// Fix Project Path for employee////////
    const EMPLOYEE_MODULE_PATH = '/Tashi/web/app_dev.php/employee/';
  
    ///////////// Entity Constant//////////
    const ENT_UserTbl = 'TashiERPBundle:UserTbl';
    const ENT_UserRoleTbl = 'TashiERPBundle:UserRoleTbl';
   
    /////////// Service Class Constant////////
    const SERVICE_EMPLOYEE = 'tashi.employee.service';
    
   
    /////////// ENTITY CONSTANT///////////
    const ENT_EMP_STATUS_MASTER = 'TashiCommonBundle:EmpStatusMaster';
    const ENT_EMP_JOB_TITLE_MASTER = 'TashiCommonBundle:EmpJobTitleMaster';
    const ENT_EMP_RELIGION_MASTER = 'TashiCommonBundle:CmnPersonReligionMaster';
    const ENT_EMP_NATIONALITY_MASTER = 'TashiCommonBundle:CmnPersonNationalityMaster';
    const ENT_WORKER_EXPERT_MASTER = 'TashiCommonBundle:EmpWorkerExpertMaster';
    const ENT_WORK_SALARY_TYPE_MASTER = 'TashiCommonBundle:EmpWorkerSalaryTypeMaster';
    const ENT_WORK_SALARY_TXN = 'TashiCommonBundle:EmpWorkerSalaryTypeMasterTxn';
    const ENT_WORKER_EXPERT_TXN = 'TashiCommonBundle:EmpWorkerExpertMasterTxn';
    const ENT_WORKING_TYPE_MASTER = 'TashiCommonBundle:EmpWorkerWorkingTypeMaster';
    const ENT_JOB_PROFILE_MASTER = 'TashiCommonBundle:EmpJobProfileMaster';
    const ENT_EMPLOYMENT_TYPE_MASTER = 'TashiCommonBundle:EmpEmploymentType';
    const ENT_EMPLOYMENT_RELIGION_MASTER = 'TashiCommonBundle:CmnPersonReligionMaster';
    const ENT_EMP_DEPT_MASTER = 'TashiCommonBundle:EmpDepartmentMaster';
    const ENT_EMPLOYEE_MASTER = 'TashiCommonBundle:EmpEmployeeMaster';
    const ENT_CMN_PERSON = 'TashiCommonBundle:CmnPerson';
    const ENT_EMP_ADD_TXN = 'TashiCommonBundle:EmpAddressTxn';
    const ENT_EMP_BANK_TXN = 'TashiCommonBundle:EmpBankTxn';
    const ENT_EMP_CONTACT_MOBILE_TXN = 'TashiCommonBundle:EmpContactMobileNoTxn';
    const ENT_EMP_DEPENDENT_TXN = 'TashiCommonBundle:EmpDependentTxn';
    const ENT_EMP_WORKING_TYPE_TXN = 'TashiCommonBundle:EmpWorkerWorkingTypeMasterTxn';
    const ENT_EMP_ACCOUNT_BAL = 'TashiCommonBundle:EmpAccountBalance';
    const ENT_EMP_ACCOUNT_DEPOSIT = 'TashiCommonBundle:EmpAccountDeposit';
    const ENT_EMP_ACCOUNT_EXPENSES = 'TashiCommonBundle:EmpAccountExpenses';
    
 
    ///////////Employee Twig File Constant/////////// 
    const TWIG_EMP_DASHBOARD = 'TashiEmployeeBundle:Employee:employeeDashboard.html.twig';   
    const TWIG_NEW_EMP_DETAIL = 'TashiEmployeeBundle:Employee:newEmpDetail.html.twig';
    const TWIG_NEW_EMP = 'TashiEmployeeBundle:Employee:newEmployee.html.twig';
    const TWIG_EMP_JOB_DETAIL = 'TashiEmployeeBundle:Employee:employeeOfJobDetails.html.twig';
    const TWIG_EMP_ADDRESS_DETAIL = 'TashiEmployeeBundle:Employee:employeeOfAddressDetails.html.twig';
    const TWIG_EMP_CONTACT_DETAIL = 'TashiEmployeeBundle:Employee:employeeOfContactDetails.html.twig';
    const TWIG_EMP_LOAD_ADDRESS_FORM = 'TashiEmployeeBundle:Employee:employeeOfAddressDetailsForm.html.twig';
    const TWIG_EMP_LOAD_CMN_LOCATION_LIST = 'TashiEmployeeBundle:Employee:cmnLocationLoadList.html.twig';
    const TWIG_EMP_BANK_ACC_LIST = 'TashiEmployeeBundle:Employee:empBankAccountList.html.twig';
    const TWIG_EMP_BANK_DETAIL = 'TashiEmployeeBundle:Employee:employeeOfBankAccountDetails.html.twig';
    const TWIG_EMP_DEPENDENT_DETAIL = 'TashiEmployeeBundle:Employee:employeeOfDependentDetails.html.twig';
    const TWIG_EMP_QUALIFICATION = 'TashiEmployeeBundle:Employee:employeeOfQualification.html.twig';
    const TWIG_EMP_EXPERIENCE = 'TashiEmployeeBundle:Employee:employeeOfExperience.html.twig';
    const TWIG_EMP_BANK_DETAIL_LIST = 'TashiEmployeeBundle:Employee:displayEmpBankDetails.html.twig';
    const TWIG_EMP_CONTACT_DETAIL_LIST = 'TashiEmployeeBundle:Employee:displayEmpContactDetails.html.twig';
    const TWIG_EMP_EDIT_MOBILE_NOS = 'TashiEmployeeBundle:Employee:empEditMobileNos.html.twig';
    const TWIG_EMP_UPDATE_MOBILE_TBL_ROW = 'TashiEmployeeBundle:Employee:empMobileUpdateTableRow.html.twig';
    const TWIG_EMP_ADDRESS_DETAIL_LIST = 'TashiEmployeeBundle:Employee:displayEmpAddressDetails.html.twig';
    const TWIG_EMP_DEPENDENT_DETAIL_LIST = 'TashiEmployeeBundle:Employee:displayEmpDependentDetail.html.twig';
    const TWIG_EMP_EMPLOYEE = 'TashiEmployeeBundle:Employee:employeeWorker.html.twig';
    const TWIG_LOAD_EMP_WORKERS = 'TashiEmployeeBundle:Employee:employeeWorkerDetails.html.twig';
    const TWIG_EDIT_OFFICE_EMP = 'TashiEmployeeBundle:Employee:editOfficeEmployee.html.twig';
    const TWIG_SEARCH_EMP_RSULT_LIST = 'TashiEmployeeBundle:Employee:search_Emp_Result_List.html.twig';
    const TWIG_SEARCH_WORKER_RSULT_LIST = 'TashiEmployeeBundle:Employee:search_emp_worker_result_list.html.twig';
    const TWIG_EMP_DEPARTMENT = 'TashiEmployeeBundle:Employee:employeeMasterEmployeeDepartment.html.twig';
    const TWIG_EMP_DISPLAY_DEPARTMENT_LIST = 'TashiEmployeeBundle:Employee:displayEmpDepartmentList.html.twig';
    const TWIG_BRANCH_OFFICE = 'TashiEmployeeBundle:Employee:branch_office.html.twig';
    const TWIG_BRANCH_OFFICE_LIST = 'TashiEmployeeBundle:Employee:branch_office_list.html.twig';
    const TWIG_LEAVE_CREATION = 'TashiEmployeeBundle:Employee:leave_creation.html.twig';
    const TWIG_LEAVE_EMP_SEARCH_RESULT = 'TashiEmployeeBundle:Employee:leave_emp_search_result.html.twig';
    const TWIG_EMP_SEARCH = 'TashiEmployeeBundle:Employee:searchEmployee.html.twig';
    const TWIG_WORKER_SEARCH = 'TashiEmployeeBundle:Employee:searchWorker.html.twig';
    
    
    /*************************ERP***********************************************/
    //-------------- Twig files start ---------------searchEmployee.html.twig
    const EMPLOYEE_HOME_PAGE='ERPEmployeeBundle:Employee:employeeHomePage.html.twig';
    const CREATE_EMPLOYEE_PAGE='ERPEmployeeBundle:Employee:createNewEmployee.html.twig';
    const APPEND_CREATE_EMPLOYEE_PAGE='ERPEmployeeBundle:Employee:appendNewEmployee.html.twig';
    const APPEND_CREATE_EMPLOYEE_ADDRESS='ERPEmployeeBundle:Employee:appendEmployeeAddress.html.twig';
    const SEARCH_OR_CREATE_EMPLOYEE_DETAILS = 'ERPEmployeeBundle:Employee:searchOrCreateEmployee.html.twig';
    const SEARCH_EMPLOYEE_RESULT = 'ERPEmployeeBundle:Employee:employeeExistSearchResult.html.twig';
    const SEARCH_EMPLOYEE = 'ERPEmployeeBundle:Employee:searchEmployee.html.twig';
    const ADDRESS_FORM_INSERT = 'ERPEmployeeBundle:Employee:employee_addressForm.html.twig';
    const ViewWalletHistory = 'TashiEmployeeBundle:Employee:employeeViewMyWallet.html.twig';
    //-------------- Twig files end -----------------
    
    //-------------- Service ------------------
    
}
