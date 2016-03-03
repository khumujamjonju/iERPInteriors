<?php
namespace Tashi\SystemSettingBundle\Helper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemSettingHelper
 *
 * @author KHUMUPOKPAM
 */
class SystemSettingConstant {
    //SERVICE CONSTANT
    const SERVICE_SYSTEMSETTING='tashi.systemsetting.service';
    
    //TWIG CONSTANT
    const TWIG_SETTING_DASHBOARD='TashiSystemSettingBundle:SystemSetting:settingDashboard.html.twig';
    
    //MODULE
    const TWIG_MODULE_ADD='TashiSystemSettingBundle:Module:AddModule.html.twig';
    const TWIG_MODULE_EDIT='TashiSystemSettingBundle:Module:EditModule.html.twig';
    const TWIG_MODULE_LIST='TashiSystemSettingBundle:Module:ModuleList.html.twig';
    
    //ACTIVITY
    const TWIG_ACTIVITY_ADD='TashiSystemSettingBundle:Activities:AddActivity.html.twig';
    const TWIG_ACTIVITY_EDIT='TashiSystemSettingBundle:Activities:EditActivity.html.twig';
    const TWIG_ACTIVITY_LIST='TashiSystemSettingBundle:Activities:ActivityList.html.twig';
}
