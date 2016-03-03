<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StockMaster
 *
 * @ORM\Table(name="stock_master", indexes={@ORM\Index(name="fk_prd_product_master_idx", columns={"Product_id_fk"}), @ORM\Index(name="fk_stock_po_idx", columns={"Purchaseorder_id_fk"}), @ORM\Index(name="fk_stock_prd_price_idx", columns={"Price_id_fk"}), @ORM\Index(name="fk_bin_stock", columns={"Bin_id_fk"}), @ORM\Index(name="fk_unit_stock", columns={"Unit_id_fk"}), @ORM\Index(name="fk_store_stock", columns={"Store_id_fk"}), @ORM\Index(name="fk_bldg_stock", columns={"Building_id_fk"}), @ORM\Index(name="fk_floor_stock", columns={"Floor_id_fk"}), @ORM\Index(name="fk_room_stock", columns={"Room_id_fk"}), @ORM\Index(name="fk_rack_stock", columns={"Rack_id_fk"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\StockRepository")
 */
class StockMaster
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
     * @ORM\Column(name="Description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="Quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="Reorder_qty", type="integer", nullable=true)
     */
    private $reorderQty;

    /**
     * @var string
     *
     * @ORM\Column(name="Batch_no", type="string", length=45, nullable=true)
     */
    private $batchNo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Manufacturing_date", type="date", nullable=true)
     */
    private $manufacturingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Expiry_date", type="date", nullable=true)
     */
    private $expiryDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Warranty", type="integer", nullable=true)
     */
    private $warranty;

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
     * @var \Tashi\CommonBundle\Entity\StoreBinMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreBinMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Bin_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $binFk;

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
     * @var \Tashi\CommonBundle\Entity\PoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Purchaseorder_id_fk", referencedColumnName="PO_Pk")
     * })
     */
    private $purchaseorderFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductPriceTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductPriceTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Price_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $priceFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Product_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $productFk;

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
     * @var \Tashi\CommonBundle\Entity\StoreMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\StoreMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Store_id_fk", referencedColumnName="Store_Master_Pk")
     * })
     */
    private $storeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProductUnitTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProductUnitTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Unit_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $unitFk;



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
     * Set description
     *
     * @param string $description
     *
     * @return StockMaster
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return StockMaster
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
     * Set reorderQty
     *
     * @param integer $reorderQty
     *
     * @return StockMaster
     */
    public function setReorderQty($reorderQty)
    {
        $this->reorderQty = $reorderQty;

        return $this;
    }

    /**
     * Get reorderQty
     *
     * @return integer
     */
    public function getReorderQty()
    {
        return $this->reorderQty;
    }

    /**
     * Set batchNo
     *
     * @param string $batchNo
     *
     * @return StockMaster
     */
    public function setBatchNo($batchNo)
    {
        $this->batchNo = $batchNo;

        return $this;
    }

    /**
     * Get batchNo
     *
     * @return string
     */
    public function getBatchNo()
    {
        return $this->batchNo;
    }

    /**
     * Set manufacturingDate
     *
     * @param \DateTime $manufacturingDate
     *
     * @return StockMaster
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
     * @return StockMaster
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
     * @param integer $warranty
     *
     * @return StockMaster
     */
    public function setWarranty($warranty)
    {
        $this->warranty = $warranty;

        return $this;
    }

    /**
     * Get warranty
     *
     * @return integer
     */
    public function getWarranty()
    {
        return $this->warranty;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * @return StockMaster
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
     * Set binFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreBinMaster $binFk
     *
     * @return StockMaster
     */
    public function setBinFk(\Tashi\CommonBundle\Entity\StoreBinMaster $binFk = null)
    {
        $this->binFk = $binFk;

        return $this;
    }

    /**
     * Get binFk
     *
     * @return \Tashi\CommonBundle\Entity\StoreBinMaster
     */
    public function getBinFk()
    {
        return $this->binFk;
    }

    /**
     * Set buildingFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreBuildingMaster $buildingFk
     *
     * @return StockMaster
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
     * @return StockMaster
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
     * Set purchaseorderFk
     *
     * @param \Tashi\CommonBundle\Entity\PoMaster $purchaseorderFk
     *
     * @return StockMaster
     */
    public function setPurchaseorderFk(\Tashi\CommonBundle\Entity\PoMaster $purchaseorderFk = null)
    {
        $this->purchaseorderFk = $purchaseorderFk;

        return $this;
    }

    /**
     * Get purchaseorderFk
     *
     * @return \Tashi\CommonBundle\Entity\PoMaster
     */
    public function getPurchaseorderFk()
    {
        return $this->purchaseorderFk;
    }

    /**
     * Set priceFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductPriceTxn $priceFk
     *
     * @return StockMaster
     */
    public function setPriceFk(\Tashi\CommonBundle\Entity\PrdProductPriceTxn $priceFk = null)
    {
        $this->priceFk = $priceFk;

        return $this;
    }

    /**
     * Get priceFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductPriceTxn
     */
    public function getPriceFk()
    {
        return $this->priceFk;
    }

    /**
     * Set productFk
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $productFk
     *
     * @return StockMaster
     */
    public function setProductFk(\Tashi\CommonBundle\Entity\PrdProductMaster $productFk = null)
    {
        $this->productFk = $productFk;

        return $this;
    }

    /**
     * Get productFk
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getProductFk()
    {
        return $this->productFk;
    }

    /**
     * Set roomFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreRoomMaster $roomFk
     *
     * @return StockMaster
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
     * Set storeFk
     *
     * @param \Tashi\CommonBundle\Entity\StoreMaster $storeFk
     *
     * @return StockMaster
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

    /**
     * Set unitFk
     *
     * @param \Tashi\CommonBundle\Entity\ProductUnitTxn $unitFk
     *
     * @return StockMaster
     */
    public function setUnitFk(\Tashi\CommonBundle\Entity\ProductUnitTxn $unitFk = null)
    {
        $this->unitFk = $unitFk;

        return $this;
    }

    /**
     * Get unitFk
     *
     * @return \Tashi\CommonBundle\Entity\ProductUnitTxn
     */
    public function getUnitFk()
    {
        return $this->unitFk;
    }
}
