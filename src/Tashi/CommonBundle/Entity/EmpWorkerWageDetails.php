<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpWorkerWageDetails
 *
 * @ORM\Table(name="emp_worker_wage_details", indexes={@ORM\Index(name="fk_salary_slip_employee_idx", columns={"Employee_Fk"}), @ORM\Index(name="fk_salary_slip_month_idx", columns={"Month_Fk"}), @ORM\Index(name="fk_worker_wage_type_idx", columns={"wage_type_id_fk"})})
 * @ORM\Entity
 */
class EmpWorkerWageDetails
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
     * @ORM\Column(name="Year", type="string", length=10, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="wage_type_amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $wageTypeAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_wage_type", type="integer", nullable=true)
     */
    private $totalWageType;

    /**
     * @var string
     *
     * @ORM\Column(name="net_wage", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $netWage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="date", nullable=true)
     */
    private $entryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="working_date_from", type="date", nullable=true)
     */
    private $workingDateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="working_date_to", type="date", nullable=true)
     */
    private $workingDateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=15, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_Update_Date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

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
     * @ORM\Column(name="is_wage_date_single", type="integer", nullable=true)
     */
    private $isWageDateSingle;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_Accounted", type="integer", nullable=true)
     */
    private $isAccounted;

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
     * @var \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="wage_type_id_fk", referencedColumnName="Salary_Type_Pk")
     * })
     */
    private $wageTypeFk;

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
     * @var \Tashi\CommonBundle\Entity\CmnMonth
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnMonth")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Month_Fk", referencedColumnName="Pkid")
     * })
     */
    private $monthFk;



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
     * Set year
     *
     * @param string $year
     *
     * @return EmpWorkerWageDetails
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
     * Set wageTypeAmount
     *
     * @param string $wageTypeAmount
     *
     * @return EmpWorkerWageDetails
     */
    public function setWageTypeAmount($wageTypeAmount)
    {
        $this->wageTypeAmount = $wageTypeAmount;

        return $this;
    }

    /**
     * Get wageTypeAmount
     *
     * @return string
     */
    public function getWageTypeAmount()
    {
        return $this->wageTypeAmount;
    }

    /**
     * Set totalWageType
     *
     * @param integer $totalWageType
     *
     * @return EmpWorkerWageDetails
     */
    public function setTotalWageType($totalWageType)
    {
        $this->totalWageType = $totalWageType;

        return $this;
    }

    /**
     * Get totalWageType
     *
     * @return integer
     */
    public function getTotalWageType()
    {
        return $this->totalWageType;
    }

    /**
     * Set netWage
     *
     * @param string $netWage
     *
     * @return EmpWorkerWageDetails
     */
    public function setNetWage($netWage)
    {
        $this->netWage = $netWage;

        return $this;
    }

    /**
     * Get netWage
     *
     * @return string
     */
    public function getNetWage()
    {
        return $this->netWage;
    }

    /**
     * Set entryDate
     *
     * @param \DateTime $entryDate
     *
     * @return EmpWorkerWageDetails
     */
    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    /**
     * Get entryDate
     *
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    /**
     * Set workingDateFrom
     *
     * @param \DateTime $workingDateFrom
     *
     * @return EmpWorkerWageDetails
     */
    public function setWorkingDateFrom($workingDateFrom)
    {
        $this->workingDateFrom = $workingDateFrom;

        return $this;
    }

    /**
     * Get workingDateFrom
     *
     * @return \DateTime
     */
    public function getWorkingDateFrom()
    {
        return $this->workingDateFrom;
    }

    /**
     * Set workingDateTo
     *
     * @param \DateTime $workingDateTo
     *
     * @return EmpWorkerWageDetails
     */
    public function setWorkingDateTo($workingDateTo)
    {
        $this->workingDateTo = $workingDateTo;

        return $this;
    }

    /**
     * Get workingDateTo
     *
     * @return \DateTime
     */
    public function getWorkingDateTo()
    {
        return $this->workingDateTo;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return EmpWorkerWageDetails
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
     * Set recordUpdateDate
     *
     * @param \DateTime $recordUpdateDate
     *
     * @return EmpWorkerWageDetails
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * Set isWageDateSingle
     *
     * @param integer $isWageDateSingle
     *
     * @return EmpWorkerWageDetails
     */
    public function setIsWageDateSingle($isWageDateSingle)
    {
        $this->isWageDateSingle = $isWageDateSingle;

        return $this;
    }

    /**
     * Get isWageDateSingle
     *
     * @return integer
     */
    public function getIsWageDateSingle()
    {
        return $this->isWageDateSingle;
    }

    /**
     * Set isAccounted
     *
     * @param integer $isAccounted
     *
     * @return EmpWorkerWageDetails
     */
    public function setIsAccounted($isAccounted)
    {
        $this->isAccounted = $isAccounted;

        return $this;
    }

    /**
     * Get isAccounted
     *
     * @return integer
     */
    public function getIsAccounted()
    {
        return $this->isAccounted;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * @return EmpWorkerWageDetails
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
     * Set wageTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster $wageTypeFk
     *
     * @return EmpWorkerWageDetails
     */
    public function setWageTypeFk(\Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster $wageTypeFk = null)
    {
        $this->wageTypeFk = $wageTypeFk;

        return $this;
    }

    /**
     * Get wageTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpWorkerSalaryTypeMaster
     */
    public function getWageTypeFk()
    {
        return $this->wageTypeFk;
    }

    /**
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return EmpWorkerWageDetails
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

    /**
     * Set monthFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnMonth $monthFk
     *
     * @return EmpWorkerWageDetails
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
}
