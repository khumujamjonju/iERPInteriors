<?php

namespace Tashi\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PayrolPaymentDetails
 *
 * @ORM\Table(name="payrol_payment_details", indexes={@ORM\Index(name="fk_salary_slip_idx", columns={"cmn_entity_id"}), @ORM\Index(name="fk_payment_mode_idx", columns={"payment_mode_fk"}), @ORM\Index(name="fk_payment_details_emp_master_idx", columns={"emp_id_fk"})})
 * @ORM\Entity
 */
class PayrolPaymentDetails
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
     * @ORM\Column(name="entity_key", type="string", length=45, nullable=true)
     */
    private $entityKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="cmn_entity_id", type="integer", nullable=true)
     */
    private $cmnEntityId;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_no", type="string", length=45, nullable=true)
     */
    private $paymentNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="source_id", type="integer", nullable=true)
     */
    private $sourceId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="payment_date", type="date", nullable=true)
     */
    private $paymentDate;

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
     *   @ORM\JoinColumn(name="payment_mode_fk", referencedColumnName="pkid")
     * })
     */
    private $paymentModeFk;

    /**
     * @var \Tashi\CommonBundle\Entity\EmpEmployeeMaster
     *
     * @ORM\ManyToOne(targetEntity="Tashi\CommonBundle\Entity\EmpEmployeeMaster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="emp_id_fk", referencedColumnName="Employee_Pk")
     * })
     */
    private $empFk;



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
     * Set entityKey
     *
     * @param string $entityKey
     *
     * @return PayrolPaymentDetails
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
     * Set cmnEntityId
     *
     * @param integer $cmnEntityId
     *
     * @return PayrolPaymentDetails
     */
    public function setCmnEntityId($cmnEntityId)
    {
        $this->cmnEntityId = $cmnEntityId;

        return $this;
    }

    /**
     * Get cmnEntityId
     *
     * @return integer
     */
    public function getCmnEntityId()
    {
        return $this->cmnEntityId;
    }

    /**
     * Set paymentNo
     *
     * @param string $paymentNo
     *
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     *
     * @return PayrolPaymentDetails
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set recordActiveFlag
     *
     * @param integer $recordActiveFlag
     *
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * @return PayrolPaymentDetails
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
     * Set paymentModeFk
     *
     * @param \Tashi\CommonBundle\Entity\CmnPaymentModeMaster $paymentModeFk
     *
     * @return PayrolPaymentDetails
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
     * Set empFk
     *
     * @param \Tashi\CommonBundle\Entity\EmpEmployeeMaster $empFk
     *
     * @return PayrolPaymentDetails
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
}
