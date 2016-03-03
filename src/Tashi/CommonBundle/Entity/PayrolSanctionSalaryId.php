<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolSanctionSalaryId
 *
 * @ORM\Table(name="payrol_sanction_salary_id", indexes={@ORM\Index(name="fk_sanction_month_idx", columns={"month_fk"}), @ORM\Index(name="fk_sanction_payment_mode_idx", columns={"payment_account_by"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\AccountRepository")
 */
class PayrolSanctionSalaryId
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
     * @ORM\Column(name="year", type="string", length=10, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="sanction_description", type="string", length=1000, nullable=true)
     */
    private $sanctionDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="source_account_id", type="integer", nullable=true)
     */
    private $sourceAccountId;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_account_by", type="string", length=10, nullable=true)
     */
    private $paymentAccountBy;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_key", type="string", length=10, nullable=true)
     */
    private $entityKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_sanction", type="integer", nullable=true)
     */
    private $isSanction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sanction_date", type="date", nullable=true)
     */
    private $sanctionDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hr_approve_date", type="date", nullable=true)
     */
    private $hrApproveDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sanction_reject_date", type="date", nullable=true)
     */
    private $sanctionRejectDate;

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
     * @var \Tashi\CommonBundle\Entity\CmnMonth
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnMonth")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="month_fk", referencedColumnName="Pkid")
     * })
     */
    private $monthFk;



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
     * Set year
     *
     * @param string $year
     *
     * @return PayrolSanctionSalaryId
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PayrolSanctionSalaryId
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
     * Set sanctionDescription
     *
     * @param string $sanctionDescription
     *
     * @return PayrolSanctionSalaryId
     */
    public function setSanctionDescription($sanctionDescription)
    {
        $this->sanctionDescription = $sanctionDescription;

        return $this;
    }

    /**
     * Get sanctionDescription
     *
     * @return string
     */
    public function getSanctionDescription()
    {
        return $this->sanctionDescription;
    }
    
    /**
     * Set sourceAccountId
     *
     * @param integer $sourceAccountId
     *
     * @return PayrolSanctionSalaryId
     */
    public function setSourceAccountId($sourceAccountId)
    {
        $this->sourceAccountId = $sourceAccountId;

        return $this;
    }

    /**
     * Get sourceAccountId
     *
     * @return integer
     */
    public function getSourceAccountId()
    {
        return $this->sourceAccountId;
    }

    /**
     * Set paymentAccountBy
     *
     * @param string $paymentAccountBy
     *
     * @return PayrolSanctionSalaryId
     */
    public function setPaymentAccountBy($paymentAccountBy)
    {
        $this->paymentAccountBy = $paymentAccountBy;

        return $this;
    }

    /**
     * Get paymentAccountBy
     *
     * @return string
     */
    public function getPaymentAccountBy()
    {
        return $this->paymentAccountBy;
    }

    /**
     * Set entityKey
     *
     * @param string $entityKey
     *
     * @return PayrolSanctionSalaryId
     */
    public function setEntityKey($entityKey)
    {
        $this->entityKey = $entityKey;

        return $this;
    }

    /**
     * Get entityKey
     *
     * @return string
     */
    public function getEntityKey()
    {
        return $this->entityKey;
    }

    /**
     * Set isSanction
     *
     * @param integer $isSanction
     *
     * @return PayrolSanctionSalaryId
     */
    public function setIsSanction($isSanction)
    {
        $this->isSanction = $isSanction;

        return $this;
    }

    /**
     * Get isSanction
     *
     * @return integer
     */
    public function getIsSanction()
    {
        return $this->isSanction;
    }

    /**
     * Set sanctionDate
     *
     * @param \DateTime $sanctionDate
     *
     * @return PayrolSanctionSalaryId
     */
    public function setSanctionDate($sanctionDate)
    {
        $this->sanctionDate = $sanctionDate;

        return $this;
    }

    /**
     * Get sanctionDate
     *
     * @return \DateTime
     */
    public function getSanctionDate()
    {
        return $this->sanctionDate;
    }

    /**
     * Set hrApproveDate
     *
     * @param \DateTime $hrApproveDate
     *
     * @return PayrolSanctionSalaryId
     */
    public function setHrApproveDate($hrApproveDate)
    {
        $this->hrApproveDate = $hrApproveDate;

        return $this;
    }

    /**
     * Get hrApproveDate
     *
     * @return \DateTime
     */
    public function getHrApproveDate()
    {
        return $this->hrApproveDate;
    }

    /**
     * Set sanctionRejectDate
     *
     * @param \DateTime $sanctionRejectDate
     *
     * @return PayrolSanctionSalaryId
     */
    public function setSanctionRejectDate($sanctionRejectDate)
    {
        $this->sanctionRejectDate = $sanctionRejectDate;

        return $this;
    }

    /**
     * Get sanctionRejectDate
     *
     * @return \DateTime
     */
    public function getSanctionRejectDate()
    {
        return $this->sanctionRejectDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * @return PayrolSanctionSalaryId
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
     * Set monthFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnMonth $monthFk
     *
     * @return PayrolSanctionSalaryId
     */
    public function setMonthFk(\Tashi\CommonBundle\Entity\CmnMonth $monthFk = null)
    {
        $this->monthFk = $monthFk;

        return $this;
    }

    /**
     * Get monthFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnMonth
     */
    public function getMonthFk()
    {
        return $this->monthFk;
    }
}
