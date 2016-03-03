<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpEmployeeMaster
 *
 * @ORM\Table(name="emp_employee_master", indexes={@ORM\Index(name="emp_person_id_fk", columns={"Person_Fk"}), @ORM\Index(name="hr_emp_type_id_idx", columns={"Employement_Type_FK"}), @ORM\Index(name="fk_job_title_idx", columns={"Emp_Job_Title_Fk"}), @ORM\Index(name="fk_job_profile_idx", columns={"Emp_Job_Profile_Fk"}), @ORM\Index(name="fk_emp_status_master_idx", columns={"Status"}), @ORM\Index(name="fk_branch_idx", columns={"Branch_Office_Code"}), @ORM\Index(name="fk_department_idx", columns={"department_fk"}), @ORM\Index(name="fk_sal_grade_idx", columns={"Salary_Grade"}), @ORM\Index(name="fk_branch_employee_idx", columns={"Company_Code"})})
 * @ORM\Entity
 */
class EmpEmployeeMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Employee_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $employeePk;

    /**
     * @var string
     *
     * @ORM\Column(name="Employee_Id", type="string", length=15, nullable=false)
     */
    private $employeeId;

    /**
     * @var string
     *
     * @ORM\Column(name="Salary_Grade", type="string", length=15, nullable=true)
     */
    private $salaryGrade;

    /**
     * @var string
     *
     * @ORM\Column(name="Gross_Salary", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $grossSalary;

    /**
     * @var string
     *
     * @ORM\Column(name="worker_wage", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $workerWage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Joining_Date", type="date", nullable=true)
     */
    private $joiningDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Emp_Designation", type="string", length=245, nullable=true)
     */
    private $empDesignation;

    /**
     * @var string
     *
     * @ORM\Column(name="Job_Profile", type="string", length=500, nullable=true)
     */
    private $jobProfile;

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=true)
     */
    private $recordActiveFlag;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Insert_Date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Update_Date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status", referencedColumnName="Emp_Status_Pk")
     * })
     */
    private $status;

    /**
     * @var \Tashi\CommonBundle\Entity\BranchMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\BranchMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Branch_Office_Code", referencedColumnName="Pkid")
     * })
     */
    private $branchOfficeCode;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpDepartmentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpDepartmentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="department_fk", referencedColumnName="Pkid")
     * })
     */
    private $departmentFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpJobTitleMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpJobTitleMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_Job_Title_Fk", referencedColumnName="Job_Title_Pk")
     * })
     */
    private $empJobTitleFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmploymentType
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmploymentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Employement_Type_FK", referencedColumnName="Employment_Type_Pk")
     * })
     */
    private $employementTypeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpJobProfileMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpJobProfileMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_Job_Profile_Fk", referencedColumnName="Job_Profile_Pk")
     * })
     */
    private $empJobProfileFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnPerson
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPerson")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Person_Fk", referencedColumnName="Person_Pk")
     * })
     */
    private $personFk;



    /**
     * Get employeePk
     *
     * @return integer
     */
    public function getEmployeePk()
    {
        return $this->employeePk;
    }

    /**
     * Set employeeId
     *
     * @param string $employeeId
     *
     * @return EmpEmployeeMaster
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    /**
     * Get employeeId
     *
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set salaryGrade
     *
     * @param string $salaryGrade
     *
     * @return EmpEmployeeMaster
     */
    public function setSalaryGrade($salaryGrade)
    {
        $this->salaryGrade = $salaryGrade;

        return $this;
    }

    /**
     * Get salaryGrade
     *
     * @return string
     */
    public function getSalaryGrade()
    {
        return $this->salaryGrade;
    }

    /**
     * Set grossSalary
     *
     * @param string $grossSalary
     *
     * @return EmpEmployeeMaster
     */
    public function setGrossSalary($grossSalary)
    {
        $this->grossSalary = $grossSalary;

        return $this;
    }

    /**
     * Get grossSalary
     *
     * @return string
     */
    public function getGrossSalary()
    {
        return $this->grossSalary;
    }

    /**
     * Set workerWage
     *
     * @param string $workerWage
     *
     * @return EmpEmployeeMaster
     */
    public function setWorkerWage($workerWage)
    {
        $this->workerWage = $workerWage;

        return $this;
    }

    /**
     * Get workerWage
     *
     * @return string
     */
    public function getWorkerWage()
    {
        return $this->workerWage;
    }

    /**
     * Set joiningDate
     *
     * @param \DateTime $joiningDate
     *
     * @return EmpEmployeeMaster
     */
    public function setJoiningDate($joiningDate)
    {
        $this->joiningDate = $joiningDate;

        return $this;
    }

    /**
     * Get joiningDate
     *
     * @return \DateTime
     */
    public function getJoiningDate()
    {
        return $this->joiningDate;
    }

    /**
     * Set empDesignation
     *
     * @param string $empDesignation
     *
     * @return EmpEmployeeMaster
     */
    public function setEmpDesignation($empDesignation)
    {
        $this->empDesignation = $empDesignation;

        return $this;
    }

    /**
     * Get empDesignation
     *
     * @return string
     */
    public function getEmpDesignation()
    {
        return $this->empDesignation;
    }

    /**
     * Set jobProfile
     *
     * @param string $jobProfile
     *
     * @return EmpEmployeeMaster
     */
    public function setJobProfile($jobProfile)
    {
        $this->jobProfile = $jobProfile;

        return $this;
    }

    /**
     * Get jobProfile
     *
     * @return string
     */
    public function getJobProfile()
    {
        return $this->jobProfile;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpEmployeeMaster
     */
    public function setRecordActiveFlag($recordActiveFlag)
    {
        $this->recordActiveFlag = $recordActiveFlag;

        return $this;
    }

    /**
     * Get recordActiveFlag
     *
     * @return integer
     */
    public function getRecordActiveFlag()
    {
        return $this->recordActiveFlag;
    }

    /**
     * Set recordInsertDate
     *
     * @param \DateTime $recordInsertDate
     *
     * @return EmpEmployeeMaster
     */
    public function setRecordInsertDate($recordInsertDate)
    {
        $this->recordInsertDate = $recordInsertDate;

        return $this;
    }

    /**
     * Get recordInsertDate
     *
     * @return \DateTime
     */
    public function getRecordInsertDate()
    {
        return $this->recordInsertDate;
    }

    /**
     * Set recordUpdateDate
     *
     * @param \DateTime $recordUpdateDate
     *
     * @return EmpEmployeeMaster
     */
    public function setRecordUpdateDate($recordUpdateDate)
    {
        $this->recordUpdateDate = $recordUpdateDate;

        return $this;
    }

    /**
     * Get recordUpdateDate
     *
     * @return \DateTime
     */
    public function getRecordUpdateDate()
    {
        return $this->recordUpdateDate;
    }

    /**
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return EmpEmployeeMaster
     */
    public function setApplicationUserIpAddress($applicationUserIpAddress)
    {
        $this->applicationUserIpAddress = $applicationUserIpAddress;

        return $this;
    }

    /**
     * Get applicationUserIpAddress
     *
     * @return string
     */
    public function getApplicationUserIpAddress()
    {
        return $this->applicationUserIpAddress;
    }

    /**
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return EmpEmployeeMaster
     */
    public function setApplicationUserId($applicationUserId)
    {
        $this->applicationUserId = $applicationUserId;

        return $this;
    }

    /**
     * Get applicationUserId
     *
     * @return string
     */
    public function getApplicationUserId()
    {
        return $this->applicationUserId;
    }

    /**
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return EmpEmployeeMaster
     */
    public function setCompanyCode($companyCode)
    {
        $this->companyCode = $companyCode;

        return $this;
    }

    /**
     * Get companyCode
     *
     * @return integer
     */
    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    /**
     * Set status
     *
     * @param \Tashi\CommonBundle\Entity\EmpStatusMaster $status
     *
     * @return EmpEmployeeMaster
     */
    public function setStatus(\Tashi\CommonBundle\Entity\EmpStatusMaster $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Tashi\CommonBundle\Entity\EmpStatusMaster
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set branchOfficeCode
     *
     * @param \Tashi\CommonBundle\Entity\BranchMaster $branchOfficeCode
     *
     * @return EmpEmployeeMaster
     */
    public function setBranchOfficeCode(\Tashi\CommonBundle\Entity\BranchMaster $branchOfficeCode = null)
    {
        $this->branchOfficeCode = $branchOfficeCode;

        return $this;
    }

    /**
     * Get branchOfficeCode
     *
     * @return \Tashi\CommonBundle\Entity\BranchMaster
     */
    public function getBranchOfficeCode()
    {
        return $this->branchOfficeCode;
    }

    /**
     * Set departmentFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpDepartmentMaster $departmentFk
     *
     * @return EmpEmployeeMaster
     */
    public function setDepartmentFk(\Tashi\CommonBundle\Entity\EmpDepartmentMaster $departmentFk = null)
    {
        $this->departmentFk = $departmentFk;

        return $this;
    }

    /**
     * Get departmentFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpDepartmentMaster
     */
    public function getDepartmentFk()
    {
        return $this->departmentFk;
    }

    /**
     * Set empJobTitleFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpJobTitleMaster $empJobTitleFk
     *
     * @return EmpEmployeeMaster
     */
    public function setEmpJobTitleFk(\Tashi\CommonBundle\Entity\EmpJobTitleMaster $empJobTitleFk = null)
    {
        $this->empJobTitleFk = $empJobTitleFk;

        return $this;
    }

    /**
     * Get empJobTitleFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpJobTitleMaster
     */
    public function getEmpJobTitleFk()
    {
        return $this->empJobTitleFk;
    }

    /**
     * Set employementTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmploymentType $employementTypeFk
     *
     * @return EmpEmployeeMaster
     */
    public function setEmployementTypeFk(\Tashi\CommonBundle\Entity\EmpEmploymentType $employementTypeFk = null)
    {
        $this->employementTypeFk = $employementTypeFk;

        return $this;
    }

    /**
     * Get employementTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmploymentType
     */
    public function getEmployementTypeFk()
    {
        return $this->employementTypeFk;
    }

    /**
     * Set empJobProfileFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpJobProfileMaster $empJobProfileFk
     *
     * @return EmpEmployeeMaster
     */
    public function setEmpJobProfileFk(\Tashi\CommonBundle\Entity\EmpJobProfileMaster $empJobProfileFk = null)
    {
        $this->empJobProfileFk = $empJobProfileFk;

        return $this;
    }

    /**
     * Get empJobProfileFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpJobProfileMaster
     */
    public function getEmpJobProfileFk()
    {
        return $this->empJobProfileFk;
    }

    /**
     * Set personFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPerson $personFk
     *
     * @return EmpEmployeeMaster
     */
    public function setPersonFk(\Tashi\CommonBundle\Entity\CmnPerson $personFk = null)
    {
        $this->personFk = $personFk;

        return $this;
    }

    /**
     * Get personFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnPerson
     */
    public function getPersonFk()
    {
        return $this->personFk;
    }
}
