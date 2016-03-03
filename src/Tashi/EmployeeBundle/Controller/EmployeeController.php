<?php

namespace Tashi\EmployeeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; // symfony annotation route for defining the module
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\PayrollBundle\Helper\PayrollConstant;
use Tashi\CommonBundle\Helper\ERPMessage;

/**
 * 
 * @Route("/employee")
 * 
 */
class EmployeeController extends Controller {

    private $em;
    private $erpMessage;
    public function setContainer(ContainerInterface $container = null) {
        parent::setContainer($container);
        $this->em = $this->getDoctrine()->getManager();
        $this->erpMessage=new ERPMessage();
    }  

    /**
     * @Route ("/employee/delete_emp_job_title/{empJobTitleId}", name="_delete_emp_job_title")
     * 
     */
    public function deleteEmpJobTitleAction($empJobTitleId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpJobTitleMaster($empJobTitleId);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpJobTitle.html.twig', array('allRecord' => $result)));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
    /**
     * @Route ("/employee/delete_emp_religion/{religionId}", name="_delete_emp_religion")
     * 
     */
    public function deleteEmpReligionAction($religionId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpReligionMaster($religionId);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayReligion.html.twig', array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
     /**
     * @Route ("/employee/delete_emp_nationality/{nationalityId}", name="_delete_emp_nationality")
     * 
     */
    public function deleteEmpNationalityAction($nationalityId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpNationalityMaster($nationalityId);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayNationality.html.twig', array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/deleteEmpJobProfile/{jobProfileId}", name="_deleteEmpJobProfile")
     * 
     */
    public function deleteEmpJobProfileAction($jobProfileId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpJobProfileMaster($jobProfileId);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpJobProfile.html.twig', array('allRecord' => $result['result'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/deleteEmpWorkerExpert/{workerExpertId}", name="_deleteEmpWorkerExpert")
     * 
     */
    public function deleteEmpWorkerExpertAction($workerExpertId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpWorkerExpertMaster($workerExpertId);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkerExpert.html.twig', array('allRecord' => $result['result'])));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/deleteEmpWorkingType/{workingtypeId}", name="_deleteEmpWorkingType")
     * 
     */
    public function deleteEmpWorkingTypeAction($workingtypeId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpWorkingTypeMaster($workingtypeId);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkerType.html.twig', array('allRecord' => $result['result'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/deleteEmpWorkingSalaryType/{workingSalaryTypeId}", name="_deleteEmpWorkingSalaryType")
     * 
     */
    public function deleteWorkingSalaryTypeAction($workingSalaryTypeId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpWorkingSalaryTypeMaster($workingSalaryTypeId);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkingSalaryType.html.twig', array('allRecord' => $result['result'])));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/deleteEmpEmployeeType/{employeeTypeId}", name="_deleteEmpEmployeeType")
     * 
     */
    public function deleteEmpEmployeeTypeAction($employeeTypeId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpEmployeeTypeMaster($employeeTypeId);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmployeeType.html.twig', array('allRecord' => $result['result'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/particular_emp_detail/{empID}", name="_particular_emp_detail")
     * 
     */
    public function particularEmployeeDetailAction($empID) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
            switch ($empMasterObj->getEmployementTypeFk()->getTypeId()) {
                case 'O': // for office employee
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EDIT_OFFICE_EMP, array('empID' => $empID)));
                    break;
                case 'W': // for woker employee
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_EMPLOYEE, array('empID' => $empID)));
                    break;
            }

            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_emp_detail/{empID}", name="_delete_Particular_emp_detail")
     * 
     */
    public function deleteEmployeeDetailAction($empID) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
                $empMasterObj->setRecordActiveFlag(0);
                $empMasterObj->setRecordUpdateDate(new \DateTime("NOW"));
                $this->em->flush();
                $this->erpMessage->setMessage('Deleted employee successfully.');
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * 
     * 
     * @Route("/searchEmployeeForEdit/{key}", name="_searchEmployeeForEdit")
     *    
     */
    public function searchEmployeeForEditAction(Request $request, $key) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $queryResult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->searchEmployeeDetails($request);
                //print_r($queryResult);die(); 
                $mobile = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->SearchMobileNo($request); 
                //print_r($queryResult1);
                switch ($key) {
                   
                    case 'E' : // $key = E, this E is means employee search, use in employee module 
                        $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_SEARCH_EMP_RSULT_LIST, array('employee' => $queryResult,'mob'=>$mobile)));
                        break;
                    case 'A' :   // $key = A, this A is means employee search, use in asset module
                        $this->erpMessage->setHtml($this->renderView('TashiAssetBundle:Asset:search_Emp_Result_List_assetAssign.html.twig', array('employee' => $queryResult, 'empId' => $queryResult)));
                        break;
                    case 'L' :   // $key = L, this L is means employee search, use in leave emp search
                        $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_LEAVE_EMP_SEARCH_RESULT, array('employee' => $queryResult)));
                        break;
                }

