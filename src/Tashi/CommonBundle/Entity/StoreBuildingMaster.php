<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreBuildingMaster
 *
 * @ORM\Table(name="store_building_master", indexes={@ORM\Index(name="fk_address_master_idx", columns={"Address_Master_Fk"}), @ORM\Index(name="fk_store_master_idx", columns={"Store_Master_Fk"})})
 * @ORM\Entity
 */
class StoreBuildingMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Building_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $storeBuildingPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Building_Code", type="string", length=100, nullable=true)
     */
    private $buildingCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Building_Name", type="string", length=100, nullable=true)
     */
    private $buildingName;

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
     * @var \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationAddressMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Address_Master_Fk", referencedColumnName="Address_Pk")
     * })
     */
    private $addressMasterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StoreMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_Master_Fk", referencedColumnName="Store_Master_Pk")
     * })
     */
    private $storeMasterFk;



    /**
     * Get storeBuildingPk
     *
     * @return integer
     */
    public function getStoreBuildingPk()
    {
        return $this->storeBuildingPk;
    }

    /**
     * Set buildingCode
     *
     * @param string $buildingCode
     *
     * @return StoreBuildingMaster
     */
    public function setBuildingCode($buildingCode)
    {
        $this->buildingCode = $buildingCode;

        return $this;
    }

    /**
     * Get buildingCode
     *
     * @return string
     */
    public function getBuildingCode()
    {
        return $this->buildingCode;
    }

    /**
     * Set buildingName
     *
     * @param string $buildingName
     *
     * @return StoreBuildingMaster
     */
    public function setBuildingName($buildingName)
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    /**
     * Get buildingName
     *
     * @return string
     */
    public function getBuildingName()
    {
        return $this->buildingName;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * @return StoreBuildingMaster
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
     * Set addressMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressMasterFk
     *
     * @return StoreBuildingMaster
     */
    public function setAddressMasterFk(\Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressMasterFk = null)
    {
        $this->addressMasterFk = $addressMasterFk;

        return $this;
    }

    /**
     * Get addressMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     */
    public function getAddressMasterFk()
    {
        return $this->addressMasterFk;
    }

    /**
     * Set storeMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreMaster $storeMasterFk
     *
     * @return StoreBuildingMaster
     */
    public function setStoreMasterFk(\Tashi\CommonBundle\Entity\StoreMaster $storeMasterFk = null)
    {
        $this->storeMasterFk = $storeMasterFk;

        return $this;
    }

    /**
     * Get storeMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreMaster
     */
    public function getStoreMasterFk()
    {
        return $this->storeMasterFk;
    }
}
