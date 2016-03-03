<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoicePaymentTxn
 *
 * @ORM\Table(name="invoice_payment_txn", indexes={@ORM\Index(name="fk_paymode_invpayment_idx", columns={"Payment_mode_fk"}), @ORM\Index(name="fk_invoice_invpayment_idx", columns={"Invoice_id_fk"}), @ORM\Index(name="fk_receivedby_invpayment_idx", columns={"Received_by_fk"})})
 * @ORM\Entity
 */
class InvoicePaymentTxn
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
     * @ORM\Column(name="Payment_no", type="string", length=45, nullable=true)
     */
    private $paymentNo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Payment_date", type="date", nullable=true)
     */
    private $paymentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
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
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Received_by_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $receivedByFk;

    /**
     * @var \Tashi\CommonBundle\Entity\InvoiceMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\InvoiceMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Invoice_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $invoiceFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPaymentModeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Payment_mode_fk", referencedColumnName="pkid")
     * })
     */
    private $paymentModeFk;



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
     * Set paymentNo
     *
     * @param string $paymentNo
     *
     * @return InvoicePaymentTxn
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
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return InvoicePaymentTxn
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
     * Set amount
     *
     * @param string $amount
     *
     * @return InvoicePaymentTxn
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
     * Set remarks
     *
     * @param string $remarks
     *
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * @return InvoicePaymentTxn
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
     * Set receivedByFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $receivedByFk
     *
     * @return InvoicePaymentTxn
     */
    public function setReceivedByFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $receivedByFk = null)
    {
        $this->receivedByFk = $receivedByFk;

        return $this;
    }

    /**
     * Get receivedByFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getReceivedByFk()
    {
        return $this->receivedByFk;
    }

    /**
     * Set invoiceFk
     *
     * @param \Tashi\CommonBundle\Entity\InvoiceMaster $invoiceFk
     *
     * @return InvoicePaymentTxn
     */
    public function setInvoiceFk(\Tashi\CommonBundle\Entity\InvoiceMaster $invoiceFk = null)
    {
        $this->invoiceFk = $invoiceFk;

        return $this;
    }

    /**
     * Get invoiceFk
     *
     * @return \Tashi\CommonBundle\Entity\InvoiceMaster
     */
    public function getInvoiceFk()
    {
        return $this->invoiceFk;
    }

    /**
     * Set paymentModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk
     *
     * @return InvoicePaymentTxn
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