                $this->erpMessage->setSuccess(true);
                //$this->erpMessage->setMessage($queryResult['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage($ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * 
     * 
     * @Route("/search_worker_employee", name="search_worker_employee")
     *    
     */
    public function searchWokerEmployeeAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $queryResult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->searchWorkerDetails($request);           
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_SEARCH_WORKER_RSULT_LIST, array('worker' => $queryResult)));             
                $this->erpMessage->setSuccess(true);
                //$this->erpMessage->setMessage($queryResult['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION.$ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //--------------------------------------------------
    /**
     * @Route (path="/employee/master_dashboard", name="_emp_master_dashboard")
     */
    public function employeeDashboardAction() {
        $session=$this->getRequest()->getSession();
        $user=$session->get('UPKID');
        if(!$user){
            return $this->redirect($this->generateUrl('_login'));
        }
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('employeeDashboardAction');
        if ($accessRight == 1) {
            try {
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DASHBOARD));
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }            
        }else {
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/master_setting", name="_emp_master_setting")
     */
    public function employeeMasterSettingdAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpJobTitleMaster');
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterSetting.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    
        /**
     * @Route ("/employee/religion", name="_emp_religion")
     */
    public function employeeReligionAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnPersonReligionMaster');
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:ReligionMaster.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
       /**
     * @Route ("/employee/nationality", name="_emp_nationality")
     */
    public function employeeNationalityAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnPersonNationalityMaster');
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:nationalityMaster.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    

    /**
     * @Route ("/employee/worker", name="_emp_worker")
     */
    public function employeeWorkerAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_EMPLOYEE));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/load_emp_worker", name="_load_emp_worker")
     */
    public function loadEmpWorkerAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            if ($empID !== '') {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadWorkerEmpDetails($empID);
                $this->erpMessage->setJsonData($result);
            } else {
                $this->erpMessage->setJsonData(0);
            }
            $jobTitles = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpJobTitleMaster');
            $salaryType = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerSalaryTypeMaster');
            $workingType = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerWorkingTypeMaster');
            $workerExpertise = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerExpertMaster');
            $officeBranch = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('BranchMaster');
            $status = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpStatusMaster');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_LOAD_EMP_WORKERS, array('jobTitles' => $jobTitles,
                        'salaryType' => $salaryType,
                        'office' => $officeBranch,
                        'workerExpertise' => $workerExpertise,
                        'workingType' => $workingType,
                        'status' => $status
            )));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_update_job_title", name="_add_update_emp_job_title")
     */
    public function addUpdateEmpJobTitleAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addUpdateEmpJobTitle($request);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpJobTitle.html.twig', array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
        /**
     * @Route ("/employee/add_update_religion", name="_add_update_emp_religion")
     */
    public function addUpdateReligionAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addUpdateEmpReligion($request);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayReligion.html.twig', array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
     /**
     * @Route ("/employee/add_update_nationality", name="_add_update_emp_nationality")
     */
    public function addUpdateNationalityAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addUpdateEmpNationality($request);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayNationality.html.twig', array('allRecord' => $result)));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    

    /**
     * @Route ("/employee/retrieve_emp_job_title/{empJobTitleId}", name="_retrieve_emp_job_title")
     */
    public function retrieveEmpJobTitleAction($empJobTitleId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retrieveEmpJobTitle($empJobTitleId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/employee/retrieve_emp_religion/{religionId}", name="_retrieve_emp_religion")
     */
    public function retrieveEmpReligionAction($religionId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retrieveEmpReligion($religionId);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/employee/retrieve_emp_nationality/{nationalityId}", name="_retrieve_emp_nationality")
     */
    public function retrieveEmpNationalityAction($nationalityId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retrieveEmpNationality($nationalityId);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    

    /**
     * @Route ("/employee/job_profile", name="_emp_job_profile")
     */
    public function employeeJobProfileAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpJobProfileMaster');

            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterJobProfile.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_job_profile", name="_add_emp_job_profile")
     */
    public function addEmpJobProfileAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {


            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpJobProfile($request);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpJobProfile.html.twig', array('allRecord' => $result['result'], 'jobProfileId' => $result['jobProfileId'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_emp_job_profile/{jobProfileId}", name="_retrive_emp_job_profile")
     */
    public function retriveEmpJobProfileAction($jobProfileId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveEmpJobProfile($jobProfileId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/worker_expert", name="_emp_worker_expert")
     */
    public function employeeWorkerExpertAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerExpertMaster');

            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterWorkerExpert.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_worker_expert", name="_add_emp_worker_expert")
     */
    public function addEmpWorkerExpertAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpWorkerExpert($request);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkerExpert.html.twig', array('allRecord' => $result['result'], 'workerExpertId' => $result['workerExpertId'])));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrieve_emp_worker_expert/{workerExpertId}", name="_retrieve_emp_worker_expert")
     */
    public function retrieveEmpWorkerExpertAction($workerExpertId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retrieveEmpWorkerExpert($workerExpertId); // result is an associative array
                $this->erpMessage->setJsonData($result);   // calling function from class
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  // response is return as an object
    }

    /**
     * @Route ("/employee/working_type", name="_emp_working_type")
     */
    public function employeeWorkingTypeAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerWorkingTypeMaster');

            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterWorkingType.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_new_workingtype", name="_add_new_workingtype")
     */
    public function addEmpWorkingTypeAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $projectresult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpWorkingType($request);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkerType.html.twig', array('allRecord' => $projectresult['result'], 'workingtypeId' => $projectresult['workingtypeId'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($projectresult);
            $this->erpMessage->setMessage($projectresult['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retreive_workingtype/{workingtypeId}", name="_retreive_workingtype")
     */
    public function retreiveEmpWorkingTypeAction($workingtypeId) {


        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $projectresult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retreiveEmpWorkingType($workingtypeId);

            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($projectresult);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/working_salary_type", name="_emp_working_salary_type")
     */
    public function employeeWorkingSalaryTypeAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpWorkerSalaryTypeMaster');

            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterWorkingSalaryType.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_emp_working_salary_type", name="_add_emp_working_salary_type")
     */
    public function addEmpWorkingSalaryTypeAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpWorkingSalaryType($request);
                $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmpWorkingSalaryType.html.twig', array('allRecord' => $result['result'], 'workingSalaryTypeId' => $result['workingSalaryTypeId'])));
                $this->erpMessage->setSuccess(true);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrieve_emp_working_salary_type/{workingSalaryTypeId}", name="_retrieve_emp_working_salary_type")
     */
    public function retrieveEmpWorkingSalaryTypeAction($workingSalaryTypeId) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retrieveEmpWorkingSalaryType($workingSalaryTypeId); // result is an associative array
            $this->erpMessage->setJsonData($result);   // calling function from class
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);  // response is return as an object
    }

    /**
     * @Route ("/employee/employee_type", name="_emp_employee_type")
     */
    public function employeeEmployeeTypeAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpEmploymentType');
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:employeeMasterEmployeeType.html.twig', array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_emp_type", name="_add_emp_type")
     */
    public function addEmpTypeAction(Request $request) {
        //echo "ok controller"; die();
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpType($request);
            $this->erpMessage->setHtml($this->renderView('TashiEmployeeBundle:Employee:displayEmployeeType.html.twig', array('allRecord' => $result['result'], 'employeeTypeId' => $result['employeeTypeId'])));
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_emp_type/{employeeTypeId}", name="_retrive_emp_type")
     */
    public function retriveEmpTypeAction($employeeTypeId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();

        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveEmpType($employeeTypeId);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/employee_department", name="_emp_employee_department")
     */
    public function employeeDepartmentAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $allRecord = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpDepartmentMaster');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DEPARTMENT, array('allRecord' => $allRecord)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/branch_office", name="_branch_office")
     */
    public function branchOfficeAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            //$allRecord = $this->get(CommonConstant::SERVICE_COMMON)->activeList('EmpDepartmentMaster');
            //, array('allRecord' => $allRecord)
            $city = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCityMaster');
            $state = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationStateMaster');
            $country = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCountryMaster');
            $district = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationDistrictMaster');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_BRANCH_OFFICE, array('city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'district' => $district
            )));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/save_branch_office", name="_save_branch_office")
     */
    public function saveBranchOfficeAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveBranchOffice($request);
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_BRANCH_OFFICE_LIST, array('allBranchOffice' => $result['allBranchOffice'])));
                $this->erpMessage->setJsonData($result['branchAddTxnId']);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/branch_office_list", name="_branch_office_list")
     */
    public function branchOfficeListAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->findBy(array('recordActiveFlag' => 1));
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_BRANCH_OFFICE_LIST, array('allBranchOffice' => $result)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_branch_office_info/{branchAddTxnId}", name="_retrive_branch_office_info")
     */
    public function retriveBranchOfficeInfoAction($branchAddTxnId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $branchAddTxnObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->find($branchAddTxnId);
                $country_id = $branchAddTxnObj->getAddressFk()->getCountryCodeFk()->getCountryPk();
                $state_id = $branchAddTxnObj->getAddressFk()->getStateCodeFk()->getStatePk();
                $district_id = '';
                if($branchAddTxnObj->getAddressFk()->getDistrictFk()){
                    $district_id = $branchAddTxnObj->getAddressFk()->getDistrictFk()->getPkid();
                }else{
                    $district_id = '';
                }
                $city_id = '';
                if($branchAddTxnObj->getAddressFk()->getCityCodeFk()){
                    $city_id = $branchAddTxnObj->getAddressFk()->getCityCodeFk()->getCityPk();
                }
                $country = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCountryMaster');
                $state = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($country_id, 'S');
                $district = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($state_id, 'D');
                $city = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($district_id, 'C');
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_BRANCH_OFFICE, array('city' => $city,
                            'state' => $state,
                            'country' => $country,
                            'district' => $district
                )));
                $return_Arr = array(
                    'branch_add_txn_id' => $branchAddTxnObj->getPkid(),
                    'branch_name' => $branchAddTxnObj->getBranchFk()->getBranchName(),
                    'branch_code' => $branchAddTxnObj->getBranchFk()->getBranchCode(),
                    'mobile_no' => $branchAddTxnObj->getBranchFk()->getMobileNo(),
                    'phone_no' => $branchAddTxnObj->getBranchFk()->getTelNo(),
                    'address' => $branchAddTxnObj->getAddressFk()->getAddress1(),
                    'country_id' => $country_id,
                    'state_id' => $state_id,
                    'district_id' => $district_id,
                    'city_id' => $city_id
                );
                $this->erpMessage->setJsonData($return_Arr);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL.$ex->getMessage());
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_branch_office_info/{branchAddTxnId}", name="_delete_branch_office_info")
     */
    public function deleteBranchOfficeInfoAction($branchAddTxnId) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $branchAddTxnObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->find($branchAddTxnId);
                $branchAddTxnObj->setRecordActiveFlag(0);
                $branchAddTxnObj->setRecordUpdateDate(new \Datetime);
                $this->em->flush();

                $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($branchAddTxnObj->getAddressFk()->getAddressPk());
                $addMasterObj->setRecordActiveFlag(0);
                $addMasterObj->setRecordUpdateDate(new \Datetime);
                $this->em->flush();

                $branchObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE)->find($branchAddTxnObj->getBranchFk()->getPkid());
                $branchObj->setRecordActiveFlag(0);
                $branchObj->setRecordUpdateDate(new \Datetime);
                $this->em->flush();

                $this->erpMessage->setMessage('Branch Office has been deleted successfully');
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/create_department", name="_create_employee_department")
     */
    public function createDepartmentAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->createDepartment($request);
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DISPLAY_DEPARTMENT_LIST, array('allRecord' => $result['result'])));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_department_info/{deptID}", name="_retrive_department_info")
     */
    public function retriveDepartmentInfoAction($deptID) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveDepartmentInfo($deptID);
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {            
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_department_info/{deptID}", name="_delete_department_info")
     */
    public function deleteDepartmentAction($deptID) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteDepartment($deptID);
                $this->erpMessage->setMessage('Delete record successfully');
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/new_employee_detail", name="_new_employee_detail")
     * 
     */
    public function newEmployeeDetailAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            $key = $request->request->get('key'); //sub-menu display control key
            if ($empID !== '') {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpPersonalDetails($empID);
                $this->erpMessage->setJsonData($result);
            } else {
                $this->erpMessage->setJsonData(0);
            }
            $nationality = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnPersonNationalityMaster');
            $religion = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnPersonReligionMaster');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_NEW_EMP_DETAIL, array('nationality'=>$nationality,'religion'=>$religion, 'key' => $key)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION.$ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_new_employee", name="_add_new_employee")
     */
    public function addnewEmployeeAction() {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try{
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_NEW_EMP));
                $this->erpMessage->setSuccess(true);
            }catch (\Exception $ex){
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/save_worker_details", name="_save_worker_details")
     */
    public function saveWorkerDetailsAction(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
//        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveWorkerDetails($request);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
//        } catch (\Exception $ex) {
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION . $ex->getMessage());
//            $this->erpMessage->setSuccess(false);
//        }        
        }
        else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }

        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/save_emp_personalDetails", name="_save_emp_personalDetails")
     */
    public function saveEmpPersonalDetailsAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('EmployeeMasterSetting');
	if($accessRight==1){
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveEmpPersonalDetails($request);
            $this->erpMessage->setSuccess(true);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setMessage($result['msg']);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage($ex->getMessage());
//            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    //-----------    ends  employee create module > person details   ---------------//

    /**
     * @Route ("/employee/address_details", name="_employee_address_details")
     */
    public function employeeAddressDetialsAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {

            $empID = $request->request->get('loadID');
            $empAddressDetails = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->findBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1));
            $addressType = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationAddressTypeMaster');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_ADDRESS_DETAIL, array('empAddDetails' => $empAddressDetails, 'addressType' => $addressType)));

            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Load_Emp_Address_details", name="_load_emp_address_form")
     */
    public function loadEmpAddressFormAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('empID');
            $addressTypeID = $request->request->get('txt_Address_Type_ID');
            $addEmpTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->findBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1));
            $flag = 0;
            foreach ($addEmpTxnObj as $obj) {
                $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($obj->getAddressMasterFk()->getAddressPk());
                //echo $addMasterObj->getAddressTypeFk()->getAddressTypePk(); die();
                if ($addMasterObj->getAddressTypeFk()->getAddressTypePk() == $addressTypeID) {
                    $flag = 1;
                }
            }
            if ($flag == 1) {
                $this->erpMessage->setMessage('Address type already exist, please click edit to update !');
                $this->erpMessage->setJsonData($flag);
            } else {
                // $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addMasterID);
                $city = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCityMaster');
                $state = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationStateMaster');
                $country = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCountryMaster');
                $district = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationDistrictMaster');

                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_LOAD_ADDRESS_FORM, array('city' => $city,
                            'state' => $state,
                            'country' => $country,
                            'district' => $district
                )));
                $this->erpMessage->setJsonData($flag);
            }
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/cmn_load_list/{key}", name="_cmn_load_list")
     */
    public function cmnLoadLocationListAction(Request $request, $key) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $load_location_key = $request->request->get('load_list_key');
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($load_location_key, $key);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_LOAD_CMN_LOCATION_LIST, array('result' => $result)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/save_address_details", name="_save_addres_details")
     */
    public function saveAddressDetailAction(Request $request) {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveAddressDetails($request);
                if ($result['check_primary_add_flag'] == 1) {
                    $this->erpMessage->setJsonData($result);
                    $this->erpMessage->setMessage($result['msg']);
                } else {
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_ADDRESS_DETAIL_LIST, array('empAddDetails' => $result['empAddDetails'])));
                    $this->erpMessage->setMessage($result['msg']);
                    $this->erpMessage->setJsonData($result);
                }
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_emp_address_details/{addMasterID}", name="_delete_emp_addres_details")
     */
    public function deleteEmpAddressDetailAction($addMasterID) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpAddressDetails($addMasterID);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_address_details/{addMasterID}", name="_retrive_address_details")
     */
    public function retriveAddressDetailAction($addMasterID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveAddressDetail($addMasterID);
            $country = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('CmnLocationCountryMaster');
            $state = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($result['countryID'], 'S');
            $district = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($result['stateID'], 'D');
            $city = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->cmnLoadLocationList($result['districtID'], 'C');
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_LOAD_ADDRESS_FORM, array('city' => $city,
                        'state' => $state,
                        'country' => $country,
                        'district' => $district
            )));
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Contact_Details", name="_employee_contact_details")
     */
    public function employeeContactDetialsAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpContactDetails($empID);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_CONTACT_DETAIL, array('personObj' => $result['personObj'], 'cmnPerMobTxnObj' => $result['cmnPerMobTxnObj'])));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Save_Contact_Details/{mode}", name="_save_employee_contact_details")
     */
    public function saveEmpContactDetialsAction(Request $request, $mode) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveEmpContactDetails($request, $mode);
                if ($result['contact_flag'] == 0) {
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_CONTACT_DETAIL_LIST, array('personObj' => $result['contactDetails']['personObj'], 'cmnPerMobTxnObj' => $result['contactDetails']['cmnPerMobTxnObj'])));
                    $this->erpMessage->setSecondHtml($this->renderView(EmployeeConstant::TWIG_EMP_EDIT_MOBILE_NOS, array('cmnPerMobTxnObj' => $result['contactDetails']['cmnPerMobTxnObj'])));
                }
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Retrive_Emp_Contact_Details/{personID}", name="_retrive_contact_emp_details")
     */
    public function retriveEmpContactDetailsAction($personID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveEmpContactDetials($personID);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_EDIT_MOBILE_NOS, array('cmnPerMobTxnObj' => $result['cmnPerMobTxnObj'])));
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Delete_Emp_Contact_Details/{personID}", name="_delete_contact_emp_details")
     */
    public function deleteEmpContactDetailsAction(Request $request, $personID) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpContactDetials($request, $personID);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Update_Emp_Mobile_no/{mobMasterID}", name="_update_emp_mobile_no")
     */
    public function updateEmpMobileNoAction($mobMasterID, Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('empID');
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->updateEmpMobileNo($mobMasterID, $request);
            $result2 = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpContactDetails($empID);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_UPDATE_MOBILE_TBL_ROW, array('result' => $result)));
            $this->erpMessage->setSecondHtml($this->renderView(EmployeeConstant::TWIG_EMP_CONTACT_DETAIL_LIST, array('personObj' => $result2['personObj'], 'cmnPerMobTxnObj' => $result2['cmnPerMobTxnObj'])));
            $this->erpMessage->setMessage($result['msg']);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_Emp_Mobile_no/{mobMasterID}", name="_delete_emp_mobile_no")
     */
    public function deleteEmpMobileNoAction(Request $request, $mobMasterID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('empID');
            $detectKey = $request->request->get('detectKey');
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpMobileNo($mobMasterID);
            switch ($detectKey) {
                case 'E': //for employee
                    $result2 = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpContactDetails($empID);
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_CONTACT_DETAIL_LIST, array('personObj' => $result2['personObj'], 'cmnPerMobTxnObj' => $result2['cmnPerMobTxnObj'])));
                    break;
                case 'D':   //for dependent
                    $result2 = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpDependentDetails($empID);
                    $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DEPENDENT_DETAIL, array('dependentDetails' => $result2)));
                    break;
            }

            $this->erpMessage->setJsonData($detectKey);
            $this->erpMessage->setMessage($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Save_Bank_Details", name="_save_employee_bank_details")
     */
    public function saveEmpBankDetailsAction(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->saveEmpBankDetails($request);
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_BANK_DETAIL_LIST, array('bankDetail' => $result)));
                $this->erpMessage->setJsonData($result['bankDetailID']);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Retrive_Bank_Details/{bankMasterID}", name="_retrive_employee_bank_details")
     */
    public function retriveEmpBankDetailsAction($bankMasterID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveEmpBankDetails($bankMasterID);
            $this->erpMessage->setJsonData($result);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/Delete_Bank_Details/{bankMasterID}", name="_delete_employee_bank_details")
     */
    public function deleteEmpBankDetailsAction($bankMasterID) {
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            try{
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpBankDetails($bankMasterID);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/job_details", name="_job_details")
     */
    public function employeeJobDetialsAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            $empjobtitle = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpJobTitleMaster');
            $department = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('EmpDepartmentMaster');
            $branch = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->displayAllResult('BranchMaster');
            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_JOB_DETAIL, array('empjobtitle' => $empjobtitle,
                        'empMaster' => $empMasterObj,
                        'department' => $department,
                        'branch' => $branch
            )));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_job_details", name="_add_job_details")
     */
    public function addEmployeeJobDetialsAction(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpJobDetails($request);
                $this->erpMessage->setMessage($result['msg']);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    /**
     * @Route ("/employee/bankaccount", name="_employee_bank_acc")
     */
    public function EmpBankAccountAction(Request $request) {        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {            
            $empID = $request->request->get('loadID');
            $bankAccArr=$this->em->getRepository(CommonConstant::ENT_EMP_BANK_TXN)->findBy(array('empMasterFk'=>$empID,'recordActiveFlag'=>1),array('empBankPk'=>'ASC'));
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_BANK_ACC_LIST, array('empBankDetail' =>$bankAccArr)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            //$this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setMessage($ex->getMessage());
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/dependent_details", name="_dependent_details")
     */
    public function employeeDependentDetialsAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpDependentDetails($empID);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DEPENDENT_DETAIL, array('dependentDetails' => $result)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/add_emp_dependent_details", name="_add_emp_dependent_details")
     */
    public function addEmpDependentDetailAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->addEmpDependentDetails($request);
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_DEPENDENT_DETAIL_LIST, array('dependentDetails' => $result['dependentDetails'])));
            $this->erpMessage->setSecondHtml($this->renderView(EmployeeConstant::TWIG_EMP_EDIT_MOBILE_NOS, array('cmnPerMobTxnObj' => $result['dependentMobile'])));
            $this->erpMessage->setMessage($result['msg']);
            $this->erpMessage->setJsonData($result['dependentID']);
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/retrive_emp_dependent_details/{dependentID}", name="_retrive_emp_dependent_details")
     */
    public function retriveEmpDependentDetailAction($dependentID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->retriveEmpDependentDetails($dependentID);
                $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_EDIT_MOBILE_NOS, array('cmnPerMobTxnObj' => $result['dependentMobile'])));
                $this->erpMessage->setJsonData($result);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/delete_emp_dependent_details/{dependentID}", name="_delete_emp_dependent_details")
     */
    public function deleteEmpDependentDetailAction($dependentID) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        $accessRight = $this->get(CommonConstant::SERVICE_COMMON)->checkrole('ManageEmployee');
	if($accessRight==1){
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->deleteEmpDependentDetails($dependentID);
                $this->erpMessage->setMessage($result);
                $this->erpMessage->setSuccess(true);
            } catch (\Exception $ex) {
                $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
                $this->erpMessage->setSuccess(false);
            }
        }else{
            $this->erpMessage->setJsonData('AD');
            $this->erpMessage->setHtml($this->renderView(CommonConstant::TWIG_AUTH_ACCESS_DENIED));
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/qualification", name="_emp_qualification")
     */
    public function employeeQualificationAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            //$result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpDependentDetails($empID);
            //,array('dependentDetails' => $result)
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_QUALIFICATION));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/experience", name="_emp_experience")
     */
    public function employeeExperienceAction(Request $request) {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empID = $request->request->get('loadID');
            //$result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->loadEmpDependentDetails($empID);
            //,array('dependentDetails' => $result)
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_EXPERIENCE));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/search_employee", name="_search_employee")
     */
    public function searchEmployeeAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_EMP_SEARCH));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }
    
    /**
     * @Route ("/employee/search_worker", name="_search_worker")
     */
    public function searchWorkerAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_WORKER_SEARCH));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DATA_RETRIEVAL);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/view_my_wallet", name="_view_my_wallet")
     */
    public function viewMyWalletAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $empid = $this->getRequest()->getSession()->get('EMPID');
            $accountbalance = $this->em->getRepository(EmployeeConstant::ENT_EMP_ACCOUNT_BAL)->findOneBy(array('empFk' => $empid, 'recordActiveFlag' => 1));
            $accountdeposit = $this->em->getRepository(EmployeeConstant::ENT_EMP_ACCOUNT_DEPOSIT)->findBy(array('empFk' => $empid, 'recordActiveFlag' => 1));
            $accountexpense = $this->em->getRepository(EmployeeConstant::ENT_EMP_ACCOUNT_EXPENSES)->findBy(array('empFk' => $empid, 'recordActiveFlag' => 1, 'status' => 1));
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::ViewWalletHistory, array('balance' => $accountbalance, 'deposit' => $accountdeposit, 'expense' => $accountexpense)));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/wallet_history", name="_emp_wallet_history")
     */
    public function empWalletHistoryAction() {

        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView('TashiERPBundle:Employee:employeeWalletHistory.html.twig'));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * @Route ("/employee/leave_creation", name="_emp_leave_creation")
     */
    public function empLeaveCreationAction() {
        
        $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
        try {
            $this->erpMessage->setHtml($this->renderView(EmployeeConstant::TWIG_LEAVE_CREATION));
            $this->erpMessage->setSuccess(true);
        } catch (\Exception $ex) {
            $this->erpMessage->setMessage(CommonConstant::ERR_DB_OPERATION);
            $this->erpMessage->setSuccess(false);
        }
        $jsondata = $serializer->serialize($this->erpMessage, 'json');
        return new Response($jsondata);
    }

    /**
     * This method is used for render agent management home pages
     * 
     * 
     * @Route("/EmployeeManagement", name="_employeeManagement")
     *    
     */
    public function employeeHomeAction() {
        
            $times = new \DateTime("now");
            $timeString = $times->format('d-m-Y');
            return $this->render(EmployeeConstant::EMPLOYEE_HOME_PAGE, array('currentTime' => $timeString));
    }

    /**
     * This method is used for create agent details used by createAgent.html.twig
     * 
     * 
     * @Route("/createEmployeeDetails", name="_createEmployeeDetails")
     *    
     */
    public function createEmployeeDetailsAction() {
        
            return $this->render(EmployeeConstant::CREATE_EMPLOYEE_PAGE);
        
    }

    /**
     * This method is used to append create new employee details page used by createAgent.html.twig
     * 
     * 
     * @Route("/appendCreateEmployeeDetails", name="_appendCreateEmployeeDetails")
     *    
     */
    public function appendCreateEmployeeDetailsAction() {
        
            $crmMessage->setSuccess(true);
            $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_PAGE));
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);
    }

    /**
     * This method is used to append create new employee details page used by createAgent.html.twig
     * 
     * 
     * @Route("/appendCreateEmployeeAddress", name="_appendCreateEmployeeAddress")
     *    
     */
    public function appendCreateEmployeeAddressAction() {
        
            $crmMessage->setSuccess(true);
            $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_ADDRESS));
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);
    }

    /**
     * This method is used for create agent details used by createAgent.html.twig
     * 
     * 
     * @Route("/searchOrCreateEmployeeDetailsLoad", name="_searchOrCreateEmployeeDetailsActionLoad")
     *    
     */
    public function searchOrCreateEmployeeDetailsLoadAction() {
        
            return $this->render(EmployeeConstant::SEARCH_OR_CREATE_EMPLOYEE_DETAILS);

    }

    /**
     * This method is used for create agent details used by createAgent.html.twig
     * 
     * 
     * @Route("/searchOrCreateEmployeeDetails", name="_searchOrCreateEmployeeDetailsAction")
     *    
     */
    public function searchOrCreateEmployeeDetailsAction(Request $request) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $dataUI = json_decode($request->getContent());
            $crmMessage = new ERPMessage();
            try {
                $customerName = $dataUI->txtEmployeeName;
                $dob = $dataUI->txtDateOfBirth;
                $mobileNo = $dataUI->txtMobileNo;
                if (empty($customerName) && empty($dob) && empty($mobileNo)) {
                    $crmMessage->setSuccess(false);
                    $crmMessage->setMessage('Please provide at least one field!');
                } else {
                    $crmMessage->setSuccess(true);
                    $queryResult = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->searchEmployeeDetails($dataUI);
                    if (count($queryResult) > 0) {
                        $crmMessage->setMulticheck(true);
                        $crmMessage->setHtml($this->renderView(EmployeeConstant::SEARCH_EMPLOYEE_RESULT, array('employee' => $queryResult)));
                    } else {
                        $crmMessage->setMulticheck(false);
                        $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->findBy(array('recordActiveFlag' => 1), array('religionName' => 'ASC'));
                        $empTypeMaster = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->findBy(array('recordActiveFlag' => 1), array('typeName' => 'ASC'));
                        $employeeDetails = (object) array('name' => $customerName, 'mobileNo' => $mobileNo, 'dob' => $dob);
                        $crmMessage->setHtml($this->renderView(EmployeeConstant::CREATE_EMPLOYEE_PAGE, array(
                                    'employee' => $employeeDetails,
                                    'empMaster' => $empTypeMaster,
                                    'religion' => $religion
                        )));
                    }
                }
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for inserting employee details
     * 
     * 
     * @Route("/saveEmployeeDetails/{personId}/{mode}", name="_saveEmployeeDetails")
     *    
     */
    public function saveEmployeeDetailsAction(Request $request, $personId, $mode) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            try {
                $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->savingEmployeeDetails($request, $personId, $mode);
                $crmMessage->setMessage($result['msg']);
                if ($result['code'] == '1') {
                    $crmMessage->setSuccess(true);
                    $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($result['empid']);
                    $empTypeMaster = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->findAll();
                    $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->findBy(array('recordActiveFlag' => 1), array('religionName' => 'ASC'));
                    $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_PAGE, array(
                                'employMaster' => $employeeMaster, 'empMaster' => $empTypeMaster, 'religion' => $religion)));
                } else {
                    $crmMessage->setSuccess(false);
                }
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);
    }

    /**
     * This method is used for inserting employee details
     * 
     * 
     * @Route("/editEmployeeDetails/{employeeMasterId}", name="_editEmployeeDetails")
     *    
     */
    public function editEmployeeDetailsAction($employeeMasterId) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            try {
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($employeeMasterId);
                $empTypeMaster = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->findAll();
                $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->findBy(array('recordActiveFlag' => 1), array('religionName' => 'ASC'));
                $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_PAGE, array(
                            'employMaster' => $employeeMaster, 'empMaster' => $empTypeMaster, 'religion' => $religion)));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for viewing twig for searching employee details
     * 
     * 
     * @Route("/SearchEmployee", name="_SearchEmployee")
     *    
     */
    public function searchEmpAction() {
       
            return $this->render(EmployeeConstant::SEARCH_EMPLOYEE);
       
    }

    /**
     * This method is used for viewing twig for searching employee details
     * 
     * 
     * @Route("/newAddressDetails/{empId}", name="_newAddressDetails")
     *    
     */
    public function newAddressDetailsAction($empId) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            $crmMessage->setSuccess(true);
            $addressMaster = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findAll();
            //$addrsDetails = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->findByEmployeeFk($this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($empId));
            $addrsDetails = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->
                    findBy(array('employeeFk' => $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($empId),
                'approvalFlag' => 1, 'recordActiveFlag' => 1));
            //        /        echo $addrsDetails->getAddressFk()->getAddress1();exit();
            //        $addrsDetails = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($empAddrs->getAddressFk());
            $crmMessage->setHtml($this->renderView('ERPEmployeeBundle:Employee:newEmployeeAddress.html.twig', array(
                        'addressMaster' => $addressMaster,
                        'empId' => $empId,
                        'addrsDetails' => $addrsDetails
            )));
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for viewing twig for searching employee details
     * 
     * 
     * @Route("/viewEditEmployeeDetails/{employeeMasterId}", name="_viewEditEmployeeDetails")
     *    
     */
    public function viewEditEmployeeDetailsAction($employeeMasterId) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            try {
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($employeeMasterId);
                $crmMessage->setSuccess(true);
                $empTypeMaster = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->findAll();
                $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->findBy(array('recordActiveFlag' => 1), array('religionName' => 'ASC'));
                $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_PAGE, array(
                            'employMaster' => $employeeMaster,
                            'empMaster' => $empTypeMaster,
                            'religion' => $religion
                )));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);
    }

    /**
     * This method is used for viewing twig for employee address form
     * 
     * 
     * @Route("/employeeAddressForm/{employeeMasterId}/{addressPk}", name="_employeeAddressForm")
     *    
     */
    public function employeeAddressFormAction($employeeMasterId, $addressPk) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            try {
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($employeeMasterId);
                $crmMessage->setSuccess(true);
                //            $addType = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addType);
                $state = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findAll();
                $district = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findAll();
                $country = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findAll();
                $addType = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addressPk);
                $crmMessage->setHtml($this->renderView(EmployeeConstant::ADDRESS_FORM_INSERT, array('employeeMaster' => $employeeMaster,
                            'country' => $country, 'state' => $state, 'district' => $district, 'addressTypePk' => $addressPk, 'addtypename' => $addType->getAddressTypeName(), 'mode' => 'ins')));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for viewing twig for employee address form
     * 
     * 
     * @Route("/employeeAddressInsertion/{mode}", name="_employeeAddressInsertion")
     *    
     */
    public function employeeAddressInsertionAction(Request $request, $mode) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            $dataUI = json_decode($request->getContent());
            try {
                $employeeId = $dataUI->txt_EmployeeMaster;
                $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->employeeCreateAddress($dataUI, $mode);
                $crmMessage->setSuccess(true);
                $addressMaster = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findBy(array('recordActiveFlag' => 1));
                $addrsDetails = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->findBy
                        (array('employeeFk' => $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($employeeId),
                    'approvalFlag' => 1, 'recordActiveFlag' => 1));
                $crmMessage->setHtml($this->renderView('ERPEmployeeBundle:Employee:newEmployeeAddress.html.twig', array(
                            'addressMaster' => $addressMaster,
                            'empId' => $employeeId,
                            'addrsDetails' => $addrsDetails
                )));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * @Route("/delEmployeeAddress/{addtxnId}", name="_delEmployeeAddress")  
     */
    public function DeleteEmployeeAddressAction($addtxnId) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            $result = $this->get(EmployeeConstant::SERVICE_EMPLOYEE)->DeleteEmployeeAddress($addtxnId);
            if ($result['code'] == '1') {
                $crmMessage->setSuccess(true);
                $addressMaster = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->findAll();
                $addrsDetails = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->
                        findBy(array('employeeFk' => $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($result['empid']),
                    'approvalFlag' => 1, 'recordActiveFlag' => 1));
                $crmMessage->setHtml($this->renderView('ERPEmployeeBundle:Employee:newEmployeeAddress.html.twig', array(
                            'addressMaster' => $addressMaster,
                            'empId' => $result['empid'],
                            'addrsDetails' => $addrsDetails
                )));
            } else {
                $crmMessage->setSuccess(true);
                $crmMessage->setMessage($result['msg']);
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for viewing twig for employee address form
     * 
     * 
     * @Route("/showEmployeeAddressDetails/{addressId}/{mode}", name="_showEmployeeAddressDetails")
     *    
     */
    public function showEmployeeAddressDetailsAction($addressId, $mode) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            try {

                $addrObj = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->findOneByAddressFk($addressId);
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->find($addrObj->getEmployeeFk()->getPkid());
                $crmMessage->setSuccess(true);
                //            $addType = $this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addType);
                $state = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findAll();
                $district = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findAll();
                $country = $this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->findAll();
                $crmMessage->setHtml($this->renderView(EmployeeConstant::ADDRESS_FORM_INSERT, array('employeeMaster' => $employeeMaster,
                            'country' => $country, 'state' => $state, 'district' => $district, 'addressTypePk' => $addrObj->getAddressFk()->getAddressTypeFk()->getAddressTypePk(), 'mode' => $mode, 'addrObj' => $addrObj)));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }

    /**
     * This method is used for viewing twig for employee address form
     * 
     * 
     * @Route("/showEmployeeDetails", name="_showEmployeeDetails")
     *    
     */
    public function showEmployeeDetailsAction(Request $request) {
        
            $serializer = $this->get(CommonConstant::SERVICE_COMMON)->getSerializer();
            $crmMessage = new ERPMessage();
            $dataUI = json_decode($request->getContent());
            try {
                $mode = $dataUI->mode;
                $person = $this->em->getRepository(CommonConstant::ENT_CONTACT_PERSON_MASTER)->find($dataUI->personId);
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->findOneByPersonFk($person->getPkid());
                $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->findBy(array('recordActiveFlag' => 1), array('religionName' => 'ASC'));
                $crmMessage->setSuccess(true);
                $empTypeMaster = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->findAll();
                $crmMessage->setHtml($this->renderView(EmployeeConstant::APPEND_CREATE_EMPLOYEE_PAGE, array(
                            'employMaster' => $employeeMaster, 'mode' => $mode,
                            'empMaster' => $empTypeMaster,
                            'religion' => $religion
                )));
            } catch (\Exception $ex) {
                /* render the error_menu twig file with parameter Label Name */
                throw new \Exception($ex->getMessage());
            }
            $jsondata = $serializer->serialize($crmMessage, 'json');
            return new Response($jsondata);

    }
}
