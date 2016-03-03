<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrdProductAttributeMaster
 *
 * @ORM\Table(name="prd_product_attribute_master")
 * @ORM\Entity
 */
class PrdProductAttributeMaster
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
     * @ORM\Column(name="cmd_level_master_id", type="integer", nullable=true)
     */
    private $cmdLevelMasterId;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_name", type="string", length=100, nullable=true)
     */
    private $attributeName;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_description", type="string", length=500, nullable=true)
     */
    private $attributeDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="attribute_datatype", type="string", length=50, nullable=true)
     */
    private $attributeDatatype;

    /**
     * @var integer
     *
     * @ORM\Column(name="length_first_para", type="integer", nullable=true)
     */
    private $lengthFirstPara;

    /**
     * @var integer
     *
     * @ORM\Column(name="length_second_para", type="integer", nullable=true)
     */
    private $lengthSecondPara;

    /**
     * @var integer
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="unit_attribute_flag", type="integer", nullable=true)
     */
    private $unitAttributeFlag;

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
     * Set cmdLevelMasterId
     *
     * @param integer $cmdLevelMasterId
     *
     * @return PrdProductAttributeMaster
     */
    public function setCmdLevelMasterId($cmdLevelMasterId)
    {
        $this->cmdLevelMasterId = $cmdLevelMasterId;

        return $this;
    }

    /**
     * Get cmdLevelMasterId
     *
     * @return integer
     */
    public function getCmdLevelMasterId()
    {
        return $this->cmdLevelMasterId;
    }

    /**
     * Set attributeName
     *
     * @param string $attributeName
     *
     * @return PrdProductAttributeMaster
     */
    public function setAttributeName($attributeName)
    {
        $this->attributeName = $attributeName;

        return $this;
    }

    /**
     * Get attributeName
     *
     * @return string
     */
    public function getAttributeName()
    {
        return $this->attributeName;
    }

    /**
     * Set attributeDescription
     *
     * @param string $attributeDescription
     *
     * @return PrdProductAttributeMaster
     */
    public function setAttributeDescription($attributeDescription)
    {
        $this->attributeDescription = $attributeDescription;

        return $this;
    }

    /**
     * Get attributeDescription
     *
     * @return string
     */
    public function getAttributeDescription()
    {
        return $this->attributeDescription;
    }

    /**
     * Set attributeDatatype
     *
     * @param string $attributeDatatype
     *
     * @return PrdProductAttributeMaster
     */
    public function setAttributeDatatype($attributeDatatype)
    {
        $this->attributeDatatype = $attributeDatatype;

        return $this;
    }

    /**
     * Get attributeDatatype
     *
     * @return string
     */
    public function getAttributeDatatype()
    {
        return $this->attributeDatatype;
    }

    /**
     * Set lengthFirstPara
     *
     * @param integer $lengthFirstPara
     *
     * @return PrdProductAttributeMaster
     */
    public function setLengthFirstPara($lengthFirstPara)
    {
        $this->lengthFirstPara = $lengthFirstPara;

        return $this;
    }

    /**
     * Get lengthFirstPara
     *
     * @return integer
     */
    public function getLengthFirstPara()
    {
        return $this->lengthFirstPara;
    }

    /**
     * Set lengthSecondPara
     *
     * @param integer $lengthSecondPara
     *
     * @return PrdProductAttributeMaster
     */
    public function setLengthSecondPara($lengthSecondPara)
    {
        $this->lengthSecondPara = $lengthSecondPara;

        return $this;
    }

    /**
     * Get lengthSecondPara
     *
     * @return integer
     */
    public function getLengthSecondPara()
    {
        return $this->lengthSecondPara;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return PrdProductAttributeMaster
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set unitAttributeFlag
     *
     * @param integer $unitAttributeFlag
     *
     * @return PrdProductAttributeMaster
     */
    public function setUnitAttributeFlag($unitAttributeFlag)
    {
        $this->unitAttributeFlag = $unitAttributeFlag;

        return $this;
    }

    /**
     * Get unitAttributeFlag
     *
     * @return integer
     */
    public function getUnitAttributeFlag()
    {
        return $this->unitAttributeFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
     * @return PrdProductAttributeMaster
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
