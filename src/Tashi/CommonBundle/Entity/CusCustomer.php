<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CusCustomer
 *
 * @ORM\Table(name="cus_customer", indexes={@ORM\Index(name="fk_cim_master_custype_id_idx", columns={"Customer_Type_Id"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\CustomerMasterRepository")
 */
class CusCustomer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Customer_Id_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $customerIdPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Customer_Id", type="string", length=15, nullable=true)
     */
    private $customerId;

    /**
     * @var string
     *
     * @ORM\Column(name="Customer_Name", type="string", length=255, nullable=false)
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="Customer_Business_Nature", type="string", length=255, nullable=true)
     */
    private $customerBusinessNature;

    /**
     * @var string
     *
     * @ORM\Column(name="About", type="string", length=500, nullable=true)
     */
    private $about;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Of_Incorporation", type="date", nullable=true)
     */
    private $dateOfIncorporation;

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
     * @ORM\Column(name="Trade_License_No", type="string", length=100, nullable=true)
     */
    private $tradeLicenseNo;

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
     * @ORM\Column(name="Bank_Account_No", type="string", length=15, nullable=true)
     */
    private $bankAccountNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Short_Address", type="string", length=800, nullable=true)
     */
    private $shortAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="Risk_category", type="integer", nullable=true)
     */
    private $riskCategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="Status_Flag", type="integer", nullable=false)
     */
    private $statusFlag = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="Record_Active_Flag", type="integer", nullable=false)
     */
    private $recordActiveFlag = '1';

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
     * @var string
     *
     * @ORM\Column(name="Encrypted_Random_Code", type="string", length=200, nullable=true)
     */
    private $encryptedRandomCode;

    /**
     * @var \Tashi\CommonBundle\Entity\CusTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_Type_Id", referencedColumnName="Customer_Type_Pk")
     * })
     */
    private $customerType;



    /**
     * Get customerIdPk
     *
     * @return integer
     */
    public function getCustomerIdPk()
    {
        return $this->customerIdPk;
    }

    /**
     * Set customerId
     *
     * @param string $customerId
     *
     * @return CusCustomer
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return CusCustomer
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerBusinessNature
     *
     * @param string $customerBusinessNature
     *
     * @return CusCustomer
     */
    public function setCustomerBusinessNature($customerBusinessNature)
    {
        $this->customerBusinessNature = $customerBusinessNature;

        return $this;
    }

    /**
     * Get customerBusinessNature
     *
     * @return string
     */
    public function getCustomerBusinessNature()
    {
        return $this->customerBusinessNature;
    }

    /**
     * Set about
     *
     * @param string $about
     *
     * @return CusCustomer
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set dateOfIncorporation
     *
     * @param \DateTime $dateOfIncorporation
     *
     * @return CusCustomer
     */
    public function setDateOfIncorporation($dateOfIncorporation)
    {
        $this->dateOfIncorporation = $dateOfIncorporation;

        return $this;
    }

    /**
     * Get dateOfIncorporation
     *
     * @return \DateTime
     */
    public function getDateOfIncorporation()
    {
        return $this->dateOfIncorporation;
    }

    /**
     * Set panNo
     *
     * @param string $panNo
     *
     * @return CusCustomer
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
     * @return CusCustomer
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
     * Set tradeLicenseNo
     *
     * @param string $tradeLicenseNo
     *
     * @return CusCustomer
     */
    public function setTradeLicenseNo($tradeLicenseNo)
    {
        $this->tradeLicenseNo = $tradeLicenseNo;

        return $this;
    }

    /**
     * Get tradeLicenseNo
     *
     * @return string
     */
    public function getTradeLicenseNo()
    {
        return $this->tradeLicenseNo;
    }

    /**
     * Set cstNo
     *
     * @param string $cstNo
     *
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * Set bankAccountNo
     *
     * @param string $bankAccountNo
     *
     * @return CusCustomer
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
     * Set shortAddress
     *
     * @param string $shortAddress
     *
     * @return CusCustomer
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
     * Set riskCategory
     *
     * @param integer $riskCategory
     *
     * @return CusCustomer
     */
    public function setRiskCategory($riskCategory)
    {
        $this->riskCategory = $riskCategory;

        return $this;
    }

    /**
     * Get riskCategory
     *
     * @return integer
     */
    public function getRiskCategory()
    {
        return $this->riskCategory;
    }

    /**
     * Set statusFlag
     *
     * @param integer $statusFlag
     *
     * @return CusCustomer
     */
    public function setStatusFlag($statusFlag)
    {
        $this->statusFlag = $statusFlag;

        return $this;
    }

    /**
     * Get statusFlag
     *
     * @return integer
     */
    public function getStatusFlag()
    {
        return $this->statusFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * @return CusCustomer
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
     * Set encryptedRandomCode
     *
     * @param string $encryptedRandomCode
     *
     * @return CusCustomer
     */
    public function setEncryptedRandomCode($encryptedRandomCode)
    {
        $this->encryptedRandomCode = $encryptedRandomCode;

        return $this;
    }

    /**
     * Get encryptedRandomCode
     *
     * @return string
     */
    public function getEncryptedRandomCode()
    {
        return $this->encryptedRandomCode;
    }

    /**
     * Set customerType
     *
     * @param \Tashi\CommonBundle\Entity\CusTypeMaster $customerType
     *
     * @return CusCustomer
     */
    public function setCustomerType(\Tashi\CommonBundle\Entity\CusTypeMaster $customerType = null)
    {
        $this->customerType = $customerType;

        return $this;
    }

    /**
     * Get customerType
     *
     * @return \Tashi\CommonBundle\Entity\CusTypeMaster
     */
    public function getCustomerType()
    {
        return $this->customerType;
    }
}
