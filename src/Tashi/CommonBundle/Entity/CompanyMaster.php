<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyMaster
 *
 * @ORM\Table(name="company_master", indexes={@ORM\Index(name="fk_logo_company_idx", columns={"Logo_fk"})})
 * @ORM\Entity
 */
class CompanyMaster
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
     * @ORM\Column(name="Company_Id", type="string", length=15, nullable=true)
     */
    private $companyId;

    /**
     * @var string
     *
     * @ORM\Column(name="Company_Name", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="Slogan", type="string", length=100, nullable=true)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=100, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="Registration_No", type="string", length=45, nullable=true)
     */
    private $registrationNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Tan_no", type="string", length=45, nullable=true)
     */
    private $tanNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Tin_no", type="string", length=45, nullable=true)
     */
    private $tinNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Cin_no", type="string", length=100, nullable=true)
     */
    private $cinNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Vat_no", type="string", length=45, nullable=true)
     */
    private $vatNo;

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
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Logo_fk", referencedColumnName="pkid")
     * })
     */
    private $logoFk;



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
     * Set companyId
     *
     * @param string $companyId
     *
     * @return CompanyMaster
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return CompanyMaster
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     *
     * @return CompanyMaster
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;

        return $this;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return CompanyMaster
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set registrationNo
     *
     * @param string $registrationNo
     *
     * @return CompanyMaster
     */
    public function setRegistrationNo($registrationNo)
    {
        $this->registrationNo = $registrationNo;

        return $this;
    }

    /**
     * Get registrationNo
     *
     * @return string
     */
    public function getRegistrationNo()
    {
        return $this->registrationNo;
    }

    /**
     * Set tanNo
     *
     * @param string $tanNo
     *
     * @return CompanyMaster
     */
    public function setTanNo($tanNo)
    {
        $this->tanNo = $tanNo;

        return $this;
    }

    /**
     * Get tanNo
     *
     * @return string
     */
    public function getTanNo()
    {
        return $this->tanNo;
    }

    /**
     * Set tinNo
     *
     * @param string $tinNo
     *
     * @return CompanyMaster
     */
    public function setTinNo($tinNo)
    {
        $this->tinNo = $tinNo;

        return $this;
    }

    /**
     * Get tinNo
     *
     * @return string
     */
    public function getTinNo()
    {
        return $this->tinNo;
    }

    /**
     * Set cinNo
     *
     * @param string $cinNo
     *
     * @return CompanyMaster
     */
    public function setCinNo($cinNo)
    {
        $this->cinNo = $cinNo;

        return $this;
    }

    /**
     * Get cinNo
     *
     * @return string
     */
    public function getCinNo()
    {
        return $this->cinNo;
    }

    /**
     * Set vatNo
     *
     * @param string $vatNo
     *
     * @return CompanyMaster
     */
    public function setVatNo($vatNo)
    {
        $this->vatNo = $vatNo;

        return $this;
    }

    /**
     * Get vatNo
     *
     * @return string
     */
    public function getVatNo()
    {
        return $this->vatNo;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CompanyMaster
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
     * @return CompanyMaster
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
     * @return CompanyMaster
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
     * @return CompanyMaster
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
     * @return CompanyMaster
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
     * Set logoFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $logoFk
     *
     * @return CompanyMaster
     */
    public function setLogoFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $logoFk = null)
    {
        $this->logoFk = $logoFk;

        return $this;
    }

    /**
     * Get logoFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getLogoFk()
    {
        return $this->logoFk;
    }
}
