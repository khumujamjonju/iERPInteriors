<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetMaster
 *
 * @ORM\Table(name="asset_master", indexes={@ORM\Index(name="fk_asset_category_master_idx", columns={"Asset_Category_Master_Fk"}), @ORM\Index(name="fk_asset_status_idx", columns={"Status_id"}), @ORM\Index(name="fk_asset_document_idx", columns={"asset_photoFk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\AssetRepository")
 */
class AssetMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Asset_Register_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $assetRegisterPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Asset_ID", type="string", length=45, nullable=true)
     */
    private $assetId;

    /**
     * @var string
     *
     * @ORM\Column(name="Asset_Name", type="string", length=100, nullable=false)
     */
    private $assetName;

    /**
     * @var string
     *
     * @ORM\Column(name="Asset_Description", type="string", length=250, nullable=true)
     */
    private $assetDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="Manufacturer", type="string", length=45, nullable=true)
     */
    private $manufacturer;

    /**
     * @var string
     *
     * @ORM\Column(name="Model_No", type="string", length=45, nullable=true)
     */
    private $modelNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Serial_no", type="string", length=45, nullable=true)
     */
    private $serialNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Barcode_no", type="string", length=45, nullable=true)
     */
    private $barcodeNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Purchase_Order_No", type="string", length=45, nullable=true)
     */
    private $purchaseOrderNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Purchase_price", type="decimal", precision=12, scale=0, nullable=true)
     */
    private $purchasePrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Purchase_date", type="date", nullable=true)
     */
    private $purchaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Location", type="string", length=45, nullable=true)
     */
    private $location;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Manufacturing_date", type="date", nullable=true)
     */
    private $manufacturingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expiry_Date", type="date", nullable=true)
     */
    private $expiryDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Warranty", type="date", nullable=true)
     */
    private $warranty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Registration_date", type="date", nullable=true)
     */
    private $registrationDate;

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
     * @var \Tashi\CommonBundle\Entity\AssetCategoryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AssetCategoryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Asset_Category_Master_Fk", referencedColumnName="Asset_Master_Pk")
     * })
     */
    private $assetCategoryMasterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="asset_photoFk", referencedColumnName="pkid")
     * })
     */
    private $assetPhotofk;

    /**
     * @var \Tashi\CommonBundle\Entity\AssetStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AssetStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_id", referencedColumnName="pkid")
     * })
     */
    private $status;



    /**
     * Get assetRegisterPk
     *
     * @return integer
     */
    public function getAssetRegisterPk()
    {
        return $this->assetRegisterPk;
    }

    /**
     * Set assetId
     *
     * @param string $assetId
     *
     * @return AssetMaster
     */
    public function setAssetId($assetId)
    {
        $this->assetId = $assetId;

        return $this;
    }

    /**
     * Get assetId
     *
     * @return string
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * Set assetName
     *
     * @param string $assetName
     *
     * @return AssetMaster
     */
    public function setAssetName($assetName)
    {
        $this->assetName = $assetName;

        return $this;
    }

    /**
     * Get assetName
     *
     * @return string
     */
    public function getAssetName()
    {
        return $this->assetName;
    }

    /**
     * Set assetDescription
     *
     * @param string $assetDescription
     *
     * @return AssetMaster
     */
    public function setAssetDescription($assetDescription)
    {
        $this->assetDescription = $assetDescription;

        return $this;
    }

    /**
     * Get assetDescription
     *
     * @return string
     */
    public function getAssetDescription()
    {
        return $this->assetDescription;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return AssetMaster
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
     * Set modelNo
     *
     * @param string $modelNo
     *
     * @return AssetMaster
     */
    public function setModelNo($modelNo)
    {
        $this->modelNo = $modelNo;

        return $this;
    }

    /**
     * Get modelNo
     *
     * @return string
     */
    public function getModelNo()
    {
        return $this->modelNo;
    }

    /**
     * Set serialNo
     *
     * @param string $serialNo
     *
     * @return AssetMaster
     */
    public function setSerialNo($serialNo)
    {
        $this->serialNo = $serialNo;

        return $this;
    }

    /**
     * Get serialNo
     *
     * @return string
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * Set barcodeNo
     *
     * @param string $barcodeNo
     *
     * @return AssetMaster
     */
    public function setBarcodeNo($barcodeNo)
    {
        $this->barcodeNo = $barcodeNo;

        return $this;
    }

    /**
     * Get barcodeNo
     *
     * @return string
     */
    public function getBarcodeNo()
    {
        return $this->barcodeNo;
    }

    /**
     * Set purchaseOrderNo
     *
     * @param string $purchaseOrderNo
     *
     * @return AssetMaster
     */
    public function setPurchaseOrderNo($purchaseOrderNo)
    {
        $this->purchaseOrderNo = $purchaseOrderNo;

        return $this;
    }

    /**
     * Get purchaseOrderNo
     *
     * @return string
     */
    public function getPurchaseOrderNo()
    {
        return $this->purchaseOrderNo;
    }

    /**
     * Set purchasePrice
     *
     * @param string $purchasePrice
     *
     * @return AssetMaster
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    /**
     * Get purchasePrice
     *
     * @return string
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * Set purchaseDate
     *
     * @param \DateTime $purchaseDate
     *
     * @return AssetMaster
     */
    public function setPurchaseDate($purchaseDate)
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    /**
     * Get purchaseDate
     *
     * @return \DateTime
     */
    public function getPurchaseDate()
    {
        return $this->purchaseDate;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return AssetMaster
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set manufacturingDate
     *
     * @param \DateTime $manufacturingDate
     *
     * @return AssetMaster
     */
    public function setManufacturingDate($manufacturingDate)
    {
        $this->manufacturingDate = $manufacturingDate;

        return $this;
    }

    /**
     * Get manufacturingDate
     *
     * @return \DateTime
     */
    public function getManufacturingDate()
    {
        return $this->manufacturingDate;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     *
     * @return AssetMaster
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set warranty
     *
     * @param \DateTime $warranty
     *
     * @return AssetMaster
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return \DateTime
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return AssetMaster
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AssetMaster
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
     * @return AssetMaster
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
     * @return AssetMaster
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
     * @return AssetMaster
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
     * @return AssetMaster
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
     * @return AssetMaster
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
     * @return AssetMaster
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
     * Set assetCategoryMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\AssetCategoryMaster $assetCategoryMasterFk
     *
     * @return AssetMaster
     */
    public function setAssetCategoryMasterFk(\Tashi\CommonBundle\Entity\AssetCategoryMaster $assetCategoryMasterFk = null)
    {
        $this->assetCategoryMasterFk = $assetCategoryMasterFk;

        return $this;
    }

    /**
     * Get assetCategoryMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\AssetCategoryMaster
     */
    public function getAssetCategoryMasterFk()
    {
        return $this->assetCategoryMasterFk;
    }

    /**
     * Set assetPhotofk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $assetPhotofk
     *
     * @return AssetMaster
     */
    public function setAssetPhotofk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $assetPhotofk = null)
    {
        $this->assetPhotofk = $assetPhotofk;

        return $this;
    }

    /**
     * Get assetPhotofk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getAssetPhotofk()
    {
        return $this->assetPhotofk;
    }

    /**
     * Set status
     *
     * @param \Tashi\CommonBundle\Entity\AssetStatusMaster $status
     *
     * @return AssetMaster
     */
    public function setStatus(\Tashi\CommonBundle\Entity\AssetStatusMaster $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Tashi\CommonBundle\Entity\AssetStatusMaster
     */
    public function getStatus()
    {
        return $this->status;
    }
}
