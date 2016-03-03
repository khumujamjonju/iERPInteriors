<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrdProductAttributeValueTxn
 *
 * @ORM\Table(name="prd_product_attribute_value_txn", indexes={@ORM\Index(name="fk_prdMaster_id_idx", columns={"Product_Master_Id"}), @ORM\Index(name="fk_prdCategory_attr_txn_id_idx", columns={"prd_category_attribute_txn_id"}), @ORM\Index(name="fk_prd_attr_unit_txn_Id_idx", columns={"prd_attribute_unit_Id"})})
 * @ORM\Entity
 */
class PrdProductAttributeValueTxn
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
     * @ORM\Column(name="Product_Master_Id", type="integer", nullable=false)
     */
    private $productMasterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="prd_category_attribute_txn_id", type="integer", nullable=false)
     */
    private $prdCategoryAttributeTxnId;

    /**
     * @var string
     *
     * @ORM\Column(name="prd_attribute_value", type="string", length=30, nullable=true)
     */
    private $prdAttributeValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="prd_attribute_unit_Id", type="integer", nullable=true)
     */
    private $prdAttributeUnitId;

    /**
     * @var integer
     *
     * @ORM\Column(name="Status_Flag", type="integer", nullable=false)
     */
    private $statusFlag;

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
     * Get pkid
     *
     * @return integer
     */
    public function getPkid()
    {
        return $this->pkid;
    }

    /**
     * Set productMasterId
     *
     * @param integer $productMasterId
     *
     * @return PrdProductAttributeValueTxn
     */
    public function setProductMasterId($productMasterId)
    {
        $this->productMasterId = $productMasterId;

        return $this;
    }

    /**
     * Get productMasterId
     *
     * @return integer
     */
    public function getProductMasterId()
    {
        return $this->productMasterId;
    }

    /**
     * Set prdCategoryAttributeTxnId
     *
     * @param integer $prdCategoryAttributeTxnId
     *
     * @return PrdProductAttributeValueTxn
     */
    public function setPrdCategoryAttributeTxnId($prdCategoryAttributeTxnId)
    {
        $this->prdCategoryAttributeTxnId = $prdCategoryAttributeTxnId;

        return $this;
    }

    /**
     * Get prdCategoryAttributeTxnId
     *
     * @return integer
     */
    public function getPrdCategoryAttributeTxnId()
    {
        return $this->prdCategoryAttributeTxnId;
    }

    /**
     * Set prdAttributeValue
     *
     * @param string $prdAttributeValue
     *
     * @return PrdProductAttributeValueTxn
     */
    public function setPrdAttributeValue($prdAttributeValue)
    {
        $this->prdAttributeValue = $prdAttributeValue;

        return $this;
    }

    /**
     * Get prdAttributeValue
     *
     * @return string
     */
    public function getPrdAttributeValue()
    {
        return $this->prdAttributeValue;
    }

    /**
     * Set prdAttributeUnitId
     *
     * @param integer $prdAttributeUnitId
     *
     * @return PrdProductAttributeValueTxn
     */
    public function setPrdAttributeUnitId($prdAttributeUnitId)
    {
        $this->prdAttributeUnitId = $prdAttributeUnitId;

        return $this;
    }

    /**
     * Get prdAttributeUnitId
     *
     * @return integer
     */
    public function getPrdAttributeUnitId()
    {
        return $this->prdAttributeUnitId;
    }

    /**
     * Set statusFlag
     *
     * @param integer $statusFlag
     *
     * @return PrdProductAttributeValueTxn
     */
    public function setStatusFlag($statusFlag)
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * Get statusFlag
     *
     * @return integer
     */
    public function getStatusFlag()
    {
        return $this->statusFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
     * @return PrdProductAttributeValueTxn
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
}
