<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierContactTxn
 *
 * @ORM\Table(name="supplier_contact_txn", indexes={@ORM\Index(name="fk_cus_contact_id_txn_idx", columns={"Supplier_Fk"}), @ORM\Index(name="fk_per_contact_id_txn_idx", columns={"Person_Fk"})})
 * @ORM\Entity
 */
class SupplierContactTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Supp_ConTact_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $suppContactPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Primary_Contact", type="integer", nullable=true)
     */
    private $isPrimaryContact = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="Contact_Type_Id", type="integer", nullable=true)
     */
    private $contactTypeId;

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
     * @var \Tashi\CommonBundle\Entity\CmnPerson
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPerson")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Person_Fk", referencedColumnName="Person_Pk")
     * })
     */
    private $personFk;

    /**
     * @var \Tashi\CommonBundle\Entity\SupplierMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Supplier_Fk", referencedColumnName="Supplier_Pk")
     * })
     */
    private $supplierFk;



    /**
     * Get suppContactPk
     *
     * @return integer
     */
    public function getSuppContactPk()
    {
        return $this->suppContactPk;
    }

    /**
     * Set isPrimaryContact
     *
     * @param integer $isPrimaryContact
     *
     * @return SupplierContactTxn
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
     * Set contactTypeId
     *
     * @param integer $contactTypeId
     *
     * @return SupplierContactTxn
     */
    public function setContactTypeId($contactTypeId)
    {
        $this->contactTypeId = $contactTypeId;

        return $this;
    }

    /**
     * Get contactTypeId
     *
     * @return integer
     */
    public function getContactTypeId()
    {
        return $this->contactTypeId;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * @return SupplierContactTxn
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
     * Set personFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPerson $personFk
     *
     * @return SupplierContactTxn
     */
    public function setPersonFk(\Tashi\CommonBundle\Entity\CmnPerson $personFk = null)
    {
        $this->personFk = $personFk;

        return $this;
    }

    /**
     * Get personFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnPerson
     */
    public function getPersonFk()
    {
        return $this->personFk;
    }

    /**
     * Set supplierFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierMaster $supplierFk
     *
     * @return SupplierContactTxn
     */
    public function setSupplierFk(\Tashi\CommonBundle\Entity\SupplierMaster $supplierFk = null)
    {
        $this->supplierFk = $supplierFk;

        return $this;
    }

    /**
     * Get supplierFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierMaster
     */
    public function getSupplierFk()
    {
        return $this->supplierFk;
    }
}
