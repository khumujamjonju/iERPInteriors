<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoProductDetails
 *
 * @ORM\Table(name="po_product_details", uniqueConstraints={@ORM\UniqueConstraint(name="PO_Pk_UNIQUE", columns={"Pkid"})}, indexes={@ORM\Index(name="fk_po_master_idx", columns={"PO_id_fk"}), @ORM\Index(name="fk_po_product_idx", columns={"Product_id_Fk"}), @ORM\Index(name="fk_unit_poprd_idx", columns={"Unit_id_fk"}), @ORM\Index(name="fk_projectmaster_poprd_idx", columns={"Project_id_fk"})})
 * @ORM\Entity
 */
class PoProductDetails
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
     * @ORM\Column(name="Tax", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tax;

    /**
     * @var float
     *
     * @ORM\Column(name="Quoted_Price", type="float", precision=7, scale=2, nullable=true)
     */
    private $quotedPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="Delivered_quantity", type="integer", nullable=true)
     */
    private $deliveredQuantity;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expected_Delivery_Date", type="date", nullable=true)
     */
    private $expectedDeliveryDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Project_Related", type="integer", nullable=true)
     */
    private $isProjectRelated;

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
     * @var integer
     *
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var \Tashi\CommonBundle\Entity\ProductUnitTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProductUnitTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Unit_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $unitFk;

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
     * @var \Tashi\CommonBundle\Entity\PoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PO_id_fk", referencedColumnName="PO_Pk")
     * })
     */
    private $poFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Product_id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $productFk;



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
     * Set tax
     *
     * @param string $tax
     *
     * @return PoProductDetails
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set quotedPrice
     *
     * @param float $quotedPrice
     *
     * @return PoProductDetails
     */
    public function setQuotedPrice($quotedPrice)
    {
        $this->quotedPrice = $quotedPrice;

        return $this;
    }

    /**
     * Get quotedPrice
     *
     * @return float
     */
    public function getQuotedPrice()
    {
        return $this->quotedPrice;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PoProductDetails
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
     * Set deliveredQuantity
     *
     * @param integer $deliveredQuantity
     *
     * @return PoProductDetails
     */
    public function setDeliveredQuantity($deliveredQuantity)
    {
        $this->deliveredQuantity = $deliveredQuantity;

        return $this;
    }

    /**
     * Get deliveredQuantity
     *
     * @return integer
     */
    public function getDeliveredQuantity()
    {
        return $this->deliveredQuantity;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return PoProductDetails
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
     * Set expectedDeliveryDate
     *
     * @param \DateTime $expectedDeliveryDate
     *
     * @return PoProductDetails
     */
    public function setExpectedDeliveryDate($expectedDeliveryDate)
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }

    /**
     * Get expectedDeliveryDate
     *
     * @return \DateTime
     */
    public function getExpectedDeliveryDate()
    {
        return $this->expectedDeliveryDate;
    }

    /**
     * Set isProjectRelated
     *
     * @param integer $isProjectRelated
     *
     * @return PoProductDetails
     */
    public function setIsProjectRelated($isProjectRelated)
    {
        $this->isProjectRelated = $isProjectRelated;

        return $this;
    }

    /**
     * Get isProjectRelated
     *
     * @return integer
     */
    public function getIsProjectRelated()
    {
        return $this->isProjectRelated;
    }

    /**
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * @return PoProductDetails
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
     * Set unitFk
     *
     * @param \Tashi\CommonBundle\Entity\ProductUnitTxn $unitFk
     *
     * @return PoProductDetails
     */
    public function setUnitFk(\Tashi\CommonBundle\Entity\ProductUnitTxn $unitFk = null)
    {
        $this->unitFk = $unitFk;

        return $this;
    }

    /**
     * Get unitFk
     *
     * @return \Tashi\CommonBundle\Entity\ProductUnitTxn
     */
    public function getUnitFk()
    {
        return $this->unitFk;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return PoProductDetails
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
     * Set poFk
     *
     * @param \Tashi\CommonBundle\Entity\PoMaster $poFk
     *
     * @return PoProductDetails
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

    /**
     * Set productFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $productFk
     *
     * @return PoProductDetails
     */
    public function setProductFk(\Tashi\CommonBundle\Entity\PrdProductMaster $productFk = null)
    {
        $this->productFk = $productFk;

        return $this;
    }

    /**
     * Get productFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getProductFk()
    {
        return $this->productFk;
    }
}
