<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnLocationAddressMaster
 *
 * @ORM\Table(name="cmn_location_address_master", indexes={@ORM\Index(name="fk_address_type_id_idx", columns={"Address_Type_Id_Fk"}), @ORM\Index(name="fk_city_code_idx", columns={"City_Code_fk"}), @ORM\Index(name="fk_state_code_idx", columns={"State_Code_fk"}), @ORM\Index(name="fk_country_id_idx", columns={"Country_Code_fk"}), @ORM\Index(name="fk_district_id_idx", columns={"District_Id_fk"}), @ORM\Index(name="fk_map_file_id_idx", columns={"map_file_id"})})
 * @ORM\Entity
 */
class CmnLocationAddressMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Address_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $addressPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Attribute_Group_Id_Fk", type="integer", nullable=true)
     */
    private $attributeGroupIdFk;

    /**
     * @var string
     *
     * @ORM\Column(name="Address_Code", type="string", length=5, nullable=true)
     */
    private $addressCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Address_Title", type="string", length=245, nullable=true)
     */
    private $addressTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="Address1", type="string", length=450, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="Address2", type="string", length=450, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="owner_lease", type="string", length=45, nullable=true)
     */
    private $ownerLease;

    /**
     * @var string
     *
     * @ORM\Column(name="City_name", type="string", length=455, nullable=true)
     */
    private $cityName;

    /**
     * @var string
     *
     * @ORM\Column(name="Route", type="string", length=1000, nullable=true)
     */
    private $route;

    /**
     * @var string
     *
     * @ORM\Column(name="Locality", type="string", length=1000, nullable=true)
     */
    private $locality;

    /**
     * @var string
     *
     * @ORM\Column(name="Block_Village", type="string", length=445, nullable=true)
     */
    private $blockVillage;

    /**
     * @var integer
     *
     * @ORM\Column(name="Pin_Number", type="integer", nullable=true)
     */
    private $pinNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Police_Station", type="string", length=245, nullable=true)
     */
    private $policeStation;

    /**
     * @var string
     *
     * @ORM\Column(name="Post_Office", type="string", length=245, nullable=true)
     */
    private $postOffice;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_latitude", type="string", length=50, nullable=true)
     */
    private $gpsLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="gps_logitude", type="string", length=50, nullable=true)
     */
    private $gpsLogitude;

    /**
     * @var string
     *
     * @ORM\Column(name="landmark", type="string", length=450, nullable=true)
     */
    private $landmark;

    /**
     * @var integer
     *
     * @ORM\Column(name="map_file_id", type="integer", nullable=true)
     */
    private $mapFileId;

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
     * @var \Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Address_Type_Id_Fk", referencedColumnName="Address_Type_Pk")
     * })
     */
    private $addressTypeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationCityMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationCityMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="City_Code_fk", referencedColumnName="City_Pk")
     * })
     */
    private $cityCodeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationCountryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationCountryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Country_Code_fk", referencedColumnName="Country_Pk")
     * })
     */
    private $countryCodeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationDistrictMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationDistrictMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="District_Id_fk", referencedColumnName="Pkid")
     * })
     */
    private $districtFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationStateMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationStateMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="State_Code_fk", referencedColumnName="State_Pk")
     * })
     */
    private $stateCodeFk;



    /**
     * Get addressPk
     *
     * @return integer
     */
    public function getAddressPk()
    {
        return $this->addressPk;
    }

    /**
     * Set attributeGroupIdFk
     *
     * @param integer $attributeGroupIdFk
     *
     * @return CmnLocationAddressMaster
     */
    public function setAttributeGroupIdFk($attributeGroupIdFk)
    {
        $this->attributeGroupIdFk = $attributeGroupIdFk;

        return $this;
    }

    /**
     * Get attributeGroupIdFk
     *
     * @return integer
     */
    public function getAttributeGroupIdFk()
    {
        return $this->attributeGroupIdFk;
    }

    /**
     * Set addressCode
     *
     * @param string $addressCode
     *
     * @return CmnLocationAddressMaster
     */
    public function setAddressCode($addressCode)
    {
        $this->addressCode = $addressCode;

        return $this;
    }

    /**
     * Get addressCode
     *
     * @return string
     */
    public function getAddressCode()
    {
        return $this->addressCode;
    }

    /**
     * Set addressTitle
     *
     * @param string $addressTitle
     *
     * @return CmnLocationAddressMaster
     */
    public function setAddressTitle($addressTitle)
    {
        $this->addressTitle = $addressTitle;

        return $this;
    }

    /**
     * Get addressTitle
     *
     * @return string
     */
    public function getAddressTitle()
    {
        return $this->addressTitle;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return CmnLocationAddressMaster
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return CmnLocationAddressMaster
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set ownerLease
     *
     * @param string $ownerLease
     *
     * @return CmnLocationAddressMaster
     */
    public function setOwnerLease($ownerLease)
    {
        $this->ownerLease = $ownerLease;

        return $this;
    }

    /**
     * Get ownerLease
     *
     * @return string
     */
    public function getOwnerLease()
    {
        return $this->ownerLease;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return CmnLocationAddressMaster
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
     * Set route
     *
     * @param string $route
     *
     * @return CmnLocationAddressMaster
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set locality
     *
     * @param string $locality
     *
     * @return CmnLocationAddressMaster
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set blockVillage
     *
     * @param string $blockVillage
     *
     * @return CmnLocationAddressMaster
     */
    public function setBlockVillage($blockVillage)
    {
        $this->blockVillage = $blockVillage;

        return $this;
    }

    /**
     * Get blockVillage
     *
     * @return string
     */
    public function getBlockVillage()
    {
        return $this->blockVillage;
    }

    /**
     * Set pinNumber
     *
     * @param integer $pinNumber
     *
     * @return CmnLocationAddressMaster
     */
    public function setPinNumber($pinNumber)
    {
        $this->pinNumber = $pinNumber;

        return $this;
    }

    /**
     * Get pinNumber
     *
     * @return integer
     */
    public function getPinNumber()
    {
        return $this->pinNumber;
    }

    /**
     * Set policeStation
     *
     * @param string $policeStation
     *
     * @return CmnLocationAddressMaster
     */
    public function setPoliceStation($policeStation)
    {
        $this->policeStation = $policeStation;

        return $this;
    }

    /**
     * Get policeStation
     *
     * @return string
     */
    public function getPoliceStation()
    {
        return $this->policeStation;
    }

    /**
     * Set postOffice
     *
     * @param string $postOffice
     *
     * @return CmnLocationAddressMaster
     */
    public function setPostOffice($postOffice)
    {
        $this->postOffice = $postOffice;

        return $this;
    }

    /**
     * Get postOffice
     *
     * @return string
     */
    public function getPostOffice()
    {
        return $this->postOffice;
    }

    /**
     * Set gpsLatitude
     *
     * @param string $gpsLatitude
     *
     * @return CmnLocationAddressMaster
     */
    public function setGpsLatitude($gpsLatitude)
    {
        $this->gpsLatitude = $gpsLatitude;

        return $this;
    }

    /**
     * Get gpsLatitude
     *
     * @return string
     */
    public function getGpsLatitude()
    {
        return $this->gpsLatitude;
    }

    /**
     * Set gpsLogitude
     *
     * @param string $gpsLogitude
     *
     * @return CmnLocationAddressMaster
     */
    public function setGpsLogitude($gpsLogitude)
    {
        $this->gpsLogitude = $gpsLogitude;

        return $this;
    }

    /**
     * Get gpsLogitude
     *
     * @return string
     */
    public function getGpsLogitude()
    {
        return $this->gpsLogitude;
    }

    /**
     * Set landmark
     *
     * @param string $landmark
     *
     * @return CmnLocationAddressMaster
     */
    public function setLandmark($landmark)
    {
        $this->landmark = $landmark;

        return $this;
    }

    /**
     * Get landmark
     *
     * @return string
     */
    public function getLandmark()
    {
        return $this->landmark;
    }

    /**
     * Set mapFileId
     *
     * @param integer $mapFileId
     *
     * @return CmnLocationAddressMaster
     */
    public function setMapFileId($mapFileId)
    {
        $this->mapFileId = $mapFileId;

        return $this;
    }

    /**
     * Get mapFileId
     *
     * @return integer
     */
    public function getMapFileId()
    {
        return $this->mapFileId;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * @return CmnLocationAddressMaster
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
     * Set addressTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster $addressTypeFk
     *
     * @return CmnLocationAddressMaster
     */
    public function setAddressTypeFk(\Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster $addressTypeFk = null)
    {
        $this->addressTypeFk = $addressTypeFk;

        return $this;
    }

    /**
     * Get addressTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationAddressTypeMaster
     */
    public function getAddressTypeFk()
    {
        return $this->addressTypeFk;
    }

    /**
     * Set cityCodeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationCityMaster $cityCodeFk
     *
     * @return CmnLocationAddressMaster
     */
    public function setCityCodeFk(\Tashi\CommonBundle\Entity\CmnLocationCityMaster $cityCodeFk = null)
    {
        $this->cityCodeFk = $cityCodeFk;

        return $this;
    }

    /**
     * Get cityCodeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationCityMaster
     */
    public function getCityCodeFk()
    {
        return $this->cityCodeFk;
    }

    /**
     * Set countryCodeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationCountryMaster $countryCodeFk
     *
     * @return CmnLocationAddressMaster
     */
    public function setCountryCodeFk(\Tashi\CommonBundle\Entity\CmnLocationCountryMaster $countryCodeFk = null)
    {
        $this->countryCodeFk = $countryCodeFk;

        return $this;
    }

    /**
     * Get countryCodeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationCountryMaster
     */
    public function getCountryCodeFk()
    {
        return $this->countryCodeFk;
    }

    /**
     * Set districtFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationDistrictMaster $districtFk
     *
     * @return CmnLocationAddressMaster
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
     * Set stateCodeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateCodeFk
     *
     * @return CmnLocationAddressMaster
     */
    public function setStateCodeFk(\Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateCodeFk = null)
    {
        $this->stateCodeFk = $stateCodeFk;

        return $this;
    }

    /**
     * Get stateCodeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationStateMaster
     */
    public function getStateCodeFk()
    {
        return $this->stateCodeFk;
    }
}
