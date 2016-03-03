<?php

namespace Tashi\EmployeeBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Tashi\CommonBundle\Entity\CmnPerson;
use Tashi\CommonBundle\Entity\EmpEmployeeMaster;
use Tashi\CommonBundle\Entity\EmpQualificationDetails;
use Tashi\CommonBundle\Entity\EmpExperienceDetails;
use Tashi\CommonBundle\Entity\TbEmployeeAddressTxn;
use Tashi\CommonBundle\Entity\TbCmnAddress;
use Tashi\CommonBundle\Entity\CmnPersonNationalityMaster;
use Tashi\CommonBundle\Entity\CmnPersonReligionMaster;
use Tashi\CommonBundle\Entity\EmpJobTitleMaster;
use Tashi\CommonBundle\Entity\EmpJobProfileMaster;
use Tashi\CommonBundle\Entity\EmpWorkerExpertMaster;
use Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster;
use Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMasterTxn;
use Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster;
use Tashi\CommonBundle\Entity\EmpWorkerExpertMasterTxn;
use Tashi\CommonBundle\Entity\EmpEmploymentType;
use Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMasterTxn;
use Tashi\CommonBundle\Entity\CmnMobileNoMaster;
use Tashi\CommonBundle\Entity\EmpContactMobileNoTxn;
use Tashi\CommonBundle\Entity\CmnBankDetailsMaster;
use Tashi\CommonBundle\Entity\EmpBankTxn;
use Tashi\CommonBundle\Entity\EmpAddressTxn;
use Tashi\CommonBundle\Entity\CmnLocationAddressMaster;
use Tashi\CommonBundle\Entity\EmpDependentTxn;
use Tashi\CommonBundle\Entity\EmpDepartmentMaster;
use Tashi\CommonBundle\Entity\BranchMaster;
use Tashi\CommonBundle\Entity\BranchAddressTxn;
use Tashi\CommonBundle\Entity\CmnDocumentMaster;
use Doctrine\ORM\Query;
use Tashi\CommonBundle\Helper\CommonConstant;
use Tashi\EmployeeBundle\Helper\EmployeeConstant;
use Tashi\CompanyBundle\Helper\CompanyConstant;
use Tashi\PayrollBundle\Helper\PayrollConstant;

class EmployeeService {

    protected $em;
    protected $session;
    protected $webRoot;
    protected $commonService;

    public function __construct(EntityManager $em, Session $session, $rootDir, $commonService) {
        $this->em = $em;
        $this->session = $session;
        $this->webRoot = realpath($rootDir . '/../web/uploads/Documents');
        $this->commonService = $commonService;
    }

