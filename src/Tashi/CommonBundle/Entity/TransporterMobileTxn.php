<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransporterMobileTxn
 *
 * @ORM\Table(name="transporter_mobile_txn", indexes={@ORM\Index(name="fk_transporter_tranmobiletxn_idx", columns={"Transporter_fk"}), @ORM\Index(name="fk_mobile_tranmobiletxn_idx", columns={"Mobile_Fk"})})
 * @ORM\Entity
 */
class TransporterMobileTxn
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
     * @var integer
     *
     * @ORM\Column(name="Is_Primary_Contact", type="integer", nullable=true)
     */
    private $isPrimaryContact;

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
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=15, nullable=true)
     */
    private $applicationUserIpAddress;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnMobileNoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnMobileNoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Mobile_Fk", referencedColumnName="Pkid")
     * })
     */
    private $mobileFk;

    /**
     * @var \Tashi\CommonBundle\Entity\TransporterMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\TransporterMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transporter_fk", referencedColumnName="Pkid")
     * })
     */
    private $transporterFk;



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
     * Set isPrimaryContact
     *
     * @param integer $isPrimaryContact
     *
     * @return TransporterMobileTxn
     */
    public function setIsPrimaryContact($isPrimaryContact)
    {
        $this->isPrimaryContact = $isPrimaryContact;

        return $this;
    }

    /**
     * Get isPrimaryContact
     *
     * @return integer
     */
    public function getIsPrimaryContact()
    {
        return $this->isPrimaryContact;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return TransporterMobileTxn
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
     * @return TransporterMobileTxn
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
     * @return TransporterMobileTxn
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
     * Set applicationUserId
     *
     * @param string $applicationUserId
     *
     * @return TransporterMobileTxn
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
     * Set applicationUserIpAddress
     *
     * @param string $applicationUserIpAddress
     *
     * @return TransporterMobileTxn
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
     * Set mobileFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnMobileNoMaster $mobileFk
     *
     * @return TransporterMobileTxn
     */
    public function setMobileFk(\Tashi\CommonBundle\Entity\CmnMobileNoMaster $mobileFk = null)
    {
        $this->mobileFk = $mobileFk;

        return $this;
    }

    /**
     * Get mobileFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnMobileNoMaster
     */
    public function getMobileFk()
    {
        return $this->mobileFk;
    }

    /**
     * Set transporterFk
     *
     * @param \Tashi\CommonBundle\Entity\TransporterMaster $transporterFk
     *
     * @return TransporterMobileTxn
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
}
