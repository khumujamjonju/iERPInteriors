<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnLocationDistrictMaster
 *
 * @ORM\Table(name="cmn_location_district_master", indexes={@ORM\Index(name="fk_state_district_state_id_idx", columns={"State_Id_Fk"}), @ORM\Index(name="fk_country_district_country_id_idx", columns={"Country_Id_Fk"})})
 * @ORM\Entity
 */
class CmnLocationDistrictMaster
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
     * @ORM\Column(name="District_Name", type="string", length=200, nullable=false)
     */
    private $districtName;

    /**
     * @var string
     *
     * @ORM\Column(name="District_Code", type="string", length=5, nullable=true)
     */
    private $districtCode;

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
     * @var \Tashi\CommonBundle\Entity\CmnLocationCountryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationCountryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Country_Id_Fk", referencedColumnName="Country_Pk")
     * })
     */
    private $countryFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationStateMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationStateMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="State_Id_Fk", referencedColumnName="State_Pk")
     * })
     */
    private $stateFk;



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
     * Set districtName
     *
     * @param string $districtName
     *
     * @return CmnLocationDistrictMaster
     */
    public function setDistrictName($districtName)
    {
        $this->districtName = $districtName;

        return $this;
    }

    /**
     * Get districtName
     *
     * @return string
     */
    public function getDistrictName()
    {
        return $this->districtName;
    }

    /**
     * Set districtCode
     *
     * @param string $districtCode
     *
     * @return CmnLocationDistrictMaster
     */
    public function setDistrictCode($districtCode)
    {
        $this->districtCode = $districtCode;

        return $this;
    }

    /**
     * Get districtCode
     *
     * @return string
     */
    public function getDistrictCode()
    {
        return $this->districtCode;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * @return CmnLocationDistrictMaster
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
     * Set countryFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationCountryMaster $countryFk
     *
     * @return CmnLocationDistrictMaster
     */
    public function setCountryFk(\Tashi\CommonBundle\Entity\CmnLocationCountryMaster $countryFk = null)
    {
        $this->countryFk = $countryFk;

        return $this;
    }

    /**
     * Get countryFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationCountryMaster
     */
    public function getCountryFk()
    {
        return $this->countryFk;
    }

    /**
     * Set stateFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateFk
     *
     * @return CmnLocationDistrictMaster
     */
    public function setStateFk(\Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateFk = null)
    {
        $this->stateFk = $stateFk;

        return $this;
    }

    /**
     * Get stateFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationStateMaster
     */
    public function getStateFk()
    {
        return $this->stateFk;
    }
}
