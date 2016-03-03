<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpWorkerWorkingTypeMasterTxn
 *
 * @ORM\Table(name="emp_worker_working_type_master_txn", indexes={@ORM\Index(name="fk_emp_master_idx", columns={"Emp_Master_Fk"}), @ORM\Index(name="fk_worker_expert_idx", columns={"Working_Type_Fk"})})
 * @ORM\Entity
 */
class EmpWorkerWorkingTypeMasterTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Emp_Working_Type_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $empWorkingTypePk;

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
     * @var \Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Working_Type_Fk", referencedColumnName="Working_Type_Pk")
     * })
     */
    private $workingTypeFk;

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
     * Get empWorkingTypePk
     *
     * @return integer
     */
    public function getEmpWorkingTypePk()
    {
        return $this->empWorkingTypePk;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * @return EmpWorkerWorkingTypeMasterTxn
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
     * Set workingTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster $workingTypeFk
     *
     * @return EmpWorkerWorkingTypeMasterTxn
     */
    public function setWorkingTypeFk(\Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster $workingTypeFk = null)
    {
        $this->workingTypeFk = $workingTypeFk;

        return $this;
    }

    /**
     * Get workingTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpWorkerWorkingTypeMaster
     */
    public function getWorkingTypeFk()
    {
        return $this->workingTypeFk;
    }

    /**
     * Set empMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk
     *
     * @return EmpWorkerWorkingTypeMasterTxn
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
