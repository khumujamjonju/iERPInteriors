<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnLocationAddressTypeMaster
 *
 * @ORM\Table(name="cmn_location_address_type_master")
 * @ORM\Entity
 */
class CmnLocationAddressTypeMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Address_Type_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $addressTypePk;

    /**
     * @var string
     *
     * @ORM\Column(name="Address_Type_Name", type="string", length=45, nullable=true)
     */
    private $addressTypeName;

    /**
     * @var string
     *
     * @ORM\Column(name="Address_Type_Code", type="string", length=5, nullable=true)
     */
    private $addressTypeCode;

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
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

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
     * Get addressTypePk
     *
     * @return integer
     */
    public function getAddressTypePk()
    {
        return $this->addressTypePk;
    }

    /**
     * Set addressTypeName
     *
     * @param string $addressTypeName
     *
     * @return CmnLocationAddressTypeMaster
     */
    public function setAddressTypeName($addressTypeName)
    {
        $this->addressTypeName = $addressTypeName;

        return $this;
    }

    /**
     * Get addressTypeName
     *
     * @return string
     */
    public function getAddressTypeName()
    {
        return $this->addressTypeName;
    }

    /**
     * Set addressTypeCode
     *
     * @param string $addressTypeCode
     *
     * @return CmnLocationAddressTypeMaster
     */
    public function setAddressTypeCode($addressTypeCode)
    {
        $this->addressTypeCode = $addressTypeCode;

        return $this;
    }

    /**
     * Get addressTypeCode
     *
     * @return string
     */
    public function getAddressTypeCode()
    {
        return $this->addressTypeCode;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnLocationAddressTypeMaster
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
     * @return CmnLocationAddressTypeMaster
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
     * @return CmnLocationAddressTypeMaster
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
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return CmnLocationAddressTypeMaster
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return CmnLocationAddressTypeMaster
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return CmnLocationAddressTypeMaster
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
     * @return CmnLocationAddressTypeMaster
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
