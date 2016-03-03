<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvoiceItemTxn
 *
 * @ORM\Table(name="invoice_item_txn", indexes={@ORM\Index(name="fk_invoice_invitem_idx", columns={"Invoice_id_fk"}), @ORM\Index(name="fk_item_invitem_idx", columns={"Item_id_fk"}), @ORM\Index(name="fk_expense_invitem_idx", columns={"Expense_id_fk"})})
 * @ORM\Entity
 */
class InvoiceItemTxn
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
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Unit", type="string", length=45, nullable=true)
     */
    private $unit = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Unit_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $unitPrice = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="Markup_price", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $markupPrice = '0.00';

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="Tax_pc", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $taxPc = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="Tax_amt", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $taxAmt = '0.00';

    /**
     * @var string
     *
     * @ORM\Column(name="Total", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $total = '0.00';

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_discounted", type="integer", nullable=true)
     */
    private $isDiscounted;

    /**
     * @var string
     *
     * @ORM\Column(name="discount_amt", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $discountAmt = '0.00';

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
     * @var \Tashi\CommonBundle\Entity\ProjectExpenses
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectExpenses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Expense_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $expenseFk;

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
     * @var \Tashi\CommonBundle\Entity\ProjectItemTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectItemTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Item_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $itemFk;



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
     * Set description
     *
     * @param string $description
     *
     * @return InvoiceItemTxn
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
     * Set unit
     *
     * @param string $unit
     *
     * @return InvoiceItemTxn
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set unitPrice
     *
     * @param string $unitPrice
     *
     * @return InvoiceItemTxn
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set markupPrice
     *
     * @param string $markupPrice
     *
     * @return InvoiceItemTxn
     */
    public function setMarkupPrice($markupPrice)
    {
        $this->markupPrice = $markupPrice;

        return $this;
    }

    /**
     * Get markupPrice
     *
     * @return string
     */
    public function getMarkupPrice()
    {
        return $this->markupPrice;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return InvoiceItemTxn
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set taxPc
     *
     * @param string $taxPc
     *
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * Set total
     *
     * @param string $total
     *
     * @return InvoiceItemTxn
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
     * Set isDiscounted
     *
     * @param integer $isDiscounted
     *
     * @return InvoiceItemTxn
     */
    public function setIsDiscounted($isDiscounted)
    {
        $this->isDiscounted = $isDiscounted;

        return $this;
    }

    /**
     * Get isDiscounted
     *
     * @return integer
     */
    public function getIsDiscounted()
    {
        return $this->isDiscounted;
    }

    /**
     * Set discountAmt
     *
     * @param string $discountAmt
     *
     * @return InvoiceItemTxn
     */
    public function setDiscountAmt($discountAmt)
    {
        $this->discountAmt = $discountAmt;

        return $this;
    }

    /**
     * Get discountAmt
     *
     * @return string
     */
    public function getDiscountAmt()
    {
        return $this->discountAmt;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * @return InvoiceItemTxn
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
     * Set expenseFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectExpenses $expenseFk
     *
     * @return InvoiceItemTxn
     */
    public function setExpenseFk(\Tashi\CommonBundle\Entity\ProjectExpenses $expenseFk = null)
    {
        $this->expenseFk = $expenseFk;

        return $this;
    }

    /**
     * Get expenseFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectExpenses
     */
    public function getExpenseFk()
    {
        return $this->expenseFk;
    }

    /**
     * Set invoiceFk
     *
     * @param \Tashi\CommonBundle\Entity\InvoiceMaster $invoiceFk
     *
     * @return InvoiceItemTxn
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
     * Set itemFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemTxn $itemFk
     *
     * @return InvoiceItemTxn
     */
    public function setItemFk(\Tashi\CommonBundle\Entity\ProjectItemTxn $itemFk = null)
    {
        $this->itemFk = $itemFk;

        return $this;
    }

    /**
     * Get itemFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectItemTxn
     */
    public function getItemFk()
    {
        return $this->itemFk;
    }
}
