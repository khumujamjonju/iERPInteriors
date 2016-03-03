<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContraTransactionMaster
 *
 * @ORM\Table(name="contra_transaction_master", indexes={@ORM\Index(name="fk_source_cash", columns={"Source_id_fk"}), @ORM\Index(name="fk_target_cash", columns={"Target_id_fk"}), @ORM\Index(name="fk_trantype_contra", columns={"Transaction_type_fk"}), @ORM\Index(name="fk_paymode_contra", columns={"Transaction_mode_fk"}), @ORM\Index(name="fk_photo_contra", columns={"Proof_id_fk"})})
 * @ORM\Entity
 */
class ContraTransactionMaster
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
     * @ORM\Column(name="Receipt_no", type="string", length=100, nullable=true)
     */
    private $receiptNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=18, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Transaction_date", type="datetime", nullable=true)
     */
    private $transactionDate;

    /**
     * @var string
     *
     * @ORM\Column(name="Transaction_by", type="string", length=50, nullable=true)
     */
    private $transactionBy;

    /**
     * @var string
     *
     * @ORM\Column(name="Transaction_no", type="string", length=30, nullable=true)
     */
    private $transactionNo;

    /**
     * @var string
     *
     * @ORM\Column(name="Remarks", type="string", length=500, nullable=true)
     */
    private $remarks;

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
     * @var \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnPaymentModeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transaction_mode_fk", referencedColumnName="pkid")
     * })
     */
    private $transactionModeFk;

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
     * @var \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankDetailsMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Source_id_fk", referencedColumnName="Bank_Pk")
     * })
     */
    private $sourceFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankDetailsMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Target_id_fk", referencedColumnName="Bank_Pk")
     * })
     */
    private $targetFk;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Transaction_type_fk", referencedColumnName="Pkid")
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
     * @return ContraTransactionMaster
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
     * Set amount
     *
     * @param string $amount
     *
     * @return ContraTransactionMaster
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
     * Set transactionDate
     *
     * @param \DateTime $transactionDate
     *
     * @return ContraTransactionMaster
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
     * Set transactionBy
     *
     * @param string $transactionBy
     *
     * @return ContraTransactionMaster
     */
    public function setTransactionBy($transactionBy)
    {
        $this->transactionBy = $transactionBy;

        return $this;
    }

    /**
     * Get transactionBy
     *
     * @return string
     */
    public function getTransactionBy()
    {
        return $this->transactionBy;
    }

    /**
     * Set transactionNo
     *
     * @param string $transactionNo
     *
     * @return ContraTransactionMaster
     */
    public function setTransactionNo($transactionNo)
    {
        $this->transactionNo = $transactionNo;

        return $this;
    }

    /**
     * Get transactionNo
     *
     * @return string
     */
    public function getTransactionNo()
    {
        return $this->transactionNo;
    }

    /**
     * Set remarks
     *
     * @param string $remarks
     *
     * @return ContraTransactionMaster
     */
    public function setRemarks($remarks)
    {
        $this->remarks = $remarks;

        return $this;
    }

    /**
     * Get remarks
     *
     * @return string
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * @return ContraTransactionMaster
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
     * Set transactionModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $transactionModeFk
     *
     * @return ContraTransactionMaster
     */
    public function setTransactionModeFk(\Tashi\CommonBundle\Entity\CmnPaymentModeMaster $transactionModeFk = null)
    {
        $this->transactionModeFk = $transactionModeFk;

        return $this;
    }

    /**
     * Get transactionModeFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnPaymentModeMaster
     */
    public function getTransactionModeFk()
    {
        return $this->transactionModeFk;
    }

    /**
     * Set proofFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnDocumentMaster $proofFk
     *
     * @return ContraTransactionMaster
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
     * Set sourceFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankDetailsMaster $sourceFk
     *
     * @return ContraTransactionMaster
     */
    public function setSourceFk(\Tashi\CommonBundle\Entity\CmnBankDetailsMaster $sourceFk = null)
    {
        $this->sourceFk = $sourceFk;

        return $this;
    }

    /**
     * Get sourceFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     */
    public function getSourceFk()
    {
        return $this->sourceFk;
    }

    /**
     * Set targetFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankDetailsMaster $targetFk
     *
     * @return ContraTransactionMaster
     */
    public function setTargetFk(\Tashi\CommonBundle\Entity\CmnBankDetailsMaster $targetFk = null)
    {
        $this->targetFk = $targetFk;

        return $this;
    }

    /**
     * Get targetFk
     *
     * @return \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     */
    public function getTargetFk()
    {
        return $this->targetFk;
    }

    /**
     * Set transactionTypeFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountTransactionContraTypeMaster $transactionTypeFk
     *
     * @return ContraTransactionMaster
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
