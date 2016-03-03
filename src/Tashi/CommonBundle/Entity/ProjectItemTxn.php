<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectItemTxn
 *
 * @ORM\Table(name="project_item_txn", indexes={@ORM\Index(name="fk_projectmaster_itemtxn_idx", columns={"Project_id_fk"}), @ORM\Index(name="fk_itemmaster_itemtxn_idx", columns={"Item_id_fk"}), @ORM\Index(name="fk_status_item_idx", columns={"Status_fk"}), @ORM\Index(name="fk_prodstatus_item_idx", columns={"Product_status_fk"}), @ORM\Index(name="fk_service_itemtxn_idx", columns={"Service_id_fk"})})
 * @ORM\Entity
 */
class ProjectItemTxn
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
     * @ORM\Column(name="Item_name", type="string", length=100, nullable=true)
     */
    private $itemName;

    /**
     * @var string
     *
     * @ORM\Column(name="Service_description", type="string", length=500, nullable=true)
     */
    private $serviceDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="Team_no", type="integer", nullable=true)
     */
    private $teamNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Area_detail", type="string", length=1000, nullable=true)
     */
    private $areaDetail;

    /**
     * @var string
     *
     * @ORM\Column(name="Special_instruction", type="string", length=1000, nullable=true)
     */
    private $specialInstruction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Start_date", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expected_end_date", type="date", nullable=true)
     */
    private $expectedEndDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Actual_end_date", type="date", nullable=true)
     */
    private $actualEndDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Unit", type="string", length=45, nullable=true)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="Unit_price", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $unitPrice;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_started", type="integer", nullable=true)
     */
    private $isStarted;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_billed", type="integer", nullable=true)
     */
    private $isBilled;

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
     * @var \Tashi\CommonBundle\Entity\PrdServiceTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdServiceTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Service_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $serviceFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Item_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $itemFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectProductStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectProductStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Product_status_fk", referencedColumnName="Pkid")
     * })
     */
    private $productStatusFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectItemStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectItemStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_fk", referencedColumnName="pkid")
     * })
     */
    private $statusFk;



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
     * Set itemName
     *
     * @param string $itemName
     *
     * @return ProjectItemTxn
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set serviceDescription
     *
     * @param string $serviceDescription
     *
     * @return ProjectItemTxn
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    /**
     * Get serviceDescription
     *
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * Set teamNo
     *
     * @param integer $teamNo
     *
     * @return ProjectItemTxn
     */
    public function setTeamNo($teamNo)
    {
        $this->teamNo = $teamNo;

        return $this;
    }

    /**
     * Get teamNo
     *
     * @return integer
     */
    public function getTeamNo()
    {
        return $this->teamNo;
    }

    /**
     * Set areaDetail
     *
     * @param string $areaDetail
     *
     * @return ProjectItemTxn
     */
    public function setAreaDetail($areaDetail)
    {
        $this->areaDetail = $areaDetail;

        return $this;
    }

    /**
     * Get areaDetail
     *
     * @return string
     */
    public function getAreaDetail()
    {
        return $this->areaDetail;
    }

    /**
     * Set specialInstruction
     *
     * @param string $specialInstruction
     *
     * @return ProjectItemTxn
     */
    public function setSpecialInstruction($specialInstruction)
    {
        $this->specialInstruction = $specialInstruction;

        return $this;
    }

    /**
     * Get specialInstruction
     *
     * @return string
     */
    public function getSpecialInstruction()
    {
        return $this->specialInstruction;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return ProjectItemTxn
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set expectedEndDate
     *
     * @param \DateTime $expectedEndDate
     *
     * @return ProjectItemTxn
     */
    public function setExpectedEndDate($expectedEndDate)
    {
        $this->expectedEndDate = $expectedEndDate;

        return $this;
    }

    /**
     * Get expectedEndDate
     *
     * @return \DateTime
     */
    public function getExpectedEndDate()
    {
        return $this->expectedEndDate;
    }

    /**
     * Set actualEndDate
     *
     * @param \DateTime $actualEndDate
     *
     * @return ProjectItemTxn
     */
    public function setActualEndDate($actualEndDate)
    {
        $this->actualEndDate = $actualEndDate;

        return $this;
    }

    /**
     * Get actualEndDate
     *
     * @return \DateTime
     */
    public function getActualEndDate()
    {
        return $this->actualEndDate;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return ProjectItemTxn
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set unitPrice
     *
     * @param string $unitPrice
     *
     * @return ProjectItemTxn
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Get unitPrice
     *
     * @return string
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return ProjectItemTxn
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
     * Set isStarted
     *
     * @param integer $isStarted
     *
     * @return ProjectItemTxn
     */
    public function setIsStarted($isStarted)
    {
        $this->isStarted = $isStarted;

        return $this;
    }

    /**
     * Get isStarted
     *
     * @return integer
     */
    public function getIsStarted()
    {
        return $this->isStarted;
    }

    /**
     * Set isBilled
     *
     * @param integer $isBilled
     *
     * @return ProjectItemTxn
     */
    public function setIsBilled($isBilled)
    {
        $this->isBilled = $isBilled;

        return $this;
    }

    /**
     * Get isBilled
     *
     * @return integer
     */
    public function getIsBilled()
    {
        return $this->isBilled;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * @return ProjectItemTxn
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
     * Set serviceFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdServiceTxn $serviceFk
     *
     * @return ProjectItemTxn
     */
    public function setServiceFk(\Tashi\CommonBundle\Entity\PrdServiceTxn $serviceFk = null)
    {
        $this->serviceFk = $serviceFk;

        return $this;
    }

    /**
     * Get serviceFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdServiceTxn
     */
    public function getServiceFk()
    {
        return $this->serviceFk;
    }

    /**
     * Set itemFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $itemFk
     *
     * @return ProjectItemTxn
     */
    public function setItemFk(\Tashi\CommonBundle\Entity\PrdProductMaster $itemFk = null)
    {
        $this->itemFk = $itemFk;

        return $this;
    }

    /**
     * Get itemFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getItemFk()
    {
        return $this->itemFk;
    }

    /**
     * Set productStatusFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectProductStatusMaster $productStatusFk
     *
     * @return ProjectItemTxn
     */
    public function setProductStatusFk(\Tashi\CommonBundle\Entity\ProjectProductStatusMaster $productStatusFk = null)
    {
        $this->productStatusFk = $productStatusFk;

        return $this;
    }

    /**
     * Get productStatusFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectProductStatusMaster
     */
    public function getProductStatusFk()
    {
        return $this->productStatusFk;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return ProjectItemTxn
     */
    public function setProjectFk(\Tashi\CommonBundle\Entity\ProjectMaster $projectFk = null)
    {
        $this->projectFk = $projectFk;

        return $this;
    }

    /**
     * Get projectFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectMaster
     */
    public function getProjectFk()
    {
        return $this->projectFk;
    }

    /**
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemStatusMaster $statusFk
     *
     * @return ProjectItemTxn
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\ProjectItemStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectItemStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }
}
