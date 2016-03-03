<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpWorkerSalaryTypeMasterTxn
 *
 * @ORM\Table(name="emp_worker_salary_type_master_txn", indexes={@ORM\Index(name="fk_emp_master3_idx", columns={"Emp_Master_Fk"}), @ORM\Index(name="fk_worker_salary_type_idx", columns={"Worker_Salary_Type_Fk"})})
 * @ORM\Entity
 */
class EmpWorkerSalaryTypeMasterTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Emp_Expert_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $empExpertPk;

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
     * @ORM\Column(name="Branch_Office_Code", type="integer", nullable=true)
     */
    private $branchOfficeCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Worker_Salary_Type_Fk", referencedColumnName="Salary_Type_Pk")
     * })
     */
    private $workerSalaryTypeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_Master_Fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empMasterFk;



    /**
     * Get empExpertPk
     *
     * @return integer
     */
    public function getEmpExpertPk()
    {
        return $this->empExpertPk;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return EmpWorkerSalaryTypeMasterTxn
     */
    public function setBranchOfficeCode($branchOfficeCode)
    {
        $this->branchOfficeCode = $branchOfficeCode;

        return $this;
    }

    /**
     * Get branchOfficeCode
     *
     * @return integer
     */
    public function getBranchOfficeCode()
    {
        return $this->branchOfficeCode;
    }

    /**
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return EmpWorkerSalaryTypeMasterTxn
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
     * Set workerSalaryTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster $workerSalaryTypeFk
     *
     * @return EmpWorkerSalaryTypeMasterTxn
     */
    public function setWorkerSalaryTypeFk(\Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster $workerSalaryTypeFk = null)
    {
        $this->workerSalaryTypeFk = $workerSalaryTypeFk;

        return $this;
    }

    /**
     * Get workerSalaryTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster
     */
    public function getWorkerSalaryTypeFk()
    {
        return $this->workerSalaryTypeFk;
    }

    /**
     * Set empMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk
     *
     * @return EmpWorkerSalaryTypeMasterTxn
     */
    public function setEmpMasterFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk = null)
    {
        $this->empMasterFk = $empMasterFk;

        return $this;
    }

    /**
     * Get empMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmpMasterFk()
    {
        return $this->empMasterFk;
    }
}
