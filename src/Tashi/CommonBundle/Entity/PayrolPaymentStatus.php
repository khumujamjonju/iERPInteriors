<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolPaymentStatus
 *
 * @ORM\Table(name="payrol_payment_status", indexes={@ORM\Index(name="fk_salary_slip_idx", columns={"cmn_entity_id"}), @ORM\Index(name="fk_payment_mode_idx", columns={"payment_mode_fk"})})
 * @ORM\Entity
 */
class PayrolPaymentStatus
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Payment_Master_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paymentMasterPk;

    /**
     * @var string
     *
     * @ORM\Column(name="generated_receipt_no", type="string", length=20, nullable=true)
     */
    private $generatedReceiptNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="cmn_entity_id", type="integer", nullable=true)
     */
    private $cmnEntityId;

    /**
     * @var string
     *
     * @ORM\Column(name="Payment_Type_Key", type="string", length=5, nullable=true)
     */
    private $paymentTypeKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="date", nullable=true)
     */
    private $paymentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_no", type="string", length=45, nullable=true)
     */
    private $paymentNo;

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
     * Get paymentMasterPk
     *
     * @return integer
     */
    public function getPaymentMasterPk()
    {
        return $this->paymentMasterPk;
    }

    /**
     * Set generatedReceiptNo
     *
     * @param string $generatedReceiptNo
     *
     * @return PayrolPaymentStatus
     */
    public function setGeneratedReceiptNo($generatedReceiptNo)
    {
        $this->generatedReceiptNo = $generatedReceiptNo;

        return $this;
    }

    /**
     * Get generatedReceiptNo
     *
     * @return string
     */
    public function getGeneratedReceiptNo()
    {
        return $this->generatedReceiptNo;
    }

    /**
     * Set cmnEntityId
     *
     * @param integer $cmnEntityId
     *
     * @return PayrolPaymentStatus
     */
    public function setCmnEntityId($cmnEntityId)
    {
        $this->cmnEntityId = $cmnEntityId;

        return $this;
    }

    /**
     * Get cmnEntityId
     *
     * @return integer
     */
    public function getCmnEntityId()
    {
        return $this->cmnEntityId;
    }

    /**
     * Set paymentTypeKey
     *
     * @param string $paymentTypeKey
     *
     * @return PayrolPaymentStatus
     */
    public function setPaymentTypeKey($paymentTypeKey)
    {
        $this->paymentTypeKey = $paymentTypeKey;

        return $this;
    }

    /**
     * Get paymentTypeKey
     *
     * @return string
     */
    public function getPaymentTypeKey()
    {
        return $this->paymentTypeKey;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return PayrolPaymentStatus
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set paymentNo
     *
     * @param string $paymentNo
     *
     * @return PayrolPaymentStatus
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
     * @return PayrolPaymentStatus
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
}
