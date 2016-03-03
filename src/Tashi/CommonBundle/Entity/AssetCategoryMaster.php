<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssetCategoryMaster
 *
 * @ORM\Table(name="asset_category_master")
 * @ORM\Entity
 */
class AssetCategoryMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Asset_Master_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $assetMasterPk;

    /**
     * @var string
     *
     * @ORM\Column(name="asset_category_id", type="string", length=45, nullable=true)
     */
    private $assetCategoryId;

    /**
     * @var string
     *
     * @ORM\Column(name="Asset_Category_Name", type="string", length=100, nullable=false)
     */
    private $assetCategoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="Asset_Description", type="string", length=250, nullable=true)
     */
    private $assetDescription;

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
     * Get assetMasterPk
     *
     * @return integer
     */
    public function getAssetMasterPk()
    {
        return $this->assetMasterPk;
    }

    /**
     * Set assetCategoryId
     *
     * @param string $assetCategoryId
     *
     * @return AssetCategoryMaster
     */
    public function setAssetCategoryId($assetCategoryId)
    {
        $this->assetCategoryId = $assetCategoryId;

        return $this;
    }

    /**
     * Get assetCategoryId
     *
     * @return string
     */
    public function getAssetCategoryId()
    {
        return $this->assetCategoryId;
    }

    /**
     * Set assetCategoryName
     *
     * @param string $assetCategoryName
     *
     * @return AssetCategoryMaster
     */
    public function setAssetCategoryName($assetCategoryName)
    {
        $this->assetCategoryName = $assetCategoryName;

        return $this;
    }

    /**
     * Get assetCategoryName
     *
     * @return string
     */
    public function getAssetCategoryName()
    {
        return $this->assetCategoryName;
    }

    /**
     * Set assetDescription
     *
     * @param string $assetDescription
     *
     * @return AssetCategoryMaster
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
     * @return AssetCategoryMaster
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
}
