<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CusContactTxn
 *
 * @ORM\Table(name="cus_contact_txn", indexes={@ORM\Index(name="fk_cus_contact_id_txn_idx", columns={"Customer_Id_Fk"}), @ORM\Index(name="fk_per_contact_id_txn_idx", columns={"Person_Fk"})})
 * @ORM\Entity
 */
class CusContactTxn
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
     * @var \Tashi\CommonBundle\Entity\CusCustomer
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_Id_Fk", referencedColumnName="Customer_Id_Pk")
     * })
     */
    private $customerFk;



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
     * Set isPrimaryContact
     *
     * @param integer $isPrimaryContact
     *
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * @return CusContactTxn
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
     * Set customerFk
     *
     * @param \Tashi\CommonBundle\Entity\CusCustomer $customerFk
     *
     * @return CusContactTxn
     */
    public function setCustomerFk(\Tashi\CommonBundle\Entity\CusCustomer $customerFk = null)
    {
        $this->customerFk = $customerFk;

        return $this;
    }

    /**
     * Get customerFk
     *
     * @return \Tashi\CommonBundle\Entity\CusCustomer
     */
    public function getCustomerFk()
    {
        return $this->customerFk;
    }
}
