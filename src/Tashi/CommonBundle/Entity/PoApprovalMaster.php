<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoApprovalMaster
 *
 * @ORM\Table(name="po_approval_master", uniqueConstraints={@ORM\UniqueConstraint(name="PO_Pk_UNIQUE", columns={"PO_Approval_Pk"})}, indexes={@ORM\Index(name="fk_po_master_idx", columns={"PO_Master_Fk"})})
 * @ORM\Entity
 */
class PoApprovalMaster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="PO_Approval_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $poApprovalPk;

    /**
     * @var integer
     *
     * @ORM\Column(name="PO_Master_Fk", type="integer", nullable=true)
     */
    private $poMasterFk;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_Status", type="integer", nullable=true)
     */
    private $approvalStatus;

    /**
     * @var string
     *
     * @ORM\Column(name="Approval_Details", type="string", length=200, nullable=true)
     */
    private $approvalDetails;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Of_Approval", type="date", nullable=true)
     */
    private $dateOfApproval;

    /**
     * @var integer
     *
     * @ORM\Column(name="ApprovalFlag", type="integer", nullable=true)
     */
    private $approvalflag;

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
     * Get poApprovalPk
     *
     * @return integer
     */
    public function getPoApprovalPk()
    {
        return $this->poApprovalPk;
    }

    /**
     * Set poMasterFk
     *
     * @param integer $poMasterFk
     *
     * @return PoApprovalMaster
     */
    public function setPoMasterFk($poMasterFk)
    {
        $this->poMasterFk = $poMasterFk;

        return $this;
    }

    /**
     * Get poMasterFk
     *
     * @return integer
     */
    public function getPoMasterFk()
    {
        return $this->poMasterFk;
    }

    /**
     * Set approvalStatus
     *
     * @param integer $approvalStatus
     *
     * @return PoApprovalMaster
     */
    public function setApprovalStatus($approvalStatus)
    {
        $this->approvalStatus = $approvalStatus;

        return $this;
    }

    /**
     * Get approvalStatus
     *
     * @return integer
     */
    public function getApprovalStatus()
    {
        return $this->approvalStatus;
    }

    /**
     * Set approvalDetails
     *
     * @param string $approvalDetails
     *
     * @return PoApprovalMaster
     */
    public function setApprovalDetails($approvalDetails)
    {
        $this->approvalDetails = $approvalDetails;

        return $this;
    }

    /**
     * Get approvalDetails
     *
     * @return string
     */
    public function getApprovalDetails()
    {
        return $this->approvalDetails;
    }

    /**
     * Set dateOfApproval
     *
     * @param \DateTime $dateOfApproval
     *
     * @return PoApprovalMaster
     */
    public function setDateOfApproval($dateOfApproval)
    {
        $this->dateOfApproval = $dateOfApproval;

        return $this;
    }

    /**
     * Get dateOfApproval
     *
     * @return \DateTime
     */
    public function getDateOfApproval()
    {
        return $this->dateOfApproval;
    }

    /**
     * Set approvalflag
     *
     * @param integer $approvalflag
     *
     * @return PoApprovalMaster
     */
    public function setApprovalflag($approvalflag)
    {
        $this->approvalflag = $approvalflag;

        return $this;
    }

    /**
     * Get approvalflag
     *
     * @return integer
     */
    public function getApprovalflag()
    {
        return $this->approvalflag;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
     * @return PoApprovalMaster
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
}
