<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoMaster
 *
 * @ORM\Table(name="po_master", uniqueConstraints={@ORM\UniqueConstraint(name="PO_Pk_UNIQUE", columns={"PO_Pk"})}, indexes={@ORM\Index(name="fk_po_supplier_idx", columns={"Vendor_Master_Fk"}), @ORM\Index(name="fk_suppliercontact_po_idx", columns={"Vendor_contact_fk"}), @ORM\Index(name="fk_status_po_idx", columns={"Status_fk"}), @ORM\Index(name="fk_employee_po_idx", columns={"Employee_id_fk"}), @ORM\Index(name="fk_compnayadd_po_idx", columns={"Company_address_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\PurchaseMasterRepository")
 */
class PoMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PO_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $poPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Ui_Order_ID", type="string", length=45, nullable=true)
     */
    private $uiOrderId;

    /**
     * @var string
     *
     * @ORM\Column(name="Order_Details", type="string", length=400, nullable=true)
     */
    private $orderDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Order_Date", type="date", nullable=true)
     */
    private $orderDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expected_Delivery", type="date", nullable=true)
     */
    private $expectedDelivery;

    /**
     * @var string
     *
     * @ORM\Column(name="Sub_total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $subTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="Tax_amt", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $taxAmt;

    /**
     * @var string
     *
     * @ORM\Column(name="Grand_total", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $grandTotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="ApprovalFlag", type="integer", nullable=true)
     */
    private $approvalflag;

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
     * @var string
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $totalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="due_flag", type="integer", nullable=true)
     */
    private $dueFlag;

    /**
     * @var \Tashi\CommonBundle\Entity\CompanyAddressTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CompanyAddressTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Company_address_fk", referencedColumnName="Pkid")
     * })
     */
    private $companyAddressFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Employee_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $employeeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\SupplierMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vendor_Master_Fk", referencedColumnName="Supplier_Pk")
     * })
     */
    private $vendorMasterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PoStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_fk", referencedColumnName="pkid")
     * })
     */
    private $statusFk;

    /**
     * @var \Tashi\CommonBundle\Entity\SupplierContactTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierContactTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Vendor_contact_fk", referencedColumnName="Supp_ConTact_Pk")
     * })
     */
    private $vendorContactFk;



    /**
     * Get poPk
     *
     * @return integer
     */
    public function getPoPk()
    {
        return $this->poPk;
    }

    /**
     * Set uiOrderId
     *
     * @param string $uiOrderId
     *
     * @return PoMaster
     */
    public function setUiOrderId($uiOrderId)
    {
        $this->uiOrderId = $uiOrderId;

        return $this;
    }

    /**
     * Get uiOrderId
     *
     * @return string
     */
    public function getUiOrderId()
    {
        return $this->uiOrderId;
    }

    /**
     * Set orderDetails
     *
     * @param string $orderDetails
     *
     * @return PoMaster
     */
    public function setOrderDetails($orderDetails)
    {
        $this->orderDetails = $orderDetails;

        return $this;
    }

    /**
     * Get orderDetails
     *
     * @return string
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return PoMaster
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set expectedDelivery
     *
     * @param \DateTime $expectedDelivery
     *
     * @return PoMaster
     */
    public function setExpectedDelivery($expectedDelivery)
    {
        $this->expectedDelivery = $expectedDelivery;

        return $this;
    }

    /**
     * Get expectedDelivery
     *
     * @return \DateTime
     */
    public function getExpectedDelivery()
    {
        return $this->expectedDelivery;
    }

    /**
     * Set subTotal
     *
     * @param string $subTotal
     *
     * @return PoMaster
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
     * Set taxAmt
     *
     * @param string $taxAmt
     *
     * @return PoMaster
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
     * Set grandTotal
     *
     * @param string $grandTotal
     *
     * @return PoMaster
     */
    public function setGrandTotal($grandTotal)
    {
        $this->grandTotal = $grandTotal;

        return $this;
    }

    /**
     * Get grandTotal
     *
     * @return string
     */
    public function getGrandTotal()
    {
        return $this->grandTotal;
    }

    /**
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return PoMaster
     */
    public function setApprovalflag($approvalflag)
    {
        $this->approvalflag = $approvalflag;

        return $this;
    }

    /**
     * Get approvalflag
     *
     * @return integer
     */
    public function getApprovalflag()
    {
        return $this->approvalflag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PoMaster
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
     * @return PoMaster
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
     * @return PoMaster
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
     * @return PoMaster
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
     * @return PoMaster
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
     * @return PoMaster
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
     * Set totalAmount
     *
     * @param string $totalAmount
     *
     * @return PoMaster
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set dueFlag
     *
     * @param integer $dueFlag
     *
     * @return PoMaster
     */
    public function setDueFlag($dueFlag)
    {
        $this->dueFlag = $dueFlag;

        return $this;
    }

    /**
     * Get dueFlag
     *
     * @return integer
     */
    public function getDueFlag()
    {
        return $this->dueFlag;
    }

    /**
     * Set companyAddressFk
     *
     * @param \Tashi\CommonBundle\Entity\CompanyAddressTxn $companyAddressFk
     *
     * @return PoMaster
     */
    public function setCompanyAddressFk(\Tashi\CommonBundle\Entity\CompanyAddressTxn $companyAddressFk = null)
    {
        $this->companyAddressFk = $companyAddressFk;

        return $this;
    }

    /**
     * Get companyAddressFk
     *
     * @return \Tashi\CommonBundle\Entity\CompanyAddressTxn
     */
    public function getCompanyAddressFk()
    {
        return $this->companyAddressFk;
    }

    /**
     * Set employeeFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $employeeFk
     *
     * @return PoMaster
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
     * Set vendorMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierMaster $vendorMasterFk
     *
     * @return PoMaster
     */
    public function setVendorMasterFk(\Tashi\CommonBundle\Entity\SupplierMaster $vendorMasterFk = null)
    {
        $this->vendorMasterFk = $vendorMasterFk;

        return $this;
    }

    /**
     * Get vendorMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierMaster
     */
    public function getVendorMasterFk()
    {
        return $this->vendorMasterFk;
    }

    /**
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\PoStatusMaster $statusFk
     *
     * @return PoMaster
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\PoStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\PoStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }

    /**
     * Set vendorContactFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierContactTxn $vendorContactFk
     *
     * @return PoMaster
     */
    public function setVendorContactFk(\Tashi\CommonBundle\Entity\SupplierContactTxn $vendorContactFk = null)
    {
        $this->vendorContactFk = $vendorContactFk;

        return $this;
    }

    /**
     * Get vendorContactFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierContactTxn
     */
    public function getVendorContactFk()
    {
        return $this->vendorContactFk;
    }
}
