<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoProjectProductDetails
 *
 * @ORM\Table(name="po_project_product_details", uniqueConstraints={@ORM\UniqueConstraint(name="PO_Pk_UNIQUE", columns={"PO_Pro_Prod_Pk"})}, indexes={@ORM\Index(name="fk_po_master_idx", columns={"PO_Project_Details_Fk"}), @ORM\Index(name="fk_po_product_details_idx", columns={"PO_Product_Detail_Fk"})})
 * @ORM\Entity
 */
class PoProjectProductDetails
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PO_Pro_Prod_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $poProProdPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

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
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PO_Product_Detail_Fk", referencedColumnName="Pkid")
     * })
     */
    private $poProductDetailFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PO_Project_Details_Fk", referencedColumnName="Pkid")
     * })
     */
    private $poProjectDetailsFk;



    /**
     * Get poProProdPk
     *
     * @return integer
     */
    public function getPoProProdPk()
    {
        return $this->poProProdPk;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return PoProjectProductDetails
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
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * @return PoProjectProductDetails
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
     * Set poProductDetailFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $poProductDetailFk
     *
     * @return PoProjectProductDetails
     */
    public function setPoProductDetailFk(\Tashi\CommonBundle\Entity\PrdProductMaster $poProductDetailFk = null)
    {
        $this->poProductDetailFk = $poProductDetailFk;

        return $this;
    }

    /**
     * Get poProductDetailFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getPoProductDetailFk()
    {
        return $this->poProductDetailFk;
    }

    /**
     * Set poProjectDetailsFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $poProjectDetailsFk
     *
     * @return PoProjectProductDetails
     */
    public function setPoProjectDetailsFk(\Tashi\CommonBundle\Entity\ProjectMaster $poProjectDetailsFk = null)
    {
        $this->poProjectDetailsFk = $poProjectDetailsFk;

        return $this;
    }

    /**
     * Get poProjectDetailsFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectMaster
     */
    public function getPoProjectDetailsFk()
    {
        return $this->poProjectDetailsFk;
    }
}
