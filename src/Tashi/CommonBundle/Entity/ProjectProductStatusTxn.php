<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectProductStatusTxn
 *
 * @ORM\Table(name="project_product_status_txn", indexes={@ORM\Index(name="fk_item_prdstatustxn_idx", columns={"Item_id_fk"}), @ORM\Index(name="fk_prdstatus_prdstatustxn_idx", columns={"Status_fk"})})
 * @ORM\Entity
 */
class ProjectProductStatusTxn
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
     * @ORM\Column(name="Status_date", type="datetime", nullable=true)
     */
    private $statusDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=1000, nullable=true)
     */
    private $remarks;

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
     * @var \Tashi\CommonBundle\Entity\ProjectItemTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectItemTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Item_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $itemFk;

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
     * Set statusDate
     *
     * @param \DateTime $statusDate
     *
     * @return ProjectProductStatusTxn
     */
    public function setStatusDate($statusDate)
    {
        $this->statusDate = $statusDate;

        return $this;
    }

    /**
     * Get statusDate
     *
     * @return \DateTime
     */
    public function getStatusDate()
    {
        return $this->statusDate;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return ProjectProductStatusTxn
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ProjectProductStatusTxn
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
     * @return ProjectProductStatusTxn
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
     * @return ProjectProductStatusTxn
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
     * @return ProjectProductStatusTxn
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
     * @return ProjectProductStatusTxn
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
     * @return ProjectProductStatusTxn
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
     * Set itemFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemTxn $itemFk
     *
     * @return ProjectProductStatusTxn
     */
    public function setItemFk(\Tashi\CommonBundle\Entity\ProjectItemTxn $itemFk = null)
    {
        $this->itemFk = $itemFk;

        return $this;
    }

    /**
     * Get itemFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectItemTxn
     */
    public function getItemFk()
    {
        return $this->itemFk;
    }

    /**
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectItemStatusMaster $statusFk
     *
     * @return ProjectProductStatusTxn
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
