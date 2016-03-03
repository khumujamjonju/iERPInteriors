<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccountBankDipositWithdrawalHistory
 *
 * @ORM\Table(name="account_bank_diposit_withdrawal_history", indexes={@ORM\Index(name="fk_asset_status_idx", columns={"Amount"}), @ORM\Index(name="fk_category_account_headd_idx", columns={"Bank_Id_Fk"}), @ORM\Index(name="fk_receipt_document_file_idx", columns={"Receipt_Doc_Id_Fk"}), @ORM\Index(name="fk_deposit_withdraw_payemnt_mode_idx", columns={"Payment_Mode_Id_Fk"}), @ORM\Index(name="fk_bank_account_source_type_idx", columns={"Source_Type_Id_Fk"}), @ORM\Index(name="account_bank_diposit_withdrawal_history_ibfk_5_idx", columns={"receipt_contra_fk"})})
 * @ORM\Entity
 */
class AccountBankDipositWithdrawalHistory
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
     * @var string
     *
     * @ORM\Column(name="Payment_No", type="string", length=45, nullable=true)
     */
    private $paymentNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="Source_Id", type="integer", nullable=true)
     */
    private $sourceId;

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
     * @var \Tashi\CommonBundle\Entity\AccountSourceType
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountSourceType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Source_Type_Id_Fk", referencedColumnName="Pkid")
     * })
     */
    private $sourceTypeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankDetailsMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Bank_Id_Fk", referencedColumnName="Bank_Pk")
     * })
     */
    private $bankFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPaymentModeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Payment_Mode_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $paymentModeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnDocumentMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnDocumentMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Receipt_Doc_Id_Fk", referencedColumnName="pkid")
     * })
     */
    private $receiptDocFk;



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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * Set paymentNo
     *
     * @param string $paymentNo
     *
     * @return AccountBankDipositWithdrawalHistory
     */
    public function setPaymentNo($paymentNo)
    {
        $this->paymentNo = $paymentNo;

        return $this;
    }

    /**
     * Get paymentNo
     *
     * @return string
     */
    public function getPaymentNo()
    {
        return $this->paymentNo;
    }

    /**
     * Set sourceId
     *
     * @param integer $sourceId
     *
     * @return AccountBankDipositWithdrawalHistory
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
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * @return AccountBankDipositWithdrawalHistory
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
     * Set sourceTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountSourceType $sourceTypeFk
     *
     * @return AccountBankDipositWithdrawalHistory
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

    /**
     * Set bankFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankDetailsMaster $bankFk
     *
     * @return AccountBankDipositWithdrawalHistory
     */
    public function setBankFk(\Tashi\CommonBundle\Entity\CmnBankDetailsMaster $bankFk = null)
    {
        $this->bankFk = $bankFk;

        return $this;
    }

    /**
     * Get bankFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     */
    public function getBankFk()
    {
        return $this->bankFk;
    }

    /**
     * Set paymentModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk
     *
     * @return AccountBankDipositWithdrawalHistory
     */
    public function setPaymentModeFk(\Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk = null)
    {
        $this->paymentModeFk = $paymentModeFk;

        return $this;
    }

    /**
     * Get paymentModeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     */
    public function getPaymentModeFk()
    {
        return $this->paymentModeFk;
    }

    /**
     * Set receiptDocFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $receiptDocFk
     *
     * @return AccountBankDipositWithdrawalHistory
     */
    public function setReceiptDocFk(\Tashi\CommonBundle\Entity\CmnDocumentMaster $receiptDocFk = null)
    {
        $this->receiptDocFk = $receiptDocFk;

        return $this;
    }

    /**
     * Get receiptDocFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnDocumentMaster
     */
    public function getReceiptDocFk()
    {
        return $this->receiptDocFk;
    }
}
