<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolSalarySlipEmolumentdeductionAmount
 *
 * @ORM\Table(name="payrol_salary_slip_emolumentdeduction_amount", indexes={@ORM\Index(name="fk_salary_slip_idx", columns={"Salary_Slip_Id_Fk"}), @ORM\Index(name="fk_emolument_deduction_master_idx", columns={"Emolument_Deduction_Master_Id_Fk"})})
 * @ORM\Entity
 */
class PayrolSalarySlipEmolumentdeductionAmount
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount;

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
     * @var \Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emolument_Deduction_Master_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $emolumentDeductionMasterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PayrolSalarySlip
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PayrolSalarySlip")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Salary_Slip_Id_Fk", referencedColumnName="Salary_Slip_Pk")
     * })
     */
    private $salarySlipFk;



    /**
     * Get pkid
     *
     * @return integer
     */
    public function getPkid()
    {
        return $this->pkid;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return PayrolSalarySlipEmolumentdeductionAmount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * @return PayrolSalarySlipEmolumentdeductionAmount
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
     * Set emolumentDeductionMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster $emolumentDeductionMasterFk
     *
     * @return PayrolSalarySlipEmolumentdeductionAmount
     */
    public function setEmolumentDeductionMasterFk(\Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster $emolumentDeductionMasterFk = null)
    {
        $this->emolumentDeductionMasterFk = $emolumentDeductionMasterFk;

        return $this;
    }

    /**
     * Get emolumentDeductionMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\PayrolEmolumentDeductionMaster
     */
    public function getEmolumentDeductionMasterFk()
    {
        return $this->emolumentDeductionMasterFk;
    }

    /**
     * Set salarySlipFk
     *
     * @param \Tashi\CommonBundle\Entity\PayrolSalarySlip $salarySlipFk
     *
     * @return PayrolSalarySlipEmolumentdeductionAmount
     */
    public function setSalarySlipFk(\Tashi\CommonBundle\Entity\PayrolSalarySlip $salarySlipFk = null)
    {
        $this->salarySlipFk = $salarySlipFk;

        return $this;
    }

    /**
     * Get salarySlipFk
     *
     * @return \Tashi\CommonBundle\Entity\PayrolSalarySlip
     */
    public function getSalarySlipFk()
    {
        return $this->salarySlipFk;
    }
}
