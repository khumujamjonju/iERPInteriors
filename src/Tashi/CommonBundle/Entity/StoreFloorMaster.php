<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreFloorMaster
 *
 * @ORM\Table(name="store_floor_master", indexes={@ORM\Index(name="fk_store_building_master_idx", columns={"Store_building_master_Fk"})})
 * @ORM\Entity
 */
class StoreFloorMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Floor_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $storeFloorPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Master_Fk", type="integer", nullable=true)
     */
    private $storeMasterFk;

    /**
     * @var string
     *
     * @ORM\Column(name="Store_Floor_No", type="string", length=11, nullable=true)
     */
    private $storeFloorNo;

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
     * @var \Tashi\CommonBundle\Entity\StoreBuildingMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreBuildingMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_building_master_Fk", referencedColumnName="Store_Building_Pk")
     * })
     */
    private $storeBuildingMasterFk;



    /**
     * Get storeFloorPk
     *
     * @return integer
     */
    public function getStoreFloorPk()
    {
        return $this->storeFloorPk;
    }

    /**
     * Set storeMasterFk
     *
     * @param integer $storeMasterFk
     *
     * @return StoreFloorMaster
     */
    public function setStoreMasterFk($storeMasterFk)
    {
        $this->storeMasterFk = $storeMasterFk;

        return $this;
    }

    /**
     * Get storeMasterFk
     *
     * @return integer
     */
    public function getStoreMasterFk()
    {
        return $this->storeMasterFk;
    }

    /**
     * Set storeFloorNo
     *
     * @param string $storeFloorNo
     *
     * @return StoreFloorMaster
     */
    public function setStoreFloorNo($storeFloorNo)
    {
        $this->storeFloorNo = $storeFloorNo;

        return $this;
    }

    /**
     * Get storeFloorNo
     *
     * @return string
     */
    public function getStoreFloorNo()
    {
        return $this->storeFloorNo;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * @return StoreFloorMaster
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
     * Set storeBuildingMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreBuildingMaster $storeBuildingMasterFk
     *
     * @return StoreFloorMaster
     */
    public function setStoreBuildingMasterFk(\Tashi\CommonBundle\Entity\StoreBuildingMaster $storeBuildingMasterFk = null)
    {
        $this->storeBuildingMasterFk = $storeBuildingMasterFk;

        return $this;
    }

    /**
     * Get storeBuildingMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreBuildingMaster
     */
    public function getStoreBuildingMasterFk()
    {
        return $this->storeBuildingMasterFk;
    }
}
