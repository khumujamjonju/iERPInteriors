<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceMaster
 *
 * @ORM\Table(name="invoice_master", indexes={@ORM\Index(name="fk_project_invoice_idx", columns={"Project_id_fk"}), @ORM\Index(name="fk_billadd_invoice_idx", columns={"Billing_address_fk"}), @ORM\Index(name="fk_shipadd_invoice_idx", columns={"Shipping_address_fk"}), @ORM\Index(name="fk_salerep_invoice_idx", columns={"Sales_Rep_fk"}), @ORM\Index(name="fk_approve_invoice_idx", columns={"Approved_by_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\InvoiceRepository")
 */
class InvoiceMaster
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
     * @ORM\Column(name="Invoice_no", type="string", length=45, nullable=true)
     */
    private $invoiceNo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Invoice_date", type="date", nullable=true)
     */
    private $invoiceDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Shipping_date", type="date", nullable=true)
     */
    private $shippingDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Shipping_term", type="string", length=200, nullable=true)
     */
    private $shippingTerm;

    /**
     * @var string
     *
     * @ORM\Column(name="Payment_term", type="string", length=45, nullable=true)
     */
    private $paymentTerm;

    /**
     * @var string
     *
     * @ORM\Column(name="Sub_total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $subTotal = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Tax_pc", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $taxPc = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Tax_amt", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $taxAmt = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Discount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $discount = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $total = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Deposit", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $deposit = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Balance", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $balance = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_due", type="integer", nullable=true)
     */
    private $isDue;

    /**
     * @var string
     *
     * @ORM\Column(name="Notes", type="string", length=1000, nullable=true)
     */
    private $notes;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_flag", type="integer", nullable=true)
     */
    private $approvalFlag;

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
     * @var \Tashi\CommonBundle\Entity\CusAddressTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusAddressTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Shipping_address_fk", referencedColumnName="Pkid")
     * })
     */
    private $shippingAddressFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Approved_by_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $approvedByFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CusAddressTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusAddressTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Billing_address_fk", referencedColumnName="Pkid")
     * })
     */
    private $billingAddressFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Sales_Rep_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $salesRepFk;



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
     * Set invoiceNo
     *
     * @param string $invoiceNo
     *
     * @return InvoiceMaster
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * Get invoiceNo
     *
     * @return string
     */
    public function getInvoiceNo()
    {
        return $this->invoiceNo;
    }

    /**
     * Set invoiceDate
     *
     * @param \DateTime $invoiceDate
     *
     * @return InvoiceMaster
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    /**
     * Get invoiceDate
     *
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * Set shippingDate
     *
     * @param \DateTime $shippingDate
     *
     * @return InvoiceMaster
     */
    public function setShippingDate($shippingDate)
    {
        $this->shippingDate = $shippingDate;

        return $this;
    }

    /**
     * Get shippingDate
     *
     * @return \DateTime
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    /**
     * Set shippingTerm
     *
     * @param string $shippingTerm
     *
     * @return InvoiceMaster
     */
    public function setShippingTerm($shippingTerm)
    {
        $this->shippingTerm = $shippingTerm;

        return $this;
    }

    /**
     * Get shippingTerm
     *
     * @return string
     */
    public function getShippingTerm()
    {
        return $this->shippingTerm;
    }

    /**
     * Set paymentTerm
     *
     * @param string $paymentTerm
     *
     * @return InvoiceMaster
     */
    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;

        return $this;
    }

    /**
     * Get paymentTerm
     *
     * @return string
     */
    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    /**
     * Set subTotal
     *
     * @param string $subTotal
     *
     * @return InvoiceMaster
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    /**
     * Get subTotal
     *
     * @return string
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * Set taxPc
     *
     * @param string $taxPc
     *
     * @return InvoiceMaster
     */
    public function setTaxPc($taxPc)
    {
        $this->taxPc = $taxPc;

        return $this;
    }

    /**
     * Get taxPc
     *
     * @return string
     */
    public function getTaxPc()
    {
        return $this->taxPc;
    }

    /**
     * Set taxAmt
     *
     * @param string $taxAmt
     *
     * @return InvoiceMaster
     */
    public function setTaxAmt($taxAmt)
    {
        $this->taxAmt = $taxAmt;

        return $this;
    }

    /**
     * Get taxAmt
     *
     * @return string
     */
    public function getTaxAmt()
    {
        return $this->taxAmt;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return InvoiceMaster
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return InvoiceMaster
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set deposit
     *
     * @param string $deposit
     *
     * @return InvoiceMaster
     */
    public function setDeposit($deposit)
    {
        $this->deposit = $deposit;

        return $this;
    }

    /**
     * Get deposit
     *
     * @return string
     */
    public function getDeposit()
    {
        return $this->deposit;
    }

    /**
     * Set balance
     *
     * @param string $balance
     *
     * @return InvoiceMaster
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set isDue
     *
     * @param integer $isDue
     *
     * @return InvoiceMaster
     */
    public function setIsDue($isDue)
    {
        $this->isDue = $isDue;

        return $this;
    }

    /**
     * Get isDue
     *
     * @return integer
     */
    public function getIsDue()
    {
        return $this->isDue;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return InvoiceMaster
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return InvoiceMaster
     */
    public function setApprovalFlag($approvalFlag)
    {
        $this->approvalFlag = $approvalFlag;

        return $this;
    }

    /**
     * Get approvalFlag
     *
     * @return integer
     */
    public function getApprovalFlag()
    {
        return $this->approvalFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * @return InvoiceMaster
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
     * Set shippingAddressFk
     *
     * @param \Tashi\CommonBundle\Entity\CusAddressTxn $shippingAddressFk
     *
     * @return InvoiceMaster
     */
    public function setShippingAddressFk(\Tashi\CommonBundle\Entity\CusAddressTxn $shippingAddressFk = null)
    {
        $this->shippingAddressFk = $shippingAddressFk;

        return $this;
    }

    /**
     * Get shippingAddressFk
     *
     * @return \Tashi\CommonBundle\Entity\CusAddressTxn
     */
    public function getShippingAddressFk()
    {
        return $this->shippingAddressFk;
    }

    /**
     * Set approvedByFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $approvedByFk
     *
     * @return InvoiceMaster
     */
    public function setApprovedByFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $approvedByFk = null)
    {
        $this->approvedByFk = $approvedByFk;

        return $this;
    }

    /**
     * Get approvedByFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getApprovedByFk()
    {
        return $this->approvedByFk;
    }

    /**
     * Set billingAddressFk
     *
     * @param \Tashi\CommonBundle\Entity\CusAddressTxn $billingAddressFk
     *
     * @return InvoiceMaster
     */
    public function setBillingAddressFk(\Tashi\CommonBundle\Entity\CusAddressTxn $billingAddressFk = null)
    {
        $this->billingAddressFk = $billingAddressFk;

        return $this;
    }

    /**
     * Get billingAddressFk
     *
     * @return \Tashi\CommonBundle\Entity\CusAddressTxn
     */
    public function getBillingAddressFk()
    {
        return $this->billingAddressFk;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return InvoiceMaster
     */
    public function setProjectFk(\Tashi\CommonBundle\Entity\ProjectMaster $projectFk = null)
    {
        $this->projectFk = $projectFk;

        return $this;
    }

    /**
     * Get projectFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectMaster
     */
    public function getProjectFk()
    {
        return $this->projectFk;
    }

    /**
     * Set salesRepFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $salesRepFk
     *
     * @return InvoiceMaster
     */
    public function setSalesRepFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $salesRepFk = null)
    {
        $this->salesRepFk = $salesRepFk;

        return $this;
    }

    /**
     * Get salesRepFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getSalesRepFk()
    {
        return $this->salesRepFk;
    }
}
