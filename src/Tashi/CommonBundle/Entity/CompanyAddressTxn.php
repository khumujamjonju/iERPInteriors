<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyAddressTxn
 *
 * @ORM\Table(name="company_address_txn", indexes={@ORM\Index(name="fk_cus_address_cus_id_idx", columns={"Company_id_fk"}), @ORM\Index(name="fk_cus_address_add_id_idx", columns={"Address_Id_Fk"})})
 * @ORM\Entity
 */
class CompanyAddressTxn
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
     * @var \Tashi\CommonBundle\Entity\CompanyMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CompanyMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Company_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $companyFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationAddressMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Address_Id_Fk", referencedColumnName="Address_Pk")
     * })
     */
    private $addressFk;



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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CompanyAddressTxn
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
     * @return CompanyAddressTxn
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
     * @return CompanyAddressTxn
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
     * @return CompanyAddressTxn
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
     * @return CompanyAddressTxn
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
     * Set companyFk
     *
     * @param \Tashi\CommonBundle\Entity\CompanyMaster $companyFk
     *
     * @return CompanyAddressTxn
     */
    public function setCompanyFk(\Tashi\CommonBundle\Entity\CompanyMaster $companyFk = null)
    {
        $this->companyFk = $companyFk;

        return $this;
    }

    /**
     * Get companyFk
     *
     * @return \Tashi\CommonBundle\Entity\CompanyMaster
     */
    public function getCompanyFk()
    {
        return $this->companyFk;
    }

    /**
     * Set addressFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressFk
     *
     * @return CompanyAddressTxn
     */
    public function setAddressFk(\Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressFk = null)
    {
        $this->addressFk = $addressFk;

        return $this;
    }

    /**
     * Get addressFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     */
    public function getAddressFk()
    {
        return $this->addressFk;
    }
}
