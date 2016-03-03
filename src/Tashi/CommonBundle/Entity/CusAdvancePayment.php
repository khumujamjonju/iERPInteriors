<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CusAdvancePayment
 *
 * @ORM\Table(name="cus_advance_payment", indexes={@ORM\Index(name="fk_cus_advance_customer_master_idx", columns={"customer_fk"}), @ORM\Index(name="fk_cus_advance_payment_mode_idx", columns={"payment_mode_fk"})})
 * @ORM\Entity
 */
class CusAdvancePayment
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
     * @var integer
     *
     * @ORM\Column(name="amount_enter_account_id", type="integer", nullable=true)
     */
    private $amountEnterAccountId;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_no", type="string", length=45, nullable=true)
     */
    private $paymentNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="hod_approve", type="integer", nullable=true)
     */
    private $hodApprove;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_status", type="string", length=10, nullable=true)
     */
    private $paymentStatus;

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
     * @ORM\Column(name="is_Adjusted", type="integer", nullable=true)
     */
    private $isAdjusted;

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
     * @var \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPaymentModeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_mode_fk", referencedColumnName="pkid")
     * })
     */
    private $paymentModeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CusCustomer
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_fk", referencedColumnName="Customer_Id_Pk")
     * })
     */
    private $customerFk;



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
     * @return CusAdvancePayment
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
     * Set amountEnterAccountId
     *
     * @param integer $amountEnterAccountId
     *
     * @return CusAdvancePayment
     */
    public function setAmountEnterAccountId($amountEnterAccountId)
    {
        $this->amountEnterAccountId = $amountEnterAccountId;

        return $this;
    }

    /**
     * Get amountEnterAccountId
     *
     * @return integer
     */
    public function getAmountEnterAccountId()
    {
        return $this->amountEnterAccountId;
    }

    /**
     * Set paymentNo
     *
     * @param string $paymentNo
     *
     * @return CusAdvancePayment
     */
    public function setPaymentNo($paymentNo)
    {
        $this->paymentNo = $paymentNo;

        return $this;
    }

    /**
     * Get paymentNo
     *
     * @return string
     */
    public function getPaymentNo()
    {
        return $this->paymentNo;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CusAdvancePayment
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
     * Set hodApprove
     *
     * @param integer $hodApprove
     *
     * @return CusAdvancePayment
     */
    public function setHodApprove($hodApprove)
    {
        $this->hodApprove = $hodApprove;

        return $this;
    }

    /**
     * Get hodApprove
     *
     * @return integer
     */
    public function getHodApprove()
    {
        return $this->hodApprove;
    }

    /**
     * Set paymentStatus
     *
     * @param string $paymentStatus
     *
     * @return CusAdvancePayment
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * Set isAdjusted
     *
     * @param integer $isAdjusted
     *
     * @return CusAdvancePayment
     */
    public function setIsAdjusted($isAdjusted)
    {
        $this->isAdjusted = $isAdjusted;

        return $this;
    }

    /**
     * Get isAdjusted
     *
     * @return integer
     */
    public function getIsAdjusted()
    {
        return $this->isAdjusted;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * @return CusAdvancePayment
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
     * Set paymentModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk
     *
     * @return CusAdvancePayment
     */
    public function setPaymentModeFk(\Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk = null)
    {
        $this->paymentModeFk = $paymentModeFk;

        return $this;
    }

    /**
     * Get paymentModeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     */
    public function getPaymentModeFk()
    {
        return $this->paymentModeFk;
    }

    /**
     * Set customerFk
     *
     * @param \Tashi\CommonBundle\Entity\CusCustomer $customerFk
     *
     * @return CusAdvancePayment
     */
    public function setCustomerFk(\Tashi\CommonBundle\Entity\CusCustomer $customerFk = null)
    {
        $this->customerFk = $customerFk;

        return $this;
    }

    /**
     * Get customerFk
     *
     * @return \Tashi\CommonBundle\Entity\CusCustomer
     */
    public function getCustomerFk()
    {
        return $this->customerFk;
    }
}
