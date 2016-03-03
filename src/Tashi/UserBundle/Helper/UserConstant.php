<?php
namespace Tashi\UserBundle\Helper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserConstant
 *
 * @author KHUMUPOKPAM
 */
class UserConstant {
    //put your code here
    const SERVICE_USER='tashi.user.service';
    const TWIG_USER_DASHBOARD='TashiUserBundle:User:userDashboard.html.twig';
    const TWIG_GROUP_ADD='TashiUserBundle:Group:Grp_AddUserGroup.html.twig';
    const TWIG_GROUP_EDIT='TashiUserBundle:Group:Grp_EditUserGroup.html.twig';
    const TWIG_GROUP_LIST='TashiUserBundle:Group:Grp_GroupList.html.twig';
    
    //USER ACCOUNT
    const TWIG_SEARCH_EMPLOYEE='TashiUserBundle:User:SearchEmployee.html.twig';
    const TWIG_EMP_LIST='TashiUserBundle:User:EmployeeList.html.twig';
    const TWIG_SEARCH_ACCOUNT='TashiUserBundle:User:SearchAccount.html.twig';
    const TWIG_CREATE_ACCOUNT='TashiUserBundle:User:CreateAccount.html.twig';
    const TWIG_ACCOUNT_LIST='TashiUserBundle:User:UserAccountList.html.twig';
    const TWIG_BLOCK_ACCOUNT='TashiUserBundle:User:BlockAccount.html.twig';
    const TWIG_REACTIVATE_ACCOUNT='TashiUserBundle:User:ReactivateAccount.html.twig';
    const TWIG_ACCOUNT_HISTORY='TashiUserBundle:User:AccountHistory.html.twig';
    const TWIG_ACTIVITY_LOG='TashiUserBundle:User:UserActivityLog.html.twig';
    const TWIG_ACTIVATE_ACCOUNT='TashiUserBundle:User:ActivateAccount.html.twig';
    const TWIG_ASSIGNACTIVITY='TashiUserBundle:User:ActivityAssign.html.twig';
    const TWIG_USERACTIVITY='TashiUserBundle:User:userActivity.html.twig';
    const TWIG_SEARCHACTIVITY='TashiUserBundle:User:searchActivity.html.twig';
    const TWIG_FORGOT_PASS='TashiUserBundle:User:ForgotPassword.html.twig';
    const TWIG_RESET_PASS='TashiUserBundle:User:ResetPassword.html.twig';
    const TWIG_DISPLAY_ACTIVITY='TashiUserBundle:User:displayActivity.html.twig';
    const TWIG_CHANGE_PASSWORD='TashiUserBundle:User:ChangePassword.html.twig';
    const TWIG_VIEW_PROFILE='TashiUserBundle:User:MyProfile.html.twig';
    const TWIG_ASSIGN_USER_GROUP='TashiUserBundle:User:AssignGroup.html.twig';
    const TWIG_ASSIGN_GROUP='TashiUserBundle:User:UserListForGroupAssignment.html.twig';
    const TWIG_ASSIGN_PASSWORD='TashiUserBundle:User:AssignNewPassword.html.twig';
    const TWIG_CHANGE_EXPIRY_DATE='TashiUserBundle:User:ChangeExpiryDate.html.twig';
}
