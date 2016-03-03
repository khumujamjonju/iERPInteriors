<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmnPerson
 *
 * @ORM\Table(name="cmn_person", indexes={@ORM\Index(name="tb_cmn_person_religion_fk", columns={"Religion"}), @ORM\Index(name="fk_document_person_idx", columns={"Picture_Id_Fk"}), @ORM\Index(name="fk_nationality_person_idx", columns={"Nationality"})})
 * @ORM\Entity
 */
class CmnPerson
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Person_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $personPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Entity_Id", type="integer", nullable=true)
     */
    private $entityId;

    /**
     * @var integer
     *
     * @ORM\Column(name="Attribute_Group_Id_Fk", type="integer", nullable=true)
     */
    private $attributeGroupIdFk;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=256, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=256, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=256, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="Person_Name", type="string", length=450, nullable=true)
     */
    private $personName;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact_Father_Name", type="string", length=255, nullable=true)
     */
    private $contactFatherName;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact_Mother_Name", type="string", length=255, nullable=true)
     */
    private $contactMotherName;

    /**
     * @var string
     *
     * @ORM\Column(name="Spouse_Name", type="string", length=255, nullable=true)
     */
    private $spouseName;

    /**
     * @var string
     *
     * @ORM\Column(name="Occupation", type="string", length=45, nullable=true)
     */
    private $occupation;

    /**
     * @var string
     *
     * @ORM\Column(name="Gender", type="string", length=2, nullable=true)
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Of_Birth", type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="Designation", type="string", length=45, nullable=true)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_Id", type="string", length=100, nullable=true)
     */
    private $emailId;

    /**
     * @var string
     *
     * @ORM\Column(name="Email_Id_Office", type="string", length=100, nullable=true)
     */
    private $emailIdOffice;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=100, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone_No", type="string", length=20, nullable=true)
     */
    private $telephoneNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Mobile_No", type="string", length=20, nullable=true)
     */
    private $mobileNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Marital_Status", type="string", length=1, nullable=true)
     */
    private $maritalStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="Relationship_type", type="string", length=100, nullable=true)
     */
    private $relationshipType;

    /**
     * @var integer
     *
     * @ORM\Column(name="Physically_challenge", type="integer", nullable=true)
     */
    private $physicallyChallenge;

    /**
     * @var string
     *
     * @ORM\Column(name="Passport_Id", type="string", length=10, nullable=true)
     */
    private $passportId;

    /**
     * @var string
     *
     * @ORM\Column(name="Pan_No", type="string", length=10, nullable=true)
     */
    private $panNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Registration_No", type="string", length=100, nullable=true)
     */
    private $registrationNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Cst_No", type="string", length=100, nullable=true)
     */
    private $cstNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Vat_No", type="string", length=100, nullable=true)
     */
    private $vatNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Service_Tax_No", type="string", length=100, nullable=true)
     */
    private $serviceTaxNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Driving_Lisence_No", type="string", length=20, nullable=true)
     */
    private $drivingLisenceNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Bank_Account_No", type="string", length=15, nullable=true)
     */
    private $bankAccountNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Adhaar_No", type="string", length=15, nullable=true)
     */
    private $adhaarNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Voter_Id", type="string", length=15, nullable=true)
     */
    private $voterId;

    /**
     * @var string
     *
     * @ORM\Column(name="Short_Address", type="string", length=1400, nullable=true)
     */
    private $shortAddress;

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
     * @var \Tashi\CommonBundle\Entity\CmnPersonNationalityMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPersonNationalityMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Nationality", referencedColumnName="Pkid")
     * })
     */
    private $nationality;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Picture_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $pictureFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnPersonReligionMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPersonReligionMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Religion", referencedColumnName="Pkid")
     * })
     */
    private $religion;



    /**
     * Get personPk
     *
     * @return integer
     */
    public function getPersonPk()
    {
        return $this->personPk;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return CmnPerson
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return integer
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set attributeGroupIdFk
     *
     * @param integer $attributeGroupIdFk
     *
     * @return CmnPerson
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return CmnPerson
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return CmnPerson
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return CmnPerson
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set personName
     *
     * @param string $personName
     *
     * @return CmnPerson
     */
    public function setPersonName($personName)
    {
        $this->personName = $personName;

        return $this;
    }

    /**
     * Get personName
     *
     * @return string
     */
    public function getPersonName()
    {
        return $this->personName;
    }

    /**
     * Set contactFatherName
     *
     * @param string $contactFatherName
     *
     * @return CmnPerson
     */
    public function setContactFatherName($contactFatherName)
    {
        $this->contactFatherName = $contactFatherName;

        return $this;
    }

    /**
     * Get contactFatherName
     *
     * @return string
     */
    public function getContactFatherName()
    {
        return $this->contactFatherName;
    }

    /**
     * Set contactMotherName
     *
     * @param string $contactMotherName
     *
     * @return CmnPerson
     */
    public function setContactMotherName($contactMotherName)
    {
        $this->contactMotherName = $contactMotherName;

        return $this;
    }

    /**
     * Get contactMotherName
     *
     * @return string
     */
    public function getContactMotherName()
    {
        return $this->contactMotherName;
    }

    /**
     * Set spouseName
     *
     * @param string $spouseName
     *
     * @return CmnPerson
     */
    public function setSpouseName($spouseName)
    {
        $this->spouseName = $spouseName;

        return $this;
    }

    /**
     * Get spouseName
     *
     * @return string
     */
    public function getSpouseName()
    {
        return $this->spouseName;
    }

    /**
     * Set occupation
     *
     * @param string $occupation
     *
     * @return CmnPerson
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return CmnPerson
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return CmnPerson
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return CmnPerson
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set emailId
     *
     * @param string $emailId
     *
     * @return CmnPerson
     */
    public function setEmailId($emailId)
    {
        $this->emailId = $emailId;

        return $this;
    }

    /**
     * Get emailId
     *
     * @return string
     */
    public function getEmailId()
    {
        return $this->emailId;
    }

    /**
     * Set emailIdOffice
     *
     * @param string $emailIdOffice
     *
     * @return CmnPerson
     */
    public function setEmailIdOffice($emailIdOffice)
    {
        $this->emailIdOffice = $emailIdOffice;

        return $this;
    }

    /**
     * Get emailIdOffice
     *
     * @return string
     */
    public function getEmailIdOffice()
    {
        return $this->emailIdOffice;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return CmnPerson
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
     * Set telephoneNo
     *
     * @param string $telephoneNo
     *
     * @return CmnPerson
     */
    public function setTelephoneNo($telephoneNo)
    {
        $this->telephoneNo = $telephoneNo;

        return $this;
    }

    /**
     * Get telephoneNo
     *
     * @return string
     */
    public function getTelephoneNo()
    {
        return $this->telephoneNo;
    }

    /**
     * Set mobileNo
     *
     * @param string $mobileNo
     *
     * @return CmnPerson
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;

        return $this;
    }

    /**
     * Get mobileNo
     *
     * @return string
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * Set maritalStatus
     *
     * @param string $maritalStatus
     *
     * @return CmnPerson
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }

    /**
     * Get maritalStatus
     *
     * @return string
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * Set relationshipType
     *
     * @param string $relationshipType
     *
     * @return CmnPerson
     */
    public function setRelationshipType($relationshipType)
    {
        $this->relationshipType = $relationshipType;

        return $this;
    }

    /**
     * Get relationshipType
     *
     * @return string
     */
    public function getRelationshipType()
    {
        return $this->relationshipType;
    }

    /**
     * Set physicallyChallenge
     *
     * @param integer $physicallyChallenge
     *
     * @return CmnPerson
     */
    public function setPhysicallyChallenge($physicallyChallenge)
    {
        $this->physicallyChallenge = $physicallyChallenge;

        return $this;
    }

    /**
     * Get physicallyChallenge
     *
     * @return integer
     */
    public function getPhysicallyChallenge()
    {
        return $this->physicallyChallenge;
    }

    /**
     * Set passportId
     *
     * @param string $passportId
     *
     * @return CmnPerson
     */
    public function setPassportId($passportId)
    {
        $this->passportId = $passportId;

        return $this;
    }

    /**
     * Get passportId
     *
     * @return string
     */
    public function getPassportId()
    {
        return $this->passportId;
    }

    /**
     * Set panNo
     *
     * @param string $panNo
     *
     * @return CmnPerson
     */
    public function setPanNo($panNo)
    {
        $this->panNo = $panNo;

        return $this;
    }

    /**
     * Get panNo
     *
     * @return string
     */
    public function getPanNo()
    {
        return $this->panNo;
    }

    /**
     * Set registrationNo
     *
     * @param string $registrationNo
     *
     * @return CmnPerson
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
     * Set cstNo
     *
     * @param string $cstNo
     *
     * @return CmnPerson
     */
    public function setCstNo($cstNo)
    {
        $this->cstNo = $cstNo;

        return $this;
    }

    /**
     * Get cstNo
     *
     * @return string
     */
    public function getCstNo()
    {
        return $this->cstNo;
    }

    /**
     * Set vatNo
     *
     * @param string $vatNo
     *
     * @return CmnPerson
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
     * Set serviceTaxNo
     *
     * @param string $serviceTaxNo
     *
     * @return CmnPerson
     */
    public function setServiceTaxNo($serviceTaxNo)
    {
        $this->serviceTaxNo = $serviceTaxNo;

        return $this;
    }

    /**
     * Get serviceTaxNo
     *
     * @return string
     */
    public function getServiceTaxNo()
    {
        return $this->serviceTaxNo;
    }

    /**
     * Set drivingLisenceNo
     *
     * @param string $drivingLisenceNo
     *
     * @return CmnPerson
     */
    public function setDrivingLisenceNo($drivingLisenceNo)
    {
        $this->drivingLisenceNo = $drivingLisenceNo;

        return $this;
    }

    /**
     * Get drivingLisenceNo
     *
     * @return string
     */
    public function getDrivingLisenceNo()
    {
        return $this->drivingLisenceNo;
    }

    /**
     * Set bankAccountNo
     *
     * @param string $bankAccountNo
     *
     * @return CmnPerson
     */
    public function setBankAccountNo($bankAccountNo)
    {
        $this->bankAccountNo = $bankAccountNo;

        return $this;
    }

    /**
     * Get bankAccountNo
     *
     * @return string
     */
    public function getBankAccountNo()
    {
        return $this->bankAccountNo;
    }

    /**
     * Set adhaarNo
     *
     * @param string $adhaarNo
     *
     * @return CmnPerson
     */
    public function setAdhaarNo($adhaarNo)
    {
        $this->adhaarNo = $adhaarNo;

        return $this;
    }

    /**
     * Get adhaarNo
     *
     * @return string
     */
    public function getAdhaarNo()
    {
        return $this->adhaarNo;
    }

    /**
     * Set voterId
     *
     * @param string $voterId
     *
     * @return CmnPerson
     */
    public function setVoterId($voterId)
    {
        $this->voterId = $voterId;

        return $this;
    }

    /**
     * Get voterId
     *
     * @return string
     */
    public function getVoterId()
    {
        return $this->voterId;
    }

    /**
     * Set shortAddress
     *
     * @param string $shortAddress
     *
     * @return CmnPerson
     */
    public function setShortAddress($shortAddress)
    {
        $this->shortAddress = $shortAddress;

        return $this;
    }

    /**
     * Get shortAddress
     *
     * @return string
     */
    public function getShortAddress()
    {
        return $this->shortAddress;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CmnPerson
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
     * @return CmnPerson
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
     * @return CmnPerson
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
     * @return CmnPerson
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
     * @return CmnPerson
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
     * Set branchOfficeCode
     *
     * @param integer $branchOfficeCode
     *
     * @return CmnPerson
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
     * @return CmnPerson
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
     * Set nationality
     *
     * @param \Tashi\CommonBundle\Entity\CmnPersonNationalityMaster $nationality
     *
     * @return CmnPerson
     */
    public function setNationality(\Tashi\CommonBundle\Entity\CmnPersonNationalityMaster $nationality = null)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return \Tashi\CommonBundle\Entity\CmnPersonNationalityMaster
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set pictureFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $pictureFk
     *
     * @return CmnPerson
     */
    public function setPictureFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $pictureFk = null)
    {
        $this->pictureFk = $pictureFk;

        return $this;
    }

    /**
     * Get pictureFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getPictureFk()
    {
        return $this->pictureFk;
    }

    /**
     * Set religion
     *
     * @param \Tashi\CommonBundle\Entity\CmnPersonReligionMaster $religion
     *
     * @return CmnPerson
     */
    public function setReligion(\Tashi\CommonBundle\Entity\CmnPersonReligionMaster $religion = null)
    {
        $this->religion = $religion;

        return $this;
    }

    /**
     * Get religion
     *
     * @return \Tashi\CommonBundle\Entity\CmnPersonReligionMaster
     */
    public function getReligion()
    {
        return $this->religion;
    }
}
