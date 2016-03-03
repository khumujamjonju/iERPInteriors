<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountTransactionContraReciept
 *
 * @ORM\Table(name="account_transaction_contra_reciept", indexes={@ORM\Index(name="fk_transaction_contra_type_idx", columns={"transaction_type_fk"}), @ORM\Index(name="fk_employee_contra", columns={"Application_User_Id"})})
 * @ORM\Entity
 */
class AccountTransactionContraReciept
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
     * @ORM\Column(name="receipt_no", type="string", length=1000, nullable=true)
     */
    private $receiptNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="account_from", type="integer", nullable=true)
     */
    private $accountFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="account_to", type="integer", nullable=true)
     */
    private $accountTo;

    /**
     * @var string
     *
     * @ORM\Column(name="done_by", type="string", length=45, nullable=true)
     */
    private $doneBy;

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
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Application_User_Id", referencedColumnName="Employee_Pk")
     * })
     */
    private $applicationUser;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_type_fk", referencedColumnName="Pkid")
     * })
     */
    private $transactionTypeFk;



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
     * Set receiptNo
     *
     * @param string $receiptNo
     *
     * @return AccountTransactionContraReciept
     */
    public function setReceiptNo($receiptNo)
    {
        $this->receiptNo = $receiptNo;

        return $this;
    }

    /**
     * Get receiptNo
     *
     * @return string
     */
    public function getReceiptNo()
    {
        return $this->receiptNo;
    }

    /**
     * Set accountFrom
     *
     * @param integer $accountFrom
     *
     * @return AccountTransactionContraReciept
     */
    public function setAccountFrom($accountFrom)
    {
        $this->accountFrom = $accountFrom;

        return $this;
    }

    /**
     * Get accountFrom
     *
     * @return integer
     */
    public function getAccountFrom()
    {
        return $this->accountFrom;
    }

    /**
     * Set accountTo
     *
     * @param integer $accountTo
     *
     * @return AccountTransactionContraReciept
     */
    public function setAccountTo($accountTo)
    {
        $this->accountTo = $accountTo;

        return $this;
    }

    /**
     * Get accountTo
     *
     * @return integer
     */
    public function getAccountTo()
    {
        return $this->accountTo;
    }

    /**
     * Set doneBy
     *
     * @param string $doneBy
     *
     * @return AccountTransactionContraReciept
     */
    public function setDoneBy($doneBy)
    {
        $this->doneBy = $doneBy;

        return $this;
    }

    /**
     * Get doneBy
     *
     * @return string
     */
    public function getDoneBy()
    {
        return $this->doneBy;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AccountTransactionContraReciept
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
     * @return AccountTransactionContraReciept
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
     * @return AccountTransactionContraReciept
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
     * @return AccountTransactionContraReciept
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
     * @return AccountTransactionContraReciept
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
     * @return AccountTransactionContraReciept
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
     * Set applicationUser
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $applicationUser
     *
     * @return AccountTransactionContraReciept
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
     * Set transactionTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster $transactionTypeFk
     *
     * @return AccountTransactionContraReciept
     */
    public function setTransactionTypeFk(\Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster $transactionTypeFk = null)
    {
        $this->transactionTypeFk = $transactionTypeFk;

        return $this;
    }

    /**
     * Get transactionTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster
     */
    public function getTransactionTypeFk()
    {
        return $this->transactionTypeFk;
    }
}
