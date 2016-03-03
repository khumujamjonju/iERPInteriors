<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoStatusTxn
 *
 * @ORM\Table(name="po_status_txn", indexes={@ORM\Index(name="fk_postatus_po_idx", columns={"Po_id_fk"}), @ORM\Index(name="fk_postatus_staus_idx", columns={"Status_fk"})})
 * @ORM\Entity
 */
class PoStatusTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkdi", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkdi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Status_date", type="datetime", nullable=true)
     */
    private $statusDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
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
     * @var \Tashi\CommonBundle\Entity\PoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Po_id_fk", referencedColumnName="PO_Pk")
     * })
     */
    private $poFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PoStatusMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PoStatusMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Status_fk", referencedColumnName="pkid")
     * })
     */
    private $statusFk;



    /**
     * Get pkdi
     *
     * @return integer
     */
    public function getPkdi()
    {
        return $this->pkdi;
    }

    /**
     * Set statusDate
     *
     * @param \DateTime $statusDate
     *
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * @return PoStatusTxn
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
     * Set poFk
     *
     * @param \Tashi\CommonBundle\Entity\PoMaster $poFk
     *
     * @return PoStatusTxn
     */
    public function setPoFk(\Tashi\CommonBundle\Entity\PoMaster $poFk = null)
    {
        $this->poFk = $poFk;

        return $this;
    }

    /**
     * Get poFk
     *
     * @return \Tashi\CommonBundle\Entity\PoMaster
     */
    public function getPoFk()
    {
        return $this->poFk;
    }

    /**
     * Set statusFk
     *
     * @param \Tashi\CommonBundle\Entity\PoStatusMaster $statusFk
     *
     * @return PoStatusTxn
     */
    public function setStatusFk(\Tashi\CommonBundle\Entity\PoStatusMaster $statusFk = null)
    {
        $this->statusFk = $statusFk;

        return $this;
    }

    /**
     * Get statusFk
     *
     * @return \Tashi\CommonBundle\Entity\PoStatusMaster
     */
    public function getStatusFk()
    {
        return $this->statusFk;
    }
}
