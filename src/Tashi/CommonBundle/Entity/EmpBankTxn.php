<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpBankTxn
 *
 * @ORM\Table(name="emp_bank_txn", indexes={@ORM\Index(name="fk_emp_master_idx", columns={"Emp_Master_Fk"}), @ORM\Index(name="fk_worker_expert_idx", columns={"Bank_Master_Fk"})})
 * @ORM\Entity
 */
class EmpBankTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Emp_Bank_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $empBankPk;

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
     * @var \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankDetailsMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Bank_Master_Fk", referencedColumnName="Bank_Pk")
     * })
     */
    private $bankMasterFk;

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
     * Get empBankPk
     *
     * @return integer
     */
    public function getEmpBankPk()
    {
        return $this->empBankPk;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * @return EmpBankTxn
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
     * Set bankMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankDetailsMaster $bankMasterFk
     *
     * @return EmpBankTxn
     */
    public function setBankMasterFk(\Tashi\CommonBundle\Entity\CmnBankDetailsMaster $bankMasterFk = null)
    {
        $this->bankMasterFk = $bankMasterFk;

        return $this;
    }

    /**
     * Get bankMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     */
    public function getBankMasterFk()
    {
        return $this->bankMasterFk;
    }

    /**
     * Set empMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empMasterFk
     *
     * @return EmpBankTxn
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
