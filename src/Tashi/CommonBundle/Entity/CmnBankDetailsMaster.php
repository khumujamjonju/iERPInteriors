<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnBankDetailsMaster
 *
 * @ORM\Table(name="cmn_bank_details_master", indexes={@ORM\Index(name="fk_add_address_type_idx", columns={"Branch_Name"}), @ORM\Index(name="fk_address_type_id_idx", columns={"Contact_Number"}), @ORM\Index(name="fk_city_code_idx", columns={"City_Fk"}), @ORM\Index(name="fk_state_code_idx", columns={"State_Fk"}), @ORM\Index(name="fk_country_id_idx", columns={"Country_Fk"}), @ORM\Index(name="fk_district_id_idx", columns={"District_Id_Fk"}), @ORM\Index(name="fk_account_type_master_idx", columns={"Account_Type_Master_Fk"}), @ORM\Index(name="fk_doc_photo_scan_idx", columns={"Photo_Scan_Doc_Fk"})})
 * @ORM\Entity
 */
class CmnBankDetailsMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Bank_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $bankPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Bank_Name", type="string", length=100, nullable=true)
     */
    private $bankName;

    /**
     * @var string
     *
     * @ORM\Column(name="Branch_Name", type="string", length=100, nullable=true)
     */
    private $branchName;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact_Number", type="string", length=15, nullable=true)
     */
    private $contactNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="IFSC_Code", type="string", length=45, nullable=true)
     */
    private $ifscCode;

    /**
     * @var string
     *
     * @ORM\Column(name="MICR_Code", type="string", length=45, nullable=true)
     */
    private $micrCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Branch_Code", type="string", length=45, nullable=true)
     */
    private $branchCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Account_name", type="string", length=45, nullable=true)
     */
    private $accountName;
    
    /**
     * @var string
     *
     * @ORM\Column(name="account_balance", type="decimal", precision=15, scale=0, nullable=true)
     */
    private $accountBalance;

    /**
     * @var string
     *
     * @ORM\Column(name="Account_Number", type="string", length=20, nullable=true)
     */
    private $accountNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="Address_Fk", type="integer", nullable=true)
     */
    private $addressFk;

    /**
     * @var string
     *
     * @ORM\Column(name="Location", type="string", length=500, nullable=true)
     */
    private $location;

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
     * @var \Tashi\CommonBundle\Entity\CmnBankAccountType
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankAccountType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Account_Type_Master_Fk", referencedColumnName="Bank_Acc_Type_Pk")
     * })
     */
    private $accountTypeMasterFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationCityMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationCityMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="City_Fk", referencedColumnName="City_Pk")
     * })
     */
    private $cityFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationCountryMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationCountryMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Country_Fk", referencedColumnName="Country_Pk")
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
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Photo_Scan_Doc_Fk", referencedColumnName="pkid")
     * })
     */
    private $photoScanDocFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnLocationStateMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationStateMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="State_Fk", referencedColumnName="State_Pk")
     * })
     */
    private $stateFk;



    /**
     * Get bankPk
     *
     * @return integer
     */
    public function getBankPk()
    {
        return $this->bankPk;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     *
     * @return CmnBankDetailsMaster
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;

        return $this;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set branchName
     *
     * @param string $branchName
     *
     * @return CmnBankDetailsMaster
     */
    public function setBranchName($branchName)
    {
        $this->branchName = $branchName;

        return $this;
    }

    /**
     * Get branchName
     *
     * @return string
     */
    public function getBranchName()
    {
        return $this->branchName;
    }

    /**
     * Set contactNumber
     *
     * @param string $contactNumber
     *
     * @return CmnBankDetailsMaster
     */
    public function setContactNumber($contactNumber)
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    /**
     * Get contactNumber
     *
     * @return string
     */
    public function getContactNumber()
    {
        return $this->contactNumber;
    }

    /**
     * Set ifscCode
     *
     * @param string $ifscCode
     *
     * @return CmnBankDetailsMaster
     */
    public function setIfscCode($ifscCode)
    {
        $this->ifscCode = $ifscCode;

        return $this;
    }

    /**
     * Get ifscCode
     *
     * @return string
     */
    public function getIfscCode()
    {
        return $this->ifscCode;
    }

    /**
     * Set micrCode
     *
     * @param string $micrCode
     *
     * @return CmnBankDetailsMaster
     */
    public function setMicrCode($micrCode)
    {
        $this->micrCode = $micrCode;

        return $this;
    }

    /**
     * Get micrCode
     *
     * @return string
     */
    public function getMicrCode()
    {
        return $this->micrCode;
    }

    /**
     * Set branchCode
     *
     * @param string $branchCode
     *
     * @return CmnBankDetailsMaster
     */
    public function setBranchCode($branchCode)
    {
        $this->branchCode = $branchCode;

        return $this;
    }

    /**
     * Get branchCode
     *
     * @return string
     */
    public function getBranchCode()
    {
        return $this->branchCode;
    }

    /**
     * Set accountName
     *
     * @param string $accountName
     *
     * @return CmnBankDetailsMaster
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * Get accountName
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }
    
    /**
     * Set accountBalance
     *
     * @param string $accountBalance
     *
     * @return CmnBankDetailsMaster
     */
    public function setAccountBalance($accountBalance)
    {
        $this->accountBalance = $accountBalance;

        return $this;
    }

    /**
     * Get accountBalance
     *
     * @return string
     */
    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     *
     * @return CmnBankDetailsMaster
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set addressFk
     *
     * @param integer $addressFk
     *
     * @return CmnBankDetailsMaster
     */
    public function setAddressFk($addressFk)
    {
        $this->addressFk = $addressFk;

        return $this;
    }

    /**
     * Get addressFk
     *
     * @return integer
     */
    public function getAddressFk()
    {
        return $this->addressFk;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return CmnBankDetailsMaster
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * Set accountTypeMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankAccountType $accountTypeMasterFk
     *
     * @return CmnBankDetailsMaster
     */
    public function setAccountTypeMasterFk(\Tashi\CommonBundle\Entity\CmnBankAccountType $accountTypeMasterFk = null)
    {
        $this->accountTypeMasterFk = $accountTypeMasterFk;

        return $this;
    }

    /**
     * Get accountTypeMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnBankAccountType
     */
    public function getAccountTypeMasterFk()
    {
        return $this->accountTypeMasterFk;
    }

    /**
     * Set cityFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationCityMaster $cityFk
     *
     * @return CmnBankDetailsMaster
     */
    public function setCityFk(\Tashi\CommonBundle\Entity\CmnLocationCityMaster $cityFk = null)
    {
        $this->cityFk = $cityFk;

        return $this;
    }

    /**
     * Get cityFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationCityMaster
     */
    public function getCityFk()
    {
        return $this->cityFk;
    }

    /**
     * Set countryFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationCountryMaster $countryFk
     *
     * @return CmnBankDetailsMaster
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
     * @return CmnBankDetailsMaster
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
     * Set photoScanDocFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $photoScanDocFk
     *
     * @return CmnBankDetailsMaster
     */
    public function setPhotoScanDocFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $photoScanDocFk = null)
    {
        $this->photoScanDocFk = $photoScanDocFk;

        return $this;
    }

    /**
     * Get photoScanDocFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getPhotoScanDocFk()
    {
        return $this->photoScanDocFk;
    }

    /**
     * Set stateFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationStateMaster $stateFk
     *
     * @return CmnBankDetailsMaster
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
