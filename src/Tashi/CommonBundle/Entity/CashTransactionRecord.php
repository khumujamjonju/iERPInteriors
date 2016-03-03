<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CashTransactionRecord
 *
 * @ORM\Table(name="cash_transaction_record", indexes={@ORM\Index(name="fk_cash_transaction", columns={"Cash_id_fk"}), @ORM\Index(name="fk_contra_transaction", columns={"Contra_id_fk"})})
 * @ORM\Entity
 */
class CashTransactionRecord
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
     * @ORM\Column(name="Amount", type="decimal", precision=18, scale=2, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="Dr_Cr", type="string", length=5, nullable=true)
     */
    private $drCr;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Transaction_date", type="datetime", nullable=true)
     */
    private $transactionDate;

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
     * @ORM\Column(name="Record_insert_date", type="datetime", nullable=true)
     */
    private $recordInsertDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Record_update_date", type="datetime", nullable=true)
     */
    private $recordUpdateDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="Application_user_id", type="integer", nullable=true)
     */
    private $applicationUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="Ip_Address", type="string", length=30, nullable=true)
     */
    private $ipAddress;

    /**
     * @var \Tashi\CommonBundle\Entity\AccountCashCurrentBalance
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\AccountCashCurrentBalance")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Cash_id_fk", referencedColumnName="pkid")
     * })
     */
    private $cashFk;

    /**
     * @var \Tashi\CommonBundle\Entity\ContraTransactionMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\ContraTransactionMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Contra_id_fk", referencedColumnName="Pkid")
     * })
     */
    private $contraFk;



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
     * @return CashTransactionRecord
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
     * Set drCr
     *
     * @param string $drCr
     *
     * @return CashTransactionRecord
     */
    public function setDrCr($drCr)
    {
        $this->drCr = $drCr;

        return $this;
    }

    /**
     * Get drCr
     *
     * @return string
     */
    public function getDrCr()
    {
        return $this->drCr;
    }

    /**
     * Set transactionDate
     *
     * @param \DateTime $transactionDate
     *
     * @return CashTransactionRecord
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
     * Set remarks
     *
     * @param string $remarks
     *
     * @return CashTransactionRecord
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
     * @return CashTransactionRecord
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
     * @return CashTransactionRecord
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
     * @return CashTransactionRecord
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
     * @param integer $applicationUserId
     *
     * @return CashTransactionRecord
     */
    public function setApplicationUserId($applicationUserId)
    {
        $this->applicationUserId = $applicationUserId;

        return $this;
    }

    /**
     * Get applicationUserId
     *
     * @return integer
     */
    public function getApplicationUserId()
    {
        return $this->applicationUserId;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return CashTransactionRecord
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set cashFk
     *
     * @param \Tashi\CommonBundle\Entity\AccountCashCurrentBalance $cashFk
     *
     * @return CashTransactionRecord
     */
    public function setCashFk(\Tashi\CommonBundle\Entity\AccountCashCurrentBalance $cashFk = null)
    {
        $this->cashFk = $cashFk;

        return $this;
    }

    /**
     * Get cashFk
     *
     * @return \Tashi\CommonBundle\Entity\AccountCashCurrentBalance
     */
    public function getCashFk()
    {
        return $this->cashFk;
    }

    /**
     * Set contraFk
     *
     * @param \Tashi\CommonBundle\Entity\ContraTransactionMaster $contraFk
     *
     * @return CashTransactionRecord
     */
    public function setContraFk(\Tashi\CommonBundle\Entity\ContraTransactionMaster $contraFk = null)
    {
        $this->contraFk = $contraFk;

        return $this;
    }

    /**
     * Get contraFk
     *
     * @return \Tashi\CommonBundle\Entity\ContraTransactionMaster
     */
    public function getContraFk()
    {
        return $this->contraFk;
    }
}
