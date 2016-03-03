<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectExpenses
 *
 * @ORM\Table(name="project_expenses", indexes={@ORM\Index(name="fk_project_wallet_idx", columns={"Project_id_fk"}), @ORM\Index(name="fk_document_projexpense_idx", columns={"Proof_id_fk"})})
 * @ORM\Entity
 */
class ProjectExpenses
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
     * @ORM\Column(name="Particulars", type="string", length=45, nullable=true)
     */
    private $particulars;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Transaction_date", type="datetime", nullable=true)
     */
    private $transactionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_flag", type="integer", nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="Is_billed", type="integer", nullable=true)
     */
    private $isBilled = '0';

    /**
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Proof_id_fk", referencedColumnName="pkid")
     * })
     */
    private $proofFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ProjectMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ProjectMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Project_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $projectFk;



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
     * Set particulars
     *
     * @param string $particulars
     *
     * @return ProjectExpenses
     */
    public function setParticulars($particulars)
    {
        $this->particulars = $particulars;

        return $this;
    }

    /**
     * Get particulars
     *
     * @return string
     */
    public function getParticulars()
    {
        return $this->particulars;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProjectExpenses
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
     * Set transactionDate
     *
     * @param \DateTime $transactionDate
     *
     * @return ProjectExpenses
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }

    /**
     * Get transactionDate
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return ProjectExpenses
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
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * @return ProjectExpenses
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
     * Set isBilled
     *
     * @param integer $isBilled
     *
     * @return ProjectExpenses
     */
    public function setIsBilled($isBilled)
    {
        $this->isBilled = $isBilled;

        return $this;
    }

    /**
     * Get isBilled
     *
     * @return integer
     */
    public function getIsBilled()
    {
        return $this->isBilled;
    }

    /**
     * Set proofFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $proofFk
     *
     * @return ProjectExpenses
     */
    public function setProofFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $proofFk = null)
    {
        $this->proofFk = $proofFk;

        return $this;
    }

    /**
     * Get proofFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getProofFk()
    {
        return $this->proofFk;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return ProjectExpenses
     */
    public function setProjectFk(\Tashi\CommonBundle\Entity\ProjectMaster $projectFk = null)
    {
        $this->projectFk = $projectFk;

        return $this;
    }

    /**
     * Get projectFk
     *
     * @return \Tashi\CommonBundle\Entity\ProjectMaster
     */
    public function getProjectFk()
    {
        return $this->projectFk;
    }
}
