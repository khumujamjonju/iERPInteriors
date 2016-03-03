<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupplierBankTxn
 *
 * @ORM\Table(name="supplier_bank_txn", indexes={@ORM\Index(name="fk_cus_address_cus_id_idx", columns={"Bank_Fk"}), @ORM\Index(name="fk_cus_address_add_id_idx", columns={"Supplier_Fk"})})
 * @ORM\Entity
 */
class SupplierBankTxn
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Supp_Bank_Pk", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $suppBankPk;

    /**
     * @var string
     *
     * @ORM\Column(name="Address_Code", type="string", length=3, nullable=true)
     */
    private $addressCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="Is_Primary_Address", type="integer", nullable=true)
     */
    private $isPrimaryAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="Approval_Flag", type="integer", nullable=true)
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
     * @ORM\Column(name="Application_User_Id", type="string", length=60, nullable=true)
     */
    private $applicationUserId;

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
     * @var \Tashi\CommonBundle\Entity\SupplierMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\SupplierMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Supplier_Fk", referencedColumnName="Supplier_Pk")
     * })
     */
    private $supplierFk;

    /**
     * @var \Tashi\CommonBundle\Entity\CmnBankDetailsMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\CmnBankDetailsMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Bank_Fk", referencedColumnName="Bank_Pk")
     * })
     */
    private $bankFk;



    /**
     * Get suppBankPk
     *
     * @return integer
     */
    public function getSuppBankPk()
    {
        return $this->suppBankPk;
    }

    /**
     * Set addressCode
     *
     * @param string $addressCode
     *
     * @return SupplierBankTxn
     */
    public function setAddressCode($addressCode)
    {
        $this->addressCode = $addressCode;

        return $this;
    }

    /**
     * Get addressCode
     *
     * @return string
     */
    public function getAddressCode()
    {
        return $this->addressCode;
    }

    /**
     * Set isPrimaryAddress
     *
     * @param integer $isPrimaryAddress
     *
     * @return SupplierBankTxn
     */
    public function setIsPrimaryAddress($isPrimaryAddress)
    {
        $this->isPrimaryAddress = $isPrimaryAddress;

        return $this;
    }

    /**
     * Get isPrimaryAddress
     *
     * @return integer
     */
    public function getIsPrimaryAddress()
    {
        return $this->isPrimaryAddress;
    }

    /**
     * Set approvalFlag
     *
     * @param integer $approvalFlag
     *
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * @return SupplierBankTxn
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
     * Set supplierFk
     *
     * @param \Tashi\CommonBundle\Entity\SupplierMaster $supplierFk
     *
     * @return SupplierBankTxn
     */
    public function setSupplierFk(\Tashi\CommonBundle\Entity\SupplierMaster $supplierFk = null)
    {
        $this->supplierFk = $supplierFk;

        return $this;
    }

    /**
     * Get supplierFk
     *
     * @return \Tashi\CommonBundle\Entity\SupplierMaster
     */
    public function getSupplierFk()
    {
        return $this->supplierFk;
    }

    /**
     * Set bankFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnBankDetailsMaster $bankFk
     *
     * @return SupplierBankTxn
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
}
