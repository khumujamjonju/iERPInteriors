<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolAdvancePayment
 *
 * @ORM\Table(name="payrol_advance_payment", indexes={@ORM\Index(name="fk_employee_idx", columns={"employee_fk"})})
 * @ORM\Entity
 */
class PayrolAdvancePayment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="advance_payment_pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $advancePaymentPk;

    /**
     * @var string
     *
     * @ORM\Column(name="advance_amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $advanceAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="total_collection", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalCollection;

    /**
     * @var string
     *
     * @ORM\Column(name="Due_Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $dueAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_status", type="string", length=10, nullable=true)
     */
    private $paymentStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_key", type="integer", nullable=true)
     */
    private $createKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="approved_key", type="integer", nullable=true)
     */
    private $approvedKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="rejected_key", type="integer", nullable=true)
     */
    private $rejectedKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="approved_date", type="datetime", nullable=true)
     */
    private $approvedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rejected_date", type="datetime", nullable=true)
     */
    private $rejectedDate;

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
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="employee_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $employeeFk;



    /**
     * Get advancePaymentPk
     *
     * @return integer
     */
    public function getAdvancePaymentPk()
    {
        return $this->advancePaymentPk;
    }

    /**
     * Set advanceAmount
     *
     * @param string $advanceAmount
     *
     * @return PayrolAdvancePayment
     */
    public function setAdvanceAmount($advanceAmount)
    {
        $this->advanceAmount = $advanceAmount;

        return $this;
    }

    /**
     * Get advanceAmount
     *
     * @return string
     */
    public function getAdvanceAmount()
    {
        return $this->advanceAmount;
    }

    /**
     * Set totalCollection
     *
     * @param string $totalCollection
     *
     * @return PayrolAdvancePayment
     */
    public function setTotalCollection($totalCollection)
    {
        $this->totalCollection = $totalCollection;

        return $this;
    }

    /**
     * Get totalCollection
     *
     * @return string
     */
    public function getTotalCollection()
    {
        return $this->totalCollection;
    }

    /**
     * Set dueAmount
     *
     * @param string $dueAmount
     *
     * @return PayrolAdvancePayment
     */
    public function setDueAmount($dueAmount)
    {
        $this->dueAmount = $dueAmount;

        return $this;
    }

    /**
     * Get dueAmount
     *
     * @return string
     */
    public function getDueAmount()
    {
        return $this->dueAmount;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PayrolAdvancePayment
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     *
     * @return PayrolAdvancePayment
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;

        return $this;
    }

    /**
     * Get paymentStatus
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * Set createKey
     *
     * @param integer $createKey
     *
     * @return PayrolAdvancePayment
     */
    public function setCreateKey($createKey)
    {
        $this->createKey = $createKey;

        return $this;
    }

    /**
     * Get createKey
     *
     * @return integer
     */
    public function getCreateKey()
    {
        return $this->createKey;
    }

    /**
     * Set approvedKey
     *
     * @param integer $approvedKey
     *
     * @return PayrolAdvancePayment
     */
    public function setApprovedKey($approvedKey)
    {
        $this->approvedKey = $approvedKey;

        return $this;
    }

    /**
     * Get approvedKey
     *
     * @return integer
     */
    public function getApprovedKey()
    {
        return $this->approvedKey;
    }

    /**
     * Set rejectedKey
     *
     * @param integer $rejectedKey
     *
     * @return PayrolAdvancePayment
     */
    public function setRejectedKey($rejectedKey)
    {
        $this->rejectedKey = $rejectedKey;

        return $this;
    }

    /**
     * Get rejectedKey
     *
     * @return integer
     */
    public function getRejectedKey()
    {
        return $this->rejectedKey;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * @return PayrolAdvancePayment
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
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return PayrolAdvancePayment
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
