<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrdProductCategoryAttributeTxn
 *
 * @ORM\Table(name="prd_product_category_attribute_txn", indexes={@ORM\Index(name="fk_attr_master_id_idx", columns={"attribute_master_id", "category_master_id"}), @ORM\Index(name="fk_category_master_id_txn_idx", columns={"category_master_id"}), @ORM\Index(name="fk_attribute_master_id_txn_idx", columns={"attribute_master_id"})})
 * @ORM\Entity
 */
class PrdProductCategoryAttributeTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_master_id", type="integer", nullable=true)
     */
    private $categoryMasterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="attribute_master_id", type="integer", nullable=true)
     */
    private $attributeMasterId;

    /**
     * @var integer
     *
     * @ORM\Column(name="isNullable", type="integer", nullable=false)
     */
    private $isnullable;

    /**
     * @var integer
     *
     * @ORM\Column(name="validation_rule", type="integer", nullable=false)
     */
    private $validationRule;

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
     * Set categoryMasterId
     *
     * @param integer $categoryMasterId
     *
     * @return PrdProductCategoryAttributeTxn
     */
    public function setCategoryMasterId($categoryMasterId)
    {
        $this->categoryMasterId = $categoryMasterId;

        return $this;
    }

    /**
     * Get categoryMasterId
     *
     * @return integer
     */
    public function getCategoryMasterId()
    {
        return $this->categoryMasterId;
    }

    /**
     * Set attributeMasterId
     *
     * @param integer $attributeMasterId
     *
     * @return PrdProductCategoryAttributeTxn
     */
    public function setAttributeMasterId($attributeMasterId)
    {
        $this->attributeMasterId = $attributeMasterId;

        return $this;
    }

    /**
     * Get attributeMasterId
     *
     * @return integer
     */
    public function getAttributeMasterId()
    {
        return $this->attributeMasterId;
    }

    /**
     * Set isnullable
     *
     * @param integer $isnullable
     *
     * @return PrdProductCategoryAttributeTxn
     */
    public function setIsnullable($isnullable)
    {
        $this->isnullable = $isnullable;

        return $this;
    }

    /**
     * Get isnullable
     *
     * @return integer
     */
    public function getIsnullable()
    {
        return $this->isnullable;
    }

    /**
     * Set validationRule
     *
     * @param integer $validationRule
     *
     * @return PrdProductCategoryAttributeTxn
     */
    public function setValidationRule($validationRule)
    {
        $this->validationRule = $validationRule;

        return $this;
    }

    /**
     * Get validationRule
     *
     * @return integer
     */
    public function getValidationRule()
    {
        return $this->validationRule;
    }

    /**
     * Set statusFlag
     *
     * @param integer $statusFlag
     *
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
     * @return PrdProductCategoryAttributeTxn
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
