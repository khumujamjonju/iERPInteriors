<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountCashDipositWithdrawalHistory
 *
 * @ORM\Table(name="account_cash_diposit_withdrawal_history", indexes={@ORM\Index(name="fk_asset_status_idx", columns={"Amount"}), @ORM\Index(name="fk_receipt_document_file_idx", columns={"Receipt_Doc_Id_Fk"}), @ORM\Index(name="fk_account_cash_account_idx", columns={"Cash_Account_Id_Fk"}), @ORM\Index(name="fk_account_source_type_idx", columns={"Source_Type_Id_Fk"}), @ORM\Index(name="account_cash_diposit_withdrawal_history_ibfk_3_idx", columns={"receipt_contra_fk"})})
 * @ORM\Entity
 */
class AccountCashDipositWithdrawalHistory
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
     * @ORM\Column(name="deposit_withdrawal_key", type="string", length=5, nullable=true)
     */
    private $depositWithdrawalKey;

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
     * @ORM\Column(name="deposit_withdrawal_By", type="string", length=45, nullable=true)
     */
    private $depositWithdrawalBy;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="Source_Id", type="integer", nullable=true)
     */
    private $sourceId;

    /**
     * @var integer
     *
     * @ORM\Column(name="Receipt_Doc_Id_Fk", type="integer", nullable=true)
     */
    private $receiptDocIdFk;

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
     * @var \Tashi\CommonBundle\Entity\AccountTransactionContraReciept
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountTransactionContraReciept")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="receipt_contra_fk", referencedColumnName="pkid")
     * })
     */
    private $receiptContraFk;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountCashCurrentBalance
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountCashCurrentBalance")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Cash_Account_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $cashAccountFk;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountSourceType
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountSourceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Source_Type_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $sourceTypeFk;



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
     * Set depositWithdrawalKey
     *
     * @param string $depositWithdrawalKey
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setDepositWithdrawalKey($depositWithdrawalKey)
    {
        $this->depositWithdrawalKey = $depositWithdrawalKey;

        return $this;
    }

    /**
     * Get depositWithdrawalKey
     *
     * @return string
     */
    public function getDepositWithdrawalKey()
    {
        return $this->depositWithdrawalKey;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * Set depositWithdrawalBy
     *
     * @param string $depositWithdrawalBy
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setDepositWithdrawalBy($depositWithdrawalBy)
    {
        $this->depositWithdrawalBy = $depositWithdrawalBy;

        return $this;
    }

    /**
     * Get depositWithdrawalBy
     *
     * @return string
     */
    public function getDepositWithdrawalBy()
    {
        return $this->depositWithdrawalBy;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AccountCashDipositWithdrawalHistory
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
     * Set sourceId
     *
     * @param integer $sourceId
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;

        return $this;
    }

    /**
     * Get sourceId
     *
     * @return integer
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * Set receiptDocIdFk
     *
     * @param integer $receiptDocIdFk
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setReceiptDocIdFk($receiptDocIdFk)
    {
        $this->receiptDocIdFk = $receiptDocIdFk;

        return $this;
    }

    /**
     * Get receiptDocIdFk
     *
     * @return integer
     */
    public function getReceiptDocIdFk()
    {
        return $this->receiptDocIdFk;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * @return AccountCashDipositWithdrawalHistory
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
     * Set receiptContraFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountTransactionContraReciept $receiptContraFk
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setReceiptContraFk(\Tashi\CommonBundle\Entity\AccountTransactionContraReciept $receiptContraFk = null)
    {
        $this->receiptContraFk = $receiptContraFk;

        return $this;
    }

    /**
     * Get receiptContraFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountTransactionContraReciept
     */
    public function getReceiptContraFk()
    {
        return $this->receiptContraFk;
    }

    /**
     * Set cashAccountFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountCashCurrentBalance $cashAccountFk
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setCashAccountFk(\Tashi\CommonBundle\Entity\AccountCashCurrentBalance $cashAccountFk = null)
    {
        $this->cashAccountFk = $cashAccountFk;

        return $this;
    }

    /**
     * Get cashAccountFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountCashCurrentBalance
     */
    public function getCashAccountFk()
    {
        return $this->cashAccountFk;
    }

    /**
     * Set sourceTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountSourceType $sourceTypeFk
     *
     * @return AccountCashDipositWithdrawalHistory
     */
    public function setSourceTypeFk(\Tashi\CommonBundle\Entity\AccountSourceType $sourceTypeFk = null)
    {
        $this->sourceTypeFk = $sourceTypeFk;

        return $this;
    }

    /**
     * Get sourceTypeFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountSourceType
     */
    public function getSourceTypeFk()
    {
        return $this->sourceTypeFk;
    }
}
