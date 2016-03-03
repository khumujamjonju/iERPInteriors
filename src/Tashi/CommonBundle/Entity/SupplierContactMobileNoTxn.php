<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierContactMobileNoTxn
 *
 * @ORM\Table(name="supplier_contact_mobile_no_txn", indexes={@ORM\Index(name="fk_cus_address_cus_id_idx", columns={"Sup_Contact_Fk"}), @ORM\Index(name="fk_cus_address_add_id_idx", columns={"Mobile_Master_Fk"})})
 * @ORM\Entity
 */
class SupplierContactMobileNoTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Sup_Contact_Mob_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $supContactMobPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Contact_Type", type="string", length=2, nullable=true)
     */
    private $contactType;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Primary_Contact", type="integer", nullable=true)
     */
    private $isPrimaryContact;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_Flag", type="integer", nullable=true)
     */
    private $approvalFlag;

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
     * @var \Tashi\CommonBundle\Entity\SupplierContactTxn
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierContactTxn")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Sup_Contact_Fk", referencedColumnName="Supp_ConTact_Pk")
     * })
     */
    private $supContactFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnMobileNoMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnMobileNoMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Mobile_Master_Fk", referencedColumnName="Pkid")
     * })
     */
    private $mobileMasterFk;



    /**
     * Get supContactMobPk
     *
     * @return integer
     */
    public function getSupContactMobPk()
    {
        return $this->supContactMobPk;
    }

    /**
     * Set contactType
     *
     * @param string $contactType
     *
     * @return SupplierContactMobileNoTxn
     */
    public function setContactType($contactType)
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * Get contactType
     *
     * @return string
     */
    public function getContactType()
    {
        return $this->contactType;
    }

    /**
     * Set isPrimaryContact
     *
     * @param integer $isPrimaryContact
     *
     * @return SupplierContactMobileNoTxn
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
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return SupplierContactMobileNoTxn
     */
    public function setApprovalFlag($approvalFlag)
    {
        $this->approvalFlag = $approvalFlag;

        return $this;
    }

    /**
     * Get approvalFlag
     *
     * @return integer
     */
    public function getApprovalFlag()
    {
        return $this->approvalFlag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * @return SupplierContactMobileNoTxn
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
     * Set supContactFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierContactTxn $supContactFk
     *
     * @return SupplierContactMobileNoTxn
     */
    public function setSupContactFk(\Tashi\CommonBundle\Entity\SupplierContactTxn $supContactFk = null)
    {
        $this->supContactFk = $supContactFk;

        return $this;
    }

    /**
     * Get supContactFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierContactTxn
     */
    public function getSupContactFk()
    {
        return $this->supContactFk;
    }

    /**
     * Set mobileMasterFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnMobileNoMaster $mobileMasterFk
     *
     * @return SupplierContactMobileNoTxn
     */
    public function setMobileMasterFk(\Tashi\CommonBundle\Entity\CmnMobileNoMaster $mobileMasterFk = null)
    {
        $this->mobileMasterFk = $mobileMasterFk;

        return $this;
    }

    /**
     * Get mobileMasterFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnMobileNoMaster
     */
    public function getMobileMasterFk()
    {
        return $this->mobileMasterFk;
    }
}
