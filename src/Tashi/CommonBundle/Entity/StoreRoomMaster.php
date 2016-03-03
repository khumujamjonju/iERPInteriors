<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreRoomMaster
 *
 * @ORM\Table(name="store_room_master", indexes={@ORM\Index(name="fk_store_floor_master_idx", columns={"Store_Floor_Master_Fk"}), @ORM\Index(name="fk_store_master2_idx", columns={"Store_Master_Fk"}), @ORM\Index(name="fk_store_building1_idx", columns={"Store_Building_Master_Fk"})})
 * @ORM\Entity
 */
class StoreRoomMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Store_Room_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $storeRoomPk;

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
     * @var string
     *
     * @ORM\Column(name="Store_Room_No", type="string", length=11, nullable=true)
     */
    private $storeRoomNo;

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
     * @var \Tashi\CommonBundle\Entity\StoreFloorMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreFloorMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_Floor_Master_Fk", referencedColumnName="Store_Floor_Pk")
     * })
     */
    private $storeFloorMasterFk;



    /**
     * Get storeRoomPk
     *
     * @return integer
     */
    public function getStoreRoomPk()
    {
        return $this->storeRoomPk;
    }

    /**
     * Set storeMasterFk
     *
     * @param integer $storeMasterFk
     *
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * Set storeRoomNo
     *
     * @param string $storeRoomNo
     *
     * @return StoreRoomMaster
     */
    public function setStoreRoomNo($storeRoomNo)
    {
        $this->storeRoomNo = $storeRoomNo;

        return $this;
    }

    /**
     * Get storeRoomNo
     *
     * @return string
     */
    public function getStoreRoomNo()
    {
        return $this->storeRoomNo;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * @return StoreRoomMaster
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
     * Set storeFloorMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreFloorMaster $storeFloorMasterFk
     *
     * @return StoreRoomMaster
     */
    public function setStoreFloorMasterFk(\Tashi\CommonBundle\Entity\StoreFloorMaster $storeFloorMasterFk = null)
    {
        $this->storeFloorMasterFk = $storeFloorMasterFk;

        return $this;
    }

    /**
     * Get storeFloorMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreFloorMaster
     */
    public function getStoreFloorMasterFk()
    {
        return $this->storeFloorMasterFk;
    }
}
