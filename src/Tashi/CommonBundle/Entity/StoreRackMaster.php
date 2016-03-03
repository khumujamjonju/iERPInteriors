<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreRackMaster
 *
 * @ORM\Table(name="store_rack_master", indexes={@ORM\Index(name="fk_room_master_idx", columns={"Store_Room_Master_Fk"}), @ORM\Index(name="fk_store_master3_idx", columns={"Store_Master_Fk"}), @ORM\Index(name="fk_store_building_master2_idx", columns={"Store_Building_Master_Fk"}), @ORM\Index(name="fk_store_floor_master_idx", columns={"Store_Floor_Master_Fk"})})
 * @ORM\Entity
 */
class StoreRackMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Rack_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $storeRackPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Master_Fk", type="integer", nullable=true)
     */
    private $storeMasterFk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Building_Master_Fk", type="integer", nullable=true)
     */
    private $storeBuildingMasterFk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Floor_Master_Fk", type="integer", nullable=true)
     */
    private $storeFloorMasterFk;

    /**
     * @var string
     *
     * @ORM\Column(name="Rack_Name", type="string", length=11, nullable=true)
     */
    private $rackName;

    /**
     * @var string
     *
     * @ORM\Column(name="Row_Number", type="string", length=11, nullable=true)
     */
    private $rowNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Column_Number", type="string", length=11, nullable=true)
     */
    private $columnNumber;

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
     * @var \Tashi\CommonBundle\Entity\StoreRoomMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreRoomMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_Room_Master_Fk", referencedColumnName="Store_Room_Pk")
     * })
     */
    private $storeRoomMasterFk;



    /**
     * Get storeRackPk
     *
     * @return integer
     */
    public function getStoreRackPk()
    {
        return $this->storeRackPk;
    }

    /**
     * Set storeMasterFk
     *
     * @param integer $storeMasterFk
     *
     * @return StoreRackMaster
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
     * Set storeBuildingMasterFk
     *
     * @param integer $storeBuildingMasterFk
     *
     * @return StoreRackMaster
     */
    public function setStoreBuildingMasterFk($storeBuildingMasterFk)
    {
        $this->storeBuildingMasterFk = $storeBuildingMasterFk;

        return $this;
    }

    /**
     * Get storeBuildingMasterFk
     *
     * @return integer
     */
    public function getStoreBuildingMasterFk()
    {
        return $this->storeBuildingMasterFk;
    }

    /**
     * Set storeFloorMasterFk
     *
     * @param integer $storeFloorMasterFk
     *
     * @return StoreRackMaster
     */
    public function setStoreFloorMasterFk($storeFloorMasterFk)
    {
        $this->storeFloorMasterFk = $storeFloorMasterFk;

        return $this;
    }

    /**
     * Get storeFloorMasterFk
     *
     * @return integer
     */
    public function getStoreFloorMasterFk()
    {
        return $this->storeFloorMasterFk;
    }

    /**
     * Set rackName
     *
     * @param string $rackName
     *
     * @return StoreRackMaster
     */
    public function setRackName($rackName)
    {
        $this->rackName = $rackName;

        return $this;
    }

    /**
     * Get rackName
     *
     * @return string
     */
    public function getRackName()
    {
        return $this->rackName;
    }

    /**
     * Set rowNumber
     *
     * @param string $rowNumber
     *
     * @return StoreRackMaster
     */
    public function setRowNumber($rowNumber)
    {
        $this->rowNumber = $rowNumber;

        return $this;
    }

    /**
     * Get rowNumber
     *
     * @return string
     */
    public function getRowNumber()
    {
        return $this->rowNumber;
    }

    /**
     * Set columnNumber
     *
     * @param string $columnNumber
     *
     * @return StoreRackMaster
     */
    public function setColumnNumber($columnNumber)
    {
        $this->columnNumber = $columnNumber;

        return $this;
    }

    /**
     * Get columnNumber
     *
     * @return string
     */
    public function getColumnNumber()
    {
        return $this->columnNumber;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * @return StoreRackMaster
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
     * Set storeRoomMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreRoomMaster $storeRoomMasterFk
     *
     * @return StoreRackMaster
     */
    public function setStoreRoomMasterFk(\Tashi\CommonBundle\Entity\StoreRoomMaster $storeRoomMasterFk = null)
    {
        $this->storeRoomMasterFk = $storeRoomMasterFk;

        return $this;
    }

    /**
     * Get storeRoomMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreRoomMaster
     */
    public function getStoreRoomMasterFk()
    {
        return $this->storeRoomMasterFk;
    }
}
