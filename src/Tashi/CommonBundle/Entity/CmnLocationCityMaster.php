<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnLocationCityMaster
 *
 * @ORM\Table(name="cmn_location_city_master", indexes={@ORM\Index(name="fk_city_state_id_idx", columns={"State_Id_Fk"}), @ORM\Index(name="fk_city_country_id_idx", columns={"Country_Id_Fk"}), @ORM\Index(name="fk_district_master_idx", columns={"District_Id_Fk"})})
 * @ORM\Entity
 */
class CmnLocationCityMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="City_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cityPk;

    /**
     * @var string
     *
     * @ORM\Column(name="City_Name", type="string", length=200, nullable=false)
     */
    private $cityName;

    /**
     * @var string
     *
     * @ORM\Column(name="City_Code", type="string", length=6, nullable=true)
     */
    private $cityCode;

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
     * @var \Tashi\CommonBundle\Entity\CmnLocationDistrictMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationDistrictMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="District_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $districtFk;

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
     * Get cityPk
     *
     * @return integer
     */
    public function getCityPk()
    {
        return $this->cityPk;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return CmnLocationCityMaster
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set cityCode
     *
     * @param string $cityCode
     *
     * @return CmnLocationCityMaster
     */
    public function setCityCode($cityCode)
    {
        $this->cityCode = $cityCode;

        return $this;
    }

    /**
     * Get cityCode
     *
     * @return string
     */
    public function getCityCode()
    {
        return $this->cityCode;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * @return CmnLocationCityMaster
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
     * Set districtFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationDistrictMaster $districtFk
     *
     * @return CmnLocationCityMaster
     */
    public function setDistrictFk(\Tashi\CommonBundle\Entity\CmnLocationDistrictMaster $districtFk = null)
    {
        $this->districtFk = $districtFk;

        return $this;
    }

    /**
     * Get districtFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationDistrictMaster
     */
    public function getDistrictFk()
    {
        return $this->districtFk;
    }

    /**
     * Set stateFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateFk
     *
     * @return CmnLocationCityMaster
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
