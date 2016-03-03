<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoTransportTxn
 *
 * @ORM\Table(name="po_transport_txn", indexes={@ORM\Index(name="fk_po_potransporttxn_idx", columns={"Po_id_fk"}), @ORM\Index(name="fk_transmode_potransporttxn_idx", columns={"Transport_mode_fk"}), @ORM\Index(name="fk_transporter_potransporttxn_idx", columns={"Transporter_id_fk"})})
 * @ORM\Entity
 */
class PoTransportTxn
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
     * @ORM\Column(name="Transport_cost", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $transportCost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Status_date", type="datetime", nullable=true)
     */
    private $statusDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Record_insert", type="string", length=45, nullable=true)
     */
    private $recordInsert;

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
     * @var \Tashi\CommonBundle\Entity\TransporterMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\TransporterMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transporter_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $transporterFk;

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
     * @var \Tashi\CommonBundle\Entity\TransportModeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\TransportModeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transport_mode_fk", referencedColumnName="Pkid")
     * })
     */
    private $transportModeFk;



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
     * Set transportCost
     *
     * @param string $transportCost
     *
     * @return PoTransportTxn
     */
    public function setTransportCost($transportCost)
    {
        $this->transportCost = $transportCost;

        return $this;
    }

    /**
     * Get transportCost
     *
     * @return string
     */
    public function getTransportCost()
    {
        return $this->transportCost;
    }

    /**
     * Set statusDate
     *
     * @param \DateTime $statusDate
     *
     * @return PoTransportTxn
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
     * Set recordInsert
     *
     * @param string $recordInsert
     *
     * @return PoTransportTxn
     */
    public function setRecordInsert($recordInsert)
    {
        $this->recordInsert = $recordInsert;

        return $this;
    }

    /**
     * Get recordInsert
     *
     * @return string
     */
    public function getRecordInsert()
    {
        return $this->recordInsert;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * @return PoTransportTxn
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
     * Set transporterFk
     *
     * @param \Tashi\CommonBundle\Entity\TransporterMaster $transporterFk
     *
     * @return PoTransportTxn
     */
    public function setTransporterFk(\Tashi\CommonBundle\Entity\TransporterMaster $transporterFk = null)
    {
        $this->transporterFk = $transporterFk;

        return $this;
    }

    /**
     * Get transporterFk
     *
     * @return \Tashi\CommonBundle\Entity\TransporterMaster
     */
    public function getTransporterFk()
    {
        return $this->transporterFk;
    }

    /**
     * Set poFk
     *
     * @param \Tashi\CommonBundle\Entity\PoMaster $poFk
     *
     * @return PoTransportTxn
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
     * Set transportModeFk
     *
     * @param \Tashi\CommonBundle\Entity\TransportModeMaster $transportModeFk
     *
     * @return PoTransportTxn
     */
    public function setTransportModeFk(\Tashi\CommonBundle\Entity\TransportModeMaster $transportModeFk = null)
    {
        $this->transportModeFk = $transportModeFk;

        return $this;
    }

    /**
     * Get transportModeFk
     *
     * @return \Tashi\CommonBundle\Entity\TransportModeMaster
     */
    public function getTransportModeFk()
    {
        return $this->transportModeFk;
    }
}
