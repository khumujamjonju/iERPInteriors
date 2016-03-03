<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolSalarySlip
 *
 * @ORM\Table(name="payrol_salary_slip", indexes={@ORM\Index(name="fk_salary_slip_employee_idx", columns={"Employee_Fk"}), @ORM\Index(name="fk_salary_slip_month_idx", columns={"Month_Fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\AccountRepository")
 */
class PayrolSalarySlip
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Salary_Slip_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $salarySlipPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Year", type="string", length=10, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="Gross_Salary", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $grossSalary;

    /**
     * @var integer
     *
     * @ORM\Column(name="basic_calculation_pc", type="integer", nullable=true)
     */
    private $basicCalculationPc;

    /**
     * @var integer
     *
     * @ORM\Column(name="hra_calculation_pc", type="integer", nullable=true)
     */
    private $hraCalculationPc;

    /**
     * @var string
     *
     * @ORM\Column(name="Earning_Basic_Salary", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $earningBasicSalary;

    /**
     * @var string
     *
     * @ORM\Column(name="Earning_hra_Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $earningHraAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="Earning_Total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $earningTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="Deduction_Adjusted_Advance_Pay", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $deductionAdjustedAdvancePay;

    /**
     * @var string
     *
     * @ORM\Column(name="Deduction_Adjusted_Wallet_Bal", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $deductionAdjustedWalletBal;

    /**
     * @var string
     *
     * @ORM\Column(name="Deduction_Total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $deductionTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="Net_Salary", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $netSalary;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=10, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="Emp_Current_Advance_Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $empCurrentAdvanceAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="Emp_Current_Account_Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $empCurrentAccountAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="date", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="approved_date", type="date", nullable=true)
     */
    private $approvedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rejected_date", type="date", nullable=true)
     */
    private $rejectedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_sanction", type="integer", nullable=true)
     */
    private $isSanction;

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
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnMonth
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnMonth")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Month_Fk", referencedColumnName="Pkid")
     * })
     */
    private $monthFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Employee_Fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $employeeFk;



    /**
     * Get salarySlipPk
     *
     * @return integer
     */
    public function getSalarySlipPk()
    {
        return $this->salarySlipPk;
    }

    /**
     * Set year
     *
     * @param string $year
     *
     * @return PayrolSalarySlip
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set grossSalary
     *
     * @param string $grossSalary
     *
     * @return PayrolSalarySlip
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
     * Set basicCalculationPc
     *
     * @param integer $basicCalculationPc
     *
     * @return PayrolSalarySlip
     */
    public function setBasicCalculationPc($basicCalculationPc)
    {
        $this->basicCalculationPc = $basicCalculationPc;

        return $this;
    }

    /**
     * Get basicCalculationPc
     *
     * @return integer
     */
    public function getBasicCalculationPc()
    {
        return $this->basicCalculationPc;
    }

    /**
     * Set hraCalculationPc
     *
     * @param integer $hraCalculationPc
     *
     * @return PayrolSalarySlip
     */
    public function setHraCalculationPc($hraCalculationPc)
    {
        $this->hraCalculationPc = $hraCalculationPc;

        return $this;
    }

    /**
     * Get hraCalculationPc
     *
     * @return integer
     */
    public function getHraCalculationPc()
    {
        return $this->hraCalculationPc;
    }

    /**
     * Set earningBasicSalary
     *
     * @param string $earningBasicSalary
     *
     * @return PayrolSalarySlip
     */
    public function setEarningBasicSalary($earningBasicSalary)
    {
        $this->earningBasicSalary = $earningBasicSalary;

        return $this;
    }

    /**
     * Get earningBasicSalary
     *
     * @return string
     */
    public function getEarningBasicSalary()
    {
        return $this->earningBasicSalary;
    }

    /**
     * Set earningHraAmount
     *
     * @param string $earningHraAmount
     *
     * @return PayrolSalarySlip
     */
    public function setEarningHraAmount($earningHraAmount)
    {
        $this->earningHraAmount = $earningHraAmount;

        return $this;
    }

    /**
     * Get earningHraAmount
     *
     * @return string
     */
    public function getEarningHraAmount()
    {
        return $this->earningHraAmount;
    }

    /**
     * Set earningTotal
     *
     * @param string $earningTotal
     *
     * @return PayrolSalarySlip
     */
    public function setEarningTotal($earningTotal)
    {
        $this->earningTotal = $earningTotal;

        return $this;
    }

    /**
     * Get earningTotal
     *
     * @return string
     */
    public function getEarningTotal()
    {
        return $this->earningTotal;
    }

    /**
     * Set deductionAdjustedAdvancePay
     *
     * @param string $deductionAdjustedAdvancePay
     *
     * @return PayrolSalarySlip
     */
    public function setDeductionAdjustedAdvancePay($deductionAdjustedAdvancePay)
    {
        $this->deductionAdjustedAdvancePay = $deductionAdjustedAdvancePay;

        return $this;
    }

    /**
     * Get deductionAdjustedAdvancePay
     *
     * @return string
     */
    public function getDeductionAdjustedAdvancePay()
    {
        return $this->deductionAdjustedAdvancePay;
    }

    /**
     * Set deductionAdjustedWalletBal
     *
     * @param string $deductionAdjustedWalletBal
     *
     * @return PayrolSalarySlip
     */
    public function setDeductionAdjustedWalletBal($deductionAdjustedWalletBal)
    {
        $this->deductionAdjustedWalletBal = $deductionAdjustedWalletBal;

        return $this;
    }

    /**
     * Get deductionAdjustedWalletBal
     *
     * @return string
     */
    public function getDeductionAdjustedWalletBal()
    {
        return $this->deductionAdjustedWalletBal;
    }

    /**
     * Set deductionTotal
     *
     * @param string $deductionTotal
     *
     * @return PayrolSalarySlip
     */
    public function setDeductionTotal($deductionTotal)
    {
        $this->deductionTotal = $deductionTotal;

        return $this;
    }

    /**
     * Get deductionTotal
     *
     * @return string
     */
    public function getDeductionTotal()
    {
        return $this->deductionTotal;
    }

    /**
     * Set netSalary
     *
     * @param string $netSalary
     *
     * @return PayrolSalarySlip
     */
    public function setNetSalary($netSalary)
    {
        $this->netSalary = $netSalary;

        return $this;
    }

    /**
     * Get netSalary
     *
     * @return string
     */
    public function getNetSalary()
    {
        return $this->netSalary;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return PayrolSalarySlip
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set empCurrentAdvanceAmount
     *
     * @param string $empCurrentAdvanceAmount
     *
     * @return PayrolSalarySlip
     */
    public function setEmpCurrentAdvanceAmount($empCurrentAdvanceAmount)
    {
        $this->empCurrentAdvanceAmount = $empCurrentAdvanceAmount;

        return $this;
    }

    /**
     * Get empCurrentAdvanceAmount
     *
     * @return string
     */
    public function getEmpCurrentAdvanceAmount()
    {
        return $this->empCurrentAdvanceAmount;
    }

    /**
     * Set empCurrentAccountAmount
     *
     * @param string $empCurrentAccountAmount
     *
     * @return PayrolSalarySlip
     */
    public function setEmpCurrentAccountAmount($empCurrentAccountAmount)
    {
        $this->empCurrentAccountAmount = $empCurrentAccountAmount;

        return $this;
    }

    /**
     * Get empCurrentAccountAmount
     *
     * @return string
     */
    public function getEmpCurrentAccountAmount()
    {
        return $this->empCurrentAccountAmount;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return PayrolSalarySlip
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set approvedDate
     *
     * @param \DateTime $approvedDate
     *
     * @return PayrolSalarySlip
     */
    public function setApprovedDate($approvedDate)
    {
        $this->approvedDate = $approvedDate;

        return $this;
    }

    /**
     * Get approvedDate
     *
     * @return \DateTime
     */
    public function getApprovedDate()
    {
        return $this->approvedDate;
    }

    /**
     * Set rejectedDate
     *
     * @param \DateTime $rejectedDate
     *
     * @return PayrolSalarySlip
     */
    public function setRejectedDate($rejectedDate)
    {
        $this->rejectedDate = $rejectedDate;

        return $this;
    }

    /**
     * Get rejectedDate
     *
     * @return \DateTime
     */
    public function getRejectedDate()
    {
        return $this->rejectedDate;
    }

    /**
     * Set isSanction
     *
     * @param integer $isSanction
     *
     * @return PayrolSalarySlip
     */
    public function setIsSanction($isSanction)
    {
        $this->isSanction = $isSanction;

        return $this;
    }

    /**
     * Get isSanction
     *
     * @return integer
     */
    public function getIsSanction()
    {
        return $this->isSanction;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolSalarySlip
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
     * @return PayrolSalarySlip
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
     * @return PayrolSalarySlip
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
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return PayrolSalarySlip
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
     * @return PayrolSalarySlip
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return PayrolSalarySlip
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
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return PayrolSalarySlip
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
     * Set monthFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnMonth $monthFk
     *
     * @return PayrolSalarySlip
     */
    public function setMonthFk(\Tashi\CommonBundle\Entity\CmnMonth $monthFk = null)
    {
        $this->monthFk = $monthFk;

        return $this;
    }

    /**
     * Get monthFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnMonth
     */
    public function getMonthFk()
    {
        return $this->monthFk;
    }

    /**
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return PayrolSalarySlip
     */
    public function setEmployeeFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk = null)
    {
        $this->employeeFk = $employeeFk;

        return $this;
    }

    /**
     * Get employeeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmployeeFk()
    {
        return $this->employeeFk;
    }
}
