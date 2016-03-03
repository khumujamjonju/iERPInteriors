<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CusAddressTxn
 *
 * @ORM\Table(name="cus_address_txn", indexes={@ORM\Index(name="fk_cus_address_cus_id_idx", columns={"Customer_Fk"}), @ORM\Index(name="fk_cus_address_add_id_idx", columns={"Address_Id_Fk"})})
 * @ORM\Entity
 */
class CusAddressTxn
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
     * @ORM\Column(name="Address_Code", type="string", length=3, nullable=true)
     */
    private $addressCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Primary_Address", type="integer", nullable=true)
     */
    private $isPrimaryAddress;

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
     * @var \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnLocationAddressMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Address_Id_Fk", referencedColumnName="Address_Pk")
     * })
     */
    private $addressFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CusCustomer
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CusCustomer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Customer_Fk", referencedColumnName="Customer_Id_Pk")
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
     * Set addressCode
     *
     * @param string $addressCode
     *
     * @return CusAddressTxn
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
     * Set isPrimaryAddress
     *
     * @param integer $isPrimaryAddress
     *
     * @return CusAddressTxn
     */
    public function setIsPrimaryAddress($isPrimaryAddress)
    {
        $this->isPrimaryAddress = $isPrimaryAddress;

        return $this;
    }

    /**
     * Get isPrimaryAddress
     *
     * @return integer
     */
    public function getIsPrimaryAddress()
    {
        return $this->isPrimaryAddress;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * @return CusAddressTxn
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
     * Set addressFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressFk
     *
     * @return CusAddressTxn
     */
    public function setAddressFk(\Tashi\CommonBundle\Entity\CmnLocationAddressMaster $addressFk = null)
    {
        $this->addressFk = $addressFk;

        return $this;
    }

    /**
     * Get addressFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnLocationAddressMaster
     */
    public function getAddressFk()
    {
        return $this->addressFk;
    }

    /**
     * Set customerFk
     *
     * @param \Tashi\CommonBundle\Entity\CusCustomer $customerFk
     *
     * @return CusAddressTxn
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
