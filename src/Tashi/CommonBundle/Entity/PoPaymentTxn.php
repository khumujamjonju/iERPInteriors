<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoPaymentTxn
 *
 * @ORM\Table(name="po_payment_txn", indexes={@ORM\Index(name="fk_po_popayment_idx", columns={"Po_id_fk"}), @ORM\Index(name="fk_paymode_popayment_idx", columns={"payment_mode_fk"})})
 * @ORM\Entity
 */
class PoPaymentTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="datetime", nullable=true)
     */
    private $paymentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_no", type="string", length=45, nullable=true)
     */
    private $paymentNo;

    /**
     * @var string
     *
     * @ORM\Column(name="bank_name", type="string", length=70, nullable=true)
     */
    private $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=300, nullable=true)
     */
    private $remarks;

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
     * @var string
     *
     * @ORM\Column(name="Custom1", type="string", length=45, nullable=true)
     */
    private $custom1;

    /**
     * @var string
     *
     * @ORM\Column(name="Custom2", type="string", length=45, nullable=true)
     */
    private $custom2;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_format", type="string", length=45, nullable=true)
     */
    private $paymentFormat;

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
     * @var \Tashi\CommonBundle\Entity\PoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Po_id_fk", referencedColumnName="PO_Pk")
     * })
     */
    private $poFk;



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
     * @return PoPaymentTxn
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
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * Set bankName
     *
     * @param string $bankName
     *
     * @return PoPaymentTxn
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return PoPaymentTxn
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * @return PoPaymentTxn
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
     * Set custom1
     *
     * @param string $custom1
     *
     * @return PoPaymentTxn
     */
    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;

        return $this;
    }

    /**
     * Get custom1
     *
     * @return string
     */
    public function getCustom1()
    {
        return $this->custom1;
    }

    /**
     * Set custom2
     *
     * @param string $custom2
     *
     * @return PoPaymentTxn
     */
    public function setCustom2($custom2)
    {
        $this->custom2 = $custom2;

        return $this;
    }

    /**
     * Get custom2
     *
     * @return string
     */
    public function getCustom2()
    {
        return $this->custom2;
    }

    /**
     * Set paymentFormat
     *
     * @param string $paymentFormat
     *
     * @return PoPaymentTxn
     */
    public function setPaymentFormat($paymentFormat)
    {
        $this->paymentFormat = $paymentFormat;

        return $this;
    }

    /**
     * Get paymentFormat
     *
     * @return string
     */
    public function getPaymentFormat()
    {
        return $this->paymentFormat;
    }

    /**
     * Set paymentModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk
     *
     * @return PoPaymentTxn
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
     * Set poFk
     *
     * @param \Tashi\CommonBundle\Entity\PoMaster $poFk
     *
     * @return PoPaymentTxn
     */
    public function setPoFk(\Tashi\CommonBundle\Entity\PoMaster $poFk = null)
    {
        $this->poFk = $poFk;

        return $this;
    }

    /**
     * Get poFk
     *
     * @return \Tashi\CommonBundle\Entity\PoMaster
     */
    public function getPoFk()
    {
        return $this->poFk;
    }
}
