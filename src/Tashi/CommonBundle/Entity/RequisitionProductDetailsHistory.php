<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RequisitionProductDetailsHistory
 *
 * @ORM\Table(name="requisition_product_details_history", indexes={@ORM\Index(name="fk_requisition_idx", columns={"Requisition_Fk"}), @ORM\Index(name="fk_employeepk_idx", columns={"dispatchbyFk"}), @ORM\Index(name="fk_productPk_idx", columns={"Product_id_Fk"}), @ORM\Index(name="fk_unitPk_idx", columns={"Unit_id_fk"}), @ORM\Index(name="fk_stockPk_idx", columns={"Stock_Fk"})})
 * @ORM\Entity
 */
class RequisitionProductDetailsHistory
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
     * @var integer
     *
     * @ORM\Column(name="due_quantity", type="integer", nullable=true)
     */
    private $dueQuantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dispatch_date", type="datetime", nullable=true)
     */
    private $dispatchDate;

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
     * @ORM\Column(name="Company_Code", type="integer", nullable=true)
     */
    private $companyCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Branch_Office_Code", type="integer", nullable=true)
     */
    private $branchOfficeCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Stock_Fk", type="integer", nullable=true)
     */
    private $stockFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dispatchbyFk", referencedColumnName="Employee_Pk")
     * })
     */
    private $dispatchbyfk;

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
     * @var \Tashi\CommonBundle\Entity\PrdProductUnitMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductUnitMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Unit_id_fk", referencedColumnName="pkid")
     * })
     */
    private $unitFk;



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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * Set dueQuantity
     *
     * @param integer $dueQuantity
     *
     * @return RequisitionProductDetailsHistory
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
     * Set dispatchDate
     *
     * @param \DateTime $dispatchDate
     *
     * @return RequisitionProductDetailsHistory
     */
    public function setDispatchDate($dispatchDate)
    {
        $this->dispatchDate = $dispatchDate;

        return $this;
    }

    /**
     * Get dispatchDate
     *
     * @return \DateTime
     */
    public function getDispatchDate()
    {
        return $this->dispatchDate;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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
     * Set companyCode
     *
     * @param integer $companyCode
     *
     * @return RequisitionProductDetailsHistory
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return RequisitionProductDetailsHistory
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
     * Set stockFk
     *
     * @param integer $stockFk
     *
     * @return RequisitionProductDetailsHistory
     */
    public function setStockFk($stockFk)
    {
        $this->stockFk = $stockFk;

        return $this;
    }

    /**
     * Get stockFk
     *
     * @return integer
     */
    public function getStockFk()
    {
        return $this->stockFk;
    }

    /**
     * Set dispatchbyfk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $dispatchbyfk
     *
     * @return RequisitionProductDetailsHistory
     */
    public function setDispatchbyfk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $dispatchbyfk = null)
    {
        $this->dispatchbyfk = $dispatchbyfk;

        return $this;
    }

    /**
     * Get dispatchbyfk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getDispatchbyfk()
    {
        return $this->dispatchbyfk;
    }

    /**
     * Set productFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $productFk
     *
     * @return RequisitionProductDetailsHistory
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
     * @return RequisitionProductDetailsHistory
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

    /**
     * Set unitFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductUnitMaster $unitFk
     *
     * @return RequisitionProductDetailsHistory
     */
    public function setUnitFk(\Tashi\CommonBundle\Entity\PrdProductUnitMaster $unitFk = null)
    {
        $this->unitFk = $unitFk;

        return $this;
    }

    /**
     * Get unitFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductUnitMaster
     */
    public function getUnitFk()
    {
        return $this->unitFk;
    }
}
