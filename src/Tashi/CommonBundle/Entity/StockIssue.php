<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockIssue
 *
 * @ORM\Table(name="stock_issue", indexes={@ORM\Index(name="fk_stock_issue", columns={"Stock_id_fk"}), @ORM\Index(name="fk_store_issue", columns={"Store_id_fk"}), @ORM\Index(name="fk_building_issue", columns={"Building_id_fk"}), @ORM\Index(name="fk_floor_issue", columns={"Floor_id_fk"}), @ORM\Index(name="fk_room_issue", columns={"Room_id_fk"}), @ORM\Index(name="fk_rack_issue", columns={"Rack_id_fk"})})
 * @ORM\Entity
 */
class StockIssue
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
     * @var \DateTime
     *
     * @ORM\Column(name="Issue_date", type="datetime", nullable=true)
     */
    private $issueDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

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
     * @var \Tashi\CommonBundle\Entity\StoreRackMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreRackMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Rack_id_fk", referencedColumnName="Store_Rack_Pk")
     * })
     */
    private $rackFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StoreBuildingMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreBuildingMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Building_id_fk", referencedColumnName="Store_Building_Pk")
     * })
     */
    private $buildingFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StoreFloorMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreFloorMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Floor_id_fk", referencedColumnName="Store_Floor_Pk")
     * })
     */
    private $floorFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StoreRoomMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreRoomMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Room_id_fk", referencedColumnName="Store_Room_Pk")
     * })
     */
    private $roomFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StockMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StockMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Stock_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $stockFk;

    /**
     * @var \Tashi\CommonBundle\Entity\StoreMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_id_fk", referencedColumnName="Store_Master_Pk")
     * })
     */
    private $storeFk;



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
     * Set issueDate
     *
     * @param \DateTime $issueDate
     *
     * @return StockIssue
     */
    public function setIssueDate($issueDate)
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    /**
     * Get issueDate
     *
     * @return \DateTime
     */
    public function getIssueDate()
    {
        return $this->issueDate;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return StockIssue
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StockIssue
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
     * @return StockIssue
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
     * @return StockIssue
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
     * @return StockIssue
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
     * @return StockIssue
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
     * @return StockIssue
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
     * @return StockIssue
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
     * Set rackFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreRackMaster $rackFk
     *
     * @return StockIssue
     */
    public function setRackFk(\Tashi\CommonBundle\Entity\StoreRackMaster $rackFk = null)
    {
        $this->rackFk = $rackFk;

        return $this;
    }

    /**
     * Get rackFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreRackMaster
     */
    public function getRackFk()
    {
        return $this->rackFk;
    }

    /**
     * Set buildingFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreBuildingMaster $buildingFk
     *
     * @return StockIssue
     */
    public function setBuildingFk(\Tashi\CommonBundle\Entity\StoreBuildingMaster $buildingFk = null)
    {
        $this->buildingFk = $buildingFk;

        return $this;
    }

    /**
     * Get buildingFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreBuildingMaster
     */
    public function getBuildingFk()
    {
        return $this->buildingFk;
    }

    /**
     * Set floorFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreFloorMaster $floorFk
     *
     * @return StockIssue
     */
    public function setFloorFk(\Tashi\CommonBundle\Entity\StoreFloorMaster $floorFk = null)
    {
        $this->floorFk = $floorFk;

        return $this;
    }

    /**
     * Get floorFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreFloorMaster
     */
    public function getFloorFk()
    {
        return $this->floorFk;
    }

    /**
     * Set roomFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreRoomMaster $roomFk
     *
     * @return StockIssue
     */
    public function setRoomFk(\Tashi\CommonBundle\Entity\StoreRoomMaster $roomFk = null)
    {
        $this->roomFk = $roomFk;

        return $this;
    }

    /**
     * Get roomFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreRoomMaster
     */
    public function getRoomFk()
    {
        return $this->roomFk;
    }

    /**
     * Set stockFk
     *
     * @param \Tashi\CommonBundle\Entity\StockMaster $stockFk
     *
     * @return StockIssue
     */
    public function setStockFk(\Tashi\CommonBundle\Entity\StockMaster $stockFk = null)
    {
        $this->stockFk = $stockFk;

        return $this;
    }

    /**
     * Get stockFk
     *
     * @return \Tashi\CommonBundle\Entity\StockMaster
     */
    public function getStockFk()
    {
        return $this->stockFk;
    }

    /**
     * Set storeFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreMaster $storeFk
     *
     * @return StockIssue
     */
    public function setStoreFk(\Tashi\CommonBundle\Entity\StoreMaster $storeFk = null)
    {
        $this->storeFk = $storeFk;

        return $this;
    }

    /**
     * Get storeFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreMaster
     */
    public function getStoreFk()
    {
        return $this->storeFk;
    }
}
