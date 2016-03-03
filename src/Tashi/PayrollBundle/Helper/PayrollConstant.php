<?php
namespace Tashi\PayrollBundle\Helper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PayrollConstant
 *
 * @author KHUMUPOKPAM
 */
class PayrollConstant {
    //put your code here 
    //SERVICE CONSTANT
    const SERVICE_PAYROLL='tashi.payroll.service';
    
    //TWIG CONSTANT
    const TWIG_PAYROLL_DASHBOARD='TashiPayrollBundle:Payroll:payrollDashboard.html.twig';
    const TWIG_PAYROLL_MASTER_SETTING='TashiPayrollBundle:Payroll:payrol_master_setting.html.twig';
    const TWIG_PAYROLL_MASTER_LIST='TashiPayrollBundle:Payroll:payrol_master_setting_list.html.twig';
    const TWIG_PAYROLL_CREATE_EMP_SALARY='TashiPayrollBundle:Payroll:salary_slip_search_salary_slip.html.twig';   
    const TWIG_PAYROLL_GENERATE_SALARY_SLIP='TashiPayrollBundle:Payroll:generateSalarySlip.html.twig';
    const TWIG_PAYROLL_APPROVE_SALARY='TashiPayrollBundle:Payroll:salary_slip_approved.html.twig';
    const TWIG_PAYROLL_SALARY_PAY_SLIP='TashiPayrollBundle:Payroll:salary_slip_payment.html.twig';
    const TWIG_EMPLOYEE_SEARCH_LIST='TashiPayrollBundle:Payroll:salary_slip_employee_search_list.html.twig';
    const TWIG_PAYROLL_EMOLUMENT_DEDUCTION = 'TashiPayrollBundle:Payroll:payrol_emolument_deduction_master.html.twig';
    const TWIG_PAYROLL_POPUP_EMOLUMENT_DEDUCTION = 'TashiPayrollBundle:Payroll:PopUpForm/popup_form_emolument_deduction_master.html.twig';
    const TWIG_PAYROLL_EMOLUMENT_DEDUCTION_LIST = 'TashiPayrollBundle:Payroll:payrol_emolument_deduction_master_list.html.twig';
    const TWIG_PAYROLL_EMOLUMENTS_LIST = 'TashiPayrollBundle:Payroll:salary_slip_emoluments_list.html.twig';
    const TWIG_PAYROLL_DEDUCTIONS_LIST = 'TashiPayrollBundle:Payroll:salary_slip_deductions_list.html.twig';
    const TWIG_PAYROLL_PAYMENT_MODE = 'TashiPayrollBundle:Payroll:payment_mode.html.twig';
    const TWIG_PAYROLL_PAYMENT_MODE_LIST = 'TashiPayrollBundle:Payroll:payment_mode_list.html.twig';
    const TWIG_PAYROLL_CREATE_EMP_SALARY_SLIP_FORM = 'TashiPayrollBundle:Payroll:salary_slip_creat_emp_salary_slip.html.twig';
    const TWIG_PAYROLL_ADVANCE_PAYMENT = 'TashiPayrollBundle:Payroll:advance_payment.html.twig';
    const TWIG_PAYROLL_SEARCH_EMP_RESULT_FOR_ADVANCE_PAYMENT = 'TashiPayrollBundle:Payroll:advance_payment_search_emp_result.html.twig';
    const TWIG_PAYROLL_ADVANCE_PAYMENT_FORM = 'TashiPayrollBundle:Payroll:advance_payment_form.html.twig';
    const TWIG_PAYROLL_ADVANCE_PAYMENT_APROVAL = 'TashiPayrollBundle:Payroll:advance_payment_approval.html.twig';
    const TWIG_PAYROLL_ADVANCE_PAYMENT_PAID = 'TashiPayrollBundle:Payroll:advance_payment_paid.html.twig';
    const TWIG_PAYROLL_ADVANCE_PAYMENT_HISTORY = 'TashiPayrollBundle:Payroll:advance_payment_history.html.twig';
    const TWIG_PAYROLL_VIEW_SALARY_SLIP = 'TashiPayrollBundle:Payroll:salary_slip_view_details.html.twig';
    const TWIG_PAYROLL_PARTICULAR_SALARY_SLIP_INFO = 'TashiPayrollBundle:Payroll:salary_slip_particular_salary_slip_info.html.twig';
    const TWIG_PAYROLL_APPROVAL_LIST = 'TashiPayrollBundle:Payroll:salary_slip_approval_list.html.twig';
    const TWIG_PAYROLL_AJX_APPROVED_LIST = 'TashiPayrollBundle:Payroll:salary_slip_ajx_approved_list.html.twig';    
    
    //ENTITY 
    const ENT_PAYROL_MASTER = 'TashiCommonBundle:PayrolMaster';
    const ENT_PAYROL_ADVANCE_PAYMENT = 'TashiCommonBundle:PayrolAdvancePayment';
    const ENT_PAYROL_REPAYMENT_COLLECTION = 'TashiCommonBundle:PayrolRepaymentCollection';
    const ENT_PAYROL_SALARY_SLIP = 'TashiCommonBundle:PayrolSalarySlip';
    const ENT_PAYROL_EMOLUMENT_DEDUCTION_MASTER = 'TashiCommonBundle:PayrolEmolumentDeductionMaster';
    const ENT_PAYROLL_EMOLUMENT_DEDUCTION_AMOUNT = 'TashiCommonBundle:PayrolSalarySlipEmolumentdeductionAmount';
    const ENT_PAYROL_SANCTION_SALARY_ID = 'TashiCommonBundle:PayrolSanctionSalaryId';
    const ENT_PAYROL_SANCTION_SALARY = 'TashiCommonBundle:PayrolSanctionSalarySlip';
    
    
    
    
    
    
    
    
}
