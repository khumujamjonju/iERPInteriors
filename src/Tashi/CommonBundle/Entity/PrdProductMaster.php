<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrdProductMaster
 *
 * @ORM\Table(name="prd_product_master", indexes={@ORM\Index(name="fk_prd_product_cat_id_idx", columns={"Product_Category_Id"}), @ORM\Index(name="fk_document_product_idx", columns={"Picture_id_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\PrdProductMasterRepository")
 */
class PrdProductMaster
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
     * @ORM\Column(name="SKU", type="string", length=45, nullable=true)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="Product_Code", type="string", length=15, nullable=false)
     */
    private $productCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Product_BarCode", type="string", length=45, nullable=true)
     */
    private $productBarcode;

    /**
     * @var string
     *
     * @ORM\Column(name="Product_Name", type="string", length=250, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="Product_Desc", type="string", length=450, nullable=true)
     */
    private $productDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="Manufacturer", type="string", length=45, nullable=true)
     */
    private $manufacturer;

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
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Picture_id_fk", referencedColumnName="pkid")
     * })
     */
    private $pictureFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductCategoryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Product_Category_Id", referencedColumnName="Pkid")
     * })
     */
    private $productCategory;



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
     * Set sku
     *
     * @param string $sku
     *
     * @return PrdProductMaster
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set productCode
     *
     * @param string $productCode
     *
     * @return PrdProductMaster
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get productCode
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set productBarcode
     *
     * @param string $productBarcode
     *
     * @return PrdProductMaster
     */
    public function setProductBarcode($productBarcode)
    {
        $this->productBarcode = $productBarcode;

        return $this;
    }

    /**
     * Get productBarcode
     *
     * @return string
     */
    public function getProductBarcode()
    {
        return $this->productBarcode;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return PrdProductMaster
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productDesc
     *
     * @param string $productDesc
     *
     * @return PrdProductMaster
     */
    public function setProductDesc($productDesc)
    {
        $this->productDesc = $productDesc;

        return $this;
    }

    /**
     * Get productDesc
     *
     * @return string
     */
    public function getProductDesc()
    {
        return $this->productDesc;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return PrdProductMaster
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set statusFlag
     *
     * @param integer $statusFlag
     *
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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
     * @return PrdProductMaster
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

    /**
     * Set pictureFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $pictureFk
     *
     * @return PrdProductMaster
     */
    public function setPictureFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $pictureFk = null)
    {
        $this->pictureFk = $pictureFk;

        return $this;
    }

    /**
     * Get pictureFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getPictureFk()
    {
        return $this->pictureFk;
    }

    /**
     * Set productCategory
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductCategoryMaster $productCategory
     *
     * @return PrdProductMaster
     */
    public function setProductCategory(\Tashi\CommonBundle\Entity\PrdProductCategoryMaster $productCategory = null)
    {
        $this->productCategory = $productCategory;

        return $this;
    }

    /**
     * Get productCategory
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductCategoryMaster
     */
    public function getProductCategory()
    {
        return $this->productCategory;
    }
}
