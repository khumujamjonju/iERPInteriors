<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountHeadMaster
 *
 * @ORM\Table(name="account_head_master", indexes={@ORM\Index(name="fk_asset_status_idx", columns={"Head_Name"}), @ORM\Index(name="fk_account_type_master_idx", columns={"Account_Type_Id_Fk"})})
 * @ORM\Entity
 */
class AccountHeadMaster
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
     * @ORM\Column(name="Head_Name", type="string", length=45, nullable=true)
     */
    private $headName;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Reserve", type="integer", nullable=true)
     */
    private $isReserve;

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
     * @var \Tashi\CommonBundle\Entity\AccountTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Account_Type_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $accountTypeFk;



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
     * Set headName
     *
     * @param string $headName
     *
     * @return AccountHeadMaster
     */
    public function setHeadName($headName)
    {
        $this->headName = $headName;

        return $this;
    }

    /**
     * Get headName
     *
     * @return string
     */
    public function getHeadName()
    {
        return $this->headName;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AccountHeadMaster
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
     * Set isReserve
     *
     * @param integer $isReserve
     *
     * @return AccountHeadMaster
     */
    public function setIsReserve($isReserve)
    {
        $this->isReserve = $isReserve;

        return $this;
    }

    /**
     * Get isReserve
     *
     * @return integer
     */
    public function getIsReserve()
    {
        return $this->isReserve;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * @return AccountHeadMaster
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
     * Set accountTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountTypeMaster $accountTypeFk
     *
     * @return AccountHeadMaster
     */
    public function setAccountTypeFk(\Tashi\CommonBundle\Entity\AccountTypeMaster $accountTypeFk = null)
    {
        $this->accountTypeFk = $accountTypeFk;

        return $this;
    }

    /**
     * Get accountTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountTypeMaster
     */
    public function getAccountTypeFk()
    {
        return $this->accountTypeFk;
    }
}
