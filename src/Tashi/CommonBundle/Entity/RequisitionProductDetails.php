<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequisitionProductDetails
 *
 * @ORM\Table(name="requisition_product_details", indexes={@ORM\Index(name="fk_req_pk_idx", columns={"Requisition_Fk"}), @ORM\Index(name="fk_prouctid_idx", columns={"Product_id_Fk"}), @ORM\Index(name="fk_unitid_idx", columns={"Unit_id_fk"}), @ORM\Index(name="fkpurpose_idx", columns={"purpose_Fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\RequisitionMasterRepository")
 */
class RequisitionProductDetails
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
     * @var string
     *
     * @ORM\Column(name="purpose_code", type="string", length=45, nullable=true)
     */
    private $purposeCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="due_quantity", type="integer", nullable=true)
     */
    private $dueQuantity;

    /**
     * @var \Tashi\CommonBundle\Entity\RequisitionPurpose
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\RequisitionPurpose")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purpose_Fk", referencedColumnName="Pkid")
     * })
     */
    private $purposeFk;

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
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Product_id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $productFk;

    /**
     * @var \Tashi\CommonBundle\Entity\RequisitionMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\RequisitionMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Requisition_Fk", referencedColumnName="Pkid")
     * })
     */
    private $requisitionFk;



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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * @return RequisitionProductDetails
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
     * Set purposeCode
     *
     * @param string $purposeCode
     *
     * @return RequisitionProductDetails
     */
    public function setPurposeCode($purposeCode)
    {
        $this->purposeCode = $purposeCode;

        return $this;
    }

    /**
     * Get purposeCode
     *
     * @return string
     */
    public function getPurposeCode()
    {
        return $this->purposeCode;
    }

    /**
     * Set dueQuantity
     *
     * @param integer $dueQuantity
     *
     * @return RequisitionProductDetails
     */
    public function setDueQuantity($dueQuantity)
    {
        $this->dueQuantity = $dueQuantity;

        return $this;
    }

    /**
     * Get dueQuantity
     *
     * @return integer
     */
    public function getDueQuantity()
    {
        return $this->dueQuantity;
    }

    /**
     * Set purposeFk
     *
     * @param \Tashi\CommonBundle\Entity\RequisitionPurpose $purposeFk
     *
     * @return RequisitionProductDetails
     */
    public function setPurposeFk(\Tashi\CommonBundle\Entity\RequisitionPurpose $purposeFk = null)
    {
        $this->purposeFk = $purposeFk;

        return $this;
    }

    /**
     * Get purposeFk
     *
     * @return \Tashi\CommonBundle\Entity\RequisitionPurpose
     */
    public function getPurposeFk()
    {
        return $this->purposeFk;
    }

    /**
     * Set unitFk
     *
     * @param \Tashi\CommonBundle\Entity\ProductUnitTxn $unitFk
     *
     * @return RequisitionProductDetails
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
     * Set productFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $productFk
     *
     * @return RequisitionProductDetails
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

    /**
     * Set requisitionFk
     *
     * @param \Tashi\CommonBundle\Entity\RequisitionMaster $requisitionFk
     *
     * @return RequisitionProductDetails
     */
    public function setRequisitionFk(\Tashi\CommonBundle\Entity\RequisitionMaster $requisitionFk = null)
    {
        $this->requisitionFk = $requisitionFk;

        return $this;
    }

    /**
     * Get requisitionFk
     *
     * @return \Tashi\CommonBundle\Entity\RequisitionMaster
     */
    public function getRequisitionFk()
    {
        return $this->requisitionFk;
    }
}
