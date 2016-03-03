<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountDetailsMaster
 *
 * @ORM\Table(name="account_details_master", indexes={@ORM\Index(name="fk_asset_status_idx", columns={"Amount"}), @ORM\Index(name="fk_category_account_headd_idx", columns={"Account_Head_Id_Fk"}), @ORM\Index(name="fk_employee_account", columns={"Application_User_Id"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\AccountRepository")
 */
class AccountDetailsMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pkid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pkid;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="account_key", type="string", length=10, nullable=true)
     */
    private $accountKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="account_id", type="integer", nullable=true)
     */
    private $accountId;

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
     * @ORM\Column(name="PRC_format", type="string", length=45, nullable=true)
     */
    private $prcFormat;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Application_User_Id", referencedColumnName="Employee_Pk")
     * })
     */
    private $applicationUser;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountHeadMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountHeadMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Account_Head_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $accountHeadFk;



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
     * Set amount
     *
     * @param string $amount
     *
     * @return AccountDetailsMaster
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return AccountDetailsMaster
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AccountDetailsMaster
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set accountKey
     *
     * @param string $accountKey
     *
     * @return AccountDetailsMaster
     */
    public function setAccountKey($accountKey)
    {
        $this->accountKey = $accountKey;

        return $this;
    }

    /**
     * Get accountKey
     *
     * @return string
     */
    public function getAccountKey()
    {
        return $this->accountKey;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     *
     * @return AccountDetailsMaster
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AccountDetailsMaster
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
     * @return AccountDetailsMaster
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
     * @return AccountDetailsMaster
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
     * @return AccountDetailsMaster
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
     * @return AccountDetailsMaster
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
     * @return AccountDetailsMaster
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
     * Set prcFormat
     *
     * @param string $prcFormat
     *
     * @return AccountDetailsMaster
     */
    public function setPrcFormat($prcFormat)
    {
        $this->prcFormat = $prcFormat;

        return $this;
    }

    /**
     * Get prcFormat
     *
     * @return string
     */
    public function getPrcFormat()
    {
        return $this->prcFormat;
    }

    /**
     * Set applicationUser
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $applicationUser
     *
     * @return AccountDetailsMaster
     */
    public function setApplicationUser(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $applicationUser = null)
    {
        $this->applicationUser = $applicationUser;

        return $this;
    }

    /**
     * Get applicationUser
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getApplicationUser()
    {
        return $this->applicationUser;
    }

    /**
     * Set accountHeadFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountHeadMaster $accountHeadFk
     *
     * @return AccountDetailsMaster
     */
    public function setAccountHeadFk(\Tashi\CommonBundle\Entity\AccountHeadMaster $accountHeadFk = null)
    {
        $this->accountHeadFk = $accountHeadFk;

        return $this;
    }

    /**
     * Get accountHeadFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountHeadMaster
     */
    public function getAccountHeadFk()
    {
        return $this->accountHeadFk;
    }
}