    public function displayAllResult($tbl_name) {
        try {
            return $this->commonService->activeList($tbl_name);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    //---------------- delete portions-----------------------//
    public function deleteEmpJobTitleMaster($jobTitleID) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpJobTitleMaster')->find($jobTitleID);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpJobTitleMaster'),
            'id' => $ACidObj->getJobTitlePk());
    }
    
     public function deleteEmpReligionMaster($religionId) {

        try {
            $ReligionObj = $this->em->getRepository('TashiCommonBundle:CmnPersonReligionMaster')->find($religionId);
            $ReligionObj->setRecordActiveFlag(0);
            $ReligionObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ReligionObj->setApplicationUserId($this->session->get('EMPID'));
            $ReligionObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CmnPersonReligionMaster'),
            'id' => $ReligionObj->getPkid());
    }
    
     public function deleteEmpNationalityMaster($nationalityId) {

        try {
            $ReligionObj = $this->em->getRepository('TashiCommonBundle:CmnPersonNationalityMaster')->find($nationalityId);
            $ReligionObj->setRecordActiveFlag(0);
            $ReligionObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ReligionObj->setApplicationUserId($this->session->get('EMPID'));
            $ReligionObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('CmnPersonNationalityMaster'),
            'id' => $ReligionObj->getPkid());
    }

    public function deleteEmpJobProfileMaster($jobProfileId) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpJobProfileMaster')->find($jobProfileId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpJobProfileMaster'),
            'id' => $ACidObj->getJobProfilePk());
    }

    public function deleteEmpWorkerExpertMaster($workerExpertId) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerExpertMaster')->find($workerExpertId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpWorkerExpertMaster'),
            'id' => $ACidObj->getExpertTypePk());
    }

    public function deleteEmpWorkingTypeMaster($workingtypeId) {
        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerWorkingTypeMaster')->find($workingtypeId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpWorkerWorkingTypeMaster'),
            'id' => $ACidObj->getWorkingTypePk());
    }

    public function deleteEmpWorkingSalaryTypeMaster($workingSalaryTypeId) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpWorkerSalaryTypeMaster')->find($workingSalaryTypeId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpWorkerSalaryTypeMaster'),
            'id' => $ACidObj->getSalaryTypePk());
    }

    public function deleteEmpEmployeeTypeMaster($employeeTypeId) {

        try {
            $ACidObj = $this->em->getRepository('TashiCommonBundle:EmpEmploymentType')->find($employeeTypeId);
            $ACidObj->setRecordActiveFlag(0);
            $ACidObj->setRecordUpdateDate(new \DateTime("NOW"));
            $ACidObj->setApplicationUserId($this->session->get('EMPID'));
            $ACidObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => 'Deleted Sucessfully',
            'result' => $this->commonService->activeList('EmpEmploymentType'),
            'id' => $ACidObj->getEmploymentTypePk());
    }

    public function searchEmployeeDetails($request) {

        try {

            $dataUI = json_decode($request->getContent());
            $employee_id = $dataUI->search_employee_id;   //echo $employee_id; die();

            $employee_name = $dataUI->search_employee_name;
            //  $empjobprofile = $dataUI->empjobprofile;
            //  $empjobtitle = $dataUI->empjobtitle;

            $parameters = array();
            $queryString = "SELECT emp 
                             FROM TashiCommonBundle:EmpEmployeeMaster emp 
                             JOIN emp.personFk p 
                             WHERE emp.recordActiveFlag=:activFlag 
                             AND emp.employementTypeFk =:employementType ";
            $parameters['employementType'] = 1;
            $parameters['activFlag'] = 1;
            if (!empty($employee_id) && !is_null($employee_id)) {
                $queryString .= " AND emp.employeeId = :empId ";
                $parameters['empId'] = $employee_id;
            }
            if (!empty($employee_name) && !is_null($employee_name)) {
                $queryString .= " AND p.firstName Like :empName ";
                $parameters['empName'] = $employee_name . '%';
            }
//            if (!empty($empjobprofile) && !is_null($empjobprofile)) {
//                $queryString .= " AND emp.empJobProfileFk = :empId ";
//                $parameters['empId'] = $empjobprofile;
//            }
//            if (!empty($empjobtitle) && !is_null($empjobtitle)) {
//                $queryString .= " AND emp.empJobTitleFk = :empId ";
//                $parameters['empId'] = $empjobtitle;
//            }
            // print_r($parameters) ; die(); 
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
            
            //contact nos 
            foreach ($resultSearch as $empObj) {
                
            }
            
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('searchResult' => $resultSearch);
    }
    
    public function searchWorkerDetails($request) {

        try {

            $dataUI = json_decode($request->getContent());
            $employee_id = $dataUI->search_employee_id;   //echo $employee_id; die();

            $employee_name = $dataUI->search_employee_name;
            //  $empjobprofile = $dataUI->empjobprofile;
            //  $empjobtitle = $dataUI->empjobtitle;

            $parameters = array();
            $queryString = "SELECT emp 
                             FROM TashiCommonBundle:EmpEmployeeMaster emp 
                             JOIN emp.personFk p 
                             WHERE emp.recordActiveFlag=:activFlag 
                             AND emp.employementTypeFk =:employementType ";
            $parameters['employementType'] = 2;
            $parameters['activFlag'] = 1;
            if (!empty($employee_id) && !is_null($employee_id)) {
                $queryString .= " AND emp.employeeId = :empId ";
                $parameters['empId'] = $employee_id;
            }
            if (!empty($employee_name) && !is_null($employee_name)) {
                $queryString .= " AND p.personName Like :empName";
                $parameters['empName'] = '%'.$employee_name.'%';
            }
//            if (!empty($empjobprofile) && !is_null($empjobprofile)) {
//                $queryString .= " AND emp.empJobProfileFk = :empId ";
//                $parameters['empId'] = $empjobprofile;
//            }
//            if (!empty($empjobtitle) && !is_null($empjobtitle)) {
//                $queryString .= " AND emp.empJobTitleFk = :empId ";
//                $parameters['empId'] = $empjobtitle;
//            }
            // print_r($parameters) ; die(); 
            $query = $this->em->createQuery($queryString);
            $query->setParameters($parameters);
            $resultSearch = $query->getResult();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('searchResult' => $resultSearch);
    }

    public function SearchMobileNo($request) {
try {

            $dataUI = json_decode($request->getContent());
            $employee_id = $dataUI->search_employee_id;   //echo $employee_id; die();

            $employee_name = $dataUI->search_employee_name;
            $qb=$this->em->createQueryBuilder();
            $qb->select('mobile')
                    ->from('TashiCommonBundle:EmpContactMobileNoTxn','mobile')
                    ->join('mobile.personFk','person')
                    ->join('TashiCommonBundle:EmpEmployeeMaster','emp',
                    Query\Expr\Join::WITH,$qb->expr()->eq('person.personPk','emp.personFk'))
                    ->where($qb->expr()->andX(
                            $qb->expr()->eq('mobile.recordActiveFlag',1),
                            $qb->expr()->eq('emp.recordActiveFlag',1)));
            if(!empty($employee_id) && !is_null($employee_id)){
                $qb->andWhere($qb->expr()->eq('emp.employeeId',$employee_id));
            }
            if(!empty($employee_name) && !is_null($employee_name)){
                $qb->andWhere($qb->expr()->like('person.personName','\''.$employee_name.'\''));
            }
//            $queryString = " Select emp , mobile                    
//                            FROM TashiCommonBundle:EmpContactMobileNoTxn mobile 
//                            INNER JOIN mobile.personFk person                            
//                            INNER JOIN TashiCommonBundle:EmpEmployeeMaster emp 
//                            WITH emp.personFk = person.personPk
//                            WHERE emp.recordActiveFlag=:activFlag 
//                            AND emp.employementTypeFk =:employementType ";
//            
//            $parameters['employementType'] = 1;
//            $parameters['activFlag'] = 1;
//            if (!empty($employee_id) && !is_null($employee_id)) {
//                $queryString .= " AND emp.employeeId = :empId ";
//                $parameters['empId'] = $employee_id;
//            }
//            if (!empty($employee_name) && !is_null($employee_name)) {
//                $queryString .= " AND p.firstName Like :empName ";
//                $parameters['empName'] = $employee_name . '%';
//            }
//
//            $query = $this->em->createQuery($queryString);
//            $query->setParameters($parameters);
            $query=$qb->getQuery();
            $resultSearch = $query->getResult();
                
         } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('searchResult'=>$resultSearch);
    }
    
    
    
    public function addUpdateEmpJobTitle($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $jobTitleName = $dataUI->job_title_name;
            $description = $dataUI->job_title_des;
            $jobTitleId = $dataUI->jobTitleId;
            if ($jobTitleId == "") {
                $empJobTitleObj = new EmpJobTitleMaster();
            } else {
                $empJobTitleObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_JOB_TITLE_MASTER)->find($jobTitleId);
            }

            $empJobTitleObj->setJobTitleName($jobTitleName);
            $empJobTitleObj->setDescription($description);
            $empJobTitleObj->setRecordActiveFlag(1);
            
            if ($jobTitleId == "") {
                $empJobTitleObj->setRecordInsertDate(new \Datetime());
            } else {
                $empJobTitleObj->setRecordUpdateDate(new \Datetime());
            }
            $empJobTitleObj->setApplicationUserId($this->session->get('EMPID'));
            $empJobTitleObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($empJobTitleObj);
            $this->em->flush();
            if ($jobTitleId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpJobTitleMaster')
        );
    }
    
    
     public function addUpdateEmpReligion($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $religionName = $dataUI->religion_name;
            $religionId = $dataUI->religionId;
            if ($religionId == "") {
                $empReligionObj = new CmnPersonReligionMaster();
            } else {
                $empReligionObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_RELIGION_MASTER)->find($religionId);
            }

            $empReligionObj->setReligionName($religionName);
            $empReligionObj->setRecordActiveFlag(1);
            
            if ($religionId == "") {
                $empReligionObj->setRecordInsertDate(new \Datetime());
            } else {
                $empReligionObj->setRecordUpdateDate(new \Datetime());
            }
            $empReligionObj->setApplicationUserId($this->session->get('EMPID'));
            $empReligionObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($empReligionObj);
            $this->em->flush();
            if ($religionId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CmnPersonReligionMaster')
        );
    }
    
    public function addUpdateEmpNationality($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $nationalityName = $dataUI->nationality_name;
            $nationalityId = $dataUI->nationalityId;
            if ($nationalityId == "") {
                $empReligionObj = new CmnPersonNationalityMaster();
            } else {
                $empReligionObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_NATIONALITY_MASTER)->find($nationalityId);
            }

            $empReligionObj->setNationality($nationalityName);
            $empReligionObj->setRecordActiveFlag(1);
            
            if ($nationalityId == "") {
                $empReligionObj->setRecordInsertDate(new \Datetime());
            } else {
                $empReligionObj->setRecordUpdateDate(new \Datetime());
            }
            $empReligionObj->setApplicationUserId($this->session->get('EMPID'));
            $empReligionObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($empReligionObj);
            $this->em->flush();
            if ($nationalityId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('CmnPersonNationalityMaster')
        );
    }

    public function retrieveEmpJobTitle($empJobTitleId) {
        try {
            $empJobTitleObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_JOB_TITLE_MASTER)->find($empJobTitleId);
            $return = array(
                'jobTitleID' => $empJobTitleId,
                'job_title_name' => $empJobTitleObj->getJobTitleName(),
                'job_title_des' => $empJobTitleObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function retrieveEmpReligion($religionId) {
        try {
            $empReligionObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_RELIGION_MASTER)->find($religionId);
            $return = array(
                'religionId' => $religionId,
                'religion_name' => $empReligionObj->getReligionName());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }
    
     public function retrieveEmpNationality($nationalityId) {
        try {
            $empNationalityObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_NATIONALITY_MASTER)->find($nationalityId);
            $return = array(
                'nationalityId' => $nationalityId,
                'nationality_name' => $empNationalityObj->getNationality());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $return;
    }

    public function addEmpWorkerExpert($request) {

        try {
            $dataUI = json_decode($request->getContent()); // to decode post from ui
            $exptName = $dataUI->exptName;
            $exptDesciption = $dataUI->exptDesciption;
            $workerExpertId = $dataUI->workerExpertId;
            if ($workerExpertId == "") {
                $TbEmpWorkerExpertMasterObj = new EmpWorkerExpertMaster();
            } else {
                $TbEmpWorkerExpertMasterObj = $this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_MASTER)->find($workerExpertId);
            }

            $TbEmpWorkerExpertMasterObj->setExpertType($exptName);
            $TbEmpWorkerExpertMasterObj->setDescription($exptDesciption);
            $TbEmpWorkerExpertMasterObj->setRecordActiveFlag(1);
            if ($workerExpertId == "") {
                $TbEmpWorkerExpertMasterObj->setRecordInsertDate(new \Datetime());
            } else {
                $TbEmpWorkerExpertMasterObj->setRecordUpdateDate(new \Datetime());
            }
            $TbEmpWorkerExpertMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $TbEmpWorkerExpertMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($TbEmpWorkerExpertMasterObj); // object is first saved
            $this->em->flush();
            if ($workerExpertId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpWorkerExpertMaster'),
            'workerExpertId' => $TbEmpWorkerExpertMasterObj->getExpertTypePk()
        );
    }

    public function addEmpWorkingSalaryType($request) {

        try {
            $dataUI = json_decode($request->getContent()); // to decode post from ui
            $workSalTypeName = $dataUI->Emp_Working_salary_type_Name;
            $workSalTypeDesciption = $dataUI->Emp_Working_salary_type_Des;
            $workingSalaryTypeId = $dataUI->workingSalaryTypeId;
            if ($workingSalaryTypeId == "") {
                $TbEmpWorkingSalaryTypeMasterObj = new EmpWorkerSalaryTypeMaster();
            } else {
                $TbEmpWorkingSalaryTypeMasterObj = $this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TYPE_MASTER)->find($workingSalaryTypeId);
            }



            $TbEmpWorkingSalaryTypeMasterObj->setSalaryType($workSalTypeName);
            $TbEmpWorkingSalaryTypeMasterObj->setDescription($workSalTypeDesciption);
            $TbEmpWorkingSalaryTypeMasterObj->setRecordActiveFlag(1);
            if ($workingSalaryTypeId == "") {
                $TbEmpWorkingSalaryTypeMasterObj->setRecordInsertDate(new \Datetime());
                $TbEmpWorkingSalaryTypeMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $TbEmpWorkingSalaryTypeMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            } else {
                $TbEmpWorkingSalaryTypeMasterObj->setRecordUpdateDate(new \Datetime());
                $TbEmpWorkingSalaryTypeMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $TbEmpWorkingSalaryTypeMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->persist($TbEmpWorkingSalaryTypeMasterObj); // object is first saved
            $this->em->flush();
            if ($workingSalaryTypeId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated  new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpWorkerSalaryTypeMaster'),
            'workingSalaryTypeId' => $TbEmpWorkingSalaryTypeMasterObj->getSalaryTypePk()
        );
    }

    public function retrieveEmpWorkerExpert($workerExpertId) {
        try {
            $empWorkerExpertObj = $this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_MASTER)->find($workerExpertId);
            $return = array(
                'workerExpertId' => $workerExpertId,
                'workerexpertName' => $empWorkerExpertObj->getExpertType(),
                'description' => $empWorkerExpertObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    public function retrieveEmpWorkingSalaryType($workingSalaryTypeId) {
        try {
            $EmpWorkingSalaryTypeMasterObj = $this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TYPE_MASTER)->find($workingSalaryTypeId);
            $return = array('workingSalaryTypeId' => $workingSalaryTypeId,
                'workingSalaryTypeName' => $EmpWorkingSalaryTypeMasterObj->getSalaryType(),
                'description' => $EmpWorkingSalaryTypeMasterObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    public function addEmpWorkingType($request) {
        try {

            $dataUI = json_decode($request->getContent());
            $workingtype = $dataUI->workingtype;
            $description = $dataUI->description;
            $workingtypeId = $dataUI->workingtypeId;
            if ($workingtypeId == "") {
                $workObj = new EmpWorkerWorkingTypeMaster();
            } else {
                $workObj = $this->em->getRepository(EmployeeConstant::ENT_WORKING_TYPE_MASTER)->find($workingtypeId);
            }


            $workObj->setWorkingType($workingtype);
            $workObj->setDescription($description);
            $workObj->setRecordActiveFlag(1);
            if ($workingtypeId == "") {
                $workObj->setRecordInsertDate(new \Datetime());
                $workObj->setApplicationUserId($this->session->get('EMPID'));
                $workObj->setApplicationUserIpAddress($this->session->get('IP'));
            } else {
                $workObj->setRecordUpdateDate(new \Datetime());
                $workObj->setApplicationUserId($this->session->get('EMPID'));
                $workObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->persist($workObj);
            $this->em->flush();
            if ($workingtypeId == "") {
                $msg = "'Inserted new Record'";
            } else {
                $msg = "'Updated new Record'";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpWorkerWorkingTypeMaster'),
            'workingtypeId' => $workObj->getWorkingTypePk()
        );
    }

    public function retreiveEmpWorkingType($workingtypeId) {

        try {
            $workingtypeObj = $this->em->getRepository(EmployeeConstant::ENT_WORKING_TYPE_MASTER)->find($workingtypeId);
            $return = array('workingtypeId' => $workingtypeId,
                'workingtypename' => $workingtypeObj->getWorkingType(),
                'description' => $workingtypeObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    public function addEmpJobProfile($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $empJobName = $dataUI->job_profile_name;
            $empJobDes = $dataUI->job_profile_description;
            $jobProfileId = $dataUI->jobProfileId;
            if ($jobProfileId == "") {
                $empJobProfileObject = new EmpJobProfileMaster();
            } else {
                $empJobProfileObject = $this->em->getRepository(EmployeeConstant::ENT_JOB_PROFILE_MASTER)->find($jobProfileId);
            }


            $empJobProfileObject->setJobProfileName($empJobName);
            $empJobProfileObject->setDescription($empJobDes);
            $empJobProfileObject->setRecordActiveFlag(1);
            if ($jobProfileId == "") {
                $empJobProfileObject->setRecordInsertDate(new \Datetime());
                $empJobProfileObject->setApplicationUserId($this->session->get('EMPID'));
                $empJobProfileObject->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empJobProfileObject);
            } else {
                $empJobProfileObject->setRecordUpdateDate(new \Datetime());
                $empJobProfileObject->setApplicationUserId($this->session->get('EMPID'));
                $empJobProfileObject->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();
            if ($jobProfileId == "") {
                $msg = "Inserted new Record";
            } else {
                $msg = "Updated new Record";
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpJobProfileMaster'),
            'jobProfileId' => $empJobProfileObject->getJobProfilePk()
        );
    }

    public function retriveEmpJobProfile($jobProfileId) {
        try {
            $empJobProfileObj = $this->em->getRepository(EmployeeConstant::ENT_JOB_PROFILE_MASTER)->find($jobProfileId);
            $return = array('jobProfileId' => $jobProfileId,
                'jobProfileName' => $empJobProfileObj->getJobProfileName(),
                'jobProfiledescription' => $empJobProfileObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

//    //-----------     start employee type services    ---------------//


    public function addEmpType($request) {
        try {

            $dataUI = json_decode($request->getContent());
            $empType = $dataUI->employeetypename;
            $empDescription = $dataUI->employeetypenamedescription;
            $employeeTypeId = $dataUI->employeeTypeId;
            if ($employeeTypeId == "") {
                $empTypeObj = new EmpEmploymentType();
            } else {
                $empTypeObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYMENT_TYPE_MASTER)->find($employeeTypeId);
            }

            $empTypeObj->setTypeName($empType);
            $empTypeObj->setDescription($empDescription);
            $empTypeObj->setRecordActiveFlag(1);
            if ($employeeTypeId == "") {
                $empTypeObj->setRecordInsertDate(new \Datetime());
                $empTypeObj->setApplicationUserId($this->session->get('EMPID'));
                $empTypeObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empTypeObj);
            } else {
                $empTypeObj->setRecordUpdateDate(new \Datetime());
                $empTypeObj->setApplicationUserId($this->session->get('EMPID'));
                $empTypeObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();

            //message
            if ($employeeTypeId == "") {
                $msg = 'Inserted new Record';
            } else {
                $msg = 'Updated new Record';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpEmploymentType'),
            'employeeTypeId' => $empTypeObj->getEmploymentTypePk()
        );
    }

    public function retriveEmpType($employeeTypeId) {
        try {
            $employeeTypeObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYMENT_TYPE_MASTER)->find($employeeTypeId);
            $return = array('employeeTypeId' => $employeeTypeId,
                'employeeTypeName' => $employeeTypeObj->getTypeName(),
                'empTypeDescription' => $employeeTypeObj->getDescription());
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $return;
    }

    public function createDepartment($request) {
        try {
            $dataUI = json_decode($request->getContent());
            $emp_dept_name = $dataUI->deptName;
            $description = $dataUI->description;
            $deptId = $dataUI->deptId;

            if ($deptId == "") {
                $empDeptObj = new EmpDepartmentMaster();
            } else {
                $empDeptObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPT_MASTER)->find($deptId);
            }
            $empDeptObj->setDepartmentName($emp_dept_name);
            $empDeptObj->setDescription($description);
            $empDeptObj->setRecordActiveFlag(1);
            if ($deptId == "") {
                $empDeptObj->setRecordInsertDate(new \Datetime());
                $empDeptObj->setApplicationUserId($this->session->get('EMPID'));
                $empDeptObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empDeptObj);
            } else {
                $empDeptObj->setRecordUpdateDate(new \Datetime());
                $empDeptObj->setApplicationUserId($this->session->get('EMPID'));
                $empDeptObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();

            //for message
            if ($deptId == "") {
                $msg = 'Inserted new record successfully';
            } else {
                $msg = 'Updated record successfully';
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => $msg,
            'result' => $this->commonService->activeList('EmpDepartmentMaster'),
            'deptID' => $empDeptObj->getPkid()
        );
    }

    public function saveBranchOffice($request) {
        //oficeeeee
        $conn = $this->em->getConnection();
        try {
            $dataUI = json_decode($request->getContent());
            $branch_address_txn_id = $dataUI->txt_branch_add_txn_id;
            $branch_name = $dataUI->txt_branch_name;
            $branch_code = $dataUI->txt_branch_code;
            $mobile_no = $dataUI->txt_mobile_no;
            $telephone_no = $dataUI->txt_telephone_no;
            $country_id = $dataUI->txt_country;
            $state_id = $dataUI->txt_state;
            $district_id = $dataUI->txt_district;
            $city_id = $dataUI->txt_city;
            $address1 = $dataUI->txt_address1;

            $conn->beginTransaction();

            //save record for branch office
            if ($branch_address_txn_id == '') {
                $branchObj = new BranchMaster();
            } else {
                $findBranchObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->find($branch_address_txn_id);
                $branchObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE)->find($findBranchObj->getBranchFk()->getPkid());
            }
            $branchObj->setBranchName($branch_name);
            $branchObj->setBranchCode($branch_code);
            $branchObj->setMobileNo($mobile_no);
            $branchObj->setTelNo($telephone_no);
            $branchObj->setRecordActiveFlag(1);
            $branchObj->setRecordInsertDate(new \Datetime);
            $branchObj->setApplicationUserId($this->session->get('EMPID'));
            $branchObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($branchObj);
            $this->em->flush();

            //save record for branch office address
            if ($branch_address_txn_id == '') {
                $addMasterObj = new CmnLocationAddressMaster();
            } else {
                $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($findBranchObj->getAddressFk()->getAddressPk());
            }

            $addMasterObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country_id));
            $addMasterObj->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state_id));
            $addMasterObj->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($city_id));
            $addMasterObj->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district_id));
            $addMasterObj->setAddress1($address1);
            $addMasterObj->setRecordActiveFlag(1);
            $addMasterObj->setRecordInsertDate(new \Datetime);
            $addMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $addMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($addMasterObj);
            $this->em->flush();

            //save record for branch office
            if ($branch_address_txn_id == '') {
                $branchAddObj = new BranchAddressTxn();
                $branchAddObj->setAddressFk($addMasterObj);
                $branchAddObj->setBranchFk($branchObj);
                $branchAddObj->setRecordActiveFlag(1);
                $branchAddObj->setRecordInsertDate(new \Datetime);
                $branchAddObj->setApplicationUserId($this->session->get('EMPID'));
                $branchAddObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($branchAddObj);
                $this->em->flush();
            } else {
                $branchAddObj = $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->find($branch_address_txn_id);
            }

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'save record successfully.',
            'branchAddTxnId' => $branchAddObj->getPkid(),
            'allBranchOffice' => $this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE_ADDRESS_TXN)->findBy(array('recordActiveFlag' => 1))
        );
    }

    public function retriveDepartmentInfo($deptID) {
        try {
            $empDeptObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPT_MASTER)->find($deptID);
            return array('deptID' => $deptID,
                'deptName' => $empDeptObj->getDepartmentName(),
                'description' => $empDeptObj->getDescription()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteDepartment($deptID) {
        try {
            $empDeptObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPT_MASTER)->find($deptID);
            $empDeptObj->setRecordActiveFlag(0);
            $empDeptObj->setRecordUpdateDate(new \Datetime('now'));
            $empDeptObj->setApplicationUserId($this->session->get('EMPID'));
            $empDeptObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return;
    }

    //--------create employee personal details----------------------------------------------------// 
    public function loadEmpPersonalDetails($empID) {
        try {
            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);
            $empPerObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->findOneByPersonPk($empMasterObj->getPersonFk()->getPersonPk());
            if ($empPerObj->getPictureFk()) {
                $profile_pic = $empPerObj->getPictureFk()->getPath();
            } else {
                $profile_pic = 'bundles/common/images/unk.jpg';
            }
            $nationality = '';
            if($empMasterObj->getPersonFk()->getNationality()){
                $nationality = $empMasterObj->getPersonFk()->getNationality()->getPkid();
            }
            $religion = '';
            if($empMasterObj->getPersonFk()->getReligion()){
                $religion = $empMasterObj->getPersonFk()->getReligion()->getPkid();
            }
            return array(
                'empID' => $empID,
                'assignEmpID' => $empMasterObj->getEmployeeId(),
                'person_name' => $empPerObj->getPersonName(),
                'first_name' => $empPerObj->getFirstName(),
                'middle_name' => $empPerObj->getMiddleName(),
                'last_name' => $empPerObj->getLastName(),
                'father_name' => $empPerObj->getContactFatherName(),
                'gender' => $empPerObj->getGender(),
                'marital' => $empPerObj->getMaritalStatus(),
                'dob' => date_format($empPerObj->getDateOfBirth(), 'Y-m-d'),
                'profile_pic' => $profile_pic,
                'nationality' => $nationality,
                'religion' => $religion
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function loadWorkerEmpDetails($empID) {
        try {
            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findOneByEmployeePk($empID);
            $empPerObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->findOneByPersonPk($empMasterObj->getPersonFk()->getPersonPk());
            $findWorkerSalaryObj = $this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TXN)->findOneBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1));
            $findWorkingTypeObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_WORKING_TYPE_TXN)->findOneBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1));
            $findExpertObj = $this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_TXN)->findBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1));
            $expertise_Arr = array();
            if($findExpertObj){
                $i = 0;
                foreach($findExpertObj as $expertObj){
                    $expertise_Arr[$i++] = $expertObj->getExpertTypeFk()->getExpertTypePk();
                }
            }
            $empstatus=$empMasterObj->getStatus();
            return array(
                'empID' => $empID,
                'assignEmpID' => $empMasterObj->getEmployeeId(),
                'workerName' => $empPerObj->getPersonName(),
                'relationShip' => $empPerObj->getRelationshipType(),
                'gender' => $empPerObj->getGender(),
                'mobile' => $empPerObj->getMobileNo(),
                'phone' => $empPerObj->getTelephoneNo(),
                'joiningDate' => date_format($empMasterObj->getJoiningDate(), 'Y-m-d'),
                'statusID' => $empMasterObj->getStatus()->getEmpStatusPk(),
                'salaryTypeID' => $findWorkerSalaryObj->getWorkerSalaryTypeFk()->getSalaryTypePk(),
                'amountPay' => $empMasterObj->getGrossSalary(),            
                'jobProfile' => $empMasterObj->getJobProfile(),
                'branchOffice' => $empMasterObj->getBranchOfficeCode()->getPkid(),
                'expertise' => json_encode($expertise_Arr),
                'address' => $empPerObj->getShortAddress()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function saveWorkerDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {
            $worker_id = $request->request->get('txt_employee_id');
            $worker_name = $request->request->get('txt_worker_name');
            $worker_parent = $request->request->get('txt_worker_parents');
            $join_date = $request->request->get('txt_joining_date');
            $branch_office_id = $request->request->get('txt_branch_office');
            $status = $request->request->get('txt_status');
            $mobile = $request->request->get('txt_mobile');
            $phone = $request->request->get('txt_phone');
            $salary_type_id = $request->request->get('txt_salary_type');
            $salary_amount = $request->request->get('txt_salary_amount');
            $address = $request->request->get('txt_address');
            if (null !== $request->request->get('txt_gender')) {
                $gender = $request->request->get('txt_gender');
            } else {
                $gender = '';
            }
            // insert common person
            if ($worker_id == '') {
                $empPerObj = new CmnPerson();
                $empMasterObj = '';
            } else {
                $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($worker_id);
                $empPerObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($empMasterObj->getPersonFk()->getPersonPk());
            }
            $this->saveWorkerPersonalDetails($worker_id,$empPerObj,$worker_name,$worker_parent,$gender,$mobile,$phone,$address);
            
            //insert employee master, and return object
            $empMasterObj = $this->saveWorkerJobDetails($worker_id,$empMasterObj,$empPerObj,$salary_amount,$join_date,$status,$branch_office_id);          
                        
            //add multiple or single worker expertise  
            $expert_Arr = array();
            if (is_string($request->request->get('txt_worker_expertise'))) {
                $expert_Arr[0] = $request->request->get('txt_worker_expertise'); //for only one 
            } else {
                $expert_Arr = $request->request->get('txt_worker_expertise');     //for more than one       
            } 
            if ($worker_id == '') {
                //first time entry worker expertise
                foreach ($expert_Arr as $expertise_id) { 
                    $this->saveWorkerExpertise($empMasterObj, $expertise_id);                  
                }
            } else {
                //update worker expertise
                $find_all_expertise = $this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_TXN)->findBy(array('empMasterFk' => $worker_id, 'recordActiveFlag' => 1));
                $i = 0;
                $existing_expertise_Arr = array();
                foreach ($find_all_expertise as $expertiseObj) {
                    $existing_expertise_Arr[$i++] = $expertiseObj->getExpertTypeFk()->getExpertTypePk();
                }
  
                //for insert newly selected expertise from the UI
                foreach ($expert_Arr as $expertise_id) {
                    //check worker expertise is already in the database
                    if (!in_array($expertise_id, $existing_expertise_Arr)) {
                        $this->saveWorkerExpertise($empMasterObj, $expertise_id);                        
                    }
                }

                //for delete roles, ie remove from the UI 
                foreach ($existing_expertise_Arr as $exist_expertise) {
                    if (!in_array($exist_expertise, $expert_Arr)) {
                        //delete worker expertise   
                        $this->deleteWorkerExpertise($exist_expertise);                      
                    }
                }
            }
            //add worker wage type 
            $this->saveWorkerWageType($worker_id, $salary_type_id, $empMasterObj);
                    
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        if ($worker_id == '') {
            $msg = 'Worker detail has been saved successfully';
        } else {
            $msg = 'Worker detail has been updated successfully';
        }
        return array(
            'msg' => $msg,
            'assignEmpID' => $empMasterObj->getEmployeeId(),
            'employeeID' => $empMasterObj->getEmployeePk()
        );
    }
    
    public function deleteWorkerExpertise($exist_expertise) {
        try {
            $findExpertiseObj = $this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_TXN)->findOneBy(array('expertTypeFk' => $exist_expertise, 'recordActiveFlag' => 1));                     
            $findExpertiseObj->setRecordActiveFlag(0);
            $findExpertiseObj->setRecordUpdateDate(new \DateTime('NOW'));
            $findExpertiseObj->setApplicationUserId($this->session->get('EMPID'));
            $findExpertiseObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
         }
        catch(\Exception $ex){
              throw new \Exception($ex->getMessage());
        }      
        return;
    }
    
    public function saveWorkerExpertise($empMasterObj, $expertise_id) {
        try {
            $emp_expertise_txn_obj = new EmpWorkerExpertMasterTxn();
            $emp_expertise_txn_obj->setEmpMasterFk($empMasterObj);
            $emp_expertise_txn_obj->setExpertTypeFk($this->em->getRepository(EmployeeConstant::ENT_WORKER_EXPERT_MASTER)->find($expertise_id));
            $emp_expertise_txn_obj->setRecordActiveFlag(1);
            $emp_expertise_txn_obj->setRecordInsertDate(new \DateTime('NOW'));
            $emp_expertise_txn_obj->setApplicationUserId($this->session->get('EMPID'));
            $emp_expertise_txn_obj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->persist($emp_expertise_txn_obj);
            $this->em->flush();
         }
        catch(\Exception $ex){
              throw new \Exception($ex->getMessage());
        }      
        return;
    }
    
    public function saveWorkerPersonalDetails($worker_id,$empPerObj,$worker_name,$worker_parent,$gender,$mobile,$phone,$address) {
        try {
            $empPerObj->setPersonName($worker_name);
            $empPerObj->setRelationshipType($worker_parent);
            $empPerObj->setGender($gender);
            $empPerObj->setMobileNo($mobile);
            $empPerObj->setTelephoneNo($phone);
            $empPerObj->setShortAddress($address);
            $empPerObj->setApplicationUserId($this->session->get('EMPID'));
            $empPerObj->setApplicationUserIpAddress($this->session->get('IP'));
            if ($worker_id == '') {
                $empPerObj->setRecordActiveFlag(1);
                $empPerObj->setRecordInsertDate(new \Datetime('NOW'));              
                $this->em->persist($empPerObj);
            } else {
                $empPerObj->setRecordUpdateDate(new \Datetime('NOW'));              
            }
            $this->em->flush();
         }
        catch(\Exception $ex){
              throw new \Exception($ex->getMessage());
             }
        
        return;
    }
    public function saveWorkerJobDetails($worker_id,$empMasterObj,$empPerObj,$salary_amount,$join_date,$status,$branch_office_id) {
        try {
            if ($worker_id == '') {
                $empMasterObj = new EmpEmployeeMaster();
                //Auto generate  Worker Employee Id
                $autoGenWorkerID = $this->generateAutoWorkerID();
                $empMasterObj->setEmployeeId($autoGenWorkerID);
            }          
            $empMasterObj->setPersonFk($empPerObj);
            $empMasterObj->setGrossSalary($salary_amount);
            $empMasterObj->setJoiningDate(new \Datetime($join_date));          
            $empMasterObj->setStatus($this->em->getRepository(EmployeeConstant::ENT_EMP_STATUS_MASTER)->find($status));
            $empMasterObj->setEmployementTypeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYMENT_TYPE_MASTER)->find(2));
            $empMasterObj->setBranchOfficeCode($this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE)->find($branch_office_id));                   
            
            if ($worker_id == '') {
                $empMasterObj->setStatus($this->em->getRepository(CommonConstant::ENT_EMPLOYEE_STATUS_MASTER)->find(1));
                $empMasterObj->setRecordActiveFlag(1);
                $empMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                $empMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $empMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empMasterObj);
            } else {
                $empMasterObj->getRecordUpdateDate(new \Datetime('NOW'));
                $empMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $empMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();
         }
        catch(\Exception $ex){
              throw new \Exception($ex->getMessage());
             }
        
        return $empMasterObj;
    }
    public function saveWorkerWageType($worker_id, $salary_type_id, $empMasterObj) {
        try {
            if ($worker_id == '') {
                $EmpWorkerSalaryTxnObj = new EmpWorkerSalaryTypeMasterTxn();
            } else {
                $findWorkerSalaryObj = $this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TXN)->findOneBy(array('empMasterFk' => $worker_id, 'recordActiveFlag' => 1));
                $EmpWorkerSalaryTxnObj = $this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TXN)->find($findWorkerSalaryObj->getEmpExpertPk());
            }
            $EmpWorkerSalaryTxnObj->setEmpMasterFk($empMasterObj);
            $EmpWorkerSalaryTxnObj->setWorkerSalaryTypeFk($this->em->getRepository(EmployeeConstant::ENT_WORK_SALARY_TYPE_MASTER)->find($salary_type_id));
            $EmpWorkerSalaryTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $EmpWorkerSalaryTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            if ($worker_id == '') {
                $EmpWorkerSalaryTxnObj->setRecordActiveFlag(1);
                $EmpWorkerSalaryTxnObj->setRecordInsertDate(new \Datetime('NOW'));            
                $this->em->persist($EmpWorkerSalaryTxnObj);
            } else {
                $EmpWorkerSalaryTxnObj->getRecordUpdateDate(new \Datetime('NOW'));              
            }
            $this->em->flush();
        }
        catch(\Exception $ex){
            throw new \Exception($ex->getMessage());
        }
        
        return;
    }

    public function generateAutoWorkerID() {
        try {
            $worrker_generate_ID = '';
            $queryString = "SELECT emp.employeeId empID
                                FROM TashiCommonBundle:EmpEmployeeMaster emp
                                WHERE emp.employeePk = ( SELECT MAX(e.employeePk)
                                                         FROM TashiCommonBundle:EmpEmployeeMaster e
                                                         WHERE e.employementTypeFk = 2 )";
            $query = $this->em->createQuery($queryString);
            $result = $query->getResult();
            if ($result) {
                $max_existing_worker_ID = $result[0]['empID'];
                $generated_id = (int) substr($max_existing_worker_ID, 2, strlen($max_existing_worker_ID)) + 1;
            } else {
                $generated_id = 1; // firstly generated no.
            }
            $worrker_generate_ID = 'W-' . $generated_id;
          
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        return $worrker_generate_ID;
    }

    public function saveEmpPersonalDetails($request) {
        $conn = $this->em->getConnection();
        $empID = $request->request->get('empID');
        $employee_ID = $request->request->get('txt_employee_id');
        $fileupload = $request->files->get('txt_emp_pro_pic');
        $uploadedFiles = array();
        $validFileTypes = array('image/jpeg', 'image/jpg', 'image/gif', 'image/png', 'image/bmp');
        $prevfilepath = '';
        try {
            $conn->beginTransaction();
            //check already exist employee ID when first time entry
            $emp_ID_Flag = 0;
            if ($empID == '') {
                $SearchEmpIdObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->findBy(array('employeeId' => $employee_ID, 'recordActiveFlag' => 1));
                if ($SearchEmpIdObj) {
                    $emp_ID_Flag = 1;
                    return array('emp_ID_Flag' => $emp_ID_Flag, 'msg' => 'Entry Emplooyee ID already exist !');
                }
            } else {
                $queryString = "SELECT emp
                               FROM TashiCommonBundle:EmpEmployeeMaster emp 
                               WHERE emp.employeeId = :empID
                               AND emp.employeePk != :empPk ";
                $query = $this->em->createQuery($queryString)
                        ->setParameters(array('empID' => $employee_ID, 'empPk' => $empID));
                $result = $query->getResult();
                if ($result) {
                    $emp_ID_Flag = 1;
                    return array('emp_ID_Flag' => $emp_ID_Flag, 'msg' => 'Entry Emplooyee ID already exist !');
                }
            }

            $txt_emp_firstname = $request->request->get('txt_emp_firstname');
            $txt_emp_lastname = $request->request->get('txt_emp_lastname');
            $txt_emp_middlename = $request->request->get('txt_emp_middlename');
            $txt_emp_age = $request->request->get('txt_emp_dob');
            $txt_emp_guardian = $request->request->get('txt_father_name');
            $txt_emp_nation = $request->request->get('txt_emp_nation');
            $txt_emp_religion = $request->request->get('txt_emp_religion');

            if (null !== $request->request->get('txt_emp_gender')) {
                $txt_emp_gender = $request->request->get('txt_emp_gender');
            } else {
                $txt_emp_gender = '';
            }

            if (null !== $request->request->get('txt_emp_marital_status')) {
                $txt_emp_marital_status = $request->request->get('txt_emp_marital_status');
            } else {
                $txt_emp_marital_status = '';
            }

            //---insert into cmn_person table------//
            $document = '';
            if ($empID == '') {
                $empPerObj = new CmnPerson();
                $isDocNew = true;
            } else { //update part
                $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
                $empPerObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($empMasterObj->getPersonFk()->getPersonPk());
                if ($empPerObj->getPictureFk()) {
                    $isDocNew = false;
                    $document = $empPerObj->getPictureFk();
                } else {
                    $isDocNew = true;
                }
            }

            //upload profile picture        
            if ($document) {
                $prevfilepath = $document->getPath();
            }

            if (isset($fileupload)) {
                $path = 'upload/EMP/OFFICE/';
                $fuploadresult = $this->commonService->UploadFile($fileupload, $path, 1, $validFileTypes);
                if ($fuploadresult['code'] == 1) {
                    $uploadedFiles[] = $fuploadresult['fullpath'];
                    //save image in document master
                    if (!$document) {
                        $document = new CmnDocumentMaster();
                        $document->setRecordActiveFlag(1);
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                        $isDocNew = true;
                    } else {
                        $document->setRecordInsertDate(new \DateTime("NOW"));
                        $document->setApplicationUserId($this->session->get('EMPID'));
                        $document->setApplicationUserIpAddress($this->session->get('IP'));
                    }
                    $document->setPath($path . $fuploadresult['newname']);
                    $document->setOriginalName($fuploadresult['oriname']);
                    $document->setSystemName($fuploadresult['newname']);
                    $document->setDocType($fuploadresult['ext']);
                    if ($isDocNew) {
                        $this->em->persist($document);
                    }
                    $this->em->flush($document);
                    if (file_exists($prevfilepath)) {
                        unlink($prevfilepath);
                    }
                } else {
                    $conn->rollBack();
                    foreach ($uploadedFiles as $file) {
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                    return array('code' => 0, 'msg' => $fuploadresult['msg']);
                }
            }
            //end upload profile picture            
            //  COMMON PERSON     

            if ($isDocNew) {
                if ($document !== '') {
                    $empPerObj->setPictureFk($document);
                }
            }

            $empPerObj->setFirstName($txt_emp_firstname);
            $empPerObj->setMiddleName($txt_emp_middlename);
            $empPerObj->setLastName($txt_emp_lastname);
            $empPerObj->setPersonName($txt_emp_firstname . ' ' . $txt_emp_middlename . ' ' . $txt_emp_lastname);

            $empPerObj->setDateOfBirth(new \Datetime($txt_emp_age));
            $empPerObj->setMaritalStatus($txt_emp_marital_status);

            $empPerObj->setContactFatherName($txt_emp_guardian);
            $empPerObj->setNationality($this->em->getRepository(EmployeeConstant::ENT_EMP_NATIONALITY_MASTER)->find($txt_emp_nation));
            $empPerObj->setReligion($this->em->getRepository(EmployeeConstant::ENT_EMPLOYMENT_RELIGION_MASTER)->find($txt_emp_religion));
            $empPerObj->setGender($txt_emp_gender);

            if ($empID == '') {
                $empPerObj->setRecordActiveFlag(1);
                $empPerObj->setRecordInsertDate(new \Datetime('NOW'));
                $empPerObj->setApplicationUserId($this->session->get('EMPID'));
                $empPerObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empPerObj);
            } else {
                $empPerObj->setRecordUpdateDate(new \Datetime('NOW'));
                $empPerObj->setApplicationUserId($this->session->get('EMPID'));
                $empPerObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();

            /*             * ********End of Common Person*** */
            
            
            /*             * ******** EMPLOYEE MASTER ******* */
            if ($empID == '') {
                $empMasterObj = new EmpEmployeeMaster();
            }

            $empMasterObj->setPersonFk($empPerObj);
            $empMasterObj->setEmployementTypeFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYMENT_TYPE_MASTER)->find(1));

            if ($empID == '') {
                $empMasterObj->setEmployeeId($employee_ID);
                $empMasterObj->setRecordActiveFlag(1);
                $empMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                $empMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $empMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empMasterObj);
            } else {
                $empMasterObj->getRecordUpdateDate(new \Datetime('NOW'));
                $empMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $empMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();

            $conn->commit();
            $returncode = 1;
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            foreach ($uploadedFiles as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            $returncode = 0;
            $returnmsg = 'Unable to process due to an unexpected server error. Error:' . $ex->getMessage();
        }

        if ($empID == '') {
            $returnmsg = 'Record Save Successfully';
        } else {
            $returnmsg = 'Record Update Successfully';
        }

        return array(
            'code' => $returncode,
            'msg' => $returnmsg,
            'assignEmpID' => $empMasterObj->getEmployeeId(),
            'person_name' => $empPerObj->getPersonName(),
            'empID' => $empMasterObj->getEmployeePk(),
            'emp_ID_Flag' => $emp_ID_Flag
        );
    }

    public function addEmpJobDetails($request) {
        try {
            $dataUI = json_decode($request->getContent());

            $empID = $dataUI->empID;
            $emp_job_title_ID = $dataUI->txt_emp_job_title;
            $emp_joining_date = $dataUI->txt_emp_joiningdate;
            $emp_salary_grade = strtoupper($dataUI->txt_emp_salary_grade);
            $emp_gross_salary = $dataUI->txt_emp_gross_salary;
            $department_id = $dataUI->txt_department;
            $branch_id = $dataUI->txt_branch;
            $emp_job_profile = $dataUI->txt_emp_job_profile;

            $empMasterObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
            $empMasterObj->setSalaryGrade($emp_salary_grade);
            $empMasterObj->setGrossSalary($emp_gross_salary);
            $empMasterObj->setJoiningDate(new \Datetime($emp_joining_date));
            $empMasterObj->setEmpJobTitleFk($this->em->getRepository(EmployeeConstant::ENT_EMP_JOB_TITLE_MASTER)->find($emp_job_title_ID));
            $empMasterObj->setStatus($this->em->getRepository(EmployeeConstant::ENT_EMP_STATUS_MASTER)->find(1));
            $empMasterObj->setDepartmentFk($this->em->getRepository(EmployeeConstant::ENT_EMP_DEPT_MASTER)->find($department_id));
            $empMasterObj->setBranchOfficeCode($this->em->getRepository(CommonConstant::ENT_BRANCH_OFFICE)->find($branch_id));
            $empMasterObj->setJobProfile($emp_job_profile);
            $empMasterObj->setRecordUpdateDate(new \Datetime('now'));
            $empMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $empMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {

            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Record Save Successfully');
    }

    public function cmnLoadLocationList($load_location_key, $key) {
        try {
            switch ($key) {
                case 'S': //load state, for the particular country
                    $result = $this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->findBy(array('countryCodeFk' => $load_location_key, 'recordActiveFlag' => 1));
                    break;
                case 'D'://load district, for the particular state
                    $result = $this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->findBy(array('stateFk' => $load_location_key, 'recordActiveFlag' => 1));
                    break;
                case 'C'://load city, for the particular district
                    $result = $this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->findBy(array('districtFk' => $load_location_key, 'recordActiveFlag' => 1));
                    break;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return array('key' => $key, 'loadList' => $result);
    }

    public function saveAddressDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {
            $dataUI = json_decode($request->getContent());
            $empID = $dataUI->empID;
            $add_txn_ID = $dataUI->txn_addTxnID;
            $address_type_ID = $dataUI->txt_address_type_ID;
            $address1 = $dataUI->txt_address1;
            $address2 = $dataUI->txt_address2;
            $countryID = $dataUI->txt_country;
            $stateID = $dataUI->txt_state;
            $districtID = $dataUI->txt_district;
            $cityID = $dataUI->txt_city;
            $block_village = $dataUI->txt_block_village;
            $postal_code = $dataUI->txt_postal_code;
            $landmark = $dataUI->txt_landmark;

            if (isset($dataUI->txt_check_primary)) {
                $check_primary = $dataUI->txt_check_primary;
            } else {
                $check_primary = 0;
            }
            //check primary address key     
            $check_primary_add_flag = 0;
            $parameterArr = array();
            if ($check_primary == 1) {
                if ($add_txn_ID == '') {
                    $queryString = "SELECT COUNT(a.isPrimaryAddress) primaryAddressKey 
                                     FROM TashiCommonBundle:EmpAddressTxn a 
                                     WHERE a.empMasterFk =:empID  
                                           AND a.isPrimaryAddress = :flagKey
                                           AND a.recordActiveFlag = :recordActiv ";
                    $parameterArr['empID'] = $empID;
                    $parameterArr['flagKey'] = 1;
                    $parameterArr['recordActiv'] = 1;
                } else {
                    $queryString = "SELECT COUNT(a.isPrimaryAddress) primaryAddressKey 
                                    FROM TashiCommonBundle:EmpAddressTxn a 
                                    WHERE a.empMasterFk =:empID  
                                          AND a.isPrimaryAddress = :flagKey
                                          AND a.recordActiveFlag = :recordActiv 
                                          AND a.empAddressPk != :empAddressTxnID";
                    $parameterArr['empID'] = $empID;
                    $parameterArr['flagKey'] = 1;
                    $parameterArr['recordActiv'] = 1;
                    $parameterArr['empAddressTxnID'] = $add_txn_ID;
                }

                $query = $this->em->createQuery($queryString)
                        ->setParameters($parameterArr);
                $result = $query->getSingleResult();

                if ($result['primaryAddressKey'] == 1) {
                    $check_primary_add_flag++;
                    return array('msg' => 'Primary address already exist !', 'check_primary_add_flag' => $check_primary_add_flag);
                }
            }
            // insert address Master table ( CmnLocationAddressMaster )   
            if ($add_txn_ID == '') {
                $addMasterObj = new CmnLocationAddressMaster();
            } else {
                $empAddObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->find($add_txn_ID);
                $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($empAddObj->getAddressMasterFk()->getAddressPk());
            }

            $addMasterObj->setAddress1($address1);
            $addMasterObj->setAddress2($address2);
            $addMasterObj->setBlockVillage($block_village);
            $addMasterObj->setPinNumber($postal_code);
            $addMasterObj->setLandmark($landmark);
            $addMasterObj->setCountryCodeFk($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($countryID));
            $addMasterObj->setStateCodeFk($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($stateID));
            $addMasterObj->setDistrictFk($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($districtID));
            $addMasterObj->setCityCodeFk($this->em->getRepository(CommonConstant::ENT_CITY_MASTER)->find($cityID));
            $addMasterObj->setAddressTypeFk($this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($address_type_ID));
            if ($add_txn_ID == '') {
                $addMasterObj->setRecordActiveFlag(1);
                $addMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                $addMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $addMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($addMasterObj);
            } else {
                $addMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
                $addMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $addMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();


            // insert employee address relation table ( EmpAddressTxn )
            if ($add_txn_ID == '') {
                $empAddObj = new EmpAddressTxn();
            }
            $empAddObj->setAddressMasterFk($addMasterObj);
            $empAddObj->setEmpMasterFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
            $empAddObj->setIsPrimaryAddress($check_primary);
            if ($add_txn_ID == '') {
                $empAddObj->setRecordActiveFlag(1);
                $empAddObj->setRecordInsertDate(new \Datetime('NOW'));
                $empAddObj->setApplicationUserId($this->session->get('EMPID'));
                $empAddObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empAddObj);
            } else {
                $empAddObj->setRecordUpdateDate(new \Datetime('NOW'));
                $empAddObj->setApplicationUserId($this->session->get('EMPID'));
                $empAddObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }


        if ($add_txn_ID == '') {
            $msg = 'Record Inserted Successfully';
        } else {
            $msg = 'Record Update Successfully';
        }
        return array('msg' => $msg,
            'addTxnID' => $empAddObj->getEmpAddressPk(),
            'check_primary_add_flag' => $check_primary_add_flag,
            'empAddDetails' => $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->findBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1))
        );
    }

    public function retriveAddressDetail($addMasterID) {
        try {
            $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addMasterID);
            $addEmpTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->findOneByAddressMasterFk($addMasterID);

            return array(
                'addTxnID' => $addEmpTxnObj->getEmpAddressPk(),
                'address1' => $addMasterObj->getAddress1(),
                'address2' => $addMasterObj->getAddress2(),
                'blockVillage' => $addMasterObj->getBlockVillage(),
                'postalCode' => $addMasterObj->getPinNumber(),
                'landmark' => $addMasterObj->getLandmark(),
                'isPrimary' => $addEmpTxnObj->getIsPrimaryAddress(),
                'countryID' => $addMasterObj->getCountryCodeFk()->getCountryPk(),
                'stateID' => $addMasterObj->getStateCodeFk()->getStatePk(),
                'districtID' => $addMasterObj->getDistrictFk()->getPkid(),
                'cityID' => $addMasterObj->getCityCodeFk()->getCityPk(),
                'addressTypeID' => $addMasterObj->getAddressTypeFk()->getAddressTypePk()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteEmpAddressDetails($addMasterID) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {

            $addMasterObj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addMasterID);
            $addMasterObj->setRecordActiveFlag(0);
            $addMasterObj->setRecordUpdateDate(new \Datetime('now'));
            $addMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $addMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $findAddEmpTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->findOneByAddressMasterFk($addMasterID);
            // $addEmpTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_ADD_TXN)->find($findAddEmpTxnObj->getEmpAddressPk());
            $findAddEmpTxnObj->setRecordActiveFlag(0);
            $findAddEmpTxnObj->setRecordUpdateDate(new \Datetime('now'));
            $findAddEmpTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $findAddEmpTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();

            return array('msg' => 'Deleted record successfully');
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
    }

    public function saveEmpContactDetails($request, $mode) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {

            $dataUI = json_decode($request->getContent());
            $contact_person_id = $dataUI->txt_contact_person_id;
            $contact_flag = 0;

            //logic: $mode value I => insert, U => update.
            // check only when insert, if already exist contact list
            if ($mode == 'I') {
                if (!empty($contact_person_id) && !is_null($contact_person_id)) {
                    $contact_flag = 1;
                    return array('contact_flag' => $contact_flag,
                        'msg' => 'Already exist contact details. Please edit to update or newly add !'
                    );
                }
            }

            $empID = $dataUI->empID;
            $emp_email_private = $dataUI->txt_emp_private_email;
            $emp_email_office = $dataUI->txt_emp_official_email;
            $emp_website = $dataUI->txt_emp_website;
            $emp_phone = $dataUI->txt_emp_contact_phone;

            $empObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
            $cmnPersonObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($empObj->getPersonFk()->getPersonPk());
            $cmnPersonObj->setEmailId($emp_email_private);
            $cmnPersonObj->setEmailIdOffice($emp_email_office);
            $cmnPersonObj->setWebsite($emp_website);
            $cmnPersonObj->setTelephoneNo($emp_phone);
            $this->em->flush();

            //add multiple or single mobile no
            $emp_mobileArr = array();
            if (is_string($dataUI->txt_emp_contact_mobile)) {
                $emp_mobileArr[0] = $dataUI->txt_emp_contact_mobile; //for only one 
            } else {
                $emp_mobileArr = $dataUI->txt_emp_contact_mobile;     //for more than one       
            }

            //logic: validate, do this code only when if mobile field is not blank
            if ($emp_mobileArr[0] !== '') {
                $this->cmnContactAddContactNo($emp_mobileArr, $cmnPersonObj, 'M');
            }

            $conn->commit();

            //message return
            if ($mode == 'I') {
                $msg = 'Record Save Succesfully';
            } else {
                $msg = 'Record Update Succesfully';
            }

            return array('contact_flag' => $contact_flag,
                'msg' => $msg,
                'contactDetails' => $this->loadEmpContactDetails($empID)
            );
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
    }

    public function updateEmpMobileNo($mobMasterID, $request) {
        try {
            $mobile_no = $request->request->get('txt_mob_no');
            $loopIndexNo = $request->request->get('loopIndexNo');
            $cmnMobObj = $this->em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->find($mobMasterID);
            $cmnMobObj->setMobileNo($mobile_no);
            $cmnMobObj->setRecordUpdateDate(new \Datetime('NOW'));
            $cmnMobObj->setApplicationUserId($this->session->get('EMPID'));
            $cmnMobObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            return array('mobMasterID' => $mobMasterID,
                'loopIndexNo' => $loopIndexNo,
                'mobileNo' => $mobile_no,
                'msg' => 'Updated mobile no. successfully.'
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteEmpMobileNo($mobMasterID) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();

        try {
            $cmnPersonObj = $this->em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->find($mobMasterID);
            $cmnPersonObj->setRecordActiveFlag(0);
            $cmnPersonObj->setRecordUpdateDate(new \Datetime('now'));
            $cmnPersonObj->setApplicationUserId($this->session->get('EMPID'));
            $cmnPersonObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $findThisObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findOneByMobileNoFk($mobMasterID);
            $cmnPerMobTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->find($findThisObj->getPkid());
            $cmnPerMobTxnObj->setRecordActiveFlag(0);
            $cmnPerMobTxnObj->setRecordUpdateDate(new \Datetime('now'));
            $cmnPerMobTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $cmnPerMobTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();
            $msg = 'Deleted mobile no succesfully';
            return $msg;
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
    }

    public function loadEmpContactDetails($empID) {
        try {
            $empObj = $this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID);
            $personObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($empObj->getPersonFk()->getPersonPk());
            $cmnPerMobTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findBy(array('personFk' => $empObj->getPersonFk()->getPersonPk(), 'recordActiveFlag' => 1));
            return array('personObj' => $personObj,
                'cmnPerMobTxnObj' => $cmnPerMobTxnObj
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function cmnContactAddContactNo($mobileOrPhoneNosArr, $cmnPersonObj, $keyType) {

        try {
            foreach ($mobileOrPhoneNosArr as $mobPhoneNo) {
                //add mobile master table ( CmnMobileNoMaster )
                $cmnMobPhoneObj = new CmnMobileNoMaster();
                $cmnMobPhoneObj->setMobileNo($mobPhoneNo);
                $cmnMobPhoneObj->setContactType($keyType);
                $cmnMobPhoneObj->setRecordActiveFlag(1);
                $cmnMobPhoneObj->setRecordInsertDate(new \Datetime('NOW'));
                $cmnMobPhoneObj->setApplicationUserId($this->session->get('EMPID'));
                $cmnMobPhoneObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($cmnMobPhoneObj);
                $this->em->flush();

                //add employee mobile relation table ( EmpContactMobileNoTxn )
                $empMobPhoneTxnObj = new EmpContactMobileNoTxn();
                $empMobPhoneTxnObj->setMobileNoFk($cmnMobPhoneObj);
                $empMobPhoneTxnObj->setPersonFk($cmnPersonObj);
                $empMobPhoneTxnObj->setRecordActiveFlag(1);
                $empMobPhoneTxnObj->setRecordInsertDate(new \Datetime('NOW'));
                $empMobPhoneTxnObj->setApplicationUserId($this->session->get('EMPID'));
                $empMobPhoneTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empMobPhoneTxnObj);
                $this->em->flush();
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return;
    }

    public function retriveEmpContactDetials($personID) {
        try {

            $personObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($personID);
            $cmnPerMobTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findBy(array('personFk' => $personID, 'recordActiveFlag' => 1));
            return array(
                'email_private' => $personObj->getEmailId(),
                'email_office' => $personObj->getEmailIdOffice(),
                'website' => $personObj->getWebsite(),
                'phoneNo' => $personObj->getTelephoneNo(),
                'cmnPerMobTxnObj' => $cmnPerMobTxnObj
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteEmpContactDetials($request, $personID) {
        try {

            $cmnPersonObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($personID);
            $cmnPersonObj->setEmailId('');
            $cmnPersonObj->setWebsite('');
            $cmnPersonObj->setTelephoneNo('');
            $this->em->flush();

            $findPerMobTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findBy(array('personFk' => $personID, 'recordActiveFlag' => 1));
            foreach ($findPerMobTxnObj as $val) {
                //update person mobile txn
                $cmnPerMobTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->find($val->getPkid());
                $cmnPerMobTxnObj->setRecordActiveFlag(0);
                $cmnPerMobTxnObj->setRecordUpdateDate(new \Datetime('NOW'));
                $cmnPerMobTxnObj->setApplicationUserId($this->session->get('EMPID'));
                $cmnPerMobTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();

                //update mobile master
                $cmnMobileObj = $this->em->getRepository(CommonConstant::ENT_MOBILE_MASTER)->find($val->getMobileNoFk()->getPkid());
                $cmnMobileObj->setRecordActiveFlag(0);
                $cmnMobileObj->setRecordUpdateDate(new \Datetime('NOW'));
                $cmnMobileObj->setApplicationUserId($this->session->get('EMPID'));
                $cmnMobileObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->flush();
            }

            return array('msg' => 'Contact Record Deleted Successfully');
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function saveEmpBankDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {
            $bank_detail_id = $request->request->get('txt_bank_detail_id');
            $empID = $request->request->get('empID');
            $bank_name = $request->request->get('txt_bank_name');
            $branch_name = $request->request->get('txt_branch_name');
            $branch_code = $request->request->get('txt_branch_code');
            $account_type_ID = $request->request->get('txt_account_type');
            $MICR_Code = $request->request->get('txt_micr_code');
            $IFSC_Code = $request->request->get('txt_ifsc_code');
            $contact_no = $request->request->get('txt_contact_no');
            $account_no = $request->request->get('txt_account_no');
            $location = $request->request->get('txt_location');

            // insert bank master table ( CmnBankDetailsMaster )
            if ($bank_detail_id == '') {
                $bankMasterObj = new CmnBankDetailsMaster();
            } else {
                $bankMasterObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->find($bank_detail_id);
            }

            $bankMasterObj->setBankName($bank_name);
            $bankMasterObj->setBranchName($branch_name);
            $bankMasterObj->setBranchCode($branch_code);
            $bankMasterObj->setMicrCode($MICR_Code);
            $bankMasterObj->setIfscCode($IFSC_Code);
            $bankMasterObj->setContactNumber($contact_no);
            $bankMasterObj->setAccountNumber($account_no);
            $bankMasterObj->setLocation($location);
            $bankMasterObj->setAccountTypeMasterFk($this->em->getRepository(CommonConstant::ENT_CMN_BANK_ACC_TYPE)->find($account_type_ID));
            if ($bank_detail_id == '') {
                $bankMasterObj->setRecordActiveFlag(1);
                $bankMasterObj->setRecordInsertDate(new \Datetime('NOW'));
                $bankMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $bankMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($bankMasterObj);
            } else {
                $bankMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
                $bankMasterObj->setApplicationUserId($this->session->get('EMPID'));
                $bankMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            }

            $this->em->flush();

            // insert employee bank relation table ( EmpBankTxn )
            if ($bank_detail_id == '') {
                $empBankObj = new EmpBankTxn();
                $empBankObj->setBankMasterFk($bankMasterObj);
                $empBankObj->setEmpMasterFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
                $empBankObj->setRecordActiveFlag(1);
                $empBankObj->setRecordInsertDate(new \Datetime('NOW'));
                $empBankObj->setApplicationUserId($this->session->get('EMPID'));
                $empBankObj->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($empBankObj);
                $this->em->flush();
            }


            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        //message return
        if ($bank_detail_id == '') {
            $msg = "Record Inserted Successfully";
        } else {
            $msg = "Record Update Successfully";
        }
        return array('msg' => "Record Inserted Successfully",
            'bankDetailID' => $bankMasterObj->getBankPk(),
            'empBankDetail' => $this->em->getRepository(EmployeeConstant::ENT_EMP_BANK_TXN)->findBy(array('empMasterFk' => $empID, 'recordActiveFlag' => 1))
        );
    }

    public function retriveEmpBankDetails($bankMasterID) {
        try {
            $bankMasterObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->findOneBy(array('bankPk' => $bankMasterID, 'recordActiveFlag' => 1));
            return array(
                'bankMasterID' => $bankMasterID,
                'bankName' => $bankMasterObj->getBankName(),
                'branchName' => $bankMasterObj->getBranchName(),
                'branchCode' => $bankMasterObj->getBranchCode(),
                'accTypeID' => $bankMasterObj->getAccountTypeMasterFk()->getBankAccTypePk(),
                'MICRcode' => $bankMasterObj->getMicrCode(),
                'IFSCcode' => $bankMasterObj->getIfscCode(),
                'accNo' => $bankMasterObj->getAccountNumber(),
                'contactNo' => $bankMasterObj->getContactNumber(),
                'location' => $bankMasterObj->getLocation()
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteEmpBankDetails($bankMasterID) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {

            $empBankTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_BANK_TXN)->findOneBy(array('bankMasterFk' => $bankMasterID, 'recordActiveFlag' => 1));
            $empBankTxnObj->setRecordActiveFlag(0);
            $empBankTxnObj->setRecordUpdateDate(new \Datetime('NOW'));
            $empBankTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $empBankTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $bankMasterObj = $this->em->getRepository(CommonConstant::ENT_CMN_BANK_MASTER)->findOneBy(array('bankPk' => $bankMasterID, 'recordActiveFlag' => 1));
            $bankMasterObj->setRecordActiveFlag(0);
            $bankMasterObj->setRecordUpdateDate(new \Datetime('NOW'));
            $bankMasterObj->setApplicationUserId($this->session->get('EMPID'));
            $bankMasterObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }

        return array('msg' => 'Record deleted Successfully');
    }

    public function loadEmpDependentDetails($empID) {
        try {
            $empDependentObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPENDENT_TXN)->findBy(array('employeeMasterFk' => $empID, 'recordActiveFlag' => 1));
            $i = 0;
            $dependentArr = array();
            foreach ($empDependentObj as $val) {
                $dependentArr[$i]['dependent'] = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($val->getPersonFk()->getPersonPk());
                $dependentArr[$i]['mobile'] = $this->findMobileContactNos($val->getPersonFk()->getPersonPk());
                $i++;
            }
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $dependentArr;
    }

    public function findMobileContactNos($personID) {
        try {
            return $this->em->getRepository(EmployeeConstant::ENT_EMP_CONTACT_MOBILE_TXN)->findBy(array('personFk' => $personID, 'recordActiveFlag' => 1));
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function addEmpDependentDetails($request) {
        $conn = $this->em->getConnection();
        $conn->beginTransaction();
        try {
            $dataUI = json_decode($request->getContent());
            $empID = $dataUI->empID;
            $dependentID = $dataUI->txn_dependentID;
            $first_name = $dataUI->txt_first_name;
            $middle_name = $dataUI->txt_middle_name;
            $last_name = $dataUI->txt_last_name;
            $occupation = $dataUI->txt_occupation;
            $relation = $dataUI->txt_relation;
            $phone_no = $dataUI->txt_phone_no;
            $dob = $dataUI->txt_dob;
            $address = $dataUI->txt_address;

            if ($dependentID == '') {
                $personObj = new CmnPerson();
            } else {
                $personObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($dependentID);
            }

            $personObj->setFirstName($first_name);
            $personObj->setMiddleName($middle_name);
            $personObj->setLastName($last_name);
            $personObj->setPersonName($last_name . ' ' . $first_name . ' ' . $middle_name);
            $personObj->setOccupation($occupation);
            $personObj->setRelationshipType($relation);
            $personObj->setTelephoneNo($phone_no);
            $personObj->setDateOfBirth(new \Datetime($dob));
            $personObj->setShortAddress($address);
            if ($dependentID == '') {
                $personObj->setRecordInsertDate(new \Datetime('now'));
                $personObj->setApplicationUserId($this->session->get('EMPID'));
                $personObj->setApplicationUserIpAddress($this->session->get('IP'));
                $personObj->setRecordActiveFlag(1);
                $this->em->persist($personObj);
            } else {
                $personObj->setRecordUpdateDate(new \Datetime('now'));
                $personObj->setApplicationUserId($this->session->get('EMPID'));
                $personObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();

            if ($dependentID == '') {
                $empDependentTxnObj = new EmpDependentTxn();
            } else {
                $findDependentTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPENDENT_TXN)->findOneByPersonFk($personObj->getPersonPk());
                $empDependentTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPENDENT_TXN)->find($findDependentTxnObj->getDependentPk());
            }
            $empDependentTxnObj->setPersonFk($personObj);
            $empDependentTxnObj->setEmployeeMasterFk($this->em->getRepository(EmployeeConstant::ENT_EMPLOYEE_MASTER)->find($empID));
            $empDependentTxnObj->setRecordActiveFlag(1);
            if ($dependentID == '') {
                $empDependentTxnObj->setRecordInsertDate(new \Datetime('now'));
                $empDependentTxnObj->setApplicationUserId($this->session->get('EMPID'));
                $empDependentTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
                $empDependentTxnObj->setRecordActiveFlag(1);
                $this->em->persist($empDependentTxnObj);
            } else {
                $empDependentTxnObj->setRecordUpdateDate(new \Datetime('now'));
                $empDependentTxnObj->setApplicationUserId($this->session->get('EMPID'));
                $empDependentTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();


            //add multiple or single mobile no
            $dependent_mobileArr = array();
            if (is_string($dataUI->txt_emp_contact_mobile)) {
                $dependent_mobileArr[0] = $dataUI->txt_emp_contact_mobile; //for only one 
            } else {
                $dependent_mobileArr = $dataUI->txt_emp_contact_mobile;     //for more than one       
            }
            //logic: validate, if mobile field is blank
            if ($dependent_mobileArr[0] !== '') {
                $this->cmnContactAddContactNo($dependent_mobileArr, $personObj, 'M');
            }

            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollback();
            $this->em->close();
            throw new \Exception($ex->getMessage());
        }
        //message
        if ($dependentID == '') {
            $msg = 'Record Inserted Successfully';
        } else {
            $msg = 'Record Update Successfully';
        }

        return array('msg' => 'Record Inserted Successfully',
            'dependentID' => $personObj->getPersonPk(),
            'dependentDetails' => $this->loadEmpDependentDetails($empID),
            'dependentMobile' => $this->findMobileContactNos($personObj->getPersonPk())
        );
    }

    public function retriveEmpDependentDetails($dependentID) {
        try {
            $empDependentTxnObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($dependentID);
            return array(
                'dependentID' => $dependentID,
                'first_name' => $empDependentTxnObj->getFirstName(),
                'middle_name' => $empDependentTxnObj->getMiddleName(),
                'last_name' => $empDependentTxnObj->getLastName(),
                'occupation' => $empDependentTxnObj->getOccupation(),
                'relation' => $empDependentTxnObj->getRelationshipType(),
                'phone' => $empDependentTxnObj->getTelephoneNo(),
                'address' => $empDependentTxnObj->getShortAddress(),
                'dob' => date_format($empDependentTxnObj->getDateOfBirth(), 'Y-m-d'),
                'dependentMobile' => $this->findMobileContactNos($dependentID)
            );
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function deleteEmpDependentDetails($dependentID) {
        try {
            $findDependentTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPENDENT_TXN)->findOneByPersonFk($dependentID);
            $empDependentTxnObj = $this->em->getRepository(EmployeeConstant::ENT_EMP_DEPENDENT_TXN)->find($findDependentTxnObj->getDependentPk());
            $empDependentTxnObj->setRecordActiveFlag(0);
            $empDependentTxnObj->setRecordUpdateDate(new \Datetime('now'));
            $empDependentTxnObj->setApplicationUserId($this->session->get('EMPID'));
            $empDependentTxnObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $personObj = $this->em->getRepository(EmployeeConstant::ENT_CMN_PERSON)->find($dependentID);
            $personObj->setRecordActiveFlag(0);
            $personObj->setRecordUpdateDate(new \Datetime('now'));
            $personObj->setApplicationUserId($this->session->get('EMPID'));
            $personObj->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }

        return $msg = 'Record Delete Successfully';
    }

    /*     * ************************FROM ERP************************ */

    public function savingEmployeeDetails($request, $personId, $mode) {
        $conn = $this->em->getConnection();
        try {
            $conn->beginTransaction();
            $empId = $request->request->get('txtEmpNo');
            $fname = $request->request->get('first_name');
            $mname = $request->request->get('middle_name');
            $lname = $request->request->get('last_name');
            $fathername = $request->request->get('father_name');
            $mothername = $request->request->get('mother_name');
            $dob = $request->request->get('dob');
            $gender = $request->request->get('selGender');
            $marital = $request->request->get('marital_status');
            $desg = $request->request->get('designation');
            $bloodgroup = $request->request->get('blood_group');
            $religionui = $request->request->get('selReligion');
            $nationality = $request->request->get('txtnationality');
            $mobileNo = $request->request->get('txtMobileNo');
            $email = $request->request->get('txtEmail');
            $telNo = $request->request->get('txtTeleNo');
            $empTypeui = $request->request->get('drp_empType');
            if ('ins' == $mode) {
                $person = new TbCmnPerson();
            } else {
                $person = $this->em->getRepository(CommonConstant::ENT_CONTACT_PERSON_MASTER)->find($personId);
            }
            $religion = $this->em->getRepository('ERPCommonBundle:TbCmnPersonReligionMaster')->find($religionui);
            $empType = $this->em->getRepository(CommonConstant::ENTITY_HR_TYPE_OF_EMPLOYEE)->find($empTypeui);
            $person->setFirstName($fname);
            $person->setMiddleName($mname);
            $person->setLastName($lname);
            $person->setPersonName($fname . ' ' . $mname . ' ' . $lname);
            $person->setContactFatherName($fathername);
            $person->setContactMotherName($mothername);
            $person->setDateOfBirth(new \DateTime($dob));
            $person->setGender($gender);
            $person->setMaritalStatus($marital);
            $person->setDesignation($desg);
            $person->setBloodGroup($bloodgroup);
            $person->setReligion($religion);
            $person->setNationality($nationality);
            $person->setMobileNo($mobileNo);
            $person->setEmailId($email);
            $person->setTelephoneNo($telNo);
            if ('ins' == $mode) {
                $person->setRecordActiveFlag(1);
                $person->setRecordInsertDate(new \DateTime('NOW'));
                $person->setApplicationUserId($this->session->get('EMPID'));
                $person->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($person);
            } else {
                $person->setRecordUpdateDate(new \DateTime('NOW'));
                $person->setApplicationUserId($this->session->get('EMPID'));
                $person->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();

            if ('ins' == $mode) {
                $employeeMaster = new TbCmnEmployeeMaster();
                $employeeMaster->setPersonFk($this->em->getRepository(CommonConstant::ENT_CONTACT_PERSON_MASTER)->find($person->getPkid()));
                $employeeMaster->setEmployeeId($empId);
                $employeeMaster->setEmployementTypeMaster($empType);
                $employeeMaster->setEmpDesignation($desg);
                $employeeMaster->setRecordActiveFlag(1);
                $employeeMaster->setRecordInsertDate(new \DateTime('NOW'));
                $employeeMaster->setApplicationUserId($this->session->get('EMPID'));
                $employeeMaster->setApplicationUserIpAddress($this->session->get('IP'));
                $this->em->persist($employeeMaster);
            } else {
                $employeeMaster = $this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)->findOneByPersonFk($personId);
                $employeeMaster->setEmployementTypeMaster($empType);
                $employeeMaster->setEmpDesignation($desg);
                $employeeMaster->setRecordUpdateDate(new \DateTime('NOW'));
                $employeeMaster->setApplicationUserId($this->session->get('EMPID'));
                $employeeMaster->setApplicationUserIpAddress($this->session->get('IP'));
            }
            $this->em->flush();
            $empid = $employeeMaster->getPkid();
            if ('ins' == $mode) {
                $returnmsg = 'Employee information has been saved successfully';
            } else {
                $returnmsg = 'Employee information has been updated successfully';
            }
            $returncode = 1;
            $conn->commit();
        } catch (\Exception $ex) {
            $conn->rollBack();
            $returncode = 0;
            $returnmsg = 'Unable to retrieve product information. Error:' . $ex->getMessage();
        }
        $conn->close();
        return array('code' => $returncode, 'msg' => $returnmsg, 'empid' => $empid);
    }

    public function employeeCreateAddress($dataUI, $mode) {
        $employeeId = $dataUI->txt_EmployeeMaster;
        $address1 = $dataUI->address1;
        $address2 = $dataUI->address2;
        $country = $dataUI->country;
        $state = $dataUI->state;
        $district = $dataUI->district;
        $city = $dataUI->city;
        $route = $dataUI->route;
        $block = $dataUI->block;
        $pincode = $dataUI->zipcode;
        $postOffice = $dataUI->postOffice;
        $policeStation = $dataUI->policeStation;

        $landmark = $dataUI->landmark;
        $gpsLatitude = $dataUI->gpsLatitude;
        $gpsLongitude = $dataUI->gpsLongitude;
//                $custid=$dataUI->custid;
        $locality = $dataUI->locality;
        $addtype = $dataUI->addtype;
        try {

            //Address master new object
            if ($mode == 'ins') {
                $addobj = new TbCmnAddress();
            } else {
                $addrel = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->findByEmployeeFk($employeeId);
                foreach ($addrel as $data) {
                    $addTyppk = $data->getAddressFk()->getAddressTypeFk()->getAddressTypePk();
                    if ($addTyppk == $addtype) {
                        $addMasterpk = $data->getAddressFk()->getAddressPk();
                        $addobj = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addMasterpk);
                    }
                }
            }
//                   $addobj->setEntityId();
            $addobj->setAddress1($address1);
            $addobj->setAddress2($address2);
            $addobj->setCityName($city);
            $addobj->setRoute($route);
            $addobj->setBlockVillage($block);
            $addobj->setPinNumber($pincode);
            $addobj->setPostOffice($postOffice);
            $addobj->setPoliceStation($policeStation);
            $addobj->setLandmark($landmark);
            $addobj->setLocality($locality);
            $addobj->setGpsLatitude($gpsLatitude);
            $addobj->setGpsLogitude($gpsLongitude);
            $addobj->setCountryCode($this->em->getRepository(CommonConstant::ENT_COUNTRY_MASTER)->find($country));
            $addobj->setStateCode($this->em->getRepository(CommonConstant::ENT_STATE_MASTER)->find($state));
            $addobj->setDistrict($this->em->getRepository(CommonConstant::ENT_DISTRICT_MASTER)->find($district));
            $addobj->setAddressTypeFk($this->em->getRepository(CommonConstant::ENT_ADDTYPE_MASTER)->find($addtype));
            if ($mode == 'ins') {
                $addobj->setRecordActiveFlag(1);
                $this->em->persist($addobj);
            }


            $this->em->flush($addobj);

            //Customer address relation new object
            if ($mode == 'ins') {
                $cusAddRelation = new TbEmployeeAddressTxn();
                $cusAddRelation->setAddressFk($this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addobj->getAddressPk()));
                $cusAddRelation->setEmployeeFk($this->em->getRepository(CommonConstant::ENTITY_CMN_EMPLOYEE_MASTER)
                                ->find($employeeId));
                $cusAddRelation->setApprovalFlag(1);
                $cusAddRelation->setRecordActiveFlag(1);
                $this->em->persist($cusAddRelation);
                $this->em->flush($cusAddRelation);
            }
            return true;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
            return false;
        }
    }

    public function DeleteEmployeeAddress($addtxnId) {
        $conn = $this->em->getConnection();
        try {
            $conn->beginTransaction();
            $addtxn = $this->em->getRepository(CommonConstant::ENT_EMPPLOYEE_ADDRESS_TXN)->find($addtxnId);
            $addmasterid = $addtxn->getAddressFk()->getAddressPk();
            $addmaster = $this->em->getRepository(CommonConstant::ENT_ADD_MASTER)->find($addmasterid);

            $addtxn->setApprovalFlag(0);
            $addtxn->setRecordActiveFlag(0);
            $addtxn->setRecordUpdateDate(new \DateTime("NOW"));
            $addtxn->setApplicationUserId($this->session->get('EMPID'));
            $addtxn->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();

            $addmaster->setRecordActiveFlag(0);
            $addmaster->setRecordUpdateDate(new \DateTime("NOW"));
            $addmaster->setApplicationUserId($this->session->get('EMPID'));
            $addmaster->setApplicationUserIpAddress($this->session->get('IP'));
            $this->em->flush();
            $returnmsg = '';
            $returncode = 1;
            $empid = $addtxn->getEmployeeFk()->getPkid();
            $conn->commit();
        } catch (Exception $ex) {
            $conn->rollBack();
            $returnmsg = 'Unable to retrieve product information. Error:' . $ex->getMessage();
            $returncode = 0;
            $empid = '';
        }
        return array('msg' => $returnmsg, 'code' => $returncode, 'empid' => $empid);
    }

}

