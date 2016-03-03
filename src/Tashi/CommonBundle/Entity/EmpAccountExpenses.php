<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmpAccountExpenses
 *
 * @ORM\Table(name="emp_account_expenses", indexes={@ORM\Index(name="fk_account_expense_idx", columns={"Accnt_id_fk"}), @ORM\Index(name="fk_emp_expense_idx", columns={"Emp_id_fk"}), @ORM\Index(name="fk_projectid_fk_idx", columns={"Project_id_fk"}), @ORM\Index(name="fk_emp_expense_type_idx", columns={"expenses_type"}), @ORM\Index(name="fk_document_fk_idx", columns={"Document_Fk"}), @ORM\Index(name="fk_item_idx", columns={"Item_id"})})
 * @ORM\Entity(repositoryClass="Tashi\CommonBundle\Repository\WalletRepository")
 */
class EmpAccountExpenses
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
     * @ORM\Column(name="expenses_description", type="string", length=300, nullable=true)
     */
    private $expensesDescription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expenses_date", type="datetime", nullable=true)
     */
    private $expensesDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="approved_by", type="integer", nullable=true)
     */
    private $approvedBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="status_remark", type="string", length=500, nullable=true)
     */
    private $statusRemark;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status_date", type="date", nullable=true)
     */
    private $statusDate;

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
     * @ORM\Column(name="Application_User_Id", type="string", length=45, nullable=true)
     */
    private $applicationUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="Application_User_Ip_Address", type="string", length=45, nullable=true)
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
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Document_Fk", referencedColumnName="pkid")
     * })
     */
    private $documentFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpAccount
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpAccount")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Accnt_id_fk", referencedColumnName="Accnt_id")
     * })
     */
    private $accntFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Emp_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empFk;

    /**
     * @var \Tashi\CommonBundle\Entity\PrdProductMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\PrdProductMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Item_id", referencedColumnName="Pkid")
     * })
     */
    private $item;

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
     * @var \Tashi\CommonBundle\Entity\EmpAccountSourcetype
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpAccountSourcetype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="expenses_type", referencedColumnName="Pkid")
     * })
     */
    private $expensesType;



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
     * Set expensesDescription
     *
     * @param string $expensesDescription
     *
     * @return EmpAccountExpenses
     */
    public function setExpensesDescription($expensesDescription)
    {
        $this->expensesDescription = $expensesDescription;

        return $this;
    }

    /**
     * Get expensesDescription
     *
     * @return string
     */
    public function getExpensesDescription()
    {
        return $this->expensesDescription;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return EmpAccountExpenses
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return EmpAccountExpenses
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
     * Set expensesDate
     *
     * @param \DateTime $expensesDate
     *
     * @return EmpAccountExpenses
     */
    public function setExpensesDate($expensesDate)
    {
        $this->expensesDate = $expensesDate;

        return $this;
    }

    /**
     * Get expensesDate
     *
     * @return \DateTime
     */
    public function getExpensesDate()
    {
        return $this->expensesDate;
    }

    /**
     * Set approvedBy
     *
     * @param integer $approvedBy
     *
     * @return EmpAccountExpenses
     */
    public function setApprovedBy($approvedBy)
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    /**
     * Get approvedBy
     *
     * @return integer
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EmpAccountExpenses
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set statusRemark
     *
     * @param string $statusRemark
     *
     * @return EmpAccountExpenses
     */
    public function setStatusRemark($statusRemark)
    {
        $this->statusRemark = $statusRemark;

        return $this;
    }

    /**
     * Get statusRemark
     *
     * @return string
     */
    public function getStatusRemark()
    {
        return $this->statusRemark;
    }

    /**
     * Set statusDate
     *
     * @param \DateTime $statusDate
     *
     * @return EmpAccountExpenses
     */
    public function setStatusDate($statusDate)
    {
        $this->statusDate = $statusDate;

        return $this;
    }

    /**
     * Get statusDate
     *
     * @return \DateTime
     */
    public function getStatusDate()
    {
        return $this->statusDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * @return EmpAccountExpenses
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
     * Set documentFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $documentFk
     *
     * @return EmpAccountExpenses
     */
    public function setDocumentFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $documentFk = null)
    {
        $this->documentFk = $documentFk;

        return $this;
    }

    /**
     * Get documentFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getDocumentFk()
    {
        return $this->documentFk;
    }

    /**
     * Set accntFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpAccount $accntFk
     *
     * @return EmpAccountExpenses
     */
    public function setAccntFk(\Tashi\CommonBundle\Entity\EmpAccount $accntFk = null)
    {
        $this->accntFk = $accntFk;

        return $this;
    }

    /**
     * Get accntFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpAccount
     */
    public function getAccntFk()
    {
        return $this->accntFk;
    }

    /**
     * Set empFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk
     *
     * @return EmpAccountExpenses
     */
    public function setEmpFk(\Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk = null)
    {
        $this->empFk = $empFk;

        return $this;
    }

    /**
     * Get empFk
     *
     * @return \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     */
    public function getEmpFk()
    {
        return $this->empFk;
    }

    /**
     * Set item
     *
     * @param \Tashi\CommonBundle\Entity\PrdProductMaster $item
     *
     * @return EmpAccountExpenses
     */
    public function setItem(\Tashi\CommonBundle\Entity\PrdProductMaster $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Tashi\CommonBundle\Entity\PrdProductMaster
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set projectFk
     *
     * @param \Tashi\CommonBundle\Entity\ProjectMaster $projectFk
     *
     * @return EmpAccountExpenses
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

    /**
     * Set expensesType
     *
     * @param \Tashi\CommonBundle\Entity\EmpAccountSourcetype $expensesType
     *
     * @return EmpAccountExpenses
     */
    public function setExpensesType(\Tashi\CommonBundle\Entity\EmpAccountSourcetype $expensesType = null)
    {
        $this->expensesType = $expensesType;

        return $this;
    }

    /**
     * Get expensesType
     *
     * @return \Tashi\CommonBundle\Entity\EmpAccountSourcetype
     */
    public function getExpensesType()
    {
        return $this->expensesType;
    }
}
